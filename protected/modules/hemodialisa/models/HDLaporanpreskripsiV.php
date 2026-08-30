<?php

class HDLaporanpreskripsiV extends LaporanpreskripsiV
{
	public $tgl_awal,$tgl_akhir; 
    public $heparin_continyu_cek; 
    public $prep_besi_cek;
	public $ultrafiltrasi_mode_cek, $natrium_mode_cek, $lama_uso_uf_cek, $iso_uf_ml_cek , $bicarbonat_mode_cek;
	public $tanpaheparin_nama_cek,$heparin_lmwh_cek,$heparin_intermiten_cek;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	} 
	
	public function searchTable() {
        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('periksahd_tgl', $this->tgl_awal, $this->tgl_akhir);	 
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true); 
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true); 
        if (!empty($this->dialiserke)) {    
          if($this->dialiserke =='1-5') {
			 
                 $criteria->addInCondition("dialiserke", array(1,2,3,4,5));

             }else if($this->dialiserke =='6-10') {
                    $criteria->addInCondition("dialiserke", array(6,7,8,9,10));
             }else if($this->dialiserke == 'nol') {
                    $criteria->addInCondition("dialiserke", array(0));
             }  
        }
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}  
//			$criteria->compare('LOWER(lamahd_jam)',strtolower($this->lamahd_jam),true);   
//		$criteria->compare('LOWER(lamahd_jam)',strtolower($this->lamahd_jam),true,'AND', 'LIKE'); 
		$criteria->addSearchCondition('lamahd_jam', $this->lamahd_jam, true, 'AND', 'ILIKE');
//		$criteria->compare('LOWER(kec_darah_qb)',strtolower($this->kec_darah_qb),true);  
		$criteria->compare('LOWER(jenistransfusi_nama)',strtolower($this->jenistransfusi_nama),true);
		$criteria->compare('obat_hemapo',$this->obat_hemapo);  
	    $criteria->compare('obat_recormon',$this->obat_recormon);  
		$criteria->compare('obat_eprex',$this->obat_eprex);  
        $criteria->compare('obat_renogen',$this->obat_renogen); 	 
	//	$criteria->compare('injeksi_preb_besi',$this->injeksi_preb_besi); 	
		$criteria->compare('LOWER(heparin_dosisawal)',strtolower($this->heparin_dosisawal),true);
		//$criteria->compare('LOWER(heparin_continyu)',strtolower($this->heparin_continyu),true);
		$criteria->compare('LOWER(heparin_intermiten)',strtolower($this->heparin_intermiten),true);
		$criteria->compare('LOWER(aksesvaskular_nama)',strtolower($this->aksesvaskular_nama),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(tglkonsulpoli)',strtolower($this->tglkonsulpoli),true);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);  
	    
        $criteria->compare('kec_darah_qb',$this->kec_darah_qb);  
		if (!empty($this->penyulit_teknis)) {
			$criteria->addInCondition("penyulit_teknis", $this->penyulit_teknis);
		}  
		if (!empty($this->periksahd_penyulit)) {
			$criteria->addInCondition("periksahd_penyulit", $this->periksahd_penyulit);
		}  
        
        if (!empty($this->heparin_continyu_cek)) {
            $criteria->addCondition("heparin_continyu != 0");
        } 
        if (!empty($this->prep_besi_cek)) {
            $criteria->addCondition("injeksi_preb_besi != 0");
        } 
        
        if (!empty($this->ultrafiltrasi_mode_cek)) {
            $criteria->addCondition("ultrafiltrasi_mode != null");
        } 
        if (!empty($this->natrium_mode_cek)) {
            $criteria->addCondition("natrium_mode != null");
        } 
        
        if (!empty($this->lama_uso_uf_cek)) {
            $criteria->addCondition("lama_uso_uf != 0");
        } 
        if (!empty($this->iso_uf_ml_cek)) {
            $criteria->addCondition("iso_uf_ml != 0");
        } 
        
        if (!empty($this->bicarbonat_mode_cek)) {
            $criteria->addCondition("bicarbonat_mode != null");
        }  
        
        if (!empty($this->tanpaheparin_nama_cek)) {
            $criteria->addCondition("tanpaheparin_nama is not null");
        } 
        
        if (!empty($this->heparin_lmwh_cek)) {
            $criteria->addCondition("heparin_lmwh != 0");
        }  
        if (!empty($this->heparin_intermiten_cek)) {
            $criteria->addCondition("heparin_intermiten != 0");
        } 
        
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    } 
	
	 public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;	
		$criteria->addBetweenCondition('periksahd_tgl', $this->tgl_awal, $this->tgl_akhir);		 
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true); 
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true); 
	  if (!empty($this->dialiserke)) {    
          if($this->dialiserke =='1-5') {
			 
                 $criteria->addInCondition("dialiserke", array(1,2,3,4,5));

             }else if($this->dialiserke =='6-10') {
                    $criteria->addInCondition("dialiserke", array(6,7,8,9,10));
             }else if($this->dialiserke == 'nol') {
                    $criteria->addInCondition("dialiserke", array(0));
             }  
        }
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}  
//			$criteria->compare('LOWER(lamahd_jam)',strtolower($this->lamahd_jam),true);   
//		$criteria->compare('LOWER(lamahd_jam)',strtolower($this->lamahd_jam),true,'AND', 'LIKE'); 
		$criteria->addSearchCondition('lamahd_jam', $this->lamahd_jam, true, 'AND', 'ILIKE'); 
		$criteria->compare('obat_hemapo',$this->obat_hemapo); 
		$criteria->compare('obat_recormon',$this->obat_recormon);   
		$criteria->compare('obat_eprex',$this->obat_eprex);  
         $criteria->compare('obat_renogen',$this->obat_renogen); 
	//	$criteria->compare('injeksi_preb_besi',$this->injeksi_preb_besi); 	 
		$criteria->compare('LOWER(jenistransfusi_nama)',strtolower($this->jenistransfusi_nama),true);
