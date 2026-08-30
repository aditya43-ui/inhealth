<?php
/**
* - digunakan untuk memanggil view Pemeriksaanpartograf_t, hanya untuk modul persalinan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class PSPemeriksaanpartografT extends PemeriksaanpartografT
{
	public $ada_obat = false;
	public $ada_detail = false;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		
}

?>