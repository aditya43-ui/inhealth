<?php

/**
 * This is the model class for table "resumemedis_r".
 *
 * The followings are the available columns in table 'resumemedis_r':
 * @property integer $resumemedis_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $nodocmedis
 * @property string $tglresume
 * @property string $tglmasukrs
 * @property string $tglkeluarrs
 * @property string $rujukandari_nama
 * @property integer $ruanganterahkir_id
 * @property string $ikhtisarkliniksingkat
 * @property string $resume_pemeriksaanfisik
 * @property string $resume_pemeriksaanlab
 * @property string $resume_pemeriksaanrad
 * @property string $resume_diet
 * @property string $resume_rehabmedis
 * @property integer $diagnosaawal_id
 * @property integer $diagnosautama_id
 * @property integer $diagnosasekunder1_id
 * @property integer $diagnosasekunder2_id
 * @property integer $diagnosasekunder3_id
 * @property integer $diagnosatindakan1_id
 * @property integer $diagnosatindakan2_id
 * @property string $terapiperawatan
 * @property string $terapisaatpulang
 * @property string $carapulang_kondisi
 * @property string $saran_resume
 * @property string $tglprintresume
 * @property integer $jmlprintresume
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class ResumemedisR extends CActiveRecord
{
        public $default;
        public $pegawaipengisi_nama, $diagnosamasuk;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResumemedisR the static model class
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
		return 'resumemedis_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pasien_id, pendaftaran_id, nodocmedis, tglresume, tglmasukrs, ruanganterahkir_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, pasien_id, pendaftaran_id, ruanganterahkir_id, diagnosaawal_id, diagnosautama_id, diagnosasekunder1_id, diagnosasekunder2_id, diagnosasekunder3_id, diagnosatindakan1_id, diagnosatindakan2_id, jmlprintresume, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaipengisi_id', 'numerical', 'integerOnly'=>true),
			array('nodocmedis', 'length', 'max'=>50),
			array('rujukandari_nama, nama_keluarga', 'length', 'max'=>200),
			array('carapulang_kondisi', 'length', 'max'=>10),
			array('keterangan_resume, tglkeluarrs, ikhtisarkliniksingkat, resume_pemeriksaanfisik, resume_pemeriksaanlab, resume_pemeriksaanrad, resume_diet, resume_rehabmedis, terapiperawatan, terapisaatpulang, saran_resume, tglprintresume, update_time, riwayatoperasi, carakeluar, kondisipulang, anamnesa, pemeriksaanfisik, pemeriksaanpenunjang, diagnosa_akhir, pengobatandiberikan, keadaanwaktu_pulang, pemeriksaan_lanjutan, prognosa, rekomendasi_dokter', 'safe'),
                        ['pegawaipengisi_id, riwayatalergi,  planningdanterapi, terapiyangberjalan, riwayatbedah, riwayatobat, anjuran, pemeriksaanpenunjang, tandavital','safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resumemedis_id, pegawai_id, pasien_id, pendaftaran_id, nodocmedis, tglresume, tglmasukrs, tglkeluarrs, rujukandari_nama, ruanganterahkir_id, ikhtisarkliniksingkat, resume_pemeriksaanfisik, resume_pemeriksaanlab, resume_pemeriksaanrad, resume_diet, resume_rehabmedis, diagnosaawal_id, diagnosautama_id, diagnosasekunder1_id, diagnosasekunder2_id, diagnosasekunder3_id, diagnosatindakan1_id, diagnosatindakan2_id, terapiperawatan, terapisaatpulang, carapulang_kondisi, saran_resume, tglprintresume, jmlprintresume, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, anamnesa, pemeriksaanfisik, pemeriksaanpenunjang, diagnosa_akhir, pengobatandiberikan, keadaanwaktu_pulang, pemeriksaan_lanjutan, prognosa, rekomendasi_dokter, pegawaipengisi_id, nama_keluarga', 'safe', 'on'=>'search'),
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
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'pegawaipengisi' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipengisi_id'),
            'createruangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumemedis_id' => 'Resumemedis',
			'pegawai_id' => 'Pegawai',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'nodocmedis' => 'Nodocmedis',
			'tglresume' => 'Tglresume',
			'tglmasukrs' => 'Tglmasukrs',
			'tglkeluarrs' => 'Tglkeluarrs',
			'rujukandari_nama' => 'Rujukandari Nama',
			'ruanganterahkir_id' => 'Ruanganterahkir',
			'ikhtisarkliniksingkat' => 'Ikhtisarkliniksingkat',
			'resume_pemeriksaanfisik' => 'Resume Pemeriksaanfisik',
			'resume_pemeriksaanlab' => 'Resume Pemeriksaanlab',
			'resume_pemeriksaanrad' => 'Resume Pemeriksaanrad',
			'resume_diet' => 'Resume Diet',
			'resume_rehabmedis' => 'Resume Rehabmedis',
			'diagnosaawal_id' => 'Diagnosaawal',
			'diagnosautama_id' => 'Diagnosautama',
			'diagnosasekunder1_id' => 'Diagnosasekunder1',
			'diagnosasekunder2_id' => 'Diagnosasekunder2',
			'diagnosasekunder3_id' => 'Diagnosasekunder3',
			'diagnosatindakan1_id' => 'Diagnosatindakan1',
			'diagnosatindakan2_id' => 'Diagnosatindakan2',
			'terapiperawatan' => 'Terapiperawatan',
			'terapisaatpulang' => 'Terapisaatpulang',
			'carapulang_kondisi' => 'Carapulang Kondisi',
			'saran_resume' => 'Saran Resume',
			'tglprintresume' => 'Tglprintresume',
			'jmlprintresume' => 'Jmlprintresume',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tandavital' => 'Tanda Vital'
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

		if(!empty($this->resumemedis_id)){
			$criteria->addCondition('resumemedis_id = '.$this->resumemedis_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(nodocmedis)',strtolower($this->nodocmedis),true);
		$criteria->compare('LOWER(tglresume)',strtolower($this->tglresume),true);
		$criteria->compare('LOWER(tglmasukrs)',strtolower($this->tglmasukrs),true);
		$criteria->compare('LOWER(tglkeluarrs)',strtolower($this->tglkeluarrs),true);
		$criteria->compare('LOWER(rujukandari_nama)',strtolower($this->rujukandari_nama),true);
		if(!empty($this->ruanganterahkir_id)){
			$criteria->addCondition('ruanganterahkir_id = '.$this->ruanganterahkir_id);
		}
		$criteria->compare('LOWER(ikhtisarkliniksingkat)',strtolower($this->ikhtisarkliniksingkat),true);
		$criteria->compare('LOWER(resume_pemeriksaanfisik)',strtolower($this->resume_pemeriksaanfisik),true);
		$criteria->compare('LOWER(resume_pemeriksaanlab)',strtolower($this->resume_pemeriksaanlab),true);
		$criteria->compare('LOWER(resume_pemeriksaanrad)',strtolower($this->resume_pemeriksaanrad),true);
		$criteria->compare('LOWER(resume_diet)',strtolower($this->resume_diet),true);
		$criteria->compare('LOWER(resume_rehabmedis)',strtolower($this->resume_rehabmedis),true);
		if(!empty($this->diagnosaawal_id)){
			$criteria->addCondition('diagnosaawal_id = '.$this->diagnosaawal_id);
		}
		if(!empty($this->diagnosautama_id)){
			$criteria->addCondition('diagnosautama_id = '.$this->diagnosautama_id);
		}
		if(!empty($this->diagnosasekunder1_id)){
			$criteria->addCondition('diagnosasekunder1_id = '.$this->diagnosasekunder1_id);
		}
		if(!empty($this->diagnosasekunder2_id)){
			$criteria->addCondition('diagnosasekunder2_id = '.$this->diagnosasekunder2_id);
		}
		if(!empty($this->diagnosasekunder3_id)){
			$criteria->addCondition('diagnosasekunder3_id = '.$this->diagnosasekunder3_id);
		}
		if(!empty($this->diagnosatindakan1_id)){
			$criteria->addCondition('diagnosatindakan1_id = '.$this->diagnosatindakan1_id);
		}
		if(!empty($this->diagnosatindakan2_id)){
			$criteria->addCondition('diagnosatindakan2_id = '.$this->diagnosatindakan2_id);
		}
		$criteria->compare('LOWER(terapiperawatan)',strtolower($this->terapiperawatan),true);
		$criteria->compare('LOWER(terapisaatpulang)',strtolower($this->terapisaatpulang),true);
		$criteria->compare('LOWER(carapulang_kondisi)',strtolower($this->carapulang_kondisi),true);
		$criteria->compare('LOWER(saran_resume)',strtolower($this->saran_resume),true);
		$criteria->compare('LOWER(tglprintresume)',strtolower($this->tglprintresume),true);
		if(!empty($this->jmlprintresume)){
			$criteria->addCondition('jmlprintresume = '.$this->jmlprintresume);
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
        
        public function searchRiwayat(){
            
            $cri = new CDbCriteria;
            $cri->select = [
                'tglresume',
                'resumemedis_id',
                'pegawai_id',
				'is_verifikasirekammedis',
				'create_ruangan',
				'create_loginpemakai_id',
				'pendaftaran_id',
				'pasienadmisi_id'
            ];
            
            $cri->compare("pasien_id", $this->pasien_id);
			$cri->compare("pendaftaran_id", $this->pendaftaran_id);
            if (!empty($this->default)){
                $cri->addCondition(" resumemedis_id IS NULL ");
            }            
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$cri,                    
                'sort' => [
                    'defaultOrder' => 'tglresume DESC'
                ]
            ));
        }
        
        public function loadInput(){
            $this->pegawaipengisi_nama = !empty($this->pegawaipengisi)?$this->pegawaipengisi->namaLengkap:'';
        }
}