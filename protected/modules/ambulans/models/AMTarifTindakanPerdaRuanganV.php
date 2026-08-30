<?php
class AMTarifTindakanPerdaRuanganV  extends TariftindakanperdaruanganV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
       public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//                if ((!empty($this->kelaspelayanan_id)) || (!empty($this->daftartindakan_id)) || (!empty($this->kategoritindakan_id))){
                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                    $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_id),true);
                    $criteria->compare('kategoritindakan_id',  $this->kategoritindakan_id);
                    $criteria->compare('ruangan_id',$this->ruangan_id);
//                }
//                else{
//                    $criteria->compare('ruangan_id', 0);
//                }
		
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        

	
}

