<?php

class RJSkrininggiziT extends SkrininggiziT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkrininggiziT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRiwayat()
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