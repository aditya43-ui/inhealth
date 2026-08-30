<?php

class PemusnahanObatAlkesController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.pemusnahanObatAlkes.';

  public $pemusnahandetailtersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($pemusnahanobatalkes_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemusnahan Obat Dan Alkes";
    $model = new GFPemusnahanobatalkesT;
    $format = new MyFormatter;
    $modDetails = array();
    $pesan = '';
    $model->instalasiasal_id = Yii::app()->user->getState('instalasi_id');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $instalasiAsals = CHtml::listData(GFInstalasiM::getInstalasiPemusnahanObatAlkes(), 'instalasi_id', 'instalasi_nama');
    $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganAsalPemusnahan($model->instalasiasal_id), 'ruangan_id', 'ruangan_nama');


    if (!empty($pemusnahanobatalkes_id)) {
      $model = GFPemusnahanobatalkesT::model()->findByPk($pemusnahanobatalkes_id);
      $model->instalasiasal_id = $model->ruanganasal->instalasi_id;
      $model->pegawaimengetahui_nama = (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : "");
      $ruanganAsals = CHtml::listData(GFRuanganM::getRuanganTujuanMutasis($model->instalasiasal_id), 'ruangan_id', 'ruangan_nama');
      $modDetails = $this->loadModelDetails($model->pemusnahanobatalkes_id);
    }

    if (isset($_POST['GFPemusnahanobatalkesT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['GFPemusnahanobatalkesT'];
        $model->tglpemusnahan = date("Y-m-d H:i:s");
        $model->nopemusnahan = MyGenerator::noPemusnahan();
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        //var_dump($model);exit;
        if ($model->save()) {
          if (isset($_POST['GFPemusnahanoadetailT'])) {
            if (count((array)$_POST['GFPemusnahanoadetailT']) > 0) {
              //PROSES DETAIL BERDASARKAN stokobatalkes_id & jmlbarang
              $detailGroups = array();
              foreach ($_POST['GFPemusnahanoadetailT'] as $i => $postDetail) {
                $modDetails[$i] = $this->simpanPemusnahanDetail($model, $postDetail);
                $this->simpanStokObatAlkesOut($postDetail['stokobatalkes_id'], $modDetails[$i]);
              }
              //die;
            }

            if ($this->pemusnahandetailtersimpan && $this->stokobatalkestersimpan) {
              $transaction->commit();
              $sukses = 1;
              $this->redirect(array('index', 'pemusnahanobatalkes_id' => $model->pemusnahanobatalkes_id, 'sukses' => $sukses));
            } else {
              $transaction->rollback();
              $model->pemusnahanobatalkes_id = null;
              Yii::app()->user->setFlash('error', "Data detail pemusnahan obat alkes gagal disimpan !");
              if (!$this->stokobatalkestersimpan) {
                Yii::app()->user->setFlash('error', "Data detail pemusnahan obat alkes gagal disimpan ! Stok obat tidak mencukupi !");
              }
            }
          }
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data mutasi obat alkes gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modDetails' => $modDetails,
      'instalasiAsals' => $instalasiAsals,
      'ruanganAsals' => $ruanganAsals,
      'pesan' => $pesan,
    ));
  }

  /**
   * untuk menyimpan Pemusnahanoadetail_t
   * @param type $modPemusnahan
   * @param type $postDetail
   */
  protected function simpanPemusnahanDetail($modPemusnahan, $postDetail)
  {
    $format = new MyFormatter();
    $modPemusnahanDetail = new GFPemusnahanoadetailT;
    $modPemusnahanDetail->attributes = $postDetail;
    $modPemusnahanDetail->pemusnahanobatalkes_id = $modPemusnahan->pemusnahanobatalkes_id;
    $modPemusnahanDetail->obatalkes_id = $postDetail['obatalkes_id'];
    $modPemusnahanDetail->jmlbarang = $postDetail['jmlbarang'];
    $modPemusnahanDetail->tglkadaluarsa = $format->formatDateTimeForDb($postDetail['tglkadaluarsa']);
    $modPemusnahanDetail->nobatch = $postDetail['nobatch'];
    $modPemusnahanDetail->harganetto = $postDetail['harganetto'];
    $modPemusnahanDetail->kondisibarang = $postDetail['kondisibarang'];

    if ($modPemusnahanDetail->save()) {
      $this->pemusnahandetailtersimpan &= true;
    } else {
      $this->pemusnahandetailtersimpan &= false;
    }
    return $modPemusnahanDetail;
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modPemusnahan
   * @param type $modPemusnahanDetail
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modPemusnahanDetail)
  {
    //        echo "a";exit;
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modPemusnahanDetail->jmlbarang;
    $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
    $modStokOaNew->pemusnahanoadet_id = $modPemusnahanDetail->pemusnahanoadetail_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->tglkadaluarsa = MyFormatter::formatDateTimeForDb($modStokOaNew->tglkadaluarsa);
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
    //	var_dump($modStokOaNew->attributes);
    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GFMutasioaruanganT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
  /**
   * Memanggil data dari model detail.
   * @param integer the ID of the model to be loaded
   */
  public function loadModelDetails($id)
  {
    $criteria = new CdbCriteria();
    $criteria->addCondition('pemusnahanobatalkes_id = ' . $id);
    $criteria->join = "LEFT JOIN stokobatalkes_t ON stokobatalkes_t.pemusnahanoadet_id = t.pemusnahanoadetail_id";
    $criteria->select = "*, stokobatalkes_t.stokobatalkes_id AS stokobatalkes_id";
    $models = GFPemusnahanoadetailT::model()->findAll($criteria);
    if ($models === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $models;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfpemusnahanobatalkes-t-form') {
      echo CActiveForm::validate($model);
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
      $models = GFPegawaiV::model()->findAll($criteria);
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
      $models = GFPegawaiV::model()->findAll($criteria);
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
   * menampilkan obat
   * @return row table 
   */
  public function actionSetFormPemusnahanDetail()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $stokobatalkes_id = $_POST['stokobatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $ruangan_id = $_POST['ruanganasal_id'];
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modPemusnahanDetail = new GFPemusnahanoadetailT;
      if (empty($ruangan_id)) {
        $ruangan_id = Yii::app()->user->getState('ruangan_id');
      }
      $modStokOAs = StokobatalkesT::model()->findAllByAttributes(array('stokobatalkes_id' => $stokobatalkes_id, 'stokoa_aktif' => true));
      if (count((array)$modStokOAs) > 0) {
        $totalharganetto = 0;
        $totalhargajual = 0;
        foreach ($modStokOAs as $i => $stok) {
          $modPemusnahanDetail->obatalkes_id = $stok->obatalkes_id;
          $modPemusnahanDetail->stokobatalkes_id = $stok->stokobatalkes_id;
          $modPemusnahanDetail->jmlbarang = $jumlah;
          $modPemusnahanDetail->harganetto = round($stok->HPP);
          $modPemusnahanDetail->hargajualsatuan = round($stok->getHargaJualSatuanSesuaiTransaksi());
          $modPemusnahanDetail->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modPemusnahanDetail->tglkadaluarsa = $format->formatDateTimeForUser($stok->tglkadaluarsa);
          $modPemusnahanDetail->jmlstok = $stok->getJumlahStok($stok->obatalkes_id, $ruangan_id);
          $modPemusnahanDetail->nobatch = isset($stok->obatalkes->nobatch) ? $stok->obatalkes->nobatch : "-";
          $modPemusnahanDetail->ruangan_nama = isset($stok->ruangan->ruangan_nama) ? $stok->ruangan->ruangan_nama : "-";

          $form .= $this->renderPartial($this->path_view . '_rowPemusnahanDetail', array('modPemusnahanDetail' => $modPemusnahanDetail), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasiasal_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganAsalPemusnahan($instalasi_id), 'ruangan_id', 'ruangan_nama');

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
   * ini harus sama dengan criteria / data yg ditampilkan di grid pemilihan dialogbox
   */
  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      if (!empty($_GET['ruangan_id'])) {
        $criteria->addCondition('ruangan_id = ' . $_GET['ruangan_id']);
      } else {
        $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      }
      $criteria->addCondition('stokoa_aktif = TRUE');
      $criteria->addCondition('qtystok_in > 0');
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = GFInformasikartustokobatalkesV::model()->findAll($criteria);

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
   * untuk print data rencana kebutuhan farmasi
   */
  public function actionPrint($pemusnahanobatalkes_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $model = GFPemusnahanobatalkesT::model()->findByPk($pemusnahanobatalkes_id);
    $modDetails = GFPemusnahanoadetailT::model()->findAllByAttributes(array('pemusnahanobatalkes_id' => $pemusnahanobatalkes_id));

    $judul_print = 'Pemusnahan Obat Alkes';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraprint' => $caraprint
    ));
  }
}
