<?php

/**
 * This is the model class for table "bahansterilisasi_m".
 *
 * The followings are the available columns in table 'bahansterilisasi_m':
 * @property integer $bahansterilisasi_id
 * @property string $bahansterilisasi_nama
 * @property string $bahansterilisasi_namalain
 * @property string $bahansterilisasi_jumlah
 * @property string $bahansterilisasi_satuan
 * @property string $bahansterilisasi_warna
 * @property string $bahansterilisasi_maksuhu
 * @property boolean $bahansterilisasi_aktif
 */
class BahansterilisasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BahansterilisasiM the static model class
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
		return 'bahansterilisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahansterilisasi_nama, bahansterilisasi_namalain, bahansterilisasi_jumlah', 'required'),
			array('bahansterilisasi_nama, bahansterilisasi_namalain', 'length', 'max'=>100),
			array('bahansterilisasi_satuan, bahansterilisasi_warna', 'length', 'max'=>50),
			array('bahansterilisasi_maksuhu, bahansterilisasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bahansterilisasi_id, bahansterilisasi_nama, bahansterilisasi_namalain, bahansterilisasi_jumlah, bahansterilisasi_satuan, bahansterilisasi_warna, bahansterilisasi_maksuhu, bahansterilisasi_aktif', 'safe', 'on'=>'search'),
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
			'bahansterilisasi_id' => 'ID',
			'bahansterilisasi_nama' => 'Nama Bahan Sterilisasi',
			'bahansterilisasi_namalain' => 'Nama Lain',
			'bahansterilisasi_jumlah' => 'Jumlah',
			'bahansterilisasi_satuan' => 'Satuan',
			'bahansterilisasi_warna' => 'Warna',
			'bahansterilisasi_maksuhu' => 'Maksimal Suhu &deg;C',
			'bahansterilisasi_aktif' => 'Bahan sterilisasi Aktif',
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

		if(!empty($this->bahansterilisasi_id)){
			$criteria->addCondition('bahansterilisasi_id = '.$this->bahansterilisasi_id);
		}
		$criteria->compare('LOWER(bahansterilisasi_nama)',strtolower($this->bahansterilisasi_nama),true);
		$criteria->compare('LOWER(bahansterilisasi_namalain)',strtolower($this->bahansterilisasi_namalain),true);
		$criteria->compare('bahansterilisasi_jumlah',$this->bahansterilisasi_jumlah);
		$criteria->compare('LOWER(bahansterilisasi_satuan)',strtolower($this->bahansterilisasi_satuan),true);
		$criteria->compare('LOWER(bahansterilisasi_warna)',strtolower($this->bahansterilisasi_warna),true);
		$criteria->compare('bahansterilisasi_maksuhu',$this->bahansterilisasi_maksuhu);
		$criteria->compare('bahansterilisasi_aktif',isset($this->bahansterilisasi_aktif) ? $this->bahansterilisasi_aktif : true);

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