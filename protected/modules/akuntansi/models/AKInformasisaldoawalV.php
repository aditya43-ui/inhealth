<?php
class AKInformasisaldoawalV extends InformasisaldoawalV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public $debit, $kredit, $jmlrekening;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}

?>