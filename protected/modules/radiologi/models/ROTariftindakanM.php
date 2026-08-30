<?php

class ROTariftindakanM extends TariftindakanM {
	
    public $kategoritindakan_id;
    public $kategoritindakan_nama, $daftartindakan_kode, $daftartindakan_nama, $paket;
	public $tipepaket_id, $tipepaket_nama, $pemeriksaanrad_id, $pemeriksaanrad_nama, $jenispemeriksaanrad_id;

	public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    // public function search()
	// {
	// 	// Warning: Please modify the following code to remove attributes that
	// 	// should not be searched.

	// 	$criteria=new CDbCriteria;

	// 	if(!empty($this->tariftindakan_id)){
	// 		$criteria->addCondition("tariftindakan_id = ".$this->tariftindakan_id);					
	// 	}
	// 	if(!empty($this->jenistarif_id)){
	// 		$criteria->addCondition("jenistarif_id = ".$this->jenistarif_id);					
	// 	}
	// 	if(!empty($this->daftartindakan_id)){
	// 		$criteria->addCondition("daftartindakaN_id = ".$this->daftartindakan_id);					
	// 	}
	// 	if(!empty($this->komponentarif_id)){
	// 		$criteria->addCondition("komponentarif.komponentarif_id = ".$this->komponentarif_id);					
	// 	}
	// 	if(!empty($this->perdatarif_id)){
	// 		$criteria->addCondition("perdatarif_id = ".$this->perdatarif_id);					
	// 	}
	// 	$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
	// 	$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
	// 	$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
	// 	$criteria->compare('persencyto_tind',$this->persencyto_tind);
	// 	$criteria->compare('persencyto_tind',$this->persencyto_tind);
	// 	$criteria->with=array('perdatarif','jenistarif','komponentarif','daftartindakan');
	// 	$criteria->compare('jenistarif.jenistarif_nama',$this->jenistarif->jenistarif_nama);
	// 	$criteria->compare('komponentarif.komponentarif_nama',$this->komponentarif->komponentarif_nama);
	// 	return new CActiveDataProvider($this, array(
	// 		'criteria'=>$criteria,
	// 	));
	// }


    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = "t.*, k.*, pr.pemeriksaanrad_id, pr.pemeriksaanrad_nama, jp.jenispemeriksaanrad_id, d.daftartindakan_kode";

		$criteria->join = 'join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id 
							left join kategoritindakan_m k on k.kategoritindakan_id = d.kategoritindakan_id
							join pemeriksaanrad_m pr on pr.daftartindakan_id = d.daftartindakan_id
							join jenispemeriksaanrad_m jp on pr.jenispemeriksaanrad_id = jp.jenispemeriksaanrad_id';

							
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
		$criteria->compare('lower(pr.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama), true);

		if(!empty($this->harga_tariftindakan)){
			$criteria->addCondition("t.harga_tariftindakan = ".$this->harga_tariftindakan);					
		}

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

		$criteria->addCondition('is_rad = true');
		$criteria->order = 'tipepaket_nama';

		return new CActiveDataProvider($model, array(
			'criteria'=>$criteria,
		));
	}
}

?>
