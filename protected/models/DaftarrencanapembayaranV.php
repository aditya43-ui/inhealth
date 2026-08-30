<?php

/**
 * This is the model class for table "daftarrencanapembayaran_v".
 *
 * The followings are the available columns in table 'daftarrencanapembayaran_v':
 * @property string $verpengeluaran_id
 * @property string $no_voucher
 * @property string $tglvoucher
 * @property integer $jenispengeluaran_id
 * @property integer $jenisverifikasi_id
 * @property double $jmlpengeluaran
 * @property double $jmlpajak_pph
 * @property double $jmlpajak_ppn
 * @property string $ket_pajak
 * @property double $dendabrg_kosong
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property string $mataanggaran_id
 * @property string $matananggaran_kode
 * @property string $mataanggaran_nama
 * @property string $matanaggaran_namalain
 * @property string $penerimaanberkas_id
 * @property integer $penerimaanberkas_t
 * @property string $noberkas
 * @property string $no_bap
 * @property string $no_kontrak
 * @property double $nilai_kontrak
 * @property string $no_sp
 * @property double $nilai_sp
 * @property string $no_bast
 * @property string $no_kwitansi
 * @property double $nilai_kwitansi
 */
class DaftarrencanapembayaranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftarrencanapembayaranV the static model class
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
		return 'daftarrencanapembayaran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_id, jenisverifikasi_id, supplier_id, penerimaanberkas_t', 'numerical', 'integerOnly'=>true),
			array('jmlpengeluaran, jmlpph_21, jmlpph_22, jmlpph_23, jmlpph_psl4, jmlpajak_ppn, dendabrg_kosong, nilai_kontrak, nilai_sp, nilai_kwitansi', 'numerical'),
			array('no_voucher, supplier_nama, no_bap, no_kontrak, no_sp, no_bast, no_kwitansi', 'length', 'max'=>100),
			array('ket_pajak, noberkas', 'length', 'max'=>50),
			array('supplier_kode', 'length', 'max'=>10),
			array('matananggaran_kode', 'length', 'max'=>20),
			array('mataanggaran_nama, matanaggaran_namalain', 'length', 'max'=>200),
			array('verpengeluaran_id, tglvoucher, mataanggaran_id, penerimaanberkas_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verpengeluaran_id, no_voucher, tglvoucher, jenispengeluaran_id, jenisverifikasi_id, jmlpengeluaran, jmlpph_21, jmlpph_22, jmlpph_23, jmlpph_psl4, jmlpajak_ppn, ket_pajak, dendabrg_kosong, supplier_id, supplier_kode, supplier_nama, mataanggaran_id, matananggaran_kode, mataanggaran_nama, matanaggaran_namalain, penerimaanberkas_id, penerimaanberkas_t, noberkas, no_bap, no_kontrak, nilai_kontrak, no_sp, nilai_sp, no_bast, no_kwitansi, nilai_kwitansi', 'safe', 'on'=>'search'),
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
			'verpengeluaran_id' => 'Verpengeluaran',
			'no_voucher' => 'No Voucher',
			'tglvoucher' => 'Tglvoucher',
			'jenispengeluaran_id' => 'Jenispengeluaran',
			'jenisverifikasi_id' => 'Jenisverifikasi',
			'jmlpengeluaran' => 'Jmlpengeluaran',
			'jmlpajak_pph' => 'Jmlpajak Pph',
			'jmlpajak_ppn' => 'Jmlpajak Ppn',
			'ket_pajak' => 'Ket Pajak',
			'dendabrg_kosong' => 'Dendabrg Kosong',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Supplier Kode',
			'supplier_nama' => 'Supplier Nama',
			'mataanggaran_id' => 'Mataanggaran',
			'matananggaran_kode' => 'Matananggaran Kode',
			'mataanggaran_nama' => 'Mataanggaran Nama',
			'matanaggaran_namalain' => 'Matanaggaran Namalain',
			'penerimaanberkas_id' => 'Penerimaanberkas',
			'penerimaanberkas_t' => 'Penerimaanberkas T',
			'noberkas' => 'Noberkas',
			'no_bap' => 'No Bap',
			'no_kontrak' => 'No Kontrak',
			'nilai_kontrak' => 'Nilai Kontrak',
			'no_sp' => 'No Sp',
			'nilai_sp' => 'Nilai Sp',
			'no_bast' => 'No Bast',
			'no_kwitansi' => 'No Kwitansi',
			'nilai_kwitansi' => 'Nilai Kwitansi',
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

		$criteria->compare('verpengeluaran_id',$this->verpengeluaran_id,true);
		$criteria->compare('no_voucher',$this->no_voucher,true);
		$criteria->compare('tglvoucher',$this->tglvoucher,true);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('jenisverifikasi_id',$this->jenisverifikasi_id);
		$criteria->compare('jmlpengeluaran',$this->jmlpengeluaran);
		$criteria->compare('jmlpajak_pph',$this->jmlpajak_pph);
		$criteria->compare('jmlpajak_ppn',$this->jmlpajak_ppn);
		$criteria->compare('ket_pajak',$this->ket_pajak,true);
		$criteria->compare('dendabrg_kosong',$this->dendabrg_kosong);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('mataanggaran_id',$this->mataanggaran_id,true);
		$criteria->compare('matananggaran_kode',$this->matananggaran_kode,true);
		$criteria->compare('mataanggaran_nama',$this->mataanggaran_nama,true);
		$criteria->compare('matanaggaran_namalain',$this->matanaggaran_namalain,true);
		$criteria->compare('penerimaanberkas_id',$this->penerimaanberkas_id,true);
		$criteria->compare('penerimaanberkas_t',$this->penerimaanberkas_t);
		$criteria->compare('noberkas',$this->noberkas,true);
		$criteria->compare('no_bap',$this->no_bap,true);
		$criteria->compare('no_kontrak',$this->no_kontrak,true);
		$criteria->compare('nilai_kontrak',$this->nilai_kontrak);
		$criteria->compare('no_sp',$this->no_sp,true);
		$criteria->compare('nilai_sp',$this->nilai_sp);
		$criteria->compare('no_bast',$this->no_bast,true);
		$criteria->compare('no_kwitansi',$this->no_kwitansi,true);
		$criteria->compare('nilai_kwitansi',$this->nilai_kwitansi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}