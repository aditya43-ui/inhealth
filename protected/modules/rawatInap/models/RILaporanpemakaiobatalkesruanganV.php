<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class RILaporanpemakaiobatalkesruanganV extends LaporanpemakaiobatalkesruanganV  {

	public $tgl_awal, $bln_awal, $thn_awal;
	public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode, $tick, $data, $jumlah;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchGrafik()
	{
		$criteria=new CDbCriteria;

		if (is_array($this->jenisobatalkes_id)){
			$criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
		} else {
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addInCondition("jenisobatalkes_id",$this->jenisobatalkes_id);				
			}
		}
		$criteria->select = 'count(obatalkes_nama) as jumlah, jenisobatalkes_nama as tick, obatalkes_nama as data';
		$criteria->group = 'jenisobatalkes_nama, obatalkes_nama';
                               
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);				
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);				
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
		
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);				
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->addBetweenCondition('tglpemakaianobat',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchTable()
	{

		$criteria=new CDbCriteria;

		if (is_array($this->jenisobatalkes_id)){
                    $criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
		}
		else{
                    if(!empty($this->jenisobatalkes_id)){
                        $criteria->addInCondition('jenisobatalkes_id ='.$this>jenisobatalkes_id);
                    }
			
		}      
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);				
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->addBetweenCondition('tglpemakaianobat',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->ruangan_id)){
                    $criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;

		if (is_array($this->jenisobatalkes_id)){
			$criteria->addInCondition('jenisobatalkes_id',$this->jenisobatalkes_id);
		}
		else{
                    if(!empty($this->jenisobatalkes_id)){
                        $criteria->addInCondition('jenisobatalkes_id ='.$this>jenisobatalkes_id);
                    }
			
		}      
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);				
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->addBetweenCondition('tglpemakaianobat',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

}

?>
