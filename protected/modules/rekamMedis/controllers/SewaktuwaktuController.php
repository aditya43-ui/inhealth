<?php

class SewaktuwaktuController extends MyAuthController
{
    public $layout='//layouts/column2';
    public $path_view = 'rekamMedis.views.sewaktuWaktu.';
    public $path_view_kerohanian = 'rekamMedis.views.sewaktuWaktu.pelayanankerohanian.';
    public $path_view_pasienkabur = 'rekamMedis.views.sewaktuWaktu.pasienkabur.';
    public $path_view_pendapatlain = 'rekamMedis.views.sewaktuWaktu.pendapatlain.';
    public $path_view_penolakanresusitasi = 'rekamMedis.views.sewaktuWaktu.penolakanresusitasi.';
    public $path_view_tidakresusitasi = 'rekamMedis.views.sewaktuWaktu.tidakresusitasi.';
    public $path_view_penundaankelambatan = 'rekamMedis.views.sewaktuWaktu.penundaankelambatan.';
    public $path_view_perintahtidakresusitasi = 'rekamMedis.views.sewaktuWaktu.perintahtidakresusitasi.';
    public $path_view_tindakanrestraint = 'rekamMedis.views.sewaktuWaktu.tindakanrestraint.';
    public $path_view_pelepasantindakanrestraint = 'rekamMedis.views.sewaktuWaktu.pelepasantindakanrestraint.';
    public $path_view_pemasanganrestraint = 'rekamMedis.views.sewaktuWaktu.pemasanganrestraint.';
    public $path_view_monitoringtransfusi = 'rekamMedis.views.sewaktuWaktu.monitoringtransfusi.';
    

	public function actionIndex()
	{
        $modKunjungan= new InfopasienpengunjungV;
        $this->render($this->path_view.'index',
        array( 
            'modKunjungan'=>$modKunjungan
        ));
    }

    public function actionIndexKerohanian($pendaftaran_id = null, $id = null)
	{
        $this->layout='//layouts/iframe';
		$model=new PelayanankerohanianT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);

        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
		$model->agama = $modPasien->agama;

       

