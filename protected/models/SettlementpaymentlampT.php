<?php

/**
 * This is the model class for table "settlementpaymentlamp_t".
 *
 * The followings are the available columns in table 'settlementpaymentlamp_t':
 * @property integer $settlementpaymentlamp_id
 * @property integer $settlementpayment_id
 * @property string $lampiran
 * @property string $noreferensi
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property SettlementpaymentT $settlementpayment
 */
class SettlementpaymentlampT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SettlementpaymentlampT the static model class
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
		return 'settlementpaymentlamp_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('settlementpayment_id', 'numerical', 'integerOnly'=>true),
			array('noreferensi', 'length', 'max'=>100),
			array('keterangan,lampiran', 'safe'),
			// array('lampiran', 'file', 'types'=>'jpg, gif, png, pdf'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('settlementpaymentlamp_id, settlementpayment_id, lampiran, noreferensi, keterangan', 'safe', 'on'=>'search'),
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
			'settlementpayment' => array(self::BELONGS_TO, 'SettlementpaymentT', 'settlementpayment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'settlementpaymentlamp_id' => 'Settlementpaymentlamp',
			'settlementpayment_id' => 'Settlementpayment',
			'lampiran' => 'Lampiran',
			'noreferensi' => 'Noreferensi',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('settlementpaymentlamp_id',$this->settlementpaymentlamp_id);
		$criteria->compare('settlementpayment_id',$this->settlementpayment_id);
		$criteria->compare('lampiran',$this->lampiran,true);
		$criteria->compare('noreferensi',$this->noreferensi,true);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}