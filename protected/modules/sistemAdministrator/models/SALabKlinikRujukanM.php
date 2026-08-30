<?php
/**
 * This is the model class for table "labklinikrujukan_m".
 *
 * The followings are the available columns in table 'labklinikrujukan_m':
 * @property integer $labklinikrujukan_id
 * @property string $labklinikrujukan_nama
 * @property string $labklinikrujukan_alamat
 * @property string $labklinikrujukan_telp
 * @property string $labklinikrujukan_mobile
 * @property string $labklinikrujukan_dokterpj
 * @property boolean $labklinikrujukan_aktif
 */
class SALabKlinikRujukanM extends LabklinikrujukanM{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LabklinikrujukanM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
