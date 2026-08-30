<?php

/**
 * - digunakan sebagai Informasi Rincian Tagihan Pasien
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>

<?php
Yii::import('rawatJalan.models.*');

class RinciantagihanpasienVController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  // public function actionIndex()
  // {
  //   $this->pageTitle = Yii::app()->name . " - Rincian Tagihan Pasien";
  //   //                
  //   $model = new RJInfokunjunganrjV('searchDaftarPasienMcu');
  //   //$model = new RJPendaftaranT('searchDaftarPasien');
  //   $model->unsetAttributes();
  //   $model->tgl_awal = date('d M Y');
  //   $model->tgl_akhir = date('d M Y');
  //   $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
  //   if (isset($_GET['RJInfokunjunganrjV'])) {
  //     $model->attributes = $_GET['RJInfokunjunganrjV'];
  //     $model->statusBayar = $_GET['RJInfokunjunganrjV']['statusBayar'];
  //     $format = new MyFormatter();
  //     $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
  //     $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
  //     $model->pegawai_id = $_GET['RJInfokunjunganrjV']['pegawai_id'];
  //     $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
  //   }

  //   if (Yii::app()->request->isAjaxRequest) {
  //     echo $this->renderPartial('_tableRinciantagihan', array('model' => $model), true);
  //   } else {
  //     $this->render('mcu.views.rinciantagihanpasienV.index', array(
  //       'model' => $model,
  //     ));
  //   }
  // }

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rincian Tagihan Pasien";
    //                
    $model = new MCInfokunjunganmcuV('searchDaftarPasienMcu');
    //$model = new RJPendaftaranT('searchDaftarPasien');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    // $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['MCInfokunjunganmcuV'])) {
      $model->attributes = $_GET['MCInfokunjunganmcuV'];
      $model->statusBayar = $_GET['MCInfokunjunganmcuV']['statusBayar'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['MCInfokunjunganmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['MCInfokunjunganmcuV']['tgl_akhir']);
      $model->pegawai_id = $_GET['MCInfokunjunganmcuV']['pegawai_id'];
      // $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('_tableRinciantagihan', array('model' => $model), true);
    } else {
      $this->render('mcu.views.rinciantagihanpasienV.index', array(
        'model' => $model,
      ));
    }
  }

  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $data['nama_pegawai'] = empty($lp->pegawai_id) ? "-" : $lp->pegawai->nama_pegawai;
    //            $modRincian->pendaftaran_id = $id;
    $this->render('mcu.views.rinciantagihanpasienV.rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = RJRinciantagihanpasienV::model()->findByPk($id);
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

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $id = $_REQUEST['id'];
    $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
    $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $data['nama_pegawai'] = empty($lp->pegawai_id) ? "-" : $lp->pegawai->nama_pegawai;
    $data['judulLaporan'] = 'Data Rincian Tagihan Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('mcu.views.rinciantagihanpasienV.rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint, 'judulLaporan' => $data['judulLaporan']));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('mcu.views.rinciantagihanpasienV.rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint, 'judulLaporan' => $data['judulLaporan']));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $data['judulLaporan'],  'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('mcu.views.rinciantagihanpasienV.rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
