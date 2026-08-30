<?php

/**
 * This is the model class for table "infoinvkalibrasi_v".
 *
 * The followings are the available columns in table 'infoinvkalibrasi_v':
 * @property integer $invkalibrasi_id
 * @property string $tglkalibrasi
 * @property string $berlaku_sdtgl
 * @property string $nokalibrasi
 * @property string $invkalibrasi_ket
 * @property boolean $islaikpakai
 * @property string $lampiran_berkas
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
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
 * @property double $invperalatan_nilairesidu
 * @property integer $umurekonomis
 * @property string $tglpenghapusan
 * @property string $tipepenghapusan
 * @property double $hargajualaktiva
 * @property double $kerugian
 * @property double $keuntungan
 * @property string $peralatan_model
 * @property string $peralatan_noseri
 * @property string $peralatan_manufacturer
 * @property string $peralatan_garansihabis
 * @property double $peralatan_dayalistrik
 * @property integer $lokasi_id
 * @property string $lokasiaset_kode
 * @property string $lokasiaset_namalokasi
 * @property string $induk_satker
 * @property integer $asalaset_id
 * @property string $asalaset_nama
 * @property integer $pemilikbarang_id
 * @property string $pemilikbarang_kode
 * @property string $pemilikbarang_nama
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 */
class InfoinvkalibrasiV extends CActiveRecord
{
    public $tgl_awal,$tgl_akhir;
    public $pelaksanadet_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoinvkalibrasiV the static model class
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
		return 'infoinvkalibrasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invkalibrasi_id, ruangan_id, supplier_id, pegawai_id, gelarbelakang_id, jabatan_id, invperalatan_id, invperalatan_umurekonomis, umurekonomis, lokasi_id, asalaset_id, pemilikbarang_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('invperalatan_harga, invperalatan_akumsusut, invperalatan_nilairesidu, hargajualaktiva, kerugian, keuntungan, peralatan_dayalistrik', 'numerical'),
			array('nokalibrasi, ruangan_nama, nama_pegawai, invperalatan_kode, invperalatan_noregister, invperalatan_merk, invperalatan_ukuran, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_keadaan, lokasiaset_kode, asalaset_nama, barang_type, barang_kode', 'length', 'max'=>50),
			array('supplier_kode, gelardepan, invperalatan_kapasitasrata', 'length', 'max'=>10),
			array('supplier_nama, jabatan_nama, invperalatan_namabrg, invperalatan_bahan, peralatan_model, peralatan_noseri, peralatan_manufacturer, lokasiaset_namalokasi, pemilikbarang_nama, barang_nama', 'length', 'max'=>100),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('gelarbelakang_nama, tipepenghapusan', 'length', 'max'=>25),
			array('invperalatan_thnpembelian', 'length', 'max'=>5),
			array('invperalatan_serftkkalibrasi, pemilikbarang_kode', 'length', 'max'=>20),
			array('induk_satker', 'length', 'max'=>255),
			array('tglkalibrasi, berlaku_sdtgl, invkalibrasi_ket, islaikpakai, lampiran_berkas, invperalatan_tglguna, invperalatan_ket, invperalatan_ijinoperasional, tglpenghapusan, peralatan_garansihabis', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invkalibrasi_id, tglkalibrasi, berlaku_sdtgl, nokalibrasi, invkalibrasi_ket, islaikpakai, lampiran_berkas, ruangan_id, ruangan_nama, supplier_id, supplier_kode, supplier_nama, pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, jabatan_id, jabatan_nama, invperalatan_id, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_merk, invperalatan_ukuran, invperalatan_bahan, invperalatan_thnpembelian, invperalatan_tglguna, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_harga, invperalatan_akumsusut, invperalatan_ket, invperalatan_kapasitasrata, invperalatan_ijinoperasional, invperalatan_serftkkalibrasi, invperalatan_umurekonomis, invperalatan_keadaan, invperalatan_nilairesidu, umurekonomis, tglpenghapusan, tipepenghapusan, hargajualaktiva, kerugian, keuntungan, peralatan_model, peralatan_noseri, peralatan_manufacturer, peralatan_garansihabis, peralatan_dayalistrik, lokasi_id, lokasiaset_kode, lokasiaset_namalokasi, induk_satker, asalaset_id, asalaset_nama, pemilikbarang_id, pemilikbarang_kode, pemilikbarang_nama, barang_id, barang_type, barang_kode, barang_nama', 'safe', 'on'=>'search'),
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
			'invkalibrasi_id' => 'Invkalibrasi',
			'tglkalibrasi' => 'Tglkalibrasi',
			'berlaku_sdtgl' => 'Berlaku Sdtgl',
			'nokalibrasi' => 'Nokalibrasi',
			'invkalibrasi_ket' => 'Invkalibrasi Ket',
			'islaikpakai' => 'Islaikpakai',
			'lampiran_berkas' => 'Lampiran Berkas',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Supplier Kode',
			'supplier_nama' => 'Supplier Nama',
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
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
			'invperalatan_nilairesidu' => 'Invperalatan Nilairesidu',
			'umurekonomis' => 'Umurekonomis',
			'tglpenghapusan' => 'Tglpenghapusan',
			'tipepenghapusan' => 'Tipepenghapusan',
			'hargajualaktiva' => 'Hargajualaktiva',
			'kerugian' => 'Kerugian',
			'keuntungan' => 'Keuntungan',
			'peralatan_model' => 'Peralatan Model',
			'peralatan_noseri' => 'Peralatan Noseri',
			'peralatan_manufacturer' => 'Peralatan Manufacturer',
			'peralatan_garansihabis' => 'Peralatan Garansihabis',
			'peralatan_dayalistrik' => 'Peralatan Dayalistrik',
			'lokasi_id' => 'Lokasi',
			'lokasiaset_kode' => 'Lokasiaset Kode',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'induk_satker' => 'Induk Satker',
			'asalaset_id' => 'Asalaset',
			'asalaset_nama' => 'Asalaset Nama',
			'pemilikbarang_id' => 'Pemilikbarang',
			'pemilikbarang_kode' => 'Pemilikbarang Kode',
			'pemilikbarang_nama' => 'Pemilikbarang Nama',
			'barang_id' => 'Barang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',
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
        $criteria->addBetweenCondition('DATE(tglkalibrasi)', $this->tgl_awal, $this->tgl_akhir);     
		$criteria->compare('invkalibrasi_id',$this->invkalibrasi_id);
		//$criteria->compare('tglkalibrasi',$this->tglkalibrasi,true);
		$criteria->compare('berlaku_sdtgl',$this->berlaku_sdtgl,true);
		$criteria->compare('nokalibrasi',$this->nokalibrasi,true);
		$criteria->compare('invkalibrasi_ket',$this->invkalibrasi_ket,true);
		$criteria->compare('islaikpakai',$this->islaikpakai);
		$criteria->compare('lampiran_berkas',$this->lampiran_berkas,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);
		$criteria->compare('invperalatan_noregister',$this->invperalatan_noregister,true);
		$criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
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
		$criteria->compare('invperalatan_nilairesidu',$this->invperalatan_nilairesidu);
		$criteria->compare('umurekonomis',$this->umurekonomis);
		$criteria->compare('tglpenghapusan',$this->tglpenghapusan,true);
		$criteria->compare('tipepenghapusan',$this->tipepenghapusan,true);
		$criteria->compare('hargajualaktiva',$this->hargajualaktiva);
		$criteria->compare('kerugian',$this->kerugian);
		$criteria->compare('keuntungan',$this->keuntungan);
		$criteria->compare('peralatan_model',$this->peralatan_model,true);
		$criteria->compare('LOWER(peralatan_noseri)', strtolower($this->peralatan_noseri),true);
		$criteria->compare('peralatan_manufacturer',$this->peralatan_manufacturer,true);
		$criteria->compare('peralatan_garansihabis',$this->peralatan_garansihabis,true);
		$criteria->compare('peralatan_dayalistrik',$this->peralatan_dayalistrik);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('lokasiaset_kode',$this->lokasiaset_kode,true);
		$criteria->compare('lokasiaset_namalokasi',$this->lokasiaset_namalokasi,true);
		$criteria->compare('induk_satker',$this->induk_satker,true);
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('asalaset_nama',$this->asalaset_nama,true);
		$criteria->compare('pemilikbarang_id',$this->pemilikbarang_id);
		$criteria->compare('pemilikbarang_kode',$this->pemilikbarang_kode,true);
		$criteria->compare('pemilikbarang_nama',$this->pemilikbarang_nama,true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
                if (!empty($this->pelaksanadet_nama)){
                    $criteria->addCondition(" invkalibrasi_id IN (SELECT invkalibrasi_id FROM invkalibrasidet_t WHERE invkalibrasidet_t.nama_pegawai ilike '%".$this->pelaksanadet_nama."%' AND invkalibrasidet_t.invkalibrasi_id = t.invkalibrasi_id GROUP BY invkalibrasi_id) ");
                }
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}