		if(isset($_POST['PelayanankerohanianT']))
		{
			$model->attributes=$_POST['PelayanankerohanianT'];
            $bentuk_layanan = json_encode($_POST['PelayanankerohanianT']['bentuk_layanan']);
            $model->bentuk_layanan = $bentuk_layanan;
            $model->tgl_permintaan = !empty($model->tgl_permintaan) ? MyFormatter::formatdatetimefordb($model->tgl_permintaan) : null;
            $model->tgl_kedatangan_petugas = !empty($model->tgl_kedatangan_petugas) ? MyFormatter::formatdatetimefordb($model->tgl_kedatangan_petugas) : null;
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('indexKerohanian','pendaftaran_id'=>$model->pendaftaran_id, 'id'=>$model->pelayanankerohanian_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_kerohanian.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien
		));
	}

    public function actionIndexPasienKabur($pendaftaran_id = null, $id = null)
	{
        $this->layout='//layouts/iframe';
		$model=new BeritapasienkaburT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        

       

		if(isset($_POST['BeritapasienkaburT']))
		{
			$model->attributes=$_POST['BeritapasienkaburT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->tanggal_pengisian = !empty($model->tanggal_pengisian) ? MyFormatter::formatdatetimefordb($model->tanggal_pengisian) : null;

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('indexPasienKabur','pendaftaran_id'=>$model->pendaftaran_id, 'id'=>$model->beritapasienkabur_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_pasienkabur.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien
		));
	}

    public function actionIndexPendapatLain($pendaftaran_id = null, $formpendapatlain_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new FormpendapatlainT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($formpendapatlain_id){
            $model = FormpendapatlainT::model()->findByPK($formpendapatlain_id);
            $model->petugas_nama = $model->petugas->NamaLengkap;
            $model->inputdokter = $model->dokter_opinion;
        }

       
       

		if(isset($_POST['FormpendapatlainT']))
		{
			$model->attributes=$_POST['FormpendapatlainT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->tanggal_lahir = MyFormatter::formatdatetimefordb($model->tanggal_lahir);
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;

            if ($_POST['FormpendapatlainT']['is_luar'] == true){
                $model->dokter_opinion = $_POST['FormpendapatlainT']['inputdokter'];
                $model->is_luar = true;
            } else {
                $model->is_luar = false;
            }

            

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexPendapatLain','pendaftaran_id'=>$model->pendaftaran_id, 'formpendapatlain_id'=>$model->formpendapatlain_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_pendapatlain.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}

    public function actionIndexPenolakanResusitasi($pendaftaran_id = null, $tindakanresusitasi_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new TindakanresusitasiT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($tindakanresusitasi_id){
            $model = TindakanresusitasiT::model()->findByPK($tindakanresusitasi_id);
            $model->resusitasistatus = json_decode($model->resusitasistatus);
        }

       $modDiagnosa = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

       

		if(isset($_POST['TindakanresusitasiT']))
		{
			$model->attributes=$_POST['TindakanresusitasiT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->resusitasistatus = json_encode($_POST['TindakanresusitasiT']['resusitasistatus']);
            $model->diagnosaresusitasi = json_encode($_POST['TindakanresusitasiT']['diagnosaresusitasi']);


            

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexPenolakanResusitasi','pendaftaran_id'=>$model->pendaftaran_id, 'tindakanresusitasi_id'=>$model->tindakanresusitasi_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_penolakanresusitasi.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah,
            'modDiagnosa'=>$modDiagnosa
		));
	}


    public function actionIndexTidakResusitasi($pendaftaran_id = null, $tidakdilakukanresusitasi_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new TidakdilakukanresusitasiT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($tidakdilakukanresusitasi_id){
            $model = TidakdilakukanresusitasiT::model()->findByPK($tidakdilakukanresusitasi_id);
            $model->isikeputusan = json_decode($model->isikeputusan);
            $model->tanggal_lahir = MyFormatter::formatdatetimeforuser($model->tanggal_lahir);
            $model->nama_saksi2 = isset($model->saksi->NamaLengkap) ? $model->saksi->NamaLengkap : '';
        }


		if(isset($_POST['TidakdilakukanresusitasiT']))
		{
			$model->attributes=$_POST['TidakdilakukanresusitasiT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d G:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d G:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->isikeputusan = json_encode($_POST['TidakdilakukanresusitasiT']['isikeputusan']);
            $model->tanggal_lahir = MyFormatter::formatdatetimefordb($model->tanggal_lahir);

            

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexTidakResusitasi','pendaftaran_id'=>$model->pendaftaran_id, 'tidakdilakukanresusitasi_id'=>$model->tidakdilakukanresusitasi_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_tidakresusitasi.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}

    public function actionIndexPenundaanKelambatan($pendaftaran_id = null, $penundaandankelambatan_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new PenundaandankelambatanT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $model->unit = "RAWAT INAP";
        }else{
            $model->unit = $modPendaftaran->instalasi->instalasi_nama;
        }
        
        if ($penundaandankelambatan_id){
            $model = PenundaandankelambatanT::model()->findByPK($penundaandankelambatan_id);
            $model->petugas_nama = $model->petugas->NamaLengkap;
        }


		if(isset($_POST['PenundaandankelambatanT']))
		{
			$model->attributes=$_POST['PenundaandankelambatanT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d G:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d G:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->tanggal_pengisian = MyFormatter::formatdatetimefordb($model->tanggal_pengisian);

            

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexPenundaanKelambatan','pendaftaran_id'=>$model->pendaftaran_id, 'penundaandankelambatan_id'=>$model->penundaandankelambatan_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_penundaankelambatan.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}

    public function actionIndexPerintahTidakResusitasi($pendaftaran_id = null, $perintahsresusitasi_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new PerintahsresusitasiT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($perintahsresusitasi_id){
            $model = PerintahsresusitasiT::model()->findByPK($perintahsresusitasi_id);
            $model->tanggal_pengisian = MyFormatter::formatdatetimeforuser($model->tanggal_pengisian);
        }


		if(isset($_POST['PerintahsresusitasiT']))
		{
			$model->attributes=$_POST['PerintahsresusitasiT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d G:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d G:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->tanggal_pengisian = MyFormatter::formatdatetimefordb($model->tanggal_pengisian);

            

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexPerintahTidakResusitasi','pendaftaran_id'=>$model->pendaftaran_id, 'perintahsresusitasi_id'=>$model->perintahsresusitasi_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_perintahtidakresusitasi.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}
    

    public function actionIndexTindakanRestraint($pendaftaran_id = null, $observasirestrain_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new ObservasirestrainT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            $model->dokteryang_merawat = $modAdmisi->dokter->NamaLengkap;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            $model->dokteryang_merawat = $modPendaftaran->pegawai->NamaLengkap;
        }
        
        if ($observasirestrain_id){
            $model = ObservasirestrainT::model()->findByPK($observasirestrain_id);
            $model->tanggal_pengkajian = MyFormatter::formatdatetimeforuser($model->tanggal_pengkajian);
        }


		if(isset($_POST['ObservasirestrainT']))
		{
			$model->attributes=$_POST['ObservasirestrainT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d G:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d G:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->persetujuanolehdokter = json_encode($model->persetujuanolehdokter);
            $model->tanggal_pengkajian = MyFormatter::formatdatetimefordb($model->tanggal_pengkajian);
            

			if($model->save()){
                if (!empty($_POST['ObservasirestraindetT'])){
                    $hapusRiwayat = ObservasirestraindetT::model()->deleteAll('observasirestrain_id='.$model->observasirestrain_id.''); 
                }

                if(isset($_POST['ObservasirestraindetT'])){

                    

                    if (count($_POST['ObservasirestraindetT']) > 0){
                        
                        foreach($_POST['ObservasirestraindetT'] as $det){
                            $modDetail = new ObservasirestraindetT;
                            if ($modDetail->isNewRecord) {
                                $modDetail->create_time = date('Y-m-d G:i:s');
                                $modDetail->create_loginpemakai = Yii::app()->user->id;
                                $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            }
                            $modDetail->observasirestrain_id = $model->observasirestrain_id;
                            $modDetail->update_time = date('Y-m-d G:i:s');
                            $modDetail->update_loginpemakai = Yii::app()->user->id;
                            $modDetail->tiperestrain = $det['tiperestrain'];
                            $modDetail->lamarestrain = $det['lamarestrain'];
                            $modDetail->frekuensirestrain = $det['frekuensirestrain'];
                            $modDetail->save();
                        }
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexTindakanRestraint','pendaftaran_id'=>$model->pendaftaran_id, 'observasirestrain_id'=>$model->observasirestrain_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_tindakanrestraint.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}

    public function actionIndexPelepasanTindakanRestraint($pendaftaran_id = null, $pelepasanrestrain_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new PelepasanrestaintT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($pelepasanrestrain_id){
            $model = PelepasanrestaintT::model()->findByPK($pelepasanrestrain_id);
        }


		if(isset($_POST['PelepasanrestaintT']))
		{
			$model->attributes=$_POST['PelepasanrestaintT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d G:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d G:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->hasilobservasi = json_encode($model->hasilobservasi);
            $model->restrain_nonfarmotologi = json_encode($model->restrain_nonfarmotologi);
            

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexPelepasanTindakanRestraint','pendaftaran_id'=>$model->pendaftaran_id, 'pelepasanrestrain_id'=>$model->pelepasanrestrain_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_pelepasantindakanrestraint.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}

    public function actionIndexPemasanganRestraint($pendaftaran_id = null, $observasipemasanganrestrain_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new ObservasipemasanganrestrainT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($observasipemasanganrestrain_id){
            $model = ObservasipemasanganrestrainT::model()->findByPK($observasipemasanganrestrain_id);
            $model->tanggal = MyFormatter::formatdatetimeforuser($model->tanggal);
        }


		if(isset($_POST['ObservasipemasanganrestrainT']))
		{
			$model->attributes=$_POST['ObservasipemasanganrestrainT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d G:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d G:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->tanggal = MyFormatter::formatdatetimefordb($model->tanggal);
            

			if($model->save()){
                if (!empty($_POST['ObservasipemasanganrestraindetT'])){
                    $hapusRiwayat = ObservasipemasanganrestraindetT::model()->deleteAll('observasipemasanganrestrain_id='.$model->observasipemasanganrestrain_id.''); 
                }

                if(isset($_POST['ObservasipemasanganrestraindetT'])){

                    

                    if (count($_POST['ObservasipemasanganrestraindetT']) > 0){
                        
                        foreach($_POST['ObservasipemasanganrestraindetT'] as $det){
                            $modDetail = new ObservasipemasanganrestraindetT;
                            if ($modDetail->isNewRecord) {
                                $modDetail->create_time = date('Y-m-d G:i:s');
                                $modDetail->create_loginpemakai = Yii::app()->user->id;
                                $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            }
                            $modDetail->observasipemasanganrestrain_id = $model->observasipemasanganrestrain_id;
                            $modDetail->update_time = date('Y-m-d G:i:s');
                            $modDetail->update_loginpemakai = Yii::app()->user->id;
                            $modDetail->kes = $det['kes'];
                            $modDetail->td = $det['td'];
                            $modDetail->hr = $det['hr'];
                            $modDetail->rr = $det['rr'];
                            $modDetail->s = $det['s'];
                            if ($det['taka'] == 'true' || $det['taka'] == '1'){
                                $modDetail->taka = $det['taka'];    
                            }else{
                                $modDetail->taka = false;    
                            }
                            
                            if ($det['taki'] == 'true' || $det['taki'] == '1'){
                                $modDetail->taki = $det['taki'];    
                            }else{
                                $modDetail->taki = false;    
                            }

                            if ($det['kaka'] == 'true' || $det['kaka'] == '1'){
                                $modDetail->kaka = $det['kaka'];  
                            }else{
                                $modDetail->kaka = false;    
                            }

                            if ($det['kaki'] == 'true' || $det['kaki'] == '1'){
                                $modDetail->kaki = $det['kaki']; 
                            }else{
                                $modDetail->kaki = false;    
                            }
                            
                            $modDetail->luka = $det['luka'];
                            $modDetail->save();
                        }
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexPemasanganRestraint','pendaftaran_id'=>$model->pendaftaran_id, 'observasipemasanganrestrain_id'=>$model->observasipemasanganrestrain_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_pemasanganrestraint.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}

    public function actionIndexMonitoringTransfusi($pendaftaran_id = null, $monitoringtranfusidarah_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new MonitoringtranfusidarahT;
        $modSerahTerima =new SerahterimaT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($monitoringtranfusidarah_id){
            $model = MonitoringtranfusidarahT::model()->findByPK($monitoringtranfusidarah_id);
        }


		if(isset($_POST['MonitoringtranfusidarahT']))
		{
            // echo "<pre>";
            // echo print_r($_POST).exit();
			$model->attributes=$_POST['MonitoringtranfusidarahT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d G:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d G:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
			if($model->save()){
                
                // if (!empty($_POST['SerahterimaT'])){
                    $hapusRiwayat = SerahterimaT::model()->deleteAll('monitoringtranfusidarah_id='.$model->monitoringtranfusidarah_id.''); 
                // }

                if(isset($_POST['SerahterimaT'])){

                    

                    if (count($_POST['SerahterimaT']) > 0){
                        
                        foreach($_POST['SerahterimaT'] as $det){
                            $modDetail = new SerahterimaT;
                            if ($modDetail->isNewRecord) {
                                $modDetail->create_time = date('Y-m-d G:i:s');
                                $modDetail->create_loginpemakai = Yii::app()->user->id;
                                $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            }
                            $modDetail->monitoringtranfusidarah_id = $model->monitoringtranfusidarah_id;
                            $modDetail->update_time = date('Y-m-d G:i:s');
                            $modDetail->update_loginpemakai = Yii::app()->user->id;
                            $modDetail->nama_serahterima = $det['nama_serahterima'];
                            $modDetail->penjelasan = $det['penjelasan'];
                            $modDetail->petugas_bankdarah = $det['petugas_bankdarah'];
                            $modDetail->nama_perawat = $det['nama_perawat'];
                            $modDetail->is_petugasbankdarah = isset($det['is_petugasbankdarah']) ? $det['is_petugasbankdarah'] : false;
                            $modDetail->is_perawat = isset ($det['is_perawat']) ? $det['is_perawat'] : false;
                            $modDetail->save();
                        }
                    }
                }
                
                if (!empty($_POST['TransfusidarahT'])){
                    $hapusRiwayatTransfusi = TransfusidarahT::model()->deleteAll('monitoringtranfusidarah_id='.$model->monitoringtranfusidarah_id.''); 
                }

                if(isset($_POST['TransfusidarahT'])){
                    
                    

                    if (count($_POST['TransfusidarahT']) > 0){
                        
                        foreach($_POST['TransfusidarahT'] as $a => $det){
                            $modTransfusi = new TransfusidarahT;
                            if ($modTransfusi->isNewRecord) {
                                $modTransfusi->create_time = date('Y-m-d G:i:s');
                                $modTransfusi->create_loginpemakai = Yii::app()->user->id;
                                $modTransfusi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            }
                            $modTransfusi->monitoringtranfusidarah_id = $model->monitoringtranfusidarah_id;
                            $modTransfusi->update_time = date('Y-m-d G:i:s');
                            $modTransfusi->update_loginpemakai = Yii::app()->user->id;
                            $modTransfusi->waktu_transfusi = MyFormatter::formatdatetimefordb($det['waktu_transfusi']);
                            $modTransfusi->kondisi_transfusidarah = $det['kondisi_transfusidarah'];
                            $modTransfusi->deskripsi = $det['deskripsi'];
                            $modTransfusi->waktu_tranfusi = $det['waktu_tranfusi'];
                            $modTransfusi->petugas = $det['petugas'];
                            if (!empty($det['jam_transfusi'])){
                                $modTransfusi->jam_transfusi = isset($det['jam_transfusi']) ? $det['jam_transfusi'] : null;
                            }
                            
                            
                            
                            
                            if ($modTransfusi->save()){
                                // if (!empty($_POST['TransfusidarahdetT'])){
                                    $hapusRiwayatTransfusi = TransfusidarahdetT::model()->deleteAll('transfusidarah_id='.$modTransfusi->transfusidarah_id.''); 
                                // }
                
                                if(isset($_POST['TransfusidarahdetT'])){
                                    if (count($_POST['TransfusidarahdetT']) > 0){
                                        foreach($_POST['TransfusidarahdetT'] as $b => $det){
                                            if ($a == $b){
                                                foreach($det as $trandet){

                                                    if (!empty($trandet['tandareaksi'])){
                                                        $modTransfusidet = new TransfusidarahdetT;
                                                        if ($modTransfusidet->isNewRecord) {
                                                            $modTransfusidet->create_time = date('Y-m-d G:i:s');
                                                            $modTransfusidet->create_loginpemakai = Yii::app()->user->id;
                                                            $modTransfusidet->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                                        }
                                                        $modTransfusidet->monitoringtranfusidarah_id = $model->monitoringtranfusidarah_id;
                                                        $modTransfusidet->transfusidarah_id = $modTransfusi->transfusidarah_id;
                                                        $modTransfusidet->update_time = date('Y-m-d G:i:s');
                                                        $modTransfusidet->update_loginpemakai = Yii::app()->user->id;
                                                        $modTransfusidet->nama_tandareaksi = $trandet['tandareaksi'];
                                                        $modTransfusidet->save();
                                                    }
                                                    
                                                    
                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('IndexMonitoringTransfusi','pendaftaran_id'=>$model->pendaftaran_id, 'monitoringtranfusidarah_id'=>$model->monitoringtranfusidarah_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_monitoringtransfusi.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah,
            'modSerahTerima'=>$modSerahTerima
		));
	}

    public function actionDetailTindakanRestraint($pendaftaran_id = null, $observasirestrain_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new ObservasirestrainT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($observasirestrain_id){
            $model = ObservasirestrainT::model()->findByPK($observasirestrain_id);
            $model->tanggal_pengkajian = MyFormatter::formatdatetimeforuser($model->tanggal_pengkajian);
        }


		

		$this->render($this->path_view_tindakanrestraint.'detail',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}


    public function actionDetailPemasanganRestraint($pendaftaran_id = null, $observasipemasanganrestrain_id = null, $ubah = null)
	{
        $this->layout='//layouts/iframe';
		$model=new ObservasipemasanganrestrainT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($observasipemasanganrestrain_id){
            $model = ObservasipemasanganrestrainT::model()->findByPK($observasipemasanganrestrain_id);
        }


		

		$this->render($this->path_view_pemasanganrestraint.'detail',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'ubah'=>$ubah
		));
	}

    public function actionDetailSerahTerima($pendaftaran_id = null, $monitoringtranfusidarah_id = null)
	{
        $this->layout='//layouts/iframe';
		$model=new MonitoringtranfusidarahT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($monitoringtranfusidarah_id){
            $model = MonitoringtranfusidarahT::model()->findByPK($monitoringtranfusidarah_id);
        }


		

		$this->render($this->path_view_monitoringtransfusi.'detailSerahTerima',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien
		));
	}

    public function actionDetailTransfusi($pendaftaran_id = null, $monitoringtranfusidarah_id = null)
	{
        $this->layout='//layouts/iframe';
		$model=new MonitoringtranfusidarahT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPasien->tanggal_lahir = MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
        if ($monitoringtranfusidarah_id){
            $model = MonitoringtranfusidarahT::model()->findByPK($monitoringtranfusidarah_id);
        }


		

		$this->render($this->path_view_monitoringtransfusi.'detailTransfusi',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien
		));
	}

    public function actionUbahKerohanian($pendaftaran_id = null, $pelayanankerohanian_id = null)
	{
        $this->layout='//layouts/iframe';
		$model=new PelayanankerohanianT;
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);

        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
		$model->agama = $modPasien->agama;

        if (!empty($pelayanankerohanian_id)){
            $model = PelayanankerohanianT::model()->findByPk($pelayanankerohanian_id);
            $model->petugas_nama = isset($model->petugas->NamaLengkap) ? $model->petugas->NamaLengkap : '';
        }



		if(isset($_POST['PelayanankerohanianT']))
		{
			$model->attributes=$_POST['PelayanankerohanianT'];
            $bentuk_layanan = json_encode($_POST['PelayanankerohanianT']['bentuk_layanan']);
            $model->bentuk_layanan = $bentuk_layanan;
            $model->tgl_kedatangan_petugas = !empty($model->tgl_kedatangan_petugas) ? MyFormatter::formatdatetimefordb($model->tgl_kedatangan_petugas) : null;
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('indexKerohanian','pendaftaran_id'=>$model->pendaftaran_id, 'id'=>$model->pelayanankerohanian_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_kerohanian.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran
		));
	}

    public function actionUbahPasienKabur($pendaftaran_id = null, $beritapasienkabur_id = null)
	{
        $this->layout='//layouts/iframe';

        if (isset($beritapasienkabur_id)){
            $model= BeritapasienkaburT::model()->findByPk($beritapasienkabur_id);
            $model->petugas_nama_ruangan = $model->petugasRuangan->NamaLengkap;
            $model->petugas_nama = $model->petugas->NamaLengkap;
        }else{
            $model=new BeritapasienkaburT;
            
        }
		
        $modPendaftaran = PendaftaranT::model()->findByPK($pendaftaran_id);
        $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
        
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

        $model->pendaftaran_id = $pendaftaran_id;

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
        }
        
		if(isset($_POST['BeritapasienkaburT']))
		{
			$model->attributes=$_POST['BeritapasienkaburT'];
            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;
            $model->tanggal_pengisian = !empty($model->tanggal_pengisian) ? MyFormatter::formatdatetimefordb($model->tanggal_pengisian) : null;

			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('indexPasienKabur','pendaftaran_id'=>$model->pendaftaran_id, 'id'=>$model->beritapasienkabur_id));
            } else {
                Yii::app()->user->setFlash('Gagal', '<strong>Gagal!</strong> disimpan.');
            }
		}

		$this->render($this->path_view_pasienkabur.'create',array(
			'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien
		));
	}

    public function actionPrintKerohanian($pelayanankerohanian_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($pelayanankerohanian_id)){
            $model = PelayanankerohanianT::model()->findByPk($pelayanankerohanian_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $judul = "FORMULIR PERMINTAAN PELAYANAN KEROHANIAN";
        }
		$this->render($this->path_view_kerohanian.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul
        ));
    }

    public function actionPrintPasienKabur($beritapasienkabur_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($beritapasienkabur_id)){
            $model = BeritapasienkaburT::model()->findByPk($beritapasienkabur_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            }
            $judul = "BERITA ACARA PASIEN KABUR";
        }
		$this->render($this->path_view_pasienkabur.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul
        ));
    }

    public function actionPrintPendapatLain($formpendapatlain_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($formpendapatlain_id)){
            $model = FormpendapatlainT::model()->findByPk($formpendapatlain_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            }
            $judul = "FORM PERSETUJUAN PERMINTAAN PENDAPAT LAIN <br> (SECOND OPINION)";
        }
		$this->render($this->path_view_pendapatlain.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul
        ));
    }

    public function actionPrintPenolakanResusitasi($tindakanresusitasi_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($tindakanresusitasi_id)){
            $model = TindakanresusitasiT::model()->findByPk($tindakanresusitasi_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            }
            $judul = "PENOLAKAN, MENUNDA, ATAU MELEPAS TINDAKAN RESUSITASI/ BANTUAN HIDUP DASAR";
        }
		$this->render($this->path_view_penolakanresusitasi.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul
        ));
    }

    public function actionPrintTidakResusitasi($tidakdilakukanresusitasi_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($tidakdilakukanresusitasi_id)){
            $model = TidakdilakukanresusitasiT::model()->findByPk($tidakdilakukanresusitasi_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
                $modAdmisi = array();
            }
            $judul = "FORMULIR PERNYATAAN UNTUK TIDAK DILAKUKAN RESUSITASI (DO NO ATTEMPT RESUSCITATION)";
        }
		$this->render($this->path_view_tidakresusitasi.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul,
                'modAdmisi'=>$modAdmisi
        ));
    }

    public function actionPrintPenundaanKelambatan($penundaandankelambatan_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($penundaandankelambatan_id)){
            $model = PenundaandankelambatanT::model()->findByPk($penundaandankelambatan_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modDiagnosa = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
                $modAdmisi = array();
            }
            $judul = "INFORMASI PENUNDAAN DAN KELAMBATAN PELAYANAN";
        }
		$this->render($this->path_view_penundaankelambatan.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul,
                'modAdmisi'=>$modAdmisi,
                'modDiagnosa'=>$modDiagnosa
        ));
    }

    public function actionPrintPerintahTidakResusitasi($perintahsresusitasi_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($perintahsresusitasi_id)){
            $model = PerintahsresusitasiT::model()->findByPk($perintahsresusitasi_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
                $modAdmisi = array();
            }
            $judul = "FORMULIR PERINTAH UNTUK TIDAK DILAKUKAN RESUSITASI (DO NOT ATTEMPT RESUSCITATION)";
        }
		$this->render($this->path_view_perintahtidakresusitasi.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul,
                'modAdmisi'=>$modAdmisi
        ));
    }

    public function actionPrintTindakanRestraint($observasirestrain_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($observasirestrain_id)){
            $model = ObservasirestrainT::model()->findByPk($observasirestrain_id);
            $modDetail = ObservasirestraindetT::model()->findAllByAttributes(array('observasirestrain_id'=>$observasirestrain_id));
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
                $modAdmisi = array();
            }
            $judul = "LEMBAR OBSERVASI DAN PERSETUJUAN TINDAKAN RESTRAINT";
        }
		$this->render($this->path_view_tindakanrestraint.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul,
                'modAdmisi'=>$modAdmisi,
                'modDetail'=>$modDetail
        ));
    }

    public function actionPrintPelepasanTindakanRestraint($pelepasanrestrain_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($pelepasanrestrain_id)){
            $model = PelepasanrestaintT::model()->findByPk($pelepasanrestrain_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
                $modAdmisi = array();
            }
            $judul = "OBSERVASI RESTRAINT DAN PERSETUJUAN PELEPASAN";
        }
		$this->render($this->path_view_pelepasantindakanrestraint.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul,
                'modAdmisi'=>$modAdmisi
        ));
    }

    public function actionPrintMonitoringTransfusi($monitoringtranfusidarah_id){
        $this->layout='//layouts/printWindows';
        
        if (!empty($monitoringtranfusidarah_id)){
            $model = MonitoringtranfusidarahT::model()->findByPk($monitoringtranfusidarah_id);
            $modSerahTerima = SerahterimaT::model()->findAllByAttributes(array('monitoringtranfusidarah_id' => $monitoringtranfusidarah_id));
            $modTransfusi = TransfusidarahT::model()->findAllByAttributes(array('monitoringtranfusidarah_id' => $monitoringtranfusidarah_id));
            $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if ($modPendaftaran->pasienadmisi_id){
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
            }else{
                $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
                $modAdmisi = array();
            }
            $judul = "MONITORING TRANSFUSI DARAH/ PRODUK DARAH";
        }
		$this->render($this->path_view_monitoringtransfusi.'print',
        array('model'=>$model,
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul,
                'modAdmisi'=>$modAdmisi,
                'modSerahTerima'=>$modSerahTerima,
                'modTransfusi'=>$modTransfusi
        ));
    }
    
    public function actionPrintPemasanganRestraint($pendaftaran_id){
        $model = ObservasipemasanganrestrainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            // $modDetail = ObservasipemasanganrestraindetT::model()->findAllByPk($observasipemasanganrestrain_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $judul = "LEMBAR OBSERVASI PEMASANGAN RESTRAINT";

        if ($modPendaftaran->pasienadmisi_id){
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
        }else{
            $modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
            $modAdmisi = array();
        }
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view_pemasanganrestraint.'print',
            array('model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'judul'=>$judul,
                    'modAdmisi'=>$modAdmisi,
                    // 'modDetail'=>$modDetail
            ));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view_pemasanganrestraint . 'print', array('model'=>$model,
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'judul'=>$judul,
                    'modAdmisi'=>$modAdmisi,
                    // 'modDetail'=>$modDetail
            ), true));
            $mpdf->Output();
        }
        
		
    }
    

    public function actionHapusKerohanian(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            PelayanankerohanianT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusPasienKabur(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            BeritapasienkaburT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusPendapatLain(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            FormpendapatlainT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusPenolakanResusitasi(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            TindakanresusitasiT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusTidakResusitasi(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            TidakdilakukanresusitasiT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusPenundaanKelambatan(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            PenundaandankelambatanT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusPerintahTidakResusitasi(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            PerintahsresusitasiT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusTindakanRestraint(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            ObservasirestrainT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }
    
    public function actionHapusPelepasanTindakanRestraint(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            PelepasanrestaintT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }

    public function actionHapusPemasanganRestraint(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            ObservasipemasanganrestrainT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }
    
    public function actionHapusMonitoringTransfusi(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";
        
        try {
            $id = $_POST['id'];
            MonitoringtranfusidarahT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. ".$ex->getMessage();
        }
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
        ));
    }
    

    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();
            $model = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            $pasien = PasienM::model()->findByPk($model->pasien_id);
            $jenispenyakit = JeniskasuspenyakitM::model()->findByPk($model->jeniskasuspenyakit_id);
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                $returnVal['no_rekam_medik'] = $pasien->no_rekam_medik;
                $returnVal['nama_pasien'] = $pasien->nama_pasien;
                $returnVal['jeniskelamin'] = $pasien->jeniskelamin;
                $returnVal['jeniskasuspenyakit_nama'] = $jenispenyakit->jeniskasuspenyakit_nama;
                $returnVal['carabayar_nama'] = $model->carabayar->carabayar_nama;
                $returnVal['penanggungJawab'] = $model->pegawai->NamaLengkap;
                $returnVal['penjamin_nama'] = $model->penjamin->penjamin_nama;
                
                
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function getUrlPelayananKerohanian(){
        return $this->module->id.'/Sewaktuwaktu/IndexKerohanian';
    }

    public function getUrlBeritaPasienKabur(){
        return $this->module->id.'/Sewaktuwaktu/IndexPasienKabur';
    }

    public function getUrlPendapatLain(){
        return $this->module->id.'/Sewaktuwaktu/IndexPendapatLain';
    }

    public function getUrlPenolakanResusitasi(){
        return $this->module->id.'/Sewaktuwaktu/IndexPenolakanResusitasi';
    }

    public function getUrlTidakResusitasi(){
        return $this->module->id.'/Sewaktuwaktu/IndexTidakResusitasi';
    }

    public function getUrlPenundaanKelambatan(){
        return $this->module->id.'/Sewaktuwaktu/IndexPenundaanKelambatan';
    }

    public function getUrlPerintahTidakResusitasi(){
        return $this->module->id.'/Sewaktuwaktu/IndexPerintahTidakResusitasi';
    }
    
    public function getUrlTindkanRestraint(){
        return $this->module->id.'/Sewaktuwaktu/IndexTindakanRestraint';
    }

    public function getUrlPelepasanTindkanRestraint(){
        return $this->module->id.'/Sewaktuwaktu/IndexPelepasanTindakanRestraint';
    }

    public function getUrlPemasanganRestraint(){
        return $this->module->id.'/Sewaktuwaktu/IndexPemasanganRestraint';
    }

    public function getUrlMonitoringTransfusi(){
        return $this->module->id.'/Sewaktuwaktu/IndexMonitoringTransfusi';
    }
    
    public function getURLPengkajianJiwa(){
        return "/rekamMedis/pengkajianJiwa/index";
    }
    

	public function actionGetPegawai()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai ASC';
			$models = RKPegawaiM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]['label'] = $model->NamaLengkap;
					$returnVal[$i]['value'] = $model->NamaLengkap;
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
			}

			echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionAutocompleteKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
           // $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
           // $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            $criteria->with = array('pasien');
           // $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($nama_pasien), true);
          //  $criteria->addCondition('ruangan_id = '.$ruangan_id);
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = RKPendaftaranT::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran."-".$model->pasien->no_rekam_medik.'-'.$model->pasien->nama_pasien.(!empty($model->pasien->nama_bin) ? "(".$model->pasien->nama_bin.")" : "");
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }


	public function actionAjaxTambahRowUpload() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $str = $this->renderPartial($this->path_view_monitoringtransfusi.'_row', array(
            'model'=>new TransfusidarahT(),
            'counter' => $_POST['counter'],
        ), true);
        
        echo CJSON::encode(array(
            'html'=>$str,
        ));
    }
}