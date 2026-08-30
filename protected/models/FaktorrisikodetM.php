<?php

/**
 * This is the model class for table "faktorrisikodet_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'faktorrisikodet_m':
 * @property integer $faktorrisikodet_id
 * @property integer $faktorrisiko_id
 * @property string $faktorrisikodet_indikator
 * @property boolean $faktorrisikodet_aktif
 * @property integer $faktorrisiko_daftar_id
 *
 * The followings are the available model relations:
 * @property FaktorrisikoM $faktorrisiko
 */
class FaktorrisikodetM extends CActiveRecord
{
    public $diagnosakep_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FaktorrisikodetM the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'faktorrisikodet_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('faktorrisiko_id, faktorrisikodet_indikator, faktorrisikodet_aktif', 'required'),
            array('faktorrisiko_id, faktorrisiko_daftar_id', 'numerical', 'integerOnly'=>true),
            array('faktorrisikodet_indikator', 'length', 'max'=>200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('faktorrisikodet_id, faktorrisiko_id, faktorrisikodet_indikator, faktorrisikodet_aktif, faktorrisiko_daftar_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'faktorrisiko' => array(self::BELONGS_TO, 'FaktorrisikoM', 'faktorrisiko_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'faktorrisikodet_id' => 'Faktorrisikodet',
            'faktorrisiko_id' => 'Faktorrisiko',
            'faktorrisikodet_indikator' => 'Faktorrisikodet Indikator',
            'faktorrisikodet_aktif' => 'Faktorrisikodet Aktif',
            'faktorrisiko_daftar_id' => 'Faktorrisiko Daftar',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('faktorrisikodet_id',$this->faktorrisikodet_id);
        $criteria->compare('faktorrisiko_id',$this->faktorrisiko_id);
        $criteria->compare('faktorrisikodet_indikator',$this->faktorrisikodet_indikator,true);
        $criteria->compare('faktorrisikodet_aktif',$this->faktorrisikodet_aktif);
        $criteria->compare('faktorrisiko_daftar_id',$this->faktorrisiko_daftar_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}