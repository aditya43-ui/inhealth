<?php

class KUPembayarklaimdetailT extends PembklaimdetalT
{
	public $tgl_pendaftaran, $no_pendaftaran, $nama_pasien;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktibayarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDetail($id=null){
		$criteria=new CDbCriteria;
		$criteria->join = "JOIN pendaftaran_t ON t.pendaftaran_id = pendaftaran_t.pendaftaran_id 
						JOIN pasien_m ON t.pasien_id = pasien_m.pasien_id";
		if(!empty($id)){
			$criteria->addCondition('t.pembayarklaim_id = '.$id);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}