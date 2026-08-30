<?php

/**
 * Fungsi untuk laporan akuntansi
 *
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package    application.modules.akuntansi
 * @subpackage controllers
 * @category   controller
 */
class LaporanAkuntansiController extends MyAuthController
{
  /**
   * Laporan Jurnal
   */
  public function actionLaporanJurnal()
  {
    $this->pageTitle = Yii::app()->name . " - Jurnal";
    $model = new AKLaporanJurnalV;
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['AKLaporanJurnalV'])) {
      $model->attributes = $_GET['AKLaporanJurnalV'];
      $model->jns_periode = $_GET['AKLaporanJurnalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);
    }
    $this->render('jurnal/admin', array('model' => $model));
  }

  /**
   * Printout pada Laporan Jurnal
   */
  public function actionPrintLaporanJurnal()
  {
    $model = new AKLaporanJurnalV('searchPrint');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'LAPORAN JURNAL';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN JURNAL';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['AKLaporanJurnalV'])) {
      $model->attributes = $_REQUEST['AKLaporanJurnalV'];
      $model->jns_periode = $_GET['AKLaporanJurnalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);

      // var_dump($_GET, $model->tgl_awal, $model->tgl_akhir); die;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jurnal/_print';

    $this->printFunctionJurnal($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * Data grafik pada laporan Jurnal
   */
  public function actionFrameGrafikLaporanJurnal()
  {
    $this->layout = '//layouts/iframe';
    $model = new AKLaporanJurnalV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN JURNAL';
    $data['type'] = $_GET['type'];
    if (isset($_GET['AKLaporanJurnalV'])) {
      $model->attributes = $_GET['AKLaporanJurnalV'];
      $model->jns_periode = $_GET['AKLaporanJurnalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * Laporan Buku Besar
   */
  public function actionLaporanBukuBesar() {
    $format = new MyFormatter();
    $model = new AKLaporanbukubesarV;
    $model->tgl_awal = date('Y-m-d H:i:s');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->unsetAttributes();

    if(isset($_GET['AKLaporanbukubesarV']))
    {
        $model->attributes = $_GET['AKLaporanbukubesarV'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_akhir']);

        if(!empty($model->rekening5_id)){
            $modRek5 = Rekening5M::model()->findByPk($model->rekening5_id);
            $model->kodeRekening = (!empty($modRek5)? $modRek5->kdrekening5 .' - '.  $modRek5->nmrekening5 :"");
        }   
    }
        $this->render('bukuBesar/admin', array(
            'model' => $model
        ));
    }

    /**
     * Printout untuk Laporan Buku besar
     */
    public function actionPrintLaporanBukuBesar() {
        $format = new MyFormatter();
        $model = new AKLaporanbukubesarV('searchLaporan');
        $model->unsetAttributes();
        
        $periode = PeriodepostingM::model()->find(array(
          'condition'=>"tglperiodeposting_akhir::date <= '".date('Y-m-d')."'",
          'order'=>'tglperiodeposting_akhir desc',
        ));

        if (!empty($periode)) {
          $model->periodeposting_id = $periode->periodeposting_id;
          $model->tgl_awal = $periode->tglperiodeposting_awal;
          $model->tgl_akhir = $periode->tglperiodeposting_akhir;
        }

        if (isset($_REQUEST['AKLaporanbukubesarV'])) {
          $model->attributes = $_REQUEST['AKLaporanbukubesarV'];
          $format = new MyFormatter();
        
          $periode = PeriodepostingM::model()->findByPk($model->periodeposting_id);
          $model->tgl_awal = !empty($periode->tglperiodeposting_awal)?$periode->tglperiodeposting_awal:null; //$format->formatDateTimeForDb($_REQUEST['AKLaporanBukuBesarV']['tgl_awal']);
          $model->tgl_akhir = !empty($periode->tglperiodeposting_akhir)?$periode->tglperiodeposting_akhir:null; //$format->formatDateTimeForDb($_REQUEST['AKLaporanBukuBesarV']['tgl_akhir']);
          $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_awal']);
          $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_akhir']);
        }
        $judulLaporan = 'LAPORAN BUKU BESAR';
        if (!empty($model->unitkerja_id)) {
          $uk = UnitkerjaM::model()->findByPk($model->unitkerja_id);
          $judulLaporan .= " - ".$uk->namaunitkerja;
        }

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Buku Besar';
        $data['type'] = ""; //$_REQUEST['type'];
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'bukuBesar/_print';
        
        $this->printFunctionV2($model, $data, $caraPrint, $judulLaporan, $target);
    }

  /**
   * Grafik pada laporan buku besar
   */
  public function actionFrameGrafikLaporanBukuBesar()
  {
    $this->layout = '//layouts/iframe';
    $model = new AKLaporanbukubesarV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Besar Berdasarkan Nama Rekening';
    $data['type'] = $_GET['type'];
    if (isset($_GET['AKLaporanbukubesarV'])) {
      $model->attributes = $_GET['AKLaporanbukubesarV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * Fungsi printout
   *
   * @param mixed $model
   * @param mixed $data
   * @param string $caraPrint
   * @param string $judulLaporan
   * @param string $target
   */
  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();

    if (!empty($model->tgl_awal)) {
      $periode = (!empty($this->parserTanggal($model->tgl_awal)) ? $this->parserTanggal($model->tgl_awal) : null) . ' s/d ' . (!empty($this->parserTanggal($model->tgl_akhir)) ? $this->parserTanggal($model->tgl_akhir) : null);
    } else {
      $periode = '';
    }

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      // $mpdf->SetHTMLFooter('{PAGENO}');
      $footer = '
            <table width="100%">
            <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
             <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
            </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * Fungsi printout dengan perbedaan pada printout via PDF
   *
   * @param mixed $model
   * @param mixed $data
   * @param string $caraPrint
   * @param string $judulLaporan
   * @param string $target
   */
  protected function printFunctionV2($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();

    if (!empty($model->tgl_awal)) {
      $periode = (!empty($this->parserTanggal($model->tgl_awal)) ? $this->parserTanggal(date("Y-m-d", strtotime($model->tgl_awal))) : null) . ' s/d ' . (!empty($this->parserTanggal($model->tgl_akhir)) ? $this->parserTanggal(date("Y-m-d", strtotime($model->tgl_akhir))) : null);
    } else {
      $periode = '';
    }

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $period = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tgl_awal))) . ' - ' . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tgl_akhir)));
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array(), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * Fungsi printout untuk jurnal
   *
   * @param mixed $model
   * @param mixed $data
   * @param string $caraPrint
   * @param string $judulLaporan
   * @param string $target
   */
  protected function printFunctionJurnal($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();

    if (!empty($model->tgl_awal)) {
      $periode = (!empty($this->parserTanggal($model->tgl_awal)) ? $this->parserTanggal($model->tgl_awal) : null) . ' s/d ' . (!empty($this->parserTanggal($model->tgl_akhir)) ? $this->parserTanggal($model->tgl_akhir) : null);
    } else {
      $periode = '';
    }

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $period = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tgl_awal))) . ' - ' . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tgl_akhir)));
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array(), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * Parsing tanggals
   *
   * @param string $tgl
   * @return string
   */
  protected function parserTanggal($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    $str = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null);
    if (!empty($result[1])) $str .= ' ' . $result[1];

    return $str;
  }

  /**
   * Laporan Arus Kas
   */
  public function actionLaporanArusKas()
  {
    $this->pageTitle = Yii::app()->name . " - Arus Kas";
    $format = new MyFormatter();
    $model = new AKLaporanaruskasV();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d H:i:s');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    //		$model->periodeposting_id = AKLaporanaruskasV::model()->getTglPeriode()->periodeposting_id;
    if (isset($_GET['AKLaporanaruskasV'])) {

      $format = new MyFormatter();
      $model->attributes = $_GET['AKLaporanaruskasV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanaruskasV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanaruskasV']['tgl_akhir']);
      //$model->ruangan_id = $_GET['AKLaporanaruskasV']['ruangan_id'];
      //            $model->periodeposting_id = $_GET['AKLaporanaruskasV']['periodeposting_id'];
    }
    $this->render('aruskas/admin', array(
      'model' => $model,
      'format' => $format,
    ));
  }

  /**
   * Printout pada Laporan Arus Kas
   */
  public function actionPrintLaporanArusKas()
  {
    $model = new AKLaporanaruskasV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $periode = '';
    //		$model->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
    $criteria = new CDbCriteria;
    if (isset($_GET['AKLaporanaruskasV'])) {
      $model->attributes = $_GET['AKLaporanaruskasV'];
      //$model->ruangan_id = $_GET['AKLaporanaruskasV']['ruangan_id'];
      $model->periodeposting_id = !empty($_GET['AKLaporanaruskasV']['periodeposting_id']) ? $_GET['AKLaporanaruskasV']['periodeposting_id'] : null;
    } else {
      if (!empty($model->periodeposting_id)) {
        $criteria->addCondition('periodeposting_id = ' . $model->periodeposting_id);
      }
      if (!empty($model->ruangan_id)) {
        $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
      }
    }

    if (!empty($model->periodeposting_id)) {
      $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);
      $periode = $periodeposting_id->periodeposting_nama;
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'LAPORAN ARUS KAS';

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('aruskas/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('aruskas/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $period = '';
      if (!empty($model->periodeposting_id)) {
        $period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
      }
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array(), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('aruskas/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * Laporan Neraca
   */
  public function actionLaporanNeraca()
  {
    $modelLaporan = new AKLaporanneracaV('searchNeraca');
    $modelLaporan->unsetAttributes();
    //		$modelLaporan->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
    $criteria = new CDbCriteria;
    if (isset($_GET['AKLaporanneracaV'])) {
      $modelLaporan->attributes = $_GET['AKLaporanneracaV'];
      $format = new MyFormatter();
      $modelLaporan->ruangan_id = $_GET['AKLaporanneracaV']['ruangan_id'];
      $modelLaporan->periodeposting_id = $_GET['AKLaporanneracaV']['periodeposting_id'];

      if (!empty($modelLaporan->periodeposting_id)) {
        $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
      }
      if (!empty($modelLaporan->ruangan_id)) {
        $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
      }
    } else {
      if (!empty($modelLaporan->periodeposting_id)) {
        $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
      }
      if (!empty($modelLaporan->ruangan_id)) {
        $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
      }
    }

    $model = AKLaporanneracaV::model()->findAll($criteria);


    $this->render('neraca/admin', array(
      'model' => $model,
      'modelLaporan' => $modelLaporan,
    ));
  }

  /**
   * Printout untuk Laporan Neraca
   */
  public function actionPrintLaporanNeraca()
  {
    $modelLaporan = new AKLaporanneracaV('searchNeraca');
    $modelLaporan->unsetAttributes();
    $periode = '';
    //		$modelLaporan->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
    $criteria = new CDbCriteria;
    if (isset($_GET['AKLaporanneracaV'])) {
      $modelLaporan->attributes = $_GET['AKLaporanneracaV'];
      $format = new MyFormatter();
      $modelLaporan->ruangan_id = $_GET['AKLaporanneracaV']['ruangan_id'];
      $modelLaporan->periodeposting_id = $_GET['AKLaporanneracaV']['periodeposting_id'];

      if (!empty($modelLaporan->periodeposting_id)) {
        $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
      }
      if (!empty($modelLaporan->ruangan_id)) {
        $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
      }
    } else {
      if (!empty($modelLaporan->periodeposting_id)) {
        $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
      }
      if (!empty($modelLaporan->ruangan_id)) {
        $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
      }
    }

    $model = AKLaporanneracaV::model()->findAll($criteria);

    if (!empty($modelLaporan->periodeposting_id)) {
      $periodeposting_id = AKPeriodepostingM::model()->findByPk($modelLaporan->periodeposting_id);
      $periode = 'Periode : ' . $periodeposting_id->periodeposting_nama;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'Laporan Posisi Keuangan / Neraca';

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('neraca/Print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('neraca/Print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = 'L';                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // $mpdf->SetHTMLFooter('{PAGENO}');
      $footer = '
            <table width="100%">
            <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
             <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
            </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
      $mpdf->tMargin = 5;
      $mpdf->WriteHTML($this->renderPartial('neraca/Print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * Laporan Laba Rugi
   */
  public function actionLaporanLabaRugi()
  {
    $model = new AKLaporanlabarugiV('searchLaporan');
    $format = new MyFormatter();
    $lap = AKLaporanlabarugiV::model()->getTglPeriode();
    if (!empty($lap)) $model->periodeposting_id = $lap->periodeposting_id;
    if (isset($_GET['AKLaporanlabarugiV'])) {
      $model->attributes = $_GET['AKLaporanlabarugiV'];
      $model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
    }
    $this->render('labarugi/admin', array('model' => $model));
  }

  /**
   * Printout untuk Laporan Laba Rugi
   */
  public function actionPrintLaporanLabaRugi()
  {
    $model = new AKLaporanlabarugiV('searchLaporanPrint');
    $model->unsetAttributes();
    $judulLaporan = 'Laporan Laba Rugi';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Laba Rugi';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
    if (isset($_REQUEST['AKLaporanlabarugiV'])) {
      $model->attributes = $_REQUEST['AKLaporanlabarugiV'];
      $format = new MyFormatter();
      $model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'labarugi/_print';

    $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

    $periode = $periodeposting_id->periodeposting_nama;

    $format = new MyFormatter();
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // $mpdf->SetHTMLFooter('{PAGENO}');
      $footer = '
            <table width="100%">
            <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
             <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
            </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      // //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * Laporan Perubahan Modal
   */
  public function actionLaporanPerubahanModal()
  {
    $this->pageTitle = Yii::app()->name . " - Perubahan Modal";
    $format = new MyFormatter();
    $model = new AKLaporanperubahanmodalV('search');
    $model->unsetAttributes();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //  $tgl_periode = AKLaporanperubahanmodalV::model()->getTglPeriode();
    //  $model->periodeposting_id = (isset($tgl_periode->periodeposting_id) ? $tgl_periode->periodeposting_id : NULL);

    if (isset($_GET['AKLaporanperubahanmodalV'])) {
      $model->attributes = $_GET['AKLaporanperubahanmodalV'];

      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanperubahanmodalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanperubahanmodalV']['tgl_akhir']);
    }

    $this->render('perubahanmodal/admin', array(
      'model' => $model,
      'format' => $format
    ));
  }

  /**
   * Printout Laporan Perubahan Modal
   */
  public function actionPrintLaporanPerubahanModal()
  {
    $format = new MyFormatter();
    $model = new AKLaporanperubahanmodalV('search');
    $model->unsetAttributes();

    $judulLaporan = 'LAPORAN PERUBAHAN MODAL';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Arus Kas';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : "";
    if (isset($_REQUEST['AKLaporanperubahanmodalV'])) {
      $model->attributes = $_REQUEST['AKLaporanperubahanmodalV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanperubahanmodalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanperubahanmodalV']['tgl_akhir']);
      //  $model->ruangan_id = $_GET['AKLaporanperubahanmodalV']['ruangan_id'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'perubahanmodal/_print';

    $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

    $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . " s/d " . MyFormatter::formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format' => $format));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format' => $format));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $period = '';
      if (!empty($model->periodeposting_id)) {
        $period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
      }
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array(), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);


      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format' => $format), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * Laporan Rasio
   */
  public function actionLaporanRasio()
  {
    $model = new AKSaldorekeningrasioV('search');
    $model->unsetAttributes();
    // $model->tglAwal = date('Y-m-d 00:00:00');
    // $model->tgl_akhir = date('Y-m-d H:i:s');

    $periode['tglAwal'] = date('Y-m-d 00:00:00');
    $periode['tglAkhir'] = date('Y-m-d H:i:s');

    if (isset($_GET['LaporanrasioV'])) {
      $model->attributes = $_GET['LaporanrasioV'];
      $format = new MyFormatter();
      // $model->tglAwal = $format->formatDateTimeMediumForDB($_GET['LaporanrasioV']['tglAwal']);
      // $model->tglAkhir = $format->formatDateTimeMediumForDB($_GET['LaporanrasioV']['tglAkhir']);
      // $model->ruangan_id = $_GET['LaporanrasioV']['ruangan_id'];
      // $periode['tglAwal']     = $model->tglAwal;
      // $periode['tglAkhir']    = $model->tglAkhir;
    }

    $this->render('rasio/admin', array('model' => $model, 'periode' => $periode));
  }

  /**
   * Printout pada Laporan Rasio
   */
  public function actionprintLaporanRasio()
  {
    $model = new AKSaldorekeningrasioV('search');
    $model->unsetAttributes();
    $judulLaporan = 'Laporan Rasio';
    // $model->tglAwal     = date('Y-m-d 00:00:00');
    // $model->tglAkhir    = date('Y-m-d H:i:s');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Rasio';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : '';
    if (isset($_REQUEST['LaporanrasioV'])) {
      $model->attributes = $_REQUEST['LaporanrasioV'];
      //            $format = new MyFormatter();
      // $model->tglAwal = $format->formatDateTimeMediumForDB($_REQUEST['LaporanrasioV']['tglAwal']);
      // $model->tglAkhir = $format->formatDateTimeMediumForDB($_REQUEST['LaporanrasioV']['tglAkhir']);
      // $model->ruangan_id = $_GET['LaporanrasioV']['ruangan_id'];
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rasio/_print';

    $format = new MyFormatter();
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // $mpdf->SetHTMLFooter('{PAGENO}');
      $footer = '
            <table width="100%">
            <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
             <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
            </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /*
     * Autocomplete Rekening Akuntansi
     */
  public function actionRekeningAkuntansi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      //                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
      $term = strtolower(trim($_GET['term']));

      $condition = "LOWER(nmrekeninglast) LIKE '%" . $term . "%' OR LOWER(nmrekening2) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
      if (isset($_GET['id_jenis_rek'])) {
        $condition = "(LOWER(nmrekeninglast) LIKE '%" . $term . "%' OR LOWER(nmrekening2) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekeninglast_nb = 'D' OR rekening1_nb = 'D' OR rekening2_nb = 'D')";
        if ($_GET['id_jenis_rek'] == 'Kredit') {
          $condition = "(LOWER(nmrekeninglast) LIKE '%" . $term . "%' OR LOWER(nmrekening2) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekeninglast_nb = 'K' OR rekening1_nb = 'K' OR rekening2_nb = 'K')";
        }
      }

      $criteria->addCondition($condition);
      $criteria->order = 'nmrekeninglast';
      $models = RekeningakuntansiV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if (isset($model->rincianobyek_id)) {
          $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekeninglast;
          $nama_rekening = $model->nmrekeninglast;
        } else {
          if (isset($model->obyek_id)) {
            $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
            $nama_rekening = $model->nmrekening4;
          } else {
            $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
            $nama_rekening = $model->nmrekening3;
          }
        }
        $returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
        $returnVal[$i]['value'] = $nama_rekening;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Autocomplete Rekening Akuntansi berdasarkan Kode Rekening
   */
  public function actionRekeningKodeAkuntansi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();

      $term = strtolower($_GET['term']);
      $condition = "LOWER(kdrekeninglast) LIKE '%" . $term . "%' OR LOWER(kdrekening4) LIKE '%" . $term . "%' OR LOWER(kdrekening3) LIKE '%" . $term . "%'";
      $criteria->addCondition($condition);
      $criteria->order = 'kdrekeninglast';
      $models = RekeningakuntansiV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          if (isset($model->rekeninglast_id)) {
            $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekeninglast;
            $nama_rekening = $model->kdrekeninglast;
          } else {
            if (isset($model->rekening4_id)) {
              $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
              $nama_rekening = $model->kdrekening4;
            } else {
              $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
              $nama_rekening = $model->kdrekening3;
            }
          }
          $returnVal[$i]['label'] = $kode_rekening;
          $returnVal[$i]['value'] = $nama_rekening;
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Laporan catatan atas laporan Keuangan
   */
  public function actionLaporanCALK()
  {
    $this->pageTitle = Yii::app()->name . " - Catatan Atas Laporan Keuangan";
    $model = new CalkT('search');
    $model->unsetAttributes();

    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['CalkT'])) {
      $model->attributes = $_GET['CalkT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['CalkT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['CalkT']['tgl_akhir']);
    }

    $this->render('calk/admin', array('model' => $model, 'format' => $format));
  }

  /**
   * Printout pada laporan Catatan atas laporan Peuangan.
   *
   * @param type $id
   * @param type $caraPrint
   */
  public function actionPrintLaporan()
  {
    $model = new CalkT('search');
    $model->unsetAttributes();
    $judulLaporan = 'Laporan Catatan Atas Laporan Keuangan';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Catatan Atas Laporan Keuangan';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : '';
    if (isset($_REQUEST['CalkT'])) {
      $model->attributes = $_REQUEST['CalkT'];
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'calk/_print';

    $periode = $model->calk_no;
    $format = new MyFormatter();
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionPrintLaporanCALK($id, $caraPrint = null)
  {
    $model = CalkT::model()->findByPk($id);

    $target = 'calk/_printCalk';
    $p = RekperiodM::model()->findByPk($id);

    $periode = $model->calk_no;

    $format = new MyFormatter();
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
