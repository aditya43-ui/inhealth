<?php

class PembayaranGiziController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.pembayaranGizi.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new GZPasienMasukPenunjangV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GZPasienMasukPenunjangV'])) {
      $model->attributes = $_GET['GZPasienMasukPenunjangV'];
      $model->statusBayar = $_GET['GZPasienMasukPenunjangV']['statusBayar'];
      if (!empty($_GET['GZPasienMasukPenunjangV']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPasienMasukPenunjangV']['tgl_awal']);
      }
      if (!empty($_GET['GZPasienMasukPenunjangV']['tgl_awal'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPasienMasukPenunjangV']['tgl_akhir']);
      }
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modRincian = GZRincianTagihanPasienGizi::model()->findAllByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render($this->path_view . 'rincian', array('modPendaftaran' => $modPendaftaran, 'modAdmisi' => $modAdmisi, 'modRincian' => $modRincian, 'data' => $data));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GZRincianTagihanPasienGizi::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rjrinciantagihanpasien-v-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $id = $_REQUEST['id'];
    $modPendaftaran = GZPendaftaranT::model()->findByPk($id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modRincian = GZRincianTagihanPasienGizi::model()->findAllByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $data['judulLaporan'] = 'Data Rincian Tagihan Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'rincian', array('modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'rincian', array('modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
      $mpdf->WriteHTML($style, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'rincian', array('modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
