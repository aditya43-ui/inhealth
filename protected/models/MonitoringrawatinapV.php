<?php

/**
 * This is the model class for table "monitoringrawatinap_v".
 *
 * The followings are the available columns in table 'monitoringrawatinap_v':
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $no_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property boolean $alihstatus
 * @property string $umur
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property string $tglpulang
 * @property string $kunjungan
 * @property boolean $statuskeluar
 * @property boolean $rawatgabung
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property string $tglmasukkamar
 * @property string $nomasukkamar
 * @property string $jammasukkamar
 * @property string $tglkeluarkamar
 * @property string $jamkeluarkamar
 * @property integer $pasienbatalperiksa_id
 * @property integer $pasienpulang_id
 * @property string $tglpasienpulang
 * @property string $carakeluar
 * @property string $kondisipulang
 */
class MonitoringrawatinapV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $cekTanggalAdmisi;
        public $pegawai_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringrawatinapV the static model class
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
		return 'monitoringrawatinap_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, carabayar_id, penjamin_id, caramasuk_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pasienadmisi_id, kamarruangan_id, pasienbatalperiksa_id, pasienpulang_id', 'numerical', 'integerOnly'=>true),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, statusperiksa, statuspasien, carabayar_nama, penjamin_nama, caramasuk_nama, ruangan_nama, instalasi_nama, kelaspelayanan_nama, kunjungan, nomasukkamar, carakeluar, kondisipulang', 'length', 'max'=>50),
			array('nama_bin, umur', 'length', 'max'=>30),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik, kamarruangan_nokamar, kamarruangan_nobed', 'length', 'max'=>10),
			array('tgl_pendaftaran, alihstatus, tgladmisi, tglpulang, statuskeluar, rawatgabung, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglmasukkamar, jammasukkamar, tglkeluarkamar, jamkeluarkamar, tglpasienpulang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cekTanggalAdmisi, pasien_id, namadepan, nama_pasien, nama_bin, jeniskelamin, photopasien, alamatemail, statusrekammedis, no_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, statusperiksa, statuspasien, alihstatus, umur, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, pasienadmisi_id, tgladmisi, tglpulang, kunjungan, statuskeluar, rawatgabung, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed, tglmasukkamar, nomasukkamar, jammasukkamar, tglkeluarkamar, jamkeluarkamar, pasienbatalperiksa_id, pasienpulang_id, tglpasienpulang, carakeluar, kondisipulang', 'safe', 'on'=>'search'),
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
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'statusperiksa' => 'Status periksa',
			'statuspasien' => 'Statuspasien',
			'alihstatus' => 'Alihstatus',
			'umur' => 'Umur',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'caramasuk_id' => 'Caramasuk',
			'caramasuk_nama' => 'Caramasuk Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskasuspenyakit_id' => 'Jenis kasus penyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgladmisi' => 'Tgladmisi',
			'tglpulang' => 'Tglpulang',
			'kunjungan' => 'Kunjungan',
			'statuskeluar' => 'Statuskeluar',
			'rawatgabung' => 'Rawatgabung',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'tglmasukkamar' => 'Tglmasukkamar',
			'nomasukkamar' => 'Nomasukkamar',
			'jammasukkamar' => 'Jammasukkamar',
			'tglkeluarkamar' => 'Tglkeluarkamar',
			'jamkeluarkamar' => 'Jamkeluarkamar',
			'pasienbatalperiksa_id' => 'Pasienbatalperiksa',
			'pasienpulang_id' => 'Pasienpulang',
			'tglpasienpulang' => 'Tglpasienpulang',
			'carakeluar' => 'Cara pulang',
			'kondisipulang' => 'Kondisi pulang',
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
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('statuskeluar',$this->statuskeluar);
		$criteria->compare('rawatgabung',$this->rawatgabung);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->compare('pasienbatalperiksa_id',$this->pasienbatalperiksa_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);

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
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('statuskeluar',$this->statuskeluar);
		$criteria->compare('rawatgabung',$this->rawatgabung);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->compare('pasienbatalperiksa_id',$this->pasienbatalperiksa_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
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
                $criteria->join = 'JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id';
                $criteria->order = 't.tgladmisi DESC';
                if ($this->cekTanggalAdmisi){
                    $criteria->addBetweenCondition('DATE(t.tgladmisi)',$this->tgl_awal,$this->tgl_akhir);
                }
                $criteria->compare('t.tglmasukkamar',$this->tglmasukkamar);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.arakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(t.kondisipulang)',strtolower($this->kondisipulang),true);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
                $criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('t.ruangan_id',$this->ruangan_id);
                $criteria->compare('p.pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}