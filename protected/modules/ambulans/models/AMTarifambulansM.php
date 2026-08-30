<?php

class AMTarifambulansM extends TarifAmbulansM
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
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('daftartindakan');
		$criteria->compare('t.tarifambulans_id',$this->tarifambulans_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(t.tarifambulans_kode)',strtolower($this->tarifambulans_kode),true);
		$criteria->compare('LOWER(t.kepropinsi_nama)',strtolower($this->kepropinsi_nama),true);
		$criteria->compare('LOWER(t.kekabupaten_nama)',strtolower($this->kekabupaten_nama),true);
		$criteria->compare('LOWER(t.kekecamatan_nama)',strtolower($this->kekecamatan_nama),true);
		$criteria->compare('LOWER(t.kekelurahan_nama)',strtolower($this->kekelurahan_nama),true);
		$criteria->compare('t.jmlkilometer',$this->jmlkilometer);
		$criteria->compare('t.tarifperkm',$this->tarifperkm);
		$criteria->compare('t.tarifambulans',$this->tarifambulans);
		if(!empty($this->penjamin_id)){
			$criteria->compare('t.penjamin_id',$this->penjamin_id);
		}
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->limit = 5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}
?>
