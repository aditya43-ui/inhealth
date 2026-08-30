<?php

/**
 * @author Tantowy <tantowijaya@.com>
 * This is the model class for table "seleksikuesioner_t".
 *
 * The followings are the available columns in table 'seleksikuesioner_t':
 * @property integer $seleksidonor_id
 * @property integer $daftardonasi_id
 * @property integer $kuesionerdonor_id
 * @property boolean $ceklist
 *
 * The followings are the available model relations:
 * @property KuesionerdonorM $kuesionerdonor
 * @property SeleksipendonorT $seleksidonor
 */
class BDSeleksikuesionerT extends SeleksikuesionerT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SeleksikuesionerT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
}