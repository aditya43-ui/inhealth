<?php

class LaporanNeracaSaldoController extends Controller
{
    public $path_view = 'akuntansi.views.laporanNeracaSaldo.';
		public function actionIndex() {
      $format = new MyFormatter();
			$model = new AKLaporanbukubesarV;
			$model->tgl_awal = date('Y-m-d H:i:s');
			$model->tgl_akhir = date('Y-m-d H:i:s');
      $model->unsetAttributes();

		if(isset($_GET['AKLaporanbukubesarV']))
        {
            $model->attributes = $_GET['AKLaporanbukubesarV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['AKLaporanbukubesarV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['AKLaporanbukubesarV']['tgl_akhir']);
						$model->namaRekening = $_GET['AKLaporanbukubesarV']['namaRekening'];
						$model->rekening5_id = $_GET['AKLaporanbukubesarV']['rekening5_id'];
            $format = new MyFormatter();
        }
        
        
		echo $this->render($this->path_view.'index', array(
			'model' => $model,
				), true
		);
    }

	public function actionPrint()
	{
		$format = new MyFormatter();
		$model = new AKLaporanbukubesarV;
		$model->tgl_awal = date('Y-m-d H:i:s');
		$model->tgl_akhir = date('Y-m-d H:i:s');
        $model->unsetAttributes();
		
		
		
		
		if(isset($_GET['AKLaporanbukubesarV']))
        {
            $model->attributes = $_GET['AKLaporanbukubesarV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['AKLaporanbukubesarV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['AKLaporanbukubesarV']['tgl_akhir']);
            $format = new MyFormatter();
        }
		$caraPrint = $_REQUEST['caraPrint'];
		$segmen = isset($_REQUEST['Segmen']) ? $_REQUEST['Segmen'] : null;
		$target = $this->path_view.'print';

        
        $judulLaporan = "Laporan Neraca Saldo";

		$periode = MyFormatter::formatDateTimeForUser($model->tgl_awal)." s/d ".MyFormatter::formatDateTimeForUser($model->tgl_akhir);

		$format = new MyFormatter();
		if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$target = $this->path_view.'print';
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->SetHTMLFooter('{PAGENO}');
//			//$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
			$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
			$period = '';
			if (!empty($model->periodeposting_id)){
				$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
			}

			$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen), true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}
    
    public function actionCekSaldoAwalPeriode() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $periodeposting_id = $_POST['periode'];
        
        $saldoawal = SaldoawalT::model()->findByAttributes(array(
            'periodeposting_id'=>$periodeposting_id,
        ));
        
        $ok = 1;
        
        if (empty($saldoawal)) {
            $ok = 0;
        }
        
        echo CJSON::encode(array('ok'=>$ok));
    }

}