<?php

class GUInformasistokbarangV extends InformasistokbarangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokbarangV the static model class
	 */
        public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;
        public $jumlah, $data;
        public $stok;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
                if(!empty($this->jenisbarang_id)){
			$criteria->addCondition('jenisbarang_id = '.$this->jenisbarang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
                if($this->ceklisminimal){
                    $criteria->addCondition('inventarisasi_stok <= minimalstok');
                }
		return $criteria;
	}
        
        public function searchBarangRuangan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
                $criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}else{
                    $criteria->addCondition('ruangan_id is null ');
                }
		//if(!empty($this->instalasi_id)){
		//	$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		//}
                $criteria->limit=10;
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
                
        
        
	/**
	 * untuk informasi stok
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        
        public function searchMaterialHabisTable() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionMaterialHabisCriteria();
            $criteria->order = 'ruangan_nama, barang_nama ASC';
            
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchMaterialHabisPrint() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionMaterialHabisCriteria();
            $criteria->order = 'ruangan_nama, barang_nama ASC';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                    ));
        }

        protected function functionMaterialHabisCriteria() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama), TRUE);
            $criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri), TRUE);
            $criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk), TRUE);
            $criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode), TRUE);
            
            if(!empty($this->stok)){
                if(is_array($this->stok)){
                    $strCriteriaStokAda = "";
                    $strCriteriaStokHbs = "";
                    foreach ($this->stok as $srcStock){
                        if ($srcStock == '0'){
                            $strCriteriaStokHbs = " inventarisasi_stok = 0 "; 
                        }
                        if ($srcStock == '1'){
                            $strCriteriaStokAda = " inventarisasi_stok > 0 "; 
                        }
                    }
                    if(!empty($strCriteriaStokHbs) || !empty($strCriteriaStokAda)){
                        $strCriteriaStk = "";
                        if(!empty($strCriteriaStokHbs) && !empty($strCriteriaStokAda)){
                            $strCriteriaStk = $strCriteriaStokHbs. " OR " . $strCriteriaStokAda;
                        }else{
                            if(!empty($strCriteriaStokHbs)){
                                $strCriteriaStk = $strCriteriaStokHbs;
                            }
                            
                            if(!empty($strCriteriaStokAda)){
                               $strCriteriaStk = $strCriteriaStokAda; 
                            }
                        }
                        $criteria->addCondition($strCriteriaStk);
                    }
                    
                }else{
                    if ($this->stok == '0'){
                        $criteria->addCondition(" inventarisasi_stok = 0 ");
                    }elseif ($this->stok == '1'){
                        $criteria->addCondition(" inventarisasi_stok > 0 ");
                    }
                }
            }
            
            
            if(!empty($this->ruangan_id)){                    
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }else{
               if (!empty($this->instalasi_id)){
                   $criteria->compare("instalasi_id", $this->instalasi_id);
               }
            }
            


            return $criteria;
        }

         public function searchMaterialHabisGrafik()
         {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = "count(barang_id) as jumlah , (CASE WHEN inventarisasi_stok > 0 THEN 'Stok Ada' ELSE 'Habis' END) as data";
                
                $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama), TRUE);
                $criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri), TRUE);
                $criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk), TRUE);
                $criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode), TRUE);
                
                if(!empty($this->stok)){
                if(is_array($this->stok)){
                    $strCriteriaStokAda = "";
                    $strCriteriaStokHbs = "";
                    foreach ($this->stok as $srcStock){
                        if ($srcStock == '0'){
                            $strCriteriaStokHbs = " inventarisasi_stok = 0 "; 
                        }
                        if ($srcStock == '1'){
                            $strCriteriaStokAda = " inventarisasi_stok > 0 "; 
                        }
                    }
                    if(!empty($strCriteriaStokHbs) || !empty($strCriteriaStokAda)){
                        $strCriteriaStk = "";
                        if(!empty($strCriteriaStokHbs) && !empty($strCriteriaStokAda)){
                            $strCriteriaStk = $strCriteriaStokHbs. " OR " . $strCriteriaStokAda;
                        }else{
                            if(!empty($strCriteriaStokHbs)){
                                $strCriteriaStk = $strCriteriaStokHbs;
                            }
                            
                            if(!empty($strCriteriaStokAda)){
                               $strCriteriaStk = $strCriteriaStokAda; 
                            }
                        }
                        $criteria->addCondition($strCriteriaStk);
                    }
                    
                }else{
                    if ($this->stok == '0'){
                        $criteria->addCondition(" inventarisasi_stok = 0 ");
                    }elseif ($this->stok == '1'){
                        $criteria->addCondition(" inventarisasi_stok > 0 ");
                    }
                }
            }
                
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->compare("instalasi_id", $this->instalasi_id);
                   }
                }
                $criteria->group = 'inventarisasi_stok, ruangan_nama ';
                $criteria->order = 'jumlah DESC';

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }      
        
        public function searchDialogBarangStok()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = 'barang_id, barang_nama, barang_satuan, barang_type, barang_ukuran, barang_bahan, minimalstok, sum(inventarisasi_stok) as inventarisasi_stok';
                $criteria->group = 'barang_id, barang_nama, barang_satuan, barang_type, barang_ukuran, barang_bahan, minimalstok';
                $criteria->compare('LOWER(barang_nama)', strtolower($this->barang_nama), true);
                $criteria->compare('LOWER(barang_type)', strtolower($this->barang_type), true);
                $criteria->compare('LOWER(barang_satuan)', strtolower($this->barang_satuan), true);
                $criteria->compare('LOWER(barang_ukuran)', strtolower($this->barang_ukuran), true);
                $criteria->compare('LOWER(barang_bahan)', strtolower($this->barang_bahan), true);
                $criteria->addCondition('inventarisasi_stok <= minimalstok');
                $criteria->addCondition(" ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
    
    public function searchPrint() {
        $prov = $this->search();
        $prov->criteria->limit = -1;
        $prov->criteria->order = "inventarisasi_stok";
        $prov->sort = false;
        $prov->pagination = false;
        
        return $prov;
    }
    
    public function searchInformasiMinimum()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria; 
            if(!empty($this->jenisbarang_id)){
                $criteria->addCondition('jenisbarang_id = '.$this->jenisbarang_id);
            }
            $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama), TRUE);
            $criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri), TRUE);
            $criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk), TRUE);
            $criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode), TRUE);
            $criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),false);
            $criteria->addCondition('inventarisasi_stok <= minimalstok');
            
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
            ));
    }
    
    public function searchPrintInformasiMinimum()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria; 
            if(!empty($this->jenisbarang_id)){
                $criteria->addCondition('jenisbarang_id = '.$this->jenisbarang_id);
            }
            $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama), TRUE);
            $criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri), TRUE);
            $criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk), TRUE);
            $criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode), TRUE);
            $criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),false);
            $criteria->addCondition('inventarisasi_stok <= minimalstok');
            
            return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                'pagination'=>false
            ));
    }
}