<?php

/**
 * This is the model class for table "penerimaanspesimendet_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'penerimaanspesimendet_t':
 * @property integer $penerimaanspesimendet_id
 * @property integer $pasien_id
 * @property integer $tindakanpelayanan_id
 * @property integer $samplelab_id
 * @property integer $penerimaanspesimen_id
 *
 * The followings are the available model relations:
 * @property TindakanpelayananT $tindakanpelayanan
 * @property PasienM $pasien
 * @property SamplelabM $samplelab
 * @property PenerimaanspesimenT $penerimaanspesimen
 */
class PenerimaanspesimendetT extends CActiveRecord
{
    public $spesimen_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanspesimendetT the static model class
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
		return 'penerimaanspesimendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, tindakanpelayanan_id, samplelab_id, penerimaanspesimen_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaanspesimendet_id, pasien_id, tindakanpelayanan_id, samplelab_id, penerimaanspesimen_id', 'safe', 'on'=>'search'),
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
			'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'samplelab' => array(self::BELONGS_TO, 'SamplelabM', 'samplelab_id'),
			'penerimaanspesimen' => array(self::BELONGS_TO, 'PenerimaanspesimenT', 'penerimaanspesimen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaanspesimendet_id' => 'Penerimaanspesimendet',
			'pasien_id' => 'Pasien',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'samplelab_id' => 'Samplelab',
			'penerimaanspesimen_id' => 'Penerimaanspesimen',
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

		$criteria->compare('penerimaanspesimendet_id',$this->penerimaanspesimendet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('penerimaanspesimen_id',$this->penerimaanspesimen_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}