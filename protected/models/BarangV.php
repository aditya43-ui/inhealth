<?php

/**
 * This is the model class for table "barang_v".
 *
 * The followings are the available columns in table 'barang_v':
 * @property integer $golongan_id
 * @property string $golongan_kode
 * @property string $golongan_nama
 * @property integer $kelompok_id
 * @property string $kelompok_kode
 * @property string $kelompok_nama
 * @property integer $subkelompok_id
 * @property string $subkelompok_kode
 * @property string $subkelompok_nama
 * @property integer $bidang_id
 * @property string $bidang_kode
 * @property string $bidang_nama
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_namalainnya
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_statusregister
 * @property integer $barang_ekonomis_thn
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 * @property string $barang_image
 * @property boolean $barang_aktif
 * @property integer $invasetlain_id
 * @property integer $asalaset_inventarisasiasetlain_id
 * @property string $asalaset_inventarisasiasetlain_nama
 * @property string $asalaset_inventarisasiasetlain_singkatan
 * @property integer $lokasiaset_inventarisasiasetlain_id
 * @property string $lokasiaset_inventarisasiasetlain_kode
 * @property string $lokasiaset_inventarisasiasetlain_namainstalasi
 * @property string $lokasiaset_inventarisasiasetlain_namabagian
 * @property string $lokasiaset_inventarisasiasetlain_namalokasi
 * @property integer $pemilikbarang_inventarisasiasetlain_id
 * @property string $pemilikbarang_inventarisasiasetlain_kode
 * @property string $pemilikbarang_inventarisasiasetlain_nama
 * @property string $invasetlain_kode
 * @property string $invasetlain_noregister
 * @property string $invasetlain_namabrg
 * @property string $invasetlain_judulbuku
 * @property string $invasetlain_spesifikasibuku
 * @property string $invasetlain_asalkesenian
 * @property double $invasetlain_jumlah
 * @property string $invasetlain_thncetak
 * @property double $invasetlain_harga
 * @property string $invasetlain_tglguna
 * @property double $invasetlain_akumsusut
 * @property string $invasetlain_ket
 * @property string $invasetlain_penciptakesenian
 * @property string $invasetlain_bahankesenian
 * @property string $invasetlain_jenishewan_tum
 * @property string $invasetlain_ukuranhewan_tum
 * @property integer $invtanah_id
 * @property integer $asalaset_inventarisasitanah_id
 * @property string $asalaset_inventarisasitanah_nama
 * @property string $asalaset_inventarisasitanah_singkatan
 * @property integer $lokasiaset_inventarisasitanah_id
 * @property string $lokasiaset_inventarisasitanah_kode
 * @property string $lokasiaset_inventarisasitanah_namainstalasi
 * @property string $lokasiaset_inventarisasitanah_namabagian
 * @property string $lokasiaset_inventarisasitanah_namalokasi
 * @property integer $pemilikbarang_inventarisasitanah_id
 * @property string $pemilikbarang_inventarisasitanah_kode
 * @property string $pemilikbarang_inventarisasitanah_nama
 * @property string $invtanah_kode
 * @property string $invtanah_noregister
 * @property string $invtanah_namabrg
 * @property string $invtanah_luas
 * @property string $invtanah_thnpengadaan
 * @property string $invtanah_tglguna
 * @property string $invtanah_alamat
 * @property string $invtanah_status
 * @property string $invtanah_tglsertifikat
 * @property string $invtanah_nosertifikat
 * @property string $invtanah_penggunaan
 * @property double $invtanah_harga
 * @property string $invtanah_ket
 * @property double $invtanah_umurekonomis
 * @property double $invtanah_nilairesidu
 * @property string $tglpenghapusan
 * @property string $tipepenghapusan
 * @property double $hargajualaktiva
 * @property double $kerugian
 * @property double $keuntungan
 * @property integer $invperalatan_id
 * @property integer $asalaset_inventarisasiperalatan_id
 * @property string $asalaset_inventarisasiperalatan_nama
 * @property string $asalaset_inventarisasiperalatan_singkatan
 * @property integer $lokasiaset_inventarisasiperalatan_id
 * @property string $lokasiaset_inventarisasiperalatan_kode
 * @property string $lokasiaset_inventarisasiperalatan_namainstalasi
 * @property string $lokasiaset_inventarisasiperalatan_namabagian
 * @property string $lokasiaset_inventarisasiperalatan_namalokasi
 * @property integer $pemilikbarang_inventarisasiperalatan_id
 * @property string $pemilikbarang_inventarisasiperalatan_kode
 * @property string $pemilikbarang_inventarisasiperalatan_nama
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
 * @property integer $invgedung_id
 * @property integer $asalaset_inventarisasigedung_id
 * @property string $asalaset_inventarisasigedung_nama
 * @property string $asalaset_inventarisasigedung_singkatan
 * @property integer $lokasiaset_inventarisasigedung_id
 * @property string $lokasiaset_inventarisasigedung_kode
 * @property string $lokasiaset_inventarisasigedung_namainstalasi
 * @property string $lokasiaset_inventarisasigedung_namabagian
 * @property string $lokasiaset_inventarisasigedung_namalokasi
 * @property integer $pemilikbarang_inventarisasigedung_id
 * @property string $pemilikbarang_inventarisasigedung_kode
 * @property string $pemilikbarang_inventarisasigedung_nama
 * @property string $invgedung_kode
 * @property string $invgedung_noregister
 * @property string $invgedung_namabrg
 * @property string $invgedung_kontruksi
 * @property double $invgedung_luaslantai
 * @property string $invgedung_alamat
 * @property string $invgedung_tgldokumen
 * @property string $invgedung_tglguna
 * @property string $invgedung_nodokumen
 * @property double $invgedung_harga
 * @property double $invgedung_akumsusut
 * @property string $invgedung_ket
 * @property integer $invgedung_umurekonomis
 * @property double $invgedung_nilairesidu
 * @property integer $invjalan_id
 * @property integer $asalaset_inventarisasijalan_id
 * @property string $asalaset_inventarisasijalan_nama
 * @property string $asalaset_inventarisasijalan_singkatan
 * @property integer $lokasiaset_inventarisasijalan_id
 * @property string $lokasiaset_inventarisasijalan_kode
 * @property string $lokasiaset_inventarisasijalan_namainstalasi
 * @property string $lokasiaset_inventarisasijalan_namabagian
 * @property string $lokasiaset_inventarisasijalan_namalokasi
 * @property integer $pemilikbarang_inventarisasijalan_id
 * @property string $pemilikbarang_inventarisasijalan_kode
 * @property string $pemilikbarang_inventarisasijalan_nama
 * @property string $invjalan_kode
 * @property string $invjalan_noregister
 * @property string $invjalan_namabrg
 * @property string $invjalan_kontruksi
 * @property string $invjalan_panjang
 * @property string $invjalan_lebar
 * @property string $invjalan_luas
 * @property string $invjalan_letak
 * @property string $invjalan_tgldokumen
 * @property string $invjalan_tglguna
 * @property string $invjalan_nodokumen
 * @property string $invjalan_statustanah
 * @property string $invjalan_keadaaan
 * @property double $invjalan_harga
 * @property double $invjalan_akumsusut
 * @property string $invjalan_ket
 * @property double $barang_harganetto
 * @property double $barang_persendiskon
 * @property double $barang_ppn
 * @property double $barang_hpp
 * @property double $barang_hargajual
 */
class BarangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BarangV the static model class
	 */
    public $subsubkelompok_id;
    public $subsubkelompok_nama;
    public $subsubkelompok_kode;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'barang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subsubkelompok_id, golongan_id, kelompok_id, subkelompok_id, bidang_id, barang_id, barang_ekonomis_thn, barang_jmldlmkemasan, invasetlain_id, asalaset_inventarisasiasetlain_id, lokasiaset_inventarisasiasetlain_id, pemilikbarang_inventarisasiasetlain_id, invtanah_id, asalaset_inventarisasitanah_id, lokasiaset_inventarisasitanah_id, pemilikbarang_inventarisasitanah_id, invperalatan_id, asalaset_inventarisasiperalatan_id, lokasiaset_inventarisasiperalatan_id, pemilikbarang_inventarisasiperalatan_id, invperalatan_umurekonomis, invgedung_id, asalaset_inventarisasigedung_id, lokasiaset_inventarisasigedung_id, pemilikbarang_inventarisasigedung_id, invgedung_umurekonomis, invjalan_id, asalaset_inventarisasijalan_id, lokasiaset_inventarisasijalan_id, pemilikbarang_inventarisasijalan_id', 'numerical', 'integerOnly'=>true),
			array('invasetlain_jumlah, invasetlain_harga, invasetlain_akumsusut, invtanah_harga, invtanah_umurekonomis, invtanah_nilairesidu, hargajualaktiva, kerugian, keuntungan, invperalatan_harga, invperalatan_akumsusut, invgedung_luaslantai, invgedung_harga, invgedung_akumsusut, invgedung_nilairesidu, invjalan_harga, invjalan_akumsusut, barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual', 'numerical'),
			array('golongan_kode, kelompok_kode, subkelompok_kode, bidang_kode, barang_type, barang_kode, barang_merk, barang_warna, barang_satuan, asalaset_inventarisasiasetlain_nama, lokasiaset_inventarisasiasetlain_kode, lokasiaset_inventarisasiasetlain_namabagian, invasetlain_kode, invasetlain_noregister, invasetlain_judulbuku, invasetlain_spesifikasibuku, invasetlain_asalkesenian, invasetlain_penciptakesenian, invasetlain_bahankesenian, invasetlain_jenishewan_tum, invasetlain_ukuranhewan_tum, asalaset_inventarisasitanah_nama, lokasiaset_inventarisasitanah_kode, lokasiaset_inventarisasitanah_namabagian, invtanah_kode, invtanah_noregister, invtanah_status, asalaset_inventarisasiperalatan_nama, lokasiaset_inventarisasiperalatan_kode, lokasiaset_inventarisasiperalatan_namabagian, invperalatan_kode, invperalatan_noregister, invperalatan_merk, invperalatan_ukuran, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_keadaan, asalaset_inventarisasigedung_nama, lokasiaset_inventarisasigedung_kode, lokasiaset_inventarisasigedung_namabagian, invgedung_kode, invgedung_noregister, asalaset_inventarisasijalan_nama, lokasiaset_inventarisasijalan_kode, lokasiaset_inventarisasijalan_namabagian, invjalan_kode, invjalan_noregister, invjalan_statustanah, invjalan_keadaaan', 'length', 'max'=>50),
			array('golongan_nama, kelompok_nama, subkelompok_nama, bidang_nama, barang_nama, barang_namalainnya, lokasiaset_inventarisasiasetlain_namainstalasi, lokasiaset_inventarisasiasetlain_namalokasi, pemilikbarang_inventarisasiasetlain_nama, invasetlain_namabrg, invasetlain_ket, lokasiaset_inventarisasitanah_namainstalasi, lokasiaset_inventarisasitanah_namalokasi, pemilikbarang_inventarisasitanah_nama, invtanah_namabrg, invtanah_nosertifikat, invtanah_penggunaan, invtanah_ket, lokasiaset_inventarisasiperalatan_namainstalasi, lokasiaset_inventarisasiperalatan_namalokasi, pemilikbarang_inventarisasiperalatan_nama, invperalatan_namabrg, invperalatan_bahan, lokasiaset_inventarisasigedung_namainstalasi, lokasiaset_inventarisasigedung_namalokasi, pemilikbarang_inventarisasigedung_nama, invgedung_namabrg, invgedung_ket, lokasiaset_inventarisasijalan_namainstalasi, lokasiaset_inventarisasijalan_namalokasi, pemilikbarang_inventarisasijalan_nama, invjalan_namabrg, invjalan_ket', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan, pemilikbarang_inventarisasiasetlain_kode, pemilikbarang_inventarisasitanah_kode, pemilikbarang_inventarisasiperalatan_kode, invperalatan_serftkkalibrasi, pemilikbarang_inventarisasigedung_kode, invgedung_kontruksi, invgedung_nodokumen, pemilikbarang_inventarisasijalan_kode, invjalan_kontruksi', 'length', 'max'=>20),
			array('barang_thnbeli, invasetlain_thncetak, invtanah_thnpengadaan, invperalatan_thnpembelian', 'length', 'max'=>5),
			array('barang_image', 'length', 'max'=>200),
			array('asalaset_inventarisasiasetlain_singkatan, asalaset_inventarisasitanah_singkatan, asalaset_inventarisasiperalatan_singkatan, invperalatan_kapasitasrata, asalaset_inventarisasigedung_singkatan, asalaset_inventarisasijalan_singkatan', 'length', 'max'=>10),
			array('invtanah_luas, invjalan_panjang, invjalan_lebar, invjalan_luas, invjalan_letak, invjalan_nodokumen', 'length', 'max'=>30),
			array('tipepenghapusan', 'length', 'max'=>25),
			array('barang_statusregister, barang_aktif, invasetlain_tglguna, invtanah_tglguna, invtanah_alamat, invtanah_tglsertifikat, tglpenghapusan, invperalatan_tglguna, invperalatan_ket, invperalatan_ijinoperasional, invgedung_alamat, invgedung_tgldokumen, invgedung_tglguna, invjalan_tgldokumen, invjalan_tglguna', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subsubkelompok_id,subsubkelompok_nama, subsubkelompok_kode, golongan_id, golongan_kode, golongan_nama, kelompok_id, kelompok_kode, kelompok_nama, subkelompok_id, subkelompok_kode, subkelompok_nama, bidang_id, bidang_kode, bidang_nama, barang_id, barang_type, barang_kode, barang_nama, barang_namalainnya, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_aktif, invasetlain_id, asalaset_inventarisasiasetlain_id, asalaset_inventarisasiasetlain_nama, asalaset_inventarisasiasetlain_singkatan, lokasiaset_inventarisasiasetlain_id, lokasiaset_inventarisasiasetlain_kode, lokasiaset_inventarisasiasetlain_namainstalasi, lokasiaset_inventarisasiasetlain_namabagian, lokasiaset_inventarisasiasetlain_namalokasi, pemilikbarang_inventarisasiasetlain_id, pemilikbarang_inventarisasiasetlain_kode, pemilikbarang_inventarisasiasetlain_nama, invasetlain_kode, invasetlain_noregister, invasetlain_namabrg, invasetlain_judulbuku, invasetlain_spesifikasibuku, invasetlain_asalkesenian, invasetlain_jumlah, invasetlain_thncetak, invasetlain_harga, invasetlain_tglguna, invasetlain_akumsusut, invasetlain_ket, invasetlain_penciptakesenian, invasetlain_bahankesenian, invasetlain_jenishewan_tum, invasetlain_ukuranhewan_tum, invtanah_id, asalaset_inventarisasitanah_id, asalaset_inventarisasitanah_nama, asalaset_inventarisasitanah_singkatan, lokasiaset_inventarisasitanah_id, lokasiaset_inventarisasitanah_kode, lokasiaset_inventarisasitanah_namainstalasi, lokasiaset_inventarisasitanah_namabagian, lokasiaset_inventarisasitanah_namalokasi, pemilikbarang_inventarisasitanah_id, pemilikbarang_inventarisasitanah_kode, pemilikbarang_inventarisasitanah_nama, invtanah_kode, invtanah_noregister, invtanah_namabrg, invtanah_luas, invtanah_thnpengadaan, invtanah_tglguna, invtanah_alamat, invtanah_status, invtanah_tglsertifikat, invtanah_nosertifikat, invtanah_penggunaan, invtanah_harga, invtanah_ket, invtanah_umurekonomis, invtanah_nilairesidu, tglpenghapusan, tipepenghapusan, hargajualaktiva, kerugian, keuntungan, invperalatan_id, asalaset_inventarisasiperalatan_id, asalaset_inventarisasiperalatan_nama, asalaset_inventarisasiperalatan_singkatan, lokasiaset_inventarisasiperalatan_id, lokasiaset_inventarisasiperalatan_kode, lokasiaset_inventarisasiperalatan_namainstalasi, lokasiaset_inventarisasiperalatan_namabagian, lokasiaset_inventarisasiperalatan_namalokasi, pemilikbarang_inventarisasiperalatan_id, pemilikbarang_inventarisasiperalatan_kode, pemilikbarang_inventarisasiperalatan_nama, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_merk, invperalatan_ukuran, invperalatan_bahan, invperalatan_thnpembelian, invperalatan_tglguna, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_harga, invperalatan_akumsusut, invperalatan_ket, invperalatan_kapasitasrata, invperalatan_ijinoperasional, invperalatan_serftkkalibrasi, invperalatan_umurekonomis, invperalatan_keadaan, invgedung_id, asalaset_inventarisasigedung_id, asalaset_inventarisasigedung_nama, asalaset_inventarisasigedung_singkatan, lokasiaset_inventarisasigedung_id, lokasiaset_inventarisasigedung_kode, lokasiaset_inventarisasigedung_namainstalasi, lokasiaset_inventarisasigedung_namabagian, lokasiaset_inventarisasigedung_namalokasi, pemilikbarang_inventarisasigedung_id, pemilikbarang_inventarisasigedung_kode, pemilikbarang_inventarisasigedung_nama, invgedung_kode, invgedung_noregister, invgedung_namabrg, invgedung_kontruksi, invgedung_luaslantai, invgedung_alamat, invgedung_tgldokumen, invgedung_tglguna, invgedung_nodokumen, invgedung_harga, invgedung_akumsusut, invgedung_ket, invgedung_umurekonomis, invgedung_nilairesidu, invjalan_id, asalaset_inventarisasijalan_id, asalaset_inventarisasijalan_nama, asalaset_inventarisasijalan_singkatan, lokasiaset_inventarisasijalan_id, lokasiaset_inventarisasijalan_kode, lokasiaset_inventarisasijalan_namainstalasi, lokasiaset_inventarisasijalan_namabagian, lokasiaset_inventarisasijalan_namalokasi, pemilikbarang_inventarisasijalan_id, pemilikbarang_inventarisasijalan_kode, pemilikbarang_inventarisasijalan_nama, invjalan_kode, invjalan_noregister, invjalan_namabrg, invjalan_kontruksi, invjalan_panjang, invjalan_lebar, invjalan_luas, invjalan_letak, invjalan_tgldokumen, invjalan_tglguna, invjalan_nodokumen, invjalan_statustanah, invjalan_keadaaan, invjalan_harga, invjalan_akumsusut, invjalan_ket, barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual', 'safe', 'on'=>'search'),
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
			'golongan_id' => 'Golongan',
			'golongan_kode' => 'Golongan Kode',
			'golongan_nama' => 'Golongan Nama',
			'kelompok_id' => 'Kelompok',
			'kelompok_kode' => 'Kelompok Kode',
			'kelompok_nama' => 'Kelompok Nama',
			'subkelompok_id' => 'Subkelompok',
			'subkelompok_kode' => 'Subkelompok Kode',
			'subkelompok_nama' => 'Subkelompok Nama',
                        'subsubkelompok_id' => 'Subsubkelompok',
			'subsubkelompok_kode' => 'Subsubkelompok Kode',
			'subsubkelompok_nama' => 'Subsubkelompok Nama',
			'bidang_id' => 'Bidang',
			'bidang_kode' => 'Bidang Kode',
			'bidang_nama' => 'Bidang Nama',
			'barang_id' => 'Barang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',			
			'barang_namalainnya' => 'Barang Namalainnya',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_ukuran' => 'Barang Ukuran',
			'barang_bahan' => 'Barang Bahan',
			'barang_thnbeli' => 'Barang Thnbeli',
			'barang_warna' => 'Barang Warna',
			'barang_statusregister' => 'Barang Statusregister',
			'barang_ekonomis_thn' => 'Tahun Ekonomis Barang',
			'barang_satuan' => 'Barang Satuan',
			'barang_jmldlmkemasan' => 'Barang Jmldlmkemasan',
			'barang_image' => 'Barang Image',
			'barang_aktif' => 'Barang Aktif',
			'invasetlain_id' => 'Invasetlain',
			'asalaset_inventarisasiasetlain_id' => 'Asalaset Inventarisasiasetlain',
			'asalaset_inventarisasiasetlain_nama' => 'Asalaset Inventarisasiasetlain Nama',
			'asalaset_inventarisasiasetlain_singkatan' => 'Asalaset Inventarisasiasetlain Singkatan',
			'lokasiaset_inventarisasiasetlain_id' => 'Lokasiaset Inventarisasiasetlain',
			'lokasiaset_inventarisasiasetlain_kode' => 'Lokasiaset Inventarisasiasetlain Kode',
			'lokasiaset_inventarisasiasetlain_namainstalasi' => 'Lokasiaset Inventarisasiasetlain Namainstalasi',
			'lokasiaset_inventarisasiasetlain_namabagian' => 'Lokasiaset Inventarisasiasetlain Namabagian',
			'lokasiaset_inventarisasiasetlain_namalokasi' => 'Lokasiaset Inventarisasiasetlain Namalokasi',
			'pemilikbarang_inventarisasiasetlain_id' => 'Pemilikbarang Inventarisasiasetlain',
			'pemilikbarang_inventarisasiasetlain_kode' => 'Pemilikbarang Inventarisasiasetlain Kode',
			'pemilikbarang_inventarisasiasetlain_nama' => 'Pemilikbarang Inventarisasiasetlain Nama',
			'invasetlain_kode' => 'Kode Barang (Aset Lain)',
			'invasetlain_noregister' => 'No. Registrasi (Aset Lain)',
			'invasetlain_namabrg' => 'Nama Barang (Aset Lain)',
			'invasetlain_judulbuku' => 'Invasetlain Judulbuku',
			'invasetlain_spesifikasibuku' => 'Invasetlain Spesifikasibuku',
			'invasetlain_asalkesenian' => 'Invasetlain Asalkesenian',
			'invasetlain_jumlah' => 'Invasetlain Jumlah',
			'invasetlain_thncetak' => 'Invasetlain Thncetak',
			'invasetlain_harga' => 'Invasetlain Harga',
			'invasetlain_tglguna' => 'Tgl. Penggunaan (Aset Lain)',
			'invasetlain_akumsusut' => 'Invasetlain Akumsusut',
			'invasetlain_ket' => 'Invasetlain Ket',
			'invasetlain_penciptakesenian' => 'Invasetlain Penciptakesenian',
			'invasetlain_bahankesenian' => 'Invasetlain Bahankesenian',
			'invasetlain_jenishewan_tum' => 'Invasetlain Jenishewan Tum',
			'invasetlain_ukuranhewan_tum' => 'Invasetlain Ukuranhewan Tum',
			'invtanah_id' => 'Invtanah',
			'asalaset_inventarisasitanah_id' => 'Asalaset Inventarisasitanah',
			'asalaset_inventarisasitanah_nama' => 'Asalaset Inventarisasitanah Nama',
			'asalaset_inventarisasitanah_singkatan' => 'Asalaset Inventarisasitanah Singkatan',
			'lokasiaset_inventarisasitanah_id' => 'Lokasiaset Inventarisasitanah',
			'lokasiaset_inventarisasitanah_kode' => 'Lokasiaset Inventarisasitanah Kode',
			'lokasiaset_inventarisasitanah_namainstalasi' => 'Lokasiaset Inventarisasitanah Namainstalasi',
			'lokasiaset_inventarisasitanah_namabagian' => 'Lokasiaset Inventarisasitanah Namabagian',
			'lokasiaset_inventarisasitanah_namalokasi' => 'Lokasiaset Inventarisasitanah Namalokasi',
			'pemilikbarang_inventarisasitanah_id' => 'Pemilikbarang Inventarisasitanah',
			'pemilikbarang_inventarisasitanah_kode' => 'Pemilikbarang Inventarisasitanah Kode',
			'pemilikbarang_inventarisasitanah_nama' => 'Pemilikbarang Inventarisasitanah Nama',
			'invtanah_kode' => 'Kode Barang (Tanah)',
			'invtanah_noregister' => 'No. Registrasi (Tanah)',
			'invtanah_namabrg' => 'Nama Barang (Tanah)',
			'invtanah_luas' => 'Invtanah Luas',
			'invtanah_thnpengadaan' => 'Invtanah Thnpengadaan',
			'invtanah_tglguna' => 'Invtanah Tglguna',
			'invtanah_alamat' => 'Invtanah Alamat',
			'invtanah_status' => 'Invtanah Status',
			'invtanah_tglsertifikat' => 'Invtanah Tglsertifikat',
			'invtanah_nosertifikat' => 'Invtanah Nosertifikat',
			'invtanah_penggunaan' => 'Invtanah Penggunaan',
			'invtanah_harga' => 'Invtanah Harga',
			'invtanah_ket' => 'Invtanah Ket',
			'invtanah_umurekonomis' => 'Umur Ekonomis (Tanah)',
			'invtanah_nilairesidu' => 'Invtanah Nilairesidu',
			'tglpenghapusan' => 'Tglpenghapusan',
			'tipepenghapusan' => 'Tipepenghapusan',
			'hargajualaktiva' => 'Hargajualaktiva',
			'kerugian' => 'Kerugian',
			'keuntungan' => 'Keuntungan',
			'invperalatan_id' => 'Invperalatan',
			'asalaset_inventarisasiperalatan_id' => 'Asalaset Inventarisasiperalatan',
			'asalaset_inventarisasiperalatan_nama' => 'Asalaset Inventarisasiperalatan Nama',
			'asalaset_inventarisasiperalatan_singkatan' => 'Asalaset Inventarisasiperalatan Singkatan',
			'lokasiaset_inventarisasiperalatan_id' => 'Lokasiaset Inventarisasiperalatan',
			'lokasiaset_inventarisasiperalatan_kode' => 'Lokasiaset Inventarisasiperalatan Kode',
			'lokasiaset_inventarisasiperalatan_namainstalasi' => 'Lokasiaset Inventarisasiperalatan Namainstalasi',
			'lokasiaset_inventarisasiperalatan_namabagian' => 'Lokasiaset Inventarisasiperalatan Namabagian',
			'lokasiaset_inventarisasiperalatan_namalokasi' => 'Lokasiaset Inventarisasiperalatan Namalokasi',
			'pemilikbarang_inventarisasiperalatan_id' => 'Pemilikbarang Inventarisasiperalatan',
			'pemilikbarang_inventarisasiperalatan_kode' => 'Pemilikbarang Inventarisasiperalatan Kode',
			'pemilikbarang_inventarisasiperalatan_nama' => 'Pemilikbarang Inventarisasiperalatan Nama',
			'invperalatan_kode' => 'Kode Barang (Peralatan)',
			'invperalatan_noregister' => 'No. Registrasi (Peralatan)',
			'invperalatan_namabrg' => 'Nama Barang (Peralatan)',
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
			'invperalatan_umurekonomis' => 'Umur Ekonomis (Peralatan)',
			'invperalatan_keadaan' => 'Invperalatan Keadaan',
			'invgedung_id' => 'Invgedung',
			'asalaset_inventarisasigedung_id' => 'Asalaset Inventarisasigedung',
			'asalaset_inventarisasigedung_nama' => 'Asalaset Inventarisasigedung Nama',
			'asalaset_inventarisasigedung_singkatan' => 'Asalaset Inventarisasigedung Singkatan',
			'lokasiaset_inventarisasigedung_id' => 'Lokasiaset Inventarisasigedung',
			'lokasiaset_inventarisasigedung_kode' => 'Lokasiaset Inventarisasigedung Kode',
			'lokasiaset_inventarisasigedung_namainstalasi' => 'Lokasiaset Inventarisasigedung Namainstalasi',
			'lokasiaset_inventarisasigedung_namabagian' => 'Lokasiaset Inventarisasigedung Namabagian',
			'lokasiaset_inventarisasigedung_namalokasi' => 'Lokasiaset Inventarisasigedung Namalokasi',
			'pemilikbarang_inventarisasigedung_id' => 'Pemilikbarang Inventarisasigedung',
			'pemilikbarang_inventarisasigedung_kode' => 'Pemilikbarang Inventarisasigedung Kode',
			'pemilikbarang_inventarisasigedung_nama' => 'Pemilikbarang Inventarisasigedung Nama',
			'invgedung_kode' => 'Kode Barang (Gedung)',
			'invgedung_noregister' => 'No. Registrasi (Gedung)',
			'invgedung_namabrg' => 'Nama Barang (Gedung)',
			'invgedung_kontruksi' => 'Invgedung Kontruksi',
			'invgedung_luaslantai' => 'Invgedung Luaslantai',
			'invgedung_alamat' => 'Invgedung Alamat',
			'invgedung_tgldokumen' => 'Invgedung Tgldokumen',
			'invgedung_tglguna' => 'Invgedung Tglguna',
			'invgedung_nodokumen' => 'Invgedung Nodokumen',
			'invgedung_harga' => 'Invgedung Harga',
			'invgedung_akumsusut' => 'Invgedung Akumsusut',
			'invgedung_ket' => 'Invgedung Ket',
			'invgedung_umurekonomis' => 'Invgedung Umurekonomis',
			'invgedung_nilairesidu' => 'Invgedung Nilairesidu',
			'invjalan_id' => 'Invjalan',
			'asalaset_inventarisasijalan_id' => 'Asalaset Inventarisasijalan',
			'asalaset_inventarisasijalan_nama' => 'Asalaset Inventarisasijalan Nama',
			'asalaset_inventarisasijalan_singkatan' => 'Asalaset Inventarisasijalan Singkatan',
			'lokasiaset_inventarisasijalan_id' => 'Lokasiaset Inventarisasijalan',
			'lokasiaset_inventarisasijalan_kode' => 'Lokasiaset Inventarisasijalan Kode',
			'lokasiaset_inventarisasijalan_namainstalasi' => 'Lokasiaset Inventarisasijalan Namainstalasi',
			'lokasiaset_inventarisasijalan_namabagian' => 'Lokasiaset Inventarisasijalan Namabagian',
			'lokasiaset_inventarisasijalan_namalokasi' => 'Lokasiaset Inventarisasijalan Namalokasi',
			'pemilikbarang_inventarisasijalan_id' => 'Pemilikbarang Inventarisasijalan',
			'pemilikbarang_inventarisasijalan_kode' => 'Pemilikbarang Inventarisasijalan Kode',
			'pemilikbarang_inventarisasijalan_nama' => 'Pemilikbarang Inventarisasijalan Nama',
			'invjalan_kode' => 'Kode Barang (Jaringan)',
			'invjalan_noregister' => 'No. Registrasi (Jaringan)',
			'invjalan_namabrg' => 'Nama Barang (Jaringan)',
			'invjalan_kontruksi' => 'Invjalan Kontruksi',
			'invjalan_panjang' => 'Invjalan Panjang',
			'invjalan_lebar' => 'Invjalan Lebar',
			'invjalan_luas' => 'Invjalan Luas',
			'invjalan_letak' => 'Invjalan Letak',
			'invjalan_tgldokumen' => 'Invjalan Tgldokumen',
			'invjalan_tglguna' => 'Invjalan Tglguna',
			'invjalan_nodokumen' => 'Invjalan Nodokumen',
			'invjalan_statustanah' => 'Invjalan Statustanah',
			'invjalan_keadaaan' => 'Invjalan Keadaaan',
			'invjalan_harga' => 'Invjalan Harga',
			'invjalan_akumsusut' => 'Invjalan Akumsusut',
			'invjalan_ket' => 'Invjalan Ket',
			'barang_harganetto' => 'Harga Barang',
			'barang_persendiskon' => 'Barang Persendiskon',
			'barang_ppn' => 'Barang Ppn',
			'barang_hpp' => 'Barang Hpp',
			'barang_hargajual' => 'Barang Hargajual',
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

		if(!empty($this->golongan_id)){
			$criteria->addCondition('golongan_id = '.$this->golongan_id);
		}
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		if(!empty($this->subkelompok_id)){
			$criteria->addCondition('subkelompok_id = '.$this->subkelompok_id);
		}
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id = '.$this->bidang_id);
		}
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan));
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
		}
		if(!empty($this->asalaset_inventarisasiasetlain_id)){
			$criteria->addCondition('asalaset_inventarisasiasetlain_id = '.$this->asalaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_nama)',strtolower($this->asalaset_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiasetlain_singkatan)',strtolower($this->asalaset_inventarisasiasetlain_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiasetlain_id)){
			$criteria->addCondition('lokasiaset_inventarisasiasetlain_id = '.$this->lokasiaset_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_kode)',strtolower($this->lokasiaset_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namainstalasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namabagian)',strtolower($this->lokasiaset_inventarisasiasetlain_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiasetlain_namalokasi)',strtolower($this->lokasiaset_inventarisasiasetlain_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiasetlain_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiasetlain_id = '.$this->pemilikbarang_inventarisasiasetlain_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_kode)',strtolower($this->pemilikbarang_inventarisasiasetlain_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiasetlain_nama)',strtolower($this->pemilikbarang_inventarisasiasetlain_nama),true);
		$criteria->compare('LOWER(invasetlain_kode)',strtolower($this->invasetlain_kode),true);
		$criteria->compare('LOWER(invasetlain_noregister)',strtolower($this->invasetlain_noregister),true);
		$criteria->compare('LOWER(invasetlain_namabrg)',strtolower($this->invasetlain_namabrg),true);
		$criteria->compare('LOWER(invasetlain_judulbuku)',strtolower($this->invasetlain_judulbuku),true);
		$criteria->compare('LOWER(invasetlain_spesifikasibuku)',strtolower($this->invasetlain_spesifikasibuku),true);
		$criteria->compare('LOWER(invasetlain_asalkesenian)',strtolower($this->invasetlain_asalkesenian),true);
		$criteria->compare('invasetlain_jumlah',$this->invasetlain_jumlah);
		$criteria->compare('LOWER(invasetlain_thncetak)',strtolower($this->invasetlain_thncetak),true);
		$criteria->compare('invasetlain_harga',$this->invasetlain_harga);
		$criteria->compare('LOWER(invasetlain_tglguna)',strtolower($this->invasetlain_tglguna),true);
		$criteria->compare('invasetlain_akumsusut',$this->invasetlain_akumsusut);
		$criteria->compare('LOWER(invasetlain_ket)',strtolower($this->invasetlain_ket),true);
		$criteria->compare('LOWER(invasetlain_penciptakesenian)',strtolower($this->invasetlain_penciptakesenian),true);
		$criteria->compare('LOWER(invasetlain_bahankesenian)',strtolower($this->invasetlain_bahankesenian),true);
		$criteria->compare('LOWER(invasetlain_jenishewan_tum)',strtolower($this->invasetlain_jenishewan_tum),true);
		$criteria->compare('LOWER(invasetlain_ukuranhewan_tum)',strtolower($this->invasetlain_ukuranhewan_tum),true);
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		if(!empty($this->asalaset_inventarisasitanah_id)){
			$criteria->addCondition('asalaset_inventarisasitanah_id = '.$this->asalaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasitanah_nama)',strtolower($this->asalaset_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasitanah_singkatan)',strtolower($this->asalaset_inventarisasitanah_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasitanah_id)){
			$criteria->addCondition('lokasiaset_inventarisasitanah_id = '.$this->lokasiaset_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_kode)',strtolower($this->lokasiaset_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namainstalasi)',strtolower($this->lokasiaset_inventarisasitanah_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namabagian)',strtolower($this->lokasiaset_inventarisasitanah_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasitanah_namalokasi)',strtolower($this->lokasiaset_inventarisasitanah_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasitanah_id)){
			$criteria->addCondition('pemilikbarang_inventarisasitanah_id = '.$this->pemilikbarang_inventarisasitanah_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_kode)',strtolower($this->pemilikbarang_inventarisasitanah_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasitanah_nama)',strtolower($this->pemilikbarang_inventarisasitanah_nama),true);
		$criteria->compare('LOWER(invtanah_kode)',strtolower($this->invtanah_kode),true);
		$criteria->compare('LOWER(invtanah_noregister)',strtolower($this->invtanah_noregister),true);
		$criteria->compare('LOWER(invtanah_namabrg)',strtolower($this->invtanah_namabrg),true);
		$criteria->compare('LOWER(invtanah_luas)',strtolower($this->invtanah_luas),true);
		$criteria->compare('LOWER(invtanah_thnpengadaan)',strtolower($this->invtanah_thnpengadaan),true);
		$criteria->compare('LOWER(invtanah_tglguna)',strtolower($this->invtanah_tglguna),true);
		$criteria->compare('LOWER(invtanah_alamat)',strtolower($this->invtanah_alamat),true);
		$criteria->compare('LOWER(invtanah_status)',strtolower($this->invtanah_status),true);
		$criteria->compare('LOWER(invtanah_tglsertifikat)',strtolower($this->invtanah_tglsertifikat),true);
		$criteria->compare('LOWER(invtanah_nosertifikat)',strtolower($this->invtanah_nosertifikat),true);
		$criteria->compare('LOWER(invtanah_penggunaan)',strtolower($this->invtanah_penggunaan),true);
		$criteria->compare('invtanah_harga',$this->invtanah_harga);
		$criteria->compare('LOWER(invtanah_ket)',strtolower($this->invtanah_ket),true);
		$criteria->compare('invtanah_umurekonomis',$this->invtanah_umurekonomis);
		$criteria->compare('invtanah_nilairesidu',$this->invtanah_nilairesidu);
		$criteria->compare('LOWER(tglpenghapusan)',strtolower($this->tglpenghapusan),true);
		$criteria->compare('LOWER(tipepenghapusan)',strtolower($this->tipepenghapusan),true);
		$criteria->compare('hargajualaktiva',$this->hargajualaktiva);
		$criteria->compare('kerugian',$this->kerugian);
		$criteria->compare('keuntungan',$this->keuntungan);
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->asalaset_inventarisasiperalatan_id)){
			$criteria->addCondition('asalaset_inventarisasiperalatan_id = '.$this->asalaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_nama)',strtolower($this->asalaset_inventarisasiperalatan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasiperalatan_singkatan)',strtolower($this->asalaset_inventarisasiperalatan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasiperalatan_id)){
			$criteria->addCondition('lokasiaset_inventarisasiperalatan_id = '.$this->lokasiaset_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_kode)',strtolower($this->lokasiaset_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namainstalasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namabagian)',strtolower($this->lokasiaset_inventarisasiperalatan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasiperalatan_namalokasi)',strtolower($this->lokasiaset_inventarisasiperalatan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasiperalatan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasiperalatan_id = '.$this->pemilikbarang_inventarisasiperalatan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_kode)',strtolower($this->pemilikbarang_inventarisasiperalatan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasiperalatan_nama)',strtolower($this->pemilikbarang_inventarisasiperalatan_nama),true);
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
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->asalaset_inventarisasigedung_id)){
			$criteria->addCondition('asalaset_inventarisasigedung_id = '.$this->asalaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasigedung_nama)',strtolower($this->asalaset_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasigedung_singkatan)',strtolower($this->asalaset_inventarisasigedung_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasigedung_id)){
			$criteria->addCondition('lokasiaset_inventarisasigedung_id = '.$this->lokasiaset_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_kode)',strtolower($this->lokasiaset_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namainstalasi)',strtolower($this->lokasiaset_inventarisasigedung_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namabagian)',strtolower($this->lokasiaset_inventarisasigedung_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasigedung_namalokasi)',strtolower($this->lokasiaset_inventarisasigedung_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasigedung_id)){
			$criteria->addCondition('pemilikbarang_inventarisasigedung_id = '.$this->pemilikbarang_inventarisasigedung_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_kode)',strtolower($this->pemilikbarang_inventarisasigedung_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasigedung_nama)',strtolower($this->pemilikbarang_inventarisasigedung_nama),true);
		$criteria->compare('LOWER(invgedung_kode)',strtolower($this->invgedung_kode),true);
		$criteria->compare('LOWER(invgedung_noregister)',strtolower($this->invgedung_noregister),true);
		$criteria->compare('LOWER(invgedung_namabrg)',strtolower($this->invgedung_namabrg),true);
		$criteria->compare('LOWER(invgedung_kontruksi)',strtolower($this->invgedung_kontruksi),true);
		$criteria->compare('invgedung_luaslantai',$this->invgedung_luaslantai);
		$criteria->compare('LOWER(invgedung_alamat)',strtolower($this->invgedung_alamat),true);
		$criteria->compare('LOWER(invgedung_tgldokumen)',strtolower($this->invgedung_tgldokumen),true);
		$criteria->compare('LOWER(invgedung_tglguna)',strtolower($this->invgedung_tglguna),true);
		$criteria->compare('LOWER(invgedung_nodokumen)',strtolower($this->invgedung_nodokumen),true);
		$criteria->compare('invgedung_harga',$this->invgedung_harga);
		$criteria->compare('invgedung_akumsusut',$this->invgedung_akumsusut);
		$criteria->compare('LOWER(invgedung_ket)',strtolower($this->invgedung_ket),true);
		if(!empty($this->invgedung_umurekonomis)){
			$criteria->addCondition('invgedung_umurekonomis = '.$this->invgedung_umurekonomis);
		}
		$criteria->compare('invgedung_nilairesidu',$this->invgedung_nilairesidu);
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		if(!empty($this->asalaset_inventarisasijalan_id)){
			$criteria->addCondition('asalaset_inventarisasijalan_id = '.$this->asalaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(asalaset_inventarisasijalan_nama)',strtolower($this->asalaset_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(asalaset_inventarisasijalan_singkatan)',strtolower($this->asalaset_inventarisasijalan_singkatan),true);
		if(!empty($this->lokasiaset_inventarisasijalan_id)){
			$criteria->addCondition('lokasiaset_inventarisasijalan_id = '.$this->lokasiaset_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_kode)',strtolower($this->lokasiaset_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namainstalasi)',strtolower($this->lokasiaset_inventarisasijalan_namainstalasi),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namabagian)',strtolower($this->lokasiaset_inventarisasijalan_namabagian),true);
		$criteria->compare('LOWER(lokasiaset_inventarisasijalan_namalokasi)',strtolower($this->lokasiaset_inventarisasijalan_namalokasi),true);
		if(!empty($this->pemilikbarang_inventarisasijalan_id)){
			$criteria->addCondition('pemilikbarang_inventarisasijalan_id = '.$this->pemilikbarang_inventarisasijalan_id);
		}
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_kode)',strtolower($this->pemilikbarang_inventarisasijalan_kode),true);
		$criteria->compare('LOWER(pemilikbarang_inventarisasijalan_nama)',strtolower($this->pemilikbarang_inventarisasijalan_nama),true);
		$criteria->compare('LOWER(invjalan_kode)',strtolower($this->invjalan_kode),true);
		$criteria->compare('LOWER(invjalan_noregister)',strtolower($this->invjalan_noregister),true);
		$criteria->compare('LOWER(invjalan_namabrg)',strtolower($this->invjalan_namabrg),true);
		$criteria->compare('LOWER(invjalan_kontruksi)',strtolower($this->invjalan_kontruksi),true);
		$criteria->compare('LOWER(invjalan_panjang)',strtolower($this->invjalan_panjang),true);
		$criteria->compare('LOWER(invjalan_lebar)',strtolower($this->invjalan_lebar),true);
		$criteria->compare('LOWER(invjalan_luas)',strtolower($this->invjalan_luas),true);
		$criteria->compare('LOWER(invjalan_letak)',strtolower($this->invjalan_letak),true);
		$criteria->compare('LOWER(invjalan_tgldokumen)',strtolower($this->invjalan_tgldokumen),true);
		$criteria->compare('LOWER(invjalan_tglguna)',strtolower($this->invjalan_tglguna),true);
		$criteria->compare('LOWER(invjalan_nodokumen)',strtolower($this->invjalan_nodokumen),true);
		$criteria->compare('LOWER(invjalan_statustanah)',strtolower($this->invjalan_statustanah),true);
		$criteria->compare('LOWER(invjalan_keadaaan)',strtolower($this->invjalan_keadaaan),true);
		$criteria->compare('invjalan_harga',$this->invjalan_harga);
		$criteria->compare('invjalan_akumsusut',$this->invjalan_akumsusut);
		$criteria->compare('LOWER(invjalan_ket)',strtolower($this->invjalan_ket),true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);

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
            //$criteria->limit=10;

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
        
        public function getStokRuangan($ruangan_id = null) {
            
            $ruangan_id = $ruangan_id ?? Yii::app()->user->getState('ruangan_id') ?? null;
            
            $criteria = new CDbCriteria;
            $criteria->compare('barang_id', $this->barang_id);
            $criteria->compare('ruangan_id', $ruangan_id);
            $criteria->select = 'sum(inventarisasi_stok) as inventarisasi_stok';
            
            $model = InformasistokbarangV::model()->find($criteria);
            
            
            return (empty($model) || empty($model->inventarisasi_stok)) ? 0 : $model->inventarisasi_stok;
            
        }
			
}