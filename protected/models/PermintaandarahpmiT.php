<?php

/**
 * This is the model class for table "permintaandarahpmi_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * The followings are the available columns in table 'permintaandarahpmi_t':
 * @property integer $permintaandarahpmi_id
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property integer $petugas_id
 * @property string $tgl_permintaan
 * @property string $no_permintaan
 * @property string $keterangan_permintaan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property InstalasiM $instalasi
 * @property PegawaiM $petugas
 * @property PermintaandarahpmidetT[] $permintaandarahpmidetTs
 * 
 * @package application.models
 */
class PermintaandarahpmiT extends CActiveRecord {

    public $petugas_nama, $ruangan_nama, $instalasi_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PermintaandarahpmiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'permintaandarahpmi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('create_time, petugas_id, create_loginpemakai_id, no_permintaan, tgl_permintaan', 'required'),
            array('ruangan_id, instalasi_id', 'numerical', 'integerOnly' => true),
            array('no_permintaan', 'length', 'max' => 100),
            array('tgl_permintaan, keterangan_permintaan, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('permintaandarahpmi_id, ruangan_id, instalasi_id, petugas_id, tgl_permintaan, no_permintaan, keterangan_permintaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
            'permintaandarahpmidetTs' => array(self::HAS_MANY, 'PermintaandarahpmidetT', 'permintaandarahpmi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'permintaandarahpmi_id' => 'Permintaandarahpmi',
            'ruangan_id' => 'Ruangan',
            'instalasi_id' => 'Instalasi',
            'petugas_id' => 'Petugas',
            'tgl_permintaan' => 'Tanggal Permintaan',
            'no_permintaan' => 'No. Permintaan',
            'keterangan_permintaan' => 'Keterangan Permintaan',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'ruangan_nama' => 'Ruangan',
            'instalasi_nama' => 'Instalasi',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->permintaandarahpmi_id)) {
            $criteria->addCondition('permintaandarahpmi_id = ' . $this->permintaandarahpmi_id);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        if (!empty($this->petugas_id)) {
            $criteria->addCondition('petugas_id = ' . $this->petugas_id);
        }
        $criteria->compare('LOWER(tgl_permintaan)', strtolower($this->tgl_permintaan), true);
        $criteria->compare('LOWER(no_permintaan)', strtolower($this->no_permintaan), true);
        $criteria->compare('LOWER(keterangan_permintaan)', strtolower($this->keterangan_permintaan), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);

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
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
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

}
