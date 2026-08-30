<?php

/**
 * This is the model class for table "pembatalanuangmuka_t".
 *
 * The followings are the available columns in table 'pembatalanuangmuka_t':
 * @property integer $pembatalanuangmuka_id
 * @property integer $bayaruangmuka_id
 * @property integer $tandabuktikeluar_id
 * @property integer $tandabuktibayar_id
 * @property string $tglpembatalan
 * @property string $keterangan_batal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BKPembatalanUangmukaT extends PembatalanuangmukaT
{
    
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return PembatalanuangmukaT the static model class
    */
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    protected function beforeValidate ()
    {
        $format = new MyFormatter();
        foreach($this->metadata->tableSchema->columns as $columnName => $column)
        {
            if($column->dbType == 'date')
            {
                $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
            }elseif ($column->dbType == 'timestamp without time zone'){
                $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
            }
        }
        return parent::beforeValidate();
    }        
}