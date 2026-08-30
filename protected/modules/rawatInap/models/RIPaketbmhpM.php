<?php

class RIPaketbmhpM extends PaketbmhpM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPaket()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
            
		 $criteria->select = 'daftartindakan_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, kelompokumur_m.kelompokumur_id, kelompokumur_m.kelompokumur_nama,t.hargapemakaian';        
        $criteria->join = 'JOIN obatalkes_m ON obatalkes_m.obatalkes_id = t.obatalkes_id
        					JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = t.daftartindakan_id
        					JOIN kelompokumur_m ON kelompokumur_m.kelompokumur_id = t.kelompokumur_id';
        $criteria->group = $criteria->select;
		
		
		if(!empty($this->paketbmhp_id)){
			$criteria->addCondition("paketbmhp_id = ".$this->paketbmhp_id);		
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);		
		}
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);		
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
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',strtolower($this->obatalkesNama),true);
		$criteria->compare('LOWER(daftartindakan_m.daftartindakan_nama)',strtolower($this->daftartindakanNama),true);
		$criteria->compare('LOWER(kelompokumur_m.kelompokumur_nama)',strtolower($this->kelompokumurNama),true);
		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}