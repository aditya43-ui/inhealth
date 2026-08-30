<?php

/**
 * This is the model class for table "infopengkajianaskep_v".
 *
 * The followings are the available columns in table 'infopengkajianaskep_v':
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $anamesa_id
 * @property integer $pemeriksaanfisik_id
 * @property string $no_pengkajian
 * @property string $pengkajianaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $tglanamnesis
 * @property string $keluhanutama
 * @property string $keluhantambahan
 * @property string $riwayatpenyakitterdahulu
 * @property string $riwayatpenyakitkeluarga
 * @property string $riwayatimunisasi
 * @property string $riwayatalergiobat
 * @property string $riwayatmakanan
 * @property string $tglperiksafisik
 * @property string $keadaanumum
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $tekanandarah
 * @property integer $detaknadi
 * @property string $suhutubuh
 * @property string $pernapasan
 * @property integer $gcs_motorik
 * @property string $kelainanpadabagtubuh
 * @property integer $pengkajianaskep_id
 * @property string $ruangan_nama
 * @property string $kelaspelayanan_nama
 * @property string $nama_pasien
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_rekam_medik
 * @property string $umur
 * @property string $statusperkawinan
 * @property string $jeniskelamin
 * @property string $pekerjaan_nama
 * @property string $pendidikan_nama
 * @property string $agama
 * @property string $alamat_pasien
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property string $diagnosa_nama
 * @property string $nama_pj
 * @property string $no_identitas
 * @property string $tgllahir_pj
 * @property string $no_teleponpj
 * @property string $no_mobilepj
 * @property string $hubungankeluarga
 * @property string $alamat_pj
 * @property string $jk
 * @property string $riwayatperjalananpasien
 * @property boolean $pernahdirawat
 * @property string $dirawatdimana
 * @property string $lamasakit
 * @property string $riwpenyakitkeldari
 * @property string $penyakitmayor
 * @property string $reaksialergiobat
 * @property string $reaksialergimakanan
 * @property string $riwayatalergilainnya
 * @property string $reaksialergilainnya
 * @property string $pengobatanygsudahdilakukan
 * @property string $riwayatkelahiran
 * @property string $gelangtandaalergi
 * @property boolean $statusmerokok
 * @property integer $jmlrokok_btg_hr
 * @property string $statuspsikologis
 * @property string $statusmental
 * @property string $masalahsebelumnya
 * @property string $prilakukekerasansebelumnya
 * @property boolean $penurunanbb_3bln
 * @property boolean $asupanberkurang
 * @property string $aktifitas_mobilisasi
 * @property string $sebutkan_bantuan
 * @property boolean $resikocedera
 * @property boolean $isgelangresiko
 * @property string $tandasegitigaterpasang
 * @property string $skriningnyeri
 * @property string $skalanyeri
 * @property string $karakteristiknyeri
 * @property string $lokasinyeri
 * @property string $nyeriterasa
 * @property string $nyerihilangbila
 * @property boolean $hubkeluarga
 * @property string $tempattinggal
 * @property string $keterangananamesa
 * @property double $meanarteripressure
 * @property string $denyutjantung
 * @property string $inspeksi
 * @property string $palpasi
 * @property string $perkusi
 * @property string $auskultasi
 * @property boolean $jn_paten
 * @property boolean $jn_obstruktifpartial
 * @property boolean $jn_obstruktifnormal
 * @property boolean $jn_stridor
 * @property boolean $jn_gargling
 * @property boolean $pgd_simetri
 * @property boolean $pgd_asimetri
 * @property boolean $pgp_normal
 * @property boolean $pgp_kussmaul
 * @property boolean $pgp_takipnea
 * @property boolean $pgp_retraktif
 * @property boolean $pgp_dangkal
 * @property integer $sirkulasi_nadicarotis
 * @property integer $sirkulasi_nadiradialis
 * @property boolean $cfr_kecil_2
 * @property boolean $cfr_besar_2
 * @property boolean $kulit_normal
 * @property boolean $kulit_jaundice
 * @property boolean $kulit_cyanosis
 * @property boolean $kulit_pucat
 * @property boolean $kulit_berkeringat
 * @property string $akral
 * @property integer $gcs_eye
 * @property integer $gcs_verbal
 * @property boolean $adakelgastrointestinal
 * @property string $gastrointestinal_sebutkan
 * @property boolean $pembatasanmakanan
 * @property string $batasmakanan_sebutkan
 * @property boolean $gigipalsu
 * @property string $gigipalsu_bagian
 * @property boolean $mual
 * @property boolean $muntah
 * @property boolean $pendengaran
 * @property string $pendengaran_sebutkan
 * @property boolean $penglihatan
 * @property string $penglihatan_sebutkan
 * @property boolean $defekasi
 * @property string $defekasi_sebutkan
 * @property boolean $miksi
 * @property string $miksi_sebutkan
 * @property boolean $hamil
 * @property string $hpht
 * @property string $keluhanmenstruasi
 * @property integer $skornorton
 * @property boolean $resikodekubitus
 * @property boolean $terdapatluka
 * @property string $lokasiluka
 * @property boolean $hambatanpembelajaran
 * @property string $hambatanpembelajaran_ya
 * @property boolean $butuhpenerjemah
 * @property string $kebutuhanpembelajaran
 */
