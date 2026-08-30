<?php
class MCPermintaanmcuT extends PermintaanmcuT
{
	public $qty_tindakan;
	public $satuantindakan;
	public $tarif_satuan;
	public $tarif_tindakan;
	public $tarifpaketpel;
	public $jenispemeriksaan_nama;
	public $pemeriksaanlab_id;
	public $pemeriksaanrad_id;
	public $ruangan_nama;
        public $namatindakan;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanmcuT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}