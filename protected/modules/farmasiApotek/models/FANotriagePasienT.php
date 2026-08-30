<?php

class FANotriagePasienT extends NotriagePasienT
{
	public $no_triage;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NotriagePasienT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */

	public static function getDropTrigaePasien($pendaftaran_id) {
		$cri = new CDbCriteria();
		if ((!empty($pendaftaran_id))) {
			$cri->addCondition(" (pasien_id is NULL AND pendaftaran_id is NULL) OR pendaftaran_id =" . $pendaftaran_id);
		}else{
			$cri->addCondition("pasien_id is NULL AND pendaftaran_id is NULL");
		}
                $cri->order = "no_bed_triage ASC";
		$data = [];
		$query = NotriagePasienT::model()->findAll($cri);
		foreach ($query as $key => $value) {
			$data[$value->notriage_pasien_id] = $value->no_triage_pasien . ' - ' .$value->no_bed_triage ;
		}

		return $data;
    }
}
?>