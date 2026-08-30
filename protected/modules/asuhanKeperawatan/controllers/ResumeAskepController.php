<?php

class ResumeAskepController extends MyAuthController {

	protected $successSave = true;
	public $path_view = "asuhanKeperawatan.views.resumeAskep.";

	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = "//layouts/iframe";
		}
		$modPendaftaran = new ASPendaftaranT;
		$modPasien = new ASPasienM;
		$model = new ASResumeaskepR;
		$modDiagnosa = new ASDiagnosaM;
		$modPulang = new ASPasienpulangT;
		$model->tglresume = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
		$model->noresume = "- Otomatis -";

		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

		$url_batal = Yii::app()->createAbsoluteUrl(
				Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
		);
		if (isset($_GET['resumeaskep_id'])) {                    
			$model = ASResumeaskepR::model()->findByPk($_GET['resumeaskep_id']);
                        $model->nama_pegawai = $model->pegawai->namaLengkap;
			$criteria = new CdbCriteria();
			$criteria->select = 't.*,pegawai.*';
			$criteria->join = 'JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = t.pegawai_id';
			$criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
			$modPendaftaran = ASPendaftaranT::model()->find($criteria);
			$modPasien = ASPasienM::model()->findByPk($modPendaftaran->pasien_id);
			$modPasienMorb = ASPasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id));
			if (!empty($modPasienMorb->diagnosa_id)) {
				$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
			} else {
				$modDiagnosa = new ASDiagnosaM;
			}
		}

		$successSave = false;
