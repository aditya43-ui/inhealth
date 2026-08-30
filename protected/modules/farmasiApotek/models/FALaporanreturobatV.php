<?php
class FALaporanreturobatV extends LaporanreturobatV
{   public $data, $jumlah, $subtotal;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
        
        /**
     * data provider untuk table
     */
    public function searchTable(){
        $criteria = $this->functionCriteria(true);
		$criteria->order = " tglretur DESC ";
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    /**
     * data provider untuk print
     */
    public function searchPrint(){
        $criteria = $this->functionCriteria(true);
		$criteria->order = " tglretur DESC ";
        
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    /**
     * data provider untuk grafik
     */
    public function searchGrafik(){
        
        $criteria = $this->functionCriteria();

        $criteria2 = $criteria;
        $criteria2->select = 'count(noreturresep) as jumlah, jenispenjualan as data';
       // if (!empty($this->noreturresep)){
         //   $criteria2->select .= ', jenisobatalkes_nama as data'; 
           // $criteria2->group = 'jenisobatalkes_nama';
       // }else{
         //   $criteria2->select .= ', carabayar_nama as data'; 
           // $criteria2->group = 'carabayar_nama';
       // }
		$criteria2->group = 'data';
		$criteria2->order = 'jumlah DESC';
		 
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria2,
        ));
        
    }
    
    /**
     * method untuk criteria
     * @return CDbCriteria 
     */
    public function functionCriteria($params = null)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            if (isset($params)){
                $criteria->select = 'tglretur,jenispenjualan,noreturresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur,carabayar_nama, penjamin_nama, obatalkes_nama, satuankecil_nama, qty_retur, hargasatuan, totalretur, (qty_retur * hargasatuan) as subtotal';
                $criteria->group = 'tglretur,jenispenjualan,noreturresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur,carabayar_nama, penjamin_nama, obatalkes_nama, satuankecil_nama, qty_retur, hargasatuan, totalretur';
            }else{
                $criteria->select = 'obatalkes_nama, tglretur,jenispenjualan,noreturresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur, carabayar_nama, penjamin_nama';
                $criteria->group = 'obatalkes_nama,tglretur,jenispenjualan,noreturresep,no_rekam_medik, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, umur,carabayar_nama, penjamin_nama';
            }
						
			
			
			
            $criteria->addBetweenCondition('DATE(tglretur)',$this->tgl_awal,$this->tgl_akhir);
			
			if (!empty($this->jenispenjualan)){
				$criteria->addInCondition("jenispenjualan", $this->jenispenjualan);
			}
            //$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);						
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);            
			
            return $criteria;
    }
}