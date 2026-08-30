<?php

/**
 * This is the model class for table "trx_sys_order".
 *
 * The followings are the available columns in table 'trx_sys_order':
 * @property integer $trx_sys_order_id
 * @property string $message_dt
 * @property string $order_control
 * @property string $pid
 * @property string $apid
 * @property string $pname
 * @property string $address1
 * @property string $ptype
 * @property string $birth_dt
 * @property string $sex
 * @property string $ono
 * @property string $request_dt
 * @property string $source
 * @property string $clinician
 * @property string $room_no
 * @property string $priority
 * @property string $comment
 * @property string $visitno
 * @property string $order_testid
 * @property boolean $flag
 * @property string $address2
 * @property string $address3
 * @property string $address4
 */
class TrxSysOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trx_sys_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message_dt, request_dt', 'length', 'max'=>14),
			array('order_control, ptype', 'length', 'max'=>2),
			array('pid, apid', 'length', 'max'=>16),
			array('pname, address1, address2, address3, address4', 'length', 'max'=>50),
			array('birth_dt', 'length', 'max'=>8),
			array('sex, priority', 'length', 'max'=>1),
			array('ono', 'length', 'max'=>20),
			array('source, clinician', 'length', 'max'=>61),
			array('room_no', 'length', 'max'=>6),
			array('comment', 'length', 'max'=>200),
			array('visitno', 'length', 'max'=>30),
			array('order_testid', 'length', 'max'=>2000),
			array('flag', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('trx_sys_order_id, message_dt, order_control, pid, apid, pname, address1, ptype, birth_dt, sex, ono, request_dt, source, clinician, room_no, priority, comment, visitno, order_testid, flag, address2, address3, address4', 'safe', 'on'=>'search'),
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
			'trx_sys_order_id' => 'Trx Sys Order',
			'message_dt' => 'Message Dt',
			'order_control' => 'Order Control',
			'pid' => 'Pid',
			'apid' => 'Apid',
			'pname' => 'Pname',
			'address1' => 'Address1',
			'ptype' => 'Ptype',
			'birth_dt' => 'Birth Dt',
			'sex' => 'Sex',
			'ono' => 'Ono',
			'request_dt' => 'Request Dt',
			'source' => 'Source',
			'clinician' => 'Clinician',
			'room_no' => 'Room No',
			'priority' => 'Priority',
			'comment' => 'Comment',
			'visitno' => 'Visitno',
			'order_testid' => 'Order Testid',
			'flag' => 'Flag',
			'address2' => 'Address2',
			'address3' => 'Address3',
			'address4' => 'Address4',
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

		$criteria->compare('trx_sys_order_id',$this->trx_sys_order_id);
		$criteria->compare('message_dt',$this->message_dt,true);
		$criteria->compare('order_control',$this->order_control,true);
		$criteria->compare('pid',$this->pid,true);
		$criteria->compare('apid',$this->apid,true);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('ptype',$this->ptype,true);
		$criteria->compare('birth_dt',$this->birth_dt,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('ono',$this->ono,true);
		$criteria->compare('request_dt',$this->request_dt,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('clinician',$this->clinician,true);
		$criteria->compare('room_no',$this->room_no,true);
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('visitno',$this->visitno,true);
		$criteria->compare('order_testid',$this->order_testid,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('address3',$this->address3,true);
		$criteria->compare('address4',$this->address4,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TrxSysOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
