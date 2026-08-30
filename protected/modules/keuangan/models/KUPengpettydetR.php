<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table pengpettydet_r, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class KUPengpettydetR extends PengpettydetR {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

?>
