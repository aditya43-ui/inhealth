<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - model yang digunakan untuk mengambil data tabel BDPengujiandarah_t, hanya untuk di modul bank darah
 * @website      <http://>
 * RSST-1515
 */
class BDPengujiandarahT extends PengujiandarahT
{

    public $goldar1, $rhesus1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PengujiandarahT the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
