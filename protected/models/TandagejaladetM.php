<?php

/**
 * This is the model class for table "tandagejaladet_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'tandagejaladet_m':
 * @property integer $tandagejaladet_id
 * @property integer $tandagejala_id
 * @property string $tandagejala_indikator
 * @property boolean $tandagejaladet_aktif
 *
 * The followings are the available model relations:
 * @property TandagejalaM $tandagejala
 */
class TandagejaladetM extends CActiveRecord
{
    public $diagnosakep_id, $kelompoktandagejala, $subkelompoktandagejala;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandagejaladetM the static model class
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
		return 'tandagejaladet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandagejala_id', 'required'),
			array('tandagejala_id', 'numerical', 'integerOnly'=>true),
			//array('tandagejala_indikator', 'length', 'max'=>200),
			array('tandagejala_daftar_id, tandagejaladet_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tandagejaladet_id, tandagejala_id, tandagejala_indikator, tandagejaladet_aktif', 'safe', 'on'=>'search'),
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
			'tandagejala' => array(self::BELONGS_TO, 'TandagejalaM', 'tandagejala_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandagejaladet_id' => 'Tandagejaladet',
			'tandagejala_id' => 'Tandagejala',
			'tandagejala_indikator' => 'Tandagejala Indikator',
			'tandagejaladet_aktif' => 'Tandagejaladet Aktif',
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

		$criteria->compare('tandagejaladet_id',$this->tandagejaladet_id);
		$criteria->compare('tandagejala_id',$this->tandagejala_id);
		$criteria->compare('tandagejala_indikator',$this->tandagejala_indikator,true);
                $criteria->compare('tandagejaladet_aktif',isset($this->tandagejaladet_aktif)?$this->tandagejaladet_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}