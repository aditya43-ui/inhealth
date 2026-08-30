<?php

class RJResepturT extends ResepturT
{
	public $totalhargajual, $paketobat_id, $nama_paket, $ppds_id, $ppds_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRiwayatResep()
	{
		$criteria = new CDbCriteria;

		if (!empty($this->pasien_id)) {
			$criteria->addCondition("pasien_id = " . $this->pasien_id);
		}
			
		$criteria->order = 'create_time desc'; 

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

}