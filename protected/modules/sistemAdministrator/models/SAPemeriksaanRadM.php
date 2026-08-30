<?php

class SAPemeriksaanRadM extends PemeriksaanradM
{
    public $refhasilrad_id,$pemeriksaanrad_jenis,$jenispemeriksaanrad_id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AgamaM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function searchPilih()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->with = array('daftartindakan','jenispemeriksaanrad');
                $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
                $criteria->compare('LOWER(jenispemeriksaanrad.jenispemeriksaanrad_nama)',strtolower($this->jenispemeriksaanrad_nama),true);
		$criteria->compare('t.pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.jenispemeriksaanrad_id',$this->jenispemeriksaanrad_id);
		$criteria->compare('LOWER(t.pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		$criteria->compare('LOWER(t.pemeriksaanrad_namalainnya)',strtolower($this->pemeriksaanrad_namalainnya),true);
		$criteria->compare('t.pemeriksaanrad_aktif',isset($this->pemeriksaanrad_aktif)?$this->pemeriksaanrad_aktif:true);
//                $criteria->addCondition('pemeriksaanrad_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>