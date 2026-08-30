<?php

class PPDokrekammedisM extends DokrekammedisM {

    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
//    public function relations()
//	{
//		// NOTE: you may need to adjust the relation name and the related
//		// class name for the relations automatically generated below.
//		return array(
//                    'warnadok'=>array(self::BELONGS_TO, 'WarnadokrmM', 'warnadokrm_id'),
//                    'subrak'=>array(self::BELONGS_TO, 'SubrakM', 'subrak_id'),
//                    'lokasirak'=>array(self::BELONGS_TO, 'LokasirakM', 'lokasirak_id'),
//                    'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
//                    'peminjaman'=>array(self::HAS_ONE, 'PeminjamanrmT', 'dokrekammedis_id'),
//                    //'pendaftaran'=>array(self::HAS_MANY, 'PendaftaranT', array('pasien_id'=>'pendaftaran_id'), 'through'=>'peminjaman'),
//                    
//		);
//	}
//    
//    public function searchPeminjaman()
//	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
//		$criteria=new CDbCriteria;
//		if(!empty($this->dokrekammedis_id)){
//				$criteria->addCondition("dokrekammedis_id = ".$this->dokrekammedis_id); 			
//			}
//		if(!empty($this->warnadokrm_id)){
//				$criteria->addCondition("warnadokrm_id = ".$this->warnadokrm_id); 			
//			}
//                $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik), true);
//                //$criteria->compare('LOWER(pendaftaran.tglpendaftaran)',  strtolower($this->tglpendaftaran), true);
//                $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik), true);
//                $criteria->compare('penjamin.printpeminjaman',  $this->print);
//			if(!empty($this->lokasirak_id)){
//				$criteria->addCondition("lokasirak_id = ".$this->lokasirak_id); 			
//			}
//			if(!empty($this->pasien_id)){
//				$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
//			}
////		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
////		$criteria->compare('LOWER(tglrekammedis)',strtolower($this->tglrekammedis),true);
////		$criteria->compare('LOWER(tglmasukrak)',strtolower($this->tglmasukrak),true);
////		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
////		$criteria->compare('LOWER(tglkeluarakhir)',strtolower($this->tglkeluarakhir),true);
////		$criteria->compare('LOWER(tglmasukakhir)',strtolower($this->tglmasukakhir),true);
////		$criteria->compare('LOWER(nomortertier)',strtolower($this->nomortertier),true);
////		$criteria->compare('LOWER(nomorsekunder)',strtolower($this->nomorsekunder),true);
////		$criteria->compare('LOWER(nomorprimer)',strtolower($this->nomorprimer),true);
////		$criteria->compare('LOWER(warnanorm_i)',strtolower($this->warnanorm_i),true);
////		$criteria->compare('LOWER(warnanorm_ii)',strtolower($this->warnanorm_ii),true);
////		$criteria->compare('LOWER(tgl_in_aktif)',strtolower($this->tgl_in_aktif),true);
////		$criteria->compare('LOWER(tglpemusnahan)',strtolower($this->tglpemusnahan),true);
////		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
////		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
////		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
////		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
////		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
//                $criteria->with = array('warnadok','subrak','lokasirak','pasien', 'peminjaman.pendaftaran');
//                
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
//	}

}