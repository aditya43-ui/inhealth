<?php

/**
 * This is the model class for table "approval_t".
 *
 * The followings are the available columns in table 'approval_t':
 * @property integer $approval_id
 * @property string $tglapproval
 * @property string $keteranganapproval
 * @property integer $appr_diperiksaoleh_id
 * @property string $appr_tgldiperiksa
 * @property integer $appr_disetujuioleh_id
 * @property boolean $status_disetujui
 * @property string $appr_tgldisetujui
 * @property string $appr_create_time
 * @property string $appr_update_time
 * @property string $appr_create_login
 * @property string $appr_update_login
 * @property string $cara_bayar
 *
 * The followings are the available model relations:
 * @property PermohonanpinjamanT[] $permohonanpinjamanTs
 */
class ApprovalT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApprovalT the static model class
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
		return 'approval_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglapproval, appr_create_time, appr_create_login', 'required'),
			array('appr_diperiksaoleh_id, appr_disetujuioleh_id', 'numerical', 'integerOnly'=>true),
			array('appr_create_login, appr_update_login, cara_bayar', 'length', 'max'=>100),
			array('keteranganapproval, appr_tgldiperiksa, status_disetujui, appr_tgldisetujui, appr_update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('approval_id, tglapproval, keteranganapproval, appr_diperiksaoleh_id, appr_tgldiperiksa, appr_disetujuioleh_id, status_disetujui, appr_tgldisetujui, appr_create_time, appr_update_time, appr_create_login, appr_update_login, cara_bayar', 'safe', 'on'=>'search'),
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
			'permohonanpinjamanTs' => array(self::HAS_MANY, 'PermohonanpinjamanT', 'approval_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'approval_id' => 'Approval',
			'tglapproval' => 'Tglapproval',
			'keteranganapproval' => 'Keteranganapproval',
			'appr_diperiksaoleh_id' => 'Appr Diperiksaoleh',
			'appr_tgldiperiksa' => 'Appr Tgldiperiksa',
			'appr_disetujuioleh_id' => 'Appr Disetujuioleh',
			'status_disetujui' => 'Status Disetujui',
			'appr_tgldisetujui' => 'Appr Tgldisetujui',
			'appr_create_time' => 'Appr Create Time',
			'appr_update_time' => 'Appr Update Time',
			'appr_create_login' => 'Appr Create Login',
			'appr_update_login' => 'Appr Update Login',
			'cara_bayar' => 'Jenis Penjamin',
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

		$criteria->compare('approval_id',$this->approval_id);
		$criteria->compare('tglapproval',$this->tglapproval,true);
		$criteria->compare('keteranganapproval',$this->keteranganapproval,true);
		$criteria->compare('appr_diperiksaoleh_id',$this->appr_diperiksaoleh_id);
		$criteria->compare('appr_tgldiperiksa',$this->appr_tgldiperiksa,true);
		$criteria->compare('appr_disetujuioleh_id',$this->appr_disetujuioleh_id);
		$criteria->compare('status_disetujui',$this->status_disetujui);
		$criteria->compare('appr_tgldisetujui',$this->appr_tgldisetujui,true);
		$criteria->compare('appr_create_time',$this->appr_create_time,true);
		$criteria->compare('appr_update_time',$this->appr_update_time,true);
		$criteria->compare('appr_create_login',$this->appr_create_login,true);
		$criteria->compare('appr_update_login',$this->appr_update_login,true);
		$criteria->compare('cara_bayar',$this->cara_bayar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}