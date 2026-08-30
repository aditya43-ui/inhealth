<?php
Yii::import("penggajian.models.*");
Yii::import("billingKasir.models.*");
Yii::import("penggajian.controllers.LaporanController");
class LaporanKUController extends LaporanController
{
  public $path_view_ku = 'keuangan.views.laporanKu.';
  public $init = 'KU';

  public function actionTargetBEP()
  {
    $this->pageTitle = Yii::app()->name . " - Target Bep";
    $model = new KULaporanpakaialatmedisV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['KULaporanpakaialatmedisV'])) {
      $model->attributes = $_GET['KULaporanpakaialatmedisV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanpakaialatmedisV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanpakaialatmedisV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . 'targetBep.admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintTargetBEP()
  {
    $model = new KULaporanpakaialatmedisV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN TARGET BEP';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN TARGET BEP';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KULaporanpakaialatmedisV'])) {
      $model->attributes = $_GET['KULaporanpakaialatmedisV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanpakaialatmedisV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanpakaialatmedisV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view_ku . 'targetBep/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikTargetBEP()
  {
    $this->layout = '//layouts/iframe';
    $model = new KULaporanpakaialatmedisV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN TARGET BEP';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN TARGET BEP';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KULaporanpakaialatmedisV'])) {
      $model->attributes = $_GET['KULaporanpakaialatmedisV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanpakaialatmedisV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanpakaialatmedisV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPengajuanAnggaranOperasional()
  {
    $this->pageTitle = Yii::app()->name . " - Realilsasi Anggaran Operasional";
    $model = new KUInfopengajuanpettyV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['KUInfopengajuanpettyV'])) {
      $model->attributes = $_GET['KUInfopengajuanpettyV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_akhir']);
      $model->unitkerja_id = isset($_GET['KUInfopengajuanpettyV']['unitkerja_id']) ? $_GET['KUInfopengajuanpettyV']['unitkerja_id'] : null;
    }

    $this->render($this->path_view_ku . 'pengajuanAnggaranOperasional.admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintPengajuanAnggaranOperasional()
  {
    $model = new KUInfopengajuanpettyV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN PENGAJUAN ANGGARAN OPERASIONAL';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN PENGAJUAN ANGGARAN OPERASIONAL';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KUInfopengajuanpettyV'])) {
      $model->attributes = $_GET['KUInfopengajuanpettyV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_akhir']);
      $model->unitkerja_id = isset($_GET['KUInfopengajuanpettyV']['unitkerja_id']) ? $_GET['KUInfopengajuanpettyV']['unitkerja_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view_ku . 'pengajuanAnggaranOperasional/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPengajuanAnggaranOperasional()
  {
    $this->layout = '//layouts/iframe';
    $model = new KUInfopengajuanpettyV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN PENGAJUAN ANGGARAN OPERASIONAL';
    //Data Grafik
    $data['title'] = 'GRAFIK PENGAJUAN ANGGARAN OPERASIONAL';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KUInfopengajuanpettyV'])) {
      $model->attributes = $_GET['KUInfopengajuanpettyV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInfopengajuanpettyV']['tgl_akhir']);
      $model->unitkerja_id = isset($_GET['KUInfopengajuanpettyV']['unitkerja_id']) ? $_GET['KUInfopengajuanpettyV']['unitkerja_id'] : null;
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }


  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs')
  {
    $format = new MyFormatter();

    if (!empty($model->tgl_awal)) {
      $periode = $periode = $format->formatDateTimeId($model->tgl_awal) . ' s/d ' . $format->formatDateTimeId($model->tgl_akhir);
    } else {
      $periode = '';
    }

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
      $footer = '<table width="100%"><tr>'
        . '<td style = "text-align:left;font-size:8px;"><i><b>Generated By Ehealthsys</b></i></td>'
        . '<td style = "text-align:right;font-size:8px;"><i><b>Print Count :</b></i></td>'
        . '</tr></table>';
      //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
      //$mpdf->SetHTMLFooter('{PAGENO}');
      ////$mpdf->useOddEven = 1;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
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
   * @category		controllers
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
   * - laporan pendapatan ruangan
   */
  public function actionPendapatanRuangan()
  {
    $this->pageTitle = Yii::app()->name . " - Pendapatan Ruangan";
    $model = new KURinciantagihanpasiensudahbayarV('search');
    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-t');

    if (isset($_GET['KURinciantagihanpasiensudahbayarV'])) {
      $model->attributes = $_GET['KURinciantagihanpasiensudahbayarV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KURinciantagihanpasiensudahbayarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KURinciantagihanpasiensudahbayarV']['tgl_akhir']);
      //$model->carabayar_id = isset($_GET['KURinciantagihanpasiensudahbayarV']['carabayar_id'])?$_GET['KURinciantagihanpasiensudahbayarV']['carabayar_id']:null;
      //$model->penjamin_id = isset($_GET['KURinciantagihanpasiensudahbayarV']['penjamin_id'])?$_GET['KURinciantagihanpasiensudahbayarV']['penjamin_id']:null;
    }

    $this->render($this->path_view_ku . 'pendapatanRuangan/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintPendapatanRuangan()
  {
    $model = new KURinciantagihanpasiensudahbayarV('search');
    $judulLaporan = 'LAPORAN GRAFIK PENDAPATAN RUANGAN';

    //Data Grafik        
    $data['title'] = 'GRAFIK LAPORAN PENDAPATAN RUANGAN';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['KURinciantagihanpasiensudahbayarV'])) {
      $model->attributes = $_REQUEST['KURinciantagihanpasiensudahbayarV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['KURinciantagihanpasiensudahbayarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KURinciantagihanpasiensudahbayarV']['tgl_akhir']);
      //$model->carabayar_id = isset($_GET['KURinciantagihanpasiensudahbayarV']['carabayar_id'])?$_GET['KURinciantagihanpasiensudahbayarV']['carabayar_id']:null;
      //$model->penjamin_id = isset($_GET['KURinciantagihanpasiensudahbayarV']['penjamin_id'])?$_GET['KURinciantagihanpasiensudahbayarV']['penjamin_id']:null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_ku . 'pendapatanRuangan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new KURinciantagihanpasiensudahbayarV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN PENDAPATAN RUANGAN';
    $data['type'] = $_GET['type'];
    if (isset($_GET['KURinciantagihanpasiensudahbayarV'])) {
      $model->attributes = $_GET['KURinciantagihanpasiensudahbayarV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KURinciantagihanpasiensudahbayarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KURinciantagihanpasiensudahbayarV']['tgl_akhir']);
      //$model->carabayar_id = isset($_GET['KURinciantagihanpasiensudahbayarV']['carabayar_id'])?$_GET['KURinciantagihanpasiensudahbayarV']['carabayar_id']:null;
      //$model->penjamin_id = isset($_GET['KURinciantagihanpasiensudahbayarV']['penjamin_id'])?$_GET['KURinciantagihanpasiensudahbayarV']['penjamin_id']:null;
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /**
   * - laporan pendapatan ruangan akhir
   */


  /**
   * @category		controllers
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
   * - laporan jasa instalasi
   */
  public function actionJasaInstalasi()
  {
    $this->pageTitle = Yii::app()->name . " - Jasa Instalasi";
    $model = new KULaporanjasainstalasiV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KULaporanjasainstalasiV'])) {
      $model->attributes = $_GET['KULaporanjasainstalasiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanjasainstalasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanjasainstalasiV']['tgl_akhir']);
      $model->pegawai_id = isset($_GET['KULaporanjasainstalasiV']['pegawai_id']) ? $_GET['KULaporanjasainstalasiV']['pegawai_id'] : null;
      $model->carabayar_id = isset($_GET['KULaporanjasainstalasiV']['carabayar_id']) ? $_GET['KULaporanjasainstalasiV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['KULaporanjasainstalasiV']['penjamin_id']) ? $_GET['KULaporanjasainstalasiV']['penjamin_id'] : null;
      $model->tindakansudahbayar_id = isset($_GET['KULaporanjasainstalasiV']['tindakansudahbayar_id']) ? $_GET['KULaporanjasainstalasiV']['tindakansudahbayar_id'] : null;
    }

    $this->render($this->path_view_ku . 'jasaInstalasi/index', array(
      'model' => $model
    ));
  }

  public function actionPrintJasaInstalasi()
  {
    $model = new KULaporanjasainstalasiV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    $judulLaporan = 'LAPORAN JASA INSTALASI';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN JASA INSTLASI';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['KULaporanjasainstalasiV'])) {
      $model->attributes = $_REQUEST['KULaporanjasainstalasiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanjasainstalasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanjasainstalasiV']['tgl_akhir']);
      $model->pegawai_id = isset($_GET['KULaporanjasainstalasiV']['pegawai_id']) ? $_GET['KULaporanjasainstalasiV']['pegawai_id'] : null;
      $model->carabayar_id = isset($_GET['KULaporanjasainstalasiV']['carabayar_id']) ? $_GET['KULaporanjasainstalasiV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['KULaporanjasainstalasiV']['penjamin_id']) ? $_GET['KULaporanjasainstalasiV']['penjamin_id'] : null;
      $model->tindakansudahbayar_id = isset($_GET['KULaporanjasainstalasiV']['tindakansudahbayar_id']) ? $_GET['KULaporanjasainstalasiV']['tindakansudahbayar_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_ku . 'jasaInstalasi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new KULaporanjasainstalasiV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN JASA INSTALASI';
    $data['type'] = $_GET['type'];
    if (isset($_GET['KULaporanjasainstalasiV'])) {
      $model->attributes = $_GET['KULaporanjasainstalasiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanjasainstalasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanjasainstalasiV']['tgl_akhir']);
      $model->pegawai_id = isset($_GET['KULaporanjasainstalasiV']['pegawai_id']) ? $_GET['KULaporanjasainstalasiV']['pegawai_id'] : null;
      $model->carabayar_id = isset($_GET['KULaporanjasainstalasiV']['carabayar_id']) ? $_GET['KULaporanjasainstalasiV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['KULaporanjasainstalasiV']['penjamin_id']) ? $_GET['KULaporanjasainstalasiV']['penjamin_id'] : null;
      $model->tindakansudahbayar_id = isset($_GET['KULaporanjasainstalasiV']['tindakansudahbayar_id']) ? $_GET['KULaporanjasainstalasiV']['tindakansudahbayar_id'] : null;
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * - laporan jasa intakasi akhir
   */


  /**
   * - awalan laporan closing kasir
   */

  public function actionClosingKasir()
  {
    $this->pageTitle = Yii::app()->name . " - Closing Kasir";
    $model = new KULaporanclosingkasirV('searchInformasi');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');


    if (isset($_GET['KULaporanclosingkasirV'])) {
      $model->attributes = $_GET['KULaporanclosingkasirV'];
      $model->jns_periode = $_GET['KULaporanclosingkasirV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanclosingkasirV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanclosingkasirV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanclosingkasirV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";

      //$model->ruanganKasir = $_GET['BKLaporanclosingkasirV']['create_ruangan'];
    }
    // $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd'),'medium',null);
    // $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd'),'medium',null);

    $this->render($this->path_view_ku . 'closingKasir/index', array('model' => $model));
  }

  public function actionPrintClosingKasir()
  {
    $model = new KULaporanclosingkasirV('searchPrint');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'LAPORAN CLOSING KASIR';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN CLOSING KASIR';
    $data['type'] = $_REQUEST['type'];
    $pegCreated = LoginpemakaiK::model()->findByPK(Yii::app()->user->getState('loginpemakai_id'));
    $data['nama_pegawai'] = (!empty($pegCreated->pegawai_id)) ? $pegCreated->pegawai->nama_pegawai : Yii::app()->user->getState('nama_pemakai');
    if (isset($_REQUEST['KULaporanclosingkasirV'])) {
      $model->attributes = $_REQUEST['KULaporanclosingkasirV'];
      $model->jns_periode = $_GET['KULaporanclosingkasirV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanclosingkasirV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanclosingkasirV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanclosingkasirV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      if (!empty($model->pegawai_id)) {
        $judulLaporan .= '<br>';
        $judulLaporan .= PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap;
      }
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_ku . 'closingKasir/print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikClosingKasir()
  {
    $this->layout = '//layouts/iframe';
    $model = new KULaporanclosingkasirV('searchGrafik');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN CLOSING KASIR';
    $data['type'] = $_GET['type'];
    if (isset($_GET['KULaporanclosingkasirV'])) {
      $model->attributes = $_GET['KULaporanclosingkasirV'];
      $model->jns_periode = $_GET['KULaporanclosingkasirV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanclosingkasirV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanclosingkasirV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanclosingkasirV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanclosingkasirV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      if (!empty($model->pegawai_id)) {
        $data['title'] .= '<br>';
        $data['title'] .= PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap;
      }
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * - akhiran laporan closing kasir
   */


  /*
* ======================== PEMBEBASAN TARIF ===============================
*/

  public function actionPembebasanTarif()
  {
    $this->pageTitle = Yii::app()->name . " - Pembebasan Tarif";
    $model = new KULaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    $filter = null;
    if (isset($_GET['KULaporanpembebasantarifV'])) {
      $model->attributes = $_GET['KULaporanpembebasantarifV'];
      $model->jns_periode = $_REQUEST['KULaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['KULaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['KULaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->instalasi_id = isset($_GET['KULaporanpembebasantarifV']['instalasi_id']) ? $_GET['KULaporanpembebasantarifV']['instalasi_id'] : null;
    }

    $this->render($this->path_view_ku . 'pembebasanTarif/index', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintPembebasanTarif()
  {
    $model = new KULaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    $judulLaporan = 'LAPORAN PEMBEBASAN TARIF';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN PEMBEBASAN TARIF';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['KULaporanpembebasantarifV'])) {
      $model->attributes = $_REQUEST['KULaporanpembebasantarifV'];

      $model->jns_periode = $_REQUEST['KULaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['KULaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['KULaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->instalasi_id = isset($_GET['KULaporanpembebasantarifV']['instalasi_id']) ? $_GET['KULaporanpembebasantarifV']['instalasi_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_ku . 'pembebasanTarif/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikPembebasanTarif()
  {
    $this->layout = '//layouts/iframe';
    $model = new KULaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN PEMBEBASAN TARIF';
    $data['type'] = $_GET['type'];
    if (isset($_GET['KULaporanpembebasantarifV'])) {
      $model->attributes = $_GET['KULaporanpembebasantarifV'];

      $model->jns_periode = $_REQUEST['KULaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['KULaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['KULaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->instalasi_id = isset($_GET['KULaporanpembebasantarifV']['instalasi_id']) ? $_GET['KULaporanpembebasantarifV']['instalasi_id'] : null;
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * @author	M Iqbal Laksana
   * - awal laporan frekeunse layanan
   */
  public function actionFrekuensiLayanan()
  {
    $this->pageTitle = Yii::app()->name . " - Frekuensi Layanan";
    $model = new KULapfrekuensilayananV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['KULapfrekuensilayananV'])) {
      $model->attributes = $_GET['KULapfrekuensilayananV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULapfrekuensilayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULapfrekuensilayananV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . 'frekuensiLayanan.admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintFrekuensiLayanan()
  {

    $model = new KULapfrekuensilayananV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN FREKUENSI LAYANAN';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN FREKUENSI LAYANAN';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KULapfrekuensilayananV'])) {
      $model->attributes = $_GET['KULapfrekuensilayananV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULapfrekuensilayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULapfrekuensilayananV']['tgl_akhir']);
    }


    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view_ku . 'frekuensiLayanan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikFrekuensiLayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new KULapfrekuensilayananV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN FREKUENSI LAYANAN';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN FREKUENSI LAYANAN';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KULapfrekuensilayananV'])) {
      $model->attributes = $_GET['KULapfrekuensilayananV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULapfrekuensilayananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULapfrekuensilayananV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }


  /**
   * laporan rekap piutang
   */
  /*
* end BillingKasir->LaporanRekapPendapatan
*/

  public function actionLaporanRekapPiutang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Piutang";
    $model = new BKLaporanrekappendapatanV('searchPiutang');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_GET['BKLaporanrekappendapatanV'];
      $model->jns_periode = $_REQUEST['BKLaporanrekappendapatanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanrekappendapatanV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanrekappendapatanV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanrekappendapatanV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $this->render($this->path_view_ku . 'piutangPenjamin/index', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanRekapPiutang()
  {
    $model = new BKLaporanrekappendapatanV('searchPrintPiutang');
    if ($_GET['filter_tab'] == "penjamin") {
      $penjamin = "Penjamin";
    } else {
      $penjamin = strtoupper($_GET['filter_tab']);
    }
    $judulLaporan = 'LAPORAN REKAP PIUTANG ' . $penjamin . '';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN REKAP PIUTANG PENJAMIN ';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_REQUEST['BKLaporanrekappendapatanV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_ku . 'piutangPenjamin/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanRekapPiutang()
  {
    $this->layout = '//layouts/iframe';
    $model = new BKLaporanrekappendapatanV('searchPiutang');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = strtoupper('Grafik Laporan Rekap Piutang Penjamin');
    $data['type'] = $_GET['type'];
    if (isset($_GET['BKLaporanrekappendapatanV'])) {
      $model->attributes = $_GET['BKLaporanrekappendapatanV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekappendapatanV']['tgl_akhir']);
      $model->ruangan_id = isset($_GET['BKLaporanrekappendapatanV']['ruangan_id']) ? $_GET['BKLaporanrekappendapatanV']['ruangan_id'] : null;
      $model->instalasi_id = isset($_GET['BKLaporanrekappendapatanV']['instalasi_id']) ? $_GET['BKLaporanrekappendapatanV']['instalasi_id'] : null;
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * laporan pembayaran supplier awal
   */

  public function actionPembayaranSupplier()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Supplier";
    $model = new KULaporanbayarankesupplierV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['KULaporanbayarankesupplierV'])) {
      $model->attributes = $_GET['KULaporanbayarankesupplierV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanbayarankesupplierV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanbayarankesupplierV']['tgl_akhir']);
      $model->supplier_jenis = isset($_GET['KULaporanbayarankesupplierV']['supplier_jenis']) ? $_GET['KULaporanbayarankesupplierV']['supplier_jenis'] : null;
    }

    $this->render($this->path_view_ku . 'pembayaranSupplier.admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintPembayaranSupplier()
  {

    $model = new KULaporanbayarankesupplierV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN PEMBAYARAN SUPPLIER';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN PEMBAYARAN SUPPLIER';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KULaporanbayarankesupplierV'])) {
      $model->attributes = $_GET['KULaporanbayarankesupplierV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanbayarankesupplierV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanbayarankesupplierV']['tgl_akhir']);
      $model->supplier_jenis = isset($_GET['KULaporanbayarankesupplierV']['supplier_jenis']) ? $_GET['KULaporanbayarankesupplierV']['supplier_jenis'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view_ku . 'pembayaranSupplier/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPembayaranSupplier()
  {
    $this->layout = '//layouts/iframe';
    $model = new KULaporanbayarankesupplierV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN PEMBAYARAN SUPPLIER';
    //Data Grafik
    $data['title'] = 'GARAFIK LAPORAN PEMBAYARAN SUPPLIER';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['KULaporanbayarankesupplierV'])) {
      $model->attributes = $_GET['KULaporanbayarankesupplierV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanbayarankesupplierV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanbayarankesupplierV']['tgl_akhir']);
      $model->supplier_jenis = isset($_GET['KULaporanbayarankesupplierV']['supplier_jenis']) ? $_GET['KULaporanbayarankesupplierV']['supplier_jenis'] : null;
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }


  /**
   * laporan pembayaran supplier akhir
   */


  /**
   * laporan stok awal
   */

  public function actionStock()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Farmasi";
    $model = new KUInfostokobatalkesruanganV;
    $model->unsetAttributes();
    //$model->qtystok_in = '0';
    // $model->qtystok_out = '0';
    if (isset($_GET['KUInfostokobatalkesruanganV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['KUInfostokobatalkesruanganV'];
      $model->qtystok_in = isset($_GET['KUInfostokobatalkesruanganV']['qtystok_in']) ? $_GET['KUInfostokobatalkesruanganV']['qtystok_in'] : '';
      $model->qtystok_out = isset($_GET['KUInfostokobatalkesruanganV']['qtystok_out']) ? $_GET['KUInfostokobatalkesruanganV']['qtystok_out'] : '';
      //$model->stok = isset($_GET['GFInfostokobatalkesruanganV']['stok'])?$_GET['GFInfostokobatalkesruanganV']['stok']:'';
    }
    $this->render($this->path_view_ku . 'stock/stock', array(
      'model' => $model,
    ));
  }

  public function actionPrintStock()
  {
    $model = new KUInfostokobatalkesruanganV;
    // $model->tgl_awal = date('Y-m-d 00:00:00');
    // $model->tgl_akhir = date('Y-m-d 23:59:59');
    $model->qtystok_in = '0';
    $model->qtystok_out = '0';
    $judulLaporan = 'STOK OBAT & ALKES';

    //Data Grafik
    $data['title'] = 'GRAFIK STOK OBAT & ALKES';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type']  : null);
    if (isset($_REQUEST['KUInfostokobatalkesruanganV'])) {
      $model->attributes = $_GET['KUInfostokobatalkesruanganV'];
      $model->qtystok_in = isset($_GET['KUInfostokobatalkesruanganV']['qtystok_in']) ? $_GET['KUInfostokobatalkesruanganV']['qtystok_in'] : '';
      $model->qtystok_out = isset($_GET['KUInfostokobatalkesruanganV']['qtystok_out']) ? $_GET['KUInfostokobatalkesruanganV']['qtystok_out'] : '';
    }
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    $target = $this->path_view_ku . 'stock/printStock';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameStock()
  {
    $this->layout = '//layouts/iframe';

    $model = new KUInfostokobatalkesruanganV;
    //  $model->tgl_awal = date('Y-m-d 00:00:00');
    // $model->tgl_akhir = date('Y-m-d 23:59:59');
    $model->qtystok_in = '0';
    $model->qtystok_out = '0';
    //Data Grafik
    $data['title'] = 'GRAFIK STOK OBAT & ALKES';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;

    if (isset($_REQUEST['KUInfostokobatalkesruanganV'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['KUInfostokobatalkesruanganV'];
      $model->qtystok_in = isset($_GET['KUInfostokobatalkesruanganV']['qtystok_in']) ? $_GET['KUInfostokobatalkesruanganV']['qtystok_in'] : '';
      $model->qtystok_out = isset($_GET['KUInfostokobatalkesruanganV']['qtystok_out']) ? $_GET['KUInfostokobatalkesruanganV']['qtystok_out'] : '';
    }
    $searchdata = $model->searchGrafik();
    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchdata,
    ));
  }

  /**
   * laporan stok akhir
   */
}
