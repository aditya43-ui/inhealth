<?php

class RJTindakanRuanganV extends TindakanruanganV
{
    public $daftartindakan_kode;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanpelayananT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->daftartindakan_id)){
				$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);		
			}
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
			if(!empty($this->kategoritindakan_id)){
				$criteria->addCondition("kategoritindakan_id = ".$this->kategoritindakan_id);		
			}
            $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
            $criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
            $criteria->compare('persendiskon_tind',$this->persendiskon_tind);
            $criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
            $criteria->compare('persencyto_tind',$this->persencyto_tind);
			if(!empty($this->kelompoktindakan_id)){
				$criteria->addCondition("kelompoktindakan_id = ".$this->kelompoktindakan_id);		
			}
            $criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
			if(!empty($this->komponentarif_id)){
				$criteria->addCondition("komponentarif_id = ".$this->komponentarif_id);		
			}
            $criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);		
			}
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);		
			}
            $criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
			}
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
?>
