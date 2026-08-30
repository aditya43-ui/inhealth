<?php

/**
 * This is the model class for table "pengkajiankeperawatanjiwa_t".
 *
 * The followings are the available columns in table 'pengkajiankeperawatanjiwa_t':
 * @property integer $pengkajiankeperawatanjiwa_id
 * @property string $tgl_pengkajian
 * @property string $informan
 * @property integer $pendaftaran_id
 * @property string $alasan_masuk
 * @property integer $perawat_id
 * @property boolean $prediosposisi_gangunajiwa_masalalu
 * @property string $prediosposisi_pengobatansebelumnya
 * @property string $prediosposisi_aniayafisik
 * @property string $prediosposisi_aniayafisik_usia
 * @property string $prediosposisi_aniayaseksual
 * @property string $prediosposisi_aniayaseksual_usia
 * @property string $prediosposisi_penolakan
 * @property string $prediosposisi_penolakan_usia
 * @property string $prediosposisi_krt
 * @property string $prediosposisi_krt_usia
 * @property string $prediosposisi_kriminal
 * @property string $prediosposisi_kriminal_usia
 * @property string $prediosposisi_penjelasan
 * @property string $prediosposisi_masalahkeperawatan
 * @property boolean $prediosposisi_anggotakeluraga_gangguan
 * @property string $prediosposisi_hubungankeluarga
 * @property string $prediosposisi_gejala
 * @property string $prediosposisi_riwayatpengobatan
 * @property string $prediosposisi_masalahkeperawatan_keluarga
 * @property string $prediosposisi_pengalamanmasalalu
 * @property string $prediosposisi_masalahkeperawatan_masalalu
 * @property string $fisik_tandavital
 * @property double $fisik_tinggibadan
 * @property double $fisik_beratbadan
 * @property boolean $fisik_keluhan
 * @property string $fisik_penjelasan
 * @property string $fisik_masalahkeperawatan
 * @property string $psikososial_genogram
 * @property string $psikososial_penjelasan
 * @property string $psikososial_masalahkeperawatan
 * @property string $psikososial_gambarandiri
 * @property string $psikososial_identitas
 * @property string $psikososial_peran
 * @property string $psikososial_idealdiri
 * @property string $psikososial_hargadiri
 * @property string $psikososial_masalahkeperawatan_konsepdiri
 * @property string $psikososial_sosial_orangberarti
 * @property string $psikososial_sosial_peran_dalam_kelompok
 * @property string $psikososial_sosial_hambatan
 * @property string $psikososial_masalahkeperawatan_sosial
 * @property string $psikososial_spiritual_nilai
 * @property string $psikososial_spiritual_ibadah
 * @property string $psikososial_masalahkeperawatan_spiritual
 * @property string $status_penampilan
 * @property string $status_masalahkeperawatan_penampilan
 * @property string $status_pembicaraan
 * @property string $status_masalahkeperawatan_pembicaraan
 * @property string $status_aktifitasmotorik
 * @property string $status_masalahkeperawatan_aktifitasmotorik
 * @property string $status_alamperasaan
 * @property string $status_masalahkeperawatan_alamperasaan
 * @property string $status_efek
 * @property string $status_masalahkeperawatan_efek
 * @property string $status_interaksiwawancara
 * @property string $status_masalahkeperawatan_interaksiwawancara
 * @property string $status_persepsi
 * @property string $status_masalahkeperawatan_persepsi
 * @property string $status_prosespikir
 * @property string $status_masalahkeperawatan_prosespikir
 * @property string $status_isipikir
 * @property string $status_masalahkeperawatan_isipikir
 * @property string $status_waham
 * @property string $status_masalahkeperawatan_waham
 * @property string $status_kesadaran
 * @property string $status_masalahkeperawatan_kesadaran
 * @property string $status_memori
 * @property string $status_masalahkeperawatan_memori
 * @property string $status_konsentrasi
 * @property string $status_masalahkeperawatan_konsentrasi
 * @property string $status_penilaian
 * @property string $status_masalahkeperawatan_penilaian
 * @property string $status_dayatitikdiri
 * @property string $status_masalahkeperawatan_dayatitikdiri
 * @property string $kebutuhanpulang_makan
 * @property string $kebutuhanpulang_bab
 * @property string $kebutuhanpulang_penjelasan_makanbab
 * @property string $kebutuhanpulang_masalahkeperawatan_makanbab
 * @property string $kebutuhanpulang_mandi
 * @property string $kebutuhanpulang_berpakaian
 * @property string $kebutuhanpulang_istirahat
 * @property string $kebutuhanpulang_penggunaanobat
 * @property boolean $kebutuhanpulang_pemeliharaankesehatan_lanjutan
 * @property boolean $kebutuhanpulang_pemeliharaankesehatan_pendukung
 * @property boolean $kebutuhanpulang_kegiatanrumah_makanan
 * @property boolean $kebutuhanpulang_kegiatanrumah_kerapihan
 * @property boolean $kebutuhanpulang_kegiatanrumah_mencuci
 * @property boolean $kebutuhanpulang_kegiatanrumah_keuangan
 * @property boolean $kebutuhanpulang_kegiatanluarrumah_belanja
 * @property boolean $kebutuhanpulang_kegiatanluarrumah_transportasi
 * @property boolean $kebutuhanpulang_kegiatanluarrumah_lain2
 * @property string $kebutuhanpulang_penjelasan
 * @property string $kebutuhanpulang_masalahkeperawatan
 * @property string $mekanismekoping_adaptif
 * @property string $mekanismekoping_adaptif_lainnya
 * @property string $mekanismekoping_maladaptif
 * @property string $mekanismekoping_maladaptif_lainnya
 * @property string $mekanismekoping_masalahkeperawatan
 * @property string $masalahpsikososial
 * @property string $masalahpsikososial_masalahkeperawatan
 * @property string $pengetahuankurang
 * @property string $pengetahuankurang_masalahkeperawatan
 * @property string $diagnosamedik
 * @property string $terapimedik
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $perawat
 */
