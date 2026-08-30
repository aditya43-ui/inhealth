<?php

/**
 * This is the model class for table "informasipermintaanpembelian_v".
 *
 * The followings are the available columns in table 'informasipermintaanpembelian_v':
 * @property integer $permintaanpembelian_id
 * @property string $tglpermintaanpembelian
 * @property string $nopermintaan
 * @property integer $rencanakebfarmasi_id
 * @property string $tglperencanaan
 * @property string $noperencnaan
 * @property string $statusrencana
 * @property integer $permintaanpenawaran_id
 * @property string $tglpenawaran
 * @property string $nosuratpenawaran
 * @property string $statuspenawaran
 * @property boolean $ispenawaranmasuk
 * @property integer $penerimaanbarang_id
 * @property string $estimasitglterima
 * @property string $alamatpengiriman
 * @property string $tglterima
 * @property string $noterima
 * @property integer $fakturpembelian_id
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $pegawai_gelardepan
 * @property string $pegawai_nama
 * @property string $pegawai_gelarbelakang
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
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
 * @property boolean $istermasukppn
 * @property boolean $istermasukpph
 * @property string $keteranganpermintaan
 * @property string $statuspembelian
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 */
class InformasipermintaanpembelianV extends CActiveRecord
{
    public $statuspermintaanuangmuka;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipermintaanpembelianV the static model class
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
		return 'informasipermintaanpembelian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permintaanpembelian_id, rencanakebfarmasi_id, permintaanpenawaran_id, penerimaanbarang_id, fakturpembelian_id, instalasi_id, ruangan_id, pegawai_id, supplier_id, supplier_termin, pegawaimengetahui_id, pegawaimenyetujui_id, sumberdana_id, batalpermintaanpembelian_id, pajak_id', 'numerical', 'integerOnly'=>true),
                    array('jmlpermintaanuangmuka', 'numerical'),
			array('nopermintaan, noperencnaan, nosuratpenawaran, nofaktur, instalasi_nama, ruangan_nama, pegawai_nama, supplier_telp, supplier_fax, supplier_kodepos, supplier_matauang, supplier_website, supplier_email, pegawaimengetahui_nama, pegawaimenyetujui_nama', 'length', 'max'=>50),
			array('statusrencana, statuspenawaran, noterima, supplier_jenis, statuspembelian', 'length', 'max'=>20),
			array('pegawai_gelardepan, supplier_kode, pegawaimengetahui_gelardepan, pegawaimenyetujui_gelardepan', 'length', 'max'=>10),
			array('pegawai_gelarbelakang, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_gelarbelakang', 'length', 'max'=>15),
			array('supplier_nama, supplier_propinsi, supplier_kabupaten, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, pajak_nama', 'length', 'max'=>100),
			array('supplier_logo', 'length', 'max'=>500),
                        array('sumberdana_nama', 'length', 'max'=>100),
                    
			array('tglpermintaanpembelian, tglperencanaan, tglpenawaran, ispenawaranmasuk, estimasitglterima, alamatpengiriman, tglterima, tglfaktur, supplier_alamat, istermasukppn, istermasukpph, keteranganpermintaan, sumberdana_id, sumberdana_nama, tgldikirim, tglpermintaanuangmuka', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permintaanpembelian_id, tglpermintaanpembelian, nopermintaan, rencanakebfarmasi_id, tglperencanaan, noperencnaan, statusrencana, permintaanpenawaran_id, tglpenawaran, nosuratpenawaran, statuspenawaran, ispenawaranmasuk, penerimaanbarang_id, estimasitglterima, alamatpengiriman, tglterima, noterima, fakturpembelian_id, tglfaktur, nofaktur, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pegawai_id, pegawai_gelardepan, pegawai_nama, pegawai_gelarbelakang, supplier_id, supplier_kode, supplier_nama, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_matauang, supplier_website, supplier_email, supplier_logo, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, supplier_jenis, supplier_termin, istermasukppn, istermasukpph, keteranganpermintaan, statuspembelian, pegawaimengetahui_id, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_id, pegawaimenyetujui_gelardepan, pegawaimenyetujui_nama, pegawaimenyetujui_gelarbelakang, pegawaimengetahuiumum_id, tglmengetahuiumum, sumberdana_id, sumberdana_nama, batalpermintaanpembelian_id, tgldikirim, tglpermintaanuangmuka, jmlpermintaanuangmuka, pajak_id, pajak_nama', 'safe', 'on'=>'search'),
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
			'permintaanpembelian_id' => 'Permintaanpembelian',
			'tglpermintaanpembelian' => 'Tanggal Permintaan',
			'nopermintaan' => 'No. Permintaan',
			'rencanakebfarmasi_id' => 'Rencanakebfarmasi',
			'tglperencanaan' => 'Tanggal Rencana',
			'noperencnaan' => 'No. Rencana',
			'statusrencana' => 'Status Rencana',
			'permintaanpenawaran_id' => 'Permintaanpenawaran',
			'tglpenawaran' => 'Tanggal Penawaran',
			'nosuratpenawaran' => 'No. Surat Penawaran',
			'statuspenawaran' => 'Status Penawaran',
			'ispenawaranmasuk' => 'Ispenawaranmasuk',
			'penerimaanbarang_id' => 'Penerimaanbarang',
			'estimasitglterima' => 'Estimasitglterima',
			'alamatpengiriman' => 'Alamatpengiriman',
			'tglterima' => 'Tglterima',
			'noterima' => 'Noterima',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'tglfaktur' => 'Tanggal Faktur',
			'nofaktur' => 'No. Faktur',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'pegawai_gelardepan' => 'Pegawai Gelardepan',
			'pegawai_nama' => 'Pegawai Nama',
			'pegawai_gelarbelakang' => 'Pegawai Gelarbelakang',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Kode Supplier',
			'supplier_nama' => 'Nama Supplier',
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
			'istermasukppn' => 'Istermasukppn',
			'istermasukpph' => 'Istermasukpph',
			'keteranganpermintaan' => 'Keteranganpermintaan',
			'statuspembelian' => 'Status Pembelian',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
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

		$criteria->compare('permintaanpembelian_id',$this->permintaanpembelian_id);
		$criteria->compare('tglpermintaanpembelian',$this->tglpermintaanpembelian,true);
		$criteria->compare('nopermintaan',$this->nopermintaan,true);
		$criteria->compare('rencanakebfarmasi_id',$this->rencanakebfarmasi_id);
		$criteria->compare('tglperencanaan',$this->tglperencanaan,true);
		$criteria->compare('noperencnaan',$this->noperencnaan,true);
		$criteria->compare('statusrencana',$this->statusrencana,true);
		$criteria->compare('permintaanpenawaran_id',$this->permintaanpenawaran_id);
		$criteria->compare('tglpenawaran',$this->tglpenawaran,true);
		$criteria->compare('nosuratpenawaran',$this->nosuratpenawaran,true);
		$criteria->compare('statuspenawaran',$this->statuspenawaran,true);
		$criteria->compare('ispenawaranmasuk',$this->ispenawaranmasuk);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('estimasitglterima',$this->estimasitglterima,true);
		$criteria->compare('alamatpengiriman',$this->alamatpengiriman,true);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterima',$this->noterima,true);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawai_gelardepan',$this->pegawai_gelardepan,true);
		$criteria->compare('pegawai_nama',$this->pegawai_nama,true);
		$criteria->compare('pegawai_gelarbelakang',$this->pegawai_gelarbelakang,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
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
		$criteria->compare('istermasukppn',$this->istermasukppn);
		$criteria->compare('istermasukpph',$this->istermasukpph);
		$criteria->compare('keteranganpermintaan',$this->keteranganpermintaan,true);
		$criteria->compare('statuspembelian',$this->statuspembelian,true);
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
}