<?php

class GFFakturDetailT extends FakturdetailT
{
        public $harganettoper;
        public $persenppn;
        public $persenpph;
        public $checklist;
        public $jmlpermintaan;
        public $subtotal;
		public $satuanobat;
		public $satuankecil_nama;
		public $satuanbesar_nama;
		public $hargasatuanper;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturdetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * getHargaBeliBesar menampilkan harga belibesar dari penerimaandetail_t
         */
        public function getHargaBeliBesar(){
            $hbb = PenerimaandetailT::model()->findByAttributes(array('penerimaandetail_id'=>$this->penerimaandetail_id))->hargabelibesar;
            return $hbb;
        }
        
        
}