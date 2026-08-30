<?php

/**
 * This is the model class for table "lingkungankerja_r".
 *
 * The followings are the available columns in table 'lingkungankerja_r':
 * @property integer $lingkungankerja_id
 * @property integer $pelamar_id
 * @property string $nourut
 * @property string $dgnlingkungan
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property PelamarT $pelamar
 */
class KPLingkunganKerjaR extends LingkunganKerjaR
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LingkunganKerjaR the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getdenganLingkungan(){
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'denganlingkungankerja'));
    }
    
}
?>
