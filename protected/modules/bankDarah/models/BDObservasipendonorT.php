<?php
/**
 * Digunakan untuk mengambil data tabel Gambarnyeri_t, hanya untuk di modul bank darah
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * RSST-1498
 */
class BDObservasipendonorT extends ObservasipendonorT
{
    public $ada_keluhan;
	
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ObservasipendonorT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}