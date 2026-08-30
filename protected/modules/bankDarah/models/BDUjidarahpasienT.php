<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - model yang digunakan untuk mengambil data tabel Ujidarahpasien_t, hanya untuk di modul bank darah
 * @website      <http://>
 * RSST-1471
 */
class BDUjidarahpasienT extends UjidarahpasienT
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
