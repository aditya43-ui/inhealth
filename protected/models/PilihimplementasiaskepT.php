<?php

/**
 * This is the model class for table "pilihimplementasiaskep_t".
 *
 * The followings are the available columns in table 'pilihimplementasiaskep_t':
 * @property integer $pilihimplementasiaskep_id
 * @property integer $implementasiaskepdet_id
 * @property integer $indikatorimplkepdet_id
 * @property integer $alternatifdx_id
 *
 * The followings are the available model relations:
 * @property ImplementasiaskepdetT $implementasiaskepdet
 * @property IndikatorimplkepdetM $indikatorimplkepdet
 */
class PilihimplementasiaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PilihimplementasiaskepT the static model class
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
		return 'pilihimplementasiaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('implementasiaskepdet_id', 'required'),
			array('implementasiaskepdet_id, indikatorimplkepdet_id, alternatifdx_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pilihimplementasiaskep_id, implementasiaskepdet_id, indikatorimplkepdet_id, alternatifdx_id', 'safe', 'on'=>'search'),
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
			'implementasiaskepdet' => array(self::BELONGS_TO, 'ImplementasiaskepdetT', 'implementasiaskepdet_id'),
			'indikatorimplkepdet' => array(self::BELONGS_TO, 'IndikatorimplkepdetM', 'indikatorimplkepdet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pilihimplementasiaskep_id' => 'Pilihimplementasiaskep',
			'implementasiaskepdet_id' => 'Implementasiaskepdet',
			'indikatorimplkepdet_id' => 'Indikatorimplkepdet',
			'alternatifdx_id' => 'Alternatifdx',
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

		$criteria->compare('pilihimplementasiaskep_id',$this->pilihimplementasiaskep_id);
		$criteria->compare('implementasiaskepdet_id',$this->implementasiaskepdet_id);
		$criteria->compare('indikatorimplkepdet_id',$this->indikatorimplkepdet_id);
		$criteria->compare('alternatifdx_id',$this->alternatifdx_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}