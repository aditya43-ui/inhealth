<?php

/**
 * This is the model class for table "jenistandagejala_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'jenistandagejala_m':
 * @property integer $jenistandagejala_id
 * @property string $jenistandagejala_nama
 * @property string $subjenistandagejala_nama
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property KelompoktandagejaladaftarM[] $kelompoktandagejaladaftarMs
 */
class JenistandagejalaM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JenistandagejalaM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jenistandagejala_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenistandagejala_nama, subjenistandagejala_nama, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
            array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly' => true),
            array('jenistandagejala_nama, subjenistandagejala_nama', 'length', 'max' => 50),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('jenistandagejala_id, jenistandagejala_nama, subjenistandagejala_nama, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'kelompoktandagejaladaftarMs' => array(self::HAS_MANY, 'KelompoktandagejaladaftarM', 'jenistandagejala_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'jenistandagejala_id' => 'Jenistandagejala',
            'jenistandagejala_nama' => 'Jenistandagejala Nama',
            'subjenistandagejala_nama' => 'Subjenistandagejala Nama',
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

        $criteria->compare('jenistandagejala_id', $this->jenistandagejala_id);
        $criteria->compare('jenistandagejala_nama', $this->jenistandagejala_nama, true);
        $criteria->compare('subjenistandagejala_nama', $this->subjenistandagejala_nama, true);
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
     * Set data dropdown jenis tanda gejala
     * @return array $data option untuk dropdown
     */
    public static function getDropDownJenis() {
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "jenistandagejala_nama ASC";
        $models = JenistandagejalaM::model()->findAll($criteria);
        if (count($models) > 0) {
            foreach ($models as $model) {
                $data[$model->jenistandagejala_id] = $model->jenistandagejala_nama . " - " . $model->subjenistandagejala_nama;
            }
        }
        return $data;
    }

}
