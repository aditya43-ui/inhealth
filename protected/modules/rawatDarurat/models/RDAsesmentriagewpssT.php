<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table Asesmennyeriflaccs_t, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

class RDAsesmentriagewpssT extends AsesmentriagewpssT
{
	public $transport_lain, $dikirim_lain, $code, $no_triage;
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