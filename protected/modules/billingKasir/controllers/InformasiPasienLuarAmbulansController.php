<?php

class InformasiPasienLuarAmbulansController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'billingKasir.views.informasiPasienLuarAmbulans.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Pasien Luar Ambulans";
    $format = new MyFormatter();
    $model = new BKRinciantagihanpasienpenunjangV('searchRincianTagihan');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values
    $model->statusBayar = "BELUM LUNAS";

    if (isset($_GET['BKRinciantagihanpasienpenunjangV'])) {
      $model->attributes = $_GET['BKRinciantagihanpasienpenunjangV'];
      // $model->statusBayar=$_GET['BKRinciantagihanpasienpenunjangV']['statusBayar'];
      // $model->statusperiksa=$_GET['BKRinciantagihanpasienpenunjangV']['statusperiksa']; 
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKRinciantagihanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKRinciantagihanpasienpenunjangV']['tgl_akhir']);
    }


    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionRincian($pembayaranpelayanan_id = null, $id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya Sementara';
    // $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $criteria = new CDbCriteria();
    $criteria->order = 'ruangan_id';
    $criteria->addCondition('pendaftaran_id = ' . $id);
    if (empty($pembayaranpelayanan_id)) {
      $criteria->addCondition('tindakansudahbayar_id IS NULL'); //belum lunas rincianpemeriksaanlabrad_v RincianpemeriksaanlabradV
      $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAll($criteria);
    } else {
      // $criteria->addCondition('tindakansudahbayar_id > 0'); //sudah lunas rinciantagihapasiensudahbayar_v
      $modRincian = RinciantagihapasiensudahbayarV::model()->findAll($criteria);
    }
    $modRincianTagihan = RinciantagihanpasienV::model()->find('pendaftaran_id = ' . $id . ' and tindakansudahbayar_id is null');
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $data['nama_pegawai'] = empty($lp->pegawai_id) ? "" : $lp->pegawai->nama_pegawai;

    $this->render(
      $this->path_view . 'rincian',
      array(
        'modRincian' => $modRincian, 'data' => $data,
        'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modRincianTagihan' => $modRincianTagihan
      )
    );
  }

  public function actionPrint()
  {
    $id = $_REQUEST['id'];
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $data['judulLaporan'] = 'Data Rincian Tagihan Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('billingKasir.views.rinciantagihanpasienpenunjangV.rincian', array('modPenunjang' => $modPenunjang, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('billingKasir.views.rinciantagihanpasienpenunjangV.rincian', array('modPenunjang' => $modPenunjang, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
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
      $mpdf->WriteHTML($this->renderPartial('billingKasir.views.rinciantagihanpasienpenunjangV.rincian', array('modPenunjang' => $modPenunjang, 'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
