<?php
/**
* digunakan sebagai transaksi permintaan penawaran
* @author Elham Budianto <elhambudianto@.com>
* @package application.modules.pengadaan
* @subpackage controllers
**/
class PermintaanPenawaranController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.permintaanPenawaran.';
    public $permintaanpenawaranobattersimpan = true;
    
    /**
     * Menampilkan transaksi permintaan penawaran
     * @param type $permintaanpenawaran_id
     * @param type $rencana_id
     */
    public function actionIndex($permintaanpenawaran_id=null,$rencana_id = null)
    {
        $modRencanaKebFarmasi = new ADRencanaKebFarmasiT;
        $modPermintaanPenawaran = new ADPermintaanPenawaranT;
        $modPenawaranDetail = new ADPenawaranDetailT;
        $modObatAlkes = new ADObatalkesM;
        $modPermintaanPenawaran->harganettopenawaran=0; 
        $modPermintaanPenawaran->tglpenawaran=date('Y-m-d H:i:s');
        $modDetails = null;
        
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
        

        if(!empty($rencana_id) && (empty($permintaanpenawaran_id))){
            $modRencanaKebFarmasi = ADRencanaKebFarmasiT::model()->findByPk($rencana_id);
            if (!empty($modRencanaKebFarmasi)){
                $modDetailRencana = ADRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$rencana_id));
                $hargaPermintaanPenawaran = 0;
                if (count($modDetailRencana) > 0){
                    foreach ($modDetailRencana as $i => $rencana) {
                        
                        if (!empty($modRencanaKebFarmasi->jmlwaktupemakaian)){
                            $jml = $rencana->getSisaRencana($rencana_id);
                            $jmlTot = is_array($jml)?(($rencana->jmlpermintaan * $modRencanaKebFarmasi->jmlwaktupemakaian) - $jml[$rencana->obatalkes_id]['stok']):$rencana->jmlpermintaan * $modRencanaKebFarmasi->jmlwaktupemakaian;

                            if ($jmlTot < 0){
                                $jmlTot = 0;
                            }
                        }else{
                           $jmlTot =  $rencana->jmlpermintaan;
                        }
                        
                        
                        //$harga = $rencana->jmlpermintaan * $rencana->harganettorenc;
                        $harga = $jmlTot * $rencana->harganettorenc;
                        $hargaPermintaanPenawaran = $hargaPermintaanPenawaran + $harga;
                        $modDetails[$i] = new ADPenawaranDetailT();
                        $modDetails[$i]->attributes = $rencana->attributes;
                        $modDetails[$i]->harganetto = $rencana->harganettorenc;
                       // $modDetails[$i]->qty = $rencana->jmlpermintaan;
                        $modDetails[$i]->qty = $jmlTot;
                        $modDetails[$i]->kemasanbesar = $rencana->kemasanbesar;
                        $modDetails[$i]->hargabelibesar = $rencana->harganettorenc * $rencana->kemasanbesar;
                    }
                }

                $modPermintaanPenawaran->rencanakebfarmasi_id = $modRencanaKebFarmasi->rencanakebfarmasi_id;
                $modPermintaanPenawaran->harganettopenawaran = $hargaPermintaanPenawaran;
            }
        }
        
        if(!empty($permintaanpenawaran_id)){
            $modPermintaanPenawaran= ADPermintaanPenawaranT::model()->findByPk($permintaanpenawaran_id);
            $modPermintaanPenawaran->pegawaimengetahui_nama = !empty($modPermintaanPenawaran->pegawaimengetahui->NamaLengkap) ? $modPermintaanPenawaran->pegawaimengetahui->NamaLengkap : "";
            $modPermintaanPenawaran->pegawaimenyetujui_nama = !empty($modPermintaanPenawaran->pegawaimenyetujui->NamaLengkap) ? $modPermintaanPenawaran->pegawaimenyetujui->NamaLengkap : "";
            
            $modDetails = ADPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id'=>$modPermintaanPenawaran->permintaanpenawaran_id));
        }

        $format = new MyFormatter();

         if(isset($_POST['ADPermintaanPenawaranT'])){
//             echo '<pre>';
//                    var_dump($_POST['ADPermintaanPenawaranT']);
             $transaction = Yii::app()->db->beginTransaction();
             try {
                    $modPermintaanPenawaran->attributes=$_POST['ADPermintaanPenawaranT'];
					if(isset($_GET['ubah'])){
						$modPermintaanPenawaran->update_time = date('Y-m-d H:i:s');
						$modPermintaanPenawaran->update_loginpemakai_id = Yii::app()->user->id;
						$modPermintaanPenawaran->pegawai_id = Yii::app()->user->getState('pegawai_id');
						$modPermintaanPenawaran->pegawaimengetahui_id = $_POST['ADPermintaanPenawaranT']['pegawaimengetahui_id'];
						$modPermintaanPenawaran->pegawaimenyetujui_id = $_POST['ADPermintaanPenawaranT']['pegawaimenyetujui_id'];
						$modPermintaanPenawaran->tglpenawaran = $format->formatDateTimeForDb($_POST['ADPermintaanPenawaranT']['tglpenawaran']);
						$modPermintaanPenawaran->ispenawaranmasuk = $_POST['ADPermintaanPenawaranT']['ispenawaranmasuk'];
					}else{
						$modPermintaanPenawaran->nosuratpenawaran=MyGenerator::noPenawaran();
						$modPermintaanPenawaran->create_time = date('Y-m-d H:i:s');
						$modPermintaanPenawaran->create_loginpemakai_id = Yii::app()->user->id;
						$modPermintaanPenawaran->create_ruangan = Yii::app()->user->getState('ruangan_id');
						$modPermintaanPenawaran->pegawai_id = Yii::app()->user->getState('pegawai_id');
						$modPermintaanPenawaran->pegawaimengetahui_id = $_POST['ADPermintaanPenawaranT']['pegawaimengetahui_id'];
						$modPermintaanPenawaran->pegawaimenyetujui_id = $_POST['ADPermintaanPenawaranT']['pegawaimenyetujui_id'];
						$modPermintaanPenawaran->tglpenawaran = $format->formatDateTimeForDb($_POST['ADPermintaanPenawaranT']['tglpenawaran']);
						$modPermintaanPenawaran->ispenawaranmasuk = $_POST['ADPermintaanPenawaranT']['ispenawaranmasuk'];
					}
					$modPermintaanPenawaran->statuspenawaran = "BELUM DISETUJUI"; //LNG-581
                    if($modPermintaanPenawaran->save()){
						if(isset($_GET['ubah'])){
							$modDetailPenawaran = ADPenawaranDetailT::model()->deleteAllByAttributes(array('permintaanpenawaran_id'=>$modPermintaanPenawaran->permintaanpenawaran_id));
						}
						if(count($_POST['ADPenawaranDetailT']) > 0){
//                                                        echo '<pre>';
//                                                        var_dump($_POST['ADPenawaranDetailT']); die;
							foreach($_POST['ADPenawaranDetailT'] AS $i => $postOa){
								$modDetails[$i] = $this->simpanDetailPenawaran($modPermintaanPenawaran,$postOa);
							}
						}
                    }
                    
                    if($this->permintaanpenawaranobattersimpan){
                        // SMS GATEWAY
                        $modSupplier = $modPermintaanPenawaran->supplier;
                        $sms = new Sms();
                        $smscp1 = 1;
                        $smscp2 = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modSupplier->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPermintaanPenawaran->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                           
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPermintaanPenawaran->tglpenawaran),$isiPesan);
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
                        $modPermintaanPenawaran->isNewRecord = FALSE;
                        $this->redirect(array('index','permintaanpenawaran_id'=>$modPermintaanPenawaran->permintaanpenawaran_id,'smscp1'=>$smscp1,'smscp2'=>$smscp2,'sukses'=>1));
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data Permintaan penawaran gagal disimpan !");
                    }

            }catch(Exception $exc){
                $modPermintaanPenawaran->isNewRecord = true;
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }    
        }

