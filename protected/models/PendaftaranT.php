<?php

/**
 * This is the model class for table "pendaftaran_t".
 *
 * The followings are the available columns in table 'pendaftaran_t':
 * @property integer $pendaftaran_id
 * @property integer $pasienpulang_id
 * @property integer $pasienbatalperiksa_id
 * @property integer $penanggungjawab_id
 * @property integer $penjamin_id
 * @property integer $shift_id
 * @property integer $pasien_id
 * @property integer $persalinan_id
 * @property integer $pegawai_id
 * @property integer $instalasi_id
 * @property integer $caramasuk_id
 * @property integer $pengirimanrm_id
 * @property integer $peminjamanrm_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $kelaspelayanan_id
 * @property integer $carabayar_id
 * @property integer $pasienadmisi_id
 * @property integer $kelompokumur_id
 * @property integer $golonganumur_id
 * @property integer $rujukan_id
 * @property integer $antrian_id
 * @property integer $karcis_id
 * @property integer $ruangan_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $tglselesaiperiksa
 * @property string $keterangan_reg
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property boolean $nopendaftaran_aktif
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property string $tglrenkontrol
 * @property boolean $statusfarmasi
 * @property integer $sep_id
 * @property integer $doktertujuankontrol_id
 *
 * The followings are the available model relations:
 * @property AnamesadietT[] $anamesadietTs
 * @property AmbiljenazahT[] $ambiljenazahTs
 * @property AnamnesaT[] $anamnesaTs
 * @property AntrianT[] $antrianTs
 * @property PenjualanresepT[] $penjualanresepTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property BookingkamarT[] $bookingkamarTs
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property PasienmasukpenunjangT[] $pasienmasukpenunjangTs
 * @property PasienadmisiT[] $pasienadmisiTs
 * @property PasienpulangT[] $pasienpulangTs
 * @property DietpasienT[] $dietpasienTs
 * @property PeminjamanrmT[] $peminjamanrmTs
 * @property PengirimanrmT[] $pengirimanrmTs
 * @property HasilpemeriksaanpaT[] $hasilpemeriksaanpaTs
 * @property HasilpemeriksaanrmT[] $hasilpemeriksaanrmTs
 * @property HasilpemeriksaanlabT[] $hasilpemeriksaanlabTs
 * @property ResepturT[] $resepturTs
 * @property PasienkirimkeunitlainT[] $pasienkirimkeunitlainTs
 * @property KembalirmT[] $kembalirmTs
 * @property KonsulpoliT[] $konsulpoliTs
 * @property JadwalkunjunganrmT[] $jadwalkunjunganrmTs
 * @property KegbayitabungT[] $kegbayitabungTs
 * @property PasienmorbiditasT[] $pasienmorbiditasTs
 * @property PasienkecelakaanT[] $pasienkecelakaanTs
 * @property ReturresepT[] $returresepTs
 * @property PasienapachescoreT[] $pasienapachescoreTs
 * @property PasienimunisasiT[] $pasienimunisasiTs
 * @property PasienkbT[] $pasienkbTs
 * @property PindahkamarT[] $pindahkamarTs
 * @property PemeriksaanfisikT[] $pemeriksaanfisikTs
 * @property PesanmenudetailT[] $pesanmenudetailTs
 * @property PesanambulansT[] $pesanambulansTs
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property RincianCetakan[] $rincianCetakans
 * @property SuratketeranganR[] $suratketeranganRs
 * @property UbahruanganR[] $ubahruanganRs
 * @property PemakaianambulansT[] $pemakaianambulansTs
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property PasiendirujukkeluarT[] $pasiendirujukkeluarTs
 * @property OdontogramdetailT[] $odontogramdetailTs
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property PembklaimdetalT[] $pembklaimdetalTs
 * @property PeriksakehamilanT[] $periksakehamilanTs
 * @property PersalinanT[] $persalinanTs
 * @property AsuhankeperawatanT[] $asuhankeperawatanTs
 * @property AntrianT $antrian
 * @property CarabayarM $carabayar
 * @property CaramasukM $caramasuk
 * @property GolonganumurM $golonganumur
 * @property InstalasiM $instalasi
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property KarcisM $karcis
 * @property KelaspelayananM $kelaspelayanan
 * @property KelompokumurM $kelompokumur
 * @property PasienM $pasien
 * @property PasienbatalperiksaR $pasienbatalperiksa
 * @property PasienpulangT $pasienpulang
 * @property PegawaiM $pegawai
 * @property PeminjamanrmT $peminjamanrm
 * @property PenanggungjawabM $penanggungjawab
 * @property PengirimanrmT $pengirimanrm
 * @property PenjaminpasienM $penjamin
 * @property PersalinanT $persalinan
 * @property RuanganM $ruangan
 * @property RujukanT $rujukan
 * @property ShiftM $shift
 * @property HasilpemeriksaanradT[] $hasilpemeriksaanradTs
 * @property KirimmenupasienT[] $kirimmenupasienTs
 * @property PasiennapzaT[] $pasiennapzaTs
 * @property SepT[] $sepTs
 */
