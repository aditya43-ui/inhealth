<?php
/**
* Model untuk kirimkantondarah_t hanya untuk modul Bank Darah
 * @author Elham Budianto<elhambudianto1@gmail.com>
 * @package application.modules.bankDarah
 * @subpackage models
**/

class BDKirimkantongdarahT extends KirimkantongdarahT
{
        public $is_pilihkarcis; //untuk chekbox di form
        public $satuantindakan; //untuk form diinsert ke tindakanpelayanan_t
        public $ruangankirim_nama;
        public $no_urut;
        public $petugastransporter_nama;     
        
        /**
        * Returns the static model of the specified AR class.
        * @param string $className active record class name.
        * @return TerimadistribusidarahT the static model class
        */
       public static function model($className = __CLASS__) {
           return parent::model($className);
       }
}
