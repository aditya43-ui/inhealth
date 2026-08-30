<?php
class AKRekeningpelayananV extends RekeningpelayananV
{
    public $mappingruangan, $mappingpelayanan;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
            $criteria=new CDbCriteria;

            if (!empty($this->ruangan)) {
                $criteria->addCondition('ruangan = ' . $this->ruangan);
            }

            if (!empty($this->komponentarif_id)) {
                    $criteria->addCondition('komponentarif_id = ' . $this->komponentarif_id);
            }
            $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5),true);	
            $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5),true);
            $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama),true);
            
            if (!empty($this->saldonormal)){
                if (strtolower($this->saldonormal) == 'd' || strtolower($this->saldonormal) == 'debit'){
                        $criteria->addInCondition(" LOWER(saldonormal) ",array('d','debit'));
                }

                if (strtolower($this->saldonormal) == 'k' || strtolower($this->saldonormal) == 'kredit'){
                        $criteria->addInCondition(" LOWER(saldonormal) ",array('k','kredit'));
                }
            }
            
            if (!empty($this->mappingpelayanan)){
                if($this->mappingpelayanan  == 'sudah'){
                    $criteria->addCondition('pelayananrek_id IS NOT NULL');
                }else{
                    $criteria->addCondition('pelayananrek_id IS NULL');
                }
            }
            
            if (!empty($this->mappingruangan)){
                if($this->mappingruangan == 'sudah'){
                    $criteria->addCondition('ruangan IS NOT NULL');
                }else{
                    $criteria->addCondition('ruangan IS NULL');
                }
            }

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
        public function searchPrint()
	{
		$criteria=new CDbCriteria;

                 if (!empty($this->ruangan)) {
                    $criteria->addCondition('ruangan = ' . $this->ruangan);
                }

                if (!empty($this->komponentarif_id)) {
                        $criteria->addCondition('komponentarif_id = ' . $this->komponentarif_id);
                }
                $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5),true);	
                $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5),true);
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama),true);

                if (!empty($this->saldonormal)){
                    if (strtolower($this->saldonormal) == 'd' || strtolower($this->saldonormal) == 'debit'){
                            $criteria->addInCondition(" LOWER(saldonormal) ",array('d','debit'));
                    }

                    if (strtolower($this->saldonormal) == 'k' || strtolower($this->saldonormal) == 'kredit'){
                            $criteria->addInCondition(" LOWER(saldonormal) ",array('k','kredit'));
                    }
                }

                if (!empty($this->mappingpelayanan)){
                    if($this->mappingpelayanan  == 'sudah'){
                        $criteria->addCondition('pelayananrek_id IS NOT NULL');
                    }else{
                        $criteria->addCondition('pelayananrek_id IS NULL');
                    }
                }

                if (!empty($this->mappingruangan)){
                    if($this->mappingruangan == 'sudah'){
                        $criteria->addCondition('ruangan IS NOT NULL');
                    }else{
                        $criteria->addCondition('ruangan IS NULL');
                    }
                }
                
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}

	
}

?>