<?php

class KPRencanadiklatT extends RencanadiklatT {
	public $pemberitugas_nama,$pegawaimengetahui_nama,$pegawaimenyetujui_nama,$nomorindukpegawai;
	public $pegawai_nama,$jenisdiklat_nama,$jmlRow,$nama_pegawai,$ceklis;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function searchRencanaDiklat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		$criteria->with = array('pegawai,pegawaidiklatTs');
		//$criteria->join = "JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id 
		//				   LEFT JOIN pegawaidiklat_t ON pegawaidiklat_t.rencanadiklat_id = t.rencanadiklat_id";
		if(!empty($this->rencanadiklat_id)){
			$criteria->addCondition('t.rencanadiklat_id = '.$this->rencanadiklat_id);
		}
		
		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir))
			$criteria->addBetweenCondition ('tglrencanadiklat', $this->tgl_awal, $this->tgl_akhir);
		
	//	if(!empty($this->pegawai_id)){
	//		$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
	//	}
                
		if(!empty($this->jenisdiklat_id)){
			$criteria->addCondition('jenisdiklat_id = '.$this->jenisdiklat_id);
		}
	//	$criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
        //        $criteria->compare('pegawai_m.nomorindukpegawai',$this->nomorindukpegawai);
		$criteria->compare('LOWER(norencanadiklat)',strtolower($this->norencanadiklat),true);
		$criteria->compare('LOWER(rencanadiklat_periode)',strtolower($this->rencanadiklat_periode),true);
		$criteria->compare('LOWER(rencanadiklat_sampaidgn)',strtolower($this->rencanadiklat_sampaidgn),true);
		$criteria->compare('LOWER(tempat_diklat)',strtolower($this->tempat_diklat),true);
		$criteria->compare('LOWER(alamat_diklat)',strtolower($this->alamat_diklat),true);
		$criteria->compare('LOWER(namadiklat)',strtolower($this->namadiklat),true);
		$criteria->compare('LOWER(keterangan_diklat)',strtolower($this->keterangan_diklat),true);
		$criteria->compare('LOWER(status_rencana)',strtolower($this->status_rencana),true);
		//$criteria->addCondition('pegawaidiklat_t.rencanadiklat_id IS NULL');
		$criteria->order = 'norencanadiklat';
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
