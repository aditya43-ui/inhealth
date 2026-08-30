<?php
/**
 * - Extend Komponen Darah M
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-1978
 */

class BDKomponendarahM extends KomponendarahM
{       
        public $daftartindakan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponendarahM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getJeniskantongdarahItems()
	{
            return JeniskantongdarahM::model()->findAll('jeniskantongdarah_aktif=TRUE ORDER BY jeniskantongdarah_id');
	}
        
}