<?php

class GZTindakanPelayananT extends TindakanpelayananT
{
        public $jenistarif_id; //untuk di form
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