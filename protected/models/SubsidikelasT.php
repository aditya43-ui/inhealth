<?php

/**
 * This is the model class for table "subsidikelas_t".
 *
 * The followings are the available columns in table 'subsidikelas_t':
 * @property integer $subsidikelas_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $kelaspelayanan_id
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirumahsakit
 */
class SubsidikelasT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubsidikelasT the static model class
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
		return 'subsidikelas_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranpelayanan_id, kelaspelayanan_id', 'required'),
			array('pembayaranpelayanan_id, kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('subsidiasuransi, subsidipemerintah, subsidirumahsakit', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subsidikelas_id, pembayaranpelayanan_id, kelaspelayanan_id, subsidiasuransi, subsidipemerintah, subsidirumahsakit', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subsidikelas_id' => 'Subsidikelas',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidipemerintah' => 'Subsidipemerintah',
			'subsidirumahsakit' => 'Subsidirumahsakit',
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

		$criteria->compare('subsidikelas_id',$this->subsidikelas_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirumahsakit',$this->subsidirumahsakit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}