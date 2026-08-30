<?php

/**
 * This is the model class for table "implementasiaskepdet_t".
 *
 * The followings are the available columns in table 'implementasiaskepdet_t':
 * @property integer $implementasiaskepdet_id
 * @property integer $implementasiaskep_id
 * @property integer $diagnosakep_id
 * @property boolean $implementasiaskepdet_iskolaborasi
 * @property string $implementasiaskepdet_ketkolaborasi
 * @property integer $rencanaaskepdet_id
 *
 * The followings are the available model relations:
 * @property PilihimplementasiaskepT[] $pilihimplementasiaskepTs
 * @property ImplementasiaskepT $implementasiaskep
 * @property DiagnosakepM $diagnosakep
 * @property RencanaaskepdetT $rencanaaskepdet
 */
class ImplementasiaskepdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImplementasiaskepdetT the static model class
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
		return 'implementasiaskepdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('implementasiaskep_id, diagnosakep_id', 'required'),
			array('implementasiaskep_id, diagnosakep_id, rencanaaskepdet_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('implementasiaskepdet_iskolaborasi, implementasiaskepdet_ketkolaborasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('implementasiaskepdet_id, implementasiaskep_id, diagnosakep_id, implementasiaskepdet_iskolaborasi, implementasiaskepdet_ketkolaborasi, rencanaaskepdet_id, pegawai_id', 'safe', 'on'=>'search'),
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
			'pilihimplementasiaskepTs' => array(self::HAS_MANY, 'PilihimplementasiaskepT', 'implementasiaskepdet_id'),
			'implementasiaskep' => array(self::BELONGS_TO, 'ImplementasiaskepT', 'implementasiaskep_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
			'rencanaaskepdet' => array(self::BELONGS_TO, 'RencanaaskepdetT', 'rencanaaskepdet_id'),
                    'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'implementasiaskepdet_id' => 'Implementasiaskepdet',
			'implementasiaskep_id' => 'Implementasiaskep',
			'diagnosakep_id' => 'Diagnosakep',
			'implementasiaskepdet_iskolaborasi' => 'Implementasiaskepdet Iskolaborasi',
			'implementasiaskepdet_ketkolaborasi' => 'Implementasiaskepdet Ketkolaborasi',
			'rencanaaskepdet_id' => 'Rencanaaskepdet',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('implementasiaskepdet_id',$this->implementasiaskepdet_id);
		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('implementasiaskepdet_iskolaborasi',$this->implementasiaskepdet_iskolaborasi);
		$criteria->compare('implementasiaskepdet_ketkolaborasi',$this->implementasiaskepdet_ketkolaborasi,true);
		$criteria->compare('rencanaaskepdet_id',$this->rencanaaskepdet_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}