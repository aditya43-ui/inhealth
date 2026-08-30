<?php

class RencanaPengembalianOAEDTController extends MyAuthController
{
  public $layout = "//layouts/column1";
  public $renPengembalian = false;
  public $renPengembalianDetail = true;

  public function actionIndex()
  {
    $format = new MyFormatter;
    $model = new GFRenpengembalianedT;
    $model->norenpengembalian = MyGenerator::noRenPengemED();
    $model->tglrenpengembalian = $format->formatDateTimeForUser(date("Y-m-d"));
    $modDetail = new GFRenpengeddetailT;

    if (isset($_POST['GFRenpengembalianedT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = new GFRenpengembalianedT;
        $model->attributes = $_POST['GFRenpengembalianedT'];
        $model->tglrenpengembalian = $format->formatDateTimeForDb($_POST['GFRenpengembalianedT']['tglrenpengembalian']);
        $model->tglmengetahui = isset($model->mengetahui_id) ? date("Y-m-d") : null;
        $model->tglmenyetujui = isset($model->menyetujui_id) ? date("Y-m-d") : null;
        $model->ruangan_id = Yii::app()->user->ruangan_id;
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        if ($model->save()) {
          $this->renPengembalian = true;
          foreach ($_POST['GFRenpengeddetailT'] as $i => $detail) {
            $modDetail = new GFRenpengeddetailT;
            $modDetail->attributes = $detail;
            $modDetail->renpengembalianed_id = $model->renpengembalianed_id;
            if ($modDetail->save()) {
              $this->renPengembalianDetail &= true;
            } else {
              $this->renPengembalianDetail &= false;
            }
          }
        }
        if ($this->renPengembalian && $this->renPengembalianDetail) {
          $transaction->commit();
          $this->redirect(array('index', 'renpengembalianed_id' => $model->renpengembalianed_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Penutupan Periode Rekening gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penutupan Periode Rekening gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  /**
   * menampilkan data rekening
   * @return row table 
   */
  public function actionLoadTabelObatAlkesED()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $supplier_id      = $_POST['supplier_id'];
      $storeeddetail_id    = $_POST['storeeddetail_id'];
      $satuankecil_id      = $_POST['satuankecil_id'];
      $tglkadaluarsa_renpeng  = $_POST['tglkadaluarsa'];
      $obatalkes_id      = $_POST['obatalkes_id'];
      $obatalkes_nama      = $_POST['obatalkes_nama'];
      $jumlah          = $_POST['jumlah'];

      // load nama supplier & nama satuan kecil
      $modSupplier = SupplierM::model()->findByPk($supplier_id);
      $modSatuankecil = SatuankecilM::model()->findByPk($satuankecil_id);

      $format = new MyFormatter();
      $modDetail = new GFRenpengeddetailT;
      $modDetail->obatalkes_id = $obatalkes_id;
      $modDetail->supplier_id = $supplier_id;
      $modDetail->storeeddetail_id = $storeeddetail_id;
      $modDetail->satuankecil_id = $satuankecil_id;
      $modDetail->qty_renpenged = $jumlah;
      $modDetail->tglkadaluarsa_renpeng = $tglkadaluarsa_renpeng;
      $modDetail->obatalkes_nama = $obatalkes_nama;
      $modDetail->supplier_nama = $modSupplier->supplier_nama;
      $modDetail->satuankecil_nama = $modSatuankecil->satuankecil_nama;

      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $this->renderPartial(
            '_rowRencanaPengED',
            array(
              'format' => $format,
              'modDetail' => $modDetail,
            ),
            true
          )
        )
      );
      exit;
    }
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
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
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
      $criteria->select = $criteria->group;
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = GFPegawairuanganV::model()->findAll($criteria);
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
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->with = array('obatalkes');
      $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('isdikembalikan IS FALSE');
      $criteria->order = 'obatalkes.obatalkes_nama';
      $criteria->limit = 5;
      $models = GFStoreeddetailT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama;
        $returnVal[$i]['value'] = $model->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrint($renpengembalianed_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modDetail = array();
    $model = GFRenpengembalianedT::model()->findByPk($renpengembalianed_id);
    $modDetails = GFRenpengeddetailT::model()->findAllByAttributes(array('renpengembalianed_id' => $renpengembalianed_id));

    foreach ($modDetails as $i => $details) {
      // load nama supplier & nama satuan kecil
      $modObatAlkes = ObatalkesM::model()->findByPk($details->obatalkes_id);
      $modSupplier = SupplierM::model()->findByPk($details->supplier_id);
      $modSatuankecil = SatuankecilM::model()->findByPk($details->satuankecil_id);

      $modDetail[$i]['obatalkes_id'] = $details->obatalkes_id;
      $modDetail[$i]['obatalkes_nama'] = $modObatAlkes->obatalkes_nama;
      $modDetail[$i]['supplier_id']  = $details->supplier_id;
      $modDetail[$i]['supplier_nama'] = $modSupplier->supplier_nama;
      $modDetail[$i]['satuankecil_nama'] = $modSatuankecil->satuankecil_nama;
      $modDetail[$i]['qty_renpenged'] = $details->qty_renpenged;
      $modDetail[$i]['tglkadaluarsa_renpeng'] = $format->formatDateTimeForUser($details->tglkadaluarsa_renpeng);
    }

    $judul_print = 'RENCANA PENGEMBALIAN OBAT ALKES EXPIRED';
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
      'model' => $model,
      'modDetail' => $modDetail,
      'caraPrint' => $caraPrint
    ));
  }
}
