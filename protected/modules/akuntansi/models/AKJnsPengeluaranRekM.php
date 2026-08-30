<?php

    class AKJnsPengeluaranRekM extends JnspengeluaranrekM
    {
            /**
             * Returns the static model of the specified AR class.
             * @param string $className active record class name.
             * @return AKJnsPengeluaranRekM the static model class
             */
            public static function model($className=__CLASS__)
            {
                    return parent::model($className);
            }
            
            public function searchJenisPengeluaran()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;

                    $criteria->select = 'jenispengeluaran_id';
                    $criteria->compare('jnspengeluaranrek_id',$this->jnspengeluaranrek_id);
                    $criteria->compare('rekening1_id',$this->rekening1_id);
                    $criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
                    $criteria->compare('rekening3_id',$this->rekening3_id);
                    $criteria->compare('rekening5_id',$this->rekening5_id);
                    $criteria->compare('rekening2_id',$this->rekening2_id);
                    $criteria->compare('rekening4_id',$this->rekening4_id);
                    $criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                    $criteria->group='jenispengeluaran_id';
                    
                    if(isset($this->jenispengeluaran_nama))
                    {
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(jenispengeluaran_nama)', strtolower($this->jenispengeluaran_nama), true);
                        $criteria_satu->compare('LOWER(jenispengeluaran_kode)', strtolower($this->jenispengeluaran_kode), true);
                        $criteria_satu->compare('LOWER(jenispengeluaran_namalain)', strtolower($this->jenispengeluaran_namalain), true);
                        $record = JenispengeluaranM::model()->findAll($criteria_satu);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispengeluaran_id;
                        }
                       if(count((array)$data) > 0){
                            $condition = 'jenispengeluaran_id IN ('. implode(',', $data) .')';
                            $criteria->addCondition($condition);
                       }
                    }
                    
                    if(isset($this->rekening_debit)){
//                    var_dump(2);

                        $debit = "D";
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekening_debit),true);
                        $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);

                        $record = JnspengeluaranrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                        var_dump($record->attributes);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispengeluaran_id;
                        }
                        if(count((array)$data)>0){
                               $condition = 'jenispengeluaran_id IN ('. implode(',', $data) .')';
                               $criteria->addCondition($condition);
                        }
                    }

                    if(isset($this->rekeningKredit)){
    //                    var_dump(2);

                            $debit = "K";
                            $criteria_satu = new CDbCriteria;
                            $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekeningKredit),true);
                            $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);

                            $record = JnspengeluaranrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                            var_dump($record->attributes);
                            $data = array();
                            foreach($record as $value)
                            {
                                $data[] = $value->jenispengeluaran_id;
                            }
                            if(count((array)$data)>0){
                                   $condition = 'jenispengeluaran_id IN ('. implode(',', $data) .')';
                                   $criteria->addCondition($condition);
                            }
                    }

                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                    ));
            }
            
            public function searchJenisPengeluaranPrint()
            {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $criteria=new CDbCriteria;

                    $criteria->select = 'jenispengeluaran_id';
                    $criteria->compare('jnspengeluaranrek_id',$this->jnspengeluaranrek_id);
                    $criteria->compare('rekening1_id',$this->rekening1_id);
                    $criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
                    $criteria->compare('rekening3_id',$this->rekening3_id);
                    $criteria->compare('rekening5_id',$this->rekening5_id);
                    $criteria->compare('rekening2_id',$this->rekening2_id);
                    $criteria->compare('rekening4_id',$this->rekening4_id);
                    $criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                    $criteria->group='jenispengeluaran_id';
                    
                    if(isset($this->jenispengeluaran_nama))
                    {
                        $criteria_satu = new CDbCriteria;
                        $criteria_satu->compare('LOWER(jenispengeluaran_nama)', strtolower($this->jenispengeluaran_nama), true);
                        $criteria_satu->compare('LOWER(jenispengeluaran_kode)', strtolower($this->jenispengeluaran_kode), true);
                        $criteria_satu->compare('LOWER(jenispengeluaran_namalain)', strtolower($this->jenispengeluaran_namalalin), true);
                        $record = JenispengeluaranM::model()->findAll($criteria_satu);
                        $data = array();
                        foreach($record as $value)
                        {
                            $data[] = $value->jenispengeluaran_id;
                        }
                        
                       $condition = 'jenispengeluaran_id IN ('. implode(',', $data) .')';
                       $criteria->addCondition($condition);
                    }
                    
                    $criteria->limit = -1;

                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>false,
                    ));
            }

    }

?>