<?php

class BKPembayaranpelayananT extends PembayaranpelayananT
{
    public $tgl_awal, $bln_awal, $thn_awal;
    public $tgl_akhir, $bln_akhir, $thn_akhir;
    public $jns_periode;
    public $no_rekam_medik;
    public $no_pendaftaran;
    public $nama_pasien;
    public $nama_bin;
     public $tgl_bkm_akhir;
    public $tgl_bkm_awal;
    public $ceklis;
    public $tgl_pendaftaran_cari,$idInstalasi;
    public $tglPendaftaran, $noPendaftaran, $umur, $kasusPenyakit, $instalasiId, $instalasiNama, $ruanganNama
           ,$namaPasien,$jeniskelamin,$namaBIn, $pendaftaranId, $pasienId, $pasienAdmisiId, $noRM, $alamatPasien,
            $tandabuktibayarId,$totalOaR,$totalTindakanR,$totalBiayaR;
     public $instalasi_nama;
     public $antrian_id;
     public $total_inacbg_2;
     public $bank_nominal;
		 public $statusperiksa;
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPasienSudahBayar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                
		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->with = array('pendaftaran','pasien','tandabuktibayar');
		$criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
//                $criteria->addCondition('pendaftaran.penjamin_id != 117');
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("t.penjamin_id ",$this->penjamin_id);					
		}
		
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("t.carabayar_id ",$this->carabayar_id);					
		}
		$criteria->addCondition('t.orderbatalpembayaranpelayanan_id IS NULL');
		
		
		$criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPasienBerdasarkanPenjamin()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pendaftaran','pasien','tandabuktibayar');
		$criteria->join = 'JOIN PENJAMINPASIEN_M ppm ON ppm.penjamin_id = t.penjamin_id';
		$criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
		$criteria->addCondition('t.penjamin_id != '.Params::PENJAMIN_ID_UMUM);
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("t.penjamin_id ",$this->penjamin_id);					
		}
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("t.carabayar_id ",$this->carabayar_id);					
		}
		$criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition('t.orderbatalpembayaranpelayanan_id IS NULL');
		// echo '<pre>';var_dump($criteria);die;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));            
        }
        
        public function searchPasienBerdasarkanUmum()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pendaftaran','pasien','tandabuktibayar');
		$criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
		$criteria->addCondition('t.penjamin_id = '.Params::PENJAMIN_ID_UMUM);
		$criteria->addCondition('t.orderbatalpembayaranpelayanan_id IS NULL');
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("t.penjamin_id ",$this->penjamin_id);					
		}
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("t.carabayar_id ",$this->carabayar_id);					
		}
		$criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));            
        }
        
        // print //
        public function searchPrintPasienSudahBayar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->with = array('pendaftaran','pasien','tandabuktibayar');
		$criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
//                $criteria->addCondition('pendaftaran.penjamin_id != 117');
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("pendaftaran.penjamin_id ",$this->penjamin_id);					
		}
		$criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		$criteria->limit = -1;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchPrintPasienBerdasarkanPenjamin()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->with = array('pendaftaran','pasien','tandabuktibayar');
		$criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
		$criteria->addCondition('pendaftaran.penjamin_id != '.Params::PENJAMIN_ID_UMUM);
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("pendaftaran.penjamin_id ",$this->penjamin_id);					
		}
		$criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);
//                $criteria->addBetweenCondition('DATE(tandabuktibayar.tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->limit = -1;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));            
        }
        
        public function searchPrintPasienBerdasarkanUmum()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pendaftaran','pasien','tandabuktibayar');
		$criteria->addCondition('tandabuktibayar.returbayarpelayanan_id IS NULL');
		$criteria->addCondition('t.penjamin_id = '.Params::PENJAMIN_ID_UMUM);
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("pendaftaran.penjamin_id ",$this->penjamin_id);					
		}
		$criteria->order = 'tandabuktibayar.tglbuktibayar DESC';
		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->limit = -1;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));            
        }
        // end print //
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
                $criteria->addBetweenCondition('DATE(tandabuktibayar.tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);
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

        public function searchPasienRetur(){
            $criteria=new CDbCriteria;

            $criteria->with = array('pendaftaran','pasien','ruangan');
            $criteria->compare('LOWER(pendaftaran.no_pendaftaran)', strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(pasien.nama_bin)', strtolower($this->nama_bin),true);
			if(!empty($this->idInstalasi)){
				$criteria->addCondition("pendaftaran.instalasi_id = ".$this->idInstalasi);					
			}
            
            return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
        }
        
}
