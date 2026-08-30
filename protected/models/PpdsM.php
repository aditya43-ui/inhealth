<?php

/**
 * This is the model class for table "ppds_m".
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'ppds_m':
 * @property integer $ppds_id
 * @property string $ppds_nim
 * @property string $ppds_nik
 * @property string $ppds_nama
 * @property string $ppds_jeniskelamin
 * @property string $ppds_tempatlahir
 * @property string $ppds_tanggallahir
 * @property string $ppds_agama
 * @property string $ppds_statusperkawinan
 * @property integer $programstudi_id
 * @property string $ppds_tahap
 * @property string $ppds_semestermasuk
 * @property string $tglmasuk_fk
 * @property string $tglmasuk_bagian
 * @property integer $pendidik_id
 * @property string $ppds_pembiayaan
 * @property string $ppds_asaldana
 * @property boolean $ikatandinas
 * @property string $ppds_foto
 * @property string $ppds_tgllulus
 * @property string $ppds_status
 * @property boolean $ppds_aktif
 * @property boolean $ppds_verifikasi
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 * @property integer $tahunakademik_id
 *
 * The followings are the available model relations:
 * @property OrientasidetT[] $orientasidetTs
 * @property CapaiankompetensiT[] $capaiankompetensiTs
 * @property PenelitiM[] $penelitiMs
 * @property PenilaianpradikdetT[] $penilaianpradikdetTs
 */
class PpdsM extends CActiveRecord {

