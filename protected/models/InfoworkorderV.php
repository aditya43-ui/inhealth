<?php

/**
 * This is the model class for table "infoworkorder_v".
 *
 * The followings are the available columns in table 'infoworkorder_v':
 * @property integer $workorder_id
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
 * @property integer $kontrakpemeliharaan_id
 * @property string $kontrakpem_no
 * @property string $kontrakpem_tgl
 * @property string $kontrakpem_sdtgl
 * @property double $kontrakpem_nilai
 * @property string $kontrakpem_ket
 * @property string $statuskontrak
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $pegawai_wo_id
 * @property string $pegawai_nip
 * @property string $pegawai_gelardepan
 * @property string $pegawai_nama
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property string $supplier_alamat
 * @property string $supplier_propinsi
 * @property string $supplier_kabupaten
 * @property string $supplier_telp
 * @property string $supplier_fax
 * @property string $supplier_kodepos
 * @property string $supplier_cp
 * @property string $supplier_cp_hp
 * @property string $supplier_cp_email
 * @property string $supplier_jenis
 * @property string $supplier_cp_jabatan
 * @property boolean $supplier_simbada
 * @property integer $teknisiperalatan_id
 * @property string $namateknisi
 * @property string $jeniskelamin
 * @property string $tempatlahir
 * @property string $tgllahir
 * @property string $agama
 * @property string $alamat_teknisi
 * @property string $no_kontak_teknisi
 * @property integer $pegawai_pjp_id
 * @property string $pegawai_pjp_nip
 * @property string $pegawai_pjp_gelardepan
 * @property string $pegawai_pjp_nama
 * @property integer $gelarbelakangpjp_id
 * @property string $gelarbelakangpjp_nama
 * @property integer $jabatanpjp_id
 * @property string $jabatanpjp_nama
 * @property integer $pegawai_teknisi_id
 * @property string $pegawai_teknisi_nip
 * @property string $pegawai_teknisi_gelardepan
 * @property string $pegawai_teknisi_nama
 * @property integer $gelarbelakangteknisi_id
 * @property string $gelarbelakangteknisi_nama
 * @property integer $jabatanteknisi_id
 * @property string $jabatanteknisi_nama
 */
class InfoworkorderV extends CActiveRecord {

