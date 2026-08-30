<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil tabel komponengaji_m, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/


class KPKomponengajipegawaiM extends KomponengajipegawaiM {
	public $tipekomponen;
	public $jeniskomponen;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public function getDropKomponenGaji(){
		$cri = new CDbCriteria();
		$cri->addCondition(" komponengaji_aktif = TRUE ");
		$cri->order = " komponengaji_nama ASC ";
		$drop = KomponengajiM::model()->findAll($cri);
		
		return CHtml::listData($drop, 'komponengaji_id', 'KomponenNamaDanKode');
	}
	

}

?>
