<?php
class MCTariftindakanperdaruanganV extends TariftindakanperdaruanganV
{
	public $is_pilih = 0;
	public $tipepaket_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}