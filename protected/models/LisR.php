<?php

/**
 * This is the model class for table "lis_r".
 *
 * The followings are the available columns in table 'lis_r':
 * @property integer $lis_id
 * @property string $lis_reg_no
 * @property string $lis_test_id
 * @property string $his_reg_no
 * @property string $test_name
 * @property string $result
 * @property string $result_comment
 * @property string $reference_value
 * @property string $reference_note
 * @property string $test_flag_sign
 * @property string $test_units_name
 * @property string $instrument_name
 * @property string $authorization_date
 * @property string $authorization_user
 * @property string $greaterthan_value
 * @property string $lessthan_value
 * @property string $company_id
 * @property string $agreement_id
 * @property string $age_year
 * @property string $age_month
 * @property string $age_days
 * @property string $his_test_id_order
 * @property string $transfer_flag
 * @property string $collection_time
 * @property string $validate_time
 * @property string $received_time
 */
class LisR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lis_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lis_reg_no, lis_test_id', 'length', 'max'=>10),
			array('his_reg_no', 'length', 'max'=>20),
			array('test_flag_sign', 'length', 'max'=>5),
			array('test_units_name, instrument_name, authorization_user, greaterthan_value, lessthan_value, company_id, agreement_id', 'length', 'max'=>50),
			array('age_year', 'length', 'max'=>3),
			array('age_month, age_days', 'length', 'max'=>2),
			array('transfer_flag', 'length', 'max'=>1),
			array('test_name, result, result_comment, reference_value, reference_note, authorization_date, his_test_id_order, collection_time, validate_time, received_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lis_id, lis_reg_no, lis_test_id, his_reg_no, test_name, result, result_comment, reference_value, reference_note, test_flag_sign, test_units_name, instrument_name, authorization_date, authorization_user, greaterthan_value, lessthan_value, company_id, agreement_id, age_year, age_month, age_days, his_test_id_order, transfer_flag, collection_time, validate_time, received_time', 'safe', 'on'=>'search'),
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
			'lis_id' => 'Lis',
			'lis_reg_no' => 'Lis Reg No',
			'lis_test_id' => 'Lis Test',
			'his_reg_no' => 'His Reg No',
			'test_name' => 'Test Name',
			'result' => 'Result',
			'result_comment' => 'Result Comment',
			'reference_value' => 'Reference Value',
			'reference_note' => 'Reference Note',
			'test_flag_sign' => 'Test Flag Sign',
			'test_units_name' => 'Test Units Name',
			'instrument_name' => 'Instrument Name',
			'authorization_date' => 'Authorization Date',
			'authorization_user' => 'Authorization User',
			'greaterthan_value' => 'Greaterthan Value',
			'lessthan_value' => 'Lessthan Value',
			'company_id' => 'Company',
			'agreement_id' => 'Agreement',
			'age_year' => 'Age Year',
			'age_month' => 'Age Month',
			'age_days' => 'Age Days',
			'his_test_id_order' => 'His Test Id Order',
			'transfer_flag' => 'Transfer Flag',
			'collection_time' => 'Collection Time',
			'validate_time' => 'Validate Time',
			'received_time' => 'Received Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lis_id',$this->lis_id);
		$criteria->compare('lis_reg_no',$this->lis_reg_no,true);
		$criteria->compare('lis_test_id',$this->lis_test_id,true);
		$criteria->compare('his_reg_no',$this->his_reg_no,true);
		$criteria->compare('test_name',$this->test_name,true);
		$criteria->compare('result',$this->result,true);
		$criteria->compare('result_comment',$this->result_comment,true);
		$criteria->compare('reference_value',$this->reference_value,true);
		$criteria->compare('reference_note',$this->reference_note,true);
		$criteria->compare('test_flag_sign',$this->test_flag_sign,true);
		$criteria->compare('test_units_name',$this->test_units_name,true);
		$criteria->compare('instrument_name',$this->instrument_name,true);
		$criteria->compare('authorization_date',$this->authorization_date,true);
		$criteria->compare('authorization_user',$this->authorization_user,true);
		$criteria->compare('greaterthan_value',$this->greaterthan_value,true);
		$criteria->compare('lessthan_value',$this->lessthan_value,true);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('agreement_id',$this->agreement_id,true);
		$criteria->compare('age_year',$this->age_year,true);
		$criteria->compare('age_month',$this->age_month,true);
		$criteria->compare('age_days',$this->age_days,true);
		$criteria->compare('his_test_id_order',$this->his_test_id_order,true);
		$criteria->compare('transfer_flag',$this->transfer_flag,true);
		$criteria->compare('collection_time',$this->collection_time,true);
		$criteria->compare('validate_time',$this->validate_time,true);
		$criteria->compare('received_time',$this->received_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LisR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
