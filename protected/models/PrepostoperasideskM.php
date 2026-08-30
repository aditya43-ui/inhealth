<?php

/**
 * This is the model class for table "prepostoperasidesk_m".
 *
 * The followings are the available columns in table 'prepostoperasidesk_m':
 * @property integer $prepostoperasidesk_id
 * @property string $nama_prepostoperasidesk
 * @property integer $level_prepostoperasidesk
 * @property string $jenischecklist
 * @property integer $parent_id
 * @property boolean $status
 * @property integer $urutan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 */
class PrepostoperasideskM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrepostoperasideskM the static model class
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
		return 'prepostoperasidesk_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_prepostoperasidesk, level_prepostoperasidesk, jenischecklist, status, urutan, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('level_prepostoperasidesk, parent_id, urutan, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_prepostoperasidesk', 'length', 'max'=>200),
			array('jenischecklist', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prepostoperasidesk_id, nama_prepostoperasidesk, level_prepostoperasidesk, jenischecklist, parent_id, status, urutan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'prepostoperasidesk_id' => 'Prepostoperasidesk',
			'nama_prepostoperasidesk' => 'Nama Deskripsi',
			'level_prepostoperasidesk' => 'Level',
			'jenischecklist' => 'Jenis Checklist',
			'parent_id' => 'Berhubungan dengan',
			'status' => 'Status',
			'urutan' => 'Urutan',
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

		$criteria->compare('LOWER(nama_prepostoperasidesk)',strtolower($this->nama_prepostoperasidesk),true);
		$criteria->compare('level_prepostoperasidesk',$this->level_prepostoperasidesk);
		$criteria->compare('jenischecklist',$this->jenischecklist);

		if(!empty($this->parent_id)){
			$criteria->addCondition('parent_id ='.$this->parent_id);
		}
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(nama_prepostoperasidesk)',strtolower($this->nama_prepostoperasidesk),true);
		$criteria->compare('level_prepostoperasidesk',$this->level_prepostoperasidesk);
		$criteria->compare('jenischecklist',$this->jenischecklist);

		if(!empty($this->parent_id)){
			$criteria->addCondition('parent_id ='.$this->parent_id);
		}
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	public function getJenisNamaOperasi(){
		return $this->jenischecklist.' - '.$this->nama_prepostoperasidesk;
	}
}
