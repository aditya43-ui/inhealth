<?php

/**
 * This is the model class for table "konfigsystem_k".
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'konfigsystem_k':
 * @property integer $konfigsystem_id
 * @property boolean $isantrian
 * @property boolean $iskarcis
 * @property boolean $printkartulsng
 * @property boolean $printkunjunganlsng
 * @property boolean $nama_huruf_capital
 * @property boolean $alamat_huruf_capital
 * @property string $mr_lab
 * @property string $mr_rad
 * @property string $mr_ibs
 * @property string $mr_rehabmedis
 * @property string $mr_apotik
 * @property string $mr_jenazah
 * @property string $nopendaftaran_rj
 * @property string $nopendaftaran_ri
 * @property string $nopendaftaran_gd
 * @property string $nopendaftaran_lab
 * @property string $nopendaftaran_rad
 * @property string $nopendaftaran_ibs
 * @property string $nopendaftaran_rehabmedis
 * @property string $nopendaftaran_jenazah
 * @property string $running_text_display
 * @property string $running_text_kiosk
 * @property boolean $dokterruangan
 * @property boolean $tindakanruangan
 * @property boolean $tindakankelas
 * @property boolean $tgltransaksimundur
 * @property boolean $krngistokgizi
 * @property boolean $krngistokumum
 * @property double $persentasirujin
 * @property double $persentasirujout
 * @property integer $monitoringrefresh
 * @property boolean $isotomatispresensi
 * @property boolean $karcisbarulama
 * @property integer $lamakonfbooking
 * @property integer $jmldigitrm
 * @property boolean $akomodasiotomatis
 * @property boolean $iskartudgntemplate
 * @property boolean $isbridging
 * @property string $bpjs_host
 * @property integer $bpjs_port
 * @property string $nodejs_host
 * @property integer $nodejs_port
 * @property boolean $is_nodejsaktif
 * @property string $telnet_host
 * @property integer $telnet_port
 * @property boolean $is_telnetaktif
 * @property string $bpjs_uid
 * @property string $bpjs_secret
 * @property string $jenissuaraantrian
 * @property boolean $issmsgateway
 * @property boolean $mapdashboard
 * @property boolean $isbayarkekasirpenunjang
 * @property boolean $isjurnalotomatis
 * @property boolean $ispostingotomatis
 * @property integer $masaberlaku_pelamar_hr
 * @property string $nopendaftaran_apotik
 * @property double $pembulatanhargakasir
 * @property integer $jatuhtempoklaim
 * @property integer $jatuhtempotagihan
 * @property boolean $hl7broker_aktif
 * @property string $hl7broker_host
 * @property string $hl7broker_port
 * @property integer $delaytombolantrian
 * @property integer $normlama_min
 * @property integer $normlama_maks
 * @property boolean $isonestopbilling
 * @property boolean $isstatuspulang_otomatis
 * @property string $bpjs_userkey
 * @property string $bpjs_v2
 * @property string $bpjs_terenkripsi
 * @property integer $tindakanluarrs
 */
class KonfigsystemK extends CActiveRecord {

	public $google_api_key, $isonestopbilling, $isstatuspulang_otomatis, $labelnomorpegawai, $labelpegawai;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KonfigsystemK the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'konfigsystem_k';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('running_text_display, persentasirujin, persentasirujout', 'required'),
            array('monitoringrefresh, lamakonfbooking, jmldigitrm, bpjs_port, nodejs_port, telnet_port, masaberlaku_pelamar_hr, jatuhtempoklaim, jatuhtempotagihan, delaytombolantrian, cutoff_penggajian, lama_cuti, levelrekeninglast,jumlahdigit_nokepegawaian, jasaoperator_id, jasaasoperator_id, jasaanestesi_id, jasaperanestesi_id, jasaperruangpulih_id, jasaperinstrument_id, jasapersirkuler_id, tindakanluarrs', 'numerical', 'integerOnly' => true),

            array('persentasirujin, persentasirujout, pembulatanhargakasir, upgrade_vip', 'numerical'),
            array('mr_lab, mr_rad, mr_ibs, mr_rehabmedis, mr_apotik, mr_jenazah, nopendaftaran_rj, nopendaftaran_ri, nopendaftaran_gd, nopendaftaran_lab, nopendaftaran_rad, nopendaftaran_ibs, nopendaftaran_rehabmedis, nopendaftaran_jenazah, nopendaftaran_apotik', 'length', 'max' => 4),
            array('bpjs_host, nodejs_host, telnet_host, bpjs_uid, kemenkes_idrs, bpjs_inacbg_key, api_inhealth, token_inhealth, provider_inhealth, antreanonline_uid, antreanonline_kodefaskes', 'length', 'max' => 100),
            array('bpjs_secret, kemenkes_password, antreanonline_secret', 'length', 'max' => 255),
            array('jenissuaraantrian,prefix_kode_surat, metode_nokepegawaian,metode_triage, labeldepan_nokepegawaian, labelnomorpegawai, labelpegawai', 'length', 'max' => 50),
            array('hl7broker_host, kemenkes_host, antreanonline_url', 'length', 'max' => 200),
            array('servicename_bpjs', 'length', 'max' => 20),
            array('hl7broker_port, normlama_min, normlama_maks', 'length', 'max' => 10),

