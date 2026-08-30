<?php
class AKLaporanpembayarangajiV extends LaporanpembayarangajiV
{
	public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpembayarangajiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
//		$criteria->addBetweenCondition('date(periodegaji)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->addBetweenCondition('date(tglpenggajian)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->jenispengeluaran_id)){
			$criteria->addCondition('jenispengeluaran_id = '.$this->jenispengeluaran_id);
		}
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		if(!empty($this->pengeluaranumum_id)){
			$criteria->addCondition('pengeluaranumum_id = '.$this->pengeluaranumum_id);
		}
		$criteria->compare('LOWER(kelompoktransaksi)',strtolower($this->kelompoktransaksi),true);
		$criteria->compare('LOWER(nopengeluaran)',strtolower($this->nopengeluaran),true);
		$criteria->compare('LOWER(tglpengeluaran)',strtolower($this->tglpengeluaran),true);
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition('tandabuktikeluar_id = '.$this->tandabuktikeluar_id);
		}
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);
		if(!empty($this->penggajianpeg_id)){
			$criteria->addCondition('penggajianpeg_id = '.$this->penggajianpeg_id);
		}
		$criteria->compare('LOWER(tglpenggajian)',strtolower($this->tglpenggajian),true);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(pegawai_nip)',strtolower($this->pegawai_nip),true);
		$criteria->compare('LOWER(pegawai_jenisidentitas)',strtolower($this->pegawai_jenisidentitas),true);
		$criteria->compare('LOWER(pegawai_noidentitas)',strtolower($this->pegawai_noidentitas),true);
		$criteria->compare('LOWER(pegawai_gelardepan)',strtolower($this->pegawai_gelardepan),true);
		$criteria->compare('LOWER(pegawai_nama)',strtolower($this->pegawai_nama),true);
		$criteria->compare('LOWER(pegawai_gelarbelakang)',strtolower($this->pegawai_gelarbelakang),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('totalterima',$this->totalterima);
		$criteria->compare('totalpajak',$this->totalpajak);
		$criteria->compare('totalpotongan',$this->totalpotongan);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);		
		$criteria->compare('gajipertahun',$this->gajipertahun);
		$criteria->compare('biayajabatan',$this->biayajabatan);
		$criteria->compare('potonganpensiun',$this->potonganpensiun);
		$criteria->compare('LOWER(kodeptkp)',strtolower($this->kodeptkp),true);
		$criteria->compare('ptkppertahun',$this->ptkppertahun);
		$criteria->compare('penerimaanbersihpertahun',$this->penerimaanbersihpertahun);
		$criteria->compare('pkp',$this->pkp);
		if(!empty($this->persentasepph21)){
			$criteria->addCondition('persentasepph21 = '.$this->persentasepph21);
		}
		$criteria->compare('pph21pertahun',$this->pph21pertahun);
		$criteria->compare('pph21perbulan',$this->pph21perbulan);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('LOWER(satuanvol)',strtolower($this->satuanvol),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('LOWER(keterangankeluar)',strtolower($this->keterangankeluar),true);
		$criteria->compare('isurainkeluarumum',$this->isurainkeluarumum);

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
		));
	}

}