<?php

class BKRekeningakuntansiV extends RekeningakuntansiV
{
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return AnamnesaT the static model class
    */
    public $rekening1_id;
    public $id_temp_rek;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getInfoRekening()
    {
        $criteria = new CDbCriteria;
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
		}
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
		}
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
		}
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, nourutrek';
        $result = RekeningakuntansiV::model()->find($criteria);
        return $result;
    }
    
    public function cariRekening()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
        $criteria->compare('LOWER(nmrekeninglain5)',strtolower($this->nmrekeninglain5),true);
//        $criteria->addCondition('kdrekening5 IS NOT NULL');
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, nourutrek';
        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria,
            )
        );
    }
    
    public function getKodeRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3 . "-" . $this->kdrekening4 . "-" . $this->kdrekening5;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3 . "-" . $this->kdrekening4;
            }else{
                $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3;
            }
        }
        
        return $kode_rekening;
    }
    
    public function getNamaRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->nmrekening5;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->nmrekening4;
            }else{
                $kode_rekening = $this->nmrekening3;
            }
        }
        
        return $kode_rekening;
    }
    
    public function getIdRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->rekening5_id;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->rekening4_id;
            }else{
                $kode_rekening = $this->rekening3_id;
            }
        }
        return $kode_rekening;
    }
    
    public function searchByFilter()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
		}
        $criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
        $criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
        $criteria->compare('LOWER(nmrekeninglain1)',strtolower($this->nmrekeninglain1),true);
        $criteria->compare('LOWER(rekening1_nb)',strtolower($this->rekening1_nb),true);
        $criteria->compare('rekening1_aktif',$this->rekening1_aktif);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
		}
        $criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
        $criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
        $criteria->compare('LOWER(nmrekeninglain2)',strtolower($this->nmrekeninglain2),true);
        $criteria->compare('LOWER(rekening2_nb)',strtolower($this->rekening2_nb),true);
        $criteria->compare('rekening2_aktif',$this->rekening2_aktif);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
		}
        $criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
        $criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
        $criteria->compare('LOWER(nmrekeninglain3)',strtolower($this->nmrekeninglain3),true);
        $criteria->compare('LOWER(rekening3_nb)',strtolower($this->rekening3_nb),true);
        $criteria->compare('rekening3_aktif',$this->rekening3_aktif);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
		}
        $criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
        $criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
        $criteria->compare('LOWER(nmrekeninglain4)',strtolower($this->nmrekeninglain4),true);
        $criteria->compare('LOWER(rekening4_nb)',strtolower($this->rekening4_nb),true);
        $criteria->compare('rekening4_aktif',$this->rekening4_aktif);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
		}
        $criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
        $criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
        $criteria->compare('LOWER(nmrekeninglain5)',strtolower($this->nmrekeninglain5),true);
        $criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('nourutrek',$this->nourutrek);
        $criteria->compare('rekening5_aktif',$this->rekening5_aktif);
        $criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
        $criteria->compare('sak',$this->sak);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
//        $condition = 'rekening5_id IS NOT NULL';
//        $criteria->addCondition($condition);
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, nourutrek';
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }    
    public function searchByFilterPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);			
		}
        $criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
        $criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
        $criteria->compare('LOWER(nmrekeninglain1)',strtolower($this->nmrekeninglain1),true);
        $criteria->compare('LOWER(rekening1_nb)',strtolower($this->rekening1_nb),true);
        $criteria->compare('rekening1_aktif',$this->rekening1_aktif);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);			
		}
        $criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
        $criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
        $criteria->compare('LOWER(nmrekeninglain2)',strtolower($this->nmrekeninglain2),true);
        $criteria->compare('LOWER(rekening2_nb)',strtolower($this->rekening2_nb),true);
        $criteria->compare('rekening2_aktif',$this->rekening2_aktif);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);			
		}
        $criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
        $criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
        $criteria->compare('LOWER(nmrekeninglain3)',strtolower($this->nmrekeninglain3),true);
        $criteria->compare('LOWER(rekening3_nb)',strtolower($this->rekening3_nb),true);
        $criteria->compare('rekening3_aktif',$this->rekening3_aktif);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);			
		}
        $criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
        $criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
        $criteria->compare('LOWER(nmrekeninglain4)',strtolower($this->nmrekeninglain4),true);
        $criteria->compare('LOWER(rekening4_nb)',strtolower($this->rekening4_nb),true);
        $criteria->compare('rekening4_aktif',$this->rekening4_aktif);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);			
		}
        $criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
        $criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
        $criteria->compare('LOWER(nmrekeninglain5)',strtolower($this->nmrekeninglain5),true);
        $criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('nourutrek',$this->nourutrek);
        $criteria->compare('rekening5_aktif',$this->rekening5_aktif);
        $criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
        $criteria->compare('sak',$this->sak);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
//        $condition = 'rekening5_id IS NOT NULL';
//        $criteria->addCondition($condition);
        $criteria->limit = -1;
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, nourutrek';
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }    

    protected function afterFind(){
        if(isset($this->rekening5_id))
        {
            $this->id_temp_rek = 'rekening5_id' . 'x' . $this->rekening5_id;
        }else{
            if(isset($this->rekening4_id))
            {
                $this->id_temp_rek = 'rekening4_id' . 'x' . $this->rekening4_id;
            }else{
                $this->id_temp_rek = 'rekening3_id' . 'x' . $this->rekening3_id;
            }
        }
        return true;
    }
    
}
?>