class PengkajiankeperawatanjiwaT extends CActiveRecord
{
    public function getJsonColumn() {
        return array(
            'fisik_tandavital',
            /*
            'status_penampilan',
            'status_pembicaraan',
            'status_aktifitasmotorik',
            'status_alamperasaan',
            'status_efek',
            'status_interaksiwawancara',
            'status_persepsi',
            'status_prosespikir',
            'status_isipikir',
            'status_waham',
            'status_kesadaran',
            'status_disorientasi',
            'status_memori',
            'status_konsentrasi',
            'status_penilaian',
            'status_dayatitikdiri',
             * 
             */
            'kebutuhanpulang_istirahat',
            'mekanismekoping_adaptif',
            'mekanismekoping_maladaptif',
            'pengetahuankurang',
            'masalahpsikososial',
        );
    }
    
    
    public static function psikososialLabel() {
        return array(
            0 => 'Masalah dengan dilingkungan kelompok',
            1 => 'Masalah berhubungan dengan lingkungan',
            2 => 'Masalah dengan pendidikan',
            3 => 'Masalah dengan pekerjaan',
            4 => 'Masalah dengan perumahan',
            5 => 'Masalah ekonomi',
            6 => 'Masalah dengan pelayanan kesehatan',
            7 => 'Masalah lainnya',
        );
    }
    
