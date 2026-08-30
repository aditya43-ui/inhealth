<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table realisasidiklat_t, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class KPRealisasidiklatT extends RealisasidiklatT {

	public $tgl_awal, $tgl_akhir;
	
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function searchInformasi() {
		$prov = $this->search();
		
		$prov->criteria->addBetweenCondition('tglrealisasi::date', $this->tgl_awal, $this->tgl_akhir);
		
		return $prov;
	}

}

?>
