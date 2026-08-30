<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table skalanyeriflaccs_m, yang digunakan hanya untuk modul rawat darurat saja saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

class RISkalanyeriflaccsM extends SkalanyeriflaccsM
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

}