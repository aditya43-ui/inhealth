<?php

/**
 * This is the model class for table "peminjamanrm_t".
 *
 * The followings are the available columns in table 'peminjamanrm_t':
 * @property integer $peminjamanrm_id
 * @property integer $pengirimanrm_id
 * @property integer $dokrekammedis_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $kembalirm_id
 * @property integer $ruangan_id
 * @property string $nourut_pinjam
 * @property string $tglpeminjamanrm
 * @property string $untukkepentingan
 * @property string $keteranganpeminjaman
 * @property string $tglakandikembalikan
 * @property string $namapeminjam
 * @property boolean $printpeminjaman
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $instalasi_id
 *
 * The followings are the available model relations:
 * @property PengirimanrmT[] $pengirimanrmTs
 * @property PendaftaranT[] $pendaftaranTs
 * @property KembalirmT[] $kembalirmTs
 * @property DokrekammedisM $dokrekammedis
 * @property KembalirmT $kembalirm
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PengirimanrmT $pengirimanrm
 * @property RuanganM $ruangan
 */
class PeminjamanrmT extends CActiveRecord
{
	public $no_rekam_medik;
	public $nama_pasien;
	public $jenis_kelamin;
	public $tanggal_lahir;
	public $umur;
	public $lokasirak_nama,$subrak_nama,$warnadokrm_namawarna;
	public $printArray;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeminjamanrmT the static model class
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
		return 'peminjamanrm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dokrekammedis_id, pasien_id, ruangan_id, nourut_pinjam, tglpeminjamanrm, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pengirimanrm_id, dokrekammedis_id, pasien_id, pendaftaran_id, kembalirm_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('nourut_pinjam', 'length', 'max'=>5),
			array('untukkepentingan', 'length', 'max'=>50),
			array('namapeminjam', 'length', 'max'=>100),
			array('keteranganpeminjaman, tglakandikembalikan, printpeminjaman, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peminjamanrm_id, pengirimanrm_id, dokrekammedis_id, pasien_id, pendaftaran_id, kembalirm_id, ruangan_id, nourut_pinjam, tglpeminjamanrm, untukkepentingan, keteranganpeminjaman, tglakandikembalikan, namapeminjam, printpeminjaman, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, instalasi_id', 'safe', 'on'=>'search'),
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
			'pengirimanrmTs' => array(self::HAS_MANY, 'PengirimanrmT', 'peminjamanrm_id'),
			'pendaftaranTs' => array(self::HAS_MANY, 'PendaftaranT', 'peminjamanrm_id'),
			'kembalirmTs' => array(self::HAS_MANY, 'KembalirmT', 'peminjamanrm_id'),
			'dokrekammedis' => array(self::BELONGS_TO, 'DokrekammedisM', 'dokrekammedis_id'),
			'kembalirm' => array(self::BELONGS_TO, 'KembalirmT', 'kembalirm_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pengirimanrm' => array(self::BELONGS_TO, 'PengirimanrmT', 'pengirimanrm_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'peminjamanrm_id' => 'ID',
			'pengirimanrm_id' => 'ID Pengiriman RM',
			'dokrekammedis_id' => 'Dok. Rekam Medis',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'kembalirm_id' => 'Kembali RM',
			'ruangan_id' => 'Ruangan',
			'nourut_pinjam' => 'No. Urut Pinjam',
			'tglpeminjamanrm' => 'Tgl. Peminjaman RM',
			'untukkepentingan' => 'Untuk Kepentingan',
			'keteranganpeminjaman' => 'Keterangan Peminjaman',
			'tglakandikembalikan' => 'Tgl. Akan Dikembalikan',
			'namapeminjam' => 'Nama Peminjam',
			'printpeminjaman' => 'Print Peminjam',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'instalasi_id' => 'Instalasi',
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

		if(!empty($this->peminjamanrm_id)){
			$criteria->addCondition('peminjamanrm_id = '.$this->peminjamanrm_id);
		}
		if(!empty($this->pengirimanrm_id)){
			$criteria->addCondition('pengirimanrm_id = '.$this->pengirimanrm_id);
		}
		if(!empty($this->dokrekammedis_id)){
			$criteria->addCondition('dokrekammedis_id = '.$this->dokrekammedis_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->kembalirm_id)){
			$criteria->addCondition('kembalirm_id = '.$this->kembalirm_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nourut_pinjam)',strtolower($this->nourut_pinjam),true);
		$criteria->compare('LOWER(tglpeminjamanrm)',strtolower($this->tglpeminjamanrm),true);
		$criteria->compare('LOWER(untukkepentingan)',strtolower($this->untukkepentingan),true);
		$criteria->compare('LOWER(keteranganpeminjaman)',strtolower($this->keteranganpeminjaman),true);
		$criteria->compare('LOWER(tglakandikembalikan)',strtolower($this->tglakandikembalikan),true);
		$criteria->compare('LOWER(namapeminjam)',strtolower($this->namapeminjam),true);
		$criteria->compare('printpeminjaman',$this->printpeminjaman);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
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