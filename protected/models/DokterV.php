<?php

/**
 * This is the model class for table "dokter_v".
 *
 * The followings are the available columns in table 'dokter_v':
 * @property integer $ruangan_id
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
class DokterV extends CActiveRecord {

    public $is_dokterumum = 0, $jabatan_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DokterV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dokter_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, pegawai_id, pendidikan_id, pendkualifikasi_id, pangkat_id, kelompokpegawai_id, jabatan_id', 'numerical', 'integerOnly' => true),
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
            array('ruangan_id, ruangan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, pegawai_aktif, agama, golongandarah, alamatemail, notelp_pegawai, nomobile_pegawai, photopegawai, pendidikan_id, pendidikan_nama, pendkualifikasi_id, pendkualifikasi_nama, nomorindukpegawai, pangkat_id, kelompokpegawai_id, jabatan_id', 'safe', 'on' => 'search'),
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
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan',
            'pegawai_id' => 'Pegawai',
            'gelardepan' => 'Gelar Depan',
            'nama_pegawai' => 'Nama',
            'gelarbelakang_nama' => 'Gelar Belakang',
            'jeniskelamin' => 'Jenis Kelamin',
            'nama_keluarga' => 'Nama Keluarga',
            'tempatlahir_pegawai' => 'Tempat Lahir Pegawai',
            'tgl_lahirpegawai' => 'Tanggal Lahir Pegawai',
            'alamat_pegawai' => 'Alamat Pegawai',
            'pegawai_aktif' => 'Pegawai Aktif',
            'agama' => 'Agama',
            'golongandarah' => 'Golongan Darah',
            'alamatemail' => 'Alamat E-mail',
            'notelp_pegawai' => 'No. Telepon',
            'nomobile_pegawai' => 'No. Handphone',
            'photopegawai' => 'Photopegawai',
            'pendidikan_id' => 'Pendidikan',
            'pendidikan_nama' => 'Pendidikan Nama',
            'pendkualifikasi_id' => 'Pendidikan',
            'pendkualifikasi_nama' => 'Nama Pendidikan',
            'nomorindukpegawai' => 'NIP',
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

        $criteria->compare('ruangan_id', $this->ruangan_id);
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchDokterResep() {
        $p = $this->search();
        $p->criteria->select = $p->criteria->group = "pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, nomorindukpegawai, jabatan_id";
        $p->sort->defaultOrder = 'nama_pegawai';
        return $p;
    }

    public function searchAllDokter() {
        $criteria = new CDbCriteria();
        $criteria->join = " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id ";
        $criteria->select = "t.pegawai_id, t.nomorindukpegawai, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama, t.jabatan_id, j.jabatan_nama";
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        $criteria->compare('LOWER(j.jabatan_nama)', strtolower($this->jabatan_nama), true);
        if (!empty($this->jabatan_id)) {
            $criteria->addCondition("t.jabatan_id = '" . $this->jabatan_id . "' ");
        }
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->group = "t.pegawai_id, t.nomorindukpegawai, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama, t.jabatan_id, j.jabatan_nama";
        $criteria->order = 't.nama_pegawai';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('ruangan_id', $this->ruangan_id);
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

    public function getNamaLengkap() {
        return $this->gelardepan . " " . $this->nama_pegawai . ", " . $this->gelarbelakang_nama;
    }

    public function getGelarBelakangItems() {
        return GelarbelakangM::model()->findAll(array('order' => 'gelarbelakang_nama'));
    }

    public function getSukuItems() {
        return SukuM::model()->findAll(array('order' => 'suku_nama'));
    }

    public function getkelompokPegawaiItems() {
        return KelompokpegawaiM::model()->findAll(array('order' => 'kelompokpegawai_nama'));
    }

    public function getPendidikanKualifikasiItems() {
        return PendidikankualifikasiM::model()->findAll(array('order' => 'pendkualifikasi_nama'));
    }

    public function getJabatanItems() {
        return JabatanM::model()->findAll(array('order' => 'jabatan_nama'));
    }

    public function getPendidikanItems() {
        return PendidikanM::model()->findAll(array('order' => 'pendidikan_nama'));
    }

    public function getPangkatItems() {
        return PangkatM::model()->findAll(array('order' => 'pangkat_nama'));
    }

    public function getPropinsiItems() {
        return PropinsiM::model()->findAll(array('order' => 'propinsi_nama'));
    }

    /**
     * menampilkan dokter 
     * @param type $ruangan_id
     * @return type
     */
    public function getDokter($ruangan_id) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        $criteria->addCondition('pegawai_aktif = true');
        $criteria->order = "nama_pegawai, gelardepan";
        return DokterV::model()->findAll($criteria);
    }

    public function getDropDokterByRuangan($ruangan_id = null) {
        $ruangan_id = !empty($ruangan_id) ? $ruangan_id : Yii::app()->user->getState('ruangan_id');

        $cri = new CDbCriteria();
        $cri->addCondition(" ruangan_id = " . $ruangan_id);
        $cri->addCondition(" pegawai_aktif = TRUE ");
        $cri->order = "nama_pegawai ASC";

        return CHtml::listData(DokterV::model()->findAll($cri), 'pegawai_id', 'namaLengkap');
    }

    public function getDropDokterResep() {
        $cri = new CDbCriteria();
        $cri->addCondition(" pegawai_aktif = TRUE ");
        $cri->order = "nama_pegawai ASC";

        return CHtml::listData(DokterV::model()->findAll($cri), 'pegawai_id', 'namaLengkap');
    }

    public function getDropDokterResepByNama() {
        $cri = new CDbCriteria();
        $cri->addCondition(" pegawai_aktif = TRUE ");
        $cri->order = "nama_pegawai ASC";

        return CHtml::listData(DokterV::model()->findAll($cri), 'nama_pegawai', 'namaLengkap');
    }

    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('pangkat_id', $this->pangkat_id);
        $criteria->compare('kelompokpegawai_id', $this->kelompokpegawai_id);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai), true);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        //$criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            //'pagination' => false,
        ));
    }

    /**
     * 
     * @return \CActiveDataProvider
     */
    public function searchDialogPegRuangan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition(" ruangan_id = " . Yii::app()->user->getState('ruangan_id'));

        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare("LOWER(nama_pegawai)", strtolower($this->nama_pegawai), true);
        $criteria->order = " nama_pegawai ASC ";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * 
     * @return \CActiveDataProvider
     */
    public function searchDialogPeg() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare("ruangan_id", $this->ruangan_id);
        $criteria->compare("LOWER(nama_pegawai)", strtolower($this->nama_pegawai), true);
        $criteria->order = " nama_pegawai ASC ";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchDialogNotRuangan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama";
        $criteria->group = $criteria->select;
        $criteria->addCondition('pegawai_aktif is true');
        $criteria->compare("LOWER(nama_pegawai)", strtolower($this->nama_pegawai), true);
        $criteria->order = " nama_pegawai ASC ";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchDialogDpjp() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition('pegawai_aktif is true');
        $criteria->compare("LOWER(nama_pegawai)", strtolower($this->nama_pegawai), true);
        $criteria->order = "nama_pegawai, gelardepan";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
