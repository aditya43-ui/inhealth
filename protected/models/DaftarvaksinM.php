<?php

/**
 * This is the model class for table "daftarvaksin_m".
 *
 * The followings are the available columns in table 'daftarvaksin_m':
 * @property integer $daftarvaksin_id
 * @property integer $vaksin_id
 * @property string $daftarvaksin_nama
 * @property integer $urutan
 * @property boolean $daftarvaksin_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property VaksinM $vaksin
 */
class DaftarvaksinM extends CActiveRecord {

    public $jenisvaksin_id;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'daftarvaksin_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('vaksin_id, daftarvaksin_nama, urutan, create_time, create_loginpemakai_id', 'required'),
            array('vaksin_id, urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('daftarvaksin_nama', 'length', 'max' => 100),
            array('daftarvaksin_aktif, update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('daftarvaksin_id, vaksin_id, daftarvaksin_nama, urutan, daftarvaksin_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vaksin' => array(self::BELONGS_TO, 'VaksinM', 'vaksin_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'daftarvaksin_id' => 'Daftarvaksin',
            'vaksin_id' => 'Vaksin',
            'daftarvaksin_nama' => 'Daftarvaksin Nama',
            'urutan' => 'Urutan',
            'daftarvaksin_aktif' => 'Daftarvaksin Aktif',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('daftarvaksin_id', $this->daftarvaksin_id);
        $criteria->compare('vaksin_id', $this->vaksin_id);
        $criteria->compare('daftarvaksin_nama', $this->daftarvaksin_nama, true);
        $criteria->compare('urutan', $this->urutan);
        $criteria->compare('daftarvaksin_aktif', $this->daftarvaksin_aktif);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DaftarvaksinM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    

}
