<?php

/**
 * This is the model class for table "petapenyebaranmcu_r".
 *
 * The followings are the available columns in table 'petapenyebaranmcu_r':
 * @property integer $petapenyebaranmcu_id
 * @property string $tanggal
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $jumlah
 * @property string $longitude
 * @property string $latitude
 */
class PetapenyebaranmcuR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PetapenyebaranmcuR the static model class
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
		return 'petapenyebaranmcu_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kecamatan_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('kecamatan_nama', 'length', 'max'=>50),
			array('tanggal, longitude, latitude', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('petapenyebaranmcu_id, tanggal, kecamatan_id, kecamatan_nama, jumlah, longitude, latitude', 'safe', 'on'=>'search'),
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
			'petapenyebaranmcu_id' => 'Petapenyebaranmcu',
			'tanggal' => 'Tanggal',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'jumlah' => 'Jumlah',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
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

		if(!empty($this->petapenyebaranmcu_id)){
			$criteria->addCondition('petapenyebaranmcu_id = '.$this->petapenyebaranmcu_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->jumlah)){
			$criteria->addCondition('jumlah = '.$this->jumlah);
		}
		$criteria->compare('LOWER(longitude)',strtolower($this->longitude),true);
		$criteria->compare('LOWER(latitude)',strtolower($this->latitude),true);

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