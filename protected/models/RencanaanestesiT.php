<?php
/**
 * Model untuk "rencanaanestesi_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * The followings are the available columns in table 'rencanaanestesi_t':
 * @property integer $rencanaanestesi_id
 * @property string $tglrencanaanestesi
 * @property integer $pegawaipenyusun_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property boolean $premedikasi
 * @property boolean $premedikasi_midazolam
 * @property boolean $premedikasi_morphine
 * @property boolean $premedikasi_pethidine
 * @property boolean $premedikasi_ssulfasatropin
 * @property boolean $sedasi
 * @property boolean $monitor
 * @property boolean $observasi
 * @property string $induksi_insfluasi
 * @property boolean $induksi_sedatif
 * @property boolean $induksi_sedatif_midazolam
 * @property boolean $induksi_sedatif_propofol
 * @property boolean $induksi_sedatif_ketamine
 * @property boolean $induksi_analgetik
 * @property boolean $induksi_analgetik_morphine
 * @property boolean $induksi_analgetik_pethidine
 * @property boolean $induksi_analgetik_fentanyl
 * @property boolean $induksi_analgetik_ketamine
 * @property boolean $induksi_pelumpuhotak
 * @property boolean $induksi_pelumpuhotak_atracurium
 * @property boolean $induksi_pelumpuhotak_vecuronium
 * @property boolean $induksi_pelumpuhotak_rocuronium
 * @property boolean $inhalasi
 * @property boolean $inhalasi_o2
 * @property boolean $inhalasi_halothan
 * @property boolean $inhalasi_isofluran
 * @property boolean $inhalasi_sevofluran
 * @property boolean $inhalasi_enfluran
 * @property boolean $inhalasi_desflurane
 * @property boolean $intravena
 * @property boolean $intravena_propofol
 * @property boolean $intravena_morphien
 * @property boolean $intravena_pethidine
 * @property boolean $intravena_fentanyl
 * @property boolean $intravena_atracurium
 * @property boolean $intravena_vecuronium
 * @property boolean $intravena_recoronium
 * @property string $intravena_lainnya
 * @property string $intravena_lainnya_dosis
 * @property boolean $regional_anestesi
 * @property boolean $sab
 * @property boolean $epidural
 * @property boolean $pnb
 * @property boolean $anestesi_lokal_lidocaine
 * @property boolean $anestesi_lokal_bupivacaine
 * @property boolean $anestesi_lokal_rapivacaine
 * @property string $additif_keterangan1
 * @property string $additif_dosis1
 * @property string $additif_keterangan2
 * @property string $additif_dosis2
 * @property string $catatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $general_anestesi
 * @property boolean $general_masker
 * @property boolean $general_tiva
 * @property boolean $general_intubasi
 * @property boolean $general_lma
 * @property boolean $additif
 * @property boolean $induksi_insfluasidengan
 * @property boolean $anestesi_lokal
 */
class RencanaanestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanaanestesiT the static model class
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
		return 'rencanaanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglrencanaanestesi, pegawaipenyusun_id, pendaftaran_id, pasien_id, create_time, create_loginpemakai_id', 'required'),
			array('pegawaipenyusun_id, pendaftaran_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('induksi_insfluasi, intravena_lainnya, intravena_lainnya_dosis, additif_keterangan1, additif_dosis1, additif_keterangan2, additif_dosis2', 'length', 'max'=>100),
			array('intravena_lainnya_cek, premedikasi, premedikasi_midazolam, premedikasi_morphine, premedikasi_pethidine, premedikasi_ssulfasatropin, sedasi, monitor, observasi, induksi_sedatif, induksi_sedatif_midazolam, induksi_sedatif_propofol, induksi_sedatif_ketamine, induksi_analgetik, induksi_analgetik_morphine, induksi_analgetik_pethidine, induksi_analgetik_fentanyl, induksi_analgetik_ketamine, induksi_pelumpuhotak, induksi_pelumpuhotak_atracurium, induksi_pelumpuhotak_vecuronium, induksi_pelumpuhotak_rocuronium, inhalasi, inhalasi_o2, inhalasi_halothan, inhalasi_isofluran, inhalasi_sevofluran, inhalasi_enfluran, inhalasi_desflurane, intravena, intravena_propofol, intravena_morphien, intravena_pethidine, intravena_fentanyl, intravena_atracurium, intravena_vecuronium, intravena_recoronium, regional_anestesi, sab, epidural, pnb, anestesi_lokal_lidocaine, anestesi_lokal_bupivacaine, anestesi_lokal_rapivacaine, catatan, update_time, general_anestesi, general_masker, general_tiva, general_intubasi, general_lma, additif, induksi_insfluasidengan, anestesi_lokal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intravena_lainnya_cek, rencanaanestesi_id, tglrencanaanestesi, pegawaipenyusun_id, pendaftaran_id, pasien_id, premedikasi, premedikasi_midazolam, premedikasi_morphine, premedikasi_pethidine, premedikasi_ssulfasatropin, sedasi, monitor, observasi, induksi_insfluasi, induksi_sedatif, induksi_sedatif_midazolam, induksi_sedatif_propofol, induksi_sedatif_ketamine, induksi_analgetik, induksi_analgetik_morphine, induksi_analgetik_pethidine, induksi_analgetik_fentanyl, induksi_analgetik_ketamine, induksi_pelumpuhotak, induksi_pelumpuhotak_atracurium, induksi_pelumpuhotak_vecuronium, induksi_pelumpuhotak_rocuronium, inhalasi, inhalasi_o2, inhalasi_halothan, inhalasi_isofluran, inhalasi_sevofluran, inhalasi_enfluran, inhalasi_desflurane, intravena, intravena_propofol, intravena_morphien, intravena_pethidine, intravena_fentanyl, intravena_atracurium, intravena_vecuronium, intravena_recoronium, intravena_lainnya, intravena_lainnya_dosis, regional_anestesi, sab, epidural, pnb, anestesi_lokal_lidocaine, anestesi_lokal_bupivacaine, anestesi_lokal_rapivacaine, additif_keterangan1, additif_dosis1, additif_keterangan2, additif_dosis2, catatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, general_anestesi, general_masker, general_tiva, general_intubasi, general_lma, additif, induksi_insfluasidengan, anestesi_lokal', 'safe', 'on'=>'search'),
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
			'rencanaanestesi_id' => 'Rencanaanestesi',
			'tglrencanaanestesi' => 'Tglrencanaanestesi',
			'pegawaipenyusun_id' => 'Pegawaipenyusun',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'premedikasi' => 'Premedikasi',
			'premedikasi_midazolam' => 'Premedikasi Midazolam',
			'premedikasi_morphine' => 'Premedikasi Morphine',
			'premedikasi_pethidine' => 'Premedikasi Pethidine',
			'premedikasi_ssulfasatropin' => 'Premedikasi Ssulfasatropin',
			'sedasi' => 'Sedasi',
			'monitor' => 'Monitor',
			'observasi' => 'Observasi',
			'induksi_insfluasi' => 'Induksi Insfluasi',
			'induksi_sedatif' => 'Induksi Sedatif',
			'induksi_sedatif_midazolam' => 'Induksi Sedatif Midazolam',
			'induksi_sedatif_propofol' => 'Induksi Sedatif Propofol',
			'induksi_sedatif_ketamine' => 'Induksi Sedatif Ketamine',
			'induksi_analgetik' => 'Induksi Analgetik',
			'induksi_analgetik_morphine' => 'Induksi Analgetik Morphine',
			'induksi_analgetik_pethidine' => 'Induksi Analgetik Pethidine',
			'induksi_analgetik_fentanyl' => 'Induksi Analgetik Fentanyl',
			'induksi_analgetik_ketamine' => 'Induksi Analgetik Ketamine',
			'induksi_pelumpuhotak' => 'Induksi Pelumpuhotak',
			'induksi_pelumpuhotak_atracurium' => 'Induksi Pelumpuhotak Atracurium',
			'induksi_pelumpuhotak_vecuronium' => 'Induksi Pelumpuhotak Vecuronium',
			'induksi_pelumpuhotak_rocuronium' => 'Induksi Pelumpuhotak Rocuronium',
			'inhalasi' => 'Inhalasi',
			'inhalasi_o2' => 'Inhalasi O2',
			'inhalasi_halothan' => 'Inhalasi Halothan',
			'inhalasi_isofluran' => 'Inhalasi Isofluran',
			'inhalasi_sevofluran' => 'Inhalasi Sevofluran',
			'inhalasi_enfluran' => 'Inhalasi Enfluran',
			'inhalasi_desflurane' => 'Inhalasi Desflurane',
			'intravena' => 'Intravena',
			'intravena_propofol' => 'Intravena Propofol',
			'intravena_morphien' => 'Intravena Morphien',
			'intravena_pethidine' => 'Intravena Pethidine',
			'intravena_fentanyl' => 'Intravena Fentanyl',
			'intravena_atracurium' => 'Intravena Atracurium',
			'intravena_vecuronium' => 'Intravena Vecuronium',
			'intravena_recoronium' => 'Intravena Recoronium',
			'intravena_lainnya' => 'Intravena Lainnya',
			'intravena_lainnya_dosis' => 'Intravena Lainnya Dosis',
			'regional_anestesi' => 'Regional Anestesi',
			'sab' => 'Sab',
			'epidural' => 'Epidural',
			'pnb' => 'Pnb',
			'anestesi_lokal_lidocaine' => 'Anestesi Lokal Lidocaine',
			'anestesi_lokal_bupivacaine' => 'Anestesi Lokal Bupivacaine',
			'anestesi_lokal_rapivacaine' => 'Anestesi Lokal Rapivacaine',
			'additif_keterangan1' => 'Additif Keterangan1',
			'additif_dosis1' => 'Additif Dosis1',
			'additif_keterangan2' => 'Additif Keterangan2',
			'additif_dosis2' => 'Additif Dosis2',
			'catatan' => 'Catatan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'general_anestesi' => 'General Anestesi',
			'general_masker' => 'General Masker',
			'general_tiva' => 'General Tiva',
			'general_intubasi' => 'General Intubasi',
			'general_lma' => 'General Lma',
			'additif' => 'Additif',
			'induksi_insfluasidengan' => 'Induksi Insfluasidengan',
			'anestesi_lokal' => 'Anestesi Lokal',
			'intravena_lainnya_cek' => 'Anestesi Lokal',
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

		$criteria->compare('rencanaanestesi_id',$this->rencanaanestesi_id);
		$criteria->compare('tglrencanaanestesi',$this->tglrencanaanestesi,true);
		$criteria->compare('pegawaipenyusun_id',$this->pegawaipenyusun_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('premedikasi',$this->premedikasi);
		$criteria->compare('premedikasi_midazolam',$this->premedikasi_midazolam);
		$criteria->compare('premedikasi_morphine',$this->premedikasi_morphine);
		$criteria->compare('premedikasi_pethidine',$this->premedikasi_pethidine);
		$criteria->compare('premedikasi_ssulfasatropin',$this->premedikasi_ssulfasatropin);
		$criteria->compare('sedasi',$this->sedasi);
		$criteria->compare('monitor',$this->monitor);
		$criteria->compare('observasi',$this->observasi);
		$criteria->compare('induksi_insfluasi',$this->induksi_insfluasi,true);
		$criteria->compare('induksi_sedatif',$this->induksi_sedatif);
		$criteria->compare('induksi_sedatif_midazolam',$this->induksi_sedatif_midazolam);
		$criteria->compare('induksi_sedatif_propofol',$this->induksi_sedatif_propofol);
		$criteria->compare('induksi_sedatif_ketamine',$this->induksi_sedatif_ketamine);
		$criteria->compare('induksi_analgetik',$this->induksi_analgetik);
		$criteria->compare('induksi_analgetik_morphine',$this->induksi_analgetik_morphine);
		$criteria->compare('induksi_analgetik_pethidine',$this->induksi_analgetik_pethidine);
		$criteria->compare('induksi_analgetik_fentanyl',$this->induksi_analgetik_fentanyl);
		$criteria->compare('induksi_analgetik_ketamine',$this->induksi_analgetik_ketamine);
		$criteria->compare('induksi_pelumpuhotak',$this->induksi_pelumpuhotak);
		$criteria->compare('induksi_pelumpuhotak_atracurium',$this->induksi_pelumpuhotak_atracurium);
		$criteria->compare('induksi_pelumpuhotak_vecuronium',$this->induksi_pelumpuhotak_vecuronium);
		$criteria->compare('induksi_pelumpuhotak_rocuronium',$this->induksi_pelumpuhotak_rocuronium);
		$criteria->compare('inhalasi',$this->inhalasi);
		$criteria->compare('inhalasi_o2',$this->inhalasi_o2);
		$criteria->compare('inhalasi_halothan',$this->inhalasi_halothan);
		$criteria->compare('inhalasi_isofluran',$this->inhalasi_isofluran);
		$criteria->compare('inhalasi_sevofluran',$this->inhalasi_sevofluran);
		$criteria->compare('inhalasi_enfluran',$this->inhalasi_enfluran);
		$criteria->compare('inhalasi_desflurane',$this->inhalasi_desflurane);
		$criteria->compare('intravena',$this->intravena);
		$criteria->compare('intravena_propofol',$this->intravena_propofol);
		$criteria->compare('intravena_morphien',$this->intravena_morphien);
		$criteria->compare('intravena_pethidine',$this->intravena_pethidine);
		$criteria->compare('intravena_fentanyl',$this->intravena_fentanyl);
		$criteria->compare('intravena_atracurium',$this->intravena_atracurium);
		$criteria->compare('intravena_vecuronium',$this->intravena_vecuronium);
		$criteria->compare('intravena_recoronium',$this->intravena_recoronium);
		$criteria->compare('intravena_lainnya',$this->intravena_lainnya,true);
		$criteria->compare('intravena_lainnya_dosis',$this->intravena_lainnya_dosis,true);
		$criteria->compare('regional_anestesi',$this->regional_anestesi);
		$criteria->compare('sab',$this->sab);
		$criteria->compare('epidural',$this->epidural);
		$criteria->compare('pnb',$this->pnb);
		$criteria->compare('anestesi_lokal_lidocaine',$this->anestesi_lokal_lidocaine);
		$criteria->compare('anestesi_lokal_bupivacaine',$this->anestesi_lokal_bupivacaine);
		$criteria->compare('anestesi_lokal_rapivacaine',$this->anestesi_lokal_rapivacaine);
		$criteria->compare('additif_keterangan1',$this->additif_keterangan1,true);
		$criteria->compare('additif_dosis1',$this->additif_dosis1,true);
		$criteria->compare('additif_keterangan2',$this->additif_keterangan2,true);
		$criteria->compare('additif_dosis2',$this->additif_dosis2,true);
		$criteria->compare('catatan',$this->catatan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('general_anestesi',$this->general_anestesi);
		$criteria->compare('general_masker',$this->general_masker);
		$criteria->compare('general_tiva',$this->general_tiva);
		$criteria->compare('general_intubasi',$this->general_intubasi);
		$criteria->compare('general_lma',$this->general_lma);
		$criteria->compare('additif',$this->additif);
		$criteria->compare('induksi_insfluasidengan',$this->induksi_insfluasidengan);
		$criteria->compare('anestesi_lokal',$this->anestesi_lokal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         /**
         * untuk mencari instalasi aktif 
         * @author Rusdiyanto <rusdiyanto@inovamedik.com>
         * @param type $instalasi_id
         * @return type
         */
        public function getRuanganInstalasiItems($instalasi_id = null)
	{
	    if(!empty($instalasi_id)){
			$criteria = new CDbCriteria;
			$criteria->addCondition('instalasi_id ='.$instalasi_id);
			$criteria->addCondition('ruangan_aktif is TRUE');

			return RuanganM::model()->findAll($criteria);
		}else{
			return array();
		}
	}
        /**
         * untuk pencari pegawai berdasarkan ruangan
         * @author Rusdiyanto <rusdiyanto@inovamedik.com>
         * @param integer $ruangan_id
         * @return type
         */
        public function getPegawaiItems($ruangan_id='')
        {
        if(!empty($ruangan_id)):
            return PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
                'order'=>'nama_pegawai',
            ));
        else:
            return array();
        endif;
        }
}