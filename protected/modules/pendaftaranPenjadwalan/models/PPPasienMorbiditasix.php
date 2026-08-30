<?php
/**
 * model untuk mengakses tabel diagnosa_m, hanya untuk modul pendaftaran penjadwalan
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class PPPasienMorbiditasix extends PasienmorbiditasT
{
    public $pasienicd9cm_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}