    public static function pengetahuanKurangLabel() {
        return array(
            'Penyakit Jiwa'=>'Penyakit Jiwa',
            'Faktor Presipitasi'=>'Faktor Presipitasi',
            'Koping'=>'Koping',
            'System Pendukung'=>'System Pendukung',
            'Penyakit Fisik'=>'Penyakit Fisik',
            'Obat-Obatan'=>'Obat-Obatan',
            'Lainnya'=>'Lainnya',
        );
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengkajiankeperawatanjiwaT the static model class
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
		return 'pengkajiankeperawatanjiwa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_pengkajian', 'required'),
			array('pendaftaran_id, perawat_id', 'numerical', 'integerOnly'=>true),
			array('fisik_tinggibadan, fisik_beratbadan', 'numerical'),
			array('informan', 'length', 'max'=>255),
			array('prediosposisi_pengobatansebelumnya', 'length', 'max'=>100),
			array('alasan_masuk, prediosposisi_gangunajiwa_masalalu, prediosposisi_aniayafisik, prediosposisi_aniayafisik_usia, prediosposisi_aniayaseksual, prediosposisi_aniayaseksual_usia, prediosposisi_penolakan, prediosposisi_penolakan_usia, prediosposisi_krt, prediosposisi_krt_usia, prediosposisi_kriminal, prediosposisi_kriminal_usia, prediosposisi_penjelasan, prediosposisi_masalahkeperawatan, prediosposisi_anggotakeluraga_gangguan, prediosposisi_hubungankeluarga, prediosposisi_gejala, prediosposisi_riwayatpengobatan, prediosposisi_masalahkeperawatan_keluarga, prediosposisi_pengalamanmasalalu, prediosposisi_masalahkeperawatan_masalalu, fisik_tandavital, fisik_keluhan, fisik_penjelasan, fisik_masalahkeperawatan, psikososial_genogram, psikososial_penjelasan, psikososial_masalahkeperawatan, psikososial_gambarandiri, psikososial_identitas, psikososial_peran, psikososial_idealdiri, psikososial_hargadiri, psikososial_masalahkeperawatan_konsepdiri, psikososial_sosial_orangberarti, psikososial_sosial_peran_dalam_kelompok, psikososial_sosial_hambatan, psikososial_masalahkeperawatan_sosial, psikososial_spiritual_nilai, psikososial_spiritual_ibadah, psikososial_masalahkeperawatan_spiritual, status_penampilan, status_masalahkeperawatan_penampilan, status_pembicaraan, status_masalahkeperawatan_pembicaraan, status_aktifitasmotorik, status_masalahkeperawatan_aktifitasmotorik, status_alamperasaan, status_masalahkeperawatan_alamperasaan, status_efek, status_masalahkeperawatan_efek, status_interaksiwawancara, status_masalahkeperawatan_interaksiwawancara, status_persepsi, status_masalahkeperawatan_persepsi, status_prosespikir, status_masalahkeperawatan_prosespikir, status_isipikir, status_masalahkeperawatan_isipikir, status_waham, status_masalahkeperawatan_waham, status_kesadaran, status_masalahkeperawatan_kesadaran, status_memori, status_masalahkeperawatan_memori, status_konsentrasi, status_masalahkeperawatan_konsentrasi, status_penilaian, status_masalahkeperawatan_penilaian, status_dayatitikdiri, status_masalahkeperawatan_dayatitikdiri, kebutuhanpulang_makan, kebutuhanpulang_bab, kebutuhanpulang_penjelasan_makanbab, kebutuhanpulang_masalahkeperawatan_makanbab, kebutuhanpulang_mandi, kebutuhanpulang_berpakaian, kebutuhanpulang_istirahat, kebutuhanpulang_penggunaanobat, kebutuhanpulang_pemeliharaankesehatan_lanjutan, kebutuhanpulang_pemeliharaankesehatan_pendukung, kebutuhanpulang_kegiatanrumah_makanan, kebutuhanpulang_kegiatanrumah_kerapihan, kebutuhanpulang_kegiatanrumah_mencuci, kebutuhanpulang_kegiatanrumah_keuangan, kebutuhanpulang_kegiatanluarrumah_belanja, kebutuhanpulang_kegiatanluarrumah_transportasi, kebutuhanpulang_kegiatanluarrumah_lain2, kebutuhanpulang_penjelasan, kebutuhanpulang_masalahkeperawatan, mekanismekoping_adaptif, mekanismekoping_adaptif_lainnya, mekanismekoping_maladaptif, mekanismekoping_maladaptif_lainnya, mekanismekoping_masalahkeperawatan, masalahpsikososial, masalahpsikososial_masalahkeperawatan, pengetahuankurang, pengetahuankurang_masalahkeperawatan, diagnosamedik, terapimedik', 'safe'),
			array('status_disorientasi', 'safe'),
			array('pengetahuankurang_lainnya', 'safe'),
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengkajiankeperawatanjiwa_id, tgl_pengkajian, informan, pendaftaran_id, alasan_masuk, perawat_id, prediosposisi_gangunajiwa_masalalu, prediosposisi_pengobatansebelumnya, prediosposisi_aniayafisik, prediosposisi_aniayafisik_usia, prediosposisi_aniayaseksual, prediosposisi_aniayaseksual_usia, prediosposisi_penolakan, prediosposisi_penolakan_usia, prediosposisi_krt, prediosposisi_krt_usia, prediosposisi_kriminal, prediosposisi_kriminal_usia, prediosposisi_penjelasan, prediosposisi_masalahkeperawatan, prediosposisi_anggotakeluraga_gangguan, prediosposisi_hubungankeluarga, prediosposisi_gejala, prediosposisi_riwayatpengobatan, prediosposisi_masalahkeperawatan_keluarga, prediosposisi_pengalamanmasalalu, prediosposisi_masalahkeperawatan_masalalu, fisik_tandavital, fisik_tinggibadan, fisik_beratbadan, fisik_keluhan, fisik_penjelasan, fisik_masalahkeperawatan, psikososial_genogram, psikososial_penjelasan, psikososial_masalahkeperawatan, psikososial_gambarandiri, psikososial_identitas, psikososial_peran, psikososial_idealdiri, psikososial_hargadiri, psikososial_masalahkeperawatan_konsepdiri, psikososial_sosial_orangberarti, psikososial_sosial_peran_dalam_kelompok, psikososial_sosial_hambatan, psikososial_masalahkeperawatan_sosial, psikososial_spiritual_nilai, psikososial_spiritual_ibadah, psikososial_masalahkeperawatan_spiritual, status_penampilan, status_masalahkeperawatan_penampilan, status_pembicaraan, status_masalahkeperawatan_pembicaraan, status_aktifitasmotorik, status_masalahkeperawatan_aktifitasmotorik, status_alamperasaan, status_masalahkeperawatan_alamperasaan, status_efek, status_masalahkeperawatan_efek, status_interaksiwawancara, status_masalahkeperawatan_interaksiwawancara, status_persepsi, status_masalahkeperawatan_persepsi, status_prosespikir, status_masalahkeperawatan_prosespikir, status_isipikir, status_masalahkeperawatan_isipikir, status_waham, status_masalahkeperawatan_waham, status_kesadaran, status_masalahkeperawatan_kesadaran, status_memori, status_masalahkeperawatan_memori, status_konsentrasi, status_masalahkeperawatan_konsentrasi, status_penilaian, status_masalahkeperawatan_penilaian, status_dayatitikdiri, status_masalahkeperawatan_dayatitikdiri, kebutuhanpulang_makan, kebutuhanpulang_bab, kebutuhanpulang_penjelasan_makanbab, kebutuhanpulang_masalahkeperawatan_makanbab, kebutuhanpulang_mandi, kebutuhanpulang_berpakaian, kebutuhanpulang_istirahat, kebutuhanpulang_penggunaanobat, kebutuhanpulang_pemeliharaankesehatan_lanjutan, kebutuhanpulang_pemeliharaankesehatan_pendukung, kebutuhanpulang_kegiatanrumah_makanan, kebutuhanpulang_kegiatanrumah_kerapihan, kebutuhanpulang_kegiatanrumah_mencuci, kebutuhanpulang_kegiatanrumah_keuangan, kebutuhanpulang_kegiatanluarrumah_belanja, kebutuhanpulang_kegiatanluarrumah_transportasi, kebutuhanpulang_kegiatanluarrumah_lain2, kebutuhanpulang_penjelasan, kebutuhanpulang_masalahkeperawatan, mekanismekoping_adaptif, mekanismekoping_adaptif_lainnya, mekanismekoping_maladaptif, mekanismekoping_maladaptif_lainnya, mekanismekoping_masalahkeperawatan, masalahpsikososial, masalahpsikososial_masalahkeperawatan, pengetahuankurang, pengetahuankurang_masalahkeperawatan, diagnosamedik, terapimedik', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'perawat' => array(self::BELONGS_TO, 'PegawaiM', 'perawat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengkajiankeperawatanjiwa_id' => 'Pengkajiankeperawatanjiwa',
			'tgl_pengkajian' => 'Tgl. Pengkajian',
			'informan' => 'Informan',
			'pendaftaran_id' => 'Pendaftaran',
			'alasan_masuk' => 'Alasan Masuk',
			'perawat_id' => 'Perawat',
			'prediosposisi_gangunajiwa_masalalu' => 'Prediosposisi Gangunajiwa Masalalu',
			'prediosposisi_pengobatansebelumnya' => 'Prediosposisi Pengobatansebelumnya',
			'prediosposisi_aniayafisik' => 'Prediosposisi Aniayafisik',
			'prediosposisi_aniayafisik_usia' => 'Prediosposisi Aniayafisik Usia',
			'prediosposisi_aniayaseksual' => 'Prediosposisi Aniayaseksual',
			'prediosposisi_aniayaseksual_usia' => 'Prediosposisi Aniayaseksual Usia',
			'prediosposisi_penolakan' => 'Prediosposisi Penolakan',
			'prediosposisi_penolakan_usia' => 'Prediosposisi Penolakan Usia',
			'prediosposisi_krt' => 'Prediosposisi Krt',
			'prediosposisi_krt_usia' => 'Prediosposisi Krt Usia',
			'prediosposisi_kriminal' => 'Prediosposisi Kriminal',
			'prediosposisi_kriminal_usia' => 'Prediosposisi Kriminal Usia',
			'prediosposisi_penjelasan' => 'Prediosposisi Penjelasan',
			'prediosposisi_masalahkeperawatan' => 'Prediosposisi Masalahkeperawatan',
			'prediosposisi_anggotakeluraga_gangguan' => 'Prediosposisi Anggotakeluraga Gangguan',
			'prediosposisi_hubungankeluarga' => 'Prediosposisi Hubungankeluarga',
			'prediosposisi_gejala' => 'Prediosposisi Gejala',
			'prediosposisi_riwayatpengobatan' => 'Prediosposisi Riwayatpengobatan',
			'prediosposisi_masalahkeperawatan_keluarga' => 'Prediosposisi Masalahkeperawatan Keluarga',
			'prediosposisi_pengalamanmasalalu' => 'Prediosposisi Pengalamanmasalalu',
			'prediosposisi_masalahkeperawatan_masalalu' => 'Prediosposisi Masalahkeperawatan Masalalu',
			'fisik_tandavital' => 'Fisik Tandavital',
			'fisik_tinggibadan' => 'Fisik Tinggibadan',
			'fisik_beratbadan' => 'Fisik Beratbadan',
			'fisik_keluhan' => 'Fisik Keluhan',
			'fisik_penjelasan' => 'Fisik Penjelasan',
			'fisik_masalahkeperawatan' => 'Fisik Masalahkeperawatan',
			'psikososial_genogram' => 'Psikososial Genogram',
			'psikososial_penjelasan' => 'Psikososial Penjelasan',
			'psikososial_masalahkeperawatan' => 'Psikososial Masalahkeperawatan',
			'psikososial_gambarandiri' => 'Psikososial Gambarandiri',
			'psikososial_identitas' => 'Psikososial Identitas',
			'psikososial_peran' => 'Psikososial Peran',
			'psikososial_idealdiri' => 'Psikososial Idealdiri',
			'psikososial_hargadiri' => 'Psikososial Hargadiri',
			'psikososial_masalahkeperawatan_konsepdiri' => 'Psikososial Masalahkeperawatan Konsepdiri',
			'psikososial_sosial_orangberarti' => 'Psikososial Sosial Orangberarti',
			'psikososial_sosial_peran_dalam_kelompok' => 'Psikososial Sosial Peran Dalam Kelompok',
			'psikososial_sosial_hambatan' => 'Psikososial Sosial Hambatan',
			'psikososial_masalahkeperawatan_sosial' => 'Psikososial Masalahkeperawatan Sosial',
			'psikososial_spiritual_nilai' => 'Psikososial Spiritual Nilai',
			'psikososial_spiritual_ibadah' => 'Psikososial Spiritual Ibadah',
			'psikososial_masalahkeperawatan_spiritual' => 'Psikososial Masalahkeperawatan Spiritual',
			'status_penampilan' => 'Status Penampilan',
			'status_masalahkeperawatan_penampilan' => 'Status Masalahkeperawatan Penampilan',
			'status_pembicaraan' => 'Status Pembicaraan',
			'status_masalahkeperawatan_pembicaraan' => 'Status Masalahkeperawatan Pembicaraan',
			'status_aktifitasmotorik' => 'Status Aktifitasmotorik',
			'status_masalahkeperawatan_aktifitasmotorik' => 'Status Masalahkeperawatan Aktifitasmotorik',
			'status_alamperasaan' => 'Status Alamperasaan',
			'status_masalahkeperawatan_alamperasaan' => 'Status Masalahkeperawatan Alamperasaan',
			'status_efek' => 'Status Efek',
			'status_masalahkeperawatan_efek' => 'Status Masalahkeperawatan Efek',
			'status_interaksiwawancara' => 'Status Interaksiwawancara',
			'status_masalahkeperawatan_interaksiwawancara' => 'Status Masalahkeperawatan Interaksiwawancara',
			'status_persepsi' => 'Status Persepsi',
			'status_masalahkeperawatan_persepsi' => 'Status Masalahkeperawatan Persepsi',
			'status_prosespikir' => 'Status Prosespikir',
			'status_masalahkeperawatan_prosespikir' => 'Status Masalahkeperawatan Prosespikir',
			'status_isipikir' => 'Status Isipikir',
			'status_masalahkeperawatan_isipikir' => 'Status Masalahkeperawatan Isipikir',
			'status_waham' => 'Status Waham',
			'status_masalahkeperawatan_waham' => 'Status Masalahkeperawatan Waham',
			'status_kesadaran' => 'Status Kesadaran',
			'status_masalahkeperawatan_kesadaran' => 'Status Masalahkeperawatan Kesadaran',
			'status_memori' => 'Status Memori',
			'status_masalahkeperawatan_memori' => 'Status Masalahkeperawatan Memori',
			'status_konsentrasi' => 'Status Konsentrasi',
			'status_masalahkeperawatan_konsentrasi' => 'Status Masalahkeperawatan Konsentrasi',
			'status_penilaian' => 'Status Penilaian',
			'status_masalahkeperawatan_penilaian' => 'Status Masalahkeperawatan Penilaian',
			'status_dayatitikdiri' => 'Status Dayatitikdiri',
			'status_masalahkeperawatan_dayatitikdiri' => 'Status Masalahkeperawatan Dayatitikdiri',
			'kebutuhanpulang_makan' => 'Kebutuhanpulang Makan',
			'kebutuhanpulang_bab' => 'Kebutuhanpulang Bab',
			'kebutuhanpulang_penjelasan_makanbab' => 'Kebutuhanpulang Penjelasan Makanbab',
			'kebutuhanpulang_masalahkeperawatan_makanbab' => 'Kebutuhanpulang Masalahkeperawatan Makanbab',
			'kebutuhanpulang_mandi' => 'Kebutuhanpulang Mandi',
			'kebutuhanpulang_berpakaian' => 'Kebutuhanpulang Berpakaian',
			'kebutuhanpulang_istirahat' => 'Kebutuhanpulang Istirahat',
			'kebutuhanpulang_penggunaanobat' => 'Kebutuhanpulang Penggunaanobat',
			'kebutuhanpulang_pemeliharaankesehatan_lanjutan' => 'Kebutuhanpulang Pemeliharaankesehatan Lanjutan',
			'kebutuhanpulang_pemeliharaankesehatan_pendukung' => 'Kebutuhanpulang Pemeliharaankesehatan Pendukung',
			'kebutuhanpulang_kegiatanrumah_makanan' => 'Kebutuhanpulang Kegiatanrumah Makanan',
			'kebutuhanpulang_kegiatanrumah_kerapihan' => 'Kebutuhanpulang Kegiatanrumah Kerapihan',
			'kebutuhanpulang_kegiatanrumah_mencuci' => 'Kebutuhanpulang Kegiatanrumah Mencuci',
			'kebutuhanpulang_kegiatanrumah_keuangan' => 'Kebutuhanpulang Kegiatanrumah Keuangan',
			'kebutuhanpulang_kegiatanluarrumah_belanja' => 'Kebutuhanpulang Kegiatanluarrumah Belanja',
			'kebutuhanpulang_kegiatanluarrumah_transportasi' => 'Kebutuhanpulang Kegiatanluarrumah Transportasi',
			'kebutuhanpulang_kegiatanluarrumah_lain2' => 'Kebutuhanpulang Kegiatanluarrumah Lain2',
			'kebutuhanpulang_penjelasan' => 'Kebutuhanpulang Penjelasan',
			'kebutuhanpulang_masalahkeperawatan' => 'Kebutuhanpulang Masalahkeperawatan',
			'mekanismekoping_adaptif' => 'Mekanismekoping Adaptif',
			'mekanismekoping_adaptif_lainnya' => 'Mekanismekoping Adaptif Lainnya',
			'mekanismekoping_maladaptif' => 'Mekanismekoping Maladaptif',
			'mekanismekoping_maladaptif_lainnya' => 'Mekanismekoping Maladaptif Lainnya',
			'mekanismekoping_masalahkeperawatan' => 'Mekanismekoping Masalahkeperawatan',
			'masalahpsikososial' => 'Masalahpsikososial',
			'masalahpsikososial_masalahkeperawatan' => 'Masalahpsikososial Masalahkeperawatan',
			'pengetahuankurang' => 'Pengetahuankurang',
			'pengetahuankurang_masalahkeperawatan' => 'Pengetahuankurang Masalahkeperawatan',
			'diagnosamedik' => 'Diagnosamedik',
			'terapimedik' => 'Terapimedik',
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

