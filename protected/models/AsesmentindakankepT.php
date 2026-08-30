<?php

/**
 * This is the model class for table "asesmentindakankep_t".
 *
 * The followings are the available columns in table 'asesmentindakankep_t':
 * @property integer $asesmentindakankep_id
 * @property integer $asesmenpasienigd_id
 * @property integer $tindakankeperawatan_id
 *
 * The followings are the available model relations:
 * @property TindakankeperawatanM $tindakankeperawatan
 * @property AsesmenpasienigdT $asesmenpasienigd
 */
class AsesmentindakankepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmentindakankepT the static model class
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
		return 'asesmentindakankep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmenpasienigd_id, tindakankeperawatan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmentindakankep_id, asesmenpasienigd_id, tindakankeperawatan_id', 'safe', 'on'=>'search'),
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
			'tindakankeperawatan' => array(self::BELONGS_TO, 'TindakankeperawatanM', 'tindakankeperawatan_id'),
			'asesmenpasienigd' => array(self::BELONGS_TO, 'AsesmenpasienigdT', 'asesmenpasienigd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmentindakankep_id' => 'Asesmentindakankep',
			'asesmenpasienigd_id' => 'Asesmenpasienigd',
			'tindakankeperawatan_id' => 'Tindakankeperawatan',
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

		$criteria->compare('asesmentindakankep_id',$this->asesmentindakankep_id);
		$criteria->compare('asesmenpasienigd_id',$this->asesmenpasienigd_id);
		$criteria->compare('tindakankeperawatan_id',$this->tindakankeperawatan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}