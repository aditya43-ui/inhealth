<?php

class ROObatalkespasienT extends ObatalkespasienT {
        public $qty_stok = 0; //untuk validasi 
        public $stokobatalkes_id;
        public $obatalkes_nama;
        public $satuankecil_nama;
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
