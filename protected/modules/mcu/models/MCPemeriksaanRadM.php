<?php

class MCPemeriksaanRadM extends PemeriksaanradM
{
    public $refhasilrad_id,$jenispemeriksaanrad_nama,$pemeriksaanrad_jenis;
    public $isChecked = false; //status jika di pilih
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AgamaM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getDaftarTindakanNama($daftartindakanId = null) {
        return DaftartindakanM::model()->findByPk($daftartindakanId);
    }

    public function searchTabel()
    {
 

        $criteria=new CDbCriteria;
        $criteria->with = array('daftartindakan','jenispemeriksaanrad');
        $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addCondition("t.pemeriksaanrad_id = ".$this->pemeriksaanrad_id);					
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("t.daftartindakan_id = ".$this->daftartindakan_id);					
		}
		if(!empty($this->jenispemeriksaanrad_id)){
			$criteria->addCondition("t.jenispemeriksaanrad_id = ".$this->jenispemeriksaanrad_id);					
		}
        $criteria->compare('LOWER(t.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
        $criteria->compare('LOWER(t.pemeriksaanrad_namalainnya)',strtolower($this->pemeriksaanrad_namalainnya),true);
        $criteria->compare('LOWER(jenispemeriksaanrad.jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
        $criteria->compare('t.pemeriksaanrad_aktif',isset($this->pemeriksaanrad_aktif)?$this->pemeriksaanrad_aktif:true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
?>