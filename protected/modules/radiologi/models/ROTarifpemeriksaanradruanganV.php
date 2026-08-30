<?php

class ROTarifpemeriksaanradruanganV extends TarifpemeriksaanradruanganV
{
        public $is_pilih = false; //check / uncheck pada pemilihan pemeriksaan (update pemeriksaan)
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifpemeriksaanradruanganV the static model class
	 */
	
	public $paket, $tipepaket_nama;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchTarif()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('LOWER(jenispemeriksaanrad_kode)',strtolower($this->jenispemeriksaanrad_kode),true);
		$criteria->compare('jenispemeriksaanrad_urutan',$this->jenispemeriksaanrad_urutan);
		$criteria->compare('LOWER(jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('LOWER(pemeriksaanrad_kode)',strtolower($this->pemeriksaanrad_kode),true);
		$criteria->compare('pemeriksaanrad_urutan',$this->pemeriksaanrad_urutan);
		$criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
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
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                'sort'=>array(
                                    'defaultOrder'=>'jenistarif_nama, jenispemeriksaanrad_nama, pemeriksaanrad_nama, kelaspelayanan_id'
                                )
		));
	}
        
        public function searchTarifPrint() {
            $provider = $this->searchTarif();
            $provider->criteria->limit = -1;
            $provider->pagination = false;
            
            return $provider;
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
		return KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC");
	} 

	public function getKategoritindakanItems()
	{
		return KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama ASC");
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