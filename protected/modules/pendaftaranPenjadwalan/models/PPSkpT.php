<?php

/**
 * Class model tabel skp_t
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage models
 */
class PPSkpT extends SkpT {

    public $nokartu, $tglskp, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $lakalantas, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans, $lokasilakalantas, $jenisfaskes;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SkpT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
