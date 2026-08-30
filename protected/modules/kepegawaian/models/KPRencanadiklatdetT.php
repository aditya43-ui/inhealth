<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table rencanadiklatdet_t, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class KPRencanadiklatdetT extends RencanadiklatdetT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

?>
