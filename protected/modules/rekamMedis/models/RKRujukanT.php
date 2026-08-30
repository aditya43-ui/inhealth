<?php

class RKRujukanT extends RujukanT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
public function getAsalRujukanItems()
        {
            return AsalrujukanM::model()->findAllByAttributes(array('asalrujukan_aktif'=>true),array('order'=>'asalrujukan_nama'));
        }

}