<?php

class PenerimaanBarangController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.penerimaanBarang.';
    public $penerimaanbarangberhasiltersimpan = true;
    public $stokobatalkestersimpan = true;
    public $fakturpembeliantersimpan = true;
    public $fakturpembeliandetailtersimpan = true;
    public $uangmukatersimpan = true;
    public $returpembeliantersimpan = false;
    public $returpembeliandetailtersimpan = false;
    public $ubahhargaobatsimpan = true;
    public $succesSave = true;
    public $successSave = false;
    public $pesan = "";
    
    public function actionIndex($penerimaanbarang_id = null, $permintaanpembelian_id = null){
        $format = new MyFormatter();
        $modUangMuka = new GFUangMukaBeliT;
        $modPenerimaanBarang = new GFPenerimaanBarangT;
        $modPermintaanPembelian=  new GFPermintaanPembelianT;
        $modFakturPembelian = new GFFakturpembelianT;
        $modDetails = array();
        
        $modPenerimaanBarang->noterima = "Otomatis";
        $modPenerimaanBarang->tglterima = date('Y-m-d H:i:s');
        $modPenerimaanBarang->tglsuratjalan = date('Y-m-d H:i:s');     
//		$modPenerimaanBarang->is_langsungfaktur = 1;
		$modPenerimaanBarang->tglkadaluarsa = date('Y-m-d 00:00:00', strtotime('+2 years'));
		
		if (Yii::app()->user->getState('nama_pegawai')){
			$modPenerimaanBarang->pegawai_nama = Yii::app()->user->getState('nama_pegawai');
		}
        
        $modFakturPembelian->biayamaterai = 0;        
        $modFakturPembelian->tglfaktur = date('Y-m-d H:i:s');
        $modFakturPembelian->tgljatuhtempo = date('Y-m-d 00:00:00');
        
        //$modPenerimaanBarang->tglkadaluarsa = date('Y-m-d H:i:s');
        
        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id',$modul_id);
        $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
        $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
        if(isset($_POST['tujuansms'])){
            $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
        
        $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
        if(isset($modApprovalotorisasiM)){
            $modPenerimaanBarang->pegawaimengetahui_id = $modApprovalotorisasiM->kepalafarmasi_id; 
            $modPenerimaanBarang->pegawaimengetahui_nama = $modApprovalotorisasiM->kepalafarmasi->namaLengkap;
        }
        
        $modPenerimaanBarang->is_langsungfaktur = false;
       
        if (isset($permintaanpembelian_id) && (empty($penerimaanbarang_id))) {
            $modPermintaanPembelian = GFPermintaanPembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id, 'penerimaanbarang_id' => null));
            if (!empty($modPermintaanPembelian)) {
                $modPenerimaanBarang->supplier_id = $modPermintaanPembelian->supplier_id;
                $modPenerimaanBarang->supplier_nama = $modPermintaanPembelian->supplier->supplier_nama;
                $modPenerimaanBarang->permintaanpembelian_id = $modPermintaanPembelian->permintaanpembelian_id;
                $modPermintaanDetail = GFPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $modPermintaanPembelian->permintaanpembelian_id));				
                $modPermintaanPembelian->tglpermintaanpembelian = MyFormatter::formatDateTimeForUser($modPermintaanPembelian->tglpermintaanpembelian);
                $modPermintaanPembelian->sumberdana_nama = (isset($modPermintaanPembelian->sumberdana)?$modPermintaanPembelian->sumberdana->sumberdana_nama:"");
                $modFakturPembelian->syaratbayar_id = $modPermintaanPembelian->syaratbayar_id;
                $modPermintaanPembelian->pajak_nama = (isset($modPermintaanPembelian->pajak)?$modPermintaanPembelian->pajak->pajak_nama:"");
                $modPenerimaanBarang->sumberdana_id = $modPermintaanPembelian->sumberdana_id;
                
                $modUangMuka = GFUangMukaBeliT::model()->findByAttributes(array('permintaanpembelian_id'=>$modPermintaanPembelian->permintaanpembelian_id));
                
                if(isset($modUangMuka)){
                    $modPenerimaanBarang->tgluangbelimuka = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
                    $modPenerimaanBarang->jumlahuang = $modUangMuka->jumlahuang;
                }else{
                    $modUangMuka = new GFUangMukaBeliT;
                }
                
                if (count((array)$modPermintaanDetail) > 0) {
                    foreach ($modPermintaanDetail as $i => $detail) {			
                        $oa = ObatalkesM::model()->findByPk($detail->obatalkes_id);
                        $modDetails[$i] = new GFPenerimaanDetailT;
                        $modDetails[$i]->attributes = $detail->attributes;
                        $modDetails[$i]->jmlterima = $detail->jmlpermintaan;
                        $modDetails[$i]->jmlpermintaan = $detail->jmlpermintaan;
                        $modDetails[$i]->satuankecil_id = $detail->satuankecil_id;
                        $modDetails[$i]->satuanbesar_id = $detail->satuanbesar_id;
                        
                        if (empty($detail->satuankecil_id)) {
                            $modDetails[$i]->satuanobat = 'SATUANBESAR';
                        } else {
                            $modDetails[$i]->satuanobat = 'SATUANKECIL';
                        }
                    }
                }
            }
        }
       
        if(!empty($penerimaanbarang_id)){
            $modPenerimaanBarang= GFPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);
            $modPenerimaanBarang->pegawaimengetahui_nama = !empty($modPenerimaanBarang->pegawaimengetahui->NamaLengkap) ? $modPenerimaanBarang->pegawaimengetahui->NamaLengkap : "";
            $modPenerimaanBarang->pegawaimenyetujui_nama = !empty($modPenerimaanBarang->pegawaimenyetujui->NamaLengkap) ? $modPenerimaanBarang->pegawaimenyetujui->NamaLengkap : "";
            
            $modDetails = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$modPenerimaanBarang->penerimaanbarang_id));        
            
//            $modUangMuka = GFUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
//            if(!empty($modUangMuka)){
//                $modPenerimaanBarang->is_uangmuka = 1;            
//            }else{
//                $modUangMuka = new GFUangMukaBeliT;
//            }
            
