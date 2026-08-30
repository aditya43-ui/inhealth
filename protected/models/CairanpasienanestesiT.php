<?php

/**
 * This is the model class for table "cairanpasienanestesi_t".
 *
 * The followings are the available columns in table 'cairanpasienanestesi_t':
 * @property integer $cairanpasienanestesi_id
 * @property integer $daftartilikanestesipasien_id
 * @property string $cairan_jenis
 * @property double $cairan_volume
 *
 * The followings are the available model relations:
 * @property DaftartilikanestesipasienT $daftartilikanestesipasien
 */
class CairanpasienanestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CairanpasienanestesiT the static model class
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
		return 'cairanpasienanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartilikanestesipasien_id', 'required'),
			array('daftartilikanestesipasien_id', 'numerical', 'integerOnly'=>true),
			array('cairan_volume', 'numerical'),
			array('cairan_jenis', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cairanpasienanestesi_id, daftartilikanestesipasien_id, cairan_jenis, cairan_volume', 'safe', 'on'=>'search'),
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
			'daftartilikanestesipasien' => array(self::BELONGS_TO, 'DaftartilikanestesipasienT', 'daftartilikanestesipasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cairanpasienanestesi_id' => 'Cairanpasienanestesi',
			'daftartilikanestesipasien_id' => 'Daftartilikanestesipasien',
			'cairan_jenis' => 'Cairan Jenis',
			'cairan_volume' => 'Cairan Volume',
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

		$criteria->compare('cairanpasienanestesi_id',$this->cairanpasienanestesi_id);
		$criteria->compare('daftartilikanestesipasien_id',$this->daftartilikanestesipasien_id);
		$criteria->compare('cairan_jenis',$this->cairan_jenis,true);
		$criteria->compare('cairan_volume',$this->cairan_volume);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}