<?php

/**
 * This is the model class for table "jawabanquisioner_m".
 *
 * The followings are the available columns in table 'jawabanquisioner_m':
 * 
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>  
 * @author Elham Budianto <elhambudianto1@gmail.com> 
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 * @property integer $jawabanquisioner_id
 * @property string $jawabanquisioner_jawaban
 * @property integer $jawabanquisioner_bobot
 * @property integer $jawabanquisioner_urutan
 * @property boolean $jawabanquisioner_aktif
 * @property integer $pertanyaanquisioner_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SurveykepuasanQuisionerdetT[] $surveykepuasanQuisionerdetTs
 * @property PertanyaanquisionerM $pertanyaanquisioner
 */
class JawabanquisionerM extends CActiveRecord
{
        public $pertanyaanquisioner_pertanyaan,$jenisformsurvey_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JawabanquisionerM the static model class
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
		return 'jawabanquisioner_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pertanyaanquisioner_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jawabanquisioner_bobot, jawabanquisioner_urutan, pertanyaanquisioner_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jawabanquisioner_jawaban', 'length', 'max'=>45),
			array('jawabanquisioner_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jawabanquisioner_id, jawabanquisioner_jawaban, jawabanquisioner_bobot, jawabanquisioner_urutan, jawabanquisioner_aktif, pertanyaanquisioner_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'surveykepuasanQuisionerdetTs' => array(self::HAS_MANY, 'SurveykepuasanQuisionerdetT', 'jawabanquisioner_id'),
			'pertanyaanquisioner' => array(self::BELONGS_TO, 'PertanyaanquisionerM', 'pertanyaanquisioner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jawabanquisioner_id' => 'Jawabanquisioner',
			'jawabanquisioner_jawaban' => 'Jawabanquisioner Jawaban',
			'jawabanquisioner_bobot' => 'Jawabanquisioner Bobot',
			'jawabanquisioner_urutan' => 'Jawabanquisioner Urutan',
			'jawabanquisioner_aktif' => 'Jawabanquisioner Aktif',
			'pertanyaanquisioner_id' => 'Pertanyaanquisioner',
			'create_time' => 'Create Time',
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

		$criteria->compare('jawabanquisioner_id',$this->jawabanquisioner_id);
		$criteria->compare('jawabanquisioner_jawaban',$this->jawabanquisioner_jawaban,true);
		$criteria->compare('jawabanquisioner_bobot',$this->jawabanquisioner_bobot);
		$criteria->compare('jawabanquisioner_urutan',$this->jawabanquisioner_urutan);
		$criteria->compare('jawabanquisioner_aktif',$this->jawabanquisioner_aktif);
                if(!empty($this->pertanyaanquisioner_id)){
		$criteria->addCondition('pertanyaanquisioner_id = '.$this->pertanyaanquisioner_id);
                }
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jawabanquisioner_id',$this->jawabanquisioner_id);
		$criteria->compare('jawabanquisioner_jawaban',$this->jawabanquisioner_jawaban,true);
		$criteria->compare('jawabanquisioner_bobot',$this->jawabanquisioner_bobot);
		$criteria->compare('jawabanquisioner_urutan',$this->jawabanquisioner_urutan);
		$criteria->compare('jawabanquisioner_aktif',$this->jawabanquisioner_aktif);
                if(!empty($this->pertanyaanquisioner_id)){
		$criteria->addCondition('pertanyaanquisioner_id = '.$this->pertanyaanquisioner_id);
                }
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}