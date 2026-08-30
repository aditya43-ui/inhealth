<?php

class PIPendaftaranT extends PendaftaranT
{
        public $jeniskasuspenyakit_nama,$kelas_layanan;
		public $nama_pegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendaftaranT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function getKelasPelayananItems($param=null)
	{
		$criteria = new CdbCriteria();
		if($param==Params::RUANGAN_ID_RAD){
			$criteria->addCondition("ruangan_id = ".Params::RUANGAN_ID_RAD);
        }else if($param==Params::RUANGAN_ID_LAB_KLINIK){
			$criteria->addCondition("ruangan_id = ".Params::RUANGAN_ID_LAB_KLINIK);
		}else if($param==Params::RUANGAN_ID_LAB_ANATOMI){
			$criteria->addCondition("ruangan_id = ".Params::RUANGAN_ID_LAB_ANATOMI);
		}else if(is_array($param)){
			$criteria->addInCondition('ruangan_id', $param);
        }
		return KelasruanganM::model()->findAll($criteria);
	}
	
	public function getRuanganItems($instalasi_id=null)
	{
		if($instalasi_id==null){
			return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama'));
		}else{
			return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama'));   
		}
	}
	
	/**
		* menampilkan dokter 
		* @param type $ruangan_id
		* @return type
    */
	public function getDokterItems($ruangan_id='')
	{
		$criteria = new CdbCriteria();
		if(!empty($ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$ruangan_id);		
		}
		$criteria->addCondition('pegawai_aktif = true');
		$criteria->order = "nama_pegawai, gelardepan";
		$modDokter = DokterV::model()->findAll($criteria);
		return $modDokter;
	}
}