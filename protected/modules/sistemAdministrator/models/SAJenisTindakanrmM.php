<?php
/**
 * This is the model class for table "jenistindakanrm_m".
 *
 * The followings are the available columns in table 'jenistindakanrm_m':
 * @property integer $jenistindakanrm_id
 * @property string $jenistindakanrm_nama
 * @property string $jenistindakanrm_namalainnya
 * @property boolean $jenistindakanrm_aktif
 */
class SAJenisTindakanrmM extends JenistindakanrmM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JenistindakanrmM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