            array('is_mips, mips_host, mips_password, hl7broker_api_url', 'safe'),
            array('is_ktpreader,isppds,isbydokter, ishelpusaktif,alamatheadersurat, klinikgigi_id, is_finger_pasien, finger_pasien_portserver, finger_pasien_hostserver, refreshnotifikasi, chat, email_aktif, linkemail_aktifexp, linkemail_resetexp,notifikasi,bpjs_inacbg_path, isantrian, iskarcis, printkartulsng, printkunjunganlsng, nama_huruf_capital, alamat_huruf_capital, running_text_kiosk, running_text_kamar, dokterruangan, tindakanruangan, tindakankelas, tgltransaksimundur, krngistokgizi, krngistokumum, isotomatispresensi, karcisbarulama, akomodasiotomatis, iskartudgntemplate, isbridging, is_nodejsaktif, is_telnetaktif, issmsgateway, mapdashboard, isbayarkekasirpenunjang, isjurnalotomatis, ispostingotomatis, hl7broker_aktif, logolayarantrian, is_api_gmap, cutoff_penggajian, tampilhargagu, tampilhargagf, suaranotifikasi, isstokgiziminus, isstokumumminus, kelasrujukanpenunjang_id, lama_cuti, tampilhargagz, ispajakgajipegawai, ispajakdokter, is_kemenkes, whatsapp_host, whatsapp_host_single, whatsapp_host_file, whatsapp_renkontrol,whatsapp_h1renkontrol,whatsapp_hadirrenkontrol,whatsapp_tdkhadirrenkontrol,hl7broker_api_url, weasis_host,footer_antrian, weasis_port, weasis_aktif, ispenerimaanlangsung, isfakturdigudang, regulasibpjs_rd, regulasibpjs_rj, regulasibpjs_rd_isrd, regulasibpjs_rd_isrj, regulasibpjs_rj_isrd, regulasibpjs_rj_isrj, jenispenambahan_akomodasiranap, waktutampilalert_akomodasisdhterhitung, antreanonlinewsbpjs, kopsurat_gizi, bridging_host', 'safe'),

            array('oviyam_aktif, oviyam_host, oviyam_port, oviyam_server', 'safe'),
            array('regulasibpjs_rd, regulasibpjs_rj, regulasibpjs_rd_isrd, regulasibpjs_rd_isrj, regulasibpjs_rj_isrd, regulasibpjs_rj_isrj, jam_jobakomodasiranap', 'safe'),
            array('carabayarpenunjangluar_id, kelasrujukanpenunjangluar_id, jenispenambahan_akomodasiranap, waktutampilalert_akomodasisdhterhitung', 'safe'),



            array('isonestopbilling,jenisrujukan, isstatuspulang_otomatis', 'safe'),
            
