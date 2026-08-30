<?php

/**
 * This is the model class for table "carabayarkeluarrek_m".
 *
 * The followings are the available columns in table 'carabayarkeluarrek_m':
 * @property integer $carabayarkeluarrek_id
 * @property string $carabayarkeluar
 * @property integer $rekening5_id
 * @property string $debitkredit
 *
 * The followings are the available model relations:
 * @property Rekening5M $rekening5
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.models
 * @category model
 */
class CarabayarkeluarrekM extends CActiveRecord
{
    public $kdrekening4, $kdrekening5, $nmrekening3, $nmrekening4, $nmrekening5, $rekening1_id,$rekening2_id, $rekening3_id, $rekening4_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarabayarkeluarrekM the static model class
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
		return 'carabayarkeluarrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayarkeluar, rekening5_id, debitkredit', 'required'),
			array('rekening5_id', 'numerical', 'integerOnly'=>true),
			array('carabayarkeluar', 'length', 'max'=>50),
			array('debitkredit', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('carabayarkeluarrek_id, carabayarkeluar, rekening5_id, debitkredit', 'safe', 'on'=>'search'),
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
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'carabayarkeluarrek_id' => 'Carabayarkeluarrek',
			'carabayarkeluar' => 'Cara Bayar Keluar',
			'rekening5_id' => 'Rekening5',
			'debitkredit' => 'Debitkredit',
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

		$criteria->compare('carabayarkeluarrek_id',$this->carabayarkeluarrek_id);
		$criteria->compare('carabayarkeluar',$this->carabayarkeluar,true);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}