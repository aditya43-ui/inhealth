<?php

/**
 * This is the model class for table "peminjamandokumenrm_v".
 *
 * The followings are the available columns in table 'peminjamandokumenrm_v':
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
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $peminjamanrm_id
 * @property integer $pengirimanrm_id
 * @property integer $kembalirm_id
 */
class PeminjamandokumenrmV extends CActiveRecord
{
        public $tgl_rekam_medik_akhir; 
        public $no_rekam_medik_akhir; 
        public $tgl_rekam_medik;
        public $tglpeminjamanrm_akhir;
        public $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeminjamandokumenrmV the static model class
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
		return 'peminjamandokumenrm_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warnadokrm_id, lokasirak_id, pasien_id, dokrekammedis_id, ruangan_id, pendaftaran_id, peminjamanrm_id, pengirimanrm_id, kembalirm_id', 'numerical', 'integerOnly'=>true),
			array('warnadokrm_namawarna, warnadokrm_kodewarna, nodokumenrm, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('lokasirak_nama, namapeminjam', 'length', 'max'=>100),
			array('no_rekam_medik, statusrekammedis', 'length', 'max'=>10),
			array('nama_pasien, warnanorm_i, warnanorm_ii, untukkepentingan, ruangan_nama', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('nomortertier, nomorsekunder, nomorprimer', 'length', 'max'=>2),
			array('nourut_pinjam', 'length', 'max'=>5),
			array('tglpeminjamanrm_akhir, tglrekammedis, tgl_rekam_medik, tanggal_lahir, alamat_pasien, tglmasukrak, tglkeluarakhir, tglmasukakhir, tglpeminjamanrm, keteranganpeminjaman, tglakandikembalikan, printpeminjaman, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglpeminjamanrm_akhir, instalasi_id, tgl_rekam_medik_akhir, no_rekam_medik_akhir, warnadokrm_id, warnadokrm_namawarna, warnadokrm_kodewarna, lokasirak_id, lokasirak_nama, nodokumenrm, tglrekammedis, pasien_id, no_rekam_medik, tgl_rekam_medik, nama_pasien, nama_bin, jeniskelamin, tanggal_lahir, alamat_pasien, tempat_lahir, tglmasukrak, statusrekammedis, nomortertier, nomorsekunder, nomorprimer, warnanorm_i, warnanorm_ii, tglkeluarakhir, tglmasukakhir, dokrekammedis_id, nourut_pinjam, tglpeminjamanrm, untukkepentingan, keteranganpeminjaman, tglakandikembalikan, namapeminjam, printpeminjaman, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ruangan_id, ruangan_nama, pendaftaran_id, no_pendaftaran, peminjamanrm_id, pengirimanrm_id, kembalirm_id', 'safe', 'on'=>'search'),
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
                    'peminjaman'=>  array(self::BELONGS_TO, 'PeminjamanrmT', 'peminjamanrm_id'),
                    'pengiriman'=>array(self::BELONGS_TO, 'PengirimanrmT', 'pengirimanrm_id'),
                    'instalasi'=>array(self::HAS_ONE, 'InstalasiM', array('instalasi_id'=>'instalasi_id'), 'through'=>'pendaftaran'),
                    
                    //'peminjaman'=>array(self::HAS_ONE, 'PeminjamanrmT', array('dokrekammedis_id'=>'dokrekammedis_id'), 'through'=>'dokumenrekammedis')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'warnadokrm_id' => 'Warna Dokumen',
			'warnadokrm_namawarna' => 'Nama Warna Dokumen',
			'warnadokrm_kodewarna' => 'Kode Warna Dokumen',
			'lokasirak_id' => 'Lokasi Rak',
			'lokasirak_nama' => 'Lokasi Rak Nama',
			'nodokumenrm' => 'No. Dokumen',
			'tglrekammedis' => 'Tanggal Rekam Medis',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medis',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'tempat_lahir' => 'Tempat Lahir',
			'tglmasukrak' => 'Tanggal Masuk Rak',
			'statusrekammedis' => 'Status Rekam Medis',
			'nomortertier' => 'Nomor Tertier',
			'nomorsekunder' => 'Nomor Sekunder',
			'nomorprimer' => 'Nomor Primer',
			'warnanorm_i' => 'Warna Norm I',
			'warnanorm_ii' => 'Warna Norm Ii',
			'tglkeluarakhir' => 'Tanggal Keluar Akhir',
			'tglmasukakhir' => 'Tanggal Masuk Akhir',
			'dokrekammedis_id' => 'Dokrekammedis',
			'nourut_pinjam' => 'Nourut Pinjam',
			'tglpeminjamanrm' => 'Tanggal Peminjaman RM',
			'untukkepentingan' => 'Untuk Kepentingan',
			'keteranganpeminjaman' => 'Keterangan Peminjaman',
			'tglakandikembalikan' => 'Tanggal Akan Dikembalikan',
			'namapeminjam' => 'Nama Peminjam',
			'printpeminjaman' => 'Print Peminjaman',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Nama Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'peminjamanrm_id' => 'Peminjamanrm',
			'pengirimanrm_id' => 'Pengirimanrm',
			'kembalirm_id' => 'Kembalirm',
                        'instalasi_id'=>'Instalasi',
                        'instalasi_nama'=>'Nama Instalasi'
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

		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('LOWER(warnadokrm_kodewarna)',strtolower($this->warnadokrm_kodewarna),true);
		$criteria->compare('lokasirak_id',$this->lokasirak_id);
		$criteria->compare('LOWER(lokasirak_nama)',strtolower($this->lokasirak_nama),true);
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('LOWER(tglrekammedis)',strtolower($this->tglrekammedis),true);
		$criteria->compare('pasien_id',$this->pasien_id);
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
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
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
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('kembalirm_id',$this->kembalirm_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('LOWER(warnadokrm_kodewarna)',strtolower($this->warnadokrm_kodewarna),true);
		$criteria->compare('lokasirak_id',$this->lokasirak_id);
		$criteria->compare('LOWER(lokasirak_nama)',strtolower($this->lokasirak_nama),true);
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('LOWER(tglrekammedis)',strtolower($this->tglrekammedis),true);
		$criteria->compare('pasien_id',$this->pasien_id);
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
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
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
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('kembalirm_id',$this->kembalirm_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function primaryKey() {
            return 'pendaftaran_id';
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                     else if ($column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }    
            }

            return parent::beforeValidate ();
        }

//        public function beforeSave() {         
//            if($this->tglpengirimanrm===null || trim($this->tglpengirimanrm)==''){
//	        $this->setAttribute('tglpengirimanrm', null);
//            }
//            
//            return parent::beforeSave();
//        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
}