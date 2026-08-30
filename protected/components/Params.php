<?php

/**
 * Params berisi:
 * 1. Nilai default
 * 2. Nilai id yang di sesuaikan dengan tabel di database
 * 3. Nilai konstant
 * 4. Nilai konstant yang disesuaikan dengan lookup_m
 */
Class Params {

    // daftar akses menu approval keuangan
    const MENU_ID_BATAL_TINDAKAN = 4489;
    const MENU_ID_BATAL_VERIFIKASI = 4481;
    const MENU_ID_BATAL_ALOKASI = 4510;
    const MENU_ID_BATAL_PEMBAYARAN = 4512;
    const MENU_ID_PASIEN_RESEPTUR_TRIAGE = 4488;
    const MENU_ID_PASIEN_RESEPTUR_OK = 4547;

    const STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN = "SEDANG TINDAKAN";
    const REKENING5_ID_LABARUGI_BERJALAN = 149;
    const REKENING5_ID_LABARUGI_DITAHAN = 148;
    const DEFAULT_LOGO_TELEMEDIKA = 'https://telemedis..com'; //profilrumahsakit_m


    const METODE_TRIAGE_START ='start';
    const METODE_TRIAGE_ATS ='ats';
    const METODE_TRIAGE_ESI='esi';
    const METODE_TRIAGE_WPS='wpsss';
  
    const GAMBAR_TUBUH_ID_PEREMPUAN = 29;
    const GAMBAR_TUBUH_ID_LAKILAKI = 14;
	//koordinat
	const DEFAULT_PROFIL_LONGITUDE = -7.5428517;
	const DEFAULT_PROFIL_LATITUDE = 112.2412829;

    //kelompok umur
    const KELOMPOKUMUR_DEWASA = 3;   //nilai kelompok UMUR DEWASA
    const KELOMPOKUMUR_ANAK = 2; //NILAI KELOMPOK UMUR ANAK
    const KELOMPOKUMUR_BAYI = 5; //NILAI KELOMPOK UMUR BAYI
    const KELOMPOKUMUR_BARU_LAHIR = 6; //NILAI KELOMPOK BAYI BARU LAHIR
    const KELOMPOKUMUR_BALITA = 1; //NILAI KELOMPOK BALITA
    const KELOMPOKUMUR_LANSIA = 4; //NILAI KELOMPOK LANSIA

    const MODELANTRIAN_BPJS = 'A';

    //pegawai_id
    const PEGAWAI_ID_STRIP = 2;
    //google api
    const GOOGLE_API_KEY = 'AIzaSyApnaXyhVemu4B9MPJ_NbDwW07MZSNYhak';
    // icon default
    const ICON_MODUL = 'thumb.png';
    const ICON_PROFIL = 'thumb.png';
    const ICON_PROFIL_PEGAWAI = 'Avatar.png';
    const ICON_PROFIL_USER = 'Avatar.png';
    // DEFAULT CONST AUTHENTICATION
    const DEFAULT_UPDATE = 'Update';
    const DEFAULT_CREATE = 'Create';
    const DEFAULT_DELETE = 'Delete';
    const DEFAULT_ADMIN = 'Admin';
    const DEFAULT_PROFIL_RUMAH_SAKIT = 1; //profilrumahsakit_m
    const DEFAULT_PROFILKOPERASI = 1;
    const DEFAULT_RUANGAN_KIOSK = 2;           //pendaftaran rawat jalan
    const DEFAULT_RUANGAN_KIOSK_KASIR = 66;   //kasir sentral
    const DEFAULT_SESSION_INACTIVE = 1440;   //batas session (menit)
    const DEFAULT_KERTAS_UKURAN = 'A4';
    const DEFAULT_KERTAS_POSISI = 'P';
    const DEFAULT_KELASPELAYANAN_PENUNJANG = 6; //6 = Tanpa Kelas
    const DEFAULT_JENISKASUSPENYAKIT_PENUNJANG = 2; //2= Bedah
    const JENIS_KASUSPENYAKIT_ID_UMUM = 18;

    const MODELANTRIAN_UMUM_ANTRIAN = 1;

    const MODELANTRIAN_BPJS_ANTRIAN = 2;
    
    const JENIS_KASUSPENYAKIT_ID_MCU = 51; //dari master jeniskasuspenyakit_m
    const JENIS_KASUSPENYAKIT_ID_ANESTESI = 199; //dari master jeniskasuspenyakit_m
    const JENIS_KASUSPENYAKIT_ID_LAB_KLIINIK = 31; //dari master jeniskasuspenyakit_m

    const JENIS_KASUSPENYAKIT_ID_RD = 19; //dari master jeniskasuspenyakit_m

    const DEFAULT_WARGANEGARA = 'INDONESIA';
    const DEFAULT_AGAMA = 'ISLAM';
    const DEFAULT_PERDA_TARIF = 1;
    const DEFAULT_STATUS_OPERASI = 'RENCANA';
    const DEFAULT_KATEGORITINDAKAN_GIZI = 9; //ID KATEGORI TINDAKAN = MAKANAN GIZI;
    const DEFAULT_KELOMPOKTINDAKAN_GIZI = 23;
    const DEFAULT_PASIEN_APOTEK_UMUM = 0; //id pasien untuk apotek - penjualan umum NOREKAM: AP000002
    const DEFAULT_PASIEN_APOTEK_KARYAWAN = 1; //id pasien untuk apotek - penjualan karyawan NOREKAM: AP000003
    const DEFAULT_PASIEN_APOTEK_DOKTER = 1; //id pasien untuk apotek - penjualan dokter NOREKAM: AP000003
    const DEFAULT_PASIEN_APOTEK_UNIT = 5; //id pasien untuk apotek - penjualan unit NOREKAM: AP000005
    const DEFAULT_PASIEN_APOTEK_SOSIAL = 6; //id pasien untuk apotek - penjualan unit NOREKAM: AP000005
    const DEFAULT_PASIEN_AMBULAN_LUAR = 7; //id pasien untuk ambulan luar unit NOREKAM: AM000001
    const DEFAULT_PASIEN_AMBULAN_LUAR_RM = 'AM000001'; //id pasien untuk ambulan luar unit NOREKAM: AM000001
    const DEFAULT_SATUANBESAR_ID = 4; //4 = BOX
    const SATUAN_BESAR_BELUM_DI_SET = 110; //4 = BOX
    const DEFAULT_BAYARGAJIPEGAWAI_ID = 1; //untuk jurnal di keuangan-transaksi-pembayaran gaji karyawan
    const DEFAULT_KLAIMPIUTANG_ID = 64; //untuk jurnal di keuangan-transaksi-pembayaran klaim piutang
    //=== END DEFAULT ===
    //=== KONSTANTA ===
    //Merupakan konstanta yang diubah disesuaikan dengan data yang di database atau yang digunakan pada aplikasi tertentu
    
    const LOGINPEMAKAI_ID_ADMIN = 1; // loginpemakai_id admin
    const PERANPENGGUNA_ID_ADMIN = 1; // peranpengguna_k administrator
    const PERANPENGGUNA_ID_SUPPORT = 20; // peranpengguna_k asupport
    const DATE_FORMAT = 'dd M yy';      //format default date untuk datepicker
    const DATE_FORMATV2 = 'dd/mm/yy';
    const DATE_FORMATV3 = 'yy-mm-dd';
    const TIME_FORMAT = 'H:i:s';        //format default time untuk datepicker
    const TIME_FORMATV2 = 'dd/mm/yy H:i:s';
    const MONTH_FORMAT = 'M yy';  //format untuk monthpicker
    const TOOLTIP_PLACEMENT = 'top';                 //nilai konstanta tooltip placement untuk bootstrap tooltip
    const TOOLTIP_SELECTOR = 'a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]';        //nilai konstanta tooltip selector untuk bootstrap tooltip
    const SYARAT_CARABAYAR_TUNAI = 1;
    const SYARAT_CARABAYAR_KREDIT = 2;
    const CARABAYAR_ID_MEMBAYAR = 1;
    //const CARABAYAR_ID_TUNAI = 1;
    const CARABAYAR_ID_BPJS = 2;
    const CARABAYAR_ID_BPJS_TENAGAKERJA = 20;
    const CARABAYAR_ID_BADAK = 5;
    const CARABAYAR_ID_DEP_BADAK = 6;
    const CARABAYAR_ID_PEKERJA = 7;
    const CARABAYAR_ID_GRATIS = 8;
    // const CARABAYAR_ID_PERUSAHAAN = 9;
    const CARABAYAR_ID_PERUSAHAAN = 22;
    const CARABAYAR_ID_MANDIRI_PIUTANG = 24;
    const CARABAYAR_ID_JAMKESPA = 18;
    const CARABAYAR_ID_ASURANSI = 3;
    const CARABAYAR_ID_JAMKESDA = 18;
    // VERIFIKASI PROSEDUR
    const VERIFIKASI_DISETUJUI = 'Disetujui';
    const VERIFIKASI_DITOLAK = 'Ditolak';
    const VERIFIKASI_PENGAJUAN = 'PENGAJUAN';
    const VERIFIKASI_DRAFT = 'DRAFT';

    const PEKERJAAN_ID_TIDAK_BEKERJA = 13;
    const MODUL_ID_SISADMIN = 1;
    const MODUL_ID_PENDAFTARAN = 2;
    const MODUL_ID_RJ = 5;
    const MODUL_ID_RD = 6;
    const MODUL_ID_RI = 7;
    const MODUL_ID_PERSALINAN = 12;
    const MODUL_ID_LAB = 8;
    const MODUL_ID_RAD = 9;
    const MODUL_ID_APOTEK = 10;
    const MODUL_ID_BEDAHSENTRAL = 11;
    const MODUL_ID_REHABMEDIS = 78;
    const MODUL_ID_REKAMMEDIS = 4;
    const MODUL_ID_JENAZAH = 74;
    const MODUL_ID_GIZI = 15;
    const MODUL_ID_GUDANGFARMASI = 16;
    const MODUL_ID_GUDANGUMUM = 17;
    const MODUL_ID_AMBULANS = 73;
    const MODUL_ID_AKUNTANSI = 26;
    const MODUL_ID_KEUANGAN = 44;
    const MODUL_ID_PENGGAJIAN = 61;
    const MODUL_ID_KEPEGAWAIAN = 32;
    const MODUL_ID_LAUNDRY = 54;
    const MODUL_ID_BILLINGKASIR = 19;
    const MODUL_ID_MCU = 86;
    const MODUL_ID_HEMO = 85;
    const MODUL_ID_LAUNDRY_NOTIF = 70;
    const MODUL_ID_ANTRIAN = 76;
    const MODUL_ID_ANESTESI = 92;
    const MODUL_ID_ICU = 72;
    const MODUL_ID_INFORMASI = 3;  //modul Informasi
    const MODUL_ID_KIOS = 90;
    const MODUL_ID_PENGADAAN = 66;
    const MODUL_ID_TINDAKAN = 97;

    const MODUL_ID_HIDE = [self::MODUL_ID_RD, self::MODUL_ID_RI, self::MODUL_ID_ICU, self::MODUL_ID_RJ, self::MODUL_ID_TINDAKAN, self::MODUL_ID_HEMO, self::MODUL_ID_PERSALINAN, self::MODUL_ID_REHABMEDIS];
    
    const INSTALASI_ID_RI_ARR = [self::INSTALASI_ID_ICU, 4, 79, 38, 14, 85, 20, 100];
    const INSTALASI_ID_IGD = 3;
    const INSTALASI_ID_RM = 1;
    const INSTALASI_ID_RJ = 2;
    const INSTALASI_ID_RD = 3;
    const INSTALASI_ID_RI = 4;
    const INSTALASI_ID_KECANTIKAN = 30;
    const INSTALASI_ID_LAB = 5;
    const INSTALASI_ID_RAD = 6;
    const INSTALASI_ID_IBS = 7;
    const INSTALASI_ID_REHAB = 8;
    const INSTALASI_ID_FISIOTERAPI = 8;
    const INSTALASI_ID_FARMASI = 9;
    const INSTALASI_ID_GIZI = 10;
    const INSTALASI_ID_JZ = 17;
    const INSTALASI_ID_AMBULAN = 40; // Umum Penunjang. Sebelum : 40;
    const INSTALASI_ID_KASIR = 41; // instalasi keuangan
    const INSTALASI_ID_KASIR2 = 43; // instalasi kasir
    const INSTALASI_ID_LOGISTIK = 44;
    const INSTALASI_ID_ICU = 20;
    const INSTALASI_ID_PI= 20;
    const INSTALASI_ID_KEPEGAWAIAN = 26;
    const INSTALASI_ID_GUDANG_FARMASI= 58;
    const INSTALASI_ID_LAUNDRY= 24;
    const INSTALASI_ID_PERSALINAN = 38;
    const INSTALASI_ID_PERSALINAN2 = 38;
    const INSTALASI_ID_KEUANGAN= 43;
    const INSTALASI_ID_UMUM_PENUNJANG = 26;
    const INSTALASI_ID_MCU = 15;
    const INSTALASI_ID_APS = 15;    
    const INSTALASI_ID_PERAWATAN_INTENSIF = 20;
    const INSTALASI_ID_ANESTESI = 18;
    const INSTALASI_ID_BAGIAN_TU = 12;    
    const INSTALASI_ID_SISADMIN = 79;
    const INSTALASI_ID_HEMODIALISA = 83;
    const INSTALASI_ID_MCU2 = 82;
    const INSTALASI_ID_LAB_PA = 25;
    const INSTALASI_ID_BANK_DARAH = 5;
    const INSTALASI_ID_MIKROBIOLOGI = 17;    
    const INSTALASI_ID_TINDAKAN = 85;    
    const INSTALASI_ID_TINDAKAN2 = 4;    
    const INSTALASI_ID_TINDAKAN3 = 70;    
    const INSTALASI_ID_TINDAKAN4 = 79;    
    const INSTALASI_ID_TINDAKAN5 = 2;    
    const INSTALASI_ID_TINDAKAN6 = 14;
    const INSTALASI_ID_GIGI = 73;    
    const INSTALASI_ID_RAWAT_INAP_ARRAY = [4, 79, 38, 14];
    const KASUSDIAGNOSA_KASUS_LAMA = "KASUS LAMA";
    const KASUSDIAGNOSA_KASUS_BARU = "KASUS BARU";

    const HARGAYGDIGUNAKAN_PENYESUAIAN = 'PENYESUAIAN'; //lookup_m lookup_type = 'hargaygdigunakan'
    const HARGAYGDIGUNAKAN_MAX = 'MAKSIMUM'; //lookup_m lookup_type = 'hargaygdigunakan'
    const HARGAYGDIGUNAKAN_MIN = 'MINIMUM'; //lookup_m lookup_type = 'hargaygdigunakan'
    const HARGAYGDIGUNAKAN_AVG = 'RATA-RATA'; //lookup_m lookup_type = 'hargaygdigunakan'
    const HARGAYGDIGUNAKAN_TERAKHIR = 'TERAKHIR'; //lookup_m lookup_type = 'hargaygdigunakan'
    const INSTALASI_ID_LAB_MK = 96;

    const KOMPONENTARIF_ID_TOTAL = 6;
    const KOMPONENTARIF_ID_PELAYANAN = 24;
    const KOMPONENTARIF_ID_JASA_MEDIS = 5;
    const KOMPONENTARIF_ID_JASA_PEMBACA = 52;
    const KOMPONENTARIF_ID_JASA_PERUJUK = 31;
    const KOMPONENTARIF_ID_JASA_PENGIRIM = 51;
    const KOMPONENTARIF_ID_JASA_SOPIR = 57;
    const KOMPONENTARIF_ID_JASA_LAUNDRY = 55;
    const KOMPONENTARIF_ID_JASA_RADIOGRAFER = 46;
    const KOMPONENTARIF_ID_JASA_OPERATOR = 21; //jasa dokter operator
    const KOMPONENTARIF_ID_JASA_DOKTER_OPERATOR = 53; //jasa dokter operator
    const KOMPONENTARIF_ID_JASA_ASISTEN_OPERATOR = 23;
    const KOMPONENTARIF_ID_JASA_ASISTEN_OPERATOR_2 = 60;
    const KOMPONENTARIF_ID_JASA_PARAMEDIS = 2;
    const KOMPONENTARIF_ID_JASA_ANASTESI = 12; //jasa dokter anastersi
    const KOMPONENTARIF_ID_JASA_UMUM = 11; //jasa dokter umum
    const KOMPONENTARIF_ID_JASA_SPESIALIS = 10; //jasa dokter spesialis
    const KOMPONENTARIF_ID_JASA_DR_ANAK = 59; //jasa dokter anak
    const KOMPONENTARIF_ID_JASA_DR_TOLONG_BAYI = 65; //dokter penolong bayi
    const KOMPONENTARIF_ID_JASA_ASISTEN_ANASTESI = 13;
    const KOMPONENTARIF_ID_JASA_ONLOOP_1 = 54;
    const KOMPONENTARIF_ID_JASA_ONLOOP_2 = 61;
    const KOMPONENTARIF_ID_JASA_INSTRUMEN = 56;
    const KOMPONENTARIF_ID_JASA_RUMAH_SAKIT = 1;
    const KOMPONENTARIF_ID_JASA_KONSUL_GIZI = 7;
    const KOMPONENTARIF_ID_JASA_BIDAN_1 = 58;
    const KOMPONENTARIF_ID_JASA_BIDAN_2 = 64;
    const KOMPONENUNIT_ID_GIZI = 23; // komponenunit_id untuk konsultasi gizi
    const KOMPONENUNIT_ID_AMBULANS = 23;
    const KOMPONENUNIT_ID_MOBIL_JENAZAH = 1;//belum di set
    const KOMPONENUNIT_ID_MOBIL_TANPAGAWAT = 1;//belum di set
    const KOMPONENUNIT_ID_MOBIL_GAWAT = 1;//belum di set
    const KOMPONENUNIT_ID_MOBIL_VIP = 1;//belum di set
    const RUANGAN_ID_AMBULANCE = 64; // sebelum : 273;
    const RUANGAN_ID_APOTEK_1 = 59;
    
    const RUANGAN_ID_UPFRAJALUMUM = 237;
    const RUANGAN_ID_UPFRAJALJKN = 235;
    
    const RUANGAN_ID_USG_GRIU = 890;
    const RUANGAN_ID_XRAY_GRIU = 891;
    const RUANGAN_ID_APOTEK_RJ = 60;
    const RUANGAN_ID_BEDAH = 57;
    const RUANGAN_ID_OK_EMERGENCY = 59;
    const RUANGAN_ID_FISIOTERAPI = 272;
    const RUANGAN_ID_REHABMEDIS = 1065;

    const PATOLOGI_MIKROBIOLOGI_KLINIK = 'MIKROBIOLOGI KLINIK';
    const TIPE_ALAMAT_PPDS_IDENTITAS = "Identitas";
    const TIPE_ALAMAT_PPDS_TINGGAL = "Tinggal"; 

    const BAHAN_SPESIMEN_JENIS_PUS = "PUS"; 

    const RUANGAN_ID_GIZI = 62;
    const RUANGAN_ID_GUDANG_FARMASI = 58;
    const RUANGAN_ID_GUDANG_UMUM = 222; //purchasing
    const RUANGAN_ID_LOGISTIK = 269; //purchasing
    const RUANGAN_ID_PURCHASING = 222; //purchasing
    const RUANGAN_ID_KLINIK_MCU = 25;  //Ruangan Klinik MCU
    const RUANGAN_ID_LAB = 52;         //digunakan jika ruangan lab klinik & anatomi di non-aktifkan
    // const RUANGAN_ID_LAB_MIKROBIOLOGI = 495; //"Mikrobiologi klinik"
    const RUANGAN_ID_LAB_MIKROBIOLOGI = 1131; //"Mikrobiologi klinik"

    
    const JENISPEMERIKSAANLAB_KELOMPOK_MIKROBIOLOGI = 'MIKROBIOLOGI KLINIK';
        
    const RUANGAN_ID_LAB_KLINIK = 53;

    const RUANGAN_ID_LAB_PATOLOGI = 470;

    const RUANGAN_ID_LAB_ANATOMI = 470;
    const RUANGAN_ID_PERINATOLOGI = 237;
    const RUANGAN_ID_RAD = 56;
    const RUANGAN_ID_STERILISASI = 223;
    const RUANGAN_ID_LAUNDRY = 226;
    const RUANGAN_ID_LOKET_PENDAFTARAN = 2;
    const RUANGAN_ID_KASIR = 66;
    const RUANGAN_ID_LOKET = 2;
    const RUANGAN_ID_KEBIDANAN = 386;
    const RUANGAN_ID_KEBIDANAN_BPJS = 394;
    const RUANGAN_ID_FORENSIC = 283;
    const RUANGAN_ID_ANAK = 29;
    const RUANGAN_ID_PRIA = 27;
    const RUANGAN_ID_WANITA = 28;
    const RUANGAN_ID_ICU = 46;
    const RUANGAN_ID_VK = 75;
    const RUANGAN_ID_LANTAI_2 = 31;
    const RUANGAN_ID_LANTAI_3 = 30;
    const RUANGAN_ID_BERSALIN = 8;
    const RUANGAN_ID_KEPEGAWAIAN = 84;
    const RUANGAN_ID_KLAIM_KPS = 81;
    const RUANGAN_ID_KLAIM_BPJS = 80;
    const RUANGAN_ID_SIMRS = 1;
    const RUANGAN_ID_REKAM_MEDIS = 6;
    const RUANGAN_ID_REKAM_MEDIK = 1260;
    const RUANGAN_ID_POLIK_GIGI = 16;
    const RUANGAN_ID_PERAWATAN_DARURAT = 7;
    const RUANGAN_ID_VERLOS_KAMER = 246;
    const RUANGAN_ID_FINANCE = 79;
    const RUANGAN_ID_BENDAHARA = 75;
    const RUANGAN_ID_NURSE_STATION = 237;
    const RUANGAN_ID_FORENSIK = 283;
    const RUANGAN_ID_HEMO = 426;
    const RUANGAN_ID_HEMODIALISA = 426;
    const RUANGAN_TRANSFUSI_DARAH = 225;
    const RUANGAN_ID_INFORMASI = 364; // Ruangan Informasi
    const RUANGAN_ID_MCU = 25; // Ruangan MCU
    const RUANGAN_ID_NICU = 322;
    const RUANGAN_ID_BAYI_SAKIT = 376;
    const RUANGAN_ID_BAYI_SEHAT = 307;
    const RUANGAN_ID_AKUNTANSI = 77;
    const RUANGAN_ID_PENGGAJIAN = 290;
    const RUANGAN_ID_ANASTESI = 523;  //asal mula adalah 26
    const RUANGAN_ID_KMKP = 500;   
    const RUANGAN_ID_KEPERAWATAN_YANKES = '';
    const RUANGAN_ID_PERSALINAN = 246;
    const RUANGAN_ID_GIGI_UMUM = 460;
    const RUANGAN_ID_GIGI_ANAK = 458;
    const RUANGAN_ID_GIGI_KONSERVASI = 511;  
    const RUANGAN_ID_GIGI_LAKTASI = 8; 
    const RUANGAN_ID_GIGI_JIWA = 515;
    const RUANGAN_ID_GIGI_PSIKOLOG_ANAK = 315;
    const RUANGAN_ID_GIGI_PSIKOLOG_DEWASA = 516;
    const RUANGAN_ID_NURSESTATION = 9;    
    const RUANGAN_ID_BANK_DARAH = 312;
    const RUANGAN_ID_EMERGENCYCARE = 271;
    const RUANGAN_ID_KLINIK_ANASTESI = 523;
    const RUANGAN_ID_KEUANGAN = 577;
    const RUANGAN_ID_ROE_INAP = 1272;

    
    public static $ruangan_id_rehab = [];
    // 1252, 1253, 1255, 1254, 272
    public static function setRuangIdRehab($values) {
        self::$ruangan_id_rehab = array_merge(self::$ruangan_id_rehab, $values);
    }
    
    public static $RUANGAN_ID_TINDAKAN = [372, 70, 372, 364, 447, 451, 467, 452, 450, 448, 1238, 508, 940, 1236, 1235, 1234, 509, 272, 507];

    public static function setRuangIdTindakan($values) {
      self::$RUANGAN_ID_TINDAKAN = array_merge(self::$RUANGAN_ID_TINDAKAN, $values);
    }

    const KODEBPJS_ID_REHABMEDIK = "IRM";   

    const KELASPELAYANAN_ID_TANPA_KELAS = 6;
    const KELASPELAYANAN_ID_TANPA_KELAS_MCU = 6;
    const KELASPELAYANAN_ID_KELAS_III = 5;
    const KELASPELAYANAN_ID_KELAS_II = 4;
    const KELASPELAYANAN_ID_KELAS_I = 3;
    const KELASPELAYANAN_ID_SUPER_VIP = 25;
    const KELASPELAYANAN_ID_VIP = 2;
    const KELASPELAYANAN_ID_VIP_B = 27;
    const KELASPELAYANAN_ID_VVIP = 10;
    const KELASPELAYANAN_ID_EKSEKUTIF = 25;
    const PENJAMIN_ID_UMUM = 398;
    const PENJAMIN_ID_BPJS = 122;
    const PENJAMIN_ID_BPJS_KESEHATAN = 2;
    const PENJAMIN_ID_BPJS_KETENAGAKERJAAN = 3;
    const PENJAMIN_ID_PERUSAHAAN = 402;
    const PENJAMIN_ID_BANK_PAPUA = 397;
    const PENJAMIN_ID_INHEALTH = 4; //4
    const PENJAMIN_ID_GRATIS = 96;
    const PENJAMIN_ID_PISA = 34; // LNG-3
    const PENJAMIN_ID_PROKESPEN = 100; // LNG-3
    const PENJAMIN_ID_MANDIRI_PIUTANG = 904;

    const DAFTARTINDAKAN_ID_KONSUL = 101; //id untuk karcis tindakan konsul
    const DAFTARTINDAKAN_ID_KONSUL_SPESIALIS = 709; //id untuk karcis tindakan konsul
    const DAFTARTINDAKAN_ID_KONSUL_UMUM = 717; //id untuk karcis tindakan konsul
    const DAFTARTINDAKAN_ID_ASUHAN_KEPERAWATAN = 513;
    const DAFTARTINDAKAN_ID_VISITE_UMUM = 705;
    const DAFTARTINDAKAN_ID_VISITE_PERAWAT = 577;
    const DAFTARTINDAKAN_ID_PEMULASARAN_JENAZAH = 24;
    const WAKTU_KETERLAMBATAN_1 = 1; //untuk waktu keterlamatan datang dalam menit
    const WAKTU_KETERLAMBATAN_2 = 15; //untuk waktu keterlamatan datang dalam menit
    const JENISJURNAL_ID_PENERIMAAN_KAS = 1;
    const JENISJURNAL_ID_PENGELUARAN_KAS = 2;
    const JENISJURNAL_ID_PEMBELIAN = 3;
    const JENISJURNAL_ID_PELAYANAN = 4;
    const JENISJURNAL_ID_PENJUALAN = 5;
    const JENISJURNAL_ID_UMUM = 6;
    const JENISJURNAL_ID_PENYUSUTAN = 12;
    const JENISJURNAL_ID_REKONSILIASI_BANK = 11;
    const JENISJURNAL_ID_PERSEDIAAN = 14;
    const JENISJURNAL_ID_JURNALUMUM_TRANSAKSINONKAS = 13;
    //jenis jurnal umum
    const JENISJURNAL_ID_UMUM_TRANSFER = 5;
    const JENISJURNAL_ID_UMUM_PENYESUAIN = 6;
    const JENISJURNAL_ID_UMUM_KOREKSI = 7;
    const JENISJURNAL_ID_UMUM_BALIK = 8;
    const JENISJURNAL_ID_UMUM_PENUTUP = 9;
    const JENISJURNAL_ID_UMUM_PENGGABUNGAN = 10;
    // MDO
    const JENISJURNAL_ID_HUTANG = 3;
    const JENISJURNAL_ID_PIUTANG = 4;
    const JENISJURNAL_ID_TRANSFER = 5;
    const JENISJURNAL_ID_PENYESUAIAN = 6;
    const JENISJURNAL_ID_KOREKSI = 7;
    const JENISJURNAL_ID_BALIK = 8;
    const JENISJURNAL_ID_PENUTUP = 9;
    const JENISJURNAL_ID_PENGGABUNGAN = 10;
    const JENISJURNAL_ID_REKONSILIASI = 11;
    const JENISPENGELUARAN_ID_PENGGAJIAN = 1; //id untuk jenispengeluaran penggajian pegawai
    const JENISPENGELUARAN_ID_PENGEMBALIANUANGMUKA = 62; //id untuk jenispengeluaran pengeluaran kas
    const JENISPENGELUARAN_ID_PESANGON = 67; //id untuk jenispengeluaran pesangon pegawai
    const JENISPENGELUARAN_ID_PEMBAYARANJASA = 68; //id untuk jenispengeluaran pesangon pegawai
    const JENISPENGELUARAN_ID_PETTYCASH = 63;
    const JENISPENGELUARAN_ID_KASBON = 999;
    const JENISPENERIMAAN_ID_KASBON = 999;
    const JENISOBATALKES_ID_GASMEDIS = 11;
    const JENISOBATALKES_ID_NARKOTIKA = 42;
    const JENISOBATALKES_ID_PSIKOTROPIKA = 32;
    const JENISOBATALKES_ID_BHP = 4;
    const JENISOBATALKES_ID_ALKES = 1;
    const TIPE_KOMPONEN_GAJI_TUNJANGAN_TETAP = 'TUNJANGAN TETAP';
    const KOMPONENGAJI_ID_PINJAMAN = 9;
    const KOMPONENGAJI_ID_NATURA = 122;
    const CARAMASUK_ID_LANGSUNG_RI = 1;          //id untuk cara masuk langsung rawat inap
    const CARAMASUK_ID_RD = 2;          //id untuk cara masuk melalui rawat darurat
    const CARAMASUK_ID_RJ = 3;          //id untuk cara masuk melalui rawat jalan
    const TIPEPAKET_ID_NONPAKET = 1;       //id tipe paket non paket
    const TIPEPAKET_ID_LUARPAKET = 2;       //id tipe paket luar paket
    const PATOLOGI_KLINIK = 'PATOLOGI KLINIK';
    const PATOLOGI_ANATOMI = 'PATOLOGI ANATOMI';
    const JUMLAH_PERHALAMAN = 5;
    const RACIKAN_ID_RACIKAN = 1;
    const RACIKAN_ID_NONRACIKAN = 2;
    const SUPPLIER_JENIS_FARMASI = 'Farmasi';
    const SUPPLIER_JENIS_GIZI = 'Gizi';
    const SUPPLIER_JENIS_UMUM = 'Umum';
    const JENISSTOKOPNAME_PENYESUAIAN = 'Penyesuaian';
    const JENISSTOKOPNAME_STOK_AWAL = 'Stok Awal';
    const IP_FINGER_PRINT = '192.168.0.121';
    const KEY_FINGER_PRINT = '123';
    const KONFIG_FIFO = TRUE; //jika false = LIFO (Last In First Out)
    const ALIAS = ' alias ';
    const BAYAR_JASA_DOKTER_LUAR = 'rujukan';
    const BAYAR_JASA_DOKTER_RS = 'rs';

    /*
     * Konstanta Yang Disesuaikan dengan lookup_m
     * format params: LOOKUPTYPE_LOOKUPVALUE
     */
    const CARAKELUAR_DIRUJUK = 'DIRUJUK';  //disesuaikan dengan lookup_m.lookup_type = carakeluar
    const CARAKELUAR_RAWATINAP = 'DIRAWAT INAP'; //disesuaikan dengan lookup_m.lookup_type = carakeluar
    const CARAKELUAR_MENINGGAL = 'MENINGGAL'; //disesuaikan dengan lookup_m.lookup_type = carakeluar
    const CARAKELUAR_ID_DIPULANGKAN = 1;  //carakeluar_m
    const CARAKELUAR_ID_DIRUJUK = 2;  //carakeluar_m
    const CARAKELUAR_ID_PULANGPAKSA = 3;  //carakeluar_m
    const CARAKELUAR_ID_MENINGGAL = 4;  //carakeluar_m
    const CARAKELUAR_ID_RAWATINAP = 5;  //carakeluar_m
    const CARAKELUAR_ID_LAINLAIN = 6;  //carakeluar_m
    const CARAKELUAR_ID_MELARIKANDIRI = 7;  //carakeluar_m
    const CARAKELUAR_ID_PERMINTAANSENDIRI = 3;  //carakeluar_m
    const CARAPEMBAYARAN_TUNAI = "TUNAI"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
    const CARAPEMBAYARAN_CICILAN = "CICILAN"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
    const CARAPEMBAYARAN_HUTANG = "HUTANG"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
    const CARAPEMBAYARAN_PIUTANG = "PIUTANG"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
    const CARAPEMBAYARAN_KREDIT = "KREDIT";
    const CARAPEMBAYARAN_NONTUNAI = "NON TUNAI"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
    const CARAPEMBAYARAN_TRANSFER = "TRANSFER"; //disesuaikan dengan lookup_m.lookup_type = carapembayaran
    const STATUSBOOKING_NON_ANTRI = 'NON ANTRI'; //disesuaikan dengan lookup_m.lookup_type = statusbooking



    // status kirim hasil pemeriksaan radiologi
    const STATUSKIRIM_HASILRAD_SIAP_KIRIM = 'SIAP KIRIM';
    const STATUSKIRIM_HASILRAD_SEDANG_KIRIM = 'SEDANG KIRIM';
    const STATUSKIRIM_HASILRAD_SUDAH_DITERIMA = 'SUDAH DITERIMA';
    const STATUSKIRIM_HASILRAD_SUDAH_DIAMBIL = 'SUDAH DIAMBIL';

    const STATUSBOOKING_ANTRI = 'ANTRI'; //disesuaikan dengan lookup_m.lookup_type = statusbooking
    const KETERANGANKAMAR_DIPESAN = 'DIPESAN'; //disesuaikan dengan lookup_m.lookup_type = keterangankamar
    const KETERANGANKAMAR_TERSEDIA = 'TERSEDIA'; //disesuaikan dengan lookup_m.lookup_type = keterangankamar
    const KETERANGANKAMAR_DIGUNAKAN = 'DIGUNAKAN'; //disesuaikan dengan lookup_m.lookup_type = keterangankamar
    const KETERANGANKAMAR_RENCANA_PULANG = 'RENCANA PULANG'; //disesuaikan dengan lookup_m.lookup_type = keterangankamar
    const KETERANGANSLOT_DIPESAN = 'DIPESAN'; //disesuaikan dengan lookup_m.lookup_type = keterangan_slot
    const KETERANGANSLOT_TERSEDIA = 'TERSEDIA'; //disesuaikan dengan lookup_m.lookup_type = keterangan_slot
    const KETERANGANSLOT_DIGUNAKAN = 'DIGUNAKAN'; //disesuaikan dengan lookup_m.lookup_type = keterangan_slot
    const KETERANGANSLOT_RENCANA_PULANG = 'RENCANA PULANG'; //disesuaikan dengan lookup_m.lookup_type = keterangan_slot
    const STATUSPERIKSA_RUJUKAN = 'RUJUKAN'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
    const STATUSPERIKSA_ANTRIAN = 'ANTRIAN'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
    const STATUSPERIKSA_SEDANG_PERIKSA = 'SEDANG PERIKSA'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
    const STATUSPERIKSA_SEDANG_DIRAWATINAP = 'SEDANG DIRAWAT INAP'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
    const STATUSPERIKSA_BATAL_PERIKSA = 'BATAL PERIKSA'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
    const STATUSPERIKSA_SUDAH_DIPERIKSA = 'SUDAH DI PERIKSA'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
    const STATUSPERIKSA_SUDAH_PULANG = 'SUDAH PULANG'; //disesuaikan dengan lookup_m.lookup_type = statusperiksa
    const STATUSPERIKSA_NUNGGU_DAFTAR_SO = 'MENUNGGU ADMISI PASIEN'; //params statusperiksa_nunggu_daftar_so, diubah menjadi menunggu admisi pasien //
    const STATUSPERIKSA_DIRAWAT_INAP = 'DIRAWAT INAP';
    const STATUSPERIKSAHASIL_SUDAH = 'SUDAH'; //disesuaikan dengan lookup_m.lookup_type = statusperiksahasil
    const STATUSPERIKSAHASIL_BELUM = 'BELUM'; //disesuaikan dengan lookup_m.lookup_type = statusperiksahasil
    const STATUSPERIKSAHASIL_SEDANG = 'SEDANG'; //disesuaikan dengan lookup_m.lookup_type = statusperiksahasil
    const STATUSPERIKSABEDAH_RENCANA = 'RENCANA';
    const STATUSPERIKSABEDAH_SELESAI = 'SELESAI';
    const STATUSPERIKSABEDAH_MULAI = 'MULAI';
    const STATUS_BOOKING_ANTRI_ID = 210; //disesuaikan dengan lookup_m.lookup_ID = 210
    const STATUSPASIEN_BARU = "PENGUNJUNG BARU"; //disesuaikan dengan lookup_m.lookup_type = statuspasien
    const STATUSPASIEN_LAMA = "PENGUNJUNG LAMA"; //disesuaikan dengan lookup_m.lookup_type = statuspasien
    const STATUSPASIEN_BARU_ANTRIAN = "BARU"; // untuk antrian pasien baru
    const STATUSPASIEN_LAMA_ANTRIAN = "LAMA"; // untuk antrian pasien lama
    const STATUSKUNJUNGAN_BARU = "KUNJUNGAN BARU";
    const STATUSKUNJUNGAN_LAMA = "KUNJUNGAN LAMA";
    const STATUSMASUK_RUJUKAN = "RUJUKAN"; //disesuaikan dengan lookup_m.lookup_type = statusmasuk
    const STATUSMASUK_NONRUJUKAN = "NON RUJUKAN"; //disesuaikan dengan lookup_m.lookup_type = statusmasuk
    const STATUSREKAMMEDIS_AKTIF = 'AKTIF'; //disesuaikan dengan lookup_m.lookup_type = statusrekamedis
    const STATUSREKAMMEDIS_NON_AKTIF = 'NON AKTIF'; //disesuaikan dengan lookup_m.lookup_type = statusrekamedis
    const STATUSPESAN_BIASA = 'BIASA'; //disesuaikan dengan lookup_m.lookup_type = statuspesan
    const STATUSKONFIRMASI_SUDAH = 'SUDAH DIKONFIRMASI';
    const STATUSKONFIRMASI_BELUM = 'BELUM DIKONFIRMASI';
    const STATUSKONFIRMASI_BOOKING_SUDAH = 'SUDAH KONFIRMASI'; //disesuaikan dengan lookup_m.lookup_type = statuskonfirmasi
    const STATUSKONFIRMASI_BOOKING_BELUM = 'BELUM KONFIRMASI'; //disesuaikan dengan lookup_m.lookup_type = statuskonfirmasi
    const STATUSKONFIRMASI_BOOKING_BATAL = 'BATAL BOOKING'; //disesuaikan dengan lookup_m.lookup_type = statuskonfirmasi
    const STATUSBAYAR_LUNAS = 'LUNAS';
    const STATUSBAYAR_BELUM_LUNAS = 'BELUM LUNAS';
    const STATUS_POSTING_SUDAH = 'SUDAH POSTING';
    const STATUS_POSTING_BELUM = 'BELUM POSTING';
    const STATUS_KEPUASAN_PUAS = "PUAS";                //untuk msurveypelayanan_t.status_kepuasan
    const STATUS_KEPUASAN_TIDAK_PUAS = "TIDAK PUAS";    //untuk msurveypelayanan_t.status_kepuasan
    const JENISSURVEY_WEBSITE = "WEBSITE";  //untuk msurveypelayanan_t.jenissurvey
    const JENISSURVEY_MOBILE = "MOBILE";    //untuk msurveypelayanan_t.jenissurvey
    const JENISSURVEY_SIMRS = "SIMRS";      //untuk msurveypelayanan_t.jenissurvey
    const KONDISIPULANG_MENINGGAL_1 = 'MENINGGAL < 48 JAM'; //disesuaikan dengan lookup_m.lookup_type = kondisipulang
    const KONDISIPULANG_MENINGGAL_2 = 'MENINGGAL > 48 JAM'; //disesuaikan dengan lookup_m.lookup_type = kondisipulang
    const KONDISIPULANG_RAWATINAP = 'RAWAT INAP'; //disesuaikan dengan lookup_m.lookup_type = kondisipulang
    const KONDISIKELUAR_ID_MENINGGAL_1 = 3; //kondisikeluar_m
    const KONDISIKELUAR_ID_MENINGGAL_2 = 4; //kondisikeluar_m
    const KONDISIKELUAR_ID_RAWATINAP = 2; //kondisikeluar_m
    const KONDISIKELUAR_ID_TERKONTROL = 13; //kondisikeluar_m
    const JENIS_KELAMIN_PEREMPUAN = 'PEREMPUAN';    //disesuaikan dengan lookup_m.lookup_type = jeniskelamin
    const JENIS_KELAMIN_LAKI_LAKI = 'LAKI-LAKI';    //disesuaikan dengan lookup_m.lookup_type = jeniskelamin
    //jenis kendaraan
    const JENISKENDARAAN_MOBIL_JENAZAH = 'Mobil Jenazah';
    //jenisidentitas
    const JENIS_IDENTTITAS_KTP = 'KTP';    //disesuaikan dengan lookup_m.lookup_type = jeniskelamin
    const JENIS_IDENTITAS_KTP = "KTP";    //disesuaikan dengan lookup_m.lookup_type = jeniskelamin
    const JENIS_IDENTITAS_PASPOR = "PASPOR"; //disesuaikan dengan lookup_m.lookup_type = jenisidentitas
    const JENIS_IDENTITAS_LAINNYA = "LAINNYA"; //disesuaikan dengan lookup_m.lookup_type = jenisidentitas
    const JENIS_IDENTITAS_SIM = "SIM"; //disesuaikan dengan lookup_m.lookup_type = jenisidentitas
    //digunakan untuk rhesus
    const RHESUS_POSITIF = 'RH+'; //lookup_m (rhesus)
    const RHESUS_NEGATIF = 'RH-'; //lookup_m (rhesus)
    //nama depan
    const NAMA_DEPAN_BAYI = 'By. '; //diambil dari lookup_m dengan kondisi lookup_type='namadepan'
    const NAMA_DEPAN_NYONYA = 'Ny. '; //diambil dari lookup_m dengan kondisi lookup_type='namadepan'
    const NAMA_DEPAN_ANAK = 'An. '; //diambil dari lookup_m dengan kondisi lookup_type='namadepan'
    const NAMA_DEPAN_NONA = 'Nn. '; //diambil dari lookup_m dengan kondisi lookup_type='namadepan'
    const NAMA_DEPAN_TUAN = 'Tn. '; //diambil dari lookup_m dengan kondisi lookup_type='namadepan'
    const JENISSURAT_SEHAT = 10; //UNTUK JENIS SURAT SEHAT
    const JENISSURAT_SAKIT = 20; //UNTUK JENIS SURAT SEHAT
    const JENISSURAT_RUJUKAN = 21; //UNTUK JENIS SURAT SEHAT

    const KELOMPOKDIAGNOSA_UTAMA = 2;   //nilai diagnosa utama pada kelompok diagnosa
    const KELOMPOKDIAGNOSA_MASUK = 1;   //nilai diagnosa utama pada kelompok diagnosa
    const KELOMPOKDIAGNOSA_TAMBAH = 3;   //nilai diagnosa utama pada kelompok diagnosa

    const KELOMPOKPEGAWAI_ID_TENAGA_MEDIK = 1; //kelompokpegawai_m ahli gizi
    const KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN = 3; //kelompokpegawai_m ahli gizi

    const KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN = 3; //kelompokpegawai_m non keperawatan
    const KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN = 2; //kelompokpegawai_m tenaga keperawatan
    const KELOMPOKPEGAWAI_ID_AHLI_GIZI = 5; //kelompokpegawai_m ahli gizi 16
    const KELOMPOKPEGAWAI_ID_TENAGA_LAB = 18; //kelompokpegawai_m tenaga lab (analis lab)
    const KELOMPOKPEGAWAI_ID_TENAGA_RAD = 22; //kelompokpegawai_m tenaga rad (radiografer)
    const KELOMPOKPEGAWAI_ID_BIDAN = 20; //kelompokpegawai_m bidan
    const KELOMPOKPEGAWAI_ID_DOKTER_TETAP = 1; //kelompokpegawai_m ahli gizi
    const KELOMPOKPEGAWAI_ID_DOKTER_SPESIALIS = 20; //kelompokpegawai_m ahli gizi
    const KELOMPOKPEGAWAI_ID_DOKTER_GIGI = 19; //kelompokpegawai_m ahli gizi
    const KELOMPOKPEGAWAI_ID_DOKTER_UMUM = 21; //kelompokpegawai_m ahli gizi
    const KELOMPOKPEGAWAI_ID_DOKTER_PART_TIME = 24;
    const KELOMPOKPEGAWAI_ID_TENAGA_PELAYANAN_NON_MEDIS = 24;
    const KELOMPOKPEGAWAI_ID_KETERAPIAN_FISIK = 31; //kelompokpegawai_m KETERAPIAN FISIK
    const KELOMPOKPEGAWAI_ID_TENAGA_GIZI = 30; //kelompokpegawai_m TENAGA GIZI
    const KELOMPOKPEGAWAI_ID_APOTEKER = 26; //kelompokpegawai_m APOTEKER    
    const KELOMPOKPEGAWAI_ID_TERAPIWICARA = 29;
    const KELOMPOKPEGAWAI_ID_OKUPASITERAPI = 30;

    const KELOMPOKTINDAKAN_ID_GIZI	= 23; //kelompoktindakan_m gizi 24
    const KELOMPOKTINDAKAN_ID_RAD	= 9; //kelompoktindakan_m radiodiagnostik 10
    const KELOMPOKTINDAKAN_ID_LAB	= 24; //kelompoktindakan_m laboratorium 25
    const KELOMPOKTINDAKAN_ID_MCU	= 26; //kelompoktindakan_m mcu
    const KELOMPOKTINDAKAN_ID_AKOMODASI = 14;
    const KELOMPOKTINDAKAN_ID_AMBULANS = 7;
    const KELOMPOKTINDAKAN_ID_PEMULASARAN_JENAZAH	= 13; //kelompoktindakan_m pemulasaran jenazah
    const KELOMPOKTINDAKAN_ID_PELAYANANRAWATINAP	= 17; //kelompoktindakan_m pemulasaran jenazah

    const KELOMPOKKOMPONENTARIF_ID_MEDIS = 1;
    const KELOMPOKKOMPONENTARIF_ID_PARAMEDIS = 2;
    const KELOMPOKKOMPONENTARIF_ID_RS = 4;
    const KELOMPOKKOMPONENTARIF_ID_ADMIN = 3;
    const KELOMPOKKOMPONENTARIF_ID_BHP = 5;
    const SATUAN_TINDAKAN_PENDAFTARAN = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
    const SATUAN_TINDAKAN_VISITE = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
    const SATUAN_TINDAKAN_LABORATORIUM = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
    const SATUAN_TINDAKAN_REHAB_MEDIS = 'KALI';  //disesuaikan dengan lookup_m.lookup_type = satuantindakan
    const SATUAN_TINDAKAN_DARAH = 'KALI';
    const SATUAN_LAMARAWAT_RD = 'JAM';
    const SATUAN_LAMARAWAT_RI = 'HARI';
    const SATUAN_LAMARAWAT_RJ = 'HARI';
    const SATUAN_KECIL = 'SATUANKECIL';
    const SATUANJML_URT = "Buah"; //berdasarkan lookup_m.lookup_type = ukuranrumahtangga
    const LOOKUPTYPE_TRANSPORTASI = 'transportasi'; //tipe dari tabel lookup_m untuk transportasi
    const LOOKUPTYPE_KEADAAN_MASUK = 'keadaanmasuk'; //tipe dari tabel lookup_m untuk keadaan masuk
    const LOOKUPTYPE_KONDISI_PULANG = 'kondisipulang'; //tipe dari tabel lookup_m untuk kondisi pulang
    const LOOKUPTYPE_CARA_KELUAR = 'carakeluar'; //tipe dari tabel lookup_m untuk cara keluar
    const LOOKUPTYPE_JENISPEMERIKSAANLAB_KELOMPOK = 'jenispemeriksaanlab_kelompok';

    const LOOKUPTYPE_JENISPEMERIKSAANLAB_NAMA = 'jenispemeriksaanlab_nama';
    
    const LOOKUPTYPE_PEMERIKSAANLAB_NAMA = 'pemeriksaanlab_nama';
     //tipe dari tabel lookup_m untuk kelompok pemeriksaan lab
     const LOOKUPTYPE_JENISFORM = 'jenisform_nama';
    
     const LOOKUPTYPE_SATUAN_HASIL_LAB = 'satuanhasillab'; //tipe dari tabel lookup_m untuk satuan hasil lab
    const LOOKUPTYPE_STATUS_PERIKSA_HASIL = 'statusperiksahasil'; // tipe dari tabel lookup_m untuk status periksa hasil
    const LOOKUPTYPE_OBATALKES_KADAROBAT = 'obatalkes_kadarobat'; // tipe dari tabel lookup_m untuk status kadar obat
    const LOOKUPTYPE_DENYUTJANTUNG = 'denyutjantung'; // tipe dari tabel lookup_m untuk denyut jantung
    const LOOKUPTYPE_SATUAN_KELOMPOK_UMUR = 'satuankelumur'; //tipe dari tabel lookup_m untuk satuan kelompok umur
    const LOOKUPTYPE_SEDIAANOBATRACIKAN = 'sediaanobatracikan'; //tipe dari tabel lookup_m untuk sediaan obat racikan
    const LOOKUPTYPE_SIGNA_OA = 'signa_oa'; //tipe dari tabel lookup_m untuk signa obat
    const LOOKUPTYPE_JENIS_KELAMIN = 'jeniskelamin'; //tipe dari tabel lookup_m untuk jenis kelamin
    const LOOKUPTYPE_OBATALKES_KATEGORI = 'obatalkes_kategori';
    const LOOKUPTYPE_OBATALKES_GOLONGAN = 'obatalkes_golongan';
    const LOOKUPTYPE_KRU_BEDAH = 'krubedah';
    const LOOKUPTYPE_NILAI_UANG = 'nilaiuang';
    const LOOKUPTYPE_KRU_ANESTESI = 'kruanestesi';    

    const JENISPESANMENU_PASIEN = 'Pasien'; //disesuaikan dengan lookup_m.lookup_type = jenispesanmenu
    const JENISPESANMENU_PEGAWAI = 'Pegawai'; //disesuaikan dengan lookup_m.lookup_type = jenispesanmenu
    const JENISPESANMENU_PENDAMPING = 'Pendamping'; //disesuaikan dengan lookup_m.lookup_type = jenispesanmenu
    const JENISPENJUALAN_RESEP = "PENJUALAN RESEP"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
    const JENISPENJUALAN_RESEP_LUAR = "PENJUALAN RESEP LUAR"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
    const JENISPENJUALAN_BEBAS = "PENJUALAN BEBAS"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
    const JENISPENJUALAN_DOKTER = "PENJUALAN DOKTER"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
    const JENISPENJUALAN_KARYAWAN = "PENJUALAN PEGAWAI"; //disesuaikan dengan lookup_m.lookup_type = jenispenjualan
    const JENISPELAYANAN_RJ = 2; //di ambil dari lookup_m.lookup_type = jenispelayanan
    const JENISPELAYANAN_RI = 1; //di ambil dari lookup_m.lookup_type = jenispelayanan
    const OBATALKESPASIEN_BMHP = "BM"; //disesuaikan dengan lookup_m.lookup_type = 'jnspelayanan'
    const OBATALKESPASIEN_GOLONGAN_NARKOTIKA = "NARKOTIKA"; //disesuaikan dengan lookup_m.lookup_type = 'obatalkes_golongan'
    const OBATALKESPASIEN_GOLONGAN_PSIKOTROPIKA = "PSIKOTROPIKA"; //disesuaikan dengan lookup_m.lookup_type = 'obatalkes_golongan'
    const METODEANTRIAN_FIFO = "FIFO"; //disesuaikan dengan lookup_m.lookup_type = 'metodeantrian'
    const METODEANTRIAN_FEFO = "FEFO"; //disesuaikan dengan lookup_m.lookup_type = 'metodeantrian'
    const METODEANTRIAN_LIFO = "LIFO"; //disesuaikan dengan lookup_m.lookup_type = 'metodeantrian'
    const JENISTARIF_ID_PELAYANAN = 1; //dari jenistarif_m
    const JENISTARIF_ID_NONBPJS = 6; //dari jenistarif_m
    const JENISTARIF_ID_BPJS = 7; //dari jenistarif_m
    const KELMENU_ID_DASHBOARD = 62;
    //JENIS LAYAR ANTRIAN
    const LAYARANTRIAN_JENIS_POLIKLINIK = 'POLIKLINIK'; //disesuaikan dengan lookup_m.lookup_type = 'layarantrian_jenis'
    const LAYARANTRIAN_JENIS_PENUNJANG = 'PENUNJANG'; //disesuaikan dengan lookup_m.lookup_type = 'layarantrian_jenis'
    const LAYARANTRIAN_JENIS_KASIR = 'KASIR'; //disesuaikan dengan lookup_m.lookup_type = 'layarantrian_jenis'
    const STATUSOPERASI_SELESAI = 'SELESAI'; //disesuaikan dengan lookup_m.lookup_type = 'statusoperasi'
    const STATUSOPERASI_MULAI = 'MULAI'; //disesuaikan dengan lookup_m.lookup_type = 'statusoperasi'
    const STATUSOPERASI_RENCANA = 'RENCANA'; //disesuaikan dengan lookup_m.lookup_type = 'statusoperasi'
    const KETERANGANBATAL_BEDAH_SENTRAL = 'Batal Bedah Sentral'; //untuk filter pasienbatalperiksa_r.keterangan_batal
    // TUJUAN SMS (smsgateway_m.tujuansms)
    const TUJUANSMS_PASIEN = "pasien";
    const TUJUANSMS_DOKTER = "dokter";
    const TUJUANSMS_PENANGGUNGJAWAB = "penanggungjawab";
    const TUJUANSMS_SUPPLIER = "supplier";
    const TUJUANSMS_ASURANSI = "asuransi";
    const TUJUANSMS_PEMESAN = "pemesan";
    const TUJUANSMS_PEGAWAI = "pegawai";
    const TUJUANSMS_PEGAWAI_PEMESAN = "pegawaipemesan";
    const TUJUANSMS_PEGAWAI_PEMINJAM = "pegawaipeminjam";
    const TUJUANSMS_PEMOHON = "pemohon";
    //ID smsgateway static (smsgateway_m.smsgateway_id)
    const SMSGATEWAY_PEMBERITAHUAN_JANJI_POLIKLINIK_PASIEN = 130;
    const SMSGATEWAY_PEMBERITAHUAN_JANJI_POLIKLINIK_DOKTER = 131;
    const SMSGATEWAY_STATUS_KONFIMASI_PESAN_KAMAR = 132;
    const SMSGATEWAY_RENCANAKONTROL_PASIEN = 133;
    const SMSGATEWAY_RENCANAKONTROL_DOKTER = 134;
    const SMSGATEWAY_ULANGTAHUN_PASIEN = 135;
    const SMSGATEWAY_ULANGTAHUN_PEGAWAI = 136;
    const SMSGATEWAY_JATUHTEMPO_HUTANG = 156;
    const SMSGATEWAY_JATUHTEMPO_PINJAMAN = 157;
    const SMSGATEWAY_PASIENPULANG = 157;
    const KATEGORICATATAN_ID_AGENDA = 2; //disesuaikan dengan mkategoricatatan_m
    const KATEGORICATATAN_ID_UMUM = 1; //disesuaikan dengan mkategoricatatan_m
    const JENISPERAWATAN_PENCUCIAN = 'PENCUCIAN'; //disesuaikan dengan lookup_m.lookup_type = 'jenisperawatan'
    const JENISPERAWATAN_PERBAIKAN = 'PERBAIKAN'; //disesuaikan dengan lookup_m.lookup_type = 'jenisperawatan'
    const JENISPERAWATAN_PERAWATAN = 'PERAWATAN'; //disesuaikan dengan lookup_m.lookup_type = 'jenisperawatan'
    const JENISPERAWATAN_DEKONTAMINASI = 'DEKONTAMINASI'; //disesuaikan dengan lookup_m.lookup_type = 'jenisperawatan'
    const JENISPERAWATAN_KEHILANGAN = 'KEHILANGAN'; //disesuaikan dengan lookup_m.lookup_type = 'jenisperawatan'
    const STATUSPERAWATAN_SELESAI = 'SELESAI'; //disesuaikan dengan lookup_m.lookup_type = 'statusperawatan'
    const JENISKELOMPOK_OB = 'OB'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
    const JENISKELOMPOK_AL = 'AL'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
    const JENISKELOMPOK_GM = 'GM'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
    const JENISKELOMPOK_XY = 'XY'; //disesuaikan dengan lookup_m.lookup_type = 'jnskelompok'
    const REKENING1_LEN = 2;
    const REKENING2_LEN = 4;
    const REKENING3_LEN = 6;
    const REKENING4_LEN = 8;
    const REKENING5_LEN = 10;
    const REKENING1_BEBAN_PELAYANAN = 27;
    const REKENING1_BEBAN_UMUM = 28;
    const REKENING1_BEBAN_LAINNYA = 29;
    const STATUSKEHADIRAN_HADIR = 1;
    const STATUSKEHADIRAN_SAKIT = 2;
    const STATUSKEHADIRAN_IZIN = 3;
    const STATUSKEHADIRAN_DINAS = 4;
    const STATUSKEHADIRAN_ALPHA = 5;
    const STATUSKEHADIRAN_CUTI = 8;
    const STATUSKEHADIRAN_NAMA_HADIR = 'HADIR';
    const STATUSKEHADIRAN_NAMA_SAKIT = 'SAKIT';
    const STATUSKEHADIRAN_NAMA_IZIN = 'IZIN';
    const STATUSKEHADIRAN_NAMA_DINAS = 'DINAS';
    const STATUSKEHADIRAN_NAMA_ALPHA = 'ALPA';
    const STATUSKEHADIRAN_NAMA_CUTI = 'CUTI';
    const STATUSSCAN_MASUK = 1;
    const STATUSSCAN_PULANG = 2;
    const STATUSSCAN_DATANG = 4;
    const STATUSSCAN_KELUAR = 3;
    const STATUSSCAN_TIDAKTAHU = 5;
    const SURAT_KETERANGAN_KONTROL = 2;
    const SURAT_KETERANGAN_KEMATIAN = 3;
    const SURAT_KETERANGAN_KESEHATAN_JIWA = 57; //belum ada di master data, harus disesuaikan lagi dengan master RS
    const SURAT_KETERANGAN_KELAYAKAN_COVID19 = 57;
    const SURAT_KETERANGAN = 59;
    const SURAT_PERSETUJUAN_PERSETUJUAN = 'PERSETUJUAN';
    const SURAT_PERSETUJUAN_PENOLAKAN = 'PENOLAKAN';
    const PENDIDIKAN_S1 = 8;
    const SHIFT_PAGI = 1;
    const DEFAULT_JENISINVENTARISASI = 'Penyesuaian';
    const DEFAULT_JENISINVENTARISASI_STOKAWAL = 'Stok Awal';
    const ASALRUJUKAN_ID_RS = 4;
    const RUJUKANDARI_ID_ABE = 1811;
    const GOLONGAN_UMUR_DEWASA = 3; // 25-44th
    const GOLONGAN_UMUR_ORANG_TUA = 4; // 45-64th
    const GOLONGAN_UMUR_MANULA = 5; // 65+th
    const GOLONGAN_UMUR_BARU_LAHIR = 6; // 0<28hr
    const GOLONGAN_UMUR_BAYI = 7; // 28hr>1th
    const GOLONGAN_UMUR_ANAK_ANAK = 1; // 5-14th
    const GOLONGAN_UMUR_REMAJA = 2; // 15-24th
    const GOLONGAN_UMUR_BALITA = 8; // 1-5thn
    const ID_SIMPANAN_POKOK = 1;
    const ID_SIMPANAN_WAJIB = 2;
    const ID_SIMPANAN_SUKARELA = 3;
    const ID_SIMPANAN_DEPOSITO = 4;
    const ID_SIMPANAN_JASA_SUKARELA = 5;
    const TIPE_PENGHAAPUSAN_PENJUALAN = 'penjualan';
    const STATUS_PERKAWINAN_KAWIN = 'KAWIN'; //mengikuti data lookup_m dari lookup_type = 'statusperkawinan'
    const STATUS_PERKAWINAN_TIDAK_KAWIN = 'TIDAK KAWIN'; //mengikuti data lookup_m dari lookup_type = 'statusperkawinan'
    const STATUS_PERKAWINAN_NIKAH = 'NIKAH'; //mengikuti data lookup_m dari lookup_type = 'statusperkawinan'
    //status pengiriman obat alkes
    const STATUS_PENGIRIMANOA_PENDING = 'PENDING';
    const STATUS_PENGIRIMANOA_IN_PROGRESS = 'IN PROGRESS';
    // const STATUS_PENGIRIMANOA_READY = 'READY';
    const STATUS_PENGIRIMANOA_READY = 'DONE';
    //status terima oa
    const STATUS_TERIMAOA_DISETUJUI = 'DISETUJUI';
    const STATUS_TERIMAOA_DITOLAK = 'DITOLAK';
    const STATUS_TERIMAOA_DITUNDA = 'DITUNDA';
    //status pengajuan anggaran operasional
    const STATUS_PETTY_CASH_PENGAJUAN = 'PENGAJUAN';
    const STATUS_PETTY_CASH_DISETUJUI = 'DISETUJUI';
    const STATUS_PETTY_CASH_DITOLAK = 'DITOLAK';

    // golongan indikator
    const GOLONGAN_INDIKATOR_PERILAKU = 'PERILAKU';
    const GOLONGAN_INDIKATOR_PERTUMBUHAN_PROFESI = 'PERTUMBUHAN PROFESI';
    const GOLONGAN_INDIKATOR_CLINICAL_RESULT = 'CLINICAL RESULT';

    //status Abnormal Absen
    const STATUS_ABNORMALABSEN_DISETUJUI = 'Disetujui';
    const STATUS_ABNORMALABSEN_DITOLAK = 'Ditolak';

    //params demam berdarah
    const DAFTARTINDAKAN_ID_IGG = 3878;
    const DAFTARTINDAKAN_ID_IGM = 3964;
    //koperasi
    const JENISSIMPANAN_ID_DEPOSITO = 4;
    //prefix pendaftaran
    const PREFIX_RAWAT_JALAN = 'RJ';
    const PREFIX_RAWAT_INAP = 'RI';
    const PREFIX_RAWAT_DARURAT = 'RD';
    const PREFIX_LABORATORIUM = 'LB';
    const PREFIX_RADIOLOGI = 'RO';
    const PREFIX_BEDAH_SENTRAL = 'BS';
    const PREFIX_REHAB_MEDIS = 'RM';
    const PREFIX_PEMULASARAN_JEN = 'PJ';
    const PREFIX_APOTIK = 'AP';
    const PREFIX_MCU = 'MC';
    //kategori pegawai
    const KATEGORI_PEGAWAI_TETAP = 'PEGAWAI TETAP'; //disesuaikan dengan lookup_m (lookup_type = ''kategoripegawai )
    const KATEGORI_PEGAWAI_TIDAK_TETAP = 'PEGAWAI TIDAK TETAP'; //disesuaikan dengan mkategoricatatan_m
    const KATEGORI_PEGAWAI_KONTRAK = 'KONTRAK'; //disesuaikan dengan mkategoricatatan_m
    const KATEGORI_PEGAWAI_HARIAN = 'HARIAN'; //disesuaikan dengan mkategoricatatan_m
    //konfigurasi email
    //tipe kirim
    const KONFIG_EMAIL_TIPE_KIRIM_SMTP = 'SMTP'; // diambil dari lookup_type = 'email_sendtype'
    const KONFIG_EMAIL_TIPE_KIRIM_GMAIL = 'GMAIL API'; // diambil dari lookup_type = 'email_sendtype'
    //tipe email oauth
    const KONFIG_EMAIL_OAUTH = 'XOAUTH2';
    //===   END KONSTANTA ===
    //digunakan pada surat keterangan lahir - Jenis Kelahiran
    const JENIS_KELAHIRAN_TUNGGAL = 'TUNGGAL';
    const JENIS_KELAHIRAN_KEMBAR2 = 'KEMBAR 2';
    const JENIS_KELAHIRAN_KEMBAR3 = 'KEMBAR 3';
    const JENIS_KELAHIRAN_LAINNYA = 'LAINNYA';
    //digunakan pada surat keterangan berabda sehat
    const SURAT_KETERANGAN_FISIK_SEHAT = 'SEHAT';
    const SURAT_KETERANGAN_FISIK_TIDAK_SEHAT = 'TIDAK SEHAT';
    //digunakan pada surat keterangan tindakan sedasi
    const JENISSURAT_NAMA_PERSETUJUAN_SEDASI = 'PERSETUJUAN TINDAKAN SEDASI';
    const JENISSURAT_NAMA_PENOLAKAN_SEDASI = 'PENOLAKAN TINDAKAN SEDASI';
    //digunakan pada surat keterangan berabda sehat
    const SURAT_KETERANGAN_KELAYAKAN_KERJA_LAYAK = 'LAYAK';
    const SURAT_KETERANGAN_KELAYAKAN_KERJA_TIDAK = 'TIDAK LAYAK';
    //digunakan pada surat keterangan kesehatan jiwa
    const SURAT_KETERANGAN_KESEHATAN_JIWA_MEMENUHI = 'MEMENUHI';
    const SURAT_KETERANGAN_KESEHATAN_JIWA_TIDAK = 'TIDAK MEMENUHI';
    //jabatan_id
    const JABATAN_ID_DIREKTUR = 1;
    const JABATAN_ID_DIREKTUR_RS = 92;
    const JABATAN_ID_KASI_PERSONALIA = 71;
    const JABATAN_ID_MANAGER = 91;
    const JABATAN_ID_KA_BAG_ADMIN_UMUM = 83;
    const JABATAN_ID_BIDAN = 30;
    const JABATAN_ID_DOKTER_UMUM = 23;
    const JABATAN_ID_DOKTER_SPESIALIS = 29;
    const JABATAN_ID_KONSULTAN_GIZI = 78;
    const JABATAN_ID_RADIOGRAPHER = 37;
    const JABATAN_ID_ADMIN_KEPEGAWAIAN = 76;
    const JABATAN_ID_HUMAN_RESOURCES = 131;
    //penanggung jawab
    const JABATAN_ID_PJI_FARMASI = 63;
    const JABATAN_ID_PJI_BEDAH = 58;
    const JABATAN_ID_PJI_RI = 59;
    const JABATAN_ID_PJI_RJ = 60;
    const JABATAN_ID_PJI_RD = 62;
    const JABATAN_ID_PJI_PIUTANG = 64;
    const JABATAN_ID_PJI_SECURITY = 65;
    const JABATAN_ID_PJI_PERSALINAN = 85;
    const JABATAN_ID_PJI_LAB = 86;
    const JABATAN_ID_PJI_GIZI = 87;
    const JABATAN_ID_APOTEKER = 193;
    const JABATAN_ID_KEPALA_APOTEKER = 168;
    const JABATAN_ID_FISIOTERAPI = 42;
    const JABATAN_ID_KEPALA_FISIOTERAPI = 201;
    //hidden harga dan arif
    const HIDDEN_HARGA = 'hidden';
    const HIDDEN_GRID_HARGA = FALSE; // digunakan pada grid view, param visible
    //pemeriksaan radiologi
    const PEMERIKSAAN_RAD_UPPER_LOWER_ABDOMEN = 60; //usg
    const PEMERIKSAAN_RAD_UPPER_LOWER = 59; //usg
    const PEMERIKSAAN_RAD_UROLOGI = 64; //usg
    const PEMERIKSAAN_RAD_THORAX_PA = 44; //foto

    //module laborarotium
    const TAMBAH_DIAGNOSA = FALSE; //usg

    //status pemakaian obat
    const STATUS_OBAT_TERPAKAI_FAST = 'FAST MOVING';
    const STATUS_OBAT_TERPAKAI_SLOW = 'SLOW MOVING';
    const STATUS_OBAT_TERPAKAI_MIDDLE = 'MIDDLE MOVING';
    const STATUS_OBAT_TERPAKAI_STUCK = 'STUCK';
    //kategori pengajuan petty cash
    const KATEGORI_PETTYCASH_MEDIS = 'MEDIS';
    const KATEGORI_PETTYCASH_NONMEDIS = 'NON MEDIS';
    //input type
    const INPUTTYPE_TEXT = 'TEXT';
    const INPUTTYPE_TEXTAREA = 'TEXTAREA';
    const INPUTTYPE_RADIO = 'RADIO';
    const INPUTTYPE_CHECK = 'CHECKBOX';
    const INPUTTYPE_DATE = 'DATE';
    //Loket M
    const LOKET_ID_UMUM = 14;
    const LOKET_ID_ASURANSI = 16;
    const LOKET_ID_BPJS = 15;
    //Rekening Column
    const REKENINGCOLUMN_PEMBAYARANJASAMEDIS = "pembayaranjasa_t";
    const REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_LAINLAIN = 63;
    const REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_STP = 65;
    const REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_YMH = 64;
    const REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_PPH21 = 66;
    const REKENINGCOLUMN_TABLE_FAKTURDETAILT = "fakturdetail_t";
    const REKENINGCOLUMN_COLUMN_OBATALKESID = "obatalkes_id";
    const REKENINGCOLUMN_ID_BAYARKESUPPLIER = 57;
    const REKENINGCOLUMN_TABLE_TERIMAPERSDETAILT = "terimapersdetail_t";
    const REKENINGCOLUMN_COLUMN_BARANGID = "barang_id";
    const REKENINGCOLUMN_TABLE_TERIMABAHANDETAILT = "terimabahandetail_t";
    const REKENINGCOLUMN_COLUMN_TERIMABAHANDETAILID = "terimabahandetail_id";
    const REKENINGCOLUMN_TABLE_TERIMAPERSEDIAANT = "terimapersediaan_t";
    const REKENINGCOLUMN_COLUMN_PAJAKPPH = "pajakpph";
    const REKENINGCOLUMN_COLUMN_PERSENPPHFAKTUR = "persenpphfaktur";
    const REKENINGCOLUMN_TABLE_TERIMABAHANMAKANT = "terimabahanmakan_t";
    const REKENINGCOLUMN_COLUMN_PERSENPPH = "persenpph";
    const REKENINGCOLUMN_TABLE_TANDABUKTIKELUART = "tandabuktikeluar_t";
    const REKENINGCOLUMN_COLUMN_BIAYAONGKOSKIRIM = "biayaongkos_kirim";
    const REKENINGCOLUMN_COLUMN_BIAYAADMINISTRASI = "biayaadministrasi";
    const REKENINGCOLUMN_TABLE_RETPENDETAILT = "retpendetail_t";
    const REKENINGCOLUMN_COLUMN_JMLPPN = "jmlppn";
    const REKENINGCOLUMN_COLUMN_JMLPPH = "jmlpph";
    const REKENINGCOLUMN_TABLE_RETURDETAILT = "returdetail_t";
    const REKENINGCOLUMN_COLUMN_HARGAPPNRETUR = "hargappnretur";
    const REKENINGCOLUMN_COLUMN_HARGAPPHRETUR = "hargapphretur";
    const REKENINGCOLUMN_TABLE_RETURPENBAHANMAKANDETAILT = "returpenbahanmakandetail_t";
    const REKENINGCOLUMN_COLUMN_RETURBAHANMAKANID = "returbahanmakan_id";
    const REKENINGCOLUMN_COLUMN_RETURBAHANDETAILID = "terimabahandetail_id";
    const REKENINGCOLUMN_TABLE_PENERIMAANUMUMT = "penerimaanumum_t";
    const REKENINGCOLUMN_COLUMN_PENUM_JMLPPN = "ppn";
    const REKENINGCOLUMN_COLUMN_JMLPPH21 = "jmlpph_21";
    const REKENINGCOLUMN_COLUMN_JMLPPH22 = "jmlpph_22";
    const REKENINGCOLUMN_COLUMN_JMLPPH23 = "jmlpph_23";
    const REKENINGCOLUMN_COLUMN_PENERIMAANUMUMID = "penerimaanumum_id";
    const REKENINGCOLUMN_COLUMN_NOPENERIMAAN = "nopenerimaan";
    const REKENINGCOLUMN_COLUMN_JLMUANGMUKABELI = "jlmuangmukabeli";
    const REKENINGCOLUMN_TABLE_UANGMUKABELIT = "uangmukabeli_t";
    const REKENINGCOLUMN_COLUMN_JUMLAHUANG = "jumlahuang";
    const REKENINGCOLUMN_COLUMN_TANDABUKTI_BIAYAADMINISTRASI = "tandabukti_biayaadministrasi";
    const REKENINGCOLUMN_COLUMN_BIAYAMATERAI = "biaya_materai";
    const REKENINGCOLUMN_COLUMN_BIAYAMATERAIBAYAR = "biayamaterai";
    const REKENINGCOLUMN_TABLE_FAKTURPEMBELIANT = "fakturpembelian_t";
    const REKENINGCOLUMN_COLUMN_JMLUANGMUKABELI = "jmluangmukabeli";
    const REKENINGCOLUMN_TABLE_PENGGAJIANPEGT = "penggajianpeg_t";
    const REKENINGCOLUMN_COLUMN_PENGGAJIANPEG_BPJSKETENAGAKERJA = "penggajianpeg_bpjsketenagakerja";
    const REKENINGCOLUMN_COLUMN_PENGGAJIANPEG_BPJSKESEHATAN = "penggajianpeg_bpjskesehatan";
    const REKENINGCOLUMN_COLUMN_PENGGAJIANPEG_JAMSOSTEK = "penggajianpeg_jamsostek";
    const REKENINGCOLUMN_TABLE_PEMBAYARANJASAT = "pembayaranjasa_t";
    const REKENINGCOLUMN_COLUMN_TOTALBAYARJASA = "totalbayarjasa";
    const REKENINGCOLUMN_COLUMN_TOTALPAJAK = "total_pajak";
    const REKENINGCOLUMN_TABLE_SETORANPAJAKT = "setoranpajak_t";
    const REKENINGCOLUMN_COLUMN_SETORANPAJAKPPH = "setoranpajak_pph";
    const REKENINGCOLUMN_COLUMN_SETORANPAJAKBPJSTK = "setoranpajak_bpjstk";
    const REKENINGCOLUMN_COLUMN_SETORANPAJAKBPJSKS = "setoranpajak_bpjsks";
    const REKENINGCOLUMN_COLUMN_SETORANPAJAKPPN = "setoranpajak_ppn";
    const REKENINGCOLUMN_TABLE_TANDABUKTIBAYART = "tandabuktibayar_t";
    const REKENINGCOLUMN_COLUMN_TANDABUKTIBAYARCASH = "tandabuktibayar_cash";
    const REKENINGCOLUMN_COLUMN_JMLPEMBULATANBAYAR = "jmlpembulatan";
    const REKENINGCOLUMN_TABLE_REKENING5M = "rekening5_m";
    const REKENINGCOLUMN_COLUMN_REKENINGKOSONGDEBIT = "rekening5_kosongdebit";
    const REKENINGCOLUMN_COLUMN_REKENINGKOSONGKREDIT = "rekening5_kosongkredit";
    const REKENINGCOLUMN_COLUMN_JMLDISCOUNT = "jmldiscount";

    const JENISSETORAN_PPHPEGAWAI = "Setoran Hutang PPh 21 Pegawai";
    const JENISSETORAN_PPHJASADOKTER = "Setoran Hutang PPh 21 Jasa Dokter";
    const JENISSETORAN_BPJSTK = "Setoran Hutang BPJS Ketenagakerjaan";
    const JENISSETORAN_PPHPEMBELIAN = "Setoran Hutang PPh Pembelian";
    const JENISSETORAN_BPJSKS = "Setoran Hutang BPJS Kesehatan";
    const JENISSETORAN_PENGELUARANKAS = "Setoran Hutang PPh Pengeluaran Kas";

    const REKENINGCOLUMN_TABLE_PEMBAYARKLAIMT = "pembayarklaim_t";
    const REKENINGCOLUMN_COLUMN_JMLPIUTANGTAKTERTAGIH = "jmlpiutangtaktertagih";
    const REKENINGCOLUMN_TABLE_PENGBONUSTHRDETAILT = "pengbonusthrdetail_t";
    const REKENINGCOLUMN_COLUMN_TOTALTHR = "totalthr";
    const REKENINGCOLUMN_COLUMN_TUNJANGANPPH21THR = "tunjangan_pph_21_thr";
    const REKENINGCOLUMN_COLUMN_THPTHR = "thp_thr";
    const REKENINGCOLUMN_COLUMN_THPBONUS = "thp_bonus";
    const REKENINGCOLUMN_TABLE_PEMBBONUSTHRT = "pembbonusthr_t";
    const REKENINGCOLUMN_COLUMN_TOTALHUTANGTHR = "totalhutang_thr";
    const REKENINGCOLUMN_COLUMN_TOTALHUTANGBONUS = "totalhutang_bonus";


    const REKENINGCOLUMN_ID_KASBONPEGAWAI = 35;
    const REKENINGCOLUMN_ID_BIAYAADMINISTRASI = 215;

    const REKENINGCOLUMN_TABLE_PEMBATALANUANGMUKAT = "pembatalanuangmuka_t";
    const REKENINGCOLUMN_COLUMN_PEMBATALANUANGMUKAID = "pembatalanuangmuka_id";

    const REKENINGCOLUMN_TABLE_BUKUBESART = "bukubesar_t";
    const REKENINGCOLUMN_COLUMN_BUKUBESARLABARUGITAHUNBERJALAN = "bukubesar_labarugi";
    

    const STATUS_HD_TIDAK_SELESAI = 'TIDAK SELESAI';

    const REKENINGCOLUMN_TABLE_TINDAKANPELAYANANT = "tindakanpelayanan_t";
    const REKENINGCOLUMN_COLUMN_DISCOUNTTINDAKAN = "discount_tindakan";
    /**
     * @author Yusuf Putra Anugrah <yusufputra@.com>
     * digunakan untuk format kertas f4 untuk pdf
     */
    //const KERTAS_F4 = array(210,330); tidak digunakan untuk array digunakan pakai fungsi
    /**
     * @author Yusuf Putra Anugrah <yusufputra@.com>
     * digunakan untuk format kertas f4 untuk print all
     */
    const width_F4 = 210;
    const height_F4 = 330;
    const WIDTH_A4 = 210;
    const HEIGHT_A4 = 297;

    /* Hardcode prefix pendaftaran */

    public static function getPrefixNoPendaftaran() {
        return array(
            Params::PREFIX_RAWAT_JALAN => Params::PREFIX_RAWAT_JALAN,
            Params::PREFIX_RAWAT_INAP => Params::PREFIX_RAWAT_INAP,
            Params::PREFIX_RAWAT_DARURAT => Params::PREFIX_RAWAT_DARURAT,
            Params::PREFIX_LABORATORIUM => Params::PREFIX_LABORATORIUM,
            Params::PREFIX_RADIOLOGI => Params::PREFIX_RADIOLOGI,
            Params::PREFIX_BEDAH_SENTRAL => Params::PREFIX_BEDAH_SENTRAL,
            Params::PREFIX_REHAB_MEDIS => Params::PREFIX_REHAB_MEDIS,
            Params::PREFIX_APOTIK => Params::PREFIX_APOTIK,
            Params::PREFIX_MCU => Params::PREFIX_MCU,
        );
    }

    //statusoa
    const OA_STATUS_DIGUNAKAN = 'DIGUNAKAN'; //lookup_m, dengan lookup_type(statusoa)
    const OA_STATUS_RUSAK = 'RUSAK'; //lookup_m, dengan lookup_type(statusoa)
    //pengantar penanggung jawab
    const PENGANTAR_DIRI_SENDIRI = 'DIRI SENDIRI';
    const PENGANTAR_KELUARGA = 'KELUARGA';
    const PENGANTAR_LAINLAIN = 'LAIN-LAIN';
    const PENGANTAR_ORANG_LAIN = 'ORANG LAIN';
    const PENGANTAR_ORANG_POLISI = 'PIHAK BERWAJIB/POLISI';
    const PENGANTAR_WARGA_SETEMPAT = 'WARGA SETEMPAT';
    const WARGA_NEGARA_WNI = 'WNI';
    const SUKU_ID_JAWA = 2; 
    
    const PENDIDIKAN_ID_TIDAK_DIKETAHUI = 31;
    const PEKERJAAN_ID_TIDAK_TAHU = 14; 


    const RUANGAN_ID_BKIA = 470; 

    const FILTER_INSTALASI_ID_FOR_PENJUALANRESEP_RS = [2, 3, 4, 14, 38, 79, 85, 100, 20];

    
    const ASALRUJUKAN_ID_PKM_PUSKESMAS = 3;

    
    const PENGANTAR_PEGAWAI_RS = 'PEGAWAI RS';
    //warna triase
    const TRIASE_WARNA_MERAH = 'merah';
    const TRIASE_WARNA_HIJAU = 'hijau';
    const TRIASE_WARNA_KUNING = 'kuning';
    const TRIASE_WARNA_HITAM = 'hitam';
    //pilihan jawaban
    const JAWAB_YA = 'YA';
    const JAWAB_TIDAK = 'TIDAK';
    //pilihan alatbantu
    const ALAT_BANTU_1 = 'BEDREST/ DIBANTU PERAWAT';
    const ALAT_BANTU_2 = 'ALAT PENOPANG/ ALAT BANTU BERJALAN';
    const ALAT_BANTU_3 = 'BERPEGANGAN PADA BENDA-BENDA SEKITAR';
    //pilihan cara berjalan
    const CARA_BERJALAN_1 = 'NORMAL/ TIDAK DAPAT BERGERAK SENDIRI';
    const CARA_BERJALAN_2 = 'LEMAH TIDAK BERTENAGA';
    const CARA_BERJALAN_3 = 'GANGGUAN (PINCANG/DISERET)';
    //pilihan status mental
    const STATUS_MENTAL_1 = 'MENYADARI KEMAMPUAN DIRI SENDIRI';
    const STATUS_MENTAL_2 = 'KETERBATASAN DAYA INGAT';
    //pilihan skrining skor resiko jatuh
    const SKOR_RESIKO_JATUH_RESIKO_1 = 'Tidak Berisiko'; // 0-24
    const SKOR_RESIKO_JATUH_TINDAKAN_1 = 'Perawatan Dasar'; //0-24
    const SKOR_RESIKO_JATUH_RESIKO_2 = 'Resiko Rendah'; // 25-50
    const SKOR_RESIKO_JATUH_TINDAKAN_2 = 'Pelaksanaan Intervensi \nPencegahan jatuh Standar'; // 25-50
    const SKOR_RESIKO_JATUH_RESIKO_3 = 'Resiko Tinggi'; // >=50
    const SKOR_RESIKO_JATUH_TINDAKAN_3 = 'Pelaksanaan Intervensi \nPencegahan jatuh resiko tinggi'; //>= 50
    //kuota jam kerja
    const KUOTA_JAM_KERJA = 6;
    //cuti setelah kerja dalam bulan
    const CUTI_KERJA = 12;
    //subsidi rs untuk rawat darurat saja
    const SUBSIDI_RS_UNTUK_RD = FALSE;
    //jabatan
    const JABATAN_ID_KEPALA_UMUM = 71;
    //status cuti
    const STATUS_CUTI_DISETUJUI = 'DISETUJUI';
    const STATUS_CUTI_DITOLAK = 'DITOLAK';
    const STATUS_CUTI_PENGAJUAN = 'PENGAJUAN';
    //jenis diklat
    const JENIS_DIKLAT_EKSTERNAL = 5;
    const JENIS_DIKLAT_INTERNAL = 6;
    //status rencana diklat
    const STATUS_RENCANA_DIKLAT_RENCANA = 'RENCANA';
    const STATUS_RENCANA_DIKLAT_REALISASI = 'REALISASI';
    const STATUS_RENCANA_DIKLAT_BATAL = 'BATAL';
    //gambar gigi
    const TINGGI_GIGI_DRAW = '96px';
    //jenis pemeriksaan nama
    const JENISPEMERIKSAANLAB_HEMATOLOGI = 'HEMATOLOGI';
    const JENISPEMERIKSAANLAB_ELEKTROLIT = 'ELEKTROLIT';
    const JENISPEMERIKSAANRAD_USG = 'USG';
    const JENISPEMERIKSAANRAD_FOTOXRAY = 'FOTO X-RAY (RONTGEN)';
    //unitker_id
    const UNITKERJA_ID_KEUANGAN = 22;
    const UNITKERJA_ID_FINANCE = 24;
    const UNITKERJA_ID_BENDAHARA = 27;
    const UNITKERJA_ID_DIREKTUR = 2;
    const UNITKERJA_ID_PELAYANAN_MEDIS = 7;
    const UNITKERJA_ID_PENUNJANG_MEDIS = 15;
    const UNITKERJA_ID_PURCHASING = 26; //purchasing
    const UNITKERJA_ID_FARMASI = 19; //unit kerja farmasi
    const UNITKERJA_ID_LAUNDRY = 21; //unit kerja laaundry
    const UNITKERJA_ID_RAWAT_JALAN = 13; //unit kerja laaundry
    const UNITKERJA_ID_PENGADAAN_DAN_JASA = 98;
    const UNITKERJA_ID_KMKP = 270;
    const UNITKERJA_ID_SEKSI_PENGEMBANGAN_MUTU_KEPERAWATAN = 10;
    const UNITKERJA_ID_DOKTER = 46;

    const JENISPEMERIKSAANMCU_PRIVAT = 'privat';
    const JENISPEMERIKSAANMCU_VAKSIN = 'vaksin';
    const JENISPEMERIKSAANMCU_REGULER = 'reguler';

    const STATUS_RENCANA_LEMBUR_RENCANA = 'RENCANA';
    const STATUS_RENCANA_LEMBUR_DISETUJUI = 'DISETUJUI';
    const STATUS_RENCANA_LEMBUR_DITOLAK = 'DITOLAK';
    const STATUS_RENCANA_LEMBUR_BATAL = 'BATAL';
    //skala nyeri umur
    const SKALA_NYERI_BERDASARKAN_UMUR_1 = 'Usia > 6 Tahun';
    const SKALA_NYERI_BERDASARKAN_UMUR_2 = 'Usia < 6 Tahun';
    const SKALA_NYERI_UMUR_KURANG = 6;
    const SKALA_NYERI_UMUR_LEBIH = 6;
    const STATUS_DOKTER = 'Dokter Utama';
    const NOTIF_LABEL_BUAT_DOKRM = 'Pembuatan Berkas Rekam Medis';
    const NOTIF_LABEL_KIRIM_DOKRM = 'Pengiriman Berkas Rekam Medis';
    const KRUBEDAH_OPERATOR = 'OPERATOR';
    const KRUBEDAH_ASISTEN_OPERATOR = 'ASISTEN OPERATOR';
    const KRUBEDAH_DOKTER_ANESTESI = 'DOKTER ANESTESI';
    
    const KRUBEDAH_DOKTER_RESUSITASI = 'DOKTER RESUSITASI';
    
    const KRUBEDAH_ASISTEN_ANESTESI = 'ASISTEN ANESTESI';
    const KRUBEDAH_PENATA_ANESTESI = 'PENATA ANESTESI';
    const KRUBEDAH_PERAWAT_ANESTESI = 'PERAWAT ANESTESI';

    const KRUBEDAH_PPDS ='PPDS';
    const KRUBEDAH_PETUGAS_RR = 'PETUGAS RR';
    const KRUBEDAH_PERAWAT_INSTRUMENT = 'PERAWAT INSTRUMENT';
    const KRUBEDAH_PERAWAT_SIRKULER = 'PERAWAT SIRKULER';
    const KRUBEDAH_BIDAN_PENERIMA_BAYI = 'BIDAN PENERIMA BAYI';
    const KRUBEDAH_DOKTER_PENERIMA_BAYI = 'DOKTER PENERIMA BAYI';
    const OBAT_TIDAK_TERPAKAI_STUCK = 3; //kurang 3 bulan
    const KETERANGAN_BUAT_JANJI_RENKONTROL = 'DARI RENCANA KONTROL';
    const DEFAULT_PPN = 10;
    const SATUANOBAT_BESAR = "SATUAN BESAR"; //dari lookup_type satuanobat
    const SATUANOBAT_KECIL = "SATUAN KECIL"; //dari lookup_type satuanobat
    const JABATAN_ID_AHLI_GIZI = 78;
    const JABATAN_ID_DRIVER = 66;
    const JABATAN_ID_SECURITY = 49;
    const JABATAN_ID_LAUNDRY = 52;
    const JABATAN_ID_KESLING = 73;
    const JABATAN_ID_STAF_KEUANGAN = 31;
    const MATAUANG_ID_RUPIAH = 1;
    //nama - nama hari
    const HARI_MINGGU = 'MINGGU';
    //settingan preesensi terlambat
    const PRESENSI_AWAL_TERLAMBAT = '+15 minutes';
    //partograf kontraksi detik
    const PARTOGRAF_KONTRAK_KURANG = '< 20'; //diambil dari lookup_m dengan lookup_type partograf_lamakontraksi
    const PARTOGRAF_KONTRAK_SD = '20 - 40'; //diambil dari lookup_m dengan lookup_type partograf_lamakontraksi
    const PARTOGRAF_KONTRAK_LEBIH = '> 40'; //diambil dari lookup_m dengan lookup_type partograf_lamakontraksi
    /**
     * digunakan untuk ukuran format kertas lebar
     */
    const width_A4 = "210";

    /**
     * digunakan untuk ukuran format kertas tinggi
     */
    const height_A4 = "297";
    // params hemodialisa
    const CARAMASUK_ID_HD = 4;          //id untuk cara masuk melalui hemodialisa
    const INSTALASI_ID_HD = 83;
    const INSTALASI_ID_HD_GA = 84;
    const SATUAN_LAMARAWAT_HD = 'Jam';
    const PEGAWAI_ID_SYSADMIN = 1028;
    const DEFAULT_KONDISIKELUAR_ID = 1; //1 = SEMBUH
    const PEGAWAI_DPJP_ID_STRIP = "1028"; //default pegawai/dpjp untu pendaftaran pegawai "-"
    const PEGAWAI_MCU_KOORDINATOR_ID = 4423; //default pegawai/dpjp untu pendaftaran pegawai "-"
    const PEGAWAI_KP_VERIFIKATOR = 3594; //default pegawai menyetujui, untuk cuti pegawai
    const PEGAWAI_SUB_BAG_PENERIMAAN = 3735; //default pegawai menyetujui, untuk cuti pegawai
    //jenis peralatan
    const JENIS_PERALATAN_BARANG = 'PERALATAN';
    const JENIS_PERALATAN_LINEN = 'LINEN';
    const JENIS_PERALATAN_ALATMEDIS = 'ALAT MEDIS';
    //master metodedarah_m
    const METODE_DARAH_ID_SLIDE_TEST = 1; //
    const METODE_DARAH_ID_TUBE_TEST = 2; //
    //status seleksi pendonor
    const STATUS_SELEKSI_DITOLAK = 'DITOLAK';
    const STATUS_SELEKSI_DITERIMA = 'DITERIMA';
    //grading
    const GRADING_MERAH = 'Merah';
    const GRADING_BIRU = 'Biru';
    const GRADING_HIJAU = 'Hijau';
    const GRADING_KUNING = 'Kuning';
    //komponen darah
    const KOMPONEN_DARAH_PRC = 'PRC';
    const KOMPONEN_DARAH_WB = 'WB';
    const KOMPONEN_DARAH_PCR = 'PCR';
    const KOMPONEN_DARAH_TC = 'TC';
    const KOMPONEN_DARAH_FFP = 'FFP';
    const KOMPONEN_DARAH_CRY = 'CRY';
    //komponen darah id
    const KOMPONEN_DARAH_ID_CRY = 16;

    /**
     * @author Elham Budianto <elhambudianto@.com>
     * Daftar id komponen darah
     */
    const ID_KOMPONEN_DARAH_WB = 7;
    const ID_KOMPONEN_DARAH_FFP = 9;
    const ID_KOMPONEN_DARAH_PRC = 8;
    const ID_KOMPONEN_DARAH_TC = 12;
    const ID_KOMPONEN_DARAH_PCR = 15;

    /**
     * Jabatan Kepala Instalasi Bank Darah
     * @author Elham Budianto <elhambudianto@.com>
     */
    const JABATAN_KEPALA_INSTALASI_BANK_DARAH = 3224;
    //kelancaran aliran darah
    const ALIRAN_DARAH_LANCAR = 'LANCAR'; //lookup_m (kelancarandarah)
    const ALIRAN_DARAH_TIDAK = 'TIDAK LANCAR'; //lookup_m (kelancarandarah)

    /**
     * digunakan pada transaksi pengujian konfirmasi golongan darah, sebagai nama yang tersimpan ke tabel terkaitnya
     */
    const PENGUJIAN_GOLDARAH_POSITIF = 'POSITIF';
    const PENGUJIAN_GOLDARAH_NEGATIF = 'NEGATIF';
    const PENGUJIAN_GOLDARAH_NONE = 'NONE';
    const HASIL_GOLDARAH_COCOK = 'COCOK';
    const HASIL_GOLDARAH_TIDAK = 'TIDAK COCOK';
    const KESIMPULAN_GOLDARAH_TIDAK = 'Diskrepansi';
    //value lookup_m dengan kondisi lookup_type='monitorintraanestesi_outcairankeluar'
    const MONITOR_INTRAANESTESI_OUTCAIRANKELUAR_EBL = 'EBL'; //ebl
    const MONITOR_INTRAANESTESI_INCAIRANMASUK_DARAH = 'DARAH'; //ebl
    const MONITOR_INTRAANESTESI_INPUT_OBAT = 'OBAT';
    //value lookup_m dengan kondisi lookup_type='kategoripengadaan'
    const KATEGORI_PENGADAAN_PENYEDIA = 'PENYEDIA';
    const KATEGORI_PENGADAAN_SWAKELOLA = 'SWAKELOLA';
    const KATEGORI_PENGADAAN_DEFAULT = 'Swakelola';
    const KATEGORI_PENGADAAN_TIPE_DEFAULT = 'Tipe 1';

    const DOKUMEN_PENGADAAN_PERSIAPAN_PENGADAAN = 'Persiapan Pengadaan';
    const KESIMPULAN_UJI_KOMPATIBILITAS_KOMPATIBEL = 'Kompatibel';
    const KESIMPULAN_UJI_KOMPATIBILITAS_INKOMPATIBEL = 'InKompatibel';
    //value lookup_m dengan kondisi lookup_type='rilis'
    const STATUS_UJI_KOMPATIBILITAS_RELEASE = 'Release';
    const STATUS_UJI_KOMPATIBILITAS_STOP = 'Stop';
    const SKALA_NYERI_0 = 'Tidak Nyeri';
    const SKALA_NYERI_1_2 = 'Sedikit Nyeri';
    const SKALA_NYERI_3_4 = 'Agak Menganggu';
    const SKALA_NYERI_5_6 = 'Menganggu Aktifitas';
    const SKALA_NYERI_7_8 = 'Sangat Menganggu';
    const SKALA_NYERI_9_10 = 'Tak Tertahankan';
    // untuk status pembersihan
    const STATUSPEMBERSIHAN_MULAI = 'Mulai';
    const STATUSPEMBERSIHAN_SEDANGCUCI = 'Sedang Cuci';
    const STATUSPEMBERSIHAN_SELESAI = 'Selesai';
    const STATUSPEMBERSIHAN_CUCIULANG = 'Cuci Ulang';
    const SATUAN_LAMARAWAT_PI = "HARI"; //Untuk default HARI
    const KELOMPOKTRANSAKSIPENGELUARAN_KAS = "KAS";
    // sumber dana
    const SUMBERDANA_ID_PT = 2;
    const SUMBERDANA_ID_RS = 1;
    // status anestesi
    const STATUSDURANTEANESTESI_SEDANG_ANESTESI = "Sedang Anestesi/Sedasi";
    const STATUSDURANTEANESTESI_AKHIR_ANESTESI = "Akhir Anestesi (Ekstubasi)";
    // status tindakan
    const STATUSDURANTEANESTESI_SEDANG_TINDAKAN = "Sedang Berlangsung Tindakan";
    const STATUSDURANTEANESTESI_AKHIR_TINDAKAN = "Akhir Berlangsung Tindakan";
    // jenis spesimen
    const JENISSPESIMEN_PA_LAINNYA = 3;
    //untuk group phonbook sms gateway
    const GROUP_UMUM = 1;
    const GROUP_PASIEN = 2;
    const GROUP_SUPPLIER = 3;
    const GROUP_ASURANSI = 4;
    const GROUP_PELAMAR = 5;
    const GROUP_PEGAWAI = 6;
    const DEFAULT_NO_MOBILE_PASIEN = "-";
    const TIPEINPUT_ISIINFORMASI_CHECKBOX = "CHECKBOX";
    const TIPEINPUT_ISIINFORMASI_PENJELASANTETAP = "PENJELASAN TETAP";
    const TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER = "DIINPUT OLEH USER";
    //status hd
    const STATUS_HD_SELESAI = 'SELESAI TINDAKAN';
    
    const INDIKATOR_OPPE_CARING_ID = 3;
    const INDIKATOR_OPPE_CLINICALCARE_ID = 6;
    
    //krubedah pelaksana anestesi
    const KRUANESTESI_SPESIALIS_ANESTESIOLOGI  ='Spesialis Anestesiologi';  
    const KRUANESTESI_PPDS_ANESTESIOLOGI  ='PPDS Anastesiologi';
    const KRUANESTESI_ASISTEN_PERAWAT  ='Asisten Perawat Anastesi';       
        
    //induksi detail
    const INDUKSI_DET_LOKASI_INPUT = 'LOKASI INFUS';
    const INDUKSI_DET_TEMPAT_CVC = 'TEMPAT CVC';
    const INDUKSI_DET_TEMPAT_ARTERI_LINE = 'TEMPAT ARTERI LINE';   
    // Lookup Kepegawaian 
    const LOOKUP_KEPEGAWAIAN_LABELNOMORPEGAWAI= 'labelnomorpegawai';
    const LOOKUP_KEPEGAWAIAN_LABELPEGAWAI= 'labelpegawai';
    
    //jenis surat
    const JENISSURAT_TUGAS = 15;
    const JENISSURAT_ID_SSKK = 26;
    
    //status periapan pengadaan
    const STATUS_PERSIAPAN_DIAJUKAN = 'Diajukan';
    const STATUS_PERSIAPAN_REVISI = 'Revisi';
    const STATUS_PERSIAPAN_DIBATALKAN = 'Dibatalkan';
    const STATUS_PERSIAPAN_DISETUJUI = 'Disetujui';
    
    //jabatan pengadaan
    const JABATAN_PENGADAAN_PA = 'PA';
    const JABATAN_PENGADAAN_KPA = 'KPA';
    const JABATAN_PENGADAAN_PPK = 'PPK';
    const JABATAN_PENGADAAN_PPKOM = 'PPKom';
    const JABATAN_PENGADAAN_TIM_TEKNIS = 'Tim Teknis';    
    const JABATAN_PENGADAAN_PEJABAT_PENGADAAN = 'Pejabat Pengadaan';    
    const JABATAN_PENGADAAN_PPTK = 'Pejabat Pelaksana Teknis Kegiatan';    
    const JABATAN_PENGADAAN_PJK = 'Penanggung Jawab Kegiatan';    
    const JABATAN_PENGADAAN_KA_UPBJ = ' Ka. UPBJ';    
    const JABATAN_PENGADAAN_KA_UPPTSA = 'Ka. UPPTSA';
    const JABATAN_PENGADAAN_DRAFTER = 'Drafter';
    
    //status rencana umum
    const STATUS_RENCANA_UMUM_PENGADAAN_DRAFT = 'Draft';
    const STATUS_RENCANA_UMUM_PENGADAAN_REVISI = 'Revisi';
    const STATUS_RENCANA_UMUM_PENGADAAN_REVISI_PPK = 'Revisi PPK';
    const STATUS_RENCANA_UMUM_PENGADAAN_REVISI_TPP_RUP = 'Revisi TPP-RUP';
    const STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK = 'Persetujuan PPK';
    const STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_KPA = 'Persetujuan KPA';
    const STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PA = 'Persetujuan PA';
    const STATUS_RENCANA_UMUM_PENGADAAN_DIBATALKAN = 'Dibatalkan';
    const STATUS_RENCANA_UMUM_RUP_DIUMUMKAN = 'RUP Diumumkan';
    
    const JENIS_PENGADAAN_ID_JASA_KONSULTASI = 3;
    const METODE_PENGADAAN_ID_EPURCHASING = 3;
    
    const RENCANA_UMUM_PENGADAAN_STATUS_RUP = 'Rup Diumumkan';
    const RENCANA_UMUM_PENGADAAN_STATUS_PERSIAPAN = 'Persiapan Pengadaan';
    
    //status surat perjanjian kerja
    const STATUS_SPK_TERVERIFIKASI = 'Terverifikasi';
    const STATUS_SPK_TERBAYAR = 'Terbayar';
    
    //status pengajuan sk
    const STATUS_PENGAJUAN_DISETUJUI = 'DISETUJUI'; // dari lookup_m dengan kondisi lookup_type = 'statuspengajuansk'
    const STATUS_PENGAJUAN_TIDAK_DISETUJUI = 'TIDAK DISETUJUI'; // dari lookup_m dengan kondisi lookup_type = 'statuspengajuansk'
    const STATUS_PENGAJUAN_REVISI = 'REVISI'; // dari lookup_m dengan kondisi lookup_type = 'statuspengajuansk'
    
    const STATUS_INFORMASI_UMUM_REVISI_DOKUMEN = 'Revisi Dokumen';
    const STATUS_INFORMASI_UMUM_DIAJUKAN = 'Diajukan';
    
    //pdf set
    const DEFAULT_KERTAS_POSISI_LANDSCAPE = 'L';
    
    // Status Insiden RS     
    const STATUS_LAPORAN_INSIDEN_DITOLAK = 'Ditolak';
    const STATUS_LAPORAN_INSIDEN_DISETUJUI = 'Disetujui';
    const STATUS_LAPORAN_INSIDEN_MENUNGGU_PERSETUJUAN = 'Menunggu Persetujuan';

    const STATUS_PENGAJUAN_KASBON_PENGAJUAN = 'PENGAJUAN';
    const STATUS_PENGAJUAN_KASBON_PERSETUJUAN = 'PERSETUJUAN';
    const STATUS_PENGAJUAN_KASBON_DISETUJUI = 'DISETUJUI';

    const STATUS_VALIDASI_KASBON_BELUM_DIVERIFIKASI = 'Belum Diverifikasi';
    const STATUS_VALIDASI_KASBON_TERVERIFIKASI = 'Terverifikasi';

    //CPPT
    const CPPT_JENIS_PPA_ID = 1;
    const CPPT_JENIS_PPA_ID_DOKTER_UMUM = 2;
    const CPPT_JENIS_PPA_ID_PERAWAT = 3;
    const CPPT_JENIS_PPA_ID_APOTEKER = 4;
    const CPPT_JENIS_PPA_ID_GIZI = 5;
    const CPPT_JENIS_PPA_ID_FISIO = 6;
    const CPPT_JENIS_PPA_ID_LAINNYA = 7;
    const CPPT_JENIS_PPA_ID_DOKTER = 8;
    
    const KOMPONENTARIF_ID_JASA_DOKTER = 85;

    const JENIS_OBATALKES_ID_OBAT = 22; 

    //pdf set
    const DEFAULT_KERTAS_POSISI_PORTRAIT = 'p';
    
    const PEKERJAAN_ID_DIBAWAHUMUR = 71;
    
    //digunakan pada transaksi pendaftaran lab
    const NO_MASUK_PENUNJANG_PK = 'PK'; // pendaftaran di modul laboratorium
    const NO_MASUK_PENUNJANG_PA = 'PA'; // pendaftaran di modul laboratorium PA

    //prefix kantong darah
    const PREFIX_KANTONG_DARAH_UTAMA = 'UT';
    const PREFIX_KANTONG_DARAH_SAMPLE = 'V'; //v = violet, penanda golongan konfirmasi darah
    const PREFIX_KANTONG_DARAH_SKRINING_IMLTD = 'R'; //red = merah, penanda skring IMLTD

    /**
     * @author Andyka Putra <andykaputra@.com>
     * Daftar id jenis kantong darah
     */
    const ID_JENIS_KANTONG_DARAH_SINGLE = 1;
    const ID_JENIS_KANTONG_DARAH_DOUBLE = 2;
    const ID_JENIS_KANTONG_DARAH_TRIPLE = 3;
    const ID_JENIS_KANTONG_DARAH_QUADRUPLE = 4;

    /**
     * Hasil screening
     */
    const HASIL_SKRINING_REAKTIF = 'Reaktif';
    const HASIL_SKRINING_NONREAKTIF = 'Non Reaktif';

    //untuk status pendaftaran donor darah
    const STATUS_PENDONOR_ANTRIAN ='ANTRIAN';
    const STATUS_PENDONOR_SELEKSI ='SELEKSI';
    const STATUS_PENDONOR_OBSERVASI ='OBSERVASI';
    const STATUS_PENDONOR_SELESAI ='SELESAI';

    //jenis donor
    const DONOR_SUKARELA = 'Sukarela';
    const DONOR_PENGGANTI = 'Pengganti';

    //ruangan transfusi
    const RUANGAN_NAMA_TRANSFUSI_DARAH = 'BANK DARAH';

    //jenis diet
    const JENIS_DIET_ID_MAKANAN_PASIEN = 396;
    
    //JENIS WAKTU
    const ID_MAKAN_PAGI = 2;
    const ID_MAKAN_SIANG = 13;
    const ID_MAKAN_SORE = 15;

    public static function getJasaMedis() {
        return array(
            self::KOMPONENTARIF_ID_JASA_ANASTESI, 
            self::KOMPONENTARIF_ID_JASA_OPERATOR,
            self::KOMPONENTARIF_ID_JASA_DOKTER,
            self::KOMPONENTARIF_ID_JASA_MEDIS
        );
    }
    /**
     * mengambil ukuran kertas f4
     * @return array $dt menampung nilai array
     */
    public static function getUkuranKertas() {
        $dt = array(
            'F4' => array(215, 330),
            'A4' => array(210, 297),
            'A5' => array(145, 297)
        );

        return $dt;
    }

    public static function getTipeInputIsiInformasiList() {
        return array(
            self::TIPEINPUT_ISIINFORMASI_CHECKBOX => self::TIPEINPUT_ISIINFORMASI_CHECKBOX,
            self::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP => self::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP,
            self::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER => self::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER
        );
    }

    public static function getKelompokUmurHamil() {
        return array(2, 3, 4);
    }

    public static function getKelompokUmurCongenital() {
        return array(1, 2, 5, 6);
    }

    public static function getRuanganPoliGigi() {
        return array(
            305, 345
        );
    }

    public static function getStatusRencanaLembur() {
        return array(
            self::STATUS_RENCANA_LEMBUR_RENCANA => self::STATUS_RENCANA_LEMBUR_RENCANA,
            self::STATUS_RENCANA_LEMBUR_DISETUJUI => self::STATUS_RENCANA_LEMBUR_DISETUJUI,
            self::STATUS_RENCANA_LEMBUR_DITOLAK => self::STATUS_RENCANA_LEMBUR_DITOLAK,
            self::STATUS_RENCANA_LEMBUR_BATAL => self::STATUS_RENCANA_LEMBUR_BATAL,
        );
    }

    public static function getStatusRencanaPelatihan() {
        return array(
            self::STATUS_RENCANA_DIKLAT_RENCANA => self::STATUS_RENCANA_DIKLAT_RENCANA,
            self::STATUS_RENCANA_DIKLAT_REALISASI => self::STATUS_RENCANA_DIKLAT_REALISASI,
            self::STATUS_RENCANA_DIKLAT_BATAL => self::STATUS_RENCANA_DIKLAT_BATAL,
        );
    }

    public static function KomponenUnitRuangan() {
        return array(//Ruangan => komponenunit
            18 => 25, //akupuntur
            12 => 17, // anak
            10 => 16, //bedah
            11 => 20, //dalam
            16 => 21, //gigi dan mulut
            13 => 15, //kebidanan dan kandungan
            17 => 14, //kulit dan kelamin
            14 => 12, //mata
            25 => 8, //mcu
            20 => 13, //saraf
            15 => 14, //tht
            57 => 22, //bedah sentral
            62 => 6, //gizi
            53 => 2, //laboratorium
            63 => 9, //pemulasaran jenazah
            56 => 10, //radiologi
            3 => 3, //rawat darurat (instalasi/komponen)
            27 => 11, // Perawatan Pria
            28 => 11, // Perawatan Wanita
            29 => 11, // Perawatan Anak
            30 => 11, // Lantai 3
            31 => 11, // Lantai 2
            237 => 11, // Perinatologi
            239 => 11, // Rawat Bedah
            8 => 5, // Ruang Bersalin
            4 => 11, //(instalasi/komponen)
            46 => 4, //ruang icu
            90 => 18, //rehab medis
        );
    }

    public static function KelompokTindakanInstalasi() {
        return array(//instalasi => kelompoktindakan
            2 => 15, //rawat jalan
            4 => 17, //rawat inap
            3 => 4, //rawat darurat
            25 => 26, //mcu patokannya menggunakan ruangan
            7 => 10, //bedah sntral//pelayanan medik operatif
            10 => 23, //gizi
            5 => 24, //laboratorium
            17 => 12, //pemulasarann jenazxah
            6 => 9, //pelayanan pemeriksaan radiodiagnostik
            20 => 21, //rawat intensef
            8 => 5, //rehabilitasi medis
        );
    }

    /* Hardcode status periksa */

    public static function statusPeriksa() {
        return array(
            'ANTRIAN' => 'ANTRIAN',
            'SEDANG DIRAWAT INAP' => 'SEDANG DIRAWAT INAP',
            'SEDANG PERIKSA' => 'SEDANG PERIKSA',
            'SUDAH DI PERIKSA' => 'SUDAH DI PERIKSA',
            //'MENUNGGU DAFTAR DI LOKET SO'=>'MENUNGGU DAFTAR DI LOKET SO',
            'MENUNGGU ADMISI PASIEN' => 'MENUNGGU ADMISI PASIEN',
            'SUDAH PULANG' => 'SUDAH PULANG',
            'BATAL PERIKSA' => 'BATAL PERIKSA',
        );
    }

    public static function statusPeriksaInfoKunjunganRJ() {
        return array(
            'ANTRIAN' => 'ANTRIAN',
            'SEDANG DIRAWAT INAP' => 'SEDANG DIRAWAT INAP',
            'SEDANG PERIKSA' => 'SEDANG PERIKSA',
            'SUDAH DI PERIKSA' => 'SUDAH DI PERIKSA',
            //'MENUNGGU DAFTAR DI LOKET SO'=>'MENUNGGU DAFTAR DI LOKET SO',
            'MENUNGGU ADMISI PASIEN' => 'MENUNGGU ADMISI PASIEN',
            'SUDAH PULANG' => 'SUDAH PULANG',
            // 'BATAL PERIKSA' => 'BATAL PERIKSA',
        );
    }

    public static function statusPeriksaCol() {
        return array(
            'ANTRIAN' => 'btn-black',
            'SEDANG DIRAWAT INAP' => 'btn-purple',
            'SEDANG PERIKSA' => 'btn-gold',
            'SUDAH DI PERIKSA' => 'btn-blue',
            //'MENUNGGU DAFTAR DI LOKET SO'=>'MENUNGGU DAFTAR DI LOKET SO',
            'MENUNGGU ADMISI PASIEN' => 'btn-orange',
            'SUDAH PULANG' => 'btn-green',
            'BATAL PERIKSA' => 'btn-red',
        );
    }

    public static function statusPeriksaPT() {
        return array(
            'ANTRIAN' => 'ANTRIAN',
            'SEDANG PERIKSA' => 'SEDANG PERIKSA',
            'SUDAH DI PERIKSA' => 'SUDAH DI PERIKSA',
        );
    }

    public static function sys2bpjsKelas($id = null) {
        $arr = array(
            '3' => 1,
            '5' => 2,
            '4' => 3,
        );
        if (!empty($id))
            return $arr[$id];
        return $arr;
    }

    public static function statusPersetujuan() {
        return array(
            false => 'BELUM DISETUJUI',
            true => 'SUDAH DISETUJUI',
        );
    }

    /**
     * array instalasi rawat inap
     * @return type
     */
    public static function getArrayInstalasiInap() {
        return array(
            Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU, 79, 38, 14, 85, 100
        );
    }

    public static function kelasPelayananNilai($kelaspelayanan_id = null) {
        $arr = array(
            self::KELASPELAYANAN_ID_KELAS_III => 1,
            self::KELASPELAYANAN_ID_KELAS_II => 2,
            self::KELASPELAYANAN_ID_KELAS_I => 3,
            self::KELASPELAYANAN_ID_VIP => 4,
            self::KELASPELAYANAN_ID_VIP_B => 5,
            self::KELASPELAYANAN_ID_VVIP => 6,
            self::KELASPELAYANAN_ID_EKSEKUTIF => 7,
        );

        if (!empty($kelaspelayanan_id)) {
            if (!empty($arr[$kelaspelayanan_id]))
                return $arr[$kelaspelayanan_id];
            return 0;
        }

        return $arr;
    }

    //=== PATH & URL ===
    //Merupakan inisialisasi path dan url yang digunakan untuk menyimpan dan mengakses file

	/**
	 * untuk mengambil path direktori gambar untuk slider Antrian
	 * @return string path contoh: /var/www/simrs/data/images/slideantrian/
	 */
	public static function pathAntrianSliderGambar()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/slideantrian/';
	}

	public static function pathAntrianSliderGambarThumbs()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/slideantrian/thumbs/';
	}

	public static function urlAntrianSliderGambar()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/slideantrian/';
	}

    public static function urlEkios()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/kiosk/';
	}

        public static function pathFasilitasGambar()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/fasilitas/';
	}

	public static function urlFasilitasGambar()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/fasilitas/';
	}

	public static function urlAntrianSliderGambarThumbs()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/slideantrian/thumbs/';
	}

	/**
	 * untuk mengambil path direktori latar belakang layar antrian
	 * @return string path contoh: /var/www/simrs/data/images/antrian/
	 */
	public static function pathBackgroundAntrian()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/antrian/';
	}
	public static function pathBackgroundAntrianThumbs()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/antrian/thumbs/';
	}

	public static function urlBackgroundAntrian()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/antrian/';
	}
	public static function urlBackgroundAntrianThumbs()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/antrian/thumbs/';
	}
      
	/**
	 * untuk mengambil path direktori icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function pathIconModulDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_modul/';
	}
  
	/**
	 * untuk mengambil path direktori thumbnail icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function pathIconModulThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_modul/thumbs/';
	}

	/**
	 * untuk mengambil url direktori thumbnail icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function urlIconModulThumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/icon_modul/thumbs/';
	}

	/**
	 * untuk mengambil path direktori icon menu
	 * @return string path contoh: /var/www/simrs/images/icon_menu
	 */
	public static function pathIconMenuDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_menu/';
	}

	/**
	 * untuk mengambil path direktori thumbnail icon menu
	 * @return string path contoh: /var/www/simrs/images/icon_menu
	 */
	public static function pathIconMenuThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/icon_menu/thumbs/';
	}

	/**
	 * untuk mengambil url direktori thumbnail icon modul
	 * @return string path contoh: /var/www/simrs/images/icon_modul
	 */
	public static function urlIconModulDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/icon_modul/';
	}
  
	public static function urlIconMenuDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/icon_menu/';
	}    
	public static function urlBarangDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/images/barang/';
	}

	public static function pathProfilRSDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/profil_rs/';
	}  
	public static function pathBarangDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/barang/';
	}

	public static function pathProfilRSTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/profil_rs/tumbs/';
	}
	public static function pathBarangTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/images/barang/tumbs/';
	}

    public static function pathPetunjukPenggunaanDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/petunjukpenggunaan/';
	}

	//======================================Path Instalasi==============================================
	public static function pathRuanganDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/ruangan/';
	}

	public static function pathRuanganTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/ruangan/tumbs/';
	}

	public static function urlRuanganDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/ruangan/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlRuanganTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/ruangan/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}
	//====================================Akhir Path dan UrlInstalasi=====================================

	//======================================Path Kamr Ruangan==============================================
	public static function pathKamarRuanganDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kamarruangan/';
	}

	public static function pathKamarRuanganTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kamarruangan/tumbs/';
	}

	public static function urlKamarRuanganDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kamarruangan/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlKamarRuanganTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kamarruangan/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}
	//====================================Akhir Path dan UrlKamarRuangan=====================================
