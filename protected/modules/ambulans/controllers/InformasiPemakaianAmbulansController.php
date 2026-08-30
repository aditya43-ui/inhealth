<?php
class InformasiPemakaianAmbulansController extends MyAuthController
{
  public $layout = '//layouts/column1';

  public $is_hapustindakan = false;

  public function actionIndex()
  {
    $model = new AMInformasipemakaianambulansV;
    $format = new MyFormatter;
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir  = date('Y-m-d');
    if (isset($_GET['AMInformasipemakaianambulansV'])) {
      $model->unsetAttributes();
      $model->attributes = $_GET['AMInformasipemakaianambulansV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AMInformasipemakaianambulansV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMInformasipemakaianambulansV']['tgl_akhir']);
    }
    $this->pageTitle = Yii::app()->name . " - Pemakaian Ambulans";
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionView($pemakaianambulans_id)
  {
    $this->layout = '//layouts/iframe';
    $model = AMInformasipemakaianambulansV::model()->findByAttributes(array('pemakaianambulans_id' => $pemakaianambulans_id));
    $format = new MyFormatter;
    $this->render('view', array('model' => $model, 'format' => $format));
  }

  public function actionBatalPakai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $result = array();
      $pemakaian_id = isset($_POST['pemakaian_id']) ? $_POST['pemakaian_id'] : null;
      $pemesanan_id = isset($_POST['pemesanan_id']) ? $_POST['pemesanan_id'] : null;
      $modPemakaiAmbulans = AMPemakaianambulansT::model()->findByPk($pemakaian_id);
      $modPemesananambulans = AMPesanambulansT::model()->findByAttributes(array('pemakaianambulans_id' => $pemakaian_id));

      $trans = Yii::app()->db->beginTransaction();
      $status = 'berhasil';
      $msg = 'Pemakaian Ambulans berhasil dibatalkan.';

      if (!empty($modPemesananambulans)) {


        $updatePemakaian = PemakaianambulansT::model()->updateByPk($pemakaian_id, array('pesanambulans_t' => null));
        $updatePemesanan = PesanambulansT::model()->updateByPk($modPemesananambulans->pesanambulans_t, array('pemakaianambulans_id' => null));
        if ($updatePemakaian && $updatePemesanan) {
          $modBatal = $this->saveBatalPakai($modPemakaiAmbulans);

          if ($this->is_hapustindakan) {
            $updatePemakaian = PemakaianambulansT::model()->updateByPk($pemakaian_id, array('batalpakaiambulans_id' => $modBatal->batalpakaiambulans_id));
            MobilambulansM::model()->updateByPk($modPemakaiAmbulans->mobilambulans_id, array(
              'isterpakai' => false,
            ));
          } else {
            $status = 'gagal';
            $msg = "Pemakaian Ambulans tidak bisa dibatalkan dikarenakan sudah dibayar.";
          }
        } else {
          $status = 'gagal';
        }
      } else {
        $modBatal = $this->saveBatalPakai($modPemakaiAmbulans);
        if ($this->is_hapustindakan) {
          $updatePemakaian = PemakaianambulansT::model()->updateByPk($pemakaian_id, array('batalpakaiambulans_id' => $modBatal->batalpakaiambulans_id));
          MobilambulansM::model()->updateByPk($modPemakaiAmbulans->mobilambulans_id, array(
            'isterpakai' => false,
          ));
        } else {
          $status = 'gagal';
          $msg = "Pemakaian Ambulans tidak bisa dibatalkan dikarenakan sudah dibayar.";
        }
      }

      if ($status == 'berhasil') {
        $trans->commit();
      } else {
        $trans->rollback();
      }


      $result['status'] = $status;
      $result['msg'] = $msg;
      echo CJSON::encode($result);
    }
    Yii::app()->end();
  }

  public function actionPrintDetail($pemakaianambulans_id)
  {
    $this->layout = '//layouts/printWindows';
    $model = AMInformasipemakaianambulansV::model()->findByAttributes(array('pemakaianambulans_id' => $pemakaianambulans_id));
    $format = new MyFormatter;

    $judul_print = 'Detail Pemakaian Ambulance Pasien';
    $this->render('print', array(
      'format' => $format,
      'model' => $model,
      'judul_print' => $judul_print,
    ));
  }

  public function saveBatalPakai($pakai)
  {

    $this->is_hapustindakan = true;

    $model = new AMBatalpakaiambulansT;
    $model->pemakaianambulans_id = $pakai->pemakaianambulans_id;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->tglpembatalan = date('Y-m-d H:i:s');
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($model->validate()) {
      $model->save();
      PemakaianambulansT::model()->updateByPk($pakai->pemakaianambulans_id, array('tindakanpelayanan_id' => null));

      $tindakan = AMTindakanpelayananT::model()->findByPk($pakai->tindakanpelayanan_id);
      if (!empty($tindakan->tindakansudahbayar_id)) {
        $this->is_hapustindakan = false;
      } else {
        AMTindakanpelayananT::model()->deleteByPk($pakai->tindakanpelayanan_id);
      }
    }

    return $model;
  }

  public function actionUpdateTglKembali()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $ok = 1;

    if (isset($_POST['AMInformasipemakaianambulansV'])) {

      $trans = Yii::app()->db->beginTransaction();

      try {
        $model = PemakaianambulansT::model()->findByPk($_POST['AMInformasipemakaianambulansV']['pemakaianambulans_id']);
        $model->tglkembaliambulans = MyFormatter::formatDateTimeForDb($_POST['AMInformasipemakaianambulansV']['tglkembaliambulans']);
        $model->kmakhir = $_POST['AMInformasipemakaianambulansV']['kmakhir'];
        $model->jumlahkm = $model->kmakhir - $model->kmawal;

        if (!$model->save()) {
          $ok = 0;
        }

        MobilambulansM::model()->updateByPk($model->mobilambulans_id, array(
          'kmterakhirkend' => $model->kmakhir,
          'isterpakai' => false,
        ));

        if ($ok == 1) {
          $trans->commit();
        } else {
          $trans->rollback();
        }
      } catch (Exception $ex) {
        $trans->rollback();
        $ok = 0;
      }
    }

    echo CJSON::encode(array('ok' => $ok));
  }
}
