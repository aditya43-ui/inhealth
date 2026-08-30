<?php

/**
 * This is the model class for table "smsgateway_m".
 *
 * The followings are the available columns in table 'smsgateway_m':
 * @property integer $smsgateway_id
 * @property integer $modul_id
 * @property string $tujuansms
 * @property string $jenissms
 * @property string $formatsms
 * @property integer $jmlkaraktersms
 * @property string $katawalsms
 * @property string $kataakhirsms
 * @property boolean $ishurufkapital
 * @property string $modcontroller
 * @property string $modaction
 * @property string $templatesms
 * @property boolean $statussms
 */
class SmsgatewayM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SmsgatewayM the static model class
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
		return 'smsgateway_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('modul_id, tujuansms, jenissms, formatsms, jmlkaraktersms, katawalsms, kataakhirsms, templatesms', 'required'),
			array('modul_id, jmlkaraktersms', 'numerical', 'integerOnly'=>true),
			array('tujuansms, jenissms', 'length', 'max'=>50),
			array('formatsms', 'length', 'max'=>10),
			array('katawalsms, kataakhirsms', 'length', 'max'=>5),
			array('modcontroller, modaction', 'length', 'max'=>200),
			array('templatesms', 'length', 'max'=>250),
			array('ishurufkapital, statussms', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('smsgateway_id, modul_id, tujuansms, jenissms, formatsms, jmlkaraktersms, katawalsms, kataakhirsms, ishurufkapital, modcontroller, modaction, templatesms, statussms', 'safe', 'on'=>'search'),
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
			'smsgateway_id' => 'Sms gateway',
			'modul_id' => 'Modul',
			'jenissms' => 'Jenis sms',
			'formatsms' => 'Format sms',
			'jmlkaraktersms' => 'Jumlah karakter sms',
			'katawalsms' => 'Kata awal sms',
			'kataakhirsms' => 'Kata akhir sms',
			'ishurufkapital' => 'Huruf kapital',
			'modcontroller' => 'Nama controller',
			'modaction' => 'Nama action',
			'templatesms' => 'Template sms',
			'statussms' => 'Status sms',
			'tujuansms' => 'Tujuan sms',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->smsgateway_id)){
			$criteria->addCondition('smsgateway_id = '.$this->smsgateway_id);
		}
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id = '.$this->modul_id);
		}
		$criteria->compare('LOWER(tujuansms)',strtolower($this->tujuansms),true);
		$criteria->compare('LOWER(jenissms)',strtolower($this->jenissms),true);
		$criteria->compare('LOWER(formatsms)',strtolower($this->formatsms),true);
		if(!empty($this->jmlkaraktersms)){
			$criteria->addCondition('jmlkaraktersms = '.$this->jmlkaraktersms);
		}
		$criteria->compare('LOWER(katawalsms)',strtolower($this->katawalsms),true);
		$criteria->compare('LOWER(kataakhirsms)',strtolower($this->kataakhirsms),true);
		$criteria->compare('ishurufkapital',$this->ishurufkapital);
		$criteria->compare('LOWER(modcontroller)',strtolower($this->modcontroller),true);
		$criteria->compare('LOWER(modaction)',strtolower($this->modaction),true);
		$criteria->compare('LOWER(templatesms)',strtolower($this->templatesms),true);
		$criteria->compare('statussms',$this->statussms);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}