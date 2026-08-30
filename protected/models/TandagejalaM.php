<?php

/**
 * This is the model class for table "tandagejala_m".
 *
 * The followings are the available columns in table 'tandagejala_m':
 * @property integer $tandagejala_id
 * @property integer $diagnosakep_id
 * @property string $tandagejala_indikator
 * @property boolean $tandagejala_aktif
 *
 * The followings are the available model relations:
 * @property PilihrencanaaskepT[] $pilihrencanaaskepTs
 * @property DiagnosakepM $diagnosakep
 */
class TandagejalaM extends CActiveRecord
{
        public $jenistandagejala_nama, $subjenistandagejala_nama, $tandagejala_daftar_nama;
        public $jenistandagejala;
        public $diagnosakep_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandagejalaM the static model class
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
		return 'tandagejala_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakep_id, tandagejala_aktif', 'required'),
			array('diagnosakep_id', 'numerical', 'integerOnly'=>true),
			array('tandagejala_indikator', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tandagejala_id, diagnosakep_id, tandagejala_indikator, tandagejala_aktif', 'safe', 'on'=>'search'),
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
			'pilihrencanaaskepTs' => array(self::HAS_MANY, 'PilihrencanaaskepT', 'tandagejala_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
			'kelompoktandagejaladaftar' => array(self::BELONGS_TO, 'KelompoktandagejaladaftarM', 'kelompoktandagejaladaftar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandagejala_id' => 'Tandagejala',
			'diagnosakep_id' => 'Diagnosakep',
			'tandagejala_indikator' => 'Tandagejala Indikator',
			'tandagejala_aktif' => 'Tandagejala Aktif',
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

		$criteria->compare('tandagejala_id',$this->tandagejala_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('tandagejala_indikator',$this->tandagejala_indikator,true);
		$criteria->compare('tandagejala_aktif',$this->tandagejala_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}