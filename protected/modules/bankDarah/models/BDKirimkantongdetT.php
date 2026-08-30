<?php
/**
 * model ini digunakan untuk meload tabel Kirimkantongdet_t
 * 
 * @package application.modules.bankDarah
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class BDKirimkantongdetT extends KirimkantongdetT
{
    public $kantongdarahdet_id;
    public $nomorbarcode_utama, $pilih, $no_kantongpabrik, $komponendarah_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimkantongdetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}