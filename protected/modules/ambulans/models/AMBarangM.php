<?php

class AMBarangM extends BarangM
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		//$criteria->limit=5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
	} 
        
        public function criteriaSearchDialogAmbulan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.barang_id',$this->barang_id);
//		$criteria->compare('t.subsubkelompok_id',$this->subsubkelompok_id); 
//                $criteria->addCondition('t.subsubkelompok_id = 475'); 
                $criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		$criteria->compare('t.barang_type',$this->barang_type,true);
		$criteria->compare('t.barang_kode',$this->barang_kode,true);
		$criteria->compare('LOWER(t.barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('t.barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('t.barang_merk',$this->barang_merk,true);
		$criteria->compare('t.barang_noseri',$this->barang_noseri,true);
		$criteria->compare('LOWER(t.barang_ukuran)',  strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(t.barang_bahan)',  strtolower($this->barang_bahan),true);
		$criteria->compare('t.barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('t.barang_warna',$this->barang_warna,true);
		$criteria->compare('t.barang_statusregister',$this->barang_statusregister);
		$criteria->compare('t.barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('t.barang_satuan',$this->barang_satuan,true);
		$criteria->compare('t.barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('t.barang_image',$this->barang_image,true);
		$criteria->compare('t.barang_harganetto',$this->barang_harganetto);		
		$criteria->compare('t.barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('t.barang_ppn',$this->barang_ppn);
		$criteria->compare('t.barang_hpp',$this->barang_hpp);
		$criteria->compare('t.barang_hargajual',$this->barang_hargajual);
		$criteria->compare('t.jenisbarang_id',$this->jenisbarang_id);
                $criteria->compare('t.subsubkelompok_nama',$this->subsubkelompok_nama);
                $criteria->compare('t.barang_aktif',isset($this->barang_aktif)?$this->barang_aktif:true);                
                return $criteria;
	}  
        
        public function searchDialogAmbulan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch(); 
        // $criteria->addCondition('t.subsubkelompok_id = 475'); 
		// $criteria->limit=5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 
}
?>
