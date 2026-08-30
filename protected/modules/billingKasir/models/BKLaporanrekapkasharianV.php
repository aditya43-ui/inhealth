<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil table Pengajuanpetty_t, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*		@wiki		https://piiproject.atlassian.net/wiki/spaces/MDO 
*/


class BKLaporanrekapkasharianV extends LaporanrekapkasharianV {
	public $rekapclosing_umumrj;
	public $rekapclosing_umumri;
	public $rekapclosing_ekses;
	public $rekapclosing_piutang;
	public $rekapclosing_saldomalam;
	public $rekapclosing_debetbca;	
	public $rekapclosing_pelunasanpiutang;
	public $rekapclosing_lainlain;	
	public $rekapclosing_totalcash;
	
	public $rekappendapatan_bpjs;
	public $rekappendapatan_asuransi;
	public $rekappendapatan_umum;
	public $rekappendapatan_jumlah;
	public $rekappendapatan_ekses;
	
	public $rekapuangpelayanan_nilaiuang; 	

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	
	public function criteriaSearch(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition("DATE(tanggal)", $this->tgl_awal, $this->tgl_akhir);
		$criteria->order = " DATE(tanggal) ASC ";
				
		return $criteria;
	}
	
	public function searchLaporan(){
		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;
		
		return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
				'pagination'=>false
        ));
	}
	
	public function searchLaporanPrint(){
		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;
		
		return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
				'pagination'=>false
        ));
	}

}

?>
