<?php

/**
 * This is the model class for table "informasistokbarang_v".
 *
 * The followings are the available columns in table 'informasistokbarang_v':
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_namalainnya
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_statusregister
 * @property integer $barang_ekonomis_thn
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 * @property string $barang_image
 * @property double $barang_harga
 * @property integer $bidang_id
 * @property string $bidang_kode
 * @property string $bidang_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_lokasi
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property double $inventarisasi_hargabeli_avg
 * @property double $inventarisasi_stok
 */
class InformasistokbarangV extends CActiveRecord
{
    public $ceklisminimal;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokbarangV the static model class
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
		return 'informasistokbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, barang_ekonomis_thn, barang_jmldlmkemasan, bidang_id, ruangan_id, instalasi_id, minimalstok, jenisbarang_id', 'numerical', 'integerOnly'=>true),
			array('barang_harga, inventarisasi_hargabeli_avg, inventarisasi_stok, qtykeadaan_baik, qtykeadaan_dalamperbaikan, qtykeadaan_rusak', 'numerical'),
			array('barang_type, barang_kode, barang_merk, barang_warna, barang_satuan, bidang_kode, ruangan_nama, ruangan_lokasi, instalasi_nama, jenisbarang_nama', 'length', 'max'=>50),
			array('barang_nama, barang_namalainnya, bidang_nama', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('barang_image', 'length', 'max'=>200),
			array('barang_statusregister', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barang_id, barang_type, barang_kode, barang_nama, barang_namalainnya, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_harga, bidang_id, bidang_kode, bidang_nama, ruangan_id, ruangan_nama, ruangan_lokasi, instalasi_id, instalasi_nama, inventarisasi_hargabeli_avg, inventarisasi_stok, minimalstok, jenisbarang_nama, jenisbarang_id, qtykeadaan_baik, qtykeadaan_dalamperbaikan, qtykeadaan_rusak', 'safe', 'on'=>'search'),
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
			'barang_id' => 'Barang',
			'barang_type' => 'Tipe Barang',
			'barang_kode' => 'Kode Barang',
			'barang_nama' => 'Nama Barang',
			'barang_namalainnya' => 'Nama Lain Barang',
			'barang_merk' => 'Merk',
			'barang_noseri' => 'No. Seri',
			'barang_ukuran' => 'Ukuran',
			'barang_bahan' => 'Bahan',
			'barang_thnbeli' => 'Tahun Beli',
			'barang_warna' => 'Warna',
			'barang_statusregister' => 'Status Register',
			'barang_ekonomis_thn' => 'Barang Ekonomis',
			'barang_satuan' => 'Satuan Barang',
			'barang_jmldlmkemasan' => 'Jumlah Dalam Kemasan',
			'barang_image' => 'Image',
			'barang_harga' => 'Harga Barang',
			'bidang_id' => 'Bidang',
			'bidang_kode' => 'Kode Bidang',
			'bidang_nama' => 'Nama Bidang',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'ruangan_lokasi' => 'Lokasi Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'inventarisasi_hargabeli_avg' => 'Harga Beli (rata-rata)',
			'inventarisasi_stok' => 'Jumlah Stok',
                    'jenisbarang_id' => 'Jenis Barang',
                    
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

		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_harga',$this->barang_harga);
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('inventarisasi_hargabeli_avg',$this->inventarisasi_hargabeli_avg);
		$criteria->compare('inventarisasi_stok',$this->inventarisasi_stok);

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