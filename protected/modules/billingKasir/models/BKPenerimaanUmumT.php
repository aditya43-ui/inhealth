<?php

class BKPenerimaanUmumT extends PenerimaanumumT
{
        public $isuraiantransaksi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanumumT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('buktibayar');
		$criteria->addCondition('buktibayar.returpenerimaanumum_id IS NULL');
		$criteria->addBetweenCondition('DATE(tglpenerimaan)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->penerimaanumum_id)){
			$criteria->addCondition("penerimaanumum_id = ".$this->penerimaanumum_id);					
		}
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition("tandabuktibayar_id = ".$this->tandabuktibayar_id);					
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
		}
		if(!empty($this->jenispenerimaan_id)){
			$criteria->addCondition("jenispenerimaan_id = ".$this->jenispenerimaan_id);					
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
		}
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(kelompoktransaksi)',strtolower($this->kelompoktransaksi),true);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('LOWER(keterangan_penerimaan)',strtolower($this->keterangan_penerimaan),true);
		$criteria->compare('LOWER(namapenandatangan)',strtolower($this->namapenandatangan),true);
		$criteria->compare('LOWER(nippenandatangan)',strtolower($this->nippenandatangan),true);
		$criteria->compare('LOWER(jabatanpenandatangan)',strtolower($this->jabatanpenandatangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}