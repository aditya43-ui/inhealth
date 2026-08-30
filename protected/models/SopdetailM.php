<?php

/**
 * This is the model class for table "sopdetail_m".
 *
 * The followings are the available columns in table 'sopdetail_m':
 * @property integer $sopdetail_id
 * @property integer $sop_id
 * @property string $sopdetail_kelompok
 * @property string $sopdetail_nama
 * @property integer $sopdetail_nourut
 * @property boolean $sopdetail_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SopM $sop
 */
class SopdetailM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sopdetail_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sop_id, sopdetail_kelompok, sopdetail_nama, create_loginpemakai_id, create_ruangan', 'required'),
			array('sop_id, sopdetail_nourut, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('sopdetail_kelompok', 'length', 'max'=>100),
			array('create_time, update_time, sopdetail_nama', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sopdetail_id, sop_id, sopdetail_kelompok, sopdetail_nama, sopdetail_nourut, sopdetail_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'sop' => array(self::BELONGS_TO, 'SopM', 'sop_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sopdetail_id' => 'Sopdetail',
			'sop_id' => 'SOP',
			'sopdetail_kelompok' => 'Kelompok Prosedur',
			'sopdetail_nama' => 'Prosedur',
			'sopdetail_nourut' => 'Nomor Urut',
			'sopdetail_aktif' => 'Sopdetail Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->sop_id)){
			$criteria->addCondition('sop_id = '.$this->sop_id);	
		}
		$criteria->compare('sopdetail_kelompok',$this->sopdetail_kelompok,true);
		$criteria->compare('sopdetail_aktif',$this->sopdetail_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SopdetailM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
