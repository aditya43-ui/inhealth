<?php

/**
 * This is the model class for table "approvalfingerbpjs_t".
 *
 * The followings are the available columns in table 'approvalfingerbpjs_t':
 * @property integer $approvalfingerbpjs_id
 * @property string $tgl_sep
 * @property string $tgl_approval
 * @property integer $noka_bpjs
 * @property string $namapeserta_bpjs
 * @property integer $jenispelayanan
 * @property integer $jenispengajuan
 * @property string $keterangan
 * @property string $user
 * @property integer $create_loginpemakai_id
 * @property string $create_time
 * @property integer $ruanganlogin_id
 */
class ApprovalfingerbpjsT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'approvalfingerbpjs_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('noka_bpjs', 'required'),
			array('noka_bpjs, jenispelayanan, jenispengajuan, create_loginpemakai_id, ruanganlogin_id', 'numerical', 'integerOnly'=>true),
			array('namapeserta_bpjs', 'length', 'max'=>50),
			array('keterangan', 'length', 'max'=>250),
			array('user', 'length', 'max'=>100),
			array('tgl_sep, tgl_approval, create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('approvalfingerbpjs_id, tgl_sep, tgl_approval, noka_bpjs, namapeserta_bpjs, jenispelayanan, jenispengajuan, keterangan, user, create_loginpemakai_id, create_time, ruanganlogin_id', 'safe', 'on'=>'search'),
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
			'approvalfingerbpjs_id' => 'Approvalfingerbpjs',
			'tgl_sep' => 'Tgl Sep',
			'tgl_approval' => 'Tgl Approval',
			'noka_bpjs' => 'Noka Bpjs',
			'namapeserta_bpjs' => 'Namapeserta Bpjs',
			'jenispelayanan' => 'Jenispelayanan',
			'jenispengajuan' => 'Jenispengajuan',
			'keterangan' => 'Keterangan',
			'user' => 'User',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_time' => 'Create Time',
			'ruanganlogin_id' => 'Ruanganlogin',
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

		$criteria->compare('approvalfingerbpjs_id',$this->approvalfingerbpjs_id);
		$criteria->compare('tgl_sep',$this->tgl_sep,true);
		$criteria->compare('tgl_approval',$this->tgl_approval,true);
		$criteria->compare('noka_bpjs',$this->noka_bpjs);
		$criteria->compare('namapeserta_bpjs',$this->namapeserta_bpjs,true);
		$criteria->compare('jenispelayanan',$this->jenispelayanan);
		$criteria->compare('jenispengajuan',$this->jenispengajuan);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('ruanganlogin_id',$this->ruanganlogin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ApprovalfingerbpjsT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
