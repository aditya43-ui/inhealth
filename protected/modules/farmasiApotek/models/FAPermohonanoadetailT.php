<?php
class FAPermohonanoadetailT extends PermohonanoadetailT
{
	public $harganetto;
        public $stokakhir;
        public $maksimalstok;
        public $sumberdana_id;
        public $persenpph;
        public $persenppn;
        public $tglkadaluarsa;
        public $kemasanbesar;
        public $satuanbesar_id;
        public $satuanobat;
        public $permohonandetail_qty;
        public $persendiscount;
        public $jmldiscount;
        public $minimalstok;
        public $subtotal;
        public $obatalkes_kategori;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermohonanoadetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}