            array('bpjs_terenkripsi, bpjs_v2, bpjs_userkey, bpjs_aplicare_host, bridging_inhealth, antreanonline_userkey, antreanonline_host, antreanonline_service, antreanonline_port, tampilstokpenjualan, pesanmenudietotomatis, is_notiftglkadaluarsa', 'safe'),
            array('estimasipelayanan', 'numerical', 'integerOnly' => true),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ishelpusaktif,alamatheadersurat, bpjs_inacbg_path, konfigsystem_id, jenisrujukan, isantrian, iskarcis, printkartulsng, printkunjunganlsng, nama_huruf_capital, alamat_huruf_capital, mr_lab, mr_rad, mr_ibs, mr_rehabmedis, mr_apotik, mr_jenazah, nopendaftaran_rj, nopendaftaran_ri, nopendaftaran_gd, nopendaftaran_lab, nopendaftaran_rad, nopendaftaran_ibs, nopendaftaran_rehabmedis, nopendaftaran_jenazah, running_text_display, running_text_kiosk, dokterruangan, tindakanruangan, tindakankelas, tgltransaksimundur, krngistokgizi, krngistokumum, persentasirujin, persentasirujout, monitoringrefresh, isotomatispresensi, karcisbarulama, lamakonfbooking, jmldigitrm, akomodasiotomatis, iskartudgntemplate,isppds,isbydokter, isbridging, bpjs_host, bpjs_port, nodejs_host, nodejs_port, is_nodejsaktif, telnet_host, telnet_port, is_telnetaktif, bpjs_uid, bpjs_secret, jenissuaraantrian, issmsgateway, mapdashboard, isbayarkekasirpenunjang, isjurnalotomatis, ispostingotomatis, masaberlaku_pelamar_hr, nopendaftaran_apotik, pembulatanhargakasir, jatuhtempoklaim, jatuhtempotagihan, hl7broker_aktif, hl7broker_host, hl7broker_port, delaytombolantrian, normlama_min, normlama_maks, logolayarantrian, cutoff_penggajian, tampilhargagu, tampilhargagf, isstokgiziminus, isstokumumminus, lama_cuti, tampilhargagz, ispajakgajipegawai, ispajakdokter, is_kemenkes, kemenkes_idrs, kemenkes_password, kemenkes_host, ispenerimaanlangsung, isfakturdigudang, bridging_inhealth, api_inhealth, token_inhealth, provider_inhealth, servicename_bpjs, bpjs_inacbg_key, upgrade_vip, levelrekeninglast, jumlahdigit_nokepegawaian,metode_triage, metode_nokepegawaian, labeldepan_nokepegawaian, labelnomorpegawai, labelpegawai,antreanonlinewsbpjs, antreanonline_userkey, antreanonline_host, antreanonline_service, antreanonline_port, antreanonline_uid, antreanonline_secret, jasaoperator_id, jasaasoperator_id, jasaanestesi_id, jasaperanestesi_id, jasaperruangpulih_id, jasaperinstrument_id, jasapersirkuler_id, antreanonline_kodefaskes, antreanonline_url, jam_jobakomodasiranap, tampilstokpenjualan, tindakanluarrs, pesanmenudietotomatis', 'safe', 'on' => 'search'),
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
            'konfigsystem_id' => 'ID',
            'isantrian' => 'Antrian',
            'iskarcis' => 'Karcis',
            'printkartulsng' => 'Print Kartu Langsung',
            'printkunjunganlsng' => 'Print Kunjungan langsung',
            'nama_huruf_capital' => 'Nama Huruf Capital',
            'alamat_huruf_capital' => 'Alamat Huruf Capital',
            'mr_lab' => 'Prefix RM Laboratorium',
            'jenisrujukan'=>'Default Pencarian Rujukan',
            'mr_rad' => 'Prefix RM Radiologi',
            'mr_ibs' => 'Prefix RM Bedah Sentral',
            'mr_rehabmedis' => 'Prefix RM Rehab Medis',
            'mr_apotik' => 'Prefix RM Apotik',
            'mr_jenazah' => 'Prefix RM Jenazah',
            'nopendaftaran_rj' => 'No. Pendaftaran Rawat Jalan',
            'nopendaftaran_ri' => 'No. Pendaftaran Rawat inap',
            'nopendaftaran_gd' => 'No. Pendaftaran Gawat darurat',
            'nopendaftaran_lab' => 'No. Pendaftaran Laboratorium',
            'nopendaftaran_rad' => 'No. Pendaftaran Radiologi',
            'nopendaftaran_ibs' => 'No. Pendaftaran Bedah Sentral',
            'nopendaftaran_rehabmedis' => 'No. Pendaftaran Rehab Medis',
            'nopendaftaran_jenazah' => 'No. Pendaftaran Jenazah',
            'running_text_display' => 'Running Text Display',
            'running_text_kiosk' => 'Running Text Kiosk',
            'running_text_kamar' => 'Running Text Informasi Ketersediaan Kamar',
            'dokterruangan' => 'Dokter Ruangan',
            'tindakanruangan' => 'Tindakan Ruangan',
            'tindakankelas' => 'Kelas Tindakan',
            'krngistokgizi' => 'Hitung Otomatis Stok Instalasi Gizi',
            'krngistokumum' => 'Hitung Otomatis Stok Gudang Umum',
            'persentasirujin' => 'Rujukan Ke Dalam',
            'persentasirujout' => 'Rujukan Ke Luar',
            'monitoringrefresh' => 'Monitoring Refresh (detik)',
            'monitoringpresensi' => 'Monitoring Presensi (detik)',
            'karcisbarulama' => 'Karcis Baru / Lama',
            'lamakonfbooking' => 'Lama Konfirmasi Booking (Jam)',
            //'refreshnotifikasi' => 'Refresh Notifikasi & Chat (detik)',
            'jmldigitrm' => 'Jumlah Digit RM',
            'akomodasiotomatis' => 'Akomodasi Otomatis',
            'iskartudgntemplate' => 'Kartu dengan Template',
            'isbridging' => 'Bridging BPJS',
            'tgltransaksimundur' => 'Tanggal Transaksi Mundur',
            'is_nodejsaktif' => 'Node JS Aktif',
            'is_telnetaktif' => 'Telnet Aktif',
            'nodejs_host' => 'Host Node JS',
            'nodejs_port' => 'Port Node JS',
            'telnet_host' => 'Host Telnet (LED Matrix)',
            'telnet_port' => 'Port Telnet (LED Matrix)',
            'bpjs_host' => 'Host Bridging BPJS',
            'bpjs_port' => 'Port Bridging BPJS',
            'bpjs_uid' => 'Consumer ID BPJS',
            'bpjs_secret' => 'Consumer Secret BPJS',
            'jenissuaraantrian' => 'Jenis Suara Antrian',
            'mapdashboard' => 'Map Dashboard',
            'isbayarkekasirpenunjang' => 'Bayar Penunjang Sebelum Periksa',
            'isjurnalotomatis' => 'Otomatis Jurnal Rekening',
            'ispostingotomatis' => 'Otomatis Posting Jurnal',
            'masaberlaku_pelamar_hr' => 'Masa Berlaku Pelamar',
            'nopendaftaran_apotik' => 'No. Pendaftaran Apotik',
            'pembulatanhargakasir' => 'Pembulatan Kasir',
            'jatuhtempoklaim' => 'Termin jatuh tempo klaim',
            'jatuhtempotagihan' => 'Termin jatuh tempo tagihan',
            'hl7broker_aktif' => 'HL-7 Broker Aktif',
            'hl7broker_host' => 'Host HL-7 Broker',
            'hl7broker_port' => 'Port HL-7 Broker',
            'delaytombolantrian' => 'Delay Tombol Antrian',
            'normlama_min' => 'No. RM Lama Dari',
            'normlama_maks' => 'Sampai dengan',
            'issmsgateway' => 'SMS Gateway',
            'bpjs_inacbg_path' => 'Host INA-CBG',
			'email_aktif' => 'Email',
			'linkemail_aktifexp' => 'Link Aktif Kedaluwarsa',
			'linkemail_resetexp' => 'Link Reset Kedaluwarsa',
			'refreshnotifikasi' => 'Refresh Notifikasi',
            'logolayarantrian'=>'Logo Layar Antrian',
            'is_api_gmap'=>'Google Maps API',
            'tampilhargagu'=>'Tampil Harga Gudang Umum',
            'tampilhargagf'=>'Tampil Harga Gudang Farmasi',
            'isstokgiziminus'=>'Stok Instalasi Gizi Minus',
            'isstokumumminus'=>'Stok Gudang Umum Minus',
            'suaranotifikasi'=>'Suara Notifikasi',
            'kelasrujukanpenunjang_id'=>'Kelas Rujukan Penunjang',
            'lama_cuti'=>'Lama Cuti',
            'alamatheadersurat'=>'Alamat Header Surat',
            'tampilhargagz'=>'Tampil Harga Gizi',
            'ispajakgajipegawai'=>'Total Pajak',
            'ispajakdokter'=>'Total Pajak Dokter',
            'hl7broker_api_url'=>'URL API HL-7',
            'weasis_host' => 'Weasis Host',
            'weasis_port' => 'Weasis Port',
            'weasis_aktif' => 'Weasis Aktif',
            'kemenkes_host'=>'Host Kemenkes',
            'is_kemenkes'=>'Kemenkes Aktif',
            'isbydokter'=>'By Dokter',
            'isppds'=>'PPDS',
            'kemenkes_idrs'=>'Id RS Kemenkes',
            'kemenkes_password'=>'Password Kemenkes',
            'footer_antrian' =>  'Footer Text Antrian',
            'whatsapp_host_single' => 'WhatsApp Host (Single)',
            'whatsapp_host_file' => 'WhatsApp Host (File)',
            'whatsapp_host' => 'WhatsApp Host (Multi/Broadcast)',
            'ispenerimaanlangsung'=>'Pengadaan Tanpa Purchase Order',
            'isfakturdigudang'=>'Pemfakturan di Modul Pengadaan',
            'regulasibpjs_rd' => 'Regulasi RD',
            'regulasibpjs_rj' => 'Regulasi RJ',
            'jenispenambahan_akomodasiranap' => 'Perhitungan Penambahan Akomodasi',
            'waktutampilalert_akomodasisdhterhitung'=>'Tampil alert akomodasi sudah terhitung jika lama dirawat dibawah',
            
