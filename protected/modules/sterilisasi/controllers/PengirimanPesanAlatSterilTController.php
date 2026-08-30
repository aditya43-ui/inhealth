<?php

class PengirimanPesanAlatSterilTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $pengirimanSteril = false;
  public $pengirimanSterilDet = true;

  public function actionIndex($id = null)
  {
    $format = new MyFormatter;
    // load data pemesanan
    $modPemesanan = STPesanperlinensterilT::model()->findByPk($id);
    $modRuangan = RuanganM::model()->findByPk($modPemesanan->ruangan_id);
    $modPemesananDet = STPesanperlinensterildetT::model()->findAllByAttributes(array('pesanperlinensteril_id' => $id));

    $model = new STKirimperlinensterilT;
    $model->kirimperlinensteril_no = MyGenerator::noKirimSterilisasi();
    $model->instalasi_nama = $modRuangan->instalasi->instalasi_nama;
    $model->ruangan_id = $modRuangan->ruangan_id;
    $model->ruangan_nama = $modRuangan->ruangan_nama;

    // data untuk proses simpan
    $modDetails = array();
    $modDetail = new STKirimperlinensterildetT;
    if (isset($_POST['STKirimperlinensterilT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['STKirimperlinensterilT'];
        $model->ruangan_id = Yii::app()->user->ruangan_id;
        $model->kirimperlinensteril_tgl = $format->formatDateTimeForDb($_POST['STKirimperlinensterilT']['kirimperlinensteril_tgl']);
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;

        if ($model->save()) {
          $this->pengirimanSteril = true;
          if (count((array)$_POST['STPesanperlinensterildetT']) > 0) {
            foreach ($_POST['STPesanperlinensterildetT'] as $i => $postPemesananSteril) {
              $modDetail = new STKirimperlinensterildetT;
              $modDetail->attributes = $postPemesananSteril;
              $modDetail->kirimperlinensteril_id = $model->kirimperlinensteril_id;
              $modDetail->linen_id = $postPemesananSteril['linen_id'];
              $modDetail->barang_id = $postPemesananSteril['barang_id'];
              $modDetail->kirimperlinensterildet_jml = $postPemesananSteril['pesanperlinensterildet_jml'];
              $modDetail->kirimperlinensterildet_ket = $postPemesananSteril['pesanperlinensterildet_ket'];
              if ($modDetail->save()) {
                $this->pengirimanSterilDet &= true;
                if (empty($model->pesanperlinensteril_id)) {
                  $model->pesanperlinensteril_id = $postPemesananSteril['pesanperlinensteril_id'];
                  $model->save();
                }
              } else {
                $this->pengirimanSterilDet &= false;
              }
            }
          }
        }
        if ($this->pengirimanSteril && $this->pengirimanSterilDet) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $id, 'kirimperlinensteril_id' => $model->kirimperlinensteril_id, 'sukses' => 1));
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
      'model' => $model, 'format' => $format, 'modPemesananDet' => $modPemesananDet
    ));
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
