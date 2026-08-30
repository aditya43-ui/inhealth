<?php

class KPPegawaiM extends PegawaiM
{

	public $nama_pemakai;
	public $new_password;
	public $new_password_repeat;
	public $jenispendidikan;
	public $umur_bekerja;
	public $norekening;
	public $banknorekening;
	public $jabatan_nama;
	public $pangkat_nama;
	public $kelompokpegawai_nama;
	public $pendidikan_nama;
	public $jml_tanggungan,$latitude,$longitude;
    public $bln_periode;
    public $tgl_start, $tgl_sekarang;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
	public $tempPhoto;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		/**
		 * digunakan di modul Kepegawaian pelmar file kontrakPelamar.php
		 */
	   public function getGelarDepanItems(){
		   return LookupM::model()->findAllByAttributes(array('lookup_type'=>'gelardepan'), array('order'=>'lookup_name asc'));
	   }
	   public function getGelarBelakangItems(){
		   return  GelarbelakangM::model()->findAll('gelarbelakang_aktif = true order by gelarbelakang_nama asc');
	   }

	   public function getPropinsiItems(){
			return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true), array('order'=>'propinsi_nama asc'));
		}


	   public function getKabupatenItems($propinsi_id=null){
			if (!empty($propinsi_id)) {
				return KabupatenM::model()->findAllByAttributes (array('kabupaten_aktif'=>TRUE, 'propinsi_id'=>$propinsi_id), array('order'=>'kabupaten_nama asc'));
			} else if(!empty($this->propinsi_id)) {     
				return KabupatenM::model()->findAll('propinsi_id='.$this->propinsi_id.' order BY kabupaten_nama asc');
			} else {
				return array();
			}  
	   }
	   public function getKecamatanItems($kabupaten_id=null){
			if (!empty($kabupaten_id))
				return KecamatanM::model()->findAllByAttributes (array('kecamatan_aktif'=>TRUE, 'kabupaten_id'=>$kabupaten_id), array('order'=>'kecamatan_nama asc'));
			else
				return KecamatanM::model()->findAll('kecamatan_aktif=TRUE ORDER BY kecamatan_nama asc');
	   }
	   public function getKelurahanItems($kecamatan_id=null){
			// if (!empty($kecamatan_id))
				return KelurahanM::model()->findAllByAttributes (array('kelurahan_aktif'=>TRUE, 'kecamatan_id'=>$kecamatan_id),array('order'=>'kelurahan_nama asc'));
			// else
			// 	return KelurahanM::model()->findAll('kelurahan_aktif=TRUE ORDER BY kelurahan_nama asc');
	   }


	   public function getStatuskepemilikanrumahItems()
		{
			return StatuskepemilikanrumahM::model()->findAll('statuskepemilikanrumah_aktif=TRUE ORDER BY statuskepemilikanrumah_nama asc');
		}

	   public function getRumahSakitItems(){
			return ProfilrumahsakitM::model()->findAll();
		}
		
		
		public function getPendidikanItems(){
			return PendidikanM::model()->findAllByAttributes(array('pendidikan_aktif'=>TRUE), array('order'=>'pendidikan_nama asc'));
		}
		public function getPendKualifikasiItems($pendidikan_id=null){
			if (!empty($pendidikan_id)){
				return PendidikankualifikasiM::model()->findAllByAttributes (array('pendkualifikasi_aktif'=>TRUE, 'pendidikan_id'=>$pendidikan_id),array('order'=>'pendkualifikasi_nama asc'));
			} else if(!empty($this->pendidikan_id)) {
				return PendidikankualifikasiM::model()->findAllByAttributes (array('pendkualifikasi_aktif'=>TRUE, 'pendidikan_id'=>$this->pendidikan_id),array('order'=>'pendkualifikasi_nama asc'));
			}else{
				return array();
			}
		}
		public function getKelompokPegawaiItems($pendkualifikasi_id=null){
			if (!empty($pendkualifikasi_id)){
				$modPendKualifikasi = PendidikankualifikasiM::model()->findByPK($pendkualifikasi_id);
				return KelompokpegawaiM::model()->findAll("kelompokpegawai_id = ".$modPendKualifikasi->kelompokpegawai_id);
			} else if(!empty($this->pendkualifikasi_id)) {
				$modPendKualifikasi = PendidikankualifikasiM::model()->findByPK($this->pendkualifikasi_id);
				return KelompokpegawaiM::model()->findAll("kelompokpegawai_id = ".$modPendKualifikasi->kelompokpegawai_id);
			}else{
//				return array();
				return KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif IS TRUE ");
			}
		}
		public function getKelompokPegawaiItems_unfiltered($pendkualifikasi_id=null){
			$modPendKualifikasi = PendidikankualifikasiM::model()->findByPK($this->pendkualifikasi_id);
			return KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif IS TRUE ");
		}
		public function getJenisTenagaMedisItems(){
			return JenistenagamedisM::model()->findAllByAttributes(array('jenistenagamedis_aktif'=>TRUE), array('order'=>'tenagamedis_nama asc'));
		}
		
		public function getSukuItems(){
			return SukuM::model()->findAllByAttributes(array('suku_aktif'=>TRUE), array('order'=>'suku_nama asc'));
		}
		public function getKategoriPegawai(){
			return LookupM::model()->findAllByAttributes(array('lookup_type'=>'kategoripegawai','lookup_aktif'=>TRUE),array('order'=>'lookup_name asc'));
		}
		public function getStatusPegawai(){
			return LookupM::model()->findAllByAttributes(array('lookup_type'=>'statuspegawai','lookup_aktif'=>TRUE),array('order'=>'lookup_name asc'));
		}
		
		public function getPangkatItems(){
			return PangkatM::model()->findAllByAttributes(array('pangkat_aktif'=>true),array('order'=>'pangkat_nama asc'));
		}
		public function beforeSave() 
		{
			if($this->tgl_lahirpegawai===null || trim($this->tgl_lahirpegawai)=='')
			{
				$this->setAttribute('tgl_lahirpegawai', null);
				$this->setAttribute('tglditerima', null);
			}
			return parent::beforeSave();
		}        

		public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);               
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);		
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->order = 'pegawai_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
				));
	}

	public function search10PegawaiBaru()
	{
		$criteria=new CDbCriteria;
		$criteria->order = 'tglditerima DESC';
        $criteria->addCondition("tglditerima::date >= '".date('Y-m-01')."'");
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
				));
	}
    
    /**
     * Dipakai untuk Informasi Manpower
     * @return \CActiveDataProvider
     */
    public function searchPegawaiBulan() {
        $criteria = new CDbCriteria();
        
        $tgl_awal = date('Y-m-01', strtotime($this->bln_periode."-01"));
        $tgl_akhir = date('Y-m-t', strtotime($this->bln_periode."-01"));
        
        $criteria->select = '*, '
                . '(case when tglditerima is null then create_time else tglditerima end) as tgl_start, '
                . '(case when tglberhenti is null then current_date else tglberhenti end) as tgl_sekarang';
        
        $criteria->addCondition("(tglditerima is null or (tglditerima::date < '".$tgl_akhir."')) "
                . "and (tglberhenti is null or tglberhenti::date > '".$tgl_awal."')");
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
    }
	
	
	/**
	 * fungsi untuk print detail penggajian pegawai.
	 */
	public function searchPrintPenggajian(){
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('DATE(tgl_lahirpegawai)',$this->tgl_lahirpegawai);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
	}
        
        public function getSukuNama()
        {
            return isset($this->suku_id)?$this->suku->suku_nama:'';
        }
        
        public function getAksesRuangan()
        {
            $loginpemakai=LoginpemakaiK::model()->find("pegawai_id='$this->pegawai_id'");
           
            $login = new CDbCriteria();
            $login->with = array('ruangan');
            $login->addCondition('loginpemakai_id ='.$loginpemakai->loginpemakai_id);
            $login->order = 'ruangan.ruangan_nama ASC';
            return RuanganpemakaiK::model()->findAll($login);
        }
        
        public function getAksesModul()
        {
            $loginpemakai=LoginpemakaiK::model()->find("pegawai_id='$this->pegawai_id'");
           
            $login = new CDbCriteria();
            $login->with = array('modul');
            $login->addCondition('loginpemakai_id ='.$loginpemakai->loginpemakai_id);
            $login->order = 'modul.modul_nama ASC';
           return AksespenggunaK::model()->findAll($login);
        }
        
        public function getPtkpItems() {
            return PtkpM::model()->findAllByAttributes(array('berlaku'=>TRUE), array('order'=>'statusperkawinan, jmltanggunan asc'));
        }
        
        /**
        * 
        * @return \CActiveDataProvider
        */
       public function searchDashboardSIPSTRAkhir() {
           $criteria = new CDbCriteria;
           $criteria->select = [
               'nomorindukpegawai',
               'nama_pegawai',
               'masa_str',
               'masa_sip'
           ];
           $criteria->compare('pegawai_aktif',true);
           $criteria->addCondition(" masa_str IS NOT NULL OR masa_sip IS NOT NULL ");
           $criteria->addCondition(" ((masa_str - INTERVAL '6 DAY') <= '".date("Y-m-d")."') OR ((masa_sip - INTERVAL '6 DAY') <= '".date("Y-m-d")."') ");
           $criteria->limit = 10;

           return new CActiveDataProvider($this, array(
               'criteria' => $criteria,
               'pagination' => false,
               'sort' => [
                   'defaultOrder' => '(CASE WHEN (masa_str < masa_sip) THEN masa_str ELSE masa_sip END) ASC'
               ]
           ));
       }
}