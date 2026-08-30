<?php

class SABarangM extends BarangM
{

     public $golongan_id;
     public $bidang_nama;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('bidang');
		if (!empty($this->barang_id)){
			$criteria->addCondition('t.barang_id ='.$this->barang_id);
		}
		//if (!empty($this->bidang_id)){
			//$criteria->addCondition('t.bidang_id ='.$this->bidang_id);
		//}
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('barang_image',$this->barang_image,true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		//$criteria->compare('barang_aktif',isset($this->bidang_aktif)?$this->barang_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
    public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('bidang');
		if (!empty($this->barang_id)){
			$criteria->addCondition('t.barang_id ='.$this->barang_id);
		}
		//if (!empty($this->bidang_id)){
		//	$criteria->addCondition('t.bidang_id ='.$this->bidang_id);
		//}
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('barang_image',$this->barang_image,true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_aktif',$this->barang_aktif);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		//$criteria->compare('barang_aktif',isset($this->bidang_aktif)?$this->barang_aktif:true);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}
?>
