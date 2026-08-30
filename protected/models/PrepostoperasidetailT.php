<?php

/**
 * This is the model class for table "prepostoperasidetail_t".
 *
 * The followings are the available columns in table 'prepostoperasidetail_t':
 * @property integer $prepostoperasidetail_id
 * @property integer $prepostoperasi_id
 * @property integer $prepostoperasidesk_id
 * @property string $status_pengisian
 * @property string $jenischecklist
 * @property boolean $ischeck
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PrepostoperasiT $prepostoperasi
 * @property PrepostoperasideskM $prepostoperasidesk
 */
class PrepostoperasidetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrepostoperasidetailT the static model class
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
		return 'prepostoperasidetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prepostoperasi_id, prepostoperasidesk_id, status_pengisian, jenischecklist, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('prepostoperasi_id, prepostoperasidesk_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('status_pengisian', 'length', 'max'=>100),
			array('keterangan', 'length', 'max'=>200),
			array('checklist_diisioleh', 'length', 'max'=>50),
			array('ischeck, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prepostoperasidetail_id, prepostoperasi_id, prepostoperasidesk_id, status_pengisian, jenischecklist, ischeck, keterangan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, checklist_diisioleh', 'safe', 'on'=>'search'),
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
			'prepostoperasi' => array(self::BELONGS_TO, 'PrepostoperasiT', 'prepostoperasi_id'),
			'prepostoperasidesk' => array(self::BELONGS_TO, 'PrepostoperasideskM', 'prepostoperasidesk_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prepostoperasidetail_id' => 'Prepostoperasidetail',
			'prepostoperasi_id' => 'Prepostoperasi',
			'prepostoperasidesk_id' => 'Prepostoperasidesk',
			'status_pengisian' => 'Status Pengisian',
			'jenischecklist' => 'Jenischecklist',
			'ischeck' => 'Ischeck',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('prepostoperasidetail_id',$this->prepostoperasidetail_id);
		$criteria->compare('prepostoperasi_id',$this->prepostoperasi_id);
		$criteria->compare('prepostoperasidesk_id',$this->prepostoperasidesk_id);
		$criteria->compare('status_pengisian',$this->status_pengisian,true);
		$criteria->compare('jenischecklist',$this->jenischecklist,true);
		$criteria->compare('ischeck',$this->ischeck);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
