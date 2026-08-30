<?php
class RIRencanatindakanT extends RencanatindakanT
{
	public $kategoriTindakanNama,$daftartindakanNama,$is_pilihtindakan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanatindakanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}