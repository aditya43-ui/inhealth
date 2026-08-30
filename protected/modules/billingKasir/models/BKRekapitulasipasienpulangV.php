<?php

class BKRekapitulasipasienpulangV extends RekapitulasipasienpulangV
{
    public $tgl_awal;
    public $tgl_akhir;
    public $no_rekam_medik;
    public $no_pendaftaran;
    public $nama_pasien;
    public $nama_bin;
    // public $pembayaranpelayanan_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranpelayananT the static model class
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
         //  'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
//                    //'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
//                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                  //  'tandabuktibayar'=>array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'pembebasantarif_id' => 'Pembebasantarif',
			'suratketjaminan_id' => 'Suratketjaminan',
			'pasien_id' => 'Pasien',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'ruangan_id' => 'Ruangan',
			//'tandabuktibayar_id' => 'Tandabuktibayar',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'nopembayaran' => 'No. Pembayaran',
			//'tglpembayaran' => 'Tgl. Pembayaran',
			'noresep' => 'Noresep',
			'nosjp' => 'Nosjp',
			'totalbiayaoa' => 'Totalbiayaoa',
			'totalbiayatindakan' => 'Totalbiayatindakan',
			'tarif_tindakan' => 'Totalbiayapelayanan',
			'subsidiasuransi_tindakan' => 'subsidiasuransi_tindakan',
			'totalsubsidipemerintah' => 'Totalsubsidipemerintah',
			'totalsubsidirs' => 'Totalsubsidirs',
			'iurbiaya_tindakan' => 'Totaliurbiaya',
			'totalbayartindakan' => 'Totalbayartindakan',
			'totaldiscount' => 'Total Keringanan',
			'totalpembebasan' => 'Totalpembebasan',
			'totalsisatagihan' => 'Totalsisatagihan',
			'ruanganpelakhir_id' => 'Ruanganpelakhir',
			'statusbayar' => 'Statusbayar',
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
	public function searchPasienSudahPulang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

              //  $criteria->with = array('pendaftaran');
                // $criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
				$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin),true);
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
				}
           
				$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan,true);
               
				if (pembayaranpelayanan_id==NULL){
				$status=='Belum Bayar';
            }
            else {
               $status=='Sudah Bayar';
            }
                 
               // $criteria->compare('pendaftaran.pembayaranpelayanan_id', $this->pembayaranpelayanan_id,true);
                // $criteria->addCondition('pendaftaran.pembayaranpelayanan_id IS NOT NULL');
//                $criteria->with = 'tandabuktibayar';
               //
               //  $criteria->addCondition("totalsisatagihan = 0");
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
               // $criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                      
		));
	}
        
        public function searchPrintPasienSudahPulang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

              //  $criteria->with = array('pendaftaran');
                // $criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
				$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin),true);
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
				}
           
                 $criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan,true);
               
                  if (pembayaranpelayanan_id==NULL){
                 $status=='Belum Bayar';
            }
            else {
               $status=='Sudah Bayar';
            }
                 
               // $criteria->compare('pendaftaran.pembayaranpelayanan_id', $this->pembayaranpelayanan_id,true);
                // $criteria->addCondition('pendaftaran.pembayaranpelayanan_id IS NOT NULL');
//                $criteria->with = 'tandabuktibayar';
               //
               //  $criteria->addCondition("totalsisatagihan = 0");
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
               // $criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       'pagination'=>false,
		));
	}
        
        
        public function searchPasienBerdasarkanPenjamin()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                //$criteria->with = array('pendaftaran','pasien');
                //$criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
				$criteria->addCondition('penjamin_id != 117');
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin),true);
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
				}
                //$criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
             $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));            
        }
        
        public function searchPasienBerdasarkanUmum()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
              //  $criteria->with = array('pendaftaran','pasien','tandabuktibayar');
              //  $criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
                $criteria->addCondition('penjamin_id = 117');
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin),true);
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
				}
               // $criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
               $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));            
        }
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPasienBerhutang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->with = array('pendaftaran','pasien','tandabuktibayar');
                $criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
                $criteria->addBetweenCondition('tandabuktibayar.tglbuktibayar', $this->tgl_awal, $this->tgl_akhir);
//                $criteria->addCondition('totalsisatagihan > 0');
                //$criteria->with = 'tandabuktibayar';
                $criteria->addCondition("tandabuktibayar.carapembayaran NOT IN ('TUNAI')");
                $criteria->order = 'tandabuktibayar.tglbuktibayar DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getNamaModel()
        {
            return __CLASS__;
        }
        
        // perhitungan detailPembayaran() SALAH, DICEK DI INFORMASI PASIEN SUDAH BAYAR TOTALNYA BERBEDA DENGAN KWITANSI DAN RINCIAN TAGIHAN
        public function detailPembayaran()
        {
            $query = "
                SELECT * FROM pembayaranpelayanan_t
                JOIN tandabuktibayar_t ON
                    pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id
                JOIN tindakansudahbayar_t ON
                    tindakansudahbayar_t.pembayaranpelayanan_id = tindakansudahbayar_t.pembayaranpelayanan_id AND 
                    pembayaranpelayanan_t.pembayaranpelayanan_id = tindakansudahbayar_t.pembayaranpelayanan_id
                JOIN tindakanpelayanan_t ON 
                    tindakanpelayanan_t.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                JOIN daftartindakan_m ON
                    tindakanpelayanan_t.daftartindakan_id = daftartindakan_m.daftartindakan_id
                WHERE pembayaranpelayanan_t.pembayaranpelayanan_id = '". $this->pembayaranpelayanan_id ."'
            ";
            $detail = Yii::app()->db->createCommand($query)->queryAll();
            return $detail;
        }

        public function getTotalRetur()
        {
        	$total="Sudah Retur";
        	//Data Tidak Ditemukan
        	// $modTandaBukti= TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$this->pembayaranpelayanan_id));
        	// $modRetur= ReturbayarpelayananT::model()->findByAttributes(array('tandabuktibayar_id'=>$this->tandabuktibayar_id));
        	// $total = $modRetur->totalbiayaretur+$modRetur->biayaadministrasi;
        	return $total;

        }
        
        public function getStatus(){
            if ($this->pembayaranpelayanan_id==NULL){
               
                return 'Belum Bayar';
            }
            else {
                return 'Sudah Bayar';
            }
            
        }
        
   
}
