<?php
class FAObatalkesM extends ObatalkesM
{
	public $stoksekarang;
	public $sumberdana_nama;
	public $jenisobatalkes_nama;
	public $therapiobat_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchObatFarmasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter();
		$criteria=new CDbCriteria;

		$criteria->with = array('sumberdana','satuankecil', 'satuanbesar');
		
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
		}
		if(!empty($this->lokasigudang_id)){
			$criteria->addCondition("t.lokasigudang_id = ".$this->lokasigudang_id);						
		}
		$criteria->compare('LOWER(lokasigudang.lokasigudang_nama)',  strtolower($this->lokasigudangNama));
		
		if(!empty($this->generik_id)){
			$criteria->addCondition("t.generik_id = ".$this->generik_id);						
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition("t.satuanbesar_id = ".$this->satuanbesar_id);						
		}
		$criteria->compare('LOWER(satuanbesar.satuanbesar_nama)',  strtolower($this->satuanbesarNama));
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);						
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("t.satuankecil_id = ".$this->satuankecil_id);						
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
		if(!empty($this->therapiobat_id)){
			$criteria->join .= ('JOIN therapimapobat_m ON therapimapobat_m.obatalkes_id = t.obatalkes_id');
			$criteria->addCondition('therapimapobat_m.therapiobat_id = '.$this->therapiobat_id);
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('LOWER(noregister)',strtolower($this->noregister),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
                
                $criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('marginresep',$this->marginresep);
		$criteria->compare('jasadokter',$this->jasadokter);
		$criteria->compare('hjaresep',$this->hjaresep);
		$criteria->compare('marginnonresep',$this->marginnonresep);
		$criteria->compare('hjanonresep',$this->hjanonresep);
                $criteria->compare('hpp',$this->hpp);
                
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
		$criteria->compare('discountinue',$this->discountinue);
		$criteria->compare('obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
		$criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
		$criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
                $criteria->addCondition('obatalkes_farmasi is true');
                // $criteria->limit=10;
                return new CActiveDataProvider($this, array(
                                'criteria'=>$criteria,
                        ));
                }
                
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
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("t.sumberdana_id = ".$this->sumberdana_id);						
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("t.satuankecil_id = ".$this->satuankecil_id);						
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("t.jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
        $criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
        $criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
        $criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
        $criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
        $criteria->compare('LOWER(t.tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
        $criteria->compare('LOWER(satuankecil_m.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
        $criteria->compare('LOWER(sumberdana_m.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
        $criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
        $criteria->addCondition('obatalkes_aktif = TRUE');
        $criteria->order='obatalkes_nama ASC';
		// $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->with = array('sumberdana','satuankecil');
		
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("t.obatalkes_id = ".$this->obatalkes_id);						
		}
		if(!empty($this->lokasigudang_id)){
			$criteria->addCondition("t.lokasigudang_id = ".$this->lokasigudang_id);						
		}
		if(!empty($this->therapiobat_id)){
			$criteria->addCondition("t.therapiobat_id = ".$this->therapiobat_id);						
		}
		if(!empty($this->generik_id)){
			$criteria->addCondition("t.generik_id = ".$this->generik_id);						
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition("t.satuanbesar_id = ".$this->satuanbesar_id);						
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("t.sumberdana_id = ".$this->sumberdana_id);						
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("t.satuankecil_id = ".$this->satuankecil_id);						
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("t.jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
		$criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(t.obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('LOWER(t.noregister)',strtolower($this->noregister),true);
		$criteria->compare('LOWER(t.nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('t.kemasanbesar',$this->kemasanbesar);
		$criteria->compare('t.kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(t.satuankekuatan)',strtolower($this->satuankekuatan),true);
                
		$criteria->compare('t.harganetto',$this->harganetto);
		$criteria->compare('t.hargajual',$this->hargajual);
		$criteria->compare('t.discount',$this->discount);
		$criteria->compare('t.marginresep',$this->marginresep);
		$criteria->compare('t.jasadokter',$this->jasadokter);
		$criteria->compare('t.hjaresep',$this->hjaresep);
		$criteria->compare('t.marginnonresep',$this->marginnonresep);
		$criteria->compare('t.hjanonresep',$this->hjanonresep);
		$criteria->compare('t.hpp',$this->hpp);
                
		$criteria->compare('LOWER(t.tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('t.minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(t.formularium)',strtolower($this->formularium),true);
		$criteria->compare('t.discountinue',$this->discountinue);
		$criteria->compare('t.obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
		$criteria->compare('LOWER(t.satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
		$criteria->compare('LOWER(t.sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
		$criteria->compare('t.obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->order='t.obatalkes_nama ASC';
		// $criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * untuk dialog pilih obat alkes
     * @return type
     */
    public function getSatuanKecilNama(){
        return $this->satuankecil->satuankecil_nama;
    }
    /**
     * untuk dialog pilih obat alkes
     * @return type
     */
    public function getSumberDanaNama(){
        return $this->sumberdana->sumberdana_nama;
    }
	
}