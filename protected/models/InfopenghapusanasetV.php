<?php

/**
 * This is the model class for table "infopenghapusanaset_v".
 *
 * The followings are the available columns in table 'infopenghapusanaset_v':
 * @property integer $penghapusanaset_id
 * @property string $tglpenghapusan
 * @property string $nopenghapusan
 * @property string $no_sk_penghapusan
 * @property string $tgl_sk_penghapusan
 * @property string $carapenghapusan
 * @property string $ket_penghapusan
 * @property integer $penghapusan_id
 * @property string $penghapusan_nip
 * @property string $penghapusan_gelardepan
 * @property string $penghapusan_nama
 * @property integer $gelarpenghapusan_id
 * @property string $gelarpenghapusan_nama
 * @property integer $jabatanpenghapusan_id
 * @property string $jabatanpenghapusan_nama
 * @property integer $penghapusanmengetahui_id
 * @property string $penghapusanmengetahui_nip
 * @property string $penghapusanmengetahui_gelardepan
 * @property string $penghapusanmengetahui_nama
 * @property integer $gelarpenghapusanmengetahui_id
 * @property string $gelarpenghapusanmengetahui_nama
 * @property integer $jabatanpenghapusanmengetahui_id
 * @property string $jabatanpenghapusanmengetahui_nama
 * @property integer $menyetujui_id
 * @property string $menyetujui_nip
 * @property string $menyetujui_gelardepan
 * @property string $menyetujui_nama
 * @property integer $gelarmenyetujui_id
 * @property string $gelarmenyetujui_nama
 * @property integer $jabatanmenyetujui_id
 * @property string $jabatanmenyetujui_nama
 * @property integer $ruanghapus_id
 * @property string $ruanghapus_nama
 * @property integer $pengeluaranaset_id
 * @property string $nopengeluaranaset
 * @property string $tglpengeluaranaset
 * @property string $kd_lokasi_kode
 * @property string $pengeluaran_kodelokasi
 * @property string $lokasipenerima_kode
 * @property string $penerimaaset
 * @property string $jenisperuntukan
 * @property string $no_suratperintah
 * @property string $tglsuratperintah
 * @property string $tglpenyerahan
 * @property string $alasan_pengeluaran
 * @property integer $ruangkeluar_id
 * @property string $ruangkeluar_nama
 * @property integer $pengeluaran_id
 * @property string $pengeluaran_nip
 * @property string $pengeluaran_gelardepan
 * @property string $pengeluaran_nama
 * @property integer $gelarbelakangkeluar_id
 * @property string $gelarbelakangkeluar_nama
 * @property integer $jabatankeluar_id
 * @property string $jabatankeluar_nama
 * @property integer $mengetahui_id
 * @property string $mengetahui_nip
 * @property string $mengetahui_gelardepan
 * @property string $mengetahui_nama
 * @property integer $gelarmengetahui_id
 * @property string $gelarmengetahui_nama
 * @property integer $jabatanmengetahui_id
 * @property string $jabatanmengetahui_nama
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
class InfopenghapusanasetV extends CActiveRecord
{
    public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopenghapusanasetV the static model class
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
		return 'infopenghapusanaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penghapusanaset_id, penghapusan_id, gelarpenghapusan_id, jabatanpenghapusan_id, penghapusanmengetahui_id, gelarpenghapusanmengetahui_id, jabatanpenghapusanmengetahui_id, menyetujui_id, gelarmenyetujui_id, jabatanmenyetujui_id, ruanghapus_id, pengeluaranaset_id, ruangkeluar_id, pengeluaran_id, gelarbelakangkeluar_id, jabatankeluar_id, mengetahui_id, gelarmengetahui_id, jabatanmengetahui_id, invperalatan_id, invperalatan_umurekonomis, asalaset_id, pemilikbarang_id, lokasi_id, jenisbarang_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('invperalatan_harga, invperalatan_akumsusut, peralatan_dayalistrik', 'numerical'),
			array('nopenghapusan, jabatanpenghapusan_nama, jabatanpenghapusanmengetahui_nama, jabatanmenyetujui_nama, penerimaaset, jabatankeluar_nama, jabatanmengetahui_nama, invperalatan_namabrg, invperalatan_bahan, peralatan_model, peralatan_noseri, peralatan_manufacturer, pemilikbarang_nama, lokasiaset_namainstalasi, lokasiaset_namalokasi, jenis_lokasi, barang_nama', 'length', 'max'=>100),
			array('no_sk_penghapusan, carapenghapusan, penghapusan_nama, penghapusanmengetahui_nama, menyetujui_nama, ruanghapus_nama, nopengeluaranaset, kd_lokasi_kode, pengeluaran_kodelokasi, lokasipenerima_kode, jenisperuntukan, no_suratperintah, ruangkeluar_nama, pengeluaran_nama, mengetahui_nama, invperalatan_kode, invperalatan_noregister, invperalatan_merk, invperalatan_ukuran, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_keadaan, asalaset_nama, lokasiaset_kode, lokasiaset_namabagian, kodepos_lokasi, telp_lokasi, jenisbarang_nama, barang_type, barang_kode', 'length', 'max'=>50),
			array('penghapusan_nip, penghapusanmengetahui_nip, menyetujui_nip, pengeluaran_nip, mengetahui_nip', 'length', 'max'=>30),
			array('penghapusan_gelardepan, penghapusanmengetahui_gelardepan, menyetujui_gelardepan, pengeluaran_gelardepan, mengetahui_gelardepan, invperalatan_kapasitasrata', 'length', 'max'=>10),
			array('gelarpenghapusan_nama, gelarpenghapusanmengetahui_nama, gelarmenyetujui_nama, gelarbelakangkeluar_nama, gelarmengetahui_nama', 'length', 'max'=>25),
			array('invperalatan_thnpembelian', 'length', 'max'=>5),
			array('invperalatan_serftkkalibrasi, pemilikbarang_kode', 'length', 'max'=>20),
			array('deskripsi_lokasi, alamat_lokasi', 'length', 'max'=>300),
			array('kotakab_lokasi, induk_satker', 'length', 'max'=>255),
			array('tglpenghapusan, tgl_sk_penghapusan, ket_penghapusan, tglpengeluaranaset, tglsuratperintah, tglpenyerahan, alasan_pengeluaran, invperalatan_tglguna, invperalatan_ket, invperalatan_ijinoperasional, peralatan_garansihabis, jenisbarang_deskripsi, barang_statusregister', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penghapusanaset_id, tglpenghapusan, nopenghapusan, no_sk_penghapusan, tgl_sk_penghapusan, carapenghapusan, ket_penghapusan, penghapusan_id, penghapusan_nip, penghapusan_gelardepan, penghapusan_nama, gelarpenghapusan_id, gelarpenghapusan_nama, jabatanpenghapusan_id, jabatanpenghapusan_nama, penghapusanmengetahui_id, penghapusanmengetahui_nip, penghapusanmengetahui_gelardepan, penghapusanmengetahui_nama, gelarpenghapusanmengetahui_id, gelarpenghapusanmengetahui_nama, jabatanpenghapusanmengetahui_id, jabatanpenghapusanmengetahui_nama, menyetujui_id, menyetujui_nip, menyetujui_gelardepan, menyetujui_nama, gelarmenyetujui_id, gelarmenyetujui_nama, jabatanmenyetujui_id, jabatanmenyetujui_nama, ruanghapus_id, ruanghapus_nama, pengeluaranaset_id, nopengeluaranaset, tglpengeluaranaset, kd_lokasi_kode, pengeluaran_kodelokasi, lokasipenerima_kode, penerimaaset, jenisperuntukan, no_suratperintah, tglsuratperintah, tglpenyerahan, alasan_pengeluaran, ruangkeluar_id, ruangkeluar_nama, pengeluaran_id, pengeluaran_nip, pengeluaran_gelardepan, pengeluaran_nama, gelarbelakangkeluar_id, gelarbelakangkeluar_nama, jabatankeluar_id, jabatankeluar_nama, mengetahui_id, mengetahui_nip, mengetahui_gelardepan, mengetahui_nama, gelarmengetahui_id, gelarmengetahui_nama, jabatanmengetahui_id, jabatanmengetahui_nama, invperalatan_id, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_merk, invperalatan_ukuran, invperalatan_bahan, invperalatan_thnpembelian, invperalatan_tglguna, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_harga, invperalatan_akumsusut, invperalatan_ket, invperalatan_kapasitasrata, invperalatan_ijinoperasional, invperalatan_serftkkalibrasi, invperalatan_umurekonomis, invperalatan_keadaan, peralatan_model, peralatan_noseri, peralatan_manufacturer, peralatan_garansihabis, peralatan_dayalistrik, asalaset_id, asalaset_nama, pemilikbarang_id, pemilikbarang_kode, pemilikbarang_nama, lokasi_id, lokasiaset_kode, lokasiaset_namainstalasi, lokasiaset_namabagian, lokasiaset_namalokasi, deskripsi_lokasi, jenis_lokasi, alamat_lokasi, kotakab_lokasi, kodepos_lokasi, telp_lokasi, induk_satker, jenisbarang_id, jenisbarang_nama, jenisbarang_deskripsi, barang_id, barang_type, barang_kode, barang_nama, barang_statusregister', 'safe', 'on'=>'search'),
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
			'penghapusanaset_id' => 'Penghapusanaset',
			'tglpenghapusan' => 'Tglpenghapusan',
			'nopenghapusan' => 'Nopenghapusan',
			'no_sk_penghapusan' => 'No Sk Penghapusan',
			'tgl_sk_penghapusan' => 'Tgl Sk Penghapusan',
			'carapenghapusan' => 'Carapenghapusan',
			'ket_penghapusan' => 'Ket Penghapusan',
			'penghapusan_id' => 'Penghapusan',
			'penghapusan_nip' => 'Penghapusan Nip',
			'penghapusan_gelardepan' => 'Penghapusan Gelardepan',
			'penghapusan_nama' => 'Penghapusan Nama',
			'gelarpenghapusan_id' => 'Gelarpenghapusan',
			'gelarpenghapusan_nama' => 'Gelarpenghapusan Nama',
			'jabatanpenghapusan_id' => 'Jabatanpenghapusan',
			'jabatanpenghapusan_nama' => 'Jabatanpenghapusan Nama',
			'penghapusanmengetahui_id' => 'Penghapusanmengetahui',
			'penghapusanmengetahui_nip' => 'Penghapusanmengetahui Nip',
			'penghapusanmengetahui_gelardepan' => 'Penghapusanmengetahui Gelardepan',
			'penghapusanmengetahui_nama' => 'Penghapusanmengetahui Nama',
			'gelarpenghapusanmengetahui_id' => 'Gelarpenghapusanmengetahui',
			'gelarpenghapusanmengetahui_nama' => 'Gelarpenghapusanmengetahui Nama',
			'jabatanpenghapusanmengetahui_id' => 'Jabatanpenghapusanmengetahui',
			'jabatanpenghapusanmengetahui_nama' => 'Jabatanpenghapusanmengetahui Nama',
			'menyetujui_id' => 'Menyetujui',
			'menyetujui_nip' => 'Menyetujui Nip',
			'menyetujui_gelardepan' => 'Menyetujui Gelardepan',
			'menyetujui_nama' => 'Menyetujui Nama',
			'gelarmenyetujui_id' => 'Gelarmenyetujui',
			'gelarmenyetujui_nama' => 'Gelarmenyetujui Nama',
			'jabatanmenyetujui_id' => 'Jabatanmenyetujui',
			'jabatanmenyetujui_nama' => 'Jabatanmenyetujui Nama',
			'ruanghapus_id' => 'Ruanghapus',
			'ruanghapus_nama' => 'Ruanghapus Nama',
			'pengeluaranaset_id' => 'Pengeluaranaset',
			'nopengeluaranaset' => 'Nopengeluaranaset',
			'tglpengeluaranaset' => 'Tglpengeluaranaset',
			'kd_lokasi_kode' => 'Kd Lokasi Kode',
			'pengeluaran_kodelokasi' => 'Pengeluaran Kodelokasi',
			'lokasipenerima_kode' => 'Lokasipenerima Kode',
			'penerimaaset' => 'Penerimaaset',
			'jenisperuntukan' => 'Jenisperuntukan',
			'no_suratperintah' => 'No Suratperintah',
			'tglsuratperintah' => 'Tglsuratperintah',
			'tglpenyerahan' => 'Tglpenyerahan',
			'alasan_pengeluaran' => 'Alasan Pengeluaran',
			'ruangkeluar_id' => 'Ruangkeluar',
			'ruangkeluar_nama' => 'Ruangkeluar Nama',
			'pengeluaran_id' => 'Pengeluaran',
			'pengeluaran_nip' => 'Pengeluaran Nip',
			'pengeluaran_gelardepan' => 'Pengeluaran Gelardepan',
			'pengeluaran_nama' => 'Pengeluaran Nama',
			'gelarbelakangkeluar_id' => 'Gelarbelakangkeluar',
			'gelarbelakangkeluar_nama' => 'Gelarbelakangkeluar Nama',
			'jabatankeluar_id' => 'Jabatankeluar',
			'jabatankeluar_nama' => 'Jabatankeluar Nama',
			'mengetahui_id' => 'Mengetahui',
			'mengetahui_nip' => 'Mengetahui Nip',
			'mengetahui_gelardepan' => 'Mengetahui Gelardepan',
			'mengetahui_nama' => 'Mengetahui Nama',
			'gelarmengetahui_id' => 'Gelarmengetahui',
			'gelarmengetahui_nama' => 'Gelarmengetahui Nama',
			'jabatanmengetahui_id' => 'Jabatanmengetahui',
			'jabatanmengetahui_nama' => 'Jabatanmengetahui Nama',
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
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->compare('penghapusanaset_id',$this->penghapusanaset_id);
		$criteria->compare('tglpenghapusan',$this->tglpenghapusan,true);
		$criteria->compare('nopenghapusan',$this->nopenghapusan,true);
		$criteria->compare('no_sk_penghapusan',$this->no_sk_penghapusan,true);
		$criteria->compare('tgl_sk_penghapusan',$this->tgl_sk_penghapusan,true);
		$criteria->compare('carapenghapusan',$this->carapenghapusan,true);
		$criteria->compare('ket_penghapusan',$this->ket_penghapusan,true);
		$criteria->compare('penghapusan_id',$this->penghapusan_id);
		$criteria->compare('penghapusan_nip',$this->penghapusan_nip,true);
		$criteria->compare('penghapusan_gelardepan',$this->penghapusan_gelardepan,true);
		$criteria->compare('penghapusan_nama',$this->penghapusan_nama,true);
		$criteria->compare('gelarpenghapusan_id',$this->gelarpenghapusan_id);
		$criteria->compare('gelarpenghapusan_nama',$this->gelarpenghapusan_nama,true);
		$criteria->compare('jabatanpenghapusan_id',$this->jabatanpenghapusan_id);
		$criteria->compare('jabatanpenghapusan_nama',$this->jabatanpenghapusan_nama,true);
		$criteria->compare('penghapusanmengetahui_id',$this->penghapusanmengetahui_id);
		$criteria->compare('penghapusanmengetahui_nip',$this->penghapusanmengetahui_nip,true);
		$criteria->compare('penghapusanmengetahui_gelardepan',$this->penghapusanmengetahui_gelardepan,true);
		$criteria->compare('penghapusanmengetahui_nama',$this->penghapusanmengetahui_nama,true);
		$criteria->compare('gelarpenghapusanmengetahui_id',$this->gelarpenghapusanmengetahui_id);
		$criteria->compare('gelarpenghapusanmengetahui_nama',$this->gelarpenghapusanmengetahui_nama,true);
		$criteria->compare('jabatanpenghapusanmengetahui_id',$this->jabatanpenghapusanmengetahui_id);
		$criteria->compare('jabatanpenghapusanmengetahui_nama',$this->jabatanpenghapusanmengetahui_nama,true);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('menyetujui_nip',$this->menyetujui_nip,true);
		$criteria->compare('menyetujui_gelardepan',$this->menyetujui_gelardepan,true);
		$criteria->compare('menyetujui_nama',$this->menyetujui_nama,true);
		$criteria->compare('gelarmenyetujui_id',$this->gelarmenyetujui_id);
		$criteria->compare('gelarmenyetujui_nama',$this->gelarmenyetujui_nama,true);
		$criteria->compare('jabatanmenyetujui_id',$this->jabatanmenyetujui_id);
		$criteria->compare('jabatanmenyetujui_nama',$this->jabatanmenyetujui_nama,true);
		$criteria->compare('ruanghapus_id',$this->ruanghapus_id);
		$criteria->compare('ruanghapus_nama',$this->ruanghapus_nama,true);
		$criteria->compare('pengeluaranaset_id',$this->pengeluaranaset_id);
		$criteria->compare('nopengeluaranaset',$this->nopengeluaranaset,true);
		$criteria->compare('tglpengeluaranaset',$this->tglpengeluaranaset,true);
		$criteria->compare('kd_lokasi_kode',$this->kd_lokasi_kode,true);
		$criteria->compare('pengeluaran_kodelokasi',$this->pengeluaran_kodelokasi,true);
		$criteria->compare('lokasipenerima_kode',$this->lokasipenerima_kode,true);
		$criteria->compare('penerimaaset',$this->penerimaaset,true);
		$criteria->compare('jenisperuntukan',$this->jenisperuntukan,true);
		$criteria->compare('no_suratperintah',$this->no_suratperintah,true);
		$criteria->compare('tglsuratperintah',$this->tglsuratperintah,true);
		$criteria->compare('tglpenyerahan',$this->tglpenyerahan,true);
		$criteria->compare('alasan_pengeluaran',$this->alasan_pengeluaran,true);
		$criteria->compare('ruangkeluar_id',$this->ruangkeluar_id);
		$criteria->compare('ruangkeluar_nama',$this->ruangkeluar_nama,true);
		$criteria->compare('pengeluaran_id',$this->pengeluaran_id);
		$criteria->compare('pengeluaran_nip',$this->pengeluaran_nip,true);
		$criteria->compare('pengeluaran_gelardepan',$this->pengeluaran_gelardepan,true);
		$criteria->compare('pengeluaran_nama',$this->pengeluaran_nama,true);
		$criteria->compare('gelarbelakangkeluar_id',$this->gelarbelakangkeluar_id);
		$criteria->compare('gelarbelakangkeluar_nama',$this->gelarbelakangkeluar_nama,true);
		$criteria->compare('jabatankeluar_id',$this->jabatankeluar_id);
		$criteria->compare('jabatankeluar_nama',$this->jabatankeluar_nama,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('mengetahui_nip',$this->mengetahui_nip,true);
		$criteria->compare('mengetahui_gelardepan',$this->mengetahui_gelardepan,true);
		$criteria->compare('mengetahui_nama',$this->mengetahui_nama,true);
		$criteria->compare('gelarmengetahui_id',$this->gelarmengetahui_id);
		$criteria->compare('gelarmengetahui_nama',$this->gelarmengetahui_nama,true);
		$criteria->compare('jabatanmengetahui_id',$this->jabatanmengetahui_id);
		$criteria->compare('jabatanmengetahui_nama',$this->jabatanmengetahui_nama,true);
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
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->group = 'penghapusanaset_id, tglpenghapusan, no_sk_penghapusan, tgl_sk_penghapusan, carapenghapusan, ket_penghapusan';
        $criteria->select = $criteria->group;
        $criteria->addBetweenCondition("DATE(tglpenghapusan) ", $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('penghapusanaset_id',$this->penghapusanaset_id);
		//$criteria->compare('tglpenghapusan',$this->tglpenghapusan,true);
		$criteria->compare('nopenghapusan',$this->nopenghapusan,true);
		$criteria->compare('LOWER(no_sk_penghapusan)', strtolower($this->no_sk_penghapusan),true);
		$criteria->compare('tgl_sk_penghapusan',$this->tgl_sk_penghapusan,true);
		$criteria->compare('LOWER(carapenghapusan)',strtolower($this->carapenghapusan),true);
		$criteria->compare('LOWER(penghapusan_nama)', strtolower($this->penghapusan_nama),true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}