<?php

class RIPasienKirimKeUnitLainT extends PasienkirimkeunitlainT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasiendirujukkeluarT the static model class
     */

    public $diagnosa_id, $pasienmorbiditas_id,$lokalisasi,$diagnosaklinik,$stadiumt,$stadiumn,$stadiumm,$ketklinik,
    $riwayatdulu,$ketpasebelumnya,$riwayatsebelumnya,
    $pemeriksaanpenunjang, $diagnosis;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
