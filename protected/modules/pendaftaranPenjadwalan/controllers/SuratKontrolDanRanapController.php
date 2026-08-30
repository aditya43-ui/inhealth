<?php

Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.DaftarPasienController');
Yii::import('rawatJalan.controllers.SuratPerintahRawatInapController');


class SuratKontrolDanRanapController extends MyAuthController
{
	public $path_view;

	public function actionCreateKontrol()
	{
		$this->render('createKontrol');
	}

	public function actionCreateRanap()
	{
		$this->render('createRanap');
	}

	public function actionIndex()
	{
		$model = new InformasisuratSrkSpriV;
		$model->unsetAttributes();
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d');
		$model->cari_berdasarkan = 'tglsurat';
		$model->katakunci = null;

		if (isset($_GET['InformasisuratSrkSpriV'])) {
			$model->attributes = $_GET['InformasisuratSrkSpriV'];
			$model->jenissurat = $_GET['InformasisuratSrkSpriV']['jenissurat'];
			$model->cari_berdasarkan = $_GET['InformasisuratSrkSpriV']['cari_berdasarkan'];
			$model->katakunci = isset($_GET['InformasisuratSrkSpriV']['katakunci']) ? $_GET['InformasisuratSrkSpriV']['katakunci'] : '';
			$model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['InformasisuratSrkSpriV']['tgl_awal']);
			$model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['InformasisuratSrkSpriV']['tgl_akhir']);

