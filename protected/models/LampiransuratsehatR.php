<?php

/**
 * This is the model class for table "lampiransuratsehat_r".
 *
 * The followings are the available columns in table 'lampiransuratsehat_r':
 * @property integer $lampiransuratsehat_id
 * @property integer $suratketerangan_id
 * @property string $lampiransuratsehat_nama
 */
class LampiransuratsehatR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LampiransuratsehatR the static model class
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
		return 'lampiransuratsehat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suratketerangan_id, lampiransuratsehat_nama', 'required'),
			array('suratketerangan_id', 'numerical', 'integerOnly'=>true),
			array('lampiransuratsehat_nama', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lampiransuratsehat_id, suratketerangan_id, lampiransuratsehat_nama', 'safe', 'on'=>'search'),
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
			'lampiransuratsehat_id' => 'Lampiransuratsehat',
			'suratketerangan_id' => 'Suratketerangan',
			'lampiransuratsehat_nama' => 'Lampiransuratsehat Nama',
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

		$criteria->compare('lampiransuratsehat_id',$this->lampiransuratsehat_id);
		$criteria->compare('suratketerangan_id',$this->suratketerangan_id);
		$criteria->compare('lampiransuratsehat_nama',$this->lampiransuratsehat_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}