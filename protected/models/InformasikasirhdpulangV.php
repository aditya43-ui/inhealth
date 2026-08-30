<?php

/**
 * This is the model class for table "informasikasirhdpulang_v".
 *
 * The followings are the available columns in table 'informasikasirhdpulang_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $shift_id
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $pasienpulang_id
 * @property integer $pembayaranpelayanan_id
 * @property string $namaperusahaan
 * @property string $tglselesaiperiksa
 * @property string $tglpasienpulang
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property string $satuanlamarawat
 * @property integer $carakeluar_id
 * @property string $carakeluar
 * @property integer $kondisikeluar_id
 * @property string $kondisipulang
 * @property string $nopeserta
 * @property string $tglcetakkartuasuransi
 * @property string $kodefeskestk1
 * @property string $nama_feskestk1
 * @property string $masaberlakukartu
 * @property string $nokartukeluarga
 * @property string $nopassport
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property boolean $asuransipasien_aktif
 * @property boolean $statusfarmasi
 */
class InformasikasirhdpulangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikasirhdpulangV the static model class
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
		return 'informasikasirhdpulang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, shift_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pasienpulang_id, pembayaranpelayanan_id, lamarawat, carakeluar_id, kondisikeluar_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max'=>30),
			array('nama_pasien, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, penjamin_nama, pengantar, hubungankeluarga, nama_pj, ruangan_nama, instalasi_nama, kelaspelayanan_nama, nama_pegawai, namaperusahaan, satuanlamarawat, nopeserta, kodefeskestk1, status_konfirmasi', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien, nama_feskestk1, nopassport', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama, penerimapasien, carakeluar, kondisipulang, nokartukeluarga', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tglselesaiperiksa, tglpasienpulang, tglcetakkartuasuransi, masaberlakukartu, tgl_konfirmasi, asuransipasien_aktif, statusfarmasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, shift_id, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardepan, nama_pegawai, gelarbelakang_nama, pasienpulang_id, pembayaranpelayanan_id, namaperusahaan, tglselesaiperiksa, tglpasienpulang, penerimapasien, lamarawat, satuanlamarawat, carakeluar_id, carakeluar, kondisikeluar_id, kondisipulang, nopeserta, tglcetakkartuasuransi, kodefeskestk1, nama_feskestk1, masaberlakukartu, nokartukeluarga, nopassport, status_konfirmasi, tgl_konfirmasi, asuransipasien_aktif, statusfarmasi', 'safe', 'on'=>'search'),
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
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'statusperkawinan' => 'Statusperkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'pendaftaran_id' => 'Pendaftaran',
			'pekerjaan_id' => 'Pekerjaan',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_urutantri' => 'No Urutantri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaanmasuk',
			'statusperiksa' => 'Status Periksa',
			'statuspasien' => 'Statuspasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjunganrumah',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No. Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'shift_id' => 'Shift',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungankeluarga',
			'nama_pj' => 'Nama Pj',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'pasienpulang_id' => 'Pasienpulang',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'namaperusahaan' => 'Namaperusahaan',
			'tglselesaiperiksa' => 'Tglselesaiperiksa',
			'tglpasienpulang' => 'Tglpasienpulang',
			'penerimapasien' => 'Penerimapasien',
			'lamarawat' => 'Lamarawat',
			'satuanlamarawat' => 'Satuanlamarawat',
			'carakeluar_id' => 'Carakeluar',
			'carakeluar' => 'Carakeluar',
			'kondisikeluar_id' => 'Kondisikeluar',
			'kondisipulang' => 'Kondisipulang',
			'nopeserta' => 'Nopeserta',
			'tglcetakkartuasuransi' => 'Tglcetakkartuasuransi',
			'kodefeskestk1' => 'Kodefeskestk1',
			'nama_feskestk1' => 'Nama Feskestk1',
			'masaberlakukartu' => 'Masaberlakukartu',
			'nokartukeluarga' => 'Nokartukeluarga',
			'nopassport' => 'Nopassport',
			'status_konfirmasi' => 'Status Konfirmasi',
			'tgl_konfirmasi' => 'Tgl. Konfirmasi',
			'asuransipasien_aktif' => 'Asuransipasien Aktif',
			'statusfarmasi' => 'Statusfarmasi',
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

		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id = '.$this->pekerjaan_id);
		}
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('penanggungjawab_id = '.$this->penanggungjawab_id);
		}
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition('pasienpulang_id = '.$this->pasienpulang_id);
		}
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(tglselesaiperiksa)',strtolower($this->tglselesaiperiksa),true);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		if(!empty($this->lamarawat)){
			$criteria->addCondition('lamarawat = '.$this->lamarawat);
		}
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
		if(!empty($this->carakeluar_id)){
			$criteria->addCondition('carakeluar_id = '.$this->carakeluar_id);
		}
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		if(!empty($this->kondisikeluar_id)){
			$criteria->addCondition('kondisikeluar_id = '.$this->kondisikeluar_id);
		}
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(nopeserta)',strtolower($this->nopeserta),true);
		$criteria->compare('LOWER(tglcetakkartuasuransi)',strtolower($this->tglcetakkartuasuransi),true);
		$criteria->compare('LOWER(kodefeskestk1)',strtolower($this->kodefeskestk1),true);
		$criteria->compare('LOWER(nama_feskestk1)',strtolower($this->nama_feskestk1),true);
		$criteria->compare('LOWER(masaberlakukartu)',strtolower($this->masaberlakukartu),true);
		$criteria->compare('LOWER(nokartukeluarga)',strtolower($this->nokartukeluarga),true);
		$criteria->compare('LOWER(nopassport)',strtolower($this->nopassport),true);
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);
		$criteria->compare('statusfarmasi',$this->statusfarmasi);

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