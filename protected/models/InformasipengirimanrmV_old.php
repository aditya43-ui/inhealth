<?php

/**
 * This is the model class for table "informasipengirimanrm_v".
 *
 * The followings are the available columns in table 'informasipengirimanrm_v':
 * @property integer $pengirimanrm_id
 * @property integer $peminjamanrm_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property integer $dokrekammedis_id
 * @property integer $ruangantujuan_id
 * @property string $ruangantujuan_nama
 * @property integer $instalasitujuan_id
 * @property string $instalasitujuan_nama
 * @property string $nourut_keluar
 * @property string $tglpengirimanrm
 * @property boolean $kelengkapandokumen
 * @property string $petugaspengirim
 * @property boolean $printpengiriman
 * @property integer $ruanganpengirim_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $kembalirm_id
 * @property string $tglkembali
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $statusdokrm
 */
class InformasipengirimanrmV_old extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipengirimanrmV the static model class
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
		return 'informasipengirimanrm_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengirimanrm_id, peminjamanrm_id, pasien_id, pendaftaran_id, dokrekammedis_id, ruangantujuan_id, instalasitujuan_id, ruanganpengirim_id, kembalirm_id', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, ruangantujuan_nama, instalasitujuan_nama, statusdokrm', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('nourut_keluar', 'length', 'max'=>5),
			array('petugaspengirim', 'length', 'max'=>100),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tglpengirimanrm, kelengkapandokumen, printpengiriman, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglkembali, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengirimanrm_id, peminjamanrm_id, pasien_id, no_rekam_medik, tgl_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, pendaftaran_id, dokrekammedis_id, ruangantujuan_id, ruangantujuan_nama, instalasitujuan_id, instalasitujuan_nama, nourut_keluar, tglpengirimanrm, kelengkapandokumen, petugaspengirim, printpengiriman, ruanganpengirim_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kembalirm_id, tglkembali, no_pendaftaran, tgl_pendaftaran, statusdokrm', 'safe', 'on'=>'search'),
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
			'ruanganpengirim'=>array(self::BELONGS_TO,'RuanganM','ruanganpengirim_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengirimanrm_id' => 'ID Pengiriman RM',
			'peminjamanrm_id' => 'ID Peminjaman RM',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Alias',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'dokrekammedis_id' => 'ID Dok. Rekam Medis',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'ruangantujuan_nama' => 'Ruangan Tujuan',
			'instalasitujuan_id' => 'Instalasi Tujuan',
			'instalasitujuan_nama' => 'Instalasi Tujuan',
			'nourut_keluar' => 'No. Urut Keluar',
			'tglpengirimanrm' => 'Tgl. Pengiriman RM',
			'kelengkapandokumen' => 'Kelengkapan Dokumen',
			'petugaspengirim' => 'Petugas Pengiriman',
			'printpengiriman' => 'Print Pengiriman',
			'ruanganpengirim_id' => 'Ruangan Pengiriman',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'kembalirm_id' => 'ID Kembali RM',
			'tglkembali' => 'Tgl. Kembali',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl, Pendaftaran',
			'statusdokrm' => 'Status Dok. RM',
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

		if(!empty($this->pengirimanrm_id)){
			$criteria->addCondition('pengirimanrm_id = '.$this->pengirimanrm_id);
		}
		if(!empty($this->peminjamanrm_id)){
			$criteria->addCondition('peminjamanrm_id = '.$this->peminjamanrm_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->dokrekammedis_id)){
			$criteria->addCondition('dokrekammedis_id = '.$this->dokrekammedis_id);
		}
		if(!empty($this->ruangantujuan_id)){
			$criteria->addCondition('ruangantujuan_id = '.$this->ruangantujuan_id);
		}
		$criteria->compare('LOWER(ruangantujuan_nama)',strtolower($this->ruangantujuan_nama),true);
		if(!empty($this->instalasitujuan_id)){
			$criteria->addCondition('instalasitujuan_id = '.$this->instalasitujuan_id);
		}
		$criteria->compare('LOWER(instalasitujuan_nama)',strtolower($this->instalasitujuan_nama),true);
		$criteria->compare('LOWER(nourut_keluar)',strtolower($this->nourut_keluar),true);
		$criteria->compare('LOWER(tglpengirimanrm)',strtolower($this->tglpengirimanrm),true);
		$criteria->compare('kelengkapandokumen',$this->kelengkapandokumen);
		$criteria->compare('LOWER(petugaspengirim)',strtolower($this->petugaspengirim),true);
		$criteria->compare('printpengiriman',$this->printpengiriman);
		if(!empty($this->ruanganpengirim_id)){
			$criteria->addCondition('ruanganpengirim_id = '.$this->ruanganpengirim_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->kembalirm_id)){
			$criteria->addCondition('kembalirm_id = '.$this->kembalirm_id);
		}
		$criteria->compare('LOWER(tglkembali)',strtolower($this->tglkembali),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(statusdokrm)',strtolower($this->statusdokrm),true);

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
		
		public function getInstalasiItems()
        {
            return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_id');
        }
        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_id');
        }
}