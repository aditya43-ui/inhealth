<?php

/**
 * This is the model class for table "insidenrsdet_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'insidenrsdet_t':
 * @property integer $insidenrsdet_id
 * @property integer $insidenrs_id
 * @property integer $kelompoksubtipeinsiden_id
 * @property integer $subtipeinsiden_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SubtipeinsidenM $subtipeinsiden
 * @property KelompoksubtipeinsidenM $kelompoksubtipeinsiden
 * @property InsidenrsT $insidenrs
 */
class InsidenrsdetT extends CActiveRecord {

    public $pilih, $tipeinsiden;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsidenrsdetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'insidenrsdet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('insidenrs_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('insidenrs_id, kelompoksubtipeinsiden_id, subtipeinsiden_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('insidenrsdet_id, insidenrs_id, kelompoksubtipeinsiden_id, subtipeinsiden_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subtipeinsiden' => array(self::BELONGS_TO, 'SubtipeinsidenM', 'subtipeinsiden_id'),
            'kelompoksubtipeinsiden' => array(self::BELONGS_TO, 'KelompoksubtipeinsidenM', 'kelompoksubtipeinsiden_id'),
            'insidenrs' => array(self::BELONGS_TO, 'InsidenrsT', 'insidenrs_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'insidenrsdet_id' => 'Insidenrsdet',
            'insidenrs_id' => 'Insidenrs',
            'kelompoksubtipeinsiden_id' => 'Kelompoksubtipeinsiden',
            'subtipeinsiden_id' => 'Subtipeinsiden',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
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

        $criteria->compare('insidenrsdet_id', $this->insidenrsdet_id);
        $criteria->compare('insidenrs_id', $this->insidenrs_id);
        $criteria->compare('kelompoksubtipeinsiden_id', $this->kelompoksubtipeinsiden_id);
        $criteria->compare('subtipeinsiden_id', $this->subtipeinsiden_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
