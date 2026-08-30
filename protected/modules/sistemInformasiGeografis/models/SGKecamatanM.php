<?php

/** 
 * This is the model class for table "kecamatan_m".
 *
 * The followings are the available columns in table 'kecamatan_m':
 * @property integer $kecamatan_id
 * @property integer $kabupaten_id
 * @property string $kecamatan_nama
 * @property string $kecamatan_namalainnya
 * @property boolean $kecamatan_aktif
 */
class SGKecamatanM extends KecamatanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KecamatanM the static model class
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
		return 'kecamatan_m';
	}
	
	/**
	 * search kecamatan
	 */
	public function searchKecamatan() {
		
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kabupaten_id, kecamatan_nama, kecamatan_aktif', 'required'),
			array('kabupaten_id', 'numerical', 'integerOnly'=>true),
			array('kecamatan_nama, kecamatan_namalainnya', 'length', 'max'=>50),
			array('longitude, latitude', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kecamatan_id, kabupaten_id, kecamatan_nama, kecamatan_namalainnya, kecamatan_aktif,longitude,latitude', 'safe', 'on'=>'search'),
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
                'kabupaten' => array(self::BELONGS_TO, 'KabupatenM', 'kabupaten_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kecamatan_id' => 'ID',
			'kabupaten_id' => 'Nama Kabupaten',
			'kecamatan_nama' => 'Nama Kecamatan',
			'kecamatan_namalainnya' => 'Nama Lain',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'kecamatan_aktif' => 'Aktif',
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

		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('LOWER(kecamatan_namalainnya)',strtolower($this->kecamatan_namalainnya),true);
		$criteria->compare('kecamatan_aktif',isset($this->kecamatan_aktif)?$this->kecamatan_aktif:true);
//                $criteria->addCondition('kecamatan_aktif is true');
                $criteria->order = 'kecamatan_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('LOWER(kecamatan_namalainnya)',strtolower($this->kecamatan_namalainnya),true);
//		$criteria->compare('kecamatan_aktif',$this->kecamatan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->order = 'kecamatan_id';
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                         'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            return parent::beforeSave();
            $this->kecamatan_nama = ucwords(strtolower($this->kecamatan_nama));
            $this->kecamatan_namalainnya = strtoupper($this->kecamatan_namalainnya);
            
            
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
         * Mengambil daftar semua kabupaten
         * @return CActiveDataProvider 
         */
        public function getKabupatenItems()
        {
            return KabupatenM::model()->findAll('kabupaten_aktif = TRUE ORDER BY kabupaten_nama');
        }
        
        /**
         * Mengambil  Propinsi_id berdasarkan Kabupaten
         * @return CActiveDataProvider 
         */
        public function getPropinsiItemsKab($kabId)
        {
           $propinsi =  KabupatenM::model()->findByPk($kabId);
           return $propinsi->propinsi_id ;
        }
        
        /**
         * Mengambil daftar semua kecamatan yg sudah diorder dan dicari berdasarkan kecamatan_aktif = TRUE
         * @return CActiveDataProvider 
         */
        public function getKecamatanItems()
        {
            return $this->findAll(array('order'=>'kecamatan_nama'));
        }
        
        /**
         * Mengambil daftar semua kecamatan berdasarkan kabupaten_id
         * @param type $kabId integer kabupaten_id
         * @return CActiveDataProvider 
         */

        public function getKecamatanItemsKab($kabId)
        {
            return $this->findAllByAttributes(array('kabupaten_id'=>$kabId),array('order'=>'kecamatan_nama'));
        }
        
        public static function getKecamatanList(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('kecamatan_aktif = TRUE');
            $criteria->order = "kecamatan_nama";
            return self::model()->findAll($criteria);
        }
        
        
}
