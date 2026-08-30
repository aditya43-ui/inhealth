<?php

class ATLaporanpendapatanruanganV extends LaporanpendapatanruanganV {

    public $jumlah;
    public $data;
    public $tick;
    public $sumtarifsatuan;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data';
        $criteria->group = 'kelaspelayanan_nama';
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

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function functionCriteria(){
        $criteria = new CDbCriteria();
        
        if (!is_array($this->kelaspelayanan_id)){
            $this->kelaspelayanan_id = 0;
        }
        if (!is_array($this->penjamin_id)){
            $this->penjamin_id = 0;
        }
        
//        $criteria->join = " JOIN tindakanpelayanan_t tp ON t.tindakanpelayanan_id = tp.tindakanpelayanan_id "
//                        . " JOIN pegawai_m p ON p.pegawai_id = tp.dokterpemeriksa1_id";
        
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
//		if(!empty($this->penjamin_id)){
//			$criteria->addInCondition("penjamin_id",$this->penjamin_id); 	
//			if (is_array($this->penjamin_id)){
//				$criteria->addInCondition("penjamin_id",$this->penjamin_id); 	
//			}else{
//				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
//			}
//		}
//        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
//		if(!empty($this->carabayar_id)){
//			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
//		}
//        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        
        //Carabayar
        if(!empty($this->carabayar_id)){
                $criteria->addInCondition("carabayar_id ", $this->carabayar_id);
        }
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if(!empty($this->penjamin_id)){
                $criteria->addInCondition("penjamin_id ", $this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        
//        if(!empty($this->kelaspelayanan_id)){
//                $criteria->addInCondition("kelaspelayanan_id",$this->kelaspelayanan_id); 	
//                if (is_array($this->kelaspelayanan_id)){
//                        $criteria->addInCondition("kelaspelayanan_id",$this->kelaspelayanan_id); 	
//                }else{
//                        $criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
//                }
//        }
//
//        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        
        //Kelas Pelayanan
        if(!empty($this->kelaspelayanan_id)){
                $criteria->addInCondition("kelaspelayanan_id ", $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        
        //Dokter
        
        if (!empty($this->nama_pegawai)){
            $criteria->addInCondition("nama_pegawai", $this->nama_pegawai);
        }
        
        
        if(!empty($this->instalasi_id)){
                $criteria->addCondition("instalasi_id = ".$this->instalasi_id); 	
        }
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
        if(!empty($this->tipepaket_id)){
                $criteria->addCondition("tipepaket_id = ".$this->tipepaket_id); 	
        }
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
//        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        
        
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}