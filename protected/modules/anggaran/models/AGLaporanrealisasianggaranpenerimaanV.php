<?php

class AGLaporanrealisasianggaranpenerimaanV extends LaporanrealisasianggaranpenerimaanV {
	public $tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('renanggpenerimaan_id',$this->renanggpenerimaan_id);
		$criteria->compare('noren_penerimaan',$this->noren_penerimaan,true);
		$criteria->compare('konfiganggaran_id',$this->konfiganggaran_id);
		$criteria->compare('deskripsiperiode',$this->deskripsiperiode,true);
		$criteria->addBetweenCondition('tglrenanggaranpen', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('sumberanggaran_id',$this->sumberanggaran_id);
		$criteria->compare('sumberanggarannama',$this->sumberanggarannama,true);
		$criteria->compare('nilaipenerimaananggaran',$this->nilaipenerimaananggaran);
		$criteria->compare('realisasianggpenerimaan_id',$this->realisasianggpenerimaan_id);
		$criteria->compare('realisasipenerimaan',$this->realisasipenerimaan);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
