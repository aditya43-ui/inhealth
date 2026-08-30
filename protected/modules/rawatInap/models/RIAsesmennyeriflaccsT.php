<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table Asesmennyeriflaccs_t, yang digunakan hanya untuk modul kepegawaian saja
*       @author		Deni Hamdani <denihamdani@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

class RIAsesmennyeriflaccsT extends AsesmennyeriflaccsT
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