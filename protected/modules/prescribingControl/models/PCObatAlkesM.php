<?php

class PCObatAlkesM extends ObatalkesM
{
        public $generik_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchObatFarmasiRuangan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                $format = new MyFormatter();
		$criteria=new CDbCriteria;

		$criteria->with = array('sumberdana','satuankecil', 'satuanbesar','generik');
		$criteria->compare('LOWER(generik.generik_nama)',  strtolower($this->generik_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id); 	
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("t.satuankecil_id = ".$this->satuankecil_id); 	
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id); 	
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
                $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
                
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
		$criteria->compare('LOWER(satuanbesar.satuanbesar_nama)',strtolower($this->satuanbesarNama),true);
		$criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
		$criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
                
                $criteria2 = new CDbCriteria;
                $criteria2->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
                $modObat = $this->model()->find($criteria2);
                if(isset($modObat)){
                    $generik_id = $modObat->generik_id;
                    
                
                    if(empty($this->generik_nama) && !empty($generik_id)){              
                        $criteria->addCondition("LOWER(t.obatalkes_nama) ILIKE '%".$this->obatalkes_nama."%' OR t.generik_id = ".$generik_id);
                    }
                }else{
                    $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
                }
                $criteria->addCondition('obatalkes_farmasi is true');
                
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}