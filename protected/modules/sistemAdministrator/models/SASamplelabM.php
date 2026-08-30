<?php
/**
 * This is the model class for table "samplelab_m".
 *
 * The followings are the available columns in table 'samplelab_m':
 * @property integer $samplelab_id
 * @property string $samplelab_nama
 * @property string $samplelab_namalainnya
 * @property boolean $samplelab_aktif
 */
class SASamplelabM extends SamplelabM{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SamplelabM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