//		echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";
//		exit;
		if (isset($_POST['ASResumeaskepR']) && !empty($_POST['ASPendaftaranT']['pendaftaran_id'])) {
			$modPendaftaran = ASPendaftaranT::model()->findByPk($_POST['ASPendaftaranT']['pendaftaran_id']);
			$modPasien = ASPasienM::model()->findByPk($_POST['ASPendaftaranT']['pasien_id']);

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model = $this->saveResume($_POST['ASResumeaskepR'], $_POST['ASPendaftaranT']);

				$successSave = $this->successSave;

				if ($successSave) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$transaction->commit();
					$this->redirect(array('index', 'status' => 1, 'resumeaskep_id' => $model->resumeaskep_id));
				} else {
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
				$transaction->rollback();
			}
		}

		$this->render('index', array(
			'modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien,
			'modPulang' => $modPulang,
			'modDiagnosa' => $modDiagnosa,
			'model' => $model,
			'successSave' => $successSave,
			'url_batal' => $url_batal
				)
		);
	}
	
	public function actionCekPendaftaran($pendaftaran_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($pendaftaran_id)) {
				$data = ASResumeaskepR::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionLoadPasien($pendaftaran_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = '';
			if (isset($pendaftaran_id)) {
				$data = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
				$pasien = PasienM::model()->findByPk($data->pasien_id);
				
				$data = array_merge($data->attributes, $pasien->attributes);
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionLoadDiagnosaMedis($pasien_id, $pendaftaran_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data['diagnosa_id'] = "";
			$data['diagnosa_nama'] = "";

			$modPasienMorb = ASPasienmorbiditasT::model()->findAllByAttributes(array('pasien_id' => $pasien_id, 'pendaftaran_id'=>$pendaftaran_id, 'kelompokdiagnosa_id'=> 2));
//			if (!empty($modPasienMorb->diagnosa_id)) {
//				$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
//			} else {
//				$modDiagnosa = array();
//			}

			foreach ($modPasienMorb as $i => $detail) {
				
					$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $detail->diagnosa_id));
					
				if ($i == 0) {
					$data['diagnosa_id'] = $modDiagnosa->diagnosa_id;
					$data['diagnosa_nama'] = $modDiagnosa->diagnosa_nama;
					} else {
					$data['diagnosa_id'] .= ','. $modDiagnosa->diagnosa_id;
					$data['diagnosa_nama'] .= ','. $modDiagnosa->diagnosa_nama;
				}
			}
//			if (count($modDiagnosa) > 0) {
//				$data['diagnosa_id'] .= $modDiagnosa->diagnosa_id;
//				$data['diagnosa_nama'] .= $modDiagnosa->diagnosa_nama;
//			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionLoadDiagnosaTindakanKeperawatan($pendaftaran_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data['tindakankeperawatan'] = "";
			$data['diagnosakeperawatan'] = "";
			$modPengkajian = ASPengkajianaskepT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
			if (!empty($modPengkajian)) {
				$modRencana = ASRencanaaskepT::model()->findByAttributes(array('pengkajianaskep_id' => $modPengkajian->pengkajianaskep_id));
				if (!empty($modRencana)) {
					$modImplementasi = ASImplementasiaskepT::model()->findByAttributes(array('rencanaaskep_id' => $modRencana->rencanaaskep_id));
				} else {
					$modImplementasi = array();
				}
				if (empty($modImplementasi)) {
					$modImplementasiDet = ASImplementasiaskepdetT::model()->findAllByAttributes(array('implementasiaskep_id' => $modImplementasi->implementasiaskep_id));
				} else {
					$modImplementasiDet = array();
				}
				if (count($modImplementasiDet)) {
					foreach ($modImplementasiDet as $i => $detail) {
						$modDiagnosa = ASDiagnosakepM::model()->findByPk($detail->diagnosakep_id);
						if ($i == 0) {
							$data['diagnosakeperawatan'] = $modDiagnosa->diagnosakep_nama;
						} else {
							$data['diagnosakeperawatan'] .= ',' . $modDiagnosa->diagnosakep_nama;
						}

						$modPilih = ASPilihimplementasiaskepT::model()->findAllByAttributes(array('implementasiaskepdet_id' => $detail->implementasiaskepdet_id));
						if (count($modPilih)) {
							foreach ($modPilih as $j => $pilih) {
								$indikator = ASIndikatorimplkepdetM::model()->findByPk($pilih->indikatorimplkepdet_id);
								if ($j == 0) {
									if (isset($indikator->indikatorimplkepdet_indikator)) {
										$data['tindakankeperawatan'] = $indikator->indikatorimplkepdet_indikator;
									}
								} else {
									if (isset($indikator->indikatorimplkepdet_indikator)) {
										$data['tindakankeperawatan'] .= ',' . $indikator->indikatorimplkepdet_indikator;
									}
								}
							}
						}
					}
				}
			}


			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionLoadRiwayatAnemnesa() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadRiwayat = ASAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'tglanamnesis DESC'));
			if (count($loadRiwayat) > 0) {
				foreach ($loadRiwayat AS $i => $modRiwayatAnemnesa) {
					$rows .= $this->renderPartial($this->path_view . "_rowRiwayatAnemnesa", array('modRiwayatAnemnesa' => $modRiwayatAnemnesa), true);
				}
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

	public function actionLoadRiwayatPeriksaFisik() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$loadRiwayat = ASPemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'tglperiksafisik DESC'));
			if (count($loadRiwayat) > 0) {
				foreach ($loadRiwayat AS $i => $modRiwayatPeriksaFisik) {
					$rows .= $this->renderPartial($this->path_view . "_rowRiwayatPemeriksaanFisik", array('modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik), true);
				}
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}
	
	

	protected function saveResume($post, $pendaftaran) {
		$model = new ASResumeaskepR;
		$model->attributes = $post;
		$model->pasien_id = $pendaftaran['pasien_id'];
		$model->pendaftaran_id = $pendaftaran['pendaftaran_id'];
		$model->pegawai_id = $post['pegawai_id'];
		$model->namaperawat = $post['nama_pegawai'];
		$model->ruangan_id = Yii::app()->user->ruangan_id;
		$model->noresume = MyGenerator::noResumeAskep();
		$model->tglresume = MyFormatter::formatDateTimeForDb($post['tglresume']);
		$model->tglmasukrs = MyFormatter::formatDateTimeForDb($pendaftaran['tgl_pendaftaran']);
		$model->tglkeluarrs = !empty($post['tglkeluarrs']) ? MyFormatter::formatDateTimeForDb($post['tglkeluarrs']) : date('Y-m-d H:i:s');
		$model->create_ruangan = Yii::app()->user->ruangan_id;
		$model->create_time = date('Y-m-d');
		$model->create_loginpemakai_id = Yii::app()->user->id;

		if ($model->validate()) {
			$model->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}
                                

		return $model;
	}

	public function actionPrint() {
		$model = ASResumeaskepR::model()->findByPk($_REQUEST['resumeaskep_id']);
		$modPasien = ASPasienpulangrddanriV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
//		$modPasienMorb = ASPasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPasien->pasien_id));
//		if (!empty($modPasienMorb->diagnosa_id)) {
//			$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
//		} else {
//			$modDiagnosa = new ASDiagnosaM();
//		}
                                
		$modProfile = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
		$judulLaporan = 'Resume Keperawatan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien,  'modProfile' => $modProfile, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien,  'modProfile' => $modProfile, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modPasien' => $modPasien, 'modProfile' => $modProfile, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	/**
	 * untuk menampilkan data kunjungan dari autocomplete
	 * - no_pendaftaran
	 * - no_rekam_medik
	 * - nama_pasien
	 */
	public function actionAutocompletenopendaftaran() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();

			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			$models = ASPasienpulangrddanriV::model()->findAll($criteria);
			
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
				$returnVal[$i]['value'] = $model->no_pendaftaran;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionAutocompletenorekammedik() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();

			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			$models = ASPasienpulangrddanriV::model()->findAll($criteria);
			
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
				$returnVal[$i]['value'] = $model->no_rekam_medik;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionAutocompletenamapasien() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();

			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pasien)', strtolower($_GET['term']), true);
			$criteria->limit = 5;
			$models = ASPasienpulangrddanriV::model()->findAll($criteria);

			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
				$returnVal[$i]['value'] = $model->nama_pasien;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	public function actionPegawairiwayat() {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai';
			$criteria->limit = 5;
			$models = PegawaiM::model()->findAll($criteria);

			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
				$returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
				$returnVal[$i]['value'] = $model->pegawai_id;
				$returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionLoadAnamnesaMasuk($pendaftaran_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = array();

			$modAnamnesaMasuk = ASAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id),array('order'=>'tglanamnesis ASC','limit'=>'1'));

			if (!empty($modAnamnesaMasuk)) {
				$data = $modAnamnesaMasuk;
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}
	
	public function actionLoadAnamnesaPulang($pendaftaran_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = array();

			$modAnamnesaPulang = ASAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id),array('order'=>'tglanamnesis DESC','limit'=>'1'));

			if (!empty($modAnamnesaPulang)) {
				$data = $modAnamnesaPulang;
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}
	
	public function actionLoadFisikMasuk($pendaftaran_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = array();

			$modFisikMasuk = ASPemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id),array('order'=>'tglperiksafisik ASC','limit'=>'1'));

			if (!empty($modFisikMasuk)) {
				$data = $modFisikMasuk;
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}
	
	public function actionLoadFisikPulang($pendaftaran_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = array();

			$modFisikPulang = ASPemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id),array('order'=>'tglperiksafisik DESC','limit'=>'1'));

			if (!empty($modFisikPulang)) {
				$data = $modFisikPulang;
			}

			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

}
