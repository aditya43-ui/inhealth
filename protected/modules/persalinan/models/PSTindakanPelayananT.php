<?php

class PSTindakanPelayananT extends TindakanpelayananT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanpelayananT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getJumlahTarif()
    {
        return $this->tarif_tindakan * $this->qty_tindakan + $this->tarifcyto_tindakan;
    }
                
    protected function afterFind(){
        foreach($this->metadata->tableSchema->columns as $columnName => $column){

            if (!strlen($this->$columnName)) continue;

            if ($column->dbType == 'date'){                         
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                    CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                    }
        }
        return true;
    }
    
//    public function getTipePaketItems()
//    {
//        return TipepaketM::model()->findAllByAttributes(array('tipepaket_aktif'=>true));
//    }
    
    public function searchDetailTindakan($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($data)){
			$criteria->addCondition('pendaftaran_id='.$data);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