class PendaftaranT extends CActiveRecord
{
    public $ruangan_nama;
    public $dokter_pemeriksa, $ppds_id, $ppds_nama, $pasienmasukpenunjang_id, $carabayar_nama, $kelaspelayanan_nama, $penjamin_nama;
    public $ceklispendaftaran;
    public $jeniskasuspenyakit_nama, $diagnosa_kode, $diagnosa_nama, $tgladmisi, $smspasien, $nama_pasien, $kepercayaan;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PendaftaranT the static model class
     */

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pendaftaran_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('instalasi_id, kelompokumur_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statuspasien, kunjungan, statusmasuk, umur, create_time, create_loginpemakai_id', 'required'),
            array('pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, sep_id, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, skp_id', 'numerical', 'integerOnly' => true),
            array('no_pendaftaran, statuspengiriman', 'length', 'max' => 20),
            array('no_urutantri', 'length', 'max' => 6),
            array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, status_konfirmasi', 'length', 'max' => 50),
            array('umur', 'length', 'max' => 30),
            array('buatjanjipoli_id,kategoriasalpasien, isumumkebpjs, alihstatus, byphone, kunjunganrumah, tglselesaiperiksa, keterangan_reg, update_time, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tgl_konfirmasi, tglrenkontrol, statusfarmasi, ruangankontrol_id, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, logpenghapusandatakemenkes, slotantrian, verifikasitagihan_id', 'safe'),
            array('doktertujuankontrol_id, statuskirim_wsbpjs, respons_wsbpjs', 'safe'),
            array('info_rs_dari, nursestation_id, lantai_hd, buatjanjipoli_id,kategoriasalpasien, isumumkebpjs, alihstatus, byphone, kunjunganrumah, tglselesaiperiksa, keterangan_reg, update_time, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tgl_konfirmasi, tglrenkontrol, statusfarmasi, ruangankontrol_id, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, logpenghapusandatakemenkes, ket_rencanakontrol, slotantrian, verifikasitagihan_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pendaftaran_id, pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, tglselesaiperiksa, keterangan_reg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, status_konfirmasi, tgl_konfirmasi, tglrenkontrol, statusfarmasi, sep_id, ruangankontrol_id, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman, skp_id, statuskirim_wsbpjs, respons_wsbpjs, verifikasitagihan_id', 'safe', 'on' => 'search'),
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
            'anamesadietTs' => array(self::HAS_MANY, 'AnamesadietT', 'pendaftaran_id'),
            'ambiljenazahTs' => array(self::HAS_MANY, 'AmbiljenazahT', 'pendaftaran_id'),
            'anamnesaTs' => array(self::HAS_MANY, 'AnamnesaT', 'pendaftaran_id'),
            'anamnesa' => array(self::HAS_ONE, 'AnamnesaT', 'pendaftaran_id'),
            'antrianTs' => array(self::HAS_MANY, 'AntrianT', 'pendaftaran_id'),
            'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'pendaftaran_id'),
            'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'pendaftaran_id'),
            'bookingkamarTs' => array(self::HAS_MANY, 'BookingkamarT', 'pendaftaran_id'),
            'bayaruangmukaTs' => array(self::HAS_MANY, 'BayaruangmukaT', 'pendaftaran_id'),
            'pasienmasukpenunjangTs' => array(self::HAS_MANY, 'PasienmasukpenunjangT', 'pendaftaran_id'),
            'pasienmasukpenunjang' => array(self::HAS_ONE, 'PasienmasukpenunjangT', 'pendaftaran_id'),
            'pasienadmisiTs' => array(self::HAS_MANY, 'PasienadmisiT', 'pendaftaran_id'),
            'pasienpulangTs' => array(self::HAS_MANY, 'PasienpulangT', 'pendaftaran_id'),
            'dietpasienTs' => array(self::HAS_MANY, 'DietpasienT', 'pendaftaran_id'),
            'peminjamanrmTs' => array(self::HAS_MANY, 'PeminjamanrmT', 'pendaftaran_id'),
            'pengirimanrmTs' => array(self::HAS_MANY, 'PengirimanrmT', 'pendaftaran_id'),
            'hasilpemeriksaanpaTs' => array(self::HAS_MANY, 'HasilpemeriksaanpaT', 'pendaftaran_id'),
            'hasilpemeriksaanrmTs' => array(self::HAS_MANY, 'HasilpemeriksaanrmT', 'pendaftaran_id'),
            'hasilpemeriksaanlabTs' => array(self::HAS_MANY, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
            'hasilpemeriksaanlab' => array(self::HAS_ONE, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
            'resepturTs' => array(self::HAS_MANY, 'ResepturT', 'pendaftaran_id'),
            'pasienkirimkeunitlainTs' => array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
            'kembalirmTs' => array(self::HAS_MANY, 'KembalirmT', 'pendaftaran_id'),
            'konsulpoliTs' => array(self::HAS_MANY, 'KonsulpoliT', 'pendaftaran_id'),
            'jadwalkunjunganrmTs' => array(self::HAS_MANY, 'JadwalkunjunganrmT', 'pendaftaran_id'),
            'kegbayitabungTs' => array(self::HAS_MANY, 'KegbayitabungT', 'pendaftaran_id'),
            'pasienmorbiditasTs' => array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
            'pasienkecelakaanTs' => array(self::HAS_MANY, 'PasienkecelakaanT', 'pendaftaran_id'),
            'returresepTs' => array(self::HAS_MANY, 'ReturresepT', 'pendaftaran_id'),
            'pasienapachescoreTs' => array(self::HAS_MANY, 'PasienapachescoreT', 'pendaftaran_id'),
            'pasienimunisasiTs' => array(self::HAS_MANY, 'PasienimunisasiT', 'pendaftaran_id'),
            'pasienkbTs' => array(self::HAS_MANY, 'PasienkbT', 'pendaftaran_id'),
            'pindahkamarTs' => array(self::HAS_MANY, 'PindahkamarT', 'pendaftaran_id'),
            'pemeriksaanfisikTs' => array(self::HAS_MANY, 'PemeriksaanfisikT', 'pendaftaran_id'),
            'pemeriksaanfisik' => array(self::HAS_ONE, 'PemeriksaanfisikT', 'pendaftaran_id'),
            'pesanmenudetailTs' => array(self::HAS_MANY, 'PesanmenudetailT', 'pendaftaran_id'),
            'pesanambulansTs' => array(self::HAS_MANY, 'PesanambulansT', 'pendaftaran_id'),
            'rencanaoperasiTs' => array(self::HAS_MANY, 'RencanaoperasiT', 'pendaftaran_id'),
            'rincianCetakans' => array(self::HAS_MANY, 'RincianCetakan', 'pendaftaran_id'),
            'suratketeranganRs' => array(self::HAS_MANY, 'SuratketeranganR', 'pendaftaran_id'),
            'ubahruanganRs' => array(self::HAS_MANY, 'UbahruanganR', 'pendaftaran_id'),
            'pemakaianambulansTs' => array(self::HAS_MANY, 'PemakaianambulansT', 'pendaftaran_id'),
            'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'pendaftaran_id'),
            'pasiendirujukkeluarTs' => array(self::HAS_MANY, 'PasiendirujukkeluarT', 'pendaftaran_id'),
            'odontogramdetailTs' => array(self::HAS_MANY, 'OdontogramdetailT', 'pendaftaran_id'),
            'pasienanastesiTs' => array(self::HAS_MANY, 'PasienanastesiT', 'pendaftaran_id'),
            'pembklaimdetalTs' => array(self::HAS_MANY, 'PembklaimdetalT', 'pendaftaran_id'),
            'periksakehamilanTs' => array(self::HAS_MANY, 'PeriksakehamilanT', 'pendaftaran_id'),
            'persalinanTs' => array(self::HAS_MANY, 'PersalinanT', 'pendaftaran_id'),
            'asuhankeperawatanTs' => array(self::HAS_MANY, 'AsuhankeperawatanT', 'pendaftaran_id'),
            'antrian' => array(self::BELONGS_TO, 'AntrianT', 'antrian_id'),
            'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
            'caramasuk' => array(self::BELONGS_TO, 'CaramasukM', 'caramasuk_id'),
            'golonganumur' => array(self::BELONGS_TO, 'GolonganumurM', 'golonganumur_id'),
            'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
            'kasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
            'jeniskasuspenyakit' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'jeniskasuspenyakit_id'),
            'karcis' => array(self::BELONGS_TO, 'KarcisM', 'karcis_id'),
            'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
            'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pasienbatalperiksa' => array(self::BELONGS_TO, 'PasienbatalperiksaR', 'pasienbatalperiksa_id'),
            'pasienpulang' => array(self::BELONGS_TO, 'PasienpulangT', 'pasienpulang_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'peminjamanrm' => array(self::BELONGS_TO, 'PeminjamanrmT', 'peminjamanrm_id'),
            'penanggungjawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
            'penanggungJawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
            'pengirimanrm' => array(self::BELONGS_TO, 'PengirimanrmT', 'pengirimanrm_id'),
            'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
            'persalinan' => array(self::BELONGS_TO, 'PersalinanT', 'persalinan_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'rujukan' => array(self::BELONGS_TO, 'RujukanT', 'rujukan_id'),
            'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
            'hasilpemeriksaanradTs' => array(self::HAS_MANY, 'HasilpemeriksaanradT', 'pendaftaran_id'),
            'kirimmenupasienTs' => array(self::HAS_MANY, 'KirimmenupasienT', 'pendaftaran_id'),
            'pasiennapzaTs' => array(self::HAS_MANY, 'PasiennapzaT', 'pendaftaran_id'),
            'pembayaranpelayanan' => array(self::HAS_MANY, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
            'obatalkespasien' => array(self::HAS_MANY, 'ObatalkespasienT', 'pendaftaran_id'),
            'tindakanpelayanan' => array(self::HAS_MANY, 'TindakanpelayananT', 'pendaftaran_id'),
            'dokter' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'kirimkeunitlain' => array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
            'diagnosa' => array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
            'diagnosas' => array(self::HAS_ONE, 'PasienmorbiditasT', 'pendaftaran_id'),
            'diagnosax' => array(self::BELONGS_TO, 'PasienmorbiditasT', 'pendaftaran_id'),
            'createlogin'=> array(self::BELONGS_TO, 'PegawaiM', 'create_loginpemakai_id'),
            'sepTs' => array(self::BELONGS_TO, 'SepT', 'sep_id'),
            'ruangankontrol' => array(self::BELONGS_TO, 'RuanganM', 'ruangankontrol_id'),
            'kirimkeunitlain' => array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
            'resumemedis' => array(self::BELONGS_TO, 'ResumemedisR', 'ruangankontrol_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'ubahdokter' => array(self::BELONGS_TO, 'UbahdokterR', 'pendaftaran_id'),
            'admisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pasienpulang' => array(self::BELONGS_TO, 'PasienpulangT', 'pasienpulang_id'),

        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pendaftaran_id' => 'Pendaftaran',
            'pasienpulang_id' => 'Pasien Pulang',
            'pasienbatalperiksa_id' => 'Pasien Batal Periksa',
            'penanggungjawab_id' => 'Penanggung Jawab',
            'penjamin_id' => 'Penjamin',
            'keluhan' => 'Keluhan',
            'diagnosamasuk' => 'Diagnosa Masuk',
            'shift_id' => 'Shift',
            'pasien_id' => 'Pasien',
            'persalinan_id' => 'Persalinan',
            'pegawai_id' => 'Dokter',
            'instalasi_id' => 'Instalasi',
            'caramasuk_id' => 'Cara Masuk',
            'pengirimanrm_id' => 'Pengiriman RM',
            'peminjamanrm_id' => 'Peminjaman RM',
            'jeniskasuspenyakit_id' => 'Sub-Spesialis',
            'pembayaranpelayanan_id' => 'Pembayaran Pelayanan',
            'kelaspelayanan_id' => 'Kelas Pelayanan',
            'carabayar_id' => 'Jenis Penjamin',
            'pasienadmisi_id' => 'Pasien Admisi',
            'kelompokumur_id' => 'Kelompok Umur',
            'golonganumur_id' => 'Golongan Umur',
            'rujukan_id' => 'Rujukan',
            'antrian_id' => 'Antrian',
            'karcis_id' => 'Karcis',
            'ruangan_id' => '&nbsp;&nbsp;Ruangan',
            'no_pendaftaran' => 'Nomor Pendaftaran',
            'tgl_pendaftaran' => 'Tanggal Pendaftaran',
            'no_urutantri' => 'Nomor Urut Antri',
            'transportasi' => 'Transportasi',
            'keadaanmasuk' => 'Keadaan Masuk',
            'statusperiksa' => 'Status Periksa',
            'statuspasien' => 'Status Pasien',
            'kunjungan' => 'Kunjungan',
            'alihstatus' => 'Alih Status',
            'byphone' => 'Dengan Telepon',
            'kunjunganrumah' => 'Kunjungan Rumah',
            'statusmasuk' => 'Status Masuk',
            'umur' => 'Umur',
            'tglselesaiperiksa' => 'Tanggal Selesai Periksa',
            'keterangan_reg' => 'Keterangan Registrasi',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'nopendaftaran_aktif' => 'No. Pendaftaran Aktif',
            'status_konfirmasi' => 'Status Konfirmasi',
            'tgl_konfirmasi' => 'Tanggal Konfirmasi',
            'tglrenkontrol' => 'Tanggal Rencana Kontrol',
            'statusfarmasi' => 'Status Farmasi',
            'no_rekam_medik' => 'Nomer Rekam Medik',
            'sep_id' => 'SEP',
            'ruangankontrol_id' => 'Polik Kontrol',
            'isumumkebpjs' => 'Perubahan Umum ke BPJS ?',
            'kategoriasalpasien' => 'Kategori Asal Pasien',
            'nursestation_id' => 'Nurse Station',
            'info_rs_dari' => 'Mendapatkan info RS dari',
            'ket_rencanakontrol' => '&nbsp;Keterangan',
            'jeniskasuspenyakit_id' => 'Spesialis'

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

        $criteria = new CDbCriteria;

        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasienpulang_id', $this->pasienpulang_id);
        $criteria->compare('pasienbatalperiksa_id', $this->pasienbatalperiksa_id);
        $criteria->compare('penanggungjawab_id', $this->penanggungjawab_id);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('persalinan_id', $this->persalinan_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('caramasuk_id', $this->caramasuk_id);
        $criteria->compare('pengirimanrm_id', $this->pengirimanrm_id);
        $criteria->compare('peminjamanrm_id', $this->peminjamanrm_id);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('kelompokumur_id', $this->kelompokumur_id);
        $criteria->compare('golonganumur_id', $this->golonganumur_id);
        $criteria->compare('rujukan_id', $this->rujukan_id);
        $criteria->compare('antrian_id', $this->antrian_id);
        $criteria->compare('karcis_id', $this->karcis_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
        $criteria->compare('LOWER(keterangan_reg)', strtolower($this->keterangan_reg), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        $criteria->compare('nopendaftaran_aktif', $this->nopendaftaran_aktif);
        $criteria->compare('LOWER(status_konfirmasi)', strtolower($this->status_konfirmasi), true);
        $criteria->compare('LOWER(tgl_konfirmasi)', strtolower($this->tgl_konfirmasi), true);
        $criteria->compare('LOWER(tglrenkontrol)', strtolower($this->tglrenkontrol), true);
        $criteria->compare('statusfarmasi', $this->statusfarmasi);
        $criteria->compare('sep_id', $this->sep_id);

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

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function setStatusPeriksa($status)
    {

        // var_dump($this->attributes, $status); die;
        $a = PasienadmisiT::model()->findByAttributes(array(
            'pendaftaran_id' => $this->pendaftaran_id,
        ));
        $p = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id' => $this->pendaftaran_id,
        ), array(
            'condition' => 'pasienbatalpulang_id is null',
        ));

        $pj = PasienmasukpenunjangT::model()->findByAttributes(array(
            'pendaftaran_id' => $this->pendaftaran_id,
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
            'pasienkirimkeunitlain_id' => NULL,
        ), array('order' => 'pasienmasukpenunjang_id DESC'));


        if (empty($a) && empty($p)) {


            $this->statusperiksa = $status;

            if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_FISIOTERAPI) {
                if (count((array) $pj) > 0) {
                    $updateStatusPeriksa = PasienmasukpenunjangT::model()->updateByPk($pj->pasienmasukpenunjang_id, array('statusperiksa' => $status));
                }
            }

            if ($this->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {

                // echo '<pre>'; var_dump($pj); die;

                // if(date('Y-m-d', strtotime($this->tgl_pendaftaran)) == date('Y-m-d')) {

                if(!empty($pj)) {
                    $updateStatusPeriksa = PasienmasukpenunjangT::model()->updateByPk($pj->pasienmasukpenunjang_id, array('statusperiksa' => $status));
                }

                $updateStatusPeriksaPd = self::model()->updateByPk($this->pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
                //   } else {
                    //   return true;
                //   }
            }

            return $this->save();
        }

        return true;
    }

    public function getColumn($prefix = '')
    {
        $sql = " select column_name from information_schema.columns where column_name ilike 'nopendaftaran_%' AND table_name = 'konfigsystem_k' ORDER BY column_name ASC";
        $column = Yii::app()->db->createCommand($sql)->queryAll();
        $totCol = count((array) $column);

        $col = "";
        $col2 = array();
        foreach ($column as $data) {
            $col .= $data['column_name'] . ', ';
            $col2[] = $data['column_name'];
        }
        $col = rtrim($col, ', ');

        $criteria = new CDbCriteria();
        $criteria->select = " " . $col . " ";
        $hasil = KonfigsystemK::model()->find($criteria);

        $value = array();
        if (!empty($prefix)) {
            $value[''] = '-- Pilih --';
        }
        for ($i = 0; $i < $totCol; $i++) {
            if (!empty($prefix) > 0) {
                foreach ($prefix as $pr) {
                    if (isset($pr)) {
                        $subcol = $col2[$i];
                        if ($pr == $hasil->$subcol) {
                            $value[$hasil->$subcol] = $hasil->$subcol;
                        } else {
                            // tidak melakukan apa2 /skip
                        }
                    }
                }
            }
        }

        return $value;
    }

    public function broadcastNotifSudahPeriksa($id)
    {
        $modPendaftaran = self::model()->findByPk($id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $ruangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);

        $judul = 'Pasien sudah Diperiksa';


        $ruangan_nama = empty($ruangan) ? "-" : $ruangan->ruangan_nama;

        $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . $modPasien->nama_pasien . '<br/>'
            . 'Ruangan ' . $ruangan_nama;

        if (in_array($modPendaftaran->instalasi_id, array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD))) {
            $arr = array(
                'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                'instalasi_id' => $modPendaftaran->instalasi_id,
            );
            $isi .= CHtml::link('<br/><u>Klik ini untuk melakukan pembayaran.</u>', Yii::app()->createUrl('/billingKasir/PembayaranTagihanPasien/index', $arr));
        }




        // print_r($judul);
        // print_r($isi);
        // die;
        //var_dump($judul, $isi, $modelAdmisi->attributes); die;

        return CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
            // array('instalasi_id'=>Params::INSTALASI_ID_RM, 'ruangan_id'=> Params::RUANGAN_ID_LOKET, 'modul_id'=>Params::MODUL_ID_PENDAFTARAN ),
            // array('instalasi_id'=>Yii::app()->user->getState('instalasi_id'), 'ruangan_id'=> Yii::app()->user->getState('ruangan_id'), 'modul_id'=>Yii::app()->session['modul_id'] ),
        ));


        // print_r($modPendaftaran->attributes); die;
    }

    public function getRuanganItems($instalasi_id=null)
        {
          if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama'));
          }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama'));   
          }
        }

    public function getNamaLengkap($id = null)
    {
        if (empty($id)) {
            $this->pegawai_id;
        }
        $dokter = PegawaiM::model()->findByAttributes(array('pegawai_id' => $id));

        if (empty($dokter)) {
            return "-";
        }

        $gelarbelakang_nama = GelarbelakangM::model()->findByPk($dokter->gelarbelakang_id);
        return $dokter->gelardepan . " " . $dokter->nama_pegawai . ", ";
    }

    public function getMasihAnak()
    {
        $tgl_daftar = new DateTime($this->tgl_pendaftaran);
        $tgl_lahir = new DateTime($this->pasien->tanggal_lahir);

        $interval = $tgl_lahir->diff($tgl_daftar);
        return $interval->y <= 14;
    }

    public function getMasihBayi()
    {
        $tgl_daftar = new DateTime($this->tgl_pendaftaran);
        $tgl_lahir = new DateTime($this->pasien->tanggal_lahir);

        $interval = $tgl_lahir->diff($tgl_daftar);
        return ($interval->y == 0 && $interval->m == 0 && $interval->d < 30);
    }

    public function cekPemeriksaanInstalasi($instalasi_id)
    {

        $cr = new CDbCriteria();
        $cr->join = "join ruangan_m r on r.ruangan_id = t.create_ruangan";
        $cr->compare('r.instalasi_id', $instalasi_id);
        $cr->compare('t.pendaftaran_id', $this->pendaftaran_id);

        $anamnesa = AnamnesaT::model()->find($cr);
        $pemeriksaan = PemeriksaanfisikT::model()->find($cr);

        $cr2 = new CDbCriteria();
        $cr2->join = "join ruangan_m r on r.ruangan_id = t.ruanganreseptur_id";
        $cr2->compare('r.instalasi_id', $instalasi_id);
        $cr2->compare('t.pendaftaran_id', $this->pendaftaran_id);

        $reseptur = ResepturT::model()->find($cr2);

        $persalinan = null;
        if ($instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
            $persalinan = PersalinanT::model()->findByAttributes(array(
                'pendaftaran_id' => $this->pendaftaran_id,
            ));
        }


        return !empty($persalinan) || !empty($anamnesa) || !empty($pemeriksaan) || !empty($reseptur);
    }

    public static function simpanData($model, $post = [])
    {
        $ok = true;
        $format = new MyFormatter;
        $modPas = $model->pasien;

        $model->attributes = $post;
        $model->golonganumur_id = CustomFunction::getGolonganUmur($modPas->tanggal_lahir);
        $model->umur = CustomFunction::getUmur($modPas->tanggal_lahir);
        $model->statuspasien = Params::STATUSPASIEN_LAMA;
        $model->kunjungan = CustomFunction::getKunjungan($modPas, $model->ruangan_id);
        $model->tgl_pendaftaran = !empty($model->tgl_pendaftaran) ? $format->formatDateTimeForDb($model->tgl_pendaftaran) : null;

        $model->shift_id = Yii::app()->user->getState('shift_id');
        if (empty($model->shift_id)) {
            $now = date('H:i:s');
            $sql = "SELECT * FROM shift_m where '$now' < shift_jamakhir and shift_aktif = true order by shift_jamakhir";
            $result = Yii::app()->db->createCommand($sql)->queryRow();
            if (empty($result['shift_id'])) {
                $sql = "SELECT * FROM shift_m where '$now' > shift_jamawal and shift_aktif = true order by shift_jamakhir DESC";
                $result = Yii::app()->db->createCommand($sql)->queryRow();
            }

            $model->shift_id = $result['shift_id'];
        }

        $model->tgl_konfirmasi = !empty($model->tgl_konfirmasi) ? $format->formatDateTimeForDb($model->tgl_konfirmasi) : null;
        $model->tglselesaiperiksa = !empty($model->tglselesaiperiksa) ? $format->formatDateTimeForDb($model->tglselesaiperiksa) : null;
        $model->tglrenkontrol = !empty($model->tglrenkontrol) ? $format->formatDateTimeForDb($model->tglrenkontrol) : null;
        $model->keterangan_pendaftaran = isset($post['keterangan_pendaftaran']) ? $post['keterangan_pendaftaran'] : null;

        if (empty($model->pendaftaran_id)) {
            $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id, $model->tgl_pendaftaran);
            $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
            $model->kelompokumur_id = (!empty($modPas->kelompokumur_id) ? $modPas->kelompokumur_id : CustomFunction::getKelompokUmur($modPas->tanggal_lahir));
            $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
            $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = empty(Yii::app()->user->getState('loginpemakai_id')) ? 1 : Yii::app()->user->getState('loginpemakai_id');
            $model->create_ruangan = empty(Yii::app()->user->getState('ruangan_id')) ? 1 : Yii::app()->user->getState('ruangan_id');

            $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
            $estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;

            $tgl_awal = date('Y-m-d');
            $tgl_akhir = date('Y-m-d');
            $criteria = new CDbCriteria();
            $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
            $criteria->addCondition("tgl_pendaftaran::date = '" . $tgl_awal . "'");
            $criteria->order = 'tgl_pendaftaran DESC';
            $dataPendaftaran = self::model()->find($criteria);
            // var_dump($estimasipelayanan, $dataPendaftaran->attributes); die;

            $tgldaftar = new DateTime($model->tgl_pendaftaran);
            if (!empty($dataPendaftaran) && !empty($dataPendaftaran->tglakandilayani)) {
                $tglakandilayani = new DateTime($dataPendaftaran->tglakandilayani);

                if ($tgldaftar < $tglakandilayani) {
                    $tglakandilayani->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                    $model->tglakandilayani = $tglakandilayani->format('Y-m-d H:i:s');
                } else {
                    $tgldaftar->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                    $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
                }
            } else {
                $tgldaftar->add(new DateInterval("PT" . $estimasipelayanan . "M"));
                $model->tglakandilayani = $tgldaftar->format('Y-m-d H:i:s');
            }

            if (isset($post['buatjanjipoli_id']) || !empty($model->buatjanjipoli_id)) {
                $model->buatjanjipoli_id = $post['buatjanjipoli_id'];

                $janjipoli = BuatjanjipoliT::model()->findByPk($model->buatjanjipoli_id);

                $model->tglakandilayani = $model->tgl_pendaftaran;

                if (!empty($janjipoli) && $janjipoli->ruangan_id == $model->ruangan_id) {
                    $model->no_urutantri = $janjipoli->no_antrianjanji;
                }
            }
        } else {
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = empty(Yii::app()->user->getState('loginpemakai_id')) ? 1 : Yii::app()->user->getState('loginpemakai_id');
        }

        $ok &= $model->save();

        $data['sukses'] = $ok;
        $data['model'] = $model;

        return $data;
    }

    /**
     * 
     * @return type
     */
    public function cekMorbiditasAkutKronis()
    {
        $mod = null;
        if (!empty($this->pendaftaran_id) && !empty($this->ruangan_id)) {
            $cri = new CDbCriteria;
            $cri->select = " LOWER(statusdiagnosapasien) as statusdiagnosapasien, DATE(create_time) as create_time ";
            $cri->addCondition(" (pendaftaran_id <> " . $this->pendaftaran_id . " AND pendaftaran_id < " . $this->pendaftaran_id . " ) AND  ruangan_id = " . $this->ruangan_id . " AND pasien_id = " . $this->pasien_id . " AND LOWER(statusdiagnosapasien) IN ('akut','kronis') ");
            //$cri->addCondition("diagnosa_id <> 0");
            $cri->order = " create_time DESC ";
            $mod = PasienmorbiditasT::model()->find($cri);
        }
        return !empty($mod) ? $mod : '';
    }

    /**
     * 
     * @return type
     */
    public function riwayatKePenunjang()
    {
        $load = [];
        if (!empty($this->pendaftaran_id)) {
            $load['ruangan'] = [];
            $load['data'] = [];

            $mod = PasienmasukpenunjangV::model()->findAll(" pendaftaran_id  = " . $this->pendaftaran_id);

            foreach ($mod as $key => $val) {
                $init = $val->pasienmasukpenunjang_id;

                $load['ruangan'][$val->ruangan_id] = $val->ruangan_nama;

                $modHasilLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $val->pasienmasukpenunjang_id));
                $modHasilRad = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $val->pasienmasukpenunjang_id));
                $modHasilRehab = HasilpemeriksaanrmT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $val->pasienmasukpenunjang_id));
                $modAsesmenGizi = AsesmengiziT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $val->pasienmasukpenunjang_id), array(
                    'order' => 'asesmengizi_id desc'
                ));

                if (!empty($modHasilLab)) {
                    $criteria = new CDbCriteria();
                    $criteria->join = "
                            JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
                            JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                            JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
                    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilLab->hasilpemeriksaanlab_id);
                    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
                    $modDetail = RJDetailhasilpemeriksaanlabT::model()->findAll($criteria);

                    $load['laboratorium'][$init]['kunjungan'] = $val;
                    $load['laboratorium'][$init]['detail'] = $modDetail;
                    $load['laboratorium'][$init]['hasil'] = $modHasilLab;
                }

                if (!empty($modHasilRad)) {
                    $pemeriksa = PegawaiM::model()->findByAttributes(array('pegawai_id' => $val->pegawai_id));

                    $load['radiologi'][$init]['kunjungan'] = $val;
                    $load['radiologi'][$init]['pemeriksa'] = $pemeriksa;
                    $load['radiologi'][$init]['hasil'] = $modHasilRad;
                }

                if (!empty($modHasilRehab)) {
                    $detailHasil = HasilpemeriksaanrmT::model()->findAll('pasienmasukpenunjang_id = ' . $val->pasienmasukpenunjang_id);
                    $load['rehabmedis'][$init]['kunjungan'] = $val;
                    $load['rehabmedis'][$init]['hasil'] = $detailHasil;
                }

                if (!empty($modAsesmenGizi)) {
                    $load['asesmengizi'][$init]['kunjungan'] = $val;
                    $load['asesmengizi'][$init]['hasil'] = $modAsesmenGizi;
                }
            }
        }

        return $load;
    }

    public function searchRiwayatPRMRJ()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "t.pegawai_id, t.pasien_id, t.pendaftaran_id, ru.ruangan_id, ru.ruangan_nama, t.tgl_pendaftaran, t.isprmrj, t.instalasi_id, t.petugaskesehatan_prmrj";
        $criteria->group = $criteria->select;

        $criteria->join = "LEFT JOIN pasienmorbiditas_t mo ON mo.pendaftaran_id = t.pendaftaran_id "
            . "JOIN ruangan_m ru ON ru.ruangan_id = t.ruangan_id "
            . "LEFT JOIN diagnosa_m diag ON diag.diagnosa_id = mo.diagnosa_id ";

        //       if($this->ceklispendaftaran){
        //           if(!empty($this->tgl_pendaftaran)){
        //               $rencanaaskep_tgl = $this->getKonverviDateRange($this->tgl_pendaftaran);
        //               $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $rencanaaskep_tgl[0], $rencanaaskep_tgl[1]);
        //           }
        //       }
        //
        //       // if(!empty($this->pendaftaran_id)){
        //       //     $criteria->addCondition('t.pendaftaran_id ='.$this->pendaftaran_id);
        // // }
        //
        if (!empty($this->pasien_id)) {
            $criteria->addCondition('t.pasien_id =' . $this->pasien_id);
        }

        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('t.ruangan_id =' . $this->ruangan_id);
        }
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition('t.pegawai_id =' . $this->pegawai_id);
        }
        $criteria->compare('t.isprmrj', (($this->isprmrj) ? true : false), false);
        $criteria->compare('lower(diag.diagnosa_kode)', strtolower($this->diagnosa_kode), true);
        $criteria->compare('lower(diag.diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->addCondition('t.pasienbatalperiksa_id IS NULL ');
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function generateNoRandom()
    {
        $rand = rand(100, 999);
        return date('YmdHis') . $rand;
    }

    public function generateNoPendaftaranDanSimpan()
    {

        if (empty($this->pendaftaran_id)) {
            return;
        }

        $nomor = (string)MyGenerator::noPendaftaran($this->instalasi_id, $this->tgl_pendaftaran);
        $this->no_pendaftaran = $nomor;

        $row = self::model()->updateByPk($this->pendaftaran_id, array(
            'no_pendaftaran' => $nomor,
        ));

        if ($row == 0) {
            $this->generateNoPendaftaranDanSimpan();
        }
    }


    public function generateNoPendaftaranMultipoli($pendaftaran_id, $instalasi_id, $tgl_pendaftaran)
    {
        self::model()->updateByPk($pendaftaran_id, array(
            'no_pendaftaran' => (string)MyGenerator::noPendaftaran($instalasi_id, $tgl_pendaftaran),
        ));
    }

    public function isPasienPulangAtauTindakLanjut($konsulpoli_id = null) {

        // var_dump($this->statusperiksa);die;

        if ($this->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
            $pulangMenunggal = PasienpulangT::model()->findByAttributes(array(
                'pendaftaran_id'=>$this->pendaftaran_id,
                'carakeluar_id'=>Params::CARAKELUAR_ID_MENINGGAL
            ));

            // var_dump(Yii::App()->user->getState('ruangan_id'), $pulangMenunggal); die;


            if (!empty($pulangMenunggal) && Yii::App()->user->getState('ruangan_id') == Params::RUANGAN_ID_FORENSIC) {
                return false;
            }


            return true;
        }

        $pulangInap = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id'=>$this->pendaftaran_id,
        ), array(
            'condition'=>'pasienbatalpulang_id is null and pasienadmisi_id is not null'
        ));

        // var_dump(!empty($pulangInap));die;

        if (!empty($pulangInap)) {
            return true;
        }

        // Validasi PJA Rawat Inap
        $ctindakan0 = TindakanpelayananT::model()->countByAttributes(array(
            'pendaftaran_id'=>$this->pendaftaran_id,
        ), array(
            'condition'=>'pasienadmisi_id is not null'
        ));
        $ctindakan = TindakanpelayananT::model()->countByAttributes(array(
            'pendaftaran_id'=>$this->pendaftaran_id,
        ), array(
            'condition'=>'pasienadmisi_id is not null and (isapprovaltindaklanjut = false or isapprovaltindaklanjut is null)'
        ));
        $coa0 = ObatalkespasienT::model()->countByAttributes(array(
            'pendaftaran_id'=>$this->pendaftaran_id,
        ), array(
            'condition'=>'pasienadmisi_id is not null'
        ));
        $coa = ObatalkespasienT::model()->countByAttributes(array(
            'pendaftaran_id'=>$this->pendaftaran_id,
        ), array(
            'condition'=>'pasienadmisi_id is not null and (isapprovaltindaklanjut = false or isapprovaltindaklanjut is null)'
        ));

        // echo '<pre>';var_dump(($ctindakan0 + $coa0) > 0 && ($ctindakan + $coa) == 0);die;
        if (($ctindakan0 + $coa0) > 0 && ($ctindakan + $coa) == 0) {
            return true;
        }

        // Konsul
        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
        if (!empty($konsul)) {
            return false;
        }

        // echo '<pre>';var_dump($this->instalasi_id == Params::INSTALASI_ID_RD && empty($this->pasienadmisi_id));die;
        if ($this->instalasi_id == Params::INSTALASI_ID_RD && empty($this->pasienadmisi_id)) {

            if (in_array($this->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SEDANG_PERIKSA))) {
                return false;
            }

            if (in_array($this->statusperiksa, array(Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO))) {

                $tindakan0 = TindakanpelayananT::model()->countByAttributes(array(
                    'pendaftaran_id'=>$this->pendaftaran_id,
                ));
    
                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$this->pendaftaran_id,
                    'isapprovaltindaklanjut'=>true,
                ));
    
                $oa0 = ObatalkespasienT::model()->countByAttributes(array(
                    'pendaftaran_id'=>$this->pendaftaran_id,
                ));
    
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$this->pendaftaran_id,
                    'isapprovaltindaklanjut'=>true,
                ));

                if ($tindakan0 + $oa0 > 0) {
                    if (!empty($tindakan) || !empty($oa)) {
                        return true;
                    } else {
                        return false;
                    }
                }


                return false;
            }
            
            return false;
        }


        // var_dump(!empty($konsul));

        if ($this->statusperiksa == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
        //    return true;
        }

        $tindakLanjut = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id'=>$this->pendaftaran_id,
        ), array(
            'condition'=>'pasienbatalpulang_id is null and pasienadmisi_id is null'
        ));

        // var_dump(!empty($tindakLanjut));die;
        // echo '<pre>';var_dump(Yii::app()->user->getState('instalasi_id'));die;

        $arrRI = Params::grupInstalasiRIID();
        $arrRI[] = 7;
        $arrRI[] = Params::INSTALASI_ID_REHAB;
        // echo '<pre>';var_dump(!empty($tindakLanjut), !in_array(Yii::app()->user->getState('instalasi_id'), $arrRI));die;
        return 
            Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_ROE_INAP && Yii::app()->user->getState('modul_id') != Params::MODUL_ID_TINDAKAN 
            && (!in_array(Yii::app()->user->getState('instalasi_id'), $arrRI) && !empty($tindakLanjut));

        // return $this->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || !empty($this->pasienpulang_id);
    }

    function cekTindakLanjutIKF() {
        $disable = false;
        if(!empty($this->pasienadmisi_id)) {
            $modPasienAdmisi = PasienadmisiT::model()->findByPk($this->pasienadmisi_id);
            if(!empty($modPasienAdmisi->pasienpulang)) {
                // var_dump($modPasienAdmisi->pasienpulang->isapprovaltindaklanjut);
                if($modPasienAdmisi->pasienpulang->isapprovaltindaklanjut == 't') {
                    $disable = true;
                }
            }
        } else if($this->pasienpulang_id){
            $modPasienPulang = PasienpulangT::model()->findByPk($this->pasienpulang_id);
            if(!empty($modPasienPulang)) {
                if($modPasienPulang->isapprovaltindaklanjut == 't') {
                    $disable == true;
                }
            }
        }
        
        return $disable;
    }

    function validasiRekamMedis() {

        // jika diorder ke penunjang
        if(isset($_GET['pasienmasukpenunjang_id'])) {
            $modPenunjang = PasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
            if(!empty($modPenunjang)) {
                // cek dia diorder dari rawat inap atau rj atau rd
                if(!empty($modPenunjang->pasienadmisi_id)) {
                    //jika pasien dari rawat inap maka cek tindak lanjutnya dari pasinadmisi_t.pasienpulang_id nya sudah terisi atau belum

                    if(!empty($modPenunjang->pasienadmisi->pasienpulang_id)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        // pengecekan ketika di rawat jalan atau darurat
        if ($this->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $this->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP) {
            return true;
        }

        return false;
    }
}
