<?php
Yii::import('laboratoriumPA.controllers.PendaftaranLaboratoriumController');
Yii::import('radiologi.models.*');
class PemeriksaanPasienLaboratoriumController extends PendaftaranLaboratoriumController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = "laboratoriumPA.views.pemeriksaanPasienLaboratorium.";
    public $path_view_pendaftaran = "laboratoriumPA.views.pendaftaranLaboratorium.";

    /**
     * Tambah / Ubah Pemeriksaan Laboratorium.
     */
    public function actionIndex($pasienmasukpenunjang_id=null)
    {
        $format = new MyFormatter();
        $modKunjungan=new LBPasienMasukPenunjangV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
		$modPasienMasukPenunjang = new LBPasienmasukpenunjangT;
        $modPemeriksaanLab = new LBTarifpemeriksaanlabruanganV;
        $modHasilPemeriksaan = new LBHasilPemeriksaanLabT;
        $modHasilPemeriksaanPA = new LBHasilPemeriksaanPAT;
        $modTindakan=new LBTindakanPelayananT;
        $dataTindakans = array(); 
		
		$modRujukKeluar = new PemeriksaankeluarT();
		
        $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : $pasienmasukpenunjang_id);
        if(!empty($pasienmasukpenunjang_id)){
            $loadModKunjungan = $this->loadModPasienMasukPenunjang($pasienmasukpenunjang_id);
            if(isset($loadModKunjungan)){
                $modKunjungan = $loadModKunjungan;
				$modKunjungan->dokterperujuk = $modKunjungan->getDokterPerujuk();
                $modPasienMasukPenunjang->attributes = $loadModKunjungan->attributes;
				$modPasienMasukPenunjang->pegawai_nama = $modPasienMasukPenunjang->pegawai->namaLengkap;
                $modPasienMasukPenunjang->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
                $modPasienMasukPenunjang->perawat_id = $modPasienMasukPenunjang->getPerawatId();
				if (!empty($modPasienMasukPenunjang->perawat_id)){
					$modPasienMasukPenunjang->perawat_nama = PegawaiM::model()->findByPk($modPasienMasukPenunjang->perawat_id)->namaLengkap;
				}
				
				
				
                if($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
                    $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$loadModKunjungan->pasienmasukpenunjang_id));
                    if(strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)){
                        Yii::app()->user->setFlash('warning', "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !");
                    }else{
                        $modHasilPemeriksaan = $loadHasilPemeriksaan;
                    }
                }else if($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
                    //TIDAK ADA UPDATE LBHasilPemeriksaanPAT
                }
            }
        }
        
        if(isset($_POST['pasienmasukpenunjang_id']))
        {
            
            // var_dump($_POST); die;
            
            $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
            $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
            $transaction = Yii::app()->db->beginTransaction();
            try {
				if(isset($_POST['LBPasienmasukpenunjangT'])){
					$modPasienMasukPenunjang->pegawai_id = $_POST['LBPasienmasukpenunjangT']['pegawai_id'];
					$modPasienMasukPenunjang->perawat_id = $_POST['LBPasienmasukpenunjangT']['perawat_id'];
					$modPasienMasukPenunjang->save();
				}
				
                if(isset($_POST['LBTindakanPelayananT'][0])){
                    if(count($_POST['LBTindakanPelayananT'][0]) > 0){
                        foreach($_POST['LBTindakanPelayananT'][0] AS $ii => $tindakan){
                            if(!empty($tindakan['tindakanpelayanan_id'])){
                                $dataTindakans[$ii] = LBTindakanPelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                                $dataTindakans[$ii]->jeniskasuspenyakit_id = $modPasienMasukPenunjang->jeniskasuspenyakit_id;
								$dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                                $dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
								$dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                                $dataTindakans[$ii]->update();
                            }else{
                                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran,$modPasienMasukPenunjang,$tindakan);
                                if($_POST['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK){
                                    if(isset($modHasilPemeriksaan->hasilpemeriksaanlab_id)){
                                        $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii],$tindakan);
                                    }
                                }else if($_POST['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI){
                                    $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                                }
                            }
                            $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
                            $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];                                                        
                            $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
                        }
                    }
                }
                /*
                if (isset($_POST['PemeriksaankeluarT'])) {
                    $this->simpanPemeriksaanKeluar($_POST['PemeriksaankeluarT'], $modPasienMasukPenunjang, $dataTindakans);
                }
                 * 
                 */
                // var_dump($this->tindakanpelayanantersimpan, $this->komponentindakantersimpan, $this->hasilpemeriksaantersimpan);
                // die;
                   
                if($this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan){
                    $transaction->commit();
                    $this->redirect(array('index','pasienmasukpenunjang_id'=>$modKunjungan->pasienmasukpenunjang_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pemeriksaan laboratorium gagal disimpan !");
//                        echo "-".$this->tindakanpelayanantersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
//                        exit;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data pemeriksaan laboratorium gagal disimpan !"." ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render('index',array(
            'modKunjungan'=>$modKunjungan,
            'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
            'modPemeriksaanLab'=>$modPemeriksaanLab,
            'modTindakan'=>$modTindakan,
            'dataTindakans'=>$dataTindakans,
			'modRujukKeluar'=>$modRujukKeluar
        ));
    }
    
    
    public function simpanPemeriksaanKeluar($post, $modPasienMasukPenunjang, $modTindakan) {
        
        // var_dump($this->tindakanpelayanantersimpan);
        
        foreach ($post as $item) {
            // $model = PemeriksaankeluarT::model()->findByPk($item['pemeriksaankeluar_id']);
            // if (empty($model)) {
            $model = new PemeriksaankeluarT;
            // }
            
            // $modTindakan = null;
                
            
            $model->attributes = $item;
            $model->pemeriksaankeluar_tgl = MyFormatter::formatDateTimeForDb($model->pemeriksaankeluar_tgl);
            $model->ruanganpengirim_id = $modPasienMasukPenunjang->ruangan_id;
            $model->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
            $model->daftartindakan_id = $modTindakan->daftartindakan_id;
            
            if (trim($model->pemeriksaankeluar_ket) == "") {
                $model->pemeriksaankeluar_ket = "-";
            }
            
            
            $supir_id = $model->supir_id;
            $perawat_id = $model->perawat_id;
            
            /*
            foreach($dataTindakans as $tindakan) {
                if ($tindakan->daftartindakan_id == $item['daftartindakan_id']) {
                    $modTindakan = $tindakan; 
                    $model->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                    break;
                }
            }
             * 
             */
            
            if ($model->validate() || $model->validate()) {
                $this->tindakanpelayanantersimpan = $this->tindakanpelayanantersimpan && $model->save();
                
                // var_dump($supir_id, $perawat_id); die;
                
                $modTindakan->supir_id = $supir_id;
                $modTindakan->perawat_id = $perawat_id;
                $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
                $modTindakan->update(array('supir_id', 'perawat_id', 'tarif_tindakan'));
                
            } else {
                $this->tindakanpelayanantersimpan = false;
                // var_dump($model->errors); die;
            }
            
            $this->simpankomponensupirperawat($modTindakan, Params::KOMPONENTARIF_ID_JASA_SOPIR, 4830);
            $this->simpankomponensupirperawat($modTindakan, Params::KOMPONENTARIF_ID_JASA_PARAMEDIS, 4025);
            
            // var_dump($this->tindakanpelayanantersimpan);
            
            $modTindakan = $this->updateTotalTarifTindakan($modTindakan);
            
            // var_dump($this->tindakanpelayanantersimpan);
            // var_dump($modTindakan->attributes, $this->tindakanpelayanantersimpan, $model->attributes, $item);
            
            // die;
        }
        
        

    }
    
    
    protected function simpankomponensupirperawat($tindakan, $komponentarif_id, $tarif) {
        $kom = TindakankomponenT::model()->findByAttributes(array(
            'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
            'komponentarif_id'=>$komponentarif_id,
        ));
        
        $ok = true;
        
        if (!empty($kom)) {
            $base_tarif = $kom->tarif_kompsatuan * $tindakan->qty_tindakan;
            $selisih = $tarif - $kom->tarif_kompsatuan;
            $kom->tarif_kompsatuan += $selisih;
            $kom->tarif_tindakankomp += $selisih * $tindakan->qty_tindakan;
            $kom->subsidiasuransikomp += ($selisih * $tindakan->qty_tindakan) * $kom->subsidiasuransikomp / $base_tarif;
            $kom->subsidipemerintahkomp += ($selisih * $tindakan->qty_tindakan) * $kom->subsidipemerintahkomp / $base_tarif;
            $kom->subsidirumahsakitkomp += ($selisih * $tindakan->qty_tindakan) * $kom->subsidirumahsakitkomp / $base_tarif;
            $kom->iurbiayakomp += ($selisih * $tindakan->qty_tindakan) * $kom->iurbiayakomp / $base_tarif;
            $ok = $ok && $kom->save();
        } else {
            $kom = new TindakankomponenT;
            $kom->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
            $kom->komponentarif_id = $komponentarif_id;
            $kom->tarif_kompsatuan = $tarif;
            $kom->tarif_tindakankomp = $tarif * $tindakan->qty_tindakan;
            $kom->tarifcyto_tindakankomp = 0;
            $kom->subsidiasuransikomp = 0;
            $kom->subsidipemerintahkomp = 0;
            $kom->subsidirumahsakitkomp = 0;
            $kom->iurbiayakomp = 0;
            $ok = $ok && $kom->save();
        }
        
        $this->tindakanpelayanantersimpan = $this->tindakanpelayanantersimpan && $ok;
        
        // var_dump($ok, $kom->attributes);
        
        
        // die;
    }
    
    protected function updateTotalTarifTindakan($tindakan) {
        $kom = TindakankomponenT::model()->findAllByAttributes(array(
            'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
        ), array(
            'condition'=>'komponentarif_id <> 6',
        ));
        
        $total_satuan = 0;
        $total_tarif = 0;
        $total_medis = 0;
        $total_paramedis = 0;
        $total_akomodasi = 0;
        $total_bhp = 0;
        
        foreach ($kom as $item) {
            $gr = PersenkelkomponentarifM::model()->findByAttributes(array(
                'komponentarif_id'=>$item->komponentarif_id,
            ));
            
            $total_satuan += $item->tarif_kompsatuan;
            $total_tarif += $item->tarif_tindakankomp;
            
            if ($gr->kelompokkomponentarif_id == Params::KELOMPOKKOMPONENTARIF_ID_MEDIS) 
                $total_medis += $item->tarif_tindakankomp;
            else if ($gr->kelompokkomponentarif_id == Params::KELOMPOKKOMPONENTARIF_ID_PARAMEDIS) 
                $total_paramedis += $item->tarif_tindakankomp;
            else if ($gr->kelompokkomponentarif_id == Params::KELOMPOKKOMPONENTARIF_ID_BHP) 
                $total_bhp += $item->tarif_tindakankomp;
            else $total_akomodasi += $item->tarif_tindakankomp;
            
            
            // var_dump($item->attributes);
        }
        
        $base_satuan = $tindakan->tarif_tindakan;
        
        $tindakan->tarif_satuan = $total_satuan;
        $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;
        
        $tindakan->tarif_medis = $total_medis;
        $tindakan->tarif_paramedis = $total_paramedis;
        $tindakan->tarif_rsakomodasi = $total_akomodasi;
        $tindakan->tarif_bhp = $total_bhp;
        
        $tindakan->subsidiasuransi_tindakan = $tindakan->tarif_tindakan * $tindakan->subsidiasuransi_tindakan / $base_satuan;
        $tindakan->subsidipemerintah_tindakan = $tindakan->tarif_tindakan * $tindakan->subsidipemerintah_tindakan / $base_satuan;
        $tindakan->subsisidirumahsakit_tindakan = $tindakan->tarif_tindakan * $tindakan->subsisidirumahsakit_tindakan / $base_satuan;
        $tindakan->iurbiaya_tindakan = $tindakan->tarif_tindakan * $tindakan->iurbiaya_tindakan / $base_satuan;
        
        $this->tindakanpelayanantersimpan = $this->tindakanpelayanantersimpan && $tindakan->update(array(
            "tarif_satuan", "tarif_tindakan", "tarif_medis", "tarif_paramedis", "tarif_rsakomodasi", "tarif_bhp",
            "subsidiasuransi_tindakan", "subsidipemerintah_tindakan", "subsisidirumahsakit_tindakan", "iurbiaya_tindakan"
        )); 
        
        // var_dump($this->tindakanpelayanantersimpan, $tindakan->attributes); die;
        
        return $tindakan;
    }
    
    
    /**
     * @param type $pasienmasukpenunjang_id
     * @return LBPasienMasukPenunjangV
     */
    public function loadModPasienMasukPenunjang($pasienmasukpenunjang_id){
            $criteria=new CDbCriteria;
            $criteria->addCondition("pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id);
            $model = LBPasienMasukPenunjangV::model()->find($criteria);					
            return $model;
    }
    
    /**
    * untuk menampilkan data kunjungan dari autocomplete
    * - no_masukpenunjang
    * - no_pendaftaran
    * - no_rekam_medik
    * - nama_pasien
    */
    public function actionAutocompleteKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
            $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->addCondition('ruangan_id = '.$ruangan_id);
            $criteria->order = 'no_pendaftaran, no_masukpenunjang, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = LBPasienMasukPenunjangV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran."-".$model->no_masukpenunjang.'-'.$model->no_rekam_medik.'-'.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Mengurai data kunjungan berdasarkan:
     * - pasienmasukpenunjang_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();
            $model = $this->loadModPasienMasukPenunjang($_POST['pasienmasukpenunjang_id']);
            if(isset($model)){
                $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id));
                if(isset($loadHasilPemeriksaan)){
                    if(strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)){
                        $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !";
                    }else{
						$p = PendaftaranT::model()->findByPk($model->pendaftaran_id);
						if( (strtolower(trim($p->statusperiksa)) == strtolower(Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO)) || (strtolower(trim($p->statusperiksa)) == strtolower(Params::STATUSPERIKSA_SUDAH_PULANG) ) ){
							$returnVal['pesan'] = "Pasien dengan status periksa  $p->statusperiksa, tidak bisa merubah tindakan pemeriksaan !";
						}
					}
                }
            }
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["perawat_id"] = $model->getPerawatId();
			$returnVal["dokterperujuk"] = $model->getDokterPerujuk();
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    /**
     * set LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetTindakanPelayanan(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $drop = '<option value="">-- Pilih --</option>';
            
            $modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
            if(count($modTindakans) > 0){
                foreach($modTindakans AS $i => $modTindakan){
                    
                    $rujuk = PemeriksaankeluarT::model()->findByAttributes(array(
                        'tindakanpelayanan_id'=>$modTindakan->tindakanpelayanan_id,
                    ));
                    
                    
                    $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->pemeriksaanlab_id;
                    $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
                    $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
                    $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);
                    
                    $rows .= $this->renderPartial("_rowTindakanPemeriksaan",array('i'=>0, 'modTindakan'=>$modTindakan, 'rujuk'=>$rujuk), true);
                
                    if (empty($rujuk))
                        $drop .= CHtml::tag('option', array('value'=>$modTindakan->daftartindakan_id),CHtml::encode($modTindakan->daftartindakan->daftartindakan_nama),true);
                    
                }
            }
            echo CJSON::encode(array(
                'rows'=>$rows,
                'drop'=>$drop,
            ));
        }
        Yii::app()->end();
    }
    /**
     * hapus LKTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     * @params daftartindakan_id
     */
    public function actionHapusTindakanPelayanan(){
        if(Yii::app()->request->isAjaxRequest) {
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
                $modTindakan = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id'],'daftartindakan_id'=>$_POST['daftartindakan_id']));
                $modTindakan->detailhasilpemeriksaanlab_id = null;
                $modTindakan->hasilpemeriksaanpa_id = null;
                $modTindakan->update();
                $hapusTindakanKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$modTindakan->tindakanpelayanan_id));
                if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
                    $hapusDetailHasilPemeriksaan = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$modTindakan->tindakanpelayanan_id));
                }else if($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
                    $hapusHasilPemeriksaanPA = HasilpemeriksaanpaT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$modTindakan->tindakanpelayanan_id));
                }
                $cekTindakan = TindakanpelayananT::model()->findByPk($modTindakan->tindakanpelayanan_id);
                if($cekTindakan->tindakansudahbayar_id){
                    $hapusTindakan = false;
                }else{
                    $hapusTindakan = TindakanpelayananT::model()->deleteByPk($modTindakan->tindakanpelayanan_id);
                }
                if($hapusTindakanKomponen && $hapusTindakan){
                    $transaction->commit();
                    $data['pesan'] = "Pemeriksaan berhasil dihapus!";
                    $data['sukses'] = 1;
                }else{
                    $transaction->rollback();
                    if(!$hapusTindakanKomponen)
                        $data['pesan'] = "Pemeriksaan komponen gagal dihapus!";
                    if(!$hapusTindakan)
                        $data['pesan'] = "Pemeriksaan gagal dihapus karena sudah dibayarkan!";
                    $data['sukses'] = 0;
                }    
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Pemeriksaan gagal dihapus! :".MyExceptionMessage::getMessage($exc,true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
	
	public function actionAddTindakanPilihan(){
		if (Yii::app()->request->isAjaxRequest){				
			$id = isset($_POST['id'])?$_POST['id']:null;
			$ruangan_id = isset($_POST['ruangan_id'])?$_POST['ruangan_id']:null;
			$penjamin_id = isset($_POST['penjamin_id'])?$_POST['penjamin_id']:null;
			$kelaspelayanan_id = isset($_POST['kelaspelayanan_id'])?$_POST['kelaspelayanan_id']:null;
			$pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id'])?$_POST['pasienmasukpenunjang_id']:null;
			$ada = '';
			$data['pesan'] = '';

			$pemeriksaan = LBTarifpemeriksaanlabruanganV::model()->findAllByAttributes(array(
				'daftartindakan_id'=> $id,
				'ruangan_id' => $ruangan_id,
				'penjamin_id' => $penjamin_id,
				'kelaspelayanan_id' => $kelaspelayanan_id,
			));
			
			$cekAda = LBTindakanPelayananT::model()->findAllByAttributes(array(
				'daftartindakan_id'=> $id,
				'ruangan_id' => $ruangan_id,
				'penjamin_id' => $penjamin_id,
				'kelaspelayanan_id' => $kelaspelayanan_id,
				'pasienmasukpenunjang_id'=> $pasienmasukpenunjang_id
			));
			
			if (count($cekAda)>0){
				$data['sukses'] = 1;
				foreach ($cekAda as $dt){
					$ada .= $dt->getPemeriksaanLab()->pemeriksaanlab_nama.', ';
				}
			}

			$str = "";
			$tindakan = new LBTindakanPelayananT;
			foreach ($pemeriksaan as $item) {
				$tindakan->daftartindakan_id = $item->daftartindakan_id;
				$tindakan->pemeriksaanlab_id = $item->pemeriksaanlab_id;
				$tindakan->jenistarif_id = $item->jenistarif_id;
				$tindakan->qty_tindakan = 1;
				$tindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
				$tindakan->tarif_satuan = $item->harga_tariftindakan;
				$tindakan->tarif_tindakan = $item->harga_tariftindakan * $tindakan->qty_tindakan;
				
				$str .= $this->renderPartial("_rowTindakanPemeriksaanV2",array('i'=>0, 'modTindakan'=>$tindakan, 'item'=>$item), true);
			}
			
			$data['row'] = $str;
			$data['ada'] = true;
			
			echo json_encode($data);
		}
		Yii::app()->end();
	}
    
    
    public function actionDetailRujukan($id) {
        $this->layout = '//layouts/iframeNeon';
        
        $model = PemeriksaankeluarT::model()->findByPk($id);
        $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
            'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id
        ));
        $tindakan = TindakanpelayananT::model()->findByPk($model->tindakanpelayanan_id);
        
        $this->render('_detailRujukPenunjang', array(
            'model'=>$model,
            'penunjang'=>$penunjang,
            'tindakan'=>$tindakan,
        ));
    }
    
    public function actionBatalRujukKeluar() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $data = array(
            'ok'=>1,
            'msg'=>'',
        );
        
        $this->tindakanpelayanantersimpan = true;
        $trans = Yii::app()->db->beginTransaction();
        
        
        try {
            $model = PemeriksaankeluarT::model()->findByPk($_POST['id']);
            $tindakan = TindakanpelayananT::model()->findByPk($model->tindakanpelayanan_id);
            
            TindakankomponenT::model()->deleteAllByAttributes(array(
                'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
                'komponentarif_id'=>array(Params::KOMPONENTARIF_ID_JASA_SOPIR, Params::KOMPONENTARIF_ID_JASA_PARAMEDIS),
            ));
            
            $tindakan->perawat_id = $tindakan->supir_id = null;
            $tindakan->update(array('perawat_id','supir_id'));
            
            $tindakan = $this->updateTotalTarifTindakan($tindakan);
            
            
            PemeriksaankeluarT::model()->deleteByPk($model->pemeriksaankeluar_id);
            
            if ($this->tindakanpelayanantersimpan) {
                $trans->commit();
            } else {
                $trans->rollback();
                $data['ok'] = 0;
                $data['msg'] = "";
            }
            
        } catch (CException $e) {
            $trans->rollback();
            $data['ok'] = 0;
            $data['msg'] = $e->message;
        }
        
        
        echo CJSON::encode($data);
    }
    
    public function actionSetFormRujukan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $tindakan = TindakanpelayananT::model()->findByPk($_POST['id']);
        $daftar = DaftartindakanM::model()->findByPk($tindakan->daftartindakan_id);
        $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
            'pasienmasukpenunjang_id'=>$tindakan->pasienmasukpenunjang_id,
        ));
        
        $res = $penunjang->attributes;
        $res['daftartindakan'] = $daftar->attributes;
        $res['tindakanpelayanan_id'] = $tindakan->tindakanpelayanan_id;
        $res['daftartindakan_id'] = $tindakan->daftartindakan_id;
        $res['daftartindakan_nama'] = $daftar->daftartindakan_nama;
        
        echo CJSON::encode($res);
        
    }
    
    
    public function actionSimpanRujukanKeluar() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($_POST['PemeriksaankeluarT'][0]['pasienmasukpenunjang_id']);
        $dataTindakan = TindakanpelayananT::model()->findByPk($_POST['PemeriksaankeluarT'][0]['tindakanpelayanan_id']);
        $trans = Yii::app()->db->beginTransaction();
        $this->tindakanpelayanantersimpan = true;
        
        $data = array(
            'ok'=>1,
            'msg'=>'',
        );
        
        try {
            
            $this->simpanPemeriksaanKeluar($_POST['PemeriksaankeluarT'], $modPasienMasukPenunjang, $dataTindakan);
            
            if ($this->tindakanpelayanantersimpan) {
                $trans->commit();
            } else {
                $trans->rollback();
                $data['ok'] = 0;
                $data['msg'] = "";
            }
            
        } catch (CException $e) {
            $trans->rollback();
            $data['ok'] = 0;
            $data['msg'] = $e->getMessage();
        }
        
        
        
        echo CJSON::encode($data);
    }
}
