<?php

/**
 * This is the model class for table "informasipenjualanresep_v".
 *
 * The followings are the available columns in table 'informasipenjualanresep_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $penjualanresep_id
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property double $totharganetto
 * @property double $totalhargajual
 * @property double $totaltarifservice
 * @property double $biayaadministrasi
 * @property double $biayakonseling
 * @property double $pembulatanharga
 * @property double $jasadokterresep
 * @property string $instalasiasal_nama
 * @property string $ruanganasal_nama
 * @property integer $pasienpegawai_id
 * @property integer $pasienprofilrs_id
 * @property integer $pasieninstalasiunit_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $gelardepan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglpenjualan
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property integer $lamapelayanan
 * @property integer $pasienadmisi_id
 * @property integer $reseptur_id
 * @property integer $pendaftaran_id
 * @property string $umur
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $photopasien
 * @property string $alamatemail
 * @property integer $antrianfarmasi_id
 * @property string $noantrian
 * @property boolean $panggilantrian
 * @property boolean $antrianlewat
 * @property string $tglambilantrian
 * @property integer $racikan_id
 * @property string $racikan_nama
 * @property string $racikan_singkatan
 * @property double $tarifservice
 * @property double $persenservice
 * @property double $biayakemasan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $gelarbelakang_nama
 */