//        $modPermintaanPenawaran->tglpenawaran = Yii::app()->dateFormatter->formatDateTime(
//        CDateTimeParser::parse($modPermintaanPenawaran->tglpenawaran, 'yyyy-MM-dd hh:mm:ss')); 


        $this->render($this->path_view.'index',array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi,
                                    'modPermintaanPenawaran'=>$modPermintaanPenawaran,
                                    'modDetails'=>$modDetails,
                                    'format'=>$format,
                                    'modPenawaranDetail'=>$modPenawaranDetail,
                                    'modObatAlkes'=>$modObatAlkes));
    }
    
    
    /**
     * simpan ADPenawaranDetailT
     * @param type $modPermintaanPenawaran
     * @param type $post
     * @return \ADRencDetailkebT
     */
    public function simpanDetailPenawaran($modPermintaanPenawaran ,$post){
        $format = new MyFormatter();
        $modDetailPenawaran = new ADPenawaranDetailT;

        $modDetailPenawaran->attributes = $post;
        $modDetailPenawaran->qty = $post['qty'];
        $modDetailPenawaran->kemasanbesar = $post['kemasanbesar'];
        $modDetailPenawaran->permintaanpenawaran_id = $modPermintaanPenawaran->permintaanpenawaran_id; //fake id

        $obatSupplier = new ObatsupplierM;
        if(!empty($modPermintaanPenawaran->supplier_id)){
            $criteria = new CDbCriteria();
			if(!empty($modDetailPenawaran->obatalkes_id)){
				$criteria->addCondition("obatalkes_id = ".$modDetailPenawaran->obatalkes_id);		
			}
			if(!empty($modPermintaanPenawaran->supplier_id)){
				$criteria->addCondition("supplier_id = ".$modPermintaanPenawaran->supplier_id);		
			}
            $obatSupplier = ObatsupplierM::model()->find($criteria);
        }else{
            //Dikosongkan karena input manual
            $obatSupplier->hargabelibesar = (float)0;
        }
        $modDetailPenawaran->hargabelibesar = (isset($obatSupplier->hargabelibesar) ? (float)$obatSupplier->hargabelibesar : 0);
        if($post['satuanobat'] == PARAMS::SATUAN_KECIL){
            $modDetailPenawaran->satuanbesar_id = NULL;
        }else{
            $modDetailPenawaran->satuankecil_id = NULL;
        }

        if($modDetailPenawaran->validate()) {
            $modDetailPenawaran->save();
        } else {
            $this->permintaanpenawaranobattersimpan  &= false;
        }
        return $modDetailPenawaran;
    }

    /**
     * untuk print data permintaan penawaran
     * @param type $permintaanpenawaran_id
     * @param type $caraPrint
     */
    public function actionPrint($permintaanpenawaran_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPermintaanPenawaran = ADPermintaanPenawaranT::model()->findByPk($permintaanpenawaran_id);     
        $modPenawaranDetail = ADPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id'=>$permintaanpenawaran_id));

        $judul_print = 'Permintaan Penawaran Farmasi';
        
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
                'modPermintaanPenawaran'=>$modPermintaanPenawaran,
                'modPenawaranDetail'=>$modPenawaranDetail,
                'caraPrint'=>$caraPrint
        ));
    } 
    
    /**
     * Load data permintaan penawaran
     */
    public function actionLoadFormPermintaanPenawaran()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];

            $modPermintaanPenawaran = new ADPermintaanPenawaranT;
            $modPenawaranDetail = new ADPenawaranDetailT;
            $modObatAlkes = ADObatalkesM::model()->findByPk($obatalkes_id);
                        
            $jmlKemasan = ($modObatAlkes->kemasanbesar > 0) ? $modObatAlkes->kemasanbesar : 1;
            $modPenawaranDetail->qty = $jumlah;
            $modPenawaranDetail->harganetto = $modObatAlkes->harganetto;
            $modPenawaranDetail->stokakhir = StokobatalkesT::getJumlahStok($obatalkes_id, Yii::app()->user->getState('ruangan_id'));
