<?php
class PCUnitDosisT extends UnitdosisT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstalasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Fungsi untuk Dropdown Nama Dokter unit dosis.
	 * @param $ruangan_id
	 * @return $ruangan_id
	 */
	public function getDokterItems($ruangan_id='')
	{
		$ruangan_id = Yii::app()->user->getState('ruangan_id');
		if(!empty($ruangan_id))
			return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
		else
			return array();
	}
	
	/**
	 * Fungsi untuk Dropdown Nama Ruangan unit dosis.
	 * @param null
	 * @return null
	 */
	public function getRuanganInstalasiFarmasi()
	{
		return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>Params::INSTALASI_ID_FARMASI));
	}
}