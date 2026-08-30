<?php

class RinciantagihanpasienpenunjangVController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionIndex()
  {
    //                
    $model = new LBPasienMasukPenunjangV('searchRincian');
    $format = new MyFormatter();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['LBPasienMasukPenunjangV'])) {
      $model->attributes = $_GET['LBPasienMasukPenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBPasienMasukPenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBPasienMasukPenunjangV']['tgl_akhir']);
      $model->statusBayar = $_GET['LBPasienMasukPenunjangV']['statusBayar'];
    }

    $this->render('laboratorium.views.rinciantagihanpasienpenunjangV.index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionRincian($id = null)
  {
    //            $model = new LBRinciantagihanpasienpenunjangV('search');
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = LBPendaftaranT::model()->findByPk($id);
    $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $id));
    if (empty($modPenunjang)) {
      $criteria = new CDbCriteria;
      $criteria->with = array('pasienadmisi');
      if (!empty($id)) {
        $criteria->addCondition('pasienadmisi.pendaftaran_id = ' . $id);
      }
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $modPenunjang = PasienmasukpenunjangT::model()->find($criteria);
    }
    $modRincian = LBRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
    $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $data['nama_pegawai'] = empty($lp->pegawai_id) ? null : $lp->pegawai->nama_pegawai;
    $this->render('laboratorium.views.rinciantagihanpasienpenunjangV.rincian', array(
      'modPenunjang' => $modPenunjang,
      'modPendaftaran' => $modPendaftaran,
      'modRincian' => $modRincian,
      'data' => $data
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = LBRinciantagihanpasienpenunjangV::model()->findByPk($id);
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
    $modPendaftaran = LBPendaftaranT::model()->findByPk($id);
    $modRincian = LBRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 'ruangan_id'));
    $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $data['judulLaporan'] = 'Data Rincian Tagihan Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('laboratorium.views.rinciantagihanpasienpenunjangV.rincian', array('modPenunjang' => $modPenunjang, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('laboratorium.views.rinciantagihanpasienpenunjangV.rincian', array('modPenunjang' => $modPenunjang, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //                //$mpdf->useOddEven = 2;  
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
      $mpdf->WriteHTML($style, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('laboratorium.views.rinciantagihanpasienpenunjangV.rincian', array('modPenunjang' => $modPenunjang, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($data['judulLaporan'] . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
