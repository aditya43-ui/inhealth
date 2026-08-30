<?php
class FALaporanfarmasikopnameV extends LaporanfarmasikopnameV
{
    public $data, $jumlah;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchTable()
    {
            $criteria=new CDbCriteria;
			$criteria->addBetweenCondition('date(tglstokopname)',$this->tgl_awal,$this->tgl_akhir);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    public function searchTableGF()
    {
            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('date(tglstokopname)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
			}
            $criteria->addCondition('ruangan_id = 86');
          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
       /**
     * data provider untuk grafik
     */
    public function searchGrafik(){
        
        $criteria2=new CDbCriteria;

        $criteria2->addBetweenCondition('date(tglstokopname)',$this->tgl_awal,$this->tgl_akhir);
        $criteria2->select = 'count(stokopname_id) as jumlah';
        $criteria2->select .= ', obatalkes_nama as data'; 
        $criteria2->group = 'obatalkes_nama';
    
        return  new CActiveDataProvider($this, array(
                    'criteria'=>$criteria2,
        ));
        
    }
        
        
    public function searchPrint()
    {
        $criteria=new CDbCriteria;

        $criteria->addBetweenCondition('date(tglstokopname)',$this->tgl_awal,$this->tgl_akhir);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    public function searchPrintGF()
    {
        $criteria=new CDbCriteria;

        $criteria->addBetweenCondition('date(tglstokopname)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
        $criteria->addCondition('ruangan_id = 86');
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }

}