<?php

/**
 * This is the model class for table "laporanpengirimansterilisasi_v".
 *
 * The followings are the available columns in table 'laporanpengirimansterilisasi_v':
 * @property string $sterilisasi_tgl
 * @property string $ruangan_nama
 * @property string $alatmedis_nama
 * @property string $barang_nama
 * @property integer $sterilisasidetail_jml
 * @property string $sterilisasidetail_ket
 * @property string $mengetahui
 * @property string $menerima
 * @property string $mengetahui_k
 * @property string $menerima_k
 */
class LaporanpengirimansterilisasiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpengirimansterilisasiV the static model class
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
		return 'laporanpengirimansterilisasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sterilisasidetail_jml', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, mengetahui, menerima, mengetahui_k, menerima_k', 'length', 'max'=>50),
			array('alatmedis_nama, barang_nama', 'length', 'max'=>100),
			array('sterilisasidetail_ket', 'length', 'max'=>200),
			array('sterilisasi_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sterilisasi_tgl, ruangan_nama, alatmedis_nama, barang_nama, sterilisasidetail_jml, sterilisasidetail_ket, mengetahui, menerima, mengetahui_k, menerima_k', 'safe', 'on'=>'search'),
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
			'sterilisasi_tgl' => 'Sterilisasi Tgl',
			'ruangan_nama' => 'Ruangan Nama',
			'alatmedis_nama' => 'Alatmedis Nama',
			'barang_nama' => 'Barang Nama',
			'sterilisasidetail_jml' => 'Sterilisasidetail Jml',
			'sterilisasidetail_ket' => 'Sterilisasidetail Ket',
			'mengetahui' => 'Mengetahui',
			'menerima' => 'Menerima',
			'mengetahui_k' => 'Mengetahui K',
			'menerima_k' => 'Menerima K',
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

		$criteria->compare('LOWER(sterilisasi_tgl)',strtolower($this->sterilisasi_tgl),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(alatmedis_nama)',strtolower($this->alatmedis_nama),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		if(!empty($this->sterilisasidetail_jml)){
			$criteria->addCondition('sterilisasidetail_jml = '.$this->sterilisasidetail_jml);
		}
		$criteria->compare('LOWER(sterilisasidetail_ket)',strtolower($this->sterilisasidetail_ket),true);
		$criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
		$criteria->compare('LOWER(menerima)',strtolower($this->menerima),true);
		$criteria->compare('LOWER(mengetahui_k)',strtolower($this->mengetahui_k),true);
		$criteria->compare('LOWER(menerima_k)',strtolower($this->menerima_k),true);

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