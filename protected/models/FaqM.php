<?php

/**
 * This is the model class for table "faq_m".
 *
 * The followings are the available columns in table 'faq_m':
 * @property integer $faq_id
 * @property string $modul_id
 * @property string $faq_pertanyaan
 * @property string $faq_jawaban
 * @property string $faq_urutan
 * @property boolean $faq_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class FaqM extends CActiveRecord
{
	public $modul_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FaqM the static model class
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
		return 'faq_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faq_pertanyaan,faq_jawaban', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('modul_id', 'length', 'max'=>100),
			array('faq_pertanyaan', 'length', 'max'=>255),
			array('create_time, update_time','safe'),
			array('faq_jawaban, faq_urutan, faq_aktif', 'safe'),

			array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->getState('loginpemakai_id'),'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->getState('loginpemakai_id'),'on'=>'update'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert, update'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faq_id, modul_id, faq_pertanyaan, faq_jawaban, faq_urutan, faq_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'modul' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faq_id' => 'Faq',
			'modul_id' => 'Modul',
			'faq_pertanyaan' => 'Pertanyaan',
			'faq_jawaban' => 'Jawaban',
			'faq_urutan' => 'Urutan',
			'faq_aktif' => 'Aktif',
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

		$criteria->compare('faq_id',$this->faq_id);
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id = '.$this->modul_id);
		}
		$criteria->compare('faq_pertanyaan',$this->faq_pertanyaan,true);
		$criteria->compare('faq_jawaban',$this->faq_jawaban,true);
		$criteria->compare('faq_urutan',$this->faq_urutan,true);
		$criteria->compare('faq_aktif',$this->faq_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('faq_id',$this->faq_id);
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id = '.$this->modul_id);
		}
		$criteria->compare('faq_pertanyaan',$this->faq_pertanyaan,true);
		$criteria->compare('faq_jawaban',$this->faq_jawaban,true);
		$criteria->compare('faq_urutan',$this->faq_urutan,true);
		$criteria->compare('faq_aktif',$this->faq_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}