<?php
Yii::import('laboratoriumPA.controllers.PendaftaranLaboratoriumController');
Yii::import('laboratoriumPA.models.*');
Yii::import('laboratoriumPA.views.pendaftaranLaboratorium');
class PendaftaranLaboratoriumAnatomiPPController extends PendaftaranLaboratoriumController
{
	
	public $pageTitle = 'Pendaftaran Pasien Laboratorium';
	public $path_view_pendaftaran = 'pendaftaranPenjadwalan.views.pendaftaranLaboratoriumPP.';
	
	/**
	* proses simpan / ubah data pasien
	* @param type $modPasien
	* @param type $post
	* @return type
	*/
	public function simpanPasien($modPasien, $post){
	   $format = new MyFormatter();
	   if(isset($post['pasien_id']) && (!empty($post['pasien_id']))){
		   $load = new $modPasien;
		   $modPasien = $load->findByPk($post['pasien_id']);
	   }
	   $modPasien->attributes = $post;
	   $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
	   $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
	   if(isset($post['tempPhoto'])){
		   $modPasien->photopasien = $post['tempPhoto'];
	   }
	   if(empty($modPasien->pasien_id)){
		   $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
		   $modPasien->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
		   $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
		   $modPasien->ispasienluar = FALSE;
		   $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
		   $modPasien->create_loginpemakai_id = Yii::app()->user->id;
		   $modPasien->create_time = date('Y-m-d H:i:s');
		   $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
	   }else{
		   $modPasien->update_loginpemakai_id = Yii::app()->user->id;
		   $modPasien->update_time = date('Y-m-d H:i:s');
	   }
	   $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
	   $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
	   if($modPasien->save()){
		   $this->pasientersimpan = true;
	   }

	   return $modPasien;
	}
	
	/**
	* proses simpan / ubah data pendaftaran
	* @return type
	*/
	public function simpanPendaftaran($model,$modPasien,$modRujukan,$modPenanggungJawab,$post, $postPasien, $postPenunjang, $modAsuransiPasien){
		$format = new MyFormatter();
		$model->attributes = $post;
		$model->pendaftaran_id = null;
		$model->pasien_id = $modPasien->pasien_id;
		$model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
		$model->rujukan_id = $modRujukan->rujukan_id;
		$model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
		if (empty($model->ruangan_id)){
			$model->ruangan_id = Params::RUANGAN_ID_LAB_KLINIK;
		}
		$model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
		if(count($postPenunjang) > 0){ //pegawai_id, jeniskasuspenyakit_id, kelaspelayanan_id dari salah satu form pasienmasukpenunjang
			foreach($postPenunjang AS $i=>$penunjang){
				if(!empty($penunjang['pegawai_id'])){
					$model->pegawai_id = $penunjang['pegawai_id'];
				}
				if(!empty($penunjang['jeniskasuspenyakit_id'])){
					$model->jeniskasuspenyakit_id = $penunjang['jeniskasuspenyakit_id'];
				}
				if(!empty($penunjang['kelaspelayanan_id'])){
					$model->kelaspelayanan_id = $penunjang['kelaspelayanan_id'];
				}
			}

		}
		$model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
		$model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
		$model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);            
		$model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
		$model->shift_id = Yii::app()->user->getState('shift_id');
		$model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
		$model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
		$model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
		$model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$model->create_loginpemakai_id = Yii::app()->user->id;
		$model->create_time = date("Y-m-d H:i:s");
		if(Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)){
			$model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
		}else{
			$model->tgl_pendaftaran = date("Y-m-d H:i:s");
		}
		$model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
		$model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
		$model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
		$model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
		$model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;

		if($model->save()){
			$this->pendaftarantersimpan = true;
		}
		return $model;
	}
}
