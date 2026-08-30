<?php

/**
 * This is the model class for table "informasifakturpembelian_v".
 *
 * The followings are the available columns in table 'informasifakturpembelian_v':
 * @property integer $fakturpembelian_id
 * @property string $tglfaktur
 * @property string $tgljatuhtempo
 * @property string $keteranganfaktur
 * @property string $nofaktur
 * @property integer $penerimaanbarang_id
 * @property string $tglterima
 * @property string $noterima
 * @property string $tglsuratjalan
 * @property string $nosuratjalan
 * @property string $statuspenerimaan
 * @property integer $returpembelian_id
 * @property string $tglretur
 * @property string $noretur
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property double $totalretur
 * @property string $tglterimafaktur
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property string $supplier_namalain
 * @property string $supplier_alamat
 * @property string $supplier_propinsi
 * @property string $supplier_kabupaten
 * @property string $supplier_telp
 * @property string $supplier_fax
 * @property string $supplier_kodepos
 * @property string $supplier_npwp
 * @property string $supplier_norekening
 * @property string $supplier_namabank
 * @property string $supplier_rekatasnama
 * @property string $supplier_matauang
 * @property string $supplier_website
 * @property string $supplier_email
 * @property string $supplier_logo
 * @property string $supplier_cp
 * @property string $supplier_cp_hp
 * @property string $supplier_cp_email
 * @property string $supplier_cp2
 * @property string $supplier_cp2_hp
 * @property string $supplier_cp2_email
 * @property string $supplier_jenis
 * @property integer $supplier_termin
 * @property integer $syaratbayar_id
 * @property string $syaratbayar_nama
 * @property integer $uangmukabeli_id
 * @property integer $tandabuktiuangmuka_id
 * @property string $tglkaskeluar_uangmuka
 * @property string $nokaskeluar_uangmuka
 * @property string $carabayarkeluar_uangmuka
 * @property string $namabank
 * @property string $norekening
 * @property string $rekatasnama
 * @property double $jumlahuang
 * @property integer $bayarkesupplier_id
 * @property integer $tandabuktibayarkesupplier_id
 * @property string $tglkaskeluar_bayarkesupplier
 * @property string $nokaskeluar_bayarkesupplier
 * @property string $carabayarkeluar_bayarkesupplier
 * @property string $tglbayarkesupplier
 * @property double $totaltagihan
 * @property double $jmldibayarkan
 * @property integer $batalbayarsupplier_id
 * @property string $tglbatalbayar
 * @property string $alasanbatalbayar
 * @property string $user_name_otoritasi
 * @property integer $user_id_otorisasi
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property double $totharganetto
 * @property double $jmldiscount
 * @property double $totalpajakpph
 * @property double $totalpajakppn
 * @property double $totalhargabruto
 */
