<?php

/**
 * This is the model class for table "mcu_pemeriksaanjantung_t".
 * @author rusdiyanto <rusdiyanto@.com>
 * @subpackage models
 * The followings are the available columns in table 'mcu_pemeriksaanjantung_t':
 * @property integer $checkup_jantung_id
 * @property string $tgl_pemeriksaan
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $anamnesis
 * @property string $keluhan_utama
 * @property string $palpitasi
 * @property string $nyeri
 * @property string $dyapneu
 * @property string $batuk
 * @property string $hemoptysis
 * @property string $edoma
 * @property string $pusing
 * @property string $pingsan
 * @property string $kelainan_pencernaan
 * @property string $rheumatic_fever
 * @property string $syphilis
 * @property string $diphtheria
 * @property string $tonsilitas
 * @property string $nephritis
 * @property string $influenza
 * @property string $lain_lain
 * @property integer $nadi
 * @property integer $uvp
 * @property string $kesan_umum
 * @property string $thorax_jantung_inspeksi
 * @property string $thorax_palpasi_apex
 * @property string $thorax_pulsasi
 * @property string $thorax_lift
 * @property string $thorax_thrill
 * @property string $thorax_purkusi
 * @property string $thorax_auskultasi
 * @property string $thorax_paru
 * @property string $leher_kelenjar_gondok
 * @property string $leher_pulsasi
 * @property string $leher_vera_melebar
 * @property string $leher_carotid_shudder
 * @property string $abdomen_hati
 * @property string $abdomen_limpa
 * @property string $extremitas
 * @property string $pemeriksaan_sinarx
 * @property string $elektrokardiogram
 * @property string $treadmill
 * @property string $hasil_laboratorium
 * @property string $diagnosis_sementara
 * @property string $definitif
 * @property string $terapi
 * @property integer $dokterpemeriksa_id
 * @property string $tekanandarah
 */
