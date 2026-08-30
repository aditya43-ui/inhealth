<?php

class AKPenggajianpegT extends LaporanpenggajianV
{    
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        public $tglAwal, $tglAkhir, $nama_pegawai, $jabatan_id, $periodegaji, $harikerja, $jmlefektifharikerja;
        public $gajipph;
        public $biayajabatan;
        public $iuranpensiun;
        public $penerimaanpph;
        public $ptkp;
        public $pkp;
        public $pphpersen;
        public $pph21;
        public $tick;
        public $data;
		public $jumlah;

}
?>
