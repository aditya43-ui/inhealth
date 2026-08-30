<?php

class BKTandabuktibayarT extends TandabuktibayarT {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktibayarT the static model class
	 */
	public $tgl_awal;
	public $tgl_akhir;
	public $is_menggunakankartu, $carapembayaran_nama, $loket_id, $loket_nama, $jnspembayar_id;
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'ruangan_id' => 'Ruangan',
			'pembatalanuangmuka_id' => 'Pembatalanuangmuka',
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'closingkasir_id' => 'Closingkasir',
			'returpenerimaanumum_id' => 'Returpenerimaanumum',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'returbayarpelayanan_id' => 'Returbayarpelayanan',
			'shift_id' => 'Shift',
			'nourutkasir' => 'No Urut Kasir',
			'nobuktibayar' => 'No. Bukti Bayar',
			'tglbuktibayar' => 'Tanggal Bukti Bayar',
			'carapembayaran' => 'Cara Pembayaran',
			'dengankartu' => 'Kartu / Transfer',
			'bankkartu' => 'Nama Bank',
			'nokartu' => 'No. Kartu / No. Rekening Pengirim',
			'nostrukkartu' => 'No. Struk / No. Transfer',
			'darinama_bkm' => 'Dari Nama',
			'alamat_bkm' => 'Alamat',
			'sebagaipembayaran_bkm' => 'Sebagai Pembayaran',
			'jmlpembulatan' => 'Jumlah Pembulatan',
			'jmlpembayaran' => 'Jumlah Pembayaran',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayamaterai' => 'Biaya Materai',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uang Kembalian',
			'keterangan_pembayaran' => 'Keterangan Pembayaran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Petugas Kasir',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'isprint' => 'Isprint',
			'pembayarankapitasidetail_id' => 'Pembayarankapitasidetail',
			'bank_id' => 'Bank',
		);
	}
	
	public function searchTable() {
		$criteria = new CDbCriteria;
		$criteria->select = "t.pembayaranpelayanan_id, t.tandabuktibayar_id, t.jmlpembulatan, t.tglbuktibayar, t.uangditerima, t.uangkembalian, t.bank_nominal, t.nobuktibayar, t.carapembayaran, loket_m.loket_nama, t.bayaruangmuka_id, t.darinama_bkm";
		$criteria->group = $criteria->select;

		$criteria->join .= "left JOIN pembayaranpelayanan_t on pembayaranpelayanan_t.pembayaranpelayanan_id = t.pembayaranpelayanan_id
			LEFT JOIN antrian_t on antrian_t.pendaftaran_id = pembayaranpelayanan_t.pendaftaran_id 
			LEFT JOIN loket_m on loket_m.loket_id = antrian_t.loket_id 
			LEFT JOIN jenispembayaran_t on jenispembayaran_t.tandabuktibayar_id = t.tandabuktibayar_id 
			LEFT JOIN jnspembayar_m on jnspembayar_m.jnspembayar_id = jenispembayaran_t.jnspembayar_id";
		if(!empty($this->shift_id)){
			if (is_array($this->shift_id)){
				$criteria->addInCondition("t.shift_id",$this->shift_id);			
			}else{
				$criteria->addCondition("t.shift_id = ".$this->shift_id);			
			}
		}

		if(!empty($this->loket_id)){
			if (is_array($this->loket_id)){
					$criteria->addInCondition("loket_m.loket_id",$this->loket_id);			
				}else{
					$criteria->addCondition("loket_m.loket_id = ".$this->loket_id);			
				}
			}
		if (!empty($this->ruangan_id)) {
			$criteria->addCondition("t.ruangan_id = " . $this->ruangan_id);
		}

		if (!empty($this->create_loginpemakai_id)) {
			$criteria->addCondition("t.create_loginpemakai_id = " . $this->create_loginpemakai_id);
		}
                
		$criteria->addBetweenCondition('t.tglbuktibayar', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition('t.closingkasir_id IS NULL');
    $criteria->compare('LOWER(t.carapembayaran)',strtolower($this->carapembayaran),false);   
		
		if (!empty($this->jnspembayar_id)) {
			$criteria->addCondition("jnspembayar_m.jnspembayar_id = " . $this->jnspembayar_id);
		}
                
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function getRuanganKasir() {
		$criteria = new CDbCriteria;
		$criteria->addInCondition('instalasi_id',array(Params::INSTALASI_ID_KASIR, Params::INSTALASI_ID_FARMASI, 15, Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_REHAB));
		return RuanganM::model()->findAll($criteria);
	}
        
       

}
