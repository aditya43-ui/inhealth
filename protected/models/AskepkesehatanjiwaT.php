<?php

/**
 * This is the model class for table "askepkesehatanjiwa_t".
 *
 * The followings are the available columns in table 'askepkesehatanjiwa_t':
 * @property integer $askepkesehatanjiwa_id
 * @property integer $pendaftaran_id
 * @property integer $petugaspengisi_id
 * @property string $setting_pengakajian
 * @property integer $ruangan_id
 * @property string $puskesmas_nama
 * @property string $puskesmas_register
 * @property string $tgl_pengkajian
 * @property string $jam_pengkajian
 * @property integer $perawatpengkaji_id
 * @property string $informan_nama
 * @property string $informan_jeniskelamin
 * @property string $informan_umur
 * @property integer $informan_pekerjaan_id
 * @property string $informan_hubungandenganpasien
 * @property boolean $informan_istinggalserumah
 * @property integer $informan_rt
 * @property integer $informan_rw
 * @property integer $informan_kelurahan_id
 * @property string $informan_notelp
 * @property string $informan_nomobile
 * @property string $keluhanutama
 * @property string $riwayatpenyakit_sebelumnya
 * @property string $isadakeluarga_gangguanjiwa
 * @property string $pengalamantdk_menyenangkan
 * @property boolean $isriwayataniaya_fisik
 * @property boolean $isriwayataniaya_seksual
 * @property boolean $isriwayataniaya_penolakan
 * @property boolean $isriwayataniaya_kekerasandlmkeluarga
 * @property boolean $isriwayataniaya_tindakkriminal
 * @property string $riwayataniaya_penjelasan
 * @property string $genogram_gambar
 * @property string $genogram_penjelasan
 * @property string $pengambilankeputusan
 * @property string $polakomunikasi
 * @property string $presipitasi_peristiwabrdialami
 * @property string $presipitasi_perubahanadl
 * @property string $presipitasi_perubahanfisik
 * @property string $presipitasi_lingkunganpenuhkritik
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property integer $nadi
 * @property integer $pernapasan
 * @property double $suhutubuh
 * @property double $tinggibadan
 * @property double $beratbadan
 * @property string $hasilukur_bbtb
 * @property string $fisik_diagnosakeperawatan
 * @property string $konsepdiri_citratubuh
 * @property string $konsepdiri_identitas
 * @property string $konsepdiri_peran
 * @property string $konsepdiri_idealdiri
 * @property string $konsepdiri_hargadiri
 * @property string $hubsosial_orangterdekat
 * @property string $hubsosial_peransertadlmkegiatan
 * @property string $hubsosial_hambatandlmhubdgnoranglain
 * @property string $spiritual_nilaikeyakinan
 * @property string $spiritual_kegiatanibadah
 * @property string $spiritual_pengaruhterhadapkoping
 * @property string $caraberpakaian
 * @property string $caraberpakaian_penjelasan
 * @property string $caraberjalan_sikaptubuh
 * @property string $kebersihan
 * @property string $ekspresiwajah
 * @property string $pembicaraan_frekuensi
 * @property string $pembicaraan_volume
 * @property string $pembicaraan_karakteristik
 * @property string $pembicaraan_penjelasan
 * @property string $tingkataktivitas
 * @property string $jenisaktivitas
 * @property string $isyarattubuh
 * @property string $interaksiselama_wawancara
 * @property string $aktivitasmotorik_penjelasan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $petugaspengisi
 * @property RuanganM $ruangan
 * @property PegawaiM $perawatpengkaji
 */
class AskepkesehatanjiwaT extends CActiveRecord {

    public $instalasi_id;
    public $informan_kabupaten_id;
    public $informan_kecamatan_id;
    public $informan_propinsi_id;
    
