<?php

class PermintaanPembelianController extends MyAuthController
{

    public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.permintaanPembelian.';
    public $permintaanpembeliantersimpan = true;
    
    public function actionIndex($permintaanpembelian_id = null,$rencana_id = null, $penawaran_id = null){
        $format = new MyFormatter;
        $modPermintaanPembelian = new ADPermintaanpembelianT;
        
        $modPermintaanPembelian->tglpermintaanpembelian = date('Y-m-d H:i:s');
        $modPermintaanPembelian->nopermintaan = "Otomatis";
        $modPermintaanPembelian->tglpermintaanuangmuka = date('Y-m-d H:i:s');
        $modPermintaanPembelian->is_uangmukapembelian = false;
        
        $modDetails = array();
        $modRencanaKebFarmasi = new ADRencanaKebFarmasiT;
        $modPermintaanPenawaran = new ADPermintaanPenawaranT;
        
        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id',$modul_id);
        $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
        $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
        
        // alamat pengiriman
        $profil = ProfilrumahsakitM::model()->find();
        if (!empty($profil)){
            $kelrh = (!empty($profil->kelurahan_id)?$profil->kelurahan->kelurahan_nama:null);
            $kec = (!empty($profil->kecamatan_id)?$profil->kecamatan->kecamatan_nama:null);
            $kab = (!empty($profil->kabupaten_id)?$profil->kabupaten->kabupaten_nama:null);
            $prov = (!empty($profil->propinsi_id)?$profil->propinsi->propinsi_nama:null);
            $alamatpengirim = $profil->alamatlokasi_rumahsakit.", ".$kelrh.", ".$kec.", ".$kab.", ".$prov." ".$profil->kodepos;
            $modPermintaanPembelian->alamatpengiriman = $alamatpengirim;

        }
        
        $modKonfigFarmasi = GFKonfigfarmasiK::model()->find('konfigfarmasi_aktif is true');
        
        if(!empty($modKonfigFarmasi->penanggungjawab_apoterker_id)){
            $modPenanggungApoteker = PegawaiM::model()->findByPk($modKonfigFarmasi->penanggungjawab_apoterker_id);
            if(!empty($modPenanggungApoteker)){
              $modPermintaanPembelian->pegawaiapoteker_id = $modPenanggungApoteker->pegawai_id;
              $modPermintaanPembelian->pegawaiapoteker_nama = $modPenanggungApoteker->namaLengkap;
              $modPermintaanPembelian->pegawaiapoteker_alamat = $modPenanggungApoteker->alamat_pegawai;
              $modPermintaanPembelian->pegawaiapoteker_sipa = $modPenanggungApoteker->suratizinpraktek;
            }
        }
        
        if(isset($_POST['tujuansms'])){
            $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        if (!empty($penawaran_id) && (empty($permintaanpembelian_id))){
            $modPermintaanPenawaran = ADPermintaanPenawaranT::model()->findByPk($penawaran_id);
            echo "<pre>";
            var_dump($modPermintaanPenawaran); die;
            $jumlahPermintaan = ADPermintaanpembelianT::model()->countByAttributes(array('permintaanpenawaran_id'=>$modPermintaanPenawaran->permintaanpenawaran_id));
            $modPermintaanPembelian->permintaanpenawaran_id = $modPermintaanPenawaran->permintaanpenawaran_id;
            $modPermintaanPembelian->attributes = $modPermintaanPenawaran->attributes;
            if (!empty($modPermintaanPenawaran)){
                $modPenawaranDetail = ADPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id'=>$modPermintaanPenawaran->permintaanpenawaran_id));
                if (count((array)$modPenawaranDetail) > 0){
                    $totalSebelumDiskon = 0;
                    foreach ($modPenawaranDetail as $key => $value) {                                
                        $obat = ObatalkesM::model()->findByPk($value->obatalkes_id);
                        $stok = StokobatalkesT::getJumlahStok($obat->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                        $kemasanbesar = ($obat->kemasanbesar > 0) ? $obat->kemasanbesar : 1;
                        $jmlKemasan = ($obat->kemasanbesar > 0) ? $obat->kemasanbesar : 1;
                        $jmlpermintaan = round($value->qty / $kemasanbesar);
                        if($jmlpermintaan < 0 ){
                            $jmlpermintaan = 0;
                        }                                               
                        
                        $modDetails[$key] = new ADPermintaanDetailT();
                        $modDetails[$key]->attributes = $value->attributes;
                        $modDetails[$key]->stokakhir = $stok;
                        $modDetails[$key]->jmlpermintaan = $jmlpermintaan;                        
                        $modDetails[$key]->harganettoper = $value->harganetto;
                        $modDetails[$key]->satuankecil_id = empty($value->satuankecil_id) ? null : $value->satuankecil_id;
                        $modDetails[$key]->satuanbesar_id = empty($value->satuanbesar_id) ? null : $value->satuanbesar_id;
                        $modDetails[$key]->kemasanbesar = $value->kemasanbesar;
                        $modDetails[$key]->tglkadaluarsa = $obat->tglkadaluarsa;
                        $modDetails[$key]->persendiscount = $obat->discount;
                        $modDetails[$key]->jmldiscount = ($modDetails[$key]->jmlpermintaan * $modDetails[$key]->harganettoper * $modDetails[$key]->persendiscount/100);
                        $modDetails[$key]->maksimalstok = 0;
                        $modDetails[$key]->hargasatuanper = 0;
                        $modDetails[$key]->persenppn = 0;
                        $modDetails[$key]->persenpph = 0;
                        $modDetails[$key]->biaya_lainlain = 0;
                        $totalSebelumDiskon += $modDetails[$key]->jmlpermintaan*$modDetails[$key]->harganettoper;
                    }   
                }
            }
        }else if (!empty($rencana_id) && (empty($permintaanpembelian_id))){
            $modRencanaKebFarmasi = ADRencanaKebFarmasiT::model()->findByPk($rencana_id);
            // echo "<pre>";
            // var_dump($modRencanaKebFarmasi);die;
            $modPermintaanPembelian->rencanakebfarmasi_id = $modRencanaKebFarmasi->rencanakebfarmasi_id;
            $modPermintaanPembelian->sumberdana_id = $modRencanaKebFarmasi->sumberdana_id;
            $modPermintaanPembelian->sumberdana_nama = (!empty($modRencanaKebFarmasi->sumberdana_id)?$modRencanaKebFarmasi->sumberdana->sumberdana_nama:"");
            $modRencanaDetail = GFRencDetailkebT::model()->findByAttributes(array('rencanakebfarmasi_id'=>$modRencanaKebFarmasi->rencanakebfarmasi_id));
            $modSupplier = SupplierM::model()->findByPk($modRencanaDetail->supplier_id);
            $modPermintaanPembelian->supplier_id = $modRencanaDetail->supplier_id;
            $modPermintaanPembelian->supplier_nama = $modSupplier->supplier_nama;
            if ($modRencanaKebFarmasi){
                $modRencanaDetail = GFRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$modRencanaKebFarmasi->rencanakebfarmasi_id));
                if (count((array)$modRencanaDetail) > 0){
                    $totalSebelumDiskon = 0;
                    foreach ($modRencanaDetail as $i => $value) {
                        $obat = ADObatalkesM::model()->findByPk($value->obatalkes_id);
                        $stok = StokobatalkesT::getJumlahStok($obat->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                        $jmlKemasan = ($value->kemasanbesar > 0) ? $value->kemasanbesar : $obat->kemasanbesar;
                        $modDetails[$i] = new ADPermintaanDetailT();
                        $modDetails[$i]->attributes = $value->attributes;
                        $modDetails[$i]->stokakhir = 0;
                        
                        if (!empty($modRencanaKebFarmasi->jmlwaktupemakaian)){
                            $jml = $value->getSisaRencana($rencana_id);
                            $jmlTot = is_array($jml)?(($value->jmlpermintaan * $modRencanaKebFarmasi->jmlwaktupemakaian) - $jml[$value->obatalkes_id]['stok']):$value->jmlpermintaan * $modRencanaKebFarmasi->jmlwaktupemakaian;

                            if ($jmlTot < 0){
                                $jmlTot = 0;
                            }
                        }else{
                            $jmlTot = $value->jmlpermintaan;
                        }
                        
                        // $modDetails[$i]->jmlpermintaan = $jmlTot;
                        $modDetails[$i]->jmlpermintaan = $value->jmlpermintaan;
                        $modDetails[$i]->harganettoper = $value->harganettorenc;
                        $modDetails[$i]->satuanobat = empty($value->satuankecil_id) ? Params::SATUANOBAT_BESAR : Params::SATUANOBAT_KECIL;
                        $modDetails[$i]->satuankecil_id = (empty($value->satuankecil_id) ? null : $value->satuankecil_id);
                        $modDetails[$i]->satuanbesar_id = (empty($value->satuanbesar_id) ? null : $value->satuanbesar_id);
                        $modDetails[$i]->hargasatuanper = $value->harganettorenc * $value->kemasanbesar; //krn harga beli besar belum di tentukan di rencana
                        $modDetails[$i]->kemasanbesar = $value->kemasanbesar;
                        $modDetails[$i]->tglkadaluarsa = $value->tglkadaluarsa;
//                        $modDetails[$i]->persendiscount = $obat->discount;
                        $modDetails[$i]->jmldiscount = ($modDetails[$i]->jmlpermintaan * $modDetails[$i]->hargasatuanper * $modDetails[$i]->persendiscount/100);
                        $modDetails[$i]->maksimalstok = 0;
                        $modDetails[$i]->persenppn = (!empty($value->persenppn)) ? $value->persenppn : 0;
                        $modDetails[$i]->hargasatuanper = 0;
//                        $modDetails[$i]->persenpph = (!empty($value->persenppn)) ? $value->persenppn : 0;
                        $modDetails[$i]->biaya_lainlain = 0;
                        $totalSebelumDiskon += $modDetails[$i]->jmlpermintaan*$modDetails[$i]->harganettoper;
                    }
                }
            }
        }
                
        $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
        if(isset($modApprovalotorisasiM)){
            if($modPermintaanPembelian->sumberdana_id == Params::SUMBERDANA_ID_PT){
                $modPermintaanPembelian->pegawaimengetahui_id = $modApprovalotorisasiM->managerkeuanganpt_id;
                $modPermintaanPembelian->pegawaimengetahuiumum_id = $modApprovalotorisasiM->managerumumpt_id;
                $modPermintaanPembelian->pegawaimenyetujui_id = $modApprovalotorisasiM->direkturpt_id;
            }else{
                $modPermintaanPembelian->pegawaimengetahui_id = $modApprovalotorisasiM->managerkeuangan_id;
                $modPermintaanPembelian->pegawaimengetahuiumum_id = $modApprovalotorisasiM->managerumum_id;
                $modPermintaanPembelian->pegawaimenyetujui_id = $modApprovalotorisasiM->direkturrs_id;
            }
        }
        
        $modPermintaanPembelian->pegawai_id = Yii::app()->user->getState('pegawai_id');
        
        if(!empty($permintaanpembelian_id)){
            $modPermintaanPembelian= ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);
            $modPermintaanPembelian->pegawaimengetahui_nama = !empty($modPermintaanPembelian->pegawaimengetahui->NamaLengkap) ? $modPermintaanPembelian->pegawaimengetahui->NamaLengkap : "";
            $modPermintaanPembelian->pegawaimenyetujui_nama = !empty($modPermintaanPembelian->pegawaimenyetujui->NamaLengkap) ? $modPermintaanPembelian->pegawaimenyetujui->NamaLengkap : "";
            $modPermintaanPembelian->sumberdana_nama = (!empty($modPermintaanPembelian->sumberdana_id)?$modPermintaanPembelian->sumberdana->sumberdana_nama:"");
            
            $sup = SupplierM::model()->findByPk($modPermintaanPembelian->supplier_id);
            $modPermintaanPembelian->supplier_nama = $sup->supplier_nama;
            $modPermintaanPembelian->supplier_alamat = $sup->supplier_alamat;
            
            if(!empty($modPermintaanPembelian->tglpermintaanuangmuka)){
                $modPermintaanPembelian->is_uangmukapembelian = true;
            }else{
                $modPermintaanPembelian->is_uangmukapembelian = false;
            }
            
            if (!empty($modPermintaanPembelian->pegawaiapoteker_id)) {
                $peg = PegawaiM::model()->findByPk($modPermintaanPembelian->pegawaiapoteker_id);
                $modPermintaanPembelian->pegawaiapoteker_nama = $peg->namaLengkap;
                $modPermintaanPembelian->pegawaiapoteker_alamat = $peg->alamat_pegawai;
                $modPermintaanPembelian->pegawaiapoteker_sipa = $peg->suratizinpraktek;
            }
            
            if(!empty($modPermintaanPembelian->rencanakebfarmasi_id)){
                $modRencanaKebFarmasi->noperencnaan = $modPermintaanPembelian->rencanakebfarmasi->noperencnaan;
                $modRencanaKebFarmasi->tglperencanaan = $modPermintaanPembelian->rencanakebfarmasi->tglperencanaan;
            }
            
             if(!empty($modApprovalotorisasiM)){
                if($modPermintaanPembelian->sumberdana_id == Params::SUMBERDANA_ID_PT){
                    $modPermintaanPembelian->pegawaimengetahui_id = $modApprovalotorisasiM->managerkeuanganpt_id;
                    $modPermintaanPembelian->pegawaimengetahuiumum_id = $modApprovalotorisasiM->managerumumpt_id;
                    $modPermintaanPembelian->pegawaimenyetujui_id = $modApprovalotorisasiM->direkturpt_id;
                }else{
                    $modPermintaanPembelian->pegawaimengetahui_id = $modApprovalotorisasiM->managerkeuangan_id;
                    $modPermintaanPembelian->pegawaimengetahuiumum_id = $modApprovalotorisasiM->managerumum_id;
                    $modPermintaanPembelian->pegawaimenyetujui_id = $modApprovalotorisasiM->direkturrs_id;
                }
            }
            $modDetails = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$modPermintaanPembelian->permintaanpembelian_id));
        }
         if (!empty($modPermintaanPembelian->pegawaimengetahui_id)){
             $modpeg = PegawaiM::model()->findByPk($modPermintaanPembelian->pegawaimengetahui_id);
             $modPermintaanPembelian->pegawaimengetahui_nama = $modpeg->namaLengkap;
         }
         
         if (!empty($modPermintaanPembelian->pegawaimenyetujui_id)){
             $modpeg = PegawaiM::model()->findByPk($modPermintaanPembelian->pegawaimenyetujui_id);
             $modPermintaanPembelian->pegawaimenyetujui_nama = $modpeg->namaLengkap;
         }
         
         if (!empty($modPermintaanPembelian->pegawaimengetahuiumum_id)){
             $modpeg = PegawaiM::model()->findByPk($modPermintaanPembelian->pegawaimengetahuiumum_id);
             $modPermintaanPembelian->pegawaimengetahuiumum_nama = $modpeg->namaLengkap;
         }
        
        $modPegPemesan = PegawaiM::model()->findByPk($modPermintaanPembelian->pegawai_id);
        if(isset($modPegPemesan)){
            $modPermintaanPembelian->pegawai_nama = $modPegPemesan->namaLengkap;
        }
        
        if(isset($_POST['ADPermintaanpembelianT'])){
          
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPermintaanPembelian->attributes=$_POST['ADPermintaanpembelianT'];
                if(isset($_GET['ubah'])){
                    $modPermintaanPembelian->update_time = date('Y-m-d H:i:s');
                    $modPermintaanPembelian->update_loginpemakai_id = Yii::app()->user->id;
                    $modPermintaanPembelian->tglpermintaanpembelian = $format->formatDateTimeForDb($modPermintaanPembelian->tglpermintaanpembelian);
                }else{
                    if($modPermintaanPembelian->sumberdana_id == Params::SUMBERDANA_ID_PT){
                       $modPermintaanPembelian->nopermintaan=MyGenerator::noPembelianTerbaru("SHB"); 
                    }else{
                       $modPermintaanPembelian->nopermintaan=MyGenerator::noPembelianTerbaru(); 
                    }

                    $modPermintaanPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $modPermintaanPembelian->instalasi_id = Yii::app()->user->getState('instalasi_id');
//						$modPermintaanPembelian->pegawai_id = Yii::app()->user->getState('pegawai_id');
                    $modPermintaanPembelian->tglpermintaanpembelian=$format->formatDateTimeForDb($_POST['ADPermintaanpembelianT']['tglpermintaanpembelian']);                                                
                    $modPermintaanPembelian->create_time = date('Y-m-d H:i:s');
                    $modPermintaanPembelian->create_loginpemakai_id = Yii::app()->user->id;
                    $modPermintaanPembelian->create_ruangan = Yii::app()->user->ruangan_id;

                    if (!empty($_POST['oa_kategori_obat'])) {
                        $modPermintaanPembelian->nopermintaan=MyGenerator::noPembelianGolongan($_POST['oa_kategori_obat']);
                        $lookup = LookupM::model()->findByAttributes(array(
                            'lookup_type'=>'obatalkes_golongan',
                            'lookup_value'=>$_POST['oa_kategori_obat']
                        ));

                        if (!empty($lookup)) {
                            $modPermintaanPembelian->golongan_kode = $lookup->lookup_kode;
                        }
                    }
                }
                if(!empty($_POST['ADPermintaanpembelianT']['is_uangmukapembelian']) && $_POST['ADPermintaanpembelianT']['is_uangmukapembelian'] == 1){
                    if(!empty($modPermintaanPembelian->tglpermintaanuangmuka)){
                       $modPermintaanPembelian->tglpermintaanuangmuka = MyFormatter::formatDateTimeForDb($modPermintaanPembelian->tglpermintaanuangmuka);
                   }
               }else{
                   $modPermintaanPembelian->tglpermintaanuangmuka = null;
               }
               $modPermintaanPembelian->tgldikirim= (!empty($_POST['ADPermintaanpembelianT']['tgldikirim'])? $format->formatDateTimeForDb($_POST['ADPermintaanpembelianT']['tgldikirim']) : null);                                                
                    $modPermintaanPembelian->statuspembelian = "BELUM DISETUJUI"; //LNG-582
                    
                    if ($modPermintaanPembelian->validate()) {
                        $this->permintaanpembeliantersimpan = $this->permintaanpembeliantersimpan && $modPermintaanPembelian->save();
                        
                        if(isset($_GET['ubah'])){
                            $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->deleteAllByAttributes(array('permintaanpembelian_id'=>$modPermintaanPembelian->permintaanpembelian_id));
                        }
                        if(count((array)$_POST['ADPermintaanDetailT']) > 0){
                           foreach($_POST['ADPermintaanDetailT'] AS $i => $postOa){
                               $modDetails[$i] = $this->simpanPermintaanPembelian($modPermintaanPembelian,$postOa);
                           }
                        }
                    } else {
                        $this->permintaanpembeliantersimpan = false;
                    }
                    
                if($this->permintaanpembeliantersimpan){
                     
                    // SMS GATEWAY
                    $modSupplier = $modPermintaanPembelian->supplier;
                    $sms = new Sms();
                    $smscp1 = 1;
                    $smscp2 = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modSupplier->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modPermintaanPembelian->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                       
                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPermintaanPembelian->tglpermintaanpembelian),$isiPesan);
                        $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);

                        if($smsgateway->tujuansms == Params::TUJUANSMS_SUPPLIER && $smsgateway->statussms){
                            if(!empty($modSupplier->supplier_cp_hp)){
                                $sms->kirim($modSupplier->supplier_cp_hp,$isiPesan);
                            }else{
                                $smscp1 = 0;
                                if(!empty($modSupplier->supplier_cp2_hp)){
                                    $sms->kirim($modSupplier->supplier_cp2_hp,$isiPesan);
                                }else{
                                    $smscp2 = 0;
                                }
                            }
                            
                        }
                        
                    }
                    
                    $judul = "Permintaan Pembelian";
                    $isi = $modPermintaanPembelian->nopermintaan;
                   
                    $link_permintaan = $this->createUrl('/gudangFarmasi/InformasiPermintaanPembelianGF/Index',array(
                        
						'ADInformasipermintaanpembelianV[nopermintaan]'=>$modPermintaanPembelian->nopermintaan,
						'ADInformasipermintaanpembelianV[tgl_awal]'=>date('Y-m-d H:i:s', strtotime($modPermintaanPembelian->tglpermintaanpembelian)),
						'ADInformasipermintaanpembelianV[tgl_akhir]'=>date('Y-m-d H:i:s', strtotime($modPermintaanPembelian->tglpermintaanpembelian)),
					));
                    
                    CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=>Params::RUANGAN_ID_FINANCE, 'modul_id'=>Params::MODUL_ID_KEUANGAN,  'link_proses'=>$link_permintaan),//, 'link_proses'=>$link_rj
                    ));
                    
                    // END SMS GATEWAY
                    $transaction->commit();                    
                    $this->redirect(array('index','permintaanpembelian_id'=>$modPermintaanPembelian->permintaanpembelian_id,'smscp1'=>$smscp1,'smscp2'=>$smscp2,'sukses'=>1));
                    $modPermintaanPembelian->isNewRecord = FALSE;
                }else{
                    $transaction->rollback();
                    
                    $msg = "Data Permintaan Pembelian gagal disimpan !";
                    
                    $aerr = $modPermintaanPembelian->errors;
                    
                    if (!empty($aerr) && count((array)$aerr) > 0) {
                        $msg .= "<br/>";
                        $msg .= '<ul>';
                        foreach ($aerr as $item) {
                            foreach ($item as $det) {
                                $msg .= '<li>'.$det.'</li>';
                            }
                        } 
                        $msg .= '</ul>';
                    }
                    
                    Yii::app()->user->setFlash('error',$msg);
                    $modPermintaanPembelian->isNewRecord = TRUE;
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Permintaan Pembelian gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
                $modPermintaanPembelian->isNewRecord = TRUE;
            }
        }
        
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'modPermintaanPembelian'=>$modPermintaanPembelian,
            'modDetails'=>$modDetails,
            'modRencanaKebFarmasi'=>$modRencanaKebFarmasi,
            'modPermintaanPenawaran'=>$modPermintaanPenawaran
        ));

    }
    
     /**
     * simpan ADPermintaanDetailT
     * @param type $modPermintaanPembelian
     * @param type $post
     * @return \ADPermintaanDetailT
     */
    public function simpanPermintaanPembelian($modPermintaanPembelian ,$post){
        $format = new MyFormatter();
        $modPermintaanPembelianDetail = new ADPermintaanDetailT;
        $modPermintaanPembelianDetail->attributes = $post;
        $modPermintaanPembelianDetail->permintaanpembelian_id = $modPermintaanPembelian->permintaanpembelian_id; //fake id
        $modPermintaanPembelianDetail->tglkadaluarsa = $format->formatDateTimeForDb($post['tglkadaluarsa']);
        $modPermintaanPembelianDetail->jmldiscount = 0;
        $modPermintaanPembelianDetail->maksimalstok = 0;
        //$modPermintaanPembelianDetail->persenppn = 0;
        //$modPermintaanPembelianDetail->persenpph = 0;		
		// $modPermintaanPembelianDetail->hargasatuanper = MyFormatter::formatNumberForDb($modPermintaanPembelianDetail->hargasatuanper);
		// $modPermintaanPembelianDetail->hpp = MyFormatter::formatNumberForDb($modPermintaanPembelianDetail->hpp);
		// $modPermintaanPembelianDetail->ppn = MyFormatter::formatNumberForDb($modPermintaanPembelianDetail->ppn);
    $modPermintaanPembelianDetail->hargasatuanper = $modPermintaanPembelianDetail->hargasatuanper;
		$modPermintaanPembelianDetail->hpp = $modPermintaanPembelianDetail->hpp;
		$modPermintaanPembelianDetail->ppn = $modPermintaanPembelianDetail->ppn;
		     
        $modPermintaanPembelianDetail->biaya_lainlain = 0;
        
        if($post['satuanobat'] == PARAMS::SATUANOBAT_KECIL){
            $modPermintaanPembelianDetail->satuanbesar_id = NULL;
        }else{
            $modPermintaanPembelianDetail->satuankecil_id = NULL;
        }
        
        if($modPermintaanPembelianDetail->validate()) { 
			
            $modPermintaanPembelianDetail->save();
        } else {
            $this->permintaanpembeliantersimpan &= false;
        }
        
        
        return $modPermintaanPembelianDetail;
    }
    
    /**
    * menampilkan obat
    * @return row table 
    */
    public function actionLoadFormPermintaanPembelian()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
			$status = $_POST['statusobat'];
            $jumlah = $_POST['jumlah'];
			$supplier_id = $_POST['supplier_id'];
			$tipesatuan = $_POST['tipesatuan'];
            
            $format = new MyFormatter();
            $modPermintaanPembelian = new ADPermintaanPembelianT();
            $modPermintaanPembelianDetail = new ADPermintaanDetailT;
			
            $modObatAlkes = ADObatalkesM::model()->findByPk($obatalkes_id);
			if (!empty($supplier_id)){
				$modObatSupplier = GFObatSupplierM::model()->findByAttributes(array('supplier_id'=>$supplier_id, 'obatalkes_id'=>$obatalkes_id));
			}
                        
            $jmlKemasan = ($modObatAlkes->kemasanbesar > 0) ? $modObatAlkes->kemasanbesar : 1;
			
			if ($tipesatuan == Params::SATUANOBAT_BESAR){
				$jumlah = $jumlah * $jmlKemasan;
				$modPermintaanPembelianDetail->jmlpermintaan = $jumlah;
				$modPermintaanPembelianDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
			}else{
				$modPermintaanPembelianDetail->jmlpermintaan = $jumlah;
				$modPermintaanPembelianDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
			}
            
			$modPermintaanPembelianDetail->satuanobat = $tipesatuan;
			
			if ($status == 'supplier'){
				//$modPermintaanPembelianDetail->harganettoper = number_format($modObatSupplier->hargabelikecil,2,",",".");
				$modPermintaanPembelianDetail->harganettoper = $modObatSupplier->hargabelikecil;
			}else{
				//$modPermintaanPembelianDetail->harganettoper = number_format($modObatAlkes->harganetto,2,",",".");
				$modPermintaanPembelianDetail->harganettoper = $modObatAlkes->harganetto;
			}
			
			
            
            //$modPermintaanPembelianDetail->harganettoper = $modObatAlkes->harganetto;