//            $modFakturPembelian = GFFakturpembelianT::model()->findByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
//            if(count((array)$modFakturPembelian)){
//                $modPenerimaanBarang->is_langsungfaktur = 1;            
//            }else{
//                $modFakturPembelian = new GFFakturpembelianT;
//            }
        }
        
        if (isset($_POST['GFPenerimaanBarangT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
				
              $modPenerimaanBarang->attributes=$_POST['GFPenerimaanBarangT'];
              $modPenerimaanBarang->noterima = MyGenerator::noTerimaBarang();
              $modPenerimaanBarang->pegawai_id = Yii::app()->user->getState('pegawai_id');
              $modPenerimaanBarang->tglterima=$format->formatDateTimeForDb($_POST['GFPenerimaanBarangT']['tglterima']);
              $modPenerimaanBarang->tglsuratjalan=$format->formatDateTimeForDb($_POST['GFPenerimaanBarangT']['tglsuratjalan']);
              $modPenerimaanBarang->create_time = date('Y-m-d H:i:s');
              $modPenerimaanBarang->update_time = date('Y-m-d H:i:s');
              $modPenerimaanBarang->create_loginpemakai_id = Yii::app()->user->id;
              $modPenerimaanBarang->update_loginpemakai_id = Yii::app()->user->id;
              $modPenerimaanBarang->create_ruangan = Yii::app()->user->ruangan_id;
              $modPenerimaanBarang->gudangpenerima_id = Yii::app()->user->getState('ruangan_id');
					
                if($modPenerimaanBarang->save()){ 
                  if(Yii::app()->user->getState('ispenerimaanlangsung') == false){
                    $updatePermintaanPembelian = GFPermintaanPembelianT::model()->updateByPk($modPenerimaanBarang->permintaanpembelian_id, array('penerimaanbarang_id'=>$modPenerimaanBarang->penerimaanbarang_id));
                  }

                    if (Yii::app()->user->getState('isfakturdigudang') == true && (!empty($_POST['GFPenerimaanBarangT']['is_langsungfaktur']) && $_POST['GFPenerimaanBarangT']['is_langsungfaktur'] == 1)){ 
                      $modFakturPembelian = $this->simpanFakturPembelian($modFakturPembelian, $modPenerimaanBarang);
                    }

                    if(count((array)$_POST['GFPenerimaanDetailT']) > 0){
                       foreach($_POST['GFPenerimaanDetailT'] AS $i => $postOa){ 
                           $modDetails[$i] = $this->simpanPenerimaanBarangDetail($modPenerimaanBarang,$postOa); 
                           $this->simpanStokObatAlkes($modDetails[$i],$postOa,$modPenerimaanBarang);

                           if (Yii::app()->user->getState('isfakturdigudang') == true && (!empty($_POST['GFPenerimaanBarangT']['is_langsungfaktur']) && $_POST['GFPenerimaanBarangT']['is_langsungfaktur'] == 1)){ 
                            $this->simpanFakturDetail($modDetails[$i], $modFakturPembelian, $postOa);
                          }
                       }
                    }

                    if(Yii::app()->user->getState('isjurnalotomatis') == true){
                      //Jurnal Terima 
                      if(Yii::app()->user->getState('isjurnalfaktur') == true){
                        $modPenerima = PenerimaanbarangT::model()->findByPk($modPenerimaanBarang->penerimaanbarang_id);
                        $modDetailPene = PenerimaandetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$modPenerima->penerimaanbarang_id));
            
                        if(!empty($modDetailPene)){
                          foreach($modDetailPene as $oriDetailPen){
                            $modOa = ObatalkesM::model()->findByPk($oriDetailPen->obatalkes_id);
                            if(!empty($modOa->jenisobatalkes_id)){
                              $modRekOa = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $modOa->jenisobatalkes_id, 'isterimagudang' => true, 'ruangan_id'=> Yii::app()->user->getState('ruangan_id')), array('order'=>'debitkredit ASC'));
                              $modJurnal = $this->saveJurnalRekeningPenerimaan($modPenerima, $modOa);
                              
                              if(!empty($modRekOa)){
                                $nourut = 1;
                                foreach($modRekOa as $dataRek){
                                  if(!empty($dataRek->rekening5_id)){
                                    $this->saveJurnalDetailPenerimaan($modJurnal, $dataRek->rekening5_id, round(($oriDetailPen->jmlterima * $oriDetailPen->harganettoper),2),$dataRek->debitkredit, $nourut);
                                    $nourut++;
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                } 
				
                if($this->penerimaanbarangberhasiltersimpan && $this->stokobatalkestersimpan && $this->uangmukatersimpan && $this->fakturpembeliantersimpan && $this->fakturpembeliandetailtersimpan){
                    // SMS GATEWAY
                    $modSupplier = $modPenerimaanBarang->supplier;
                    $sms = new Sms();
                    $smscp1 = 1;
                    $smscp2 = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modSupplier->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modPenerimaanBarang->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                       
                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPenerimaanBarang->tglterima),$isiPesan);
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
                    // END SMS GATEWAY
                    
                    //START NOTIFIKASI
                    $judul = 'Penerimaan Obat & Alkes';
                    
                    $isi = (!empty($modPenerimaanBarang->pegawai_id)?$modPenerimaanBarang->pegawai->namaLengkap:Yii::app()->user->getState('nama_pegawai'))." sudah menerima obat & alkes dengan No Terima  ".$modPenerimaanBarang->noterima;
                    
                    $transaction->commit();
                    $modPenerimaanBarang->isNewRecord = FALSE;
                    $this->redirect(array('index','penerimaanbarang_id'=>$modPenerimaanBarang->penerimaanbarang_id,'smscp1'=>$smscp1,'smscp2'=>$smscp2,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Penerimaan Obat dan Alat Kesehatan dari Supplier gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Penerimaan Obat dan Alat Kesehatan dari Supplier gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }
        
        $this->render('index',array(
            'format'=>$format,
            'modUangMuka'=>$modUangMuka,
            'modPenerimaanBarang'=>$modPenerimaanBarang,
            'modPermintaanPembelian'=>$modPermintaanPembelian,
            'modFakturPembelian'=>$modFakturPembelian,
            'modDetails'=>$modDetails,
        ));
    }
    
    /**
     * simpan GFPenerimaanDetailT
     * @param type $modPenerimaanBarang
     * @param type $post
     * @return \GFPenerimaanDetailT
     */
    public function simpanPenerimaanBarangDetail($modPenerimaanBarang ,$post){
        $format = new MyFormatter();
        $modPenerimaanBarangDetail = new GFPenerimaanDetailT;
        $modPenerimaanBarangDetail->attributes = $post;
        $modPenerimaanBarangDetail->penerimaanbarang_id = $modPenerimaanBarang->penerimaanbarang_id; //fake id
        $modPenerimaanBarangDetail->tglkadaluarsa = $format->formatDateTimeForDb($post['tglkadaluarsa']);
        if(empty($modPenerimaanBarangDetail->tglkadaluarsa)){
            $modPenerimaanBarangDetail->tglkadaluarsa = date('Y-m-d H:i:s',strtotime("+2 years"));
        }
		
		if ($modPenerimaanBarangDetail->kemasanbesar == 0) $modPenerimaanBarangDetail->kemasanbesar = 1;
		
        $modPenerimaanBarangDetail->nobatch = $post['nobatch'];
        $modPenerimaanBarangDetail->biaya_lainlain = 0;
        $modPenerimaanBarangDetail->fakturdetail_id = NULL;
        $modPenerimaanBarangDetail->returdetail_id = NULL;
        $modPenerimaanBarangDetail->stokobatalkes_id = NULL;
        $modPenerimaanBarangDetail->jmldiscount = $modPenerimaanBarangDetail->jmldiscount;
        $modPenerimaanBarangDetail->hargasatuanper = $modPenerimaanBarangDetail->hargasatuanper;
        $modPenerimaanBarangDetail->harganettoper = $modPenerimaanBarangDetail->harganettoper;
		
        
        if($post['satuanobat'] == PARAMS::SATUANOBAT_KECIL){
            $modPenerimaanBarangDetail->satuanbesar_id = NULL;
        }else{
            $modPenerimaanBarangDetail->satuankecil_id = NULL;
        }
        
        if($modPenerimaanBarangDetail->validate()) { 
            $modPenerimaanBarangDetail->save();
			
			$oa = GFObatAlkesM::model()->findByPk($modPenerimaanBarangDetail->obatalkes_id);
			
			$ObatSupp = GFObatSupplierM::model()->findByAttributes(array('supplier_id'=>$modPenerimaanBarang->supplier_id,'obatalkes_id'=>$modPenerimaanBarangDetail->obatalkes_id));
			
			$ok = true;
                        
                        if(!empty($oa)){ //RSPMC-1923
                            GFObatAlkesM::model()->updateByPk($oa->obatalkes_id, array('tglkadaluarsa'=>$modPenerimaanBarangDetail->tglkadaluarsa));
                        }
                        
			if (!empty($ObatSupp)){
				
				if ($oa->harganetto != round($modPenerimaanBarangDetail->harganettoper)){				
					$ObatSupp->hargabelikecil = round($modPenerimaanBarangDetail->harganettoper);
					$ObatSupp->hargabelibesar = round($modPenerimaanBarangDetail->harganettoper) * $oa->kemasanbesar;
					$ObatSupp->diskon_persen = $modPenerimaanBarangDetail->persendiscount;
					$ObatSupp->ppn_persen =  $modPenerimaanBarangDetail->persenppn;
					$ok = $ok && $ObatSupp->update();	
				}
			}else{
				$ObatSupp = new GFObatSupplierM;
				$ObatSupp->obatalkes_id = $modPenerimaanBarangDetail->obatalkes_id;
				$ObatSupp->satuanbesar_id = $oa->satuanbesar_id;
				$ObatSupp->satuankecil_id = $oa->satuankecil_id;
				$ObatSupp->supplier_id = $modPenerimaanBarang->supplier_id;
				$ObatSupp->hargabelikecil = round($modPenerimaanBarangDetail->harganettoper);
				$ObatSupp->hargabelibesar = round($modPenerimaanBarangDetail->harganettoper) * $oa->kemasanbesar;
				$ObatSupp->diskon_persen = $modPenerimaanBarangDetail->persendiscount;
				$ObatSupp->ppn_persen =  $modPenerimaanBarangDetail->persenppn;
				$ok = $ok && $ObatSupp->save();						
			}

        } else {
            $this->penerimaanbarangberhasiltersimpan &= false;
        }
        return $modPenerimaanBarangDetail;
    }
    
     /**
     * simpan GFUangMukaBeliT
     * @param type $modUangMuka
     * @param type $modPenerimaanBarang
     * @return \GFUangMukaBeliT
     */
    
    public function simpanUangMuka($modUangMuka,$modPenerimaanBarang){
        $modUangMuka = new GFUangMukaBeliT;
        $modUangMuka->attributes = $_POST['GFUangMukaBeliT'];
        $modUangMuka->supplier_id = $modPenerimaanBarang->supplier_id;
        $modUangMuka->penerimaanbarang_id = $modPenerimaanBarang->penerimaanbarang_id;
        
        if($modUangMuka->validate()) { 
            $modUangMuka->save();
        } else {
            $this->uangmukatersimpan &= false;
        }
        
        return $modUangMuka;
    }
    
    /**
     * simpan GFFakturpembelianT
     * @param type $modFakturPembelian
     * @param type $modPenerimaanBarang
     * @return \GFFakturpembelianT
     */
    
    public function simpanFakturPembelian($modFakturPembelian,$modPenerimaanBarang){
        $format = new MyFormatter;
        $modFakturPembelian = new GFFakturpembelianT;
        $modFakturPembelian->attributes = $_POST['GFFakturpembelianT'];
        $modFakturPembelian->penerimaanbarang_id = $modPenerimaanBarang->penerimaanbarang_id;
        $modFakturPembelian->supplier_id = $modPenerimaanBarang->supplier_id;
        $modFakturPembelian->pajak_id = $modPenerimaanBarang->pajak_id;
        $modFakturPembelian->tglfaktur = $format->formatDateTimeForDb($modFakturPembelian->tglfaktur);
        $modFakturPembelian->tgljatuhtempo = $format->formatDateTimeForDb($modFakturPembelian->tgljatuhtempo);
        $modFakturPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modFakturPembelian->create_time = date('Y-m-d H:i:s');
        $modFakturPembelian->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modFakturPembelian->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modFakturPembelian->pegawai_id = $modPenerimaanBarang->pegawai_id;
        $modFakturPembelian->pegawaimengetahui_id = $modPenerimaanBarang->pegawaimengetahui_id;
        $modFakturPembelian->pegawaimenyetujui_id = $modPenerimaanBarang->pegawaimenyetujui_id;
		
        if($modFakturPembelian->validate()) { 
            $modFakturPembelian->save();
			    $updatePenerimaanBarang = GFPenerimaanBarangT::model()->updateByPk($modFakturPembelian->penerimaanbarang_id, array('tglterimafaktur'=>$modFakturPembelian->tglfaktur, 'fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id));
        } else {
            $this->fakturpembeliantersimpan &= false;
        }
        
        return $modFakturPembelian;
    }
    
    /**
     * simpan GFFakturDetailT
     * @param type $modPenerimaanBarang
     * @param type $post
     * @return \GFPenerimaanDetailT
     */
    public function simpanFakturDetail($modPenerimaanDetail, $modFakturPembelian, $postTerima){
        $format = new MyFormatter();
        $modFakturDetail = new GFFakturDetailT;
        $modFakturDetail->penerimaandetail_id = $modPenerimaanDetail->penerimaandetail_id;
        $modFakturDetail->fakturpembelian_id = $modFakturPembelian->fakturpembelian_id;
        $modFakturDetail->obatalkes_id = $modPenerimaanDetail->obatalkes_id;
        $modFakturDetail->sumberdana_id = $modPenerimaanDetail->sumberdana_id;
        $modFakturDetail->jmlterima = $modPenerimaanDetail->jmlterima;
        $modFakturDetail->harganettofaktur = $modPenerimaanDetail->harganettoper;
        $modFakturDetail->persenppnfaktur = $modPenerimaanDetail->persenppn;
        $modFakturDetail->persenpphfaktur = $modPenerimaanDetail->persenpph;
        $modFakturDetail->persendiscount = $modPenerimaanDetail->persendiscount;
        $modFakturDetail->jmldiscount = $modPenerimaanDetail->jmldiscount;
        $modFakturDetail->hargasatuan = $modPenerimaanDetail->hargasatuanper;
        $modFakturDetail->kemasanbesar = $modPenerimaanDetail->kemasanbesar;
        $modFakturDetail->satuanbesar_id = $modPenerimaanDetail->satuanbesar_id;
        $modFakturDetail->satuankecil_id = $modPenerimaanDetail->satuankecil_id;
        $modFakturDetail->tglkadaluarsa = $format->formatDateTimeForDb($modPenerimaanDetail->tglkadaluarsa);
		
        if($modFakturDetail->validate()) { 
            $modFakturDetail->save();
            $loadObatAlkes = ObatalkesM::model()->findByPk($modFakturDetail->obatalkes_id);
            $harganettolama = $loadObatAlkes->harganetto;
            $hargajuallama = $loadObatAlkes->hargajual;
            $hargaBerubah = false;
            $updateHarganetto = false;
  
            if ($loadObatAlkes->harganetto != $modFakturDetail->harganettofaktur) {
              $hargaBerubah = true;
              if ($postTerima['hppcheck'] > 0) {
                $updateHarganetto = true;
              }
            }
  
            if ($loadObatAlkes->ppn_persen != $modFakturDetail->persenppnfaktur) {
              $loadObatAlkes->ppn_persen = $modFakturDetail->persenppnfaktur;
              $hargaBerubah = true;
            }
  
            if ($loadObatAlkes->discount != $modFakturDetail->jmldiscount) {
              $loadObatAlkes->discount = $modFakturDetail->jmldiscount;
              $hargaBerubah = true;
            }
            if ($hargaBerubah) {
              if ($updateHarganetto) {
                $loadObatAlkes->harganetto = $modFakturDetail->harganettofaktur;
                $judul = 'Perubahan Harga Netto Obat Alkes';
                $isi = $loadObatAlkes->obatalkes_nama;
                CustomFunction::broadcastNotif($judul, $isi, array(
                  array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_GUDANG_FARMASI, 'modul_id' => Params::MODUL_ID_GUDANGFARMASI),
                ));
              }
  
  
              $loadObatAlkes->hpp = round($loadObatAlkes->JumHPP,2);
              $hargajual = round(($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->margin / 100)),2);
              if ($hargajual > $loadObatAlkes->hargamaksimum) {
                $loadObatAlkes->hargamaksimum = $hargajual;
              }
              if ($loadObatAlkes->hargaminimum <= 0 || $hargajual < $loadObatAlkes->hargaminimum) {
                $loadObatAlkes->hargaminimum = $hargajual;
              }
              if ($loadObatAlkes->hargaaverage > 0 && $hargajual > 0) {
                $loadObatAlkes->hargaaverage = round((($loadObatAlkes->hargaaverage + $hargajual) / 2),2);
              } else {
                $loadObatAlkes->hargaaverage = $hargajual;
              }
  
              $loadObatAlkes->hargajual = $hargajual;
              $loadObatAlkes->hjaresep = round(($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->marginresep / 100)),2);
              $loadObatAlkes->hjanonresep = round(($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->marginnonresep / 100)),2);
  
              if ($loadObatAlkes->save()) {
                $modPenerimaan = PenerimaanbarangT::model()->findByPk($modFakturDetail->fakturpembelian->penerimaanbarang_id);
                $ubah = new UbahhargaobatR();
                $ubah->obatalkes_id = $loadObatAlkes->obatalkes_id;
                $ubah->loginpemakai_id = Yii::app()->user->id;
                $ubah->sumberdana_id = $loadObatAlkes->sumberdana_id;
                $ubah->tglperubahan = date('Y-m-d');
                $ubah->alasanperubahan = "Penerimaan Supplier " . $modPenerimaan->supplier->supplier_nama . " - " . $modPenerimaan->noterima;
                $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $ubah->disetujuioleh = $peg->namaLengkap;
                $ubah->create_time = date('Y-m-d H:i:s');
                $ubah->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $ubah->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $ubah->harganettoasal = $harganettolama;
                $ubah->harganettoperubahan = $loadObatAlkes->harganetto;
                $ubah->hargajualasal = $hargajuallama;
                $ubah->hargajualperubahan = $loadObatAlkes->hargajual;
  
                if ($ubah->validate()) {
                  $ubah->save();
                }
              }
            }

            if (Yii::app()->user->getState('isjurnalotomatis') == true) {
              $alkesOa = $modFakturDetail->obatalkes;

              $modJnsOaFaktur = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $alkesOa->jenisobatalkes_id, 'ispenerimaanoa' => true, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));

              if (!empty($modFakturDetail->satuanbesar_id)) {
                $jmlTerima = ($modFakturDetail->jmlterima * $modFakturDetail->kemasanbesar);
              } else {
                $jmlTerima = $modFakturDetail->jmlterima;
              }
              $jmlQty = round(($modPenerimaanDetail->harganettoper * $jmlTerima),2);
              $hargaNettoDiskon = round(($jmlQty - $modFakturDetail->jmldiscount),2);
              $jmlPPn = round(($hargaNettoDiskon * ($modFakturDetail->persenppnfaktur / 100)),2);
              $jmlPPh = round(($hargaNettoDiskon * ($modFakturDetail->persenpphfaktur / 100)),2);
              $jmlAll = round(($hargaNettoDiskon + $jmlPPn - $jmlPPh),2);

              if(!empty($modJnsOaFaktur)){
                $modJurnalRekening = $this->saveJurnalRekeningFaktur($modFakturPembelian, $modFakturDetail);
                $nourutJurnal = 1;
                $rek_d = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $alkesOa->jenisobatalkes_id, 'ispenerimaanoa' => true, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'debitkredit'=>'D'));
                if(!empty($rek_d) && $jmlQty > 0){
                  $this->saveJurnalDetailFaktur($modJurnalRekening, $rek_d->rekening5_id, $jmlQty, 0, $nourutJurnal);
                  $nourutJurnal = ($nourutJurnal + 1);
                }

                $rek_diskon = RekeningcolumnM::model()->findByAttributes(array('table_name'=> Params::REKENINGCOLUMN_TABLE_FAKTURDETAILT,'column_name'=> Params::REKENINGCOLUMN_COLUMN_JMLDISCOUNT,'debitkredit'=>'D'));
                if(!empty($rek_diskon) && $modFakturDetail->jmldiscount > 0){
                  $this->saveJurnalDetailFaktur($modJurnalRekening, $rek_diskon->rekening5_id, $modFakturDetail->jmldiscount, 0, $nourutJurnal);
                  $nourutJurnal = ($nourutJurnal + 1);
                }

                $rekppn = PajakM::model()->findByAttributes(array('isppnmasukan'=>true, 'debitkredit'=>'K'));
                if(!empty($rekppn) && $jmlPPn > 0){
                  $this->saveJurnalDetailFaktur($modJurnalRekening, $rekppn->rekening5_id, 0, $jmlPPn, $nourutJurnal);
                  $nourutJurnal = ($nourutJurnal + 1);
                }

                if(!empty($modFakturPembelian->pajak_id)){
                  $rekpph = PajakM::model()->findByAttributes(array('pajak_id'=>$modFakturPembelian->pajak_id, 'debitkredit'=>'K'));
                  if(!empty($rekpph) && $jmlPPh > 0){
                    $this->saveJurnalDetailFaktur($modJurnalRekening, $rekpph->rekening5_id, 0, $jmlPPh, $nourutJurnal);
                    $nourutJurnal = ($nourutJurnal + 1);
                  }
                }
                
                $rek_k = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $alkesOa->jenisobatalkes_id, 'ispenerimaanoa' => true, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'debitkredit'=>'K'));
                if(!empty($rek_k) && $modFakturDetail->hargasatuan > 0){
                  $this->saveJurnalDetailFaktur($modJurnalRekening, $rek_k->rekening5_id, 0, $modFakturDetail->hargasatuan, $nourutJurnal);
                }
                
              }
            }
        } else {
            $this->fakturpembeliandetailtersimpan &= false;
        }
        return $modFakturDetail;
    }
    
    public function simpanStokObatAlkes($modPenerimaanDetail,$postOa,$modPenerimaanBarang){
        $format = new MyFormatter;
        $modStok = new GFStokObatAlkesT;
        $loadObatAlkes = GFObatAlkesM::model()->findByPk($modPenerimaanDetail->obatalkes_id);
        $modStok->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStok->penerimaandetail_id = $modPenerimaanDetail->penerimaandetail_id;
        $modStok->tglkadaluarsa = !empty($modPenerimaanDetail->tglkadaluarsa) ? $format->formatDateTimeForDb($modPenerimaanDetail->tglkadaluarsa) : null;
        $modStok->obatalkes_id = $modPenerimaanDetail->obatalkes_id;
        $modStok->nobatch = $postOa['nobatch'];
        $modStok->tglstok_in = $modPenerimaanBarang->tglterima;
        $modStok->tglstok_out = NULL;
		
		$harganettolama = $loadObatAlkes->harganetto;
		$hargajuallama = $loadObatAlkes->hargajual;
	$kemasanbsr = 0;
        
        if(!empty($modPenerimaanDetail->satuanbesar_id)){
            if($modPenerimaanDetail->kemasanbesar > 0){
                $kemasanbsr = ($modPenerimaanDetail->jmlterima * $modPenerimaanDetail->kemasanbesar);
            }else{
                $kemasanbsr = $modPenerimaanDetail->jmlterima;
            }
            //if ($modPenerimaanDetail->kemasanbesar < 1) $modPenerimaanDetail->kemasanbesar = 1;
//            $modStok->qtystok_in = $modPenerimaanDetail->jmlterima;
            $modStok->qtystok_in = $kemasanbsr;
            $modStok->harganetto = $modPenerimaanDetail->harganettoper;
        }else{
            $modStok->qtystok_in = $modPenerimaanDetail->jmlterima;
            $modStok->harganetto = $modPenerimaanDetail->harganettoper;
        }       
        
        $modStok->qtystok_out = 0;        
        $modStok->persendiscount = $modPenerimaanDetail->persendiscount;
        $modStok->jmldiscount = $modPenerimaanDetail->jmldiscount;
        $modStok->persenppn = $modPenerimaanDetail->persenppn;
        $modStok->persenpph = $modPenerimaanDetail->persenpph;
        $modStok->persenmargin = $loadObatAlkes->margin;
		
		$jmlmargin = ($modPenerimaanDetail->hargasatuanper) * ($modStok->persenmargin/100);
		$modStok->jmlmargin = round($jmlmargin,2);
		
        //$modStok->jmlmargin = 0;
        $modStok->create_time = date('Y-m-d H:i:s');
        $modStok->update_time = date('Y-m-d H:i:s');
        $modStok->create_loginpemakai_id = Yii::app()->user->id;
        $modStok->update_loginpemakai_id = Yii::app()->user->id;
        $modStok->create_ruangan = Yii::app()->user->ruangan_id;
        $modStok->tglterima = $modPenerimaanDetail->penerimaanbarang->tglterima;
        $modStok->satuankecil_id = (isset($modPenerimaanDetail->satuankecil_id) ? $modPenerimaanDetail->satuankecil_id : $loadObatAlkes->satuankecil_id);
        
        
        if($modStok->validate()) { 
            $modStok->save();
			
				// if ($loadObatAlkes->harganetto != round($modPenerimaanDetail->harganettoper)){
				// 	$loadObatAlkes->tglkadaluarsa = $modStok->tglkadaluarsa;
				// 	$loadObatAlkes->harganetto = $modStok->harganetto;
					
                //     $loadObatAlkes->ppn_persen = $modStok->persenppn;
										
				// 	$loadObatAlkes->hpp = round($loadObatAlkes->JumHPP);
				// 	$loadObatAlkes->kemasanbesar = $modPenerimaanDetail->kemasanbesar;
                    
				// 	$loadObatAlkes->satuanbesar_id = (!empty($modStok->satuanbesar_id) ? $modStok->satuanbesar_id : $loadObatAlkes->satuanbesar_id);
				// 	$loadObatAlkes->nobatch = $postOa['nobatch'];


                //     $hargajual = round($loadObatAlkes->hpp + ($loadObatAlkes->hpp * ($loadObatAlkes->margin/100) ));

				// 	if($hargajual > $loadObatAlkes->hargamaksimum){
				// 		$loadObatAlkes->hargamaksimum = round($hargajual);
				// 	}
				// 	if($loadObatAlkes->hargaminimum <= 0 || round($hargajual) < $loadObatAlkes->hargaminimum){
				// 		$loadObatAlkes->hargaminimum = round($hargajual);
				// 	}
				// 	if($loadObatAlkes->hargaaverage > 0 && round($hargajual) > 0){
				// 		$loadObatAlkes->hargaaverage = round(($loadObatAlkes->hargaaverage + round($hargajual)) / 2);
				// 	}else{
				// 		$loadObatAlkes->hargaaverage = round($hargajual);
				// 	}
					
				// 	$loadObatAlkes->hargajual = round($hargajual);
                //     $loadObatAlkes->hjaresep = round($loadObatAlkes->hpp + ($loadObatAlkes->hpp * ($loadObatAlkes->marginresep/100)));
                //     $loadObatAlkes->hjanonresep = round($loadObatAlkes->hpp + ($loadObatAlkes->hpp * ($loadObatAlkes->marginnonresep/100)));

				// 	if($loadObatAlkes->save()){

				// 		$ubah = new UbahhargaobatR();
				// 		$ubah->obatalkes_id = $loadObatAlkes->obatalkes_id;
				// 		$ubah->loginpemakai_id = Yii::app()->user->id;
				// 		$ubah->sumberdana_id = $loadObatAlkes->sumberdana_id;
				// 		$ubah->tglperubahan = date('Y-m-d');
				// 		$ubah->alasanperubahan = "Penerimaan Supplier ".$modPenerimaanBarang->supplier->supplier_nama." - ".$modPenerimaanBarang->noterima;
				// 		$peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
				// 		$ubah->disetujuioleh = $peg->namaLengkap;					
				// 		$ubah->create_time = date('Y-m-d H:i:s');
				// 		$ubah->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
				// 		$ubah->create_ruangan = Yii::app()->user->getState('ruangan_id');
				// 		$ubah->harganettoasal = $harganettolama;
				// 		$ubah->harganettoperubahan = $loadObatAlkes->harganetto;
				// 		$ubah->hargajualasal = $hargajuallama;
				// 		$ubah->hargajualperubahan = $loadObatAlkes->hargajual;

				// 		if ($ubah->validate()) {
				// 			$this->ubahhargaobatsimpan =  $this->ubahhargaobatsimpan && $ubah->save();
				// 		}else{
				// 			$this->ubahhargaobatsimpan =  false;
				// 		}
						
				// 	}else{
				// 		$this->stokobatalkestersimpan &= false;
				// 	}
				// }
                
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        
        return $modStok;      
    }
    
    public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = GFPegawaiV::model()->findAll($criteria);
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
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = GFPegawaiV::model()->findAll($criteria);
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
    
    /**
    * menampilkan obat
    * @return row table 
    */
    public function actionLoadFormPenerimaanBarang()
    {
        if(Yii::app()->request->isAjaxRequest) { 
          $obatalkes_id = $_POST['obatalkes_id'];
			    $status = $_POST['statusobat'];
          $jumlah = $_POST['jumlah'];
          $supplier_id = $_POST['supplier_id'];
          $tipesatuan = $_POST['tipesatuan'];
          $tgl_kadaluarsa = (isset($_POST['tgl_kadaluarsa']))?$_POST['tgl_kadaluarsa']:null;
          $nobatch = isset($_POST['nobatch']) ? $_POST['nobatch'] : "";
          
          $format = new MyFormatter();
          $modPenerimaanBarang = new GFPenerimaanBarangT();
          $modPenerimaanBarangDetail = new GFPenerimaanDetailT;
			
          $modObatAlkes = GFObatalkesM::model()->findByPk($obatalkes_id);
          if (!empty($supplier_id)){
            $modObatSupplier = GFObatSupplierM::model()->findByAttributes(array('supplier_id'=>$supplier_id, 'obatalkes_id'=>$obatalkes_id));
          }
			
          $jmlKemasan = $modObatAlkes->kemasanbesar;
          $modPenerimaanBarangDetail->jmlpermintaan = 0;
			
          if ($tipesatuan == Params::SATUANOBAT_BESAR){
            $jumlah = round(($jumlah * $jmlKemasan),2);
            $modPenerimaanBarangDetail->jmlterima = $jumlah;
            $modPenerimaanBarangDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
          }else{
            $modPenerimaanBarangDetail->jmlterima = $jumlah;
            $modPenerimaanBarangDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
          }
           $modPenerimaanBarangDetail->jmlterima = MyFormatter::formatNumberForPrint($modPenerimaanBarangDetail->jmlterima,2);
            
          $modPenerimaanBarangDetail->satuanobat = $tipesatuan;
          
          if ($status == 'supplier'){
            $modPenerimaanBarangDetail->harganettoper = $modObatSupplier->hargabelikecil;
          }else{
            $modPenerimaanBarangDetail->harganettoper = $modObatAlkes->harganetto;
          }
          $modPenerimaanBarangDetail->harganettoper = MyFormatter::formatNumberForPrint($modPenerimaanBarangDetail->harganettoper,2);
			
          $modPenerimaanBarangDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
          $modPenerimaanBarangDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
          $modPenerimaanBarangDetail->persenppn = Params::DEFAULT_PPN;
          $modPenerimaanBarangDetail->persenpph = 0;
			    $modPenerimaanBarangDetail->harganettoubah = $modPenerimaanBarangDetail->harganettoper;
          $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($tgl_kadaluarsa) ? $format->formatDateTimeForUser($tgl_kadaluarsa) : null);
          $modPenerimaanBarangDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
            
			    $modPenerimaanBarangDetail->satuankecil_nama = $modObatAlkes->satuanKecil;            
          $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($tgl_kadaluarsa) ? $format->formatDateTimeForDb($tgl_kadaluarsa) :"");         
          $modPenerimaanBarangDetail->nobatch = (isset($modObatAlkes->nobatch) ? $modObatAlkes->nobatch : (isset($nobatch) ? $nobatch : ""));         

          echo CJSON::encode(array(
              'status'=>'create_form', 
              'form'=>$this->renderPartial($this->path_view.'_rowObatPenerimaanBarang', array(
                      'modPenerimaanBarang'=>$modPenerimaanBarang,
                      'modPenerimaanBarangDetail'=>$modPenerimaanBarangDetail,
                      'format'=>$format
                  ), 
              true))
          );
          exit;  
        }
    }
    
    /**
     * untuk print data penerimaan barang farmasi
     */
    public function actionPrint($penerimaanbarang_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPenerimaanBarang = GFPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);     
        $modPenerimaanBarangDetail = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
        $modFakturPembelian = GFFakturpembelianT::model()->findByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));

        if(empty($modFakturPembelian)){
          $modFakturPembelian = new GFFakturpembelianT();
        }
        
        $judul_print = 'DATA PENERIMAAN OBAT DAN ALAT KESEHATAN';
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
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPenerimaanBarang'=>$modPenerimaanBarang,
                'modPenerimaanBarangDetail'=>$modPenerimaanBarangDetail,
                'modFakturPembelian'=>$modFakturPembelian,
                'caraPrint'=>$caraPrint
        ));
    } 
    
    public function actionAutocompleteObatAlkes()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'obatalkes_nama';
            $criteria->limit = 5;
            $models = GFObatAlkesM::model()->findAll($criteria);
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
	
	public function actionReturPembelianOA($penerimaanbarang_id)
	{
        Yii::import('application.modules.keuangan.models.KURekeningakuntansiV');
        Yii::import('application.modules.keuangan.models.KUPenerimaanUmumT');
        
		$format = new MyFormatter;
		$modPembelian = new GFReturPembelianT;
		$modPenerimaan = GFPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);
		//$modPenerimaanDet = GFPenerimaanDetailT::model()->findAll('penerimaanbarang_id ='.$penerimaanbarang_id);
		$modFakturBeli = GFFakturpembelianT::model()->findByPk($modPenerimaan->fakturpembelian_id);
		$modPenerimaanDet = GFFakturDetailT::model()->findAll('fakturpembelian_id ='.$modFakturBeli->fakturpembelian_id);
		$modPembelianDet = array();
		$modStokObat = array();
		$sukses = false;
        $modTandabukti = new TandabuktibayarT;
        $modTandabukti->nobuktibayar = "-- Otomatis --";
        $modTandabukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
        $modPenUmum = new KUPenerimaanUmumT;
		
		$modPembelian->ruangan_id = $modPenerimaan->create_ruangan;
		$modPembelian->supplier_id = $modPenerimaan->supplier_id;
		
		$modFakturPembelian = GFFakturpembelianT::model()->findByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
        
        
        $supplier = SupplierM::model()->findByPk($modPembelian->supplier_id);
        
        if (!empty($supplier)) {
            $modTandabukti->darinama_bkm = $supplier->supplier_nama;
            $modTandabukti->alamat_bkm = $supplier->supplier_alamat;
        }
        $modTandabukti->sebagaipembayaran_bkm = "RETUR PEMBELIAN FARMASI - ".$modFakturBeli->nofaktur;


		if (isset($_POST['GFReturPembelianT'])){
			$transaction = Yii::app()->db->beginTransaction();
            try {
			// insert tabel returpembelian_t
			$modPembelian->attributes = $_POST['GFReturPembelianT'];
			$modPembelian->penerimaanbarang_id = $_POST['GFPenerimaanBarangT']['penerimaanbarang_id'];
			$modPembelian->fakturpembelian_id = $_POST['GFPenerimaanBarangT']['fakturpembelian_id'];
			$modPembelian->totalretur = $_POST['GFReturPembelianT']['totalretur'];
			$modPembelian->noretur = MyGenerator::noRetur();
			$modPembelian->tglretur = date("Y-m-d H:i:s");
			$modPembelian->create_time = date("Y-m-d");
			$modPembelian->create_loginpemakai_id = Yii::app()->user->id;
			$modPembelian->create_ruangan = Yii::app()->user->getState('ruangan_id');
				if ($modPembelian->save()){
					$this->returpembeliantersimpan = true;
					
					
					if (isset($_POST['GFReturDetailT'])){
						$returdet = $_POST['GFReturDetailT'];
						if (count((array)$returdet) > 0){
							// insert tabel returdetail_t
							foreach($returdet as $i => $det){
								if (($det['jmlretur'] > 0 ) && ($det['isRetur'] == true)){
								$modPembelianDet[$i] = new GFReturDetailT;
								$modPembelianDet[$i]->penerimaandetail_id = $det['penerimaandetail_id'];
								$modPembelianDet[$i]->obatalkes_id = $det['obatalkes_id'];
								$modPembelianDet[$i]->satuanbesar_id = $det['satuanbesar_id'];
								$modPembelianDet[$i]->fakturdetail_id = $det['fakturdetail_id'];
								$modPembelianDet[$i]->sumberdana_id = $det['sumberdana_id'];
								$modPembelianDet[$i]->returpembelian_id = $modPembelian->returpembelian_id;
								$modPembelianDet[$i]->satuankecil_id = $det['satuankecil_id'];
								$modPembelianDet[$i]->jmlretur = $det['jmlretur'];
								$modPembelianDet[$i]->harganettoretur = $det['harganettoretur'];
								$modPembelianDet[$i]->hargappnretur = $det['hargappnretur'];
								$modPembelianDet[$i]->hargapphretur = $det['hargapphretur'];
								$modPembelianDet[$i]->jmldiscount = $det['jmldiscount'];
								$modPembelianDet[$i]->hargasatuanretur = MyFormatter::formatRupiahForDB($det['hargasatuanretur']);
									// update tabel penerimaandetail_t	(returdetail_id)

									if ($modPembelianDet[$i]->save()){		
										$update  = GFPenerimaanDetailT::model()->findByPk($modPembelianDet[$i]->penerimaandetail_id);										
										$update->returdetail_id = $modPembelianDet[$i]->returdetail_id;
										
										if($update->update()){
											$update  = GFFakturDetailT::model()->findByPk($modPembelianDet[$i]->fakturdetail_id);
											/** retur tidak mengubah quantiti retur **/
											
											//$update->jmlterima = $update->jmlterima - $modPembelianDet[$i]->jmlretur; 
											$update->returdetail_id = $modPembelianDet[$i]->returdetail_id;
											

                                            
											if ($update->update()){
												$this->simpanStokObatAlkesOut($modPembelianDet[$i],$modPembelianDet[$i]->returdetail_id, $update);
												$this->returpembeliandetailtersimpan = true;
											}else{
												$this->returpembeliandetailtersimpan = false;
											}
										}else{
											$this->returpembeliandetailtersimpan = false;
										}																				
										
									}else{
										$this->returpembeliandetailtersimpan = false;
									}
									
								}
                                
							}
						}
					}
					
				}else{
					$this->returpembeliantersimpan = false;
				}
                
                
//                $modTandaBukti = $this->saveTandaBukti($_POST['TandabuktibayarT']);
//				$modPenUmum = $this->savePenerimaan($_POST['KUPenerimaanUmumT'], $modTandaBukti, $modPembelian);
                
//                if(isset($_POST['RekeningakuntansiV'])) {
//                
//                    $modJurnalRekening = $this->saveJurnalRekening($modPenUmum, $modPembelian, $modFakturBeli);
//                    $modJurnalDetail = $this->saveJurnalDetail(
//                        $_POST['KUPenerimaanUmumT'],
//                        $modJurnalRekening,
//                        null,
//                        // $modJurnalPosting,
//                        $_POST['RekeningakuntansiV']
//                    );
//                
//                } else {
//                    if (!empty($modPembelian->returpembelian_id)) {
//                        $res = Yii::app()->db
//                            ->createCommand("select set_afterreturfarmasi_fix(".$modPembelian->returpembelian_id.") as simpan")
//                            ->queryRow();
//
//                        if (count((array)$res) != 0) {
//                            $this->returpembeliantersimpan = $this->returpembeliantersimpan && $res['simpan'];
//                        }
//
//                    }
//                }
				
				
                if($this->returpembeliantersimpan && $this->returpembeliandetailtersimpan){                    
                    if(Yii::app()->user->getState('isjurnalotomatis') == true){
                        $checkDatadetail = 0;
                        $modDetailTerima= ReturdetailT::model()->findAllByAttributes(array('returpembelian_id'=>$modPembelian->returpembelian_id));

                     if(count((array)$modDetailTerima)>0){
                         foreach ($modDetailTerima as $dtFakturDetail){
                             $modTerimDtl = PenerimaandetailT::model()->findByPk($dtFakturDetail->penerimaandetail_id);
                             $modBarangM = ObatalkesM::model()->findByPk($modTerimDtl->obatalkes_id);

                              if(isset($modBarangM)){
                                  if(!empty($modBarangM->jenisobatalkes_id)){
                                      $modJenisbarangRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modBarangM->jenisobatalkes_id, 'isreturpembelian'=>true));

                                      if(count((array)$modJenisbarangRek)>0){
                                           $checkDatadetail++;
                                       }else{
                                           if($checkDatadetail > 1){
                                               $checkDatadetail--;
                                           }
                                       }
                                  }
                              }
                         }
                     }

                     if($checkDatadetail > 0){
                           foreach ($modDetailTerima as $dtFakturDetail){
                               $modTerimDtl = PenerimaandetailT::model()->findByPk($dtFakturDetail->penerimaandetail_id);
                               $modBarangM = ObatalkesM::model()->findByPk($modTerimDtl->obatalkes_id);
                               if(isset($modBarangM)){
                                   if(!empty($modBarangM->jenisobatalkes_id)){
                                      $modJenisbarangRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modBarangM->jenisobatalkes_id, 'isreturpembelian'=>true));

                                      if(count((array)$modJenisbarangRek) >0){
                                           $modJurnalRekening = $this->saveJurnalRekeningRetur($modPembelian, $dtFakturDetail);
                                           foreach ($modJenisbarangRek as $dtjnsbarangrek){
                                               $this->saveJurnalDetailRetur($modJurnalRekening, $dtFakturDetail, $dtjnsbarangrek);
                                           }
                                           if($dtFakturDetail->hargappnretur > 0){
                                               $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '".Params::REKENINGCOLUMN_TABLE_RETURDETAILT."' AND column_name = '".Params::REKENINGCOLUMN_COLUMN_HARGAPPNRETUR."'");
                                               if(isset($rekeningcolumn)){
                                                   $this->saveJurnalDetailRetur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn,true);
                                               }
                                           }

                                           if($dtFakturDetail->hargapphretur > 0){
                                               $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '".Params::REKENINGCOLUMN_TABLE_RETURDETAILT."' AND column_name = '".Params::REKENINGCOLUMN_COLUMN_HARGAPPHRETUR."'");
                                               if(isset($rekeningcolumn)){
                                                   $this->saveJurnalDetailRetur($modJurnalRekening, $dtFakturDetail, $rekeningcolumn,null,true);
                                               }
                                           }
                                       }
                                   }
                               }
                           }
                       }
                   }
                                       
                    $modPenerimaan->returpembelian_id = $modPembelian->returpembelian_id;
                    $modPenerimaan->save();
					
                    $transaction->commit();
                    $modPembelian->isNewRecord = FALSE;
                    $this->redirect(array('returPembelianOA','penerimaanbarang_id'=>$penerimaanbarang_id,'returpembelian_id'=>$modPembelian->returpembelian_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Pembelian gagal diretur ! (err2)");
                }
				
			} catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Pembelian gagal diretur ! (err1)".MyExceptionMessage::getMessage($e,true));
            }
		}
			
		$this->render('formReturPembelian',array(
			'modPenerimaan'=>$modPenerimaan,
			'modPenerimaanDet'=>$modPenerimaanDet,
			'modPembelian'=>$modPembelian,
			'format'=>$format,
			'modFakturPembelian' => $modFakturPembelian,
            'modTandabukti' => $modTandabukti,
            'modPenUmum' => $modPenUmum,
		));
	}
	
	protected function simpanStokObatAlkesOut($stokObatAlkes,$returdetail_id, $penerimaandetail){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByAttributes(array('obatalkes_id'=>$stokObatAlkes->obatalkes_id));
        $oa = ObatalkesM::model()->findByPk($stokObatAlkes->obatalkes_id);
        
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->attributes = $oa->attributes;
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->returdetail_id = $returdetail_id;
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $stokObatAlkes->jmlretur;
		$modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
		$modStokOaNew->tglstok_in = NULL;
		
        
        //if (!empty($penerimaandetail->satuanbesar_id)) {
        //    $modStokOaNew->qtystok_out *= $penerimaandetail->kemasanbesar;
        //}
        
        // $modStokOaNew->stokobatalkesasal_id = $modStokOa->stokobatalkes_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
		$modStokOaNew->persenppn = $oa->ppn_persen;
		$modStokOaNew->persenmargin = $oa->margin;
        
        
        if($modStokOaNew->validate()){ 
            $modStokOaNew->save();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }       
	
	/**
	* @author M Iqbal Laksana
	* @category fungsi
	* @return show data
	* - digunakan untuk menampikan kembali inputan yang telah dilakukan
	*/
	public function actionVerifikasi()
	{
            if (Yii::app()->request->isAjaxRequest){
				$ok = 1;
				$msg = '';
				
                $this->layout = '//layouts/iframe';
				
				$model = new GFPenerimaanBarangT;
				$modFaktur = new GFFakturpembelianT;
				
                if(isset($_POST['GFPenerimaanBarangT'])){
                    $model->attributes = $_POST['GFPenerimaanBarangT'];
                    $model->jumlahuang = (isset($_POST['GFPenerimaanBarangT']['jumlahuang'])?$_POST['GFPenerimaanBarangT']['jumlahuang']:0);
//					$model->is_langsungfaktur = $_POST['GFPenerimaanBarangT']['is_langsungfaktur'];
                }
				
                /*
                // RSPMC-2133 FAKTUR DI NONAKTIFKAN
				if(isset($_POST['GFFakturpembelianT'])){
                    $modFaktur->attributes = $_POST['GFFakturpembelianT'];
                }
                 * 
                 */
								
				
                echo CJSON::encode(array(
					'ok'=>$ok,
					'msg'=>$msg,
                    'content'=>$this->renderPartial('verifikasi',array(
                        'model'=>$model,
                        'modDet'=>$_POST['GFPenerimaanDetailT'],
						'modFaktur'=>$modFaktur
                ), true)));
                Yii::app()->end();
            }
	}
    
    
    
    /**
     * Dupliasi fungsi dari keuangan.penerimaanUmum
     */
    protected function saveTandaBukti($postTandaBukti)
	{
		$format = new MyFormatter();
		$modTandaBukti = new TandabuktibayarT;
		$modTandaBukti->attributes = $postTandaBukti;
		$modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
		$modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
		$modTandaBukti->shift_id = Yii::app()->user->getState('shift_id');
		$modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($postTandaBukti['tglbuktibayar']);
		$modTandaBukti->create_time = date('Y-m-d H:i:s');
        $modTandaBukti->jmlpembulatan = 0;
		$modTandaBukti->create_loginpemakai_id = Yii::app()->user->id;
		$modTandaBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');
		if($modTandaBukti->validate()){
			$modTandaBukti->save();
			$this->returpembeliantersimpan = true;
		} else {
			$this->returpembeliantersimpan = false;
			throw new CDbException("Data tanda bukti bayar belum lengkap");
		}
        
		return $modTandaBukti;
	}
        
	protected function savePenerimaan($postPenerimaan,$modTandaBukti, $modPembelian)
	{

		$modPenUmum = new KUPenerimaanUmumT;
		$modPenUmum->attributes = $postPenerimaan;
        $modPenUmum->tglpenerimaan = $modTandaBukti->tglbuktibayar;
        $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
        $modPenUmum->volume = 1;
        $modPenUmum->satuanvol = 'KALI';
        $modPenUmum->hargasatuan = $modTandaBukti->jmlpembayaran;
        $modPenUmum->totalharga = $modPenUmum->volume * $modPenUmum->hargasatuan;
		$modPenUmum->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modPenUmum->penjamin_id = Params::PENJAMIN_ID_UMUM;
		$modPenUmum->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
        $modPenUmum->returpembelian_id = $modPembelian->returpembelian_id;
        $modPenUmum->keterangan_penerimaan = $modTandaBukti->sebagaipembayaran_bkm;

		if($modPenUmum->validate()){
			$modPenUmum->save();
			$this->returpembeliantersimpan = true;
		} else {
			$this->returpembeliantersimpan = false;
			throw new CDbException("Data penerimaan belum lengkap");
		}
        
        
		return $modPenUmum;
	}
    
    protected function saveJurnalRekening($modPenUmum, $modPembelian, $modFakturBeli)
	{
        
                $period = Yii::app()->user->getState('periode_ids');
                if (is_array($period)) {
                    $period = $period[0];
                }
            
		$modJurnalRekening = new JurnalrekeningT;
		$modJurnalRekening->tglbuktijurnal = $modPenUmum->tglpenerimaan;
		$modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modPenUmum->tglpenerimaan, 'JTK');
		$modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
		$modJurnalRekening->noreferensi = $modPenUmum->nopenerimaan;
		$modJurnalRekening->tglreferensi = $modPenUmum->tglpenerimaan;
		$modJurnalRekening->nobku = "";
		$modJurnalRekening->urianjurnal = 'Retur Pembelian barang - '.$modFakturBeli->nofaktur;
		$modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
		$modJurnalRekening->rekperiod_id = $period;
		$modJurnalRekening->create_time = $modPenUmum->tglpenerimaan;
		$modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
		$modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modJurnalRekening->returpembelian_id = $modPembelian->returpembelian_id;
        
        
		if($modJurnalRekening->validate()){
			$modJurnalRekening->save();
			$this->returpembeliantersimpan = true;
		} else {
			$this->returpembeliantersimpan = false;
			throw new CDbException("Data jurnal rekening belum lengkap");
		}
		return $modJurnalRekening;
        
	}
    
    
    protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null, $rekeningakuntansi = null)
	{

		$valid = true;
		foreach($rekeningakuntansi as $i=>$data){

			$model = new JurnaldetailT();
			// $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
			$model->rekperiod_id = $modJurnalRekening->rekperiod_id;
			$model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
//                $model[$i]->uraiantransaksi = $arrJurnal['jenisKodeNama'];
			$model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
			$model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit']:0;
			$model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit']:0;
			$model->nourut = $i+1;
			$model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
			$model->catatan = "";

			if($model->validate())
			{
				$model->save();
			}else{
				$valid = false;
				throw new CDbException("Data jurnal rekening detail belum lengkap");
				break;
			}    

		}
        
        // die;

		$this->returpembeliantersimpan = $valid;
	}
	
        
        protected function saveJurnalRekeningFaktur($modPenUmum, $dtFakturDetail)
        { 
          $period = Yii::app()->user->getState('periode_ids');
          if (is_array($period)) {
            $period = $period[0];
          }

          $format = new MyFormatter();
          $modJurnalRekening = new JurnalrekeningT;
          $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_HUTANG;
          $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modPenUmum->tglfaktur);
          $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
          $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
          $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
          $modJurnalRekening->noreferensi = $modPenUmum->nofaktur;
          $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modPenUmum->tglfaktur);
          $modJurnalRekening->nobku = "";
          $modJurnalRekening->urianjurnal = 'Faktur Pembelian ' . (!empty($dtFakturDetail->obatalkes->jenisobatalkes_id) ? $dtFakturDetail->obatalkes->jenisobatalkes->jenisobatalkes_nama : "") . " " . $dtFakturDetail->obatalkes->obatalkes_nama . " - " . $modPenUmum->supplier->supplier_nama . " - " . $modPenUmum->nofaktur;

          $periodeID = $period;
          $modJurnalRekening->rekperiod_id = $periodeID;
          $modJurnalRekening->create_time = date('Y-m-d H:i:s');
          $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
          $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modJurnalRekening->ruangan_id = $modPenUmum->ruangan_id;
          $modJurnalRekening->fakturpembelian_id = $modPenUmum->fakturpembelian_id;

          if ($modJurnalRekening->validate()) {
            $modJurnalRekening->save();
            $this->succesSave = true;
          } else {
            $this->succesSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
          }
          
            $period = Yii::app()->user->getState('periode_ids');
            if (is_array($period)) {
                $period = $period[0];
            }
            return $modJurnalRekening;
        }

        public function saveJurnalDetailFaktur($modJurnalRekening, $rekening5_id, $saldodebit, $saldokredit, $nourut){
            $valid = true;
            $modelJurnalDetail = new JurnaldetailT();
            $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
            $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
            $modelJurnalDetail->rekening5_id = $rekening5_id;
            $modelJurnalDetail->nourut = $nourut;
            $modelJurnalDetail->saldodebit = $saldodebit;
            $modelJurnalDetail->saldokredit = $saldokredit;

            if($modelJurnalDetail->validate()){
                $modelJurnalDetail->save();
            }else{
//                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
                $valid = false;
            }
            
            return $valid;         
        }    
        
        
    protected function saveJurnalRekeningRetur($model, $dtDetail)
    {
        $obatalkes = ObatalkesM::model()->findByPk($dtDetail->obatalkes_id);
        $supplierM = SupplierM::model()->findByPk($model->supplier_id);
        
        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }

        $format = new MyFormatter();
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_HUTANG;
        $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglretur);
        $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $model->noretur;
        $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglretur);
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = 'Retur Penerimaan '. (!empty($obatalkes->jenisobatalkes_id)?$obatalkes->jenisobatalkes->jenisobatalkes_nama:"") ." " .$obatalkes->obatalkes_nama ." - ". $supplierM->supplier_nama  ." - ". $model->noretur;

        $periodeID = $period;
        $modJurnalRekening->rekperiod_id = $periodeID;
        $modJurnalRekening->create_time = $format->formatDateTimeForDB($model->tglretur);
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->ruangan_id = $model->create_ruangan;
        $modJurnalRekening->returpembelian_id = $model->returpembelian_id;

        if($modJurnalRekening->validate()){
            $modJurnalRekening->save();
            $this->successSave = true;
        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
        }
        return $modJurnalRekening;
    }

    public function saveJurnalDetailRetur($modJurnalRekening, $postRekenings, $modelRek, $isPPN=null, $ispph = null){
        $valid = true;
//        $modJurnalPosting = null;
        
        if (empty($modelRek)) {
            return true;
        }
        
        $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
        $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
        $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
        $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);
        
