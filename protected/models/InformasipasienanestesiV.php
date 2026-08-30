<?php

/**
 * This is the model class for table "informasipasienanestesi_v".
 *
 * The followings are the available columns in table 'informasipasienanestesi_v':
 * @property integer $pasienanastesi_id
 * @property string $tglanastesi
 * @property string $noanestesi
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property string $umur
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $pasienmasukpenunjang_id
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $statusanestesi
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $gelardepan
 */
class InformasipasienanestesiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipasienanestesiV the static model class
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
		return 'informasipasienanestesi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienanastesi_id, pasien_id, pendaftaran_id, jeniskasuspenyakit_id, pasienmasukpenunjang_id, carabayar_id, penjamin_id, pegawai_id, gelarbelakang_id, pekerjaan_id, kelaspelayanan_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('noanestesi, jeniskelamin, statusanestesi, no_pendaftaran, no_masukpenunjang', 'length', 'max'=>20),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('nama_pasien, carabayar_nama, penjamin_nama, nama_pegawai, pekerjaan_nama, kelaspelayanan_nama, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tglanastesi, alamat_pasien, tgl_pendaftaran, tglmasukpenunjang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienanastesi_id, tglanastesi, noanestesi, pasien_id, no_rekam_medik, nama_pasien, jeniskelamin, alamat_pasien, pendaftaran_id, umur, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, pasienmasukpenunjang_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, statusanestesi, no_pendaftaran, tgl_pendaftaran, no_masukpenunjang, tglmasukpenunjang, pegawai_id, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, pekerjaan_id, pekerjaan_nama, kelaspelayanan_id, kelaspelayanan_nama, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, gelardepan', 'safe', 'on'=>'search'),
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
			'pasienanastesi_id' => 'Pasien Anestesi',
			'tglanastesi' => 'Tanggal Anestesi',
			'noanestesi' => 'No. Anestesi',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'umur' => 'Umur',
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'statusanestesi' => 'Status Anestesi',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_masukpenunjang' => 'No. Masuk Penunjang',
			'tglmasukpenunjang' => 'Tgl. Masuk Penunjang',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelar Belakang',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'pekerjaan_id' => 'Pekerjaan',
			'pekerjaan_nama' => 'Pekerjaan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'gelardepan' => 'Gelar Depan',
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

		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		$criteria->compare('LOWER(tglanastesi)',strtolower($this->tglanastesi),true);
		$criteria->compare('LOWER(noanestesi)',strtolower($this->noanestesi),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(statusanestesi)',strtolower($this->statusanestesi),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		//$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
		}
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id = '.$this->pekerjaan_id);
		}
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);

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