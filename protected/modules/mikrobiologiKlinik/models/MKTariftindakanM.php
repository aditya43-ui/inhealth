<?php

class MKTariftindakanM extends TariftindakanM {

	public $paket, $kategoritindakan_nama;
	public $tipepaket_id, $tipepaket_nama, $pemeriksaanlab_id, $pemeriksaanlab_nama, $jenispemeriksaanlab_id, $jenispemeriksaanlab_nama;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->tariftindakan_id)){
			$criteria->addCondition('tariftindakan_id = '.$this->tariftindakan_id);
		}
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition('jenistarif_id = '.$this->jenistarif_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakaN_id = '.$this->daftartindakan_id);
		}
		if(!empty($this->komponentarif_id)){
			$criteria->addCondition('komponentarif.komponentarif_id = '.$this->komponentarif_id);
		}
		if(!empty($this->perdatarif_id)){
			$criteria->addCondition('perdatarif_id = '.$this->perdatarif_id);
		}
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->with=array('perdatarif','jenistarif','komponentarif','daftartindakan');
		$criteria->compare('jenistarif.jenistarif_nama',$this->jenistarif->jenistarif_nama);
		$criteria->compare('komponentarif.komponentarif_nama',$this->komponentarif->komponentarif_nama);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function search2()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		// $criteria->select = "t.*, k.*, pr.pemeriksaanlab_id, pr.pemeriksaanlab_nama, j.jenispemeriksaanlab_id, j.jenispemeriksaanlab_nama";
		$criteria->select = "t.jenistarif_id, t.harga_tariftindakan, t.kelaspelayanan_id, d.daftartindakan_kode, d.daftartindakan_id,  k.kategoritindakan_nama,
							 pr.pemeriksaanlab_id, pr.pemeriksaanlab_nama, j.jenispemeriksaanlab_id, j.jenispemeriksaanlab_nama";
		
		$criteria->group = $criteria->select;

		$criteria->join = 'join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id 
							left join kategoritindakan_m k on k.kategoritindakan_id = d.kategoritindakan_id
							join pemeriksaanlab_m pr on pr.daftartindakan_id = d.daftartindakan_id
							join jenispemeriksaanlab_m j on j.jenispemeriksaanlab_id = pr.jenispemeriksaanlab_id';

						
		$criteria->addCondition('d.kelompoktindakan_id = 98');					

		if(!empty($this->tariftindakan_id)){
			$criteria->addCondition("t.tariftindakan_id = ".$this->tariftindakan_id);					
		}
		if(!empty($this->jenistarif_id)){
			$criteria->addCondition("t.jenistarif_id = ".$this->jenistarif_id);					
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("t.daftartindakan_id = ".$this->daftartindakan_id);					
		}
		if(!empty($this->komponentarif_id)){
			$criteria->addCondition("t.komponentarif_id = ".$this->komponentarif_id);					
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id);					
		}

		$criteria->compare('lower(k.kategoritindakan_nama)',strtolower($this->kategoritindakan_nama), true);
		$criteria->compare('lower(d.daftartindakan_kode)',strtolower($this->daftartindakan_kode), true);
		$criteria->compare('lower(d.daftartindakan_nama)',strtolower($this->daftartindakan_nama), true);
		$criteria->compare('lower(j.jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama), true);
		$criteria->compare('lower(pr.pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama), true);

		$criteria->addCondition("d.daftartindakan_aktif is true");
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'d.daftartindakan_nama, t.kelaspelayanan_id',
			)
		));
	
	}

	public function searchPaket() {
		$model = new TipepaketM;
		$criteria = new CDbCriteria;

		$criteria->compare('lower(tipepaket_nama)', strtolower($this->tipepaket_nama));

		$criteria->addCondition('is_mikro = true');
		$criteria->order = 'tipepaket_nama';

		return new CActiveDataProvider($model, array(
			'criteria'=>$criteria,
		));
	}
}

?>
