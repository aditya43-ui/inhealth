<?php
/**
* - digunakan untuk memanggil view bagiantubuh_m, hanya untuk modul bedah sentral
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
class BSBagiantubuhM extends BagiantubuhM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BagiantubuhM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getBagianTubuh() {
		$modBagianTubuh = BSBagiantubuhM::model()->findAll("bagiantubuh_aktif is true");
		return $modBagianTubuh;
	}
	
}
