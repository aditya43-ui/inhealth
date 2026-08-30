<?php

/**
 * This is the model class for table "pejabatpengadaandet_m".
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pejabatpengadaandet_m':
 * @property integer $pejabatpengadaan_id
 * @property integer $instalasi_id
 *
 * The followings are the available model relations:
 * @property InstalasiM $instalasi
 * @property PejabatpengadaanM $pejabatpengadaan
 */
class PejabatpengadaandetM extends CActiveRecord
{
        public $instalasi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PejabatpengadaandetM the static model class
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
		return 'pejabatpengadaandet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pejabatpengadaan_id, instalasi_id', 'required'),
			array('pejabatpengadaan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pejabatpengadaan_id, instalasi_id', 'safe', 'on'=>'search'),
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
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'pejabatpengadaan' => array(self::BELONGS_TO, 'PejabatpengadaanM', 'pejabatpengadaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pejabatpengadaan_id' => 'Pejabatpengadaan',
			'instalasi_id' => 'Instalasi',
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

		$criteria->compare('pejabatpengadaan_id',$this->pejabatpengadaan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}