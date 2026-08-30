<?php

class RKMetodeGCSM extends MetodegcsM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MetodegcsM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getTextMetodeGCSM()
        {
            return $this->metodegcs_nilai.'. '.$this->metodegcs_nama;
        }

}