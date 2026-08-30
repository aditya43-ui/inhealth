<?php

class LBNilaiRujukanM extends NilairujukanM
{
        public $daftartindakan_id;
        public $jenispemeriksaanlab_id;
        public $pemeriksaanlab_id;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NilairujukanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
            
		return parent::model($className);
	}
}