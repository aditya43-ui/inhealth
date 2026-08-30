<?php

/**
 * This is the model class for table "skalanyeriflaccs_m".
 *
 * The followings are the available columns in table 'skalanyeriflaccs_m':
 * @property integer $skalanyeriflaccs_id
 * @property integer $kat_skalanyeri_id
 * @property integer $skalanyeriflaccs_param
 * @property string $skalanyeriflaccs_desc
 * @property integer $skalanyeriflaccs_nilai
 * @property boolean $skalanyeriflaccs_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property KategoriskalanyeriM $katSkalanyeri
 */
class SkalanyeriflaccsM extends CActiveRecord
{
	public $kat_skalanyeri_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkalanyeriflaccsM the static model class
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
		return 'skalanyeriflaccs_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kat_skalanyeri_id, skalanyeriflaccs_param, skalanyeriflaccs_desc, skalanyeriflaccs_nilai, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('kat_skalanyeri_id, skalanyeriflaccs_param, skalanyeriflaccs_nilai, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('skalanyeriflaccs_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('skalanyeriflaccs_id, kat_skalanyeri_id, skalanyeriflaccs_param, skalanyeriflaccs_desc, skalanyeriflaccs_nilai, skalanyeriflaccs_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'katSkalanyeri' => array(self::BELONGS_TO, 'KategoriskalanyeriM', 'kat_skalanyeri_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skalanyeriflaccs_id' => 'Skalanyeriflaccs',
			'kat_skalanyeri_id' => 'Kat Skalanyeri',
			'skalanyeriflaccs_param' => 'Skalanyeriflaccs Param',
			'skalanyeriflaccs_desc' => 'Skalanyeriflaccs Desc',
			'skalanyeriflaccs_nilai' => 'Skalanyeriflaccs Nilai',
			'skalanyeriflaccs_aktif' => 'Skalanyeriflaccs Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('skalanyeriflaccs_id',$this->skalanyeriflaccs_id);
		$criteria->compare('kat_skalanyeri_id',$this->kat_skalanyeri_id);
		$criteria->compare('skalanyeriflaccs_param',$this->skalanyeriflaccs_param);
		$criteria->compare('skalanyeriflaccs_desc',$this->skalanyeriflaccs_desc,true);
		$criteria->compare('skalanyeriflaccs_nilai',$this->skalanyeriflaccs_nilai);
		$criteria->compare('skalanyeriflaccs_aktif',$this->skalanyeriflaccs_aktif);
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