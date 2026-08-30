<?php
/**
 * - Extend Jenis Kantong Darah M
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-1978
 */

class BDJeniskantongdarahM extends JeniskantongdarahM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniskantongdarahM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}