            'oviyam_host' => 'Host',
            'oviyam_port' => 'Port',
            'oviyam_aktif' => 'Aktif',
            'oviyam_server' => 'ServerName',
            
            'bpjs_aplicare_host' => 'Host Bridging BPJS Aplicare',
            'servicename_bpjs'=>'Service Vklaim BPJS',
            'bpjs_inacbg_key'=>'Key INA-CBG',
            'bridging_inhealth'=>'Briging Inhealth',
            'api_inhealth'=>'Link Briging Inhealth',
            'token_inhealth'=>'Token Briging Inhealth',
            'provider_inhealth'=>'Provider Briging Inhealth',
            
            'carabayarpenunjangluar_id'=>'Cara Bayar Penunjang Rujukan Luar',
            'kelasrujukanpenunjangluar_id'=>'Kelas Penunjang Rujukan Luar',
            
            'isonestopbilling' => 'One Stop Billing Pasien',
            'isstatuspulang_otomatis' => 'Status Pulang Otomatis',
            'bpjs_userkey' => 'User Key BPJS',
            'bpjs_v2' => 'BPJS v2',
            'bpjs_terenkripsi' => 'Terenkripsi',
            'antreanonlinewsbpjs' => 'Antrean Online',
            'antreanonline_userkey' => 'Userkey Antrean Online',
            'antreanonline_host' => 'Host Antrean Online',
            'antreanonline_port' => 'Port Antrean Online',
            'antreanonline_service' => 'Service Antrean Online',
            'antreanonline_uid' => 'Consumer ID Antrean',
            'antreanonline_secret' => 'Consumer Secret Antrean',
            'nominal_tanggunganbpjs' => 'Nominal Tanggungan BPJS',
            'jasaoperator_id'=>'Komponen Jasa dr. Operator',
            'jasaasoperator_id'=>'Komponen Jasa Asisten Operator',
            'jasaanestesi_id'=>'Komponen Jasa dr. Anestesi',
            'jasaperanestesi_id'=>'Komponen Jasa Perawat Anestesi',
            'jasaperruangpulih_id'=>'Komponen Jasa Perawat Ruang Pulih',
            'jasaperinstrument_id'=>'Komponen Jasa Perawat Instrument',
            'jasapersirkuler_id'=>'Komponen Jasa Perawat Sirkuler',
            'antreanonline_kodefaskes' => 'Kode Faskes Antrian Online',
            'antreanonline_url' => 'Url Antrean Online',
            'tampilstokpenjualan'=>'Tampil Stok Obat Penjualan',
            'tindakanluarrs' => 'Tindakan Luar RS',
            'whatsapp_renkontrol' => ' Rencana Kontrol',
            'whatsapp_h1renkontrol' => 'Reminder H-1 Rencana Kontrol',
            'whatsapp_hadirrenkontrol' => 'Balasan Rencana Kontrol (Hadir)',
            'whatsapp_tdkhadirrenkontrol' => 'Balasan Rencana Kontrol (Tidak Hadir)',

