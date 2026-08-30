<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table biayapelatihan_t, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class KPBiayapelatihanT extends BiayapelatihanT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

?>
