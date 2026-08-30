<?php

/**
 * This is the model class for table "infostokkantongdarah_v".
 * @author Rusdiyanto <rusdiyanto@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * @category model
 *
 * The followings are the available columns in table 'infostokkantongdarah_v':
 * @property integer $stokkantongdarah_id
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $nomorbarcode
 * @property integer $jeniskantongdarah_id
 * @property string $nama_jenis
 * @property string $nama_jenis_sngkt
 * @property integer $komponendarah_id
 * @property string $namakomponendrh
 * @property string $singkatan_komp
 * @property integer $jmlkantongdarah
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $kantongdarah_id
 * @property string $tglpencatatan
 * @property string $no_kantongdarah
 * @property integer $daftardonasi_id
 * @property integer $pendonor_id
 * @property string $no_pendonor
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $alamat_lengkap
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $notelp_pendonor
 * @property string $nomobile_pendonor
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * 
 */
class InfostokkantongdarahV extends CActiveRecord {

    public $rilis;
    public $pendaftaran_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InfostokkantongdarahV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'infostokkantongdarah_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('stokkantongdarah_id, instalasi_id, ruangan_id, jeniskantongdarah_id, komponendarah_id, jmlkantongdarah, loginpemakai_id, pegawai_id, gelarbelakang_id, jabatan_id, kantongdarah_id, daftardonasi_id, pendonor_id', 'numerical', 'integerOnly' => true),
            array('beratbadan_kg, tinggibadan_cm', 'numerical'),
            array('instalasi_nama, ruangan_nama, nama_pegawai, no_pendonor, no_identitas', 'length', 'max' => 50),
            array('nomorbarcode, namakomponendrh, jabatan_nama, no_kantongdarah, nama_lengkap, tempat_lahir, notelp_pendonor', 'length', 'max' => 100),
            array('nama_jenis, alamat_lengkap, nomobile_pendonor', 'length', 'max' => 255),
            array('nama_jenis_sngkt, singkatan_komp', 'length', 'max' => 5),
            array('nama_pemakai, jenis_kelamin, statusperkawinan, rhesus', 'length', 'max' => 20),
            array('nomorindukpegawai, jenisidentitas', 'length', 'max' => 30),
            array('gelardepan', 'length', 'max' => 10),
            array('gelarbelakang_nama', 'length', 'max' => 25),
            array('gol_darah', 'length', 'max' => 2),
            array('tglpencatatan, tgllahir', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('stokkantongdarah_id, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, nomorbarcode, jeniskantongdarah_id, nama_jenis, nama_jenis_sngkt, komponendarah_id, namakomponendrh, singkatan_komp, jmlkantongdarah, loginpemakai_id, nama_pemakai, pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, jabatan_id, jabatan_nama, kantongdarah_id, tglpencatatan, no_kantongdarah, daftardonasi_id, pendonor_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, statusperkawinan, gol_darah, rhesus, tgl_kadaluarsa', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'stokkantongdarah_id' => 'Stokkantongdarah',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan Nama',
            'nomorbarcode' => 'Nomorbarcode',
            'jeniskantongdarah_id' => 'Jeniskantongdarah',
            'nama_jenis' => 'Nama Jenis',
            'nama_jenis_sngkt' => 'Nama Jenis Sngkt',
            'komponendarah_id' => 'Komponendarah',
            'namakomponendrh' => 'Namakomponendrh',
            'singkatan_komp' => 'Singkatan Komp',
            'jmlkantongdarah' => 'Jmlkantongdarah',
            'loginpemakai_id' => 'Loginpemakai',
            'nama_pemakai' => 'Nama Pemakai',
            'pegawai_id' => 'Pegawai',
            'nomorindukpegawai' => 'Nomorindukpegawai',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Nama Pegawai',
            'gelarbelakang_id' => 'Gelarbelakang',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'jabatan_id' => 'Jabatan',
            'jabatan_nama' => 'Jabatan Nama',
            'kantongdarah_id' => 'Kantongdarah',
            'tglpencatatan' => 'Tglpencatatan',
            'no_kantongdarah' => 'No Kantongdarah',
            'daftardonasi_id' => 'Daftardonasi',
            'pendonor_id' => 'Pendonor',
            'no_pendonor' => 'No Pendonor',
            'jenisidentitas' => 'Jenisidentitas',
            'no_identitas' => 'No Identitas',
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tgllahir' => 'Tgllahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat_lengkap' => 'Alamat Lengkap',
            'beratbadan_kg' => 'Beratbadan Kg',
            'tinggibadan_cm' => 'Tinggibadan Cm',
            'notelp_pendonor' => 'Notelp Pendonor',
            'nomobile_pendonor' => 'Nomobile Pendonor',
            'statusperkawinan' => 'Statusperkawinan',
            'gol_darah' => 'Gol Darah',
            'rhesus' => 'Rhesus',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function criteriaSearch() {
        /*
         * @return CdbCriteria that can return criterias.
         */
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('stokkantongdarah_id', $this->stokkantongdarah_id);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('nomorbarcode', $this->nomorbarcode, true);
        $criteria->compare('jeniskantongdarah_id', $this->jeniskantongdarah_id);
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        $criteria->compare('nama_jenis_sngkt', $this->nama_jenis_sngkt, true);
        $criteria->compare('komponendarah_id', $this->komponendarah_id);
        $criteria->compare('namakomponendrh', $this->namakomponendrh, true);
        $criteria->compare('singkatan_komp', $this->singkatan_komp, true);
        $criteria->compare('jmlkantongdarah', $this->jmlkantongdarah);
        $criteria->compare('loginpemakai_id', $this->loginpemakai_id);
        $criteria->compare('nama_pemakai', $this->nama_pemakai, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('nomorindukpegawai', $this->nomorindukpegawai, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('jabatan_nama', $this->jabatan_nama, true);
        $criteria->compare('kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('tglpencatatan', $this->tglpencatatan, true);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('no_pendonor', $this->no_pendonor, true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tgllahir', $this->tgllahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('alamat_lengkap', $this->alamat_lengkap, true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('notelp_pendonor', $this->notelp_pendonor, true);
        $criteria->compare('nomobile_pendonor', $this->nomobile_pendonor, true);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('rhesus', $this->rhesus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian data untuk informasi
     * @return \CActiveDataProvider
     */
    public function informasi() {
        $criteria = new CDbCriteria;
        $criteria->select = "TRIM(gol_darah) as gol_darah, "
                . "singkatan_komp";
               // . "count(jmlkantongdarah) as jmlkantongdarah,"
             //   . "count(u.rilis) as rilis";
        $criteria->group = "TRIM(gol_darah), singkatan_komp";
        $criteria->order = " singkatan_komp ASC, TRIM(gol_darah) ASC";
        $criteria->addCondition("gol_darah is not null");
        //$criteria->join = "LEFT JOIN ujikompatibilitas_t u ON t.ujikompatibilitas_id = u.ujikompatibilitas_id";
        $criteria->compare('stokkantongdarah_id', $this->stokkantongdarah_id);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('nomorbarcode', $this->nomorbarcode, true);
        $criteria->compare('jeniskantongdarah_id', $this->jeniskantongdarah_id);
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        $criteria->compare('nama_jenis_sngkt', $this->nama_jenis_sngkt, true);
        $criteria->compare('komponendarah_id', $this->komponendarah_id);
        $criteria->compare('namakomponendrh', $this->namakomponendrh, true);
        $criteria->compare('singkatan_komp', $this->singkatan_komp, true);
        $criteria->compare('jmlkantongdarah', $this->jmlkantongdarah);
        $criteria->compare('loginpemakai_id', $this->loginpemakai_id);
        $criteria->compare('nama_pemakai', $this->nama_pemakai, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('nomorindukpegawai', $this->nomorindukpegawai, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('jabatan_nama', $this->jabatan_nama, true);
        $criteria->compare('kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('tglpencatatan', $this->tglpencatatan, true);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('no_pendonor', $this->no_pendonor, true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tgllahir', $this->tgllahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('alamat_lengkap', $this->alamat_lengkap, true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('notelp_pendonor', $this->notelp_pendonor, true);
        $criteria->compare('nomobile_pendonor', $this->nomobile_pendonor, true);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('rhesus', $this->rhesus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian data detail
     * @return \CDbCriteria
     */
    public function detail() {
        $criteria = new CDbCriteria;
        $criteria->compare('stokkantongdarah_id', $this->stokkantongdarah_id);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('nomorbarcode', $this->nomorbarcode, true);
        $criteria->compare('jeniskantongdarah_id', $this->jeniskantongdarah_id);
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        $criteria->compare('nama_jenis_sngkt', $this->nama_jenis_sngkt, true);
        $criteria->compare('komponendarah_id', $this->komponendarah_id);
        $criteria->compare('namakomponendrh', $this->namakomponendrh, true);
        $criteria->compare('singkatan_komp', $this->singkatan_komp, true);
        $criteria->compare('jmlkantongdarah', $this->jmlkantongdarah);
        $criteria->compare('loginpemakai_id', $this->loginpemakai_id);
        $criteria->compare('nama_pemakai', $this->nama_pemakai, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('nomorindukpegawai', $this->nomorindukpegawai, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('jabatan_nama', $this->jabatan_nama, true);
        $criteria->compare('kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('no_pendonor', $this->no_pendonor, true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('alamat_lengkap', $this->alamat_lengkap, true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('notelp_pendonor', $this->notelp_pendonor, true);
        $criteria->compare('nomobile_pendonor', $this->nomobile_pendonor, true);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('rhesus', $this->rhesus, true);

        if (!empty($this->stokkantongdarah_id)) {
            $criteria->addCondition('stokkantongdarah_id = ' . $this->stokkantongdarah_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(nomorbarcode)', strtolower($this->nomorbarcode), true);
        if (!empty($this->jeniskantongdarah_id)) {
            $criteria->addCondition('jeniskantongdarah_id = ' . $this->jeniskantongdarah_id);
        }
        $criteria->compare('LOWER(nama_jenis)', strtolower($this->nama_jenis), true);
        $criteria->compare('LOWER(nama_jenis_sngkt)', strtolower($this->nama_jenis_sngkt), true);
        if (!empty($this->komponendarah_id)) {
            $criteria->addCondition('komponendarah_id = ' . $this->komponendarah_id);
        }
        $criteria->compare('LOWER(namakomponendrh)', strtolower($this->namakomponendrh), true);
        if(!empty($this->singkatan_komp)){
            $criteria->compare('LOWER(singkatan_komp)', strtolower($this->singkatan_komp), true);
        }
        if (!empty($this->jmlkantongdarah)) {
            $criteria->addCondition('jmlkantongdarah = ' . $this->jmlkantongdarah);
        }
        if (!empty($this->loginpemakai_id)) {
            $criteria->addCondition('loginpemakai_id = ' . $this->loginpemakai_id);
        }
        $criteria->compare('LOWER(nama_pemakai)', strtolower($this->nama_pemakai), true);
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition('pegawai_id = ' . $this->pegawai_id);
        }
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        if (!empty($this->gelarbelakang_id)) {
            $criteria->addCondition('gelarbelakang_id = ' . $this->gelarbelakang_id);
        }
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        if (!empty($this->jabatan_id)) {
            $criteria->addCondition('jabatan_id = ' . $this->jabatan_id);
        }
        $criteria->compare('LOWER(jabatan_nama)', strtolower($this->jabatan_nama), true);
        if (!empty($this->kantongdarah_id)) {
            $criteria->addCondition('kantongdarah_id = ' . $this->kantongdarah_id);
        }
        $criteria->compare('LOWER(tglpencatatan)', strtolower($this->tglpencatatan), true);
        $criteria->compare('LOWER(no_kantongdarah)', strtolower($this->no_kantongdarah), true);
        if (!empty($this->daftardonasi_id)) {
            $criteria->addCondition('daftardonasi_id = ' . $this->daftardonasi_id);
        }
        if (!empty($this->pendonor_id)) {
            $criteria->addCondition('pendonor_id = ' . $this->pendonor_id);
        }
        $criteria->compare('LOWER(no_pendonor)', strtolower($this->no_pendonor), true);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas)', strtolower($this->no_identitas), true);
        $criteria->compare('LOWER(nama_lengkap)', strtolower($this->nama_lengkap), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tgllahir)', strtolower($this->tgllahir), true);
        $criteria->compare('LOWER(jenis_kelamin)', strtolower($this->jenis_kelamin), true);
        $criteria->compare('LOWER(alamat_lengkap)', strtolower($this->alamat_lengkap), true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('LOWER(notelp_pendonor)', strtolower($this->notelp_pendonor), true);
        $criteria->compare('LOWER(nomobile_pendonor)', strtolower($this->nomobile_pendonor), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(gol_darah)', strtolower($this->gol_darah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian data dialog
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('stokkantongdarah_id', $this->stokkantongdarah_id);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('nomorbarcode', $this->nomorbarcode, true);
        $criteria->compare('jeniskantongdarah_id', $this->jeniskantongdarah_id);
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        $criteria->compare('nama_jenis_sngkt', $this->nama_jenis_sngkt, true);
        $criteria->compare('komponendarah_id', $this->komponendarah_id);
        $criteria->compare('namakomponendrh', $this->namakomponendrh, true);
        $criteria->compare('singkatan_komp', $this->singkatan_komp, true);
        $criteria->compare('jmlkantongdarah', $this->jmlkantongdarah);
        $criteria->compare('loginpemakai_id', $this->loginpemakai_id);
        $criteria->compare('nama_pemakai', $this->nama_pemakai, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('nomorindukpegawai', $this->nomorindukpegawai, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('jabatan_nama', $this->jabatan_nama, true);
        $criteria->compare('kantongdarah_id', $this->kantongdarah_id);
        $criteria->compare('tglpencatatan', $this->tglpencatatan, true);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('daftardonasi_id', $this->daftardonasi_id);
        $criteria->compare('pendonor_id', $this->pendonor_id);
        $criteria->compare('no_pendonor', $this->no_pendonor, true);
        $criteria->compare('jenisidentitas', $this->jenisidentitas, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('nama_lengkap', $this->nama_lengkap, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tgllahir', $this->tgllahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('alamat_lengkap', $this->alamat_lengkap, true);
        $criteria->compare('beratbadan_kg', $this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm', $this->tinggibadan_cm);
        $criteria->compare('notelp_pendonor', $this->notelp_pendonor, true);
        $criteria->compare('nomobile_pendonor', $this->nomobile_pendonor, true);
        $criteria->compare('statusperkawinan', $this->statusperkawinan, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('rhesus', $this->rhesus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * fungsi untuk dialog kantong darah di transaksi kompatibilitas
     * @author Rusdiyanto <rusdiyanto@.com>
     * @return \CActiveDataProvider
     */
    public function searchDialogPengujianKompatibilitas() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('stokkantongdarah_id', $this->stokkantongdarah_id);
        $criteria->addCondition('ujikompatibilitas_id is null');
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('no_formulir', $this->no_formulir, true);
        $criteria->compare('no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('LOWER(singkatan_komp)', trim(strtolower($this->singkatan_komp)), true);
        $criteria->compare('rhesus', $this->rhesus, true);
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * fungsi untuk dialog kantong darah di transaksi kompatibilitas
     * @author Rusdiyanto <rusdiyanto@.com>
     * @return \CActiveDataProvider
     */
    public function searchDialogKantongDarahMonitoringTransfusi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('t.stokkantongdarah_id', $this->stokkantongdarah_id);
        $criteria->compare('t.no_identitas', $this->no_identitas, true);
        $criteria->compare('t.no_formulir', $this->no_formulir, true);
        $criteria->compare('t.no_kantongdarah', $this->no_kantongdarah, true);
        $criteria->compare('t.gol_darah', $this->gol_darah, true);
        $criteria->compare('t.komponendarah_id', $this->komponendarah_id);
        $criteria->compare('LOWER(t.singkatan_komp)', trim(strtolower($this->singkatan_komp)), true);
        $criteria->compare('t.rhesus', $this->rhesus, true);
        $criteria->compare('t.nama_jenis', $this->nama_jenis, true);
        
        $criteria->join = 'join ujikompatibilitas_t u on u.ujikompatibilitas_id = t.ujikompatibilitas_id '
            . 'join permintaandarahdet_t d on d.permintaandarahdet_id = u.permintaandarahdet_id '
            . 'join permintaandarah_t p on p.permintaandarah_id = d.permintaandarah_id';
        
        $criteria->compare('p.pendaftaran_id', $this->pendaftaran_id);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian data yang akan dicetak
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    /**
     * Menghitung jumlah stok kantong darah berdasarkan nama komponen dan golongan darah
     * @param type $singkatan_komp
     * @param type $gol_darah
     * @return int
     */ 
    public function getStokKantongDarah($singkatan_komp , $gol_darah){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(t.jmlkantongdarah) as jmlkantongdarah , komponen.singkatan_komp ,t.gol_darah';
        $criteria->join = 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
        $criteria->group = 'komponen.singkatan_komp,t.gol_darah';
        $criteria->addCondition("t.ujikompatibilitas_id is null");
        $criteria->addCondition("komponen.singkatan_komp ='".$singkatan_komp."'");
        $criteria->addCondition("t.gol_darah ='".$gol_darah."'");
        $model = InfostokkantongdarahV::model()->find($criteria);
        if(!empty($model)){
            $total = $model->jmlkantongdarah;
        }else{
            $total = 0;
        }
        return $total;
    }
    
    /**
     * Menampilkan total stok darah yang sudah siap
     * @param type $singkatan_komp
     * @param type $gol_darah
     * @return int 
     */
    public function getStokDarahSiap($singkatan_komp,$gol_darah){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(t.jmlkantongdarah) as jmlkantongdarah , komponen.singkatan_komp , t.golongan_darah';
        $criteria->join = 'LEFT JOIN ujikompatibilitas_t as uji ON t.ujikompatibilitas_id = uji.ujikompatibilitas_id '
                        //. 'LEFT JOIN penyiapandarah_t as penyiapan ON uji.ujikompatibilitas_id = penyiapan.ujikompatibilitas_id '
                        //. 'LEFT JOIN penyerahandarah_t as penyerahan ON penyiapan.penyiapandarah_id = penyerahan.penyiapandarah_id '
                        . 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
        $criteria->group = 'komponen.singkatan_komp,t.golongan_darah';
        $criteria->addCondition("t.ujikompatibilitas_id is not null");
        //$criteria->addCondition("penyiapan.penyiapandarah_id is not null");
        //$criteria->addCondition("penyerahan.penyerahandarah_id is null");
        $criteria->addCondition("komponen.singkatan_komp ='".$singkatan_komp."'");
        $criteria->addCondition("t.golongan_darah ='".$gol_darah."'");
        $model = StokkantongdarahT::model()->find($criteria);
        if(!empty($model)){
            $total = $model->jmlkantongdarah;
        }else{
            $total = 0;
        }
        return $total;
    }
    
    /**
     * Menghitung stok darah keluar
     * @param type $singkatan_komp
     * @param type $gol_darah
     * @return int
     */
    public function getStokDarahKeluar($singkatan_komp,$gol_darah){
        $criteria = new CDbCriteria();
        $criteria->select = 'count(t.jmlkantongdarah) as jmlkantongdarah , komponen.singkatan_komp , t.golongan_darah';
        $criteria->join = 'LEFT JOIN ujikompatibilitas_t as uji ON t.ujikompatibilitas_id = uji.ujikompatibilitas_id '
                        . 'LEFT JOIN penyiapandarah_t as penyiapan ON uji.ujikompatibilitas_id = penyiapan.ujikompatibilitas_id '
                        . 'LEFT JOIN penyerahandarah_t as penyerahan ON penyiapan.penyiapandarah_id = penyerahan.penyiapandarah_id '
                        . 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
        $criteria->group = 'komponen.singkatan_komp,t.golongan_darah';
        $criteria->addCondition('t.ujikompatibilitas_id is not null');
        $criteria->addCondition('penyiapan.tgl_terimadarah is not null');
        $criteria->addCondition("komponen.singkatan_komp ='".$singkatan_komp."'");
        $criteria->addCondition("t.golongan_darah ='".$gol_darah."'");
        $model = StokkantongdarahT::model()->find($criteria);
        if(!empty($model)){
            $total = $model->jmlkantongdarah;
        }else{
            $total =0;
        }
        return $total;
    }
}