//            $modPenawaranDetail->stokakhir = 0;
            $modPenawaranDetail->maksimalstok = 0;
            $modPenawaranDetail->sumberdana_id = isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null;
            $modPenawaranDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
//            $modPenawaranDetail->persenpph = 0;
//            $modPenawaranDetail->persenppn = 0;
//            $modPenawaranDetail->tglkadaluarsa = NULL;
            $modPenawaranDetail->kemasanbesar = $modObatAlkes->kemasanbesar;
            $modPenawaranDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
            $modPenawaranDetail->satuanbesar_id = $modObatAlkes->satuanbesar_id;

            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial($this->path_view.'_rowObatAlkesPasien', array(
                        'modPenawaranDetail'=>$modPenawaranDetail,
                        'modPermintaanPenawaran'=>$modPermintaanPenawaran,
                ), 
                true)
            ));
         Yii::app()->end();
        }
    }

    /**
    * Menampilkan obat dari permintaan penawaran
    * @return row table
    */
    public function actionGetObatAlkesPermintaanPenawaran()
    {

       if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id  = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
            $qty_obat = (isset($_POST['qty_obat']) ? $_POST['qty_obat'] : null);
            $supplier_id = (isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null);

            $modPenawaranDetail = new PenawarandetailT;
            $modObatAlkes=ObatalkesM::model()->findByPk($obatalkes_id);
            $modStokObatAlkes=StokobatalkesT::model()->findAll('obatalkes_id='.$obatalkes_id.'');
            $obatSupplier = new ObatsupplierM;
            if(!empty($supplier_id)){
                $criteria = new CDbCriteria();
				if(!empty($obatalkes_id)){
					$criteria->addCondition("obatalkes_id = ".$obatalkes_id);		
				}
				if(!empty($supplier_id)){
					$criteria->addCondition("supplier_id = ".$supplier_id);		
				}
                $obatSupplier = ObatsupplierM::model()->find($criteria);
            }else{
                //Dikosongkan karena input manual
                $obatSupplier->hargabelibesar = 0;
            }
            $stokAkhir = 0;
            $maxStok = 0;
            $hargabelibesar = (isset($obatSupplier->hargabelibesar) ? $obatSupplier->hargabelibesar : 0);
            foreach($modStokObatAlkes AS $tampil):
                $stokAkhir+=$tampil['qtystok_in'];
                $maxStok+=$tampil['qtystok_out'];
            endforeach;
            $jmlKemasan = (!empty($modObatAlkes->kemasanbesar)) ? $modObatAlkes->kemasanbesar : 1;
            $stokAkhir = $stokAkhir;
//            $hargaJual = ($obatSupplier->hargajual > 0) ? $obatSupplier->hargajual : $modObatAlkes->hargajual;
//            $hargaNetto = ($modObatAlkes->harganetto > 0) ? $modObatAlkes->harganetto : $hargaJual;
//            $harganetto = ($obatSupplier->harganetto > 0) ? $obatSupplier->harganetto : $hargaNetto;
//            $subTotal = $qty_obat * $harganetto;
//            $hargabelikecil = $obatSupplier->hargabelikecil;
            if($hargabelibesar > 0){
                $hargabelibesar = number_format(($obatSupplier->hargabelibesar > 0 ) ? $obatSupplier->hargabelibesar : $obatSupplier->hargabelikecil * $jmlKemasan,0,'','');
                $hargabelikecil = $hargabelibesar / $jmlKemasan;
            }else{
                $hargabelibesar = 0;
                $hargabelikecil = 0;
            }
            $subTotal = $qty_obat * $hargabelibesar;
                $tr="<tr>
                        <td>".CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE)).                              
                              CHtml::activeHiddenField($modPenawaranDetail,'['.$obatalkes_id.']satuankecil_id',array('value'=>$modObatAlkes->satuankecil_id)).
                              CHtml::activeHiddenField($modPenawaranDetail,'['.$obatalkes_id.']satuanbesar_id',array('value'=>$modObatAlkes->satuanbesar_id)). 
                              CHtml::activeHiddenField($modPenawaranDetail,'['.$obatalkes_id.']sumberdana_id',array('value'=>$modObatAlkes->sumberdana_id)). 
                              CHtml::activeHiddenField($modPenawaranDetail,'['.$obatalkes_id.']obatalkes_id',array('value'=>$modObatAlkes->obatalkes_id, 'class'=>'obatAlkes')). 
                       "</td>
                        <td>".$modObatAlkes->obatalkes_kategori."/<br/>".$modObatAlkes->obatalkes_nama."</td>
                        <td>".(isset($modObatAlkes->sumberdana->sumberdana_nama)?$modObatAlkes->sumberdana->sumberdana_nama:" - ")."</td>
                        <td>".$stokAkhir." ".(isset($modObatAlkes->satuankecil->satuankecil_nama)?$modObatAlkes->satuankecil->satuankecil_nama:" - ")."</td>
                        <td>".CHtml::activetextField($modPenawaranDetail,'['.$obatalkes_id.']jmlkemasan',array('readonly'=>true,'value'=>$jmlKemasan,'class'=>'span1 integer'))
                        ." ".(isset($modObatAlkes->satuankecil->satuankecil_nama)?$modObatAlkes->satuankecil->satuankecil_nama:" - ")."/".(isset($modObatAlkes->satuanbesar->satuanbesar_nama)?$modObatAlkes->satuanbesar->satuanbesar_nama:" - ")."</td>
                        <td>".CHtml::activetextField($modPenawaranDetail,'['.$obatalkes_id.']qty',array('readonly'=>false,'value'=>$qty_obat,'class'=>'span1 qty integer','onkeyup'=>'hitungSubtotal(this);'))
                        ." ".(isset($modObatAlkes->satuanbesar->satuanbesar_nama)?$modObatAlkes->satuanbesar->satuanbesar_nama:" - ")."</td>
                        <td>".CHtml::activetextField($modPenawaranDetail,'['.$obatalkes_id.']hargabelibesar',array('value'=>$hargabelibesar,'class'=>'span2 integer','readonly'=>false, 'onkeyup'=>'hitungHargaNetto(this); hitungSubtotal(this);'))
                            .CHtml::activeHiddenField($modPenawaranDetail,'['.$obatalkes_id.']harganetto',array('value'=>$hargabelikecil,'class'=>'span1 netto','readonly'=>TRUE))."</td>
                        <td>".CHtml::textField('subtotal',$subTotal,array('class'=>'span2 integer','readonly'=>TRUE))."</td>
                        <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',array("rel"=>"tooltip","title"=>"Klik untuk membatalkan permintaan penawaran",'href'=>'','onclick'=>'hapusObat(this);return false;','style'=>'text-decoration:none;'))."</td>
                      </tr>   
                    ";
           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }

    /**
     * untuk menampilkan data obat sesuai supplier
     */
    public function actionGetSupplier(){
        if(Yii::app()->request->isAjaxRequest) { 
            $supplier_id = $_POST['supplier_id'];
            $modObatSupplier = ObatsupplierM::model()->findAll('supplier_id='.$supplier_id);
            $data['supplier_id'] = $supplier_id;

           echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    /**
     * Auto complete pegawai mengetahui
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
     * Auto complete pegawai menyetujui
     */
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
     * Autocomplete rencana kebutuhan obat farmasi
     */
    public function actionAutocompleteRencanaKebutuhanFarmasi()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(noperencnaan)', strtolower($_GET['term']), true);
            $criteria->order = 'noperencnaan';
            $criteria->limit = 5;
            $models = ADRencanaKebFarmasiT::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->noperencnaan;
                $returnVal[$i]['value'] = $model->rencanakebfarmasi_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
}