<?php
class RJHasilpemeriksaanlabT extends HasilpemeriksaanlabT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'detailhasilpemeriksaanlab'=>array(self::HAS_MANY, 'DetailhasilpemeriksaanlabT', 'hasilpemeriksaanlab_id'),
		);
	}

}