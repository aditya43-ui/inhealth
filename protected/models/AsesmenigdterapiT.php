<?php

/**
 * This is the model class for table "asesmenigdterapi_t".
 *
 * The followings are the available columns in table 'asesmenigdterapi_t':
 * @property integer $asesmenigdterapi_id
 * @property string $asesmenigdterapi_tgl
 * @property integer $asesmenpasienigd_id
 * @property integer $obatalkes_id
 * @property string $obatalkes_nama
 * @property string $terapi_dosis
 * @property string $terapi_rute
 * @property integer $terapi_diperiksa
 * @property integer $terapi_diberikan
 *
 * The followings are the available model relations:
 * @property AsesmenpasienigdT $asesmenpasienigd
 */
class AsesmenigdterapiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmenigdterapiT the static model class
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
		return 'asesmenigdterapi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenigdterapi_tgl, asesmenpasienigd_id, terapi_diperiksa, terapi_diberikan', 'required'),
			array('asesmenpasienigd_id, obatalkes_id, terapi_diperiksa, terapi_diberikan', 'numerical', 'integerOnly'=>true),
			array('obatalkes_nama', 'length', 'max'=>200),
			array('terapi_dosis', 'length', 'max'=>100),
			array('terapi_rute', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmenigdterapi_id, asesmenigdterapi_tgl, asesmenpasienigd_id, obatalkes_id, obatalkes_nama, terapi_dosis, terapi_rute, terapi_diperiksa, terapi_diberikan', 'safe', 'on'=>'search'),
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
			'asesmenpasienigd' => array(self::BELONGS_TO, 'AsesmenpasienigdT', 'asesmenpasienigd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenigdterapi_id' => 'Asesmenigdterapi',
			'asesmenigdterapi_tgl' => 'Asesmenigdterapi Tgl',
			'asesmenpasienigd_id' => 'Asesmenpasienigd',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_nama' => 'Obatalkes Nama',
			'terapi_dosis' => 'Terapi Dosis',
			'terapi_rute' => 'Terapi Rute',
			'terapi_diperiksa' => 'Terapi Diperiksa',
			'terapi_diberikan' => 'Terapi Diberikan',
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

		$criteria->compare('asesmenigdterapi_id',$this->asesmenigdterapi_id);
		$criteria->compare('asesmenigdterapi_tgl',$this->asesmenigdterapi_tgl,true);
		$criteria->compare('asesmenpasienigd_id',$this->asesmenpasienigd_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkes_nama',$this->obatalkes_nama,true);
		$criteria->compare('terapi_dosis',$this->terapi_dosis,true);
		$criteria->compare('terapi_rute',$this->terapi_rute,true);
		$criteria->compare('terapi_diperiksa',$this->terapi_diperiksa);
		$criteria->compare('terapi_diberikan',$this->terapi_diberikan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}