<?php

class LBPegawaiM extends PegawaiM
{
    
    public $nama_pemakai;
    public $new_password;
    public $new_password_repeat;  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
	 */
    public $tempPhoto;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * menampilkan tenaga laboratorium
	 * @param type $ruangan_id
	 */
	public function getTenagaLaboratoriums($ruangan_id = null){
		$criteria = new CDbCriteria();
		$criteria->addCondition("kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN);
		if(!empty($ruangan_id)){
			$criteria->join = "JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id";
			$criteria->addCondition("ruanganpegawai_m.ruangan_id = ".$ruangan_id);
		}
		$models = self::model()->findAll($criteria);
		if(count((array)$models) > 0){
			return $models;
		}else{
			return array();
		}
	}

}