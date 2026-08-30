<?php

class KPRegistrasifingerprint extends PegawaiM
{
        public $nipsampai, $namasampai, $jabatansampai, $pendidikan_nama, $jabatan_nama, $kelompokpegawai_nama, $pangkat_nama, $kelompoksampai, $alatfinger_id, $norekening, $banknorekening;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'jabatan'=>array(self::BELONGS_TO,'JabatanM','jabatan_id'),
                    'kelompokpegawai'=>array(self::BELONGS_TO, 'KelompokpegawaiM', 'kelompokpegawai_id'),
                    'pangkat'=>array(self::BELONGS_TO, 'PangkatM', 'pangkat_id'),
                    'pendidikan'=>array(self::BELONGS_TO, 'PendidikanM', 'pendidikan_id'),
                    'gelarbelakang'=>array(self::BELONGS_TO, 'GelarbelakangM', 'gelarbelakang_id'),
		);
	}
	
        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->join = "INNER JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id 
                    //       INNER JOIN pangkat_m ON pangkat_m.pangkat_id = t.pangkat_id
		//				   INNER JOIN pendidikan_m ON pendidikan_m.pendidikan_id = t.pendidikan_id";
                $criteria->with = array('jabatan');
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('t.jabatan_id',$this->jabatan_id);
		$criteria->compare('t.pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('t.pangkat_id',$this->pangkat_id);
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
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>array('pageSize'=>5),
		));
	}
        public function searchRegistrasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		$criteria->compare('pegawai_id',$this->pegawai_id);
//		$criteria->compare('kelurahan_id',$this->kelurahan_id);
//		$criteria->compare('kecamatan_id',$this->kecamatan_id);
//		$criteria->compare('profilrs_id',$this->profilrs_id);
//		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
//		$criteria->compare('suku_id',$this->suku_id);
//		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
//		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
                if(isset($this->alatfinger_id) && strlen($this->alatfinger_id) > 0)
                {
                    $criteria->addCondition('
                        pegawai_id NOT IN (SELECT pegawai_id FROM nofingeralat_m WHERE alatfinger_id = '. $this->alatfinger_id .')
                    ');
                }else{
                    $criteria->compare('pegawai_id','99889988');
                }
                
                if (!empty($this->jabatansampai)){
                    $criteria->addBetweenCondition('jabatan_id',$this->jabatan_id, $this->jabatansampai);
                }
                else{
                    $criteria->compare('jabatan_id',$this->jabatan_id);
                }
                if (!empty($this->nipsampai)){
                    $criteria->addBetweenCondition('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai), strtolower($this->nipsampai));
                }
                else{
                    $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
                }
                if (!empty($this->namasampai)){
                    $criteria->addBetweenCondition('LOWER(nama_pegawai)',strtolower($this->nama_pegawai), strtolower($this->namasampai));
                }
                else{
                    $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                }
                if (!empty($this->kelompoksampai)){
                    $criteria->addBetweenCondition('kelompokpegawai_id',strtolower($this->kelompokpegawai_id), strtolower($this->kelompoksampai));
                }
                else{
                    $criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
                }
//		$criteria->compare('pendidikan_id',$this->pendidikan_id);
//		$criteria->compare('propinsi_id',$this->propinsi_id);
//		$criteria->compare('pangkat_id',$this->pangkat_id);
//		$criteria->compare('kabupaten_id',$this->kabupaten_id);
//		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
//		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
//		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
//		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
//		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
//
//		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
//		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
//		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
//		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
//		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
//		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
//		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
//		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
//		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
//		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
//		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
//		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
//		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
//		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
//		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
//		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
//		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
//		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
//		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
//		$criteria->compare('esselon_id',$this->esselon_id);
//		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
//		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
//		$criteria->addCondition('nofingerprint is null');
//		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
//		$criteria->compare('tinggibadan',$this->tinggibadan);
//		$criteria->compare('beratbadan',$this->beratbadan);
//		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
//		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchInformasi()
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
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
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
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
                
                /*
		$criteria->addCondition('nofingerprint is not null');
		$criteria->addCondition("trim(nofingerprint) != ''");
                 * 
                 */
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                        'pagination'=>false,
		));
	}
        
        public function searchInformasiprint()
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
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
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
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
//		$criteria->addCondition('nofingerprint is not null');
//		$criteria->addCondition("trim(nofingerprint) != ''");
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                                                'pagination'=>false,
//                        'pagination'=>false,
		));
	}
        
        public function searchPegawaiAktif() {
        $criteria = new CDbCriteria;

        
        
        if (!empty($this->jabatansampai)) {
            $criteria->addBetweenCondition('t.jabatan_id', $this->jabatan_id, $this->jabatansampai);
        } else {
            $criteria->compare('t.jabatan_id', $this->jabatan_id);
        }
        if (!empty($this->nipsampai)) {
            $criteria->addBetweenCondition('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), strtolower($this->nipsampai));
        } else {
            $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        }
        if (!empty($this->namasampai)) {
            $criteria->addBetweenCondition('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), strtolower($this->namasampai));
        } else {
            $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        }
        if (!empty($this->kelompoksampai)) {
            $criteria->addBetweenCondition('t.kelompokpegawai_id', strtolower($this->kelompokpegawai_id), strtolower($this->kelompoksampai));
        } else {
            $criteria->compare('t.kelompokpegawai_id', $this->kelompokpegawai_id);
        }
         
        if (isset($this->alatfinger_id) && strlen($this->alatfinger_id) > 0) {
            $criteria->join = 'left join pegawaifinger_m f on f.pegawai_id = t.pegawai_id '
                    . 'and f.alatfinger_id = '.$this->alatfinger_id;
            
            $criteria->select = "t.*, f.alatfinger_id";
//            $criteria->addCondition('
//                        pegawai_id NOT IN (SELECT pegawai_id FROM nofingeralat_m WHERE alatfinger_id = ' . $this->alatfinger_id . ')
//                    ');
        } else {
            $criteria->compare('t.pegawai_id', '99889988');
        }
        
        $criteria->addCondition('pegawai_aktif = true');
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort'=>array(
                'defaultOrder'=>'t.nama_pegawai'
            )
        ));
    }
}