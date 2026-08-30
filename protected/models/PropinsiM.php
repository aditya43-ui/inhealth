<?php

/**
 * This is the model class for table "propinsi_m".
 *
 * The followings are the available columns in table 'propinsi_m':
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $propinsi_namalainnya
 * @property boolean $propinsi_aktif
 */
class PropinsiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PropinsiM the static model class
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
		return 'propinsi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propinsi_nama', 'required'),
			array('propinsi_nama, propinsi_namalainnya', 'length', 'max'=>25),
			array('latitude, longitude', 'length', 'max'=>100),
            array('kodepropinsi_kemenkes', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('propinsi_id, propinsi_nama, propinsi_namalainnya, propinsi_aktif, longitude, latitude, kodepropinsi_kemenkes', 'safe', 'on'=>'search'),
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
			'propinsi_id' => 'ID',
			'propinsi_nama' => 'Nama Provinsi',
			'propinsi_namalainnya' => 'Nama Lain Provinsi',
			'propinsi_aktif' => 'Provinsi Aktif',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
            'kodepropinsi_kemenkes'=> 'Kode Provinsi Kemenkes'
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

		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(propinsi_namalainnya)',strtolower($this->propinsi_namalainnya),true);
		$criteria->compare('propinsi_aktif',isset($this->propinsi_aktif)?$this->propinsi_aktif:true);
//                $criteria->addCondition('propinsi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(propinsi_namalainnya)',strtolower($this->propinsi_namalainnya),true);
//		$criteria->compare('propinsi_aktif',$this->propinsi_aktif);
                $criteria->limit=-1; 
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
                public function beforeSave() {
                    $this->propinsi_nama = ucwords(strtolower($this->propinsi_nama));
                    $this->propinsi_namalainnya = strtoupper($this->propinsi_namalainnya);
                    return parent::beforeSave();
                }
                
                /**
                 * Mengambil daftar semua Propinsi
                 * @return CActiveDataProvider 
                 */
                public function getPropinsiItems()
                {
                    return $this->findAll(array('order'=>'propinsi_nama'));
                }
}