<?php

/**
 * This is the model class for table "jadwaldoktermod_m".
 *
 * The followings are the available columns in table 'jadwaldoktermod_m':
 * @property integer $jadwaldoktermod_id
 * @property integer $pegawai_id
 * @property string $pegawai_nama
 * @property string $create_time
 * @property string $update_time
 * @property string $tanggaljaga
 * @property boolean $is_mod
 * @property boolean $is_spvcadangan
 */
class JadwaldoktermodM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jadwaldoktermod_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tanggaljaga', 'required'),
			array('jadwaldoktermod_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('pegawai_nama', 'length', 'max'=>255),
			array('create_time, update_time, is_mod, is_spvcadangan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jadwaldoktermod_id, pegawai_id, pegawai_nama, create_time, update_time, tanggaljaga, is_mod, is_spvcadangan', 'safe', 'on'=>'search'),
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
			'jadwaldoktermod_id' => 'Jadwaldoktermod',
			'pegawai_id' => 'Pegawai',
			'pegawai_nama' => 'Pegawai Nama',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'tanggaljaga' => 'Tanggaljaga',
			'is_mod' => 'Is Mod',
			'is_spvcadangan' => 'Is Spvcadangan',
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

		$criteria->compare('jadwaldoktermod_id',$this->jadwaldoktermod_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawai_nama',$this->pegawai_nama,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('tanggaljaga',$this->tanggaljaga,true);
		$criteria->compare('is_mod',$this->is_mod);
		$criteria->compare('is_spvcadangan',$this->is_spvcadangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchDialog()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jadwaldoktermod_id',$this->jadwaldoktermod_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawai_nama',$this->pegawai_nama,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->addCondition("tanggaljaga ='" . $this->tanggaljaga . "'");
		$criteria->compare('is_mod',$this->is_mod);
		$criteria->compare('is_spvcadangan',$this->is_spvcadangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JadwaldoktermodM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
