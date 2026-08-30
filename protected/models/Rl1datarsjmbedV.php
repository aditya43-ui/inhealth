<?php

/**
 * This is the model class for table "rl1datarsjmbed_v".
 *
 * The followings are the available columns in table 'rl1datarsjmbed_v':
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $jlmbed
 */
class Rl1datarsjmbedV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl1datarsjmbedV the static model class
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
		return 'rl1datarsjmbed_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('kelaspelayanan_nama', 'length', 'max'=>50),
			array('jlmbed', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelaspelayanan_id, kelaspelayanan_nama, jlmbed', 'safe', 'on'=>'search'),
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
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'jlmbed' => 'Jlmbed',
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

		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('jlmbed',$this->jlmbed,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}