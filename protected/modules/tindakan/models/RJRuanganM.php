<?php

class RJRuanganM extends TindakanruanganM
{
    public $daftartindakan_id,$kategoritindakan_nama,$ruangan_nama,$harga_tariftindakan;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        

}