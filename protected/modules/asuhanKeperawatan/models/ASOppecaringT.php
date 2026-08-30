<?php
/**
 * Model extend oppecaring_t di modul asuhan keperawatan 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.asuhankeperawatan
 * @subpackage models
 * @category model
 */
class ASOppecaringT extends OppecaringT {

    public $namaunitkerja, $indikatoroppekeperawatan_nama,$return; 
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return OppecaringT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
