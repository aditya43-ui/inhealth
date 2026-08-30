<?php
/**
 * Digunakan untuk mengekstend model LampiransuratsehatR
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * @package application.modules.rekamMedis
 * @subpackage models
 */
class EKLampiransuratsehatR extends LampiransuratsehatR
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResumemedisJadwalkontrolR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
?>