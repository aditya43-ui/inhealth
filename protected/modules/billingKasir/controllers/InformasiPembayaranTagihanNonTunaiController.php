<?php

class InformasiPembayaranTagihanNonTunaiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'billingKasir.views.informasiPembayaranTagihanNonTunai.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Tagihan Non Tunai";
    $format = new MyFormatter();
    $model = new BKInformasipembayarantagihannontunaiV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tgljatuhtempo_awal = date('Y-m-d');
    $model->tgljatuhtempo_akhir = date('Y-m-d');
    $model->ceklis = false;
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['BKInformasipembayarantagihannontunaiV'])) {
      $model->attributes = $_GET['BKInformasipembayarantagihannontunaiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgl_akhir']);
      $model->tgljatuhtempo_awal = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgljatuhtempo_awal']);
      $model->tgljatuhtempo_akhir = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgljatuhtempo_akhir']);
      $model->ceklis = $_GET['BKInformasipembayarantagihannontunaiV']['ceklis'];
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintAll(){
    // echo "<pre>";
    // var_dump($_GET);die;
    $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
    $format = new MyFormatter();
    // $tgl_awal = $format->formatDateTimeForDb($_POST['tgl_awal']);
    // $tgl_akhir = $format->formatDateTimeForDb($_POST['tgl_akhir']);
    // $carabayar_nama = $_POST['carabayar_nama'];
    // $petugasadministrasi_id = $_POST['petugasadministrasi_id'];
    $criteria = new CDbCriteria;
    // $criteria->addBetweenCondition('DATE(tglpembayaran)', $tgl_awal, $tgl_akhir);
    // $criteria->compare('lower(carabayar_nama)', strtolower($carabayar_nama));
    // if (!empty($petugasadministrasi_id)) {
    //   $criteria->addCondition('petugasadministrasi_id = ' . $petugasadministrasi_id);
    // }
    // $criteria->order='jnspembayar_nama asc';

    // $model = BKInformasipembayarantagihannontunaiV::model()->findAll($criteria);
    // $model = new BKInformasipembayarantagihannontunaiV();
    // $model->unsetAttributes();
    // $model->tgl_awal = date('Y-m-d');
    // $model->tgl_akhir = date('Y-m-d');
    // $model->tgljatuhtempo_awal = date('Y-m-d');
    // $model->tgljatuhtempo_akhir = date('Y-m-d');
    // $model->ceklis = false;
      // clear any default values

    if (isset($_GET['BKInformasipembayarantagihannontunaiV'])) {
      // $model->attributes = $_GET['BKInformasipembayarantagihannontunaiV'];
      $tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgl_awal']);
      $tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgl_akhir']);
      $tgljatuhtempo_awal = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgljatuhtempo_awal']);
      $tgljatuhtempo_akhir = $format->formatDateTimeForDb($_GET['BKInformasipembayarantagihannontunaiV']['tgljatuhtempo_akhir']);
      $ceklis = $_GET['BKInformasipembayarantagihannontunaiV']['ceklis'];
      $nopembayaran = $_GET['BKInformasipembayarantagihannontunaiV']['nopembayaran'];
      $no_rekam_medik = $_GET['BKInformasipembayarantagihannontunaiV']['no_rekam_medik'];
      $no_pendaftaran = $_GET['BKInformasipembayarantagihannontunaiV']['no_pendaftaran'];
      $nama_pasien = $_GET['BKInformasipembayarantagihannontunaiV']['nama_pasien'];
      $penjamin_nama = $_GET['BKInformasipembayarantagihannontunaiV']['penjamin_nama'];
      $carabayar_nama = $_GET['BKInformasipembayarantagihannontunaiV']['carabayar_nama'];
      $petugasadministrasi_id = $_GET['BKInformasipembayarantagihannontunaiV']['petugasadministrasi_id'];
      $kelastanggungan_id = $_GET['BKInformasipembayarantagihannontunaiV']['kelastanggungan_id'];
      $instalasi_id = $_GET['BKInformasipembayarantagihannontunaiV']['instalasi_id'];
      $ruangan_id = $_GET['BKInformasipembayarantagihannontunaiV']['ruangan_id'];
      $kelaspelayanan_id = $_GET['BKInformasipembayarantagihannontunaiV']['kelaspelayanan_id'];
      $jnspembayar_id = $_GET['BKInformasipembayarantagihannontunaiV']['jnspembayar_id'];
      $bankpembayaran_id = $_GET['BKInformasipembayarantagihannontunaiV']['bankpembayaran_id'];
      $closingkasir_id = $_GET['BKInformasipembayarantagihannontunaiV']['closingkasir_id'];

    }
    $criteria->addBetweenCondition('DATE(tglpembayaran)', $tgl_awal, $tgl_akhir);

        if($ceklis){
            $criteria->addBetweenCondition('DATE(tgljatuhtempo)', $tgljatuhtempo_awal, $tgljatuhtempo_akhir);
        }


        $criteria->compare('lower(nopembayaran)', strtolower($nopembayaran), true);
        $criteria->compare('lower(no_rekam_medik)', strtolower($no_rekam_medik), true);
        $criteria->compare('lower(no_pendaftaran)', strtolower($no_pendaftaran), true);
        $criteria->compare('lower(nama_pasien)', strtolower($nama_pasien), true);
        // $criteria->compare('lower(dengankartu)', strtolower($dengankartu));
        // $criteria->compare('lower(bank_namapengirim)', strtolower($bank_namapengirim));
        $criteria->compare('lower(carabayar_nama)', strtolower($carabayar_nama));
        $criteria->compare('lower(penjamin_nama)', strtolower($penjamin_nama));
        // $criteria->compare('lower(bank_namapengirim)', strtolower($bank_namapengirim));
        // $criteria->compare('lower(bank_namapengirim)', strtolower($bank_namapengirim));
        // $criteria->compare('lower(bank_namapengirim)', strtolower($bank_namapengirim));

        if (!empty($kelastanggungan_id)) {
            $criteria->addCondition('kelastanggungan_id = ' . $kelastanggungan_id);
        }
        if (!empty($petugasadministrasi_id)) {
            $criteria->addCondition('petugasadministrasi_id = ' . $petugasadministrasi_id);
        }

        if (!empty($instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $instalasi_id);
        }

        if (!empty($ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }

        if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
        }

        if (!empty($bank_id)) {
            $criteria->addCondition('bank_id = ' . $bank_id);
        }

        if (!empty($bankpembayaran_id)) {
            $criteria->addCondition('bankpembayaran_id = ' . $bankpembayaran_id);
        }

        if (!empty($jnspembayar_id)) {
            $criteria->addCondition('jnspembayar_id = ' . $jnspembayar_id);
        }

        if(!empty($closingkasir_id)){
            if ($closingkasir_id == 1):
                $criteria->addCondition('t.closingkasir_id is not null ');
            elseif ($closingkasir_id == 2):
                $criteria->addCondition('t.closingkasir_id is null ');
            endif;
        }
        $criteria->order = 'jnspembayar_id asc';
        $model = BKInformasipembayarantagihannontunaiV::model()->findAll($criteria);


    // echo "<pre>";
    // var_dump($model);

    $this->render('billingKasir.views.informasiPembayaranTagihanNonTunai.printall', array('model'=>$model));



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
