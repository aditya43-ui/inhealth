<?php

/**
 * This is the model class for table "bataskarakteristikdet_m".
 *
 * The followings are the available columns in table 'bataskarakteristikdet_m':
 * @property integer $bataskarakteristikdet_id
 * @property integer $bataskarakteristik_id
 * @property string $bataskarakteristikdet_indikator
 * @property boolean $bataskarakteristikdet_aktif
 * @property integer $faktorpenyebab_daftar_id
 *
 * The followings are the available model relations:
 * @property BataskarakteristikM $bataskarakteristik
 */
class BataskarakteristikdetM extends CActiveRecord
{
    public $varSort1;
    public $faktorpenyebab_daftar_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BataskarakteristikdetM the static model class
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
        return 'bataskarakteristikdet_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bataskarakteristik_id, bataskarakteristikdet_indikator, bataskarakteristikdet_aktif', 'required'),
            array('bataskarakteristik_id, faktorpenyebab_daftar_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bataskarakteristikdet_id, bataskarakteristik_id, bataskarakteristikdet_indikator, bataskarakteristikdet_aktif, faktorpenyebab_daftar_id', 'safe', 'on'=>'search'),
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
            'faktorpenyebabDaftar' => array(self::BELONGS_TO, 'FaktoryebabDaftarM', 'faktorpenyebab_daftar_id'),
            'bataskarakteristik' => array(self::BELONGS_TO, 'BataskarakteristikM', 'bataskarakteristik_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'bataskarakteristikdet_id' => 'Bataskarakteristikdet',
            'bataskarakteristik_id' => 'Bataskarakteristik',
            'bataskarakteristikdet_indikator' => 'Bataskarakteristikdet Indikator',
            'bataskarakteristikdet_aktif' => 'Bataskarakteristikdet Aktif',
            'faktorpenyebab_daftar_id' => 'Faktorpenyebab Daftar',
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

        $criteria->compare('bataskarakteristikdet_id',$this->bataskarakteristikdet_id);
        $criteria->compare('bataskarakteristik_id',$this->bataskarakteristik_id);
        $criteria->compare('bataskarakteristikdet_indikator',$this->bataskarakteristikdet_indikator,true);
        $criteria->compare('bataskarakteristikdet_aktif',$this->bataskarakteristikdet_aktif);
        $criteria->compare('faktorpenyebab_daftar_id',$this->faktorpenyebab_daftar_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
}