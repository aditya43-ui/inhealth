<?php

/**
 * Extend model dari application.models.PegawairuanganV untuk modul Bank Darah
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDPegawairuanganV extends PegawairuanganV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlatmedisM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}