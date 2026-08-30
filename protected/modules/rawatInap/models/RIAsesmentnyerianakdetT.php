<?php
/**
 * 
 * - digunakan untuk mengenerate data pada tabel Asesmentnyeri_t, hanya untuk modul rawat inap saja
 * RSST-1288
 */
class RIAsesmentnyerianakdetT extends AsesmentnyerianakdetT
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