<?php

class ADLaporanPembelianbarangT extends PembelianbarangT {

    public $totalbeli;
    public $hargabeli;
    public $jmlbeli;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglpembelian)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition("supplier_id = ".$this->supplier_id);			
		}
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		if(!empty($this->peg_pemesanan_id)){
			$criteria->addCondition("peg_pemesanan_id = ".$this->peg_pemesanan_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->peg_menyetujui_id)){
			$criteria->addCondition("peg_menyetujui_id = ".$this->peg_menyetujui_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPembelianBarang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria ();
               
		$criteria->select = 't.*, belibrgdetail_t.*, (belibrgdetail_t.hargabeli) as hargabeli, (belibrgdetail_t.jmlbeli) as jmlbeli';
		$criteria->addBetweenCondition('date(tglpembelian)',$this->tgl_awal, $this->tgl_akhir,true);
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition("supplier_id = ".$this->supplier_id);			
		}
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		if(!empty($this->peg_pemesanan_id)){
			$criteria->addCondition("peg_pemesanan_id = ".$this->peg_pemesanan_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->peg_menyetujui_id)){
			$criteria->addCondition("peg_menyetujui_id = ".$this->peg_menyetujui_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->join= 'INNER JOIN belibrgdetail_t ON t.pembelianbarang_id = belibrgdetail_t.pembelianbarang_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchPembelianBarangPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglpembelian)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition("supplier_id = ".$this->supplier_id);			
		}
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		if(!empty($this->peg_pemesanan_id)){
			$criteria->addCondition("peg_pemesanan_id = ".$this->peg_pemesanan_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->peg_menyetujui_id)){
			$criteria->addCondition("peg_menyetujui_id = ".$this->peg_menyetujui_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function searchTable() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionCriteria();
            $criteria->order = 'supplier.supplier_nama';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
         }
     
        protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with=array('supplier');
        $criteria->addBetweenCondition('date(tglpembelian)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition("supplier_id = ".$this->supplier_id);			
		}
        $criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
        $criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
        if(!empty($this->peg_pemesanan_id)){
			$criteria->addCondition("peg_pemesanan_id = ".$this->peg_pemesanan_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->peg_menyetujui_id)){
			$criteria->addCondition("peg_menyetujui_id = ".$this->peg_menyetujui_id);			
		}
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

        return $criteria;
    }
     
     public function searchPembelianBaranggrafik()
     {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
            $format = new MyFormatter();
            $criteria=new CDbCriteria;
            
            $criteria->select = "count(t.pembelianbarang_id) as jumlah, date(tglpembelian) as data";
            $criteria->group ="date(tglpembelian)";
            $criteria->addBetweenCondition('date(tglpembelian)', $this->tgl_awal, $this->tgl_akhir);
            if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
			}
			if(!empty($this->terimapersediaan_id)){
				$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
			}
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
			}
			if(!empty($this->supplier_id)){
				$criteria->addCondition("supplier_id = ".$this->supplier_id);			
			}
            $criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
            $criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
            if(!empty($this->peg_pemesanan_id)){
				$criteria->addCondition("peg_pemesanan_id = ".$this->peg_pemesanan_id);			
			}
			if(!empty($this->peg_mengetahui_id)){
				$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
			}
			if(!empty($this->peg_menyetujui_id)){
				$criteria->addCondition("peg_menyetujui_id = ".$this->peg_menyetujui_id);			
			}
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
	public function criteria()
	{
		$criteria=new CDbCriteria;
		$criteria->select = 't.*, belibrgdetail_t.*, (belibrgdetail_t.hargabeli) as hargabeli, (belibrgdetail_t.jmlbeli) as jmlbeli';
		$criteria->join= 'INNER JOIN belibrgdetail_t ON t.pembelianbarang_id = belibrgdetail_t.pembelianbarang_id';
		$criteria->addCondition('t.pembelianbarang_id =  belibrgdetail_t.pembelianbarang_id');
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		$criteria->addBetweenCondition('date(t.tglpembelian)',$this->tgl_awal,$this->tgl_akhir);
                
		return $criteria;
	}
                
     public function getTotalharga()
    {
        $criteria=$this->Criteria();
        $criteria->select = 'SUM(belibrgdetail_t.hargabeli *  belibrgdetail_t.jmlbeli)';
        return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
    }
        
        
}

?>
