<?php

/**
 * This is the model class for table "laporanstokbarang_v".
 *
 * The followings are the available columns in table 'laporanstokbarang_v':
 * @property string $barang_nama
 * @property string $barang_type
 * @property string $barang_satuan
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_aktif
 * @property double $inventarisasi_qty_in
 * @property double $inventarisasi_qty_out
 * @property double $inventarisasi_qty_skrg
 * @property double $inventarisasi_hargasatuan
 * @property integer $ruangan_id
 * @property integer $supplier_id
 * @property string $supplier_nama
 */
class LaporanstokbarangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanstokbarangV the static model class
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
		return 'laporanstokbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_hargasatuan', 'numerical'),
			array('barang_nama, supplier_nama', 'length', 'max'=>100),
			array('barang_type, barang_satuan, barang_merk, barang_warna', 'length', 'max'=>50),
			array('barang_noseri, barang_ukuran, barang_bahan', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('barang_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barang_nama, barang_type, barang_satuan, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_aktif, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_hargasatuan, ruangan_id, supplier_id, supplier_nama', 'safe', 'on'=>'search'),
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
			'barang_nama' => 'Barang Nama',
			'barang_type' => 'Barang Type',
			'barang_satuan' => 'Barang Satuan',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_ukuran' => 'Barang Ukuran',
			'barang_bahan' => 'Barang Bahan',
			'barang_thnbeli' => 'Barang Thnbeli',
			'barang_warna' => 'Barang Warna',
			'barang_aktif' => 'Barang Aktif',
			'inventarisasi_qty_in' => 'Inventarisasi Qty In',
			'inventarisasi_qty_out' => 'Inventarisasi Qty Out',
			'inventarisasi_qty_skrg' => 'Inventarisasi Qty Skrg',
			'inventarisasi_hargasatuan' => 'Inventarisasi Hargasatuan',
			'ruangan_id' => 'Ruangan',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
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

		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_hargasatuan',$this->inventarisasi_hargasatuan);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}