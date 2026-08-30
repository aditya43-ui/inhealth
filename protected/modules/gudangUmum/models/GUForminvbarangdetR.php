<?php
class GUForminvbarangdetR extends ForminvbarangdetR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ForminvbarangdetR the static model class
	 */
	public $qtystok;
        public $inventarisasi;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//=== UNTUK TABLE (FORM) INVENTARISASI BARANG ===
	public function getBarang_kode(){
		if(isset($this->barang->barang_kode)){
			return $this->barang->barang_kode;
		}else{
			return "";
		}
	}
	public function getBarang_nama(){
		if(isset($this->barang->barang_nama)){
			return $this->barang->barang_nama;
		}else{
			return "";
		}
	}
	public function getBarang_merk(){
		if(isset($this->barang->barang_merk)){
			return $this->barang->barang_merk;
		}else{
			return "";
		}
	}
	public function getBarang_noseri(){
		if(isset($this->barang->barang_noseri)){
			return $this->barang->barang_noseri;
		}else{
			return "";
		}
	}
	public function getBarang_satuan(){
		if(isset($this->barang->barang_satuan)){
			return $this->barang->barang_satuan;
		}else{
			return "";
		}
	}
	public function getHargajual(){
		if(isset($this->barang->barang_hargajual)){
			return $this->barang->barang_hargajual;
		}else{
			return "";
		}
	}
	public function getBarang_harganetto(){
		if(isset($this->barang->barang_harganetto)){
			return $this->barang->barang_harganetto;
		}else{
			return "";
		}
	}
}