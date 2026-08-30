<?php

/**
 * This is the model class for table "kardeks_t".
 *
 * The followings are the available columns in table 'kardeks_t':
 * @property integer $kardeks_id
 * @property integer $pendaftaran_id
 * @property string $tgl_pemeriksaan
 * @property boolean $kardeks_dewasa
 * @property double $hemo_dewasa_sistol
 * @property double $hemo_dewasa_diastol
 * @property string $hemo_dewasa_map
 * @property double $hemo_dewasa_nadi
 * @property double $hemo_dewasa_rr
 * @property double $hemo_dewasa_suhu
 * @property double $hemo_dewasa_spo2
 * @property double $hemo_dewasa_cvp
 * @property double $hemo_anak_suhuinkubator
 * @property string $hemo_anak_retraksi
 * @property string $hemo_anak_sianosis
 * @property string $hemo_anak_grunting
 * @property string $hemo_anak_warnakulit
 * @property string $hemo_anak_tonusotot
 * @property string $hemo_anak_hisaplendir
 * @property string $hemo_anak_udema
 * @property string $hemo_anak_perut
 * @property string $ssp_kesadaran
 * @property string $ssp_gcs_eye
 * @property string $ssp_gcs_verbal
 * @property string $ssp_gcs_motorik
 * @property string $ssp_pupilka_ukuran
 * @property string $ssp_pupilka_reaksi
 * @property string $ssp_pupilki_ukuran
 * @property string $ssp_pupilki_reaksi
 * @property string $ssp_kejang
 * @property string $medika_bolus
 * @property string $medika_oral
 * @property string $medika_infus
 * @property string $medika_lainlain
 * @property string $vent_pola
 * @property string $vent_tidal
 * @property string $vent_pspapasb
 * @property string $vent_peep
 * @property string $vent_rr
 * @property string $vent_fio2
 * @property string $vent_time_infirasi
 * @property string $vent_time_eksfirasi
 * @property boolean $vent_sputum
 * @property string $vent_ph
 * @property string $vent_pco2
 * @property string $vent_be
 * @property string $vent_hco3
 * @property string $vent_o2saturasi
 * @property string $output_urine
 * @property string $output_muntah
 * @property string $output_bab
 * @property string $output_pendarahan
 * @property string $output_drain
 * @property double $balance_konstanta
 * @property double $balance_beratbadan
 * @property integer $balance_usia
 * @property double $balance_jmlcairan
 * @property double $balance_iwl
 * @property double $balance_konstanta_suhu
 * @property double $balance_kenaikan_suhu
 * @property double $balance_iwl_kenaikan_suhu
 * @property double $balance_total_intake
 * @property double $balance_total_output
 * @property double $balance_total_sekarang
 * @property double $balance_total_sebelum
 * @property double $balance_total_komulatif
 * @property double $balance_diuresis
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 */
class KardeksT extends CActiveRecord
{
	public $iramaekg;
	public $nutrisi_parental;
	public $hemo_anak_aktifitas, $nutrisi_enternal, $down_ketscore, $apgar_ketscore;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KardeksT the static model class
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
		return 'kardeks_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, balance_usia, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pemeriksaan_ke', 'numerical', 'integerOnly'=>true),
			array('iramaekg, downscore_pernapasan, downscore_retraksi, downscore_sianosis, downscore_airentry, downscore_merintih, downscore_kettotalskor, apgarscore_appearence, apgarscore_pulse, apgarscore_grimace, apgarscore_activity, apgarscore_respiration, apgarscore_kettotalskor', 'length', 'max'=>200),
			array('downscore_skor_pernapasan, downscore_skor_retraksi, downscore_skor_sianosis, downscore_skor_airentry, downscore_skor_merintih, downscore_totalskor, apgarscore_skor_appearence, apgarscore_skor_pulse, apgarscore_skor_grimace, apgarscore_skor_activity, apgarscore_skor_respiration, apgarscore_totalskor, hemo_dewasa_sistol, hemo_dewasa_diastol, hemo_dewasa_nadi, hemo_dewasa_rr, hemo_dewasa_suhu, hemo_dewasa_spo2, hemo_dewasa_cvp, hemo_anak_suhuinkubator, balance_konstanta, balance_beratbadan, balance_jmlcairan, balance_iwl, balance_konstanta_suhu, balance_kenaikan_suhu, balance_iwl_kenaikan_suhu, balance_total_intake, balance_total_output, balance_total_sekarang, balance_total_sebelum, balance_total_komulatif, balance_diuresis', 'numerical'),
			array('pemeriksaan_ke, vent_po2, vent_tco2, tgl_pemeriksaan, kardeks_dewasa, hemo_dewasa_map, hemo_anak_retraksi, hemo_anak_sianosis, hemo_anak_grunting, hemo_anak_warnakulit, hemo_anak_tonusotot, hemo_anak_hisaplendir, hemo_anak_udema, hemo_anak_perut, ssp_kesadaran, ssp_gcs_eye, ssp_gcs_verbal, ssp_gcs_motorik, ssp_pupilka_ukuran, ssp_pupilka_reaksi, ssp_pupilki_ukuran, ssp_pupilki_reaksi, ssp_kejang, medika_bolus, medika_oral, medika_infus, medika_lainlain, vent_pola, vent_tidal, vent_pspapasb, vent_peep, vent_rr, vent_fio2, vent_time_infirasi, vent_time_eksfirasi, vent_sputum, vent_ph, vent_pco2, vent_be, vent_hco3, vent_o2saturasi, output_urine, output_muntah, output_bab, output_pendarahan, output_drain, update_time, nutrisi_enternal, nutrisi_parental', 'safe'),
			array('hemo_dewasa_map2, balance_iwl_jam, balance_jam, balance_cairanmasuk, iramaekg', 'safe'),
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kardeks_id, pendaftaran_id, tgl_pemeriksaan, kardeks_dewasa, hemo_dewasa_sistol, hemo_dewasa_diastol, hemo_dewasa_map, hemo_dewasa_nadi, hemo_dewasa_rr, hemo_dewasa_suhu, hemo_dewasa_spo2, hemo_dewasa_cvp, hemo_anak_suhuinkubator, hemo_anak_retraksi, hemo_anak_sianosis, hemo_anak_grunting, hemo_anak_warnakulit, hemo_anak_tonusotot, hemo_anak_hisaplendir, hemo_anak_udema, hemo_anak_perut, ssp_kesadaran, ssp_gcs_eye, ssp_gcs_verbal, ssp_gcs_motorik, ssp_pupilka_ukuran, ssp_pupilka_reaksi, ssp_pupilki_ukuran, ssp_pupilki_reaksi, ssp_kejang, medika_bolus, medika_oral, medika_infus, medika_lainlain, vent_pola, vent_tidal, vent_pspapasb, vent_peep, vent_rr, vent_fio2, vent_time_infirasi, vent_time_eksfirasi, vent_sputum, vent_ph, vent_pco2, vent_be, vent_hco3, vent_o2saturasi, output_urine, output_muntah, output_bab, output_pendarahan, output_drain, balance_konstanta, balance_beratbadan, balance_usia, balance_jmlcairan, balance_iwl, balance_konstanta_suhu, balance_kenaikan_suhu, balance_iwl_kenaikan_suhu, balance_total_intake, balance_total_output, balance_total_sekarang, balance_total_sebelum, balance_total_komulatif, balance_diuresis, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, iramaekg, nutrisi_enternal, nutrisi_parental, hemo_anak_aktifitas', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kardeks_id' => 'Kardeks',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
			'kardeks_dewasa' => 'Kardeks Dewasa',
			'hemo_dewasa_sistol' => 'Sistole',
			'hemo_dewasa_diastol' => 'Diastole',
			'hemo_dewasa_map' => 'Hemo Dewasa Map',
			'hemo_dewasa_nadi' => 'Nadi',
			'hemo_dewasa_rr' => 'RR',
			'hemo_dewasa_suhu' => 'Suhu',
			'hemo_dewasa_spo2' => 'SpO2',
			'hemo_dewasa_cvp' => 'CVP',
			'hemo_anak_suhuinkubator' => 'Suhu Inkubator',
			'hemo_anak_retraksi' => 'Retraksi',
			'hemo_anak_sianosis' => 'Sianosis',
			'hemo_anak_grunting' => 'Grunting',
			'hemo_anak_warnakulit' => 'Warna Kulit',
			'hemo_anak_tonusotot' => 'Tonus Otot',
			'hemo_anak_hisaplendir' => 'Hisap Lendir',
			'hemo_anak_udema' => 'Udema',
			'hemo_anak_perut' => 'Perut',
			'ssp_kesadaran' => 'Kesadaran',
			'ssp_gcs_eye' => 'GCS Eye',
			'ssp_gcs_verbal' => 'GCS Verbal',
			'ssp_gcs_motorik' => 'GCS Motorik',
			'ssp_pupilka_ukuran' => 'Pupil Ka Ukuran',
			'ssp_pupilka_reaksi' => 'Pupil Ka Reaksi',
			'ssp_pupilki_ukuran' => 'Pupil Ki Ukuran',
			'ssp_pupilki_reaksi' => 'Pupil Ki Reaksi',
			'ssp_kejang' => 'Kejang',
			'medika_bolus' => 'Bolus',
			'medika_oral' => 'Oral',
			'medika_infus' => 'Infus',
			'medika_lainlain' => 'Lain-lain',
			'vent_pola' => 'Pola / Mode',
			'vent_tidal' => 'Tidal/ Volume',
			'vent_pspapasb' => 'Ps/Pa/Pasb',
			'vent_peep' => 'PEEP',
			'vent_rr' => 'RR',
			'vent_fio2' => 'FiO2',
			'vent_time_infirasi' => 'Time Inpirasi',
			'vent_time_eksfirasi' => 'Time Ekspirasi',
			'vent_sputum' => 'Sputum',
			'vent_ph' => 'pH',
			'vent_pco2' => 'pCO2',
			'vent_po2' => 'pO2',
			'vent_tco2' => 'TCO2',
			'vent_be' => 'BE',
			'vent_hco3' => 'HCO3',
			'vent_o2saturasi' => 'O2 Saturasi',
			'output_urine' => 'Urine',
			'output_muntah' => 'Muntah',
			'output_bab' => 'BAB',
			'output_pendarahan' => 'Pendarahan',
			'output_drain' => 'Drain',
			'balance_konstanta' => 'Konstanta',
			'balance_beratbadan' => 'Berat Badan',
			'balance_usia' => 'Usia',
			'balance_jmlcairan' => 'Jml. Cairan',
			'balance_iwl' => 'Hasil IWL',
			'balance_konstanta_suhu' => 'Konstanta Suhu',
			'balance_kenaikan_suhu' => 'Kenaikan Suhu',
			'balance_iwl_kenaikan_suhu' => 'Hasil IWL',
			'balance_total_intake' => 'Total Input',
			'balance_total_output' => 'Total Output',
			'balance_total_sekarang' => 'Balance Sekarang',
			'balance_total_sebelum' => 'Balance Sebelum',
			'balance_total_komulatif' => 'Balance Komulatif',
			'balance_diuresis' => 'Diuresis',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'balance_iwl_jam' => 'IWL / Jam',
			'balance_cairanmasuk' => 'Cairan Masuk',
			'hemo_anak_aktifitas' => 'Aktifitas',
			'nutrisi_enternal'	=> 'Nutrisi Enternal',
			'nutrisi_parental' => 'Nutrisi Parental'
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

		$criteria->compare('kardeks_id',$this->kardeks_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('kardeks_dewasa',$this->kardeks_dewasa);
		$criteria->compare('hemo_dewasa_sistol',$this->hemo_dewasa_sistol);
		$criteria->compare('hemo_dewasa_diastol',$this->hemo_dewasa_diastol);
		$criteria->compare('hemo_dewasa_map',$this->hemo_dewasa_map,true);
		$criteria->compare('hemo_dewasa_nadi',$this->hemo_dewasa_nadi);
		$criteria->compare('hemo_dewasa_rr',$this->hemo_dewasa_rr);
		$criteria->compare('hemo_dewasa_suhu',$this->hemo_dewasa_suhu);
		$criteria->compare('hemo_dewasa_spo2',$this->hemo_dewasa_spo2);
		$criteria->compare('hemo_dewasa_cvp',$this->hemo_dewasa_cvp);
		$criteria->compare('hemo_anak_suhuinkubator',$this->hemo_anak_suhuinkubator);
		$criteria->compare('hemo_anak_retraksi',$this->hemo_anak_retraksi,true);
		$criteria->compare('hemo_anak_sianosis',$this->hemo_anak_sianosis,true);
		$criteria->compare('hemo_anak_grunting',$this->hemo_anak_grunting,true);
		$criteria->compare('hemo_anak_warnakulit',$this->hemo_anak_warnakulit,true);
		$criteria->compare('hemo_anak_tonusotot',$this->hemo_anak_tonusotot,true);
		$criteria->compare('hemo_anak_hisaplendir',$this->hemo_anak_hisaplendir,true);
		$criteria->compare('hemo_anak_udema',$this->hemo_anak_udema,true);
		$criteria->compare('hemo_anak_perut',$this->hemo_anak_perut,true);
		$criteria->compare('hemo_anak_aktifitas',$this->hemo_anak_aktifitas,true);
		$criteria->compare('ssp_kesadaran',$this->ssp_kesadaran,true);
		$criteria->compare('ssp_gcs_eye',$this->ssp_gcs_eye,true);
		$criteria->compare('ssp_gcs_verbal',$this->ssp_gcs_verbal,true);
		$criteria->compare('ssp_gcs_motorik',$this->ssp_gcs_motorik,true);
		$criteria->compare('ssp_pupilka_ukuran',$this->ssp_pupilka_ukuran,true);
		$criteria->compare('ssp_pupilka_reaksi',$this->ssp_pupilka_reaksi,true);
		$criteria->compare('ssp_pupilki_ukuran',$this->ssp_pupilki_ukuran,true);
		$criteria->compare('ssp_pupilki_reaksi',$this->ssp_pupilki_reaksi,true);
		$criteria->compare('ssp_kejang',$this->ssp_kejang,true);
		$criteria->compare('medika_bolus',$this->medika_bolus,true);
		$criteria->compare('medika_oral',$this->medika_oral,true);
		$criteria->compare('medika_infus',$this->medika_infus,true);
		$criteria->compare('medika_lainlain',$this->medika_lainlain,true);
		$criteria->compare('vent_pola',$this->vent_pola,true);
		$criteria->compare('vent_tidal',$this->vent_tidal,true);
		$criteria->compare('vent_pspapasb',$this->vent_pspapasb,true);
		$criteria->compare('vent_peep',$this->vent_peep,true);
		$criteria->compare('vent_rr',$this->vent_rr,true);
		$criteria->compare('vent_fio2',$this->vent_fio2,true);
		$criteria->compare('vent_time_infirasi',$this->vent_time_infirasi,true);
		$criteria->compare('vent_time_eksfirasi',$this->vent_time_eksfirasi,true);
		$criteria->compare('vent_sputum',$this->vent_sputum);
		$criteria->compare('vent_ph',$this->vent_ph,true);
		$criteria->compare('vent_pco2',$this->vent_pco2,true);
		$criteria->compare('vent_be',$this->vent_be,true);
		$criteria->compare('vent_hco3',$this->vent_hco3,true);
		$criteria->compare('vent_o2saturasi',$this->vent_o2saturasi,true);
		$criteria->compare('output_urine',$this->output_urine,true);
		$criteria->compare('output_muntah',$this->output_muntah,true);
		$criteria->compare('output_bab',$this->output_bab,true);
		$criteria->compare('output_pendarahan',$this->output_pendarahan,true);
		$criteria->compare('output_drain',$this->output_drain,true);
		$criteria->compare('balance_konstanta',$this->balance_konstanta);
		$criteria->compare('balance_beratbadan',$this->balance_beratbadan);
		$criteria->compare('balance_usia',$this->balance_usia);
		$criteria->compare('balance_jmlcairan',$this->balance_jmlcairan);
		$criteria->compare('balance_iwl',$this->balance_iwl);
		$criteria->compare('balance_konstanta_suhu',$this->balance_konstanta_suhu);
		$criteria->compare('balance_kenaikan_suhu',$this->balance_kenaikan_suhu);
		$criteria->compare('balance_iwl_kenaikan_suhu',$this->balance_iwl_kenaikan_suhu);
		$criteria->compare('balance_total_intake',$this->balance_total_intake);
		$criteria->compare('balance_total_output',$this->balance_total_output);
		$criteria->compare('balance_total_sekarang',$this->balance_total_sekarang);
		$criteria->compare('balance_total_sebelum',$this->balance_total_sebelum);
		$criteria->compare('balance_total_komulatif',$this->balance_total_komulatif);
		$criteria->compare('balance_diuresis',$this->balance_diuresis);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchRiwayat() {
        $prov = $this->search();
        $prov->criteria->order = 'kardeks_id asc';
        
        return $prov;
    }
    
    public function setPemeriksaanKe() {
        if (empty($this->pendaftaran_id)) {
            $this->pemeriksaan_ke = 0;
            return;
        }
        $cr = new CDbCriteria;
        $cr->select = 'count(pendaftaran_id) as pendaftaran_id';
        $cr->compare('pendaftaran_id', $this->pendaftaran_id);
        
        $p = self::model()->find($cr);
        $this->pemeriksaan_ke = $p->pendaftaran_id + 1;
    }
}