class InformasipenjualanresepV extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasipenjualanresepV the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'informasipenjualanresep_v';
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, rt, rw, penjualanresep_id, pasienpegawai_id, pasienprofilrs_id, pasieninstalasiunit_id, pegawai_id, carabayar_id, penjamin_id, lamapelayanan, pasienadmisi_id, reseptur_id, pendaftaran_id, anakke, jumlah_bersaudara, antrianfarmasi_id, racikan_id, instalasi_id, ruangan_id', 'numerical', 'integerOnly' => true),
            array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, racikan_tarifservice, racikan_persenservice, racikan_biayakemasan', 'numerical'),
            array('no_rekam_medik, gelardepan', 'length', 'max' => 10),
            array('namadepan, jeniskelamin, no_pendaftaran, statusperkawinan, agama, rhesus, no_mobile_pasien, racikan_singkatan', 'length', 'max' => 20),
            array('nama_pasien, noresep, nama_pegawai, carabayar_nama, penjamin_nama, racikan_nama, instalasi_nama, ruangan_nama', 'length', 'max' => 50),
            array('nama_bin, umur', 'length', 'max' => 30),
            array('tempat_lahir, warga_negara', 'length', 'max' => 25),
            array('jenispenjualan, instalasiasal_nama, ruanganasal_nama, alamatemail', 'length', 'max' => 100),
            array('golongandarah', 'length', 'max' => 2),
            array('no_telepon_pasien, gelarbelakang_nama', 'length', 'max' => 15),
            array('photopasien', 'length', 'max' => 200),
            array('noantrian', 'length', 'max' => 6),
            array('tanggal_lahir, alamat_pasien, tglresep,jumlah_dipanggil, tglpenjualan, tgl_pendaftaran, panggilantrian, antrianlewat, tglambilantrian', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasien_id, no_rekam_medik, namadepan,jumlah_dipanggil, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, penjualanresep_id, jenispenjualan, tglresep, noresep, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, instalasiasal_nama, ruanganasal_nama, pasienpegawai_id, pasienprofilrs_id, pasieninstalasiunit_id, pegawai_id, nama_pegawai, gelardepan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tglpenjualan, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, lamapelayanan, pasienadmisi_id, reseptur_id, pendaftaran_id, umur, tgl_pendaftaran, no_pendaftaran, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, alamatemail, antrianfarmasi_id, noantrian, panggilantrian, antrianlewat, tglambilantrian, racikan_id, racikan_nama, racikan_singkatan, tarifservice, persenservice, biayakemasan, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, gelarbelakang_nama', 'safe', 'on' => 'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pasien_id' => 'Pasien',
            'no_rekam_medik' => 'No. Rekam Medik',
            'namadepan' => 'Nama Depan',
            'nama_pasien' => 'Nama Pasien',
            'nama_bin' => 'Nama Bin',
            'jeniskelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat_pasien' => 'Alamat Pasien',
            'rt' => 'RT',
            'rw' => 'RW',
            'jumlah_dipanggil' => 'Jumlah Dipanggil',
            'penjualanresep_id' => 'Penjualan Resep',
            'jenispenjualan' => 'Jenis Penjualan',
            'tglresep' => 'Tgl. Resep',
            'noresep' => 'No Resep',
            'totharganetto' => 'Total Harga Netto',
            'totalhargajual' => 'Total Harga Jual',
            'totaltarifservice' => 'Total Tarif Service',
            'biayaadministrasi' => 'Biaya Administrasi',
            'biayakonseling' => 'Biaya Konseling',
            'pembulatanharga' => 'Pembulatan Harga',
            'jasadokterresep' => 'Jasa Dokter Resep',
            'instalasiasal_nama' => 'Instalasi Asal',
            'ruanganasal_nama' => 'Ruangan Asal',
            'pasienpegawai_id' => 'Pasien Pegawai',
            'pasienprofilrs_id' => 'Pasien Profil RS',
            'pasieninstalasiunit_id' => 'Pasien Instalasi Unit',
            'pegawai_id' => 'Pegawai',
            'nama_pegawai' => 'Nama Pegawai',
            'gelardepan' => 'Gelar Depan',
            'carabayar_id' => 'Jenis Penjamin',
            'carabayar_nama' => 'Jenis Penjamin',
            'penjamin_id' => 'Penjamin',
            'penjamin_nama' => 'Penjamin',
            'tglpenjualan' => 'Tgl. Penjualan',
            'discount' => 'Keringanan',
            'subsidiasuransi' => 'Tanggungan Asuransi',
            'subsidipemerintah' => 'Tanggungan Pemerintah',
            'subsidirs' => 'Tanggungan Rumah Sakit',
            'iurbiaya' => 'Iur Biaya',
            'lamapelayanan' => 'Lama Pelayanan',
            'pasienadmisi_id' => 'Pasien Admisi',
            'reseptur_id' => 'Reseptur',
            'pendaftaran_id' => 'Pendaftaran',
            'umur' => 'Umur',
            'tgl_pendaftaran' => 'Tgl. Pendaftaran',
            'no_pendaftaran' => 'No. Pendaftaran',
            'statusperkawinan' => 'Status Perkawinan',
            'agama' => 'Agama',
            'golongandarah' => 'Golongan Darah',
            'rhesus' => 'Rhesus',
            'anakke' => 'Anak Ke',
            'jumlah_bersaudara' => 'Jumlah Bersaudara',
            'no_telepon_pasien' => 'No. Telepon Pasien',
            'no_mobile_pasien' => 'No. Handphone Pasien',
            'warga_negara' => 'Warga Negara',
            'photopasien' => 'Photo Pasien',
            'alamatemail' => 'Alamat Email',
            'antrianfarmasi_id' => 'Antrian Farmasi',
            'noantrian' => 'No. Antrian',
            'panggilantrian' => 'Panggil Antrian',
            'antrianlewat' => 'Antrian Lewat',
            'tglambilantrian' => 'Tgl. Ambil Antrian',
            'racikan_id' => 'Racikan Antrian',
            'racikan_nama' => 'Racikan Antrian',
            'racikan_singkatan' => 'Racikan Antrian Singkatan',
            'tarifservice' => 'Racikan Antrian Tarif Service',
            'persenservice' => 'Racikan Antrian Persen Service',
            'biayakemasan' => 'Racikan Antrian Biaya Kemasan',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan',
            'gelarbelakang_nama' => 'Gelar Belakang',
        );
    }
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('penjualanresep_id', $this->penjualanresep_id);
        $criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
        $criteria->compare('LOWER(tglresep)', strtolower($this->tglresep), true);
        $criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
        $criteria->compare('totharganetto', $this->totharganetto);
        $criteria->compare('totalhargajual', $this->totalhargajual);
        $criteria->compare('totaltarifservice', $this->totaltarifservice);
        $criteria->compare('biayaadministrasi', $this->biayaadministrasi);
        $criteria->compare('biayakonseling', $this->biayakonseling);
        $criteria->compare('pembulatanharga', $this->pembulatanharga);
        $criteria->compare('jasadokterresep', $this->jasadokterresep);
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        $criteria->compare('pasienpegawai_id', $this->pasienpegawai_id);
        $criteria->compare('pasienprofilrs_id', $this->pasienprofilrs_id);
        $criteria->compare('pasieninstalasiunit_id', $this->pasieninstalasiunit_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('LOWER(tglpenjualan)', strtolower($this->tglpenjualan), true);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('subsidiasuransi', $this->subsidiasuransi);
        $criteria->compare('subsidipemerintah', $this->subsidipemerintah);
        $criteria->compare('subsidirs', $this->subsidirs);
        $criteria->compare('iurbiaya', $this->iurbiaya);
        $criteria->compare('lamapelayanan', $this->lamapelayanan);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('reseptur_id', $this->reseptur_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('antrianfarmasi_id', $this->antrianfarmasi_id);
        $criteria->compare('LOWER(noantrian)', strtolower($this->noantrian), true);
        $criteria->compare('panggilantrian', $this->panggilantrian);
        $criteria->compare('antrianlewat', $this->antrianlewat);
        $criteria->compare('LOWER(tglambilantrian)', strtolower($this->tglambilantrian), true);
        $criteria->compare('racikan_id', $this->racikan_id);
        $criteria->compare('LOWER(racikan_nama)', strtolower($this->racikan_nama), true);
        $criteria->compare('LOWER(racikan_singkatan)', strtolower($this->racikan_singkatan), true);
        $criteria->compare('tarifservice', $this->tarifservice);
        $criteria->compare('persenservice', $this->persenservice);
        $criteria->compare('biayakemasan', $this->biayakemasan);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('penjualanresep_id', $this->penjualanresep_id);
        $criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
        $criteria->compare('LOWER(tglresep)', strtolower($this->tglresep), true);
        $criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
        $criteria->compare('totharganetto', $this->totharganetto);
        $criteria->compare('totalhargajual', $this->totalhargajual);
        $criteria->compare('totaltarifservice', $this->totaltarifservice);
        $criteria->compare('biayaadministrasi', $this->biayaadministrasi);
        $criteria->compare('biayakonseling', $this->biayakonseling);
        $criteria->compare('pembulatanharga', $this->pembulatanharga);
        $criteria->compare('jasadokterresep', $this->jasadokterresep);
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
        $criteria->compare('pasienpegawai_id', $this->pasienpegawai_id);
        $criteria->compare('pasienprofilrs_id', $this->pasienprofilrs_id);
        $criteria->compare('pasieninstalasiunit_id', $this->pasieninstalasiunit_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('LOWER(tglpenjualan)', strtolower($this->tglpenjualan), true);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('subsidiasuransi', $this->subsidiasuransi);
        $criteria->compare('subsidipemerintah', $this->subsidipemerintah);
        $criteria->compare('subsidirs', $this->subsidirs);
        $criteria->compare('iurbiaya', $this->iurbiaya);
        $criteria->compare('lamapelayanan', $this->lamapelayanan);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('reseptur_id', $this->reseptur_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('antrianfarmasi_id', $this->antrianfarmasi_id);
        $criteria->compare('LOWER(noantrian)', strtolower($this->noantrian), true);
        $criteria->compare('panggilantrian', $this->panggilantrian);
        $criteria->compare('antrianlewat', $this->antrianlewat);
        $criteria->compare('LOWER(tglambilantrian)', strtolower($this->tglambilantrian), true);
        $criteria->compare('racikan_id', $this->racikan_id);
        $criteria->compare('LOWER(racikan_nama)', strtolower($this->racikan_nama), true);
        $criteria->compare('LOWER(racikan_singkatan)', strtolower($this->racikan_singkatan), true);
        $criteria->compare('tarifservice', $this->tarifservice);
        $criteria->compare('persenservice', $this->persenservice);
        $criteria->compare('biayakemasan', $this->biayakemasan);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
