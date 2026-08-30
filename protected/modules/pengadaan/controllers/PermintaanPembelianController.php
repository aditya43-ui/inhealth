<?php
/**
* digunakan sebagai transaksi permintaan pembelian
* @author Elham Budianto <elhambudianto@.com>
* @package application.modules.pengadaan
* @subpackage controllers
**/
class PermintaanPembelianController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.permintaanPembelian.';
    public $permintaanpembeliantersimpan = true;
    
    /**
     * Menampilkan transaksi permintaan pembelian
     * @param type $permintaanpembelian_id
     * @param type $rencana_id
     * @param type $penawaran_id
     */
    public function actionIndex($permintaanpembelian_id = null,$rencana_id = null, $penawaran_id = null){
        $format = new MyFormatter;
        $modPermintaanPembelian = new ADPermintaanpembelianT;
        
        $modPermintaanPembelian->tglpermintaanpembelian = date('Y-m-d H:i:s');
		$modPermintaanPembelian->nopermintaan = "Otomatis";
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
        if(isset($_POST['tujuansms'])){
            $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        if (!empty($penawaran_id) && (empty($permintaanpembelian_id))){
            $modPermintaanPenawaran = ADPermintaanPenawaranT::model()->findByPk($penawaran_id);
            $jumlahPermintaan = ADPermintaanpembelianT::model()->countByAttributes(array('permintaanpenawaran_id'=>$modPermintaanPenawaran->permintaanpenawaran_id));
            $modPermintaanPembelian->permintaanpenawaran_id = $modPermintaanPenawaran->permintaanpenawaran_id;
            $modPermintaanPembelian->attributes = $modPermintaanPenawaran->attributes;
            if (!empty($modPermintaanPenawaran)){
                $modPenawaranDetail = ADPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id'=>$modPermintaanPenawaran->permintaanpenawaran_id));
                if (count($modPenawaranDetail) > 0){
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
                        $modDetails[$key]->satuankecil_id = empty($value->satuankecil_id) ? $obat->satuankecil_id : $value->satuankecil_id;
                        $modDetails[$key]->satuanbesar_id = empty($value->satuanbesar_id) ? $obat->satuanbesar_id : $value->satuanbesar_id;
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
            $modPermintaanPembelian->rencanakebfarmasi_id = $modRencanaKebFarmasi->rencanakebfarmasi_id;
            if ($modRencanaKebFarmasi){
                $modRencanaDetail = ADRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$modRencanaKebFarmasi->rencanakebfarmasi_id));
                if (count($modRencanaDetail) > 0){
                    $totalSebelumDiskon = 0;
                    foreach ($modRencanaDetail as $i => $value) {
                        $obat = ADObatalkesM::model()->findByPk($value->obatalkes_id);
                        $stok = StokobatalkesT::getJumlahStok($obat->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                        $jmlKemasan = ($value->kemasanbesar > 0) ? $value->kemasanbesar : $obat->kemasanbesar;
                        $modDetails[$i] = new ADPermintaanDetailT();
                        $modDetails[$i]->attributes = $value->attributes;
                        $modDetails[$i]->stokakhir = 0;
                        //$modDetails[$i]->jmlpermintaan = $value->jmlpermintaan;
                        
                        if (!empty($modRencanaKebFarmasi->jmlwaktupemakaian)){
                            $jml = $value->getSisaRencana($rencana_id);
                            $jmlTot = is_array($jml)?(($value->jmlpermintaan * $modRencanaKebFarmasi->jmlwaktupemakaian) - $jml[$value->obatalkes_id]['stok']):$value->jmlpermintaan * $modRencanaKebFarmasi->jmlwaktupemakaian;

                            if ($jmlTot < 0){
                                $jmlTot = 0;
                            }
                        }else{
                            $jmlTot = $value->jmlpermintaan;
                        }
                        
                        $modDetails[$i]->jmlpermintaan = $jmlTot;
                        $modDetails[$i]->harganettoper = $value->harganettorenc;
                        $modDetails[$i]->satuankecil_id = empty($value->satuankecil_id) ? $obat->satuankecil_id : $value->satuankecil_id;
                        $modDetails[$i]->satuanbesar_id = empty($value->satuanbesar_id) ? $obat->satuanbesar_id : $value->satuanbesar_id;
                        $modDetails[$i]->hargasatuanper = $value->harganettorenc * $value->kemasanbesar; //krn harga beli besar belum di tentukan di rencana
                        $modDetails[$i]->kemasanbesar = $value->kemasanbesar;
                        $modDetails[$i]->tglkadaluarsa = $value->tglkadaluarsa;
                        $modDetails[$i]->persendiscount = $obat->discount;
                        $modDetails[$i]->jmldiscount = ($modDetails[$i]->jmlpermintaan * $modDetails[$i]->hargasatuanper * $modDetails[$i]->persendiscount/100);
                        $modDetails[$i]->maksimalstok = 0;
                        $modDetails[$i]->persenppn = (!empty($value->persenppn)) ? $value->persenppn : 0;
                        $modDetails[$i]->hargasatuanper = 0;
                        $modDetails[$i]->persenpph = (!empty($value->persenppn)) ? $value->persenppn : 0;
                        $modDetails[$i]->biaya_lainlain = 0;
                        $totalSebelumDiskon += $modDetails[$i]->jmlpermintaan*$modDetails[$i]->harganettoper;
                    }
                }
            }
        }
                
        if(!empty($permintaanpembelian_id)){
            $modPermintaanPembelian= ADPermintaanpembelianT::model()->findByPk($permintaanpembelian_id);
            $modPermintaanPembelian->pegawaimengetahui_nama = !empty($modPermintaanPembelian->pegawaimengetahui->NamaLengkap) ? $modPermintaanPembelian->pegawaimengetahui->NamaLengkap : "";
            $modPermintaanPembelian->pegawaimenyetujui_nama = !empty($modPermintaanPembelian->pegawaimenyetujui->NamaLengkap) ? $modPermintaanPembelian->pegawaimenyetujui->NamaLengkap : "";
            
            if(!empty($modPermintaanPembelian->rencanakebfarmasi_id)){
                $modRencanaKebFarmasi->noperencnaan = $modPermintaanPembelian->rencanakebfarmasi->noperencnaan;
                $modRencanaKebFarmasi->tglperencanaan = $modPermintaanPembelian->rencanakebfarmasi->tglperencanaan;
            }
            
            $modDetails = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$modPermintaanPembelian->permintaanpembelian_id));
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
						$modPermintaanPembelian->nopermintaan=MyGenerator::noPembelian();
						$modPermintaanPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
						$modPermintaanPembelian->instalasi_id = Yii::app()->user->getState('instalasi_id');
						$modPermintaanPembelian->pegawai_id = Yii::app()->user->getState('pegawai_id');
						$modPermintaanPembelian->tglpermintaanpembelian=$format->formatDateTimeForDb($_POST['ADPermintaanpembelianT']['tglpermintaanpembelian']);                                                
						$modPermintaanPembelian->create_time = date('Y-m-d H:i:s');
						$modPermintaanPembelian->create_loginpemakai_id = Yii::app()->user->id;
						$modPermintaanPembelian->create_ruangan = Yii::app()->user->ruangan_id;
					}
                    $modPermintaanPembelian->statuspembelian = "BELUM DISETUJUI"; //LNG-582
                    if($modPermintaanPembelian->save()){
							if(isset($_GET['ubah'])){
								$modPermintaanPembelianDetail = ADPermintaanDetailT::model()->deleteAllByAttributes(array('permintaanpembelian_id'=>$modPermintaanPembelian->permintaanpembelian_id));
							}
                            if(count($_POST['ADPermintaanDetailT']) > 0){
                               foreach($_POST['ADPermintaanDetailT'] AS $i => $postOa){
                                   $modDetails[$i] = $this->simpanPermintaanPembelian($modPermintaanPembelian,$postOa);
                               }
                           }
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
                    // END SMS GATEWAY
                    $transaction->commit();                    
                    $this->redirect(array('index','permintaanpembelian_id'=>$modPermintaanPembelian->permintaanpembelian_id,'smscp1'=>$smscp1,'smscp2'=>$smscp2,'sukses'=>1));
                    $modPermintaanPembelian->isNewRecord = FALSE;
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Permintaan Pembelian gagal disimpan !");
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
        $modPermintaanPembelianDetail->persenppn = 0;
        $modPermintaanPembelianDetail->persenpph = 0;
        $modPermintaanPembelianDetail->hargasatuanper = 0;
        $modPermintaanPembelianDetail->biaya_lainlain = 0;
        
        if($post['satuanobat'] == PARAMS::SATUAN_KECIL){
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
            $jumlah = $_POST['jumlah'];
            
            $format = new MyFormatter();
            $modPermintaanPembelian = new ADPermintaanPembelianT();
            $modPermintaanPembelianDetail = new ADPermintaanDetailT;
            $modObatAlkes = ADObatalkesM::model()->findByPk($obatalkes_id);
                        
            $jmlKemasan = ($modObatAlkes->kemasanbesar > 0) ? $modObatAlkes->kemasanbesar : 1;
            $modPermintaanPembelianDetail->jmlpermintaan = $jumlah;
            $modPermintaanPembelianDetail->harganettoper = $modObatAlkes->harganetto;
//            $modPermintaanPembelianDetail->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
            $modPermintaanPembelianDetail->stokakhir = 0;
            $modPermintaanPembelianDetail->maksimalstok = 0;
            $modPermintaanPembelianDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
            $modPermintaanPembelianDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
            $modPermintaanPembelianDetail->persenpph = Yii::app()->user->getState('persenpph');
            $modPermintaanPembelianDetail->persenppn = Yii::app()->user->getState('persenppn');
            $modPermintaanPembelianDetail->tglkadaluarsa = NULL;
            $modPermintaanPembelianDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
            $modPermintaanPembelianDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
            $modPermintaanPembelianDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;
            
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
    
    /**
     * Autocomplete pegawai mengetahui
     */
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
    
    /**
     * Autocomplete pegawai menyetujui
     */
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->join = "JOIN ruanganpegawai_m rp ON rp.pegawai_id = t.pegawai_id";            
            $criteria->addCondition(" rp.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
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
     * Autocomplete obat alkes
     */
    public function actionAutocompleteObatAlkes()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'obatalkes_nama';
            $criteria->limit = 5;
            $models = ADObatalkesM::model()->findAll($criteria);
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
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPermintaanPembelian'=>$modPermintaanPembelian,
                'modPermintaanPembelianDetail'=>$modPermintaanPembelianDetail,
                'caraPrint'=>$caraPrint
        ));
    }
    
    /**
     * Autocomplete permintaan penawaran
     */
    public function actionAutocompletePermintaanPenawaran()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nosuratpenawaran)', strtolower($_GET['term']), true);
            $criteria->order = 'nosuratpenawaran';
            $criteria->limit = 5;
            $models = ADPermintaanPenawaranT::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nosuratpenawaran;
                $returnVal[$i]['value'] = $model->permintaanpenawaran_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
?>
