<?php

class ROLaporanjasatindakan extends LaporanjasatindakanradV {

    public $jumlah;
    public $data;
    public $tick;
    public $sumtarifsatuan;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir, $instalasi_id, $instalasi_nama, $ruangan_nama, $ruangan_create, $ruangan_id;
    

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();
         $criteria->select = 'sum(qty_tindakan) as qty_tindakan, tarif_satuan, pemeriksaanrad_nama, pemeriksaanrad_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id,penjamin_nama, create_ruangan, jenispemeriksaanrad_id';
         $criteria->group = 'pemeriksaanrad_nama, pemeriksaanrad_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id, penjamin_nama, tarif_satuan, create_ruangan, jenispemeriksaanrad_id';
        return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        $criteria->select = 'sum(qty_tindakan) as jumlah, pemeriksaanrad_nama as data';
        $criteria->group = 'pemeriksaanrad_nama';
        if (!empty($this->carabayar_id)) {
            $criteria->select .= ', penjamin_nama as tick';
            $criteria->group .= ', penjamin_nama';
        } else {
            $criteria->select .= ', carabayar_nama as tick';
            $criteria->group .= ', carabayar_nama';
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->select = 'sum(qty_tindakan) as qty_tindakan, tarif_satuan, pemeriksaanrad_nama, pemeriksaanrad_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id,penjamin_nama, create_ruangan, jenispemeriksaanrad_id';
        $criteria->group = 'pemeriksaanrad_nama, pemeriksaanrad_kode, daftartindakan_id, carabayar_id, carabayar_nama,penjamin_id, penjamin_nama, tarif_satuan, create_ruangan, jenispemeriksaanrad_id';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function functionCriteria(){
        $criteria = new CDbCriteria();
        
     
        if (!is_array($this->penjamin_id)){
            $this->penjamin_id = 0;
        }
        
        $criteria->addBetweenCondition('tgl_tindakan', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("penjamin_id",$this->penjamin_id); 	
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("penjamin_id",$this->penjamin_id); 	
			}else{
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);

		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("carabayar_id",$this->carabayar_id); 	
			if (is_array($this->carabayar_id)){
				$criteria->addInCondition("carabayar_id",$this->carabayar_id); 	
			}else{
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
			}
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);

		// if(!empty($this->instalasi_id)){
		// 	$criteria->addInCondition("instalasi_id",$this->instalasi_id); 	
		// 	if (is_array($this->instalasi_id)){
		// 		$criteria->addInCondition("instalasi_id",$this->instalasi_id); 	
		// 	}else{
		// 		$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 	
		// 	}
		// }

		if(!empty($this->instalasi_id)){
            // var_dump($this->instalasi_id[0]); die;
            $ruangan_id = [];
            for ($i = 0; $i < count($this->instalasi_id); $i++) {
                $ruangan_id[] = InstalasiM::model()->findByPk($this->instalasi_id[$i])->ruanganMs[0]->ruangan_id;
            }
			$criteria->addInCondition("create_ruangan",$ruangan_id); 	
            
			// $criteria->addCondition("create_ruangan=".$ruangan_id); 	
            // $criteria->compare('create_ruangan', $ruangan_id);
            // var_dump($ruangan_id); die;

			// $criteria->addCondition("create_ruangan = ".$ruangan_id); 	

			// if (is_array($this->instalasi_id)){
			// 	$criteria->addInCondition("create_ruangan",$ruangan_id); 	
			// }else{
			// 	$criteria->addCondition("create_ruangan=".$ruangan_id); 	
			// }
		}

        if(!empty($this->ruangan_id)){
			$criteria->addInCondition("ruangan_id",$this->ruangan_id); 	
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition("ruangan_id",$this->ruangan_id); 	
			}else{
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
			}
		}
		
        $criteria->compare('daftartindakan_id', $this->daftartindakan_id);
        $criteria->compare('tgl_tindakan', $this->tgl_tindakan, true);
		
        
        
        return $criteria;
    }
    
    public function getTotalTarif()
	{
		return $this->tarif_satuan * $this->qty_tindakan;
	}

    public function totals()
    {
        $criteria=$this->functionCriteria();
    
        $criteria->select='SUM(qty_tindakan)';
    
        return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
    
    }

    public function jumlah($data)
    {
        $jumlah = preg_replace("/[^0-9]/","",$data);
        
        return $jumlah;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}