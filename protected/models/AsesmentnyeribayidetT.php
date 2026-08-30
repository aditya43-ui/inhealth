<?php

/**
 * This is the model class for table "asesmentnyeribayidet_t".
 *
 * The followings are the available columns in table 'asesmentnyeribayidet_t':
 * @property integer $asesmentnyeribayidet_id
 * @property integer $asesmentnyeri_id
 * @property string $parameter
 * @property string $penilaian
 * @property integer $skor
 *
 * The followings are the available model relations:
 * @property AsesmentnyeriT $asesmentnyeri
 */
class AsesmentnyeribayidetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmentnyeribayidetT the static model class
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
		return 'asesmentnyeribayidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmentnyeri_id, skor', 'numerical', 'integerOnly'=>true),
			array('parameter, penilaian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmentnyeribayidet_id, asesmentnyeri_id, parameter, penilaian, skor', 'safe', 'on'=>'search'),
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
			'asesmentnyeri' => array(self::BELONGS_TO, 'AsesmentnyeriT', 'asesmentnyeri_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmentnyeribayidet_id' => 'Asesmentnyeribayidet',
			'asesmentnyeri_id' => 'Asesmentnyeri',
			'parameter' => 'Parameter',
			'penilaian' => 'Penilaian',
			'skor' => 'Skor',
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

		$criteria->compare('asesmentnyeribayidet_id',$this->asesmentnyeribayidet_id);
		$criteria->compare('asesmentnyeri_id',$this->asesmentnyeri_id);
		$criteria->compare('parameter',$this->parameter,true);
		$criteria->compare('penilaian',$this->penilaian,true);
		$criteria->compare('skor',$this->skor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}