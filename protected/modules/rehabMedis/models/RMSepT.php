<?php

class RMSepT extends SepT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SepT the static model class
	 */
	     public $nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $lakalantas, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans, $lokasilakalantas, $jenisfaskes;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}