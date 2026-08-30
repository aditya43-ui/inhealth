<?php

class InformasiPiutangPenjaminController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'billingKasir.views.informasiPiutangPenjamin.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Piutang Penjamin";
    $format = new MyFormatter();
    $model = new BKInformasipiutangpenjaminV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['BKInformasipiutangpenjaminV'])) {
      $model->attributes = $_GET['BKInformasipiutangpenjaminV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipiutangpenjaminV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipiutangpenjaminV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionRincianDetail($pembayaranpelayanan_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
    $modTandaBukti = TandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPembayaranKlaim = PembayarklaimT::model()->findByAttributes(array('tandabuktibayar_id' => $modTandaBukti->tandabuktibayar_id));

    $modDetails = InformasipiutangpenjaminV::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));

    $this->render(
      $this->path_view . 'rincianPiutang',
      array(
        'model' => $model,
        'modTandaBukti' => $modTandaBukti,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        '$modPembayaranKlaim' => $modPembayaranKlaim,
        'modDetails' => $modDetails
      )
    );
  }

  public function actionPrintRincianPiutang($id)
  {
    $model = PembayaranpelayananT::model()->findByPk($id);
    $modTandaBukti = TandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPembayaranKlaim = PembayarklaimT::model()->findByAttributes(array('tandabuktibayar_id' => $modTandaBukti->tandabuktibayar_id));

    $modDetails = InformasipiutangpenjaminV::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $id));

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        $this->path_view . 'rincianPiutang',
        array(
          'model' => $model,
          'modTandaBukti' => $modTandaBukti,
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          '$modPembayaranKlaim' => $modPembayaranKlaim,
          'modDetails' => $modDetails, 'caraPrint' => $caraPrint
        )
      );
    }
  }

  public function actionPrint()
  {
    $format = new MyFormatter();
    $model = new BKInformasipembayarantagihannontunaiV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['BKInformasipembayarantagihannontunaiV'])) {
      $model->attributes = $_GET['BKInformasipembayarantagihannontunaiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgl_akhir']);
    }
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
