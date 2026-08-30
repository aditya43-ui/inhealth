<?php

/**
 * This is the model class for table "infomutasiaset_v".
 *
 * The followings are the available columns in table 'infomutasiaset_v':
 * @property integer $mutasiaset_id
 * @property string $nomutasiaset
 * @property string $tglmutasiaset
 * @property string $pegpenerima_tgl
 * @property string $mutasiaset_status
 * @property integer $ruangasal_id
 * @property string $ruangasal_nama
 * @property integer $menyerahkan_id
 * @property string $menyerahkan_nip
 * @property string $menyerahkan_gelardepan
 * @property string $menyerahkan_nama
 * @property integer $gelarbelakangserah_id
 * @property string $gelarbelakangserah_nama
 * @property integer $jabatanserah_id
 * @property string $jabatanserah_nama
 * @property integer $ruangtujuan_id
 * @property string $ruangtujuan_nama
 * @property integer $penerima_id
 * @property string $penerima_nip
 * @property string $penerima_gelardepan
 * @property string $penerima_nama
 * @property integer $gelarbelakangterima_id
 * @property string $gelarbelakangterima_nama
 * @property integer $jabatanterima_id
 * @property string $jabatanterima_nama
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
class InfomutasiasetV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $instalasiasal_id;
        public $instalasiasal_nama;
        public $instalasitujuan_id;
        public $instalasitujuan_nama;
        public $pegmenyerahkan_nama;
        public $pegmenyerahkan_id;
        public $pegpenerima_nama;
        public $pegpenerima_id;

        public $mutasi_keadaan;
        public $ket_mutasi;  
        public $unitkerjaasal_nama;
        public $unitkerjatujuan_nama;
        public $unitasal_id;
        public $unittujuan_id;
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfomutasiasetV the static model class
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
		return 'infomutasiaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mutasiaset_id, ruangasal_id, menyerahkan_id, gelarbelakangserah_id, jabatanserah_id, ruangtujuan_id, penerima_id, gelarbelakangterima_id, jabatanterima_id, invperalatan_id, invperalatan_umurekonomis, asalaset_id, pemilikbarang_id, lokasi_id, jenisbarang_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('invperalatan_harga, invperalatan_akumsusut, peralatan_dayalistrik', 'numerical'),
			array('nomutasiaset, jabatanserah_nama, jabatanterima_nama, invperalatan_namabrg, invperalatan_bahan, peralatan_model, peralatan_noseri, peralatan_manufacturer, pemilikbarang_nama, lokasiaset_namainstalasi, lokasiaset_namalokasi, jenis_lokasi, barang_nama', 'length', 'max'=>100),
			array('mutasiaset_status, gelarbelakangserah_nama, gelarbelakangterima_nama', 'length', 'max'=>25),
			array('ruangasal_nama, menyerahkan_nama, ruangtujuan_nama, penerima_nama, invperalatan_kode, invperalatan_noregister, invperalatan_merk, invperalatan_ukuran, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_keadaan, asalaset_nama, lokasiaset_kode, lokasiaset_namabagian, kodepos_lokasi, telp_lokasi, jenisbarang_nama, barang_type, barang_kode', 'length', 'max'=>50),
			array('menyerahkan_nip, penerima_nip', 'length', 'max'=>30),
			array('menyerahkan_gelardepan, penerima_gelardepan, invperalatan_kapasitasrata', 'length', 'max'=>10),
			array('invperalatan_thnpembelian', 'length', 'max'=>5),
			array('invperalatan_serftkkalibrasi, pemilikbarang_kode', 'length', 'max'=>20),
			array('deskripsi_lokasi, alamat_lokasi', 'length', 'max'=>300),
			array('kotakab_lokasi, induk_satker', 'length', 'max'=>255),
			array('lokasitujuan_id, lokasiasal_id, ruangantujuan_id, ruanganasal_id, tglmutasiaset, pegpenerima_tgl, invperalatan_tglguna, invperalatan_ket, invperalatan_ijinoperasional, peralatan_garansihabis, jenisbarang_deskripsi, barang_statusregister', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasiaset_id, nomutasiaset, tglmutasiaset, pegpenerima_tgl, mutasiaset_status, ruangasal_id, ruangasal_nama, menyerahkan_id, menyerahkan_nip, menyerahkan_gelardepan, menyerahkan_nama, gelarbelakangserah_id, gelarbelakangserah_nama, jabatanserah_id, jabatanserah_nama, ruangtujuan_id, ruangtujuan_nama, penerima_id, penerima_nip, penerima_gelardepan, penerima_nama, gelarbelakangterima_id, gelarbelakangterima_nama, jabatanterima_id, jabatanterima_nama, invperalatan_id, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_merk, invperalatan_ukuran, invperalatan_bahan, invperalatan_thnpembelian, invperalatan_tglguna, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_harga, invperalatan_akumsusut, invperalatan_ket, invperalatan_kapasitasrata, invperalatan_ijinoperasional, invperalatan_serftkkalibrasi, invperalatan_umurekonomis, invperalatan_keadaan, peralatan_model, peralatan_noseri, peralatan_manufacturer, peralatan_garansihabis, peralatan_dayalistrik, asalaset_id, asalaset_nama, pemilikbarang_id, pemilikbarang_kode, pemilikbarang_nama, lokasi_id, lokasiaset_kode, lokasiaset_namainstalasi, lokasiaset_namabagian, lokasiaset_namalokasi, deskripsi_lokasi, jenis_lokasi, alamat_lokasi, kotakab_lokasi, kodepos_lokasi, telp_lokasi, induk_satker, jenisbarang_id, jenisbarang_nama, jenisbarang_deskripsi, barang_id, barang_type, barang_kode, barang_nama, barang_statusregister', 'safe', 'on'=>'search'),
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
			'mutasiaset_id' => 'Mutasiaset',
			'nomutasiaset' => 'Nomutasiaset',
			'tglmutasiaset' => 'Tglmutasiaset',
			'pegpenerima_tgl' => 'Pegpenerima Tgl',
			'mutasiaset_status' => 'Mutasiaset Status',
			'ruangasal_id' => 'Ruangan Asal',
			'ruangasal_nama' => 'Ruangasal Nama',
			'menyerahkan_id' => 'Menyerahkan',
			'menyerahkan_nip' => 'Menyerahkan Nip',
			'menyerahkan_gelardepan' => 'Menyerahkan Gelardepan',
			'menyerahkan_nama' => 'Menyerahkan Nama',
			'gelarbelakangserah_id' => 'Gelarbelakangserah',
			'gelarbelakangserah_nama' => 'Gelarbelakangserah Nama',
			'jabatanserah_id' => 'Jabatanserah',
			'jabatanserah_nama' => 'Jabatanserah Nama',
			'ruangtujuan_id' => 'Ruangan Tujuan',
			'ruangtujuan_nama' => 'Ruangtujuan Nama',
			'penerima_id' => 'Penerima',
			'penerima_nip' => 'Penerima Nip',
			'penerima_gelardepan' => 'Penerima Gelardepan',
			'penerima_nama' => 'Penerima Nama',
			'gelarbelakangterima_id' => 'Gelarbelakangterima',
			'gelarbelakangterima_nama' => 'Gelarbelakangterima Nama',
			'jabatanterima_id' => 'Jabatanterima',
			'jabatanterima_nama' => 'Jabatanterima Nama',
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
                        'instalasiasal_id' => 'Unit Kerja Asal',
                        'instalasitujuan_id' => 'Unit Kerja Tujuan',
                        'unitasal_id' => 'Unit Kerja Asal',
                        'unittujuan_id' => 'Unit Kerja Tujuan',
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

		$criteria->compare('mutasiaset_id',$this->mutasiaset_id);
		$criteria->compare('nomutasiaset',$this->nomutasiaset,true);
		$criteria->compare('tglmutasiaset',$this->tglmutasiaset,true);
		$criteria->compare('pegpenerima_tgl',$this->pegpenerima_tgl,true);
		$criteria->compare('mutasiaset_status',$this->mutasiaset_status,true);
		$criteria->compare('ruangasal_id',$this->ruangasal_id);
		$criteria->compare('ruangasal_nama',$this->ruangasal_nama,true);
		$criteria->compare('menyerahkan_id',$this->menyerahkan_id);
		$criteria->compare('menyerahkan_nip',$this->menyerahkan_nip,true);
		$criteria->compare('menyerahkan_gelardepan',$this->menyerahkan_gelardepan,true);
		$criteria->compare('menyerahkan_nama',$this->menyerahkan_nama,true);
		$criteria->compare('gelarbelakangserah_id',$this->gelarbelakangserah_id);
		$criteria->compare('gelarbelakangserah_nama',$this->gelarbelakangserah_nama,true);
		$criteria->compare('jabatanserah_id',$this->jabatanserah_id);
		$criteria->compare('jabatanserah_nama',$this->jabatanserah_nama,true);
		$criteria->compare('ruangtujuan_id',$this->ruangtujuan_id);
		$criteria->compare('ruangtujuan_nama',$this->ruangtujuan_nama,true);
		$criteria->compare('penerima_id',$this->penerima_id);
		$criteria->compare('penerima_nip',$this->penerima_nip,true);
		$criteria->compare('penerima_gelardepan',$this->penerima_gelardepan,true);
		$criteria->compare('penerima_nama',$this->penerima_nama,true);
		$criteria->compare('gelarbelakangterima_id',$this->gelarbelakangterima_id);
		$criteria->compare('gelarbelakangterima_nama',$this->gelarbelakangterima_nama,true);
		$criteria->compare('jabatanterima_id',$this->jabatanterima_id);
		$criteria->compare('jabatanterima_nama',$this->jabatanterima_nama,true);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('invperalatan_kode',$this->invperalatan_kode,true);
		$criteria->compare('invperalatan_noregister',$this->invperalatan_noregister,true);
		$criteria->compare('invperalatan_namabrg',$this->invperalatan_namabrg,true);
		$criteria->compare('invperalatan_merk',$this->invperalatan_merk,true);
		$criteria->compare('invperalatan_ukuran',$this->invperalatan_ukuran,true);
		$criteria->compare('invperalatan_bahan',$this->invperalatan_bahan,true);
		$criteria->compare('invperalatan_thnpembelian',$this->invperalatan_thnpembelian,true);
		$criteria->compare('invperalatan_tglguna',$this->invperalatan_tglguna,true);
		$criteria->compare('invperalatan_nopabrik',$this->invperalatan_nopabrik,true);
		$criteria->compare('invperalatan_norangka',$this->invperalatan_norangka,true);
		$criteria->compare('invperalatan_nomesin',$this->invperalatan_nomesin,true);
		$criteria->compare('invperalatan_nopolisi',$this->invperalatan_nopolisi,true);
		$criteria->compare('invperalatan_nobpkb',$this->invperalatan_nobpkb,true);
		$criteria->compare('invperalatan_harga',$this->invperalatan_harga);
		$criteria->compare('invperalatan_akumsusut',$this->invperalatan_akumsusut);
		$criteria->compare('invperalatan_ket',$this->invperalatan_ket,true);
		$criteria->compare('invperalatan_kapasitasrata',$this->invperalatan_kapasitasrata,true);
		$criteria->compare('invperalatan_ijinoperasional',$this->invperalatan_ijinoperasional);
		$criteria->compare('invperalatan_serftkkalibrasi',$this->invperalatan_serftkkalibrasi,true);
		$criteria->compare('invperalatan_umurekonomis',$this->invperalatan_umurekonomis);
		$criteria->compare('invperalatan_keadaan',$this->invperalatan_keadaan,true);
		$criteria->compare('peralatan_model',$this->peralatan_model,true);
		$criteria->compare('peralatan_noseri',$this->peralatan_noseri,true);
		$criteria->compare('peralatan_manufacturer',$this->peralatan_manufacturer,true);
		$criteria->compare('peralatan_garansihabis',$this->peralatan_garansihabis,true);
		$criteria->compare('peralatan_dayalistrik',$this->peralatan_dayalistrik);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('asalaset_nama',$this->asalaset_nama,true);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('pemilikbarang_kode',$this->pemilikbarang_kode,true);
		$criteria->compare('pemilikbarang_nama',$this->pemilikbarang_nama,true);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('lokasiaset_kode',$this->lokasiaset_kode,true);
		$criteria->compare('lokasiaset_namainstalasi',$this->lokasiaset_namainstalasi,true);
		$criteria->compare('lokasiaset_namabagian',$this->lokasiaset_namabagian,true);
		$criteria->compare('lokasiaset_namalokasi',$this->lokasiaset_namalokasi,true);
		$criteria->compare('deskripsi_lokasi',$this->deskripsi_lokasi,true);
		$criteria->compare('jenis_lokasi',$this->jenis_lokasi,true);
		$criteria->compare('alamat_lokasi',$this->alamat_lokasi,true);
		$criteria->compare('kotakab_lokasi',$this->kotakab_lokasi,true);
		$criteria->compare('kodepos_lokasi',$this->kodepos_lokasi,true);
		$criteria->compare('telp_lokasi',$this->telp_lokasi,true);
		$criteria->compare('induk_satker',$this->induk_satker,true);
		$criteria->compare('jenisbarang_id',$this->jenisbarang_id);
		$criteria->compare('jenisbarang_nama',$this->jenisbarang_nama,true);
		$criteria->compare('jenisbarang_deskripsi',$this->jenisbarang_deskripsi,true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNamaLengkapPenerima(){
            return $this->penerima_gelardepan.' '.$this->penerima_nama.' '.$this->gelarbelakangterima_nama;
        }
        
        public function getNamaLengkapMenyerahkan(){
            return $this->menyerahkan_gelardepan.' '.$this->menyerahkan_nama.' '.$this->gelarbelakangserah_nama;
        }
}