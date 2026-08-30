<?php
class BKLaporanrekappendapatanV extends LaporanrekappendapatanV
{
	public $totaliurbiaya,$totalsubsidiasuransi;
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $instalasi_id, $jumlah, $tick, $data, $ruangan_id;
		public $totaltagihanseluruh, $totalpenjamin;
        
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran';
                
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal.' 00:00:00',$this->tgl_akhir.' 23:59:59');                
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $ins = new CDbCriteria();
                       $ins->addCondition(" ruangan_aktif = TRUE ");
                       $ins->addInCondition('instalasi_id',$this->instalasi_id);
                       $ruangan = RuanganM::model()->findAll($ins);
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('ruanganpelakhir_id', $r);
                   }
                }
                                
                if (!empty($this->carabayar_id)){
                    $criteria->addInCondition(" carabayar_id", $this->carabayar_id);
                }else{
                    if (!empty($this->penjamin_id)){
                        $criteria->addCondition(" penjamin_id", $this->penjamin_id);
                    }
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran';
                
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $ruangan = RuanganM::model()->findAll("instalasi_id = '".$this->instalasi_id."' AND ruangan_aktif = TRUE ");
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('ruangan_id', $r);
                   }
                }
                
           
                
                 if(!empty($this->carabayar_id)){
                    if (is_array($this->carabayar_id)){
                        $criteria->addInCondition('carabayar_id',$this->carabayar_id);
                    }else{
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
                    }
		}
                if(!empty($this->penjamin_id)){
                    if (is_array($this->penjamin_id)){
                        $criteria->addInCondition('penjamin_id',$this->penjamin_id);
                    }else{
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
                    }
		}
                
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchPiutangPenjamin()
	{
		$criteria=new CDbCriteria;
		$this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
		$criteria->select = 't.tandabuktibayar_id,t.nopembayaran, t.pendaftaran_id,t.pasien_id,t.nama_pasien,t.no_rekam_medik,t.no_pendaftaran,t.carapembayaran,t.nama_pemakai,t.penjamin_nama,t.tglpembayaran,
                                     t.ruanganakhir_nama,t.tgl_pendaftaran,t.tglpulang,t.penjamin_id,t.carabayar_id,
                                     sum(t.totalsisatagihan) as totalsisatagihan,
                                     sum(t.totalpembebasan) as totalpembebasan,
                                     sum(t.totaldiscount) as totaldiscount,
                                     sum(t.totalbayartindakan) as totalbayartindakan,
                                     sum(t.totaliurbiaya) as totaliurbiaya,
                                     sum(t.totalsubsidirs) as totalsubsidirs,
                                     sum(t.totalsubsidipemerintah) as totalsubsidipemerintah,
                                     sum(t.totalsubsidiasuransi) as totalsubsidiasuransi,
                                     sum(t.totalbiayapelayanan) as totalbiayapelayanan,
                                     sum(t.totalbiayatindakan) as totlabiayatindakan,
                                     sum(t.totalbiayaoa) as totalbiayaoa,
                                    sum(t.totalbiayapelayanan+tbb.biayaadministrasi+tbb.biayamaterai-t.totaldiscount) as totaltagihanseluruh,
                                   sum(t.totalsubsidiasuransi+t.totalsubsidipemerintah) as totalpenjamin';
                $criteria->group = 't.tandabuktibayar_id,t.nopembayaran, t.pendaftaran_id,t.pasien_id,t.nama_pasien,t.no_rekam_medik,t.no_pendaftaran,
                                    t.carapembayaran,t.nama_pemakai,t.penjamin_nama,t.tglpembayaran,t.ruanganakhir_nama,
                                    t.tgl_pendaftaran,t.tglpulang,t.penjamin_id,t.carabayar_id';
				$criteria->join = " JOIN tandabuktibayar_t tbb ON tbb.tandabuktibayar_id = t.tandabuktibayar_id  ";
                $criteria->addCondition('t.penjamin_id <> '.Params::PENJAMIN_ID_UMUM);
                $criteria->addCondition("t.carapembayaran ilike '".Params::CARAPEMBAYARAN_PIUTANG."'");
                $criteria->compare('t.carabayar_id', $this->carabayar_id);
                $criteria->compare('t.penjamin_id', $this->penjamin_id);
                $criteria->addBetweenCondition('t.tglpembayaran::date',$this->tgl_awal,$this->tgl_akhir);
				if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('t.ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
					   $criIns = new CDbCriteria();
					   $criIns->addInCondition("t.instalasi_id ", $this->instalasi_id);
					   $criIns->addCondition("t.ruangan_aktif = TRUE ");
                       $ruangan = RuanganM::model()->findAll($criIns);
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('t.ruanganpelakhir_id', $r);
                   }
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.tglpembayaran'
            ),
		));
	}
        
        public function searchPrintPenjamin()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 't.tandabuktibayar_id,t.nopembayaran, t.pendaftaran_id,t.pasien_id,t.nama_pasien,t.no_rekam_medik,t.no_pendaftaran,t.carapembayaran,t.nama_pemakai,t.penjamin_nama,t.tglpembayaran,
                                     t.ruanganakhir_nama,t.tgl_pendaftaran,t.tglpulang,t.penjamin_id,t.carabayar_id,
                                     sum(t.totalsisatagihan) as totalsisatagihan,
                                     sum(t.totalpembebasan) as totalpembebasan,
                                     sum(t.totaldiscount) as totaldiscount,
                                     sum(t.totalbayartindakan) as totalbayartindakan,
                                     sum(t.totaliurbiaya) as totaliurbiaya,
                                     sum(t.totalsubsidirs) as totalsubsidirs,
                                     sum(t.totalsubsidipemerintah) as totalsubsidipemerintah,
                                     sum(t.totalsubsidiasuransi) as totalsubsidiasuransi,
                                     sum(t.totalbiayapelayanan) as totalbiayapelayanan,
                                     sum(t.totalbiayatindakan) as totlabiayatindakan,
                                     sum(t.totalbiayaoa) as totalbiayaoa,
                                    sum(t.totalbiayapelayanan+tbb.biayaadministrasi+tbb.biayamaterai-t.totaldiscount) as totaltagihanseluruh,
                                   sum(t.totalsubsidiasuransi+t.totalsubsidipemerintah) as totalpenjamin';
                $criteria->group = 't.tandabuktibayar_id,t.nopembayaran, t.pendaftaran_id,t.pasien_id,t.nama_pasien,t.no_rekam_medik,t.no_pendaftaran,
                                    t.carapembayaran,t.nama_pemakai,t.penjamin_nama,t.tglpembayaran,t.ruanganakhir_nama,
                                    t.tgl_pendaftaran,t.tglpulang,t.penjamin_id,t.carabayar_id';
				$criteria->join = " JOIN tandabuktibayar_t tbb ON tbb.tandabuktibayar_id = t.tandabuktibayar_id  ";
                $criteria->addCondition('t.penjamin_id <> '.Params::PENJAMIN_ID_UMUM);
                $criteria->addCondition("t.carapembayaran ilike '".Params::CARAPEMBAYARAN_PIUTANG."'");
                $criteria->compare('t.carabayar_id', $this->carabayar_id);
                $criteria->compare('t.penjamin_id', $this->penjamin_id);
                $criteria->addBetweenCondition('t.tglpembayaran::date',$this->tgl_awal,$this->tgl_akhir);
				if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('t.ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
					   $criIns = new CDbCriteria();
					   $criIns->addInCondition("t.instalasi_id ", $this->instalasi_id);
					   $criIns->addCondition("t.ruangan_aktif = TRUE ");
                       $ruangan = RuanganM::model()->findAll($criIns);
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('t.ruanganpelakhir_id', $r);
                   }
                }
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
            'sort'=>array(
                'defaultOrder'=>'t.tglpembayaran'
            ),
		));
	}
        
        public function searchPiutangUmum()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
                                     ruanganakhir_nama,tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,
                                    carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama,
                                    tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id';
                $criteria->addCondition('penjamin_id = 1');   
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrintUmum()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,
                                     ruanganakhir_nama,tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id,
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
                $criteria->group = 'pendaftaran_id,pasien_id,nama_pasien,no_rekam_medik,no_pendaftaran,
                                    carapembayaran,nama_pemakai,penjamin_nama,tglpembayaran,ruanganakhir_nama,
                                    tgl_pendaftaran,tglpulang,penjamin_id,carabayar_id';
                $criteria->addCondition('penjamin_id = 1');      
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchGrafik()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'sum(totalbayartindakan) as jumlah, penjamin_nama as data';
                $criteria->addBetweenCondition('tglpembayaran',$this->tgl_awal,$this->tgl_akhir);
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruanganpelakhir_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $ruangan = RuanganM::model()->findAll("instalasi_id = '".$this->instalasi_id."' AND ruangan_aktif = TRUE ");
                        $r = array();
                        foreach($ruangan as $ruang){
                            $r[] = $ruang->ruangan_id; 
                        }
                        
                        $criteria->addInCondition('ruangan_id', $r);
                   }
                }
                
                if (!empty($this->carabayar_id)){
                    $criteria->addInCondition(" carabayar_id", $this->carabayar_id);
                }else{
                    if (!empty($this->penjamin_id)){
                        $criteria->addInCondition(" penjamin_id", $this->penjamin_id);
                    }
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
        
       function getTotalTagihan() {
           return $this->totalbiayapelayanan;
       }
       
        public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
                    //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }

}
?>