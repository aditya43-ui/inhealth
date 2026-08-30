<?php
/**
* - digunakan untuk memanggil view operasitimeout_t, hanya untuk modul bedah sentral
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
class BSOperasitimeoutT extends OperasitimeoutT
{
	public $formtimeout_nama;
	public $haschecklist;
	
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>