    public $teknisiperalatan_nama;
    public $is_pj_asset;
        

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InfoworkorderV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'infoworkorder_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('workorder_id, invperalatan_id, invperalatan_umurekonomis, asalaset_id, pemilikbarang_id, lokasi_id, jenisbarang_id, barang_id, kontrakpemeliharaan_id, ruangan_id, instalasi_id, pegawai_wo_id, gelarbelakang_id, jabatan_id, supplier_id, teknisiperalatan_id, pegawai_pjp_id, gelarbelakangpjp_id, jabatanpjp_id, pegawai_teknisi_id, gelarbelakangteknisi_id, jabatanteknisi_id', 'numerical', 'integerOnly' => true),
            array('invperalatan_harga, invperalatan_akumsusut, peralatan_dayalistrik, kontrakpem_nilai', 'numerical'),
            array('invperalatan_kode, invperalatan_noregister, invperalatan_merk, invperalatan_ukuran, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_keadaan, asalaset_nama, lokasiaset_kode, lokasiaset_namabagian, kodepos_lokasi, telp_lokasi, jenisbarang_nama, barang_type, barang_kode, ruangan_nama, instalasi_nama, pegawai_nama, supplier_telp, supplier_fax, supplier_kodepos, no_kontak_teknisi, pegawai_pjp_nama, pegawai_teknisi_nama', 'length', 'max' => 50),
            array('invperalatan_namabrg, invperalatan_bahan, peralatan_model, peralatan_noseri, peralatan_manufacturer, pemilikbarang_nama, lokasiaset_namainstalasi, lokasiaset_namalokasi, jenis_lokasi, barang_nama, kontrakpem_no, jabatan_nama, supplier_nama, supplier_propinsi, supplier_kabupaten, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp_jabatan, namateknisi, tempatlahir, jabatanpjp_nama, jabatanteknisi_nama', 'length', 'max' => 100),
            array('invperalatan_thnpembelian', 'length', 'max' => 5),
            array('invperalatan_kapasitasrata, pegawai_gelardepan, supplier_kode, agama, pegawai_pjp_gelardepan, pegawai_teknisi_gelardepan', 'length', 'max' => 10),
            array('invperalatan_serftkkalibrasi, pemilikbarang_kode, statuskontrak, supplier_jenis, jeniskelamin', 'length', 'max' => 20),
            array('deskripsi_lokasi, alamat_lokasi', 'length', 'max' => 300),
            array('kotakab_lokasi, induk_satker, alamat_teknisi', 'length', 'max' => 255),
            array('pegawai_nip, pegawai_pjp_nip, pegawai_teknisi_nip', 'length', 'max' => 30),
            array('gelarbelakang_nama, gelarbelakangpjp_nama, gelarbelakangteknisi_nama', 'length', 'max' => 25),
            array('workorder_no, invperalatan_tglguna, invperalatan_ket, invperalatan_ijinoperasional, peralatan_garansihabis, jenisbarang_deskripsi, barang_statusregister, kontrakpem_tgl, kontrakpem_sdtgl, kontrakpem_ket, supplier_alamat, supplier_simbada, tgllahir', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('workorder_id, invperalatan_id, invperalatan_kode, invperalatan_noregister, invperalatan_namabrg, invperalatan_merk, invperalatan_ukuran, invperalatan_bahan, invperalatan_thnpembelian, invperalatan_tglguna, invperalatan_nopabrik, invperalatan_norangka, invperalatan_nomesin, invperalatan_nopolisi, invperalatan_nobpkb, invperalatan_harga, invperalatan_akumsusut, invperalatan_ket, invperalatan_kapasitasrata, invperalatan_ijinoperasional, invperalatan_serftkkalibrasi, invperalatan_umurekonomis, invperalatan_keadaan, peralatan_model, peralatan_noseri, peralatan_manufacturer, peralatan_garansihabis, peralatan_dayalistrik, asalaset_id, asalaset_nama, pemilikbarang_id, pemilikbarang_kode, pemilikbarang_nama, lokasi_id, lokasiaset_kode, lokasiaset_namainstalasi, lokasiaset_namabagian, lokasiaset_namalokasi, deskripsi_lokasi, jenis_lokasi, alamat_lokasi, kotakab_lokasi, kodepos_lokasi, telp_lokasi, induk_satker, jenisbarang_id, jenisbarang_nama, jenisbarang_deskripsi, barang_id, barang_type, barang_kode, barang_nama, barang_statusregister, kontrakpemeliharaan_id, kontrakpem_no, kontrakpem_tgl, kontrakpem_sdtgl, kontrakpem_nilai, kontrakpem_ket, statuskontrak, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, pegawai_wo_id, pegawai_nip, pegawai_gelardepan, pegawai_nama, gelarbelakang_id, gelarbelakang_nama, jabatan_id, jabatan_nama, supplier_id, supplier_kode, supplier_nama, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_jenis, supplier_cp_jabatan, supplier_simbada, teknisiperalatan_id, namateknisi, jeniskelamin, tempatlahir, tgllahir, agama, alamat_teknisi, no_kontak_teknisi, pegawai_pjp_id, pegawai_pjp_nip, pegawai_pjp_gelardepan, pegawai_pjp_nama, gelarbelakangpjp_id, gelarbelakangpjp_nama, jabatanpjp_id, jabatanpjp_nama, pegawai_teknisi_id, pegawai_teknisi_nip, pegawai_teknisi_gelardepan, pegawai_teknisi_nama, gelarbelakangteknisi_id, gelarbelakangteknisi_nama, jabatanteknisi_id, jabatanteknisi_nama', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'workorder_id' => 'Workorder',
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
            'kontrakpemeliharaan_id' => 'Kontrakpemeliharaan',
            'kontrakpem_no' => 'Kontrakpem No',
            'kontrakpem_tgl' => 'Kontrakpem Tgl',
            'kontrakpem_sdtgl' => 'Kontrakpem Sdtgl',
            'kontrakpem_nilai' => 'Kontrakpem Nilai',
            'kontrakpem_ket' => 'Kontrakpem Ket',
            'statuskontrak' => 'Statuskontrak',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan Nama',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'pegawai_wo_id' => 'Pegawai Wo',
            'pegawai_nip' => 'Pegawai Nip',
            'pegawai_gelardepan' => 'Pegawai Gelardepan',
            'pegawai_nama' => 'Pegawai Nama',
            'gelarbelakang_id' => 'Gelarbelakang',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'jabatan_id' => 'Jabatan',
            'jabatan_nama' => 'Jabatan Nama',
            'supplier_id' => 'Supplier',
            'supplier_kode' => 'Supplier Kode',
            'supplier_nama' => 'Supplier Nama',
            'supplier_alamat' => 'Supplier Alamat',
            'supplier_propinsi' => 'Supplier Propinsi',
            'supplier_kabupaten' => 'Supplier Kabupaten',
            'supplier_telp' => 'Supplier Telp',
            'supplier_fax' => 'Supplier Fax',
            'supplier_kodepos' => 'Supplier Kodepos',
            'supplier_cp' => 'Supplier Cp',
            'supplier_cp_hp' => 'Supplier Cp Hp',
            'supplier_cp_email' => 'Supplier Cp Email',
            'supplier_jenis' => 'Supplier Jenis',
            'supplier_cp_jabatan' => 'Supplier Cp Jabatan',
            'supplier_simbada' => 'Supplier Simbada',
            'teknisiperalatan_id' => 'Teknisiperalatan',
            'namateknisi' => 'Namateknisi',
            'jeniskelamin' => 'Jeniskelamin',
            'tempatlahir' => 'Tempatlahir',
            'tgllahir' => 'Tgllahir',
            'agama' => 'Agama',
            'alamat_teknisi' => 'Alamat Teknisi',
            'no_kontak_teknisi' => 'No Kontak Teknisi',
            'pegawai_pjp_id' => 'Pegawai Pjp',
            'pegawai_pjp_nip' => 'Pegawai Pjp Nip',
            'pegawai_pjp_gelardepan' => 'Pegawai Pjp Gelardepan',
            'pegawai_pjp_nama' => 'Pegawai Pjp Nama',
            'gelarbelakangpjp_id' => 'Gelarbelakangpjp',
            'gelarbelakangpjp_nama' => 'Gelarbelakangpjp Nama',
            'jabatanpjp_id' => 'Jabatanpjp',
            'jabatanpjp_nama' => 'Jabatanpjp Nama',
            'pegawai_teknisi_id' => 'Pegawai Teknisi',
            'pegawai_teknisi_nip' => 'Pegawai Teknisi Nip',
            'pegawai_teknisi_gelardepan' => 'Pegawai Teknisi Gelardepan',
            'pegawai_teknisi_nama' => 'Pegawai Teknisi Nama',
            'gelarbelakangteknisi_id' => 'Gelarbelakangteknisi',
            'gelarbelakangteknisi_nama' => 'Gelarbelakangteknisi Nama',
            'jabatanteknisi_id' => 'Jabatanteknisi',
            'jabatanteknisi_nama' => 'Jabatanteknisi Nama',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        //$criteria->addBetweenCondition(" DATE(workorder_tgl) ", $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('workorder_id', $this->workorder_id);
        $criteria->compare('invperalatan_id', $this->invperalatan_id);
        $criteria->compare('invperalatan_kode', $this->invperalatan_kode, true);
        $criteria->compare('invperalatan_noregister', $this->invperalatan_noregister, true);
        $criteria->compare('invperalatan_namabrg', $this->invperalatan_namabrg, true);
        $criteria->compare('invperalatan_merk', $this->invperalatan_merk, true);
        $criteria->compare('invperalatan_ukuran', $this->invperalatan_ukuran, true);
        $criteria->compare('invperalatan_bahan', $this->invperalatan_bahan, true);
        $criteria->compare('invperalatan_thnpembelian', $this->invperalatan_thnpembelian, true);
        $criteria->compare('invperalatan_tglguna', $this->invperalatan_tglguna, true);
        $criteria->compare('invperalatan_nopabrik', $this->invperalatan_nopabrik, true);
        $criteria->compare('invperalatan_norangka', $this->invperalatan_norangka, true);
        $criteria->compare('invperalatan_nomesin', $this->invperalatan_nomesin, true);
        $criteria->compare('invperalatan_nopolisi', $this->invperalatan_nopolisi, true);
        $criteria->compare('invperalatan_nobpkb', $this->invperalatan_nobpkb, true);
        $criteria->compare('invperalatan_harga', $this->invperalatan_harga);
        $criteria->compare('invperalatan_akumsusut', $this->invperalatan_akumsusut);
        $criteria->compare('invperalatan_ket', $this->invperalatan_ket, true);
        $criteria->compare('invperalatan_kapasitasrata', $this->invperalatan_kapasitasrata, true);
        $criteria->compare('invperalatan_ijinoperasional', $this->invperalatan_ijinoperasional);
        $criteria->compare('invperalatan_serftkkalibrasi', $this->invperalatan_serftkkalibrasi, true);
        $criteria->compare('invperalatan_umurekonomis', $this->invperalatan_umurekonomis);
        $criteria->compare('invperalatan_keadaan', $this->invperalatan_keadaan, true);
        $criteria->compare('peralatan_model', $this->peralatan_model, true);
        $criteria->compare('peralatan_noseri', $this->peralatan_noseri, true);
        $criteria->compare('peralatan_manufacturer', $this->peralatan_manufacturer, true);
        $criteria->compare('peralatan_garansihabis', $this->peralatan_garansihabis, true);
        $criteria->compare('peralatan_dayalistrik', $this->peralatan_dayalistrik);
        $criteria->compare('asalaset_id', $this->asalaset_id);
        $criteria->compare('asalaset_nama', $this->asalaset_nama, true);
        $criteria->compare('pemilikbarang_id', $this->pemilikbarang_id);
        $criteria->compare('pemilikbarang_kode', $this->pemilikbarang_kode, true);
        $criteria->compare('pemilikbarang_nama', $this->pemilikbarang_nama, true);
        $criteria->compare('lokasi_id', $this->lokasi_id);
        $criteria->compare('lokasiaset_kode', $this->lokasiaset_kode, true);
        $criteria->compare('lokasiaset_namainstalasi', $this->lokasiaset_namainstalasi, true);
        $criteria->compare('lokasiaset_namabagian', $this->lokasiaset_namabagian, true);
        $criteria->compare('lokasiaset_namalokasi', $this->lokasiaset_namalokasi, true);
        $criteria->compare('deskripsi_lokasi', $this->deskripsi_lokasi, true);
        $criteria->compare('jenis_lokasi', $this->jenis_lokasi, true);
        $criteria->compare('alamat_lokasi', $this->alamat_lokasi, true);
        $criteria->compare('kotakab_lokasi', $this->kotakab_lokasi, true);
        $criteria->compare('kodepos_lokasi', $this->kodepos_lokasi, true);
        $criteria->compare('telp_lokasi', $this->telp_lokasi, true);
        $criteria->compare('induk_satker', $this->induk_satker, true);
        $criteria->compare('jenisbarang_id', $this->jenisbarang_id);
        $criteria->compare('jenisbarang_nama', $this->jenisbarang_nama, true);
        $criteria->compare('jenisbarang_deskripsi', $this->jenisbarang_deskripsi, true);
        $criteria->compare('barang_id', $this->barang_id);
        $criteria->compare('barang_type', $this->barang_type, true);
        $criteria->compare('barang_kode', $this->barang_kode, true);
        $criteria->compare('barang_nama', $this->barang_nama, true);
        $criteria->compare('barang_statusregister', $this->barang_statusregister);
        $criteria->compare('kontrakpemeliharaan_id', $this->kontrakpemeliharaan_id);
        $criteria->compare('kontrakpem_no', $this->kontrakpem_no, true);
        $criteria->compare('kontrakpem_tgl', $this->kontrakpem_tgl, true);
        $criteria->compare('kontrakpem_sdtgl', $this->kontrakpem_sdtgl, true);
        $criteria->compare('kontrakpem_nilai', $this->kontrakpem_nilai);
        $criteria->compare('kontrakpem_ket', $this->kontrakpem_ket, true);
        $criteria->compare('statuskontrak', $this->statuskontrak, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('instalasi_nama', $this->instalasi_nama, true);
        $criteria->compare('pegawai_wo_id', $this->pegawai_wo_id);
        $criteria->compare('pegawai_nip', $this->pegawai_nip, true);
        $criteria->compare('pegawai_gelardepan', $this->pegawai_gelardepan, true);
        $criteria->compare('pegawai_nama', $this->pegawai_nama, true);
        $criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jabatan_id', $this->jabatan_id);
        $criteria->compare('jabatan_nama', $this->jabatan_nama, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('supplier_kode', $this->supplier_kode, true);
        $criteria->compare('supplier_nama', $this->supplier_nama, true);
        $criteria->compare('supplier_alamat', $this->supplier_alamat, true);
        $criteria->compare('supplier_propinsi', $this->supplier_propinsi, true);
        $criteria->compare('supplier_kabupaten', $this->supplier_kabupaten, true);
        $criteria->compare('supplier_telp', $this->supplier_telp, true);
        $criteria->compare('supplier_fax', $this->supplier_fax, true);
        $criteria->compare('supplier_kodepos', $this->supplier_kodepos, true);
        $criteria->compare('supplier_cp', $this->supplier_cp, true);
        $criteria->compare('supplier_cp_hp', $this->supplier_cp_hp, true);
        $criteria->compare('supplier_cp_email', $this->supplier_cp_email, true);
        $criteria->compare('supplier_jenis', $this->supplier_jenis, true);
        $criteria->compare('supplier_cp_jabatan', $this->supplier_cp_jabatan, true);
        $criteria->compare('supplier_simbada', $this->supplier_simbada);
        $criteria->compare('teknisiperalatan_id', $this->teknisiperalatan_id);
        $criteria->compare('namateknisi', $this->namateknisi, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('tempatlahir', $this->tempatlahir, true);
        $criteria->compare('tgllahir', $this->tgllahir, true);
        $criteria->compare('agama', $this->agama, true);
        $criteria->compare('alamat_teknisi', $this->alamat_teknisi, true);
        $criteria->compare('no_kontak_teknisi', $this->no_kontak_teknisi, true);
        $criteria->compare('pegawai_pjp_id', $this->pegawai_pjp_id);
        $criteria->compare('pegawai_pjp_nip', $this->pegawai_pjp_nip, true);
        $criteria->compare('pegawai_pjp_gelardepan', $this->pegawai_pjp_gelardepan, true);
        $criteria->compare('pegawai_pjp_nama', $this->pegawai_pjp_nama, true);
        $criteria->compare('gelarbelakangpjp_id', $this->gelarbelakangpjp_id);
        $criteria->compare('gelarbelakangpjp_nama', $this->gelarbelakangpjp_nama, true);
        $criteria->compare('jabatanpjp_id', $this->jabatanpjp_id);
        $criteria->compare('jabatanpjp_nama', $this->jabatanpjp_nama, true);
        $criteria->compare('pegawai_teknisi_id', $this->pegawai_teknisi_id);
        $criteria->compare('pegawai_teknisi_nip', $this->pegawai_teknisi_nip, true);
        $criteria->compare('pegawai_teknisi_gelardepan', $this->pegawai_teknisi_gelardepan, true);
        $criteria->compare('pegawai_teknisi_nama', $this->pegawai_teknisi_nama, true);
        $criteria->compare('gelarbelakangteknisi_id', $this->gelarbelakangteknisi_id);
        $criteria->compare('gelarbelakangteknisi_nama', $this->gelarbelakangteknisi_nama, true);
        $criteria->compare('jabatanteknisi_id', $this->jabatanteknisi_id);
        $criteria->compare('jabatanteknisi_nama', $this->jabatanteknisi_nama, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition(" DATE(workorder_tgl) ", $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('workorder_id', $this->workorder_id);
        $criteria->compare('invperalatan_noregister', $this->invperalatan_noregister, true);
        $criteria->compare('LOWER(invperalatan_kode)', strtolower($this->invperalatan_kode), true);
        //$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
        $criteria->compare('LOWER(jenisbarang_nama)', strtolower($this->jenisbarang_nama), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(invperalatan_namabrg)', strtolower($this->invperalatan_namabrg), true);
        $criteria->compare('LOWER(namateknisi)', strtolower($this->namateknisi), true);
        $criteria->compare('LOWER(pegawai_pjp_nama)', strtolower($this->pegawai_pjp_nama), true);
        $criteria->compare('LOWER(peralatan_noseri)', strtolower($this->peralatan_noseri), true);
        $criteria->compare('LOWER(pegawai_teknisi_nama)', strtolower($this->pegawai_teknisi_nama), true);
        $criteria->compare('LOWER(workorder_no)', strtolower($this->workorder_no), true);
        
        if (!empty($this->lokasi_id)){
            $criteria->addCondition("lokasi_id=".$this->lokasi_id);
        }
        
         if ($this->is_pj_asset){            
            $criteria->addCondition(" (lokasi_id IN (SELECT lokasi_id FROM penanggungjawabaset_m WHERE pegawai_id = ".Yii::app()->user->getState('pegawai_id')." AND penanggungjawabaset_aktif = TRUE GROUP BY lokasi_id)) OR pj_pemeliharaan_id = ".$this->pj_pemeliharaan_id);
        }       
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
