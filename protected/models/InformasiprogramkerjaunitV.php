<?php

/**
 * This is the model class for table "informasiprogramkerjaunit_v".
 *
 * The followings are the available columns in table 'informasiprogramkerjaunit_v':
 * @property integer $rencanggaranpeng_id
 * @property integer $konfiganggaran_id
 * @property string $deskripsiperiode
 * @property integer $unitkerja_id
 * @property string $kodeunitkerja
 * @property string $namaunitkerja
 * @property integer $rencanggaranpengdet_id
 * @property integer $programkerja_id
 * @property string $programkerja_kode
 * @property string $programkerja_nama
 * @property integer $subprogramkerja_id
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_kode
 * @property string $kegiatanprogram_nama
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 */
class InformasiprogramkerjaunitV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiprogramkerjaunitV the static model class
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
		return 'informasiprogramkerjaunit_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanggaranpeng_id, konfiganggaran_id, unitkerja_id, rencanggaranpengdet_id, programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id', 'numerical', 'integerOnly'=>true),
			array('deskripsiperiode', 'length', 'max'=>100),
			array('kodeunitkerja', 'length', 'max'=>50),
			array('namaunitkerja', 'length', 'max'=>200),
			array('programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode', 'length', 'max'=>5),
			array('programkerja_nama, subprogramkerja_nama, kegiatanprogram_nama, subkegiatanprogram_nama', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanggaranpeng_id, konfiganggaran_id, deskripsiperiode, unitkerja_id, kodeunitkerja, namaunitkerja, rencanggaranpengdet_id, programkerja_id, programkerja_kode, programkerja_nama, subprogramkerja_id, subprogramkerja_kode, subprogramkerja_nama, kegiatanprogram_id, kegiatanprogram_kode, kegiatanprogram_nama, subkegiatanprogram_id, subkegiatanprogram_kode, subkegiatanprogram_nama', 'safe', 'on'=>'search'),
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
			'rencanggaranpeng_id' => 'Rencanggaranpeng',
			'konfiganggaran_id' => 'Konfiganggaran',
			'deskripsiperiode' => 'Deskripsiperiode',
			'unitkerja_id' => 'Unitkerja',
			'kodeunitkerja' => 'Kodeunitkerja',
			'namaunitkerja' => 'Namaunitkerja',
			'rencanggaranpengdet_id' => 'Rencanggaranpengdet',
			'programkerja_id' => 'Programkerja',
			'programkerja_kode' => 'Programkerja Kode',
			'programkerja_nama' => 'Programkerja Nama',
			'subprogramkerja_id' => 'Subprogramkerja',
			'subprogramkerja_kode' => 'Subprogramkerja Kode',
			'subprogramkerja_nama' => 'Subprogramkerja Nama',
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'kegiatanprogram_kode' => 'Kegiatanprogram Kode',
			'kegiatanprogram_nama' => 'Kegiatanprogram Nama',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'subkegiatanprogram_kode' => 'Subkegiatanprogram Kode',
			'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
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

		if(!empty($this->rencanggaranpeng_id)){
			$criteria->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		}
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(kodeunitkerja)',strtolower($this->kodeunitkerja),true);
		$criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
		if(!empty($this->rencanggaranpengdet_id)){
			$criteria->addCondition('rencanggaranpengdet_id = '.$this->rencanggaranpengdet_id);
		}
		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(programkerja_kode)',strtolower($this->programkerja_kode),true);
		$criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		$criteria->compare('LOWER(subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		$criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);

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