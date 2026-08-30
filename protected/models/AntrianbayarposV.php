<?php

/**
 * This is the model class for table "antrianbayarpos_v".
 *
 * The followings are the available columns in table 'antrianbayarpos_v':
 * @property integer $brg_id
 * @property integer $category_id
 * @property string $category_name
 * @property integer $subcategory_id
 * @property string $subcategory_code
 * @property string $subcategory_name
 * @property string $stock_code
 * @property string $stock_name
 * @property string $satuankecil_nama
 * @property string $barang_barcode
 * @property integer $obatalkes_id
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property double $hargajual_oa
 * @property string $tglpenjualan
 * @property string $jenispenjualan
 * @property double $totalhargajual
 * @property integer $penjualanresep_id
 * @property integer $obatalkespasien_id
 * @property string $noresep
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $create_loginpemakai_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $nama_pemakai
 */
class AntrianbayarposV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianbayarposV the static model class
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
		return 'antrianbayarpos_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brg_id, category_id, subcategory_id, obatalkes_id, penjualanresep_id, obatalkespasien_id, ruangan_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan_oa, hargajual_oa, totalhargajual', 'numerical'),
			array('category_name, stock_code, satuankecil_nama, './*noresep,*/'ruangan_nama, nama_pegawai', 'length', 'max'=>50),
			array('subcategory_code', 'length', 'max'=>10),
			array('subcategory_name, jenispenjualan', 'length', 'max'=>100),
			array('stock_name, barang_barcode', 'length', 'max'=>200),
			array('nama_pemakai', 'length', 'max'=>20),
			array('tglpenjualan, create_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, brg_id, category_id, category_name, subcategory_id, subcategory_code, subcategory_name, stock_code, stock_name, satuankecil_nama, barang_barcode, obatalkes_id, qty_oa, hargasatuan_oa, hargajual_oa, tglpenjualan, jenispenjualan, totalhargajual, penjualanresep_id, obatalkespasien_id, './*noresep, */'ruangan_id, ruangan_nama, create_loginpemakai_id, pegawai_id, nama_pegawai, nama_pemakai', 'safe', 'on'=>'search'),
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
//                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'brg_id' => 'Brg',
			'category_id' => 'Category',
			'category_name' => 'Category Name',
			'subcategory_id' => 'Subcategory',
			'subcategory_code' => 'Subcategory Code',
			'subcategory_name' => 'Subcategory Name',
			'stock_code' => 'Stock Code',
			'stock_name' => 'Stock Name',
			'satuankecil_nama' => 'Satuankecil Nama',
			'barang_barcode' => 'Barang Barcode',
			'obatalkes_id' => 'Obatalkes',
			'qty_oa' => 'Jumlah Oa',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'tglpenjualan' => 'Tanggal Penjualan',
			'jenispenjualan' => 'Jenis Penjualan',
			'totalhargajual' => 'Total Harga Jual',
			'penjualanresep_id' => 'Penjualan Resep',
			'obatalkespasien_id' => 'Obatalkespasien',
			//'noresep' => 'No. Resep',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'create_loginpemakai_id' => 'Pegawai',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'nama_pemakai' => 'Nama Pemakai',
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

		$criteria->compare('brg_id',$this->brg_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('LOWER(category_name)',strtolower($this->category_name),true);
		$criteria->compare('subcategory_id',$this->subcategory_id);
		$criteria->compare('LOWER(subcategory_code)',strtolower($this->subcategory_code),true);
		$criteria->compare('LOWER(subcategory_name)',strtolower($this->subcategory_name),true);
		$criteria->compare('LOWER(stock_code)',strtolower($this->stock_code),true);
		$criteria->compare('LOWER(stock_name)',strtolower($this->stock_name),true);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(barang_barcode)',strtolower($this->barang_barcode),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
//		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('brg_id',$this->brg_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('LOWER(category_name)',strtolower($this->category_name),true);
		$criteria->compare('subcategory_id',$this->subcategory_id);
		$criteria->compare('LOWER(subcategory_code)',strtolower($this->subcategory_code),true);
		$criteria->compare('LOWER(subcategory_name)',strtolower($this->subcategory_name),true);
		$criteria->compare('LOWER(stock_code)',strtolower($this->stock_code),true);
		$criteria->compare('LOWER(stock_name)',strtolower($this->stock_name),true);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(barang_barcode)',strtolower($this->barang_barcode),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
//		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function primaryKey() {
            return 'obatalkespasien_id';
        }
}