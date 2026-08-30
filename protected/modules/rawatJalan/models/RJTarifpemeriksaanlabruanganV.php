<?php
class RJTarifpemeriksaanlabruanganV extends TarifpemeriksaanlabruanganV
{
        public $is_pilih = false; //check / uncheck pada pemilihan pemeriksaan (update pemeriksaan)
	     public $jenisform_nama,$jenisform_id;

		/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchTarif()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('jenisform_id',$this->jenisform_id);
		$criteria->compare('LOWER(jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}		
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		//$criteria->compare('carabayar_id',$this->carabayar_id);
		//$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		//$criteria->compare('penjamin_id',$this->penjamin_id);
		//$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition(" kelaspelayanan_id = '".$this->kelaspelayanan_id."' ");
		}
		
		if (!empty($this->penjamin_id)){
			$criteria->addCondition(" penjamin_id = '".$this->penjamin_id."' ");
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getInstalasiItems()
	{
		return InstalasiM::model()->findAll('instalasi_aktif=TRUE  ORDER BY instalasi_nama');
	}
		
	/**
	 * Mengambil daftar semua ruangan
	 * @return CActiveDataProvider 
	 */
	public function getRuanganItems($instalasi_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id))
		{ 
			$criteria->addCondition("instalasi_id = ".$instalasi_id); 
		} 
		$criteria->addCondition('ruangan_aktif = true');
		$criteria->order = "ruangan_nama";
		return RuanganM::model()->findAll($criteria);
	}
	
	public function getKelasPelayananItems()
	{
		return KelaspelayananM::model()->findAll(array('condition'=>'kelaspelayanan_aktif = TRUE'),array('order'=>'kelaspelayanan_nama'));
	} 

	public function getKategoritindakanItems()
	{
		return KategoritindakanM::model()->findAll(array('condition'=>'kategoritindakan_aktif = TRUE'),array('order'=>'kategoritindakan_nama'));
	} 

}