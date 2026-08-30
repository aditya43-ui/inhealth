<?php

class InformasiMutasiMasukController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiMutasiMasuk.';
  public $terimamutasidetailtersimpan = true;
  public $stokobatalkestersimpan = true;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Obat Alkes Masuk";
    $model = new GFInformasimutasioaruanganV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(), 'instalasi_id', 'instalasi_nama');
    $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis(Params::INSTALASI_ID_FARMASI), 'ruangan_id', 'ruangan_nama');

    if (isset($_GET['GFInformasimutasioaruanganV'])) {
      $model->attributes = $_GET['GFInformasimutasioaruanganV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasimutasioaruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasimutasioaruanganV']['tgl_akhir']);
      $model->status_terima = $_GET['GFInformasimutasioaruanganV']['status_terima'];
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'instalasiAsals' => $instalasiAsals,
      'ruanganAsals' => $ruanganAsals,
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
        $instalasi_id = $_POST["$model_nama"]['instalasiasalmutasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($instalasi_id), 'ruangan_id', 'ruangan_nama');

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

  /**
   * untuk print detail mutasi
   */
  public function actionPrint($mutasioaruangan_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $model = GFMutasioaruanganT::model()->findByPk($mutasioaruangan_id);
    $modDetails = GFMutasioadetailT::model()->findAllByAttributes(array('mutasioaruangan_id' => $mutasioaruangan_id));

    $judul_print = 'Mutasi Obat Alkes';

    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraprint' => $caraprint
    ));
  }

  public function actionTerimaMutasi($terimamutasi_id = null, $mutasioaruangan_id = null)
  {
    $format = new MyFormatter();
    $model = new GFTerimamutasiT;
    $modMutasiRuangan = new GFMutasioaruanganT;
    $modMutasiRuangan->instalasitujuan_id = Params::INSTALASI_ID_FARMASI;
    $modDetails = array();
    $instalasiTujuans = CHtml::listData(GFInstalasiM::getInstalasiTujuanMutasis(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($modMutasiRuangan->instalasitujuan_id), 'ruangan_id', 'ruangan_nama');

    $model->tglterima = date('Y-m-d H:i:s');
    // Uncomment the following line if AJAX validation is needed

    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->pegawaipenerima_id = $modLogin->pegawai_id;
    if (!empty($model->pegawaipenerima_id)) $model->pegawaipenerima_nama = $modLogin->pegawai->nama_pegawai;

    if (!empty($mutasioaruangan_id)) {

      if (empty($terimamutasi_id)) {
        $this->setReferrer();
        $modMutasiRuangan = GFMutasioaruanganT::model()->findByPk($mutasioaruangan_id);
        $modMutasiRuangan->instalasitujuan_id = $modMutasiRuangan->ruangantujuan->instalasi_id;
        $modMutasiRuangan->pegawaimengetahui_nama = (isset($modMutasiRuangan->pegawaimengetahui->NamaLengkap) ? $modMutasiRuangan->pegawaimengetahui->NamaLengkap : "");
        $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id), 'ruangan_id', 'ruangan_nama');
        $modDetails = GFMutasioadetailT::model()->findAllByAttributes(array('mutasioaruangan_id' => $modMutasiRuangan->mutasioaruangan_id));

        $model->ruanganasal_id = $modMutasiRuangan->ruanganasal_id;
        $model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
        $model->mutasioaruangan_id = $mutasioaruangan_id;
      }
    } else {
      $this->cleanReferrer();
    }

    if (!empty($terimamutasi_id) && !empty($mutasioaruangan_id)) {
      $modMutasiRuangan = GFMutasioaruanganT::model()->findByPk($mutasioaruangan_id);
      $modMutasiRuangan->instalasitujuan_id = $modMutasiRuangan->ruangantujuan->instalasi_id;
      $modMutasiRuangan->pegawaimengetahui_nama = (isset($modMutasiRuangan->pegawaimengetahui->NamaLengkap) ? $modMutasiRuangan->pegawaimengetahui->NamaLengkap : "");
      $model = GFTerimamutasiT::model()->findByPk($terimamutasi_id);
      $model->pegawaimengetahui_nama = (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : "");
      $model->pegawaipenerima_nama = (isset($model->pegawaipenerima->NamaLengkap) ? $model->pegawaipenerima->NamaLengkap : "");
      $model->totalharganetto = (isset($model->totalharganetto) ? $model->totalharganetto : "");
      $model->totalhargajual = (isset($model->totalhargajual) ? $model->totalhargajual : "");
      $ruanganTujuans = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasitujuan_id), 'ruangan_id', 'ruangan_nama');

      $model->ruanganasal_id = $modMutasiRuangan->ruanganasal_id;
      $model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
      $model->mutasioaruangan_id = $mutasioaruangan_id;
      $modDetails = GFTerimamutasidetailT::model()->findAllByAttributes(array('terimamutasi_id' => $model->terimamutasi_id));
    }

    if (isset($_POST['GFTerimamutasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['GFTerimamutasiT'];
        $model->tglterima = $format->formatDateTimeForDb($_POST['GFTerimamutasiT']['tglterima']);
        $model->noterimamutasi = MyGenerator::noTerimaMutasi();
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');

        $msg = "";

        if ($model->save()) {
          if (isset($_POST['GFMutasioadetailT'])) {
            if (count((array)$_POST['GFMutasioadetailT']) > 0) {
              GFMutasioaruanganT::model()->updateByPk($mutasioaruangan_id, array('terimamutasi_id' => $model->terimamutasi_id));
              foreach ($_POST['GFMutasioadetailT'] as $i => $postDetail) {
                $modDetails[$i] = $this->simpanTerimaMutasiDetail($model, $postDetail);
                $this->simpanStokObatAlkesIn($modDetails[$i]);
              }
            }

            if (!empty($model->terimamutasi_id)) {

              $konfig = KonfigsystemK::model()->find();
              if ($konfig->isjurnalotomatis) {

                $periode = RekperiodM::model()->find(array(
                  'condition' => "isclosing IS FALSE and '" . $model->tglterima . "'::date between perideawal AND sampaidgn",
                ));
                $is_kosong = false;
                if (!empty($periode)) {
                  $posting = PeriodepostingM::model()->findByAttributes(array(
                    'rekperiode_id' => $periode->rekperiod_id,
                  ));
                  if (empty($posting)) {
                    $is_kosong = true;
                  }
                } else {
                  $is_kosong = true;
                }

                if ($is_kosong) {
                  $msg = "<br/>Peroide Akuntansi dan Posting belum ditambahkan untuk hari ini.";
                  $this->terimamutasidetailtersimpan = false;
                } else {
                  $res = Yii::app()->db
                    ->createCommand("select set_afterterimamutasioa_fix(" . $model->terimamutasi_id . ") as simpan")
                    ->queryRow();

                  if (!empty($res)) {
                    $this->terimamutasidetailtersimpan = $this->terimamutasidetailtersimpan && $res['simpan'];
                  }
                }
              }

              // var_dump($res);
            }

            $this->setNotifTerimaMutasi($model);

            if ($this->terimamutasidetailtersimpan && $this->stokobatalkestersimpan) {
              $transaction->commit();
              $this->redirect(array('index', 'terimamutasi_id' => $model->terimamutasi_id, 'mutasioaruangan_id' => $mutasioaruangan_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data detail terima mutasi obat alkes gagal disimpan ! " . $msg);
              //echo "-".$this->terimamutasidetailtersimpan."<br>";
              //echo "-".$this->stokobatalkestersimpan."<br>";
              //exit;
            }
          }
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data mutasi obat alkes gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'terimaMutasi', array(
      'model' => $model,
      'modMutasiRuangan' => $modMutasiRuangan,
      'modDetails' => $modDetails,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }


  protected function setNotifTerimaMutasi($model)
  {
    $judul = "Terima Mutasi Obat dan Alkes - " . $model->noterimamutasi;

    $asal = RuanganM::model()->findByPk($model->ruanganasal_id);
    $penerima = RuanganM::model()->findByPk($model->ruanganpenerima_id);
    $mutasi = MutasioaruanganT::model()->findByPk($model->mutasioaruangan_id);



    $isi = "Tgl. Terima : " . MyFormatter::formatDateTimeForUser($model->tglterima) . "<br/>";
    $isi .= "No. Terima : " . $model->noterimamutasi . "<br/>";
    $isi .= "<hr/>";
    $isi .= "Tgl. Mutasi : " . MyFormatter::formatDateTimeForUser($mutasi->tglmutasioa) . "<br/>";
    $isi .= "No. Mutasi : " . $mutasi->nomutasioa . "<br/>";
    $isi .= "Mutasi Dari : " . $asal->ruangan_nama;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $penerima->instalasi_id, 'ruangan_id' => $penerima->ruangan_id, 'modul_id' => $penerima->modul_id),
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
    ));
  }

  /**
   * untuk menyimpan TerimamutasidetailT
   * @param type $modTerimaMutasi
   * @param type $postDetail
   */
  protected function simpanTerimaMutasiDetail($modTerimaMutasi, $postDetail)
  {
    $modTerimaMutasiDetail = new GFTerimamutasidetailT;
    $modTerimaMutasiDetail->attributes = $postDetail;
    $modTerimaMutasiDetail->terimamutasi_id = $modTerimaMutasi->terimamutasi_id;
    $modTerimaMutasiDetail->mutasioadetail_id = $postDetail['mutasioadetail_id'];
    $modTerimaMutasiDetail->satuankecil_id = $postDetail['satuankecil_id'];
    $modTerimaMutasiDetail->tglkadaluarsa = MyFormatter::formatDateTimeForDb($modTerimaMutasiDetail->tglkadaluarsa);
    $modTerimaMutasiDetail->jmlterima = (empty($postDetail['jmlterima']) ? 0 : $postDetail['jmlterima']);
    $modTerimaMutasiDetail->harganettoterima = (empty($postDetail['harganettoterima']) ? 0 : $postDetail['harganettoterima']);
    $modTerimaMutasiDetail->hargajualterim = (empty($postDetail['hargajualterim']) ? 0 : $postDetail['hargajualterim']);
    $modTerimaMutasiDetail->totalhargaterima = (empty($postDetail['totalharga']) ? 0 : $postDetail['totalharga']);
    $modTerimaMutasiDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($modTerimaMutasiDetail->save()) {
      $this->terimamutasidetailtersimpan &= true;
    } else {
      $this->terimamutasidetailtersimpan &= false;
    }
    return $modTerimaMutasiDetail;
  }
  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modTerimaMutasi
   * @param type $modTerimaMutasiDetail
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesIn($modTerimaMutasiDetail)
  {
    $format = new MyFormatter;

    $oa = ObatalkesM::model()->findByPk($modTerimaMutasiDetail->obatalkes_id);

    $modStokOa = StokobatalkesT::model()->findByAttributes(array('mutasioadetail_id' => $modTerimaMutasiDetail->mutasioadetail_id));
    $modStokOaNew = new StokobatalkesT;
    if (!empty($modStokOa)) {
      $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    } else {
      $modStokOaNew->obatalkes_id = $modTerimaMutasiDetail->obatalkes_id;
      $modStokOaNew->tglkadaluarsa = $modTerimaMutasiDetail->tglkadaluarsa;
    }
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = $modTerimaMutasiDetail->jmlterima;
    $modStokOaNew->qtystok_out = 0;
    $modStokOaNew->tglstok_in = date('Y-m-d H:i:s');
    $modStokOaNew->tglstok_out = null;
    $modStokOaNew->terimamutasidetail_id = $modTerimaMutasiDetail->terimamutasidetail_id;
    $modStokOaNew->satuankecil_id = $modTerimaMutasiDetail->satuankecil_id;
    $modStokOaNew->tglterima = date("Y-m-d H:i:s");
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
    $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
    $modStokOaNew->stokoa_aktif = true;
    $modStokOaNew->persenppn = $oa->ppn_persen;
    $modStokOaNew->persenmargin = $oa->margin;

    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = GFPegawaiV::model()->findAll($criteria);
      $returnVal = array();
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

  public function actionAutocompletePegawaiPenerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = GFPegawaiV::model()->findAll($criteria);
      $returnVal = array();
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

  /**
   * untuk print detail terima mutasi
   */
  public function actionPrintTerimaMutasi($terimamutasi_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $model = GFTerimamutasiT::model()->findByPk($terimamutasi_id);
    $modDetails = GFTerimamutasidetailT::model()->findAllByAttributes(array('terimamutasi_id' => $terimamutasi_id));

    $judul_print = 'Terima Mutasi Obat Alkes';

    $this->render($this->path_view . 'printTerimaMutasi', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraprint' => $caraprint
    ));
  }
}