//            $modPermintaanPembelianDetail->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
            $modPermintaanPembelianDetail->stokakhir = 0;
            $modPermintaanPembelianDetail->maksimalstok = 0;
            $modPermintaanPembelianDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
            $modPermintaanPembelianDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
            $modPermintaanPembelianDetail->persenppn = 0;
            $modPermintaanPembelianDetail->persenpph = 0;//Yii::app()->user->getState('persenppn');
            $modPermintaanPembelianDetail->tglkadaluarsa = NULL;
			//$modPermintaanPembelianDetail->hargasatuanper = '';
            $modPermintaanPembelianDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
//            $modPermintaanPembelianDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
//            $modPermintaanPembelianDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
            //$modPermintaanPembelianDetail->satuanobat = Params::SATUANOBAT_KECIL;
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial($this->path_view.'_rowObatPermintaanPembelian', array(
                    'modPermintaanPembelian'=>$modPermintaanPembelian,
                    'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail,
                ), 
                true))
            );
            exit;  
        }
    }
    
    public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();            
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->compare('ruangan_id', Params::RUANGAN_ID_GUDANG_UMUM);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->join = "JOIN ruanganpegawai_m rp ON rp.pegawai_id = t.pegawai_id";            
            // $criteria->addCondition(" rp.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->compare('unitkerja_id', array(Params::UNITKERJA_ID_PELAYANAN_MEDIS, Params::UNITKERJA_ID_PENUNJANG_MEDIS));
            
            $criteria->limit = 5;
            $models = ADPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionAutocompleteObatAlkes()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'obatalkes_nama';
            $criteria->limit = 5;
            $models = ADObatAlkesM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->obatalkes_nama." (Stok=".$model->StokObatRuangan.")";
                $returnVal[$i]['value'] = $model->obatalkes_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
        
    /**
     * untuk print data permintaan pembelian farmasi
     */
    public function actionPrint($permintaanpembelian_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPermintaanPembelian = ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);     
        $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));

        $judul_print = 'Permintaan Pembelian Farmasi';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $this->render($this->path_view.'PrintBaru', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPermintaanPembelian'=>$modPermintaanPembelian,
                'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail,
                'caraPrint'=>$caraPrint
        ));
    } 
    
    
    public function actionViewStokOA() {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        
        $oa = ObatalkesM::model()->findByPk($_POST['id']);
        $stok = StokobatalkesT::model()->findAllByAttributes(array(
            'obatalkes_id'=>$_POST['id'],
            'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
        ), array(
            'order'=>'tglkadaluarsa asc',
        ));
        
        $restok = array();
        foreach ($stok as $item) {
            if (empty($restok[$item->tglkadaluarsa])) {
                $restok[$item->tglkadaluarsa] = array(
                    'tgl'=>MyFormatter::formatDateTimeForUser($item->tglkadaluarsa),
                    'stok'=>0,
                );
            }
            
            $restok[$item->tglkadaluarsa]['stok'] += $item->qtystok_in - $item->qtystok_out;
        }
        
        $rows = "";
        
        foreach ($restok as $item) {
            $rows .= '<tr class="details"><td>'.$item['tgl'].'</td><td class="info_num">'.$item['stok'].'</td></tr>';
        }
        
        $res = array();
        $res['stok_min'] = $oa->minimalstok;
        $res['stok_max'] = $oa->maksimalstok;
        $res['detail'] = $rows;
        
        echo CJSON::encode($res);
    }
    
    
    
    public function actionAutoCompleteSupplier($term = null) {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $criteria = new CDbCriteria;
        $criteria->compare('lower(supplier_nama)', strtolower($term), true);
        $criteria->addCondition('supplier_aktif = true');
        $criteria->order = 'supplier_nama';
        $criteria->limit = 10;
        
        $model = SupplierM::model()->findAll($criteria);
        $res = array();
        
        foreach ($model as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->supplier_nama;
            $sub['value'] = $item->supplier_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }
    
    
    public function actionPrintObatTertentu($permintaanpembelian_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPermintaanPembelian = ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);     
        $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
        $apoteker = new ADPegawaiM();
        if(!empty($modPermintaanPembelian->pegawaiapoteker_id)){
            $apoteker = ADPegawaiM::model()->findByPk($modPermintaanPembelian->pegawaiapoteker_id);
        }
        
        $distributor = SupplierM::model()->findByPk($modPermintaanPembelian->supplier_id);
        
        $judul_print = 'Permintaan Pembelian Farmasi';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'PrintObatTertentu', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPermintaanPembelian'=>$modPermintaanPembelian,
                'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail,
                'apoteker'=>$apoteker,
                'distributor'=>$distributor,
                'caraPrint'=>$caraPrint
        ));
    } 
    
    public function actionPrintObatPrekursor($permintaanpembelian_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPermintaanPembelian = ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);     
        $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
        $apoteker = new ADPegawaiM();
        if(!empty($modPermintaanPembelian->pegawaiapoteker_id)){
            $apoteker = ADPegawaiM::model()->findByPk($modPermintaanPembelian->pegawaiapoteker_id);
        }
        
        $distributor = SupplierM::model()->findByPk($modPermintaanPembelian->supplier_id);
        
        $judul_print = 'Permintaan Pembelian Farmasi';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'PrintObatPrekursor', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPermintaanPembelian'=>$modPermintaanPembelian,
                'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail,
                'apoteker'=>$apoteker,
                'distributor'=>$distributor,
                'caraPrint'=>$caraPrint
        ));
    }
    
    public function actionPrintObatPsikotropika($permintaanpembelian_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPermintaanPembelian = ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);     
        $modPermintaanPembelianDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
        $apoteker = new ADPegawaiM();
        if(!empty($modPermintaanPembelian->pegawaiapoteker_id)){
            $apoteker = ADPegawaiM::model()->findByPk($modPermintaanPembelian->pegawaiapoteker_id);
        }
        
        $distributor = SupplierM::model()->findByPk($modPermintaanPembelian->supplier_id);
        
        $judul_print = 'Permintaan Pembelian Farmasi';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'PrintObatPsikotropika', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPermintaanPembelian'=>$modPermintaanPembelian,
                'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail,
                'apoteker'=>$apoteker,
                'distributor'=>$distributor,
                'caraPrint'=>$caraPrint
        ));
    }
}
?>