    public $tgl_awal, $tgl_akhir;
    public $no_pendaftaran;
    public $pasien_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AskepkesehatanjiwaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'askepkesehatanjiwa_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, perawatpengkaji_id, create_time, create_loginpemakai, update_loginpemakai', 'required'),
            array('pendaftaran_id, petugaspengisi_id, ruangan_id, perawatpengkaji_id, informan_pekerjaan_id, informan_rt, informan_rw, informan_kelurahan_id, td_systolic, td_diastolic, nadi, pernapasan, create_ruangan_id', 'numerical', 'integerOnly' => true),
            array('suhutubuh, tinggibadan, beratbadan', 'numerical'),
            array('setting_pengakajian, informan_umur, informan_notelp, informan_nomobile, hasilukur_bbtb', 'length', 'max' => 50),
            array('puskesmas_nama, puskesmas_register, informan_nama, informan_hubungandenganpasien, hubsosial_orangterdekat, caraberpakaian, caraberpakaian_penjelasan', 'length', 'max' => 200),
            array('informan_jeniskelamin, isadakeluarga_gangguanjiwa', 'length', 'max' => 20),
            array('pembicaraan_frekuensi, pembicaraan_volume', 'length', 'max' => 30),
            array('pembicaraan_karakteristik, tingkataktivitas, isyarattubuh, create_loginpemakai, update_loginpemakai', 'length', 'max' => 100),
            array('keluhanfisik_penjelasan, keluhanfisik_status, informan_alamat, tgl_pengkajian, jam_pengkajian, informan_istinggalserumah, keluhanutama, riwayatpenyakit_sebelumnya, pengalamantdk_menyenangkan, isriwayataniaya_fisik, isriwayataniaya_seksual, isriwayataniaya_penolakan, isriwayataniaya_kekerasandlmkeluarga, isriwayataniaya_tindakkriminal, riwayataniaya_penjelasan, genogram_gambar, genogram_penjelasan, pengambilankeputusan, polakomunikasi, presipitasi_peristiwabrdialami, presipitasi_perubahanadl, presipitasi_perubahanfisik, presipitasi_lingkunganpenuhkritik, fisik_diagnosakeperawatan, konsepdiri_citratubuh, konsepdiri_identitas, konsepdiri_peran, konsepdiri_idealdiri, konsepdiri_hargadiri, hubsosial_peransertadlmkegiatan, hubsosial_hambatandlmhubdgnoranglain, spiritual_nilaikeyakinan, spiritual_kegiatanibadah, spiritual_pengaruhterhadapkoping, caraberjalan_sikaptubuh, kebersihan, ekspresiwajah, pembicaraan_penjelasan, jenisaktivitas, interaksiselama_wawancara, aktivitasmotorik_penjelasan, update_time', 'safe'),
            array('alamperasaan, alamperasaan_penjelasan, afek, afek_penjelasan, halusinasi, halusinasi_penjelasan, ilusi, depersonalisasi, derelisasi', 'safe'),
            array('bentukpikir,bentukpikir_jelaskan, aruspikir, aruspikir_jelaskan,isipikir,waham,waham_penjelasan,tingkatkesaradaran,tingakkesadaran_penjelasan,dayaingat,dayaingat_penjelasan,konsentasidanhitung,konsentasidanhitung_penjelasan,insight,insgiht_penjelasan', 'safe'),
            array('koping_adatif, koping_adatiflainnya, koping_maladatif, koping_malaadatiflainnya', 'safe'),
            array('masalahdlm_dukungankelompok,masalahdlm_dukungankelompokket,masalahhub_dengankelompok,masalahhub_dengankelompokket,masalahdgn_pendidikan,masalahdgn_pendidikanket,masalahdgn_pekerjaan,masalahdgn_pekerjaanket,masalahdgn_perumahan,masalahdgn_perumahanket,', 'safe'),
            array('kurangnyapendidikan,diagnosamedik,terapimedik,riwayat_penggunaanobat,hasilperiksa_lab,diagnosakeperawatan,', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('instalasi_id, tgl_awal, tgl_akhir, no_pendaftaran, askepkesehatanjiwa_id, pendaftaran_id, petugaspengisi_id, setting_pengakajian, ruangan_id, puskesmas_nama, puskesmas_register, tgl_pengkajian, jam_pengkajian, perawatpengkaji_id, informan_nama, informan_jeniskelamin, informan_umur, informan_pekerjaan_id, informan_hubungandenganpasien, informan_istinggalserumah, informan_rt, informan_rw, informan_kelurahan_id, informan_notelp, informan_nomobile, keluhanutama, riwayatpenyakit_sebelumnya, isadakeluarga_gangguanjiwa, pengalamantdk_menyenangkan, isriwayataniaya_fisik, isriwayataniaya_seksual, isriwayataniaya_penolakan, isriwayataniaya_kekerasandlmkeluarga, isriwayataniaya_tindakkriminal, riwayataniaya_penjelasan, genogram_gambar, genogram_penjelasan, pengambilankeputusan, polakomunikasi, presipitasi_peristiwabrdialami, presipitasi_perubahanadl, presipitasi_perubahanfisik, presipitasi_lingkunganpenuhkritik, td_systolic, td_diastolic, nadi, pernapasan, suhutubuh, tinggibadan, beratbadan, hasilukur_bbtb, fisik_diagnosakeperawatan, konsepdiri_citratubuh, konsepdiri_identitas, konsepdiri_peran, konsepdiri_idealdiri, konsepdiri_hargadiri, hubsosial_orangterdekat, hubsosial_peransertadlmkegiatan, hubsosial_hambatandlmhubdgnoranglain, spiritual_nilaikeyakinan, spiritual_kegiatanibadah, spiritual_pengaruhterhadapkoping, caraberpakaian, caraberpakaian_penjelasan, caraberjalan_sikaptubuh, kebersihan, ekspresiwajah, pembicaraan_frekuensi, pembicaraan_volume, pembicaraan_karakteristik, pembicaraan_penjelasan, tingkataktivitas, jenisaktivitas, isyarattubuh, interaksiselama_wawancara, aktivitasmotorik_penjelasan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'petugaspengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengisi_id'),
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'perawatpengkaji' => array(self::BELONGS_TO, 'PegawaiM', 'perawatpengkaji_id'),
            'informan_kelurahan' => array(self::BELONGS_TO, 'KelurahanM', 'informan_kelurahan_id'),
            'informan_pekerjaan' => array(self::BELONGS_TO, 'PekerjaanM', 'informan_pekerjaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'askepkesehatanjiwa_id' => 'Askepkesehatanjiwa',
            'pendaftaran_id' => 'Pendaftaran',
            'petugaspengisi_id' => 'Petugaspengisi',
            'setting_pengakajian' => 'Setting',
            'instalasi_id' => 'Instalasi',
            'ruangan_id' => 'Ruangan',
            'puskesmas_nama' => 'Puskesmas',
            'puskesmas_register' => 'No. Register',
            'tgl_pengkajian' => 'Tanggal Pengkajian',
            'jam_pengkajian' => 'Jam Pengkajian',
            'perawatpengkaji_id' => 'Perawat Pengkaji',
            'informan_nama' => 'Nama',
            'informan_jeniskelamin' => 'Jenis Kelamin',
            'informan_umur' => 'Umur',
            'informan_pekerjaan_id' => 'Pekerjaan',
            'informan_hubungandenganpasien' => 'Hubungan dengan pasien',
            'informan_istinggalserumah' => 'Tinggal serumah dengan pasien',
            'informan_rt' => 'RT',
            'informan_rw' => 'RW',
            'informan_kelurahan_id' => 'Kelurahan',
            'informan_notelp' => 'No. Telepon',
            'informan_nomobile' => 'No. Mobile',
            'keluhanutama' => 'Keluhan Utama',
            'riwayatpenyakit_sebelumnya' => 'Riwayat Kesehatan Sebelumnya',
            'isadakeluarga_gangguanjiwa' => 'Apakah ada anggota keluarga yang mengalami gangguan jiwa ?',
            'pengalamantdk_menyenangkan' => 'Pengalamantdk Menyenangkan',
            'isriwayataniaya_fisik' => 'Isriwayataniaya Fisik',
            'isriwayataniaya_seksual' => 'Isriwayataniaya Seksual',
            'isriwayataniaya_penolakan' => 'Isriwayataniaya Penolakan',
            'isriwayataniaya_kekerasandlmkeluarga' => 'Isriwayataniaya Kekerasandlmkeluarga',
            'isriwayataniaya_tindakkriminal' => 'Isriwayataniaya Tindakkriminal',
            'riwayataniaya_penjelasan' => 'Jelaskan',
            'genogram_gambar' => 'Genogram Gambar',
            'genogram_penjelasan' => 'Jelaskan',
            'pengambilankeputusan' => 'Pengambilan Keputusan (Judgement)',
            'polakomunikasi' => 'Polakomunikasi',
            'presipitasi_peristiwabrdialami' => 'Presipitasi Peristiwabrdialami',
            'presipitasi_perubahanadl' => 'Presipitasi Perubahanadl',
            'presipitasi_perubahanfisik' => 'Presipitasi Perubahanfisik',
            'presipitasi_lingkunganpenuhkritik' => 'Presipitasi Lingkunganpenuhkritik',
            'td_systolic' => 'Tekanan Darah',
            'td_diastolic' => 'Td Diastolic',
            'nadi' => 'Nadi',
            'pernapasan' => 'Pernapasan',
            'suhutubuh' => 'Suhu',
            'tinggibadan' => 'Tinggi Badan/ Penjang Badan',
            'beratbadan' => 'Berat Badan',
            'hasilukur_bbtb' => 'Hasil Ukur',
            'fisik_diagnosakeperawatan' => 'Fisik Diagnosakeperawatan',
            'konsepdiri_citratubuh' => 'Citra Tubuh',
            'konsepdiri_identitas' => 'Identitas',
            'konsepdiri_peran' => 'Peran',
            'konsepdiri_idealdiri' => 'Ideal Diri',
            'konsepdiri_hargadiri' => 'Harga Diri',
            'hubsosial_orangterdekat' => 'Orang Terdekat',
            'hubsosial_peransertadlmkegiatan' => 'Peran serta dalam kegiatan kelompok/ kegiatan',
            'hubsosial_hambatandlmhubdgnoranglain' => 'Hambatan dalam berhubungan dengan olang lain',
            'spiritual_nilaikeyakinan' => 'Nilai dan keyakinan',
            'spiritual_kegiatanibadah' => 'Kegiatan ibadah',
            'spiritual_pengaruhterhadapkoping' => 'Pengaruh spiritual terhadap koping individu',
            'caraberpakaian' => 'Cara Berpakaian',
            'caraberpakaian_penjelasan' => 'Jelaskan',
            'caraberjalan_sikaptubuh' => 'Cara Berjalan dan Sikap Tubuh',
            'kebersihan' => 'Kebersihan',
            'ekspresiwajah' => 'Ekspresi Wajah',
            'pembicaraan_frekuensi' => 'Frekuensi',
            'pembicaraan_volume' => 'Volume',
            'pembicaraan_karakteristik' => 'Karakteristik',
            'pembicaraan_penjelasan' => 'Jelaskan',
            'tingkataktivitas' => 'Tingkat Aktivitas',
            'jenisaktivitas' => 'Jenis Aktivitas',
            'isyarattubuh' => 'Isyarat Tubuh',
            'interaksiselama_wawancara' => 'Interaksi Selama Wawancara',
            'aktivitasmotorik_penjelasan' => 'Jelaskan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai' => 'Create Loginpemakai',
            'update_loginpemakai' => 'Update Loginpemakai',
            'create_ruangan_id' => 'Create Ruangan',
            'keluhanfisik_penjelasan' => 'Jelaskan',
            'keluhanfisik_status' => 'Keluhan Fisik',
            'alamperasaan'=>'Alam Perasaan',
            'alamperasaan_penjelasan'=>'Jelaskan',
            'afek'=>'Afek',
            'afek_penjelasan'=>'Jelaskan',
            'halusinasi'=>'Halusinasi',
            'halusinasi_penjelasan'=>'Jelaskan',
            'ilusi'=>'Ilusi',
            'depersonalisasi'=>'Depersonalisasi',
            'derelisasi'=>'Derelisasi',
            'bentukpikir'=>'Bentuk Pikir',
            'bentukpikir_jelaskan'=>'Jelaskan',
            'aruspikir'=>'Arus Pikir',
            'aruspikir_jelaskan'=>'Jelaskan',
            'isipikir'=>'Isi Pikir (Verbal maupun non verbal)',
            'waham'=>'Waham',
            'waham_penjelasan'=>'Jelaskan',
            'tingkatkesaradaran'=>'Tingkat Kesadaran',
            'tingakkesadaran_penjelasan'=>'Jelaskan',
            'dayaingat'=>'Daya Ingat',
            'dayaingat_penjelasan'=>'Jelaskan',
            'konsentasidanhitung'=>'Tingkat Konsentrasi dan Hitung',
            'konsentasidanhitung_penjelasan'=>'Jelaskan',
            'insight'=>'Insight',
            'insgiht_penjelasan'=>'Jelaskan',
            'koping_adatif'=>'Adatif',
            'koping_maladatif'=>'Maladatif',
            'masalahdlm_dukungankelompok' => 'Masalah dengan dukungan kelompok',
            'masalahdlm_dukungankelompokket' => 'Uraikan',
            'masalahhub_dengankelompok' => 'Masalah hubungan dengan lingkungan',
            'masalahhub_dengankelompokket' => 'Uraikan',
            'masalahdgn_pendidikan' => 'Masalah dengan pendidikan',
            'masalahdgn_pendidikanket' => 'Uraikan',
            'masalahdgn_pekerjaan' => 'Masalah dengan pekerjaan',
            'masalahdgn_pekerjaanket' => 'Uraikan',
            'masalahdgn_perumahan' => 'Masalah dengan perumahan',
            'masalahdgn_perumahanket' => 'Uraikan',
            'kurangnyapendidikan' => 'Kurangnya Pendidikan',
            'diagnosamedik' => 'Diagnosa Medik',
            'terapimedik' => 'Terapi Medik',
            'riwayat_penggunaanobat' => 'Riwayat Penggunaan Obat',
            'hasilperiksa_lab' => 'Hasil Pemeriksaan Laboratorium',
            'diagnosakeperawatan' => 'Diagnosa Keperawatan',
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

        $criteria->compare('t.askepkesehatanjiwa_id', $this->askepkesehatanjiwa_id);
        $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('t.petugaspengisi_id', $this->petugaspengisi_id);
        $criteria->compare('t.setting_pengakajian', $this->setting_pengakajian, true);
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('t.puskesmas_nama', $this->puskesmas_nama, true);
        $criteria->compare('t.puskesmas_register', $this->puskesmas_register, true);
        $criteria->compare('t.tgl_pengkajian', $this->tgl_pengkajian, true);
        $criteria->compare('t.jam_pengkajian', $this->jam_pengkajian, true);
        $criteria->compare('t.perawatpengkaji_id', $this->perawatpengkaji_id);
        $criteria->compare('t.informan_nama', $this->informan_nama, true);
        $criteria->compare('t.informan_jeniskelamin', $this->informan_jeniskelamin, true);
        $criteria->compare('t.informan_umur', $this->informan_umur, true);
        $criteria->compare('t.informan_pekerjaan_id', $this->informan_pekerjaan_id);
        $criteria->compare('t.informan_hubungandenganpasien', $this->informan_hubungandenganpasien, true);
        $criteria->compare('t.informan_istinggalserumah', $this->informan_istinggalserumah);
        $criteria->compare('t.informan_rt', $this->informan_rt);
        $criteria->compare('t.informan_rw', $this->informan_rw);
        $criteria->compare('t.informan_kelurahan_id', $this->informan_kelurahan_id);
        $criteria->compare('t.informan_notelp', $this->informan_notelp, true);
        $criteria->compare('t.informan_nomobile', $this->informan_nomobile, true);
        $criteria->compare('t.keluhanutama', $this->keluhanutama, true);
        $criteria->compare('t.riwayatpenyakit_sebelumnya', $this->riwayatpenyakit_sebelumnya, true);
        $criteria->compare('t.isadakeluarga_gangguanjiwa', $this->isadakeluarga_gangguanjiwa, true);
        $criteria->compare('t.pengalamantdk_menyenangkan', $this->pengalamantdk_menyenangkan, true);
        $criteria->compare('t.isriwayataniaya_fisik', $this->isriwayataniaya_fisik);
        $criteria->compare('t.isriwayataniaya_seksual', $this->isriwayataniaya_seksual);
        $criteria->compare('t.isriwayataniaya_penolakan', $this->isriwayataniaya_penolakan);
        $criteria->compare('t.isriwayataniaya_kekerasandlmkeluarga', $this->isriwayataniaya_kekerasandlmkeluarga);
        $criteria->compare('t.isriwayataniaya_tindakkriminal', $this->isriwayataniaya_tindakkriminal);
        $criteria->compare('t.riwayataniaya_penjelasan', $this->riwayataniaya_penjelasan, true);
        $criteria->compare('t.genogram_gambar', $this->genogram_gambar, true);
        $criteria->compare('t.genogram_penjelasan', $this->genogram_penjelasan, true);
        $criteria->compare('t.pengambilankeputusan', $this->pengambilankeputusan, true);
        $criteria->compare('t.polakomunikasi', $this->polakomunikasi, true);
        $criteria->compare('t.presipitasi_peristiwabrdialami', $this->presipitasi_peristiwabrdialami, true);
        $criteria->compare('t.presipitasi_perubahanadl', $this->presipitasi_perubahanadl, true);
        $criteria->compare('t.presipitasi_perubahanfisik', $this->presipitasi_perubahanfisik, true);
        $criteria->compare('t.presipitasi_lingkunganpenuhkritik', $this->presipitasi_lingkunganpenuhkritik, true);
        $criteria->compare('t.td_systolic', $this->td_systolic);
        $criteria->compare('t.td_diastolic', $this->td_diastolic);
        $criteria->compare('t.nadi', $this->nadi);
        $criteria->compare('t.pernapasan', $this->pernapasan);
        $criteria->compare('t.suhutubuh', $this->suhutubuh);
        $criteria->compare('t.tinggibadan', $this->tinggibadan);
        $criteria->compare('t.beratbadan', $this->beratbadan);
        $criteria->compare('t.hasilukur_bbtb', $this->hasilukur_bbtb, true);
        $criteria->compare('t.fisik_diagnosakeperawatan', $this->fisik_diagnosakeperawatan, true);
        $criteria->compare('t.konsepdiri_citratubuh', $this->konsepdiri_citratubuh, true);
        $criteria->compare('t.konsepdiri_identitas', $this->konsepdiri_identitas, true);
        $criteria->compare('t.konsepdiri_peran', $this->konsepdiri_peran, true);
        $criteria->compare('t.konsepdiri_idealdiri', $this->konsepdiri_idealdiri, true);
        $criteria->compare('t.konsepdiri_hargadiri', $this->konsepdiri_hargadiri, true);
        $criteria->compare('t.hubsosial_orangterdekat', $this->hubsosial_orangterdekat, true);
        $criteria->compare('t.hubsosial_peransertadlmkegiatan', $this->hubsosial_peransertadlmkegiatan, true);
        $criteria->compare('t.hubsosial_hambatandlmhubdgnoranglain', $this->hubsosial_hambatandlmhubdgnoranglain, true);
        $criteria->compare('t.spiritual_nilaikeyakinan', $this->spiritual_nilaikeyakinan, true);
        $criteria->compare('t.spiritual_kegiatanibadah', $this->spiritual_kegiatanibadah, true);
        $criteria->compare('t.spiritual_pengaruhterhadapkoping', $this->spiritual_pengaruhterhadapkoping, true);
        $criteria->compare('t.caraberpakaian', $this->caraberpakaian, true);
        $criteria->compare('t.caraberpakaian_penjelasan', $this->caraberpakaian_penjelasan, true);
        $criteria->compare('t.caraberjalan_sikaptubuh', $this->caraberjalan_sikaptubuh, true);
        $criteria->compare('t.kebersihan', $this->kebersihan, true);
        $criteria->compare('t.ekspresiwajah', $this->ekspresiwajah, true);
        $criteria->compare('t.pembicaraan_frekuensi', $this->pembicaraan_frekuensi, true);
        $criteria->compare('t.pembicaraan_volume', $this->pembicaraan_volume, true);
        $criteria->compare('t.pembicaraan_karakteristik', $this->pembicaraan_karakteristik, true);
        $criteria->compare('t.pembicaraan_penjelasan', $this->pembicaraan_penjelasan, true);
        $criteria->compare('t.tingkataktivitas', $this->tingkataktivitas, true);
        $criteria->compare('t.jenisaktivitas', $this->jenisaktivitas, true);
        $criteria->compare('t.isyarattubuh', $this->isyarattubuh, true);
        $criteria->compare('t.interaksiselama_wawancara', $this->interaksiselama_wawancara, true);
        $criteria->compare('t.aktivitasmotorik_penjelasan', $this->aktivitasmotorik_penjelasan, true);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.update_time', $this->update_time, true);
        $criteria->compare('t.create_loginpemakai', $this->create_loginpemakai, true);
        $criteria->compare('t.update_loginpemakai', $this->update_loginpemakai, true);
        $criteria->compare('t.create_ruangan_id', $this->create_ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchRiwayat() {
        
        $cr = new CDbCriteria;
        
        $prov = $this->search();
        
        $cr->join = 'join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id ';
        $cr->addBetweenCondition('p.tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
        $cr->compare('lower(p.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $cr->compare('p.instalasi_id', $this->instalasi_id);
        $cr->compare('p.ruangan_id', $this->ruangan_id);
        $cr->compare('p.pasien_id', $this->pasien_id);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $cr,
            'sort' => array(
                'defaultOrder'=>'p.tgl_pendaftaran, t.tgl_pengkajian, t.jam_pengkajian'
            ),
        ));
    }

    /**
     * Mengambil daftar semua propinsi
     * @return CActiveDataProvider 
     */
    public function getPropinsiItems() {
        return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif' => true), array('order' => 'propinsi_nama'));
    }

    /**
     * Mengambil daftar semua kabupaten berdasarkan propinsi
     * @return CActiveDataProvider 
     */
    public function getKabupatenItems($propinsi_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($propinsi_id)) {
            $criteria->addCondition("propinsi_id = " . $propinsi_id);
        } else {
            $criteria->addCondition("propinsi_id is null ");
        }
        $criteria->compare('kabupaten_aktif', true);
        $criteria->order = 'kabupaten_nama';
        $models = KabupatenM::model()->findAll($criteria);
        return $models;
    }

    /**
     * Mengambil daftar semua kecamatan berdasarkan kabupaten
     * @return CActiveDataProvider 
     */
    public function getKecamatanItems($kabupaten_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($kabupaten_id)) {
            $criteria->addCondition("kabupaten_id = " . $kabupaten_id);
        } else {
            $criteria->addCondition("kabupaten_id is null ");
        }
        $criteria->compare('kecamatan_aktif', true);
        $criteria->order = 'kecamatan_nama';
        $models = KecamatanM::model()->findAll($criteria);
        return $models;
    }

    /**
     * Mengambil daftar semua kelurahan berdasarkan kecamatan
     * @return CActiveDataProvider 
     */
    public function getKelurahanItems($kecamatan_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($kecamatan_id)) {
            $criteria->addCondition("kecamatan_id = " . $kecamatan_id);
        } else {
            $criteria->addCondition("kecamatan_id is null ");
        }
        $criteria->compare('kelurahan_aktif', true);
        $criteria->order = 'kelurahan_nama';
        $models = KelurahanM::model()->findAll($criteria);
        return $models;
    }

}
