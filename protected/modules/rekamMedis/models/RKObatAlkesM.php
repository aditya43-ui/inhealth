<?php

class RKObatAlkesM extends ObatalkesM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
	public $generik_nama, $obatalkes_nama2;
	public $therapiobat_id,$ruangan_id,$signa;
	public $sumberdana_nama, $jenisobatalkes_nama;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getStok($ruangan_id){
            
//            $stokQty = Yii::app()->db->createCommand()->select('sum(qtystok_current) as qtystok_current, obatalkes_id')->from('stokobatalkes_t')->group('obatalkes_id')->where("obatalkes_id = $id AND ruangan_id = 59")->queryAll();
            $stokQty = Yii::app()->db->createCommand()->select('sum(qtystok_current) as qtystok_current, obatalkes_id')->from('stokobatalkes_t')->group('obatalkes_id')->where("ruangan_id = $ruangan_id")->queryAll();
            
            $stok = 0;
            foreach($stokQty as $key=>$qty){
           
                if(($qty['qtystok_current']< 0)){
                    $stok = 0;
                }else{
                    $stok += $qty['qtystok_current'];
                }
            }
            
            return $stok;
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
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
                
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
		$criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
		$criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
		
		if(!empty($this->therapiobat_id)){
			$criteria->join = ('JOIN therapimapobat_m ON therapimapobat_m.obatalkes_id = t.obatalkes_id');
			$criteria->addCondition('therapimapobat_m.therapiobat_id = '.$this->therapiobat_id);
		}
		
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
                $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
                $criteria->addCondition('obatalkes_farmasi is true');
				
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'defaultOrder'=>'obatalkes_nama',
                        )
		));
	}
	
	public function cariTerapiObat($obatalkes_id)
	{
		$modTherapi = RJTherapimapobatM::model()->findByAttributes(array('obatalkes_id'=>$obatalkes_id));
		return $modTherapi->therapiobat_id;
	}
	
	public function searchObatAlkes()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);				
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * menampilkan data obat alkes untuk dialog
	 * @return \CActiveDataProvider
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
						JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
						LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
						";
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(satuankecil_m.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(sumberdana_m.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
                $criteria->addCondition('obatalkes_aktif = TRUE');
		$criteria->order='obatalkes_nama ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}

?>