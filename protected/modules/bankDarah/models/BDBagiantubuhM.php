<?php
/**
 * Digunakan untuk mengambil data tabel bagiantubuh_m, hanya untuk di modul bank darah
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author       Andyka Putra <andykaputra@.com>
 * @version      2.0.0
 * RSST-1498, RSST-4496
 */
class BDBagiantubuhM extends BagiantubuhM
{	
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BagiantubuhM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * Digunakan untuk mendapatkan dropdown bagian tangan untuk observasi donor darah tabulasi skala nyeri
     * @return type
     */
    public function getBagianTubuh() {
        $modBagianTubuh = BDBagiantubuhM::model()->findAllByPk(array(9, 22, 25, 45, 46, 47, 48, 49, 50, 51, 52, 53));
        return $modBagianTubuh;
    }
}
