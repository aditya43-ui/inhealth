<?php

class BSTindakandanoasudahbayarV extends TindakandanoasudahbayarV
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanOperasiM the static model class
	 */
    
        public $no_pendaftaran,$tgl_pendaftaran,$penjamin_nama;
        public $namaperusahaan,$tgl_pembayaran;
        public $tgl_awal,$tgl_akhir;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}        
	public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->select = 't.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
                                     sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
                $criteria->group = 't.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
                $criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
                                   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
                                    ';
                $criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria= new CDbCriteria;
                
                $criteria->select = 't.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
                                     sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
                $criteria->group = 't.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
                $criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
                                   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
                                    ';
                $criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
	public function searchTableUgd()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
							 sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
		$criteria->group = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
						   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
							';
		$criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->addCondition('pendaftaran_t.instalasi_id = '.Params::INSTALASI_ID_RD);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPrintUgd()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
							 sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
		$criteria->group = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
						   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
							';
		$criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->addCondition('pendaftaran_t.instalasi_id = '.Params::INSTALASI_ID_RD);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchTableRj()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
							 sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
		$criteria->group = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
						   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
							';
		$criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->addCondition('pendaftaran_t.instalasi_id = '.Params::INSTALASI_ID_RJ);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPrintRj()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
							 sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
		$criteria->group = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
						   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
							';
		$criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->addCondition('pendaftaran_t.instalasi_id = '.Params::INSTALASI_ID_RJ);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchTableRi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
							 sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
		$criteria->group = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
						   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
							';
		$criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->addCondition('pendaftaran_t.instalasi_id = '.Params::INSTALASI_ID_RI);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPrintRi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pasien_m.pasien_id,
								sum(t.totalbayartindakan) as totalbayartindakan,sum(t.totalbiayapelayanan) as totalbiayapelayanan';
		$criteria->group = 'pendaftaran_t.instalasi_id,t.tglpembayaran, pendaftaran_t.tgl_pendaftaran,pendaftaran_t.no_pendaftaran,ruangan_nama,pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.pasien_id';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
						   LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
							';
		$criteria->addBetweenCondition('pendaftaran_t.tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->addCondition('pendaftaran_t.instalasi_id = '.Params::INSTALASI_ID_RI);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        // -- UNTUK VIEW TABEL DI LAPORAN REKAP TRANSAKSI BEDAH SENTRAL -- //
        
	public function searchTableRekapTransaksiBedahSentral()
	{
		$criteria=new CDbCriteria;
                
                $criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan';
                $criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchTableRekapTransaksiBedahSentralRI()
	{
		$criteria=new CDbCriteria;
                
                $criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan';
                $criteria->group ='pasien_m.no_rekam_medik';
                $criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchTableRekapTransaksiBedahSentralRJ()
	{
		$criteria=new CDbCriteria;
                
                $criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan';
                $criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchTableRekapTransaksiBedahSentralUGD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan';
                $criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        // -- END REKAP TRANSAKSI BEDAH SENTRAL -- //
        
        /* Laporan Rekap Piutang Transaksi */
        public function searchPiutang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,t.ruangan_nama,
							 t.totalsisatagihan,penjaminpasien_m.penjamin_nama';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
						   LEFT JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = t.penjamin_id';
		$criteria->addBetweenCondition('t.tglpembayaran',$this->tgl_awal,$this->tgl_akhir,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPiutangPenjamin()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,t.ruangan_nama,
							 t.totalsisatagihan,penjaminpasien_m.penjamin_nama';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
						   LEFT JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = t.penjamin_id';
		$criteria->addBetweenCondition('t.tglpembayaran',$this->tgl_awal,$this->tgl_akhir,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPiutangUmum()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,t.ruangan_nama,
							 t.totalsisatagihan,penjaminpasien_m.penjamin_nama';
		$criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
						   LEFT JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = t.penjamin_id';
		$criteria->addBetweenCondition('t.tglpembayaran',$this->tgl_awal,$this->tgl_akhir,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrintPiutang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->select = 't.tglpembayaran, pasien_m.no_rekam_medik,pasien_m.nama_pasien,t.totalbayartindakan,t.totalbiayapelayanan';
                $criteria->join = 'LEFT JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /* End Laporan Rekap Piutang Transaksi */
        
}
?>
