<?php

/**
 * This is the model class for table "rencanaaskepdet_t".
 *
 * The followings are the available columns in table 'rencanaaskepdet_t':
 * @property integer $rencanaaskepdet_id
 * @property integer $rencanaaskep_id
 * @property integer $diagnosakep_id
 * @property integer $tujuan_id
 * @property integer $kriteriahasil_id
 * @property integer $intervensi_id
 * @property boolean $iskolaborasi
 * @property string $rencanaaskepdet_ketkolaborasi
 * @property integer $rencanaaskepdet_hari
 *
 * The followings are the available model relations:
 * @property ImplementasiaskepdetT[] $implementasiaskepdetTs
 * @property PilihrencanaaskepT[] $pilihrencanaaskepTs
 * @property DiagnosakepM $diagnosakep
 * @property KriteriahasilM $kriteriahasil
 * @property RencanaaskepT $rencanaaskep
 * @property TujuanM $tujuan
 * @property IntervensiM $intervensi
 */
class RencanaaskepdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanaaskepdetT the static model class
	 */
	public $intervensidet_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rencanaaskepdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanaaskep_id, diagnosakep_id', 'required'),
			array('rencanaaskep_id, diagnosakep_id, tujuan_id, kriteriahasil_id, intervensi_id, rencanaaskepdet_hari, pegawai_id, tautansdki_slki_det_id, diagnosisaskepdet_id', 'numerical', 'integerOnly'=>true),
			array('rencanaaskepdet_estimasiwaktu', 'length', 'max'=>50),
                        array('iskolaborasi, rencanaaskepdet_ketkolaborasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanaaskepdet_id, rencanaaskep_id, diagnosakep_id, tujuan_id, kriteriahasil_id, intervensi_id, iskolaborasi, rencanaaskepdet_ketkolaborasi, rencanaaskepdet_hari, pegawai_id', 'safe', 'on'=>'search'),
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
			'implementasiaskepdetTs' => array(self::HAS_MANY, 'ImplementasiaskepdetT', 'rencanaaskepdet_id'),
			'pilihrencanaaskepTs' => array(self::HAS_MANY, 'PilihrencanaaskepT', 'rencanaaskepdet_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
			'kriteriahasil' => array(self::BELONGS_TO, 'KriteriahasilM', 'kriteriahasil_id'),
			'rencanaaskep' => array(self::BELONGS_TO, 'RencanaaskepT', 'rencanaaskep_id'),
			'tujuan' => array(self::BELONGS_TO, 'TujuanM', 'tujuan_id'),
			'intervensi' => array(self::BELONGS_TO, 'IntervensiM', 'intervensi_id'),
                     'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanaaskepdet_id' => 'Rencanaaskepdet',
			'rencanaaskep_id' => 'Rencanaaskep',
			'diagnosakep_id' => 'Diagnosakep',
			'tujuan_id' => 'Tujuan',
			'kriteriahasil_id' => 'Kriteriahasil',
			'intervensi_id' => 'Intervensi',
			'iskolaborasi' => 'Iskolaborasi',
			'rencanaaskepdet_ketkolaborasi' => 'Rencanaaskepdet Ketkolaborasi',
			'rencanaaskepdet_hari' => 'Rencanaaskepdet Hari',
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

		$criteria->compare('rencanaaskepdet_id',$this->rencanaaskepdet_id);
		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('tujuan_id',$this->tujuan_id);
		$criteria->compare('kriteriahasil_id',$this->kriteriahasil_id);
		$criteria->compare('intervensi_id',$this->intervensi_id);
		$criteria->compare('iskolaborasi',$this->iskolaborasi);
		$criteria->compare('rencanaaskepdet_ketkolaborasi',$this->rencanaaskepdet_ketkolaborasi,true);
		$criteria->compare('rencanaaskepdet_hari',$this->rencanaaskepdet_hari);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}