<?php

/**
 * This is the model class for table "rl3_10_kegiatanpelayanankhusus_v".
 *
 * The followings are the available columns in table 'rl3_10_kegiatanpelayanankhusus_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property integer $jeniskegiatan_id
 * @property string $jeniskegiatan_kode
 * @property string $jeniskegiatan_nama
 * @property integer $jumlah
 */
class Rl310KegiatanpelayanankhususV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl310KegiatanpelayanankhususV the static model class
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
		return 'rl3_10_kegiatanpelayanankhusus_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, jeniskegiatan_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('propinsi, koders, kabupaten, namars', 'length', 'max'=>50),
			array('jeniskegiatan_kode', 'length', 'max'=>25),
			array('jeniskegiatan_nama', 'length', 'max'=>100),
			array('tgl_laporan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, koders, profilrs_id, kabupaten, namars, jeniskegiatan_id, jeniskegiatan_kode, jeniskegiatan_nama, jumlah', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'koders' => 'Koders',
			'profilrs_id' => 'Profilrs',
			'kabupaten' => 'Kabupaten',
			'namars' => 'Namars',
			'jeniskegiatan_id' => 'Jeniskegiatan',
			'jeniskegiatan_kode' => 'Jeniskegiatan Kode',
			'jeniskegiatan_nama' => 'Jeniskegiatan Nama',
			'jumlah' => 'Jumlah',
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

		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		if(!empty($this->jeniskegiatan_id)){
			$criteria->addCondition('jeniskegiatan_id = '.$this->jeniskegiatan_id);
		}
		$criteria->compare('LOWER(jeniskegiatan_kode)',strtolower($this->jeniskegiatan_kode),true);
		$criteria->compare('LOWER(jeniskegiatan_nama)',strtolower($this->jeniskegiatan_nama),true);
		if(!empty($this->jumlah)){
			$criteria->addCondition('jumlah = '.$this->jumlah);
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