class InformasifakturpembelianV extends CActiveRecord
{
	public $statusBayar;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasifakturpembelianV the static model class
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
		return 'informasifakturpembelian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fakturpembelian_id, penerimaanbarang_id, returpembelian_id, supplier_id, supplier_termin, syaratbayar_id, uangmukabeli_id, tandabuktiuangmuka_id, bayarkesupplier_id, tandabuktibayarkesupplier_id, batalbayarsupplier_id, user_id_otorisasi, instalasi_id, ruangan_id, pegawaimenyetujuikeuangan_id', 'numerical', 'integerOnly'=>true),
			array('totalretur, jumlahuang, totaltagihan, jmldibayarkan, totharganetto, jmldiscount, totalpajakpph, totalpajakppn, totalhargabruto, jmluangmukabeli, totalhutangusaha', 'numerical'),
			array('nofaktur, nosuratjalan, noretur, supplier_telp, supplier_fax, supplier_kodepos, supplier_matauang, supplier_website, supplier_email, syaratbayar_nama, nokaskeluar_uangmuka, carabayarkeluar_uangmuka, nokaskeluar_bayarkesupplier, carabayarkeluar_bayarkesupplier, user_name_otoritasi, instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('noterima, statuspenerimaan, supplier_jenis', 'length', 'max'=>20),
			array('alasanretur', 'length', 'max'=>200),
			array('supplier_kode', 'length', 'max'=>10),
			array('supplier_nama, supplier_namalain, supplier_propinsi, supplier_kabupaten, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, namabank, norekening, rekatasnama', 'length', 'max'=>100),
			array('supplier_logo', 'length', 'max'=>500),
			array('tglfaktur, tgljatuhtempo, keteranganfaktur, tglterima, tglsuratjalan, tglretur, keteranganretur, tglterimafaktur, supplier_alamat, tglkaskeluar_uangmuka, tglkaskeluar_bayarkesupplier, tglbayarkesupplier, tglbatalbayar, alasanbatalbayar, tgl_menyetujuikeuangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fakturpembelian_id, tglfaktur, tgljatuhtempo, keteranganfaktur, nofaktur, penerimaanbarang_id, tglterima, noterima, tglsuratjalan, nosuratjalan, statuspenerimaan, returpembelian_id, tglretur, noretur, alasanretur, keteranganretur, totalretur, tglterimafaktur, supplier_id, supplier_kode, supplier_nama, supplier_namalain, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_matauang, supplier_website, supplier_email, supplier_logo, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, supplier_jenis, supplier_termin, syaratbayar_id, syaratbayar_nama, uangmukabeli_id, tandabuktiuangmuka_id, tglkaskeluar_uangmuka, nokaskeluar_uangmuka, carabayarkeluar_uangmuka, namabank, norekening, rekatasnama, jumlahuang, bayarkesupplier_id, tandabuktibayarkesupplier_id, tglkaskeluar_bayarkesupplier, nokaskeluar_bayarkesupplier, carabayarkeluar_bayarkesupplier, tglbayarkesupplier, totaltagihan, jmldibayarkan, batalbayarsupplier_id, tglbatalbayar, alasanbatalbayar, user_name_otoritasi, user_id_otorisasi, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, totharganetto, jmldiscount, totalpajakpph, totalpajakppn, totalhargabruto, tgl_menyetujuikeuangan, pegawaimenyetujuikeuangan_id, jmluangmukabeli, totalhutangusaha', 'safe', 'on'=>'search'),
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
			'fakturpembelian_id' => 'Faktur Pembelian',
			'tglfaktur' => 'Tanggal Faktur',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'keteranganfaktur' => 'Keterangan Faktur',
			'nofaktur' => 'No. Faktur',
			'penerimaanbarang_id' => 'Penerimaan Barang',
			'tglterima' => 'Tgl. Terima',
			'noterima' => 'No. Terima',
			'tglsuratjalan' => 'Tgl. Surat Jalan',
			'nosuratjalan' => 'No. Surat Jalan',
			'statuspenerimaan' => 'Status Penerimaan',
			'returpembelian_id' => 'Retur Pembelian',
			'tglretur' => 'Tgl. Retur',
			'noretur' => 'No. Retur',
			'alasanretur' => 'Alasan Retur',
			'keteranganretur' => 'Keterangan Retur',
			'totalretur' => 'Total Retur',
			'tglterimafaktur' => 'Tgl. Terima Faktur',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Kode Supplier',
			'supplier_nama' => 'Nama Supplier',
			'supplier_namalain' => 'Supplier Namalain',
			'supplier_alamat' => 'Alamat Supplier',
			'supplier_propinsi' => 'Supplier Propinsi',
			'supplier_kabupaten' => 'Supplier Kabupaten',
			'supplier_telp' => 'Telepon Supplier',
			'supplier_fax' => 'Fax Supplier',
			'supplier_kodepos' => 'Supplier Kodepos',
			'supplier_npwp' => 'Supplier Npwp',
			'supplier_norekening' => 'Supplier Norekening',
			'supplier_namabank' => 'Supplier Namabank',
			'supplier_rekatasnama' => 'Supplier Rekatasnama',
			'supplier_matauang' => 'Supplier Matauang',
			'supplier_website' => 'Website Supplier',
			'supplier_email' => 'Email Supplier',
			'supplier_logo' => 'Supplier Logo',
			'supplier_cp' => 'Supplier Cp',
			'supplier_cp_hp' => 'Supplier Cp Hp',
			'supplier_cp_email' => 'Supplier Cp Email',
			'supplier_cp2' => 'Supplier Cp2',
			'supplier_cp2_hp' => 'Supplier Cp2 Hp',
			'supplier_cp2_email' => 'Supplier Cp2 Email',
			'supplier_jenis' => 'Supplier Jenis',
			'supplier_termin' => 'Supplier Termin',
			'syaratbayar_id' => 'Syarat Bayar',
			'syaratbayar_nama' => 'Syarat Bayar',
			'uangmukabeli_id' => 'Uang Muka Belli',
			'tandabuktiuangmuka_id' => 'Tanda Bukti Uang Muka',
			'tglkaskeluar_uangmuka' => 'Tgl. Kas Keluar Uang Muka',
			'nokaskeluar_uangmuka' => 'Nokaskeluar Uangmuka',
			'carabayarkeluar_uangmuka' => 'Carabayarkeluar Uangmuka',
			'namabank' => 'Namabank',
			'norekening' => 'Norekening',
			'rekatasnama' => 'Rekatasnama',
			'jumlahuang' => 'Jumlahuang',
			'bayarkesupplier_id' => 'Bayar ke Supplier',
			'tandabuktibayarkesupplier_id' => 'Tandabuktibayarkesupplier',
			'tglkaskeluar_bayarkesupplier' => 'Tglkaskeluar Bayarkesupplier',
			'nokaskeluar_bayarkesupplier' => 'Nokaskeluar Bayarkesupplier',
			'carabayarkeluar_bayarkesupplier' => 'Carabayarkeluar Bayarkesupplier',
			'tglbayarkesupplier' => 'Tgl. Bayar ke Supplier',
			'totaltagihan' => 'Total Tagihan',
			'jmldibayarkan' => 'Jumlah Dibayarkan',
			'batalbayarsupplier_id' => 'Batal Bayar Supplier',
			'tglbatalbayar' => 'Tgl. Batal Bayar',
			'alasanbatalbayar' => 'Alasanbatalbayar',
			'user_name_otoritasi' => 'User Name Otoritasi',
			'user_id_otorisasi' => 'User Id Otorisasi',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'totharganetto' => 'Total Harga Netto',
			'jmldiscount' => 'Jumlah Keringanan',
			'totalpajakpph' => 'Total Pajak Pph',
			'totalpajakppn' => 'Total Pajak Ppn',
			'totalhargabruto' => 'Total Harga Bruto',
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

		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterima',$this->noterima,true);
		$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		$criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		$criteria->compare('statuspenerimaan',$this->statuspenerimaan,true);
		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		$criteria->compare('tglretur',$this->tglretur,true);
		$criteria->compare('noretur',$this->noretur,true);
		$criteria->compare('alasanretur',$this->alasanretur,true);
		$criteria->compare('keteranganretur',$this->keteranganretur,true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_namalain',$this->supplier_namalain,true);
		$criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		$criteria->compare('supplier_propinsi',$this->supplier_propinsi,true);
		$criteria->compare('supplier_kabupaten',$this->supplier_kabupaten,true);
		$criteria->compare('supplier_telp',$this->supplier_telp,true);
		$criteria->compare('supplier_fax',$this->supplier_fax,true);
		$criteria->compare('supplier_kodepos',$this->supplier_kodepos,true);
		$criteria->compare('supplier_npwp',$this->supplier_npwp,true);
		$criteria->compare('supplier_norekening',$this->supplier_norekening,true);
		$criteria->compare('supplier_namabank',$this->supplier_namabank,true);
		$criteria->compare('supplier_rekatasnama',$this->supplier_rekatasnama,true);
		$criteria->compare('supplier_matauang',$this->supplier_matauang,true);
		$criteria->compare('supplier_website',$this->supplier_website,true);
		$criteria->compare('supplier_email',$this->supplier_email,true);
		$criteria->compare('supplier_logo',$this->supplier_logo,true);
		$criteria->compare('supplier_cp',$this->supplier_cp,true);
		$criteria->compare('supplier_cp_hp',$this->supplier_cp_hp,true);
		$criteria->compare('supplier_cp_email',$this->supplier_cp_email,true);
		$criteria->compare('supplier_cp2',$this->supplier_cp2,true);
		$criteria->compare('supplier_cp2_hp',$this->supplier_cp2_hp,true);
		$criteria->compare('supplier_cp2_email',$this->supplier_cp2_email,true);
		$criteria->compare('supplier_jenis',$this->supplier_jenis,true);
		$criteria->compare('supplier_termin',$this->supplier_termin);
		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('syaratbayar_nama',$this->syaratbayar_nama,true);
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('tandabuktiuangmuka_id',$this->tandabuktiuangmuka_id);
		$criteria->compare('tglkaskeluar_uangmuka',$this->tglkaskeluar_uangmuka,true);
		$criteria->compare('nokaskeluar_uangmuka',$this->nokaskeluar_uangmuka,true);
		$criteria->compare('carabayarkeluar_uangmuka',$this->carabayarkeluar_uangmuka,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('norekening',$this->norekening,true);
		$criteria->compare('rekatasnama',$this->rekatasnama,true);
		$criteria->compare('jumlahuang',$this->jumlahuang);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('tandabuktibayarkesupplier_id',$this->tandabuktibayarkesupplier_id);
		$criteria->compare('tglkaskeluar_bayarkesupplier',$this->tglkaskeluar_bayarkesupplier,true);
		$criteria->compare('nokaskeluar_bayarkesupplier',$this->nokaskeluar_bayarkesupplier,true);
		$criteria->compare('carabayarkeluar_bayarkesupplier',$this->carabayarkeluar_bayarkesupplier,true);
		$criteria->compare('tglbayarkesupplier',$this->tglbayarkesupplier,true);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		$criteria->compare('tglbatalbayar',$this->tglbatalbayar,true);
		$criteria->compare('alasanbatalbayar',$this->alasanbatalbayar,true);
		$criteria->compare('user_name_otoritasi',$this->user_name_otoritasi,true);
		$criteria->compare('user_id_otorisasi',$this->user_id_otorisasi);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('totalpajakpph',$this->totalpajakpph);
		$criteria->compare('totalpajakppn',$this->totalpajakppn);
		$criteria->compare('totalhargabruto',$this->totalhargabruto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}