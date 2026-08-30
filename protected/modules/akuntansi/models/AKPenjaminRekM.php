<?php
class AKPenjaminRekM extends PenjaminrekM
{
	public $is_pilihan;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchPenjamin()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->select = 'penjamin_id';
				$criteria->compare('penjaminrek_id',$this->penjaminrek_id);		
				$criteria->compare('rekening3_id',$this->rekening3_id);
				$criteria->compare('rekening4_id',$this->rekening4_id);
				$criteria->compare('rekening2_id',$this->rekening2_id);
				$criteria->compare('rekening5_id',$this->rekening5_id);
				$criteria->compare('rekening1_id',$this->rekening1_id);
				$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                $criteria->group = 'penjamin_id';
               
                
                if(isset($this->carabayar_nama))
                {
                    $criteria_satu = new CDbCriteria;
                    $criteria_satu->compare('LOWER(carabayar.carabayar_nama)', strtolower($this->carabayar_nama),true);
                    if(isset($this->penjamin_nama)){
                        $criteria_satu->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama),true); 
                    }
                    $record = PenjaminpasienM::model()->with("carabayar")->findAll($criteria_satu);
                    $data = array();
                    foreach($record as $value)
                    {
                        $data[] = $value->penjamin_id;
                    }

                   $condition = 'penjamin_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
                }

                if(isset($this->rekening_debit)){


					$debit = "D";
                    $criteria_satu = new CDbCriteria;
                    $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekening_debit),true);
                    $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);
                    
                    $record = PenjaminrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                    var_dump($record->attributes);
                    $data = array();
                    foreach($record as $value)
                    {
                        $data[] = $value->penjamin_id;
                    }
                    if(count((array)$data)>0){
                           $condition = 'penjamin_id IN ('. implode(',', $data) .')';
                           $criteria->addCondition($condition);
                    }
                }
                
                if(isset($this->rekeningKredit)){

					$debit = "K";
                    $criteria_satu = new CDbCriteria;
                    $criteria_satu->compare('LOWER(rekeningdebit.nmrekening5)', strtolower($this->rekeningKredit),true);
                    $criteria_satu->compare('LOWER(t.saldonormal)',strtolower($debit),true);
                    
                    $record = PenjaminrekM::model()->with("rekeningdebit","rekeningkredit")->findAll($criteria_satu);
                    var_dump($record->attributes);
                    $data = array();
                    foreach($record as $value)
                    {
                        $data[] = $value->penjamin_id;
                    }
                    if(count((array)$data)>0){
                           $condition = 'penjamin_id IN ('. implode(',', $data) .')';
                           $criteria->addCondition($condition);
                    }
                }

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
        public function searchPenjaminPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->select = 'penjamin_id';
				$criteria->compare('penjaminrek_id',$this->penjaminrek_id);
				$criteria->compare('penjamin_id',$this->penjamin_id);
				$criteria->compare('rekening3_id',$this->rekening3_id);
				$criteria->compare('rekening4_id',$this->rekening4_id);
				$criteria->compare('rekening2_id',$this->rekening2_id);
				$criteria->compare('rekening5_id',$this->rekening5_id);
				$criteria->compare('rekening1_id',$this->rekening1_id);
				$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
                $criteria->group = 'penjamin_id';
                
                if(isset($this->carabayar_id))
                {
                    $criteria_satu = new CDbCriteria;
                    $criteria_satu->compare('carabayar_id', $this->carabayar_id, true);
                    $record = CarabayarM::model()->findAll($criteria_satu);
                    $data = array();
                    foreach($record as $value)
                    {
                        $data[] = $value->carabayar_id;
                    }

                   $condition = 'carabayar_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
                }
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}

?>