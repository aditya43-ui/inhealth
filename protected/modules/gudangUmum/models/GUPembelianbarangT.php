<?php

class GUPembelianbarangT extends PembelianbarangT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	public $belum = false;
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('date(tglpembelian)', $this->tgl_awal, $this->tgl_akhir);
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition("pembelianbarang_id = ".$this->pembelianbarang_id);			
		}
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition("terimapersediaan_id = ".$this->terimapersediaan_id);			
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);			
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition("supplier_id = ".$this->supplier_id);			
		}
		
		if ($this->belum) {
			$criteria->addCondition('terimapersediaan_id is null');
		}
		
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		if(!empty($this->peg_pemesanan_id)){
			$criteria->addCondition("peg_pemesanan_id = ".$this->peg_pemesanan_id);			
		}
		if(!empty($this->peg_mengetahui_id)){
			$criteria->addCondition("peg_mengetahui_id = ".$this->peg_mengetahui_id);			
		}
		if(!empty($this->peg_menyetujui_id)){
			$criteria->addCondition("peg_menyetujui_id = ".$this->peg_menyetujui_id);			
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search10Terakhir()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'tglpembelian DESC';
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

}

?>
