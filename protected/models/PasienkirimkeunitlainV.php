<?php

/**
 * This is the model class for table "pasienkirimkeunitlain_v".
 *
 * The followings are the available columns in table 'pasienkirimkeunitlain_v':
 * @property integer $pasienkirimkeunitlain_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $tgl_kirimpasien
 * @property string $nourut
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $kelaspelayanan_id
* @property string $kelaspelayanan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $catatandokterpengirim
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property integer $permintaankepenunjang_id
 * @property integer $pemeriksaanlab_id
 * @property string $pemeriksaanlab_nama
 * @property integer $daftartindakanlab_id
 * @property integer $pemeriksaanrad_id
 * @property string $pemeriksaanrad_nama
 * @property integer $daftartindakanrad_id
 * @property integer $qtypermintaan
 * @property string $noperminatanpenujang
 * @property string $tglpermintaankepenunjang
 * @property string $diagnosa_nama 
 */
class PasienkirimkeunitlainV extends CActiveRecord
{
        public $cbTglMasuk = false;
        public $prefix_pendaftaran;
        public $namaDokter;
        public $pasienadmisi_id;
        public $statusperiksa;
	public $respondtime;
	public $ppds_id;
	public $ppds_nama;
		public $pasienanastesi_id;
        public $pekerjaan_id, $pekerjaan_nama;
		public $tgl_rencana_awal, $tgl_rencana_akhir;
		public $isPilihTglRencana;
		public $ceklis, $tgl_jadwalpemeriksaan, $tgl_jadwalpemeriksaanawal, $tgl_jadwalpemeriksaanakhir, $ceklisJadwal = false, $dokterperujuk;

//	  public $tgl_awal;
//      public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkirimkeunitlainV the static model class
	 */
    
