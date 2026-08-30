<?php
class PPKelaspelayananM extends KelaspelayananM {

    public static function model($class=__CLASS__){
        return parent::model($class);
    }
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('t.jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas.jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('kelaspelayanan_aktif',isset($this->kelaspelayanan_aktif)?$this->kelaspelayanan_aktif:true);
		$criteria->limit=-1;
		$criteria->order='jeniskelas.jeniskelas_nama,kelaspelayanan_nama';
		$criteria->with = array('jeniskelas');

		return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                        ));
	}

}
?>
