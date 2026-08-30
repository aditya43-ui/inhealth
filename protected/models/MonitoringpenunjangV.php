<?php

/**
 * This is the model class for table "monitoringpenunjang_v".
 *
 * The followings are the available columns in table 'monitoringpenunjang_v':
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
 * @property integer $pasienbatalperiksa_id
 */
class MonitoringpenunjangV extends CActiveRecord
{   
        public $tgl_awal;
        public $tgl_akhir;
        public $nama_dokter;
        public $pegawai_id;
        public $propinsi_id;
        public $kabupaten_id;
        public $statusmasuk;
        public $alamat_pasien;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringpenunjangV the static model class
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
		return 'monitoringpenunjang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, carabayar_id, penjamin_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pembayaranpelayanan_id, pasienbatalperiksa_id', 'numerical', 'integerOnly'=>true),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, nama_bin, statusperiksa, statuspasien, kunjungan, carabayar_nama, penjamin_nama, ruangan_nama, instalasi_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('umur', 'length', 'max'=>30),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('tgl_pendaftaran, tgl_awal, tgl_akhir, nama_dokter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienmasukpenunjang_id,pasien_id, namadepan, nama_pasien, nama_bin, jeniskelamin, no_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statusperiksa, statuspasien, kunjungan, umur, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, pembayaranpelayanan_id, pasienbatalperiksa_id', 'safe', 'on'=>'search'),
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
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_urutantri' => 'No Urut Antri',
			'statusperiksa' => 'Status Periksa',
			'statuspasien' => 'Status Pasien',
			'kunjungan' => 'Kunjungan',
			'umur' => 'Umur',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'pembayaranpelayanan_id' => 'Pembayaran Pelayanan',
			'pasienbatalperiksa_id' => 'Pasien Batal Periksa',
                        'pegawai_id' => 'Dokter'
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
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_urutantri',$this->no_urutantri,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('pasienbatalperiksa_id',$this->pasienbatalperiksa_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchTable()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->join = 'JOIN pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id';
                $criteria->order = 't.tgl_pendaftaran DESC';
                $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('t.jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
                $criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('t.ruangan_id',$this->ruangan_id);
                $criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
                $criteria->compare('p.pegawai_id', $this->pegawai_id);
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
        public function getJeniskasuspenyakitItems() {
            return JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
        }                
        
        public static function getStatusAutoRefresh(){
            return MonitoringpenunjangV::model()->find()->autorefresh;
	}
        
        
}