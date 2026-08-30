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

    public function actionIndex($penerimaanbarang_id = null, $permintaanpembelian_id = null){
        $format = new MyFormatter();
        $modUangMuka = new ADUangMukaBeliT;
        $modPenerimaanBarang = new ADPenerimaanBarangT;
        $modPermintaanPembelian=  new ADPermintaanPembelianT;
        $modFakturPembelian = new ADFakturpembelianT;
        $modDetails = array();
        
        $modPenerimaanBarang->tglterima = date('Y-m-d H:i:s');
        $modPenerimaanBarang->tglsuratjalan = date('Y-m-d H:i:s');        
        
        $modFakturPembelian->biayamaterai = 0;        
        $modFakturPembelian->tglfaktur = date('Y-m-d H:i:s');
        $modFakturPembelian->tgljatuhtempo = date('Y-m-d H:i:s');
        
        $modPenerimaanBarang->tglkadaluarsa = date('Y-m-d H:i:s');
        
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

        if (isset($permintaanpembelian_id) && (empty($penerimaanbarang_id))) {
            $modPermintaanPembelian = ADPermintaanPembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id, 'penerimaanbarang_id' => null));
            if (!empty($modPermintaanPembelian)) {
                $modPenerimaanBarang->supplier_id = $modPermintaanPembelian->supplier_id;
                $modPenerimaanBarang->permintaanpembelian_id = $modPermintaanPembelian->permintaanpembelian_id;
                $modPermintaanDetail = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $modPermintaanPembelian->permintaanpembelian_id));				
                if (count($modPermintaanDetail) > 0) {
                    foreach ($modPermintaanDetail as $i => $detail) {						
                        $modDetails[$i] = new ADPenerimaanDetailT;
                        $modDetails[$i]->attributes = $detail->attributes;
                        $modDetails[$i]->jmlterima = $detail->jmlpermintaan;
                        $modDetails[$i]->jmlpermintaan = $detail->jmlpermintaan;
                    }
                }
            }
        }
       
        if(!empty($penerimaanbarang_id)){
            $modPenerimaanBarang= ADPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);
            $modPenerimaanBarang->pegawaimengetahui_nama = !empty($modPenerimaanBarang->pegawaimengetahui->NamaLengkap) ? $modPenerimaanBarang->pegawaimengetahui->NamaLengkap : "";
            $modPenerimaanBarang->pegawaimenyetujui_nama = !empty($modPenerimaanBarang->pegawaimenyetujui->NamaLengkap) ? $modPenerimaanBarang->pegawaimenyetujui->NamaLengkap : "";
            
            $modDetails = ADPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$modPenerimaanBarang->penerimaanbarang_id));        
            
            $modUangMuka = ADUangMukaBeliT::model()->findByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
            if(!empty($modUangMuka)){
                $modPenerimaanBarang->is_uangmuka = 1;            
            }else{
                $modUangMuka = new ADUangMukaBeliT;
            }
            
            $modFakturPembelian = ADFakturpembelianT::model()->findByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
            if(!empty($modFakturPembelian)){
                $modPenerimaanBarang->is_langsungfaktur = 1;            
            }else{
                $modFakturPembelian = new ADFakturpembelianT;
            }
        }
        
        if (isset($_POST['ADPenerimaanBarangT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
				
                    $modPenerimaanBarang->attributes=$_POST['ADPenerimaanBarangT'];
                    $modPenerimaanBarang->noterima = MyGenerator::noTerimaBarang();
                    $modPenerimaanBarang->pegawai_id = Yii::app()->user->getState('pegawai_id');
                    $modPenerimaanBarang->tglterima=$format->formatDateTimeForDb($_POST['ADPenerimaanBarangT']['tglterima']);
                    $modPenerimaanBarang->tglsuratjalan=$format->formatDateTimeForDb($_POST['ADPenerimaanBarangT']['tglsuratjalan']);
                    $modPenerimaanBarang->create_time = date('Y-m-d H:i:s');
                    $modPenerimaanBarang->update_time = date('Y-m-d H:i:s');
                    $modPenerimaanBarang->create_loginpemakai_id = Yii::app()->user->id;
                    $modPenerimaanBarang->update_loginpemakai_id = Yii::app()->user->id;
                    $modPenerimaanBarang->create_ruangan = Yii::app()->user->ruangan_id;
                    
                if($modPenerimaanBarang->save()){ 
                    if (isset($_POST['ADPenerimaanBarangT']['is_uangmuka'])){ 
                        if ($_POST['ADPenerimaanBarangT']['is_uangmuka'] == '1') {//Jika Uang Muka Dipilih
                            $this->simpanUangMuka($modUangMuka,$modPenerimaanBarang);
                        }
                    }
                    if (isset($_POST['ADPenerimaanBarangT']['is_langsungfaktur'])){ 
                        if ($_POST['ADPenerimaanBarangT']['is_langsungfaktur'] == '1') {
                            $modFakturPembelian = $this->simpanFakturPembelian($modFakturPembelian,$modPenerimaanBarang);
                        }
                    }
                    $modPenerimaanBarang->fakturpembelian_id = $modFakturPembelian->fakturpembelian_id;
                    $modPenerimaanBarang->save();
                    if(count($_POST['ADPenerimaanDetailT']) > 0){
                       foreach($_POST['ADPenerimaanDetailT'] AS $i => $postOa){ 
                           $modDetails[$i] = $this->simpanPenerimaanBarangDetail($modPenerimaanBarang,$postOa); 
                           $this->simpanStokObatAlkes($modDetails[$i],$postOa,$modPenerimaanBarang);
                           if (isset($_POST['ADPenerimaanBarangT']['is_langsungfaktur'])){ 
                                if ($_POST['ADPenerimaanBarangT']['is_langsungfaktur'] == '1') {//Jika Uang Muka Dipilih
                                    $this->simpanFakturDetail($modDetails[$i],$modFakturPembelian);
                                }
                            } 
                       }
                    }
                    $updatePermintaanPembelian = ADPermintaanPembelianT::model()->updateByPk($modPenerimaanBarang->permintaanpembelian_id, array('penerimaanbarang_id'=>$modPenerimaanBarang->penerimaanbarang_id));
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
                    $transaction->commit();
                    $modPenerimaanBarang->isNewRecord = FALSE;
                    $this->redirect(array('index','penerimaanbarang_id'=>$modPenerimaanBarang->penerimaanbarang_id,'smscp1'=>$smscp1,'smscp2'=>$smscp2,'sukses'=>1));
                }else{
//                    echo "-".$this->penerimaanbarangberhasiltersimpan."<br/>";
//                    echo "-".$this->stokobatalkestersimpan."<br/>";
//                    echo "-".$this->uangmukatersimpan."<br/>";
//                    echo "-".$this->fakturpembeliantersimpan."<br/>";
//                    echo "-".$this->fakturpembeliandetailtersimpan."<br/>";exit;
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
     * simpan ADPenerimaanDetailT
     * @param type $modPenerimaanBarang
     * @param type $post
     * @return \ADPenerimaanDetailT
     */
    public function simpanPenerimaanBarangDetail($modPenerimaanBarang ,$post){
        $format = new MyFormatter();
        $modPenerimaanBarangDetail = new ADPenerimaanDetailT;
        $modPenerimaanBarangDetail->attributes = $post;
        $modPenerimaanBarangDetail->penerimaanbarang_id = $modPenerimaanBarang->penerimaanbarang_id; //fake id
        $modPenerimaanBarangDetail->tglkadaluarsa = $format->formatDateTimeForDb($post['tglkadaluarsa']);
        if(empty($modPenerimaanBarangDetail->tglkadaluarsa)){
            $modPenerimaanBarangDetail->tglkadaluarsa = date('Y-m-d H:i:s',strtotime("+2 years"));
        }
        $modPenerimaanBarangDetail->persenppn = 0;
        $modPenerimaanBarangDetail->persenpph = 0;
        $modPenerimaanBarangDetail->hargasatuanper = 0;
        $modPenerimaanBarangDetail->jmlterima = $post['jmlpermintaan'];
        $modPenerimaanBarangDetail->nobatch = $post['nobatch'];
        $modPenerimaanBarangDetail->biaya_lainlain = 0;
        $modPenerimaanBarangDetail->fakturdetail_id = NULL;
        $modPenerimaanBarangDetail->returdetail_id = NULL;
        $modPenerimaanBarangDetail->stokobatalkes_id = NULL;
        
        if($post['satuanobat'] == PARAMS::SATUAN_KECIL){
            $modPenerimaanBarangDetail->satuanbesar_id = NULL;
        }else{
            $modPenerimaanBarangDetail->satuankecil_id = NULL;
        }
        if($modPenerimaanBarangDetail->validate()) { 
            $modPenerimaanBarangDetail->save();
        } else {
            $this->penerimaanbarangberhasiltersimpan &= false;
        }
        return $modPenerimaanBarangDetail;
    }
    
     /**
     * simpan ADUangMukaBeliT
     * @param type $modUangMuka
     * @param type $modPenerimaanBarang
     * @return \ADUangMukaBeliT
     */
    
    public function simpanUangMuka($modUangMuka,$modPenerimaanBarang){
        $modUangMuka = new ADUangMukaBeliT;
        $modUangMuka->attributes = $_POST['ADUangMukaBeliT'];
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
     * simpan ADFakturpembelianT
     * @param type $modFakturPembelian
     * @param type $modPenerimaanBarang
     * @return \ADFakturpembelianT
     */
    
    public function simpanFakturPembelian($modFakturPembelian,$modPenerimaanBarang){
        $format = new MyFormatter;
        $modFakturPembelian = new ADFakturpembelianT;
        $modFakturPembelian->attributes = $_POST['ADFakturpembelianT'];
        $modFakturPembelian->penerimaanbarang_id = $modPenerimaanBarang->penerimaanbarang_id;
        $modFakturPembelian->supplier_id = $modPenerimaanBarang->supplier_id;
        $modFakturPembelian->tglfaktur = $format->formatDateTimeForDb($modFakturPembelian->tglfaktur);
        $modFakturPembelian->tgljatuhtempo = $format->formatDateTimeForDb($modFakturPembelian->tgljatuhtempo);
        $modFakturPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if($modFakturPembelian->validate()) { 
            $modFakturPembelian->save();
        } else {
            $this->fakturpembeliantersimpan &= false;
        }
        
        return $modFakturPembelian;
    }
    
    /**
     * simpan ADFakturDetailT
     * @param type $modPenerimaanBarang
     * @param type $post
     * @return \ADPenerimaanDetailT
     */
    public function simpanFakturDetail($modPenerimaanDetail,$modFakturPembelian){
        $format = new MyFormatter();
        $modFakturDetail = new ADFakturDetailT;
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
        $modFakturDetail->hargasatuan = ($modFakturDetail->harganettofaktur - $modFakturDetail->jmldiscount);
        $modFakturDetail->kemasanbesar = $modPenerimaanDetail->kemasanbesar;
        $modFakturDetail->satuanbesar_id = $modPenerimaanDetail->satuankecil_id;
        $modFakturDetail->satuankecil_id = $modPenerimaanDetail->satuanbesar_id;
        $modFakturDetail->tglkadaluarsa = $format->formatDateTimeForDb($modPenerimaanDetail->tglkadaluarsa);
        
        if($modFakturDetail->validate()) { 
            $modFakturDetail->save();
            $updatePenerimaan = ADPenerimaanDetailT::model()->updateByPk($modPenerimaanDetail->penerimaandetail_id,array('fakturdetail_id'=>$modFakturDetail->fakturdetail_id));
        } else {
            $this->fakturpembeliandetailtersimpan &= false;
        }
        return $modFakturDetail;
    }
    
    public function simpanStokObatAlkes($modPenerimaanDetail,$postOa,$modPenerimaanBarang){
        $format = new MyFormatter;
        $modStok = new ADStokObatAlkesT;
        $loadObatAlkes = ADObatAlkesM::model()->findByPk($modPenerimaanDetail->obatalkes_id);
        $modStok->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStok->penerimaandetail_id = $modPenerimaanDetail->penerimaandetail_id;
        $modStok->tglkadaluarsa = !empty($modPenerimaanDetail->tglkadaluarsa) ? $format->formatDateTimeForDb($modPenerimaanDetail->tglkadaluarsa) : null;
        $modStok->obatalkes_id = $modPenerimaanDetail->obatalkes_id;
        $modStok->nobatch = $postOa['nobatch'];
        $modStok->tglstok_in = $modPenerimaanBarang->tglterima;
        $modStok->tglstok_out = NULL;
        if(!empty($modPenerimaanDetail->satuanbesar_id)){
            $modStok->qtystok_in = $modPenerimaanDetail->jmlterima * $modPenerimaanDetail->kemasanbesar ;
            $modStok->harganetto = ($modPenerimaanDetail->harganettoper / $modStok->qtystok_in);
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
        $modStok->jmlmargin = 0;
        $modStok->create_time = date('Y-m-d H:i:s');
        $modStok->update_time = date('Y-m-d H:i:s');
        $modStok->create_loginpemakai_id = Yii::app()->user->id;
        $modStok->update_loginpemakai_id = Yii::app()->user->id;
        $modStok->create_ruangan = Yii::app()->user->ruangan_id;
        $modStok->tglterima = $modPenerimaanDetail->penerimaanbarang->tglterima;
        $modStok->satuankecil_id = (isset($modPenerimaanDetail->satuankecil_id) ? $modPenerimaanDetail->satuankecil_id : $loadObatAlkes->satuankecil_id);
        
        if($modStok->validate()) { 
            $modStok->save();
            $loadObatAlkes->tglkadaluarsa = $modStok->tglkadaluarsa;
            $loadObatAlkes->harganetto = $modStok->harganetto;
			$loadObatAlkes->discount = (($modStok->jmldiscount > 0) ? $modStok->jmldiscount : $modStok->harganetto * $modStok->persendiscount / 100) ;
            $loadObatAlkes->ppn_persen = $modStok->persenppn;
            $loadObatAlkes->hpp = $modStok->HPP;
            $loadObatAlkes->kemasanbesar = $modPenerimaanDetail->kemasanbesar;
            $loadObatAlkes->satuankecil_id =$modStok->satuankecil_id;
			$loadObatAlkes->satuanbesar_id = (!empty($modStok->satuanbesar_id) ? $modStok->satuanbesar_id : $loadObatAlkes->satuanbesar_id);
			$loadObatAlkes->nobatch = $postOa['nobatch'];
			
			if($modStok->persenmargin > 0){
				$hargajual = ($modStok->HPP + ($modStok->HPP * ($modStok->persenmargin / 100)));
			}else{
				$hargajual = $modStok->HPP + $modStok->jmlmargin;
			}
			if($hargajual > $loadObatAlkes->hargamaksimum){
				$loadObatAlkes->hargamaksimum = $hargajual;
			}
			if($loadObatAlkes->hargaminimum <= 0 || $hargajual < $loadObatAlkes->hargaminimum){
				$loadObatAlkes->hargaminimum = $hargajual;
			}
			if($loadObatAlkes->hargaaverage > 0 && $hargajual > 0){
				$loadObatAlkes->hargaaverage = ($loadObatAlkes->hargaaverage + $hargajual) / 2;
			}else{
				$loadObatAlkes->hargaaverage = $hargajual;
			}
            $loadObatAlkes->hargajual = $hargajual;
			
            if($loadObatAlkes->save()){
				
			}else{
				$this->stokobatalkestersimpan &= false;
			}
            
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
    
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
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
    
    /**
    * menampilkan obat
    * @return row table 
    */
    public function actionLoadFormPenerimaanBarang()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
            $tgl_kadaluarsa = $_POST['tgl_kadaluarsa'];
            $nobatch = isset($_POST['nobatch']) ? $_POST['nobatch'] : "";
            
            $format = new MyFormatter();
            $modPenerimaanBarang = new ADPenerimaanBarangT();
            $modPenerimaanBarangDetail = new ADPenerimaanDetailT;
            $modObatAlkes = ADObatalkesM::model()->findByPk($obatalkes_id);
            $jmlKemasan = ($modObatAlkes->kemasanbesar > 0) ? $modObatAlkes->kemasanbesar : 1;
            $modPenerimaanBarangDetail->jmlpermintaan = $jumlah;
            $modPenerimaanBarangDetail->jmlterima = $jumlah;
            $modPenerimaanBarangDetail->harganettoper = $modObatAlkes->harganetto;
//            $modPenerimaanBarangDetail->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
            $modPenerimaanBarangDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
            $modPenerimaanBarangDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
            $modPenerimaanBarangDetail->persenppn = 0;
            $modPenerimaanBarangDetail->persenpph = 0;
//            $modPenerimaanBarangDetail->persenppn = Yii::app()->user->getState('persenppn');
//            $modPenerimaanBarangDetail->persenpph = Yii::app()->user->getState('persenpph');
            $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($tgl_kadaluarsa) ? $format->formatDateTimeForUser($tgl_kadaluarsa) : null);
            $modPenerimaanBarangDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
            $modPenerimaanBarangDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
            $modPenerimaanBarangDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
            $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($tgl_kadaluarsa) ? $format->formatDateTimeForDb($tgl_kadaluarsa) :"");         
            $modPenerimaanBarangDetail->nobatch = isset($modObatAlkes->nobatch) ? $modObatAlkes->nobatch : isset($nobatch) ? $nobatch : "";         

            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial('_rowObatPenerimaanBarang', array(
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
        $modPenerimaanBarang = ADPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);     
        $modPenerimaanBarangDetail = ADPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
        $modFakturPembelian = ADFakturpembelianT::model()->findByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));

        $judul_print = 'Penerimaan Obat dan Alat Kesehatan Dari Supplier';
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
	
	public function actionReturPembelianOA($penerimaanbarang_id)
	{
		$format = new MyFormatter;
		$modPembelian = new ADReturPembelianT;
		$modPenerimaan = ADPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);
		$modPenerimaanDet = ADPenerimaanDetailT::model()->findAll('penerimaanbarang_id ='.$penerimaanbarang_id);
		$modPembelianDet = array();
		$modStokObat = array();
		$sukses = false;
		

		if (isset($_POST['ADReturPembelianT'])){
			$transaction = Yii::app()->db->beginTransaction();
            try {
			// insert tabel returpembelian_t
			$modPembelian->attributes = $_POST['ADReturPembelianT'];
			$modPembelian->penerimaanbarang_id = $_POST['ADPenerimaanBarangT']['penerimaanbarang_id'];
			$modPembelian->fakturpembelian_id = $_POST['ADPenerimaanBarangT']['fakturpembelian_id'];
			$modPembelian->totalretur = $_POST['ADReturPembelianT']['totalretur'];
			$modPembelian->noretur = MyGenerator::noRetur();
			$modPembelian->tglretur = date("Y-m-d H:i:s");
			$modPembelian->create_time = date("Y-m-d");
			$modPembelian->create_loginpemakai_id = Yii::app()->user->id;
			$modPembelian->create_ruangan = Yii::app()->user->getState('ruangan_id');
				if ($modPembelian->save()){
					$this->returpembeliantersimpan = true;
					if (isset($_POST['ADReturDetailT'])){
						$returdet = $_POST['ADReturDetailT'];
						if (count($returdet) > 0){
							// insert tabel returdetail_t
							foreach($returdet as $i => $det){
								if (($det['jmlretur'] > 0 ) && ($det['isRetur'] == true)){
								$modPembelianDet[$i] = new ADReturDetailT;
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
								$modPembelianDet[$i]->hargasatuanretur = $det['hargasatuanretur'];
									// update tabel penerimaandetail_t	(returdetail_id)
									if ($modPembelianDet[$i]->save()){
										$update  = ADPenerimaanDetailT::model()->findByPk($modPembelianDet[$i]->penerimaandetail_id);
										$update->returdetail_id = $modPembelianDet[$i]->returdetail_id;
										$update->update();
									// insert tabel stokobatalkes_t	(obatalkes_id)
										$this->simpanStokObatAlkesOut($modPembelianDet[$i],$modPembelianDet[$i]->returdetail_id);
										$this->returpembeliandetailtersimpan = true;
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
				
				if($this->returpembeliantersimpan && $this->returpembeliandetailtersimpan){                    
                    $transaction->commit();
                    $modPembelian->isNewRecord = FALSE;
                    $this->redirect(array('returPembelianOA','penerimaanbarang_id'=>$penerimaanbarang_id,'returpembelian_id'=>$modPembelian->returpembelian_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Pembelian gagal diretur !");
                }
				
			} catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Pembelian gagal diretur ! ".MyExceptionMessage::getMessage($e,true));
            }
		}
			
		$this->render('formReturPembelian',array(
			'modPenerimaan'=>$modPenerimaan,
			'modPenerimaanDet'=>$modPenerimaanDet,
			'modPembelian'=>$modPembelian,
			'format'=>$format
		));
	}
	
	protected function simpanStokObatAlkesOut($stokObatAlkes,$returdetail_id){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByAttributes(array('obatalkes_id'=>$stokObatAlkes->obatalkes_id));
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
		$modStokOaNew->returdetail_id = $returdetail_id;
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $stokObatAlkes->jmlretur;
        $modStokOaNew->stokobatalkesasal_id = $modStokOa->stokobatalkes_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
        
        if($modStokOaNew->validateStok()){ 
            $modStokOaNew->save();
            $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;      
    }        
	
}