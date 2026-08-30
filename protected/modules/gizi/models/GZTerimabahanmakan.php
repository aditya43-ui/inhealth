<?php 
class GZTerimabahanmakan extends TerimabahanmakanT {

    public $temp_no,$tgljatuhtempo, $nopengajuan, $pajak_nama;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir))
            $criteria->addBetweenCondition('DATE(t.tglterimabahan)', $this->tgl_awal, $this->tgl_akhir);
        
		$criteria->compare('t.terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('t.pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(t.sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(t.nopenerimaanbahan)',strtolower($this->nopenerimaanbahan),true);
//		$criteria->compare('LOWER(tglterimabahan)',strtolower($this->tglterimabahan),true);
		$criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(t.tglsurjalan)',strtolower($this->tglsurjalan),true);
		$criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(t.tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('t.totalharganetto',$this->totalharganetto);
		$criteria->compare('t.totaldiscount',$this->totaldiscount);
		$criteria->compare('LOWER(t.keterangan_terima_bahan)',strtolower($this->keterangan_terima_bahan),true);
		$criteria->order='t.tglterimabahan DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasiUntukFaktur() {
        $prov = $this->searchInformasi();
        $prov->criteria->addCondition("t.nofaktur is null or trim(t.nofaktur) = '' AND t.tglfaktur IS NULL");
        
        
        return $prov;
    }
    
    public function searchInformasiDialog() {
        $prov = $this->searchInformasi();
        $prov->criteria->join = 'left join bayarkesupplier_t b on b.terimabahanmakan_id = t.terimabahanmakan_id';
        $prov->criteria->addCondition('b.bayarkesupplier_id is null');
        
        return $prov;
    }
    
    public function searchInformasiFaktur() {
        $criteria=new CDbCriteria;
        
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir))
            $criteria->addBetweenCondition('DATE(t.tglfaktur)', $this->tgl_awal, $this->tgl_akhir);
        
        $criteria->compare('t.terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('t.pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(t.sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(t.nopenerimaanbahan)',strtolower($this->nopenerimaanbahan),true);
//		$criteria->compare('LOWER(tglterimabahan)',strtolower($this->tglterimabahan),true);
		$criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('LOWER(t.tglsurjalan)',strtolower($this->tglsurjalan),true);
		$criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(t.tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('t.totalharganetto',$this->totalharganetto);
		$criteria->compare('t.totaldiscount',$this->totaldiscount);
		$criteria->compare('LOWER(t.keterangan_terima_bahan)',strtolower($this->keterangan_terima_bahan),true);
		$criteria->order='t.tglterimabahan DESC';
        $criteria->addCondition("nofaktur is not null and trim(nofaktur) <> ''");
                
                if(!empty($this->syaratbayar_id)){
                    $criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
                }
                if(!empty($this->pajak_id)){
                    $criteria->addCondition('t.pajak_id = '.$this->pajak_id);
                }
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
	
	/**
         * menampilkan nama supplier 
         * @param type $ruangan_id = gizi
         * @param type $supplier_jenis = gizi
         * RSN-322
         */
        public function getSupplier()
        {
            $criteria = new CdbCriteria();
            $criteria->addCondition("supplier_jenis= '".Params::SUPPLIER_JENIS_GIZI."'");
            $criteria->addCondition('supplier_aktif = true');
            $modSupplier = SupplierM::model()->findAll($criteria);
            return $modSupplier;
        }
        
        public function getUmurHutang($tgljatuhtempo, $tglfaktur){
			$tglfaktur = date('Y-m-d', strtotime($tglfaktur));	
			$tgljatuhtempo = (!empty($tgljatuhtempo)?date('Y-m-d', strtotime($tgljatuhtempo)):date('Y-m-d H:i:s'));			
			
                        $dob=$tglfaktur; 
			$jatuhtempo=$tgljatuhtempo;
			list($y,$m,$d)=explode('-',$dob);
			list($ty,$tm,$td)=explode('-',$jatuhtempo);
                        
			if($td-$d<0){
				$day=($td+30)-$d;
				$tm--;
			}
			else{
				$day=$td-$d;
			}
			if($tm-$m<0){
				$month=($tm+12)-$m;
				$ty--;
			}
			else{
				$month=$tm-$m;
			}
			$year=$ty-$y;

			$umurHutang = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
			
			return $umurHutang;
		}
}
