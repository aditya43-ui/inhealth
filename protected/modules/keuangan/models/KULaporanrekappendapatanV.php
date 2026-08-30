<?php
class KULaporanrekappendapatanV extends LaporanrekappendapatanV
{
	public $totaliurbiaya,$totalsubsidiasuransi;
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $data, $tick, $jumlah;
        public $instalasi_id, $ruangan_id;
		public $totaltagihanseluruh;
		public $totalpenjamin;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchTable()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id,
                                     sum(totalsisatagihan) as totalsisatagihan,
                                     sum(totalpembebasan) as totalpembebasan,
                                     sum(totaldiscount) as totaldiscount,
                                     sum(totalbayartindakan) as totalbayartindakan,
                                     sum(totaliurbiaya) as totaliurbiaya,
                                     sum(totalsubsidirs) as totalsubsidirs,
                                     sum(totalsubsidipemerintah) as totalsubsidipemerintah,
                                     sum(totalsubsidiasuransi) as totalsubsidiasuransi,
                                     sum(totalbiayapelayanan) as totalbiayapelayanan,
                                     sum(totalbiayatindakan) as totlabiayatindakan,
                                     sum(totalbiayaoa) as totalbiayaoa';
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id';
				
                if (!empty($this->carabayar_id)){
                    $criteria->addInCondition("carabayar_id",$this->carabayar_id);
                }
				
				if (!empty($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);
				}
				
				if(!empty($this->ruangan_id)){     
					$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
				}
                                              
