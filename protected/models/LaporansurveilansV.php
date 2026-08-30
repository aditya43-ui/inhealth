<?php

/**
 * This is the model class for table "laporansurveilans_v".
 *
 * The followings are the available columns in table 'laporansurveilans_v':
 * @property integer $surveilans_id
 * @property string $surveilans_tgl
 * @property string $antibiotik
 * @property string $darah
 * @property string $deku
 * @property string $sputum
 * @property string $urine
 * @property boolean $ett
 * @property boolean $ivl
 * @property boolean $cvl
 * @property boolean $uc
 * @property boolean $vap
 * @property boolean $iad
 * @property boolean $pleb
 * @property boolean $isk
 * @property integer $pendaftaran_id
 * @property string $nama_pasien
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $diagnosa_id
 * @property string $diagnosa_nama
 * @property string $create_loginpemakai_id
 */
class LaporansurveilansV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansurveilansV the static model class
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
		return 'laporansurveilans_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('surveilans_id, pendaftaran_id, pasien_id, ruangan_id, pegawai_id, diagnosa_id', 'numerical', 'integerOnly'=>true),
			array('antibiotik, darah, sputum, urine', 'length', 'max'=>30),
			array('deku', 'length', 'max'=>20),
			array('nama_pasien, ruangan_nama, nama_pegawai', 'length', 'max'=>50),
			array('diagnosa_nama', 'length', 'max'=>200),
			array('surveilans_tgl, ett, ivl, cvl, uc, vap, iad, pleb, isk, create_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('surveilans_id, instalasi_id, surveilans_tgl, antibiotik, darah, deku, sputum, urine, ett, ivl, cvl, uc, vap, iad, pleb, isk, pendaftaran_id, nama_pasien, pasien_id, ruangan_id, ruangan_nama, pegawai_id, nama_pegawai, diagnosa_id, diagnosa_nama, create_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'surveilans_id' => 'Surveilans',
			'surveilans_tgl' => 'Surveilans Tgl',
			'antibiotik' => 'Antibiotik',
			'darah' => 'Darah',
			'deku' => 'Deku',
			'sputum' => 'Sputum',
			'urine' => 'Urine',
			'ett' => 'Ett',
			'ivl' => 'Ivl',
			'cvl' => 'Cvl',
			'uc' => 'Uc',
			'vap' => 'Vap',
			'iad' => 'Iad',
			'pleb' => 'Pleb',
			'isk' => 'Isk',
			'pendaftaran_id' => 'Pendaftaran',
			'nama_pasien' => 'Nama Pasien',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan', 
            'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_nama' => 'Diagnosa Nama',
			'create_loginpemakai_id' => 'Create Login Pemakai',
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

		if(!empty($this->surveilans_id)){
			$criteria->addCondition('surveilans_id = '.$this->surveilans_id);
		}
		$criteria->compare('LOWER(surveilans_tgl)',strtolower($this->surveilans_tgl),true);
		$criteria->compare('LOWER(antibiotik)',strtolower($this->antibiotik),true);
		$criteria->compare('LOWER(darah)',strtolower($this->darah),true);
		$criteria->compare('LOWER(deku)',strtolower($this->deku),true);
		$criteria->compare('LOWER(sputum)',strtolower($this->sputum),true);
		$criteria->compare('LOWER(urine)',strtolower($this->urine),true);
		$criteria->compare('ett',$this->ett);
		$criteria->compare('ivl',$this->ivl);
		$criteria->compare('cvl',$this->cvl);
		$criteria->compare('uc',$this->uc);
		$criteria->compare('vap',$this->vap);
		$criteria->compare('iad',$this->iad);
		$criteria->compare('pleb',$this->pleb);
		$criteria->compare('isk',$this->isk);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition('diagnosa_id = '.$this->diagnosa_id);
		}
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);

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