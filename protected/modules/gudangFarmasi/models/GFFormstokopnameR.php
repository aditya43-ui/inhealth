<?php
class GFFormstokopnameR extends FormstokopnameR
{
	public $hpp;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormstokopnameR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
	public function getHarganetto(){
		if(isset($this->obatalkes->harganetto)){
			return $this->obatalkes->harganetto;
		}else{
			return 0;
		}
	}
	public function getHargasatuan(){
		if(isset($this->obatalkes->hargajual)){
			return $this->obatalkes->hargajual;
		}else{
			return 0;
		}
	}
	public function getQtystok(){
		return StokobatalkesT::getJumlahStok($this->obatalkes_id,Yii::app()->user->getState('ruangan_id'));
	}
	//=== END UNTUK TABLE (FORM) STOK OPNAME ===

}