<?php

/**
 * This is the model class for table "mesinpencucian_m".
 *
 * The followings are the available columns in table 'mesinpencucian_m':
 * @property integer $mesinpencucian_id
 * @property string $mesinpencucian_kode
 * @property string $mesinpencucian_nama
 * @property string $mesinpencucian_keterangan
 * @property boolean $mesinpencucian_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class MesinpencucianM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mesinpencucian_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('mesinpencucian_kode', 'length', 'max'=>20),
			array('mesinpencucian_nama', 'length', 'max'=>25),
			array('mesinpencucian_keterangan, mesinpencucian_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mesinpencucian_id, mesinpencucian_kode, mesinpencucian_nama, mesinpencucian_keterangan, mesinpencucian_aktif, create_time, update_time, create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'mesinpencucian_id' => 'Mesinpencucian',
			'mesinpencucian_kode' => 'Mesinpencucian Kode',
			'mesinpencucian_nama' => 'Mesinpencucian Nama',
			'mesinpencucian_keterangan' => 'Mesinpencucian Keterangan',
			'mesinpencucian_aktif' => 'Mesinpencucian Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_ruangan' => 'Create Ruangan',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('mesinpencucian_id',$this->mesinpencucian_id);
		$criteria->compare('mesinpencucian_kode',$this->mesinpencucian_kode,true);
		$criteria->compare('mesinpencucian_nama',$this->mesinpencucian_nama,true);
		$criteria->compare('mesinpencucian_keterangan',$this->mesinpencucian_keterangan,true);
		$criteria->compare('mesinpencucian_aktif',$this->mesinpencucian_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MesinpencucianM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
