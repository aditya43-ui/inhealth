<?php
class LaporanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'kepegawaian.views.laporan.';

  public function actionLaporanPegawai()
  {
    //            $model = new PegawaiM('search');
    //            $format = new MyFormatter();
    //            $model->unsetAttributes();
    //            $model->jns_periode = "hari";
    //            $model->tglpresensi = date('Y-m-d');
    //            $model->tglpresensi_akhir = date('Y-m-d');
    //            $model->bln_awal = date('Y-m');
    //            $model->bln_akhir = date('Y-m');
    //            $model->thn_awal = date('Y');
    //            $model->thn_akhir = date('Y');        
    //            $filter = null;
    //            if (isset($_GET['PegawaiM'])) {
    //                    $model->attributes = $_GET['PegawaiM'];
    //                    $model->jns_periode = $_REQUEST['PegawaiM']['jns_periode'];
    //                    $model->tglpresensi = $format->formatDateTimeForDb($_GET['PegawaiM']['tglpresensi']);
    //                    $model->tglpresensi_akhir = $format->formatDateTimeForDb($_GET['PegawaiM']['tglpresensi_akhir']);
    //                    $model->bln_awal = $format->formatMonthForDb($_GET['PegawaiM']['bln_awal']);
    //                    $model->bln_akhir = $format->formatMonthForDb($_GET['PegawaiM']['bln_akhir']);
    //                    $model->thn_awal = $_GET['PegawaiM']['thn_awal'];
    //                    $model->thn_akhir = $_GET['PegawaiM']['thn_akhir'];
    //                    $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
    //                    $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
    //                    $model->ruangan_id = isset($_GET['PegawaiM']['ruangan_id']) ? $_GET['PegawaiM']['ruangan_id']:'';
    //                    switch($model->jns_periode){
    //                            case 'bulan' : $modprel->tglpresensi = $model->bln_awal."-01"; $model->tglpresensi_akhir = $bln_akhir; break;
    //                            case 'tahun' : $model->tglpresensi = $model->thn_awal."-01-01"; $model->tglpresensi_akhir = $thn_akhir; break;
    //                            default : null;
    //                    }
    //                    $model->tglpresensi = $model->tglpresensi;
    //                    $model->tglpresensi_akhir = $model->tglpresensi_akhir;
    //            }
    //
    //            $this->render('daftarHadir/index',array(
    //                'model'=>$model,
    //            ));

    $this->pageTitle = Yii::app()->name . " - Detail Presensi";
    $model = new PegawaiM();

    $model->tglpresensi = date('01 M Y');
    $model->tglpresensi_akhir = date('d M Y');
    if (isset($_GET['PegawaiM'])) {
      $model->attributes = $_GET['PegawaiM'];
      $model->tglpresensi = $_GET['PegawaiM']['tglpresensi'] . ' 00:00:00';
      $model->tglpresensi_akhir = $_GET['PegawaiM']['tglpresensi_akhir'] . ' 23:59:59';
      $model->ruangan_id = isset($_GET['PegawaiM']['ruangan_id']) ? $_GET['PegawaiM']['ruangan_id'] : null;
      $model->pegawai_id = isset($_GET['PegawaiM']['pegawai_id']) ? $_GET['PegawaiM']['pegawai_id'] : null;
    }
    $this->render('daftarHadir/indexBaru', array(
      'model' => $model,
    ));
  }

  public function actionDetailLaporanAbsen($id, $tgl_awal, $tgl_akhir)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/iframe';
    $model = new KPPresensiT('detailPresensi');
    $model->pegawai_id = $id;
    $model->tglpresensi = $format->formatDateTimeForDb($tgl_awal);
    $model->tglpresensi_akhir = $format->formatDateTimeForDb($tgl_akhir);

    /*
            $model->tglpresensi = date('Y-m-d', strtotime('2013-05-25'));
            $model->tglpresensi_akhir = date('Y-m-d');
            
            if(isset($_GET['PresensiT']))
            {
                $criteria->addBetweenCondition('DATE(tglpresensi)', $_GET['PresensiT']['tglpresensi'], $_GET['PresensiT']['tglpresensi_akhir']);
            }
             * 
             */

    if (isset($_GET['KPPresensiT'])) {
      $format = new MyFormatter();
      $tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
      $tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
      $model->tglpresensi = $tglpresensi;
      $model->tglpresensi_akhir = $tglpresensi_akhir;
    }

    $modPegawai = KPPegawaiM::model()->findByPk($id);

    $model->pegawai_id = $modPegawai->pegawai_id;

    $get = $model->generateTotalKehadiran();

    $totKehadiran = $get['totalkehadiran'];
    $minute = $get['menit'];


    $modPegawai->hadir = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_HADIR] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_HADIR, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->izin = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_IZIN] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_IZIN, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->sakit = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_SAKIT] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_SAKIT, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->dinas = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_DINAS] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_DINAS, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->alpha = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_ALPHA] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_ALPHA, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->cuti = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_CUTI] : 0;
    //$modPegawai->rerata_jam_masuk = $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$tgl_awal,'tgl_akhir'=>$tgl_akhir),true);
    //$modPegawai->rerata_jam_keluar = $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$tgl_awal,'tgl_akhir'=>$tgl_akhir),true);
    $this->render('daftarHadir/detailAbsensiBaru', array(
      'model' => $model,
      'modPegawai' => $modPegawai
    ));
  }

  //buat ngeprint detailPresensi
  public function actionPrintDetailPresensi()
  {
    $model = new PegawaiM;
    $format = new MyFormatter();
    if (isset($_REQUEST['PegawaiM'])) {
      $model->attributes = $_REQUEST['PegawaiM'];
      $model->tglpresensi = MyFormatter::formatDateTimeForDb($_REQUEST['PegawaiM']['tglpresensi']);
      $model->tglpresensi_akhir = MyFormatter::formatDateTimeForDb($_REQUEST['PegawaiM']['tglpresensi_akhir']);
    }

    $periode = $format->formatDateTimeForUser($model->tglpresensi) . ' s/d ' . $format->formatDateTimeForUser($model->tglpresensi_akhir);

    $judulLaporan = 'LAPORAN DETAIL PRESENSI';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('daftarHadir/PrintBaru', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('daftarHadir/PrintBaru', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial('daftarHadir/PrintBaru', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }


  public function actionPrintDetailLaporanPresensi($id, $tglpresensi, $tglpresensi_akhir)
  {
    $model = new KPPresensiT('detailPresensi');
    $model->pegawai_id = $id;
    $modPegawai = KPPegawaiM::model()->findByPk($id);

    //if (isset(KPPresensiT))
    /*
            if(isset($_GET['PresensiT']))
            {
                $criteria->addBetweenCondition('DATE(tglpresensi)', $_GET['PresensiT']['tglpresensi'], $_GET['PresensiT']['tglpresensi_akhir']);
            }
             * 
             */
    if (isset($_REQUEST['tglpresensi'])) {
      $tglpresensi = date('Y-m-d ', strtotime($_REQUEST['tglpresensi']));
      $tglpresensi_akhir = date('Y-m-d ', strtotime($_REQUEST['tglpresensi_akhir']));
      $model->tglpresensi = $tglpresensi;
      $model->tglpresensi_akhir = $tglpresensi_akhir;
    }

    $model->pegawai_id = $modPegawai->pegawai_id;

    $get = $model->generateTotalKehadiran();

    $totKehadiran = $get['totalkehadiran'];
    $minute = $get['menit'];


    $modPegawai->hadir = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_HADIR] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_HADIR, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->izin = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_IZIN] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_IZIN, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->sakit = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_SAKIT] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_SAKIT, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->dinas = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_DINAS] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_DINAS, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->alpha = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_ALPHA] : 0; //$modPegawai->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_ALPHA, $id, $tgl_awal, $tgl_akhir);
    $modPegawai->cuti = isset($totKehadiran[$modPegawai->pegawai_id]) ? $totKehadiran[$modPegawai->pegawai_id][Params::STATUSKEHADIRAN_CUTI] : 0;
    //$modPegawai->rerata_jam_masuk = $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$tglpresensi,'tgl_akhir'=>$tglpresensi_akhir),true);
    // $modPegawai->rerata_jam_keluar = $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$tglpresensi,'tgl_akhir'=>$tglpresensi_akhir),true);

    $judulLaporan = 'LAPORAN DETAIL PRESENSI';
    $caraPrint = $_REQUEST['caraPrint'];
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tglpresensi) . ' s/d ' . $format->formatDateTimeForUser($model->tglpresensi_akhir); //.'<br/>'.strtoupper($modPegawai->namaLengkap)




    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'daftarHadir/_tableBaru',
        array(
          'model' => $model,
          'modPegawai' => $modPegawai,
          'periode' => $periode,
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint
        )
      );
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $judulLaporan = $modPegawai->nama_pegawai;
      $this->render(
        'daftarHadir/_tableBaru',
        array(
          'model' => $model,
          'modPegawai' => $modPegawai,
          'periode' => $periode,
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'daftarHadir/_tableBaru',
          array(
            'model' => $model,
            'modPegawai' => $modPegawai,
            'periode' => $periode,
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint
          ),
          true
        )
      );
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  public function actionLaporanPresensi()
  {
    //            $model = new KPPresensiT('search');
    //            $format = new MyFormatter();
    //            $model->unsetAttributes();
    //            $model->jns_periode = "hari";
    //            $model->tglpresensi = date('Y-m-d');
    //            $model->tglpresensi_akhir = date('Y-m-d');
    //            $model->bln_awal = date('Y-m');
    //            $model->bln_akhir = date('Y-m');
    //            $model->thn_awal = date('Y');
    //            $model->thn_akhir = date('Y');        
    //            $filter = null;
    //            if (isset($_GET['KPPresensiT'])) {
    //                    $model->attributes = $_GET['KPPresensiT'];
    //                    $model->jns_periode = $_REQUEST['KPPresensiT']['jns_periode'];
    //                    $model->tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
    //                    $model->tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
    //                    $model->bln_awal = $format->formatMonthForDb($_GET['KPPresensiT']['bln_awal']);
    //                    $model->bln_akhir = $format->formatMonthForDb($_GET['KPPresensiT']['bln_akhir']);
    //                    $model->thn_awal = $_GET['KPPresensiT']['thn_awal'];
    //                    $model->thn_akhir = $_GET['KPPresensiT']['thn_akhir'];
    //                    $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
    //                    $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
    //                    if(!empty($_GET['KPPresensiT']['ruangan_id'])){
    //                        $model->ruangan_id = $_GET['KPPresensiT']['ruangan_id'];
    //                    }
    //                    switch($model->jns_periode){
    //                            case 'bulan' : $model->tglpresensi = $model->bln_awal."-01"; $model->tglpresensi_akhir = $bln_akhir; break;
    //                            case 'tahun' : $model->tglpresensi = $model->thn_awal."-01-01"; $model->tglpresensi_akhir = $thn_akhir; break;
    //                            default : null;
    //                    }
    //                    $model->tglpresensi = $model->tglpresensi;
    //                    $model->tglpresensi_akhir = $model->tglpresensi_akhir;
    //            }
    //
    //            $this->render('presensiT/_laporanpresensi',array(
    //                'model'=>$model,'format'=>$format,
    //            ));

    $this->pageTitle = Yii::app()->name . " - Presensi";
    $model = new KPPresensiT('search');
    $format = new MyFormatter();

    if (isset($_GET['KPPresensiT'])) {
      $model->attributes = $_GET['KPPresensiT'];
      $tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
      $tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
      //$tglpresensi = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi']));
      // $tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi_akhir']));
      $model->tglpresensi = $tglpresensi;
      $model->tglpresensi_akhir = $tglpresensi_akhir;
      $model->jenistenagamedis_id = !empty($_GET['KPPresensiT']['jenistenagamedis_id']) ? $_GET['KPPresensiT']['jenistenagamedis_id'] : null;
      $model->kategoripegawaiasal = !empty($_GET['KPPresensiT']['kategoripegawaiasal']) ? $_GET['KPPresensiT']['kategoripegawaiasal'] : null;
      $model->kelompokjabatan = !empty($_GET['KPPresensiT']['kelompokjabatan']) ? $_GET['KPPresensiT']['kelompokjabatan'] : null;
      $model->ruangan_id = isset($_GET['KPPresensiT']['ruangan_id']) ? $_GET['KPPresensiT']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['KPPresensiT']['instalasi_id']) ? $_GET['KPPresensiT']['instalasi_id'] : null;
      $model->shift_id = isset($_GET['KPPresensiT']['shift_id']) ? $_GET['KPPresensiT']['shift_id'] : null;
      $model->kelompokpegawai_id = isset($_GET['KPPresensiT']['kelompokpegawai_id']) ? $_GET['KPPresensiT']['kelompokpegawai_id'] : null;
      $model->jabatan_id = isset($_GET['KPPresensiT']['jabatan_id']) ? $_GET['KPPresensiT']['jabatan_id'] : null;
      $model->statusscan = isset($_GET['KPPresensiT']['statusscan']) ? $_GET['KPPresensiT']['statusscan'] : null;

      //				else{
      //					$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      //				}
      // $model->unit_perusahaan = $_GET['KPPresensiT']['unit_perusahaan'];
    } else {
      $model->tglpresensi = date('d M Y');
      $model->tglpresensi_akhir = date('d M Y');
    }
    $this->render('presensiT/_laporanpresensi', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionPrintLaporanPresensi()
  {
    $model = new KPPresensiT('search');
    $model->tglpresensi = date('Y-m-d 00:00:00');
    $model->tglpresensi_akhir = date('Y-m-d 23:59:59');
    $format = new MyFormatter();
    if (isset($_GET['KPPresensiT'])) {
      $model->attributes = $_GET['KPPresensiT'];
      $tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
      $tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
      //$tglpresensi = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi']));
      // $tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi_akhir']));
      $model->tglpresensi = $tglpresensi;
      $model->tglpresensi_akhir = $tglpresensi_akhir;
      $model->jenistenagamedis_id = !empty($_GET['KPPresensiT']['jenistenagamedis_id']) ? $_GET['KPPresensiT']['jenistenagamedis_id'] : null;
      $model->kategoripegawaiasal = !empty($_GET['KPPresensiT']['kategoripegawaiasal']) ? $_GET['KPPresensiT']['kategoripegawaiasal'] : null;
      $model->kelompokjabatan = !empty($_GET['KPPresensiT']['kelompokjabatan']) ? $_GET['KPPresensiT']['kelompokjabatan'] : null;
      $model->ruangan_id = isset($_GET['KPPresensiT']['ruangan_id']) ? $_GET['KPPresensiT']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['KPPresensiT']['instalasi_id']) ? $_GET['KPPresensiT']['instalasi_id'] : null;
      $model->shift_id = isset($_GET['KPPresensiT']['shift_id']) ? $_GET['KPPresensiT']['shift_id'] : null;
      $model->kelompokpegawai_id = isset($_GET['KPPresensiT']['kelompokpegawai_id']) ? $_GET['KPPresensiT']['kelompokpegawai_id'] : null;
      $model->jabatan_id = isset($_GET['KPPresensiT']['jabatan_id']) ? $_GET['KPPresensiT']['jabatan_id'] : null;
      $model->statusscan = isset($_GET['KPPresensiT']['statusscan']) ? $_GET['KPPresensiT']['statusscan'] : null;
      //				else{
      //					$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      //				}
      // $model->unit_perusahaan = $_GET['KPPresensiT']['unit_perusahaan'];
    } else {
      $model->tglpresensi = date('d M Y');
      $model->tglpresensi_akhir = date('d M Y');
    }
    //  $model->unit_perusahaan = $_GET['KPPresensiT']['unit_perusahaan'];

    $judulLaporan = 'LAPORAN PRESENSI';
    $caraPrint = $_REQUEST['caraPrint'];
    $periode = $format->formatDateTimeForUser($model->tglpresensi) . ' s/d ' . $format->formatDateTimeForUser($model->tglpresensi_akhir);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('presensiT/PrintBaru', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('presensiT/PrintBaru', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial('presensiT/PrintBaru', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  public function actionFramePresensi()
  {
    $this->layout = '//layouts/iframe';

    $model = new PresensiT;
    $model->tglpresensi = date('Y-m-d 00:00:00');
    $model->tglpresensi_akhir = date('Y-m-d 23:59:59');

    //Data Grafik
    $data['title'] = 'Grafik Presensi';
    $data['type'] = $_GET['type'];

    if (isset($_REQUEST['PresensiT'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['PresensiT'];
      $tglpresensi = date('Y-m-d ', strtotime($_GET['PresensiT']['tglpresensi']));
      $tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['PresensiT']['tglpresensi_akhir']));

      $model->tglpresensi = $tglpresensi;
      $model->tglpresensi_akhir = $tglpresensi_akhir;
    }
    $searchdata = $model->searchPresensiGrafik();
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchdata,
    ));
  }

  public function actionLaporanPenggajian()
  {
    $model = new KPPenggajianpegT('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d 23:59:59');
    if (isset($_GET['KPPenggajianpegT'])) {
      $format = new MyFormatter;
      $model->nama_pegawai = $_GET['KPPenggajianpegT']['nama_pegawai'];
      $model->jabatan_id = $_GET['KPPenggajianpegT']['jabatan_id'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_akhir']);
    }

    $this->render('penggajianpegT/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanPenggajian()
  {
    $model = new KPPenggajianpegT('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d 23:59:59');

    $format = new MyFormatter;
    if (isset($_GET['KPPenggajianpegT'])) {
      $model->nama_pegawai = $_GET['KPPenggajianpegT']['nama_pegawai'];
      $model->jabatan_id = $_GET['KPPenggajianpegT']['jabatan_id'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KPPenggajianpegT']['tgl_akhir']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    //                    $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
    $periode = 'asdasdasd';
    $judulLaporan = 'Laporan Penggajian';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('penggajianpegT/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('penggajianpegT/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  // Ukuran Kertas Pdf
      $posisi = Yii::app()->session['posisi_kertas'];                                      // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('penggajianpegT/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  //        protected function parserTanggal($tglpresensi){
  //                    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($tgl, 'yyyy-MM-dd hh:mm:ss'));
  //
  //                }

  protected function parserTanggal($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null) . ' ' . $result[1];
  }

  public function actionGetRuanganForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
          $ruangan = RuanganM::model()->findAll('instalasi_id=9999');
        } else {
          $ruangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . '');
        }
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
        echo CHtml::hiddenField('' . $namaModel . '[ruangan_id]');
        $i = 0;
        if (count((array)$ruangan) > 0) {
          echo "<div>" . CHtml::checkBox('checkAllRuangan', true, array(
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
          )) . "Pilih Semua";
          echo "</div><br>";
          foreach ($ruangan as $value => $name) {

            //                        echo '<label class="checkbox">';
            //                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
            //                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
            //                        echo '</label>';
            $selects[] = $value;
            $i++;
          }
          echo CHtml::checkBoxList('' . $namaModel . "[ruangan_id]", $selects, $ruangan);
        } else {
          echo '<label>Data Tidak Ditemukan</label>';
        }
      }
    }
    Yii::app()->end();
  }


  public function actionRealisasiDiklat()
  {
    $this->pageTitle = Yii::app()->name . " - Realisasi Diklat";
    $model = new KPLaporanrealisasidiklateksternalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $modInternal = new KPLaporanrealisasidiklatinternalV();
    $modInternal->tgl_awal = date('d F Y');
    $modInternal->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['KPLaporanrealisasidiklateksternalV'])) {
      $model->attributes = $_GET['KPLaporanrealisasidiklateksternalV'];
      $model->jenisdiklat_id = isset($_GET['KPLaporanrealisasidiklateksternalV']['jenisdiklat_id']) ? $_GET['KPLaporanrealisasidiklateksternalV']['jenisdiklat_id'] : null;

      if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_akhir']);
      } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
        $modInternal->jenisdiklat_id = $model->jenisdiklat_id;
        $modInternal->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_awal']);
        $modInternal->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_akhir']);
      }
    }

    $this->render($this->path_view . 'realisasiDiklat.admin', array(
      'model' => $model,
      'modInternal' => $modInternal,
    ));
  }

  /**
   * - digunakan untuk, mencetak prinout realisasi diklat
   */
  public function actionPrintRealisasiDiklat()
  {

    $model = new KPLaporanrealisasidiklateksternalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $modInternal = new KPLaporanrealisasidiklatinternalV();
    $modInternal->tgl_awal = date('d F Y');
    $modInternal->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'Laporan Realisasi Diklat';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Realisasi Diklat';
    //  $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KPLaporanrealisasidiklateksternalV'])) {
      $model->attributes = $_GET['KPLaporanrealisasidiklateksternalV'];
      $model->jenisdiklat_id = $_GET['KPLaporanrealisasidiklateksternalV']['jenisdiklat_id'];

      if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_akhir']);
        $judulLaporan .= ' Eksternal';
        $data['title'] .= ' Eksternal';
      } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
        $modInternal->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_awal']);
        $modInternal->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_akhir']);
        $modInternal->jenisdiklat_id = $model->jenisdiklat_id;
        $judulLaporan .= ' Internal';
        $data['title'] .= ' Internal';
      }
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view . 'realisasiDiklat/_print';

    if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
      $this->printFunction($modInternal, $data, $caraPrint, $judulLaporan, $target);
    } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
  }

  /**
   * - 
   */
  public function actionFrameGrafikRealisasiDiklat()
  {
    $this->layout = '//layouts/iframe';
    $model = new KPLaporanrealisasidiklateksternalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $modInternal = new KPLaporanrealisasidiklatinternalV();
    $modInternal->tgl_awal = date('d F Y');
    $modInternal->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'Laporan Realisasi Diklat';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Realisasi Diklat';
    //  $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KPLaporanrealisasidiklateksternalV'])) {
      $model->attributes = $_GET['KPLaporanrealisasidiklateksternalV'];
      $model->jenisdiklat_id = $_GET['KPLaporanrealisasidiklateksternalV']['jenisdiklat_id'];
      if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_akhir']);
        $judulLaporan .= ' Eksternal';
        $data['title'] .= ' Eksternal';
      } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
        $modInternal->jenisdiklat_id = $model->jenisdiklat_id;
        $modInternal->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_awal']);
        $modInternal->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrealisasidiklateksternalV']['tgl_akhir']);
        $judulLaporan .= ' Internal';
        $data['title'] .= ' Internal';
      }
    }

    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'modInternal' => $modInternal,
      'data' => $data,
    ));
  }

  /**
   *  - digunakan untuk, membuka menu rencana lembur
   */
  public function actionRencanaLembur()
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Lembur";
    $model = new KPLaporanrencanalembur_v();
    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-t');
    $format = new MyFormatter();

    if (isset($_GET['KPLaporanrencanalembur_v'])) {
      $model->attributes = $_GET['KPLaporanrencanalembur_v'];
      $model->tgl_awal = isset($_GET['KPLaporanrencanalembur_v']['tgl_awal']) ?  MyFormatter::formatDateTimeForDb($_GET['KPLaporanrencanalembur_v']['tgl_awal']) : null;
      $model->tgl_akhir = isset($_GET['KPLaporanrencanalembur_v']['tgl_akhir']) ?  MyFormatter::formatDateTimeForDb($_GET['KPLaporanrencanalembur_v']['tgl_akhir']) : null;
    }

    $this->render($this->path_view . 'rencanaLembur.admin', array(
      'model' => $model,
    ));
  }

  /**
   * - digunakan untuk, mencetak prinout rencana lembur
   */
  public function actionPrintRencanaLembur()
  {

    $model = new KPLaporanrencanalembur_v();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $format = new MyFormatter();
    $judulLaporan = 'Laporan Rencana Lembur';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Rencana Lembur';
    //  $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KPLaporanrencanalembur_v'])) {
      $model->attributes = $_GET['KPLaporanrencanalembur_v'];
      $model->tgl_awal =   MyFormatter::formatDateTimeForDb($_GET['KPLaporanrencanalembur_v']['tgl_awal']);
      $model->tgl_akhir =   MyFormatter::formatDateTimeForDb($_GET['KPLaporanrencanalembur_v']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view . 'rencanaLembur/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * - 
   */
  public function actionFrameGrafikRencanaLembur()
  {
    $this->layout = '//layouts/iframe';
    $model = new KPLaporanrencanalembur_v();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $format = new MyFormatter();

    $judulLaporan = 'Laporan Rencana Lembur';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Rencana Lembur';
    //  $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KPLaporanrencanalembur_v'])) {
      $model->attributes = $_GET['KPLaporanrencanalembur_v'];
      $model->tgl_awal = $_GET['KPLaporanrencanalembur_v']['tgl_awal'];
      $model->tgl_akhir = $_GET['KPLaporanrencanalembur_v']['tgl_akhir'];
    }

    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs')
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeId($model->tgl_awal) . ' s/d ' . $format->formatDateTimeId($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   *  - digunakan untuk, membuka menu realisasi diklat
   * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @category		action
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/>
   */
  public function actionRencanaDiklat()
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Diklat";
    $model = new KPLaporanrencanadiklateksternalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $modInternal = new KPLaporanrencanadiklatinternalV();
    $modInternal->tgl_awal = date('d F Y');
    $modInternal->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['KPLaporanrencanadiklateksternalV'])) {
      $model->attributes = $_GET['KPLaporanrencanadiklateksternalV'];
      $model->jenisdiklat_id = isset($_GET['KPLaporanrencanadiklateksternalV']['jenisdiklat_id']) ? $_GET['KPLaporanrencanadiklateksternalV']['jenisdiklat_id'] : null;

      if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_akhir']);
      } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
        $modInternal->jenisdiklat_id = $model->jenisdiklat_id;
        $modInternal->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_awal']);
        $modInternal->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_akhir']);
      }
    }

    $this->render($this->path_view . 'rencanaDiklat.admin', array(
      'model' => $model,
      'modInternal' => $modInternal,
    ));
  }

  /**
   * - digunakan untuk, mencetak prinout realisasi diklat
   * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @category		action
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/>
   */
  public function actionPrintRencanaDiklat()
  {

    $model = new KPLaporanrencanadiklateksternalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $modInternal = new KPLaporanrencanadiklatinternalV();
    $modInternal->tgl_awal = date('d F Y');
    $modInternal->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'Laporan Rencana Diklat';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Rencana Diklat';
    //  $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KPLaporanrencanadiklateksternalV'])) {
      $model->attributes = $_GET['KPLaporanrencanadiklateksternalV'];
      $model->jenisdiklat_id = $_GET['KPLaporanrencanadiklateksternalV']['jenisdiklat_id'];

      if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_akhir']);
        $judulLaporan .= ' Eksternal';
        $data['title'] .= ' Eksternal';
      } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
        $modInternal->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_awal']);
        $modInternal->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_akhir']);
        $modInternal->jenisdiklat_id = $model->jenisdiklat_id;
        $judulLaporan .= ' Internal';
        $data['title'] .= ' Internal';
      }
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view . 'rencanaDiklat/_print';

    if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
      $this->printFunction($modInternal, $data, $caraPrint, $judulLaporan, $target);
    } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
      $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
  }

  /**
   * - digunakan untuk menampilkan data rencana diklat dalam bentuk grafik batang, pie dan garis
   * @addedBy		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @category		action
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/spaces/MDO/>
   */
  public function actionFrameGrafikRencanaDiklat()
  {
    $this->layout = '//layouts/iframe';
    $model = new KPLaporanrencanadiklateksternalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');

    $modInternal = new KPLaporanrencanadiklatinternalV();
    $modInternal->tgl_awal = date('d F Y');
    $modInternal->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'Laporan Rencana Diklat';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Rencana Diklat';
    //  $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KPLaporanrencanadiklateksternalV'])) {
      $model->attributes = $_GET['KPLaporanrencanadiklateksternalV'];
      $model->jenisdiklat_id = $_GET['KPLaporanrencanadiklateksternalV']['jenisdiklat_id'];
      if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_akhir']);
        $judulLaporan .= ' Eksternal';
        $data['title'] .= ' Eksternal';
      } elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
        $modInternal->jenisdiklat_id = $model->jenisdiklat_id;
        $modInternal->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_awal']);
        $modInternal->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanrencanadiklateksternalV']['tgl_akhir']);
        $judulLaporan .= ' Internal';
        $data['title'] .= ' Internal';
      }
    }

    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'modInternal' => $modInternal,
      'data' => $data,
    ));
  }
}
