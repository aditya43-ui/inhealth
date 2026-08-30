<?php
/**
* - digunakan untuk memanggil table batalpelaksanaoperasi_t
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class BSBatalpelaksanaoperasiT extends BatalpelaksanaoperasiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}