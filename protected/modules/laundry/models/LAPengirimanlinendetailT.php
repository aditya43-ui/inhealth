<?php
class LAPengirimanlinendetailT extends PengirimanlinendetailT
{
	public $kodelinen,$namalinen, $kodepenyimpan, $penyimpananlinen_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengirimanlinendetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}