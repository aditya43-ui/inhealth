<?php

/**
 * This is the model class for table "resumeperawat_r".
 *
 * The followings are the available columns in table 'resumeperawat_r':
 * @property integer $resumeperawat_id
 * @property integer $pasien_id
 * @property integer $kelaspelayanan_id
 * @property integer $kamarruangan_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $nodocresperwt
 * @property string $tglreseumperwt
 * @property string $tglmasukrs
 * @property string $tglkeluarrs
 * @property integer $ruanganakhir_id
 * @property integer $perawatbidan_id
 * @property string $keluhansaatmasuk
 * @property integer $diagnosaawal_id
 * @property string $diagkeprwtdiatasi
 * @property string $diagkeprwtblmteratasi
 * @property string $tindakankeprwatan
 * @property string $hasikperiksalab
 * @property string $hasilperiksarad
 * @property string $hasilperiksadiet
 * @property string $hasilperiksarehabmedis
 * @property string $hasilperiksalainlain
 * @property string $keadaansaatkeluar
 * @property string $keadaanumumkeluar
 * @property string $suhu_saatkeluar
 * @property string $nadi_saatkeluar
 * @property string $tensi_saatkeluar
 * @property string $nafas_saatkeluar
 * @property integer $diagnosautama_id
 * @property integer $diagnosasekunder1_id
 * @property integer $diagnosasekunder2_id
 * @property integer $diagnosasekunder3_id
 * @property string $terapilanjutan
 * @property string $nasehat_diit
 * @property string $nasehat_mobilisasi
 * @property string $nasehat_eliminasi
 * @property string $nasehat_kontrol
 * @property string $carakeluar
 * @property string $tglkontrol
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class ResumeperawatR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResumeperawatR the static model class
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
		return 'resumeperawat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, kelaspelayanan_id, pendaftaran_id, pegawai_id, nodocresperwt, tglreseumperwt, tglmasukrs, ruanganakhir_id, perawatbidan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, kelaspelayanan_id, kamarruangan_id, pendaftaran_id, pegawai_id, ruanganakhir_id, perawatbidan_id, diagnosaawal_id, diagnosautama_id, diagnosasekunder1_id, diagnosasekunder2_id, diagnosasekunder3_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nodocresperwt, suhu_saatkeluar, nadi_saatkeluar, tensi_saatkeluar, nafas_saatkeluar', 'length', 'max'=>50),
			array('nasehat_diit, nasehat_mobilisasi, nasehat_eliminasi, nasehat_kontrol', 'length', 'max'=>500),
			array('carakeluar', 'length', 'max'=>100),
			array('tglkeluarrs, keluhansaatmasuk, diagkeprwtdiatasi, diagkeprwtblmteratasi, tindakankeprwatan, hasikperiksalab, hasilperiksarad, hasilperiksadiet, hasilperiksarehabmedis, hasilperiksalainlain, keadaansaatkeluar, keadaanumumkeluar, terapilanjutan, tglkontrol, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resumeperawat_id, pasien_id, kelaspelayanan_id, kamarruangan_id, pendaftaran_id, pegawai_id, nodocresperwt, tglreseumperwt, tglmasukrs, tglkeluarrs, ruanganakhir_id, perawatbidan_id, keluhansaatmasuk, diagnosaawal_id, diagkeprwtdiatasi, diagkeprwtblmteratasi, tindakankeprwatan, hasikperiksalab, hasilperiksarad, hasilperiksadiet, hasilperiksarehabmedis, hasilperiksalainlain, keadaansaatkeluar, keadaanumumkeluar, suhu_saatkeluar, nadi_saatkeluar, tensi_saatkeluar, nafas_saatkeluar, diagnosautama_id, diagnosasekunder1_id, diagnosasekunder2_id, diagnosasekunder3_id, terapilanjutan, nasehat_diit, nasehat_mobilisasi, nasehat_eliminasi, nasehat_kontrol, carakeluar, tglkontrol, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'createlogin'=>array(self::BELONGS_TO,'LoginpemakaiK','create_loginpemakai_id'),
			'updatelogin'=>array(self::BELONGS_TO,'LoginpemakaiK','update_loginpemakai_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumeperawat_id' => 'Resumeperawat',
			'pasien_id' => 'Pasien',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kamarruangan_id' => 'Kamarruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'nodocresperwt' => 'Nodocresperwt',
			'tglreseumperwt' => 'Tglreseumperwt',
			'tglmasukrs' => 'Tglmasukrs',
			'tglkeluarrs' => 'Tglkeluarrs',
			'ruanganakhir_id' => 'Ruanganakhir',
			'perawatbidan_id' => 'Perawatbidan',
			'keluhansaatmasuk' => 'Keluhansaatmasuk',
			'diagnosaawal_id' => 'Diagnosaawal',
			'diagkeprwtdiatasi' => 'Diagkeprwtdiatasi',
			'diagkeprwtblmteratasi' => 'Diagkeprwtblmteratasi',
			'tindakankeprwatan' => 'Tindakankeprwatan',
			'hasikperiksalab' => 'Hasikperiksalab',
			'hasilperiksarad' => 'Hasilperiksarad',
			'hasilperiksadiet' => 'Hasilperiksadiet',
			'hasilperiksarehabmedis' => 'Hasilperiksarehabmedis',
			'hasilperiksalainlain' => 'Hasilperiksalainlain',
			'keadaansaatkeluar' => 'Keadaansaatkeluar',
			'keadaanumumkeluar' => 'Keadaanumumkeluar',
			'suhu_saatkeluar' => 'Suhu Saatkeluar',
			'nadi_saatkeluar' => 'Nadi Saatkeluar',
			'tensi_saatkeluar' => 'Tensi Saatkeluar',
			'nafas_saatkeluar' => 'Nafas Saatkeluar',
			'diagnosautama_id' => 'Diagnosautama',
			'diagnosasekunder1_id' => 'Diagnosasekunder1',
			'diagnosasekunder2_id' => 'Diagnosasekunder2',
			'diagnosasekunder3_id' => 'Diagnosasekunder3',
			'terapilanjutan' => 'Terapilanjutan',
			'nasehat_diit' => 'Nasehat Diit',
			'nasehat_mobilisasi' => 'Nasehat Mobilisasi',
			'nasehat_eliminasi' => 'Nasehat Eliminasi',
			'nasehat_kontrol' => 'Nasehat Kontrol',
			'carakeluar' => 'Carakeluar',
			'tglkontrol' => 'Tglkontrol',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->resumeperawat_id)){
			$criteria->addCondition('resumeperawat_id = '.$this->resumeperawat_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nodocresperwt)',strtolower($this->nodocresperwt),true);
		$criteria->compare('LOWER(tglreseumperwt)',strtolower($this->tglreseumperwt),true);
		$criteria->compare('LOWER(tglmasukrs)',strtolower($this->tglmasukrs),true);
		$criteria->compare('LOWER(tglkeluarrs)',strtolower($this->tglkeluarrs),true);
		if(!empty($this->ruanganakhir_id)){
			$criteria->addCondition('ruanganakhir_id = '.$this->ruanganakhir_id);
		}
		if(!empty($this->perawatbidan_id)){
			$criteria->addCondition('perawatbidan_id = '.$this->perawatbidan_id);
		}
		$criteria->compare('LOWER(keluhansaatmasuk)',strtolower($this->keluhansaatmasuk),true);
		if(!empty($this->diagnosaawal_id)){
			$criteria->addCondition('diagnosaawal_id = '.$this->diagnosaawal_id);
		}
		$criteria->compare('LOWER(diagkeprwtdiatasi)',strtolower($this->diagkeprwtdiatasi),true);
		$criteria->compare('LOWER(diagkeprwtblmteratasi)',strtolower($this->diagkeprwtblmteratasi),true);
		$criteria->compare('LOWER(tindakankeprwatan)',strtolower($this->tindakankeprwatan),true);
		$criteria->compare('LOWER(hasikperiksalab)',strtolower($this->hasikperiksalab),true);
		$criteria->compare('LOWER(hasilperiksarad)',strtolower($this->hasilperiksarad),true);
		$criteria->compare('LOWER(hasilperiksadiet)',strtolower($this->hasilperiksadiet),true);
		$criteria->compare('LOWER(hasilperiksarehabmedis)',strtolower($this->hasilperiksarehabmedis),true);
		$criteria->compare('LOWER(hasilperiksalainlain)',strtolower($this->hasilperiksalainlain),true);
		$criteria->compare('LOWER(keadaansaatkeluar)',strtolower($this->keadaansaatkeluar),true);
		$criteria->compare('LOWER(keadaanumumkeluar)',strtolower($this->keadaanumumkeluar),true);
		$criteria->compare('LOWER(suhu_saatkeluar)',strtolower($this->suhu_saatkeluar),true);
		$criteria->compare('LOWER(nadi_saatkeluar)',strtolower($this->nadi_saatkeluar),true);
		$criteria->compare('LOWER(tensi_saatkeluar)',strtolower($this->tensi_saatkeluar),true);
		$criteria->compare('LOWER(nafas_saatkeluar)',strtolower($this->nafas_saatkeluar),true);
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
		$criteria->compare('LOWER(terapilanjutan)',strtolower($this->terapilanjutan),true);
		$criteria->compare('LOWER(nasehat_diit)',strtolower($this->nasehat_diit),true);
		$criteria->compare('LOWER(nasehat_mobilisasi)',strtolower($this->nasehat_mobilisasi),true);
		$criteria->compare('LOWER(nasehat_eliminasi)',strtolower($this->nasehat_eliminasi),true);
		$criteria->compare('LOWER(nasehat_kontrol)',strtolower($this->nasehat_kontrol),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(tglkontrol)',strtolower($this->tglkontrol),true);
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
}