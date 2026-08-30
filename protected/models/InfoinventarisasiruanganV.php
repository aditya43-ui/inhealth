<?php

/**
 * This is the model class for table "infoinventarisasiruangan_v".
 *
 * The followings are the available columns in table 'infoinventarisasiruangan_v':
 * @property integer $inventarisasi_id
 * @property string $tgltransaksi
 * @property string $inventarisasi_kode
 * @property double $inventarisasi_hargabeli
 * @property double $inventarisasi_hargasatuan
 * @property double $inventarisasi_qty_in
 * @property double $inventarisasi_qty_out
 * @property double $inventarisasi_qty_skrg
 * @property double $inventarisasi_jmlmin
 * @property string $inventarisasi_keadaan
 * @property string $inventarisasi_keterangan
 * @property integer $barang_id
 * @property string $barang_nama
 * @property string $barang_namalainnya
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_kode
 * @property string $barang_type
 * @property double $barang_ppn
 * @property double $barang_hpp
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property integer $barang_ekonomis_thn
 * @property boolean $barang_statusregister
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 */
class InfoinventarisasiruanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoinventarisasiruanganV the static model class
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
		return 'infoinventarisasiruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inventarisasi_id, barang_id, ruangan_id, barang_ekonomis_thn, barang_jmldlmkemasan', 'numerical', 'integerOnly'=>true),
			array('inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_jmlmin, barang_ppn, barang_hpp', 'numerical'),
			array('inventarisasi_kode, inventarisasi_keadaan, barang_merk, barang_kode, barang_type, ruangan_nama, ruangan_namalainnya, barang_warna, barang_satuan', 'length', 'max'=>50),
			array('barang_nama, barang_namalainnya', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('tgltransaksi, inventarisasi_keterangan, barang_statusregister', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inventarisasi_id, tgltransaksi, inventarisasi_kode, inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_jmlmin, inventarisasi_keadaan, inventarisasi_keterangan, barang_id, barang_nama, barang_namalainnya, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_kode, barang_type, barang_ppn, barang_hpp, ruangan_id, ruangan_nama, ruangan_namalainnya, barang_thnbeli, barang_warna, barang_ekonomis_thn, barang_statusregister, barang_satuan, barang_jmldlmkemasan', 'safe', 'on'=>'search'),
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
			'inventarisasi_id' => 'Inventarisasi',
			'tgltransaksi' => 'Tgltransaksi',
			'inventarisasi_kode' => 'Inventarisasi Kode',
			'inventarisasi_hargabeli' => 'Inventarisasi Hargabeli',
			'inventarisasi_hargasatuan' => 'Inventarisasi Hargasatuan',
			'inventarisasi_qty_in' => 'Inventarisasi Qty In',
			'inventarisasi_qty_out' => 'Inventarisasi Qty Out',
			'inventarisasi_qty_skrg' => 'Inventarisasi Qty Skrg',
			'inventarisasi_jmlmin' => 'Inventarisasi Jmlmin',
			'inventarisasi_keadaan' => 'Inventarisasi Keadaan',
			'inventarisasi_keterangan' => 'Inventarisasi Keterangan',
			'barang_id' => 'Barang',
			'barang_nama' => 'Barang Nama',
			'barang_namalainnya' => 'Barang Namalainnya',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_ukuran' => 'Barang Ukuran',
			'barang_bahan' => 'Barang Bahan',
			'barang_kode' => 'Barang Kode',
			'barang_type' => 'Barang Type',
			'barang_ppn' => 'Barang PPN',
			'barang_hpp' => 'Barang Hpp',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_namalainnya' => 'Ruangan Namalainnya',
			'barang_thnbeli' => 'Barang Thnbeli',
			'barang_warna' => 'Barang Warna',
			'barang_ekonomis_thn' => 'Barang Ekonomis Thn',
			'barang_statusregister' => 'Barang Statusregister',
			'barang_satuan' => 'Barang Satuan',
			'barang_jmldlmkemasan' => 'Barang Jmldlmkemasan',
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

		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('tgltransaksi',$this->tgltransaksi,true);
		$criteria->compare('inventarisasi_kode',$this->inventarisasi_kode,true);
		$criteria->compare('inventarisasi_hargabeli',$this->inventarisasi_hargabeli);
		$criteria->compare('inventarisasi_hargasatuan',$this->inventarisasi_hargasatuan);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_jmlmin',$this->inventarisasi_jmlmin);
		$criteria->compare('inventarisasi_keadaan',$this->inventarisasi_keadaan,true);
		$criteria->compare('inventarisasi_keterangan',$this->inventarisasi_keterangan,true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_namalainnya',$this->ruangan_namalainnya,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}