<?php

/**
 * This is the model class for table "informasipenjualanprodukpos_v".
 *
 * The followings are the available columns in table 'informasipenjualanprodukpos_v':
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
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $nama_pemakai
 * @property integer $oasudahbayar_id
 * @property integer $pembayaranpelayanan_id
 * @property string $tglpembayaran
 * @property string $nopembayaran
 * @property integer $tandabuktibayar_id
 * @property integer $shift_id
 * @property integer $nourutkasir
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property double $jmlpembulatan
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property double $keterangan_pembayaran
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $create_time
 */
class InformasipenjualanprodukposV extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenjualanprodukposV the static model class
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
		return 'informasipenjualanprodukpos_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brg_id, category_id, subcategory_id, obatalkes_id, penjualanresep_id, obatalkespasien_id, ruangan_id, pegawai_id, oasudahbayar_id, pembayaranpelayanan_id, tandabuktibayar_id, shift_id, nourutkasir', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan_oa, hargajual_oa, totalhargajual, jmlpembulatan, jmlpembayaran, biayaadministrasi, uangditerima, uangkembalian, keterangan_pembayaran', 'numerical'),
			array('category_name, stock_code, satuankecil_nama, noresep, ruangan_nama, nama_pegawai, nopembayaran, nobuktibayar, carapembayaran, dengankartu', 'length', 'max'=>50),
			array('subcategory_code', 'length', 'max'=>10),
			array('subcategory_name, jenispenjualan, bankkartu, nokartu, nostrukkartu', 'length', 'max'=>100),
			array('stock_name, barang_barcode', 'length', 'max'=>200),
			array('nama_pemakai', 'length', 'max'=>20),
			array('tglpenjualan, tglpembayaran, tglbuktibayar, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, create_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, brg_id, category_id, category_name, subcategory_id, subcategory_code, subcategory_name, stock_code, stock_name, satuankecil_nama, barang_barcode, obatalkes_id, qty_oa, hargasatuan_oa, hargajual_oa, tglpenjualan, jenispenjualan, totalhargajual, penjualanresep_id, obatalkespasien_id, noresep, ruangan_id, ruangan_nama, pegawai_id, nama_pegawai, nama_pemakai, oasudahbayar_id, pembayaranpelayanan_id, tglpembayaran, nopembayaran, tandabuktibayar_id, shift_id, nourutkasir, nobuktibayar, tglbuktibayar, carapembayaran, dengankartu, bankkartu, nokartu, nostrukkartu, jmlpembulatan, jmlpembayaran, biayaadministrasi, uangditerima, uangkembalian, keterangan_pembayaran, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, create_time', 'safe', 'on'=>'search'),
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
			'brg_id' => 'Brg',
			'category_id' => 'Category',
			'category_name' => 'Category Name',
			'subcategory_id' => 'Subcategory',
			'subcategory_code' => 'Sub Category Code',
			'subcategory_name' => 'Sub Category Name',
			'stock_code' => 'Stock Code',
			'stock_name' => 'Stock Name',
			'satuankecil_nama' => 'Satuan Kecil',
			'barang_barcode' => 'Barang Barcode',
			'obatalkes_id' => 'Obatalkes',
			'qty_oa' => 'Jumlah Oa',
			'hargasatuan_oa' => 'Harga Satuan',
			'hargajual_oa' => 'Harga Jual',
			'tglpenjualan' => 'Tglpenjualan',
			'jenispenjualan' => 'Jenispenjualan',
			'totalhargajual' => 'Totalhargajual',
			'penjualanresep_id' => 'Penjualanresep',
			'obatalkespasien_id' => 'Obatalkespasien',
			'noresep' => 'Noresep',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'nama_pemakai' => 'Nama Pemakai',
			'oasudahbayar_id' => 'Oasudahbayar',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tglpembayaran' => 'Tgl. Pembayaran',
			'nopembayaran' => 'No. Pembayaran',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'shift_id' => 'Shift',
			'nourutkasir' => 'Nourutkasir',
			'nobuktibayar' => 'No. Bukti Bayar',
			'tglbuktibayar' => 'Tanggal Bukti Bayar',
			'carapembayaran' => 'Cara Pembayaran',
			'dengankartu' => 'Dengankartu',
			'bankkartu' => 'Bankkartu',
			'nokartu' => 'Nokartu',
			'nostrukkartu' => 'Nostrukkartu',
			'jmlpembulatan' => 'Jmlpembulatan',
			'jmlpembayaran' => 'Jumlah Pembayaran',
			'biayaadministrasi' => 'Biaya Administrasi',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uang Kembalian',
			'keterangan_pembayaran' => 'Keterangan Pembayaran',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'create_time' => 'Waktu Create',
                        'tgl_awal'=>'Tanggal Bukti Bayar',
                        'tgl_akhir'=>'Sampai Dengan',
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
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('LOWER(tglpembayaran)',strtolower($this->tglpembayaran),true);
		$criteria->compare('LOWER(nopembayaran)',strtolower($this->nopembayaran),true);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('nourutkasir',$this->nourutkasir);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('LOWER(dengankartu)',strtolower($this->dengankartu),true);
		$criteria->compare('LOWER(bankkartu)',strtolower($this->bankkartu),true);
		$criteria->compare('LOWER(nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(nostrukkartu)',strtolower($this->nostrukkartu),true);
		$criteria->compare('jmlpembulatan',$this->jmlpembulatan);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('keterangan_pembayaran',$this->keterangan_pembayaran);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);

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
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_pemakai)',strtolower($this->nama_pemakai),true);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('LOWER(tglpembayaran)',strtolower($this->tglpembayaran),true);
		$criteria->compare('LOWER(nopembayaran)',strtolower($this->nopembayaran),true);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('nourutkasir',$this->nourutkasir);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('LOWER(dengankartu)',strtolower($this->dengankartu),true);
		$criteria->compare('LOWER(bankkartu)',strtolower($this->bankkartu),true);
		$criteria->compare('LOWER(nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(nostrukkartu)',strtolower($this->nostrukkartu),true);
		$criteria->compare('jmlpembulatan',$this->jmlpembulatan);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('uangditerima',$this->uangditerima);
		$criteria->compare('uangkembalian',$this->uangkembalian);
		$criteria->compare('keterangan_pembayaran',$this->keterangan_pembayaran);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}