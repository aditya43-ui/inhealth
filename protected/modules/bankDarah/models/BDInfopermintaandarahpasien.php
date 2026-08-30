<?php
/**
 * Load data Permintaan darah Pasien di modul bank darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDInfopermintaandarahpasien extends BDPermintaandarahT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsuransipasienM the static model class
	 */
        public $tgl_awal, $tgl_akhir, $tglren_transfusi, $sd_tglrentransfusi;
        public $alamat_pasien, $nama_pasien, $jeniskelamin, $no_rekam_medik, $ruangan_nama, $nama_pegawai, $no_pendaftaran, $tgl_pendaftaran, $create_time, $penjamin_id, $carabayar_id;
	public $golongandarah, $rhesus, $no_permintaandarah;
        public $umur;
        public $ujidarahpasien_id, $ujikompatibilitas_id, $penyiapandarah_id, $penyerahandarah_id;
        public $tglujikompabilitas, $tglpenyiapandarah, $tglpenyerahan;
        public $uji, $komp, $penyiapandarah;
        public $ruanganpemesan_id, $instalasi_asal;
        public $kelaspelayanan_nama;
        public $penjamin_nama,$tanggal_lahir;
        public $dpjp_nama, $ujidarahslide_id, $ujidarahtube_id;
        public $diagnosis;
        public $count_det;
        public $permintaandarahdet_id;
        public $gelardepan, $gelarbelakang_nama, $totaldet;
        public $rilis;
        public $ujikompatibilitas_ke, $penyiapandarah_ke, $penyerahandarah_ke;        
        public $kesimpulan_uji;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function rules() {
        return array_merge(parent::rules(), array(
            array('no_rekam_medik, nama_pasien, ruanganpemesan_id, carabayar_id, penjamin_id', 'safe'),
        ));
    }
    
    
        /**
         * Load data untuk informasi dengan kondisi permintaandarah_t.isbatal = false
         * @return \CActiveDataProvider
         */
	public function searchInformasi()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->addCondition('isbatal = false'); 
           
            $criteria->addBetweenCondition('DATE(t.tglpermintaan)', $this->tgl_awal, $this->tgl_akhir);
        
            $criteria->group = " t.pendaftaran_id, pen.tgl_pendaftaran, pen.no_pendaftaran, t.tglpermintaan, t.no_permintaandarah, "
                            .  " p.nama_pasien, rpesan.ruangan_nama, "
                            .  " p.no_rekam_medik, p.jeniskelamin, p.alamat_pasien, p.tanggal_lahir, p.golongandarah, p.rhesus, pen.umur,"
                            .  " t.permintaandarah_id, dpjp.gelardepan, gelardpjp.gelarbelakang_nama, dpjp.nama_pegawai, "
                            .  " ujidarahslide.ujidarahpasien_id, ujidarahtube.ujidarahpasien_id,"
                            .  " peny.penyerahandarah_id";
            $criteria->select =  $criteria->group.", t.no_permintaandarah, CONCAT(dpjp.gelardepan,' ',dpjp.nama_pegawai,', ',gelardpjp.gelarbelakang_nama) as dpjp_nama, "
                                . " ujidarahslide.ujidarahpasien_id as ujidarahslide_id, ujidarahtube.ujidarahpasien_id as ujidarahtube_id, peny.penyerahandarah_id";
            $criteria->join = ' JOIN pendaftaran_t pen ON t.pendaftaran_id = pen.pendaftaran_id '
                            . ' JOIN pasien_m p ON t.pasien_id = p.pasien_id '
                            . ' JOIN pegawai_m dpjp ON dpjp.pegawai_id = t.dpjp_id '
                            . ' LEFT JOIN penjaminpasien_m penjamin ON pen.penjamin_id = penjamin.penjamin_id '
                            . ' LEFT JOIN carabayar_m cara ON pen.carabayar_id = cara.carabayar_id '
                            . ' LEFT JOIN gelarbelakang_m gelardpjp ON gelardpjp.gelarbelakang_id = dpjp.gelarbelakang_id '
                            . ' JOIN ruangan_m rpesan ON rpesan.ruangan_id = t.ruanganpemesan_id '
                            . " LEFT JOIN ujidarahpasien_t ujidarahslide ON ( (ujidarahslide.permintaandarah_id = t.permintaandarah_id) AND ujidarahslide.metodedarah_id = '".Params::METODE_DARAH_ID_SLIDE_TEST."' ) "
                            . " LEFT JOIN ujidarahpasien_t ujidarahtube ON ( (ujidarahtube.permintaandarah_id = t.permintaandarah_id) AND ujidarahtube.metodedarah_id = '".Params::METODE_DARAH_ID_TUBE_TEST."' ) "
                            . " LEFT JOIN penyerahandarah_t peny ON peny.permintaandarah_id = t.permintaandarah_id ";
            $criteria->limit=10;           
            $criteria->order = 't.tglpermintaan ASC';
            $criteria->compare("LOWER(p.nama_pasien)", strtolower($this->nama_pasien),true);
            $criteria->compare("LOWER(p.rhesus)", strtolower($this->rhesus),true);
            $criteria->compare("LOWER(p.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
            $criteria->compare("LOWER(t.no_permintaandarah)", strtolower($this->no_permintaandarah),true);
            $criteria->compare("penjamin.penjamin_id", $this->penjamin_id);
            $criteria->compare("cara.carabayar_id", $this->carabayar_id);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
         /**
         * Load data untuk informasi dengan kondisi permintaandarah_t.isbatal = false
         * @return \CActiveDataProvider
         */
	public function searchInfoPermintaanDarahPasien()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->addCondition('t.isbatal = false'); 
           
            $criteria->addBetweenCondition('DATE(t.tglpermintaan)', $this->tgl_awal, $this->tgl_akhir);
        
            $criteria->group = " t.pendaftaran_id, pen.tgl_pendaftaran, pen.no_pendaftaran, t.tglpermintaan, t.no_permintaandarah,t.is_pasiensama, "
                            .  " p.nama_pasien, rpesan.ruangan_nama, "
                            .  " p.no_rekam_medik, p.jeniskelamin, p.alamat_pasien, p.tanggal_lahir, p.golongandarah, p.rhesus, pen.umur,"
                            .  " t.permintaandarah_id, dpjp.gelardepan, gelardpjp.gelarbelakang_nama, dpjp.nama_pegawai, "
                            .  " ujidarahslide.ujidarahpasien_id, ujidarahtube.ujidarahpasien_id"
                            .  " ";
            $criteria->select =  $criteria->group.", t.no_permintaandarah, CONCAT(dpjp.gelardepan,' ',dpjp.nama_pegawai,', ',gelardpjp.gelarbelakang_nama) as dpjp_nama, "
                                . " ujidarahslide.ujidarahpasien_id as ujidarahslide_id, ujidarahtube.ujidarahpasien_id as ujidarahtube_id";
            $criteria->join = ' JOIN pendaftaran_t pen ON t.pendaftaran_id = pen.pendaftaran_id '
                            . ' JOIN pasien_m p ON t.pasien_id = p.pasien_id '
                            . ' LEFT JOIN pegawai_m dpjp ON dpjp.pegawai_id = t.dpjp_id '
                            . ' LEFT JOIN penjaminpasien_m penjamin ON pen.penjamin_id = penjamin.penjamin_id '
                            . ' LEFT JOIN carabayar_m cara ON pen.carabayar_id = cara.carabayar_id '
                            . ' LEFT JOIN gelarbelakang_m gelardpjp ON gelardpjp.gelarbelakang_id = dpjp.gelarbelakang_id '
                            . ' JOIN ruangan_m rpesan ON rpesan.ruangan_id = t.ruanganpemesan_id '
                            . " LEFT JOIN ujidarahpasien_t ujidarahslide ON ( (ujidarahslide.permintaandarah_id = t.permintaandarah_id) AND ujidarahslide.metodedarah_id = '".Params::METODE_DARAH_ID_SLIDE_TEST."' ) "
                            . " LEFT JOIN ujidarahpasien_t ujidarahtube ON ( (ujidarahtube.permintaandarah_id = t.permintaandarah_id) AND ujidarahtube.metodedarah_id = '".Params::METODE_DARAH_ID_TUBE_TEST."' ) ";
            $criteria->limit=10;           
            $criteria->order = 't.tglpermintaan ASC';
            $criteria->compare("LOWER(p.nama_pasien)", strtolower($this->nama_pasien),true);
            $criteria->compare("LOWER(p.rhesus)", strtolower($this->rhesus),true);
            $criteria->compare("LOWER(p.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
            $criteria->compare("LOWER(t.no_permintaandarah)", strtolower($this->no_permintaandarah),true);
            $criteria->compare("penjamin.penjamin_id", $this->penjamin_id);
            $criteria->compare("cara.carabayar_id", $this->carabayar_id);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Load data untuk informasi dengan kondisi permintaandarah_t.isbatal = false
         * @return \CActiveDataProvider
         */
	public function searchInformasiPermintaanDarahPasien()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->group = " t.pendaftaran_id, pen.tgl_pendaftaran, pen.no_pendaftaran, t.tglpermintaan, t.no_permintaandarah,t.is_pasiensama, "
                            .  " p.nama_pasien, rpesan.ruangan_nama, "
                            .  " p.no_rekam_medik, p.jeniskelamin, p.alamat_pasien, p.tanggal_lahir, p.golongandarah, p.rhesus, pen.umur,"
                            .  " t.permintaandarah_id, dpjp.gelardepan, gelardpjp.gelarbelakang_nama, dpjp.nama_pegawai, "
                            .  " ujidarahslide.ujidarahpasien_id, ujidarahtube.ujidarahpasien_id,"
                            .  " ujikomp.ujikompatibilitas_id, ujikomp.tglujikompabilitas, ujikomp.ujikompatibilitas_ke, "
                            .  " siap.penyiapandarah_id, siap.tglpenyiapandarah, siap.penyiapandarah_ke, "
                            .  " serah.penyerahandarah_id, serah.tglpenyerahan, serah.penyerahandarah_ke, ujikomp.permintaandarahdet_id, ujikomp.rilis, ujidarahslide.kesimpulan_uji ";
            $criteria->select =  $criteria->group.", t.no_permintaandarah, CONCAT(dpjp.gelardepan,' ',dpjp.nama_pegawai,', ',gelardpjp.gelarbelakang_nama) as dpjp_nama, "
                                . " ujidarahslide.ujidarahpasien_id as ujidarahslide_id, ujidarahtube.ujidarahpasien_id as ujidarahtube_id,"
                                . " (SELECT count(sub_det.permintaandarahdet_id) FROM permintaandarahdet_t as sub_det WHERE sub_det.permintaandarah_id = t.permintaandarah_id ) as count_det";
            $criteria->join = ' JOIN pendaftaran_t pen ON t.pendaftaran_id = pen.pendaftaran_id '
                            . ' JOIN pasien_m p ON t.pasien_id = p.pasien_id '
                            . ' LEFT JOIN pegawai_m dpjp ON dpjp.pegawai_id = t.dpjp_id '
                            . ' LEFT JOIN penjaminpasien_m penjamin ON pen.penjamin_id = penjamin.penjamin_id '
                            . ' LEFT JOIN carabayar_m cara ON pen.carabayar_id = cara.carabayar_id '
                            . ' LEFT JOIN gelarbelakang_m gelardpjp ON gelardpjp.gelarbelakang_id = dpjp.gelarbelakang_id '
                            . ' JOIN ruangan_m rpesan ON rpesan.ruangan_id = t.ruanganpemesan_id '
                            . " LEFT JOIN ujidarahpasien_t ujidarahslide ON ( (ujidarahslide.permintaandarah_id = t.permintaandarah_id) AND ujidarahslide.metodedarah_id = '".Params::METODE_DARAH_ID_SLIDE_TEST."' ) "
                            . " LEFT JOIN ujidarahpasien_t ujidarahtube ON ( (ujidarahtube.permintaandarah_id = t.permintaandarah_id) AND ujidarahtube.metodedarah_id = '".Params::METODE_DARAH_ID_TUBE_TEST."' ) "
                            . " LEFT JOIN ujikompatibilitas_t ujikomp ON ujikomp.ujidarahpasien_id = ujidarahtube.ujidarahpasien_id "
                            . " LEFT JOIN permintaandarahdet_t mintadet ON mintadet.permintaandarahdet_id = ujikomp.permintaandarahdet_id "
                            . " LEFT JOIN penyiapandarah_t siap ON siap.ujikompatibilitas_id = ujikomp.ujikompatibilitas_id "
                            . " LEFT JOIN penyerahandarah_t serah ON siap.penyiapandarah_id = serah.penyiapandarah_id ";                                            
            $criteria->addCondition('t.isbatal = false');            
            $criteria->addBetweenCondition('DATE(t.tglpermintaan)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = 't.tglpermintaan ASC';
            $criteria->compare("LOWER(p.nama_pasien)", strtolower($this->nama_pasien),true);
            $criteria->compare("LOWER(p.rhesus)", strtolower($this->rhesus),true);
            $criteria->compare("LOWER(p.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
            $criteria->compare("LOWER(t.no_permintaandarah)", strtolower($this->no_permintaandarah),true);
            $criteria->compare("penjamin.penjamin_id", $this->penjamin_id);
            $criteria->compare("cara.carabayar_id", $this->carabayar_id);
            $criteria->order = " tglpermintaan ASC ";            
            
            $mod = BDInfopermintaandarahpasien::model()->findAll($criteria);
            
            $res = array();
            
            foreach ($mod as $det){
                $res[$det->permintaandarah_id]['permintaandarah_id'] = $det->permintaandarah_id;
                $res[$det->permintaandarah_id]['pendaftaran_id'] = $det->pendaftaran_id;
                $res[$det->permintaandarah_id]['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($det->tgl_pendaftaran);
                $res[$det->permintaandarah_id]['no_pendaftaran'] = $det->no_pendaftaran;
                $res[$det->permintaandarah_id]['tglpermintaan'] = MyFormatter::formatDateTimeForUser($det->tglpermintaan);
                $res[$det->permintaandarah_id]['no_permintaandarah'] = $det->no_permintaandarah;
                $res[$det->permintaandarah_id]['is_pasiensama'] = $det->is_pasiensama;
                $res[$det->permintaandarah_id]['nama_pasien'] = $det->nama_pasien;
                $res[$det->permintaandarah_id]['ruangan_nama'] = $det->ruangan_nama;
                $res[$det->permintaandarah_id]['no_rekam_medik'] = $det->no_rekam_medik;
                $res[$det->permintaandarah_id]['jeniskelamin'] = $det->jeniskelamin;
                $res[$det->permintaandarah_id]['alamat_pasien'] = $det->alamat_pasien;
                $res[$det->permintaandarah_id]['tanggal_lahir'] = $det->tanggal_lahir;
                $res[$det->permintaandarah_id]['golongandarah'] = $det->golongandarah;
                $res[$det->permintaandarah_id]['rhesus'] = $det->rhesus;
                $res[$det->permintaandarah_id]['umur'] = $det->umur;
                $res[$det->permintaandarah_id]['nama_lengkap'] = $det->gelardepan.' '.$det->nama_pegawai.', '.$det->gelarbelakang_nama;
                $res[$det->permintaandarah_id]['ujidarahslide_id'] = $det->ujidarahslide_id;
                $res[$det->permintaandarah_id]['ujidarahtube_id'] = $det->ujidarahtube_id;
                $res[$det->permintaandarah_id]['count_det'] = $det->count_det;
                $res[$det->permintaandarah_id]['dpjp_nama'] = $det->dpjp_nama;                
                $res[$det->permintaandarah_id]['is_pasiensama'] = $det->is_pasiensama;   
                $res[$det->permintaandarah_id]['kesimpulan_uji'] = $det->kesimpulan_uji;
                
                if (!empty($det->ujidarahslide_id) || !empty($det->ujidarahtube_id)){
                    //$res[$det->permintaandarah_id]['darahtube'][$det->ujidarahtube_id]['ujidarahtube_id'] = $det->ujidarahtube_id;
                    //langsung mengambil tanggal uji kompatibilitas, karena satu ujidarahtube = 1 transaksi kompatibilitas (dengan banyak stokkantongdarah_id)
                    //$res[$det->permintaandarah_id]['darahtube'][$det->ujidarahtube_id]['tglujikompatibilitas'] = !empty($det->tglujikompabilitas)?MyFormatter::formatDateTimeForUser($det->tglujikompabilitas):null;                    
                    if (!empty($det->ujikompatibilitas_id)){
                        $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahslide_id.$det->ujikompatibilitas_ke]['ujidarahtube_id'] = $det->ujidarahtube_id;                    
                        $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahslide_id.$det->ujikompatibilitas_ke]['ujidarahslide_id'] = $det->ujidarahslide_id;                    
                        $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahslide_id.$det->ujikompatibilitas_ke]['tglujikompatibilitas'] = !empty($det->tglujikompabilitas)?MyFormatter::formatDateTimeForUser($det->tglujikompabilitas):null;
                        $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahslide_id.$det->ujikompatibilitas_ke]['ujikompatibilitas_ke']= $det->ujikompatibilitas_ke; 
                        $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahslide_id.$det->ujikompatibilitas_ke]['kompatibilitas'][$det->ujikompatibilitas_id]['ujikompatibilitas_id'] = $det->ujikompatibilitas_id;
                        $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahslide_id.$det->ujikompatibilitas_ke]['kompatibilitas'][$det->ujikompatibilitas_id]['tglujikompabilitas'] = !empty($det->tglujikompabilitas)?MyFormatter::formatDateTimeForUser($det->tglujikompabilitas):null;
                        $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahslide_id.$det->ujikompatibilitas_ke]['kompatibilitas'][$det->ujikompatibilitas_id]['permintaandarahdet_id'] = $det->permintaandarahdet_id;                                                                       
                        $res[$det->permintaandarah_id]['ujikompatibilitas'][$det->ujikompatibilitas_id] = $det->ujikompatibilitas_id;
                        if (!empty(Params::cekRilis($det->rilis))){
                            if (!empty($det->permintaandarahdet_id)){
                                $res[$det->permintaandarah_id]['permintaandet'][$det->permintaandarahdet_id] = $det->permintaandarahdet_id;
                            }
                            $res[$det->permintaandarah_id]['ujikompatibilitasrelease'][$det->ujikompatibilitas_id] = $det->ujikompatibilitas_id;
                            if (!empty($det->penyiapandarah_id)){                                
                                $res[$det->permintaandarah_id]['penyiapandarah'][$det->penyiapandarah_ke]['tglpenyiapandarah'] = !empty($det->tglpenyiapandarah)?MyFormatter::formatDateTimeForUser($det->tglpenyiapandarah):null;                                
                                $res[$det->permintaandarah_id]['penyiapandarah'][$det->penyiapandarah_ke]['ujidarahtube_id'] = $det->ujidarahtube_id;
                                $res[$det->permintaandarah_id]['penyiapandarah'][$det->penyiapandarah_ke]['ujidarahslide_id'] = $det->ujidarahslide_id;
                                $res[$det->permintaandarah_id]['penyiapandarah'][$det->penyiapandarah_ke]['tglujikompabilitas'] = $det->tglujikompabilitas;                                
                                $res[$det->permintaandarah_id]['penyiapandarah'][$det->penyiapandarah_ke]['penyiapandarah_ke'] = $det->penyiapandarah_ke;                                
                                $res[$det->permintaandarah_id]['penyiapandarahid'][$det->penyiapandarah_id] = $det->penyiapandarah_id;                                
                                if (!empty($det->penyerahandarah_id)){                                    
                                    $res[$det->permintaandarah_id]['penyerahandarah'][$det->penyerahandarah_ke]['tglpenyerahandarah'] = !empty($det->tglpenyerahan)?MyFormatter::formatDateTimeForUser($det->tglpenyerahan):null;      
                                    $res[$det->permintaandarah_id]['penyerahandarah'][$det->penyerahandarah_ke]['ujidarahtube_id'] = $det->ujidarahtube_id;                                                                
                                    $res[$det->permintaandarah_id]['penyerahandarah'][$det->penyerahandarah_ke]['ujidarahslide_id'] = $det->ujidarahslide_id;                                                                
                                    $res[$det->permintaandarah_id]['penyerahandarah'][$det->penyerahandarah_ke]['tglujikompabilitas'] = $det->tglujikompabilitas;                                
                                    $res[$det->permintaandarah_id]['penyerahandarah'][$det->penyerahandarah_ke]['penyerahandarah_ke'] = $det->penyerahandarah_ke;                                
                                    $res[$det->permintaandarah_id]['penyerahandarahid'][$det->penyerahandarah_id] = $det->penyerahandarah_id;                                
                                }
                            }
                        }else{
                            $res[$det->permintaandarah_id]['ujikompatibilitasstop'][$det->ujikompatibilitas_id] = $det->ujikompatibilitas_id;
                        }
                        
                        
                                                                                                
                    }
                }                                                
            }           
                                                
            return new CArrayDataProvider($res, array(
                'keyField' => 'permintaandarah_id',
                'id' => 'permintaandarah-r-grid',
                'totalItemCount' => count((array)$res),
                'pagination' => array(
                    'pageSize' => 10,
                    'pageVar' => 'page'
                ),
            ));
        }
        
        /**
         * Pencarian data status 
         * @param type $permintaandarah_id
         */
        public function searchStatus($permintaandarah_id){
            $critera = $this->criteriaSearch();
            $critera->addCondition('WHERE t.permintaandarah_id ='.$permintaandarah_id);
            $critera->select = 't.* t.permintaandarah_id, uji.ujidarahpasien_id as ujidarah, ujikomp.ujikompatibilitas_id as komp, penyiapan.penyiapandarah_id as penyiapandarah';
            $critera->join = 'LEFT JOIN ujidarahpasien_t uji ON t.pendaftaran_id = uji.pendaftaran_id '
                            . 'LEFT JOIN ujikompatibilitas_t ujikomp ON t.pendaftaran_id = ujikomp.pendaftaran_id '
                            . 'LEFT JOIN penyiapandarah_t penyiapan ON t.pendaftaran_id = penyiapan.pendaftaran_id ';
            $critera->group = $critera->select; 
            
        }
        
        /**
         * Pencarian data dialog 
         * @return \CActiveDataProvider
         */
	public function searchDialog()
	{
		$criteria=$this->criteriaSearch();
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
		}
		$criteria->limit=5;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
        /**
         * Pencarian data dialog permintaan darah untuk transaksi penyerahaan darah 
         * @return type
         */
        public function searchDialogUntukPenyerahanDarah() {
            $prov = $this->searchInformasi();

            $prov->criteria->join .= 
                'join (select u.permintaandarah_id from penyiapandarah_t u group by u.permintaandarah_id) '
                . 'penyiapan2 on penyiapan2.permintaandarah_id = t.permintaandarah_id '
                .'left join (select u.permintaandarah_id from penyerahandarah_t u group by u.permintaandarah_id) '
                . 'penyerahan on penyerahan.permintaandarah_id = t.permintaandarah_id';
            
            $prov->criteria->addCondition('penyerahan.permintaandarah_id is null');
            $prov->criteria->addCondition('t.isbatal = false');

            $prov->sort->defaultOrder = 't.tglpermintaan';

            return $prov;
        }  
        
        /**
         * Pencarian data dialog untuk transaksi penyiapan darah
         * @return type
         */
        public function searchDialogUntukPenyiapanDarah() {
            $prov = $this->searchInformasi();

            $prov->criteria->join .= 'join (select u.permintaandarah_id from ujidarahpasien_t u '
                . 'left join ujikompatibilitas_t k on k.ujidarahpasien_id = k.ujidarahpasien_id '
                . 'where '
                . 'k.ujikompatibilitas_id is not null and '
                . 'metodedarah_id = '.Params::METODE_DARAH_ID_TUBE_TEST.' '
                . 'group by u.permintaandarah_id) '
                . 'uji on uji.permintaandarah_id = t.permintaandarah_id '
                . 'left join (select u.permintaandarah_id from penyiapandarah_t u group by u.permintaandarah_id) '
                . 'penyiapan2 on penyiapan2.permintaandarah_id = t.permintaandarah_id ';

            $prov->criteria->addCondition('penyiapan2.permintaandarah_id is null');
            $prov->criteria->addCondition('t.isbatal = false');
            
            $prov->sort->defaultOrder = 't.tglpermintaan';

            return $prov;
        }  
        
        /**
         * Pencarian data informasi
         * @return \CActiveDataProvider
         */
        public function searchInformasiDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->addCondition('t.isbatal = false AND ujidarahpasien.ujidarahpasien_id is null'); 
            $criteria->select = "daftar.no_pendaftaran,daftar.tgl_pendaftaran,penjamin.penjamin_nama,pelayanan.kelaspelayanan_nama,t.*, t.permintaandarah_id, t.pendaftaran_id,p.tanggal_lahir, "
                                . "p.nama_pasien, p.rhesus, daftar.carabayar_id, daftar.penjamin_id, daftar.umur, p.golongandarah, p.jeniskelamin, "
                                . "p.alamat_pasien, p.no_rekam_medik, r.ruangan_nama, "
                                . "(CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',gelarbelakang.gelarbelakang_nama))as nama_pegawai, "
                                . "MAX(ujidarahpasien.ujidarahpasien_id), MAX(ujikomp.ujikompatibilitas_id), MAX(penyiapan.penyiapandarah_id)";
            $criteria->join = "JOIN permintaandarah_t minta ON minta.permintaandarah_id = t.permintaandarah_id "
                            . "LEFT JOIN pasien_m as p ON t.pasien_id=p.pasien_id "
                            . "LEFT JOIN ruangan_m as r ON t.ruanganpemesan_id=r.ruangan_id "                            
                            . "JOIN pendaftaran_t daftar ON t.pendaftaran_id=daftar.pendaftaran_id "
                            . "JOIN pegawai_m as peg ON daftar.pegawai_id=peg.pegawai_id "
                            . "LEFT JOIN gelarbelakang_m as gelarbelakang ON gelarbelakang.gelarbelakang_id = peg.gelarbelakang_id "
                            . "LEFT JOIN ujidarahpasien_t ujidarahpasien ON t.pendaftaran_id = ujidarahpasien.pendaftaran_id "
                            . "LEFT JOIN ujikompatibilitas_t ujikomp ON t.pendaftaran_id = ujikomp.pendaftaran_id "
                            . "LEFT JOIN penyiapandarah_t penyiapan ON t.pendaftaran_id = penyiapan.pendaftaran_id "
                            . "LEFT JOIN penjaminpasien_m penjamin ON daftar.penjamin_id = penjamin.penjamin_id "
                            . "LEFT JOIN kelaspelayanan_m pelayanan ON daftar.kelaspelayanan_id = pelayanan.kelaspelayanan_id ";  
            $criteria->limit=10;
            $criteria->compare("LOWER(daftar.no_pendaftaran)",strtolower($this->no_pendaftaran),true);
            $criteria->compare("LOWER(p.nama_pasien)",strtolower($this->nama_pasien),true);
            $criteria->compare("LOWER(p.no_rekam_medik)",strtolower($this->no_rekam_medik),true);
            $criteria->compare("LOWER(t.no_permintaandarah)",strtolower($this->no_permintaandarah),true);
            $criteria->compare("LOWER(p.jeniskelamin)",strtolower($this->jeniskelamin));
            if (!empty($this->carabayar_id)){
                $criteria->addCondition(" carabayar_id = '".$this->carabayar_id."' ");
            }
            $criteria->group= 'daftar.no_pendaftaran,daftar.tgl_pendaftaran,penjamin.penjamin_nama,pelayanan.kelaspelayanan_nama,t.*, t.permintaandarah_id, p.nama_pasien, p.rhesus,p.tanggal_lahir, daftar.umur, p.golongandarah, p.jeniskelamin, p.alamat_pasien,daftar.carabayar_id, daftar.penjamin_id, p.no_rekam_medik, r.ruangan_nama, peg.nama_pegawai, daftar.no_pendaftaran, daftar.tgl_pendaftaran, daftar.ruangan_id, daftar.instalasi_id, gelarbelakang.gelarbelakang_nama, peg.gelardepan';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
    /**
    * memfilter dialog, yang digunakan pada transaksi uji kompatibilitas
    * @return \CActiveDataProvider
    */
   public function searchDialogForUjiKompatibilitas()
   {
        $criteria = new CDbCriteria();
        $criteria->group = " t.pendaftaran_id, pen.tgl_pendaftaran, pen.no_pendaftaran, t.tglpermintaan, t.no_permintaandarah,t.is_pasiensama, "
                        .  " p.nama_pasien, rpesan.ruangan_nama, "
                        .  " p.no_rekam_medik, p.jeniskelamin, p.alamat_pasien, p.tanggal_lahir, p.golongandarah, p.rhesus, pen.umur,"
                        .  " t.permintaandarah_id, dpjp.gelardepan, gelardpjp.gelarbelakang_nama, dpjp.nama_pegawai, "
                        .  " ujidarahslide.ujidarahpasien_id, ujidarahtube.ujidarahpasien_id,"
                        .  " ujikomp.ujikompatibilitas_id, ujikomp.tglujikompabilitas, "
                        .  " siap.penyiapandarah_id, siap.tglpenyiapandarah, "
                        .  " serah.penyerahandarah_id, serah.tglpenyerahan, ujikomp.permintaandarahdet_id, ujikomp.rilis ";
        $criteria->select =  $criteria->group.", t.no_permintaandarah, CONCAT(dpjp.gelardepan,' ',dpjp.nama_pegawai,', ',gelardpjp.gelarbelakang_nama) as dpjp_nama, "
                            . " ujidarahslide.ujidarahpasien_id as ujidarahslide_id, ujidarahtube.ujidarahpasien_id as ujidarahtube_id,"
                            . " (SELECT count(sub_det.permintaandarahdet_id) FROM permintaandarahdet_t as sub_det WHERE sub_det.permintaandarah_id = t.permintaandarah_id ) as count_det";
        $criteria->join = ' JOIN pendaftaran_t pen ON t.pendaftaran_id = pen.pendaftaran_id '
                        . ' JOIN pasien_m p ON t.pasien_id = p.pasien_id '
                        . ' LEFT JOIN pegawai_m dpjp ON dpjp.pegawai_id = t.dpjp_id '
                        . ' LEFT JOIN penjaminpasien_m penjamin ON pen.penjamin_id = penjamin.penjamin_id '
                        . ' LEFT JOIN carabayar_m cara ON pen.carabayar_id = cara.carabayar_id '
                        . ' LEFT JOIN gelarbelakang_m gelardpjp ON gelardpjp.gelarbelakang_id = dpjp.gelarbelakang_id '
                        . ' JOIN ruangan_m rpesan ON rpesan.ruangan_id = t.ruanganpemesan_id '
                        . " LEFT JOIN ujidarahpasien_t ujidarahslide ON ( (ujidarahslide.permintaandarah_id = t.permintaandarah_id) AND ujidarahslide.metodedarah_id = '".Params::METODE_DARAH_ID_SLIDE_TEST."' ) "
                        . " LEFT JOIN ujidarahpasien_t ujidarahtube ON ( (ujidarahtube.permintaandarah_id = t.permintaandarah_id) AND ujidarahtube.metodedarah_id = '".Params::METODE_DARAH_ID_TUBE_TEST."' ) "
                        . " LEFT JOIN ujikompatibilitas_t ujikomp ON ujikomp.ujidarahpasien_id = ujidarahtube.ujidarahpasien_id "
                        . " LEFT JOIN permintaandarahdet_t mintadet ON mintadet.permintaandarahdet_id = ujikomp.permintaandarahdet_id "
                        . " LEFT JOIN penyiapandarah_t siap ON siap.ujikompatibilitas_id = ujikomp.ujikompatibilitas_id "
                        . " LEFT JOIN penyerahandarah_t serah ON siap.penyiapandarah_id = serah.penyiapandarah_id ";                                            
        $criteria->addCondition('t.isbatal = false');                    
        $criteria->compare("LOWER(p.nama_pasien)", strtolower($this->nama_pasien),true);
        $criteria->compare("LOWER(p.rhesus)", strtolower($this->rhesus),true);
        $criteria->compare("LOWER(p.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
        $criteria->compare("LOWER(t.no_permintaandarah)", strtolower($this->no_permintaandarah),true);
        $criteria->compare("penjamin.penjamin_id", $this->penjamin_id);
        $criteria->compare("cara.carabayar_id", $this->carabayar_id);
        $criteria->order = " tglpermintaan DESC ";            

        $mod = BDInfopermintaandarahpasien::model()->findAll($criteria);

        $res = array();

        foreach ($mod as $det){
            if (!empty($det->ujidarahslide_id)){
                $res[$det->permintaandarah_id]['permintaandarah_id'] = $det->permintaandarah_id;
                $res[$det->permintaandarah_id]['pendaftaran_id'] = $det->pendaftaran_id;
                $res[$det->permintaandarah_id]['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($det->tgl_pendaftaran);
                $res[$det->permintaandarah_id]['no_pendaftaran'] = $det->no_pendaftaran;
                $res[$det->permintaandarah_id]['tglpermintaan'] = MyFormatter::formatDateTimeForUser($det->tglpermintaan);
                $res[$det->permintaandarah_id]['no_permintaandarah'] = $det->no_permintaandarah;
                $res[$det->permintaandarah_id]['is_pasiensama'] = $det->is_pasiensama;
                $res[$det->permintaandarah_id]['nama_pasien'] = $det->nama_pasien;
                $res[$det->permintaandarah_id]['jenispermintaan'] = $det->jenispermintaan;
                $res[$det->permintaandarah_id]['ruangan_nama'] = $det->ruangan_nama;
                $res[$det->permintaandarah_id]['no_rekam_medik'] = $det->no_rekam_medik;
                $res[$det->permintaandarah_id]['jeniskelamin'] = $det->jeniskelamin;
                $res[$det->permintaandarah_id]['alamat_pasien'] = $det->alamat_pasien;
                $res[$det->permintaandarah_id]['tanggal_lahir'] = $det->tanggal_lahir;
                $res[$det->permintaandarah_id]['golongandarah'] = $det->golongandarah;
                $res[$det->permintaandarah_id]['rhesus'] = $det->rhesus;
                $res[$det->permintaandarah_id]['umur'] = $det->umur;
                $res[$det->permintaandarah_id]['nama_lengkap'] = $det->gelardepan.' '.$det->nama_pegawai.', '.$det->gelarbelakang_nama;
                $res[$det->permintaandarah_id]['ujidarahslide_id'] = $det->ujidarahslide_id;
                $res[$det->permintaandarah_id]['ujidarahtube_id'] = $det->ujidarahtube_id;
                $res[$det->permintaandarah_id]['count_det'] = $det->count_det;
                $res[$det->permintaandarah_id]['dpjp_nama'] = $det->dpjp_nama;                
                $res[$det->permintaandarah_id]['is_pasiensama'] = $det->is_pasiensama;                
                $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahtube_id]['ujidarahtube_id'] = $det->ujidarahtube_id;                
                $res[$det->permintaandarah_id]['darahtube'][$det->ujidarahtube_id]['tglujikompatibilitas'] = !empty($det->tglujikompabilitas)?MyFormatter::formatDateTimeForUser($det->tglujikompabilitas):null;                
                if (empty($res[$det->permintaandarah_id]['permintaandet'])) {
                    $res[$det->permintaandarah_id]['permintaandet'] = array();
                }
                if (!empty($det->ujikompatibilitas_id)){                                        
                    if (!empty(Params::cekRilis($det->rilis))){                                                
                        $res[$det->permintaandarah_id]['permintaandet'][$det->permintaandarahdet_id] = $det->permintaandarahdet_id;                        
                    }else{  
                        
                    }
                }
            }
        }
        
        foreach ($res as $det){            
            if (isset($det['permintaandet'])){                     
                if ($det['count_det'] == count((array)$det['permintaandet'])){                                    
                    unset($res[$det['permintaandarah_id']]);
                }
            }
        }

        return new CArrayDataProvider($res, array(
            'keyField' => 'permintaandarah_id',
            'id' => 'permintaandarah-r-grid',
            'totalItemCount' => count((array)$res),
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page'
            ),
        ));
    }     
}