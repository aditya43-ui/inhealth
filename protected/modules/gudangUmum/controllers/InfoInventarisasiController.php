<?php
class InfoInventarisasiController extends MyAuthController{

	public $path_view = 'gudangUmum.views.infoInventarisasi.';

	public function actionIndex(){
		$format = new MyFormatter();
		$model = new GUInfoinventarisasibarangV('searchInformasi');

		$model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

		if(isset($_GET['GUInfoinventarisasibarangV'])){
			$model->attributes=$_GET['GUInfoinventarisasibarangV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_akhir']);
		}

		$this->render($this->path_view.'index',array(
			'model'=>$model,
			'format'=>$format
		));
	}

	/**
	* menampilkan url untuk print karena nama controller tiap modul yg extend berbeda
	* @return type
	*/
	public function getUrlPrint(){
		return $this->createUrl("InventarisasiBarang/Print");
	}

    public function actionPrint($caraPrint) {
        $format = new MyFormatter();
		$model = new GUInfoinventarisasibarangV('searchInformasi');

		$model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

		if(isset($_GET['GUInfoinventarisasibarangV'])){
			$model->attributes=$_GET['GUInfoinventarisasibarangV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInfoinventarisasibarangV']['tgl_akhir']);
		}

        $this->printFunction($model, $caraPrint, "Informasi Inventarisasi Barang", "print");

    }


    protected function printFunction($model, $caraPrint, $judulLaporan, $target)
    {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
//            //$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);

            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        } else if ($caraPrint == "CSV") {
            CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
        }
    }


		public function actionBatalInventarisasi() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['id'];
        $ok = 1;
        $msg = "";

        $trans = Yii::app()->db->beginTransaction();
        try {
            $inv = InvbarangdetT::model()->findAllByAttributes(array('invbarang_id'=>$id));

            foreach ($inv as $det) {
                $stok = InventarisasiruanganT::model()->findByPk($det->inventarisasi_id);

                // cek stok asal
                $stok_pake = InventarisasiruanganT::model()->findByAttributes(array(
                    'inventarisasiruanganasal_id'=>$stok->inventarisasi_id
                ));

								//relasi untuk data stok awalnya jadi dicomment BMB-3726
                // if (!empty($stok_pake)) {
                //     $ok = 0;
                //     $msg = "Data inventarisasi gagal dibatalkan. Stok inventarisasi sudah digunakan untuk transaksi lain.";
                //     break;
                // }
                InvbarangdetT::model()->updateByPk($det->invbarangdet_id, array('inventarisasi_id'=>null));
                // InventarisasiruanganT::model()->deleteByPk($stok->inventarisasi_id);
								InventarisasiruanganT::model()->deleteAllByAttributes(array('invbarangdet_id'=>$det->invbarangdet_id));
                InvbarangdetT::model()->deleteByPk($det->invbarangdet_id);
            }

						$jurnalOri = JurnalrekeningT::model()->findAllByAttributes(array('invbarang_id'=>$id));

						if(count((array)$jurnalOri) > 0){
							foreach ($jurnalOri as $orig) {
								$delJurdet = JurnaldetailT::model()->deleteAllByAttributes(array('jurnalrekening_id'=>$orig->jurnalrekening_id));
								JurnalrekeningT::model()->deleteByPk($orig->jurnalrekening_id);
							}
						}

            if ($ok == 1) {
								$delInv = InvbarangT::model()->deleteByPk($id);

								if($delInv == true){
									  $trans->commit();
								}
            } else {
                $trans->rollback();
            }
        } catch (Exception $ex) {
            $trans->rollback();
            $ok = 0;
            $msg = "Data inventarisasi gagal dibatalkan : ".$ex->getMessage();
        }

        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
    }

}
