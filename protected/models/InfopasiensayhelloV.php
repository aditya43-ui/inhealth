<?php

/**
 * This is the model class for table "infopasiensayhello_v".
 *
 * The followings are the available columns in table 'infopasiensayhello_v':
 * @property integer $pasien_id
 * @property integer $profilrs_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $tempat_lahir
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property string $ruanganakhir_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $pasienpulang_id
 * @property string $penerimapasien
 * @property string $tglpasienpulang
 * @property integer $lamarawat
 * @property string $satuanlamarawat
 * @property string $keterangankeluar
 * @property integer $carakeluar_id
 * @property string $carakeluar_nama
 * @property integer $kondisikeluar_id
 * @property string $kondisikeluar_nama
 * @property integer $pasiensayhello_id
 * @property string $pasiensayhello_tgl
 * @property string $pasiensayhello_media
 * @property string $pasiensayhello_deskripsi
 * @property string $pasiensayhello_kritik
 * @property string $pasiensayhello_saran
 * @property integer $petugassayhello_id
 * @property integer $mengetahuisayhello_id
 * @property string $sayhello_createtime
 * @property string $sayhello_updatetime
 * @property integer $sayhello_ruangan_id
 * @property string $sayhello_create_login
 * @property string $sayhello_update_login
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 */
class InfopasiensayhelloV extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InfopasiensayhelloV the static model class
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
        return 'infopasiensayhello_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, profilrs_id, rt, rw, pendaftaran_id, pasienadmisi_id, instalasi_id, pasienpulang_id, lamarawat, carakeluar_id, kondisikeluar_id, pasiensayhello_id, petugassayhello_id, mengetahuisayhello_id, sayhello_ruangan_id', 'numerical', 'integerOnly' => true),
            array('no_rekam_medik, diagnosa_kode', 'length', 'max' => 10),
            array('namadepan, jeniskelamin, statusperkawinan, agama, no_mobile_pasien, no_pendaftaran, pasiensayhello_media, sayhello_create_login, sayhello_update_login', 'length', 'max' => 20),
            array('nama_pasien, nama_ibu, nama_ayah, ruangan_nama, instalasi_nama, satuanlamarawat', 'length', 'max' => 50),
            array('nama_bin', 'length', 'max' => 30),
            array('tempat_lahir', 'length', 'max' => 25),
            array('no_telepon_pasien', 'length', 'max' => 15),
            array('photopasien, diagnosa_nama', 'length', 'max' => 200),
            array('alamatemail, penerimapasien, carakeluar_nama, kondisikeluar_nama, pasiensayhello_kritik, pasiensayhello_saran', 'length', 'max' => 100),
            array('tanggal_lahir, alamat_pasien, tgl_pendaftaran, tgladmisi, ruanganakhir_id, tglpasienpulang, keterangankeluar, pasiensayhello_tgl, pasiensayhello_deskripsi, sayhello_createtime, sayhello_updatetime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pasien_id, profilrs_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tanggal_lahir, alamat_pasien, rt, rw, tempat_lahir, statusperkawinan, agama, no_telepon_pasien, no_mobile_pasien, photopasien, alamatemail, nama_ibu, nama_ayah, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasienadmisi_id, tgladmisi, ruanganakhir_id, ruangan_nama, instalasi_id, instalasi_nama, pasienpulang_id, penerimapasien, tglpasienpulang, lamarawat, satuanlamarawat, keterangankeluar, carakeluar_id, carakeluar_nama, kondisikeluar_id, kondisikeluar_nama, pasiensayhello_id, pasiensayhello_tgl, pasiensayhello_media, pasiensayhello_deskripsi, pasiensayhello_kritik, pasiensayhello_saran, petugassayhello_id, mengetahuisayhello_id, sayhello_createtime, sayhello_updatetime, sayhello_ruangan_id, sayhello_create_login, sayhello_update_login, diagnosa_kode, diagnosa_nama', 'safe', 'on' => 'search'),
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
            'profilrs_id' => 'Profilrs',
            'no_rekam_medik' => 'No. Rekam Medik',
            'namadepan' => 'Namadepan',
            'nama_pasien' => 'Nama Pasien',
            'nama_bin' => 'Nama Bin',
            'jeniskelamin' => 'Jenis Kelamin',
            'tanggal_lahir' => 'Tgl. Lahir',
            'alamat_pasien' => 'Alamat',
            'rt' => 'RT',
            'rw' => 'RW',
            'tempat_lahir' => 'Tempat Lahir',
            'statusperkawinan' => 'Status Perkawinan',
            'agama' => 'Agama',
            'no_telepon_pasien' => 'No Telp',
            'no_mobile_pasien' => 'No Mobile',
            'photopasien' => 'Photopasien',
            'alamatemail' => 'Email',
            'nama_ibu' => 'Nama Ibu',
            'nama_ayah' => 'Nama Ayah',
            'pendaftaran_id' => 'Pendaftaran',
            'no_pendaftaran' => 'No. Pendaftaran',
            'tgl_pendaftaran' => 'Tgl. Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'tgladmisi' => 'Tgl. Admisi',
            'ruanganakhir_id' => 'Ruanganakhir',
            'ruangan_nama' => 'Ruangan',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'pasienpulang_id' => 'Pasienpulang',
            'penerimapasien' => 'Penerimapasien',
            'tglpasienpulang' => 'Tgl. Pasien Pulang',
            'lamarawat' => 'Lamarawat',
            'satuanlamarawat' => 'Satuanlamarawat',
            'keterangankeluar' => 'Keterangankeluar',
            'carakeluar_id' => 'Carakeluar',
            'carakeluar_nama' => 'Cara Pulang',
            'kondisikeluar_id' => 'Kondisikeluar',
            'kondisikeluar_nama' => 'Kondisi Pulang',
            'pasiensayhello_id' => 'Pasiensayhello',
            'pasiensayhello_tgl' => 'Pasiensayhello Tgl',
            'pasiensayhello_media' => 'Pasiensayhello Media',
            'pasiensayhello_deskripsi' => 'Pasiensayhello Deskripsi',
            'pasiensayhello_kritik' => 'Pasiensayhello Kritik',
            'pasiensayhello_saran' => 'Pasiensayhello Saran',
            'petugassayhello_id' => 'Petugassayhello',
            'mengetahuisayhello_id' => 'Mengetahuisayhello',
            'sayhello_createtime' => 'Sayhello Createtime',
            'sayhello_updatetime' => 'Sayhello Updatetime',
            'sayhello_ruangan_id' => 'Sayhello Ruangan',
            'sayhello_create_login' => 'Sayhello Create Login',
            'sayhello_update_login' => 'Sayhello Update Login',
            'diagnosa_kode' => 'Diagnosa Kode',
            'diagnosa_nama' => 'Diagnosa Nama',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->pasien_id)) {
            $criteria->addCondition('pasien_id = ' . $this->pasien_id);
        }
        if (!empty($this->profilrs_id)) {
            $criteria->addCondition('profilrs_id = ' . $this->profilrs_id);
        }
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        if (!empty($this->rt)) {
            $criteria->addCondition('rt = ' . $this->rt);
        }
        if (!empty($this->rw)) {
            $criteria->addCondition('rw = ' . $this->rw);
        }
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(nama_ibu)', strtolower($this->nama_ibu), true);
        $criteria->compare('LOWER(nama_ayah)', strtolower($this->nama_ayah), true);
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        if (!empty($this->pasienadmisi_id)) {
            $criteria->addCondition('pasienadmisi_id = ' . $this->pasienadmisi_id);
        }
        $criteria->compare('LOWER(tgladmisi)', strtolower($this->tgladmisi), true);
        $criteria->compare('LOWER(ruanganakhir_id)', strtolower($this->ruanganakhir_id), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        if (!empty($this->pasienpulang_id)) {
            $criteria->addCondition('pasienpulang_id = ' . $this->pasienpulang_id);
        }
        $criteria->compare('LOWER(penerimapasien)', strtolower($this->penerimapasien), true);
        $criteria->compare('LOWER(tglpasienpulang)', strtolower($this->tglpasienpulang), true);
        if (!empty($this->lamarawat)) {
            $criteria->addCondition('lamarawat = ' . $this->lamarawat);
        }
        $criteria->compare('LOWER(satuanlamarawat)', strtolower($this->satuanlamarawat), true);
        $criteria->compare('LOWER(keterangankeluar)', strtolower($this->keterangankeluar), true);
        if (!empty($this->carakeluar_id)) {
            $criteria->addCondition('carakeluar_id = ' . $this->carakeluar_id);
        }
        $criteria->compare('LOWER(carakeluar_nama)', strtolower($this->carakeluar_nama), true);
        if (!empty($this->kondisikeluar_id)) {
            $criteria->addCondition('kondisikeluar_id = ' . $this->kondisikeluar_id);
        }
        $criteria->compare('LOWER(kondisikeluar_nama)', strtolower($this->kondisikeluar_nama), true);
        if (!empty($this->pasiensayhello_id)) {
            $criteria->addCondition('pasiensayhello_id = ' . $this->pasiensayhello_id);
        }
        $criteria->compare('LOWER(pasiensayhello_tgl)', strtolower($this->pasiensayhello_tgl), true);
        $criteria->compare('LOWER(pasiensayhello_media)', strtolower($this->pasiensayhello_media), true);
        $criteria->compare('LOWER(pasiensayhello_deskripsi)', strtolower($this->pasiensayhello_deskripsi), true);
        $criteria->compare('LOWER(pasiensayhello_kritik)', strtolower($this->pasiensayhello_kritik), true);
        $criteria->compare('LOWER(pasiensayhello_saran)', strtolower($this->pasiensayhello_saran), true);
        if (!empty($this->petugassayhello_id)) {
            $criteria->addCondition('petugassayhello_id = ' . $this->petugassayhello_id);
        }
        if (!empty($this->mengetahuisayhello_id)) {
            $criteria->addCondition('mengetahuisayhello_id = ' . $this->mengetahuisayhello_id);
        }
        $criteria->compare('LOWER(sayhello_createtime)', strtolower($this->sayhello_createtime), true);
        $criteria->compare('LOWER(sayhello_updatetime)', strtolower($this->sayhello_updatetime), true);
        if (!empty($this->sayhello_ruangan_id)) {
            $criteria->addCondition('sayhello_ruangan_id = ' . $this->sayhello_ruangan_id);
        }
        $criteria->compare('LOWER(sayhello_create_login)', strtolower($this->sayhello_create_login), true);
        $criteria->compare('LOWER(sayhello_update_login)', strtolower($this->sayhello_update_login), true);
        $criteria->compare('LOWER(diagnosa_kode)', strtolower($this->diagnosa_kode), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);

        return $criteria;
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
}
