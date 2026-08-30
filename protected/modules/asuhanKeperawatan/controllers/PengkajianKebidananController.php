<?php

class PengkajianKebidananController extends MyAuthController {

	protected $successSave = true;
	public $path_view = "asuhanKeperawatan.views.pengkajianKebidanan.";

	public function actionIndex() {
		if (isset($_GET['frame'])) {
			$this->layout = "//layouts/iframe";
		}
		$modPendaftaran = new ASPendaftaranT;
		$modPasien = new ASPasienM;
		$modPenanggungJawab = new ASPenanggungjawabM;
		$modRiwayatAnemnesa = new ASAnamnesaT;
		$modRiwayatPeriksaFisik = new ASPemeriksaanfisikT;
		$modPengkajian = new ASPengkajianaskepT;
		$modPenunjang = new ASDatapenunjangT;
		$modPengkajian->pengkajianaskep_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
		$modPengkajian->no_pengkajian = "- Otomatis -";

		$nama_modul = Yii::app()->controller->module->id;
		$nama_controller = Yii::app()->controller->id;
		$nama_action = Yii::app()->controller->action->id;
		$modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;

		$url_batal = Yii::app()->createAbsoluteUrl(
				Yii::app()->controller->module->id . '/' . Yii::app()->controller->id
		);

		if (isset($_GET['pendaftaran_id'])) {
			$modPendaftaran = ASPendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
			$modPasien = ASPasienM::model()->findByPk($modPendaftaran->pasien_id);
		}

		if (isset($_GET['pengkajianaskep_id'])) {
			
		}
		$successSave = false;

		if (isset($_POST['ASPengkajianaskepT']) && !empty($_POST['ASPendaftaranT']['pendaftaran_id'])) {
			$modPendaftaran = ASPendaftaranT::model()->findByPk($_POST['ASPendaftaranT']['pendaftaran_id']);
			$modPasien = ASPasienM::model()->findByPk($_POST['ASPendaftaranT']['pasien_id']);

			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modPengkajian = $this->savePengkajian($_POST['ASPengkajianaskepT'], $_POST['ASPendaftaranT']['pendaftaran_id']);

				if (isset($_POST['ASDatapenunjangT'])) {

					$modPenunjang = $this->savePenunjang($_POST['ASDatapenunjangT'], $modPengkajian->pengkajianaskep_id);
				}
				$successSave = $this->successSave;

				if ($successSave) {
					Yii::app()->user->setFlash('success', "Data berhasil disimpan");
					$transaction->commit();
//                    $this->redirect(array('index','status'=>1,'returbayarpelayanan_id'=>$modRetur->returbayarpelayanan_id,'pendaftaran_id'=>$_POST['BKPendaftaranT']['pendaftaran_id'],'smspasien'=>$smspasien)); 
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
			'modPenanggungJawab' => $modPenanggungJawab,
			'modRiwayatAnemnesa' => $modRiwayatAnemnesa,
			'modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik,
			'modPengkajian' => $modPengkajian,
			'modPenunjang' => $modPenunjang,
			'successSave' => $successSave,
			'url_batal' => $url_batal
				)
		);
	}
	
	
	public function actionCekPendaftaran($pendaftaran_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = null;
//			if (isset($pendaftaran_id)) {
//				$data = ASPengkajianaskepT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
//			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionLoadPasien($pendaftaran_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = null;
			if (isset($pendaftaran_id)) {
				$data = ASInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}
	
	public function actionLoadPenanggungJawab($penanggungjawab_id) {
		if (Yii::app()->request->isAjaxRequest) {
			$data = null;
			if (isset($penanggungjawab_id)) {
				$data = ASPenanggungjawabM::model()->findByPk($penanggungjawab_id);
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
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

	public function actionLoadTambahPenunjang() {
		if (Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$rows = "";
			$modPenunjang = new ASDatapenunjangT;
			$criteria = new CdbCriteria();
			$criteria->select = 't.tglmasukpenunjang,t.ruangan_id,ruangan.ruangan_nama, t.jeniskasuspenyakit_id, jeniskasuspenyakit.jeniskasuspenyakit_nama';
			$criteria->join = 'JOIN ruangan_m AS ruangan ON ruangan.ruangan_id = t.ruangan_id
							   JOIN jeniskasuspenyakit_m AS jeniskasuspenyakit ON jeniskasuspenyakit.jeniskasuspenyakit_id = t.jeniskasuspenyakit_id';
			$criteria->addCondition('t.pendaftaran_id =' . $_GET['pendaftaran_id']);
			$loadPenunjang = ASPasienmasukpenunjangT::model()->findAll($criteria);
			if (count($loadPenunjang) > 0) {
				foreach ($loadPenunjang AS $i => $modTambahPenunjang) {
					$rows .= $this->renderPartial($this->path_view . "_rowPenunjang", array('modPenunjang' => $modPenunjang, 'modTambahPenunjang' => $modTambahPenunjang), true);
				}
			}
			echo CJSON::encode(array(
				'rows' => $rows));
		}
		Yii::app()->end();
	}

	protected function savePengkajian($post, $pendaftaran_id) {
		$modPengkajian = new ASPengkajianaskepT;
		$modPengkajian->attributes = $post;
		$modPengkajian->no_pengkajian = MyGenerator::noPengkajianAskep();
		$modPengkajian->anamesa_id = $post['anamesa_id'];
		$modPengkajian->pemeriksaanfisik_id = $post['pemeriksaanfisik_id'];
		$modPengkajian->pengkajianaskep_tgl = MyFormatter::formatDateTimeForDb($post['pengkajianaskep_tgl']);
		$modPengkajian->pendaftaran_id = $pendaftaran_id;
		$modPengkajian->create_ruangan = Yii::app()->user->ruangan_id;
		$modPengkajian->create_time = date('Y-m-d');
		$modPengkajian->create_loginpemakai_id = Yii::app()->user->id;
		$modPengkajian->ruangan_id = Yii::app()->user->ruangan_id;
		$modPengkajian->iskeperawatan = 0;
		if ($modPengkajian->validate()) {
			$modPengkajian->save();
			$this->successSave = $this->successSave && true;
		} else {
			$this->successSave = false;
		}

		return $modPengkajian;
	}

	public function savePenunjang($post, $pengkajianaskep_id) {
		foreach ($post as $i => $row) {

			$modPenunjang = new ASDatapenunjangT;
			$modPenunjang->attributes = $row;
			$modPenunjang->pengkajianaskep_id = $pengkajianaskep_id;
			$modPenunjang->datapenunjang_tgl = MyFormatter::formatDateTimeForDb($row['datapenunjang_tgl']);
			$modPenunjang->datapenunjang_nama = $row['datapenunjang_nama'];
			if ($modPenunjang->validate()) {
				$modPenunjang->save();
				$this->successSave = $this->successSave && true;
			} else {
				$this->successSave = false;
			}
		}
		return $modPenunjang;
	}

	public function actionPrint() {
		$modPengkajian = ASPengkajianaskepT::model()->findByPk($_REQUEST['pengkajianaskep_id']);
		$modPengkajian->attributes = $modPengkajian;
		$modPendaftaran = ASPendaftaranT::model()->findByPk($modPengkajian->pendaftaran_id);
		$modPasien = ASPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modPasienMorb = ASPasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id));
		if (!empty($modPasienMorb->diagnosa_id)) {
			$modDiagnosa = ASDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modPasienMorb->diagnosa_id));
		} else {
			$modDiagnosa = array();
		}

		if (!empty($modPendaftaran->penanggungjawab_id)) {
			$modPenanggungJawab = ASPenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
		} else {
			$modPenanggungJawab = array();
		}

		$modAnamnesa = ASAnamnesaT::model()->findByPk($modPengkajian->anamesa_id);
		$modPeriksaFisik = ASPemeriksaanfisikT::model()->findByPk($modPengkajian->pemeriksaanfisik_id);
		
		$penunjang = new ASDatapenunjangT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pengkajianaskep_id ='.$modPengkajian->pengkajianaskep_id);
		$modPenunjang = new CActiveDataProvider($penunjang, array(
			'criteria' => $criteria,
		));
		
		$perkawinan = new ASRiwayatperkawinanR;
		$persalinan = new ASRiwayatpersalinanR;
        $criteria = new CDbCriteria();
		$criteria->addCondition('anamesa_id =' . $modPengkajian->anamesa_id);

		$modPerkawinan = new CActiveDataProvider($perkawinan, array(
			'criteria' => $criteria,
		));
		$modPersalinan = new CActiveDataProvider($persalinan, array(
			'criteria' => $criteria,
		));
		$modProfile = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
		$judulLaporan = 'Pengkajian Kebidanan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'Print', array('modPengkajian' => $modPengkajian, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modDiagnosa' => $modDiagnosa, 'modPenanggungJawab' => $modPenanggungJawab, 'modAnamnesa' => $modAnamnesa, 'modPeriksaFisik' => $modPeriksaFisik, 'modPenunjang' => $modPenunjang, 'modPerkawinan'=>$modPerkawinan, 'modPersalinan'=>$modPersalinan, 'modProfile'=>$modProfile, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'Print', array('modPengkajian' => $modPengkajian, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modDiagnosa' => $modDiagnosa, 'modPenanggungJawab' => $modPenanggungJawab, 'modAnamnesa' => $modAnamnesa, 'modPeriksaFisik' => $modPeriksaFisik, 'modPenunjang' => $modPenunjang, 'modPerkawinan'=>$modPerkawinan, 'modPersalinan'=>$modPersalinan, 'modProfile'=>$modProfile, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPengkajian' => $modPengkajian, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modDiagnosa' => $modDiagnosa, 'modPenanggungJawab' => $modPenanggungJawab, 'modAnamnesa' => $modAnamnesa, 'modPeriksaFisik' => $modPeriksaFisik, 'modPenunjang' => $modPenunjang, 'modPerkawinan'=>$modPerkawinan, 'modPersalinan'=>$modPersalinan, 'modProfile'=>$modProfile, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}

	public function actionGetPenunjang($pengkajianaskep_id) {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$penunjang = ASDatapenunjangT::model()->findAllByAttributes(array('pengkajianaskep_id' => $pengkajianaskep_id));
			$data['form'] = "";

			if (count($penunjang) > 0) {
				foreach ($penunjang AS $i => $modPenunjang) {
					$data['form'] .= $this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true);
				}
			} else {

				$data['form'] .= '<tr><td colspan=2>Data tidak ditemukan</td></tr>';
			}
			echo CJSON::encode($data);
			Yii::app()->end();
		}
	}

