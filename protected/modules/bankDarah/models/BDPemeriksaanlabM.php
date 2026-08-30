<?php

class BDPemeriksaanlabM extends PemeriksaanlabM
{
        public $is_pilih;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
     
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('jenispemeriksaan','daftartindakan');
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(jenispemeriksaan.jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('daftartindakan.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('jenispemeriksaan.jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		$criteria->compare('LOWER(pemeriksaanlab_namalainnya)',strtolower($this->pemeriksaanlab_namalainnya),true);
		$criteria->compare('pemeriksaanlab_aktif',isset($this->pemeriksaanlab_aktif)?$this->pemeriksaanlab_aktif:true);
		$criteria->addCondition('pemeriksaanlab_aktif is true');
		$criteria->limit = 5;
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

}