<?php

/**
 * This is the model class for table "infokorektifmainten_v".
 *
 * The followings are the available columns in table 'infokorektifmainten_v':
 * @property integer $korektifmainten_id
 * @property string $korektifmainten_jenis
 * @property string $korektifmainten_tgl
 * @property string $korektifmainten_no
 * @property string $korektifmainten_status
 * @property string $korekfitmainten_progress
 * @property string $korektifmainten_finish
 * @property string $korektifmainten_ket
 * @property boolean $iskorektifinternal
 * @property string $korektifmainten_tingkat
 * @property integer $pemohon_id
 * @property string $pemohon_nip
 * @property string $pemohon_gelardepan
 * @property string $pemohon_nama
 * @property integer $gelarpemohon_id
 * @property string $gelarpemohon_nama
 * @property integer $jabatanpemohon_id
 * @property string $jabatanpemohon_nama
 * @property integer $ruangpemohon_id
 * @property string $ruangpemohon_nama
 * @property integer $teknisi_id
 * @property string $teknisi_nip
 * @property string $teknisi_gelardepan
 * @property string $teknisi_nama
 * @property integer $gelarteknisi_id
 * @property string $gelarteknisi_nama
 * @property integer $jabatanteknisi_id
 * @property string $jabatanteknisi_nama
 * @property integer $teknisiperalatan_id
 * @property string $namateknisi
 * @property string $jeniskelamin
 * @property string $tempatlahir
 * @property string $tgllahir
 * @property string $agama
 * @property string $statusperkawinan
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property string $alamat_teknisi
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property string $no_kontak_teknisi
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property integer $invperalatan_id
 * @property string $invperalatan_kode
 * @property string $invperalatan_noregister
 * @property string $invperalatan_namabrg
 * @property string $invperalatan_merk
 * @property string $invperalatan_ukuran
 * @property string $invperalatan_bahan
 * @property string $invperalatan_thnpembelian
 * @property string $invperalatan_tglguna
 * @property string $invperalatan_nopabrik
 * @property string $invperalatan_norangka
 * @property string $invperalatan_nomesin
 * @property string $invperalatan_nopolisi
 * @property string $invperalatan_nobpkb
 * @property double $invperalatan_harga
 * @property double $invperalatan_akumsusut
 * @property string $invperalatan_ket
 * @property string $invperalatan_kapasitasrata
 * @property boolean $invperalatan_ijinoperasional
 * @property string $invperalatan_serftkkalibrasi
 * @property integer $invperalatan_umurekonomis
 * @property string $invperalatan_keadaan
 * @property string $peralatan_model
 * @property string $peralatan_noseri
 * @property string $peralatan_manufacturer
 * @property string $peralatan_garansihabis
 * @property double $peralatan_dayalistrik
 * @property integer $asalaset_id
 * @property string $asalaset_nama
 * @property integer $pemilikbarang_id
 * @property string $pemilikbarang_kode
 * @property string $pemilikbarang_nama
 * @property integer $lokasi_id
 * @property string $lokasiaset_kode
 * @property string $lokasiaset_namainstalasi
 * @property string $lokasiaset_namabagian
 * @property string $lokasiaset_namalokasi
 * @property string $deskripsi_lokasi
 * @property string $jenis_lokasi
 * @property string $alamat_lokasi
 * @property string $kotakab_lokasi
 * @property string $kodepos_lokasi
 * @property string $telp_lokasi
 * @property string $induk_satker
 * @property integer $jenisbarang_id
 * @property string $jenisbarang_nama
 * @property string $jenisbarang_deskripsi
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property boolean $barang_statusregister
 */
