<?php

class RIPendaftaranT extends PendaftaranT
{
        public $jeniskasuspenyakit_nama,$kelas_layanan;
		public $nama_pegawai, $alamat_pasien, $no_rekam_medik, $spesialissubspesialis_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendaftaranT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
       
	

	public function getKelasTanggunganItems()
	{
		$cri = new CDbCriteria();
		$cri->addCondition(" kelaspelayanan_aktif = TRUE ");
		$cri->addCondition(" kelasbpjs_id IS NOT NULL ");
		$cri->order = " urutankelas ASC ";
		return KelaspelayananM::model()->findAll($cri);
	}
		
	public function getKelasPelayananItems()
	{
		return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
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

	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama ASC') ;
	}
}