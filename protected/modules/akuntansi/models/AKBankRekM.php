<?php
class AKBankRekM extends BankrekM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchBank()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->select = 'bank_id';
		$criteria->compare('bankrek_id',$this->bankrek_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
//		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                
                $criteria->group = 'bank_id';
                
                if(isset($this->namabank))
                {
                    $criteria_satu = new CDbCriteria;
                    $criteria_satu->compare('LOWER(namabank)', strtolower($this->namabank),true);
                    if(isset($this->propinsi_nama)){
                        
                        $criteria_satu->compare('LOWER(propinsi.propinsi_nama)', strtolower($this->propinsi_nama),true);
                        
                    }else if(isset($this->kabupaten_nama)){
                        
                        $criteria_satu->compare('LOWER(kabupaten.kabupaten_nama)', strtolower($this->kabupaten_nama),true);
                        
                    }else if(isset($this->matauang)){
                        
                        $criteria_satu->compare('LOWER(matauang.matauang)', strtolower($this->matauang),true);
                        
                    }else if(isset($this->norekening)){
                        
                        $criteria_satu->compare('LOWER(norekening)', strtolower($this->norekening),true);
                        
                    }else if(isset($this->alamatbank)){
                        
                        $criteria_satu->compare('LOWER(alamatbank)', strtolower($this->alamatbank),true);
                        
                    }else if(isset($this->emailbank)){
                        
                        $criteria_satu->compare('LOWER(emailbank)', strtolower($this->emailbank),true);
                        $criteria_satu->compare('LOWER(website)', strtolower($this->emailbank),true);
                        
                    }else if(isset($this->cabangdari)){
                        
                        $criteria_satu->compare('LOWER(cabangdari)', strtolower($this->cabangdari),true);
                        
                    }else if(isset($this->faxbank)){
                        
                        $criteria_satu->compare('faxbank', $this->faxbank,true);
                        
                    }else if(isset($this->kodepos)){
                        
                        $criteria_satu->compare('kodepos', $this->kodepos,true);
                        
                    }else if(isset($this->telpbank1)){
                        
                        $criteria_satu->compare('telpbank1', $this->telpbank1,true);
                        $criteria_satu->compare('telpbank2', $this->telpbank1,true);
                        
                    }
                    
                    
                    $record = BankM::model()->with('propinsi','kabupaten','matauang')->findAll($criteria_satu);
                    $data = array();
                    foreach($record as $value)
                    {
                        $data[] = $value->bank_id;
                    }

                    if(count((array)$data)>0){
                        $condition = 'bank_id IN ('. implode(',', $data) .')';
                        $criteria->addCondition($condition);
                    }
                   
                }
                
                if(isset($this->rekening_debit)){
//                    var_dump(2);

                    $debit = "D";
                    $criteria_satu = new CDbCriteria;
                    $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekening_debit),true);
                    $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);

                    $record = BankrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                    //var_dump($record->attributes);
                    $data = array();
                    foreach($record as $value)
                    {
                        $data[] = $value->bank_id;
                    }
                    if(count((array)$data)>0){
                           $condition = 'bank_id IN ('. implode(',', $data) .')';
                           $criteria->addCondition($condition);
                    }
                }

                if(isset($this->rekeningKredit)){
//                    var_dump(2);

                        $debit = "K";
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekeningKredit),true);
                        $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);

                        $record = BankrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                       // var_dump($record->attributes);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->bank_id;
                        }
                        if(count((array)$data)>0){
                               $condition = 'bank_id IN ('. implode(',', $data) .')';
                               $criteria->addCondition($condition);
                        }
                }
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchBankPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->select = 'bank_id';
		$criteria->compare('bankrek_id',$this->bankrek_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                
                $criteria->group = 'bank_id';
                
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}

	
}

?>