<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GUBarangM extends BarangM
{
     public $golongan_id;
     public $subsubkelompok_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getBidangNama(){
        return $this->subsubkelompok->subsubkelompok_nama;
    }
    
    public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		RND-8594		-> data (dialogbox) yg ditampilkan data yg stok nya masih ada.
//		$criteria->join = "JOIN inventarisasiruangan_t ON inventarisasiruangan_t.barang_id = t.barang_id";
		if(!empty($this->barang_id)){
			$criteria->addCondition("t.barang_id = ".$this->barang_id);			
		}
		if(!empty($this->bidang_id)){
			$criteria->addCondition("subsubkelompok_id = ".$this->subsubkelompok_id);			
		}    
               
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
		$criteria->compare('barang_aktif',isset($this->barang_aktif)?$this->barang_aktif:true);
                //$criteria->addCondition("barang_type != 'Aset' ");
                $criteria->order = "barang_kode ASC";
//		$criteria->addCondition('inventarisasiruangan_t.inventarisasi_qty_skrg > 0 ');
		//$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
	}

	public function getBidangItems()
    {
        return BidangM::model()->findAll('bidang_aktif = true ORDER BY bidang_nama');
    }
	
	public function searchPrint()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('subsubkelompok_id',$this->subsubkelompok_id);
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',$this->barang_kode,true);
		$criteria->compare('LOWER(barang_nama)',$this->barang_nama,true);
		$criteria->compare('LOWER(barang_namalainnya)',$this->barang_namalainnya,true);
		$criteria->compare('LOWER(barang_merk)',$this->barang_merk,true);
		$criteria->compare('LOWER(barang_noseri)',$this->barang_noseri,true);
		$criteria->compare('LOWER(barang_ukuran)',$this->barang_ukuran,true);
		$criteria->compare('LOWER(barang_bahan)',$this->barang_bahan,true);
		$criteria->compare('LOWER(barang_thnbeli)',$this->barang_thnbeli,true);
		$criteria->compare('LOWER(barang_warna)',$this->barang_warna,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('LOWER(barang_satuan)',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('LOWER(barang_image)',$this->barang_image,true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
    }
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('subsubkelompok_id',$this->subsubkelompok_id);
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
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}
?>