				if (!empty($this->instalasi_id)){
					$instalasi = new CDbCriteria;
					$instalasi->addInCondition("instalasi_id", $this->instalasi_id);
					$ruangan = RuanganM::model()->findAll($instalasi);
					$r = array();
					foreach($ruangan as $ruang){
						$r[] = $ruang->ruangan_id; 
					}

					$criteria->addInCondition('ruanganpelakhir_id', $r);//kolom dari db
				}
                
                
                $criteria->addBetweenCondition('date(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->order = 'tglpembayaran ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchTableInstalasi()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 't.nopembayaran,t.tandabuktibayar_id,carabayar_nama,pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,t.carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id,
							sum(totalsisatagihan) as totalsisatagihan,
							sum(totalpembebasan) as totalpembebasan,
							sum(totaldiscount) as totaldiscount,
							sum(totalbayartindakan) as totalbayartindakan,
							sum(totaliurbiaya) as totaliurbiaya,
							sum(totalsubsidirs) as totalsubsidirs,
							sum(totalsubsidipemerintah) as totalsubsidipemerintah,
							sum(totalsubsidiasuransi) as totalsubsidiasuransi,
							sum(totalbiayapelayanan) as totalbiayapelayanan,
							sum(totalbiayatindakan) as totlabiayatindakan,
							sum(totalbiayaoa) as totalbiayaoa,
							sum(totalbiayapelayanan+tbb.biayaadministrasi+tbb.biayamaterai-totaldiscount) as totaltagihanseluruh, 
							sum(totalsubsidiasuransi+totalsubsidipemerintah) as totalpenjamin';							
	   $criteria->group = 't.nopembayaran,t.tandabuktibayar_id,carabayar_nama,pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,t.carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id';
		$criteria->join = " JOIN tandabuktibayar_t tbb ON tbb.tandabuktibayar_id = t.tandabuktibayar_id  ";						
                if (!empty($this->carabayar_id)){
                    $criteria->addInCondition("carabayar_id",$this->carabayar_id);
                }
				
				if (!empty($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);
				}
				
				if(!empty($this->ruangan_id)){     
					$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
				}
                                              
				if (!empty($this->instalasi_id)){
					$instalasi = new CDbCriteria;
					$instalasi->addInCondition("instalasi_id", $this->instalasi_id);
					$ruangan = RuanganM::model()->findAll($instalasi);
					$r = array();
					foreach($ruangan as $ruang){
						$r[] = $ruang->ruangan_id; 
					}
					
					if(!empty($this->ruangan_id)){     
						$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
					}else{
						$criteria->addInCondition('ruanganpelakhir_id', $r);//kolom dari db
					}
				}
				
				if (!empty($this->carabayar_id)){
					$criteria->addInCondition(" carabayar_id ", $this->carabayar_id);
				}
                
				if (!empty($this->penjamin_id)){
					$criteria->addInCondition(" penjamin_id ", $this->penjamin_id);
				}
                
                $criteria->addBetweenCondition('date(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->order = 'tglpembayaran ASC';
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,			
		));
	}
        
	public function searchTableInstalasiPrint()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 't.nopembayaran,tandabuktibayar_id,carabayar_nama,pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id,
                                     sum(totalsisatagihan) as totalsisatagihan,
                                     sum(totalpembebasan) as totalpembebasan,
                                     sum(totaldiscount) as totaldiscount,
                                     sum(totalbayartindakan) as totalbayartindakan,
                                     sum(totaliurbiaya) as totaliurbiaya,
                                     sum(totalsubsidirs) as totalsubsidirs,
                                     sum(totalsubsidipemerintah) as totalsubsidipemerintah,
                                     sum(totalsubsidiasuransi) as totalsubsidiasuransi,
                                     sum(totalbiayapelayanan) as totalbiayapelayanan,
                                     sum(totalbiayatindakan) as totlabiayatindakan,
                                     sum(totalbiayaoa) as totalbiayaoa';
                $criteria->group = 't.nopembayaran,tandabuktibayar_id,carabayar_nama,pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id';
				
                if (!empty($this->carabayar_id)){
                    $criteria->addInCondition("carabayar_id",$this->carabayar_id);
                }
				
				if (!empty($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);
				}
				
				if(!empty($this->ruangan_id)){     
					$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
				}
                                              
				if (!empty($this->instalasi_id)){
					$instalasi = new CDbCriteria;
					$instalasi->addInCondition("instalasi_id", $this->instalasi_id);
					$ruangan = RuanganM::model()->findAll($instalasi);
					$r = array();
					foreach($ruangan as $ruang){
						$r[] = $ruang->ruangan_id; 
					}
					
					if(!empty($this->ruangan_id)){     
						$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
					}else{
						$criteria->addInCondition('ruanganpelakhir_id', $r);//kolom dari db
					}
				}
				
				if (!empty($this->carabayar_id)){
					$criteria->addInCondition(" carabayar_id ", $this->carabayar_id);
				}
                
				if (!empty($this->penjamin_id)){
					$criteria->addInCondition(" penjamin_id ", $this->penjamin_id);
				}
                
                $criteria->addBetweenCondition('date(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->order = 'tglpembayaran ASC';
				$criteria->limit  = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}                
	
	public function searchPrint()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id,
                                     sum(totalsisatagihan) as totalsisatagihan,
                                     sum(totalpembebasan) as totalpembebasan,
                                     sum(totaldiscount) as totaldiscount,
                                     sum(totalbayartindakan) as totalbayartindakan,
                                     sum(totaliurbiaya) as totaliurbiaya,
                                     sum(totalsubsidirs) as totalsubsidirs,
                                     sum(totalsubsidipemerintah) as totalsubsidipemerintah,
                                     sum(totalsubsidiasuransi) as totalsubsidiasuransi,
                                     sum(totalbiayapelayanan) as totalbiayapelayanan,
                                     sum(totalbiayatindakan) as totlabiayatindakan,
                                     sum(totalbiayaoa) as totalbiayaoa';
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama, namadepan,ruanganpelakhir_id';
                
                if (!empty($this->carabayar_id)){
                    $criteria->addInCondition("carabayar_id",$this->carabayar_id);
                }
				
				if (!empty($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);
				}
				
				if(!empty($this->ruangan_id)){     
					$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
				}
                                              
				if (!empty($this->instalasi_id)){
					$instalasi = new CDbCriteria;
					$instalasi->addInCondition("instalasi_id", $this->instalasi_id);
					$ruangan = RuanganM::model()->findAll($instalasi);
					$r = array();
					foreach($ruangan as $ruang){
						$r[] = $ruang->ruangan_id; 
					}

					$criteria->addInCondition('ruanganpelakhir_id', $r);
				}
                
                $criteria->addBetweenCondition('date(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->order = 'tglpembayaran ASC';
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
	public function searchGrafik()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'sum(totalbayartindakan) as jumlah, ruanganakhir_nama as data';
                $criteria->addBetweenCondition('date(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
                
				
				if(!empty($this->ruangan_id)){     
					$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
				}
                                              
				if (!empty($this->instalasi_id)){
					$instalasi = new CDbCriteria;
					$instalasi->addInCondition("instalasi_id", $this->instalasi_id);
					$ruangan = RuanganM::model()->findAll($instalasi);
					$r = array();
					foreach($ruangan as $ruang){
						$r[] = $ruang->ruangan_id; 
					}

					$criteria->addInCondition('ruanganpelakhir_id', $r);
				}          
                $criteria->group = 'ruanganakhir_nama';
                $criteria->order = 'jumlah DESC, ruanganakhir_nama ASC';
                  
                $criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	} 
	
	public function searchGrafikInstalasi()
	{
		$criteria=new CDbCriteria;

		$criteria->select = ' (sum(t.totalbayartindakan + tbb.biayaadministrasi + tbb.biayamaterai + t.totaldiscount)) as jumlah, instalasi_nama as data';
		$criteria->join = " JOIN tandabuktibayar_t tbb ON tbb.tandabuktibayar_id = t.tandabuktibayar_id  "
						. "	JOIN ruangan_m r ON r.ruangan_id = t.ruanganpelakhir_id "
						. "	JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id";
		$criteria->addBetweenCondition('date(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
                
				
		if (!empty($this->carabayar_id)){
			$criteria->addInCondition("carabayar_id",$this->carabayar_id);
		}

		if (!empty($this->penjamin_id)){
			$criteria->addInCondition("penjamin_id",$this->penjamin_id);
		}

		if(!empty($this->ruangan_id)){     
			$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
		}

		if (!empty($this->instalasi_id)){
			$instalasi = new CDbCriteria;
			$instalasi->addInCondition("instalasi_id", $this->instalasi_id);
			$ruangan = RuanganM::model()->findAll($instalasi);
			$r = array();
			foreach($ruangan as $ruang){
				$r[] = $ruang->ruangan_id; 
			}

			if(!empty($this->ruangan_id)){     
				$criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
			}else{
				$criteria->addInCondition('ruanganpelakhir_id', $r);//kolom dari db
			}
		}

		if (!empty($this->carabayar_id)){
			$criteria->addInCondition(" carabayar_id ", $this->carabayar_id);
		}

		if (!empty($this->penjamin_id)){
			$criteria->addInCondition(" penjamin_id ", $this->penjamin_id);
		}


		$criteria->group = 'instalasi_nama';
		$criteria->order = 'jumlah DESC, instalasi_nama ASC';

		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	} 
        
        public function searchGrafikPenjamin()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'sum(totalbayartindakan) as jumlah, penjamin_nama as data';
                $criteria->addBetweenCondition('date(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
                if (!empty($this->carabayar_id)){
                    $criteria->addInCondition("carabayar_id",$this->carabayar_id);
                }
				
				if (!empty($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);
				}
				
				
                $criteria->group = 'penjamin_nama';
                $criteria->order = 'jumlah DESC, penjamin_nama ASC';
                  
                $criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	} 
        
        public function getNamaModel()
        {
            return __CLASS__;
        }
        
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC");
        }
		
		public function fetchTotalDays($records=''){		
			$days=0;
			
			foreach($records as $record){
				var_dump($record->totalbiayapelayanan);
					$days+=$record->totalbiayapelayanan+12;
			}
			return $days;
		}       

}
?>