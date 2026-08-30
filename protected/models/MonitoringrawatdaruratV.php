<?php

/**
 * This is the model class for table "monitoringrawatdarurat_v".
 *
 * The followings are the available columns in table 'monitoringrawatdarurat_v':
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $no_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property string $umur
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $pembayaranpelayanan_id
 * @property boolean $alihstatus
 * @property integer $pasienpulang_id
 * @property string $carakeluar
 * @property string $kondisipulang
 * @property integer $pasienbatalperiksa_id
 */
class MonitoringrawatdaruratV extends CActiveRecord
{
                public $tgl_awal;
                public $tgl_akhir;
                public $tgl_awaladmisi;
                public $tgl_akhiradmisi;
                public $pegawai_id, $ruangantujuan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringrawatdaruratV the static model class
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
		return 'monitoringrawatdarurat_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, carabayar_id, penjamin_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pembayaranpelayanan_id, pasienpulang_id, pasienbatalperiksa_id', 'numerical', 'integerOnly'=>true),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, statusperiksa, statuspasien, kunjungan, carabayar_nama, penjamin_nama, ruangan_nama, instalasi_nama, kelaspelayanan_nama, carakeluar_id, kondisipulang', 'length', 'max'=>50),
			array('nama_bin, umur', 'length', 'max'=>30),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('tgl_pendaftaran, alihstatus', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, namadepan, nama_pasien, nama_bin, jeniskelamin, no_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statusperiksa, statuspasien, kunjungan, umur, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, pembayaranpelayanan_id, alihstatus, pasienpulang_id, carakeluar, kondisipulang, pasienbatalperiksa_id', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_urutantri' => 'No. Urutantri',
			'statusperiksa' => 'Status periksa',
			'statuspasien' => 'Statuspasien',
			'kunjungan' => 'Kunjungan',
			'umur' => 'Umur',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskasuspenyakit_id' => 'Jenis kasus penyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'alihstatus' => 'Alihstatus',
			'pasienpulang_id' => 'Pasienpulang',
			'carakeluar' => 'Cara keluar',
                        'carakeluar_id' => 'Cara keluar',
			'kondisipulang' => 'Kondisi pulang',
			'pasienbatalperiksa_id' => 'Pasienbatalperiksa',
                        'pegawai_id' => 'Dokter',
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
               
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('pasienbatalperiksa_id',$this->pasienbatalperiksa_id);
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('pasienbatalperiksa_id',$this->pasienbatalperiksa_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
	public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = 'JOIN pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id'
									. ' LEFT JOIN pemindahanpasien_t ppt ON ppt.pendaftaran_id = t.pendaftaran_id';
                $criteria->order = 't.tgl_pendaftaran DESC';
		$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(t.kondisipulang)',strtolower($this->kondisipulang),true);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
                $criteria->compare('t.carakeluar_id',$this->carakeluar_id);
                $criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('p.pegawai_id', $this->pegawai_id);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getJeniskasuspenyakitItems() {
            return JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
        }
}