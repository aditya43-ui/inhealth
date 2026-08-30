<?php

class AGPegawairuanganV extends PegawairuanganV{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function searchPegawaiMenyetujui()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
		$criteria->select = $criteria->group;
//		contoh diambil dari transaksi rencana kebutuhan (Gudang Farmasi) 
//		$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_FARMASI);   
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->order = 'nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	       
	public function getNamaLengkap()
	{
		return (isset($this->gelardepan) ? $this->gelardepan : "").' '.$this->nama_pegawai.(isset($this->gelarbelakang_nama) ? ', '.$this->gelarbelakang_nama : "");
	}
	
}
