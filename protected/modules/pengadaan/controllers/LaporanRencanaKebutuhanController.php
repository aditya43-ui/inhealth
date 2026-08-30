<?php
class LaporanRencanaKebutuhanController extends MyAuthController{
	public $path_view = 'pengadaan.views.laporanRencanaKebutuhan.';
	
	
    
    public function actionLaporanRencanaKebutuhanBarang() {
       $model = new ADRenkebbarangT;
       $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        if (isset($_GET['ADRenkebbarangT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['ADRenkebbarangT'];
            $model->jns_periode = $_GET['ADRenkebbarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ADRenkebbarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADRenkebbarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['ADRenkebbarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['ADRenkebbarangT']['bln_akhir']);
            $model->thn_awal = $_GET['ADRenkebbarangT']['thn_awal'];
            $model->thn_akhir = $_GET['ADRenkebbarangT']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        
        $this->render($this->path_view.'rencanaKebutuhanBarang',array(
            'model'=>$model,'format'=>$format
        ));
    }
    
    public function actionPrintRencanaKebutuhanBarang()
    {
        $model = new ADRenkebbarangT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Rencana Kebutuhan Barang';

        //Data Grafik
        $data['title'] = 'Grafik Rencana Kebutuhan Barang';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type']  : null);
        if (isset($_REQUEST['ADRenkebbarangT'])) {
            $model->attributes = $_REQUEST['ADRenkebbarangT'];
            $model->jns_periode = $_REQUEST['ADRenkebbarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ADRenkebbarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ADRenkebbarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['ADRenkebbarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ADRenkebbarangT']['bln_akhir']);
            $model->thn_awal = $_GET['ADRenkebbarangT']['thn_awal'];
            $model->thn_akhir = $_GET['ADRenkebbarangT']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = $this->path_view.'printRencanaBarang';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }   
    
    public function actionFrameRencanaKebutuhanBarang() {
        $this->layout = '//layouts/iframe';

        $model = new ADRenkebbarangT;
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
        $data['title'] = 'Grafik Rencana Kebutuhan Barang';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['ADRenkebbarangT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['ADRenkebbarangT'];
            $model->jns_periode = $_REQUEST['ADRenkebbarangT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ADRenkebbarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ADRenkebbarangT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['ADRenkebbarangT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ADRenkebbarangT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $searchdata = $model->searchGrafik();
        $this->render($this->path_view.'_grafik', array(
            'format'=>$format,
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }
    

    public function actionLaporanRencanaKebutuhan() {
       $model = new ADRencanaKebFarmasiT;
       $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        if (isset($_GET['ADRencanaKebFarmasiT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['ADRencanaKebFarmasiT'];
            $model->jns_periode = $_GET['ADRencanaKebFarmasiT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ADRencanaKebFarmasiT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADRencanaKebFarmasiT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['ADRencanaKebFarmasiT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['ADRencanaKebFarmasiT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        
        $this->render($this->path_view.'rencanaKebutuhan',array(
            'model'=>$model,'format'=>$format
        ));
    }
    
    public function actionPrintRencanaKebutuhan()
    {
        $model = new ADRencanaKebFarmasiT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Rencana Kebutuhan';

        //Data Grafik
        $data['title'] = 'Grafik Rencana Kebutuhan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type']  : null);
        if (isset($_REQUEST['ADRencanaKebFarmasiT'])) {
            $model->attributes = $_REQUEST['ADRencanaKebFarmasiT'];
            $model->jns_periode = $_REQUEST['ADRencanaKebFarmasiT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ADRencanaKebFarmasiT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ADRencanaKebFarmasiT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['ADRencanaKebFarmasiT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ADRencanaKebFarmasiT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = $this->path_view.'printRencana';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }   

   
    
    
    public function actionFrameRencanaKebutuhan() {
        $this->layout = '//layouts/iframe';

        $model = new ADRencanaKebFarmasiT;
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
        $data['title'] = 'Grafik Rencana Kebutuhan';
        $data['type'] = $_GET['type'];

        if (isset($_REQUEST['ADRencanaKebFarmasiT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['ADRencanaKebFarmasiT'];
            $model->jns_periode = $_REQUEST['ADRencanaKebFarmasiT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ADRencanaKebFarmasiT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ADRencanaKebFarmasiT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['ADRencanaKebFarmasiT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ADRencanaKebFarmasiT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $searchdata = $model->searchGrafik();
		
        $this->render($this->path_view.'_grafik', array(
            'format'=>$format,
            'model' => $model,
            'data' => $data,
            'searchdata'=>$searchdata,
        ));
    }

    // End Added //
	protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ((isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null) == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
	protected function parserTanggal($tgl){
        $tgl = date('Y-m-d h:i:s',strtotime($tgl));
        $tgl = explode(' ', $tgl);
        $result = array();
        foreach ($tgl as $row){
            if (!empty($row)){
                $result[] = $row;
            }
        }
        return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];

    }
}
