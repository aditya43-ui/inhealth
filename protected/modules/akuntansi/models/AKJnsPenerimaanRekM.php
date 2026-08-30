<?php

    class AKJnsPenerimaanRekM extends JnspenerimaanrekM
    {
		//public $rekening5_nb;
            public static function model($className=__CLASS__)
            {
                    return parent::model($className);
            }

            public function searchJenisPenerimaan()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;
                    $criteria->select = 'jenispenerimaan_id';
                    $criteria->compare('jnspenerimaanrek_id',$this->jnspenerimaanrek_id);
                    $criteria->compare('rekening5_id',$this->rekening5_id);
                    $criteria->compare('rekening4_id',$this->rekening4_id);
                    $criteria->compare('rekening3_id',$this->rekening3_id);
                    $criteria->compare('rekening2_id',$this->rekening2_id);
                    $criteria->compare('rekening1_id',$this->rekening1_id);
//                    $criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
                    $criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                    $criteria->group = 'jenispenerimaan_id';
                    
                    if(isset($this->jenispenerimaan_nama))
                    {
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(jenispenerimaan_nama)', strtolower($this->jenispenerimaan_nama), true);
                        $criteria_satu->compare('LOWER(jenispenerimaan_kode)', strtolower($this->jenispenerimaan_kode), true);
                        $criteria_satu->compare('LOWER(jenispenerimaan_namalain)', strtolower($this->jenispenerimaan_namalain), true);
                        $record = JenispenerimaanM::model()->findAll($criteria_satu);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispenerimaan_id;
                        }
                        if(count((array)$data)>0){
                            $condition = 'jenispenerimaan_id IN ('. implode(',', $data) .')';
                            $criteria->addCondition($condition);
                        }   
                       
                    }
                    
                    if(isset($this->rekening_debit)){
//                    var_dump(2);

                        $debit = "D";
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekening_debit),true);
                        $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);

                        $record = JnspenerimaanrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                        var_dump($record->attributes);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispenerimaan_id;
                        }
                        if(count((array)$data)>0){
                               $condition = 'jenispenerimaan_id IN ('. implode(',', $data) .')';
                               $criteria->addCondition($condition);
                        }
                    }

                    if(isset($this->rekeningKredit)){
    //                    var_dump(2);

                            $debit = "K";
                            $criteria_satu = new CDbCriteria;
                            $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekeningKredit),true);
                            $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);

                            $record = JnspenerimaanrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                            var_dump($record->attributes);
                            $data = array();
                            foreach($record as $value)
                            {
                                $data[] = $value->jenispenerimaan_id;
                            }
                            if(count((array)$data)>0){
                                   $condition = 'jenispenerimaan_id IN ('. implode(',', $data) .')';
                                   $criteria->addCondition($condition);
                            }
                    }
                    
                    // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                    ));
            }
            
             public function searchJenisPenerimaanPrint()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;
                    $criteria->select = 'jenispenerimaan_id';
                    $criteria->compare('jnspenerimaanrek_id',$this->jnspenerimaanrek_id);
                    $criteria->compare('rekening5_id',$this->rekening5_id);
                    $criteria->compare('rekening4_id',$this->rekening4_id);
                    $criteria->compare('rekening3_id',$this->rekening3_id);
                    $criteria->compare('rekening2_id',$this->rekening2_id);
                    $criteria->compare('rekening1_id',$this->rekening1_id);
                    $criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
                    $criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                    $criteria->group = 'jenispenerimaan_id';
                    // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                    $criteria->limit = -1;
                    
                    if(isset($this->jenispenerimaan_nama))
                    {
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(jenispenerimaan_nama)', strtolower($this->jenispenerimaan_nama), true);
                        $criteria_satu->compare('LOWER(jenispenerimaan_kode)', strtolower($this->jenispenerimaan_kode), true);
                        $criteria_satu->compare('LOWER(jenispenerimaan_namalain)', strtolower($this->jenispenerimaan_namalain), true);
                        $record = JenispenerimaanM::model()->findAll($criteria_satu);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispenerimaan_id;
                        }
                        
                       $condition = 'jenispenerimaan_id IN ('. implode(',', $data) .')';
                       $criteria->addCondition($condition);
                    }

                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>false,
                    ));
            }
    }

?>