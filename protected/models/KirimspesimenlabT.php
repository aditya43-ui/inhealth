<?php

/**
 * This is the model class for table "kirimspesimenlab_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'kirimspesimenlab_t':
 * @property integer $kirimspesimenlab_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $samplelab_id
 * @property string $lokasi
 *
 * The followings are the available model relations:
 * @property SamplelabM $samplelab
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PasienkirimkeunitlainT $pasienkirimkeunitlain
 */
class KirimspesimenlabT extends CActiveRecord
{
    public $spesimen_id, $samplelab_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimspesimenlabT the static model class
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
		return 'kirimspesimenlab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('samplelab_id', 'required'),
			array('pasienkirimkeunitlain_id, pasienmasukpenunjang_id, samplelab_id', 'numerical', 'integerOnly'=>true),
			array('lokasi', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kirimspesimenlab_id, pasienkirimkeunitlain_id, pasienmasukpenunjang_id, samplelab_id, lokasi', 'safe', 'on'=>'search'),
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
			'samplelab' => array(self::BELONGS_TO, 'SamplelabM', 'samplelab_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pasienkirimkeunitlain' => array(self::BELONGS_TO, 'PasienkirimkeunitlainT', 'pasienkirimkeunitlain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimspesimenlab_id' => 'Kirimspesimenlab',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'samplelab_id' => 'Samplelab',
			'lokasi' => 'Lokasi',
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

		$criteria->compare('kirimspesimenlab_id',$this->kirimspesimenlab_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('lokasi',$this->lokasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}