//======================================Path Slot Bed==============================================
public static function pathSlotBedDirectory()
{
    return Yii::getPathOfAlias('webroot').'/data/images/slotbed/';
}

public static function pathSlotBedTumbsDirectory()
{
    return Yii::getPathOfAlias('webroot').'/data/images/slotbed/tumbs/';
}

public static function urlSlotBedDirectory()
{
    return Yii::app()->getBaseUrl('webroot').'/data/images/slotbed/';          //Untuk Menampilkan Gambar Asli
}

public static function urlSlotBedTumbsDirectory()
{
    return Yii::app()->getBaseUrl('webroot').'/data/images/slotbed/tumbs/';    //Untuk Menampilkan Gambar Tumbs
}
//====================================Akhir Path dan UrlSlotBed=====================================


	//======================================Path Instalasi==============================================
	public static function pathInstalasiDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/instalasi/';
	}

	public static function pathInstalasiTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/instalasi/tumbs/';
	}

	public static function urlInstalasiDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/instalasi/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlInstalasiTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/instalasi/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}
	//====================================Akhir Path dan UrlInstalasi=====================================

	//======================================Path USG==============================================
	public static function pathUSGDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/fotousg/';
	}

	public static function pathUSGTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/fotousg/tumbs/';
	}

	public static function urlUSGDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/fotousg/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlUSGTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/fotousg/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}
	//====================================Akhir Path dan Url USG=====================================

	public static function urlProfilRSDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/profil_rs/';          //Untuk Menampilkan Gambar Asli
	}

    public static function urlPetunjukPenggunaanDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/petunjukpenggunaan/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlProfilRSTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/profil_rs/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}

        public static function urlProfilKoperasiRSDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/profil_kop/';          //Untuk Menampilkan Gambar Asli
	}

	public static function urlProfilKoperasiRSTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/profil_kop/tumbs/';    //Untuk Menampilkan Gambar Tumbs
	}

	public static function pathPegawaiDirectory()
	{
			return Yii::getPathOfAlias('webroot').'/data/images/pegawai/';
	}

	public static function pathPegawaiTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pegawai/tumbs/';
	}

    // Promo
    public static function pathPromoDirectory()
	{
			return  Yii::getPathOfAlias('webroot').'/data/images/promo/';
	}
	public static function urlPromoDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/promo/';          //Untuk Menampilkan Gambar Asli Pegawai
	}
	public static function pathPromoTumbsDirectory()
	{
		return  Yii::getPathOfAlias('webroot').'/data/images/promo/tumbs/';
	}

    // Sisa Makanan
    public static function pathSisaMakananDirectory()
	{
			return  Yii::getPathOfAlias('webroot').'/data/images/sisa_makanan/';
	}
	public static function urlSisaMakananDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/sisa_makanan/';          //Untuk Menampilkan Gambar Asli Pegawai
	}
	public static function pathSisaMakananTumbsDirectory()
	{
		return  Yii::getPathOfAlias('webroot').'/data/images/sisa_makanan/tumbs/';
	}


	public static function urlPegawaiDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pegawai/';          //Untuk Menampilkan Gambar Asli Pegawai
	}

	public static function urlPegawaiTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pegawai/tumbs/';    //Untuk Menampilkan Gambar Tumbs Pegawai
	}

	public static function pathPegawaiFileDirectory()
	{
			return Yii::getPathOfAlias('webroot').'/data/pdf/pegawai/';
	}

	public static function urlPegawaiFileDirectory()
	{
			return Yii::app()->getBaseUrl('webroot').'/data/pdf/pegawai/';
	}

        public static function pathPegPromosiFileDirectory()
	{
			return Yii::getPathOfAlias('webroot').'/data/pdf/promosi/';
	}

	public static function urlPegPromosiFileDirectory()
	{
			return Yii::app()->getBaseUrl('webroot').'/data/pdf/promosi/';
	}



	public static function urlPhotoPasienDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pasien/';    //Untuk Menampilkan photo pasien
	}

	public static function urlPhotoBarangDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/barang/';    //Untuk Menampilkan photo barang
	}

	public static function pathPasienTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pasien/tumbs/';
	}

	public static function urlPasienTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pasien/tumbs/';    //Untuk Menampilkan Gambar Tumbs Pasien
	}

	public static function pathPasienDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pasien/';
	}

	public static function urlKendaraanDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kendaraan/';    //Untuk Menampilkan Gambar Kendaraan
	}

	public static function pathKendaraanDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kendaraan/';
	}

	public static function urlKendaraanTumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/kendaraan/tumbs/';    //Untuk Menampilkan Gambar Tumbs Kendaraan
	}

	public static function pathKendaraanTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/kendaraan/tumbs/';
	}
	//======== path dan url photo dan file pelamar ========
	public static function pathPelamarThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pelamar/photos/thumbs/';
	}
	public static function pathPelamarPhotosDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pelamar/photos/';
	}
	public static function pathPelamarFilesDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pelamar/files/';
	}
	public static function urlPelamarThumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pelamar/photos/thumbs/';
	}
	public static function urlPelamarPhotosDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pelamar/photos/';
	}
	public static function urlPelamarFilesDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pelamar/files/';
	}

	//======== End path dan url photo pelamar ========

	public static function pathImagePengumumanUploaded()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pengumuman/';
	}

	public static function pathImagePengumumanUploadedThumb()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pengumuman/thumbs/';
	}

	public static function urlImagePengumumanUploaded()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pengumuman/';
	}

	public static function urlExcel()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/excel/template/';
	}

	public static function urlImagePengumumanUploadedThumb()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pengumuman/thumbs/';
	}

	 public static function urliconmenu()
	{
		return Yii::app()->getBaseUrl('webroot').'/css/images/';
	}

	public static function pathImageErrorAdmin()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/';
	}

	public static function pathBerita()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/berita/';
	}

	public static function urlBerita()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/berita/';
	}

	//======== path dan url photo pemeriksaan pasien ========
	public static function pathPemeriksaanPasienThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pemeriksaanpasien/photos/thumbs/';
	}
	public static function pathPemeriksaanPasienPhotosDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pemeriksaanpasien/photos/';
	}
	public static function urlPemeriksaanPasienThumbsDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pemeriksaanpasien/photos/thumbs/';
	}
	public static function urlPemeriksaanPasienPhotosDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pemeriksaanpasien/photos/';
	}
        public static function urlPemeriksaanGambarDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/pemeriksaanpasien/photos/thumbs/';
	}

	//======== End path dan url pemeriksaan pasien ========

	//======== Start path dan url Anatomi Tubuh Manusia ========

	public static function urlPhotoAnatomiTubuh()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/anatomi/';
	}
	public static function pathAnatomiTubuhDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/anatomi/';
	}
	public static function pathAnatomiTubuhThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/anatomi/thumbs/';
	}

	//======== End path dan url Anatomi Tubuh Manusia ========

	//======== Start path dan url Linen ========

	public static function urlLinen()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/linen/';
	}
        public static function urlLinenThumbs()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/linen/thumbs/';
	}
	public static function pathLinenDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/linen/';
	}
	public static function pathLinenThumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/linen/thumbs/';
	}

    public static function pathFileHasilPemeriksaanTindakanDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/images/hasilPemeriksaanTindakan/';
    }      
    public static function pathFileRMPasienDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/images/pasien/rekammedis/';
    }      
    public static function urlFileRMPasienDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/images/pasien/rekammedis/';
    }
    public static function pathFileRMTumbsDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/pasien/rekammedis/tumbs/';
	}

    /**
     * digunakan untuk icon erm
     * @author Yusuf Putra Anugrah <yusufputra@.com>
     * @return string location file
     */
    public static function urlIconModulERM()
    {
        return Yii::app()->getBaseUrl('webroot').'/images/icon_ERM/';
    }
    
    /**
     * untuk mengambil path direktori icon modul
     * @return string path contoh: /var/www/simrs/images/icon_modul
     */
    public static function pathSuaraAntrianDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/sounds/antrian/mp3/';
    }

    public static function pathBuktiPembayaranDirectory() {
        return Yii::getPathOfAlias('webroot') . '/images/buktipembayaran/';
    }                
    
	public static function pathUploads()
	{
		return Yii::getPathOfAlias('webroot').'/uploads/';
	}

    public static function urlSopDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/sop/';
	}

	public static function pathSopDirectory()
	{
		return Yii::getPathOfAlias('webroot').'/data/images/sop/';
	}  
    
          
    public static function pathEkgDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/elektrokardiogram/';
    }
    public static function urlEkgDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/elektrokardiogram/';
    }

    
    public static function setLabelKepegawaianKonfig() {
        return (!empty(Yii::app()->user->getState('labelpegawai')) ? Yii::app()->user->getState('labelpegawai') : "Pegawai");
    }
    
        
        //======== path dan url photo user ========
        public static function pathEdukasiPTRS()
        {
            return Yii::getPathOfAlias('webroot').'/data/pdf/edukasiptrs/';
        }
        public static function urlEdukasiPTRS()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/pdf/edukasiptrs/';
        }
        
        //======== path dan url SK TTD Elektronik ========
        public static function pathSKTTDElektronik()
        {
            return Yii::getPathOfAlias('webroot').'/data/images/sktte/';
        }
        public static function urlSKTTDElektronik()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/images/sktte/';
        }
        //======== path dan url SK TTD Elektronik ========
        
        public static function pathHasilPeriksaLab()
        {
            return Yii::getPathOfAlias('webroot').'/data/images/hasilpemeriksaanlab/';
        }

    
         
    public static function pathPersetujuanUmumIsiGambar()
    {
        return Yii::getPathOfAlias('webroot').'/data/images/persetujuanumum/';
    }
        public static function urlPersetujuanUmumIsiGambar()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/images/persetujuanumum/';
        }
        //======== path dan url photo user ========
        
        public static function pathDokumenMutasiPegDirectory()
        {
            return Yii::getPathOfAlias('webroot').'/data/images/pegawai_mutasi/';
        }
        
        public static function pathMcuPemeriksaanUmum()
        {
            return Yii::getPathOfAlias('webroot').'/data/lain/mcu-pemeriksaanumum/';
        }
        public static function urlMcuPemeriksaanUmum()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/lain/mcu-pemeriksaanumum/';
        }

        public static function urlDokumenMutasiPegDirectory()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/images/pegawai_mutasi/';
        }

        public static function pathSettlementDirectory()
        {
            return Yii::getPathOfAlias('webroot').'/data/images/settlementpayment/';
        }

        public static function pathDokumenRealisasiPelatihanDirectory()
        {
            return Yii::getPathOfAlias('webroot').'/data/images/realisasi_pelatihan/';
        }
        public static function urlDokumenRealisasiPelatihanDirectory()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/images/realisasi_pelatihan/';
        }

        public static function pathDokumenSuratInternalDirectory()
        {
            return Yii::getPathOfAlias('webroot').'/data/images/surat_internal/';
        }
        public static function urlDokumenSuratInternalDirectory()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/images/surat_internal/';
        }

        public static function pathDokumenPengumumanDirectory()
        {
            return Yii::getPathOfAlias('webroot').'/data/images/pengumuman/';
        }
        public static function urlDokumenPengumumanDirectory()
        {
            return Yii::app()->getBaseUrl('webroot').'/data/images/pengumuman/';
        }

    /**
     * untuk mengambil url direktori thumbnail icon modul
     * @return string path contoh: /var/www/simrs/images/icon_modul
     */
    public static function urlIconERMDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/images/icon_ERM/';
    }
   
    //======== Start path dan url File CALK ========

    public static function urlCALK() {
        return Yii::app()->getBaseUrl('webroot') . '/data/files/calk/';
    }

    public static function pathCALKDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/files/calk/';
    }

    //======== End path dan url File CALK ========

    public static function urlProfilRSPDFPath() {
        return Yii::app()->request->baseUrl . '/data/images/profil_rs/';
    }

    //======== path dan url photo user ========
    public static function pathUserProfile() {
        return Yii::getPathOfAlias('webroot') . '/data/images/user_profile/';
    }

    public static function urlUserProfile() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/user_profile/';
    }

    //======== path dan url photo user ========

    /**
     * path untuk mengakses file pada folder pendonor thumb
     * @return type
     */
    public static function pathPendonorDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/pendonor/';
    }

    /**
     * url  untuk mengakses file pada folder pendonor thumb
     * @return type
     */
    public static function urlPendonorDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/pendonor/';
    }

    /**
     * path untuk mengakses file pada folder pendonor thumb
     * @return type
     */
    public static function pathPendonorTumbsDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/pendonor/tumbs/';
    }

    /**
     * url  untuk mengakses file pada folder pendonor thumb
     * @return type
     */
    public static function urlPendonorTumbsDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/pendonor/tumbs/';    //Untuk Menampilkan Gambar Tumbs Pasien
    }

    public static function pathResepturDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/reseptur/';
    }

    public static function urlResepturDirectory() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/reseptur/';
    }

    public static function pathVideoAntrian() {
        return Yii::getPathOfAlias('webroot') . '/data/video/antrian/';
    }

    public static function urlVideoAntrian() {
        return Yii::app()->getBaseUrl('webroot') . '/data/video/antrian/';
    }

    // BERITA
    public static function pathTumbsBeritaGambar() {
        return Yii::getPathOfAlias('webroot') . '/data/images/berita/tumbs/';
    }
    public static function urlKategoriBeritaGambar() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/kategoriberita/';
    }
    public static function urlTumbsKategoriBeritaGambar() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/kategoriberita/tumbs/';
    }
    public static function pathKategoriBeritaGambar() {
        return Yii::getPathOfAlias('webroot') . '/data/images/kategoriberita/';
    }
    public static function pathTumbsKategoriBeritaGambar() {
        return Yii::getPathOfAlias('webroot') . '/data/images/kategoriberita/tumbs/';
    }
     public static function urlBeritaGambar() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/berita/';
    }
    public static function urlTumbsBeritaGambar() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/berita/tumbs/';
    }
    public static function pathBeritaGambar() {
        return Yii::getPathOfAlias('webroot') . '/data/images/berita/';
    }

    //======== Start path dan url Asuransi ========

    public static function pathLogoAsuransi() {
        return Yii::app()->getBaseUrl('webroot') . '/data/images/asuransi/logos';  //Untuk Menampilkan Gambar
    }

    public static function pathLogoAsuransiDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/asuransi/logos'; //Untuk menyimpan gambar
    }

    public static function urlLogoAsuransiDirectory() {
        return Yii::app()->request->baseUrl . '/data/images/asuransi/logos';
    }

    public static function pathLogoAsuransiThumbsDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/asuransi/thumbs/';
    }

    public static function pathLampiranpksFilesDirectory() {
        return Yii::getPathOfAlias('webroot') . '/data/images/asuransi/files/';
    }
    
    /**
     * path full directory untuk folder dokumen registrasi penyedia
     * @return type
     */
    public static function pathDokRegistrasiPenyediaDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/dokpenyedia/';
    }

    /**
     * url untuk mengakses file pada folder dokumen registrasi penyedia
     * @return type
     */
    public static function urlDokRegistrasiPenyediaDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/dokpenyedia/';
    }
    
    /**
     * path full directory untuk folder dokumen pendukung
     * @return type
     */
    public static function pathDokumenSSUKDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/dokssuk/';
    }

    /**
     * url untuk mengakses file pada folder dokumen pendukung
     * @return type
     */
    public static function urlDokumenSSUKDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/dokssuk/';
    }    
    
    /**
     * 
     * @return type
     */
    public static function  urlFileSkDirectory(){
        return Yii::app()->getBaseUrl('webroot').'/data/images/file-sk/';
    }

    /**
     * 
     * @return type
     */
    public static function pathFileSkDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/images/file-sk/';
    }
    
    /**
     * path full directory untuk folder dokumen persiapan pengadaan
     * @return type
     */
    public static function pathDokPersiapanPengadaanDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/dokpersiapanpengadaan/';
    }

    /**
     * url untuk mengakses file pada folder dokumen persiapan pengadaan
     * @return type
     */
    public static function urlDokPersiapanPengadaanDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/dokpersiapanpengadaan/';
    }
    
    /**
     * path full directory untuk folder dokumen rencana umum pengadaan
     * @return type
     */
    public static function pathDokRencanaUmumPengadaanDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/dokrencanaumumpengadaan/';
    }

    /**
     * url untuk mengakses file pada folder dokumen rencana umum pengadaan
     * @return type
     */
    public static function urlDokRencanaUmumPengadaanDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/dokrencanaumumpengadaan/';
    }
    
    /**
     * path full directory untuk folder dokumen persiapan pengadaan
     * @return type
     */
    public static function pathLampiranRiwayatPengadaanDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/riwayatpengadaan/';
    }

    /**
     * url untuk mengakses file pada folder dokumen persiapan pengadaan
     * @return type
     */
    public static function urlLampiranRiwayatPengadaanDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/riwayatpengadaan/';
    }
    
    //======================================Path Dokumen Penetapan Pemenang==============================================
    public static function pathPenetapanPemenangDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/penetapanpemenang/';
    }

    //====================================Akhir Path Penetapan Pemenang=====================================        
    
    //======================================Path Dokumen pengumuman Pemenang==============================================
    public static function pathPengumumanPemenangDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/pengumumanpemenang/';
    }

    //====================================Akhir Path pengumuman Pemenang=====================================
    
    //======================================Path Dokumen ba pengadaan langsung==============================================
    public static function pathBaPengadaanDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/bapengadaan/';
    }
    //====================================Akhir Path ba pengadaan langsung=====================================

    //======================================Path Dokumen Penunjukan penyedia==============================================
    public static function pathPenunjukanPenyediaDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/penunjukanpenyedia/';
    }
    //====================================Akhir Path Penunjukan penyedia=====================================
    
    /**
     * Directory folder penawaran penyedia
     * @return string
     */
    public static function pathPenawaranPenyediaFileDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/penawaranPenyedia/';
    }
    
    //======================================Path Dokumen ba negosiasi==============================================
    public static function pathBaNegosiasiDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/banegosiasi/';
    }
    //====================================Akhir Path ba negosiasi=====================================        
    
    /**
     * Lokasi upload file pada evaluasiPenawaran
     * @return type
     */
    public static function pathevaluasiPenawaranDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/evaluasiPenawaran/';
    }
    
    /**
     * url untuk mengakses file pada folder evaluasiPenawaran
     * @return type
     */
    public static function urlevaluasiPenawaranDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/evaluasiPenawaran/';
    }
    
    public static function urlFilePembukaanPenawaran()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/pembukaanpenawaran/';
    }        
    
    public static function pathFilePembukaanPenawaran()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/pembukaanpenawaran/';
    }
    
    /**
     * Lokasi upload file dan gambar berita acara
     * @return type
     */
    public static function pathberitaAcaraDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/all_file/dokumenpendukungBA/';
    }
    
    /**
     * url untuk mengakses file dan gambar pada folder surat eksternal
     * @return type
     */
    public static function urlberitaAcaraDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/all_file/dokumenpendukungBA/';
    }
    
    /**
     * Lokasi upload file dokumen spk
     * @return type
     */
    public static function pathdokumenSpkDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/pdf/dokumenspk/';
    }
    
    /**
     * url untuk mengakses file dokumen spk
     * @return type
     */
    public static function urldokumenSpkDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/pdf/dokumenspk/';
    }
    
    /**
     * path full directory untuk folder dokumen petunjuk transaksi
     * @return type
     */
    public static function pathPetunjukTransaksiDirectory()
    {
        return Yii::getPathOfAlias('webroot').'/data/images/petunjukTransaksi/';
    }

    /**
     * url untuk mengakses file pada folder petunjuk transaksi 
     * @return type
     */
    public static function urlPetunjukTransaksiDirectory()
    {
        return Yii::app()->getBaseUrl('webroot').'/data/images/petunjukTransaksi/';
    }

        //========================= Path Custom Antrian ==============================================
        
        public static function pathAntrianDirectory()
        {
            return Yii::getPathOfAlias('webroot').'/images/antrian/';
        }
        
        public static function pathAntrianCustomDirectory()
        {
            return Yii::getPathOfAlias('webroot').'/images/antrian/custom/';
        }
    
        public static function urlAntrianCustomDirectory()
        {
            return Yii::app()->getBaseUrl('webroot').'/images/antrian/custom/';
        }
    
    
    
    //======== path dan url FILE TIDAK DITEMUKAN ========
    public static function pathTidakDitemukan() {
        return Yii::getPathOfAlias('webroot') . '/data/';
    }

    public static function urlTidakDitemukan() {
        return Yii::app()->getBaseUrl('webroot') . '/data/';
    }
    
    public function getLoketRJP() {
        return array(1, 2);
    }

    public static function getListTahun($mulai = null, $lama = 100) {
        $res = array();
        if (empty($mulai))
            $mulai = date('Y');
        for ($i = 0; $i < $lama; $i++) {
            $res[$mulai + $i] = $mulai + $i;
        }

        return $res;
    }

    public static function getBulan3() {
        return array(
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        );
    }

    public static function getBulan2() {
        return array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        );
    }

    public static function getBulan() {
        return array(
            '01' => 'Januari ' . date('Y'),
            '02' => 'Februari ' . date('Y'),
            '03' => 'Maret ' . date('Y'),
            '04' => 'April ' . date('Y'),
            '05' => 'Mei ' . date('Y'),
            '06' => 'Juni ' . date('Y'),
            '07' => 'Juli ' . date('Y'),
            '08' => 'Agustus ' . date('Y'),
            '09' => 'September ' . date('Y'),
            '10' => 'Oktober ' . date('Y'),
            '11' => 'November ' . date('Y'),
            '12' => 'Desember ' . date('Y')
        );
    }

    /**
     * Load bulan tanpa tahun
     * @return type
     */
    public static function getBulanTanpaTahun()
    {
        return array(
            'Januari' => 'Januari',
            'Februari' => 'Februari',
            'Maret' => 'Maret',
            'April' => 'April',
            'Mei' => 'Mei',
            'Juni' => 'Juni',
            'Juli' => 'Juli',
            'Agustus' => 'Agustus',
            'September' => 'September',
            'Oktober' => 'Oktober',
            'November' => 'November',
            'Desember' => 'Desember'
        );
    }
    
    public static function getArrayInstalasiPelayanan() {
        return array(Params::INSTALASI_ID_RJ, //frawat jalan
            Params::INSTALASI_ID_RI, //rawat inap
            Params::INSTALASI_ID_RD, //rawat darurat
            Params::INSTALASI_ID_IBS, //bedah sentral
            Params::INSTALASI_ID_LAB, //laboratorium
            Params::INSTALASI_ID_RAD, //radiologi
                //Params::INSTALASI_ID_RM,//rehab medis
        ); //gizi
    }

    //Params::INSTALASI_ID_ICU.','.//fisioterapi
    public static function getInstalasiPenunjang() {
        return
                Params::INSTALASI_ID_IBS . ',' . //bedah sentral
                Params::INSTALASI_ID_RAD . ',' . //radiologi
                Params::INSTALASI_ID_REHAB . ',' . //rehabilitasi
                Params::INSTALASI_ID_LAB . ',' . //laboratorium
                Params::INSTALASI_ID_JZ . ',' . //pemulasaran jenazah
                Params::INSTALASI_ID_GIZI; //gizi
    }

    public static function getInstalasiJadwalPoli() {
        return
                Params::INSTALASI_ID_RD . ',' . //rawat darurat
                Params::INSTALASI_ID_RJ . ',' . //rawat jalan
                Params::INSTALASI_ID_IBS . ',' . //bedah sentral
                Params::INSTALASI_ID_RAD . ',' . //radiologi
                Params::INSTALASI_ID_REHAB . ',' . //rehabilitasi
                Params::INSTALASI_ID_LAB . ',' . //laboratorium
                Params::INSTALASI_ID_JZ; //pemulasaran jenazah
        //gizi//Params::INSTALASI_ID_GIZI
    }

    public static function getArrayInstalasiPenunjang() {
        return array(Params::INSTALASI_ID_ICU, //fisioterapi
            Params::INSTALASI_ID_IBS, //bedah sentral
            Params::INSTALASI_ID_RAD, //radiologi
            Params::INSTALASI_ID_REHAB, //rehabilitasi
            Params::INSTALASI_ID_LAB, //laboratorium
            Params::INSTALASI_ID_JZ, //pemulasaran jenazah
            Params::INSTALASI_ID_GIZI); //gizi
    }    

    /**
     * - digunakan untuk menampilkan dropdown instalasi pada laporan biaya pelayanan pada modul billing kasir
     * @added		5 Pebruari 2018
     * @return	type
     */
    public static function getArrayInstalasiBiayaPelayanan() {
        return array(
            Params::INSTALASI_ID_IBS, //bedah sentral
            Params::INSTALASI_ID_LAB, //laboratorium
            Params::INSTALASI_ID_RAD, //radiologi
            Params::INSTALASI_ID_RJ, //frawat jalan
            Params::INSTALASI_ID_RI, //rawat inap
            Params::INSTALASI_ID_RD, //rawat darurat
                //Params::INSTALASI_ID_RM,//rehab medis
        ); //gizi
    }

    public static function getUmur($tglLahir) {
        $dob = $tglLahir;
        $today = date("Y-m-d");
        list($y, $m, $d) = explode('-', $dob);
        list($ty, $tm, $td) = explode('-', $today);
        if ($td - $d < 0) {
            $day = ($td + 30) - $d;
            $tm--;
        } else {
            $day = $td - $d;
        }
        if ($tm - $m < 0) {
            $month = ($tm + 12) - $m;
            $ty--;
        } else {
            $month = $tm - $m;
        }
        $year = $ty - $y;

        return str_pad($year, 2, '0', STR_PAD_LEFT); //.' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
    }

    public static function getStatusTerima() {
        return array(
            1 => 'Sudah Diterima',
            2 => 'Belum Diterima '
        );
    }

    public static function getStatusPromosi() {
        return array(
            'DISETUJUI' => 'DISETUJUI',
            'DITOLAK' => 'DITOLAK'
        );
    }

    public static function caraPembayaran() {
        return array(
            'TUNAI' => 'TUNAI',
            'TRANSFER' => 'TRANSFER',
            'TABUNGAN' => 'TABUNGAN',
        );
    }

    public static function jenisPinjaman() {
        return array(
            'UANG' => 'UANG',
            'BARANG' => 'BARANG',
        );
    }

    public static function caraBayarPinjaman() {
        return array(
            'TUNAI' => 'TUNAI',
            'TRANSFER' => 'TRANSFER',
            'TABUNGAN' => 'TABUNGAN',
        );
    }

    public static function satuanWaktu() {
        return array(
            'BULAN' => 'BULAN',
            'TAHUN' => 'TAHUN',
        );
    }

    public static function statusPinjaman() {
        return array(
            'LUNAS' => 'LUNAS',
            'BELUM LUNAS' => 'BELUM LUNAS',
        );
    }

    public static function getAllVendor() {
        return array(
            Params::PERANPENGGUNA_ID_ADMIN,
            Params::PERANPENGGUNA_ID_SUPPORT
        );
    }

    public static function cekAkses($akses) {
        $vendor = Params::getAllVendor();
        $cek = false;
        $ak = explode(',', $akses);

        foreach ($vendor as $sys) {

            foreach ($ak as $a) {
                if ($a == $sys) {
                    $cek = true;
                }
            }
        }

        return $cek;
    }

    public static function cekAksesSysAdmin($akses) {
        $vendor = Params::getAllVendor();
        $cek = false;
        $ak = explode(',', $akses);

        foreach ($vendor as $sys) {

            foreach ($ak as $a) {
                if ($a == Params::PERANPENGGUNA_ID_ADMIN || $a == Params::PERANPENGGUNA_ID_SUPPORT) {
                    $cek = true;
                }
            }
        }

        return $cek;
    }

    public static function getMenuVendor() {
        return array(
            'modulk' => true,
            'menumodulk' => true,
        );
    }

    /**
     * - digunakan untuk mengsinkronisasi data apotek, ke instalasi pelayanan rawat inap, darurat dan jalan
     * @return type
     */
    public static function getInsPelByApotek($r) {
        $dt = array();
        if (strtolower($r->ruangan_nama) == 'apotek') {
            $dt = array(
                Params::INSTALASI_ID_RJ,
                Params::INSTALASI_ID_RD,
                Params::INSTALASI_ID_RI,
            );
        } elseif (strtolower($r->ruangan_nama) == 'apotek rawat jalan') {
            $dt = array(
                Params::INSTALASI_ID_RJ,
            );
        } else { // apotek umum
            $dt = array(
                Params::INSTALASI_ID_RD,
                Params::INSTALASI_ID_RI,
            );
        }

        return $dt;
    }

    public static function getColorStPromosi($st) {
        $dt = array(
            'DISETUJUI' => 'btn btn-success nohover',
            'DITOLAK' => 'btn btn-danger nohover'
        );

        return isset($dt[$st]) ? $dt[$st] : null;
    }

    /**
     * - digunakan untuk menmapilkan warna status pada, status pengiriman (pemesanan obat alkes)
     * @param type $st
     * @return type
     */
    public static function getColorStPengiriman($st) {
        $dt = array(
            self::STATUS_PENGIRIMANOA_PENDING => 'btn btn-info',
            self::STATUS_PENGIRIMANOA_IN_PROGRESS => 'btn btn-warning txthitam',
            self::STATUS_PENGIRIMANOA_READY => 'btn btn-success',
        );

        return isset($dt[$st]) ? $dt[$st] : null;
    }

    public static function getChangeStPengiriman($st) {
        $dt = array(
            self::STATUS_PENGIRIMANOA_PENDING => self::STATUS_PENGIRIMANOA_IN_PROGRESS,
            self::STATUS_PENGIRIMANOA_IN_PROGRESS => self::STATUS_PENGIRIMANOA_READY
        );

        return isset($dt[$st]) ? $dt[$st] : null;
    }

    public static function getChangeOdontogram($st) {
        $dt = array(
            13 => 13,
            12 => 12,
            11 => 11,
            21 => 21,
            22 => 22,
            23 => 23,
            53 => 53,
            52 => 52,
            51 => 51,
            61 => 61,
            62 => 62,
            63 => 63,
            83 => 83,
            82 => 82,
            81 => 81,
            71 => 71,
            72 => 72,
            73 => 73,
            43 => 43,
            42 => 42,
            41 => 41,
            31 => 31,
            32 => 32,
            33 => 33,
        );

        return isset($dt[$st]) ? $dt[$st] : null;
    }

    /**
     * - digunakan untuk kolom riwayatjatuh_penilaian, diagnosismedis_penilaian
     * @return type
     */
    public static function getPilihanJawaban() {
        return array(
            self::JAWAB_YA => 'Ya',
            self::JAWAB_TIDAK => 'Tidak'
        );
    }

    /**
     * - digunakan untuk kolom alatbantujalan_penilaian
     * @return type
     */
    public static function getAlatBantu() {
        return array(
            self::ALAT_BANTU_1 => ucwords(strtolower(self::ALAT_BANTU_1)),
            self::ALAT_BANTU_2 => ucwords(strtolower(self::ALAT_BANTU_2)),
            self::ALAT_BANTU_3 => ucwords(strtolower(self::ALAT_BANTU_3))
        );
    }

    /**
     * - digunakan untuk menampung data komponen tarif yang digunakan pada laporan rekap jasa dokter
     * @return type
     */
    public static function getKomponenTarifLapJasaDokter() {
        return array(
            self::KOMPONENTARIF_ID_JASA_MEDIS,
            self::KOMPONENTARIF_ID_JASA_SPESIALIS,
            self::KOMPONENTARIF_ID_JASA_UMUM,
            self::KOMPONENTARIF_ID_JASA_ANASTESI,
            self::KOMPONENTARIF_ID_JASA_OPERATOR,
            self::KOMPONENTARIF_ID_JASA_DR_ANAK,
            self::KOMPONENTARIF_ID_JASA_DR_TOLONG_BAYI,
        );
    }

    /**
     * - digunakan untuk kolom caraberjalan_penilaian
     * @return type
     */
    public static function getCara() {
        return array(
            self::CARA_BERJALAN_1 => ucwords(strtolower(self::CARA_BERJALAN_1)),
            self::CARA_BERJALAN_2 => ucwords(strtolower(self::CARA_BERJALAN_2)),
            self::CARA_BERJALAN_3 => ucwords(strtolower(self::CARA_BERJALAN_3))
        );
    }

    /**
     * - digunakan untuk kolom statusmental_penilaian
     * @return type
     */
    public static function getStatusMental() {
        return array(
            self::STATUS_MENTAL_1 => ucwords(strtolower(self::STATUS_MENTAL_1)),
            self::STATUS_MENTAL_2 => ucwords(strtolower(self::STATUS_MENTAL_2)),
        );
    }

    /**
     * - digunakan untuk melakukan pemeriksaan jika status kehadiran selain HADIR
     * @param type $hadir
     */
    public static function getStatusHadir($hadir) {
        $dt = array(
            Params::STATUSKEHADIRAN_SAKIT => 'Sakit',
            Params::STATUSKEHADIRAN_IZIN => 'Izin',
            Params::STATUSKEHADIRAN_DINAS => 'Dinas',
            Params::STATUSKEHADIRAN_ALPHA => 'Alpha',
        );

        if (isset($dt[$hadir])) {
            return $dt[$hadir];
        } else {
            return '';
        }
    }

    /**
     * - digunakan untuk melakukan mencari kehadiran tanpa status hadir
     */
    public static function getKehadiranTanpaHadir() {
        return array(
            Params::STATUSKEHADIRAN_SAKIT,
            Params::STATUSKEHADIRAN_IZIN,
            Params::STATUSKEHADIRAN_DINAS,
            Params::STATUSKEHADIRAN_ALPHA
        );
    }

    /**
     * - digunakan untuk melakukan pemeriksaan jika instalasi bukan rawat darurat dan rawat inap
     * @param type $hadir
     */
    public static function getModulRDRI($ins) {
        $dt = array(
            self::MODUL_ID_RD => 'Rawat Darurat',
            self::MODUL_ID_RI => 'Rawat Inap',
            self::MODUL_ID_PERSALINAN => 'Persalinan',
                // self::MODUL_ID_REHABMEDIS => 'Rehab Medis',
        );

        if (isset($dt[$ins])) {
            return $dt[$ins];
        } else {
            return '';
        }
    }

    /**
     * - digunakan untuk menampilkan data pada reflect pupil
     * @return type
     */
    public static function getReflectPupil() {
        return array(
            true => 'Positif',
            false => 'Negatif',
        );
    }

    /**
     * - digunakan untuk menampilkan data pada pembesaran KGB
     * @return type
     */
    public static function getPembesaranKGB() {
        return array(
            true => 'Positif',
            false => 'Negatif'
        );
    }

    /**
     * - digunakan untuk menampilkan data pada Reflek Cahaya
     * @return type
     */
    public static function getReflek(){
        return array(
            true => 'Positif',
            false => 'Negatif'
        );
    }

    /**
     * - digunakan untuk menampilkan data pada pembesaran kelenjar thyroid
     * @return type
     */
    public static function getPembesaranThroid() {
        return array(
            true => 'Positif',
            false => 'Negatif'
        );
    }

    /**
     * - digunakan untuk menampilkan data pada jvp
     * @return type
     */
    public static function getJVP() {
        return array(
            true => 'Meningkat',
            false => 'Tidak Meningkat'
        );
    }

    /**
     * - digunakan untuk menampilkan data pada jvp
     * @return type
     */
    public static function getDataKepalaLeher() {
        return array(
            // 'isanemia' => 'Anemia',
            // 'isleterus' => 'Leterus',
            // 'iscyanosis' => 'Cyanosis',
            // 'isdyspneu' => 'Dyspneu',
            'isanemia' => 'Normal',
            'isleterus' => 'Anemic',
            'iscyanosis' => 'Icterus',
            'isdyspneu'=>'',
        );
    }

    /**
     * - digunakan untuk mengubah nilai boolean menjadi 0 atau 1
     * @return type
     */
    public static function gantiBoolean($st) {
        $data = array(
            false => '0',
            true => '1',
        );

        if (isset($data[$st])) {
            return $data[$st];
        } else {
            return '';
        }
    }

    /**
     * - digunakan untuk kolom status_cuti
     * @return type
     */
    public static function getStatusCuti() {
        return array(
            self::STATUS_CUTI_DISETUJUI => ucwords(strtolower(self::STATUS_CUTI_DISETUJUI)),
            self::STATUS_CUTI_DITOLAK => ucwords(strtolower(self::STATUS_CUTI_DITOLAK)),
            self::STATUS_CUTI_PENGAJUAN => ucwords(strtolower(self::STATUS_CUTI_PENGAJUAN)),
        );
    }

    public static function getSatuanDate($date) {
        $dt = array(
            'bulan' => 'month',
            'tahun' => 'year',
            'month' => 'month',
            'year' => 'year',
        );

        return isset($dt[strtolower($date)]) ? $dt[$date] : '';
    }

    public static function getUnitKeuangan($data) {
        $dt = array(
            self::UNITKERJA_ID_BENDAHARA => self::UNITKERJA_ID_BENDAHARA,
            self::UNITKERJA_ID_FINANCE => self::UNITKERJA_ID_FINANCE,
            self::UNITKERJA_ID_KEUANGAN => self::UNITKERJA_ID_KEUANGAN
        );

        return isset($dt[strtolower($data)]) ? $dt[$data] : '';
    }

    public static function getTindakLanjutRujuk() {
        return array(
            'RS' => 'RS',
            'PUSKESMAS' => 'PUSKESMAS',
            'DOKTER KELUARGA' => 'DOKTER KELUARGA',
            'DOKTER' => 'DOKTER',
            'HOME CARE' => 'HOME CARE',
        );
    }

    public static function getKruBedahLookup() {
        return array(
            self::KRUBEDAH_OPERATOR,
            self::KRUBEDAH_ASISTEN_OPERATOR,
            self::KRUBEDAH_DOKTER_ANESTESI,
            self::KRUBEDAH_ASISTEN_ANESTESI,
            self::KRUBEDAH_PENATA_ANESTESI,
            self::KRUBEDAH_PETUGAS_RR,
            self::KRUBEDAH_PERAWAT_INSTRUMENT,
            self::KRUBEDAH_PERAWAT_SIRKULER,
            self::KRUBEDAH_PERAWAT_ANESTESI
        );
    }

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status periksa
     */
    public static function getWrStatusPeriksa($status) {
        $status = trim($status);
        if ($status == "SEDANG PERIKSA") {
            $status = '<a class="btn btn-warning nohover">' . $status . '</a>';
        } else if ($status == "ANTRIAN") {
            $status = '<a class="btn btn-primary nohover">' . $status . '</a>';
        } else if ($status == "SUDAH PULANG") {
            $status = '<a class="btn btn-info nohover">' . $status . '</a>';
        } else if ($status == "SUDAH DI PERIKSA") {
            $status = '<a class="btn btn-secondary nohover">' . $status . '</a>';
        } else if ($status == "SEDANG DIRAWAT INAP") {
            $status = '<a class="btn btn-success nohover">' . $status . '</a>';
        } else if ($status == "MENUNGGU ADMISI PASIEN") {
            $status = '<a class="btn btn-danger nohover">' . $status . '</a>';
        } else {
            $status = '<a class="btn btn-default nohover">' . $status . '</a>';
        }
        return $status;
    }

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status
     */
    public static function getWrStatusHasil($status) {
        $status = trim($status);
        if ($status == Params::STATUSPERIKSAHASIL_BELUM) {
            $status = '<button class="btn btn-danger nohover">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSAHASIL_SUDAH) {
            $status = '<button class="btn btn-blue nohover">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSAHASIL_SEDANG) {
            $status = '<button class="btn btn-gold nohover">' . $status . '</button>';
        }
        return $status;
    }

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status
     */
    public static function getWrStatusBedah($status) {
        $status = trim($status);
        if ($status == Params::STATUSPERIKSABEDAH_MULAI) {
            $status = '<button class="btn btn-gold nohover">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSABEDAH_RENCANA) {
            $status = '<button class="btn btn-info nohover">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSABEDAH_SELESAI) {
            $status = '<button class="btn btn-success nohover">' . $status . '</button>';
        }
        return $status;
    }

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status
     */
    public static function getWrStatusOperasi($status) {
        $status = trim($status);
        if ($status == Params::STATUSPERIKSAHASIL_BELUM) {
            $status = '<button class="btn btn-danger nohover">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSAHASIL_SUDAH) {
            $status = '<button class="btn btn-blue nohover">' . $status . '</button>';
        } else if ($status == Params::STATUSPERIKSAHASIL_SEDANG) {
            $status = '<button class="btn btn-gold nohover">' . $status . '</button>';
        }
        return $status;
    }

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status bayar
     */
    public static function getWrStatusBayar($status) {
        $status = trim($status);
        if ($status == Params::STATUSBAYAR_BELUM_LUNAS) {
            $status = '<button class="btn btn-danger nohover" style="color:white;">' . $status . '</button>';
        } else if ($status == Params::STATUSBAYAR_LUNAS) {
            $status = '<button class="btn btn-success nohover" style="color:white;">' . $status . '</button>';
        }
        return $status;
    }

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status posting
     */
    public static function getWrStatusPosting($status) {
        $status = trim($status);
        if ($status == Params::STATUS_POSTING_SUDAH) {
            $status = '<button class="btn btn-success nohover">' . $status . '</button>';
        } else if ($status == Params::STATUS_POSTING_BELUM) {
            $status = '<button class="btn btn-danger nohover">' . $status . '</button>';
        }
        return $status;
    }

    /**
     * cek nilai
     * @param type $nilai
     * @return string
     */
    public static function cekUjiKompatibilitas($nilai) {
        if (strpos($nilai, '+') === 0) {
            $st = Params::PENGUJIAN_GOLDARAH_POSITIF;
        } elseif (strpos($nilai, '-') === 0) {
            $st = Params::PENGUJIAN_GOLDARAH_NEGATIF;
        } else {
            $st = '';
        }

        return $st;
    }

    /**
     * cek status rilis, di transaksi pengujian kompatibilitas
     * @param type $st
     * @return type
     */
    public static function cekRilis($st) {
        $dt = array(
            self::STATUS_UJI_KOMPATIBILITAS_RELEASE => self::STATUS_UJI_KOMPATIBILITAS_RELEASE,
            'rilis' => 'rilis',
        );

        return isset($dt[$st]) ? $dt[$st] : '';
    }

    /**
     * generate semua rilis
     * @param type $st
     * @return type
     */
    public static function getRilis() {
        return array(
            'rilis' => 'rilis',
            self::STATUS_UJI_KOMPATIBILITAS_RELEASE => self::STATUS_UJI_KOMPATIBILITAS_RELEASE,
        );
    }

    /**
     * - digunakan untuk memberikan akses, pegawai tertentu saja yang bisa mengakses fungsi ini
     * @param type $data
     * @return type
     */
    public static function getPegawaiAksesRincianExcel($pegawai_id) {
        $dt = array(
            2 => 2, //dokter fadilla delima sandi
            68 => 68, //khusnul hotimal
        );

        return isset($dt[$pegawai_id]) ? $dt[$pegawai_id] : '';
    }

    /**
     * - digunakan mengubah hari menjadi angka
     * @param type $data
     * @return type
     */
    public static function getNumberByDays($days) {
        $dt = array(
            'SENIN' => 1,
            'SELASA' => 2,
            'RABU' => 3,
            'KAMIS' => 4,
            'JUMAT' => 5,
            'SABTU' => 6,
            'MINGGU' => 7,
        );

        return isset($dt[$days]) ? $dt[$days] : null;
    }   

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status kehadiran
     */
    public static function getWarnaKehadiran($status, $verifikasi = false, $data = null, $jabatanuser = null) {
//			if (in_array($data['jabatanuser_id'], array(Params::JABATAN_ID_KASI_PERSONALIA, Params::JABATAN_ID_HUMAN_RESOURCES))) {
        $onclick = '$("#dialogUbahPresensi").dialog("open");';
//			}else{
//
//                 $kasi = JabatanM::model()->findByPk(Params::JABATAN_ID_KASI_PERSONALIA);
//                 $adminPeg = JabatanM::model()->findByPk(Params::JABATAN_ID_HUMAN_RESOURCES);
//
//				 $onclick = 'myAlert("Hanya <b>'.$kasi['jabatan_nama'].'</b> dan <b>'.$adminPeg['jabatan_nama'].'</b> yang dapat mengakses fitur ini ","Perhatian !")';
//			}

        if (strtolower($status) == strtolower(Params::STATUSKEHADIRAN_NAMA_HADIR)) {
            if ($verifikasi == false || $verifikasi == null) {
                return CHtml::link("<button class = 'btn' style = 'background:#11ba01;border:1px solid #11ba01;'><i class='" . MyIcon::getIcons('ubah') . "'></i>" . $status . "</button>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahDataPresensi', array("pegawai_id" => $data['pegawai_id'], "tglpresensi" => $data['tglpresensi'], 'presensi_id' => array(
                                        'masuk' => $data['presensimasuk_id'],
                                        'keluar' => $data['presensikeluar_id'],
                                        'datang' => $data['presensidatang_id'],
                                        'pulang' => $data['presensipulang_id'],
                                        'shift_id' => $data['shift_id']
                            ))), array(
                            "target" => "frameUbahPresensi",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengubah data presensi",
                            "onclick" => $onclick
                ));
                //return "<button class = 'nohover btn' style = 'background:#11ba01;border:1px solid #11ba01;'>".$status."</button>";
            } else {
                return "<button class = 'nohover btn' style = 'background:#11ba01 !important;border:1px solid #11ba01;'>" . $status . "</button>";
            }
        } elseif (strtolower($status) == strtolower(Params::STATUSKEHADIRAN_NAMA_ALPHA)) {
            if ($verifikasi == false || $verifikasi == null) {
                return CHtml::link("<button class = 'btn' style = 'background:#c90202;border:1px solid #c90202;'><i class='" . MyIcon::getIcons('ubah') . "'></i>" . $status . "</button>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahDataPresensi', array("pegawai_id" => $data['pegawai_id'], "tglpresensi" => $data['tglpresensi'], 'presensi_id' => array(
                                        'masuk' => empty($data["jamscan_masuk"]) ? null : $data['presensimasuk_id'],
                                        'keluar' => $data['presensikeluar_id'],
                                        'datang' => $data['presensidatang_id'],
                                        'pulang' => empty($data['jamscan_pulang']) ? null : $data['presensipulang_id'],
                                        'shift_id' => $data['shift_id']
                            ))), array(
                            "target" => "frameUbahPresensi",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengubah data presensi",
                            "onclick" => $onclick
                ));
                //return "<button class = 'nohover btn' style = 'background:#c90202;border:1px solid #c90202;'>".$status."</button>";
            } else {
                return "<button class = 'nohover btn' style = 'background:#c90202;border:1px solid #c90202;'>" . $status . "</button>";
            }
        } elseif (strtolower($status) == strtolower(Params::STATUSKEHADIRAN_NAMA_SAKIT)) {
            if ($verifikasi == false || $verifikasi == null) {
                return CHtml::link("<button class = 'btn' style = 'background:#777271;border:1px solid #777271;'><i class='" . MyIcon::getIcons('ubah') . "'></i>" . $status . "</button>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahDataPresensi', array("pegawai_id" => $data['pegawai_id'], "tglpresensi" => $data['tglpresensi'], 'presensi_id' => array(
                                        'masuk' => $data['presensimasuk_id'],
                                        'keluar' => $data['presensikeluar_id'],
                                        'datang' => $data['presensidatang_id'],
                                        'pulang' => $data['presensipulang_id'],
                                        'shift_id' => $data['shift_id']
                            ))), array(
                            "target" => "frameUbahPresensi",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengubah data presensi",
                            "onclick" => $onclick
                ));
                //return "<button class = 'nohover btn' style = 'background:#777271;border:1px solid #777271;'>".$status."</button>";
            } else {
                return "<button class = 'nohover btn' style = 'background:#777271;border:1px solid #777271;'>" . $status . "</button>";
            }
        } elseif (strtolower($status) == strtolower(Params::STATUSKEHADIRAN_NAMA_IZIN)) {
            if ($verifikasi == false || $verifikasi == null) {
                return CHtml::link("<button class = 'btn' style = 'background:#0303a5;border:1px solid #0303a5;'><i class='" . MyIcon::getIcons('ubah') . "'></i>" . $status . "</button>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahDataPresensi', array("pegawai_id" => $data['pegawai_id'], "tglpresensi" => $data['tglpresensi'], 'presensi_id' => array(
                                        'masuk' => $data['presensimasuk_id'],
                                        'keluar' => $data['presensikeluar_id'],
                                        'datang' => $data['presensidatang_id'],
                                        'pulang' => $data['presensipulang_id'],
                                        'shift_id' => $data['shift_id']
                            ))), array(
                            "target" => "frameUbahPresensi",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengubah data presensi",
                            "onclick" => $onclick
                ));
                //return "<button class = 'nohover btn' style = 'background:#0303a5;border:1px solid #0303a5;'>".$status."</button>";
            } else {
                return "<button class = 'nohover btn' style = 'background:#0303a5;border:1px solid #0303a5;'>" . $status . "</button>";
            }
        } elseif (strtolower($status) == strtolower(Params::STATUSKEHADIRAN_NAMA_DINAS)) {
            if ($verifikasi == false || $verifikasi == null) {
                return CHtml::link("<button class = 'btn btn-primary' ><i class='" . MyIcon::getIcons('ubah') . "'></i>" . $status . "</button>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahDataPresensi', array("pegawai_id" => $data['pegawai_id'], 'presensi_id' => array(
                                        'masuk' => $data['presensimasuk_id'],
                                        'keluar' => $data['presensikeluar_id'],
                                        'datang' => $data['presensidatang_id'],
                                        'pulang' => $data['presensipulang_id'],
                                        'shift_id' => $data['shift_id']
                            ))), array(
                            "target" => "frameUbahPresensi",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengubah data presensi",
                            "onclick" => $onclick
                ));
                //return "<button class = 'nohover btn btn-primary' style = ''>".$status."</button>";
            } else {
                return "<button class = 'nohover btn btn-primary' style = ''>" . $status . "</button>";
            }
        } elseif (strtolower($status) == strtolower(Params::STATUSKEHADIRAN_NAMA_CUTI)) {
            if ($verifikasi == false || $verifikasi == null) {
                return CHtml::link("<button class = 'btn btn-info' ><i class='" . MyIcon::getIcons('ubah') . "'></i>" . $status . "</button>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahDataPresensi', array("pegawai_id" => $data['pegawai_id'], 'presensi_id' => array(
                                        'masuk' => $data['presensimasuk_id'],
                                        'keluar' => $data['presensikeluar_id'],
                                        'datang' => $data['presensidatang_id'],
                                        'pulang' => $data['presensipulang_id'],
                                        'shift_id' => $data['shift_id']
                            ))), array(
                            "target" => "frameUbahPresensi",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengubah data presensi",
                            "onclick" => $onclick
                ));
                //return "<button class = 'nohover btn btn-primary' style = ''>".$status."</button>";
            } else {
                return "<button class = 'nohover btn btn-info' style = ''>" . $status . "</button>";
            }
        }
    }

    /**
     * @author M Iqbal Laksana
     * @param type $pemeriksaandet_nama
     * @return string
     * - digunakan untuk memberikan warna hasil pemeriksaan lab
     * - hanya berlaku jika format cara pengisian hasil lab seperti berikut : 1-1/2-3/5-7/1-20 dan seterusnya
     */
    public static function hasilDetLabTextNumber($pemeriksaandet_nama) {
        $arr = array(
            'hitung jenis' => '2', //berarti ada banyak data
        );

        return isset($arr[strtolower($pemeriksaandet_nama)]) ? $arr[strtolower($pemeriksaandet_nama)] : '';
    }

    /**
     * @author M Iqbal Laksana
     * @return string
     * - digunakan untuk memfilter tidak menampilkan jenis jurnal yang disebut pada fungsi ini
     *
     */
    public static function notJnsJurnalPostUmum() {
        return array(
            self::JENISJURNAL_ID_PENERIMAAN_KAS,
            self::JENISJURNAL_ID_PENGELUARAN_KAS,
            self::JENISJURNAL_ID_HUTANG,
            self::JENISJURNAL_ID_PIUTANG,
            self::JENISJURNAL_ID_PERSEDIAAN
        );
    }

    /**
     * @author M Iqbal Laksana
     * @param type $unitkerja
     * @return string
     * - digunakan untuk memberikan warna hasil pemeriksaan lab
     * - hanya berlaku jika format cara pengisian hasil lab seperti berikut : 1-1/2-3/5-7/1-20 dan seterusnya
     */
    public static function cekUnitReturTerimaOa($unitkerja, $modul) {
        $arr['gudangfarmasi'] = array(
            Params::UNITKERJA_ID_FARMASI => 'UNIT FARMASI', //berarti ada banyak data
            Params::UNITKERJA_ID_PURCHASING => 'PURCHASING', //berarti ada banyak data
        );

        $arr['keuangan'] = array(
            Params::UNITKERJA_ID_KEUANGAN => 'UNIT KEUANGAN', //berarti ada banyak data
        );

        return isset($arr[$modul][($unitkerja)]) ? $arr[$modul][($unitkerja)] : '';
    }

    public static function getDropStatusScan() {
        return array(
            'terlambat' => 'Terlambat',
            'pulangawal' => 'Pulang Awal',
        );
    }

    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk melakukan pemeriksaan untuk generate status kehadiran sesuai perhitungan terlambat dan lainnya
     * @param type $hadir
     */
    public static function getCekStatusHadir($hadir) {
        $dt = array(
            Params::STATUSKEHADIRAN_SAKIT => 'Sakit',
            Params::STATUSKEHADIRAN_IZIN => 'Izin',
            Params::STATUSKEHADIRAN_DINAS => 'Dinas',
            Params::STATUSKEHADIRAN_ALPHA => 'Alpha',
            Params::STATUSKEHADIRAN_HADIR => 'Hadir',
        );

        if (isset($dt[$hadir])) {
            return $dt[$hadir];
        } else {
            return '';
        }
    }

    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk melakukan pemeriksaan jika status scan yang diinginkan ada pada list dibawah ini
     * @param type $hadir
     */
    public static function getCekStatusScan($hadir) {
        $dt = self:: getDropStatusScan();

        if (isset($dt[$hadir])) {
            return $dt[$hadir];
        } else {
            return '';
        }
    }

    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk mencatatkan jabatan mana saja yang dapat mengakses fitur rencana lembur
     * @param type $hadir
     */
    public static function getKepalaUnitApp() {
        return array(
            self::JABATAN_ID_KASI_PERSONALIA,
            self::JABATAN_ID_KA_BAG_ADMIN_UMUM
        );
    }

    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk mencatatkan jabatan mana saja yang dapat mengakses fitur rencana lembur dalam pengkondi-an IF
     * @param type $hadir
     */
    public static function getKepalaUnitAppByArr($j) {
        $dt = array(
            self::JABATAN_ID_KASI_PERSONALIA => self::JABATAN_ID_KASI_PERSONALIA,
            self::JABATAN_ID_KA_BAG_ADMIN_UMUM => self::JABATAN_ID_KA_BAG_ADMIN_UMUM
        );

        if (isset($dt[$j])) {
            return $dt[$j];
        } else {
            return '';  
        }
    }
    
    /*
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk mencatatkan jabatan penanggung jawab ruanganya/instalasi masing - masing
     * @param type $hadir
     */
    public static function getCekJabatanPJRuang($j, $jenis) {
        if ($jenis == 'ruangan') {
            $dt = array(
                self::JABATAN_ID_PJI_BEDAH => self::RUANGAN_ID_BEDAH,
                self::JABATAN_ID_PJI_RI => self::RUANGAN_ID_NURSE_STATION,
                self::JABATAN_ID_PJI_RD => self::RUANGAN_ID_PERAWATAN_DARURAT,
                self::JABATAN_ID_PJI_FARMASI => self::RUANGAN_ID_APOTEK_1,
                self::JABATAN_ID_PJI_PERSALINAN => self::RUANGAN_ID_VERLOS_KAMER,
                self::JABATAN_ID_PJI_LAB => self::RUANGAN_ID_LAB_KLINIK,
                self::JABATAN_ID_PJI_GIZI => self::RUANGAN_ID_GIZI,
            );
        } elseif ($jenis == 'instalasi') {
            $dt = array(
                self::JABATAN_ID_PJI_RJ => self::INSTALASI_ID_RJ,
            );
        }

        if (isset($dt[$j])) {
            return $dt[$j];
        } else {
            return '';
        }
    }

    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * - digunakan untuk mencatatkan jabatan mana saja yang biasanya dapat mengendarai mobil ambulance jasa trasportasi
     * @param type $hadir
     */
    public static function getPegSupirByJab() {
        return array(
            self::JABATAN_ID_DRIVER,
            self::JABATAN_ID_PJI_SECURITY,
            self::JABATAN_ID_SECURITY,
            self::JABATAN_ID_KESLING,
            self::JABATAN_ID_LAUNDRY,
        );
    }

    public static function getJenisJasa() {
        return array(
            'rs' => 'Jasa Tenaga Medis RS',
            'askep' => 'Asuhan Keperawatan',
            'farmasi' => 'Jasa Farmasi',
            'laundry' => 'Jasa Laundry',
            'sopir' => 'Jasa Sopir',
            'radio' => 'Jasa Radiografer',
            'paramedis' => 'Jasa Paramedis',
        );
    }

    /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status
     */
    public static function getWrStatusPengajuanGaji($status) {
        $status = trim($status);
        if ($status == 'BELUM') {
            $status = '<button class="btn btn-danger nohover">' . $status . '</button>';
        } else if ($status == 'SUDAH') {
            $status = '<button class="btn btn-success nohover">' . $status . '</button>';
        }
        return $status;
    }

    public static function grupInstalasiRJID() {
        return array(
            self::INSTALASI_ID_RJ,
        );
    }

    public static function grupInstalasiRJ() {
        return CHtml::listData(InstalasiM::model()->findAllByAttributes(array(
                            'instalasi_id' => self::grupInstalasiRJID(),
                                ), array(
                            'order' => 'instalasi_id',
                        )), 'instalasi_id', 'instalasi_nama');
    }

    public static function cekHiddenHargaGudangUmum() {
        // $konfig = KonfigsystemK::model()->find();
        // $classHidden = false;
        // if (isset($konfig->tampilhargagu)) {
        //     if ($konfig->tampilhargagu == true) {
        //         if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_PURCHASING) {
        //             $classHidden = true;
        //         }
        //     }
        // }
        // if ($classHidden == false) {
        //     if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_FINANCE) {
                $classHidden = true;
        //     }
        // }
        return $classHidden;
    }

     public static function cekHiddenHargaGudangFarmasi() {
        //   $konfig = KonfigsystemK::model()->find();
        //     $classHidden = false;
        //     if(isset($konfig->tampilhargagf)){
        //         if($konfig->tampilhargagf==true){
        //             if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_PURCHASING){
                        $classHidden = true;
            //         }
            //     }
            // }
            // if($classHidden==false){
            //     if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_FINANCE){
            //         $classHidden = true;
            //     }
            // }

        return $classHidden;
    }

    public static function cekHiddenHargaGizi() {
        $konfig = KonfigsystemK::model()->find();
        $classHidden = false;
        if (isset($konfig->tampilhargagz)) {
            if ($konfig->tampilhargagz == true) {
                if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_PURCHASING) {
                    $classHidden = true;
                }
            }
        }
        if ($classHidden == false) {
            if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_FINANCE) {
                $classHidden = true;
            }
        }
        return $classHidden;
    }

    public static function getInsPatologiKlinik() {
        $dt = array(
            5,
            105,
            106,
            107,
            109,
            114,
            115,
            119,
            195
        );

        return $dt;
    }

    public static function getInsPatologiAnatomi() {
        $dt = array(
            92, 113
        );

        return $dt;
    }

    public static function getInsMikrobiologiKlinik() {
        $dt = array(
            90, 108
        );

        return $dt;
    }

    /**
     * @author M Iqbal Laksana
     * @param  type $status
     * @return string
     * - digunakan untuk memberikan warna pada status tindakan (status hd)
     */
    public static function getWrStatusTindakan($status) {
        $status = trim($status);
        if ($status == "SEDANG TINDAKAN") {
            $status = '<a id="red" class="btn btn-gold nohover" name="yt1" style="width:150px;">' . $status . '</a>';
        } elseif ($status == "ANTRIAN") {
            $status = '<a id="green" class="btn btn-black nohover" style="color:#fff;width:150px;">' . $status . '</a>';
        } elseif ($status == "SELESAI TINDAKAN") {
            $status = '<a id="blue" class="btn btn-green nohover"  style="color:#fff;width:150px;">' . $status . '</a>';
        } else {
            $status = '<a id="orange" class="btn btn-danger nohover" style="width:150px;">' . $status . '</a>';
        }
        return $status;
    }

    public static function urlAmbilObatDirectory()
	{
		return Yii::app()->getBaseUrl('webroot').'/data/images/ambilobat/';    //Untuk Menampilkan Gambar Tumbs Pasien
	}

    public static function getListKasbon() {
        return array(
            self::STATUS_PENGAJUAN_KASBON_PENGAJUAN => self::STATUS_PENGAJUAN_KASBON_PENGAJUAN,
            self::STATUS_PENGAJUAN_KASBON_PERSETUJUAN => self::STATUS_PENGAJUAN_KASBON_PERSETUJUAN,
            self::STATUS_PENGAJUAN_KASBON_DISETUJUI => self::STATUS_PENGAJUAN_KASBON_DISETUJUI
        );
    }

    public static function getStatusKasbon($status) {
        if ($status == self::STATUS_PENGAJUAN_KASBON_PENGAJUAN) {
            $status = '<a id="red" class="btn btn-gold nohover" name="yt1" style="width:150px;">' . $status . '</a>';
        } elseif ($status == self::STATUS_PENGAJUAN_KASBON_PERSETUJUAN) {
            $status = '<a id="green" class="btn btn-black nohover" style="color:#fff;width:150px;">' . $status . '</a>';
        } elseif ($status == self::STATUS_PENGAJUAN_KASBON_DISETUJUI) {
            $status = '<a id="blue" class="btn btn-green nohover"  style="color:#fff;width:150px;">' . $status . '</a>';
        } else {
            $status = '<a id="orange" class="btn btn-danger nohover" style="width:150px;">' . $status . '</a>';
        }
        return $status;
    }

    public static function getDefaultProfilRS() {
        return Yii::app()->params['tambahan']['profilrs_id'];
    }
    public static function pathLogoLabel()
	{
		return Yii::getPathOfAlias('webroot').'/images/';
	}
        
    public static function grupInstalasiRIID() {
        return array(self::INSTALASI_ID_RI, self::INSTALASI_ID_ICU, 79, 38, 14, 85, 100, self::INSTALASI_ID_GIZI, self::INSTALASI_ID_RD);
    }

         /**
     * @author M Iqbal Laksana
     * @param type $status
     * @return string
     * - digunakan untuk memberikan warna pada status
     */
    public static function getWrStatusOperasiBS($status) {
        $status = trim($status);
        if ($status == 'RENCANA') {
            $status = '<button class="btn btn-secondary nohover">' . $status . '</button>';
        } else if ($status == 'MULAI') {
            $status = '<button class="btn btn-warning nohover">' . $status . '</button>';
        } else if ($status == 'SELESAI') {
            $status = '<button class="btn btn-success nohover">' . $status . '</button>';
        } else if ($status == 'BATAL') {
            $status = '<button class="btn btn-danger nohover">' . $status . '</button>';
        }
        return $status;
    }
}

?>