            'pesanmenudietotomatis' => 'Pesan Menu Diet Otomatis',
            'is_notiftglkadaluarsa' => 'Notif Tgl Kadaluarsa Farmasi'
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    *
    */
    public function attributeTooltips() {
        return array(
            'konfigsystem_id' => 'ID',
            'isantrian' => 'Menggunakan pemanggilan antrian',
            'iskarcis' => 'Menggunakan karcis pendaftaran',
            'printkartulsng' => ' Langsung print kartu setelah transaksi pendaftaran',
            'printkunjunganlsng' => 'Langsung print status kunjungan setelah transaksi pendaftaran',
            'nama_huruf_capital' => 'Nama pasien otomatis huruf kapital',
            'alamat_huruf_capital' => 'Alamat pasien otomatis huruf kapital',
            'mr_lab' => 'Karakter di depan nomor rekam medik untuk pasien laboratorium',
            'mr_rad' => 'Karakter di depan nomor rekam medik untuk pasien radiologi',
            'mr_ibs' => 'Karakter di depan nomor rekam medik untuk pasien bedah sentral',
            'mr_rehabmedis' => 'Karakter di depan nomor rekam medik untuk pasien rehab medis',
            'mr_apotik' => 'Karakter di depan nomor rekam medik untuk pasien apotek',
            'mr_jenazah' => 'Karakter di depan nomor rekam medik untuk pasien jenazah',
            'nopendaftaran_rj' => 'Karakter di depan nomor transaksi pendaftaran rawat jalan',
            'nopendaftaran_ri' => 'Karakter di depan nomor transaksi pendaftaran rawat inap',
            'nopendaftaran_gd' => 'Karakter di depan nomor transaksi pendaftaran gawat darurat',
            'nopendaftaran_lab' => 'Karakter di depan nomor transaksi pendaftaran laboratorium',
            'nopendaftaran_rad' => 'Karakter di depan nomor transaksi pendaftaran radiologi',
            'nopendaftaran_ibs' => 'Karakter di depan nomor transaksi pendaftaran bedah sentral',
            'nopendaftaran_rehabmedis' => 'Karakter di depan nomor transaksi pendaftaran rehabmedis',
            'nopendaftaran_jenazah' => 'Karakter di depan nomor transaksi pendaftaran jenazah',
            'running_text_display' => 'Teks berjalan di layar antrian',
            'running_text_kiosk' => 'Teks berjalan di kios ambil antrian',
            'running_text_kamar' => 'Teks berjalan di informasi ketersediaan kamar',
            'dokterruangan' => 'Tampilkan dokter pemeriksa sesuai ruangan login',
            'tindakanruangan' => 'Tampilkan tindakan / pemeriksaan sesuai ruangan login',
            'tindakankelas' => 'Tampilkan tindakan / pemeriksaan sesuai kelas pelayanan pasien',
            'krngistokgizi' => 'Aktifkan proses penghitungan stok bahan gizi',
            'krngistokumum' => 'Aktifkan proses penghitungan stok umum',
            'persentasirujin' => 'Presentase tarif untuk rujukan instalasi / klinik lain',
            'persentasirujout' => 'Presentasi tarif untuk rujukan ke luar rumah sakit',
            'monitoringrefresh' => 'Refresh otomatis  monitoring di rekam medik interval detik',
            'monitoringpresensi' => 'Refresh penarikan data presensi dari alat fingerprint interval detik',
            'karcisbarulama' => 'Karcis pendaftaran pasien baru / lama dibedakan',
            'lamakonfbooking' => 'Batas jam paling lambat konfirmasi booking',
            'refreshnotifikasi' => 'Refresh ajax otomatis notifikasi & chat per detik jika tidak menggunakan node js',
            'jmldigitrm' => 'Jumlah nominal digit nomor rekamedis',
            'akomodasiotomatis' => 'Penghitungan akomodasi otomatis ketika pemeriksaan pasien rawat inap',
            'iskartudgntemplate' => 'Print kartu dengan template / gambar latar',
            'isbridging' => 'Mengaktifkan bridging BPJS',
            'tgltransaksimundur' => 'Tanggal transaksi bisa di mundurkan',
            'is_nodejsaktif' => 'Mengaktifkan node js',
            'is_telnetaktif' => 'Mengaktifkan telnet running text pemanggilan pasien klinik',
            'nodejs_host' => 'Host / alamat server node js',
            'nodejs_port' => 'Port server node js',
            'telnet_host' => 'Host / alamat server telnet',
            'telnet_port' => 'Port server telnet',
            'bpjs_host' => 'Host / alamat server bridging BPJS',
            'bpjs_port' => 'Port server bridging BPJS',
            'bpjs_uid' => 'Consumer ID yang diberikan BPJS untuk rumah sakit',
            'bpjs_secret' => 'Consumer Secret yang diberikan BPJS untuk rumah sakit',
            'jenissuaraantrian' => 'Jenis suara pemanggilan antrian',
            'mapdashboard' => 'Mengaktifkan google map di dashboard',
            'isbayarkekasirpenunjang' => 'Bayar pemeriksaan penunjang di kasir sebelum diperiksa',
            'isjurnalotomatis' => 'Jurnal rekening dilakukan otomatis dengan trigger',
            'ispostingotomatis' => 'Posting jurnal dilakukan otomatis dengan trigger. Ini hanya bisa aktif jika otomatis jurnal rekening aktif',
            'masaberlaku_pelamar_hr' => 'Masa berlaku pelamar',
            'nopendaftaran_apotik' => 'Karakter di depan nomor transaksi pendaftaran apotek',
            'pembulatanhargakasir' => 'Pembulatan total pembayaran di kasir',
            'jatuhtempoklaim' => 'Jangka waktu jatuh tempo klaim dari supplier',
            'jatuhtempotagihan' => 'Jangka waktu jatuh tempo tagihan yang harud dibayar ke supplier',
            'hl7broker_aktif' => 'HL-7 Broker Aktif / Non-aktif',
            'hl7broker_host' => 'Alamat IP / Host server HL-7 Broker',
            'hl7broker_port' => 'Port server HL-7 Broker',
            'delaytombolantrian' => 'Mengatur delay refresh tombol pada ambil tiket antrian di kiosk',
			'normlama_min' => 'Nomor Rekam Medik Lama (Dari) yang sudah di input ke table pasien_m',
            'normlama_maks' => 'Nomor Rekam Medik Lama (Sampai dengan) yang sudah di input ke table pasien_m',
			'email_aktif' => 'Email Aktif atau Tidak Aktif',
			'linkemail_aktifexp' => 'Mengatur Link Aktif Kedaluwarsa batas waktunya berdasarkan jam',
			'linkemail_resetexp' => 'Mengatur Link Reset Kedaluwarsa batas waktunya berdasarkan jam',
            'isonestopbilling' => 'One Stop Billing Pasien',
            'isstatuspulang_otomatis' => 'Status Pulang Otomatis',
            'bpjs_userkey' => 'User Key BPJS',
            'antreanonline_userkey' => 'User Key Antrean Online',
            'antreanonline_uid' => 'Consumer ID Antrean yang diberikan BPJS untuk rumah sakit',
            'antreanonline_secret' => 'Consumer Secret Antrean yang diberikan BPJS untuk rumah sakit',
            'nominal_tanggunganbpjs' => 'Nominal Tanggungan BPJS',
            'jasaoperator_id'=>'Komponen Jasa dr. Operator',
            'jasaasoperator_id'=>'Komponen Jasa Asisten Operator',
            'jasaanestesi_id'=>'Komponen Jasa dr. Anestesi',
            'jasaperanestesi_id'=>'Komponen Jasa Perawat Anestesi',
            'jasaperruangpulih_id'=>'Komponen Jasa Perawat Ruang Pulih',
            'jasaperinstrument_id'=>'Komponen Jasa Perawat Instrument',
            'jasapersirkuler_id'=>'Komponen Jasa Perawat Sirkuler',
            'tampilstokpenjualan'=>'Tampil Stok Obat Penjualan'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->konfigsystem_id)) {
            $criteria->addCondition('konfigsystem_id = ' . $this->konfigsystem_id);
        }
        $criteria->compare('isantrian', $this->isantrian);
        $criteria->compare('iskarcis', $this->iskarcis);
        $criteria->compare('printkartulsng', $this->printkartulsng);
        $criteria->compare('printkunjunganlsng', $this->printkunjunganlsng);
        $criteria->compare('nama_huruf_capital', $this->nama_huruf_capital);
        $criteria->compare('alamat_huruf_capital', $this->alamat_huruf_capital);
        $criteria->compare('LOWER(mr_lab)', strtolower($this->mr_lab), true);
        $criteria->compare('LOWER(mr_rad)', strtolower($this->mr_rad), true);
        $criteria->compare('LOWER(mr_ibs)', strtolower($this->mr_ibs), true);
        $criteria->compare('LOWER(mr_rehabmedis)', strtolower($this->mr_rehabmedis), true);
        $criteria->compare('LOWER(mr_apotik)', strtolower($this->mr_apotik), true);
        $criteria->compare('LOWER(mr_jenazah)', strtolower($this->mr_jenazah), true);
        $criteria->compare('LOWER(nopendaftaran_rj)', strtolower($this->nopendaftaran_rj), true);
        $criteria->compare('LOWER(nopendaftaran_ri)', strtolower($this->nopendaftaran_ri), true);
        $criteria->compare('LOWER(nopendaftaran_gd)', strtolower($this->nopendaftaran_gd), true);
        $criteria->compare('LOWER(nopendaftaran_lab)', strtolower($this->nopendaftaran_lab), true);
        $criteria->compare('LOWER(nopendaftaran_rad)', strtolower($this->nopendaftaran_rad), true);
        $criteria->compare('LOWER(nopendaftaran_ibs)', strtolower($this->nopendaftaran_ibs), true);
        $criteria->compare('LOWER(nopendaftaran_rehabmedis)', strtolower($this->nopendaftaran_rehabmedis), true);
        $criteria->compare('LOWER(nopendaftaran_jenazah)', strtolower($this->nopendaftaran_jenazah), true);
        $criteria->compare('LOWER(running_text_display)', strtolower($this->running_text_display), true);
        $criteria->compare('LOWER(running_text_kiosk)', strtolower($this->running_text_kiosk), true);
        $criteria->compare('dokterruangan', $this->dokterruangan);
        $criteria->compare('tindakanruangan', $this->tindakanruangan);
        $criteria->compare('tindakankelas', $this->tindakankelas);
        $criteria->compare('tgltransaksimundur', $this->tgltransaksimundur);
        $criteria->compare('krngistokgizi', $this->krngistokgizi);
        $criteria->compare('krngistokumum', $this->krngistokumum);
        $criteria->compare('persentasirujin', $this->persentasirujin);
        $criteria->compare('persentasirujout', $this->persentasirujout);
        if (!empty($this->monitoringrefresh)) {
            $criteria->addCondition('monitoringrefresh = ' . $this->monitoringrefresh);
        }
        $criteria->compare('isotomatispresensi', $this->isotomatispresensi);
        $criteria->compare('karcisbarulama', $this->karcisbarulama);
        if (!empty($this->lamakonfbooking)) {
            $criteria->addCondition('lamakonfbooking = ' . $this->lamakonfbooking);
        }
        if (!empty($this->jmldigitrm)) {
            $criteria->addCondition('jmldigitrm = ' . $this->jmldigitrm);
        }
        $criteria->compare('akomodasiotomatis', $this->akomodasiotomatis);
        $criteria->compare('iskartudgntemplate', $this->iskartudgntemplate);
        $criteria->compare('isbridging', $this->isbridging);
        $criteria->compare('LOWER(bpjs_host)', strtolower($this->bpjs_host), true);
        if (!empty($this->bpjs_port)) {
            $criteria->addCondition('bpjs_port = ' . $this->bpjs_port);
        }
        $criteria->compare('LOWER(nodejs_host)', strtolower($this->nodejs_host), true);
        if (!empty($this->nodejs_port)) {
            $criteria->addCondition('nodejs_port = ' . $this->nodejs_port);
        }
        $criteria->compare('is_nodejsaktif', $this->is_nodejsaktif);
        $criteria->compare('LOWER(telnet_host)', strtolower($this->telnet_host), true);
        if (!empty($this->telnet_port)) {
            $criteria->addCondition('telnet_port = ' . $this->telnet_port);
        }
        $criteria->compare('is_telnetaktif', $this->is_telnetaktif);
        $criteria->compare('LOWER(bpjs_uid)', strtolower($this->bpjs_uid), true);
        $criteria->compare('LOWER(antreanonline_uid)', strtolower($this->antreanonline_uid), true);
        $criteria->compare('LOWER(bpjs_secret)', strtolower($this->bpjs_secret), true);
        $criteria->compare('LOWER(antreanonline_secret)', strtolower($this->antreanonline_secret), true);
        $criteria->compare('LOWER(jenissuaraantrian)', strtolower($this->jenissuaraantrian), true);
        $criteria->compare('issmsgateway', $this->issmsgateway);
        $criteria->compare('mapdashboard', $this->mapdashboard);
        $criteria->compare('isbayarkekasirpenunjang', $this->isbayarkekasirpenunjang);
        $criteria->compare('isjurnalotomatis', $this->isjurnalotomatis);
        $criteria->compare('ispostingotomatis', $this->ispostingotomatis);
        if (!empty($this->masaberlaku_pelamar_hr)) {
            $criteria->addCondition('masaberlaku_pelamar_hr = ' . $this->masaberlaku_pelamar_hr);
        }
        $criteria->compare('LOWER(nopendaftaran_apotik)', strtolower($this->nopendaftaran_apotik), true);
        $criteria->compare('pembulatanhargakasir', $this->pembulatanhargakasir);
        if (!empty($this->jatuhtempoklaim)) {
            $criteria->addCondition('jatuhtempoklaim = ' . $this->jatuhtempoklaim);
        }
        if (!empty($this->jatuhtempotagihan)) {
            $criteria->addCondition('jatuhtempotagihan = ' . $this->jatuhtempotagihan);
        }
        $criteria->compare('hl7broker_aktif', $this->hl7broker_aktif);
        $criteria->compare('LOWER(hl7broker_host)', strtolower($this->hl7broker_host), true);
        $criteria->compare('LOWER(hl7broker_port)', strtolower($this->hl7broker_port), true);
        if (!empty($this->delaytombolantrian)) {
            $criteria->addCondition('delaytombolantrian = ' . $this->delaytombolantrian);
        }

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * digunakan untuk atribute tootip
     * @param type $attribute
     * @return type
     */
    public function getAttributeTooltip($attribute) {
        $labels = $this->attributeTooltips();
        if (isset($labels[$attribute]))
            return $labels[$attribute];
        else if (strpos($attribute, '.') !== false) {
            $segs = explode('.', $attribute);
            $name = array_pop($segs);
            $model = $this;
            foreach ($segs as $seg) {
                $relations = $model->getMetaData()->relations;
                if (isset($relations[$seg]))
                    $model = CActiveRecord::model($relations[$seg]->className);
                else
                    break;
            }
            return $model->getAttributeLabel($name);
        } else
            return $this->generateAttributeLabel($attribute);
    }

}

?>
