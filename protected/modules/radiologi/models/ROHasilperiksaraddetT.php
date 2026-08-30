<?php
/**
* - digunakan sebagai dasar untuk memanggil table hasilperiksaraddet_t, hanya di modulradiologi
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class ROHasilperiksaraddetT extends HasilperiksaraddetT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}