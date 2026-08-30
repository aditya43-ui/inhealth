<?php
class BKTarifpemeriksaanradruanganV extends TarifpemeriksaanradruanganV
{
        public $is_pilih = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifpemeriksaanradruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}