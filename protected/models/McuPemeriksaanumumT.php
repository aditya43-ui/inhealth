<?php

/**
 * This is the model class for table "mcu_pemeriksaanumum_t".
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.models
 * The followings are the available columns in table 'mcu_pemeriksaanumum_t':
 * @property integer $mcu_pemeriksaanumum_id
 * @property string $tgl_pemeriksaan
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $diagnosis
 * @property string $tekanandarah
 * @property integer $nadi
 * @property integer $beratbadan
 * @property integer $tinggibadan
 * @property double $nilai_bmi
 * @property integer $bodymassindex_id
 * @property boolean $anemia_positif
 * @property boolean $anemia_negatif
 * @property boolean $ikterus_positif
 * @property boolean $ikterus_negatif
 * @property boolean $sesak_positif
 * @property boolean $sesak_negatif
 * @property boolean $gizi_baik
 * @property boolean $gizi_kurang
 * @property boolean $sembab_positif
 * @property boolean $sembab_negatif
 * @property string $sembab_keterangan
 * @property boolean $kepala_normal
 * @property boolean $kepala_abnormal
 * @property string $kepala_keterangan
 * @property boolean $leher_normal
 * @property boolean $leher_abnormal
 * @property string $leher_keterangan
 * @property boolean $jantung_normal
 * @property boolean $jantung_abnormal
 * @property string $jantung_keterangan
 * @property boolean $paru_normal
 * @property boolean $paru_abnormal
 * @property string $paru_keterangan
 * @property boolean $hepar_normal
 * @property boolean $hepar_abnormal
 * @property string $hepar_keterangan
 * @property boolean $limpa_takteraba
 * @property boolean $limpa_teraba
 * @property string $limpa_keterangan
 * @property boolean $abdomen_normal
 * @property boolean $abdomen_abnormal
 * @property string $abdomen_keterangan
 * @property boolean $extremitas_normal
 * @property boolean $extremitas_abnormal
 * @property string $extremitas_keterangan
 * @property boolean $tulangpersendian_normal
 * @property boolean $tulangpersendian_abnormal
 * @property string $tulangpersendian_keterangan
 * @property boolean $fotothorax_normal
 * @property boolean $fotothorax_abnormal
 * @property string $fotothorax_keterangan
 * @property double $bill_d
 * @property double $bill_t
 * @property double $alk
 * @property double $hdl
 * @property double $ldl
 * @property double $hb
 * @property integer $lekosit
 * @property double $hitungjenis_eo
 * @property double $hitungjenis_ba
 * @property double $hitungjenis_st
 * @property double $hitungjenis_sgm
 * @property double $hitungjenis_ly
 * @property double $hitungjenis_h
 * @property string $led
 * @property string $golongandarah
 * @property boolean $urine_normal
 * @property boolean $urine_abnormal
 * @property string $urine_keterangan
 * @property boolean $foses_normal
 * @property boolean $foses_abnormal
 * @property string $foses_keterangan
 * @property integer $bsn
 * @property integer $dua_jpp
 * @property integer $kolesterol_total
 * @property integer $triglisarida
 * @property integer $bun
 * @property integer $kreatinin
 * @property integer $asamurat
 * @property integer $sgot
 * @property integer $sgpt
 * @property boolean $hbeag_positif
 * @property boolean $hbeag_negatif
 * @property boolean $antihbe_positif
 * @property boolean $antihbe_negatif
 * @property string $kesimpulan_kesehatan
 * @property string $kesimpulan_keterangan
 * @property string $dugaan_diagnosis
 * @property string $terapi
 * @property string $saran
 * @property integer $konsulpoli_id
 * @property integer $dokterpemeriksa_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class McuPemeriksaanumumT extends CActiveRecord
{
    public $is_konsul, $keperluan, $jeniskeperluanmcu;
    public $path_berkas_temp;
    public $listpaketpemeriksaan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return McuPemeriksaanumumT the static model class
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
		return 'mcu_pemeriksaanumum_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, jeniskeperluanmcu, pasien_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, nadi, beratbadan, tinggibadan, bodymassindex_id, lekosit, bsn, dua_jpp, kolesterol_total, triglisarida, bun, kreatinin, asamurat, sgot, sgpt, konsulpoli_id, dokterpemeriksa_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilai_bmi, bill_d, bill_t, alk, hdl, ldl, hb, hitungjenis_eo, hitungjenis_ba, hitungjenis_st, hitungjenis_sgm, hitungjenis_ly, hitungjenis_h', 'numerical'),
			array('tekanandarah, led', 'length', 'max'=>10),
			array('mata_virus_kanan,mata_virus_kiri,mata_persepsi_warna,mata,sembab_keterangan, kepala_keterangan, leher_keterangan, jantung_keterangan, paru_keterangan, hepar_keterangan, limpa_keterangan, abdomen_keterangan, extremitas_keterangan, tulangpersendian_keterangan, fotothorax_keterangan, urine_keterangan, foses_keterangan', 'length', 'max'=>100),
			array('golongandarah', 'length', 'max'=>2),
			array('kesimpulan_kesehatan', 'length', 'max'=>15),
            array('jeniskeperluanmcu', 'length', 'max'=>100),
                    
			array('tekanandarah_sistolik,tekanandarah_diastolik,bmi_kategori,tgl_pemeriksaan, diagnosis, anemia_positif, anemia_negatif, ikterus_positif, ikterus_negatif, sesak_positif, sesak_negatif, gizi_baik, gizi_kurang, sembab_positif, sembab_negatif, kepala_normal, kepala_abnormal, leher_normal, leher_abnormal, jantung_normal, jantung_abnormal, paru_normal, paru_abnormal, hepar_normal, hepar_abnormal, limpa_takteraba, limpa_teraba, abdomen_normal, abdomen_abnormal, extremitas_normal, extremitas_abnormal, tulangpersendian_normal, tulangpersendian_abnormal, fotothorax_normal, fotothorax_abnormal, urine_normal, urine_abnormal, foses_normal, foses_abnormal, hbeag_positif, hbeag_negatif, antihbe_positif, antihbe_negatif, kesimpulan_keterangan, dugaan_diagnosis, terapi, saran, update_time', 'safe'),
                        array('anamnesis, palpitasi, dyapneu, hemoptysis, pusing, kelainan_pencernaan, rheumatic_fever, syphilis, diphtheria, keluhan_utama, nyeri, batuk, edoma, pingsan, tonsilitas, nephritis, influenza, lain_lain', 'safe'),//jantung
                        array('hasil_pap_smeer, pemeriksaan_mamma, key_lainlain, tht, path_berkas', 'safe'),//lainlain
			['ruangan_id, pegawai_id, riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, keluhansaatini, keadaanumum, pernafasan, kesadaran, bentukkepala, benjolan, benjolan, warnarambut, mata_anemis, mata_anemis, mata_ikterik, mata_ikterik, hidung_bentuk, hidung_deviasi, hidung_deviasi, hidung_sekret','safe'],
                        ['telinga_cae_normal, telinga_cae_abnormal, telinga_mt_perforasi, telinga_mt, telinga_sekret_ada, telinga_sekret, tenggorokan_faring_hiperemis, tenggorokan_faring_hiperemistdk, tenggorokan_faring_berganula, tenggorokan_faring_berganulatdk, tenggorokan_tonsil_t1, tenggorokan_tonsil_t2, tenggorokan_tonsil_t3, leher_bentuk_simetris, leher_bentuksimetris, leher_kellimfe_teraba, leher_kellimfeteraba','safe'],
                        ['thorax_pergerakan, thorax_stem, bunyiparu_sonor, bunyiparu_sonor, bunyiparu_vesikuler, bunyiparu_vesikuler, bunyiparu_ronchi, bunyiparu_ronchi, bunyiparu_wheezing, bunyiparu_wheezing, jantung_bunyi_satu, jantung_bunyi_dua, jantung_murmur, jantung_murmur, jantung_gallop, jantung_gallop, abdomen_supel, abdomen_supel, abdomen_hepar_teraba, abdomen_hepar','safe'],
                        ['ekstermitas_akral, ekstermitas_adeformitas_ada, ekstermitas_adeformitas, ekstermitas_aoedema_ada, ekstermitas_aoedema, lab_darah_ada, lab_darah, lab_urin_ada, lab_urin, radiologi, radiologi_kesmpulan, radiologi_hasil, lab_darah_hasil, ginjal_ureum, ginjal_creatinin, ginjal_asamurat, ginjal_anjuran, fungsihati_sgot, fungsihati_sgpt','safe'],
                        ['metabolisme_glukosapuasa, metabolisme_anjuran, lemak_kolestrol, lemak_hdl, lemak_ldl, lemak_trigliserida, lemak_anjuran, lemak_urinlengkap, lemak_hasilekg, lemak_hasilthorax, lemak_hasildidapat, lemak_saran','safe'],
                        ['radiologi_ada, leher_kellimfe, jantung_bunyi, suhu, jeniskeperluanmcu, ekstermitas_adeformitas, ekstermitas_akal, tenggorokan_faring, tenggorokan_tonsil, leher_bentuk, tenggorokan_tonsil_t2bintang, tenggorokan_tonsil_t3bintang, tenggorokan_tonsil_t1bintang,mcu_pemeriksaanumum_id, telinga_cae','safe'],
                        // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mata_virus_kanan,mata_virus_kiri,mata_persepsi_warna,mata,mcu_pemeriksaanumum_id, tgl_pemeriksaan, pendaftaran_id, pasien_id, diagnosis, tekanandarah, nadi, beratbadan, tinggibadan, nilai_bmi, bodymassindex_id, anemia_positif, anemia_negatif, ikterus_positif, ikterus_negatif, sesak_positif, sesak_negatif, gizi_baik, gizi_kurang, sembab_positif, sembab_negatif, sembab_keterangan, kepala_normal, kepala_abnormal, kepala_keterangan, leher_normal, leher_abnormal, leher_keterangan, jantung_normal, jantung_abnormal, jantung_keterangan, paru_normal, paru_abnormal, paru_keterangan, hepar_normal, hepar_abnormal, hepar_keterangan, limpa_takteraba, limpa_teraba, limpa_keterangan, abdomen_normal, abdomen_abnormal, abdomen_keterangan, extremitas_normal, extremitas_abnormal, extremitas_keterangan, tulangpersendian_normal, tulangpersendian_abnormal, tulangpersendian_keterangan, fotothorax_normal, fotothorax_abnormal, fotothorax_keterangan, bill_d, bill_t, alk, hdl, ldl, hb, lekosit, hitungjenis_eo, hitungjenis_ba, hitungjenis_st, hitungjenis_sgm, hitungjenis_ly, hitungjenis_h, led, golongandarah, urine_normal, urine_abnormal, urine_keterangan, foses_normal, foses_abnormal, foses_keterangan, bsn, dua_jpp, kolesterol_total, triglisarida, bun, kreatinin, asamurat, sgot, sgpt, hbeag_positif, hbeag_negatif, antihbe_positif, antihbe_negatif, kesimpulan_kesehatan, kesimpulan_keterangan, dugaan_diagnosis, terapi, saran, konsulpoli_id, dokterpemeriksa_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jeniskeperluanmcu', 'safe', 'on'=>'search'),
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
                    'dokterpemeriksa'=>array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa_id'),
                    'dpjp'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'mcukesimpulan'=>array(self::BELONGS_TO, 'KesimpulanmcuT', 'pendaftaran_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mcu_pemeriksaanumum_id' => 'Mcu Pemeriksaanumum',
			'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'keperluan'=> 'Jenis Keperluan',
			'diagnosis' => 'Diagnosis',
			'tekanandarah' => 'Tekanandarah',
			'nadi' => 'Nadi',
			'beratbadan' => 'Berat Badan',
			'tinggibadan' => 'Tinggi Badan',
			'nilai_bmi' => 'Nilai Bmi',
			'bodymassindex_id' => 'Bodymassindex',
			'anemia_positif' => 'Anemia Positif',
			'anemia_negatif' => 'Anemia Negatif',
			'ikterus_positif' => 'Ikterus Positif',
			'ikterus_negatif' => 'Ikterus Negatif',
			'sesak_positif' => 'Sesak Positif',
			'sesak_negatif' => 'Sesak Negatif',
			'gizi_baik' => 'Gizi Baik',
			'gizi_kurang' => 'Gizi Kurang',
			'sembab_positif' => 'Sembab Positif',
			'sembab_negatif' => 'Sembab Negatif',
			'sembab_keterangan' => 'Sembab Keterangan',
			'kepala_normal' => 'Kepala Normal',
			'kepala_abnormal' => 'Kepala Abnormal',
			'kepala_keterangan' => 'Kepala Keterangan',
			'leher_normal' => 'Leher Normal',
			'leher_abnormal' => 'Leher Abnormal',
			'leher_keterangan' => 'Leher Keterangan',
			'jantung_normal' => 'Jantung Normal',
			'jantung_abnormal' => 'Jantung Abnormal',
			'jantung_keterangan' => 'Jantung Keterangan',
			'paru_normal' => 'Paru Normal',
			'paru_abnormal' => 'Paru Abnormal',
			'paru_keterangan' => 'Paru Keterangan',
			'hepar_normal' => 'Hepar Normal',
			'hepar_abnormal' => 'Hepar Abnormal',
			'hepar_keterangan' => 'Hepar Keterangan',
			'limpa_takteraba' => 'Limpa Takteraba',
			'limpa_teraba' => 'Limpa Teraba',
			'limpa_keterangan' => 'Limpa Keterangan',
			'abdomen_normal' => 'Abdomen Normal',
			'abdomen_abnormal' => 'Abdomen Abnormal',
			'abdomen_keterangan' => 'Abdomen Keterangan',
			'extremitas_normal' => 'Extremitas Normal',
			'extremitas_abnormal' => 'Extremitas Abnormal',
			'extremitas_keterangan' => 'Extremitas Keterangan',
			'tulangpersendian_normal' => 'Tulangpersendian Normal',
			'tulangpersendian_abnormal' => 'Tulangpersendian Abnormal',
			'tulangpersendian_keterangan' => 'Tulangpersendian Keterangan',
			'fotothorax_normal' => 'Fotothorax Normal',
			'fotothorax_abnormal' => 'Fotothorax Abnormal',
			'fotothorax_keterangan' => 'Fotothorax Keterangan',
			'bill_d' => 'Bill D',
			'bill_t' => 'Bill T',
			'alk' => 'Alk',
			'hdl' => 'Hdl',
			'ldl' => 'Ldl',
			'hb' => 'Hb',
			'lekosit' => 'Lekosit',
			'hitungjenis_eo' => 'Hitungjenis Eo',
			'hitungjenis_ba' => 'Hitungjenis Ba',
			'hitungjenis_st' => 'Hitungjenis St',
			'hitungjenis_sgm' => 'Hitungjenis Sgm',
			'hitungjenis_ly' => 'Hitungjenis Ly',
			'hitungjenis_h' => 'Hitungjenis H',
			'led' => 'Led',
			'golongandarah' => 'Golongandarah',
			'urine_normal' => 'Urine Normal',
			'urine_abnormal' => 'Urine Abnormal',
			'urine_keterangan' => 'Urine Keterangan',
			'foses_normal' => 'Foses Normal',
			'foses_abnormal' => 'Foses Abnormal',
			'foses_keterangan' => 'Foses Keterangan',
			'bsn' => 'Bsn',
			'dua_jpp' => 'Dua Jpp',
			'kolesterol_total' => 'Kolesterol Total',
			'triglisarida' => 'Triglisarida',
			'bun' => 'Bun',
			'kreatinin' => 'Kreatinin',
			'asamurat' => 'Asamurat',
			'sgot' => 'Sgot',
			'sgpt' => 'Sgpt',
			'hbeag_positif' => 'Hbeag Positif',
			'hbeag_negatif' => 'Hbeag Negatif',
			'antihbe_positif' => 'Antihbe Positif',
			'antihbe_negatif' => 'Antihbe Negatif',
			'kesimpulan_kesehatan' => 'Kesimpulan Kesehatan',
			'kesimpulan_keterangan' => 'Kesimpulan Keterangan',
			'dugaan_diagnosis' => 'Dugaan Diagnosis',
			'terapi' => 'Terapi',
			'saran' => 'Saran',
			'konsulpoli_id' => 'Konsulpoli',
			'dokterpemeriksa_id' => 'Dokterpemeriksa',
                        'jeniskeperluanmcu' => 'Jenis Keperluan MCU',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'mata_virus_kanan' => 'Mata Virus Kanan',
			'mata_virus_kiri' => 'Mata Virus Kiri',
			'mata_persepsi_warna' => 'Mata Persepsi Warna',
			'mata' => 'Mata',
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

		$criteria=new CDbCriteria;

		if(!empty($this->mcu_pemeriksaanumum_id)){
			$criteria->addCondition('mcu_pemeriksaanumum_id = '.$this->mcu_pemeriksaanumum_id);
		}
		$criteria->compare('LOWER(tgl_pemeriksaan)',strtolower($this->tgl_pemeriksaan),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(diagnosis)',strtolower($this->diagnosis),true);
		$criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);
		if(!empty($this->nadi)){
			$criteria->addCondition('nadi = '.$this->nadi);
		}
		if(!empty($this->beratbadan)){
			$criteria->addCondition('beratbadan = '.$this->beratbadan);
		}
		if(!empty($this->tinggibadan)){
			$criteria->addCondition('tinggibadan = '.$this->tinggibadan);
		}
		$criteria->compare('nilai_bmi',$this->nilai_bmi);
		if(!empty($this->bodymassindex_id)){
			$criteria->addCondition('bodymassindex_id = '.$this->bodymassindex_id);
		}
		$criteria->compare('anemia_positif',$this->anemia_positif);
		$criteria->compare('anemia_negatif',$this->anemia_negatif);
		$criteria->compare('ikterus_positif',$this->ikterus_positif);
		$criteria->compare('ikterus_negatif',$this->ikterus_negatif);
		$criteria->compare('sesak_positif',$this->sesak_positif);
		$criteria->compare('sesak_negatif',$this->sesak_negatif);
		$criteria->compare('gizi_baik',$this->gizi_baik);
		$criteria->compare('gizi_kurang',$this->gizi_kurang);
		$criteria->compare('sembab_positif',$this->sembab_positif);
		$criteria->compare('sembab_negatif',$this->sembab_negatif);
		$criteria->compare('LOWER(sembab_keterangan)',strtolower($this->sembab_keterangan),true);
		$criteria->compare('kepala_normal',$this->kepala_normal);
		$criteria->compare('kepala_abnormal',$this->kepala_abnormal);
		$criteria->compare('LOWER(kepala_keterangan)',strtolower($this->kepala_keterangan),true);
		$criteria->compare('leher_normal',$this->leher_normal);
		$criteria->compare('leher_abnormal',$this->leher_abnormal);
		$criteria->compare('LOWER(leher_keterangan)',strtolower($this->leher_keterangan),true);
		$criteria->compare('jantung_normal',$this->jantung_normal);
		$criteria->compare('jantung_abnormal',$this->jantung_abnormal);
		$criteria->compare('LOWER(jantung_keterangan)',strtolower($this->jantung_keterangan),true);
		$criteria->compare('paru_normal',$this->paru_normal);
		$criteria->compare('paru_abnormal',$this->paru_abnormal);
		$criteria->compare('LOWER(paru_keterangan)',strtolower($this->paru_keterangan),true);
		$criteria->compare('hepar_normal',$this->hepar_normal);
		$criteria->compare('hepar_abnormal',$this->hepar_abnormal);
		$criteria->compare('LOWER(hepar_keterangan)',strtolower($this->hepar_keterangan),true);
		$criteria->compare('limpa_takteraba',$this->limpa_takteraba);
		$criteria->compare('limpa_teraba',$this->limpa_teraba);
		$criteria->compare('LOWER(limpa_keterangan)',strtolower($this->limpa_keterangan),true);
		$criteria->compare('abdomen_normal',$this->abdomen_normal);
		$criteria->compare('abdomen_abnormal',$this->abdomen_abnormal);
		$criteria->compare('LOWER(abdomen_keterangan)',strtolower($this->abdomen_keterangan),true);
		$criteria->compare('extremitas_normal',$this->extremitas_normal);
		$criteria->compare('extremitas_abnormal',$this->extremitas_abnormal);
		$criteria->compare('LOWER(extremitas_keterangan)',strtolower($this->extremitas_keterangan),true);
		$criteria->compare('tulangpersendian_normal',$this->tulangpersendian_normal);
		$criteria->compare('tulangpersendian_abnormal',$this->tulangpersendian_abnormal);
		$criteria->compare('LOWER(tulangpersendian_keterangan)',strtolower($this->tulangpersendian_keterangan),true);
		$criteria->compare('fotothorax_normal',$this->fotothorax_normal);
		$criteria->compare('fotothorax_abnormal',$this->fotothorax_abnormal);
		$criteria->compare('LOWER(fotothorax_keterangan)',strtolower($this->fotothorax_keterangan),true);
		$criteria->compare('bill_d',$this->bill_d);
		$criteria->compare('bill_t',$this->bill_t);
		$criteria->compare('alk',$this->alk);
		$criteria->compare('hdl',$this->hdl);
		$criteria->compare('ldl',$this->ldl);
		$criteria->compare('hb',$this->hb);
		if(!empty($this->lekosit)){
			$criteria->addCondition('lekosit = '.$this->lekosit);
		}
		$criteria->compare('hitungjenis_eo',$this->hitungjenis_eo);
		$criteria->compare('hitungjenis_ba',$this->hitungjenis_ba);
		$criteria->compare('hitungjenis_st',$this->hitungjenis_st);
		$criteria->compare('hitungjenis_sgm',$this->hitungjenis_sgm);
		$criteria->compare('hitungjenis_ly',$this->hitungjenis_ly);
		$criteria->compare('hitungjenis_h',$this->hitungjenis_h);
		$criteria->compare('LOWER(led)',strtolower($this->led),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('urine_normal',$this->urine_normal);
		$criteria->compare('urine_abnormal',$this->urine_abnormal);
		$criteria->compare('LOWER(urine_keterangan)',strtolower($this->urine_keterangan),true);
		$criteria->compare('foses_normal',$this->foses_normal);
		$criteria->compare('foses_abnormal',$this->foses_abnormal);
		$criteria->compare('LOWER(foses_keterangan)',strtolower($this->foses_keterangan),true);
		if(!empty($this->bsn)){
			$criteria->addCondition('bsn = '.$this->bsn);
		}
		if(!empty($this->dua_jpp)){
			$criteria->addCondition('dua_jpp = '.$this->dua_jpp);
		}
		if(!empty($this->kolesterol_total)){
			$criteria->addCondition('kolesterol_total = '.$this->kolesterol_total);
		}
		if(!empty($this->triglisarida)){
			$criteria->addCondition('triglisarida = '.$this->triglisarida);
		}
		if(!empty($this->bun)){
			$criteria->addCondition('bun = '.$this->bun);
		}
		if(!empty($this->kreatinin)){
			$criteria->addCondition('kreatinin = '.$this->kreatinin);
		}
		if(!empty($this->asamurat)){
			$criteria->addCondition('asamurat = '.$this->asamurat);
		}
		if(!empty($this->sgot)){
			$criteria->addCondition('sgot = '.$this->sgot);
		}
		if(!empty($this->sgpt)){
			$criteria->addCondition('sgpt = '.$this->sgpt);
		}
		$criteria->compare('hbeag_positif',$this->hbeag_positif);
		$criteria->compare('hbeag_negatif',$this->hbeag_negatif);
		$criteria->compare('antihbe_positif',$this->antihbe_positif);
		$criteria->compare('antihbe_negatif',$this->antihbe_negatif);
		$criteria->compare('LOWER(kesimpulan_kesehatan)',strtolower($this->kesimpulan_kesehatan),true);
		$criteria->compare('LOWER(kesimpulan_keterangan)',strtolower($this->kesimpulan_keterangan),true);
		$criteria->compare('LOWER(dugaan_diagnosis)',strtolower($this->dugaan_diagnosis),true);
		$criteria->compare('LOWER(terapi)',strtolower($this->terapi),true);
		$criteria->compare('LOWER(saran)',strtolower($this->saran),true);
		if(!empty($this->konsulpoli_id)){
			$criteria->addCondition('konsulpoli_id = '.$this->konsulpoli_id);
		}
		if(!empty($this->dokterpemeriksa_id)){
			$criteria->addCondition('dokterpemeriksa_id = '.$this->dokterpemeriksa_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

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

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}