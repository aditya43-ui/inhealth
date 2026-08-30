<?php

/**
 * This is the model class for table "typeanastesi_m".
 *
 * The followings are the available columns in table 'typeanastesi_m':
 * @property integer $typeanastesi_id
 * @property integer $anastesi_id
 * @property string $typeanastesi_nama
 * @property string $typeanastesi_namalain
 * @property boolean $typeanastesi_aktif
 *
 * The followings are the available model relations:
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property AnastesiM $anastesi
 */
class SATypeanastesiM extends TypeanastesiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TypeanastesiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getAnestesiItems()
    {
        return AnastesiM::model()->findAll('anastesi_aktif = true ORDER BY anastesi_nama');
    }

}