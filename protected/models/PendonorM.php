<?php

/**
 * This is the model class for table "pendonor_m".
 *
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pendonor_m':
 * @property integer $pendonor_id
 * @property integer $profilrs_id
 * @property string $no_pendonor
 * @property string $jenisidentitas
 * @property string $no_identitas
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgllahir
 * @property string $jenis_kelamin
 * @property string $alamat_lengkap
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $notelp_pendonor
 * @property string $nomobile_pendonor
 * @property integer $pekerjaan_id
 * @property string $statusperkawinan
 * @property string $gol_darah
 * @property string $rhesus
 * @property boolean $is_pernah_donor
 * @property integer $donasi_ke_sblm
 * @property string $tgl_donor_terakhir
 * @property string $tempat_donor_terakhir
 * @property integer $donasi_ke
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property DaftardonasiT[] $daftardonasiTs
 */
class PendonorM extends CActiveRecord
{
        public $tgl_awal ,$tgl_akhir;
        public $no_formulir;
        public $umur;
        public $is_pernahdonor1;
        public $is_jenis;
        public $temp_file, $waktu_observasi;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendonorM the static model class
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
		return 'pendonor_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg,nomobile_pendonor, statusperkawinan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('profilrs_id, pekerjaan_id, donasi_ke_sblm, donasi_ke, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, tinggibadan_cm', 'numerical'),
			array('no_pendonor, no_identitas', 'length', 'max'=>50),
			array('jenisidentitas', 'length', 'max'=>30),
			array('nama_lengkap, tempat_lahir, notelp_pendonor, tempat_donor_terakhir', 'length', 'max'=>100),
			array('jenis_kelamin, statusperkawinan, rhesus', 'length', 'max'=>20),
			array('alamat_lengkap, nomobile_pendonor', 'length', 'max'=>255),
			array('gol_darah', 'length', 'max'=>2),
			array('agama, propinsi_id,kabupaten_id,kecamatan_id,kelurahan_id,temp_file, photopendonor, is_pernahdonor1,is_pernah_donor, tgl_donor_terakhir, gol_darah, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendonor_id, profilrs_id, no_pendonor, jenisidentitas, no_identitas, nama_lengkap, tempat_lahir, tgllahir, jenis_kelamin, alamat_lengkap, beratbadan_kg, tinggibadan_cm, notelp_pendonor, nomobile_pendonor, pekerjaan_id, statusperkawinan, gol_darah, rhesus, is_pernah_donor, donasi_ke_sblm, tgl_donor_terakhir, tempat_donor_terakhir, donasi_ke, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, agama', 'safe', 'on'=>'search'),
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
                    'daftardonasiTs' => array(self::HAS_MANY, 'DaftardonasiT', 'pendonor_id'),
                    'pekerjaan' => array(self::BELONGS_TO, 'PekerjaanM', 'pekerjaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pendonor_id' => 'Pendonor',
			'profilrs_id' => 'Profilrs',
			'no_pendonor' => 'No Pendonor',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas' => 'No Identitas',
			'nama_lengkap' => 'Nama Lengkap',
			'tempat_lahir' => 'Tempat Lahir',
			'tgllahir' => 'Tgllahir',
			'jenis_kelamin' => 'Jenis Kelamin',
			'alamat_lengkap' => 'Alamat Lengkap',
			'beratbadan_kg' => 'Beratbadan Kg',
			'tinggibadan_cm' => 'Tinggibadan Cm',
			'notelp_pendonor' => 'Notelp Pendonor',
			'nomobile_pendonor' => 'Nomobile Pendonor',
			'pekerjaan_id' => 'Pekerjaan',
			'statusperkawinan' => 'Statusperkawinan',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'is_pernah_donor' => 'Pernah Donor Sebelumnya?',
			'donasi_ke_sblm' => 'Donasi Ke Sblm',
			'tgl_donor_terakhir' => 'Tgl Donor Terakhir',
			'tempat_donor_terakhir' => 'Tempat Donor Terakhir',
			'donasi_ke' => 'Donasi Ke',
			'agama' => 'Agama',
			'donor_itd_ke' => 'Donasi Terakhir ITD ke-',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->pendonor_id)){
			$criteria->addCondition('pendonor_id = '.$this->pendonor_id);
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(no_pendonor)',strtolower($this->no_pendonor),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas)',strtolower($this->no_identitas),true);
		$criteria->compare('LOWER(nama_lengkap)',strtolower($this->nama_lengkap),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
//		$criteria->compare('LOWER(tgllahir)',strtolower($this->tgllahir),true);
                if ($this->tgllahir != "") {
                    $criteria->addCondition("DATE(tgllahir) = '" . MyFormatter::formatDateTimeForDb($this->tgllahir) . "'");
                }
		$criteria->compare('LOWER(jenis_kelamin)',strtolower($this->jenis_kelamin),true);
		$criteria->compare('LOWER(alamat_lengkap)',strtolower($this->alamat_lengkap),true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('LOWER(notelp_pendonor)',strtolower($this->notelp_pendonor),true);
		$criteria->compare('LOWER(nomobile_pendonor)',strtolower($this->nomobile_pendonor),true);
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id = '.$this->pekerjaan_id);
		}
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(gol_darah)',strtolower($this->gol_darah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('is_pernah_donor',$this->is_pernah_donor);
		if(!empty($this->donasi_ke_sblm)){
			$criteria->addCondition('donasi_ke_sblm = '.$this->donasi_ke_sblm);
		}
		$criteria->compare('LOWER(tgl_donor_terakhir)',strtolower($this->tgl_donor_terakhir),true);
		$criteria->compare('LOWER(tempat_donor_terakhir)',strtolower($this->tempat_donor_terakhir),true);
		if(!empty($this->donasi_ke)){
			$criteria->addCondition('donasi_ke = '.$this->donasi_ke);
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
}