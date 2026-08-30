<?php

/**
 * This is the model class for table "infoinventarisasibarang_v".
 *
 * The followings are the available columns in table 'infoinventarisasibarang_v':
 * @property integer $invbarang_id
 * @property string $invbarang_no
 * @property string $invbarang_tgl
 * @property string $invbarang_ket
 * @property double $invbarang_totalnetto
 * @property integer $mengetahui_id
 * @property integer $petugas1_id
 * @property integer $petugas2_id
 * @property string $create_time
 * @property string $update_time
 * @property string $update_loginpemakai_id
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $inventarisasi_id
 * @property double $inventarisasi_qty_in
 * @property double $inventarisasi_qty_out
 * @property double $inventarisasi_qty_skrg
 * @property integer $invbarangdet_id
 * @property double $volume_fisik
 * @property double $harga_satuan
 * @property double $jumlah_harga
 * @property double $harga_netto
 * @property double $jumlah_netto
 * @property string $kondisi_barang
 * @property integer $barang_id
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_satuan
 * @property double $barang_harganetto
 * @property double $barang_hpp
 * @property integer $formulirinvbarang_id
 * @property string $forminvbarang_no
 * @property string $forminvbarang_tgl
 * @property double $forminvbarang_totalvolume
 * @property double $forminvbarang_totalharga
 * @property integer $forminvbarangdet_id
 * @property double $volume_inventaris
 */
class InfoinventarisasibarangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoinventarisasibarangV the static model class
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
		return 'infoinventarisasibarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invbarang_id, mengetahui_id, petugas1_id, petugas2_id, inventarisasi_id, invbarangdet_id, barang_id, formulirinvbarang_id, forminvbarangdet_id', 'numerical', 'integerOnly'=>true),
			array('invbarang_totalnetto, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, volume_fisik, harga_satuan, jumlah_harga, harga_netto, jumlah_netto, barang_harganetto, barang_hpp, forminvbarang_totalvolume, forminvbarang_totalharga, volume_inventaris', 'numerical'),
			array('invbarang_no, kondisi_barang, barang_kode, barang_merk, barang_satuan, forminvbarang_no', 'length', 'max'=>50),
			array('barang_nama', 'length', 'max'=>100),
			array('barang_noseri', 'length', 'max'=>20),
			array('invbarang_tgl, invbarang_ket, create_time, update_time, update_loginpemakai_id, create_loginpemakai_id, create_ruangan, forminvbarang_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invbarang_id, invbarang_no, invbarang_tgl, invbarang_ket, invbarang_totalnetto, mengetahui_id, petugas1_id, petugas2_id, create_time, update_time, update_loginpemakai_id, create_loginpemakai_id, create_ruangan, inventarisasi_id, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, invbarangdet_id, volume_fisik, harga_satuan, jumlah_harga, harga_netto, jumlah_netto, kondisi_barang, barang_id, barang_kode, barang_nama, barang_merk, barang_noseri, barang_satuan, barang_harganetto, barang_hpp, formulirinvbarang_id, forminvbarang_no, forminvbarang_tgl, forminvbarang_totalvolume, forminvbarang_totalharga, forminvbarangdet_id, volume_inventaris', 'safe', 'on'=>'search'),
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
			'invbarang_id' => 'Invbarang',
			'invbarang_no' => 'Invbarang No',
			'invbarang_tgl' => 'Invbarang Tgl',
			'invbarang_ket' => 'Invbarang Ket',
			'invbarang_totalnetto' => 'Invbarang Totalnetto',
			'mengetahui_id' => 'Mengetahui',
			'petugas1_id' => 'Petugas1',
			'petugas2_id' => 'Petugas2',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'inventarisasi_id' => 'Inventarisasi',
			'inventarisasi_qty_in' => 'Inventarisasi Qty In',
			'inventarisasi_qty_out' => 'Inventarisasi Qty Out',
			'inventarisasi_qty_skrg' => 'Inventarisasi Qty Skrg',
			'invbarangdet_id' => 'Invbarangdet',
			'volume_fisik' => 'Volume Fisik',
			'harga_satuan' => 'Harga Satuan',
			'jumlah_harga' => 'Jumlah Harga',
			'harga_netto' => 'Harga Netto',
			'jumlah_netto' => 'Jumlah Netto',
			'kondisi_barang' => 'Kondisi Barang',
			'barang_id' => 'Barang',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_satuan' => 'Barang Satuan',
			'barang_harganetto' => 'Barang Harganetto',
			'barang_hpp' => 'Barang Hpp',
			'formulirinvbarang_id' => 'Formulirinvbarang',
			'forminvbarang_no' => 'Forminvbarang No',
			'forminvbarang_tgl' => 'Forminvbarang Tgl',
			'forminvbarang_totalvolume' => 'Forminvbarang Totalvolume',
			'forminvbarang_totalharga' => 'Forminvbarang Totalharga',
			'forminvbarangdet_id' => 'Forminvbarangdet',
			'volume_inventaris' => 'Volume Inventaris',
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

		$criteria->compare('invbarang_id',$this->invbarang_id);
		$criteria->compare('invbarang_no',$this->invbarang_no,true);
		$criteria->compare('invbarang_tgl',$this->invbarang_tgl,true);
		$criteria->compare('invbarang_ket',$this->invbarang_ket,true);
		$criteria->compare('invbarang_totalnetto',$this->invbarang_totalnetto);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('petugas1_id',$this->petugas1_id);
		$criteria->compare('petugas2_id',$this->petugas2_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('invbarangdet_id',$this->invbarangdet_id);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('harga_netto',$this->harga_netto);
		$criteria->compare('jumlah_netto',$this->jumlah_netto);
		$criteria->compare('kondisi_barang',$this->kondisi_barang,true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('formulirinvbarang_id',$this->formulirinvbarang_id);
		$criteria->compare('forminvbarang_no',$this->forminvbarang_no,true);
		$criteria->compare('forminvbarang_tgl',$this->forminvbarang_tgl,true);
		$criteria->compare('forminvbarang_totalvolume',$this->forminvbarang_totalvolume);
		$criteria->compare('forminvbarang_totalharga',$this->forminvbarang_totalharga);
		$criteria->compare('forminvbarangdet_id',$this->forminvbarangdet_id);
		$criteria->compare('volume_inventaris',$this->volume_inventaris);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}