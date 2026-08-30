<?php

class PJAmbiljenazahT extends AmbiljenazahT
{
	public $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AmbiljenazahT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getStatusJenazah($pasien_id='')
        {
            if(!empty($pasien_id)){
                $ambil = PJAmbiljenazahT::model()->findAllByAttributes(array('pasien_id'=>$pasien_id));
                return count((array)$ambil);
            } else {
                return 0;
            }
        }
}