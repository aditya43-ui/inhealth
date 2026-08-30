<?php

/**
 * This is the model class for table "programstudi_m".
 * 
 * @author          Yusuf Putra Anugrah<yusufputra@.com>
 * @author          Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-2233
 * @package         application.models
 * 
 *
 * The followings are the available columns in table 'programstudi_m':
 * @property integer $programstudi_id
 * @property string $programstudi_kode
 * @property string $programstudi_nama
 * @property string $programstudi_namalainnya
 * @property string $programstudi_singkatan
 * @property string $programstudi_visi
 * @property string $programstudi_misi
 * @property string $programstudi_deskripsikurikulum
 * @property string $programstudi_deskripsistdpendidikan
 * @property integer $kps_id
 * @property boolean $programstudi_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class ProgramstudiM extends CActiveRecord {

    public $default;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProgramstudiM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'programstudi_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('programstudi_kode, prodi_satuanstase, programstudi_nama, kps_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('kps_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('programstudi_kode', 'length', 'max' => 10),
            array('programstudi_nama, programstudi_namalainnya', 'length', 'max' => 255),
            array('programstudi_visi', 'length', 'max' => 500),
            array('programstudi_singkatan', 'length', 'max' => 25),
            array('programstudi_misi, programstudi_email, programstudi_fax, programstudi_telepon, programstudi_lokasi, programstudi_deskripsikurikulum, programstudi_deskripsistdpendidikan, programstudi_aktif, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('programstudi_id, programstudi_kode, programstudi_nama, programstudi_namalainnya, programstudi_singkatan, programstudi_visi, programstudi_misi, programstudi_deskripsikurikulum, programstudi_deskripsistdpendidikan, kps_id, programstudi_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'programstudi_id' => 'Programstudi',
            'programstudi_kode' => 'Programstudi Kode',
            'programstudi_nama' => 'Nama Program Studi',
            'programstudi_namalainnya' => 'Programstudi Namalainnya',
            'prodi_satuanstase' => 'Satuan Lama Stase',
            'programstudi_singkatan' => 'Programstudi Singkatan',
            'programstudi_visi' => 'Programstudi Visi',
            'programstudi_misi' => 'Programstudi Misi',
            'programstudi_deskripsikurikulum' => 'Programstudi Deskripsikurikulum',
            'programstudi_deskripsistdpendidikan' => 'Programstudi Deskripsistdpendidikan',
            'kps_id' => 'Kps',
            'programstudi_aktif' => 'Programstudi Aktif',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Load data
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;
        $criteria->compare('programstudi_id', $this->programstudi_id);
        $criteria->compare('lower(programstudi_kode)', strtolower($this->programstudi_kode), true);
        $criteria->compare('LOWER(programstudi_nama)', strtolower($this->programstudi_nama), true);
        $criteria->compare('LOWER(programstudi_namalainnya)', strtolower($this->programstudi_namalainnya), true);
        $criteria->compare('LOWER(programstudi_singkatan)', strtolower($this->programstudi_singkatan), true);
        $criteria->compare('LOWER(programstudi_visi)', strtolower($this->programstudi_visi), true);
        $criteria->compare('LOWER(programstudi_misi)', strtolower($this->programstudi_misi), true);
        $criteria->compare('LOWER(programstudi_deskripsikurikulum)', strtolower($this->programstudi_deskripsikurikulum), true);
        $criteria->compare('LOWER(programstudi_deskripsistdpendidikan)', strtolower($this->programstudi_deskripsistdpendidikan), true);
        $criteria->compare('kps_id', $this->kps_id);
        $criteria->compare('programstudi_aktif', $this->programstudi_aktif);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        if (!empty($this->default)){
            $criteria->addCondition(" programstudi_id IS NULL ");
        }
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
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data cetak
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Load data program studi
     * @return type
     */
    public function getProgramStudiItems() {
        return CHtml::listData(
            $this->findAll('programstudi_aktif = true order by programstudi_nama ASC'), 'programstudi_id', 'programstudi_nama'
        );
    }
    
    /**
     * Load prodi aktif
     * @return \CActiveDataProvider
     */
    public function searchProdiAktif(){
        $criteria = $this->criteriaSearch();
        $criteria->addCondition("programstudi_aktif is true");
        $criteria->order = "programstudi_nama ASC";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
