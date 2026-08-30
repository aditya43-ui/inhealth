<?php

/**
 * This is the model class for table "riwayatpendingcm_t".
 *
 * The followings are the available columns in table 'riwayatpendingcm_t':
 * @property integer $riwayatpendingcm_id
 * @property integer $korektifmainten_id
 * @property string $keterangan
 * @property string $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property KorektifmaintenT $korektifmainten
 */
class RiwayatpendingcmT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatpendingcmT the static model class
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
		return 'riwayatpendingcm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('korektifmainten_id,status, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('korektifmainten_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>50),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatpendingcm_id, korektifmainten_id, keterangan, status, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'korektifmainten' => array(self::BELONGS_TO, 'KorektifmaintenT', 'korektifmainten_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'riwayatpendingcm_id' => 'Riwayatpendingcm',
			'korektifmainten_id' => 'Korektifmainten',
			'keterangan' => 'Keterangan',
			'status' => 'Status',
			'create_time' => 'Tanggal',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('riwayatpendingcm_id',$this->riwayatpendingcm_id);
		$criteria->compare('korektifmainten_id',$this->korektifmainten_id);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}