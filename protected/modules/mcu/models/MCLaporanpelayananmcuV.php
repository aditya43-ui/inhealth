<?php
class MCLaporanpelayananmcuV extends LaporanpelayananmcuV
{
	public $tgl_awal,$tgl_akhir,$jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $jumlah,$data,$tick;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearchLaporan()
	{
		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->permintaanmcu_id)){
			$criteria->addCondition('permintaanmcu_id = '.$this->permintaanmcu_id);
		}
		$criteria->compare('tarifperpaketmcu',$this->tarifperpaketmcu);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		if(!empty($this->paketpelayanan_id)){
			$criteria->addCondition('paketpelayanan_id = '.$this->paketpelayanan_id);
		}
		$criteria->compare('LOWER(namatindakan)',strtolower($this->namatindakan),true);
		$criteria->compare('tarifpaketpel',$this->tarifpaketpel);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
		$criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
		$criteria->compare('tarifpaket',$this->tarifpaket);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);

		return $criteria;
	}
       
	public function searchLaporanPaket()
	{
		$criteria=$this->criteriaSearchLaporan();
		$criteria->addCondition('tipepaket_id !='.Params::TIPEPAKET_ID_NONPAKET);
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function searchLaporanNonPaket()
	{
		$criteria=$this->criteriaSearchLaporan();
		$criteria->addCondition('tipepaket_id ='.Params::TIPEPAKET_ID_NONPAKET);
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function searchPrintLaporanPaket()
	{
		$criteria=$this->criteriaSearchLaporan();
		$criteria->addCondition('tipepaket_id !='.Params::TIPEPAKET_ID_NONPAKET);
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function searchPrintLaporanNonPaket()
	{
		$criteria=$this->criteriaSearchLaporan();
		$criteria->addCondition('tipepaket_id ='.Params::TIPEPAKET_ID_NONPAKET);
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function searchGrafikPaket()
	{
		$criteria=$this->criteriaSearchLaporan();
		$criteria->addCondition('tipepaket_id !='.Params::TIPEPAKET_ID_NONPAKET);
		$criteria->select = 'count(permintaanmcu_id) as jumlah, daftartindakan_nama as data, tipepaket_nama as tick';
		$criteria->group = 'daftartindakan_nama,tipepaket_nama';
		
		$criteria->limit=15; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function searchGrafikNonPaket()
	{
		$criteria=$this->criteriaSearchLaporan();
		$criteria->addCondition('tipepaket_id ='.Params::TIPEPAKET_ID_NONPAKET);
		$criteria->select = 'count(permintaanmcu_id) as jumlah, daftartindakan_nama as data, tipepaket_nama as tick';
		$criteria->group = 'daftartindakan_nama,tipepaket_nama';
		
		$criteria->limit=15; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}