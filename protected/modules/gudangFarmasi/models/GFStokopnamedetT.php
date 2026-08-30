<?php

class GFStokopnamedetT extends StokopnamedetT{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchDataObat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->stokopnamedet_id)){
			$criteria->addCondition('stokopnamedet_id = '.$this->stokopnamedet_id);
		}
		if(!empty($this->formstokopname_id)){
			$criteria->addCondition('formstokopname_id = '.$this->formstokopname_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->stokopname_id)){
			$criteria->addCondition('stokopname_id = '.$this->stokopname_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('volume_sistem',$this->volume_sistem);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jumlahharga',$this->jumlahharga);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('jumlahnetto',$this->jumlahnetto);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function searchDataObatPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->stokopnamedet_id)){
			$criteria->addCondition('stokopnamedet_id = '.$this->stokopnamedet_id);
		}
		if(!empty($this->formstokopname_id)){
			$criteria->addCondition('formstokopname_id = '.$this->formstokopname_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->stokopname_id)){
			$criteria->addCondition('stokopname_id = '.$this->stokopname_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('volume_sistem',$this->volume_sistem);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jumlahharga',$this->jumlahharga);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('jumlahnetto',$this->jumlahnetto);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
	
	//=== UNTUK TABLE (FORM) STOK OPNAME ===
	public function getJenisobatalkes_nama(){
		if(isset($this->obatalkes->jenisobatalkes->jenisobatalkes_nama)){
			return $this->obatalkes->jenisobatalkes->jenisobatalkes_nama;
		}else{
			return "";
		}
	}
	public function getObatalkes_kode(){
		if(isset($this->obatalkes->obatalkes_kode)){
			return $this->obatalkes->obatalkes_kode;
		}else{
			return "";
		}
	}
	public function getObatalkes_nama(){
		if(isset($this->obatalkes->obatalkes_nama)){
			return $this->obatalkes->obatalkes_nama;
		}else{
			return "";
		}
	}
	public function getObatalkes_golongan(){
		if(isset($this->obatalkes->obatalkes_golongan)){
			return $this->obatalkes->obatalkes_golongan;
		}else{
			return "";
		}
	}
	public function getObatalkes_kategori(){
		if(isset($this->obatalkes->obatalkes_kategori)){
			return $this->obatalkes->obatalkes_kategori;
		}else{
			return "";
		}
	}
	public function getHargajual_avg(){
		return $this->hargasatuan;
	}
	public function getHarganettoapotek_avg(){
		return $this->harganetto;
	}
	public function getQtystok(){
		return StokobatalkesT::getJumlahStok($this->obatalkes_id,Yii::app()->user->getState('ruangan_id'));
	}
	//=== END UNTUK TABLE (FORM) STOK OPNAME ===
	/**
	 * menampilkan jumlah selisih stok (copy dari: StokobatalkesT::getJumlahStok())
	 */
	public function getJmlSelisihStok($ruangan_id = null){
		$criteria = new CDbCriteria();
		$criteria->addCondition('stokoa_aktif IS TRUE');
		$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		if(!empty($ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$ruangan_id);
		}
		$criteria->addBetweenCondition("create_time",$this->tglperiksafisik,date("Y-m-d H:i:s"));
		$criteria->group = "obatalkes_id, ruangan_id";
		$criteria->select = "sum(qtystok_in - qtystok_out) AS qtystok";
		$model = StokobatalkesT::model()->find($criteria);
		if(isset($model->qtystok)){
			return $model->qtystok;
		}else{
			return 0;
		}
	}
}

?>
