<?php

class GFInformasireturpembelianV extends InformasireturpembelianV {
	public $tgl_awal, $tgl_akhir, $tglterimafaktur, $tglfaktur;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasireturpembelianV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Pencarian Data Retur Pembelian
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		$criteria->addBetweenCondition('DATE(tglretur)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->returpembelian_id)){
			$criteria->addCondition('returpembelian_id = '.$this->returpembelian_id);
		}
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noretur)',strtolower($this->noretur),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('totalretur',$this->totalretur);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->compare('LOWER(noterima)',strtolower($this->noterima),true);
		$criteria->compare('DATE(tglterimafaktur)',$this->tglterimafaktur);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
		$criteria->compare('DATE(tglfaktur)',$this->tglfaktur);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('LOWER(keteranganfaktur)',strtolower($this->keteranganfaktur),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
		$criteria->compare('LOWER(supplier_namabank)',strtolower($this->supplier_namabank),true);
		$criteria->compare('LOWER(supplier_rekatasnama)',strtolower($this->supplier_rekatasnama),true);
		$criteria->compare('LOWER(supplier_matauang)',strtolower($this->supplier_matauang),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_logo)',strtolower($this->supplier_logo),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
		$criteria->compare('LOWER(supplier_cp_hp)',strtolower($this->supplier_cp_hp),true);
		$criteria->compare('LOWER(supplier_cp_email)',strtolower($this->supplier_cp_email),true);
		$criteria->compare('LOWER(supplier_cp2)',strtolower($this->supplier_cp2),true);
		$criteria->compare('LOWER(supplier_cp2_hp)',strtolower($this->supplier_cp2_hp),true);
		$criteria->compare('LOWER(supplier_cp2_email)',strtolower($this->supplier_cp2_email),true);
		$criteria->compare('LOWER(supplier_jenis)',strtolower($this->supplier_jenis),true);
		if(!empty($this->supplier_termin)){
			$criteria->addCondition('supplier_termin = '.$this->supplier_termin);
		}
		$criteria->compare('LOWER(longitude)',strtolower($this->longitude),true);
		$criteria->compare('LOWER(latitude)',strtolower($this->latitude),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		
		$criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
	
	// fungsi untuk dropdown ketika pencarian retur pembelian (modul Gudang Farmasi, menu Informasi Retur Pembelian)
	public function getInstalasi($instalasi='')
	{
		if(!empty($instalasi))
			return self::model()->findAll('instalasi_id = '.$instalasi.' ORDER BY instalasi_nama');
		else 
			return array();
	}
	public function getRuangan($ruangan='')
	{
		if(!empty($ruangan))
			return self::model()->findAll('ruangan_id = '.$ruangan.' ORDER BY ruangan_nama');
		else 
			return array();
	}
}