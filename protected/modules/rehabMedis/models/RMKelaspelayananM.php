<?php
class RMKelaspelayananM extends KelaspelayananM
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('kelaspelayanan_aktif',isset($this->kelaspelayanan_aktif)?$this->kelaspelayanan_aktif:true);
		$criteria->compare('persentasirujin',$this->persentasirujin);
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}