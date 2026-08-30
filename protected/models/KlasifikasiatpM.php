<?php

/**
 * This is the model class for table "klasifikasiatp_m".
 *
 * The followings are the available columns in table 'klasifikasiatp_m':
 * @property integer $klasifikasiatp_id
 * @property integer $pemeriksaanlab_id
 * @property string $klasifikasiatp_jenis
 * @property string $klasifikasiatp_nama
 * @property integer $klasifikasiatp_min
 * @property integer $klasifikasiatp_max
 * @property string $klasifikasiatp_level
 */
class KlasifikasiatpM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasiatpM the static model class
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
		return 'klasifikasiatp_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanlab_id, klasifikasiatp_jenis, klasifikasiatp_nama, klasifikasiatp_min, klasifikasiatp_max, klasifikasiatp_level', 'required'),
			array('pemeriksaanlab_id, klasifikasiatp_min, klasifikasiatp_max', 'numerical', 'integerOnly'=>true),
			array('klasifikasiatp_jenis, klasifikasiatp_nama', 'length', 'max'=>20),
			array('klasifikasiatp_level', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('klasifikasiatp_id, pemeriksaanlab_id, klasifikasiatp_jenis, klasifikasiatp_nama, klasifikasiatp_min, klasifikasiatp_max, klasifikasiatp_level', 'safe', 'on'=>'search'),
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
			'klasifikasiatp_id' => 'Klasifikasiatp',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'klasifikasiatp_jenis' => 'Klasifikasiatp Jenis',
			'klasifikasiatp_nama' => 'Klasifikasiatp Nama',
			'klasifikasiatp_min' => 'Klasifikasiatp Min',
			'klasifikasiatp_max' => 'Klasifikasiatp Max',
			'klasifikasiatp_level' => 'Klasifikasiatp Level',
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

		if(!empty($this->klasifikasiatp_id)){
			$criteria->addCondition('klasifikasiatp_id = '.$this->klasifikasiatp_id);
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		$criteria->compare('LOWER(klasifikasiatp_jenis)',strtolower($this->klasifikasiatp_jenis),true);
		$criteria->compare('LOWER(klasifikasiatp_nama)',strtolower($this->klasifikasiatp_nama),true);
		if(!empty($this->klasifikasiatp_min)){
			$criteria->addCondition('klasifikasiatp_min = '.$this->klasifikasiatp_min);
		}
		if(!empty($this->klasifikasiatp_max)){
			$criteria->addCondition('klasifikasiatp_max = '.$this->klasifikasiatp_max);
		}
		$criteria->compare('LOWER(klasifikasiatp_level)',strtolower($this->klasifikasiatp_level),true);

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