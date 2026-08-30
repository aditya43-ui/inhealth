<?php

/**
 * This is the model class for table "jenisform_m".
 *
 * The followings are the available columns in table 'jenisform_m':
  * @property integer $jenisform_id
 * @property string $jenisform_nama
 */
class SAJenisFormlabM extends JenisformM
{   
	public $jenisform_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisformM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}