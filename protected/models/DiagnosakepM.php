<?php

/**
 * This is the model class for table "diagnosakep_m".
 *
 * The followings are the available columns in table 'diagnosakep_m':
 * @property integer $diagnosakep_id
 * @property string $diagnosakep_kode
 * @property string $diagnosakep_nama
 * @property string $diagnosakep_deskripsi
 * @property boolean $diagnosakep_aktif
 *
 * The followings are the available model relations:
 * @property FaktorhubM[] $faktorhubMs
 * @property FaktorrisikoM[] $faktorrisikoMs
 * @property EvaluasiaskepdetT[] $evaluasiaskepdetTs
 * @property ImplementasiaskepdetT[] $implementasiaskepdetTs
 * @property RencanaaskepdetT[] $rencanaaskepdetTs
 * @property IntervensiM[] $intervensiMs
 * @property ImplementasikepM[] $implementasikepMs
 * @property AlternatifdxM[] $alternatifdxMs
 * @property TandagejalaM[] $tandagejalaMs
 * @property KriteriahasilM[] $kriteriahasilMs
 * @property TujuanM[] $tujuanMs
 * @property BataskarakteristikM[] $bataskarakteristikMs
 */
class DiagnosakepM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosakepM the static model class
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
		return 'diagnosakep_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakep_kode, diagnosakep_nama, diagnosakep_aktif', 'required'),
			array('diagnosakep_kode', 'length', 'max'=>10),
			array('diagnosakep_nama', 'length', 'max'=>200),
			array('diagnosakep_deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosakep_id, diagnosakep_kode, diagnosakep_nama, diagnosakep_deskripsi, diagnosakep_aktif', 'safe', 'on'=>'search'),
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
			'faktorhubMs' => array(self::HAS_MANY, 'FaktorhubM', 'diagnosakep_id'),
			'faktorrisikoMs' => array(self::HAS_MANY, 'FaktorrisikoM', 'diagnosakep_id'),
			'evaluasiaskepdetTs' => array(self::HAS_MANY, 'EvaluasiaskepdetT', 'diagnosakep_id'),
			'implementasiaskepdetTs' => array(self::HAS_MANY, 'ImplementasiaskepdetT', 'diagnosakep_id'),
			'rencanaaskepdetTs' => array(self::HAS_MANY, 'RencanaaskepdetT', 'diagnosakep_id'),
			'intervensiMs' => array(self::HAS_MANY, 'IntervensiM', 'diagnosakep_id'),
			'implementasikepMs' => array(self::HAS_MANY, 'ImplementasikepM', 'diagnosakep_id'),
			'alternatifdxMs' => array(self::HAS_MANY, 'AlternatifdxM', 'diagnosakep_id'),
			'tandagejalaMs' => array(self::HAS_MANY, 'TandagejalaM', 'diagnosakep_id'),
			'kriteriahasilMs' => array(self::HAS_MANY, 'KriteriahasilM', 'diagnosakep_id'),
			'tujuanMs' => array(self::HAS_MANY, 'TujuanM', 'diagnosakep_id'),
			'bataskarakteristikMs' => array(self::HAS_MANY, 'BataskarakteristikM', 'diagnosakep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'diagnosakep_id' => 'Diagnosakep',
			'diagnosakep_kode' => 'Kode Diagnosa',
			'diagnosakep_nama' => 'Nama Diagnosa',
			'diagnosakep_deskripsi' => 'Diagnosakep Deskripsi',
			'diagnosakep_aktif' => 'Diagnosakep Aktif',
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

		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('LOWER(diagnosakep_kode)',strtolower($this->diagnosakep_kode),true);
		$criteria->compare('LOWER(diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(diagnosakep_deskripsi)',strtolower($this->diagnosakep_deskripsi),true);
		$criteria->compare('diagnosakep_aktif',$this->diagnosakep_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}