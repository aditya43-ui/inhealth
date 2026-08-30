<?php
class RJRujukanT extends RujukanT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    /**
     * validasi pada transaksi versi awal
     * @return type
     */
    public function beforeSave() {         
        if($this->tanggal_rujukan==null || trim($this->tanggal_rujukan)==''){
            $this->setAttribute('tanggal_rujukan', null);
        }

        return parent::beforeSave();
    }
    /**
     * validasi pada transaksi versi awal
     * @return type
     */
    protected function beforeValidate ()
    {
        // convert to storage format
        //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
        $format = new MyFormatter();
        //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
        foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if ($column->dbType == 'date'){
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
//                          JANGAN GUNAKAN YANG INI. FATAL BUGS ==>  $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
        }

        return parent::beforeValidate ();
    }


    /**
     * validasi pada transaksi versi awal
     * @return boolean
     */
    protected function afterFind(){
        foreach($this->metadata->tableSchema->columns as $columnName => $column){

            if (!strlen($this->$columnName)) continue;

            if ($column->dbType == 'date'){                         
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                    }
        }
        return true;
    }
    
    /**
     * Mengambil daftar semua asal rujukan
     * @return CActiveDataProvider 
     */

    public function getAsalRujukanItems()
    {
        return AsalrujukanM::model()->findAllByAttributes(array('asalrujukan_aktif'=>true),array('order'=>'asalrujukan_nama'));
    }

    /**
     * Mengambil daftar semua kabupaten berdasarkan propinsi
     * @return CActiveDataProvider 
     */
    public function getRujukanDariItems($asalrujukan_id=null)
    {
        if(!empty($asalrujukan_id))
            return RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id,),array('order'=>'namaperujuk'));
        else {
            return array();
        }
    }
}
?>