    public $programstudi_nama, $pendidik_nama, $is_filter, $tahunakademik_tahun;
    public $tahun;
    public $file_sample, $tahap_selanjutnya;
    public $tahunakademik_tipe, $tahunakademik_awal, $tahunakademik_akhir;
    public $kompetensi_nama;
    public $default;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PpdsM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ppds_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ppds_nim, ppds_nik, ppds_nama, ppds_jeniskelamin, ppds_tempatlahir, ppds_tanggallahir, ppds_agama, ppds_statusperkawinan, programstudi_id, ppds_tahap, tglmasuk_fk, tglmasuk_bagian, ppds_pembiayaan, ppds_asaldana, ppds_status, create_loginpemakai_id, create_time, create_ruangan', 'required'),
            array('programstudi_id, pendidik_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('ppds_nim, ppds_nik, ppds_nama, ppds_jeniskelamin, ppds_tempatlahir, ppds_tanggallahir, ppds_agama, ppds_statusperkawinan, programstudi_id, ppds_tahap, tglmasuk_fk, tglmasuk_bagian, ppds_pembiayaan, ppds_asaldana, ppds_status, create_loginpemakai_id, create_time, create_ruangan', 'required'),
            array('programstudi_id, pendidik_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tahunakademik_id', 'numerical', 'integerOnly' => true),
            array('ppds_nim, ppds_nik, ppds_jeniskelamin', 'length', 'max' => 20),
            array('ppds_nama, ppds_tempatlahir, ppds_agama, ppds_tahap, ppds_pembiayaan, ppds_asaldana, ppds_status', 'length', 'max' => 100),
            array('ppds_statusperkawinan', 'length', 'max' => 25),
            array('ppds_semestermasuk', 'length', 'max' => 10),
            array('ppds_foto', 'length', 'max' => 255),
            array('ikatandinas, ppds_tgllulus, ppds_aktif, ppds_verifikasi, update_time,nonaktif_tgl,nonaktif_ket', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ppds_id, ppds_nim, ppds_nik, ppds_nama, ppds_jeniskelamin, ppds_tempatlahir, ppds_tanggallahir, ppds_agama, ppds_statusperkawinan, programstudi_id, ppds_tahap, ppds_semestermasuk, tglmasuk_fk, tglmasuk_bagian, pendidik_id, ppds_pembiayaan, ppds_asaldana, ikatandinas, ppds_foto, ppds_tgllulus, ppds_status, ppds_aktif, ppds_verifikasi, create_loginpemakai_id, update_loginpemakai_id, create_time, update_time, create_ruangan', 'safe', 'on' => 'search'),
            array('ppds_id, ppds_nim, ppds_nik, ppds_nama, ppds_jeniskelamin, ppds_tempatlahir, ppds_tanggallahir, ppds_agama, ppds_statusperkawinan, programstudi_id, ppds_tahap, ppds_semestermasuk, tglmasuk_fk, tglmasuk_bagian, pendidik_id, ppds_pembiayaan, ppds_asaldana, ikatandinas, ppds_foto, ppds_tgllulus, ppds_status, ppds_aktif, ppds_verifikasi, create_loginpemakai_id, update_loginpemakai_id, create_time, update_time, create_ruangan, tahunakademik_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'orientasidetTs' => array(self::HAS_MANY, 'OrientasidetT', 'ppds_id'),
            'capaiankompetensiTs' => array(self::HAS_MANY, 'CapaiankompetensiT', 'ppds_id'),
            'penelitiMs' => array(self::HAS_MANY, 'PenelitiM', 'ppds_id'),
            'penilaianpradikdetTs' => array(self::HAS_MANY, 'PenilaianpradikdetT', 'ppds_id'),
            'penilaianpradikdetTs' => array(self::HAS_MANY, 'PenilaianpradikdetT', 'ppds_id'),
            'capaiankompetensiTs' => array(self::HAS_MANY, 'CapaiankompetensiT', 'ppds_id'),
            'penelitiMs' => array(self::HAS_MANY, 'PenelitiM', 'ppds_id'),
            'programstudi' => array(self::BELONGS_TO, 'ProgramstudiM', 'programstudi_id'),
            'tahunakademik' => array(self::BELONGS_TO, 'TahunakademikM', 'tahunakademik_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ppds_id' => 'PPDS',
            'ppds_nim' => 'NIM',
            'ppds_nik' => 'NIK',
            'ppds_nama' => 'Nama',
            'ppds_jeniskelamin' => 'Jenis Kelamin',
            'ppds_tempatlahir' => 'Tempat Lahir',
            'ppds_tanggallahir' => 'Tanggal Lahir',
            'ppds_agama' => 'Agama',
            'ppds_statusperkawinan' => 'Status Perkawinan',
            'programstudi_id' => 'Program Studi',
            'ppds_tahap' => 'Tahap',
            'ppds_semestermasuk' => 'Semester Masuk',
            'tglmasuk_fk' => 'Tgl Masuk Fk',
            'tglmasuk_bagian' => 'Tgl Masuk Bagian',
            'pendidik_id' => 'Pendidik',
            'ppds_pembiayaan' => 'Pembiayaan',
            'ppds_asaldana' => 'Asal Dana',
            'ikatandinas' => 'Ikatan Dinas',
            'ppds_foto' => 'Foto',
            'ppds_tgllulus' => 'Tanggal Lulus',
            'ppds_status' => 'Status',
            'ppds_aktif' => 'Aktif',
            'ppds_verifikasi' => 'Verifikasi',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_ruangan' => 'Create Ruangan',
            'tahunakademik_id' => 'Tahunakademik',
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

        $criteria->compare('ppds_id', $this->ppds_id);
        $criteria->compare('ppds_nik', $this->ppds_nik, true);
        $criteria->compare('LOWER(ppds_nama)', strtolower($this->ppds_nama), true);
        $criteria->compare('LOWER(ppds_nim)', strtolower($this->ppds_nim), true);
        $criteria->compare('ppds_jeniskelamin', $this->ppds_jeniskelamin, true);
        $criteria->compare('ppds_tempatlahir', $this->ppds_tempatlahir, true);
        $criteria->compare('ppds_tanggallahir', $this->ppds_tanggallahir, true);
        $criteria->compare('ppds_agama', $this->ppds_agama, true);
        $criteria->compare('ppds_statusperkawinan', $this->ppds_statusperkawinan, true);
        $criteria->compare('programstudi_id', $this->programstudi_id);
        $criteria->compare('ppds_tahap', $this->ppds_tahap, true);
        $criteria->compare('ppds_semestermasuk', $this->ppds_semestermasuk, true);
        $criteria->compare('tglmasuk_fk', $this->tglmasuk_fk, true);
        $criteria->compare('tglmasuk_bagian', $this->tglmasuk_bagian, true);
        $criteria->compare('pendidik_id', $this->pendidik_id);
        $criteria->compare('ppds_pembiayaan', $this->ppds_pembiayaan, true);
        $criteria->compare('ppds_asaldana', $this->ppds_asaldana, true);
        $criteria->compare('ikatandinas', $this->ikatandinas);
        $criteria->compare('ppds_foto', $this->ppds_foto, true);
        $criteria->compare('ppds_tgllulus', $this->ppds_tgllulus, true);
        $criteria->compare('ppds_status', $this->ppds_status, true);
        $criteria->compare('ppds_aktif', $this->ppds_aktif);
        $criteria->compare('ppds_verifikasi', $this->ppds_verifikasi);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('tahunakademik_id', $this->tahunakademik_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function searchDialogPPDS() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('ppds_id', $this->ppds_id);
        $criteria->compare('ppds_nik', $this->ppds_nik, true);
        $criteria->compare('LOWER(ppds_nama)', strtolower($this->ppds_nama), true);
        $criteria->compare('LOWER(ppds_nim)', strtolower($this->ppds_nim), true);
        $criteria->compare('ppds_jeniskelamin', $this->ppds_jeniskelamin, true);
        $criteria->compare('ppds_tempatlahir', $this->ppds_tempatlahir, true);
        $criteria->compare('ppds_tanggallahir', $this->ppds_tanggallahir, true);
        $criteria->compare('ppds_agama', $this->ppds_agama, true);
        $criteria->compare('ppds_statusperkawinan', $this->ppds_statusperkawinan, true);
        $criteria->compare('programstudi_id', $this->programstudi_id);
        $criteria->compare('ppds_tahap', $this->ppds_tahap, true);
        $criteria->compare('ppds_semestermasuk', $this->ppds_semestermasuk, true);
        $criteria->compare('tglmasuk_fk', $this->tglmasuk_fk, true);
        $criteria->compare('tglmasuk_bagian', $this->tglmasuk_bagian, true);
        $criteria->compare('pendidik_id', $this->pendidik_id);
        $criteria->compare('ppds_pembiayaan', $this->ppds_pembiayaan, true);
        $criteria->compare('ppds_asaldana', $this->ppds_asaldana, true);
        $criteria->compare('ikatandinas', $this->ikatandinas);
        $criteria->compare('ppds_foto', $this->ppds_foto, true);
        $criteria->compare('ppds_tgllulus', $this->ppds_tgllulus, true);
        $criteria->compare('ppds_status', $this->ppds_status, true);
        $criteria->compare('ppds_aktif', $this->ppds_aktif);
        $criteria->addCondition('ppds_aktif =' . 'true');
        $criteria->compare('ppds_verifikasi', $this->ppds_verifikasi);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('tahunakademik_id', $this->tahunakademik_id);
        $criteria->order = 'ppds_nama';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchData() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $sort = new CSort;
        $criteria->select='t.*, p.programstudi_nama, a.tahunakademik_tahun';
        $criteria->join='join programstudi_m p on t.programstudi_id=p.programstudi_id '
                . 'join tahunakademik_m a on t.tahunakademik_id=a.tahunakademik_id ';
        
        $criteria->compare('ppds_aktif', $this->ppds_aktif);

        if (!empty($this->ppds_id)) {
            $criteria->addCondition('t.ppds_id is null');
        }
        $criteria->compare('LOWER(t.ppds_nim)', strtolower($this->ppds_nim), true);
        if (!empty($this->tahunakademik_id)) {
            $criteria->addCondition('t.tahunakademik_id =' . $this->tahunakademik_id);
        }
        $criteria->compare('LOWER(ppds_nama)', strtolower($this->ppds_nama), true);
        if (!empty($this->programstudi_id)) {
            $criteria->addCondition('t.programstudi_id =' . $this->programstudi_id);
        }
        $criteria->compare('p.programstudi_nama',$this->programstudi_nama);
        $criteria->compare('a.tahunakademik_tahun',$this->tahunakademik_tahun);
        
        $sort->attributes = array(
            'tahunakademik_tahun' => array(
                'asc' => "a.tahunakademik_tahun ASC",
                'desc' => "a.tahunakademik_tahun DESC"
            ),
            'programstudi_nama' => array(
                'asc' => "p.programstudi_nama ASC",
                'desc' => "p.programstudi_nama DESC"
            ),
        );

        $sort->defaultOrder = array(
            'programstudi_nama' => false
        );

//        $criteria->order = 'ppds_nim ASC, ppds_nama ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>$sort,
        ));
    }

    /**
     * Mencetak Dokumen master ppds
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('ppds_nim', $this->ppds_nim, true);
        if (!empty($this->tahunakademik_id)) {
            $criteria->addCondition('tahunakademik_id =' . $this->tahunakademik_id);
        }
        $criteria->compare('ppds_nama', $this->ppds_nama, true);
        if (!empty($this->programstudi_id)) {
            $criteria->addCondition('programstudi_id =' . $this->programstudi_id);
        }
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Fungsi untuk mencari data dosen wali
     * @return \CActiveDataProvider
     */
    public function searchDosen() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $sort = new CSort;
            if(!empty($this->pendidik_id)){
            $criteria->addCondition("pendidik_id = ".$this->pendidik_id);			
        }
        $criteria->select='t.*, m.programstudi_nama';
        $criteria->join='join programstudi_m m on t.programstudi_id=m.programstudi_id';
        $criteria->compare('t.ppds_id', $this->ppds_id);
        $criteria->compare('t.ppds_nim', $this->ppds_nim, true);
        $criteria->compare('t.ppds_nik', $this->ppds_nik, true);
        $criteria->compare('t.ppds_nama', $this->ppds_nama, true);
        $criteria->compare('t.ppds_jeniskelamin', $this->ppds_jeniskelamin, true);
        $criteria->compare('t.ppds_tempatlahir', $this->ppds_tempatlahir, true);
        $criteria->compare('t.ppds_tanggallahir', $this->ppds_tanggallahir, true);
        $criteria->compare('t.ppds_agama', $this->ppds_agama, true);
        $criteria->compare('t.ppds_statusperkawinan', $this->ppds_statusperkawinan, true);
        $criteria->compare('t.programstudi_id', $this->programstudi_id);
        $criteria->compare('m.programstudi_nama', $this->programstudi_nama);
        $criteria->compare('t.ppds_tahap', $this->ppds_tahap, true);
        $criteria->compare('t.ppds_semestermasuk', $this->ppds_semestermasuk, true);
        $criteria->compare('t.tglmasuk_fk', $this->tglmasuk_fk, true);
        $criteria->compare('t.tglmasuk_bagian', $this->tglmasuk_bagian, true);
        //$criteria->addCondition('pendidik_id IS NOT NULL OR pendidik_id='.$this->pendidik_id);
//        $criteria->compare('pendidik_id', $this->pendidik_id, true);
        $criteria->compare('LOWER(t.pendidik_nama)',strtolower($this->pendidik_nama),true);
        $criteria->compare('t.ppds_pembiayaan', $this->ppds_pembiayaan, true);
        $criteria->compare('t.ppds_asaldana', $this->ppds_asaldana, true);
        $criteria->compare('t.ikatandinas', $this->ikatandinas);
        $criteria->compare('t.ppds_foto', $this->ppds_foto, true);
        $criteria->compare('t.ppds_tgllulus', $this->ppds_tgllulus, true);
        $criteria->compare('t.ppds_status', $this->ppds_status, true);
        $criteria->compare('t.ppds_aktif', $this->ppds_aktif);
        $criteria->compare('t.ppds_verifikasi', $this->ppds_verifikasi);
        $criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('t.update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.update_time', $this->update_time, true);
        $criteria->compare('t.create_ruangan', $this->create_ruangan);
        $criteria->addCondition('t.pendidik_id IS NOT NULL');
        
        $sort->attributes = array(
            'programstudi_nama' => array(
                'asc' => "m.programstudi_nama ASC",
                'desc' => "m.programstudi_nama DESC"
            ),
            'ppds_nama' => array(
                'asc' => "t.ppds_nama ASC",
                'desc' => "t.ppds_nama DESC"
            ),
            'pendidik_id' => array(
                'asc' => "t.pendidik_id ASC",
                'desc' => "t.pendidik_id DESC"
            ),
        );

        $sort->defaultOrder = array(
            'programstudi_nama' => false
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>$sort,
        ));
    }

