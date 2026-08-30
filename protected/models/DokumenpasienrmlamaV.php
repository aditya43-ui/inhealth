<?php

/**
 * This is the model class for table "dokumenpasienrmlama_v".
 *
 * The followings are the available columns in table 'dokumenpasienrmlama_v':
 * @property integer $warnadokrm_id
 * @property string $warnadokrm_namawarna
 * @property string $warnadokrm_kodewarna
 * @property integer $lokasirak_id
 * @property string $lokasirak_nama
 * @property string $nodokumenrm
 * @property string $tglrekammedis
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $tempat_lahir
 * @property string $tglmasukrak
 * @property string $statusrekammedis
 * @property string $nomortertier
 * @property string $nomorsekunder
 * @property string $nomorprimer
 * @property string $warnanorm_i
 * @property string $warnanorm_ii
 * @property string $tglkeluarakhir
 * @property string $tglmasukakhir
 * @property integer $dokrekammedis_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $no_pendaftaran
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $pendaftaran_id
 * @property integer $subrak_id
 * @property string $subrak_nama
 * @property integer $peminjamanrm_id
 * @property integer $pengirimanrm_id
 * @property boolean $printpeminjaman
 * @property string $tgl_pendaftaran
 * @property integer $kembalirm_id
 * @property boolean $kelengkapandokumen
 */