//			$criteria->compare('LOWER(kec_darah_qb)',strtolower($this->kec_darah_qb),true);
		$criteria->compare('LOWER(heparin_dosisawal)',strtolower($this->heparin_dosisawal),true);
	//	$criteria->compare('LOWER(heparin_continyu)',strtolower($this->heparin_continyu),true);
		$criteria->compare('LOWER(heparin_intermiten)',strtolower($this->heparin_intermiten),true);
		$criteria->compare('LOWER(aksesvaskular_nama)',strtolower($this->aksesvaskular_nama),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(tglkonsulpoli)',strtolower($this->tglkonsulpoli),true);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true); 
		$criteria->compare('kec_darah_qb',$this->kec_darah_qb);  
  

        if (!empty($this->penyulit_teknis)) {
			$criteria->addInCondition("penyulit_teknis", $this->penyulit_teknis);
		}  
		if (!empty($this->periksahd_penyulit)) {
			$criteria->addInCondition("periksahd_penyulit", $this->periksahd_penyulit);
		}    
        if (!empty($this->heparin_continyu_cek)) {
            $criteria->addCondition("heparin_continyu != 0");
        } 
        if (!empty($this->prep_besi_cek)) {
            $criteria->addCondition("injeksi_preb_besi != 0");
        } 
        if (!empty($this->ultrafiltrasi_mode_cek)) {
            $criteria->addCondition("ultrafiltrasi_mode != null");
        } 
        if (!empty($this->natrium_mode_cek)) {
            $criteria->addCondition("natrium_mode != null");
        } 
        
        if (!empty($this->lama_uso_uf_cek)) {
            $criteria->addCondition("lama_uso_uf != 0");
        } 
        if (!empty($this->iso_uf_ml_cek)) {
            $criteria->addCondition("iso_uf_ml != 0");
        } 
        if (!empty($this->bicarbonat_mode_cek)) {
            $criteria->addCondition("bicarbonat_mode != null");
        } 
        if (!empty($this->tanpaheparin_nama_cek)) {
            $criteria->addCondition("tanpaheparin_nama is not null");
        } 
        if (!empty($this->heparin_lmwh_cek)) {
            $criteria->addCondition("heparin_lmwh != 0");
        }
        if (!empty($this->heparin_intermiten_cek)) {
            $criteria->addCondition("heparin_intermiten != 0");
        }
		// Klo limit lebih kecil dari nol itu berarti ga ada limit  
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	} 
	
	  public function getRuanganItems()
        {
                    return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>45,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
       
        
        } 
		
	 public function getJenishd($jenishd_id) {
		 
		 $hasil = ''; 
		 
		 if(isset($jenishd_id)) {
		 $modJenisHd= JenishdM::model()->findByAttributes(array('jenishd_id'=>$jenishd_id)); 
		     if(!empty($modJenisHd)) {
				 $hasil = $modJenisHd->jenishd_nama;
			 }		 
		 }else{
			 $hasil ='Tidak ADA';
		 } 
		 return $hasil;
	 } 
	 
	 public function getJenisDialisat($jenisdialisat_id) {
		 
		 $hasil = ''; 
		 
		 if(isset($jenisdialisat_id)) {
		 $modJenisHd= JenisdialisatM::model()->findByAttributes(array('jenisdialisat_id'=>$jenisdialisat_id)); 
		     if(count($modJenisHd) > 0) {
				 $hasil = $modJenisHd->jenisdialisat_nama;
			 }		 
		 }else{
			 $hasil ='Tidak ADA';
		 } 
		 return $hasil;
	 } 
     
     
	
}