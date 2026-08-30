<?php
class BKPaketbmhpM extends PaketbmhpM {
    public $tipepaketNama;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchData()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->with = array('obatalkes','daftartindakan','kelompokumur', 'tipepaket');
		if(!empty($this->paketbmhp_id)){
			$criteria->addCondition("paketbmhp_id = ".$this->paketbmhp_id);					
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("t.daftartindakan_id = ".$this->daftartindakan_id);					
		}
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition("t.tipepaket_id = ".$this->tipepaket_id);					
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);					
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);					
		}
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id);					
		}
		$criteria->compare('qtypemakaian',$this->qtypemakaian);
		$criteria->compare('qtystokout',$this->qtystokout);
		$criteria->compare('hargapemakaian',$this->hargapemakaian);
		//$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',strtolower($this->obatalkesNama),true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakanNama),true);
		$criteria->compare('LOWER(kelompokumur.kelompokumur_nama)',strtolower($this->kelompokumurNama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}