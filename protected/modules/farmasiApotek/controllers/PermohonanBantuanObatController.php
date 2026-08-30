<?php

class PermohonanBantuanObatController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'farmasiApotek.views.permohonanBantuanObat.';
  public $permohonanbantuanobattersimpan = true;

  public function actionIndex($permohonanoa_id = null)
  {
    $modPermohonanOa = new FAPermohonanoaT;
    $modPermohonanOaDetail = new FAPermohonanoadetailT;
    $modObatAlkes = new FAObatalkesM;

    $modPermohonanOa->permohonanoa_tgl = date('Y-m-d H:i:s');
    $modPermohonanOa->permohonanoa_nomor = MyGenerator::noPermohonanBantuan();
    $modPermohonanOa->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPermohonanOa->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPermohonanOa->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modDetails = null;

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (!empty($permohonanoa_id)) {
      $modPermohonanOa = FAPermohonanoaT::model()->findByPk($permohonanoa_id);
      $modDetails = FAPermohonanoadetailT::model()->findAllByAttributes(array('permohonanoa_id' => $modPermohonanOa->permohonanoa_id));

      $modPermohonanOa->pegawaimengetahui_nama = !empty($modPermohonanOa->pegawaimengetahui->NamaLengkap) ? $modPermohonanOa->pegawaimengetahui->NamaLengkap : "";
      $modPermohonanOa->pegawaimenyetujui_nama = !empty($modPermohonanOa->pegawaimenyetujui->NamaLengkap) ? $modPermohonanOa->pegawaimenyetujui->NamaLengkap : "";
      if (count((array)$modDetails) > 0) {
        $totalSebelumDiskon = 0;
        foreach ($modDetails as $key => $value) {
          $obat = ObatalkesM::model()->findByPk($value->obatalkes_id);

          $modDetails[$key] = new FAPermohonanoadetailT();
          $modDetails[$key]->attributes = $value->attributes;
          $modDetails[$key]->permohonanoadetail_qty = $value->permohonanoadetail_qty;
          $modDetails[$key]->harganetto = $obat->harganetto;
          //            $modDetails[$key]->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
          $modDetails[$key]->stokakhir = 0;
          $modDetails[$key]->maksimalstok = 0;
          $modDetails[$key]->sumberdana_id = isset($obat->sumberdana_id) ? $obat->sumberdana_id : null;
          $modDetails[$key]->obatalkes_id = $value->obatalkes_id;
          $modDetails[$key]->kemasanbesar = $value->kemasanbesar;
          $modDetails[$key]->satuankecil_id = $value->satuankecil_id;
          $modDetails[$key]->satuanbesar_id = $obat->satuanbesar_id;
        }
      }
    }

    $format = new MyFormatter();

    if (isset($_POST['FAPermohonanoaT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPermohonanOa->attributes = $_POST['FAPermohonanoaT'];
        $modPermohonanOa->create_time = date('Y-m-d H:i:s');
        $modPermohonanOa->profilrs_id = Params::getDefaultProfilRS();
        $modPermohonanOa->create_loginpemakai_id = Yii::app()->user->id;
        $modPermohonanOa->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPermohonanOa->pegawaimenyetujui_id = $_POST['FAPermohonanoaT']['pegawaimenyetujui_id'];
        $modPermohonanOa->pegawaimengetahui_id = $_POST['FAPermohonanoaT']['pegawaimengetahui_id'];
        $modPermohonanOa->permohonanoa_tgl = $format->formatDateTimeForDb($_POST['FAPermohonanoaT']['permohonanoa_tgl']);

        //                    echo "<pre>";
        //                    print_r($modPermohonanOa->attributes);exit;
        if ($modPermohonanOa->save()) {
          //                        echo "a";exit;
          if (count((array)$_POST['FAPermohonanoadetailT']) > 0) {
            foreach ($_POST['FAPermohonanoadetailT'] as $i => $postOa) {
              $modDetails[$i] = $this->simpanDetailPermohonan($modPermohonanOa, $postOa);
            }
          }
        } else {
          echo "b";
          exit;
        }

        if ($this->permohonanbantuanobattersimpan) {
          // SMS GATEWAY
          $sms = new Sms();
          $smspemohon = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPermohonanOa->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }

            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPermohonanOa->permohonanoa_tgl), $isiPesan);
            $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PEMOHON && $smsgateway->statussms) {
              if (!empty($modPermohonanOa->pemohon_nomobile)) {
                $sms->kirim($modPermohonanOa->pemohon_nomobile, $isiPesan);
              } else {
                $smspemohon = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
          $modPermohonanOa->isNewRecord = FALSE;
          $this->redirect(array('index', 'permohonanoa_id' => $modPermohonanOa->permohonanoa_id, 'smspemohon' => $smspemohon, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Permohonan Bantuan Obat gagal disimpan !");
        }
      } catch (Exception $exc) {
        $modPermohonanOa->isNewRecord = true;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'format' => $format,
      'modPermohonanOa' => $modPermohonanOa,
      'modPermohonanOaDetail' => $modPermohonanOa,
      'modDetails' => $modDetails,
      'modObatAlkes' => $modObatAlkes
    ));
  }


  /**
   * simpan FAPermohonanoadetailT
   * @param type $modPermohonanOa
   * @param type $post
   * @return \FAPermohonanoadetailT
   */
  public function simpanDetailPermohonan($modPermohonanOa, $post)
  {
    $format = new MyFormatter();
    $modPermohonanOaDetail = new FAPermohonanoadetailT;

    $modPermohonanOaDetail->attributes = $post;
    $modPermohonanOaDetail->permohonanoadetail_qty = $post['permohonanoadetail_qty'];
    $modPermohonanOaDetail->satuankecil_id = $post['satuankecil_id'];
    $modPermohonanOaDetail->obatalkes_id = $post['obatalkes_id'];
    $modPermohonanOaDetail->permohonanoa_id = $modPermohonanOa->permohonanoa_id; //fake id

    if ($modPermohonanOaDetail->validate()) {
      $modPermohonanOaDetail->save();
    } else {
      $this->permohonanbantuanobattersimpan  &= false;
    }
    return $modPermohonanOaDetail;
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionLoadFormPermohonanBantuan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $form = "";
      $format = new MyFormatter();
      $modPermohonanOa = new FAPermohonanoaT();
      $modPermohonanOaDetail = new FAPermohonanoadetailT;
      $modObatAlkes = FAObatalkesM::model()->findByPk($obatalkes_id);

      $jmlKemasan = ($modObatAlkes->kemasanbesar > 0) ? $modObatAlkes->kemasanbesar : 1;
      $modPermohonanOaDetail->permohonanoadetail_qty = $jumlah;
      $modPermohonanOaDetail->harganetto = $modObatAlkes->harganetto;
      //            $modPermohonanOaDetail->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
      $modPermohonanOaDetail->stokakhir = 0;
      $modPermohonanOaDetail->maksimalstok = 0;
      $modPermohonanOaDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
      $modPermohonanOaDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
      $modPermohonanOaDetail->persenpph = Yii::app()->user->getState('persenppn');
      $modPermohonanOaDetail->persenppn = Yii::app()->user->getState('persenpph');
      $modPermohonanOaDetail->tglkadaluarsa = NULL;
      $modPermohonanOaDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
      $modPermohonanOaDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
      $modPermohonanOaDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;

      $form .= $this->renderPartial($this->path_view . '_rowObatPermohonanBantuan', array('modObatAlkes' => $modObatAlkes, 'modPermohonanOaDetail' => $modPermohonanOaDetail), true);
      echo CJSON::encode(array('form' => $form));
      Yii::app()->end();
    }
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = FAPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawaiMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = FAPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = FAObatalkesM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes_nama . " (Stok=" . $model->StokObatRuangan . ")";
        $returnVal[$i]['value'] = $model->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPermohonanOa = new FAPermohonanoaT;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPermohonanOa->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPermohonanOa = new FAPermohonanoaT;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPermohonanOa->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPermohonanOa = new FAPermohonanoaT;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPermohonanOa->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * untuk print data permohonan bantuan obat
   */
  public function actionPrint($permohonanoa_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPermohonanOa = FAPermohonanoaT::model()->findByPk($permohonanoa_id);
    $modPermohonanOaDetail = FAPermohonanoadetailT::model()->findAllByAttributes(array('permohonanoa_id' => $permohonanoa_id));

    $judul_print = 'Permohonan Bantuan Obat';

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPermohonanOa' => $modPermohonanOa,
      'modPermohonanOaDetail' => $modPermohonanOaDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
