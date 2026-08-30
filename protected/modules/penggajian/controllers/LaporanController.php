<?php

class LaporanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'penggajian.views.penggajianpegT.';
  public $path_view_lap = 'penggajian.views.laporan.';
  public $init = '';

  public function actionLaporanPegawai()
  {
    $model = new PegawaiM();
    if (isset($_GET['PegawaiM'])) {
      $model->attributes = $_GET['PegawaiM'];
    }
    $this->render('daftarHadir/index', array(
      'model' => $model,
    ));
  }

  public function actionDetailLaporanAbsen($id)
  {
    $this->layout = '//layouts/iframe';
    $model = new KPPresensiT('detailPresensi');
    $model->pegawai_id = $id;
    $model->tglpresensi = date('Y-m-d 00:00:00');
    $model->tglpresensi_akhir = date('Y-m-d 23:59:59');

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
    $this->render('daftarHadir/detailAbdesensi', array(
      'model' => $model,
      'modPegawai' => $modPegawai
    ));
  }

  //buat ngeprint detailPresensi
  public function actionPrintDetailPresensi()
  {
    $model = new PegawaiM;
    $model->attributes = $_REQUEST['PegawaiM'];
    $judulLaporan = 'Laporan Presensi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('daftarHadir/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('daftarHadir/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('daftarHadir/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintDetailLaporanPresensi($id)
  {
    $model = new KPPresensiT('detailPresensi');
    $model->pegawai_id = $id;
    $modPegawai = KPPegawaiM::model()->findByPk($id);
    /*
          if(isset($_GET['PresensiT']))
          {
          $criteria->addBetweenCondition('DATE(tglpresensi)', $_GET['PresensiT']['tglpresensi'], $_GET['PresensiT']['tglpresensi_akhir']);
          }
         * 
         */
    $modPegawai = KPPegawaiM::model()->findByPk($id);

    $judulLaporan = 'Laporan Presensi Per Pegawai';
    $caraPrint = $_REQUEST['caraPrint'];
    $periode = null;
    if (isset($_REQUEST['tglpresensi'])) {
      $tglpresensi = date('Y-m-d ', strtotime($_REQUEST['tglpresensi']));
      $tglpresensi_akhir = date('Y-m-d ', strtotime($_REQUEST['tglpresensi_akhir']));
      $model->tglpresensi = $tglpresensi;
      $model->tglpresensi_akhir = $tglpresensi_akhir;
    }

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'daftarHadir/_printWindows',
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
        'daftarHadir/_printExel',
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
      //$mpdf->useOddEven = 2;
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 5, 5, 5, 5);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'daftarHadir/_printPdf',
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
      $mpdf->Output();
    }
  }

  public function actionLaporanPresensi()
  {
    $model = new KPPresensiT('search');
    $format = new MyFormatter();

    if (isset($_GET['KPPresensiT'])) {
      $model->attributes = $_GET['KPPresensiT'];
      $tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
      $tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
      $tglpresensi = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi']));
      $tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi_akhir']));
      $model->tglpresensi = $tglpresensi;
      $model->tglpresensi_akhir = $tglpresensi_akhir;
      if (!empty($_GET['KPPresensiT']['ruangan_id'])) {
        $model->ruangan_id = $_GET['KPPresensiT']['ruangan_id'];
      }
      //				else{
      //					$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      //				}
      $model->unit_perusahaan = $_GET['KPPresensiT']['unit_perusahaan'];
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
    $model->attributes = $_GET['KPPresensiT'];
    $model->tglpresensi = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi']));
    $model->tglpresensi_akhir = date('Y-m-d ', strtotime($_GET['KPPresensiT']['tglpresensi_akhir']));
    $model->unit_perusahaan = $_GET['KPPresensiT']['unit_perusahaan'];

    $judulLaporan = 'Laporan Presensi';
    $caraPrint = $_REQUEST['caraPrint'];
    $periode = $this->parserTanggal($model->tglpresensi) . ' s/d ' . $this->parserTanggal($model->tglpresensi_akhir);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('presensiT/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('presensiT/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('presensiT/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
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
    $this->pageTitle = Yii::app()->name . " - Penggajian";
    $model = new GJPenggajianpegT('search');
    $model->tglpenggajian = date('Y-m-01');
    if (isset($_GET['GJPenggajianpegT'])) {
      $format = new MyFormatter;
      $model->nama_pegawai = $_GET['GJPenggajianpegT']['nama_pegawai'];
      $model->jabatan_id = isset($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : null;
      $model->unitkerja_id = isset($_GET['GJPenggajianpegT']['unitkerja_id']) ? $_GET['GJPenggajianpegT']['unitkerja_id'] : null;
      $model->tglpenggajian = isset($_GET['GJPenggajianpegT']['tglpenggajian']) ? MyFormatter::formatDateTimeForDb($_GET['GJPenggajianpegT']['tglpenggajian']) : null;
    }
    $this->render($this->path_view_lap . 'penggajianpegT/index', array(
      'model' => $model
    ));
  }

  public function actionPrintLaporanPenggajian()
  {
    $model = new GJPenggajianpegT('search');

    $format = new MyFormatter;


    // var_dump($_GET); die;

    if (isset($_GET['GJPenggajianpegT'])) {
      $model->nama_pegawai = $_GET['GJPenggajianpegT']['nama_pegawai'];
      $model->jabatan_id = isset($_GET['GJPenggajianpegT']['jabatan_id']) ? $_GET['GJPenggajianpegT']['jabatan_id'] : null;
      $model->tglpenggajian = isset($_GET['GJPenggajianpegT']['tglpenggajian']) ? MyFormatter::formatDateTimeForDb($_GET['GJPenggajianpegT']['tglpenggajian']) : null;
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $periode = MyFormatter::formatDateTimeForUser($model->tglpenggajian);
    // $periode = 'asdasdasd';
    $judulLaporan = 'LAPORAN PENGGAJIAN';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('penggajian.views.laporan.penggajianpegT/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('penggajian.views.laporan.penggajianpegT/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                    // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                     // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //            //$mpdf->useOddEven = 2;
      // $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage('L', '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('penggajian.views.laporan.penggajianpegT/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
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
          echo "<div style='margin-left:-70px;'>" . CHtml::checkBox('checkAllRuangan', true, array(
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

  public function actionRekapTrendPenghasilanTahun()
  {
    $model = new GJRekaptrenpengahasilansetahunV();
    $model->periodegaji = date('Y');
    if (isset($_GET['GJRekaptrenpengahasilansetahunV'])) {
      $format = new MyFormatter;
      $model->periodegaji = $_GET['GJRekaptrenpengahasilansetahunV']['periodegaji'];
      $model->nama_pegawai = $_GET['GJRekaptrenpengahasilansetahunV']['nama_pegawai'];
      $model->jabatan_id = isset($_GET['GJRekaptrenpengahasilansetahunV']['jabatan_id']) ? $_GET['GJRekaptrenpengahasilansetahunV']['jabatan_id'] : null;
    }
    $this->render($this->path_view_lap . 'rekapTrendPenghasilanTahun/index', array(
      'model' => $model
    ));
  }

  public function actionPrintRekapTrendPenghasilanTahun()
  {
    $model = new GJRekaptrenpengahasilansetahunV();
    $model->periodegaji = date('Y');

    if (isset($_GET['GJRekaptrenpengahasilansetahunV'])) {
      $format = new MyFormatter;
      $model->periodegaji = $_GET['GJRekaptrenpengahasilansetahunV']['periodegaji'];
      $model->nama_pegawai = $_GET['GJRekaptrenpengahasilansetahunV']['nama_pegawai'];
      $model->jabatan_id = isset($_GET['GJRekaptrenpengahasilansetahunV']['jabatan_id']) ? $_GET['GJRekaptrenpengahasilansetahunV']['jabatan_id'] : null;
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $periode = "Tahun " . $model->periodegaji;
    // $periode = 'asdasdasd';
    $judulLaporan = 'LAPORAN Rekap Trend Penghasilan Setahun';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view_lap . 'rekapTrendPenghasilanTahun/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view_lap . 'rekapTrendPenghasilanTahun/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                    // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                     // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      //            //$mpdf->useOddEven = 2;
      //            $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view_lap . 'rekapTrendPenghasilanTahun/Print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionDetailRekapPenghasilan($pegawai_id, $periodegaji)
  {
    $this->layout = '//layouts/iframe';

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : "";

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view_lap . 'rekapTrendPenghasilanTahun/detailPenghasilan', array('pegawai_id' => $pegawai_id, 'periodegaji' => $periodegaji, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view_lap . 'rekapTrendPenghasilanTahun/detailPenghasilan', array('pegawai_id' => $pegawai_id, 'periodegaji' => $periodegaji, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                    // Ukuran Kertas Pdf
      $posisi = 'L';                                     // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      // //$mpdf->useOddEven = 2;
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 25, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view_lap . 'rekapTrendPenghasilanTahun/detailPenghasilan', array('pegawai_id' => $pegawai_id, 'periodegaji' => $periodegaji, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    } else {
      $this->render($this->path_view_lap . 'rekapTrendPenghasilanTahun/detailPenghasilan', array(
        'pegawai_id' => $pegawai_id,
        'periodegaji' => $periodegaji,
      ));
    }
  }

  public function actionLaporanRekapPajakDokter($filterruangan = null)
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Pajak Dokter";
    $model = new GJLaporanrekappajakdokterV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->bln_awal = MyFormatter::formatMonthForUser(date('M Y'));
    $model->bln_akhir = MyFormatter::formatMonthForUser(date('M Y'));
    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-t');

    if ($filterruangan)
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['GJLaporanrekappajakdokterV'])) {
      $model->attributes = $_GET['GJLaporanrekappajakdokterV'];
      $tgl_input = MyFormatter::formatMonthForDb($_GET['GJLaporanrekappajakdokterV']['bln_awal']) . "-01";
      $tgl_input_akhir = MyFormatter::formatMonthForDb($_GET['GJLaporanrekappajakdokterV']['bln_akhir']) . "-01";

      if (strtotime($tgl_input) > strtotime($tgl_input_akhir)) {
        $tgl_awal = date('Y-m-01 00:00:00', strtotime($tgl_input_akhir));
        $tgl_akhir = date('Y-m-t 00:00:00', strtotime($tgl_input));
      } else {
        $tgl_awal = date('Y-m-01 00:00:00', strtotime($tgl_input));
        $tgl_akhir = date('Y-m-t 00:00:00', strtotime($tgl_input_akhir));
      }

      $model->tgl_awal = $tgl_awal;
      $model->tgl_akhir = $tgl_akhir;
    }

    $this->layout = "//layouts/iframe";
    $this->render($this->path_view_lap . 'rekapPajakDokter/_adminRekap', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionPrintLaporanRekapPajakDokter()
  {
    $model = new GJRekaptrenpengahasilansetahunV();
    $model = new GJLaporanrekappajakdokterV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->bln_awal = MyFormatter::formatMonthForUser(date('M Y'));
    $model->bln_akhir = MyFormatter::formatMonthForUser(date('M Y'));
    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-t');

    //        if ($filterruangan) $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['GJLaporanrekappajakdokterV'])) {
      $model->attributes = $_GET['GJLaporanrekappajakdokterV'];
      $tgl_input = MyFormatter::formatMonthForDb($_GET['GJLaporanrekappajakdokterV']['bln_awal']) . "-01";
      $tgl_input_akhir = MyFormatter::formatMonthForDb($_GET['GJLaporanrekappajakdokterV']['bln_akhir']) . "-01";


      if (strtotime($tgl_input) > strtotime($tgl_input_akhir)) {
        $tgl_awal = date('Y-m-01 00:00:00', strtotime($tgl_input_akhir));
        $tgl_akhir = date('Y-m-t 00:00:00', strtotime($tgl_input));
      } else {
        $tgl_awal = date('Y-m-01 00:00:00', strtotime($tgl_input));
        $tgl_akhir = date('Y-m-t 00:00:00', strtotime($tgl_input_akhir));
      }

      $model->tgl_awal = $tgl_awal;
      $model->tgl_akhir = $tgl_akhir;
    }
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : "";
    $periode = "";

    $judulLaporan = 'LAPORAN AKUMULASI JASA & PAJAK DOKTER';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view_lap . 'rekapPajakDokter/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view_lap . 'rekapPajakDokter/_print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                    // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                     // Posisi L->Landscape,P->Portait
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 12), true));
      // //$mpdf->useOddEven = 2;  
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 20, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view_lap . 'rekapPajakDokter/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetDokterSpesialis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }
      $criteria->group = $criteria->select = 'pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_nama';
      $models = DokterspesialisV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionLaporanSelisihGaji()
  {
    $model = new GJPenggajianpegT('detailPresensi');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');


    if (isset($_GET['GJPenggajianpegT'])) {
      $format = new MyFormatter();
      $model->bln_awal = $format->formatMonthForDb($_GET['GJPenggajianpegT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GJPenggajianpegT']['bln_akhir']);
    }

    $this->render($this->path_view_lap . 'selisihGaji/index', array(
      'model' => $model,
    ));
  }


  //buat ngeprint detailPresensi
  public function actionPrintLaporanSelisihGaji()
  {
    $model = new GJPenggajianpegT;
    $model->unsetAttributes();
    $model->attributes = $_REQUEST['GJPenggajianpegT'];
    $judulLaporan = 'Laporan Selisih Gaji';

    $periode = $_GET['GJPenggajianpegT']['bln_awal'] . " s/d " . $_REQUEST['GJPenggajianpegT']['bln_akhir'];
    $model->bln_awal = MyFormatter::formatMonthForDb($_REQUEST['GJPenggajianpegT']['bln_awal']);
    $model->bln_akhir = MyFormatter::formatMonthForDb($_REQUEST['GJPenggajianpegT']['bln_akhir']);



    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view_lap . 'selisihGaji/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view_lap . 'selisihGaji/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view_lap . 'selisihGaji/Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode), true));
      $mpdf->Output();
    }
  }
}