class InfopengkajianaskepV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopengkajianaskepV the static model class
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
		return 'infopengkajianaskep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, pegawai_id, detaknadi, gcs_motorik, pengkajianaskep_id, jmlrokok_btg_hr, sirkulasi_nadicarotis, sirkulasi_nadiradialis, gcs_eye, gcs_verbal, skornorton', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, tinggibadan_cm, meanarteripressure', 'numerical'),
			array('no_pengkajian, tekanandarah, no_pendaftaran, statusperkawinan, jeniskelamin, agama, jk, lamasakit, gelangtandaalergi, aktifitas_mobilisasi, tandasegitigaterpasang, nyeriterasa', 'length', 'max'=>20),
			array('nama_pegawai, ruangan_nama, kelaspelayanan_nama, nama_pasien, pekerjaan_nama, pendidikan_nama, nama_pj, no_identitas, hubungankeluarga, skalanyeri, karakteristiknyeri, lokasinyeri', 'length', 'max'=>50),
			array('riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, riwayatalergiobat, riwayatmakanan, dirawatdimana, riwpenyakitkeldari, penyakitmayor, reaksialergiobat, reaksialergimakanan, riwayatalergilainnya, reaksialergilainnya, pengobatanygsudahdilakukan, riwayatkelahiran, statuspsikologis, statusmental, masalahsebelumnya, prilakukekerasansebelumnya, sebutkan_bantuan, nyerihilangbila, tempattinggal, denyutjantung, gastrointestinal_sebutkan, batasmakanan_sebutkan, gigipalsu_bagian, pendengaran_sebutkan, penglihatan_sebutkan, defekasi_sebutkan, miksi_sebutkan, hpht, keluhanmenstruasi, lokasiluka, hambatanpembelajaran_ya, kebutuhanpembelajaran', 'length', 'max'=>100),
			array('riwayatimunisasi, keadaanumum, inspeksi, palpasi, perkusi, auskultasi', 'length', 'max'=>500),
			array('suhutubuh, no_rekam_medik, kamarruangan_nobed, skriningnyeri', 'length', 'max'=>10),
			array('kelainanpadabagtubuh, umur', 'length', 'max'=>30),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('diagnosa_nama, akral', 'length', 'max'=>200),
			array('no_teleponpj, no_mobilepj', 'length', 'max'=>15),
			array('pengkajianaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglanamnesis, keluhanutama, keluhantambahan, tglperiksafisik, pernapasan, tgl_pendaftaran, alamat_pasien, tgllahir_pj, alamat_pj, riwayatperjalananpasien, pernahdirawat, statusmerokok, penurunanbb_3bln, asupanberkurang, resikocedera, isgelangresiko, hubkeluarga, keterangananamesa, jn_paten, jn_obstruktifpartial, jn_obstruktifnormal, jn_stridor, jn_gargling, pgd_simetri, pgd_asimetri, pgp_normal, pgp_kussmaul, pgp_takipnea, pgp_retraktif, pgp_dangkal, cfr_kecil_2, cfr_besar_2, kulit_normal, kulit_jaundice, kulit_cyanosis, kulit_pucat, kulit_berkeringat, adakelgastrointestinal, pembatasanmakanan, gigipalsu, mual, muntah, pendengaran, penglihatan, defekasi, miksi, hamil, resikodekubitus, terdapatluka, hambatanpembelajaran, butuhpenerjemah', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, no_pengkajian, pengkajianaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawai_id, nama_pegawai, tglanamnesis, keluhanutama, keluhantambahan, riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, riwayatimunisasi, riwayatalergiobat, riwayatmakanan, tglperiksafisik, keadaanumum, beratbadan_kg, tinggibadan_cm, tekanandarah, detaknadi, suhutubuh, pernapasan, gcs_motorik, kelainanpadabagtubuh, pengkajianaskep_id, ruangan_nama, kelaspelayanan_nama, nama_pasien, no_pendaftaran, tgl_pendaftaran, no_rekam_medik, umur, statusperkawinan, jeniskelamin, pekerjaan_nama, pendidikan_nama, agama, alamat_pasien, kamarruangan_nokamar, kamarruangan_nobed, diagnosa_nama, nama_pj, no_identitas, tgllahir_pj, no_teleponpj, no_mobilepj, hubungankeluarga, alamat_pj, jk, riwayatperjalananpasien, pernahdirawat, dirawatdimana, lamasakit, riwpenyakitkeldari, penyakitmayor, reaksialergiobat, reaksialergimakanan, riwayatalergilainnya, reaksialergilainnya, pengobatanygsudahdilakukan, riwayatkelahiran, gelangtandaalergi, statusmerokok, jmlrokok_btg_hr, statuspsikologis, statusmental, masalahsebelumnya, prilakukekerasansebelumnya, penurunanbb_3bln, asupanberkurang, aktifitas_mobilisasi, sebutkan_bantuan, resikocedera, isgelangresiko, tandasegitigaterpasang, skriningnyeri, skalanyeri, karakteristiknyeri, lokasinyeri, nyeriterasa, nyerihilangbila, hubkeluarga, tempattinggal, keterangananamesa, meanarteripressure, denyutjantung, inspeksi, palpasi, perkusi, auskultasi, jn_paten, jn_obstruktifpartial, jn_obstruktifnormal, jn_stridor, jn_gargling, pgd_simetri, pgd_asimetri, pgp_normal, pgp_kussmaul, pgp_takipnea, pgp_retraktif, pgp_dangkal, sirkulasi_nadicarotis, sirkulasi_nadiradialis, cfr_kecil_2, cfr_besar_2, kulit_normal, kulit_jaundice, kulit_cyanosis, kulit_pucat, kulit_berkeringat, akral, gcs_eye, gcs_verbal, adakelgastrointestinal, gastrointestinal_sebutkan, pembatasanmakanan, batasmakanan_sebutkan, gigipalsu, gigipalsu_bagian, mual, muntah, pendengaran, pendengaran_sebutkan, penglihatan, penglihatan_sebutkan, defekasi, defekasi_sebutkan, miksi, miksi_sebutkan, hamil, hpht, keluhanmenstruasi, skornorton, resikodekubitus, terdapatluka, lokasiluka, hambatanpembelajaran, hambatanpembelajaran_ya, butuhpenerjemah, kebutuhanpembelajaran', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'no_pengkajian' => 'No Pengkajian',
			'pengkajianaskep_tgl' => 'Pengkajianaskep Tgl',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'tglanamnesis' => 'Tglanamnesis',
			'keluhanutama' => 'Keluhanutama',
			'keluhantambahan' => 'Keluhantambahan',
			'riwayatpenyakitterdahulu' => 'Riwayatpenyakitterdahulu',
			'riwayatpenyakitkeluarga' => 'Riwayatpenyakitkeluarga',
			'riwayatimunisasi' => 'Riwayatimunisasi',
			'riwayatalergiobat' => 'Riwayatalergiobat',
			'riwayatmakanan' => 'Riwayatmakanan',
			'tglperiksafisik' => 'Tglperiksafisik',
			'keadaanumum' => 'Keadaanumum',
			'beratbadan_kg' => 'Beratbadan Kg',
			'tinggibadan_cm' => 'Tinggibadan Cm',
			'tekanandarah' => 'Tekanandarah',
			'detaknadi' => 'Detaknadi',
			'suhutubuh' => 'Suhutubuh',
			'pernapasan' => 'Pernapasan',
			'gcs_motorik' => 'Gcs Motorik',
			'kelainanpadabagtubuh' => 'Kelainanpadabagtubuh',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'nama_pasien' => 'Nama Pasien',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'umur' => 'Umur',
			'statusperkawinan' => 'Statusperkawinan',
			'jeniskelamin' => 'Jenis Kelamin',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'pendidikan_nama' => 'Pendidikan Nama',
			'agama' => 'Agama',
			'alamat_pasien' => 'Alamat Pasien',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'diagnosa_nama' => 'Diagnosa Nama',
			'nama_pj' => 'Nama Pj',
			'no_identitas' => 'No Identitas',
			'tgllahir_pj' => 'Tgllahir Pj',
			'no_teleponpj' => 'No Teleponpj',
			'no_mobilepj' => 'No Mobilepj',
			'hubungankeluarga' => 'Hubungankeluarga',
			'alamat_pj' => 'Alamat Pj',
			'jk' => 'Jk',
			'riwayatperjalananpasien' => 'Riwayatperjalananpasien',
			'pernahdirawat' => 'Pernahdirawat',
			'dirawatdimana' => 'Dirawatdimana',
			'lamasakit' => 'Lamasakit',
			'riwpenyakitkeldari' => 'Riwpenyakitkeldari',
			'penyakitmayor' => 'Penyakitmayor',
			'reaksialergiobat' => 'Reaksialergiobat',
			'reaksialergimakanan' => 'Reaksialergimakanan',
			'riwayatalergilainnya' => 'Riwayatalergilainnya',
			'reaksialergilainnya' => 'Reaksialergilainnya',
			'pengobatanygsudahdilakukan' => 'Pengobatanygsudahdilakukan',
			'riwayatkelahiran' => 'Riwayatkelahiran',
			'gelangtandaalergi' => 'Gelangtandaalergi',
			'statusmerokok' => 'Statusmerokok',
			'jmlrokok_btg_hr' => 'Jmlrokok Btg Hr',
			'statuspsikologis' => 'Statuspsikologis',
			'statusmental' => 'Statusmental',
			'masalahsebelumnya' => 'Masalahsebelumnya',
			'prilakukekerasansebelumnya' => 'Prilakukekerasansebelumnya',
			'penurunanbb_3bln' => 'Penurunanbb 3bln',
			'asupanberkurang' => 'Asupanberkurang',
			'aktifitas_mobilisasi' => 'Aktifitas Mobilisasi',
			'sebutkan_bantuan' => 'Sebutkan Bantuan',
			'resikocedera' => 'Resikocedera',
			'isgelangresiko' => 'Isgelangresiko',
			'tandasegitigaterpasang' => 'Tandasegitigaterpasang',
			'skriningnyeri' => 'Skriningnyeri',
			'skalanyeri' => 'Skalanyeri',
			'karakteristiknyeri' => 'Karakteristiknyeri',
			'lokasinyeri' => 'Lokasinyeri',
			'nyeriterasa' => 'Nyeriterasa',
			'nyerihilangbila' => 'Nyerihilangbila',
			'hubkeluarga' => 'Hubkeluarga',
			'tempattinggal' => 'Tempattinggal',
			'keterangananamesa' => 'Keterangananamesa',
			'meanarteripressure' => 'Meanarteripressure',
			'denyutjantung' => 'Denyutjantung',
			'inspeksi' => 'Inspeksi',
			'palpasi' => 'Palpasi',
			'perkusi' => 'Perkusi',
			'auskultasi' => 'Auskultasi',
			'jn_paten' => 'Jn Paten',
			'jn_obstruktifpartial' => 'Jn Obstruktifpartial',
			'jn_obstruktifnormal' => 'Jn Obstruktifnormal',
			'jn_stridor' => 'Jn Stridor',
			'jn_gargling' => 'Jn Gargling',
			'pgd_simetri' => 'Pgd Simetri',
			'pgd_asimetri' => 'Pgd Asimetri',
			'pgp_normal' => 'Pgp Normal',
			'pgp_kussmaul' => 'Pgp Kussmaul',
			'pgp_takipnea' => 'Pgp Takipnea',
			'pgp_retraktif' => 'Pgp Retraktif',
			'pgp_dangkal' => 'Pgp Dangkal',
			'sirkulasi_nadicarotis' => 'Sirkulasi Nadicarotis',
			'sirkulasi_nadiradialis' => 'Sirkulasi Nadiradialis',
			'cfr_kecil_2' => 'Cfr Kecil 2',
			'cfr_besar_2' => 'Cfr Besar 2',
			'kulit_normal' => 'Kulit Normal',
			'kulit_jaundice' => 'Kulit Jaundice',
			'kulit_cyanosis' => 'Kulit Cyanosis',
			'kulit_pucat' => 'Kulit Pucat',
			'kulit_berkeringat' => 'Kulit Berkeringat',
			'akral' => 'Akral',
			'gcs_eye' => 'Gcs Eye',
			'gcs_verbal' => 'Gcs Verbal',
			'adakelgastrointestinal' => 'Adakelgastrointestinal',
			'gastrointestinal_sebutkan' => 'Gastrointestinal Sebutkan',
			'pembatasanmakanan' => 'Pembatasanmakanan',
			'batasmakanan_sebutkan' => 'Batasmakanan Sebutkan',
			'gigipalsu' => 'Gigipalsu',
			'gigipalsu_bagian' => 'Gigipalsu Bagian',
			'mual' => 'Mual',
			'muntah' => 'Muntah',
			'pendengaran' => 'Pendengaran',
			'pendengaran_sebutkan' => 'Pendengaran Sebutkan',
			'penglihatan' => 'Penglihatan',
			'penglihatan_sebutkan' => 'Penglihatan Sebutkan',
			'defekasi' => 'Defekasi',
			'defekasi_sebutkan' => 'Defekasi Sebutkan',
			'miksi' => 'Miksi',
			'miksi_sebutkan' => 'Miksi Sebutkan',
			'hamil' => 'Hamil',
			'hpht' => 'Hpht',
			'keluhanmenstruasi' => 'Keluhanmenstruasi',
			'skornorton' => 'Skornorton',
			'resikodekubitus' => 'Resikodekubitus',
			'terdapatluka' => 'Terdapatluka',
			'lokasiluka' => 'Lokasiluka',
			'hambatanpembelajaran' => 'Hambatanpembelajaran',
			'hambatanpembelajaran_ya' => 'Hambatanpembelajaran Ya',
			'butuhpenerjemah' => 'Butuhpenerjemah',
			'kebutuhanpembelajaran' => 'Kebutuhanpembelajaran',
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
		$criteria->compare('pengkajianaskep_tgl',$this->pengkajianaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tglanamnesis',$this->tglanamnesis,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('riwayatmakanan',$this->riwayatmakanan,true);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('keadaanumum',$this->keadaanumum,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh,true);
		$criteria->compare('pernapasan',$this->pernapasan,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('riwayatperjalananpasien',$this->riwayatperjalananpasien,true);
		$criteria->compare('pernahdirawat',$this->pernahdirawat);
		$criteria->compare('dirawatdimana',$this->dirawatdimana,true);
		$criteria->compare('lamasakit',$this->lamasakit,true);
		$criteria->compare('riwpenyakitkeldari',$this->riwpenyakitkeldari,true);
		$criteria->compare('penyakitmayor',$this->penyakitmayor,true);
		$criteria->compare('reaksialergiobat',$this->reaksialergiobat,true);
		$criteria->compare('reaksialergimakanan',$this->reaksialergimakanan,true);
		$criteria->compare('riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('reaksialergilainnya',$this->reaksialergilainnya,true);
		$criteria->compare('pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('gelangtandaalergi',$this->gelangtandaalergi,true);
		$criteria->compare('statusmerokok',$this->statusmerokok);
		$criteria->compare('jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('statuspsikologis',$this->statuspsikologis,true);
		$criteria->compare('statusmental',$this->statusmental,true);
		$criteria->compare('masalahsebelumnya',$this->masalahsebelumnya,true);
		$criteria->compare('prilakukekerasansebelumnya',$this->prilakukekerasansebelumnya,true);
		$criteria->compare('penurunanbb_3bln',$this->penurunanbb_3bln);
		$criteria->compare('asupanberkurang',$this->asupanberkurang);
		$criteria->compare('aktifitas_mobilisasi',$this->aktifitas_mobilisasi,true);
		$criteria->compare('sebutkan_bantuan',$this->sebutkan_bantuan,true);
		$criteria->compare('resikocedera',$this->resikocedera);
		$criteria->compare('isgelangresiko',$this->isgelangresiko);
		$criteria->compare('tandasegitigaterpasang',$this->tandasegitigaterpasang,true);
		$criteria->compare('skriningnyeri',$this->skriningnyeri,true);
		$criteria->compare('skalanyeri',$this->skalanyeri,true);
		$criteria->compare('karakteristiknyeri',$this->karakteristiknyeri,true);
		$criteria->compare('lokasinyeri',$this->lokasinyeri,true);
		$criteria->compare('nyeriterasa',$this->nyeriterasa,true);
		$criteria->compare('nyerihilangbila',$this->nyerihilangbila,true);
		$criteria->compare('hubkeluarga',$this->hubkeluarga);
		$criteria->compare('tempattinggal',$this->tempattinggal,true);
		$criteria->compare('keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('meanarteripressure',$this->meanarteripressure);
		$criteria->compare('denyutjantung',$this->denyutjantung,true);
		$criteria->compare('inspeksi',$this->inspeksi,true);
		$criteria->compare('palpasi',$this->palpasi,true);
		$criteria->compare('perkusi',$this->perkusi,true);
		$criteria->compare('auskultasi',$this->auskultasi,true);
		$criteria->compare('jn_paten',$this->jn_paten);
		$criteria->compare('jn_obstruktifpartial',$this->jn_obstruktifpartial);
		$criteria->compare('jn_obstruktifnormal',$this->jn_obstruktifnormal);
		$criteria->compare('jn_stridor',$this->jn_stridor);
		$criteria->compare('jn_gargling',$this->jn_gargling);
		$criteria->compare('pgd_simetri',$this->pgd_simetri);
		$criteria->compare('pgd_asimetri',$this->pgd_asimetri);
		$criteria->compare('pgp_normal',$this->pgp_normal);
		$criteria->compare('pgp_kussmaul',$this->pgp_kussmaul);
		$criteria->compare('pgp_takipnea',$this->pgp_takipnea);
		$criteria->compare('pgp_retraktif',$this->pgp_retraktif);
		$criteria->compare('pgp_dangkal',$this->pgp_dangkal);
		$criteria->compare('sirkulasi_nadicarotis',$this->sirkulasi_nadicarotis);
		$criteria->compare('sirkulasi_nadiradialis',$this->sirkulasi_nadiradialis);
		$criteria->compare('cfr_kecil_2',$this->cfr_kecil_2);
		$criteria->compare('cfr_besar_2',$this->cfr_besar_2);
		$criteria->compare('kulit_normal',$this->kulit_normal);
		$criteria->compare('kulit_jaundice',$this->kulit_jaundice);
		$criteria->compare('kulit_cyanosis',$this->kulit_cyanosis);
		$criteria->compare('kulit_pucat',$this->kulit_pucat);
		$criteria->compare('kulit_berkeringat',$this->kulit_berkeringat);
		$criteria->compare('akral',$this->akral,true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('adakelgastrointestinal',$this->adakelgastrointestinal);
		$criteria->compare('gastrointestinal_sebutkan',$this->gastrointestinal_sebutkan,true);
		$criteria->compare('pembatasanmakanan',$this->pembatasanmakanan);
		$criteria->compare('batasmakanan_sebutkan',$this->batasmakanan_sebutkan,true);
		$criteria->compare('gigipalsu',$this->gigipalsu);
		$criteria->compare('gigipalsu_bagian',$this->gigipalsu_bagian,true);
		$criteria->compare('mual',$this->mual);
		$criteria->compare('muntah',$this->muntah);
		$criteria->compare('pendengaran',$this->pendengaran);
		$criteria->compare('pendengaran_sebutkan',$this->pendengaran_sebutkan,true);
		$criteria->compare('penglihatan',$this->penglihatan);
		$criteria->compare('penglihatan_sebutkan',$this->penglihatan_sebutkan,true);
		$criteria->compare('defekasi',$this->defekasi);
		$criteria->compare('defekasi_sebutkan',$this->defekasi_sebutkan,true);
		$criteria->compare('miksi',$this->miksi);
		$criteria->compare('miksi_sebutkan',$this->miksi_sebutkan,true);
		$criteria->compare('hamil',$this->hamil);
		$criteria->compare('hpht',$this->hpht,true);
		$criteria->compare('keluhanmenstruasi',$this->keluhanmenstruasi,true);
		$criteria->compare('skornorton',$this->skornorton);
		$criteria->compare('resikodekubitus',$this->resikodekubitus);
		$criteria->compare('terdapatluka',$this->terdapatluka);
		$criteria->compare('lokasiluka',$this->lokasiluka,true);
		$criteria->compare('hambatanpembelajaran',$this->hambatanpembelajaran);
		$criteria->compare('hambatanpembelajaran_ya',$this->hambatanpembelajaran_ya,true);
		$criteria->compare('butuhpenerjemah',$this->butuhpenerjemah);
		$criteria->compare('kebutuhanpembelajaran',$this->kebutuhanpembelajaran,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNamaLengkap()
        {
            $nama = PegawairuanganV::model()->find("pegawai_id = '".$this->pegawai_id."' ");
            
            return $nama->gelardepan.' '.$nama->nama_pegawai.' '.$nama->gelarbelakang_nama;
        }
}