			if(Yii::app()->request->isAjaxRequest) {
				if(isset($_GET['ajax']) && $_GET['ajax'] == 'srk-spri-grid') {
					$this->renderPartial('_table', ['model' => $model]);
					Yii::app()->end();
				}
			}
		}

		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionUpdateKontrol($id)
	{
		$this->layout = '//layouts/iframe';
		$modSurat = SuratketeranganR::model()->findByPk($id);
		$modPendaftaran = PendaftaranT::model()->findByPk($modSurat->pendaftaran_id);

		if (isset($_POST['SuratketeranganR'])) {
			$trans = Yii::app()->db->beginTransaction();

			$modSurat->attributes = $_POST['SuratketeranganR'];
			$modPendaftaran->attributes = $_POST['PendaftaranT'];

			$modPendaftaran->tglrenkontrol = MyFormatter::formatDateTimeForDB($modPendaftaran->tglrenkontrol);
			$modPendaftaran->save(false);


			// set kontrol
			$kode_dokter = "";
			if (isset($_POST['PendaftaranT']['doktertujuankontrol_id'])) {
				$dok = PegawaiM::model()->findByPk($_POST['PendaftaranT']['doktertujuankontrol_id']);
				if (!empty($dok)) {
					$kode_dokter = $dok->kodedokter_bpjs;
				}
			}
			$poli = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
			if (isset($_POST['PendaftaranT']['ruangankontrol_id'])) {
				$poli = RuanganM::model()->findByPk($_POST['PendaftaranT']['ruangankontrol_id']);
			}
			$kontrol_poli = $poli->kode_bpjs;
			$kontrol_tgl_rencana = date('Y-m-d', strtotime($modPendaftaran->tglrenkontrol));
			$user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
			$kontrol_user_res = empty($user) ? "" : trim($user->namaLengkap);
			$kontrol_no_sep = isset($_POST['SepT']['nosep']) ? $_POST['SepT']['nosep'] : null;

			$bpjs = new Bpjs_Vklaim;

			// var_dump($kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res); die;
			// var_dump($modSurat->attributes); die;
			if (!empty($modSurat->nomorsurat_bpjs)) {
				$res_kontrol = CJSON::decode($bpjs->update_rencana_kontrol($modSurat->nomorsurat_bpjs, $kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res));
			} else {
				$res_kontrol = CJSON::decode($bpjs->create_rencana_kontrol($kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res));
			}
		

			$vclaim_msg = "";

			if (!$res_kontrol) {
				$vclaim_msg = "Note : Ada kesalahan ketika membuat rencana kontrol";
			}
			$res_json = $res_kontrol;

			

			if ($res_json['metaData']['code'] != 200) {
				$vclaim_msg = "Note : ".$res_json['metaData']['message'];
				$trans->rollback();
				Yii::app()->user->setFlash('error', "Surat Kontrol gagal disimpan ! ".$vclaim_msg);
				if (!empty($modSurat->nomorsurat_bpjs)) {
					$this->logBpjs($modPendaftaran, $res_json, $bpjs->server_new['update_rencana_kontrol']);
				} else {
					$this->logBpjs($modPendaftaran, $res_json, $bpjs->server_new['create_rencana_kontrol']);
				}
			} else {
				$modSurat->nomorsurat_bpjs = $res_json['response']['noSuratKontrol'];
				$modSurat->respon_bpjs = CJSON::encode($res_json['response']);
				$modSurat->save();
				if (!empty($modSurat->nomorsurat_bpjs)) {
					$this->logBpjs($modPendaftaran, $res_json, $bpjs->server_new['update_rencana_kontrol']);
				} else {
					$this->logBpjs($modPendaftaran, $res_json, $bpjs->server_new['create_rencana_kontrol']);
				}
				$trans->commit();

				Yii::app()->user->setFlash('success', "Surat Kontrol berhasil disimpan ! ");
                $this->redirect(array('updateKontrol','id'=>$id, 'sukses'=>1));
			}


			// var_dump($modSurat->attributes, $modPendaftaran->attributes, $_POST);

			// die;


		}

		$this->render('updateKontrol', array(
			'modSurat'=>$modSurat,
			'modPendaftaran'=>$modPendaftaran,
		));
	}
	public function actionUpdateSRKTanpaKunjungan($id)
	{
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter();
		$modSurat = SuratketeranganR::model()->findByPk($id);
		if(!empty($modSurat->tglrenkontrol)) {
			$tgl_rencana_kontrol = explode(' ', $modSurat->tglrenkontrol);
			$modSurat->tglrenkontrol = $format->formatDateTimeForUser($tgl_rencana_kontrol[0]);
		}

		if(!empty($modSurat->polikontrol)) {
			$modSpesialis = SpesialissubspesialisM::model()->findByAttributes(['spesialissubspesialis_kodebpjs' => $modSurat->polikontrol, 'spesialissubspesialis_aktif' => true]);
			// echo '<pre>';var_dump($modSpesialis);die;

			if(!empty($modSpesialis)) {
				$modSurat->spesialissubspesialis_id = $modSpesialis->spesialissubspesialis_id;
			}
		}

		if(!empty($modSurat->kodedokterkontrol)) {
			$modPegawaiKontrol = PegawaiM::model()->findByAttributes(['kodedokter_bpjs' => $modSurat->kodedokterkontrol]);
			if(!empty($modPegawaiKontrol)) {
				$modSurat->doktertujuankontrol_id = $modPegawaiKontrol->pegawai_id;
			}
		
		}
		// echo '<pre>';var_dump($modSurat);die;

		if (isset($_POST['SuratketeranganR'])) {
			$trans = Yii::app()->db->beginTransaction();

			$modSurat->attributes = $_POST['SuratketeranganR'];
			
			// echo '<pre>';var_dump($_POST);die;

			// set kontrol
			$kode_dokter = "";
			$kontrol_poli = '';
			$namaDokterKontrol = '';
			if (isset($_POST['SuratketeranganR']['doktertujuankontrol_id'])) {
				$dok = PegawaiM::model()->findByPk($_POST['SuratketeranganR']['doktertujuankontrol_id']);
				if (!empty($dok)) {
					$kode_dokter = $dok->kodedokter_bpjs;
					$namaDokterKontrol = $dok->namaLengkap;
				}

				// update ke suratketerangan_r
				$modSurat->kodedokterkontrol = $kode_dokter;
				$modSurat->doktertujuankontrol_id = $_POST['SuratketeranganR']['doktertujuankontrol_id'];
				$modSurat->namadokterkontrol = $namaDokterKontrol;
			}

			if(isset($_POST['SuratketeranganR']['spesialissubspesialis_id'])) {
				$modSpesialis = SpesialissubspesialisM::model()->findByPk($_POST['SuratketeranganR']['spesialissubspesialis_id']);

				if(!empty($modSpesialis)) {
					$kontrol_poli = $modSpesialis->spesialissubspesialis_kodebpjs;
				}
				// update ke suratketerangan_r
				$modSurat->polikontrol = $kontrol_poli;
				$modSurat->spesialissubspesialis_id = $_POST['SuratketeranganR']['spesialissubspesialis_id'];
			}

			if(isset($_POST['SuratketeranganR']['tglrenkontrol'])) {
				$modSurat->tglrenkontrol = $_POST['SuratketeranganR']['tglrenkontrol'];
			}

			$kontrol_tgl_rencana = MyFormatter::formatDateTimeForDb($_POST['SuratketeranganR']['tglrenkontrol']);
			$user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
			$kontrol_user_res = empty($user) ? "" : trim($user->namaLengkap);
			$kontrol_no_sep = !empty($modSurat->nosep) ? $modSurat->nosep : null;

			$bpjs = new Bpjs_Vklaim;

			// var_dump($kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res); die;
			// var_dump($modSurat->attributes); die;
		
			$res_kontrol = CJSON::decode($bpjs->update_rencana_kontrol($modSurat->nomorsurat_bpjs, $kontrol_no_sep, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res));
			

			// var_dump($res_kontrol); die;
			// update ke suratketerangan_r
			$modSurat->tglrenkontrol = $kontrol_tgl_rencana;
			$vclaim_msg = "";

			if (!$res_kontrol) {
				$vclaim_msg = "Note : Ada kesalahan ketika membuat rencana kontrol";
			}
			$res_json = $res_kontrol;

			if ($res_json['metaData']['code'] != 200) {
				$vclaim_msg = "Note : ".$res_json['metaData']['message'];
				$trans->rollback();
				$this->logBpjs($modSurat, $res_kontrol, $bpjs->server_new['update_rencana_kontrol']);
				Yii::app()->user->setFlash('error', "Surat Kontrol gagal disimpan ! ".$vclaim_msg);
			} else {
				$modSurat->nomorsurat_bpjs = $res_json['response']['noSuratKontrol'];
				$modSurat->respon_bpjs = CJSON::encode($res_json['response']);
				$modSurat->save();
				$this->logBpjs($modSurat, $res_kontrol, $bpjs->server_new['update_rencana_kontrol']);
				$trans->commit();

				Yii::app()->user->setFlash('success', "Surat Kontrol berhasil disimpan ! ");
                $this->redirect(array('UpdateSRKTanpaKunjungan','id'=>$id, 'sukses'=>1));
			}


		}

		$this->render('updateSRKTanpaKunjungan', array(
			'modSurat'=>$modSurat,
			
		));
	}

	public function actionUpdateRanap($id)
	{
		$this->layout = '//layouts/iframe';
		$modSurat = SuratperintahranapT::model()->findByPk($id);
		$modPendaftaran = PendaftaranT::model()->findByPk($modSurat->pendaftaran_id);
		$asuransi = AsuransipasienM::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id));

		$modSurat->tgl_rencanaranap = MyFormatter::formatDateTimeForUser($modSurat->tgl_rencanaranap);

		if (isset($_POST['SuratperintahranapT'])) {

			$trans = Yii::app()->db->beginTransaction();

			$modSurat->attributes = $_POST['SuratperintahranapT'];
			$modSurat->tgl_rencanaranap = MyFormatter::formatDateTimeForDB($modSurat->tgl_rencanaranap);
			
			// var_dump($modSurat->attributes, $_POST); die;
			$kode_dokter = "";
			if (!empty($modSurat->dpjp_id)) {
				$dok = PegawaiM::model()->findByPk($modSurat->dpjp_id);
				if (!empty($dok)) {
					$kode_dokter = $dok->kodedokter_bpjs;
				}
			}
			
			$no_kartu = $modSurat->nokartubpjs;
			if (isset($_POST['SepT']['nokartuasuransi'])) {
				$no_kartu = $_POST['SepT']['nokartuasuransi'];
			}

			// if (isset($_POST['$_POST['SuratperintahranapT']']))

			$poli = SpesialissubspesialisM::model()->findByPk($modSurat->spesialissubspesialis_id);
			$kontrol_poli = $poli->spesialissubspesialis_kode;
			$kontrol_tgl_rencana = date('Y-m-d', strtotime($modSurat->tgl_rencanaranap));
			$user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
			$kontrol_user_res = empty($user) ? "" : trim($user->nama_pegawai);

			
			// var_dump($no_kartu, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res); die;
			
			$bpjs = new Bpjs_Vklaim;

			$modSurat->nokartubpjs = $no_kartu;

			// var_dump($modSurat->attributes); die;

			if (!empty($modSurat->nomorspri_bpjs)) {
				$res_kontrol = CJSON::decode($bpjs->update_spri($modSurat->nomorspri_bpjs, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res));
			} else {
				$res_kontrol = CJSON::decode($bpjs->create_spri($no_kartu, $kode_dokter, $kontrol_poli, $kontrol_tgl_rencana, $kontrol_user_res));
			}

			$vclaim_msg = "";

            if (!$res_kontrol) {
                $vclaim_msg = "Note : Ada kesalahan ketika membuat rencana kontrol";
            }

			if ($res_kontrol['metaData']['code'] != 200) {
				$vclaim_msg = "Note : ".$res_kontrol['metaData']['message'];
				$trans->rollback();
				$modSurat->tgl_rencanaranap = MyFormatter::formatDateTimeForUser($modSurat->tgl_rencanaranap);

				Yii::app()->user->setFlash('error', "SPRI gagal disimpan ! ".$vclaim_msg);
			} else {
				$modSurat->nomorspri_bpjs = $res_kontrol['response']['noSPRI'];
				$modSurat->responspri_bpjs = CJSON::encode($res_kontrol);
				$modSurat->save(false);
				$trans->commit();

				Yii::app()->user->setFlash('success', "SPRI berhasil disimpan ! ");
                $this->redirect(array('updateRanap','id'=>$id, 'sukses'=>1));
			}

			
			// var_dump($res_kontrol); die;
			

		}


		$this->render('updateRanap', array(
			'modSurat'=>$modSurat,
			'modPendaftaran'=>$modPendaftaran,
			'asuransi'=>$asuransi,
		));
	}

	public function actionView($id, $jenis) {
		$modelInfo = InformasisuratSrkSpriV::model()->findByAttributes(array(
			'surat_id'=>$id,
			'jenissurat'=>$jenis,
		));

		if (empty($modelInfo)) {
			echo "Data tidak ditemukan";
			Yii::app()->end();
		}

		if ($jenis == 1) {
			$modPendaftaran = RJPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modelInfo->pendaftaran_id));
			$model = SuratketeranganR::model()->findByPk($id);
			if (empty($model)){
				echo 'Surat Keterangan Rencana Kontrol Belum Ada';
				exit;
			}
			$judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => $model->jenissurat_id));
			$modPasien = InfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
			$modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id' => $modPendaftaran->ruangankontrol_id));
			$modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modelInfo->pendaftaran_id, 'kelompokdiagnosa_id' => 2,
				'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
			if (isset($modMorbiditas)) {
				$modDiagnosa = DiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modMorbiditas->diagnosa_id));
			} else {
				$modDiagnosa = array();
			}

			$modTambahan = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modelInfo->pendaftaran_id, 'kelompokdiagnosa_id' => 3,
				'ruangan_id' => $modPendaftaran->ruangan_id));




			// foreach($modDiagnosaTambahan as $diagnosa){
			//     echo print_r($diagnosa->diagnosa_nama).exit();
			// }
			//echo print_r($modDiagnosaTambahan).exit();

			$caraPrint = "PRINT";
			$judulLaporan = '';
				$this->layout = '//layouts/printWindows';
				$this->render('rawatJalan.views.daftarPasien.PrintRencanaKonsul',
					array('modPendaftaran' => $modPendaftaran,
						'judul' => $judul,
						'caraPrint' => $caraPrint,
						'model' => $model,
						'modPasien' => $modPasien,
						'modRuangan' => $modRuangan,
						'judulLaporan' => $judulLaporan,
						'modDiagnosa' => $modDiagnosa,
						'modTambahan' => $modTambahan));
			
		} else {
			$model = SuratperintahranapT::model()->findByPk($id);
            $modPendaftaran = PendaftaranT::model()->findByPk($modelInfo->pendaftaran_id);
            $modSep = SepT::model()->findByPk($modPendaftaran->sep_id);

            $caraPrint="PRINT";
            // if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
				$this->path_view = "rawatJalan.views.suratPerintahRawatInap.";
                $this->render('rawatJalan.views.suratPerintahRawatInap.Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'caraPrint'=>$caraPrint, 'modSep'=>$modSep));
            // }
		}
	}

	public function actionViewTanpaKunjungan($id, $jenis) {
		$modelInfo = InformasisuratSrkSpriV::model()->findByAttributes(array(
			'surat_id'=>$id,
			'jenissurat'=>$jenis,
		));

		if (empty($modelInfo)) {
			echo "Data tidak ditemukan";
			Yii::app()->end();
		}

		if ($jenis == 1) {
			$modPendaftaran = RJPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modelInfo->pendaftaran_id));
			$model = SuratketeranganR::model()->findByPk($id);
			$pegawai = PegawaiM::model()->findByPk($modelInfo->pegawai_id);
			$model->nama_pegawai = $pegawai->namaLengkap;
			if (empty($model)){
				echo 'Surat Keterangan Rencana Kontrol Belum Ada';
				exit;
			}
			$judul = JenissuratM::model()->findByAttributes(array('jenissurat_id' => $model->jenissurat_id));
			$modPasien = InfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
			$modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id' => $modelInfo->ruangankontrol_id));
			$modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modelInfo->pendaftaran_id, 'kelompokdiagnosa_id' => 2,
				'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
			if (isset($modMorbiditas)) {
				$modDiagnosa = DiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modMorbiditas->diagnosa_id));
			} else {
				$modDiagnosa = array();
			}

			$modTambahan = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modelInfo->pendaftaran_id, 'kelompokdiagnosa_id' => 3,
				'ruangan_id' => $modelInfo->ruangan_id));




			// foreach($modDiagnosaTambahan as $diagnosa){
			//     echo print_r($diagnosa->diagnosa_nama).exit();
			// }
			//echo print_r($modDiagnosaTambahan).exit();

			$caraPrint = "PRINT";
			$judulLaporan = '';
				$this->layout = '//layouts/printWindows';
				$this->render('PrintRencanaKonsulTanpaKunjungan',
					array('modPendaftaran' => $modPendaftaran,
						'judul' => $judul,
						'caraPrint' => $caraPrint,
						'model' => $model,
						'modPasien' => $modPasien,
						'modRuangan' => $modRuangan,
						'judulLaporan' => $judulLaporan,
						'modDiagnosa' => $modDiagnosa,
						'modTambahan' => $modTambahan));
			
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

	public function actionCekVClaimSpesialis() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $html = '<option value="">-- Pilih --</option>';
        // $sep_id = $_POST['sep_id'];
        $no_kartu = $_POST['no_kartu'];
        $spesialis_id = $_POST['spesialis_id'];
        $tgl = MyFormatter::formatDateTimeForDB($_POST['tgl']);

        // $modSep = SepT::model()->findByPk($sep_id);
        $modSpesialis = SpesialissubspesialisM::model()->findByPk($spesialis_id);


        if (empty($modSpesialis)) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Data Spesialis tidak Ditemukan',
                'html'=>$html,
            ));
            Yii::app()->end();
        }

        // $no_kartu = $modSep->nokartuasuransi;

		// var_dump($no_kartu);die;
		if($no_kartu == '') {
			echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Mod Surat / No Kartu pasien tidak Ditemukan. Mod Surat / No Kartu pasien tidak boleh kosong',
                'html'=>$html,
            ));
            Yii::app()->end();
		}

        $bpjs = new Bpjs_Vklaim;
        $res = $bpjs->search_spesialtik_kontrol(1, $no_kartu, $tgl);

        if (!$res) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi kesalahan dalam pengecekan Ruangan VClaim',
                'html'=>$html,
            ));
            Yii::app()->end();
        }


        $res_json = CJSON::decode($res);
		if(isset($res_json['metaData'])) {
			if ($res_json['metaData']['code'] != 200) {
				echo CJSON::encode(array(
					'ok'=>0,
					'msg'=>$res_json['metaData']['message'],
					'html'=>$html,
				));
				Yii::app()->end();
			}
		} else {
			echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi kesalahan dalam pengecekan Ruangan VClaim [2]',
                'html'=>$html,
            ));
            Yii::app()->end();
		}

        $is_ada = false;
        foreach ($res_json['response']['list'] as $item) {
            if ($modSpesialis->spesialissubspesialis_kode == $item['kodePoli']) {
                $is_ada = true;


                break;
            }
        }

        if (!$is_ada) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Spesilis/Subspesialis tidak tersedia di BPJS',
                'html'=>$html,
            ));
            Yii::app()->end();
        }


        // DOKTER

        $peg = PegawaiM::model()->findAllByAttributes(array(
            'spesialissubspesialis_id'=>$modSpesialis->spesialissubspesialis_id
        ), array(
            'order'=>'nama_pegawai asc',
        ));

        $html = '<option value="">-- Pilih --</option>';

        foreach ($peg as $item) {
            $html .= '<option value="'.$item->pegawai_id.'">'.$item->namaLengkap.'</option>';
        }

        /*
        $bpjs = new Bpjs_Vklaim;
        $res = $bpjs->search_jadwal_dokter_kontrol(2, $modSpesialis->spesialissubspesialis_kode, $tgl);

        if (!$res) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi kesalahan dalam pengecekan Jadwal Dokter VClaim',
                'html'=>$html,
            ));
            Yii::app()->end();
        }



        $res_json = CJSON::decode($res);
        if ($res_json['metaData']['code'] != 200) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>$res_json['metaData']['message'],
                'html'=>$html,
            ));
            Yii::app()->end();
        }

        $is_ada = false;
        $html = '<option value="">-- Pilih --</option>';

        $peg_list = array();

        foreach ($res_json['response']['list'] as $item) {

            $peg = PegawaiM::model()->findByAttributes(array(
                'kodedokter_bpjs'=>$item['kodeDokter'],
            ));

            if (empty($peg)) {
                continue;
            }

            if (in_array($peg->pegawai_id, $peg_list)) {
                continue;
            }

            $peg_list[] = $peg->pegawai_id;

            $html .= '<option value="'.$peg->pegawai_id.'">'.$peg->namaLengkap.'</option>';

            //var_dump($item);
        }
        */






        echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'-',
            'html'=>$html,
        ));


    }

	public function actionHapusSurat() {
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}

		$modelInfo = InformasisuratSrkSpriV::model()->findByAttributes(array(
			'surat_id'=>$_POST['surat_id'],
			'jenissurat'=>$_POST['jenissurat'],
		));

		if (empty($modelInfo)) {
			echo CJSON::encode(array(
				'ok'=>0, 'msg'=>'Data tidak ditemukan.',
			));
			Yii::app()->end();
		}

		$modPendaftaran = PendaftaranT::model()->findByPk($modelInfo->pendaftaran_id);

		$ok = 1;
		$trans = Yii::app()->db->beginTransaction();
		$bpjs = new BpjsVklaim;

		try {
			if(!empty($modPendaftaran)) {
				if ($modelInfo->jenissurat == 1) {
					$modSurat = SuratketeranganR::model()->findByPk($modelInfo->surat_id);
	
					// update pendaftaran
					$modPendaftaran->tglrenkontrol = null;
					$modPendaftaran->ruangankontrol_id = null;
					$modPendaftaran->doktertujuankontrol_id = null;
					$modPendaftaran->save(false);
	
					// hapus surat dari bpjs
					if (!empty($modSurat->nomorsurat_bpjs)) {
						$res = $bpjs->hapus_rencana_kontrol($modSurat->nomorsurat_bpjs, "SYSADMIN");
						$resHapus = CJSON::decode($res);
						if($resHapus['metaData']['code'] == 200){
							$this->logBpjs($modPendaftaran, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}else{
							$this->logBpjs($modPendaftaran, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}
					}
	
					// hapus surat keterangan
					SuratketeranganR::model()->deleteByPk($modelInfo->surat_id);
				} else if ($modelInfo->jenissurat == 2) {
					$modSurat = SuratperintahranapT::model()->findByPk($modelInfo->surat_id);
	
					if (!empty($modSurat->nomorspri_bpjs)) {
						$res = $bpjs->hapus_rencana_kontrol($modSurat->nomorspri_bpjs, "SYSADMIN");
						$resHapus = CJSON::decode($res);
						if($resHapus['metaData']['code'] == 200){
							$this->logBpjs($modPendaftaran, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}else{
							$this->logBpjs($modPendaftaran, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}
					}
					// hapus surat keterangan
					SuratperintahranapT::model()->deleteByPk($modelInfo->surat_id);
				}
			} else {
				// hapus rencana kontrol tanpa kunjungan
				if ($modelInfo->jenissurat == 1) {
					$modSurat = SuratketeranganR::model()->findByPk($modelInfo->surat_id);

					// hapus surat dari bpjs
					if (!empty($modSurat->nomorsurat_bpjs)) {
						$res = $bpjs->hapus_rencana_kontrol($modSurat->nomorsurat_bpjs, "SYSADMIN");
						$resHapus = CJSON::decode($res);
						if($resHapus['metaData']['code'] == 200){
							$this->logBpjs($modSurat, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}else{
							$this->logBpjs($modSurat, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}
					}
	
					// hapus surat keterangan
					SuratketeranganR::model()->deleteByPk($modelInfo->surat_id);
				} else if ($modelInfo->jenissurat == 2) {
					$modSurat = SuratperintahranapT::model()->findByPk($modelInfo->surat_id);
	
					if (!empty($modSurat->nomorspri_bpjs)) {
						$res = $bpjs->hapus_rencana_kontrol($modSurat->nomorspri_bpjs, "SYSADMIN");
						$resHapus = CJSON::decode($res);
						if($resHapus['metaData']['code'] == 200){
							$this->logBpjs($modSurat, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}else{
							$this->logBpjs($modSurat, $resHapus, $bpjs->server_new['hapus_rencana_kontrol']);
						}
					}
					// hapus surat keterangan
					SuratperintahranapT::model()->deleteByPk($modelInfo->surat_id);
				}
			}



			$trans->commit();
			$msg = "Data berhasil di-hapus";

			echo CJSON::encode(array(
				'ok'=>$ok, 'msg'=>$msg,
			));

		} catch (Exception $e) {
			$trans->rollback();
			echo CJSON::encode(array(
				'ok'=>0, 'msg'=>'Data gagal dihapus. '.$e->getMessage(),
			));
		}
	}

	//save log bpjs
	function logBpjs($model, $reqSep, $api = null)
	{
		$log = new BpjslogR;
		$log->tgl_log = date('Y-m-d H:i:s');
		$log->code = $reqSep['metaData']['code'];
		$log->loginpemakai_id = Yii::app()->user->id;
		if (isset($reqSep['metaData']['message'])) {
			$log->pesan = $reqSep['metaData']['message'];
		}
		if (!empty($reqSep['request_vars'])) {
			$log->json_request_respose = $reqSep['request_vars'];
		}
		$log->pendaftaran_id = $model->pendaftaran_id ?? '';
		$request = Yii::app()->request;
		$ipAddress = $request->getUserHostAddress();
		$log->ip_address = $ipAddress;
		$log->api = $api;
		$log->save();
	}
}