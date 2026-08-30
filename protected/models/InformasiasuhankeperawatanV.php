<?php

/**
 * This is the model class for table "informasiasuhankeperawatan_v".
 *
 * The followings are the available columns in table 'informasiasuhankeperawatan_v':
 * @property integer $asuhankeperawatan_id
 * @property string $tglaskep
 * @property string $tglassesment
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $umur
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property integer $diagnosakeperawatan_id
 * @property string $diagnosakeperawatan_kode
 * @property string $diagnosa_medis
 * @property string $diagnosa_keperawatan
 * @property string $diagnosa_tujuan
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $shift_id
 * @property string $shift_nama
 */
class InformasiasuhankeperawatanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiasuhankeperawatanV the static model class
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
		return 'informasiasuhankeperawatan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asuhankeperawatan_id, pendaftaran_id, pasienadmisi_id, ruangan_id, instalasi_id, kamarruangan_id, pasien_id, diagnosa_id, diagnosakeperawatan_id, pegawai_id, gelarbelakang_id, shift_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, namadepan', 'length', 'max'=>20),
			array('ruangan_nama, instalasi_nama, nama_pasien, nama_pegawai, shift_nama', 'length', 'max'=>50),
			array('kamarruangan_nokamar, kamarruangan_nobed, no_rekam_medik, diagnosa_kode, diagnosakeperawatan_kode, gelardepan', 'length', 'max'=>10),
			array('umur, nomorindukpegawai', 'length', 'max'=>30),
			array('diagnosa_nama', 'length', 'max'=>200),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tglaskep, tglassesment, tgladmisi, diagnosa_medis, diagnosa_keperawatan, diagnosa_tujuan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asuhankeperawatan_id, tglaskep, tglassesment, pendaftaran_id, no_pendaftaran, pasienadmisi_id, tgladmisi, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed, pasien_id, no_rekam_medik, namadepan, nama_pasien, jeniskelamin, umur, diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosakeperawatan_id, diagnosakeperawatan_kode, diagnosa_medis, diagnosa_keperawatan, diagnosa_tujuan, pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, shift_id, shift_nama', 'safe', 'on'=>'search'),
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
			'asuhankeperawatan_id' => 'Asuhan Keperawatan',
			'tglaskep' => 'Tanggal Asuhan Keperawatan',
			'tglassesment' => 'Tanggal Assesment',
			'pendaftaran_id' => 'ID Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasienadmisi_id' => 'ID Pasien Admisi',
			'tgladmisi' => 'Tanggal Admisi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'kamarruangan_id' => 'Kamar Ruangan',
			'kamarruangan_nokamar' => 'No. Kamar Ruangan',
			'kamarruangan_nobed' => 'No. Bed',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'umur' => 'Umur',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Kode Diagnosa',
			'diagnosa_nama' => 'Nama Diagnosa',
			'diagnosakeperawatan_id' => 'Diagnosa Keperawatan',
			'diagnosakeperawatan_kode' => 'Kode Diagnosa Keperawatan',
			'diagnosa_medis' => 'Diagnosa Medis',
			'diagnosa_keperawatan' => 'Diagnosa Keperawatan',
			'diagnosa_tujuan' => 'Tujuan Diagnosa',
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomor Induk Pegawai',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelar Belakang',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift',
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

		if(!empty($this->asuhankeperawatan_id)){
			$criteria->addCondition('asuhankeperawatan_id = '.$this->asuhankeperawatan_id);
		}
		$criteria->compare('LOWER(tglaskep)',strtolower($this->tglaskep),true);
		$criteria->compare('LOWER(tglassesment)',strtolower($this->tglassesment),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition('diagnosa_id = '.$this->diagnosa_id);
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		if(!empty($this->diagnosakeperawatan_id)){
			$criteria->addCondition('diagnosakeperawatan_id = '.$this->diagnosakeperawatan_id);
		}
		$criteria->compare('LOWER(diagnosakeperawatan_kode)',strtolower($this->diagnosakeperawatan_kode),true);
		$criteria->compare('LOWER(diagnosa_medis)',strtolower($this->diagnosa_medis),true);
		$criteria->compare('LOWER(diagnosa_keperawatan)',strtolower($this->diagnosa_keperawatan),true);
		$criteria->compare('LOWER(diagnosa_tujuan)',strtolower($this->diagnosa_tujuan),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
		}
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);

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