<?php

class STPengajuansterlilisasiT extends PengajuansterlilisasiT{
	public $instalasi_id, $instalasi_nama, $ruangan_nama;
	public $pegawaimengajukan_nama,$pegawaimengetahui_nama;
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(pengajuansterlilisasi_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pengajuansterlilisasi_id)){
			$criteria->addCondition('pengajuansterlilisasi_id = '.$this->pengajuansterlilisasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(pengajuansterlilisasi_no)',strtolower($this->pengajuansterlilisasi_no),true);
		$criteria->compare('LOWER(pengajuansterlilisasi_ket)',strtolower($this->pengajuansterlilisasi_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpengajuan_id)){
			$criteria->addCondition('pegpengajuan_id = '.$this->pegpengajuan_id);
		}
		$criteria->compare('issterilisasiperalatan',$this->issterilisasiperalatan);
		$criteria->compare('issudahditerima',$this->issudahditerima);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}