class DokumenpasienrmlamaV extends CActiveRecord
{
	public $printArray,$ids;
	public $tgl_rekam_medik_akhir; 
	public $no_rekam_medik_akhir; 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokumenpasienrmlamaV the static model class
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
		return 'dokumenpasienrmlama_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warnadokrm_id, lokasirak_id, pasien_id, dokrekammedis_id, ruangan_id, instalasi_id, pendaftaran_id, subrak_id, peminjamanrm_id, pengirimanrm_id, kembalirm_id', 'numerical', 'integerOnly'=>true),
			array('warnadokrm_namawarna, warnadokrm_kodewarna, nodokumenrm, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('lokasirak_nama', 'length', 'max'=>100),
			array('no_rekam_medik, statusrekammedis', 'length', 'max'=>10),
			array('nama_pasien, warnanorm_i, warnanorm_ii, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('nama_bin, subrak_nama', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('nomortertier, nomorsekunder, nomorprimer', 'length', 'max'=>2),
			array('tglrekammedis, tgl_rekam_medik, tanggal_lahir, alamat_pasien, tglmasukrak, tglkeluarakhir, tglmasukakhir, printpeminjaman, tgl_pendaftaran, kelengkapandokumen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('warnadokrm_id, warnadokrm_namawarna, warnadokrm_kodewarna, lokasirak_id, lokasirak_nama, nodokumenrm, tglrekammedis, pasien_id, no_rekam_medik, tgl_rekam_medik, nama_pasien, nama_bin, jeniskelamin, tanggal_lahir, alamat_pasien, tempat_lahir, tglmasukrak, statusrekammedis, nomortertier, nomorsekunder, nomorprimer, warnanorm_i, warnanorm_ii, tglkeluarakhir, tglmasukakhir, dokrekammedis_id, ruangan_id, ruangan_nama, no_pendaftaran, instalasi_id, instalasi_nama, pendaftaran_id, subrak_id, subrak_nama, peminjamanrm_id, pengirimanrm_id, printpeminjaman, tgl_pendaftaran, kembalirm_id, kelengkapandokumen, tgl_rekam_medik_akhir, no_rekam_medik_akhir', 'safe', 'on'=>'search'),
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
			'dokumenrekammedis'=>array(self::BELONGS_TO, 'DokrekammedisM', 'dokrekammedis_id'),
			'subrak'=>  array(self::HAS_ONE, 'SubrakM', array('subrak_id'=>'subrak_id'), 'through'=>'dokumenrekammedis'),
			'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			//'peminjaman'=>array(self::HAS_ONE, 'PeminjamanrmT', array('dokrekammedis_id'=>'dokrekammedis_id'), 'through'=>'dokumenrekammedis'),
			'pengiriman'=>array(self::HAS_ONE, 'PengirimanrmT', array('pengirimanrm_id'=>'pengirimanrm_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'warnadokrm_id' => 'ID',
			'warnadokrm_namawarna' => 'Nama Warna Dokumen',
			'warnadokrm_kodewarna' => 'Kode Warna Dokumen',
			'lokasirak_id' => 'Lokasi Rak',
			'lokasirak_nama' => 'Lokasi Rak',
			'nodokumenrm' => 'No. Dokumen RM',
			'tglrekammedis' => 'Tgl. Rekam Medis',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'tempat_lahir' => 'Tempat Lahir',
			'tglmasukrak' => 'Tgl. Masuk Rak',
			'statusrekammedis' => 'Status Rekam Medis',
			'nomortertier' => 'Nomor Tertier',
			'nomorsekunder' => 'Nomor Sekunder',
			'nomorprimer' => 'Nomor Primer',
			'warnanorm_i' => 'Warna No. RM I',
			'warnanorm_ii' => 'Warna No. RM II',
			'tglkeluarakhir' => 'Tgl. Keluar Akhir',
			'tglmasukakhir' => 'Tgl. Masuk Akhir',
			'dokrekammedis_id' => 'Dok. Rekam Medis',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'no_pendaftaran' => 'No. Pendaftaran',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'pendaftaran_id' => 'Pendaftaran',
			'subrak_id' => 'Sub Rak',
			'subrak_nama' => 'Nama Sub Rak',
			'peminjamanrm_id' => 'ID Peminjaman',
			'pengirimanrm_id' => 'ID Pengiriman',
			'printpeminjaman' => 'Print Peminjaman',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'kembalirm_id' => 'ID Kembali',
			'kelengkapandokumen' => 'Kelengkapan Dokumen',
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

		if(!empty($this->warnadokrm_id)){
			$criteria->addCondition('warnadokrm_id = '.$this->warnadokrm_id);
		}
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('LOWER(warnadokrm_kodewarna)',strtolower($this->warnadokrm_kodewarna),true);
		if(!empty($this->lokasirak_id)){
			$criteria->addCondition('lokasirak_id = '.$this->lokasirak_id);
		}
		$criteria->compare('LOWER(lokasirak_nama)',strtolower($this->lokasirak_nama),true);
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('LOWER(tglrekammedis)',strtolower($this->tglrekammedis),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if (!empty($this->ids)) {
			// var_dump('asdasd');die;
			// if (is_array) {
				# code...
			// }
			$criteria->addInCondition('pengirimanrm_id', explode(',',$this->ids));
		}

		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tglmasukrak)',strtolower($this->tglmasukrak),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(nomortertier)',strtolower($this->nomortertier),true);
		$criteria->compare('LOWER(nomorsekunder)',strtolower($this->nomorsekunder),true);
		$criteria->compare('LOWER(nomorprimer)',strtolower($this->nomorprimer),true);
		$criteria->compare('LOWER(warnanorm_i)',strtolower($this->warnanorm_i),true);
		$criteria->compare('LOWER(warnanorm_ii)',strtolower($this->warnanorm_ii),true);
		$criteria->compare('LOWER(tglkeluarakhir)',strtolower($this->tglkeluarakhir),true);
		$criteria->compare('LOWER(tglmasukakhir)',strtolower($this->tglmasukakhir),true);
		if(!empty($this->dokrekammedis_id)){
			$criteria->addCondition('dokrekammedis_id = '.$this->dokrekammedis_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->subrak_id)){
			$criteria->addCondition('subrak_id = '.$this->subrak_id);
		}
		$criteria->compare('LOWER(subrak_nama)',strtolower($this->subrak_nama),true);
		if(!empty($this->peminjamanrm_id)){
			$criteria->addCondition('peminjamanrm_id = '.$this->peminjamanrm_id);
		}
		if(!empty($this->pengirimanrm_id)){
			$criteria->addCondition('pengirimanrm_id = '.$this->pengirimanrm_id);
		}
		$criteria->compare('printpeminjaman',$this->printpeminjaman);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		if(!empty($this->kembalirm_id)){
			$criteria->addCondition('kembalirm_id = '.$this->kembalirm_id);
		}
		$criteria->compare('kelengkapandokumen',$this->kelengkapandokumen);

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
			// var_dump($this->ids);die;
            $criteria=$this->criteriaSearch();
			
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}