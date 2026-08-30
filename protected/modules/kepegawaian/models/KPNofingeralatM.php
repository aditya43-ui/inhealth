<?php

/**
 * This is the model class for table "nofingeralat_m".
 *
 * The followings are the available columns in table 'nofingeralat_m':
 * @property integer $nofingeralat_id
 * @property integer $pegawai_id
 * @property integer $alatfinger_id
 * @property string $tglregistrasifinger
 * @property integer $nofinger
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KPNofingeralatM extends NofingeralatM
{
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return NofingeralatM the static model class
    */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}