    /**
     * Fungsi untuk mencari data ppds di master dosen wali
     * @return \CActiveDataProvider
     */
    public function searchPendidik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('ppds_id', $this->ppds_id);
        $criteria->addCondition('ppds_aktif is true');
        $criteria->compare('programstudi_id', $this->programstudi_id);
        $criteria->compare('LOWER(ppds_nim)', strtolower($this->ppds_nim),true);
        $criteria->compare('LOWER(ppds_nama)', strtolower($this->ppds_nama),true);
        //$criteria->addCondition('pendidik_id IS NOT NULL AND pendidik_id='.$this->pendidik_id);
        if (!empty($this->pendidik_id)) {
            if (!empty($_GET['PpdsM']['is_filter'])) {
                if ($_GET['PpdsM']['is_filter'] == 3) {
                    $criteria->addCondition('pendidik_id IS NULL OR pendidik_id=' . $this->pendidik_id);
                } else if ($_GET['PpdsM']['is_filter'] == 1) {
                    $criteria->addCondition('pendidik_id IS NOT NULL AND pendidik_id=' . $this->pendidik_id);
                } else {
                    $criteria->addCondition('pendidik_id IS NULL');
                }
            } else {
                $criteria->addCondition('pendidik_id IS NULL OR pendidik_id=' . $this->pendidik_id);
            }
        } else {
            $criteria->addCondition('ppds_id IS NULL');
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Fungsi untuk mencetak dokumen
     * @return \CActiveDataProvider
     */
    public function searchPrintDosenwali() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if (!empty($this->programstudi_id)) {
            $criteria->addCondition('programstudi_id =' . $this->programstudi_id);
        }
        $criteria->addCondition('pendidik_id IS NOT NULL');
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Pencarian PPDS untuk Form Evaluasi Rekap
     * @return type
     */
    public function searchPPDSEvaluasi() {
        $prov = $this->search();
        $prov->criteria->addCondition('ppds_verifikasi = TRUE');
        $prov->criteria->addCondition("verifikasi_status = '" . Params::VERIFIKASI_DISETUJUI . "'");
        $prov->pagination = false;

        return $prov;
    }

    /**
     * Digunakan untuk pencarian dalam dialog
     * @author  Andyka <andykaputra@.com>
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('programstudi');

        if (!empty($this->programstudi_id)) {
            $criteria->addCondition("programstudi.programstudi_id = '" . $this->programstudi_id . "' ");
        }
        if (!empty($this->ppds_id)) {
            $criteria->addCondition("ppds_id = '" . $this->ppds_id . "' ");
        }
        if (!empty($this->default)){
            $criteria->addCondition(" ppds_id IS NULL ");
        }
        $criteria->compare('LOWER(ppds_nim)', strtolower($this->ppds_nim), true);
        $criteria->compare('LOWER(ppds_nama)', strtolower($this->ppds_nama), true);
        $criteria->compare('LOWER(programstudi.programstudi_nama)', strtolower($this->programstudi_nama), true);
        $criteria->compare('LOWER(ppds_tahap)', strtolower($this->ppds_tahap), true);
        $criteria->compare('LOWER(verifikasi_status)', strtolower($this->verifikasi_status), true);
        $criteria->compare('ppds_aktif', $this->ppds_aktif);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ppds_nim',
            )
        ));
    }

    /**
     * Pencarian data ppds dengan kondisi : 
     * ppds_verifikasi = true
     * verifikasi_status = Disetujui
     * @return \CActiveDataProvider
     */
    public function searchPPDS() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = " t.*, ps.programstudi_nama ";
        $criteria->join = " JOIN programstudi_m ps ON ps.programstudi_id = t.programstudi_id ";
        if (!empty($this->default)){
            $criteria->addCondition("t.ppds_id is null");
        }
        $criteria->addCondition('t.ppds_verifikasi = TRUE');
        $criteria->addCondition("t.verifikasi_status = '" . Params::VERIFIKASI_DISETUJUI . "'");
        $criteria->compare('t.ppds_id', $this->ppds_id);
        $criteria->compare('t.ppds_nik', $this->ppds_nik, true);
        $criteria->compare('ps.programstudi_nama', $this->programstudi_nama, true);
        
        $criteria->compare('LOWER(t.ppds_nama)', strtolower($this->ppds_nama), true);
        $criteria->compare('LOWER(t.ppds_nim)', strtolower($this->ppds_nim), true);
        $criteria->compare('t.ppds_jeniskelamin', $this->ppds_jeniskelamin, true);
        $criteria->compare('t.ppds_tempatlahir', $this->ppds_tempatlahir, true);
        $criteria->compare('t.ppds_tanggallahir', $this->ppds_tanggallahir, true);
        $criteria->compare('t.ppds_agama', $this->ppds_agama, true);
        $criteria->compare('t.ppds_statusperkawinan', $this->ppds_statusperkawinan, true);
        
        $criteria->compare('t.ppds_tahap', $this->ppds_tahap, true);
        $criteria->compare('t.ppds_semestermasuk', $this->ppds_semestermasuk, true);
        $criteria->compare('t.tglmasuk_fk', $this->tglmasuk_fk, true);
        $criteria->compare('t.tglmasuk_bagian', $this->tglmasuk_bagian, true);
        $criteria->compare('t.pendidik_id', $this->pendidik_id);
        $criteria->compare('t.ppds_pembiayaan', $this->ppds_pembiayaan, true);
        $criteria->compare('t.ppds_asaldana', $this->ppds_asaldana, true);
        $criteria->compare('t.ikatandinas', $this->ikatandinas);
        $criteria->compare('t.ppds_foto', $this->ppds_foto, true);
        $criteria->compare('t.ppds_tgllulus', $this->ppds_tgllulus, true);
        $criteria->compare('t.ppds_status', $this->ppds_status, true);
        $criteria->compare('t.ppds_aktif', $this->ppds_aktif);
        $criteria->compare('t.ppds_verifikasi', $this->ppds_verifikasi);
        $criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('t.update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.update_time', $this->update_time, true);
        $criteria->compare('t.create_ruangan', $this->create_ruangan);
        $criteria->compare('t.tahunakademik_id', $this->tahunakademik_id);
        
        //Ketika Login sebagai KPS
        $kps = Yii::app()->user->getState('kps_id');
        $loginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
        $modPegawai = PegawaiM::model()->findByPk($loginpemakai->pegawai_id);
        if(!empty($modPegawai->pegawai_id)){ //
            if($modPegawai->pegawai_id == $kps) {
                $disabled = true;    
                $cekProdi = ProgramstudiM::model()->findByAttributes(array('kps_id'=>$kps));
                $criteria->addCondition('t.programstudi_id = '.$cekProdi->programstudi_id);
            }else{
                if(!empty($this->programstudi_id)){
                    $criteria->addCondition('t.programstudi_id = '.$this->programstudi_id);
                }
            }
        }else{
            if(!empty($this->programstudi_id)){
                $criteria->addCondition('t.programstudi_id = '.$this->programstudi_id);
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ppds_nama',
            )
        ));
    }
    
    /**
     * Pencarian data ppds dengan kondisi : 
     * ppds_aktif = true
     * verifikasi_status = Disetujui
     * @return \CActiveDataProvider
     */
    public function searchPPDSPelayanan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if (!empty($this->default)){
            $criteria->addCondition("ppds_id is null");
        }
        $criteria->addCondition('ppds_aktif = TRUE');
        $criteria->addCondition("verifikasi_status = '" . Params::VERIFIKASI_DISETUJUI . "'");
        $criteria->compare('ppds_id', $this->ppds_id);
        $criteria->compare('ppds_nik', $this->ppds_nik, true);
        
        $criteria->compare('LOWER(ppds_nama)', strtolower($this->ppds_nama), true);
        $criteria->compare('LOWER(ppds_nim)', strtolower($this->ppds_nim), true);
        $criteria->compare('ppds_jeniskelamin', $this->ppds_jeniskelamin, true);
        $criteria->compare('ppds_tempatlahir', $this->ppds_tempatlahir, true);
        $criteria->compare('ppds_tanggallahir', $this->ppds_tanggallahir, true);
        $criteria->compare('ppds_agama', $this->ppds_agama, true);
        $criteria->compare('ppds_statusperkawinan', $this->ppds_statusperkawinan, true);
        
        $criteria->compare('ppds_tahap', $this->ppds_tahap, true);
        $criteria->compare('ppds_semestermasuk', $this->ppds_semestermasuk, true);
        $criteria->compare('tglmasuk_fk', $this->tglmasuk_fk, true);
        $criteria->compare('tglmasuk_bagian', $this->tglmasuk_bagian, true);
        $criteria->compare('pendidik_id', $this->pendidik_id);
        $criteria->compare('ppds_pembiayaan', $this->ppds_pembiayaan, true);
        $criteria->compare('ppds_asaldana', $this->ppds_asaldana, true);
        $criteria->compare('ikatandinas', $this->ikatandinas);
        $criteria->compare('ppds_foto', $this->ppds_foto, true);
        $criteria->compare('ppds_tgllulus', $this->ppds_tgllulus, true);
        $criteria->compare('ppds_status', $this->ppds_status, true);
        $criteria->compare('ppds_aktif', $this->ppds_aktif);
        $criteria->compare('ppds_verifikasi', $this->ppds_verifikasi);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('tahunakademik_id', $this->tahunakademik_id);
        
        //Ketika Login sebagai KPS
        $kps = Yii::app()->user->getState('kps_id');
        $loginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
        $modPegawai = PegawaiM::model()->findByPk($loginpemakai->pegawai_id);
        if(!empty($modPegawai->pegawai_id)){ //
            if($modPegawai->pegawai_id == $kps) {
                $disabled = true;    
                $cekProdi = ProgramstudiM::model()->findByAttributes(array('kps_id'=>$kps));
                $criteria->addCondition('programstudi_id = '.$cekProdi->programstudi_id);
            }else{
                if(!empty($this->programstudi_id)){
                    $criteria->addCondition('programstudi_id = '.$this->programstudi_id);
                }
            }
        }else{
            if(!empty($this->programstudi_id)){
                $criteria->addCondition('programstudi_id = '.$this->programstudi_id);
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ppds_nama',
            )
        ));
    }
    
    public function searchDialogPegawai(){
        
        return $this->searchPPDS();
        
    }
    
    public function searchcariPPDS()
    {
        $cri = new CDbCriteria();
        $cri->compare('LOWER(ppds_nama)', strtolower($this->ppds_nama), true);
        $cri->order = "ppds_nama ASC";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $cri,
        ));
    }

}
