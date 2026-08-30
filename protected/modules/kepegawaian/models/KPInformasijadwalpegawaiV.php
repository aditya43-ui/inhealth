<?php

class KPInformasijadwalpegawaiV extends InformasijadwalpegawaiV
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasiJadwal()
	{
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tglbuatjadwal)', $this->tgl_awal, $this->tgl_akhir);

		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		$criteria->compare('LOWER(shift_jamawal)',strtolower($this->shift_jamawal),true);
		$criteria->compare('LOWER(shift_jamakhir)',strtolower($this->shift_jamakhir),true);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(shift_kode)',strtolower($this->shift_kode),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		$criteria->compare('LOWER(kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
		$criteria->compare('LOWER(periodebuatjadwal)',strtolower($this->periodebuatjadwal),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->menyetujiu_id)){
			$criteria->addCondition('menyetujiu_id = '.$this->menyetujiu_id);
		}
		$criteria->compare('LOWER(keterangan_penjadwalan)',strtolower($this->keterangan_penjadwalan),true);

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        


}