<?php

/**
 * This is the model class for table "persetujuanumum_m".
 *
 * The followings are the available columns in table 'persetujuanumum_m':
 * @property integer $persetujuanumum_id
 * @property string $persetujuaninformasi_awal
 * @property string $persetujuaninformasi_akhir
 * @property integer $profilrs_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property ProfilrumahsakitM $profilrs
 */
class PersetujuanumumM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persetujuanumum_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, create_time, create_loginpemakai_id, update_loginpemakai_id', 'required'),
			array('profilrs_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('persetujuaninformasi_awal, persetujuaninformasi_akhir, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('persetujuanumum_id, persetujuaninformasi_awal, persetujuaninformasi_akhir, profilrs_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persetujuanumum_id' => 'Persetujuanumum',
			'persetujuaninformasi_awal' => 'Persetujuaninformasi Awal',
			'persetujuaninformasi_akhir' => 'Persetujuaninformasi Akhir',
			'profilrs_id' => 'Profilrs',
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

		$criteria->compare('persetujuanumum_id',$this->persetujuanumum_id);
		$criteria->compare('persetujuaninformasi_awal',$this->persetujuaninformasi_awal,true);
		$criteria->compare('persetujuaninformasi_akhir',$this->persetujuaninformasi_akhir,true);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PersetujuanumumM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