		$criteria->compare('pengkajiankeperawatanjiwa_id',$this->pengkajiankeperawatanjiwa_id);
		$criteria->compare('tgl_pengkajian',$this->tgl_pengkajian,true);
		$criteria->compare('informan',$this->informan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('alasan_masuk',$this->alasan_masuk,true);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('prediosposisi_gangunajiwa_masalalu',$this->prediosposisi_gangunajiwa_masalalu);
		$criteria->compare('prediosposisi_pengobatansebelumnya',$this->prediosposisi_pengobatansebelumnya,true);
		$criteria->compare('prediosposisi_aniayafisik',$this->prediosposisi_aniayafisik,true);
		$criteria->compare('prediosposisi_aniayafisik_usia',$this->prediosposisi_aniayafisik_usia,true);
		$criteria->compare('prediosposisi_aniayaseksual',$this->prediosposisi_aniayaseksual,true);
		$criteria->compare('prediosposisi_aniayaseksual_usia',$this->prediosposisi_aniayaseksual_usia,true);
		$criteria->compare('prediosposisi_penolakan',$this->prediosposisi_penolakan,true);
		$criteria->compare('prediosposisi_penolakan_usia',$this->prediosposisi_penolakan_usia,true);
		$criteria->compare('prediosposisi_krt',$this->prediosposisi_krt,true);
		$criteria->compare('prediosposisi_krt_usia',$this->prediosposisi_krt_usia,true);
		$criteria->compare('prediosposisi_kriminal',$this->prediosposisi_kriminal,true);
		$criteria->compare('prediosposisi_kriminal_usia',$this->prediosposisi_kriminal_usia,true);
		$criteria->compare('prediosposisi_penjelasan',$this->prediosposisi_penjelasan,true);
		$criteria->compare('prediosposisi_masalahkeperawatan',$this->prediosposisi_masalahkeperawatan,true);
		$criteria->compare('prediosposisi_anggotakeluraga_gangguan',$this->prediosposisi_anggotakeluraga_gangguan);
		$criteria->compare('prediosposisi_hubungankeluarga',$this->prediosposisi_hubungankeluarga,true);
		$criteria->compare('prediosposisi_gejala',$this->prediosposisi_gejala,true);
		$criteria->compare('prediosposisi_riwayatpengobatan',$this->prediosposisi_riwayatpengobatan,true);
		$criteria->compare('prediosposisi_masalahkeperawatan_keluarga',$this->prediosposisi_masalahkeperawatan_keluarga,true);
		$criteria->compare('prediosposisi_pengalamanmasalalu',$this->prediosposisi_pengalamanmasalalu,true);
		$criteria->compare('prediosposisi_masalahkeperawatan_masalalu',$this->prediosposisi_masalahkeperawatan_masalalu,true);
		$criteria->compare('fisik_tandavital',$this->fisik_tandavital,true);
		$criteria->compare('fisik_tinggibadan',$this->fisik_tinggibadan);
		$criteria->compare('fisik_beratbadan',$this->fisik_beratbadan);
		$criteria->compare('fisik_keluhan',$this->fisik_keluhan);
		$criteria->compare('fisik_penjelasan',$this->fisik_penjelasan,true);
		$criteria->compare('fisik_masalahkeperawatan',$this->fisik_masalahkeperawatan,true);
		$criteria->compare('psikososial_genogram',$this->psikososial_genogram,true);
		$criteria->compare('psikososial_penjelasan',$this->psikososial_penjelasan,true);
		$criteria->compare('psikososial_masalahkeperawatan',$this->psikososial_masalahkeperawatan,true);
		$criteria->compare('psikososial_gambarandiri',$this->psikososial_gambarandiri,true);
		$criteria->compare('psikososial_identitas',$this->psikososial_identitas,true);
		$criteria->compare('psikososial_peran',$this->psikososial_peran,true);
		$criteria->compare('psikososial_idealdiri',$this->psikososial_idealdiri,true);
		$criteria->compare('psikososial_hargadiri',$this->psikososial_hargadiri,true);
		$criteria->compare('psikososial_masalahkeperawatan_konsepdiri',$this->psikososial_masalahkeperawatan_konsepdiri,true);
		$criteria->compare('psikososial_sosial_orangberarti',$this->psikososial_sosial_orangberarti,true);
		$criteria->compare('psikososial_sosial_peran_dalam_kelompok',$this->psikososial_sosial_peran_dalam_kelompok,true);
		$criteria->compare('psikososial_sosial_hambatan',$this->psikososial_sosial_hambatan,true);
		$criteria->compare('psikososial_masalahkeperawatan_sosial',$this->psikososial_masalahkeperawatan_sosial,true);
		$criteria->compare('psikososial_spiritual_nilai',$this->psikososial_spiritual_nilai,true);
		$criteria->compare('psikososial_spiritual_ibadah',$this->psikososial_spiritual_ibadah,true);
		$criteria->compare('psikososial_masalahkeperawatan_spiritual',$this->psikososial_masalahkeperawatan_spiritual,true);
		$criteria->compare('status_penampilan',$this->status_penampilan,true);
		$criteria->compare('status_masalahkeperawatan_penampilan',$this->status_masalahkeperawatan_penampilan,true);
		$criteria->compare('status_pembicaraan',$this->status_pembicaraan,true);
		$criteria->compare('status_masalahkeperawatan_pembicaraan',$this->status_masalahkeperawatan_pembicaraan,true);
		$criteria->compare('status_aktifitasmotorik',$this->status_aktifitasmotorik,true);
		$criteria->compare('status_masalahkeperawatan_aktifitasmotorik',$this->status_masalahkeperawatan_aktifitasmotorik,true);
		$criteria->compare('status_alamperasaan',$this->status_alamperasaan,true);
		$criteria->compare('status_masalahkeperawatan_alamperasaan',$this->status_masalahkeperawatan_alamperasaan,true);
		$criteria->compare('status_efek',$this->status_efek,true);
		$criteria->compare('status_masalahkeperawatan_efek',$this->status_masalahkeperawatan_efek,true);
		$criteria->compare('status_interaksiwawancara',$this->status_interaksiwawancara,true);
		$criteria->compare('status_masalahkeperawatan_interaksiwawancara',$this->status_masalahkeperawatan_interaksiwawancara,true);
		$criteria->compare('status_persepsi',$this->status_persepsi,true);
		$criteria->compare('status_masalahkeperawatan_persepsi',$this->status_masalahkeperawatan_persepsi,true);
		$criteria->compare('status_prosespikir',$this->status_prosespikir,true);
		$criteria->compare('status_masalahkeperawatan_prosespikir',$this->status_masalahkeperawatan_prosespikir,true);
		$criteria->compare('status_isipikir',$this->status_isipikir,true);
		$criteria->compare('status_masalahkeperawatan_isipikir',$this->status_masalahkeperawatan_isipikir,true);
		$criteria->compare('status_waham',$this->status_waham,true);
		$criteria->compare('status_masalahkeperawatan_waham',$this->status_masalahkeperawatan_waham,true);
		$criteria->compare('status_kesadaran',$this->status_kesadaran,true);
		$criteria->compare('status_masalahkeperawatan_kesadaran',$this->status_masalahkeperawatan_kesadaran,true);
		$criteria->compare('status_memori',$this->status_memori,true);
		$criteria->compare('status_masalahkeperawatan_memori',$this->status_masalahkeperawatan_memori,true);
		$criteria->compare('status_konsentrasi',$this->status_konsentrasi,true);
		$criteria->compare('status_masalahkeperawatan_konsentrasi',$this->status_masalahkeperawatan_konsentrasi,true);
		$criteria->compare('status_penilaian',$this->status_penilaian,true);
		$criteria->compare('status_masalahkeperawatan_penilaian',$this->status_masalahkeperawatan_penilaian,true);
		$criteria->compare('status_dayatitikdiri',$this->status_dayatitikdiri,true);
		$criteria->compare('status_masalahkeperawatan_dayatitikdiri',$this->status_masalahkeperawatan_dayatitikdiri,true);
		$criteria->compare('kebutuhanpulang_makan',$this->kebutuhanpulang_makan,true);
		$criteria->compare('kebutuhanpulang_bab',$this->kebutuhanpulang_bab,true);
		$criteria->compare('kebutuhanpulang_penjelasan_makanbab',$this->kebutuhanpulang_penjelasan_makanbab,true);
		$criteria->compare('kebutuhanpulang_masalahkeperawatan_makanbab',$this->kebutuhanpulang_masalahkeperawatan_makanbab,true);
		$criteria->compare('kebutuhanpulang_mandi',$this->kebutuhanpulang_mandi,true);
		$criteria->compare('kebutuhanpulang_berpakaian',$this->kebutuhanpulang_berpakaian,true);
		$criteria->compare('kebutuhanpulang_istirahat',$this->kebutuhanpulang_istirahat,true);
		$criteria->compare('kebutuhanpulang_penggunaanobat',$this->kebutuhanpulang_penggunaanobat,true);
		$criteria->compare('kebutuhanpulang_pemeliharaankesehatan_lanjutan',$this->kebutuhanpulang_pemeliharaankesehatan_lanjutan);
		$criteria->compare('kebutuhanpulang_pemeliharaankesehatan_pendukung',$this->kebutuhanpulang_pemeliharaankesehatan_pendukung);
		$criteria->compare('kebutuhanpulang_kegiatanrumah_makanan',$this->kebutuhanpulang_kegiatanrumah_makanan);
		$criteria->compare('kebutuhanpulang_kegiatanrumah_kerapihan',$this->kebutuhanpulang_kegiatanrumah_kerapihan);
		$criteria->compare('kebutuhanpulang_kegiatanrumah_mencuci',$this->kebutuhanpulang_kegiatanrumah_mencuci);
		$criteria->compare('kebutuhanpulang_kegiatanrumah_keuangan',$this->kebutuhanpulang_kegiatanrumah_keuangan);
		$criteria->compare('kebutuhanpulang_kegiatanluarrumah_belanja',$this->kebutuhanpulang_kegiatanluarrumah_belanja);
		$criteria->compare('kebutuhanpulang_kegiatanluarrumah_transportasi',$this->kebutuhanpulang_kegiatanluarrumah_transportasi);
		$criteria->compare('kebutuhanpulang_kegiatanluarrumah_lain2',$this->kebutuhanpulang_kegiatanluarrumah_lain2);
		$criteria->compare('kebutuhanpulang_penjelasan',$this->kebutuhanpulang_penjelasan,true);
		$criteria->compare('kebutuhanpulang_masalahkeperawatan',$this->kebutuhanpulang_masalahkeperawatan,true);
		$criteria->compare('mekanismekoping_adaptif',$this->mekanismekoping_adaptif,true);
		$criteria->compare('mekanismekoping_adaptif_lainnya',$this->mekanismekoping_adaptif_lainnya,true);
		$criteria->compare('mekanismekoping_maladaptif',$this->mekanismekoping_maladaptif,true);
		$criteria->compare('mekanismekoping_maladaptif_lainnya',$this->mekanismekoping_maladaptif_lainnya,true);
		$criteria->compare('mekanismekoping_masalahkeperawatan',$this->mekanismekoping_masalahkeperawatan,true);
		$criteria->compare('masalahpsikososial',$this->masalahpsikososial,true);
		$criteria->compare('masalahpsikososial_masalahkeperawatan',$this->masalahpsikososial_masalahkeperawatan,true);
		$criteria->compare('pengetahuankurang',$this->pengetahuankurang,true);
		$criteria->compare('pengetahuankurang_masalahkeperawatan',$this->pengetahuankurang_masalahkeperawatan,true);
		$criteria->compare('diagnosamedik',$this->diagnosamedik,true);
		$criteria->compare('terapimedik',$this->terapimedik,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}