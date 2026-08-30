<?php

class RJObatalkesPasienT extends ObatalkespasienT
{
	public $qty_stok,$stokobatalkes_id,$satuankecil_nama,$obatalkes_nama;
	public $hargajual,$harganetto;
	public $daftartindakan_id, $daftartindakan_nama;
	public $qtypemakaian,$hargapemakaian;
	public $jmlstok, $obatalkes_kode, $obatalkes_namalain, $ruangan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function searchDetailPemakaianBahan($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->obatalkespasien_id)){
			$criteria->addCondition("obatalkespasien_id = ".$this->obatalkespasien_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition("pasienmasukpenunjang_id = ".$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition("pasienanastesi_id = ".$this->pasienanastesi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);
		}
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition("tindakanpelayanan_id = ".$this->tindakanpelayanan_id);
		}
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition("tipepaket_id = ".$this->tipepaket_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);
		}
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition("racikan_id = ".$this->racikan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);
		}
		$criteria->addCondition('pendaftaran_id ='.$data);
		$criteria->addCondition('t.penjualanresep_id is Null'); //pemakaian bahan bukan obat dari penjualan resep
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchDialogOaPelayanan()
	{

		$criteria = new CDbCriteria;
		$criteria->select = "oa.obatalkes_kode, oa.obatalkes_nama, oa.obatalkes_namalain";
		$criteria->group = $criteria->select;
		$criteria->join = "JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id ".
		"JOIN penjualanresep_t penj ON penj.penjualanresep_id = t.penjualanresep_id ";
		$criteria->order = "oa.obatalkes_nama ASC";

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}

		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}

		if(!empty($this->ruangan_nama)){
			$criteria->compare('LOWER(penj.ruanganasal_nama)',strtolower($this->ruangan_nama),true);
		}

		$criteria->compare('LOWER(oa.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(oa.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(oa.obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->addCondition('oa.obatalkes_aktif = true');
		return new CActiveDataProvider($this, array(
						'criteria'=>$criteria,
		));
	}
}
