<?php

/**
 * This is the model class for table "indikatorimplkepdet_m".
 *
 * The followings are the available columns in table 'indikatorimplkepdet_m':
 * @property integer $indikatorimplkepdet_id
 * @property integer $implementasikep_id
 * @property string $indikatorimplkepdet_indikator
 * @property boolean $indikatorimplkepdet_aktif
 *
 * The followings are the available model relations:
 * @property ImplementasikepM $implementasikep
 * @property PilihimplementasiaskepT[] $pilihimplementasiaskepTs
 */
class IndikatorimplkepdetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndikatorimplkepdetM the static model class
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
		return 'indikatorimplkepdet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('implementasikep_id, indikatorimplkepdet_indikator, indikatorimplkepdet_aktif', 'required'),
			array('implementasikep_id', 'numerical', 'integerOnly'=>true),
			array('indikatorimplkepdet_indikator', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('indikatorimplkepdet_id, implementasikep_id, indikatorimplkepdet_indikator, indikatorimplkepdet_aktif', 'safe', 'on'=>'search'),
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
			'implementasikep' => array(self::BELONGS_TO, 'ImplementasikepM', 'implementasikep_id'),
			'pilihimplementasiaskepTs' => array(self::HAS_MANY, 'PilihimplementasiaskepT', 'indikatorimplkepdet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'indikatorimplkepdet_id' => 'Indikatorimplkepdet',
			'implementasikep_id' => 'Implementasikep',
			'indikatorimplkepdet_indikator' => 'Indikatorimplkepdet Indikator',
			'indikatorimplkepdet_aktif' => 'Indikatorimplkepdet Aktif',
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

		$criteria->compare('indikatorimplkepdet_id',$this->indikatorimplkepdet_id);
		$criteria->compare('implementasikep_id',$this->implementasikep_id);
		$criteria->compare('indikatorimplkepdet_indikator',$this->indikatorimplkepdet_indikator,true);
		$criteria->compare('indikatorimplkepdet_aktif',$this->indikatorimplkepdet_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}