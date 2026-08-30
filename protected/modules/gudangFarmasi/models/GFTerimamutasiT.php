<?php
class GFTerimamutasiT extends TerimamutasiT
{
        public $instalasitujuan_id;
        public $pesanobatalkes_id;
        public $ruangantujuan_id;
        public $pegawaimengetahui_nama;
        public $pegawaipenerima_nama;
        public $totalharganettomutasi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimamutasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}