class McuPemeriksaanjantungT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return McuPemeriksaanjantungT the static model class
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
		return 'mcu_pemeriksaanjantung_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id', 'required'),
			array('pendaftaran_id, pasien_id, nadi, uvp, dokterpemeriksa_id', 'numerical', 'integerOnly'=>true),
			array('palpitasi, nyeri, dyapneu, batuk, hemoptysis, edoma, pusing, pingsan, kelainan_pencernaan, rheumatic_fever, syphilis, diphtheria, tonsilitas, nephritis, influenza, lain_lain, thorax_jantung_inspeksi', 'length', 'max'=>100),
			array('thorax_palpasi_apex, leher_kelenjar_gondok, leher_vera_melebar', 'length', 'max'=>30),
			array('thorax_pulsasi, thorax_lift, thorax_thrill, leher_pulsasi, leher_carotid_shudder', 'length', 'max'=>10),
			array('abdomen_hati, abdomen_limpa, extremitas', 'length', 'max'=>50),
			array('tekanandarah', 'length', 'max'=>15),
			array('leher_ascites,abdomen_ascites,tgl_pemeriksaan, anamnesis, keluhan_utama, kesan_umum, thorax_purkusi, thorax_auskultasi, thorax_paru, pemeriksaan_sinarx, elektrokardiogram, treadmill, hasil_laboratorium, diagnosis_sementara, definitif, terapi', 'safe'),
                        ['ruangan_id, dpjp_id, diabetes, lvh, riwayatkeluarga, riwayatobat, riwayatalergi, riwayatolahraga, riwayatdietgaram, keluhanjantung, tensi, tinggibadan, suhu, beratbadan, pernafasan, bentukdada, batasjantung, rothorax, laboratorium, ekg, echo, kesimpulan, rekomendasi','safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('checkup_jantung_id, tgl_pemeriksaan, pendaftaran_id, pasien_id, anamnesis, keluhan_utama, palpitasi, nyeri, dyapneu, batuk, hemoptysis, edoma, pusing, pingsan, kelainan_pencernaan, rheumatic_fever, syphilis, diphtheria, tonsilitas, nephritis, influenza, lain_lain, nadi, uvp, kesan_umum, thorax_jantung_inspeksi, thorax_palpasi_apex, thorax_pulsasi, thorax_lift, thorax_thrill, thorax_purkusi, thorax_auskultasi, thorax_paru, leher_kelenjar_gondok, leher_pulsasi, leher_vera_melebar, leher_carotid_shudder, abdomen_hati, abdomen_limpa, extremitas, pemeriksaan_sinarx, elektrokardiogram, treadmill, hasil_laboratorium, diagnosis_sementara, definitif, terapi, dokterpemeriksa_id, tekanandarah', 'safe', 'on'=>'search'),
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
                    'dpjp'=>array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'checkup_jantung_id' => 'Checkup Jantung',
			'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'anamnesis' => 'Anamnesis',
			'keluhan_utama' => 'Keluhan Utama',
			'palpitasi' => 'Palpitasi',
			'nyeri' => 'Nyeri',
			'dyapneu' => 'Dyapneu',
			'batuk' => 'Batuk',
			'hemoptysis' => 'Hemoptysis',
			'edoma' => 'Edoma',
			'pusing' => 'Pusing',
			'pingsan' => 'Pingsan',
			'kelainan_pencernaan' => 'Kelainan Pencernaan',
			'rheumatic_fever' => 'Rheumatic Fever',
			'syphilis' => 'Syphilis',
			'diphtheria' => 'Diphtheria',
			'tonsilitas' => 'Tonsilitas',
			'nephritis' => 'Nephritis',
			'influenza' => 'Influenza',
			'lain_lain' => 'Lain Lain',
			'nadi' => 'Nadi',
			'uvp' => 'Uvp',
			'kesan_umum' => 'Kesan Umum',
			'thorax_jantung_inspeksi' => 'Thorax Jantung Inspeksi',
			'thorax_palpasi_apex' => 'Thorax Palpasi Apex',
			'thorax_pulsasi' => 'Thorax Pulsasi',
			'thorax_lift' => 'Thorax Lift',
			'thorax_thrill' => 'Thorax Thrill',
			'thorax_purkusi' => 'Thorax Purkusi',
			'thorax_auskultasi' => 'Thorax Auskultasi',
			'thorax_paru' => 'Thorax Paru',
			'leher_kelenjar_gondok' => 'Leher Kelenjar Gondok',
			'leher_pulsasi' => 'Leher Pulsasi',
			'leher_vera_melebar' => 'Leher Vera Melebar',
			'leher_carotid_shudder' => 'Leher Carotid Shudder',
			'abdomen_hati' => 'Abdomen Hati',
			'abdomen_limpa' => 'Abdomen Limpa',
			'extremitas' => 'Extremitas',
			'pemeriksaan_sinarx' => 'Pemeriksaan Sinarx',
			'elektrokardiogram' => 'Elektrokardiogram',
			'treadmill' => 'Treadmill',
			'hasil_laboratorium' => 'Hasil Laboratorium',
			'diagnosis_sementara' => 'Diagnosis Sementara',
			'definitif' => 'Definitif',
			'terapi' => 'Terapi',
			'dokterpemeriksa_id' => 'Dokterpemeriksa',
			'tekanandarah' => 'Tekanandarah',
                        'perokokatkif' => 'Perokok Aktif',
                        'diabetes' => 'Diabetes',
                        'lvh' => 'LVH',
                        'riwayatkeluarga' => 'Riwayat Keluarga',
                        'riwayatobat' => 'Riwayat Obat-obatan',
                        'riwayatalergi' => 'Riwayat Alergi',
                        'riwayatolahraga' => 'Riwayat Olahraga',
                        'riwayatdietgaram' => 'Riwayat Diet Garam',
                        'keluhanjantung' => 'Keluhan Jantung',
                        'tensi' => 'Tensi',
                        'tinggibadan' => 'Tinggi Badan',
                        'pernafasan' => 'Pernafasan',
                        'bentukdada' => 'Bentuk dada',
                        'batasjantung' => 'Batas - batas jantung',
                        'bunyijantung' => 'Bunyi Jantung',
                        'rothorax' => 'RO Thorax',
                        'laboratorium' => 'Laboratorium',
                        'ekg' => 'EKG',
                        'echo' => 'Echocardiography'
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

		if(!empty($this->checkup_jantung_id)){
			$criteria->addCondition('checkup_jantung_id = '.$this->checkup_jantung_id);
		}
		$criteria->compare('LOWER(tgl_pemeriksaan)',strtolower($this->tgl_pemeriksaan),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(anamnesis)',strtolower($this->anamnesis),true);
		$criteria->compare('LOWER(keluhan_utama)',strtolower($this->keluhan_utama),true);
		$criteria->compare('LOWER(palpitasi)',strtolower($this->palpitasi),true);
		$criteria->compare('LOWER(nyeri)',strtolower($this->nyeri),true);
		$criteria->compare('LOWER(dyapneu)',strtolower($this->dyapneu),true);
		$criteria->compare('LOWER(batuk)',strtolower($this->batuk),true);
		$criteria->compare('LOWER(hemoptysis)',strtolower($this->hemoptysis),true);
		$criteria->compare('LOWER(edoma)',strtolower($this->edoma),true);
		$criteria->compare('LOWER(pusing)',strtolower($this->pusing),true);
		$criteria->compare('LOWER(pingsan)',strtolower($this->pingsan),true);
		$criteria->compare('LOWER(kelainan_pencernaan)',strtolower($this->kelainan_pencernaan),true);
		$criteria->compare('LOWER(rheumatic_fever)',strtolower($this->rheumatic_fever),true);
		$criteria->compare('LOWER(syphilis)',strtolower($this->syphilis),true);
		$criteria->compare('LOWER(diphtheria)',strtolower($this->diphtheria),true);
		$criteria->compare('LOWER(tonsilitas)',strtolower($this->tonsilitas),true);
		$criteria->compare('LOWER(nephritis)',strtolower($this->nephritis),true);
		$criteria->compare('LOWER(influenza)',strtolower($this->influenza),true);
		$criteria->compare('LOWER(lain_lain)',strtolower($this->lain_lain),true);
		if(!empty($this->nadi)){
			$criteria->addCondition('nadi = '.$this->nadi);
		}
		if(!empty($this->uvp)){
			$criteria->addCondition('uvp = '.$this->uvp);
		}
		$criteria->compare('LOWER(kesan_umum)',strtolower($this->kesan_umum),true);
		$criteria->compare('LOWER(thorax_jantung_inspeksi)',strtolower($this->thorax_jantung_inspeksi),true);
		$criteria->compare('LOWER(thorax_palpasi_apex)',strtolower($this->thorax_palpasi_apex),true);
		$criteria->compare('LOWER(thorax_pulsasi)',strtolower($this->thorax_pulsasi),true);
		$criteria->compare('LOWER(thorax_lift)',strtolower($this->thorax_lift),true);
		$criteria->compare('LOWER(thorax_thrill)',strtolower($this->thorax_thrill),true);
		$criteria->compare('LOWER(thorax_purkusi)',strtolower($this->thorax_purkusi),true);
		$criteria->compare('LOWER(thorax_auskultasi)',strtolower($this->thorax_auskultasi),true);
		$criteria->compare('LOWER(thorax_paru)',strtolower($this->thorax_paru),true);
		$criteria->compare('LOWER(leher_kelenjar_gondok)',strtolower($this->leher_kelenjar_gondok),true);
		$criteria->compare('LOWER(leher_pulsasi)',strtolower($this->leher_pulsasi),true);
		$criteria->compare('LOWER(leher_vera_melebar)',strtolower($this->leher_vera_melebar),true);
		$criteria->compare('LOWER(leher_carotid_shudder)',strtolower($this->leher_carotid_shudder),true);
		$criteria->compare('LOWER(abdomen_hati)',strtolower($this->abdomen_hati),true);
		$criteria->compare('LOWER(abdomen_limpa)',strtolower($this->abdomen_limpa),true);
		$criteria->compare('LOWER(extremitas)',strtolower($this->extremitas),true);
		$criteria->compare('LOWER(pemeriksaan_sinarx)',strtolower($this->pemeriksaan_sinarx),true);
		$criteria->compare('LOWER(elektrokardiogram)',strtolower($this->elektrokardiogram),true);
		$criteria->compare('LOWER(treadmill)',strtolower($this->treadmill),true);
		$criteria->compare('LOWER(hasil_laboratorium)',strtolower($this->hasil_laboratorium),true);
		$criteria->compare('LOWER(diagnosis_sementara)',strtolower($this->diagnosis_sementara),true);
		$criteria->compare('LOWER(definitif)',strtolower($this->definitif),true);
		$criteria->compare('LOWER(terapi)',strtolower($this->terapi),true);
		if(!empty($this->dokterpemeriksa_id)){
			$criteria->addCondition('dokterpemeriksa_id = '.$this->dokterpemeriksa_id);
		}
		$criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);

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