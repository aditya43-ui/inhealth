<?php

/**
 * This is the model class for table "informasipenerimaanbarang_v".
 *
 * The followings are the available columns in table 'informasipenerimaanbarang_v':
 * @property integer $penerimaanbarang_id
 * @property string $noterima
 * @property string $tglterima
 * @property string $tglterimafaktur
 * @property integer $fakturpembelian_id
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property string $tgljatuhtempo
 * @property string $keteranganfaktur
 * @property string $nosuratjalan
 * @property string $tglsuratjalan
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
 * @property integer $permintaanpembelian_id
 * @property string $nopermintaan
 * @property string $tglpermintaanpembelian
 * @property string $tglterimabarang
 * @property string $alamatpengiriman
 * @property string $statuspembelian
 * @property integer $uangmukabeli_id
 * @property string $namabank
 * @property string $norekening
 * @property string $rekatasnama
 * @property double $jumlahuang
 * @property integer $returpembelian_id
 * @property string $noretur
 * @property string $tglretur
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property double $totalretur
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $gudangpenerima_id
 * @property string $gudangpenerima_nama
 * @property string $keteranganterima
 * @property double $totalpersendiscount
 * @property double $totaljmldiscount
 * @property double $harganettotal
 * @property double $totalpajakppn
 * @property double $totalpajakpph
 * @property double $totalharga
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $statuspenerimaan
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 */
class InformasipenerimaanbarangV extends CActiveRecord
{
	public $statusFaktur;
	public $pegawaipenerima_id;
	public $statusBayar;
	public $pegawaipenerima_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenerimaanbarangV the static model class
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
		return 'informasipenerimaanbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaanbarang_id, fakturpembelian_id, supplier_id, supplier_termin, permintaanpembelian_id, uangmukabeli_id, returpembelian_id, instalasi_id, gudangpenerima_id, pegawaimengetahui_id, pegawaimenyetujui_id', 'numerical', 'integerOnly'=>true),
			array('jumlahuang, totalretur, totalpersendiscount, totaljmldiscount, harganettotal, totalpajakppn, totalpajakpph, totalharga', 'numerical'),
			array('noterima, supplier_jenis, statuspembelian, statuspenerimaan', 'length', 'max'=>20),
			array('nofaktur, nosuratjalan, supplier_telp, supplier_fax, supplier_kodepos, supplier_matauang, supplier_website, supplier_email, nopermintaan, noretur, instalasi_nama, gudangpenerima_nama, pegawaimengetahui_nama, pegawaimenyetujui_nama', 'length', 'max'=>50),
			array('supplier_kode, pegawaimengetahui_gelardepan, pegawaimenyetujui_gelardepan', 'length', 'max'=>10),
			array('supplier_nama, supplier_namalain, supplier_propinsi, supplier_kabupaten, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, namabank, norekening, rekatasnama', 'length', 'max'=>100),
			array('supplier_logo', 'length', 'max'=>500),
			array('alasanretur', 'length', 'max'=>200),
			array('pegawaimengetahui_gelarbelakang, pegawaimenyetujui_gelarbelakang', 'length', 'max'=>15),
			array('tglterima, tglterimafaktur, tglfaktur, tgljatuhtempo, keteranganfaktur, tglsuratjalan, supplier_alamat, tglpermintaanpembelian, tglterimabarang, alamatpengiriman, tglretur, keteranganretur, keteranganterima, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaanbarang_id, noterima, tglterima, tglterimafaktur, fakturpembelian_id, nofaktur, tglfaktur, tgljatuhtempo, keteranganfaktur, nosuratjalan, tglsuratjalan, supplier_id, supplier_kode, supplier_nama, supplier_namalain, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_matauang, supplier_website, supplier_email, supplier_logo, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, supplier_jenis, supplier_termin, permintaanpembelian_id, nopermintaan, tglpermintaanpembelian, tglterimabarang, alamatpengiriman, statuspembelian, uangmukabeli_id, namabank, norekening, rekatasnama, jumlahuang, returpembelian_id, noretur, tglretur, alasanretur, keteranganretur, totalretur, instalasi_id, instalasi_nama, gudangpenerima_id, gudangpenerima_nama, keteranganterima, totalpersendiscount, totaljmldiscount, harganettotal, totalpajakppn, totalpajakpph, totalharga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, statuspenerimaan, pegawaimengetahui_id, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_id, pegawaimenyetujui_gelardepan, pegawaimenyetujui_nama, pegawaimenyetujui_gelarbelakang', 'safe', 'on'=>'search'),
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
			'penerimaanbarang_id' => 'Penerimaanbarang',
			'noterima' => 'No. Terima',
			'tglterima' => 'Tanggal Terima',
			'tglterimafaktur' => 'Tanggal Terima Faktur',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'keteranganfaktur' => 'Keterangan Faktur',
			'nosuratjalan' => 'No. Surat Jalan',
			'tglsuratjalan' => 'Tanggal Surat Jalan',
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
			'permintaanpembelian_id' => 'Permintaanpembelian',
			'nopermintaan' => 'No. Permintaan',
			'tglpermintaanpembelian' => 'Tglpermintaanpembelian',
			'tglterimabarang' => 'Tglterimabarang',
			'alamatpengiriman' => 'Alamatpengiriman',
			'statuspembelian' => 'Statuspembelian',
			'uangmukabeli_id' => 'Uang Muka Beli',
			'namabank' => 'Namabank',
			'norekening' => 'Norekening',
			'rekatasnama' => 'Rekatasnama',
			'jumlahuang' => 'Jumlahuang',
			'returpembelian_id' => 'Returpembelian',
			'noretur' => 'Noretur',
			'tglretur' => 'Tglretur',
			'alasanretur' => 'Alasanretur',
			'keteranganretur' => 'Keteranganretur',
			'totalretur' => 'Totalretur',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'gudangpenerima_id' => 'Gudang Penerima',
			'gudangpenerima_nama' => 'Gudangpenerima Nama',
			'keteranganterima' => 'Keteranganterima',
			'totalpersendiscount' => 'Total Persen Keringanan',
			'totaljmldiscount' => 'Total Jumlah Keringanan',
			'harganettotal' => 'Harganettotal',
			'totalpajakppn' => 'Totalpajakppn',
			'totalpajakpph' => 'Totalpajakpph',
			'totalharga' => 'Totalharga',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'statuspenerimaan' => 'Status Penerimaan',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'pegawaimenyetujui_gelardepan' => 'Pegawaimenyetujui Gelardepan',
			'pegawaimenyetujui_nama' => 'Pegawaimenyetujui Nama',
			'pegawaimenyetujui_gelarbelakang' => 'Pegawaimenyetujui Gelarbelakang',
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

		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('noterima',$this->noterima,true);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
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
		$criteria->compare('permintaanpembelian_id',$this->permintaanpembelian_id);
		$criteria->compare('nopermintaan',$this->nopermintaan,true);
		$criteria->compare('tglpermintaanpembelian',$this->tglpermintaanpembelian,true);
		$criteria->compare('tglterimabarang',$this->tglterimabarang,true);
		$criteria->compare('alamatpengiriman',$this->alamatpengiriman,true);
		$criteria->compare('statuspembelian',$this->statuspembelian,true);
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('norekening',$this->norekening,true);
		$criteria->compare('rekatasnama',$this->rekatasnama,true);
		$criteria->compare('jumlahuang',$this->jumlahuang);
		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		$criteria->compare('noretur',$this->noretur,true);
		$criteria->compare('tglretur',$this->tglretur,true);
		$criteria->compare('alasanretur',$this->alasanretur,true);
		$criteria->compare('keteranganretur',$this->keteranganretur,true);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('gudangpenerima_id',$this->gudangpenerima_id);
		$criteria->compare('gudangpenerima_nama',$this->gudangpenerima_nama,true);
		$criteria->compare('keteranganterima',$this->keteranganterima,true);
		$criteria->compare('totalpersendiscount',$this->totalpersendiscount);
		$criteria->compare('totaljmldiscount',$this->totaljmldiscount);
		$criteria->compare('harganettotal',$this->harganettotal);
		$criteria->compare('totalpajakppn',$this->totalpajakppn);
		$criteria->compare('totalpajakpph',$this->totalpajakpph);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('statuspenerimaan',$this->statuspenerimaan,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('pegawaimenyetujui_gelardepan',$this->pegawaimenyetujui_gelardepan,true);
		$criteria->compare('pegawaimenyetujui_nama',$this->pegawaimenyetujui_nama,true);
		$criteria->compare('pegawaimenyetujui_gelarbelakang',$this->pegawaimenyetujui_gelarbelakang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getPegawaiPenerima(){
		$p = PenerimaanbarangT::model()->findByPk($this->penerimaanbarang_id);
		
		return $p->pegawai->namaLengkap;
	}
	
	
}