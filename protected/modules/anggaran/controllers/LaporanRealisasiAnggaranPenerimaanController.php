<?php

class LaporanRealisasiAnggaranPenerimaanController extends MyAuthController{
	
	public $path_view = 'anggaran.views.laporanRealisasiAnggaranPenerimaan.';
	
	public function actionIndex(){
		$model = new AGLaporanrealisasianggaranpenerimaanV('searchLaporan');
        $format = new MyFormatter();
        $model->unsetAttributes();
        
        $model->bln_awal = date('Y-m', strtotime('first day of this month'));
        $model->bln_akhir = date('Y-m');
        
        if (isset($_GET['AGLaporanrealisasianggaranpenerimaanV'])) {
            $model->attributes = $_GET['AGLaporanrealisasianggaranpenerimaanV'];
            
            $model->bln_awal = $format->formatMonthForDb($_GET['AGLaporanrealisasianggaranpenerimaanV']['bln_awal']);
            
            $bln_akhir = $model->bln_awal."-".date("t",strtotime($model->bln_awal));
			$model->tgl_awal = $model->bln_awal."-01"; 
			$model->tgl_akhir = $bln_akhir;
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $this->render($this->path_view.'admin',array(
            'model'=>$model,'format'=>$format
        ));
	}
	
	public function actionPrint()
    {

        $model = new AGLaporanrealisasianggaranpenerimaanV('searchLaporan');
        $format = new MyFormatter();
        $model->unsetAttributes();
		$model->bln_awal = date('Y-m', strtotime('first day of this month'));
        $model->bln_akhir = date('Y-m');
        $judulLaporan = 'Laporan Realisasi Anggaran Penerimaan';

        //Data Grafik
        $data['title'] = 'Grafik Realisasi Anggaran Penerimaan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['AGLaporanrealisasianggaranpenerimaanV'])) {
            $model->attributes = $_REQUEST['AGLaporanrealisasianggaranpenerimaanV'];
            
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['AGLaporanrealisasianggaranpenerimaanV']['bln_awal']);
            
            $bln_akhir = $model->bln_awal."-".date("t",strtotime($model->bln_awal));
			$model->tgl_awal = $model->bln_awal."-01"; 
			$model->tgl_akhir = $bln_akhir;
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = $this->path_view.'print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }   
	
	protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
             $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            ////$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
}