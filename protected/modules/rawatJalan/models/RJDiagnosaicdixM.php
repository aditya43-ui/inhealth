<?php

class RJDiagnosaicdixM extends DiagnosaicdixM
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

	public function getDiagnosa($id)
	{
		$statusesString = "'" . implode("', '", $id) . "'";

		$sql = "SELECT diagnosaicdix_nama FROM diagnosaicdix_m WHERE 
			diagnosaicdix_id IN ({$statusesString})
		";

		return self::model()->findAllBySql($sql);
	}
}