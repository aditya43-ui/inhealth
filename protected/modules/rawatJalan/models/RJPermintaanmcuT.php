<?php
class RJPermintaanmcuT extends PermintaanmcuT
{
	public $qty_tindakan,$satuantindakan,$tarif_satuan,$tarif_tindakan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}