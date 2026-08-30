<?php
/**
 * ini akan digantikan dengan BKBayarangsuranpelayananT
 * jadi jangan gunakan model ini lagi
 */
class BKBayarAngsuranPelayananT extends BayarangsuranpelayananT
{
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