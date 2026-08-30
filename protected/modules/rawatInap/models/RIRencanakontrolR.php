<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan untuk mengambil model rencanakontrol_r, ke modul rawat darurat
* RSST-1432
*/

class RIRencanakontrolR extends RencanakontrolR
{    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
