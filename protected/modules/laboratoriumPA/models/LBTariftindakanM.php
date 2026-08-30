<?php

class LBTariftindakanM extends TariftindakanM {
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->tariftindakan_id)){
			$criteria->addCondition('tariftindakan_id = '.$this->tariftindakan_id);
		}
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakaN_id = '.$this->daftartindakan_id);
		}
		if(!empty($this->komponentarif_id)){
			$criteria->addCondition('komponentarif.komponentarif_id = '.$this->komponentarif_id);
		}
		if(!empty($this->perdatarif_id)){
			$criteria->addCondition('perdatarif_id = '.$this->perdatarif_id);
		}
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->with=array('perdatarif','jenistarif','komponentarif','daftartindakan');
		$criteria->compare('jenistarif.jenistarif_nama',$this->jenistarif->jenistarif_nama);
		$criteria->compare('komponentarif.komponentarif_nama',$this->komponentarif->komponentarif_nama);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

?>
