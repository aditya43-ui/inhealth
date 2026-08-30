<?php

/**
 * This is the model class for table "pegawairuangan_v".
 *
 * The followings are the available columns in table 'pegawairuangan_v':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jeniskelamin
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $alamat_pegawai
 * @property boolean $pegawai_aktif
 * @property string $agama
 * @property string $golongandarah
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $photopegawai
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property integer $pendkualifikasi_id
 * @property string $pendkualifikasi_nama
 * @property string $nomorindukpegawai
 * @property integer $pangkat_id
 * @property integer $kelompokpegawai_id
 * @property integer $jabatan_id
 */
class PegawairuanganV extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PegawairuanganV the static model class
     */
    public $nama_pemakai;
    public $unitkerja_id;
    public $is_dokterumum = 0;
    public $nama_lengkap;
    public $kelompokpegawai_nama;
    public $jabatan_nama;
    public $namaunitkerja;
    public $default;
    public $notkelompokpegawai_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pegawairuangan_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, instalasi_id, pegawai_id, pendidikan_id, pendkualifikasi_id, pangkat_id, kelompokpegawai_id, jabatan_id', 'numerical', 'integerOnly' => true),
            array('ruangan_nama, nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, pendidikan_nama, pendkualifikasi_nama', 'length', 'max' => 50),
            array('gelardepan', 'length', 'max' => 10),
            array('gelarbelakang_nama', 'length', 'max' => 15),
            array('jeniskelamin, agama', 'length', 'max' => 20),
            array('tempatlahir_pegawai, nomorindukpegawai', 'length', 'max' => 30),
            array('golongandarah', 'length', 'max' => 2),
            array('alamatemail', 'length', 'max' => 100),
            array('photopegawai', 'length', 'max' => 200),
            array('tgl_lahirpegawai, alamat_pegawai, pegawai_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ruangan_id, instalasi_id, ruangan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, pegawai_aktif, agama, golongandarah, alamatemail, notelp_pegawai, nomobile_pegawai, photopegawai, pendidikan_id, pendidikan_nama, pendkualifikasi_id, pendkualifikasi_nama, nomorindukpegawai, pangkat_id, kelompokpegawai_id, jabatan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
            'kelompokpegawai' => array(self::BELONGS_TO, 'KelompokpegawaiM', 'kelompokpegawai_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ruangan_id' => 'Ruangan',
            'instalasi_id' => 'Instalasi',
            'ruangan_nama' => 'Ruangan Nama',
            'pegawai_id' => 'Pegawai',
            'gelardepan' => 'Gelar Depan',
            'nama_pegawai' => 'Nama Pegawai',
            'gelarbelakang_nama' => 'Gelar Belakang Nama',
            'jeniskelamin' => 'Jenis Kelamin',
            'nama_keluarga' => 'Nama Keluarga',
            'tempatlahir_pegawai' => 'Tempat Lahir Pegawai',
            'tgl_lahirpegawai' => 'Tanggal Lahir Pegawai',
            'alamat_pegawai' => 'Alamat Pegawai',
            'pegawai_aktif' => 'Pegawai Aktif',
            'agama' => 'Agama',
            'golongandarah' => 'Golongan Darah',
            'alamatemail' => 'Alamat Email',
            'notelp_pegawai' => 'No. Telp Pegawai',
            'nomobile_pegawai' => 'No. Mobile Pegawai',
            'photopegawai' => 'Photo Pegawai',
            'pendidikan_id' => 'Pendidikan',
            'pendidikan_nama' => 'Pendidikan Nama',
            'pendkualifikasi_id' => 'Pendidikan Kualifikasi',
            'pendkualifikasi_nama' => 'Pendidikan Kualifikasi Nama',
            'nomorindukpegawai' => 'Nomor Induk Pegawai',
            'pangkat_id' => 'Pangkat',
            'kelompokpegawai_id' => 'Kelompok Pegawai',
            'jabatan_id' => 'Jabatan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('t.instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(t.gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.nama_keluarga)', strtolower($this->nama_keluarga), true);
        $criteria->compare('LOWER(t.tempatlahir_pegawai)', strtolower($this->tempatlahir_pegawai), true);
        $criteria->compare('LOWER(t.tgl_lahirpegawai)', strtolower($this->tgl_lahirpegawai), true);
        $criteria->compare('LOWER(t.alamat_pegawai)', strtolower($this->alamat_pegawai), true);
        $criteria->compare('t.pegawai_aktif', $this->pegawai_aktif);
        $criteria->compare('LOWER(t.agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(t.golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(t.alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(t.notelp_pegawai)', strtolower($this->notelp_pegawai), true);
        $criteria->compare('LOWER(t.nomobile_pegawai)', strtolower($this->nomobile_pegawai), true);
        $criteria->compare('LOWER(t.photopegawai)', strtolower($this->photopegawai), true);
        $criteria->compare('t.pendidikan_id', $this->pendidikan_id);
        $criteria->compare('LOWER(t.pendidikan_nama)', strtolower($this->pendidikan_nama), true);
        $criteria->compare('t.pendkualifikasi_id', $this->pendkualifikasi_id);
        $criteria->compare('LOWER(t.pendkualifikasi_nama)', strtolower($this->pendkualifikasi_nama), true);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('t.pangkat_id', $this->pangkat_id);
        $criteria->compare('t.kelompokpegawai_id', $this->kelompokpegawai_id);
        $criteria->compare('t.jabatan_id', $this->jabatan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'nama_pegawai'
            ),
        ));
    }

    /**
     * untuk mengenerate data pada dialog box pencarian pegawai mengetahui
     * @return \CActiveDataProvider
     */
    public function pegawaiMengetahui() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('t.instalasi_id', $this->instalasi_id);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('t.jabatan_id', $this->jabatan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * memfilter data pegawai berdasarkan user login
     * @return type
     */
    function searchPetugasLoket() {
        $provider = $this->search();

        $provider->criteria->join = 'left join loginpemakai_k l on l.pegawai_id = t.pegawai_id';
        $provider->criteria->compare('lower(nama_pemakai)', strtolower($this->nama_pemakai), true);

        return $provider;
    }

    /**
     * fungsi yang digunakan untuk memfilter prinout
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(nama_keluarga)', strtolower($this->nama_keluarga), true);
        $criteria->compare('LOWER(tempatlahir_pegawai)', strtolower($this->tempatlahir_pegawai), true);
        $criteria->compare('LOWER(tgl_lahirpegawai)', strtolower($this->tgl_lahirpegawai), true);
        $criteria->compare('LOWER(alamat_pegawai)', strtolower($this->alamat_pegawai), true);
        $criteria->compare('pegawai_aktif', $this->pegawai_aktif);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(notelp_pegawai)', strtolower($this->notelp_pegawai), true);
        $criteria->compare('LOWER(nomobile_pegawai)', strtolower($this->nomobile_pegawai), true);
        $criteria->compare('LOWER(photopegawai)', strtolower($this->photopegawai), true);
        $criteria->compare('pendidikan_id', $this->pendidikan_id);
        $criteria->compare('LOWER(pendidikan_nama)', strtolower($this->pendidikan_nama), true);
        $criteria->compare('pendkualifikasi_id', $this->pendkualifikasi_id);
        $criteria->compare('LOWER(pendkualifikasi_nama)', strtolower($this->pendkualifikasi_nama), true);
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('pangkat_id', $this->pangkat_id);
        $criteria->compare('kelompokpegawai_id', $this->kelompokpegawai_id);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * mengenerate nama lengkap
     * @return type
     */
    public function getNamaLengkap() {
        $pegawai = PegawaiM::model()->findByPk($this->pegawai_id);
        return $pegawai->namaLengkap;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function getNamaJabatan($jabatan_id) {
        $modnamajab = JabatanM::model()->findByAttributes(array('jabatan_id' => $jabatan_id));
        $namajabatan = isset($modnamajab->jabatan_nama) ? $modnamajab->jabatan_nama : "";
        return $namajabatan;
    }

    /**
     * mengenerate data pegawai, bisa berdasarkan ruangan
     * @param type $ruangan_id
     * @return type
     */
    public static function getDropPegawai($ruangan_id = '', $isAdaRuangan = false) {
        $cri = new CDbCriteria();
        $model = "PegawaiM";
        if (!empty($ruangan_id)) {
            $model = "PegawairuanganV";
            $cri->addCondition(" ruangan_id = '" . $ruangan_id . "' ");
        }
        
        if ($isAdaRuangan){
            if (empty($ruangan_id)) {
                $cri->addCondition(" pegawai_id IS NULL ");
            }
        }
        
        $cri->addCondition("pegawai_aktif = TRUE");
        $cri->order = "nama_pegawai ASC";

        return CHtml::listData($model::model()->findAll($cri), 'pegawai_id', 'namaLengkap');
    }

    /**
     * mengenerate data pegawai, bisa berdasarkan ruangan
     * @param type $ruangan_id
     * @return type
     */
    public static function getDropPegawaiByUser($ruangan_id = '') {
        $cri = new CDbCriteria();
        if (!empty($ruangan_id)) {
            $cri->addCondition(" ruangan_id = '" . $ruangan_id . "' ");
        }
        $cri->addCondition("pegawai_aktif = TRUE");
        $cri->order = "nama_pegawai ASC";

        $peg = PegawairuanganV::model()->findAll($cri);

        $id = array();
        foreach ($peg as $i) {
            $id[] = $i->pegawai_id;
        }

        $criId = new CDbCriteria();
        $criId->select = " peg.nama_pegawai, t.loginpemakai_id ";
        $criId->join = " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id ";
        $criId->addInCondition("t.pegawai_id", $id);
        $criId->order = " peg.nama_pegawai ASC ";

        return CHtml::listData(LoginpemakaiK::model()->findAll($criId), 'loginpemakai_id', 'nama_pegawai');
    }

    /**
     * mengenerate data pegawai
     * @param type $ruangan_id
     * @param type $tambah
     * @return type
     */
    public static function getDropPegawaiTambah($ruangan_id = '', $tambah = array(), $kondisi = null) {
        $cri = new CDbCriteria();
        $cri->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id';
        $data = array();
        if (!empty($ruangan_id)) {
            $cri->addCondition(" t.ruangan_id = '" . $ruangan_id . "' ");
        }
        if (!empty($kondisi)) {
            foreach ($kondisi as $param => $val) {
                $cri->compare($param, $val);
            }
        }

        $cri->addCondition("t.pegawai_aktif = TRUE");
        $cri->order = "t.nama_pegawai ASC";

        if (!empty($tambah)) {
            foreach ($tambah as $tb) {
                $data[$tb] = $tb;
            }
        }

        $peg = PegawairuanganV::model()->findAll($cri);

        if (count((array) $peg) > 0) {
            foreach ($peg as $p) {
                $data[$p->pegawai_id] = $p->namaLengkap;
            }
        }


        return $data;
    }

    /**
     * - digunakan untuk menampilkan data pegawai berdasarkan
     * @return \CActiveDataProvider
     */
    public function PegawaiByUnitKerja() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = " t.pegawai_id, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama, t.jabatan_id, t.nomorindukpegawai ";
        $criteria->join = " JOIN pegawai_m p ON p.pegawai_id =  t.pegawai_id ";
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('t.instalasi_id', $this->instalasi_id);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(t.gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('t.jabatan_id', $this->jabatan_id);
        if (!empty($this->unitkerja_id)) {
            $criteria->addInCondition("p.unitkerja_id", $this->unitkerja_id);
        }
        $criteria->group = $criteria->select;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * pencarian pegawai ruangan
     * @return type
     */
    public function searchPegawaiRuangan() {
        $prov = $this->search();

        $prov->sort->defaultOrder = 'nama_pegawai';

        return $prov;
    }

    /**
     * pencarian dialog non dokter
     * @return type
     */
    public function searchNonDokter() {
        $prov = $this->search();

        $prov->criteria->addNotInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK));
        $prov->sort->defaultOrder = 'nama_pegawai';

        return $prov;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPetugasSkoring() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('t.instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(t.gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.nama_keluarga)', strtolower($this->nama_keluarga), true);
        $criteria->compare('LOWER(t.tempatlahir_pegawai)', strtolower($this->tempatlahir_pegawai), true);
        $criteria->compare('LOWER(t.tgl_lahirpegawai)', strtolower($this->tgl_lahirpegawai), true);
        $criteria->compare('LOWER(t.alamat_pegawai)', strtolower($this->alamat_pegawai), true);
        $criteria->compare('t.pegawai_aktif', $this->pegawai_aktif);
        $criteria->compare('LOWER(t.agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(t.golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(t.alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(t.notelp_pegawai)', strtolower($this->notelp_pegawai), true);
        $criteria->compare('LOWER(t.nomobile_pegawai)', strtolower($this->nomobile_pegawai), true);
        $criteria->compare('LOWER(t.photopegawai)', strtolower($this->photopegawai), true);
        $criteria->compare('t.pendidikan_id', $this->pendidikan_id);
        $criteria->compare('LOWER(t.pendidikan_nama)', strtolower($this->pendidikan_nama), true);
        $criteria->compare('t.pendkualifikasi_id', $this->pendkualifikasi_id);
        $criteria->compare('LOWER(t.pendkualifikasi_nama)', strtolower($this->pendkualifikasi_nama), true);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('t.pangkat_id', $this->pangkat_id);
        $criteria->compare('t.kelompokpegawai_id', $this->kelompokpegawai_id);
        $criteria->compare('t.jabatan_id', $this->jabatan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 5)
        ));
    }

    /**
     * - digunakan untuk menampilkan data pegawai berdasarkan
     * @return \CActiveDataProvider
     */
    public function searchDialogPegRuangan() {
        $criteria = new CDbCriteria;
        $criteria->select = " t.nama_pegawai, t.pegawai_id,t.gelarbelakang_nama,t.gelardepan,j.jabatan_nama,t.nomorindukpegawai, u.namaunitkerja,t.kelompokpegawai_id, t.nomobile_pegawai";
        //$criteria->select = " t.nama_pegawai, t.pegawai_id,t.gelarbelakang_nama,t.gelardepan,j.jabatan_nama as jabatan_nama ";
        $criteria->join = " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "
                . " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                . " LEFT JOIN unitkerja_m u ON u.unitkerja_id = p.unitkerja_id ";
        $criteria->addCondition(" ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
        $criteria->compare("LOWER(t.nama_pegawai)", strtolower($this->nama_pegawai), true);
        $criteria->compare("t.nomorindukpegawai", strtolower($this->nomorindukpegawai), true);
        if (!empty($this->kelompokpegawai_id)) {
            if (is_array($this->kelompokpegawai_id)) {
                $criteria->addInCondition("t.kelompokpegawai_id", $this->kelompokpegawai_id);
            } else {
                $criteria->addCondition("t.kelompokpegawai_id =" . $this->kelompokpegawai_id);
            }
        }

        if (!empty($this->jabatan_id)) {
            $criteria->addCondition("t.jabatan_id =" . $this->jabatan_id);
        }
        if (!empty($this->unitkerja_id)) {
            $criteria->addCondition("u.unitkerja_id =" . $this->unitkerja_id);
        }
        $criteria->order = " t.nama_pegawai ASC ";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchDialogPegawai() {

        $criteria = new CDbCriteria;
        $criteria->group = " t.jeniskelamin, t.nama_pegawai, t.pegawai_id,t.gelarbelakang_nama,t.gelardepan,j.jabatan_nama, j.jabatan_id, t.nomorindukpegawai, u.namaunitkerja,t.kelompokpegawai_id, t.nomobile_pegawai";
        $criteria->select = $criteria->group;
        $criteria->join = " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "
                . " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                . " LEFT JOIN unitkerja_m u ON u.unitkerja_id = p.unitkerja_id ";
        $criteria->compare("LOWER(t.nama_pegawai)", strtolower($this->nama_pegawai), true);
        $criteria->compare("LOWER(u.namaunitkerja)", strtolower($this->namaunitkerja), true);
        $criteria->compare("LOWER(j.jabatan_nama)", strtolower($this->jabatan_nama), true);
        $criteria->compare("t.nomorindukpegawai", strtolower($this->nomorindukpegawai), true);
        if (!empty($this->default)) {
            $criteria->addCondition(" t.pegawai_id is null ");
        }

        if (!empty($this->kelompokpegawai_id)) {
            if (is_array($this->kelompokpegawai_id)) {
                $criteria->addInCondition("t.kelompokpegawai_id ", $this->kelompokpegawai_id);
            } else {
                $criteria->addCondition("t.kelompokpegawai_id =" . $this->kelompokpegawai_id);
            }
        }

        if (!empty($this->notkelompokpegawai_id)) {
            $criteria->addCondition("t.kelompokpegawai_id != " . $this->notkelompokpegawai_id);
        }

        if (!empty($this->ruangan_id)) {
            if (is_array($this->ruangan_id)) {
                $criteria->addInCondition("t.ruangan_id ", $this->ruangan_id);
            } else {
                $criteria->addCondition("t.ruangan_id =" . $this->ruangan_id);
            }
        }
        if (!empty($this->jabatan_id)) {
            $criteria->addCondition("t.jabatan_id =" . $this->jabatan_id);
        }
        if (!empty($this->unitkerja_id)) {
            $criteria->addCondition("u.unitkerja_id =" . $this->unitkerja_id);
        }
        if (!empty($this->instalasi_id)) {
            if (is_array($this->instalasi_id)) {
                $criteria->addInCondition("t.instalasi_id ", $this->instalasi_id);
            } else {
                $criteria->addCondition("t.instalasi_id =" . $this->instalasi_id);
            }
        }
        $criteria->order = " t.nama_pegawai ASC ";
        $model = $this;


        return new CActiveDataProvider($model, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Search perawat sesuai ruangan login 
     * @return \CActiveDataProvider
     */
    public function searchPerawatRuangan() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(t.gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(t.gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('t.pegawai_aktif', $this->pegawai_aktif);
        $criteria->compare('pendkualifikasi_id', $this->pendkualifikasi_id);
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);

        $criteria->addCondition('kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);

        if (!empty($this->kelompokpegawai_id)) {
            if (is_array($this->kelompokpegawai_id)) {
                $criteria->addInCondition('kelompokpegawai_id', $this->kelompokpegawai_id);
            } else {
                $criteria->compare('kelompokpegawai_id', $this->kelompokpegawai_id);
            }
        }

        if (!empty($this->jabatan_id)) {
            if (is_array($this->jabatan_id)) {
                $criteria->addInCondition('t.jabatan_id', $this->jabatan_id);
            } else {
                $criteria->compare("t.jabatan_id", $this->jabatan_id);
            }
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'nama_pegawai'),
        ));
    }

    /**
     * Search perawat sesuai ruangan login 
     * @return \CActiveDataProvider
     */
    public function searchAnalisLab() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->compare('LOWER(t.gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(t.gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('t.pegawai_aktif', $this->pegawai_aktif);
        $criteria->compare('pendkualifikasi_id', $this->pendkualifikasi_id);
        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);

        $criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN));

        if (!empty($this->kelompokpegawai_id)) {
            if (is_array($this->kelompokpegawai_id)) {
                $criteria->addInCondition('kelompokpegawai_id', $this->kelompokpegawai_id);
            } else {
                $criteria->compare('kelompokpegawai_id', $this->kelompokpegawai_id);
            }
        }

        if (!empty($this->jabatan_id)) {
            if (is_array($this->jabatan_id)) {
                $criteria->addInCondition('t.jabatan_id', $this->jabatan_id);
            } else {
                $criteria->compare("t.jabatan_id", $this->jabatan_id);
            }
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'nama_pegawai'),
        ));
    }

    public function searchPegawaiBankDarah()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join ='left join pegawai_m as p ON t.pegawai_id = p.pegawai_id
                                  ';
		$criteria->group = 'p.unitkerja_id,t.jabatan_id,t.nomorindukpegawai,t.nama_pegawai,t.gelardepan,t.gelarbelakang_nama,t.alamat_pegawai,t.pegawai_id';
		$criteria->select = $criteria->group;  
                $criteria->addCondition('t.ruangan_id =' . Params::RUANGAN_ID_BANK_DARAH);
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
                if(!empty($this->jabatan_id)){
			$criteria->addCondition('t.jabatan_id = '.$this->jabatan_id);
		}
                 if(!empty($this->unitkerja_id)){
			$criteria->addCondition('p.unitkerja_id = '.$this->unitkerja_id);
		}
                
		
		
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->order = 't.nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join ='left join pegawai_m as p ON t.pegawai_id = p.pegawai_id
                                  ';
		$criteria->group = 'p.unitkerja_id,t.jabatan_id,t.nomorindukpegawai,t.nama_pegawai,t.gelardepan,t.gelarbelakang_nama,t.alamat_pegawai,t.pegawai_id';
		$criteria->select = $criteria->group;  
                $criteria->addCondition("p.pegawai_aktif is true");
                $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
                if(!empty($this->jabatan_id)){
			$criteria->addCondition('t.jabatan_id = '.$this->jabatan_id);
		}
                 if(!empty($this->unitkerja_id)){
			$criteria->addCondition('p.unitkerja_id = '.$this->unitkerja_id);
		}
                $criteria->addCondition('t.kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP);
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->order = 't.nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * digunakan untuk dialog tim pegawai CRU pada transaksi realisasi monev
     * @return \CActiveDataProvider
     */
    public function searchPegawaiCRU()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join ='left join pegawai_m as p ON t.pegawai_id = p.pegawai_id
                                  ';
		$criteria->group = 'p.unitkerja_id,t.jabatan_id,t.nomorindukpegawai,t.nama_pegawai,t.gelardepan,t.gelarbelakang_nama,t.alamat_pegawai,t.pegawai_id';
		$criteria->select = $criteria->group;  
                $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
                if(!empty($this->jabatan_id)){
			$criteria->addCondition('t.jabatan_id = '.$this->jabatan_id);
		}
                 if(!empty($this->unitkerja_id)){
			$criteria->addCondition('p.unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->order = 't.nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
}
