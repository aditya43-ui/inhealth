<?php

/**
 * This is the model class for table "trx_sys_res_dt".
 *
 * The followings are the available columns in table 'trx_sys_res_dt':
 * @property integer $trx_sys_res_dt_id
 * @property string $ono
 * @property string $test_cd
 * @property string $test_nm
 * @property string $data_typ
 * @property string $result_value
 * @property string $result_ft
 * @property string $unit
 * @property string $flag
 * @property string $ref_range
 * @property string $status
 * @property string $test_comment
 * @property string $validate_by
 * @property string $validate_on
 * @property string $disp_seq
 * @property string $order_testid
 * @property string $order_testnm
 * @property string $test_group
 * @property string $item_parent
 */
class TrxSysResDt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trx_sys_res_dt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ono, test_cd, test_nm, data_typ, result_value, result_ft, unit, flag, ref_range, status, test_comment, validate_by, validate_on, disp_seq, order_testid, order_testnm, test_group, item_parent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('trx_sys_res_dt_id, ono, test_cd, test_nm, data_typ, result_value, result_ft, unit, flag, ref_range, status, test_comment, validate_by, validate_on, disp_seq, order_testid, order_testnm, test_group, item_parent', 'safe', 'on'=>'search'),
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
			'trx_sys_res_dt_id' => 'Trx Sys Res Dt',
			'ono' => 'Ono',
			'test_cd' => 'Test Cd',
			'test_nm' => 'Test Nm',
			'data_typ' => 'Data Typ',
			'result_value' => 'Result Value',
			'result_ft' => 'Result Ft',
			'unit' => 'Unit',
			'flag' => 'Flag',
			'ref_range' => 'Ref Range',
			'status' => 'Status',
			'test_comment' => 'Test Comment',
			'validate_by' => 'Validate By',
			'validate_on' => 'Validate On',
			'disp_seq' => 'Disp Seq',
			'order_testid' => 'Order Testid',
			'order_testnm' => 'Order Testnm',
			'test_group' => 'Test Group',
			'item_parent' => 'Item Parent',
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

		$criteria->compare('trx_sys_res_dt_id',$this->trx_sys_res_dt_id);
		$criteria->compare('ono',$this->ono,true);
		$criteria->compare('test_cd',$this->test_cd,true);
		$criteria->compare('test_nm',$this->test_nm,true);
		$criteria->compare('data_typ',$this->data_typ,true);
		$criteria->compare('result_value',$this->result_value,true);
		$criteria->compare('result_ft',$this->result_ft,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('flag',$this->flag,true);
		$criteria->compare('ref_range',$this->ref_range,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('test_comment',$this->test_comment,true);
		$criteria->compare('validate_by',$this->validate_by,true);
		$criteria->compare('validate_on',$this->validate_on,true);
		$criteria->compare('disp_seq',$this->disp_seq,true);
		$criteria->compare('order_testid',$this->order_testid,true);
		$criteria->compare('order_testnm',$this->order_testnm,true);
		$criteria->compare('test_group',$this->test_group,true);
		$criteria->compare('item_parent',$this->item_parent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TrxSysResDt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
