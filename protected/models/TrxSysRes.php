<?php

/**
 * This is the model class for table "trx_sys_res".
 *
 * The followings are the available columns in table 'trx_sys_res':
 * @property integer $trx_sys_res_id
 * @property string $pid
 * @property string $apid
 * @property string $pname
 * @property string $ono
 * @property string $lno
 * @property string $source_cd
 * @property string $source_nm
 * @property string $clinician_cd
 * @property string $clinician_nm
 * @property string $comment
 * @property string $visit_no
 * @property string $request_dt
 * @property string $priority
 */
class TrxSysRes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trx_sys_res';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid', 'length', 'max'=>13),
			array('apid', 'length', 'max'=>16),
			array('pname, source_nm, clinician_nm', 'length', 'max'=>50),
			array('ono, lno, visit_no', 'length', 'max'=>20),
			array('source_cd, clinician_cd', 'length', 'max'=>6),
			array('comment, request_dt, priority', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('trx_sys_res_id, pid, apid, pname, ono, lno, source_cd, source_nm, clinician_cd, clinician_nm, comment, visit_no, request_dt, priority', 'safe', 'on'=>'search'),
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
			'trx_sys_res_id' => 'Trx Sys Res',
			'pid' => 'Pid',
			'apid' => 'Apid',
			'pname' => 'Pname',
			'ono' => 'Ono',
			'lno' => 'Lno',
			'source_cd' => 'Source Cd',
			'source_nm' => 'Source Nm',
			'clinician_cd' => 'Clinician Cd',
			'clinician_nm' => 'Clinician Nm',
			'comment' => 'Comment',
			'visit_no' => 'Visit No',
			'request_dt' => 'Request Dt',
			'priority' => 'Priority',
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

		$criteria->compare('trx_sys_res_id',$this->trx_sys_res_id);
		$criteria->compare('pid',$this->pid,true);
		$criteria->compare('apid',$this->apid,true);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('ono',$this->ono,true);
		$criteria->compare('lno',$this->lno,true);
		$criteria->compare('source_cd',$this->source_cd,true);
		$criteria->compare('source_nm',$this->source_nm,true);
		$criteria->compare('clinician_cd',$this->clinician_cd,true);
		$criteria->compare('clinician_nm',$this->clinician_nm,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('visit_no',$this->visit_no,true);
		$criteria->compare('request_dt',$this->request_dt,true);
		$criteria->compare('priority',$this->priority,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TrxSysRes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