//        if(Yii::app()->user->getState('ispostingotomatis'))
//        {
//            $modJurnalPosting = new JurnalpostingT;
//            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
//            $modJurnalPosting->keterangan = "Posting automatis";
//            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
//            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
//            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
//            if($modJurnalPosting->validate()){
//                $modJurnalPosting->save();
//            }
//        }

        $modelJurnalDetail = new JurnaldetailT();
//        $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
        $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
        $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
        $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
        $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
        $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
        $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
        
        $totalHasilQty = ($postRekenings->harganettoretur * $postRekenings->jmlretur); 
        $diskonHarga = $postRekenings->jmldiscount;
        $totalNetto = ($totalHasilQty - $diskonHarga);
        $ppnHarga = $postRekenings->hargappnretur;
        $pphHarga = $postRekenings->hargapphretur;
        $totalAll = $totalNetto + $ppnHarga + $pphHarga;
        
        if($modelRek->debitkredit == 'K'){
            if(!empty($isPPN)){
                $modelJurnalDetail->nourut = 3;
                $modelJurnalDetail->saldokredit = $ppnHarga;
            } 
             if(!empty($ispph)){
                $modelJurnalDetail->nourut = 4;
                $modelJurnalDetail->saldokredit = $pphHarga;
            } 
            
            if(empty($isPPN) && empty($ispph)){
                 $modelJurnalDetail->nourut = 2;
                 $modelJurnalDetail->saldokredit = $totalNetto;
            }
              $modelJurnalDetail->saldodebit = 0;
        }else if($modelRek->debitkredit == 'D'){
            if(empty($isPPN) && empty($ispph)){
                $modelJurnalDetail->nourut = 1;
                $modelJurnalDetail->saldodebit = $totalAll;
            }
            
             $modelJurnalDetail->saldokredit = 0;
        }

        if($modelJurnalDetail->validate()){
                $modelJurnalDetail->save();
            }else{
//                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
                $valid = false;
            }

        return $valid;        
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

  protected function saveJurnalRekeningPenerimaan($model, $modOa)
  {
    $ruangan = RuanganM::model()->findByPk($model->create_ruangan);
    
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglterima);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->noterima;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglterima);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Penerimaan Pembelian ' . $ruangan->ruangan_nama.' - '. (!empty($modOa->jenisobatalkes) ? $modOa->jenisobatalkes->jenisobatalkes_nama : "") . " " . $modOa->obatalkes_nama . " - " . $model->noterima;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->penerimaanbarang_id = $model->penerimaanbarang_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetailPenerimaan($modJurnalRekening, $rekening5_id, $saldo, $saldo_normal, $nourut)
  {
    $valid = true;

    $modelJurnalDetail = new JurnaldetailT();
    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $rekening5_id;

    if ($saldo_normal == 'K') {
      $modelJurnalDetail->saldodebit = 0;
      $modelJurnalDetail->saldokredit = $saldo;
    }else{
      $modelJurnalDetail->saldodebit = $saldo;
      $modelJurnalDetail->saldokredit = 0;
    }
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
    $modelJurnalDetail->nourut = $nourut;


    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }
}