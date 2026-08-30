<?php
class LBPendaftaranMp extends PendaftaranT {
    /*
     * Variabel untuk pendaftaran pasien luar 
     */
    /** variable lama */
    public $adaKarcisLab = false;
    public $adaKarcisRad = false;
    public $isUpdatePasien = false;
    public $adaBiayaAdministrasi = false;
    public $noRekamMedik;
    public $tarifAdministrasi;
    public $pakeSample = false;
    public $isRujukan = false;
    public $isPasienLama = false;
    public $pakeAsuransi = false;
    public $adaPenanggungJawab = false;
    public $adaKarcis = false;
    
    /** variable baru */
    public $is_adapjpasien = 0;
    public $is_pasienrujukan = 0;
    public $is_adakarcis = 0;
    public $is_bayarkarcis = 0;
    public $is_pasienkecelakaan = 0;
    public $is_adasample = 0;
    public $dokter;
        
        
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
                    array('pegawai_id, kelaspelayanan_id, jeniskasuspenyakit_id, carabayar_id, penjamin_id, pasien_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statusperiksa, statuspasien, kunjungan, statusmasuk, umur, ruangan_id', 'required'), 
                    array('penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_urutantri', 'numerical', 'integerOnly'=>true),
                    array('no_pendaftaran', 'length', 'max'=>12),
                    array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk', 'length', 'max'=>50),
                    array('umur', 'length', 'max'=>30),
                    array('pegawai_id, alihstatus, byphone, kunjunganrumah, nopendaftaran_aktif', 'safe'),
                    array('pendaftaran_id, create_ruangan, kelompokumur_id, tglselesaiperiksa, tgl_konfirmasi, namaperusahaan, nopokokperusahaan, no_asuransi, nama_pemilikasuransi, kelastanggungan_id', 'safe'), // Untuk Pendaftaran Pasien Luar Lab
                    array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                    array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                    array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                    array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),

                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('pendaftaran_id, penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, create_time, upate_time, create_loginpemakai_id, upate_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tglrenkontrol,tglselesaiperiksa', 'safe', 'on'=>'search'),
            );
    }

    public function attributeLabels()
    {
            return array(
                    'pendaftaran_id' => 'Pendaftaran',
                    'penjamin_id' => 'Penjamin',
                    'caramasuk_id' => 'Cara masuk',
                    'carabayar_id' => 'Jenis Penjamin',
                    'pegawai_id' => 'Dokter Pemeriksa',
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
                    'namapemilik_asuransi' => 'Nama Pemilik Asuransi',
                    'nopokokperusahaan' => 'No. Pokok Perusahaan',
                    'kelastanggungan_id' => 'Kelas Tanggungan',
                    'namaperusahaan' => 'Nama Perusahaan',
                
                    'create_time' => 'Waktu Create',
                    'update_time' => 'update Time',
                    'create_loginpemakai_id' => 'Create Login Pemakai',
                    'update_loginpemakai_id' => 'Update Login Pemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'nopendaftaran_aktif' => 'Aktif',
            );
    }
    
    public function getRuanganItems($instalasiId='') 
    {
        $modRuangan = RuanganM::model()->findAll('(instalasi_id = '.Params::INSTALASI_ID_LAB.' OR instalasi_id = '.Params::INSTALASI_ID_RAD.' OR instalasi_id = '.Params::INSTALASI_ID_REHAB.') AND ruangan_aktif=true ORDER BY ruangan_nama');
        return $modRuangan;
    }
    
    public function getJeniskasuspenyakitItems() {
        return JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
    }
        
    public function getKelasPelayananItems()
    {
            return KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true ORDER BY kelaspelayanan_nama');
    }
        
    public function getDokterItems()
    {
            return DokterV::model()->findAll();
    }
        
    public function getCaraBayarItems()
    {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
    }
        
    public function getPenjaminItems()
    {
        return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
    }
    
    public function getAsalRujukanItems()
    {
            return AsalrujukanM::model()->findAll('asalrujukan_aktif=true ORDER BY asalrujukan_nama');
    }
        
    /**
    * Mengambil daftar semua ruangan
    * @return CActiveDataProvider 
    */
   public function getRuanganPenunjangItems()
   {
       $criteria = new CDbCriteria();
       $criteria->addCondition('ruangan_aktif = true');
       $criteria->order = "ruangan_nama";
       return RuanganpenunjangV::model()->findAll($criteria);
   }
   
}
?>
