<?php
/**
* - digunakan untuk memanggil view Pemeriksaanpartografdet_t, hanya untuk modul persalinan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class PSPemeriksaanpartografdetT extends PemeriksaanpartografdetT
{
        public $noUrutLain; 
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