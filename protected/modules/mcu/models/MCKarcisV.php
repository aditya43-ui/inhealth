<?php
class MCKarcisV extends KarcisV
{
	public $is_pilihtindakan,$tarif_satuan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}