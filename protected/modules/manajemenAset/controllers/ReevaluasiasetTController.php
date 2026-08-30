<?php

class ReevaluasiasetTController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'index';
	public $penjurnalan = false;
	public $penjurnalanDetail = true;

	public function actionIndex() {
		$model = new MAReevaluasiasetT;
		$models = new MAReevaluasiasetdetailT;
		$format = new MyFormatter();

		if (isset($_POST['MAReevaluasiasetT'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['MAReevaluasiasetT'];
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->update_loginpemakai_id = Yii::app()->user->id;
				$model->create_time = date('Y-m-d');
				$model->update_time = date('Y-m-d');
				$model->reevaluasiaset_no = $_POST['MAReevaluasiasetT']['reevaluasiaset_no'];
				$model->pegawaimengetahui_id = $_POST['pegawai_id'];
				$model->pegawaimenyetujui_id = $_POST['pegawai_id_'];
				$model->reevaluasiaset_tgl = $format->formatDateTimeForDb($_POST['MAReevaluasiasetT']['reevaluasiaset_tgl']);
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$model->save();

				foreach ($_POST as $key => $data) {

					$models->barang_id = $_POST['barang_id'];
					$models->invtanah_id = $_POST['invtanah'];
					$models->invgedung_id = $_POST['invgedung'];
					$models->invperalatan_id = $_POST['invperalatan'];
					$models->invjalan_id = $_POST['invjalan'];
					$models->invasetlain_id = $_POST['invasetlain'];
					$models->reevaluasiaset_umurekonomis = $_POST['ue'];
					$models->reevaluasiaset_nilaibuku = $_POST['nb'];
					$models->reevaluasiaset_hargaperolehan = $_POST['hrgperolehan'];
					$models->reevaluasiaset_selisihreevaluasi = $_POST['selisih'];
					$models->reevaluasiaset_id = $model->reevaluasiaset_id;

					if ($models->save()) {
						$modJurnalRekening = new MAJurnalrekeningT;
						$modJurnalRekening->jenisjurnal_id = ParamsConst::JENISJURNAL_ID_REEVALUASI;
						$modJurnalRekening->rekperiod_id = Yii::app()->user->getState('periode_ids');
						$modJurnalRekening->tglbuktijurnal = $model->reevaluasiaset_tgl;
						$modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
						$modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
						$modJurnalRekening->noreferensi = 0;
						$modJurnalRekening->tglreferensi = $model->reevaluasiaset_tgl;
						$modJurnalRekening->nobku = "";
						$modJurnalRekening->urianjurnal = "Reevaluasi Jurnal";
						$modJurnalRekening->create_time = $model->reevaluasiaset_tgl;
						$modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
						$modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

						if ($modJurnalRekening->save()) {
							$this->penjurnalan = true;
							if (isset($_POST['RekeningakuntansiV'])) {
								if (count($_POST['RekeningakuntansiV']) > 0) {
									foreach ($_POST['RekeningakuntansiV'] as $x => $jurnalDetail) {
										$modJurnalDet = new MAJurnaldetailT;
										$modJurnalDet->attributes = $jurnalDetail;
										$modJurnalDet->rekperiod_id = $modJurnalRekening->rekperiod_id;
										$modJurnalDet->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
										$modJurnalDet->uraiantransaksi = isset($jurnalDetail['nama_rekening']) ? $jurnalDetail['nama_rekening'] : "";
										$modJurnalDet->saldodebit = isset($jurnalDetail['saldodebit']) ? (int) $jurnalDetail['saldodebit'] : 0;
										$modJurnalDet->saldokredit = isset($jurnalDetail['saldokredit']) ? (int) $jurnalDetail['saldokredit'] : 0;
										$modJurnalDet->nourut = $x + 1;
										$modJurnalDet->rekening5_id = isset($jurnalDetail['rekening5_id']) ? $jurnalDetail['rekening5_id'] : null;
										$modJurnalDet->catatan = "";
									}
									if ($modJurnalDet->save()) {
										$this->penjurnalanDetail &= true;
									} else {
										$this->penjurnalanDetail &= false;
									}
								}
							}
						}
					}
				}
				if ($this->penjurnalanDetail) {
					$transaction->commit();
					$this->redirect(array('index', 'reevaluasiaset_id' => $model->reevaluasiaset_id, 'sukses' => 1));
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Mencetak data
	 */
	public function actionPrint() {
		$model = new BarangV();
		$judulLaporan = 'Reevaluasi Aset';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == '2') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	/* Digunakan di Modul Akuntansi
	 * 
	 */

	public function actionRekeningAkuntansi() {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
			$term = strtolower(trim($_GET['term']));

			$condition = "LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
			if (isset($_GET['id_jenis_rek'])) {
				$condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'D' OR rekening4_nb = 'D' OR rekening3_nb = 'D')";
				if ($_GET['id_jenis_rek'] == 'Kredit') {
					$condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'K' OR rekening4_nb = 'K' OR rekening3_nb = 'K')";
				}
			}

			$criteria->addCondition($condition);
			$criteria->order = 'nmrekening5';
			$models = RekeningakuntansiV::model()->findAll($criteria);
			$returnVal = array();
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				if (isset($model->rincianobyek_id)) {
					$kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekening5;
					$nama_rekening = $model->nmrekening5;
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

	// fungsi untuk penjurnalan di transaksi penyusutan aset
	public function actionAmbilDataRekening() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
			$rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
			$rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
			$rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
			$rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
			$status = isset($_POST['status']) ? $_POST['status'] : null;

			$criteria = new CDbCriteria;
			if (!empty($rekening5_id)) {
				$criteria->addCondition("rekening5_id = " . $rekening5_id);
			}
			if (!empty($rekening4_id)) {
				$criteria->addCondition("rekening4_id = " . $rekening4_id);
			}
			if (!empty($rekening3_id)) {
				$criteria->addCondition("rekening3_id = " . $rekening3_id);
			}
			if (!empty($rekening2_id)) {
				$criteria->addCondition("rekening2_id = " . $rekening2_id);
			}
			if (!empty($rekening1_id)) {
				$criteria->addCondition("rekening1_id = " . $rekening1_id);
			}

			$model = MARekeningakuntansiV::model()->findAll($criteria);
			if ($model) {
				echo CJSON::encode(
						$this->renderPartial('__formKodeRekening', array('model' => $model, 'status' => $status), true)
				);
			}
			Yii::app()->end();
		}
	}

}
