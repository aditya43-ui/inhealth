<?php

class InformasiRiwayatPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Riwayat Pasien Laboratorium";
    //                
    $model = new LBPasienM('search');
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->tgl_rm_awal = date("d M Y") . ' 00:00:00';
    $model->tgl_rm_akhir = date('d M Y h:i:s');

    if (isset($_GET['LBPasienM'])) {
      $model->attributes = $_GET['LBPasienM'];
      $model->tgl_rm_awal = (isset($_GET['LBPasienM']['tgl_rm_awal']) ? $format->formatDateTimeForDb($_GET['LBPasienM']['tgl_rm_awal']) : null);
      $model->tgl_rm_akhir = (isset($_GET['LBPasienM']['tgl_rm_akhir']) ? $format->formatDateTimeForDb($_GET['LBPasienM']['tgl_rm_akhir']) : null);
    }

    $this->render('laboratorium.views.informasiRiwayatPasien.index', array(
      'model' => $model,
    ));
  }

  public function actionRincian($id)
  {
    $model = new LBPasienM('search');
    // $model->ruangan_id = 10;
    // echo 'a'.print_r($model->getAttributes());
    $modPasien = LBPasienM::model()->findByPK($id);

    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Informasi Riwayat Pemeriksaan Pasien';

    $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findAllByAttributes(array('pasien_id' => $id));

    // echo"<prev>";
    // print_r($modHasilPemeriksaan);
    // exit();
    // $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
    // if(empty($modPenunjang)){
    //     $criteria = new CDbCriteria;
    //     $criteria->with = array('pasienadmisi');
    //		//     if(!empty($id)){
    //					$criteria->addCondition('pasienadmisi.pendaftaran_id = '.$id);
    //				}
    //     $modPenunjang = PasienmasukpenunjangT::model()->find($criteria);
    // }
    // $modRincian = LBRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));

    $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $data['nama_pegawai'] = empty($lp->pegawai_id) ? "" : LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('laboratorium.views.informasiRiwayatPasien.rincian', array('modHasilPemeriksaan' => $modHasilPemeriksaan, 'modPasien' => $modPasien, 'data' => $data));
  }

  public function actionPrint()
  {
    $id = $_REQUEST['id'];
    $modPasien = LBPasienM::model()->findByPK($id);
    $modHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findAllByAttributes(array('pasien_id' => $id));
    // $modRincian = LBRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
    // $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $data['judulLaporan'] = 'Data Riwayat Pemeriksaan Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('laboratorium.views.informasiRiwayatPasien.rincian', array('modHasilPemeriksaan' => $modHasilPemeriksaan, 'modPasien' => $modPasien, 'data' => $data, 'caraPrint' => $caraPrint));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('laboratorium.views.informasiRiwayatPasien.rincian', array('modHasilPemeriksaan' => $modHasilPemeriksaan, 'modPasien' => $modPasien, 'data' => $data, 'caraPrint' => $caraPrint));
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
      $mpdf->WriteHTML($this->renderPartial('laboratorium.views.informasiRiwayatPasien.rincian', array('modHasilPemeriksaan' => $modHasilPemeriksaan, 'modPasien' => $modPasien, 'data' => $data, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
