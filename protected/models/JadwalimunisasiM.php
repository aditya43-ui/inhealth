<?php

/**
 * This is the model class for table "jadwalimunisasi_m".
 *
 * The followings are the available columns in table 'jadwalimunisasi_m':
 * @property integer $jadwalimunisasi_id
 * @property integer $diagnosa_id
 * @property string $jenisimunisasi
 * @property string $umur_pemberian
 * @property integer $umur_tahun
 * @property integer $umur_bulan
 * @property string $booster_ulangan
 * @property string $imunisasi_desc
 * @property string $imunisasi_versi
 * @property boolean $jadwalimunisasi_aktif
 */
class JadwalimunisasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalimunisasiM the static model class
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
		return 'jadwalimunisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('umur_pemberian', 'required'),
			array('diagnosa_id, umur_tahun, umur_bulan', 'numerical', 'integerOnly'=>true),
			array('jenisimunisasi', 'length', 'max'=>50),
			array('umur_pemberian, booster_ulangan, imunisasi_versi', 'length', 'max'=>100),
			array('imunisasi_desc, jadwalimunisasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jadwalimunisasi_id, diagnosa_id, jenisimunisasi, umur_pemberian, umur_tahun, umur_bulan, booster_ulangan, imunisasi_desc, imunisasi_versi, jadwalimunisasi_aktif', 'safe', 'on'=>'search'),
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
			'jadwalimunisasi_id' => 'Jadwalimunisasi',
			'diagnosa_id' => 'Diagnosa',
			'jenisimunisasi' => 'Jenisimunisasi',
			'umur_pemberian' => 'Umur Pemberian',
			'umur_tahun' => 'Umur Tahun',
			'umur_bulan' => 'Umur Bulan',
			'booster_ulangan' => 'Booster Ulangan',
			'imunisasi_desc' => 'Imunisasi Desc',
			'imunisasi_versi' => 'Imunisasi Versi',
			'jadwalimunisasi_aktif' => 'Jadwalimunisasi Aktif',
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

		$criteria->compare('jadwalimunisasi_id',$this->jadwalimunisasi_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(jenisimunisasi)',strtolower($this->jenisimunisasi),true);
		$criteria->compare('LOWER(umur_pemberian)',strtolower($this->umur_pemberian),true);
		$criteria->compare('umur_tahun',$this->umur_tahun);
		$criteria->compare('umur_bulan',$this->umur_bulan);
		$criteria->compare('LOWER(booster_ulangan)',strtolower($this->booster_ulangan),true);
		$criteria->compare('LOWER(imunisasi_desc)',strtolower($this->imunisasi_desc),true);
		$criteria->compare('LOWER(imunisasi_versi)',strtolower($this->imunisasi_versi),true);
		$criteria->compare('jadwalimunisasi_aktif',$this->jadwalimunisasi_aktif);
                $criteria->addCondition('jadwalimunisasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jadwalimunisasi_id',$this->jadwalimunisasi_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(jenisimunisasi)',strtolower($this->jenisimunisasi),true);
		$criteria->compare('LOWER(umur_pemberian)',strtolower($this->umur_pemberian),true);
		$criteria->compare('umur_tahun',$this->umur_tahun);
		$criteria->compare('umur_bulan',$this->umur_bulan);
		$criteria->compare('LOWER(booster_ulangan)',strtolower($this->booster_ulangan),true);
		$criteria->compare('LOWER(imunisasi_desc)',strtolower($this->imunisasi_desc),true);
		$criteria->compare('LOWER(imunisasi_versi)',strtolower($this->imunisasi_versi),true);
		$criteria->compare('jadwalimunisasi_aktif',$this->jadwalimunisasi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}