<?php

/**
 * This is the model class for table "riwayatperkawinan_r".
 *
 * The followings are the available columns in table 'riwayatperkawinan_r':
 * @property integer $riwayatperkawinan_id
 * @property integer $pendaftaran_id
 * @property integer $anamesa_id
 * @property integer $perkawinan_ke
 * @property string $tglperkawanan
 * @property integer $lamaperkawinan_thn
 * @property string $tgllahir_suami
 * @property integer $umursuami_thn
 * @property integer $jmlanak_org
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RiwayatperkawinanR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatperkawinanR the static model class
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
		return 'riwayatperkawinan_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, anamesa_id, perkawinan_ke, tglperkawanan, lamaperkawinan_thn, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, anamesa_id, perkawinan_ke, lamaperkawinan_thn, umursuami_thn, jmlanak_org, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tgllahir_suami, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatperkawinan_id, pendaftaran_id, anamesa_id, perkawinan_ke, tglperkawanan, lamaperkawinan_thn, tgllahir_suami, umursuami_thn, jmlanak_org, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'riwayatperkawinan_id' => 'Riwayatperkawinan',
			'pendaftaran_id' => 'Pendaftaran',
			'anamesa_id' => 'Anamesa',
			'perkawinan_ke' => 'Perkawinan Ke',
			'tglperkawanan' => 'Tglperkawanan',
			'lamaperkawinan_thn' => 'Lamaperkawinan Thn',
			'tgllahir_suami' => 'Tgllahir Suami',
			'umursuami_thn' => 'Umursuami Thn',
			'jmlanak_org' => 'Jmlanak Org',
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

		$criteria->compare('riwayatperkawinan_id',$this->riwayatperkawinan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('perkawinan_ke',$this->perkawinan_ke);
		$criteria->compare('tglperkawanan',$this->tglperkawanan,true);
		$criteria->compare('lamaperkawinan_thn',$this->lamaperkawinan_thn);
		$criteria->compare('tgllahir_suami',$this->tgllahir_suami,true);
		$criteria->compare('umursuami_thn',$this->umursuami_thn);
		$criteria->compare('jmlanak_org',$this->jmlanak_org);
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