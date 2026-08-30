<?php

class MCTindakanPelayananKarcisT extends TindakanpelayananT
{
	public $is_pilihtindakan = 0; //karcis uncheck
	public $jenistarif_id; //untuk membantu filter tarif dari form
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}