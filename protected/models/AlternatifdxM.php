<?php

/**
 * This is the model class for table "alternatifdx_m".
 *
 * The followings are the available columns in table 'alternatifdx_m':
 * @property integer $alternatifdx_id
 * @property integer $diagnosakep_id
 * @property string $alternatifdx_nama
 * @property boolean $alternatifdx_aktif
 *
 * The followings are the available model relations:
 * @property DiagnosakepM $diagnosakep
 */
class AlternatifdxM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlternatifdxM the static model class
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
		return 'alternatifdx_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakep_id, alternatifdx_nama, alternatifdx_aktif', 'required'),
			array('diagnosakep_id', 'numerical', 'integerOnly'=>true),
			array('alternatifdx_nama', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('alternatifdx_id, diagnosakep_id, alternatifdx_nama, alternatifdx_aktif', 'safe', 'on'=>'search'),
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
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alternatifdx_id' => 'Alternatifdx',
			'diagnosakep_id' => 'Diagnosakep',
			'alternatifdx_nama' => 'Alternatifdx Nama',
			'alternatifdx_aktif' => 'Alternatifdx Aktif',
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

		$criteria->compare('alternatifdx_id',$this->alternatifdx_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('alternatifdx_nama',$this->alternatifdx_nama,true);
		$criteria->compare('alternatifdx_aktif',$this->alternatifdx_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}