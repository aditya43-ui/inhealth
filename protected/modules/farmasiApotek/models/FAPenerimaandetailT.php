<?php

class FAPenerimaandetailT extends PenerimaandetailT
{
    public $totalharga = 0; //menampilkan data penerimaanbarang_t.totalharga
    public $hargabelibruto = 0; //=hargabelibesar * jmlterima
    public $mergediskon = 0; //=hargabelibesar * persendiscount * jmlterima
    public $mergeppn = 0; //=hargappnper * jmlterima
    public $subtotalobat = 0; //subtotal per ppn
    
    public $satuanobat;
    public $subtotal;
    public $checklist = 1;
	public $nobatch;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaandetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * hargappnToPersen konversi dari rupiah Ppn ke persen Ppn
         * @return int
         */
        public function getHargappnToPersen(){
            $persen = 10;
            if(!empty($this->hargappnper))
                $persen = 10;
            else
                $persen = 0;
            return $persen;
        }

}