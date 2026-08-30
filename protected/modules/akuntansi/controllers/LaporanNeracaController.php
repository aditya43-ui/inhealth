<?php
class LaporanNeracaController extends MyAuthController{
	
	public $path_view = 'akuntansi.views.laporanNeraca.';
	
	public function actionIndex() {
        $model = new AKLaporanneracaV('searchLaporan2');
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("'".date("Y-m-d")."'::date between tglperiodeposting_awal and tglperiodeposting_akhir");
		$periode = PeriodepostingM::model()->find($criteria);
		
		$model->tgl_awal = date('Y-m-01');
		$model->tgl_akhir = date('Y-m-t');
            
		if (isset($_GET['AKLaporanneracaV'])) {
            
			$model->attributes = $_GET['AKLaporanneracaV'];
			$format = new MyFormatter();
            $model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['AKLaporanneracaV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['AKLaporanneracaV']['tgl_akhir'])    ;
		}
        $models = array();
		echo $this->render($this->path_view.'admin', array(
			'model' => $model,
			'models' => $models,
				), true
		);
    }

    public function actionPrintLaporanLabaRugi() {
        $model = new AKLaporanneracaV('searchLaporan2');
		$model->unsetAttributes();
		
		$judulLaporan = 'LAPORAN NERACA';

		//Data Grafik       
		$data['title'] = 'Grafik Laporan Neraca';
		isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
		if (isset($_REQUEST['AKLaporanneracaV'])) {
			$model->attributes = $_REQUEST['AKLaporanneracaV'];
			$format = new MyFormatter();
			
			$model->periodeposting_id = $_GET['AKLaporanneracaV']['periodeposting_id'];
		}
		$models = $model->findAll($model->searchLaporan2());
		$caraPrint = $_REQUEST['caraPrint'];
		$target = $this->path_view.'_print';

		$format = new MyFormatter();
		if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
			////$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}
        
  public function actionPrintLaporanNeraca() {
        $model = new AKLaporanneracaV('searchLaporan2');
		$model->unsetAttributes();
		$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		$model->thn_awal = date('Y');
		$judulLaporan = 'LAPORAN NERACA';

		//Data Grafik       
		$data['title'] = 'Grafik Laporan Neraca';
		isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
		if (isset($_REQUEST['AKLaporanneracaV'])) {
			$model->attributes = $_REQUEST['AKLaporanneracaV'];
			$format = new MyFormatter();
			$model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['AKLaporanneracaV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['AKLaporanneracaV']['tgl_akhir'])    ;
			
		}
		$models = array(); 
		$caraPrint = $_REQUEST['caraPrint'];
		$segmen = isset($_REQUEST['Segmen']) ? $_REQUEST['Segmen'] : null;
		$target = $this->path_view.'_print';

		$periode = MyFormatter::formatDateTimeForUser($model->tgl_awal)." s/d ".MyFormatter::formatDateTimeForUser($model->tgl_akhir);

		$format = new MyFormatter();
		if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'models' => $models, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'models' => $models, 'periode' => $periode,'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$target = $this->path_view.'_print';
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			
			$mpdf = new MyPDF60('', $ukuranKertasPDF);

			
			$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
			$period = '';
			if (!empty($model->periodeposting_id)){
				$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
			}

			$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew',array(),true));
                        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
                        $mpdf->WriteHTML($formatkonten, 1);
                        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
                        $mpdf->WriteHTML($stylesheet, 1);
			 $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'models' => $models, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen), true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}
	
	public function PeriodeHeader($periode = null,$models = null){
		$dataArray = array();
		foreach ($models AS $row => $data) {
			$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
		}
        $jmlKolom = 0;
		foreach ($dataArray AS $row => $data) {
      if (!empty($models) || !empty($data)) {
          $tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data;
          $periode_array .= "<th ALIGN=CENTER>".MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data)))."</th>";
      } else {
          $periode_array .= "<td></td>";
      }
      $jmlKolom ++;
		}
		return $periode_array;
	}
}