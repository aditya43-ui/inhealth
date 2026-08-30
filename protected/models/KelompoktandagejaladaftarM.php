<?php

/**
 * This is the model class for table "kelompoktandagejaladaftar_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'kelompoktandagejaladaftar_m':
 * @property integer $kelompoktandagejaladaftar_id
 * @property integer $jenistandagejala_id
 * @property integer $tandagejala_daftar_id
 * @property boolean $jenistandagejaladaftar_aktif
 * @property integer $jenistandagejaladaftar_urutan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property TandagejalaDaftarM $tandagejalaDaftar
 * @property JenistandagejalaM $jenistandagejala
 */
class KelompoktandagejaladaftarM extends CActiveRecord {

    public $tandagejala_daftar_nama, $jenistandagejala_nama, $subjenistandagejala_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompoktandagejaladaftarM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kelompoktandagejaladaftar_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenistandagejala_id, tandagejala_daftar_id, jenistandagejaladaftar_aktif, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
            array('jenistandagejala_id, tandagejala_daftar_id, jenistandagejaladaftar_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly' => true),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kelompoktandagejaladaftar_id, jenistandagejala_id, tandagejala_daftar_id, jenistandagejaladaftar_aktif, jenistandagejaladaftar_urutan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tandagejalaDaftar' => array(self::BELONGS_TO, 'TandagejalaDaftarM', 'tandagejala_daftar_id'),
            'jenistandagejala' => array(self::BELONGS_TO, 'JenistandagejalaM', 'jenistandagejala_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'kelompoktandagejaladaftar_id' => 'Kelompoktandagejaladaftar',
            'jenistandagejala_id' => 'Jenistandagejala',
            'tandagejala_daftar_id' => 'Tandagejala Daftar',
            'jenistandagejaladaftar_aktif' => 'Jenistandagejaladaftar Aktif',
            'jenistandagejaladaftar_urutan' => 'Jenistandagejaladaftar Urutan',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan_id' => 'Create Ruangan',
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

        $criteria->compare('kelompoktandagejaladaftar_id', $this->kelompoktandagejaladaftar_id);
        $criteria->compare('jenistandagejala_id', $this->jenistandagejala_id);
        $criteria->compare('tandagejala_daftar_id', $this->tandagejala_daftar_id);
        $criteria->compare('jenistandagejaladaftar_aktif',isset($this->jenistandagejaladaftar_aktif)?$this->jenistandagejaladaftar_aktif:true);
        $criteria->compare('jenistandagejaladaftar_urutan', $this->jenistandagejaladaftar_urutan);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan_id', $this->create_ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchTandaGejala() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->select = 't.kelompoktandagejaladaftar_id, t.jenistandagejala_id, jenis.jenistandagejala_nama, jenis.subjenistandagejala_nama, '
                          . 't.tandagejala_daftar_id, daftar.tandagejala_daftar_nama';
        $criteria->join = 'JOIN tandagejala_daftar_m as daftar ON t.tandagejala_daftar_id = daftar.tandagejala_daftar_id '
                        . 'JOIN jenistandagejala_m   as jenis  ON t.jenistandagejala_id   = jenis.jenistandagejala_id';
        $criteria->compare('LOWER(daftar.tandagejala_daftar_nama)', strtolower($this->tandagejala_daftar_nama), true);
        if(!empty($this->jenistandagejala_id)){
            $criteria->addCondition('t.jenistandagejala_id = '.$this->jenistandagejala_id);
        }
        $criteria->addCondition('t.jenistandagejaladaftar_aktif is true');

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

        $criteria = new CDbCriteria;

        $criteria->compare('kelompoktandagejaladaftar_id', $this->kelompoktandagejaladaftar_id);
        $criteria->compare('jenistandagejala_id', $this->jenistandagejala_id);
        $criteria->compare('tandagejala_daftar_id', $this->tandagejala_daftar_id);
        $criteria->compare('jenistandagejaladaftar_aktif',isset($this->jenistandagejaladaftar_aktif)?$this->jenistandagejaladaftar_aktif:true);
        $criteria->compare('jenistandagejaladaftar_urutan', $this->jenistandagejaladaftar_urutan);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan_id', $this->create_ruangan_id);
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
}
