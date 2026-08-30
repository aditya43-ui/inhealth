<?php

/**
 * This is the model class for table "informasialokasianggaran_v".
 *
 * The followings are the available columns in table 'informasialokasianggaran_v':
 * @property integer $programkerja_id
 * @property string $programkerja_nama
 * @property string $programkerja_kode
 * @property integer $subprogramkerja_id
 * @property string $subprogramkerja_nama
 * @property string $subprogramkerja_kode
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_nama
 * @property string $kegiatanprogram_kode
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_nama
 * @property string $subkegiatanprogram_kode
 * @property double $nilaiygdisetujui
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property string $tglapprrencanggaran
 * @property boolean $statusalokasi
 */
class InformasialokasianggaranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasialokasianggaranV the static model class
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
		return 'informasialokasianggaran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id, unitkerja_id', 'numerical', 'integerOnly'=>true),
			array('nilaiygdisetujui', 'numerical'),
			array('programkerja_nama, subprogramkerja_nama, kegiatanprogram_nama, subkegiatanprogram_nama', 'length', 'max'=>500),
			array('programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode', 'length', 'max'=>5),
			array('namaunitkerja', 'length', 'max'=>200),
			array('tglapprrencanggaran, statusalokasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('programkerja_id, programkerja_nama, programkerja_kode, subprogramkerja_id, subprogramkerja_nama, subprogramkerja_kode, kegiatanprogram_id, kegiatanprogram_nama, kegiatanprogram_kode, subkegiatanprogram_id, subkegiatanprogram_nama, subkegiatanprogram_kode, nilaiygdisetujui, unitkerja_id, namaunitkerja, tglapprrencanggaran, statusalokasi', 'safe', 'on'=>'search'),
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
			'programkerja_id' => 'Programkerja',
			'programkerja_nama' => 'Programkerja Nama',
			'programkerja_kode' => 'Programkerja Kode',
			'subprogramkerja_id' => 'Subprogramkerja',
			'subprogramkerja_nama' => 'Subprogramkerja Nama',
			'subprogramkerja_kode' => 'Subprogramkerja Kode',
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'kegiatanprogram_nama' => 'Kegiatanprogram Nama',
			'kegiatanprogram_kode' => 'Kegiatanprogram Kode',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'subkegiatanprogram_nama' => 'Subkegiatanprogram Nama',
			'subkegiatanprogram_kode' => 'Subkegiatanprogram Kode',
			'nilaiygdisetujui' => 'Nilaiygdisetujui',
			'unitkerja_id' => 'Unitkerja',
			'namaunitkerja' => 'Namaunitkerja',
			'tglapprrencanggaran' => 'Tglapprrencanggaran',
			'statusalokasi' => 'Statusalokasi',
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

		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
		$criteria->compare('LOWER(programkerja_kode)',strtolower($this->programkerja_kode),true);
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		$criteria->compare('LOWER(subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('nilaiygdisetujui',$this->nilaiygdisetujui);
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('LOWER(tglapprrencanggaran)',strtolower($this->tglapprrencanggaran),true);
		$criteria->compare('statusalokasi',$this->statusalokasi);

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