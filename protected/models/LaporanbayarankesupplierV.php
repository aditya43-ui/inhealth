<?php

/**
 * This is the model class for table "laporanbayarankesupplier_v".
 *
 * The followings are the available columns in table 'laporanbayarankesupplier_v':
 * @property integer $bayarkesupplier_id
 * @property integer $fakturpembelian_id
 * @property integer $uangmukabeli_id
 * @property integer $tandabuktikeluar_id
 * @property integer $batalbayarsupplier_id
 * @property string $tglbayarkesupplier
 * @property double $totaltagihan
 * @property double $jmldibayarkan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property double $biayaadministrasi
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property string $supplier_kode
 * @property double $jmlkaskeluar
 * @property string $carabayarkeluar
 * @property string $melalubank
 * @property string $denganrekening
 * @property string $atasnamarekening
 * @property string $namapenerima
 * @property string $alamatpenerima
 * @property string $supplier_alamat
 * @property string $supplier_telp
 * @property string $supplier_email
 * @property string $supplier_website
 * @property string $supplier_fax
 * @property string $keterangan_pengeluaran
 * @property string $tahun
 * @property string $untukpembayaran
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property string $tgljatuhtempo
 * @property string $keteranganfaktur
 * @property string $tglbatalbayar
 * @property boolean $is_oa
 * @property boolean $is_barang
 * @property boolean $is_gizi
 * @property string $is_bahanmakan
 */
class LaporanbayarankesupplierV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanbayarankesupplierV the static model class
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
		return 'laporanbayarankesupplier_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bayarkesupplier_id, fakturpembelian_id, uangmukabeli_id, tandabuktikeluar_id, batalbayarsupplier_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('totaltagihan, jmldibayarkan, biayaadministrasi, jmlkaskeluar', 'numerical'),
			array('nokaskeluar, carabayarkeluar, supplier_telp, supplier_email, supplier_website, supplier_fax, nofaktur', 'length', 'max'=>50),
			array('supplier_nama, melalubank, denganrekening, atasnamarekening, namapenerima, untukpembayaran', 'length', 'max'=>100),
			array('supplier_kode', 'length', 'max'=>10),
			array('tahun', 'length', 'max'=>4),
			array('tglbayarkesupplier, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglkaskeluar, alamatpenerima, supplier_alamat, keterangan_pengeluaran, tglfaktur, tgljatuhtempo, keteranganfaktur, tglbatalbayar, is_oa, is_barang, is_gizi, is_bahanmakan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bayarkesupplier_id, fakturpembelian_id, uangmukabeli_id, tandabuktikeluar_id, batalbayarsupplier_id, tglbayarkesupplier, totaltagihan, jmldibayarkan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, biayaadministrasi, tglkaskeluar, nokaskeluar, supplier_id, supplier_nama, supplier_kode, jmlkaskeluar, carabayarkeluar, melalubank, denganrekening, atasnamarekening, namapenerima, alamatpenerima, supplier_alamat, supplier_telp, supplier_email, supplier_website, supplier_fax, keterangan_pengeluaran, tahun, untukpembayaran, nofaktur, tglfaktur, tgljatuhtempo, keteranganfaktur, tglbatalbayar, is_oa, is_barang, is_gizi, is_bahanmakan', 'safe', 'on'=>'search'),
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
			'bayarkesupplier_id' => 'Bayar ke Supplier',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'uangmukabeli_id' => 'Uang Muka Beli',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'batalbayarsupplier_id' => 'Batal Bayar Supplier',
			'tglbayarkesupplier' => 'Tgl. Bayar ke Supplier',
			'totaltagihan' => 'Total Tagihan',
			'jmldibayarkan' => 'Jumlah Dibayarkan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'biayaadministrasi' => 'Biaya Administrasi',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
			'supplier_kode' => 'Kode Supplier',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
			'carabayarkeluar' => 'Cara Bayar Keluar',
			'melalubank' => 'Melalui Bank',
			'denganrekening' => 'Dengan Rekening',
			'atasnamarekening' => 'Atas Nama Rekening',
			'namapenerima' => 'Nama Penerima',
			'alamatpenerima' => 'Alamat Penerima',
			'supplier_alamat' => 'Alamat Supplier',
			'supplier_telp' => 'Telepon Supplier',
			'supplier_email' => 'Email Supplier',
			'supplier_website' => 'Website Supplier',
			'supplier_fax' => 'Fax Supplier',
			'keterangan_pengeluaran' => 'Keterangan Pengeluaran',
			'tahun' => 'Tahun',
			'untukpembayaran' => 'Untuk Pembayaran',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'keteranganfaktur' => 'Keterangan Faktur',
			'tglbatalbayar' => 'Tgl. Batal Bayar',
			'is_oa' => 'Is OA',
			'is_barang' => 'Is Barang',
			'is_gizi' => 'Is Gizi',
			'is_bahanmakan' => 'Is Bahan Makanan',
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

		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		$criteria->compare('tglbayarkesupplier',$this->tglbayarkesupplier,true);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('carabayarkeluar',$this->carabayarkeluar,true);
		$criteria->compare('melalubank',$this->melalubank,true);
		$criteria->compare('denganrekening',$this->denganrekening,true);
		$criteria->compare('atasnamarekening',$this->atasnamarekening,true);
		$criteria->compare('namapenerima',$this->namapenerima,true);
		$criteria->compare('alamatpenerima',$this->alamatpenerima,true);
		$criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		$criteria->compare('supplier_telp',$this->supplier_telp,true);
		$criteria->compare('supplier_email',$this->supplier_email,true);
		$criteria->compare('supplier_website',$this->supplier_website,true);
		$criteria->compare('supplier_fax',$this->supplier_fax,true);
		$criteria->compare('keterangan_pengeluaran',$this->keterangan_pengeluaran,true);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('untukpembayaran',$this->untukpembayaran,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('tglbatalbayar',$this->tglbatalbayar,true);
		$criteria->compare('is_oa',$this->is_oa);
		$criteria->compare('is_barang',$this->is_barang);
		$criteria->compare('is_gizi',$this->is_gizi);
		$criteria->compare('is_bahanmakan',$this->is_bahanmakan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}