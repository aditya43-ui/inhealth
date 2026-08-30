<?php

/**
 * This is the model class for table "informasipeminjamanrm_v".
 *
 * The followings are the available columns in table 'informasipeminjamanrm_v':
 * @property integer $peminjamanrm_id
 * @property integer $dokrekammedis_id
 * @property string $nodokumenrm
 * @property integer $warnadokrm_id
 * @property string $warnadokrm_namawarna
 * @property integer $pasien_id
 * @property string $tgl_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $no_rekam_medik
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $nourut_pinjam
 * @property string $tglpeminjamanrm
 * @property string $untukkepentingan
 * @property string $keteranganpeminjaman
 */
class InformasipeminjamanrmV extends CActiveRecord
{
                public $tgl_awal;
                public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipeminjamanrmV the static model class
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
		return 'informasipeminjamanrm_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peminjamanrm_id, dokrekammedis_id, warnadokrm_id, pasien_id, pendaftaran_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('nodokumenrm, warnadokrm_namawarna, namadepan, jeniskelamin', 'length', 'max'=>20),
			array('nama_pasien, ruangan_nama, instalasi_nama, untukkepentingan', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nourut_pinjam', 'length', 'max'=>5),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tglpeminjamanrm, keteranganpeminjaman', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peminjamanrm_id, dokrekammedis_id, nodokumenrm, warnadokrm_id, warnadokrm_namawarna, pasien_id, tgl_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tanggal_lahir, alamat_pasien, no_rekam_medik, pendaftaran_id, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, nourut_pinjam, tglpeminjamanrm, untukkepentingan, keteranganpeminjaman', 'safe', 'on'=>'search'),
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
			'peminjamanrm_id' => 'Peminjamanrm',
			'dokrekammedis_id' => 'Dokrekammedis',
			'nodokumenrm' => 'No. Dokumen',
			'warnadokrm_id' => 'Warnadokrm',
			'warnadokrm_namawarna' => 'Warnadokrm Namawarna',
			'pasien_id' => 'Pasien',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'nourut_pinjam' => 'Nourut Pinjam',
			'tglpeminjamanrm' => 'Tglpeminjamanrm',
			'untukkepentingan' => 'Untuk Kepentingan',
			'keteranganpeminjaman' => 'Keteranganpeminjaman',
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

		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(nourut_pinjam)',strtolower($this->nourut_pinjam),true);
		$criteria->addBetweenCondition('t.tglpeminjamanrm', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(untukkepentingan)',strtolower($this->untukkepentingan),true);
		$criteria->compare('LOWER(keteranganpeminjaman)',strtolower($this->keteranganpeminjaman),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(nourut_pinjam)',strtolower($this->nourut_pinjam),true);
		$criteria->compare('LOWER(tglpeminjamanrm)',strtolower($this->tglpeminjamanrm),true);
		$criteria->compare('LOWER(untukkepentingan)',strtolower($this->untukkepentingan),true);
		$criteria->compare('LOWER(keteranganpeminjaman)',strtolower($this->keteranganpeminjaman),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getInstalasiItems()
        {
            return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama ASC');
        }
        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_nama ASC');
        }
}