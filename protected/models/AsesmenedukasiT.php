<?php

/**
 * This is the model class for table "asesmenedukasi_t".
 *
 * The followings are the available columns in table 'asesmenedukasi_t':
 * @property integer $asesmenedukasi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $instalasiawal_id
 * @property string $nama_lengkap
 * @property integer $umur
 * @property string $agama
 * @property string $sukubangsa
 * @property string $nilai_keyakinan
 * @property string $alamat
 * @property string $tingkatpendidikan
 * @property string $tingkatpendidikan_lainnya
 * @property string $hub_denganpasien
 * @property boolean $menerimaedukasi_bersedia
 * @property boolean $menerimaedukasi_tidakbersedia
 * @property boolean $bahasa_indonesia
 * @property boolean $bahasa_inggis
 * @property boolean $bahasa_daerah
 * @property string $bahasa_daerah_keterangan
 * @property boolean $bahasa_lainnya
 * @property string $bahasa_lainnya_ket
 * @property boolean $kemampuanbahasa_baik
 * @property boolean $kemampuanbahasa_cukup
 * @property boolean $kemampuanbahasa_kurang
 * @property boolean $kebutuhanpenerjemah_ya
 * @property boolean $kebutuhanpenerjemah_tidak
 * @property boolean $bacatulis_baik
 * @property boolean $bacatulis_kurang
 * @property boolean $hambatanedukasi_tidakada
 * @property boolean $hambatanedukasi_motivasikurang
 * @property boolean $hambatanedukasi_kognitifterbatas
 * @property boolean $hambatanedukasi_fisiklemah
 * @property boolean $hambatanedukasi_penglihatanterganggu
 * @property boolean $hambatanedukasi_pendengaranterganggu
 * @property boolean $bicara_normal
 * @property boolean $bicara_gangguansejak
 * @property string $bicara_gangguansejak_ket
 * @property boolean $metodeedukasi_audiovisual
 * @property boolean $metodeedukasi_duskusi
 * @property boolean $metodeedukasi_wawancara
 * @property boolean $metodeedukasi_demontrasi
 * @property boolean $metodeedukasi_ceramah
 * @property boolean $metodeedukasi_lainnya
 * @property string $metodeedukasi_lainnya_ket
 * @property boolean $kebutuhanprivasi_ya
 * @property boolean $kebutuhanprivasi_ya_wawancara
 * @property boolean $kebutuhanprivasi_ya_pemeriksaanfisik
 * @property boolean $kebutuhanprivasi_ya_tindakan
 * @property boolean $kebutuhanprivasi_ya_transportasi
 * @property boolean $kebutuhanprivasi_ya_ruangperawatan
 * @property boolean $kebutuhanprivasi_ya_lainnya
 * @property string $kebutuhanprivasi_ya_lainnya_ket
 * @property boolean $kebutuhanprivasi_tidak
 * @property boolean $admisi_penjaminan
 * @property boolean $admisi_biayapengobatan
 * @property boolean $admisi_pemasangangelang
 * @property boolean $medis_diagnosapenyakit
 * @property boolean $medis_hasilpemeriksaan
 * @property boolean $medis_tindakanmedis
 * @property boolean $medis_penjelasankompilasi
 * @property boolean $medis_perkiraanharirawat
 * @property boolean $medis_lainnya
 * @property string $medis_lainnya_ket
 * @property boolean $manajemennyeri_farmakologi
 * @property boolean $manajemennyeri_nonfarmakologi
 * @property boolean $manajemennyeri_lainnya
 * @property string $manajemennyeri_lainnya_ket
 * @property boolean $keperawatan_informasitentang
 * @property boolean $keperawatan_perawatanluka
 * @property boolean $keperawatan_penggunaanalatmedis
 * @property boolean $keperawatan_penangananperawatan
 * @property boolean $keperawatan_keamananperawatan
 * @property boolean $keperawatan_cucitangan
 * @property boolean $keperawatan_edukasikhusus
 * @property boolean $keperawatan_postcatherisasi
 * @property boolean $keperawatan_lainnya
 * @property string $keperawatan_lainnya_ket
 * @property boolean $pengobatan_namakegunaanobat
 * @property boolean $pengobatan_aturanpakaiobat
 * @property boolean $pengobatan_jumlahobatdiberikan
 * @property boolean $pengobatan_carapenyimpanan
 * @property boolean $pengobatan_efeksamping
 * @property boolean $pengobatan_kontraindikasi
 * @property boolean $pengobatan_lainnya
 * @property string $pengobatan_lainnya_ket
 * @property boolean $rehabmedis_fisioterapi
 * @property boolean $rehabmedis_okupasiterapi
 * @property boolean $rehabmedis_terapiwicara
 * @property boolean $rehabmedis_ortotikprostetik
 * @property boolean $dietnutrisi_dietnutrisi
 * @property boolean $dietnutrisi_lainnya
 * @property string $dietnutrisi_lainnya_ket
 * @property boolean $pelrohani_bimbinganrohani
 * @property boolean $pelrohani_konselingrohani
 * @property boolean $penunjang_patologiklinik
 * @property boolean $penunjang_patologianatomi
 * @property boolean $penunjang_mikrobiologi
 * @property boolean $penunjang_radiodiagnostik
 * @property string $radioterapi
 * @property boolean $itd_pelbotomi
 * @property boolean $itd_lainnya
 * @property string $itd_lainnya_ket
 */
class AsesmenedukasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmenedukasiT the static model class
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
		return 'asesmenedukasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, instalasiawal_id, nama_lengkap', 'required'),
			array('pendaftaran_id, pasien_id, instalasiawal_id, umur', 'numerical', 'integerOnly'=>true),
			array('nama_lengkap, pengobatan_lainnya_ket', 'length', 'max'=>200),
			array('agama, tingkatpendidikan, bahasa_daerah_keterangan, bahasa_lainnya_ket', 'length', 'max'=>20),
			array('sukubangsa', 'length', 'max'=>30),
			array('nilai_keyakinan, bicara_gangguansejak_ket, metodeedukasi_lainnya_ket', 'length', 'max'=>50),
			array('alamat', 'length', 'max'=>250),
			array('tingkatpendidikan_lainnya, dietnutrisi_lainnya_ket', 'length', 'max'=>150),
			array('hub_denganpasien, kebutuhanprivasi_ya_lainnya_ket, medis_lainnya_ket, manajemennyeri_lainnya_ket, keperawatan_lainnya_ket, itd_lainnya_ket', 'length', 'max'=>100),
			array('menerimaedukasi_bersedia, menerimaedukasi_tidakbersedia, bahasa_indonesia, bahasa_inggis, bahasa_daerah, bahasa_lainnya, kemampuanbahasa_baik, kemampuanbahasa_cukup, kemampuanbahasa_kurang, kebutuhanpenerjemah_ya, kebutuhanpenerjemah_tidak, bacatulis_baik, bacatulis_kurang, hambatanedukasi_tidakada, hambatanedukasi_motivasikurang, hambatanedukasi_kognitifterbatas, hambatanedukasi_fisiklemah, hambatanedukasi_penglihatanterganggu, hambatanedukasi_pendengaranterganggu, bicara_normal, bicara_gangguansejak, metodeedukasi_audiovisual, metodeedukasi_duskusi, metodeedukasi_wawancara, metodeedukasi_demontrasi, metodeedukasi_ceramah, metodeedukasi_lainnya, kebutuhanprivasi_ya, kebutuhanprivasi_ya_wawancara, kebutuhanprivasi_ya_pemeriksaanfisik, kebutuhanprivasi_ya_tindakan, kebutuhanprivasi_ya_transportasi, kebutuhanprivasi_ya_ruangperawatan, kebutuhanprivasi_ya_lainnya, kebutuhanprivasi_tidak, admisi_penjaminan, admisi_biayapengobatan, admisi_pemasangangelang, medis_diagnosapenyakit, medis_hasilpemeriksaan, medis_tindakanmedis, medis_penjelasankompilasi, medis_perkiraanharirawat, medis_lainnya, manajemennyeri_farmakologi, manajemennyeri_nonfarmakologi, manajemennyeri_lainnya, keperawatan_informasitentang, keperawatan_perawatanluka, keperawatan_penggunaanalatmedis, keperawatan_penangananperawatan, keperawatan_keamananperawatan, keperawatan_cucitangan, keperawatan_edukasikhusus, keperawatan_postcatherisasi, keperawatan_lainnya, pengobatan_namakegunaanobat, pengobatan_aturanpakaiobat, pengobatan_jumlahobatdiberikan, pengobatan_carapenyimpanan, pengobatan_efeksamping, pengobatan_kontraindikasi, pengobatan_lainnya, rehabmedis_fisioterapi, rehabmedis_okupasiterapi, rehabmedis_terapiwicara, rehabmedis_ortotikprostetik, dietnutrisi_dietnutrisi, dietnutrisi_lainnya, pelrohani_bimbinganrohani, pelrohani_konselingrohani, penunjang_patologiklinik, penunjang_patologianatomi, penunjang_mikrobiologi, penunjang_radiodiagnostik, radioterapi, itd_pelbotomi, itd_lainnya', 'safe'),
                        array('pasienmasukpenunjang_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan','safe'),
			array('ppa_jenis, ppa_namajenis, pegawaippa_id, dpjp_id, supervisi_id, tgl_edukasi', 'safe'),
			array('isverifikasidpjp, verifikasidpjp_tanggal, verifikasipdjp_hasilreview', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmenedukasi_id, pendaftaran_id, pasien_id, instalasiawal_id, nama_lengkap, umur, agama, sukubangsa, nilai_keyakinan, alamat, tingkatpendidikan, tingkatpendidikan_lainnya, hub_denganpasien, menerimaedukasi_bersedia, menerimaedukasi_tidakbersedia, bahasa_indonesia, bahasa_inggis, bahasa_daerah, bahasa_daerah_keterangan, bahasa_lainnya, bahasa_lainnya_ket, kemampuanbahasa_baik, kemampuanbahasa_cukup, kemampuanbahasa_kurang, kebutuhanpenerjemah_ya, kebutuhanpenerjemah_tidak, bacatulis_baik, bacatulis_kurang, hambatanedukasi_tidakada, hambatanedukasi_motivasikurang, hambatanedukasi_kognitifterbatas, hambatanedukasi_fisiklemah, hambatanedukasi_penglihatanterganggu, hambatanedukasi_pendengaranterganggu, bicara_normal, bicara_gangguansejak, bicara_gangguansejak_ket, metodeedukasi_audiovisual, metodeedukasi_duskusi, metodeedukasi_wawancara, metodeedukasi_demontrasi, metodeedukasi_ceramah, metodeedukasi_lainnya, metodeedukasi_lainnya_ket, kebutuhanprivasi_ya, kebutuhanprivasi_ya_wawancara, kebutuhanprivasi_ya_pemeriksaanfisik, kebutuhanprivasi_ya_tindakan, kebutuhanprivasi_ya_transportasi, kebutuhanprivasi_ya_ruangperawatan, kebutuhanprivasi_ya_lainnya, kebutuhanprivasi_ya_lainnya_ket, kebutuhanprivasi_tidak, admisi_penjaminan, admisi_biayapengobatan, admisi_pemasangangelang, medis_diagnosapenyakit, medis_hasilpemeriksaan, medis_tindakanmedis, medis_penjelasankompilasi, medis_perkiraanharirawat, medis_lainnya, medis_lainnya_ket, manajemennyeri_farmakologi, manajemennyeri_nonfarmakologi, manajemennyeri_lainnya, manajemennyeri_lainnya_ket, keperawatan_informasitentang, keperawatan_perawatanluka, keperawatan_penggunaanalatmedis, keperawatan_penangananperawatan, keperawatan_keamananperawatan, keperawatan_cucitangan, keperawatan_edukasikhusus, keperawatan_postcatherisasi, keperawatan_lainnya, keperawatan_lainnya_ket, pengobatan_namakegunaanobat, pengobatan_aturanpakaiobat, pengobatan_jumlahobatdiberikan, pengobatan_carapenyimpanan, pengobatan_efeksamping, pengobatan_kontraindikasi, pengobatan_lainnya, pengobatan_lainnya_ket, rehabmedis_fisioterapi, rehabmedis_okupasiterapi, rehabmedis_terapiwicara, rehabmedis_ortotikprostetik, dietnutrisi_dietnutrisi, dietnutrisi_lainnya, dietnutrisi_lainnya_ket, pelrohani_bimbinganrohani, pelrohani_konselingrohani, penunjang_patologiklinik, penunjang_patologianatomi, penunjang_mikrobiologi, penunjang_radiodiagnostik, radioterapi, itd_pelbotomi, itd_lainnya, itd_lainnya_ket', 'safe', 'on'=>'search'),
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
                    'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
					'pegawaippa' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaippa_id'),
					'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
					'supervisi' => array(self::BELONGS_TO, 'PegawaiM', 'supervisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenedukasi_id' => 'Asesmenedukasi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'instalasiawal_id' => 'Instalasi Perawatan',
			'nama_lengkap' => 'Nama',
			'umur' => 'Umur',
			'agama' => 'Agama',
			'sukubangsa' => 'Suku Bangsa',
			'nilai_keyakinan' => 'Nilai - Nilai Keyakinan',
			'alamat' => 'Alamat',
			'tingkatpendidikan' => 'Tingkat Pendidikan',
			'tingkatpendidikan_lainnya' => 'Lainnya',
			'hub_denganpasien' => 'Hubungan Dengan Pasien',
			'menerimaedukasi_bersedia' => 'Menerimaedukasi Bersedia',
			'menerimaedukasi_tidakbersedia' => 'Menerimaedukasi Tidakbersedia',
			'bahasa_indonesia' => 'Bahasa Indonesia',
			'bahasa_inggis' => 'Bahasa Inggis',
			'bahasa_daerah' => 'Bahasa Daerah',
			'bahasa_daerah_keterangan' => 'Bahasa Daerah Keterangan',
			'bahasa_lainnya' => 'Bahasa Lainnya',
			'bahasa_lainnya_ket' => 'Bahasa Lainnya Ket',
			'kemampuanbahasa_baik' => 'Kemampuanbahasa Baik',
			'kemampuanbahasa_cukup' => 'Kemampuanbahasa Cukup',
			'kemampuanbahasa_kurang' => 'Kemampuanbahasa Kurang',
			'kebutuhanpenerjemah_ya' => 'Kebutuhanpenerjemah Ya',
			'kebutuhanpenerjemah_tidak' => 'Kebutuhanpenerjemah Tidak',
			'bacatulis_baik' => 'Bacatulis Baik',
			'bacatulis_kurang' => 'Bacatulis Kurang',
			'hambatanedukasi_tidakada' => 'Hambatanedukasi Tidakada',
			'hambatanedukasi_motivasikurang' => 'Hambatanedukasi Motivasikurang',
			'hambatanedukasi_kognitifterbatas' => 'Hambatanedukasi Kognitifterbatas',
			'hambatanedukasi_fisiklemah' => 'Hambatanedukasi Fisiklemah',
			'hambatanedukasi_penglihatanterganggu' => 'Hambatanedukasi Penglihatanterganggu',
			'hambatanedukasi_pendengaranterganggu' => 'Hambatanedukasi Pendengaranterganggu',
			'bicara_normal' => 'Bicara Normal',
			'bicara_gangguansejak' => 'Bicara Gangguansejak',
			'bicara_gangguansejak_ket' => 'Bicara Gangguansejak Ket',
			'metodeedukasi_audiovisual' => 'Metodeedukasi Audiovisual',
			'metodeedukasi_duskusi' => 'Metodeedukasi Duskusi',
			'metodeedukasi_wawancara' => 'Metodeedukasi Wawancara',
			'metodeedukasi_demontrasi' => 'Metodeedukasi Demontrasi',
			'metodeedukasi_ceramah' => 'Metodeedukasi Ceramah',
			'metodeedukasi_lainnya' => 'Metodeedukasi Lainnya',
			'metodeedukasi_lainnya_ket' => 'Metodeedukasi Lainnya Ket',
			'kebutuhanprivasi_ya' => 'Kebutuhanprivasi Ya',
			'kebutuhanprivasi_ya_wawancara' => 'Kebutuhanprivasi Ya Wawancara',
			'kebutuhanprivasi_ya_pemeriksaanfisik' => 'Kebutuhanprivasi Ya Pemeriksaanfisik',
			'kebutuhanprivasi_ya_tindakan' => 'Kebutuhanprivasi Ya Tindakan',
			'kebutuhanprivasi_ya_transportasi' => 'Kebutuhanprivasi Ya Transportasi',
			'kebutuhanprivasi_ya_ruangperawatan' => 'Kebutuhanprivasi Ya Ruangperawatan',
			'kebutuhanprivasi_ya_lainnya' => 'Kebutuhanprivasi Ya Lainnya',
			'kebutuhanprivasi_ya_lainnya_ket' => 'Kebutuhanprivasi Ya Lainnya Ket',
			'kebutuhanprivasi_tidak' => 'Kebutuhanprivasi Tidak',
			'admisi_penjaminan' => 'Admisi Penjaminan',
			'admisi_biayapengobatan' => 'Admisi Biayapengobatan',
			'admisi_pemasangangelang' => 'Admisi Pemasangangelang',
			'medis_diagnosapenyakit' => 'Medis Diagnosapenyakit',
			'medis_hasilpemeriksaan' => 'Medis Hasilpemeriksaan',
			'medis_tindakanmedis' => 'Medis Tindakanmedis',
			'medis_penjelasankompilasi' => 'Medis Penjelasankompilasi',
			'medis_perkiraanharirawat' => 'Medis Perkiraanharirawat',
			'medis_lainnya' => 'Medis Lainnya',
			'medis_lainnya_ket' => 'Medis Lainnya Ket',
			'manajemennyeri_farmakologi' => 'Manajemennyeri Farmakologi',
			'manajemennyeri_nonfarmakologi' => 'Manajemennyeri Nonfarmakologi',
			'manajemennyeri_lainnya' => 'Manajemennyeri Lainnya',
			'manajemennyeri_lainnya_ket' => 'Manajemennyeri Lainnya Ket',
			'keperawatan_informasitentang' => 'Keperawatan Informasitentang',
			'keperawatan_perawatanluka' => 'Keperawatan Perawatanluka',
			'keperawatan_penggunaanalatmedis' => 'Keperawatan Penggunaanalatmedis',
			'keperawatan_penangananperawatan' => 'Keperawatan Penangananperawatan',
			'keperawatan_keamananperawatan' => 'Keperawatan Keamananperawatan',
			'keperawatan_cucitangan' => 'Keperawatan Cucitangan',
			'keperawatan_edukasikhusus' => 'Keperawatan Edukasikhusus',
			'keperawatan_postcatherisasi' => 'Keperawatan Postcatherisasi',
			'keperawatan_lainnya' => 'Keperawatan Lainnya',
			'keperawatan_lainnya_ket' => 'Keperawatan Lainnya Ket',
			'pengobatan_namakegunaanobat' => 'Pengobatan Namakegunaanobat',
			'pengobatan_aturanpakaiobat' => 'Pengobatan Aturanpakaiobat',
			'pengobatan_jumlahobatdiberikan' => 'Pengobatan Jumlahobatdiberikan',
			'pengobatan_carapenyimpanan' => 'Pengobatan Carapenyimpanan',
			'pengobatan_efeksamping' => 'Pengobatan Efeksamping',
			'pengobatan_kontraindikasi' => 'Pengobatan Kontraindikasi',
			'pengobatan_lainnya' => 'Pengobatan Lainnya',
			'pengobatan_lainnya_ket' => 'Pengobatan Lainnya Ket',
			'rehabmedis_fisioterapi' => 'Rehabmedis Fisioterapi',
			'rehabmedis_okupasiterapi' => 'Rehabmedis Okupasiterapi',
			'rehabmedis_terapiwicara' => 'Rehabmedis Terapiwicara',
			'rehabmedis_ortotikprostetik' => 'Rehabmedis Ortotikprostetik',
			'dietnutrisi_dietnutrisi' => 'Dietnutrisi Dietnutrisi',
			'dietnutrisi_lainnya' => 'Dietnutrisi Lainnya',
			'dietnutrisi_lainnya_ket' => 'Dietnutrisi Lainnya Ket',
			'pelrohani_bimbinganrohani' => 'Pelrohani Bimbinganrohani',
			'pelrohani_konselingrohani' => 'Pelrohani Konselingrohani',
			'penunjang_patologiklinik' => 'Penunjang Patologiklinik',
			'penunjang_patologianatomi' => 'Penunjang Patologianatomi',
			'penunjang_mikrobiologi' => 'Penunjang Mikrobiologi',
			'penunjang_radiodiagnostik' => 'Penunjang Radiodiagnostik',
			'radioterapi' => 'Radioterapi',
			'itd_pelbotomi' => 'Itd Pelbotomi',
			'itd_lainnya' => 'Itd Lainnya',
			'itd_lainnya_ket' => 'Itd Lainnya Ket',
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

		$criteria->compare('asesmenedukasi_id',$this->asesmenedukasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('instalasiawal_id',$this->instalasiawal_id);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('umur',$this->umur);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('sukubangsa',$this->sukubangsa,true);
		$criteria->compare('nilai_keyakinan',$this->nilai_keyakinan,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('tingkatpendidikan',$this->tingkatpendidikan,true);
		$criteria->compare('tingkatpendidikan_lainnya',$this->tingkatpendidikan_lainnya,true);
		$criteria->compare('hub_denganpasien',$this->hub_denganpasien,true);
		$criteria->compare('menerimaedukasi_bersedia',$this->menerimaedukasi_bersedia);
		$criteria->compare('menerimaedukasi_tidakbersedia',$this->menerimaedukasi_tidakbersedia);
		$criteria->compare('bahasa_indonesia',$this->bahasa_indonesia);
		$criteria->compare('bahasa_inggis',$this->bahasa_inggis);
		$criteria->compare('bahasa_daerah',$this->bahasa_daerah);
		$criteria->compare('bahasa_daerah_keterangan',$this->bahasa_daerah_keterangan,true);
		$criteria->compare('bahasa_lainnya',$this->bahasa_lainnya);
		$criteria->compare('bahasa_lainnya_ket',$this->bahasa_lainnya_ket,true);
		$criteria->compare('kemampuanbahasa_baik',$this->kemampuanbahasa_baik);
		$criteria->compare('kemampuanbahasa_cukup',$this->kemampuanbahasa_cukup);
		$criteria->compare('kemampuanbahasa_kurang',$this->kemampuanbahasa_kurang);
		$criteria->compare('kebutuhanpenerjemah_ya',$this->kebutuhanpenerjemah_ya);
		$criteria->compare('kebutuhanpenerjemah_tidak',$this->kebutuhanpenerjemah_tidak);
		$criteria->compare('bacatulis_baik',$this->bacatulis_baik);
		$criteria->compare('bacatulis_kurang',$this->bacatulis_kurang);
		$criteria->compare('hambatanedukasi_tidakada',$this->hambatanedukasi_tidakada);
		$criteria->compare('hambatanedukasi_motivasikurang',$this->hambatanedukasi_motivasikurang);
		$criteria->compare('hambatanedukasi_kognitifterbatas',$this->hambatanedukasi_kognitifterbatas);
		$criteria->compare('hambatanedukasi_fisiklemah',$this->hambatanedukasi_fisiklemah);
		$criteria->compare('hambatanedukasi_penglihatanterganggu',$this->hambatanedukasi_penglihatanterganggu);
		$criteria->compare('hambatanedukasi_pendengaranterganggu',$this->hambatanedukasi_pendengaranterganggu);
		$criteria->compare('bicara_normal',$this->bicara_normal);
		$criteria->compare('bicara_gangguansejak',$this->bicara_gangguansejak);
		$criteria->compare('bicara_gangguansejak_ket',$this->bicara_gangguansejak_ket,true);
		$criteria->compare('metodeedukasi_audiovisual',$this->metodeedukasi_audiovisual);
		$criteria->compare('metodeedukasi_duskusi',$this->metodeedukasi_duskusi);
		$criteria->compare('metodeedukasi_wawancara',$this->metodeedukasi_wawancara);
		$criteria->compare('metodeedukasi_demontrasi',$this->metodeedukasi_demontrasi);
		$criteria->compare('metodeedukasi_ceramah',$this->metodeedukasi_ceramah);
		$criteria->compare('metodeedukasi_lainnya',$this->metodeedukasi_lainnya);
		$criteria->compare('metodeedukasi_lainnya_ket',$this->metodeedukasi_lainnya_ket,true);
		$criteria->compare('kebutuhanprivasi_ya',$this->kebutuhanprivasi_ya);
		$criteria->compare('kebutuhanprivasi_ya_wawancara',$this->kebutuhanprivasi_ya_wawancara);
		$criteria->compare('kebutuhanprivasi_ya_pemeriksaanfisik',$this->kebutuhanprivasi_ya_pemeriksaanfisik);
		$criteria->compare('kebutuhanprivasi_ya_tindakan',$this->kebutuhanprivasi_ya_tindakan);
		$criteria->compare('kebutuhanprivasi_ya_transportasi',$this->kebutuhanprivasi_ya_transportasi);
		$criteria->compare('kebutuhanprivasi_ya_ruangperawatan',$this->kebutuhanprivasi_ya_ruangperawatan);
		$criteria->compare('kebutuhanprivasi_ya_lainnya',$this->kebutuhanprivasi_ya_lainnya);
		$criteria->compare('kebutuhanprivasi_ya_lainnya_ket',$this->kebutuhanprivasi_ya_lainnya_ket,true);
		$criteria->compare('kebutuhanprivasi_tidak',$this->kebutuhanprivasi_tidak);
		$criteria->compare('admisi_penjaminan',$this->admisi_penjaminan);
		$criteria->compare('admisi_biayapengobatan',$this->admisi_biayapengobatan);
		$criteria->compare('admisi_pemasangangelang',$this->admisi_pemasangangelang);
		$criteria->compare('medis_diagnosapenyakit',$this->medis_diagnosapenyakit);
		$criteria->compare('medis_hasilpemeriksaan',$this->medis_hasilpemeriksaan);
		$criteria->compare('medis_tindakanmedis',$this->medis_tindakanmedis);
		$criteria->compare('medis_penjelasankompilasi',$this->medis_penjelasankompilasi);
		$criteria->compare('medis_perkiraanharirawat',$this->medis_perkiraanharirawat);
		$criteria->compare('medis_lainnya',$this->medis_lainnya);
		$criteria->compare('medis_lainnya_ket',$this->medis_lainnya_ket,true);
		$criteria->compare('manajemennyeri_farmakologi',$this->manajemennyeri_farmakologi);
		$criteria->compare('manajemennyeri_nonfarmakologi',$this->manajemennyeri_nonfarmakologi);
		$criteria->compare('manajemennyeri_lainnya',$this->manajemennyeri_lainnya);
		$criteria->compare('manajemennyeri_lainnya_ket',$this->manajemennyeri_lainnya_ket,true);
		$criteria->compare('keperawatan_informasitentang',$this->keperawatan_informasitentang);
		$criteria->compare('keperawatan_perawatanluka',$this->keperawatan_perawatanluka);
		$criteria->compare('keperawatan_penggunaanalatmedis',$this->keperawatan_penggunaanalatmedis);
		$criteria->compare('keperawatan_penangananperawatan',$this->keperawatan_penangananperawatan);
		$criteria->compare('keperawatan_keamananperawatan',$this->keperawatan_keamananperawatan);
		$criteria->compare('keperawatan_cucitangan',$this->keperawatan_cucitangan);
		$criteria->compare('keperawatan_edukasikhusus',$this->keperawatan_edukasikhusus);
		$criteria->compare('keperawatan_postcatherisasi',$this->keperawatan_postcatherisasi);
		$criteria->compare('keperawatan_lainnya',$this->keperawatan_lainnya);
		$criteria->compare('keperawatan_lainnya_ket',$this->keperawatan_lainnya_ket,true);
		$criteria->compare('pengobatan_namakegunaanobat',$this->pengobatan_namakegunaanobat);
		$criteria->compare('pengobatan_aturanpakaiobat',$this->pengobatan_aturanpakaiobat);
		$criteria->compare('pengobatan_jumlahobatdiberikan',$this->pengobatan_jumlahobatdiberikan);
		$criteria->compare('pengobatan_carapenyimpanan',$this->pengobatan_carapenyimpanan);
		$criteria->compare('pengobatan_efeksamping',$this->pengobatan_efeksamping);
		$criteria->compare('pengobatan_kontraindikasi',$this->pengobatan_kontraindikasi);
		$criteria->compare('pengobatan_lainnya',$this->pengobatan_lainnya);
		$criteria->compare('pengobatan_lainnya_ket',$this->pengobatan_lainnya_ket,true);
		$criteria->compare('rehabmedis_fisioterapi',$this->rehabmedis_fisioterapi);
		$criteria->compare('rehabmedis_okupasiterapi',$this->rehabmedis_okupasiterapi);
		$criteria->compare('rehabmedis_terapiwicara',$this->rehabmedis_terapiwicara);
		$criteria->compare('rehabmedis_ortotikprostetik',$this->rehabmedis_ortotikprostetik);
		$criteria->compare('dietnutrisi_dietnutrisi',$this->dietnutrisi_dietnutrisi);
		$criteria->compare('dietnutrisi_lainnya',$this->dietnutrisi_lainnya);
		$criteria->compare('dietnutrisi_lainnya_ket',$this->dietnutrisi_lainnya_ket,true);
		$criteria->compare('pelrohani_bimbinganrohani',$this->pelrohani_bimbinganrohani);
		$criteria->compare('pelrohani_konselingrohani',$this->pelrohani_konselingrohani);
		$criteria->compare('penunjang_patologiklinik',$this->penunjang_patologiklinik);
		$criteria->compare('penunjang_patologianatomi',$this->penunjang_patologianatomi);
		$criteria->compare('penunjang_mikrobiologi',$this->penunjang_mikrobiologi);
		$criteria->compare('penunjang_radiodiagnostik',$this->penunjang_radiodiagnostik);
		$criteria->compare('radioterapi',$this->radioterapi,true);
		$criteria->compare('itd_pelbotomi',$this->itd_pelbotomi);
		$criteria->compare('itd_lainnya',$this->itd_lainnya);
		$criteria->compare('itd_lainnya_ket',$this->itd_lainnya_ket,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}