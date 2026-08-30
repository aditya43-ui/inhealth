<?php
class LAPencucianbahanT extends PencucianbahanT
{
	public $bahanperawatan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PencucianbahanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}