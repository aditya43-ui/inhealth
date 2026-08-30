<?php

class STBarangV extends BarangV{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog(){

		$criteria=new CDbCriteria;
		if(!empty($this->golongan_id)){
			$criteria->addCondition('golongan_id ='.$this->golongan_id);
		}
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id ='.$this->kelompok_id);
		}
		if(!empty($this->bidang_id)){
			$criteria->addCondition('bidang_id ='.$this->bidang_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id ='.$this->barang_id);
		}
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		//$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));		
	}
}