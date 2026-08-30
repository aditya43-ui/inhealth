<?php

class SATindakanPelayananT extends TindakanpelayananT
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
    
    public function searchDetailTindakan($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if (!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id ='.$this->tindakanpelayanan_id);
		}
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id ='.$this->pasienadmisi_id);
		}
		if (!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
//		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		if (!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id ='.$this->instalasi_id);
		}
		if (!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
		if (!empty($this->shift_id)){
			$criteria->addCondition('shift_id ='.$this->shift_id);
		}
		if (!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id ='.$this->pasienmasukpenunjang_id);
		}
		if (!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id ='.$this->daftartindakan_id);
		}
                $criteria->condition = 'pendaftaran_id = '.$data;
                $criteria->condition = 'tipepaket_id = '.$this->tipepaket_id;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
