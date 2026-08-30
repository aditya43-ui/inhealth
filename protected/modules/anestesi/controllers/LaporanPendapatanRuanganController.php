<?php

class LaporanPendapatanRuanganController extends MyAuthController{
	
	public $path_view = 'anestesi.views.laporanPendapatanRuangan.';
	
	public function actionIndex(){
		$model = new ATLaporanpendapatanruanganV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);
        
        if (isset($_GET['ATLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['ATLaporanpendapatanruanganV'];
            $model->jns_periode = $_GET['ATLaporanpendapatanruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ATLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ATLaporanpendapatanruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['ATLaporanpendapatanruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['ATLaporanpendapatanruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['ATLaporanpendapatanruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['ATLaporanpendapatanruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
//            $model->tgl_awal = $model->tgl_awal." 00:00:00";
//            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
		
        $this->render($this->path_view.'admin',array(
            'model' => $model, 'filter'=>$filter,'format'=>$format
        ));
	}
	
	public function actionPrint()
    {

        $model = new ATLaporanpendapatanruanganV('search');
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Inap';
        $format = new MyFormatter();
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['ATLaporanpendapatanruanganV'])) {
            $model->attributes = $_REQUEST['ATLaporanpendapatanruanganV'];
            $model->jns_periode = $_REQUEST['ATLaporanpendapatanruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ATLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ATLaporanpendapatanruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['ATLaporanpendapatanruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ATLaporanpendapatanruanganV']['bln_akhir']);
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
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'_print';
        
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
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
	
	/**
	 * untuk checkbox penjamin
	 * @param type $encode
	 * @param type $namaModel
	 */
	public function actionGetPenjaminPasienForCheckBox($encode = false, $namaModel = '') {
		if (Yii::app()->request->isAjaxRequest) {
			$carabayar_id = $_POST["$namaModel"]['carabayar_id'];

			if ($encode) {
				echo CJSON::encode($penjamin);
			} else {
				if (empty($carabayar_id)) {
//                    $penjamin = PenjaminpasienM::model()->findAll();
					echo '<label>Data Tidak Ditemukan</label>';
				} else {
					$criteria = new CDbCriteria();
					$criteria->addCondition('carabayar_id = ' . $carabayar_id);
					$criteria->addCondition('penjamin_aktif is true');
					$criteria->order = 'penjamin_nama ASC';
					$penjamindata = PenjaminpasienM::model()->findAll($criteria);
					$penjamin = CHtml::listData($penjamindata, 'penjamin_id', 'penjamin_nama');
					echo CHtml::hiddenField('' . $namaModel . '[penjamin_id]');
					echo "<div style='margin-left:0px;'>" . CHtml::checkBox('checkAllPenjamin', false, array('onkeypress' => "return $(this).focusNextInputField(event)",
						'class' => 'checkbox-column', 'onclick' => 'checkAllPenjaminPasien()', 'checked' => 'checked')) . " Pilih Semua";
					echo "</div><br/>";
					$i = 0;
					if (count($penjamin) > 0) {
						foreach ($penjamin as $value => $name) {
							echo '<label class="checkbox">';
							echo CHtml::checkBox('' . $namaModel . '[penjamin_id][]', false, array('value' => $value));
							echo '<label for="' . $namaModel . '_penjamin_id_' . $i . '">' . $name . '</label></label>';

							$i++;
						}
					} else {
						echo '<label>Data Tidak Ditemukan</label>';
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	public function actionFrameGrafikLaporanPendapatanRuangan() {
        $this->layout = '//layouts/iframe';
        $model = new ATLaporanpendapatanruanganV('search');
        $model->tgl_awal = date('d M Y H:i:s');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan Rawat Inap';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['ATLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['ATLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ATLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ATLaporanpendapatanruanganV']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
}