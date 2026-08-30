<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RDPendaftaran extends PendaftaranT
{    
    public $kasusPenyakitNama;
    public $dokterNama;
    public $kelompokumurNama;
    public $kelompokumurId;
    public $penjaminNama;
    public $ruanganNama;
    public $tanggalAwal;
    public $tanggalAkhir;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PendaftaranRj the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('pegawai_id, pasien_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statusperiksa, statuspasien, kunjungan, 
                           statusmasuk, umur, ruangan_id, carabayar_id, penjamin_id, kelaspelayanan_id, jeniskasuspenyakit_id', 'required'),
                    array('penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_urutantri', 'numerical', 'integerOnly'=>true),
                    array('no_pendaftaran', 'length', 'max'=>20),
                    array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk', 'length', 'max'=>50),
                    array('umur', 'length', 'max'=>30),
                    array('pegawai_id, alihstatus, byphone, kunjunganrumah, nopendaftaran_aktif, no_asuransi, namapemilik_asuransi
                           nopokokperusahaan, kelastanggungan_id, namaperusahaan', 'safe'),
                
                    array('noRekamMedik, namaPasien, namaBin, alamat, propinsi, kabupaten, kecamatan, kelurahan, 
                           kasusPenyakitNama, dokterNama, kelompokumurNama, kelompokumurId, penjaminNama,
                           ruanganNama, tanggalAwal, tanggalAkhir','safe','on'=>'searchPasienPendaftaran'),
                
                    array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                    array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                    array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                    array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),

                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('pendaftaran_id, penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, create_time, upate_time, create_loginpemakai_id, upate_loginpemakai_id, create_ruangan, nopendaftaran_aktif', 'safe', 'on'=>'search'),
            );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'pendaftaran_id' => 'Pendaftaran',
                    'penjamin_id' => 'Penjamin',
                    'caramasuk_id' => 'Cara masuk',
                    'carabayar_id' => 'Jenis Penjamin',
                    'pegawai_id' => 'Dokter',
                
                    'pasien_id' => 'ID Pasien',
                    'shift_id' => 'Shift',
                    'golonganumur_id' => 'Golongan Umur',
                    'kelaspelayanan_id' => 'Kelas pelayanan',
                    'rujukan_id' => 'Rujukan',
                    'penanggungjawab_id' => 'Penanggungjawab',
                    'ruangan_id' => 'Ruangan',
                    'instalasi_id' => 'Instalasi',
                    'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
                    'no_pendaftaran' => 'No. Pendaftaran',
                    'tgl_pendaftaran' => 'Tgl. Pendaftaran',
                    'no_urutantri' => 'No. Urut Antri',
                    'transportasi' => 'Transportasi',
                    'keadaanmasuk' => 'Keadaan Masuk',
                    'statusperiksa' => 'Status Periksa',
                    'statuspasien' => 'Status Pasien',
                    'kunjungan' => 'Kunjungan',
                    'alihstatus' => 'Alih Status',
                    'byphone' => 'By Phone',
                    'kunjunganrumah' => 'Kunjungan Rumah',
                    'statusmasuk' => 'Status Masuk',
                    'umur' => 'Umur',
                    
                    'no_asuransi' => 'No. Asuransi',
                    'namapemilik_asuransi' => 'Pemilik Asuransi',
                    'nopokokperusahaan' => 'No. Pokok Perusahaan',
                    'kelastanggungan_id' => 'Kelas Tanggungan',
                    'namaperusahaan' => 'Nama Perusahaan',
                
                    'ruanganNama' => 'Ruangan',
                    'penjaminNama' => 'Penjamin',
                    'kelompokumurNama' => 'Kelompok Umur',
                    'kelompokumurId' => 'Kelompok Umur',
                    'kasusPenyakitNama' => 'Kasus Penyakit',
                    'dokterNama' => 'Dokter',
                    'create_time' => 'Waktu Create',
                    'update_time' => 'update Time',
                    'create_loginpemakai_id' => 'Create Login Pemakai',
                    'update_loginpemakai_id' => 'Update Login Pemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'nopendaftaran_aktif' => 'Aktif',
            );
    }
    
    public function searchPasienPendaftaran()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->with=array('pasien','penanggungJawab','jeniskasuspenyakit','dokter','penjamin','ruangan');
            $criteria->addCondition('ruangan.instalasi_id = '.Params::INSTALASI_ID_RD);
            $criteria->compare('LOWER(penjamin.penjamin_nama)',  strtolower($this->penjaminNama),true);
            $criteria->compare('LOWER(dokter.nama_pegawai)',  strtolower($this->dokterNama),true);
            $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)',  strtolower($this->kasusPenyakitNama),true);
            $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->noRekamMedik),true);
            $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->namaPasien),true);
            $criteria->compare('LOWER(pasien.nama_bin)',  strtolower($this->namaBin),true);
            $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat),true);
			if(!empty($this->kelompokumurId)){
				$criteria->addCondition("pasien.kelompokumur_id = ".$this->kelompokumurId);				
			}
			if(!empty($this->propinsi)){
				$criteria->addCondition("pasien.propinsi_id = ".$this->propinsi);				
			}
			if(!empty($this->kabupaten)){
				$criteria->addCondition("pasien.kabupaten_id = ".$this->kabupaten);				
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("pasien.kecamatan_id = ".$this->kecamatan_id);				
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("pasien.kelurahan_id = ".$this->kelurahan_id);				
			}
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);				
			}
			if(!empty($this->caramasuk_id)){
				$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id);				
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
			}
			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id);				
			}
			if(!empty($this->shift_id)){
				$criteria->addCondition("shift_id = ".$this->shift_id);				
			}
			if(!empty($this->golonganumur_id)){
				$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);				
			}
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
			}
			if(!empty($this->rujukan_id)){
				$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
			}
			if(!empty($this->penanggungjawab_id)){
				$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id);				
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);				
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
			}
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('no_urutantri',$this->no_urutantri);
            $criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
            $criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
            $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
            $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
            $criteria->compare('alihstatus',$this->alihstatus);
            $criteria->compare('byphone',$this->byphone);
            $criteria->compare('kunjunganrumah',$this->kunjunganrumah);
            $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
            $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
            $criteria->order = 'tgl_pendaftaran DESC';
            
            if((isset($this->tanggalAwal) && trim($this->tanggalAwal) != "") && (isset($this->tanggalAkhir) && trim($this->tanggalAkhir) != "")) {
                $format = new MyFormatter();
                $this->tanggalAwal = $format->formatDateTimeForDb($this->tanggalAwal);
                $this->tanggalAkhir = $format->formatDateTimeForDb($this->tanggalAkhir);
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', ''.$this->tanggalAwal.'', ''.$this->tanggalAkhir.'');
            }

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function getRuanganItems($instalasi_id=null)
    {
        if(!empty($instalasi_id)){
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
        }else {
            return RuanganM::model()->findAll(array('order'=>'ruangan_nama','condition'=>"instalasi_id IN (".Params::INSTALASI_ID_RJ.",".Params::INSTALASI_ID_RD.") AND ruangan_aktif = TRUE"));
        }
    }
    
    public function getDokterItems()
    {
        return DokterV::model()->findAll();

    }
    
    public function getDokterItemsInstalasi($instalasi_id=null)
    {
        if(!empty($instalasi_id)){
            return DokterV::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'nama_pegawai'));
        }else {
            return array();
        }
    }
    
     
}
?>
