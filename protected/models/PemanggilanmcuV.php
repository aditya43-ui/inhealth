
<?php

/**
 * This is the model class for table "pemanggilanmcu_v".
 *
 * The followings are the available columns in table 'pemanggilanmcu_v':
 * @property string $tglrenkontrol
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $pemanggilanmcu_id
 * @property string $tglpemanggilanmcu
 * @property string $tglakanperiksamcu
 * @property integer $pemanggilanke
 * @property string $keterangan_pemanggilan
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $asuransipasien_id
 * @property string $namaperusahaan
 * @property string $nopeserta
 * @property string $namapemilikasuransi
 * @property string $status_hubungan
 */
class PemanggilanmcuV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemanggilanmcuV the static model class
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
		return 'pemanggilanmcu_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, pemanggilanmcu_id, pemanggilanke, ruangan_id, asuransipasien_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, ruangan_nama, namaperusahaan, nopeserta, namapemilikasuransi', 'length', 'max'=>50),
			array('keterangan_pemanggilan', 'length', 'max'=>200),
			array('status_hubungan', 'length', 'max'=>100),
			array('tglrenkontrol, tglpemanggilanmcu, tglakanperiksamcu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglrenkontrol, pendaftaran_id, pasien_id, no_rekam_medik, nama_pasien, pemanggilanmcu_id, tglpemanggilanmcu, tglakanperiksamcu, pemanggilanke, keterangan_pemanggilan, ruangan_id, ruangan_nama, asuransipasien_id, namaperusahaan, nopeserta, namapemilikasuransi, status_hubungan', 'safe', 'on'=>'search'),
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
			'tglrenkontrol' => 'Tglrenkontrol',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'pemanggilanmcu_id' => 'Pemanggilanmcu',
			'tglpemanggilanmcu' => 'Tglpemanggilanmcu',
			'tglakanperiksamcu' => 'Tglakanperiksamcu',
			'pemanggilanke' => 'Pemanggilanke',
			'keterangan_pemanggilan' => 'Keterangan Pemanggilan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'asuransipasien_id' => 'Asuransipasien',
			'namaperusahaan' => 'Namaperusahaan',
			'nopeserta' => 'Nopeserta',
			'namapemilikasuransi' => 'Namapemilikasuransi',
			'status_hubungan' => 'Status Hubungan',
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

		$criteria->compare('LOWER(tglrenkontrol)',strtolower($this->tglrenkontrol),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->pemanggilanmcu_id)){
			$criteria->addCondition('pemanggilanmcu_id = '.$this->pemanggilanmcu_id);
		}
		$criteria->compare('LOWER(tglpemanggilanmcu)',strtolower($this->tglpemanggilanmcu),true);
		$criteria->compare('LOWER(tglakanperiksamcu)',strtolower($this->tglakanperiksamcu),true);
		if(!empty($this->pemanggilanke)){
			$criteria->addCondition('pemanggilanke = '.$this->pemanggilanke);
		}
		$criteria->compare('LOWER(keterangan_pemanggilan)',strtolower($this->keterangan_pemanggilan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->asuransipasien_id)){
			$criteria->addCondition('asuransipasien_id = '.$this->asuransipasien_id);
		}
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(nopeserta)',strtolower($this->nopeserta),true);
		$criteria->compare('LOWER(namapemilikasuransi)',strtolower($this->namapemilikasuransi),true);
		$criteria->compare('LOWER(status_hubungan)',strtolower($this->status_hubungan),true);

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