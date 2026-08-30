<?php

/** 
 * This is the model class for table "kabupaten_m".
 *
 * The followings are the available columns in table 'kabupaten_m':
 * @property integer $kabupaten_id
 * @property integer $propinsi_id
 * @property string $kabupaten_nama
 * @property string $kabupaten_namalainnya
 * @property boolean $kabupaten_aktif
 *
 * The followings are the available model relations:
 * @property PropinsiM $propinsi
 */
class KabupatenM extends CActiveRecord
{
        public $propinsi_nama, $kodekabupaten_kemenkes_nama;
//        ;=,$kabupaten_nama, $kabupaten_namalainnya;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KabupatenM the static model class
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
		return 'kabupaten_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propinsi_id, kabupaten_nama, kabupaten_namalainnya', 'required'),
			array('propinsi_id', 'numerical', 'integerOnly'=>true),
			array('kabupaten_nama, kabupaten_namalainnya', 'length', 'max'=>50),
            array('kodekabupaten_kemenkes', 'length', 'max'=>10),
			array('kabupaten_aktif, latitude, longitude', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('propinsi_nama, kabupaten_id, propinsi_id, kabupaten_nama, kabupaten_namalainnya, kabupaten_aktif, kodekabupaten_kemenkes', 'safe', 'on'=>'search'),
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
			'propinsi' => array(self::BELONGS_TO, 'PropinsiM', 'propinsi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kabupaten_id' => 'ID',
			'propinsi_id' => 'Nama Provinsi',
			'kabupaten_nama' => 'Nama Kota / Kabupaten',
			'kabupaten_namalainnya' => 'Nama Lain Kota / Kabupaten',
			'kabupaten_aktif' => 'Aktif',
                        'longitude' => 'Longitude',
                        'Latitude' => 'latitude',
            'kodekabupaten_kemenkes' => 'Kabupaten Kemenkes',
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

		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('LOWER(kabupaten_namalainnya)',strtolower($this->kabupaten_namalainnya),true);
		$criteria->compare('kabupaten_aktif',isset($this->kabupaten_aktif)?$this->kabupaten_aktif:true);
                //$criteria->addCondition('kabupaten_aktif is true');
                $criteria->with=array('propinsi');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('LOWER(kabupaten_namalainnya)',strtolower($this->kabupaten_namalainnya),true);
//		$criteria->compare('kabupaten_aktif',$this->kabupaten_aktif);
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
        
        public function beforeSave() {
            $this->kabupaten_nama = ucwords(strtolower($this->kabupaten_nama));
            $this->kabupaten_namalainnya = strtoupper($this->kabupaten_namalainnya);
            return parent::beforeSave();
        }
        
        /**
         * Mengambil daftar semua propinsi
         * @return CActiveDataProvider 
         */
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif = TRUE ORDER BY propinsi_nama');
        }
        /**
         * Mengambil daftar semua Kabupaten berdasarkan propinsi_id
         * @return CActiveDataProvider 
         */
        public function getKabupatenItemsProp($propId)
        {
            return $this->findAllByAttributes(array('propinsi_id'=>$propId, 'kabupaten_aktif'=>TRUE),array('order'=>'kabupaten_nama'));
        }
        
        /**
         * Mengambil daftar semua Kabupaten  yg sudah diorder dan berdasarkan kabupaten_aktif = TRUE
         * @return CActiveDataProvider 
         */
        public function getKabupatenItems()
        {
            return $this->findAll("kabupaten_aktif = TRUE ORDER BY kabupaten_nama");
        }
       
}
