<?php
/**
 * digunakan untuk transaksi surveilans tab pemeriksaan pasien
 * @author Rusdiyanto <rusdsiyanto@.com>
 * @subpackage  models
 */
class RJSurveilansT extends SurveilansT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SurveilansT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}