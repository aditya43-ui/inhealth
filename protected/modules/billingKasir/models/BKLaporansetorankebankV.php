<?php
class BKLaporansetorankebankV extends LaporansetorankebankV
{
	public $totalpenerimaan,$jmlkelas, $penerimaanrj;
        public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchSetoranKeBank(){
            $criteria = new CDbCriteria;
            $criteria->group = 'komponentarif_id, komponentarif_nama';
            $criteria->select = $criteria->group.', MAX(kelaspelayanan_id), MAX(ruangan_id), \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
            $criteria->order = 'komponentarif_nama';
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
        
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
        
        public function searchPrintSetoranKeBank(){
            $criteria = new CDbCriteria;
            $criteria->group = 'komponentarif_id, komponentarif_nama';
            $criteria->select = $criteria->group.', MAX(kelaspelayanan_id), MAX(ruangan_id), \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
//            $criteria->select = 'DISTINCT (komponentarif_id), komponentarif_nama, kelaspelayanan_id, kelaspelayanan_nama';
            $criteria->order = 'komponentarif_nama';
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
        
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
            ));
        }
		
		 public function searchSetoranKeBankBaru(){
            $criteria = new CDbCriteria;
            $criteria->group = 'tgldisetor, nostruksetor, setorbank_id, nama_pegawai, jumlahsetoran';
            $criteria->select = $criteria->group;
            $criteria->order = 'tgldisetor ASC';
            $criteria->addBetweenCondition('date(tgldisetor)', $this->tgl_awal, $this->tgl_akhir);
        
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
        
        public function searchPrintSetoranKeBankBaru(){
            $criteria = new CDbCriteria;
            //$criteria->group = 'komponentarif_id, komponentarif_nama';
            //$criteria->select = $criteria->group.', MAX(kelaspelayanan_id), MAX(ruangan_id), \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
//            $criteria->select = 'DISTINCT (komponentarif_id), komponentarif_nama, kelaspelayanan_id, kelaspelayanan_nama';
            $criteria->order = 'tgldisetor ASC';
            $criteria->addBetweenCondition('date(tgldisetor)', $this->tgl_awal, $this->tgl_akhir);
        
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
            ));
        }
		
		
        public function totalBedaKelas(){
            $criteria = new CDbCriteria;
            $criteria->select = 'DISTINCT (kelaspelayanan_id), kelaspelayanan_nama';
            $criteria->order = 'kelaspelayanan_nama';
            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
            $beda = BKLaporansetorankebankV::model()->findAll($criteria);

            return $beda;
        }
        
        public function getRawatJalan($komponentarif_id){
            
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(totalpenerimaan) as totalpenerimaan';
			if(!empty($komponentarif_id)){
				$criteria->addCondition("komponentarif_id = ".$komponentarif_id);					
			}
            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetorankebankV::model()->find($criteria)->totalpenerimaan;
            
            if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
        public function getTotalRJ(){
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(totalpenerimaan) as totalpenerimaan';
            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetorankebankV::model()->find($criteria)->totalpenerimaan;
            
            if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
        
        
        public function getRawatInap($komponentarif_id, $kelaspelayanan_id){
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(totalpenerimaan) as totalpenerimaan';
			if(!empty($komponentarif_id)){
				$criteria->addCondition("komponentarif_id = ".$komponentarif_id);					
			}
			if(!empty($kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);					
			}
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetorankebankV::model()->find($criteria)->totalpenerimaan;
            
            if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
        
        public function getTotalRI($kelaspelayanan_id){
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(totalpenerimaan) as totalpenerimaan';
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
			if(!empty($kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);					
			}
            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetorankebankV::model()->find($criteria)->totalpenerimaan;
            
            if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
        
        public function getTotalKomponen($komponentarif_id){
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(totalpenerimaan) as totalpenerimaan';
			if(!empty($komponentarif_id)){
				$criteria->addCondition("komponentarif_id = ".$komponentarif_id);					
			}
            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetorankebankV::model()->find($criteria)->totalpenerimaan;
            
            if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
        
        public function getTotal(){
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(totalpenerimaan) as totalpenerimaan';
            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetorankebankV::model()->find($criteria)->totalpenerimaan;
            
            if (empty($jumlah)){
                $jumlah = 0;
            }
            return $jumlah;
        }
		
		

}