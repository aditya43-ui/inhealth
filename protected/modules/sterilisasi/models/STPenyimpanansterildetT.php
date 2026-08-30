<?php

class STPenyimpanansterildetT extends PenyimpanansterildetT{
	public $namaPeralatan, $namaLinen;
	public $checklist,$status_penerimaan;
	public $ruangan_nama,$peralatansterilisasi_nama,$sterilisasi_no,$waktukadaluarsa,$instalasi_nama;
        public $peralatansterilisasi_id;
        public $barang_id;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPeralatansterilisasiNama() {
            if (empty($this->peralatansterilisasi_id)) {
                return "-";
            }
            
            $steril = PeralatansterilisasiM::model()->findByPk($this->peralatansterilisasi_id);
            if (empty($steril)) {
                return "-";
            }
            
            return $steril->peralatansterilisasi_nama;
        }
}
