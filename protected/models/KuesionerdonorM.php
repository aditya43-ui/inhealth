<?php

/**
 * This is the model class for table "kuesionerdonor_m".
 *
 * The followings are the available columns in table 'kuesionerdonor_m':
 * @property integer $kuesionerdonor_id
 * @property integer $kuesioner_urutan
 * @property string $kuesioner_desc
 * @property boolean $kuesioner_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SeleksikuesionerT[] $seleksikuesionerTs
 */
class KuesionerdonorM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KuesionerdonorM the static model class
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
		return 'kuesionerdonor_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kuesioner_urutan, kuesioner_desc, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('kuesioner_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kuesioner_desc', 'length', 'max'=>255),
			array('kuesioner_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kuesionerdonor_id, kuesioner_urutan, kuesioner_desc, kuesioner_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'seleksikuesionerTs' => array(self::HAS_MANY, 'SeleksikuesionerT', 'kuesionerdonor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kuesionerdonor_id' => 'Kuesionerdonor',
			'kuesioner_urutan' => 'Kuesioner Urutan',
			'kuesioner_desc' => 'Kuesioner Desc',
			'kuesioner_aktif' => 'Kuesioner Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->kuesionerdonor_id)){
			$criteria->addCondition('kuesionerdonor_id = '.$this->kuesionerdonor_id);
		}
		if(!empty($this->kuesioner_urutan)){
			$criteria->addCondition('kuesioner_urutan = '.$this->kuesioner_urutan);
		}
		$criteria->compare('LOWER(kuesioner_desc)',strtolower($this->kuesioner_desc),true);
		$criteria->compare('kuesioner_aktif',$this->kuesioner_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

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