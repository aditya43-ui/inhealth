<?php

class MAInformasipemeliharaanasetV extends InformasipemeliharaanasetV{
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
		$criteria->addBetweenCondition('DATE(pemeliharaanaset_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pemeliharaanaset_id)){
			$criteria->addCondition('pemeliharaanaset_id = '.$this->pemeliharaanaset_id);
		}
		$criteria->compare('LOWER(pemeliharaanaset_no)',strtolower($this->pemeliharaanaset_no),true);
		$criteria->compare('LOWER(pemeliharaanaset_ket)',strtolower($this->pemeliharaanaset_ket),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(gelarbelakang_pegawaimengetahui)',strtolower($this->gelarbelakang_pegawaimengetahui),true);
		$criteria->compare('LOWER(gelarbelakang_pegtugas1)',strtolower($this->gelarbelakang_pegtugas1),true);
		$criteria->compare('LOWER(gelarbelakang_pegtugas2)',strtolower($this->gelarbelakang_pegtugas2),true);
		if(!empty($this->gelarbelakangpegawaimengetahui_id)){
			$criteria->addCondition('gelarbelakangpegawaimengetahui_id = '.$this->gelarbelakangpegawaimengetahui_id);
		}
		if(!empty($this->gelarbelakangpegtugas1_id)){
			$criteria->addCondition('gelarbelakangpegtugas1_id = '.$this->gelarbelakangpegtugas1_id);
		}
		if(!empty($this->gelarbelakangpegtugas2_id)){
			$criteria->addCondition('gelarbelakangpegtugas2_id = '.$this->gelarbelakangpegtugas2_id);
		}
		if(!empty($this->pegtugas1_id)){
			$criteria->addCondition('pegtugas1_id = '.$this->pegtugas1_id);
		}
		$criteria->compare('LOWER(pegtugas1_nama)',strtolower($this->pegtugas1_nama),true);
		$criteria->compare('LOWER(gelardepan_pegawaimengetahui)',strtolower($this->gelardepan_pegawaimengetahui),true);
		$criteria->compare('LOWER(gelardepan_pegtugas1)',strtolower($this->gelardepan_pegtugas1),true);
		$criteria->compare('LOWER(gelardepan_pegtugas2)',strtolower($this->gelardepan_pegtugas2),true);
		$criteria->compare('LOWER(pegtugas2_nama)',strtolower($this->pegtugas2_nama),true);
		if(!empty($this->pegtugas2_id)){
			$criteria->addCondition('pegtugas2_id = '.$this->pegtugas2_id);
		}
		$criteria->compare('LOWER(noinduk_pegawaimengetahui)',strtolower($this->noinduk_pegawaimengetahui),true);
		$criteria->compare('LOWER(noinduk_pegtugas1)',strtolower($this->noinduk_pegtugas1),true);
		$criteria->compare('LOWER(noinduk_pegtugas2)',strtolower($this->noinduk_pegtugas2),true);
		$criteria->compare('LOWER(noidentitas_pegawaimengetahui)',strtolower($this->noidentitas_pegawaimengetahui),true);
		$criteria->compare('LOWER(noidentitas_pegtugas1)',strtolower($this->noidentitas_pegtugas1),true);
		$criteria->compare('LOWER(noidentitas_pegtugas2)',strtolower($this->noidentitas_pegtugas2),true);
		$criteria->compare('LOWER(jenisidentitas_pegtugas2)',strtolower($this->jenisidentitas_pegtugas2),true);
		$criteria->compare('LOWER(jenisidentitas_pegtugas1)',strtolower($this->jenisidentitas_pegtugas1),true);
		$criteria->compare('LOWER(jenisidentitas_pegawaimengetahui)',strtolower($this->jenisidentitas_pegawaimengetahui),true);
		
		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
           
	
}