class InfokorektifmaintenV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokorektifmaintenV the static model class
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
		return 'infokorektifmainten_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('korektifmainten_id, pemohon_id, gelarpemohon_id, jabatanpemohon_id, ruangpemohon_id, teknisi_id, gelarteknisi_id, jabatanteknisi_id, teknisiperalatan_id, pendidikan_id, kabupaten_id, supplier_id, invperalatan_id, invperalatan_umurekonomis, asalaset_id, pemilikbarang_id, lokasi_id, jenisbarang_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('invperalatan_harga, invperalatan_akumsusut, peralatan_dayalistrik', 'numerical'),
			array('korektifmainten_jenis, korektifmainten_status, jeniskelamin, statusperkawinan, invperalatan_serftkkalibrasi, pemilikbarang_kode', 'length', 'max'=>20),
			array('korektifmainten_no, korektifmainten_tingkat, pemohon_nama, ruangpemohon_nama, teknisi_nama, pendidikan_nama, kabupaten_nama, no_kontak_teknisi, invperalatan_kode, invperalatan_noregister, invperalatan_merk, invperalatan_ukuran, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_keadaan, asalaset_nama, lokasiaset_kode, lokasiaset_namabagian, kodepos_lokasi, telp_lokasi, jenisbarang_nama, barang_type, barang_kode', 'length', 'max'=>50),
			array('pemohon_nip, teknisi_nip', 'length', 'max'=>30),
			array('pemohon_gelardepan, teknisi_gelardepan, agama, supplier_kode, invperalatan_kapasitasrata', 'length', 'max'=>10),
			array('gelarpemohon_nama, gelarteknisi_nama', 'length', 'max'=>25),
			array('jabatanpemohon_nama, jabatanteknisi_nama, namateknisi, tempatlahir, supplier_nama, invperalatan_namabrg, invperalatan_bahan, peralatan_model, peralatan_noseri, peralatan_manufacturer, pemilikbarang_nama, lokasiaset_namainstalasi, lokasiaset_namalokasi, jenis_lokasi, barang_nama', 'length', 'max'=>100),
			array('alamat_teknisi, kotakab_lokasi, induk_satker', 'length', 'max'=>255),
			array('invperalatan_thnpembelian', 'length', 'max'=>5),
			array('deskripsi_lokasi, alamat_lokasi', 'length', 'max'=>300),
			array('korektifmainten_tgl, korekfitmainten_progress, korektifmainten_finish, korektifmainten_ket, iskorektifinternal, tgllahir, invperalatan_tglguna, invperalatan_ket, invperalatan_ijinoperasional, peralatan_garansihabis, jenisbarang_deskripsi, barang_statusregister', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('korektifmainten_id, korektifmainten_jenis, korektifmainten_tgl, korektifmainten_no, korektifmainten_status, korekfitmainten_progress, korektifmainten_finish, korektifmainten_ket, iskorektifinternal, korektifmainten_tingkat, pemohon_id, pemohon_nip, pemohon_gelardepan, pemohon_nama, gelarpemohon_id, gelarpemohon_nama, jabatanpemohon_id, jabatanpemohon_nama, ruangpemohon_id, ruangpemohon_nama, teknisi_id, teknisi_nip, teknisi_gelardepan, teknisi_nama, gelarteknisi_id, gelarteknisi_nama, jabatanteknisi_id, jabatanteknisi_nama, teknisiperalatan_id, namateknisi, jeniskelamin, tempatlahir, tgllahir, agama, statusperkawinan, pendidikan_id, pendidikan_nama, alamat_teknisi, kabupaten_id, kabupaten_nama, no_kontak_teknisi, supplier_id, supplier_kode, supplier_nama, invperalatan_id, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_merk, invperalatan_ukuran, invperalatan_bahan, invperalatan_thnpembelian, invperalatan_tglguna, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_harga, invperalatan_akumsusut, invperalatan_ket, invperalatan_kapasitasrata, invperalatan_ijinoperasional, invperalatan_serftkkalibrasi, invperalatan_umurekonomis, invperalatan_keadaan, peralatan_model, peralatan_noseri, peralatan_manufacturer, peralatan_garansihabis, peralatan_dayalistrik, asalaset_id, asalaset_nama, pemilikbarang_id, pemilikbarang_kode, pemilikbarang_nama, lokasi_id, lokasiaset_kode, lokasiaset_namainstalasi, lokasiaset_namabagian, lokasiaset_namalokasi, deskripsi_lokasi, jenis_lokasi, alamat_lokasi, kotakab_lokasi, kodepos_lokasi, telp_lokasi, induk_satker, jenisbarang_id, jenisbarang_nama, jenisbarang_deskripsi, barang_id, barang_type, barang_kode, barang_nama, barang_statusregister', 'safe', 'on'=>'search'),
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
			'korektifmainten_id' => 'Korektifmainten',
			'korektifmainten_jenis' => 'Korektifmainten Jenis',
			'korektifmainten_tgl' => 'Korektifmainten Tgl',
			'korektifmainten_no' => 'Korektifmainten No',
			'korektifmainten_status' => 'Korektifmainten Status',
			'korekfitmainten_progress' => 'Korekfitmainten Progress',
			'korektifmainten_finish' => 'Korektifmainten Finish',
			'korektifmainten_ket' => 'Korektifmainten Ket',
			'iskorektifinternal' => 'Iskorektifinternal',
			'korektifmainten_tingkat' => 'Korektifmainten Tingkat',
			'pemohon_id' => 'Pemohon',
			'pemohon_nip' => 'Pemohon Nip',
			'pemohon_gelardepan' => 'Pemohon Gelardepan',
			'pemohon_nama' => 'Pemohon Nama',
			'gelarpemohon_id' => 'Gelarpemohon',
			'gelarpemohon_nama' => 'Gelarpemohon Nama',
			'jabatanpemohon_id' => 'Jabatanpemohon',
			'jabatanpemohon_nama' => 'Jabatanpemohon Nama',
			'ruangpemohon_id' => 'Ruangpemohon',
			'ruangpemohon_nama' => 'Ruangpemohon Nama',
			'teknisi_id' => 'Teknisi',
			'teknisi_nip' => 'Teknisi Nip',
			'teknisi_gelardepan' => 'Teknisi Gelardepan',
			'teknisi_nama' => 'Teknisi Nama',
			'gelarteknisi_id' => 'Gelarteknisi',
			'gelarteknisi_nama' => 'Gelarteknisi Nama',
			'jabatanteknisi_id' => 'Jabatanteknisi',
			'jabatanteknisi_nama' => 'Jabatanteknisi Nama',
			'teknisiperalatan_id' => 'Teknisiperalatan',
			'namateknisi' => 'Namateknisi',
			'jeniskelamin' => 'Jeniskelamin',
			'tempatlahir' => 'Tempatlahir',
			'tgllahir' => 'Tgllahir',
			'agama' => 'Agama',
			'statusperkawinan' => 'Statusperkawinan',
			'pendidikan_id' => 'Pendidikan',
			'pendidikan_nama' => 'Pendidikan Nama',
			'alamat_teknisi' => 'Alamat Teknisi',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'no_kontak_teknisi' => 'No Kontak Teknisi',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Supplier Kode',
			'supplier_nama' => 'Supplier Nama',
			'invperalatan_id' => 'Invperalatan',
			'invperalatan_kode' => 'Invperalatan Kode',
			'invperalatan_noregister' => 'Invperalatan Noregister',
			'invperalatan_namabrg' => 'Invperalatan Namabrg',
			'invperalatan_merk' => 'Invperalatan Merk',
			'invperalatan_ukuran' => 'Invperalatan Ukuran',
			'invperalatan_bahan' => 'Invperalatan Bahan',
			'invperalatan_thnpembelian' => 'Invperalatan Thnpembelian',
			'invperalatan_tglguna' => 'Invperalatan Tglguna',
			'invperalatan_nopabrik' => 'Invperalatan Nopabrik',
			'invperalatan_norangka' => 'Invperalatan Norangka',
			'invperalatan_nomesin' => 'Invperalatan Nomesin',
			'invperalatan_nopolisi' => 'Invperalatan Nopolisi',
			'invperalatan_nobpkb' => 'Invperalatan Nobpkb',
			'invperalatan_harga' => 'Invperalatan Harga',
			'invperalatan_akumsusut' => 'Invperalatan Akumsusut',
			'invperalatan_ket' => 'Invperalatan Ket',
			'invperalatan_kapasitasrata' => 'Invperalatan Kapasitasrata',
			'invperalatan_ijinoperasional' => 'Invperalatan Ijinoperasional',
			'invperalatan_serftkkalibrasi' => 'Invperalatan Serftkkalibrasi',
			'invperalatan_umurekonomis' => 'Invperalatan Umurekonomis',
			'invperalatan_keadaan' => 'Invperalatan Keadaan',
			'peralatan_model' => 'Peralatan Model',
			'peralatan_noseri' => 'Peralatan Noseri',
			'peralatan_manufacturer' => 'Peralatan Manufacturer',
			'peralatan_garansihabis' => 'Peralatan Garansihabis',
			'peralatan_dayalistrik' => 'Peralatan Dayalistrik',
			'asalaset_id' => 'Asalaset',
			'asalaset_nama' => 'Asalaset Nama',
			'pemilikbarang_id' => 'Pemilikbarang',
			'pemilikbarang_kode' => 'Pemilikbarang Kode',
			'pemilikbarang_nama' => 'Pemilikbarang Nama',
			'lokasi_id' => 'Lokasi',
			'lokasiaset_kode' => 'Lokasiaset Kode',
			'lokasiaset_namainstalasi' => 'Lokasiaset Namainstalasi',
			'lokasiaset_namabagian' => 'Lokasiaset Namabagian',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'deskripsi_lokasi' => 'Deskripsi Lokasi',
			'jenis_lokasi' => 'Jenis Lokasi',
			'alamat_lokasi' => 'Alamat Lokasi',
			'kotakab_lokasi' => 'Kotakab Lokasi',
			'kodepos_lokasi' => 'Kodepos Lokasi',
			'telp_lokasi' => 'Telp Lokasi',
			'induk_satker' => 'Induk Satker',
			'jenisbarang_id' => 'Jenisbarang',
			'jenisbarang_nama' => 'Jenisbarang Nama',
			'jenisbarang_deskripsi' => 'Jenisbarang Deskripsi',
			'barang_id' => 'Barang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',
			'barang_statusregister' => 'Barang Statusregister',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->korektifmainten_id)){
			$criteria->addCondition('korektifmainten_id = '.$this->korektifmainten_id);
		}
		$criteria->compare('LOWER(korektifmainten_jenis)',strtolower($this->korektifmainten_jenis),true);
		$criteria->compare('LOWER(korektifmainten_tgl)',strtolower($this->korektifmainten_tgl),true);
		$criteria->compare('LOWER(korektifmainten_no)',strtolower($this->korektifmainten_no),true);
		$criteria->compare('LOWER(korektifmainten_status)',strtolower($this->korektifmainten_status),true);
		$criteria->compare('LOWER(korekfitmainten_progress)',strtolower($this->korekfitmainten_progress),true);
		$criteria->compare('LOWER(korektifmainten_finish)',strtolower($this->korektifmainten_finish),true);
		$criteria->compare('LOWER(korektifmainten_ket)',strtolower($this->korektifmainten_ket),true);
		$criteria->compare('iskorektifinternal',$this->iskorektifinternal);
		$criteria->compare('LOWER(korektifmainten_tingkat)',strtolower($this->korektifmainten_tingkat),true);
		if(!empty($this->pemohon_id)){
			$criteria->addCondition('pemohon_id = '.$this->pemohon_id);
		}
		$criteria->compare('LOWER(pemohon_nip)',strtolower($this->pemohon_nip),true);
		$criteria->compare('LOWER(pemohon_gelardepan)',strtolower($this->pemohon_gelardepan),true);
		$criteria->compare('LOWER(pemohon_nama)',strtolower($this->pemohon_nama),true);
		if(!empty($this->gelarpemohon_id)){
			$criteria->addCondition('gelarpemohon_id = '.$this->gelarpemohon_id);
		}
		$criteria->compare('LOWER(gelarpemohon_nama)',strtolower($this->gelarpemohon_nama),true);
		if(!empty($this->jabatanpemohon_id)){
			$criteria->addCondition('jabatanpemohon_id = '.$this->jabatanpemohon_id);
		}
		$criteria->compare('LOWER(jabatanpemohon_nama)',strtolower($this->jabatanpemohon_nama),true);
		if(!empty($this->ruangpemohon_id)){
			$criteria->addCondition('ruangpemohon_id = '.$this->ruangpemohon_id);
		}
		$criteria->compare('LOWER(ruangpemohon_nama)',strtolower($this->ruangpemohon_nama),true);
		if(!empty($this->teknisi_id)){
			$criteria->addCondition('teknisi_id = '.$this->teknisi_id);
		}
		$criteria->compare('LOWER(teknisi_nip)',strtolower($this->teknisi_nip),true);
		$criteria->compare('LOWER(teknisi_gelardepan)',strtolower($this->teknisi_gelardepan),true);
		$criteria->compare('LOWER(teknisi_nama)',strtolower($this->teknisi_nama),true);
		if(!empty($this->gelarteknisi_id)){
			$criteria->addCondition('gelarteknisi_id = '.$this->gelarteknisi_id);
		}
		$criteria->compare('LOWER(gelarteknisi_nama)',strtolower($this->gelarteknisi_nama),true);
		if(!empty($this->jabatanteknisi_id)){
			$criteria->addCondition('jabatanteknisi_id = '.$this->jabatanteknisi_id);
		}
		$criteria->compare('LOWER(jabatanteknisi_nama)',strtolower($this->jabatanteknisi_nama),true);
		if(!empty($this->teknisiperalatan_id)){
			$criteria->addCondition('teknisiperalatan_id = '.$this->teknisiperalatan_id);
		}
		$criteria->compare('LOWER(namateknisi)',strtolower($this->namateknisi),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempatlahir)',strtolower($this->tempatlahir),true);
		$criteria->compare('LOWER(tgllahir)',strtolower($this->tgllahir),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		if(!empty($this->pendidikan_id)){
			$criteria->addCondition('pendidikan_id = '.$this->pendidikan_id);
		}
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('LOWER(alamat_teknisi)',strtolower($this->alamat_teknisi),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('LOWER(no_kontak_teknisi)',strtolower($this->no_kontak_teknisi),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(invperalatan_noregister)',strtolower($this->invperalatan_noregister),true);
		$criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(invperalatan_merk)',strtolower($this->invperalatan_merk),true);
		$criteria->compare('LOWER(invperalatan_ukuran)',strtolower($this->invperalatan_ukuran),true);
		$criteria->compare('LOWER(invperalatan_bahan)',strtolower($this->invperalatan_bahan),true);
		$criteria->compare('LOWER(invperalatan_thnpembelian)',strtolower($this->invperalatan_thnpembelian),true);
		$criteria->compare('LOWER(invperalatan_tglguna)',strtolower($this->invperalatan_tglguna),true);
		$criteria->compare('LOWER(invperalatan_nopabrik)',strtolower($this->invperalatan_nopabrik),true);
		$criteria->compare('LOWER(invperalatan_norangka)',strtolower($this->invperalatan_norangka),true);
		$criteria->compare('LOWER(invperalatan_nomesin)',strtolower($this->invperalatan_nomesin),true);
		$criteria->compare('LOWER(invperalatan_nopolisi)',strtolower($this->invperalatan_nopolisi),true);
		$criteria->compare('LOWER(invperalatan_nobpkb)',strtolower($this->invperalatan_nobpkb),true);
		$criteria->compare('invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('LOWER(invperalatan_ket)',strtolower($this->invperalatan_ket),true);
		$criteria->compare('LOWER(invperalatan_kapasitasrata)',strtolower($this->invperalatan_kapasitasrata),true);
		$criteria->compare('invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('LOWER(invperalatan_serftkkalibrasi)',strtolower($this->invperalatan_serftkkalibrasi),true);
		if(!empty($this->invperalatan_umurekonomis)){
			$criteria->addCondition('invperalatan_umurekonomis = '.$this->invperalatan_umurekonomis);
		}
		$criteria->compare('LOWER(invperalatan_keadaan)',strtolower($this->invperalatan_keadaan),true);
		$criteria->compare('LOWER(peralatan_model)',strtolower($this->peralatan_model),true);
		$criteria->compare('LOWER(peralatan_noseri)',strtolower($this->peralatan_noseri),true);
		$criteria->compare('LOWER(peralatan_manufacturer)',strtolower($this->peralatan_manufacturer),true);
		$criteria->compare('LOWER(peralatan_garansihabis)',strtolower($this->peralatan_garansihabis),true);
		$criteria->compare('peralatan_dayalistrik',$this->peralatan_dayalistrik);
		if(!empty($this->asalaset_id)){
			$criteria->addCondition('asalaset_id = '.$this->asalaset_id);
		}
		$criteria->compare('LOWER(asalaset_nama)',strtolower($this->asalaset_nama),true);
		if(!empty($this->pemilikbarang_id)){
			$criteria->addCondition('pemilikbarang_id = '.$this->pemilikbarang_id);
		}
		$criteria->compare('LOWER(pemilikbarang_kode)',strtolower($this->pemilikbarang_kode),true);
		$criteria->compare('LOWER(pemilikbarang_nama)',strtolower($this->pemilikbarang_nama),true);
		if(!empty($this->lokasi_id)){
			$criteria->addCondition('lokasi_id = '.$this->lokasi_id);
		}
		$criteria->compare('LOWER(lokasiaset_kode)',strtolower($this->lokasiaset_kode),true);
		$criteria->compare('LOWER(lokasiaset_namainstalasi)',strtolower($this->lokasiaset_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_namabagian)',strtolower($this->lokasiaset_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_namalokasi)',strtolower($this->lokasiaset_namalokasi),true);
		$criteria->compare('LOWER(deskripsi_lokasi)',strtolower($this->deskripsi_lokasi),true);
		$criteria->compare('LOWER(jenis_lokasi)',strtolower($this->jenis_lokasi),true);
		$criteria->compare('LOWER(alamat_lokasi)',strtolower($this->alamat_lokasi),true);
		$criteria->compare('LOWER(kotakab_lokasi)',strtolower($this->kotakab_lokasi),true);
		$criteria->compare('LOWER(kodepos_lokasi)',strtolower($this->kodepos_lokasi),true);
		$criteria->compare('LOWER(telp_lokasi)',strtolower($this->telp_lokasi),true);
		$criteria->compare('LOWER(induk_satker)',strtolower($this->induk_satker),true);
		if(!empty($this->jenisbarang_id)){
			$criteria->addCondition('jenisbarang_id = '.$this->jenisbarang_id);
		}
		$criteria->compare('LOWER(jenisbarang_nama)',strtolower($this->jenisbarang_nama),true);
		$criteria->compare('LOWER(jenisbarang_deskripsi)',strtolower($this->jenisbarang_deskripsi),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}