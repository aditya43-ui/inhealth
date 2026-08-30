<?php

/**
 * This is the model class for table "layarloket_m".
 *
 * The followings are the available columns in table 'layarloket_m':
 * @property integer $loket_id
 * @property integer $layarantrian_id
 */
class LayarloketM extends CActiveRecord
{

        public $modelantrian_id;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LayarloketM the static model class
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
		return 'layarloket_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('loket_id, layarantrian_id', 'required'),
			array('loket_id, layarantrian_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('loket_id, layarantrian_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'loket_id' => 'Loket',
			'layarantrian_id' => 'Layarantrian',
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

		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('layarantrian_id',$this->layarantrian_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}