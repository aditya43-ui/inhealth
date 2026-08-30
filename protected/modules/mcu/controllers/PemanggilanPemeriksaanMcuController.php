<?php
class PemanggilanPemeriksaanMcuController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "mcu.views.pemanggilanPemeriksaanMcu.";

  public $pemanggilanmcutersimpan = false; // dilooping

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemanggilan Pemeriksaan Mcu";
    $format = new MyFormatter;
    $model = new MCPendaftaranT;
    $modPasien = new MCPasienM;
    $modPemanggilan = new MCPemanggilanmcuT();
    $modPemanggilanMcu = new MCPemanggilanmcuV();
    $modDetails = array();

    $modPemanggilan->no_pemanggilan = 'Otomatis';
    $modPemanggilan->tglpemanggilanmcu = date('Y-m-d H:i:s');
    $modPemanggilan->tglakanperiksamcu = date('Y-m-d H:i:s');

    $modPemanggilanMcu->tgl_awal_kontrol = date('Y-m-d H:i:s');
    $modPemanggilanMcu->tgl_akhir_kontrol = date('Y-m-d H:i:s');

    if (isset($_POST['MCPemanggilanmcuT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPemanggilan->attributes = $_POST['MCPemanggilanmcuT'];
        $modPemanggilan->no_pemanggilan = MyGenerator::noPemanggilanMcu();

        foreach ($_POST['MCPemanggilanmcuV'] as $i => $data) {
          if (isset($data['cekList']) && $data['cekList'] == 1) {
            $modDetails = $this->simpanPemanggilan($modPemanggilan, $_POST['MCPemanggilanmcuT'], $data);
          }
        }

        if ($this->pemanggilanmcutersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemanggilan pemeriksaan medical check up nomor " . $modPemanggilan->no_pemanggilan . " berhasil disimpan !");
          $this->redirect(array('index', 'no_pemanggilan' => $modPemanggilan->no_pemanggilan, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemanggilan pemeriksaan pasien mcu gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pemanggilan pemeriksaan pasien mcu gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    if (isset($_GET['MCPemanggilanmcuV'])) {

      $modPemanggilanMcu->unsetAttributes();
      $modPemanggilanMcu->attributes = $_GET['MCPemanggilanmcuV'];
      $modPemanggilanMcu->tgl_awal_kontrol = $format->formatDateTimeForDb($_GET['MCPemanggilanmcuV']['tgl_awal_kontrol']);
      $modPemanggilanMcu->tgl_akhir_kontrol = $format->formatDateTimeForDb($_GET['MCPemanggilanmcuV']['tgl_akhir_kontrol']);
    }

    $this->render('index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPemanggilan' => $modPemanggilan,
      'modPemanggilanMcu' => $modPemanggilanMcu
    ));
  }

  /**
   * proses simpan detail pemanggilan mcu
   */
  public function simpanPemanggilan($modPemanggilan, $postPemanggilan, $postDetail)
  {
    $format = new MyFormatter();
    $dataPemanggilan = MCPemanggilanmcuT::model()->findAllByAttributes(array('pendaftaran_id' => $postDetail['pendaftaran_id']));
    $pemanggilanke = 1;
    if (isset($dataPemanggilan)) {
      $pemanggilanke = count((array)$dataPemanggilan) + 1;
    }
    $no_pemanggilan = $modPemanggilan->no_pemanggilan;
    $modPemanggilan = new MCPemanggilanmcuT();
    $modPemanggilan->pendaftaran_id = $postDetail['pendaftaran_id'];
    $modPemanggilan->ruangan_id = $postDetail['ruangan_id'];
    $modPemanggilan->pasien_id = $postDetail['pasien_id'];
    $modPemanggilan->no_pemanggilan = $no_pemanggilan;
    $modPemanggilan->tglpemanggilanmcu = $format->formatDateTimeForDb($postPemanggilan['tglpemanggilanmcu']);
    $modPemanggilan->pemanggilanke = $pemanggilanke;
    $modPemanggilan->tglakanperiksamcu = $format->formatDateTimeForDb($postPemanggilan['tglakanperiksamcu']);
    $modPemanggilan->keterangan_pemanggilan = $postPemanggilan['keterangan_pemanggilan'];
    $modPemanggilan->status_print = 1;
    $modPemanggilan->create_time = date('Y-m-d H:i:s');
    $modPemanggilan->create_loginpemakai_id = Yii::app()->user->id;
    $modPemanggilan->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modPemanggilan->save()) {
      $this->pemanggilanmcutersimpan = true;
    } else {
      $this->pemanggilanmcutersimpan = false;
    }
    return $modPemanggilan;
  }

  /**
   * untuk print data pemanggilan pemeriksaan pasien mcu
   */
  public function actionPrint($no_pemanggilan, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPemanggilan = MCPemanggilanmcuT::model()->findByAttributes(array('no_pemanggilan' => $no_pemanggilan), array('limit' => 1));
    $modPemanggilanDetail = MCPemanggilanmcuT::model()->findAllByAttributes(array('no_pemanggilan' => $no_pemanggilan));

    $judul_print = 'Pemanggilan Pemeriksaan Pasien Medical Check Up (MCU)';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPemanggilan' => $modPemanggilan,
      'modPemanggilanDetail' => $modPemanggilanDetail,
      'caraPrint' => $caraPrint
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = MCPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'pppendaftaran-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
