<?php
class GUInvbarangdetT extends InvbarangdetT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvbarangdetT the static model class
	 */
	public $qtystok,$inventarisasi_hargasatuan,$inventarisasi_qty_skrg,$inventarisasi_kode;
        public $inventarisasi_qty_in, $inventarisasi_qty_out;
        
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
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invbarangdet_id' => 'ID',
			'barang_satuan' => 'Barang Satuan',
			'invbarang_id' => 'Inv barang ID',
			'barang_id' => 'Barang',
			'volume_fisik' => 'Volume Fisik',
			'harga_satuan' => 'Harga Satuan',
			'jumlah_harga' => 'Jumlah Harga',
			'harga_netto' => 'Harga Netto',
			'jumlah_netto' => 'Jumlah Netto',
			'kondisi_barang' => 'Kondisi Barang',
			'forminvbarangdet_id' => 'Forminvbarangdet',
			'inventarisasi_id' => 'Inventarisasi',
			'tglperiksafisik' => 'Tgl. Periksa Fisik',
			'volume_sistem' => 'Volume Sistem',
			'selisih_sistem' => 'Selisih Sistem',
			'selisih_fisik' => 'Selisih Fisik',
		);
	}
	
	public function getJmlSelisihStok($inventarisasi_id = null){
		$criteria = new CDbCriteria();
		$criteria->select = 'SUM(jumlah) AS jumlah';
		$criteria->addBetweenCondition('invbarang_tgl', $this->tglperiksafisik, date('Y-m-d H:i:s'));
		$criteria->addCondition('barang_id ='. $this->barang_id);
		$model = GUInformasikartustokbarangV::model()->find($criteria);
		if(isset($model->jumlah)){
			return $model->jumlah;
		}else{
			return 0;
		}
	}
}