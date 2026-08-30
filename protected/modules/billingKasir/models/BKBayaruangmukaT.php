<?php

class BKBayaruangmukaT extends BayaruangmukaT
{
    public $tgl_awal;
    public $tgl_akhir;
    public $no_rekam_medik;
    public $no_pendaftaran;
    public $nama_pasien;
    public $nama_bin;
    public $sisauangmuka;
    public $totbiayasementara;
    
    public $tglPendaftaran, $noPendaftaran, $umur, $kasusPenyakit, $instalasiId, $instalasiNama, $ruanganNama
           ,$namaPasien,$jeniskelamin, $namaBIn, $pendaftaranId, $pasienId, $pasienAdmisiId, $noRM;
    public $tgl_pendaftaran_cari,$instalasi_nama,$ruangan_nama,$carabayar_nama,$idInstalasi,
           $tgl_pendaftaran;
	public $pemakaianuangmuka,$jmlpembayaran;
    // public $jeniskasuspenyakit_nama,$instalasi_id,$carabayar_id,$penjamin_id,$penjamin_nama,$kelaspelayanan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BayaruangmukaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'pemakaianuangmuka_id' => 'Pemakainuangmuka',
			'ruangan_id' => 'Ruangan',
			'tgluangmuka' => 'Tgl. Deposit',
			'jumlahuangmuka' => 'Jumlah Uang Muka',
			'keteranganuangmuka' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPasienDeposit()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = '*,tandabuktibayar_t.jmlpembayaran AS jmlpembayaran, pemakaianuangmuka_t.pemakaianuangmuka AS pemakaianuangmuka, pemakaianuangmuka_t.sisauangmuka AS sisauangmuka';
                $criteria->with = array('pendaftaran','pasien');
                $criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
				$criteria->compare('LOWER(pemakaianuangmuka_t.pemakaianuangmuka)', strtolower($this->pemakaianuangmuka),true);
				$criteria->compare('LOWER(tandabuktibayar_t.jmlpembayaran)', strtolower($this->jmlpembayaran),true);
				
                $criteria->addBetweenCondition('DATE(tgluangmuka)', $this->tgl_awal, $this->tgl_akhir);
                $criteria->addCondition('t.pembatalanuangmuka_id IS NULL AND pemakaianuangmuka_t.tandabuktikeluar_id IS NULL');
                $criteria->join = 'LEFT JOIN pemakaianuangmuka_t ON pemakaianuangmuka_t.pemakaianuangmuka_id = t.pemakaianuangmuka_id
									JOIN tandabuktibayar_t ON tandabuktibayar_t.tandabuktibayar_id = t.tandabuktibayar_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPasienDepositGrid()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = '*, pemakaianuangmuka_t.sisauangmuka AS sisauangmuka';
		$criteria->with = array('pendaftaran','pasien');
		$criteria->compare('pendaftaran.no_pendaftaran', $this->no_pendaftaran);
		$criteria->compare('pasien.no_rekam_medik', $this->no_rekam_medik);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
		if(!empty($this->idInstalasi)){
			$criteria->addCondition('pendaftaran.instalasi_id = '.$this->idInstalasi);
		}
		$criteria->addCondition('pembatalanuangmuka_id IS NULL AND pemakaianuangmuka_t.tandabuktikeluar_id IS NULL');
		$criteria->join = 'LEFT JOIN pemakaianuangmuka_t ON pemakaianuangmuka_t.pemakaianuangmuka_id = t.pemakaianuangmuka_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function getTandaBukti($attribute){
		
		$modTandabukti = TandabuktibayarT::model()->findByPk($this->tandabuktibayar_id);
		
		return $modTandabukti->$attribute;
	}

	public function searchBayarUangmukaTerakhir()
    {
        $criteria=new CDbCriteria;
        $criteria->order = 'tgluangmuka DESC';
        $criteria->limit=10; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
	
	public function sisaPembayaran($jmlpembayaran,$jumlahuangmuka){
	$sisaPembayaran = '';
	$sisa=0;
		if ($jmlpembayaran > $jumlahuangmuka){
			$sisa = $jmlpembayaran - $jumlahuangmuka;
			$sisaPembayaran = "Rp ".number_format($sisa,0,",",".");
		}elseif ($jmlpembayaran < $jumlahuangmuka){
			$sisa = $jumlahuangmuka - $jmlpembayaran;
			$sisaPembayaran = "Rp ".number_format($sisa,0,",",".");
		}else{
			$sisaPembayaran = "Rp 0";
		}
	
	return $sisaPembayaran;
	}
}