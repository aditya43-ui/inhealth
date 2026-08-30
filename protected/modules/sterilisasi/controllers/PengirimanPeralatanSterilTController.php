<?php

class PengirimanPeralatanSterilTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $pengirimanSteril = false;
  public $pengirimanSterilDet = true;

  public function actionIndex($penyimpanansteril_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pengiriman Peralatan Steril";
    $format = new MyFormatter;
    $model = new STKirimperlinensterilT;
    $model->kirimperlinensteril_no = MyGenerator::noKirimSterilisasi();

    // data untuk pencarian
    $modCari = new STPenyimpanansterilT;
    $modCari->tgl_awal = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_awal));
    $modCari->tgl_akhir = $format->formatDateTimeForUser(date("Y m d"), strtotime($modCari->tgl_akhir));
    $modCariDetail = new STPenyimpanansterildetT;
    $modPenyimpananDetails = array();
    if (isset($_POST['STPenyimpanansterilT'])) {
      $tgl_awal = $format->formatDateTimeForDb($_POST['STPenyimpanansterilT']['tgl_awal']);
      $tgl_akhir = $format->formatDateTimeForDb($_POST['STPenyimpanansterilT']['tgl_akhir']);
      $penyimpanansteril_no = $_POST['STPenyimpanansterilT']['penyimpanansteril_no'];
      $rakpenyimpanan_id = $_POST['STPenyimpanansterilT']['rakpenyimpanan_id'];
      $lokasipenyimpanan_id = $_POST['STPenyimpanansterilT']['lokasipenyimpanan_id'];
      $criteria = new CDbCriteria();
      $criteria->addBetweenCondition('DATE(penyimpanansteril_tgl)', $tgl_awal, $tgl_akhir);
      $criteria->compare('LOWER(penyimpanansteril_no)', strtolower($penyimpanansteril_no), true);
      $modPenyimpanan = STPenyimpanansterilT::model()->findAll($criteria);
      foreach ($modPenyimpanan as $i => $modPenyimpananDetail) {
        $criteriaDet = new CDbCriteria();
        $criteriaDet->join = 'left join kirimperlinensterildet_t k on k.penyimpanansterildet_id = t.penyimpanansterildet_id';
        if (!empty($modPenyimpananDetail->penyimpanansteril_id)) {
          $criteriaDet->addCondition('t.penyimpanansteril_id = ' . $modPenyimpananDetail->penyimpanansteril_id);
        }
        if (!empty($rakpenyimpanan_id)) {
          $criteriaDet->addCondition('t.rakpenyimpanan_id = ' . $rakpenyimpanan_id);
        }
        if (!empty($lokasipenyimpanan_id)) {
          $criteriaDet->addCondition('t.lokasipenyimpanan_id = ' . $lokasipenyimpanan_id);
        }
        $criteriaDet->addCondition('k.penyimpanansterildet_id is null');
        $modPenyimpananDetails = STPenyimpanansterildetT::model()->findAll($criteriaDet);
      }
    }

    if (!empty($penyimpanansteril_id)) {
      $modPenyimpanan = STPenyimpanansterilT::model()->findByPk($penyimpanansteril_id);
      $modPenyimpananDetailsPre = STPenyimpanansterildetT::model()->findAllByAttributes(array('penyimpanansteril_id' => $modPenyimpanan->penyimpanansteril_id));

      $modPenyimpananDetails = array();

      foreach ($modPenyimpananDetailsPre as $item) {
        $kirim = KirimperlinensterildetT::model()->findByAttributes(array(
          'penyimpanansterildet_id' => $item->penyimpanansterildet_id,
        ));

        if (!empty($kirim)) {
          continue;
        }

        $modPenyimpananDetails[] = $item;
      }
    }

    // data untuk proses simpan
    $modDetails = array();
    $modDetail = new STKirimperlinensterildetT;
    if (isset($_POST['STPenyimpanansterildetT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['STKirimperlinensterilT'];
        //				RSSP-2640
        //				$model->ruangan_id = Yii::app()->user->ruangan_id;
        $model->ruangan_id = $_POST['STKirimperlinensterilT']['ruangan_id'];
        //				$model->pengajuansterlilisasi_id = $_POST['STPenyimpanansterildetT'][0]['penyimpanansteril_id'];
        $model->kirimperlinensteril_tgl = $format->formatDateTimeForDb($_POST['STKirimperlinensterilT']['kirimperlinensteril_tgl']);
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        if ($model->save()) {
          $this->pengirimanSteril = true;
          if (count((array)$_POST['STPenyimpanansterildetT']) > 0) {
            foreach ($_POST['STPenyimpanansterildetT'] as $i => $postPenyimpananSteril) {
              if ($_POST['STPenyimpanansterildetT'][$i]['checklist']) {
                $modDetail = new STKirimperlinensterildetT;
                $modDetail->attributes = $postPenyimpananSteril;
                $modDetail->kirimperlinensteril_id = $model->kirimperlinensteril_id;
                //										$modDetail->linen_id = $postPenyimpananSteril['linen_id'];
                $modDetail->peralatansterilisasi_id = $postPenyimpananSteril['peralatansterilisasi_id'];
                $modDetail->penyimpanansterildet_id = $postPenyimpananSteril['penyimpanansterildet_id'];
                $modDetail->kirimperlinensterildet_jml = $postPenyimpananSteril['penyimpanansterildet_jml'];
                $modDetail->kirimperlinensterildet_ket = $postPenyimpananSteril['penyimpanansterildet_ket'];


                if ($modDetail->save()) {
                  $this->pengirimanSterilDet &= true;
                } else {
                  $this->pengirimanSterilDet &= false;
                }
              }
            }
          }
        }

        $this->notifPeralatanSteril($model);

        if ($this->pengirimanSteril && $this->pengirimanSterilDet) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Pengiriman Peralatan dan Linen Steril " . $model->kirimperlinensteril_no . " berhasil disimpan !");
          $this->redirect(array('index', 'kirimperlinensteril_id' => $model->kirimperlinensteril_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pengiriman Peralatan Steril gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pengiriman Peralatan Steril gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render('index', array(
      'model' => $model, 'format' => $format, 'modCari' => $modCari, 'modPenyimpananDetails' => $modPenyimpananDetails
    ));
  }


  public function notifPeralatanSteril($model)
  {

    $ruangan = RuanganM::model()->findByPk($model->ruangan_id);
    $asal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

    $judul = "Pengiriman Peralatan Steril";
    $isi = "Pengiriman Asal : " . $asal->ruangan_nama . "<br/>No. Pengiriman : ";
    $isi .= $model->kirimperlinensteril_no;

    $link = "";
    if (!empty($ruangan->modul_id)) {
      $modul = ModulK::model()->findByPk($ruangan->modul_id);
      $urlLink = $modul->url_modul . "/PenerimaanPeralatanSterilRuanganT" . $modul->modul_key . "/index";

      if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_STERILISASI) {
        $urlLink = "sterilisasi/PenerimaanPeralatanSterilRuanganT/index";
      }

      $link = Yii::app()->createUrl($urlLink, array(
        'kirimperlinensteril_id' => $model->kirimperlinensteril_id,
      ));
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
      // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
    ));
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::model()->findAllByAttributes(array("instalasi_id" => $instalasi_id), "ruangan_aktif = true"), 'ruangan_id', 'ruangan_nama');
      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }


  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompletePegawaiMengirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STPegawaiV::model()->findAll($criteria);
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

  public function actionAutocompleteRakPenyimpanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(rakpenyimpanan_nama)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STRakpenyimpananM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->rakpenyimpanan_nama;
        $returnVal[$i]['value'] = $model->rakpenyimpanan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteLokasiPenyimpanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(lokasipenyimpanan_nama)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STLokasipenyimpananM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->lokasipenyimpanan_nama;
        $returnVal[$i]['value'] = $model->lokasipenyimpanan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk print data pengajuan perawatan
   */
  public function actionPrint($kirimperlinensteril_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPengiriman = STKirimperlinensterilT::model()->findByPk($kirimperlinensteril_id);
    $modPengirimanDetail = STKirimperlinensterildetT::model()->findAllByAttributes(array('kirimperlinensteril_id' => $kirimperlinensteril_id));

    $judul_print = 'Pengiriman Peralatan Steril';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPengiriman' => $modPengiriman,
      'modPengirimanDetail' => $modPengirimanDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