        public $permintaankepenunjang_id,$pemeriksaanlab_id,$pemeriksaanlab_nama,$daftartindakanlab_id,$pemeriksaanrad_id,
               $pemeriksaanrad_nama,$daftartindakanrad_id,$qtypermintaan,$noperminatanpenujang,$tglpermintaankepenunjang,$umur, $instalasi_ruangan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pasienkirimkeunitlain_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienkirimkeunitlain_id, pendaftaran_id, jeniskasuspenyakit_id, carabayar_id, penjamin_id, kelaspelayanan_id, pegawai_id, gelarbelakang_id, ruanganasal_id, instalasiasal_id, ruangan_id, instalasi_id, pasienmasukpenunjang_id, permintaankepenunjang_id, pemeriksaanlab_id, daftartindakanlab_id, pemeriksaanrad_id, daftartindakanrad_id, qtypermintaan', 'numerical', 'integerOnly'=>true),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, agama, rhesus, no_pendaftaran, pemeriksaanrad_nama', 'length', 'max'=>20),
			array('nama_pasien, carabayar_nama, penjamin_nama, kelaspelayanan_nama, nama_pegawai, ruanganasal_nama, instalasiasal_nama, ruangan_nama, noperminatanpenujang', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('nourut', 'length', 'max'=>3),
			array('jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('pemeriksaanlab_nama', 'length', 'max'=>40),
			array('tanggal_lahir, alamat_pasien, tgl_kirimpasien, tgl_pendaftaran, catatandokterpengirim, create_time, create_loginpemakai_id, tglpermintaankepenunjang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal,tgl_akhir,pasienkirimkeunitlain_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, agama, golongandarah, rhesus, tgl_awal, tgl_akhir, tgl_kirimpasien, nourut, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, kelaspelayanan_id, kelaspelayanan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, catatandokterpengirim, ruanganasal_id, ruanganasal_nama, instalasiasal_id, instalasiasal_nama, ruangan_id, ruangan_nama, instalasi_id, pasienmasukpenunjang_id, create_time, create_loginpemakai_id, permintaankepenunjang_id, pemeriksaanlab_id, pemeriksaanlab_nama, daftartindakanlab_id, pemeriksaanrad_id, pemeriksaanrad_nama, daftartindakanrad_id, qtypermintaan, noperminatanpenujang, tglpermintaankepenunjang, instalasi_ruangan, diagnosa_nama, is_cyto, kamarruangan_nokamar, kamarruangan_nobed', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::BELONGS_TO,  'PendaftaranT','pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'tgl_kirimpasien' => 'Tanggal Rencana Operasi',
			'nourut' => 'Nourut',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Nama Kelaspelayanan',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'catatandokterpengirim' => 'Catatandokterpengirim',
			'ruanganasal_id' => 'Ruangan',
			'ruanganasal_nama' => 'Ruangan Asal',
			'instalasiasal_id' => 'Instalasi',
			'instalasiasal_nama' => 'Instalasi Asal',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'permintaankepenunjang_id' => 'Permintaankepenunjang',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pemeriksaanlab_nama' => 'Pemeriksaanlab Nama',
			'daftartindakanlab_id' => 'Daftartindakanlab',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'pemeriksaanrad_nama' => 'Pemeriksaan',
			'daftartindakanrad_id' => 'Daftartindakanrad',
			'qtypermintaan' => 'Qtypermintaan',
			'noperminatanpenujang' => 'Noperminatanpenujang',
			'tglpermintaankepenunjang' => 'Tglpermintaankepenunjang',
			'diagnosa_nama' => 'Diagnosa Nama',
			'tglrencanapemeriksaan' => 'Tgl. Rencana Pemeriksaan'
		);
	}

        public $tgl_awal;
        public $tgl_akhir;
		public function searchRujukRad() {
			$criteria = new CDbCriteria();
			$criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
			$criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
			$criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);
			$criteria->compare('lower(t.nama_pegawai)', strtolower($this->namaDokter), true);
			$criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
			$criteria->compare('t.instalasiasal_id', $this->instalasiasal_id);
			$criteria->compare('t.ruanganasal_id', $this->ruanganasal_id);
			$criteria->compare('t.carabayar_id', $this->carabayar_id);
			$criteria->compare('t.penjamin_id', $this->penjamin_id);
			if ($this->isPilihTglRencana == 1){
				if (!empty($this->tgl_rencana_awal) && !empty($this->tgl_rencana_akhir)) {
					$criteria->addBetweenCondition('t.tglrencanapemeriksaan::date', $this->tgl_rencana_awal, $this->tgl_rencana_akhir);
				}
			}else{
				if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
					$criteria->addBetweenCondition('t.tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
				}
			}
			$criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
			$criteria->select = " t.*, p.statusperiksa ";
			$criteria->addCondition('p.pasienbatalperiksa_id is null');
			$criteria->addCondition('t.instalasi_id = ' . Yii::app()->user->getState('instalasi_id'));
			if (!empty($this->statusperiksa)) {
				$criteria->addCondition(" p.statusperiksa ilike '" . strtolower($this->statusperiksa) . "' ");
			}
			$criteria->order = 'is_cyto DESC, t.tgl_kirimpasien DESC';
	
			return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
			));
		}
        
        public function searchRujukRehab() {
            $criteria = new CDbCriteria();
            $criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);
            // $criteria->compare('t.ruangan_id', Params::RUANGAN_ID_REHABMEDIS);
			// jika ingin menambahkan kondisi ruangan_id misal ingin banyak
            Params::setRuangIdRehab([Yii::app()->user->getState('ruangan_id')]);
			$criteria->addInCondition('t.ruangan_id', Params::$ruangan_id_rehab);
			if($this->ceklis == 1)
			{
				$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			} else {
				$criteria->addBetweenCondition('DATE(t.tgl_kirimpasien)', $this->tgl_awal, $this->tgl_akhir);
			}
            $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
            $criteria->addCondition('p.pasienbatalperiksa_id is null');
            $criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
            $criteria->compare('t.ruanganasal_id', $this->ruanganasal_id);
            $criteria->compare('t.instalasiasal_id', $this->instalasiasal_id);
            $criteria->compare('t.carabayar_id', $this->carabayar_id);
            $criteria->compare('t.penjamin_id', $this->penjamin_id);
			$criteria->compare('t.pasien_id', $this->pasien_id, true);
            $criteria->order='t.tgl_kirimpasien DESC';
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

		public function searchRujukTindakan() {
            $criteria = new CDbCriteria();
            $criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);
			if(!empty($this->ruangan_id)) {
				$criteria->addCondition('t.ruangan_id='.$this->ruangan_id);
			}
			
			if($this->ceklisJadwal) {
				$criteria->addBetweenCondition('DATE(t.tgl_jadwalpemeriksaan)', $this->tgl_jadwalpemeriksaanawal, $this->tgl_jadwalpemeriksaanakhir);
			} else {
				if($this->ceklis == 1)
				{
					$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
				} else {
					$criteria->addBetweenCondition('DATE(t.tgl_kirimpasien)', $this->tgl_awal, $this->tgl_akhir);
				}
			}
            $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id
								join ruangan_m rm on rm.ruangan_id = t.ruangan_id
			";
           
            $criteria->addCondition('p.pasienbatalperiksa_id is null');
            $criteria->addCondition('rm.is_tindakan=' . 'true');
            // $criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
            $criteria->compare('t.ruanganasal_id', $this->ruanganasal_id);
            $criteria->compare('t.instalasiasal_id', $this->instalasiasal_id);

			$criteria->compare('t.ruangan_id', $this->ruangan_id);
            $criteria->compare('t.instalasi_id', $this->instalasi_id);

            $criteria->compare('t.carabayar_id', $this->carabayar_id);
            $criteria->compare('t.penjamin_id', $this->penjamin_id);
			$criteria->compare('t.pasien_id', $this->pasien_id, true);
            $criteria->order='t.tgl_kirimpasien DESC';
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }


		
        
        public function searchRujukBedah() {
            $criteria = new CDbCriteria();
            $criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);
			$criteria->compare('lower(t.pasien_id)', strtolower($this->pasien_id), true);
            // $criteria->compare('t.ruangan_id', Params::RUANGAN_ID_BEDAH);
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
            }
            $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
			$criteria->select = " t.*,p.statusperiksa ";
            $criteria->addCondition('p.pasienbatalperiksa_id is null');
			$criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            // $criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
            $criteria->compare('t.ruanganasal_id', $this->ruanganasal_id);
            $criteria->compare('t.instalasiasal_id', $this->instalasiasal_id);
            $criteria->compare('t.carabayar_id', $this->carabayar_id);
            $criteria->compare('t.penjamin_id', $this->penjamin_id);
			$criteria->compare('t.pasien_id', $this->pasien_id, true);
			if (!empty($this->statusperiksa)){
				$criteria->addCondition(" p.statusperiksa ilike '".strtolower($this->statusperiksa)."' ");
			}

			$criteria->compare('lower(t.nama_pegawai)', strtolower($this->nama_pegawai), true);

            $criteria->order='t.tgl_kirimpasien DESC';
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
		
        public function searchInformasiPasienOperasi() {
            $criteria = new CDbCriteria();
            $criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);
			$criteria->compare('lower(t.pasien_id)', strtolower($this->pasien_id), true);
            // $criteria->compare('t.ruangan_id', Params::RUANGAN_ID_BEDAH);
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('t.tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
            }
            $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
			$criteria->select = " t.*,p.statusperiksa ";
            $criteria->addCondition('p.pasienbatalperiksa_id is null');
			// $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            // $criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
            $criteria->compare('t.ruanganasal_id', $this->ruanganasal_id);
            $criteria->compare('t.instalasiasal_id', $this->instalasiasal_id);
            $criteria->compare('t.carabayar_id', $this->carabayar_id);
            $criteria->compare('t.penjamin_id', $this->penjamin_id);
			$criteria->compare('t.pasien_id', $this->pasien_id, true);
			if (!empty($this->statusperiksa)){
				$criteria->addCondition(" p.statusperiksa ilike '".strtolower($this->statusperiksa)."' ");
			}

			$criteria->compare('lower(t.nama_pegawai)', strtolower($this->nama_pegawai), true);

            $criteria->order='t.tgl_kirimpasien DESC';
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
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

		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.pasien_id', $this->pasien_id, true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);

		//$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);

			if ($this->cbTglMasuk){
	                    $criteria->addCondition('date(tgl_pendaftaran) BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
	                }

		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('instalasiasal_id',$this->instalasiasal_id);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('permintaankepenunjang_id',$this->permintaankepenunjang_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		$criteria->compare('daftartindakanlab_id',$this->daftartindakanlab_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		$criteria->compare('daftartindakanrad_id',$this->daftartindakanrad_id);
		$criteria->compare('qtypermintaan',$this->qtypermintaan);
		$criteria->compare('LOWER(noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
		$criteria->compare('LOWER(tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);
		$criteria->compare('LOWER(is_cyto)',strtolower($this->is_cyto),true);
		$criteria->compare('LOWER(kamarruangan_nokamar)', strtolower($this->kamarruangan_nokamar), true);
        $criteria->compare('LOWER(kamarruangan_nobed)', strtolower($this->kamarruangan_nobed), true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('instalasiasal_id',$this->instalasiasal_id);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('permintaankepenunjang_id',$this->permintaankepenunjang_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		$criteria->compare('daftartindakanlab_id',$this->daftartindakanlab_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		$criteria->compare('daftartindakanrad_id',$this->daftartindakanrad_id);
		$criteria->compare('qtypermintaan',$this->qtypermintaan);
		$criteria->compare('LOWER(noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
		$criteria->compare('LOWER(tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);
		$criteria->compare('t.pasien_id', $this->pasien_id, true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
        
        function getCarabayarPenjaminNama()
        {
            return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        function getNamaPasienNamaBin()
        {
           if (!empty($this->nama_bin)) {
        		return $this->nama_pasien.' alias '.$this->nama_bin;
        	} else {
       			return $this->nama_pasien;
        	}  
        }
        
        function getInstalasiNamaRuanganNama()
        {
            return $this->instalasiasal_nama.' / '.$this->ruanganasal_nama;
        }
		
		function getNamaLengkap(){
			return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
		}
                
    /**
     * Filter pada informasi pasien rujukan anestesi
     * @return \CActiveDataProvider
     */
    public function searchRujukAnestesi() {
        $criteria = new CDbCriteria();
        $criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);  
		$criteria->compare('t.pasien_id', $this->pasien_id, true);     
        $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
                .        "JOIN ruangananestesi_v ra on ra.ruangan_id = t.ruangan_id";
                    $criteria->select = " t.*,p.statusperiksa ";

		if ($this->isPilihTglRencana == 1){
			if (!empty($this->tgl_rencana_awal) && !empty($this->tgl_rencana_akhir)) {
				$criteria->addBetweenCondition('t.tglrencanapemeriksaan::date', $this->tgl_rencana_awal, $this->tgl_rencana_akhir);
			}
		}else{
			if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
				$criteria->addBetweenCondition('t.tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
			}
		}
        $criteria->addCondition('p.pasienbatalperiksa_id is null');
        $criteria->compare('t.ruanganasal_id', $this->ruanganasal_id);
        $criteria->compare('t.instalasiasal_id', $this->instalasiasal_id);
        $criteria->compare('t.carabayar_id', $this->carabayar_id);
        $criteria->compare('t.penjamin_id', $this->penjamin_id);
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        if (!empty($this->statusperiksa)){
            $criteria->addCondition(" p.statusperiksa ilike '".strtolower($this->statusperiksa)."' ");
        }
        $criteria->order='t.tgl_kirimpasien DESC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
    * Search data rujukan dengan id ruangan radiologi
    * @return \CActiveDataProvider
    */
    public function searchRujukAnastesi() {
       $criteria = new CDbCriteria();
       $criteria->join = " JOIN ruangananestesi_v ra on ra.ruangan_id = t.ruangan_id  ";
       $criteria->compare('lower(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
       $criteria->compare('lower(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
       $criteria->compare('lower(t.nama_pasien)', strtolower($this->nama_pasien), true);
	   $criteria->compare('t.pasien_id', $this->pasien_id, true);
       $criteria->join = "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id ";
       $criteria->select = " t.*,p.statusperiksa, p.pasienbatalperiksa_id";
       if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
           $criteria->addBetweenCondition('t.tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
       }
       $criteria->addCondition('p.pasienbatalperiksa_id is null');
       $criteria->compare('t.ruanganasal_id', $this->ruanganasal_id);
       $criteria->compare('t.instalasiasal_id', $this->instalasiasal_id);
       $criteria->compare('t.carabayar_id', $this->carabayar_id);
       $criteria->compare('t.penjamin_id', $this->penjamin_id);
       if (!empty($this->statusperiksa)){
               $criteria->addCondition(" p.statusperiksa ilike '".strtolower($this->statusperiksa)."' ");
       }
       $criteria->order='t.tgl_kirimpasien DESC';

       return new CActiveDataProvider($this, array(
           'criteria'=>$criteria,
       ));
    }
}