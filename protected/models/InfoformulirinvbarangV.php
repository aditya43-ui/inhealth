<?php

/**
 * This is the model class for table "infoformulirinvbarang_v".
 *
 * The followings are the available columns in table 'infoformulirinvbarang_v':
 * @property integer $formulirinvbarang_id
 * @property integer $inventarisasi_id
 * @property double $inventarisasi_qty_in
 * @property double $inventarisasi_qty_skrg
 * @property double $inventarisasi_qty_out
 * @property string $forminvbarang_no
 * @property string $forminvbarang_tgl
 * @property double $forminvbarang_totalvolume
 * @property double $forminvbarang_totalharga
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $forminvbarangdet_id
 * @property double $volume_inventaris
 * @property integer $barang_id
 * @property string $barang_nama
 * @property string $barang_kode
 * @property string $barang_noseri
 * @property double $barang_harganetto
 * @property double $barang_hpp
 * @property double $barang_ppn
 * @property integer $invbarangdet_id
 * @property double $volume_fisik
 * @property double $harga_satuan
 * @property double $jumlah_harga
 * @property double $harga_netto
 * @property double $jumlah_netto
 * @property string $kondisi_barang
 * @property integer $invbarang_id
 * @property string $invbarang_no
 * @property string $invbarang_tgl
 * @property string $invbarang_ket
 * @property double $invbarang_totalharga
 * @property double $invbarang_totalnetto
 * @property integer $mengetahui_id
 * @property integer $petugas1_id
 * @property integer $petugas2_id
 */
class InfoformulirinvbarangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoformulirinvbarangV the static model class
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
		return 'infoformulirinvbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formulirinvbarang_id, inventarisasi_id, forminvbarangdet_id, barang_id, invbarangdet_id, invbarang_id, mengetahui_id, petugas1_id, petugas2_id', 'numerical', 'integerOnly'=>true),
			array('inventarisasi_qty_in, inventarisasi_qty_skrg, inventarisasi_qty_out, forminvbarang_totalvolume, forminvbarang_totalharga, volume_inventaris, barang_harganetto, barang_hpp, barang_ppn, volume_fisik, harga_satuan, jumlah_harga, harga_netto, jumlah_netto, invbarang_totalharga, invbarang_totalnetto', 'numerical'),
			array('forminvbarang_no, barang_kode, kondisi_barang, invbarang_no', 'length', 'max'=>50),
			array('barang_nama', 'length', 'max'=>100),
			array('barang_noseri', 'length', 'max'=>20),
			array('forminvbarang_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, invbarang_tgl, invbarang_ket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formulirinvbarang_id, inventarisasi_id, inventarisasi_qty_in, inventarisasi_qty_skrg, inventarisasi_qty_out, forminvbarang_no, forminvbarang_tgl, forminvbarang_totalvolume, forminvbarang_totalharga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, forminvbarangdet_id, volume_inventaris, barang_id, barang_nama, barang_kode, barang_noseri, barang_harganetto, barang_hpp, barang_ppn, invbarangdet_id, volume_fisik, harga_satuan, jumlah_harga, harga_netto, jumlah_netto, kondisi_barang, invbarang_id, invbarang_no, invbarang_tgl, invbarang_ket, invbarang_totalharga, invbarang_totalnetto, mengetahui_id, petugas1_id, petugas2_id', 'safe', 'on'=>'search'),
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
			'formulirinvbarang_id' => 'Formulirinvbarang',
			'inventarisasi_id' => 'Inventarisasi',
			'inventarisasi_qty_in' => 'Qty In',
			'inventarisasi_qty_skrg' => 'Qty Skrg',
			'inventarisasi_qty_out' => 'Qty Out',
			'forminvbarang_no' => 'No. Formulir Inv Barang',
			'forminvbarang_tgl' => 'Tgl. Formulir Inv Barang',
			'forminvbarang_totalvolume' => 'Total Volume',
			'forminvbarang_totalharga' => 'Total Harga',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'forminvbarangdet_id' => 'Forminvbarangdet',
			'volume_inventaris' => 'Volume Inventaris',
			'barang_id' => 'Barang',
			'barang_nama' => 'Nama Barang',
			'barang_kode' => 'Kode Barang',
			'barang_noseri' => 'No Seri Barang',
			'barang_harganetto' => 'Harga Netto',
			'barang_hpp' => 'HPP',
			'barang_ppn' => 'PPN',
			'invbarangdet_id' => 'Invbarangdet',
			'volume_fisik' => 'Volume Fisik',
			'harga_satuan' => 'Harga Satuan',
			'jumlah_harga' => 'Jumlah Harga',
			'harga_netto' => 'Harga Netto',
			'jumlah_netto' => 'Jumlah Netto',
			'kondisi_barang' => 'Kondisi Barang',
			'invbarang_id' => 'Invbarang',
			'invbarang_no' => 'No. Inv Barang',
			'invbarang_tgl' => 'Tgl. Inv Barang',
			'invbarang_ket' => 'Ket. Inv Barang',
			'invbarang_totalharga' => 'Total Harga',
			'invbarang_totalnetto' => 'Total Netto',
			'mengetahui_id' => 'Mengetahui',
			'petugas1_id' => 'Petugas1',
			'petugas2_id' => 'Petugas2',
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

		$criteria->compare('formulirinvbarang_id',$this->formulirinvbarang_id);
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('forminvbarang_no',$this->forminvbarang_no,true);
		$criteria->compare('forminvbarang_tgl',$this->forminvbarang_tgl,true);
		$criteria->compare('forminvbarang_totalvolume',$this->forminvbarang_totalvolume);
		$criteria->compare('forminvbarang_totalharga',$this->forminvbarang_totalharga);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('forminvbarangdet_id',$this->forminvbarangdet_id);
		$criteria->compare('volume_inventaris',$this->volume_inventaris);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('invbarangdet_id',$this->invbarangdet_id);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('harga_netto',$this->harga_netto);
		$criteria->compare('jumlah_netto',$this->jumlah_netto);
		$criteria->compare('kondisi_barang',$this->kondisi_barang,true);
		$criteria->compare('invbarang_id',$this->invbarang_id);
		$criteria->compare('invbarang_no',$this->invbarang_no,true);
		$criteria->compare('invbarang_tgl',$this->invbarang_tgl,true);
		$criteria->compare('invbarang_ket',$this->invbarang_ket,true);
		$criteria->compare('invbarang_totalharga',$this->invbarang_totalharga);
		$criteria->compare('invbarang_totalnetto',$this->invbarang_totalnetto);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('petugas1_id',$this->petugas1_id);
		$criteria->compare('petugas2_id',$this->petugas2_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}