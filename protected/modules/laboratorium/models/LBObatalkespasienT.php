<?php

class LBObatalkespasienT extends ObatalkespasienT {
        public $qty_stok = 0; //untuk validasi 
        public $stokobatalkes_id;
        public $satuankecil_nama;
        public $prefix_pendaftaran;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

?>