	public function actionDeletePenunjang($id = null) {
		if (Yii::app()->request->isAjaxRequest) {
			$transaction = Yii::app()->db->beginTransaction();
			try {

				$data['success'] = true;

				$deletePenunjang = ASDatapenunjangT::model()->deleteByPk($id);

				if ($deletePenunjang) {
					$data['success'] = true;
					$data['pesan'] = 'Berhasil Dihapus';
					$transaction->commit();
				} else {
					$data['success'] = false;
					$data['pesan'] = 'Gagal Dihapus';
					$transaction->rollback();
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				echo MyExceptionMessage::getMessage($exc, true);
				$data['success'] = false;
			}



			echo json_encode($data);
			Yii::app()->end();
		}
	}

	public function actionDetailAnamnesis($anamesa_id = null) {
		$this->layout = "//layouts/iframe";

		$anamnesa = new ASAnamnesaT;
		$perkawinan = new ASRiwayatperkawinanR;
		$persalinan = new ASRiwayatpersalinanR;
		$criteria = new CDbCriteria();
		$criteria->select = 't.*,pasien.*,pendaftaran.*,pegawai.gelardepan,gelarbelakang.gelarbelakang_nama,pegawai.nama_pegawai,kelaspelayanan.*';
		$criteria->join = 'LEFT JOIN pasien_m AS pasien ON pasien.pasien_id = t.pasien_id
						   LEFT JOIN pendaftaran_t AS pendaftaran ON pendaftaran.pendaftaran_id = t.pendaftaran_id
						   LEFT JOIN pegawai_m AS pegawai ON pegawai.pegawai_id = t.pegawai_id
						   LEFT JOIN kelaspelayanan_m AS kelaspelayanan ON kelaspelayanan.kelaspelayanan_id = pendaftaran.kelaspelayanan_id
						   LEFT JOIN gelarbelakang_m AS gelarbelakang ON gelarbelakang.gelarbelakang_id = pegawai.gelarbelakang_id';
		$criteria->addCondition('anamesa_id =' . $anamesa_id);

		$modAnamnesa = ASAnamnesaT::model()->find($criteria);

		$criteria = new CDbCriteria();
		$criteria->addCondition('anamesa_id =' . $anamesa_id);

		$modPerkawinan = new CActiveDataProvider($perkawinan, array(
			'criteria' => $criteria,
		));
		$modPersalinan = new CActiveDataProvider($persalinan, array(
			'criteria' => $criteria,
		));
		$this->render($this->path_view . '_detailAnamnesis', array(
			'modAnamnesa' => $modAnamnesa,
			'modPerkawinan' => $modPerkawinan,
			'modPersalinan' => $modPersalinan,
		));
	}

	/**
	 * @param type $pendaftaran_id
	 */
	public function actionDetailPeriksaFisik($pemeriksaanfisik_id) {
		$this->layout = '//layouts/printWindows';
		$format = new MyFormatter;
		$criteria = new CdbCriteria();
		$criteria->with = array('pegawai');
		$criteria->addCondition('pemeriksaanfisik_id =' . $pemeriksaanfisik_id);
		$modPemeriksaanFisik = ASPemeriksaanfisikT::model()->find($criteria);

		$criteria1 = new CdbCriteria();
		$criteria1->with = array('kelaspelayanan');
		$criteria1->addCondition('pendaftaran_id =' . $modPemeriksaanFisik->pendaftaran_id);
		$modPendaftaran = ASPendaftaranT::model()->find($criteria1);
		$modPasien = ASPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modPemeriksaanGambar = ASPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $modPemeriksaanFisik->pendaftaran_id));
		$modGambarTubuh = new ASGambartubuhM();
		$modBagianTubuh = new ASBagiantubuhM();
		if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
			$modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
		}

		$judul_print = 'PEMERIKSAAN FISIK';
		$this->render($this->path_view . '_detailFisik', array(
			'format' => $format,
			'modPendaftaran' => $modPendaftaran,
			'judul_print' => $judul_print,
			'modPasien' => $modPasien,
			'modPemeriksaanFisik' => $modPemeriksaanFisik,
			'modPemeriksaanGambar' => $modPemeriksaanGambar,
			'modGambarTubuh' => $modGambarTubuh,
			'modBagianTubuh' => $modBagianTubuh
		));
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
			$criteria->addBetweenCondition("DATE(tglmasukkamar)",date("Y-m-d", strtotime("31 days")),date("Y-m-d"));
			$criteria->limit = 5;
			$models = ASInfopasienmasukkamarV::model()->findAll($criteria);
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
			$models = ASInfopasienmasukkamarV::model()->findAll($criteria);
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
			$models = ASInfopasienmasukkamarV::model()->findAll($criteria);
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
	
	public function actionPegawairiwayat()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                $criteria->order = 'nama_pegawai';
                $criteria->limit=5;
                $models = PegawaiM::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nomorindukpegawai.' - '.$model->nama_pegawai.' - '.$model->jeniskelamin;
                    $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                    $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();

        }

}
