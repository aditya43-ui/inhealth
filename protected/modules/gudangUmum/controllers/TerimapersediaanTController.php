<?php

class TerimapersediaanTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
  public $successSave = false;
  public $pesan = "";

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex($id = null, $terimaid = null)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new GUTerimapersediaanT;
		$format= new MyFormatter;
		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$model->nopenerimaan = 'Otomatis';				
		$modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
		$model->peg_penerima_id = $modLogin->pegawai_id;
		if (!empty($modLogin->pegawai_id)) $model->peg_penerima_nama = $modLogin->pegawai->nama_pegawai;
		$model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
                
    $modRuangPenerimaan = RuanganM::model()->findByPk($model->ruanganpenerima_id);
    
    if(isset($modRuangPenerimaan)){
        $model->instalasi_id = $modRuangPenerimaan->instalasi_id;
        $model->ruanganpenerima_nama = $modRuangPenerimaan->ruangan_nama;
        $model->instalasi_nama = (!empty($modRuangPenerimaan->instalasi_id)?$modRuangPenerimaan->instalasi->instalasi_nama:"");
    }
                
		$model->tglterima = date('Y-m-d H:i:s');
		$model->tglsuratjalan = date('Y-m-d H:i:s');
		$model->tglfaktur = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
		$model->totalharga = 0 ;
		$model->discount = 0;
		$model->biayaadministrasi = 0;
		$model->pajakpph = 0;
		$model->pajakppn =0;
    $model->is_langsungfaktur = false;

		$modDetails = array();
		$modPesan = array();
		 $modBeli = new PembelianbarangT;
                 $modUangMuka = new UangmukabeliT();
		$modDetailBeli = array();
                 
                $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
                if(isset($modApprovalotorisasiM)){
                    $model->peg_mengetahui_id = $modApprovalotorisasiM->kepalaumum_id; 
                    $model->peg_mengetahui_nama = $modApprovalotorisasiM->kepalaumum->namaLengkap;
                }
        
                if (isset($_GET['id'])){
                    $id = $_GET['id'];
                    if (!empty($id)) {
                        $modBeli = PembelianbarangT::model()->find('pembelianbarang_id = '.$id.' and terimapersediaan_id is null');
                        if (!empty($modBeli)){
                            
                            if (!empty($modBeli->supplier_id)) {
                                $supplier = SupplierM::model()->findByPk($modBeli->supplier_id);
                                $model->supplier_nama = empty($supplier) ? null : $supplier->supplier_nama;
                                $model->supplier_id = $modBeli->supplier_id;
                            }
                            
                            if(!empty($modBeli->pembelianbarang_id)){
                                $modUangMuka = UangmukabeliT::model()->findByAttributes(array('pembelianbarang_id'=>$modBeli->pembelianbarang_id));
                                if(isset($modUangMuka)){
                                    $modUangMuka->tgluangmukabeli = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
                                    $model->jlmuangmukabeli = MyFormatter::formatNumberForPrint($modUangMuka->jumlahuang,2);
                                }else{
                                    $modUangMuka = new UangmukabeliT();
                                }
                            }
                            
                            $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$id));
                            $model->pembelianbarang_id = $id;
                            $model->sumberdana_id = $modBeli->sumberdana_id;
                            $modSumberdana = SumberdanaM::model()->findByPk($model->sumberdana_id);
                            $model->pajak_id = $modBeli->pajak_id;
                            
                            if(isset($modSumberdana)){
                                $model->sumberdana = $modSumberdana->sumberdana_nama;
                            }
                            
                            foreach ($modDetailBeli as $i=>$row){
                                $modDetails[$i] = new TerimapersdetailT();
                                $modDetails[$i]->attributes = $row->attributes;
                                $modDetails[$i]->jmlterima = $row->jmlbeli;
                                $modDetails[$i]->jmlbeli = $row->jmlbeli;
                                $modDetails[$i]->jmldalamkemasan = $row->jmldlmkemasan; //$row->barang->barang_jmldlmkemasan;
                                $modDetails[$i]->kondisibarang = "Baik";
//                                if($row->persenppn == 0){
//                                   $modDetails[$i]->persenppn = 10; 
//                                }
                                $modDetails[$i]->persenppn = $row->persen_ppn;
                                $modDetails[$i]->hargabeli = MyFormatter::formatNumberForPrint($modDetails[$i]->hargabeli, 2);
                                $modDetails[$i]->hargasatuan = MyFormatter::formatNumberForPrint($modDetails[$i]->hargasatuan, 2);
//                                $modDetails[$i]->hargasatuan = MyFormatter::formatNumberForPrint($modDetails[$i]->hargasatuan, 2);
//                                var_dump($modDetails[$i]->attributes); die;
                            }
                        }
                    }
                }
				
				if (!empty($terimaid)) {
					$model = GUTerimapersediaanT::model()->findByPk($terimaid);
					$modBeli->supplier_id = $model->supplier_id;
					$modDetails = GUTerimapersdetailT::model()->findAllByAttributes(array(
						'terimapersediaan_id'=>$terimaid,
					));
					if (!empty($model->peg_penerima_id)) $model->peg_penerima_nama = $model->penerima->nama_pegawai;
					if (!empty($model->peg_mengetahui_id)) $model->peg_penerima_nama = $model->mengetahui->nama_pegawai;
				}

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['GUTerimapersediaanT']))
		{
			$format= new MyFormatter;
                        
      $model->attributes=$_POST['GUTerimapersediaanT'];
			$model->nopenerimaan = MyGenerator::noPenerimaanPersediaan($instalasi_id);
      $tglTerima = "";
      $tglSrtJalan = "";
      $tglfaktur = "";
      $tglJthTempo = "";
      
      if(!empty($_POST['GUTerimapersediaanT']['tglterima'])){
          $dateTerima = $format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tglterima']);
          // $timeTerima = date("H:i:s");
          $tglTerima = $dateTerima; // . " ".$timeTerima;
      }
      
        if(!empty($_POST['GUTerimapersediaanT']['tglsuratjalan'])){
          $dateSrtJalan = $format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tglsuratjalan']);
          // $timeSrtJalan = date("H:i:s");
          $tglSrtJalan = $dateSrtJalan; // . " ".$timeSrtJalan;
      }
      
        if(!empty($_POST['GUTerimapersediaanT']['tglfaktur'])){
          $datefaktur = $format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tglfaktur']);
          // $timefaktur = date("H:i:s");
          $tglfaktur = $datefaktur; //. " ".$timefaktur;
      }
      
        if(!empty($_POST['GUTerimapersediaanT']['tgljatuhtempo'])){
          $dateTempo = $format->formatDateTimeForDb($_POST['GUTerimapersediaanT']['tgljatuhtempo']);
          // $timeTempo = date("H:i:s");
          $tglJthTempo = $dateTempo; //. " ".$timeTempo;
      }
                        
			$model->tglterima=$tglTerima;
			$model->tglsuratjalan=$tglSrtJalan;
      if (Yii::app()->user->getState('isfakturdigudang') == true && (!empty($_POST['GUTerimapersediaanT']['is_langsungfaktur']) && $_POST['GUTerimapersediaanT']['is_langsungfaktur'] == 1)){ 
        $model->tglfaktur = $tglfaktur;
        $model->tgljatuhtempo = $tglJthTempo;
        $model->nofaktur = $_POST['GUTerimapersediaanT']['nofaktur'];
        $model->syaratbayar_id = $_POST['GUTerimapersediaanT']['syaratbayar_id'];
        $model->keteranganfaktur = $_POST['GUTerimapersediaanT']['keteranganfaktur'];
      }
			$model->create_time=date("Y-m-d");
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        // $model->supplier_id = $_POST['PembelianbarangT']['supplier_id'];
                        //$model->carapembayaran = $_POST['GUTerimapersediaanT']['carapembayaran'];
                        //var_dump($model->attributes);die;
			if (!empty($id)) $model->pembelianbarang_id = $id;
			else if (isset($_POST['PembelianbarangT']['pembelianbarang_id'])) {
				$model->pembelianbarang_id = $_POST['PembelianbarangT']['pembelianbarang_id'];
			}
			
			// var_dump($_POST, $model->attributes); die;
			
			if (count((array)$_POST['TerimapersdetailT']) > 0){
                            if ($model->validate()){
                                $transaction = Yii::app()->db->beginTransaction();
								$success = true;
                                try{
                                    if($model->save()){


                                        if (empty($id)) {
                                            $modDetailBeli = new BelibrgdetailT;
                                        } else {
                                            $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$id));
                                        }
                                        $modDetails = $this->validasiTabular($model, $_POST['TerimapersdetailT'], $modDetailBeli);
                                        if (!empty($model->pembelianbarang_id)){
                                            PembelianbarangT::model()->updateByPk($model->pembelianbarang_id, array('terimapersediaan_id'=>$model->terimapersediaan_id));
                                        }
                                        $modDetails = $this->validasiTabular($model, $_POST['TerimapersdetailT'], $modDetailBeli);
                                        foreach ($modDetails as $i=>$data){
                                            if ($data->jmlterima > 0){
                                                $modInven = new InventarisasiruanganT();
                                                $modInven->ruangan_id = $model->ruanganpenerima_id;
                                                $modInven->barang_id = $data->barang_id;
                                                $modInven->tgltransaksi = date('Y-m-d');
                                                $modInven->inventarisasi_kode = MyGenerator::kodeTerimaPersediaan();
                                                $modInven->inventarisasi_hargabeli = $data->hargabeli;
                                                $modInven->inventarisasi_hargasatuan = $data->hargasatuan;
                                                $modInven->inventarisasi_qty_in = $data->jmlterima;
                                                $modInven->inventarisasi_qty_out = 0;
                                                $modInven->inventarisasi_qty_skrg = $data->jmlterima;
                                                $modInven->inventarisasi_keadaan = $data->kondisibarang;
												
												// var_dump($modInven->attributes, $modInven->validate(), $modInven->errors);
												
                                                if ($modInven->save()){
                                                    $data->inventarisasi_id = $modInven->inventarisasi_id;

                                                    if ($data->save()){
                                                        InventarisasiruanganT::model()->updateByPk($modInven->inventarisasi_id, array('terimapersdetail_id'=>$data->terimapersdetail_id));

                                                        if (Yii::app()->user->getState('isfakturdigudang') == true && (!empty($_POST['GUTerimapersediaanT']['is_langsungfaktur']) && $_POST['GUTerimapersediaanT']['is_langsungfaktur'] == 1)){ 
                                                          $this->updateHargaBarang($data);
    
                                                          if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                                                            $alkesOa = $data->barang;
                                              
                                                            $modJnsOaFaktur = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $alkesOa->jenisbarang_id, 'ispenerimaanoa' => true, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
                                                           
                                                            $jmlQty = round(($data->hargasatuan * $data->jmlterima),2);
                                                            $hargaNettoDiskon = round(($jmlQty - $data->jmldiscount),2);
                                                            $jmlPPn = round(($hargaNettoDiskon * ($data->persenppn / 100)),2);
                                                            $jmlPPh = round(($hargaNettoDiskon * ($data->persenpph / 100)),2);
                                                            $jmlAll = round(($hargaNettoDiskon + $jmlPPn - $jmlPPh),2);
                                              
                                                            if(!empty($modJnsOaFaktur)){
                                                              $modJurnalRekening = $this->saveJurnalRekeningFaktur($model, $data);
                                                              $nourutJurnal = 1;
                                                              $rek_d = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $alkesOa->jenisbarang_id, 'ispenerimaanoa' => true, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'debitkredit'=>'D'));
                                                              if(!empty($rek_d) && $jmlQty > 0){
                                                                $this->saveJurnalDetailFaktur($modJurnalRekening, $rek_d->rekening5_id, $jmlQty, 0, $nourutJurnal);
                                                                $nourutJurnal = ($nourutJurnal + 1);
                                                              }
                                              
                                                              $rek_diskon = RekeningcolumnM::model()->findByAttributes(array('table_name'=> Params::REKENINGCOLUMN_TABLE_TERIMAPERSDETAILT,'column_name'=> Params::REKENINGCOLUMN_COLUMN_JMLDISCOUNT,'debitkredit'=>'D'));
                                                              if(!empty($rek_diskon) && $data->jmldiscount > 0){
                                                                $this->saveJurnalDetailFaktur($modJurnalRekening, $rek_diskon->rekening5_id, $data->jmldiscount, 0, $nourutJurnal);
                                                                $nourutJurnal = ($nourutJurnal + 1);
                                                              }
                                              
                                                              $rekppn = PajakM::model()->findByAttributes(array('isppnmasukan'=>true, 'debitkredit'=>'K'));
                                                              if(!empty($rekppn) && $jmlPPn > 0){
                                                                $this->saveJurnalDetailFaktur($modJurnalRekening, $rekppn->rekening5_id, 0, $jmlPPn, $nourutJurnal);
                                                                $nourutJurnal = ($nourutJurnal + 1);
                                                              }
                                              
                                                              if(!empty($model->pajak_id)){
                                                                $rekpph = PajakM::model()->findByAttributes(array('pajak_id'=>$model->pajak_id, 'debitkredit'=>'K'));
                                                                if(!empty($rekpph) && $jmlPPh > 0){
                                                                  $this->saveJurnalDetailFaktur($modJurnalRekening, $rekpph->rekening5_id, 0, $jmlPPh, $nourutJurnal);
                                                                  $nourutJurnal = ($nourutJurnal + 1);
                                                                }
                                                              }
                                                              
                                                              $rek_k = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $alkesOa->jenisobatalkes_id, 'ispenerimaanoa' => true, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'debitkredit'=>'K'));
                                                              if(!empty($rek_k) && $data->hargasatuan > 0){
                                                                $this->saveJurnalDetailFaktur($modJurnalRekening, $rek_k->rekening5_id, 0, $data->hargasatuan, $nourutJurnal);
                                                              }
                                                              
                                                            }
                                                          }
    
                                                        }
                                                    }
                                                    else{
                                                        $success = false;
                                                    }
                                                }
                                                else{
                                                    $success = false;
                                                }
                                            }
                                        }

                                        if(Yii::app()->user->getState('isjurnalotomatis') == true){
                                          //Jurnal Terima 
                                          if(Yii::app()->user->getState('isjurnalfaktur') == true){
                                            $modPenerima = TerimapersediaanT::model()->findByPk($model->terimapersediaan_id);
                                            $modDetailPene = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id'=>$modPenerima->terimapersediaan_id));
                                
                                            if(!empty($modDetailPene)){
                                              foreach($modDetailPene as $oriDetailPen){
                                                $modOa = BarangM::model()->findByPk($oriDetailPen->barang_id);
                                                if(!empty($modOa->jenisbarang_id)){
                                                  $modRekOa = JenisbarangrekM::model()->findAllByAttributes(array('jenisbarang_id' => $modOa->jenisbarang_id, 'isterimagudang' => true, 'ruangan_id'=> Yii::app()->user->getState('ruangan_id')), array('order'=>'debitkredit ASC'));
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
                                    else{
                                        $success = false;
                                    }
                                    
                                    if ($success == true) {
                                        // $res = Yii::app()->db
                                        //         ->createCommand("select set_afterterimapersediaan_fix(" . $model->terimapersediaan_id . ") as simpan")
                                        //         ->queryRow();

                                        // if (!empty($res)) {
                                        //     $success = $success && $res['simpan'];
                                        // }                            
                                    }  
									
									// var_dump($success); die;
									
                                    if ($success == true){
                                        
                                        //START NOTIFIKASI
                                        $judul = 'Penerimaan Barang';

                                        $isi = (!empty($model->peg_penerima_id)?$model->penerima->namaLengkap:$model->nama_pemakai)." sudah menerima barang dengan No Terima  ".$model->nopenerimaan;

                                        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
                                        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
                                        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
                                        
                                        
                                        CustomFunction::broadcastNotif($judul, $isi, array(
                                            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id),
                                            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id),
                                            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id),                      
                                        ));   
                                        //END NOTIFIKASI
                                        
                                        $sukses = 1;
                                        $transaction->commit();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        //if (isset($model->pembelianbarang_id)){
                                        //    $this->redirect(array('index','id'=>$model->pembelianbarang_id,'sukses'=>$sukses));
                                        //}
                                        //else{
                                            $this->redirect(array('index','terimaid'=>$model->terimapersediaan_id,'sukses'=>$sukses));
                                        //}
                                    }
                                    else{
                                        $transaction->rollback();
                                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                                    }
                                }
                                catch (Exception $ex){
                                     $transaction->rollback();
                                     Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                                }
                            }
                        }else{
                            $model->validate();
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
                        }
		}
                if (!isset($modDetails)){
                    $modDetails = null;
                }
                if (!isset($modDetailBeli)){
                    $modDetailBeli = null;
                }
                        
		$this->render('index',array(
			'model'=>$model, 'modDetails'=>$modDetails, 'modBeli'=>$modBeli, 'modDetailBeli'=>$modDetailBeli,'modUangMuka'=>$modUangMuka
		));
	}
        
        protected function validasiTabular($model, $data, $beli){
            $valid = true;
            foreach ($data as $i=>$row){
                $modDetails[$i] = new TerimapersdetailT();
                $modDetails[$i]->attributes = $row;
                $modDetails[$i]->terimapersediaan_id = $model->terimapersediaan_id;
                if (!empty($beli->pembelianbarang_id)){
                    $modDetails[$i]->jmlbeli = $beli[$i]->jmlbeli;
                }
                $valid = $modDetails[$i]->validate() && $valid;
				
				// var_dump($modDetails[$i]->attributes, $valid, $modDetails[$i]->errors);
				
            }
            
            return $modDetails;
        }
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(GURuanganM::getRuanganPenerimas($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count((array)$models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	//Pencarian Penerimaan Persediaan barang 
    public function actionGetPenerimaanPersediaanBarang(){
        if (Yii::app()->request->isAjaxRequest){
            $idBarang = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            
            $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($idBarang);
            $modDetail = new TerimapersdetailT();
            $modDetail->barang_id = $idBarang;
            $modDetail->satuanbeli = $satuan;
            $modDetail->jmlterima = MyFormatter::formatNumberForPrint($jumlah, 2);
            $modDetail->hargabeli=$modBarang->barang_harganetto * $jumlah;
            $modDetail->hargasatuan = MyFormatter::formatNumberForPrint($modBarang->barang_harganetto,2);
            $modDetail->jmldalamkemasan = (!empty($modBarang->barang_jmldlmkemasan)? $modBarang->barang_jmldlmkemasan : 1);
            $modDetail->kondisibarang = "Baik";
            
            $tr = $this->renderPartial('_detailPenerimaanPersediaanBarang', array('modBarang'=>$modBarang, 'modDetail'=>$modDetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
		
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['GUTerimapersediaanT']))
		{
			$model->attributes=$_POST['GUTerimapersediaanT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->terimapersediaan_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('GUTerimapersediaanT');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new GUTerimapersediaanT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GUTerimapersediaanT']))
			$model->attributes=$_GET['GUTerimapersediaanT'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=GUTerimapersediaanT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='guterimapersediaan-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionInformasi()
	{
//                
		$model=new GUTerimapersediaanT('search');
//		$model->unsetAttributes();  // clear any default values
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
//                $model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
		if(isset($_GET['GUTerimapersediaanT'])){
                    $model->attributes=$_GET['GUTerimapersediaanT'];
                    $format = new MyFormatter();
                    $model->supplier_id=$_GET['GUTerimapersediaanT']['supplier_id'];
                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                }

		$this->render('informasi',array(
			'model'=>$model,
		));
	}
        
        public function actionDetailTerimaPersediaan($id){
            $this->layout ='//layouts/iframe';
            $modTerima = TerimapersediaanT::model()->findByPk($id);
            $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id'=>$modTerima->terimapersediaan_id));
            $this->render('detailInformasi', array(
                'modTerima'=>$modTerima,
                'modDetailTerima'=>$modDetailTerima,
            ));
        }
        
        public function actionPrint($id){
            $this->layout='//layouts/printWindows';
            $judulLaporan='Data Penerimaan Barang';
            
            $modTerima = TerimapersediaanT::model()->findByPk($id);
            $modDetailTerima = TerimapersdetailT::model()->findAllByAttributes(array('terimapersediaan_id'=>$modTerima->terimapersediaan_id));
            $this->render('detailInformasi', array(
                'judulLaporan'=>$judulLaporan, 
                'modTerima'=>$modTerima,
                'modDetailTerima'=>$modDetailTerima,
            ));
        }
        
    public function actionReturPenerimaan($id){
        $this->layout = 'iframe';
        $model = new ReturpenerimaanT();
        $modTerima = TerimapersediaanT::model()->find('terimapersediaan_id  = '.$id.' and returpenerimaan_id is null');
        $modDetailTerima = TerimapersdetailT::model()->findAll('terimapersediaan_id = '.$id.' and retpendetail_id is null');
        if ((!empty($modTerima)) && (count((array)$modDetailTerima) > 0)){
            $model->tglreturterima = date('Y-m-d H:i:s');
            $model->terimapersediaan_id = $modTerima->terimapersediaan_id;
            $model->noreturterima = MyGenerator::noReturTerima();
            $this->render('returPenerimaan', array(
                'model'=>$model,
            ));
        }
        else{
            echo 'Barang telah dibatal mutasikan';
        }
        if (isset($_POST['BatalmutasibrgT'])){
            $modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $success = true;
                $modBatals = $this->validateTableBatal($_POST['BatalmutasibrgT']);
                foreach ($modBatals as $i => $data) {
                    if ($data->qty_batal > 0){
                        $modInventaris = InventarisasiruanganT::model()->findByAttributes(array('barang_id'=>$data->barang_id),array('order'=>'tgltransaksi', 'limit'=>1));
                        if ($data->save()) {
                            InventarisasiruanganT::kembalikanStok($data->qty_batal, $data->barang_id);
                            MutasibrgdetailT::model()->updateByPk($_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'], array('batalmutasibrg_id'=>$data->batalmutasibrg_id));
                            InventarisasiruanganT::model()->updateAll(array('batalmutasibrg_id'=>$data->batalmutasibrg_id),'mutasibrgdetail_id = '.$_POST['BatalmutasibrgT']['barang_id'][$i]['mutasibrgdetail_id'].' and barang_id = '.$data->barang_id);
                        } else {
                            $success = false;
                        }
                    }
                }

                if ($success == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->refresh();
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        
        
    }
	
	public function actionAutoCompletePembelian($term = null) {
		if(Yii::app()->request->isAjaxRequest && !empty($term)) {
			$crit = new CDbCriteria;
			$crit->compare('lower(nopembelian)', strtolower($term), true);
			$crit->addCondition('terimapersediaan_id is null');
			$dat = PembelianbarangT::model()->findAll($crit);
			
			$res = array();
			foreach ($dat as $item) {
				$sub = $item->attributes;
				$sub['label'] = $item->nopembelian;
				$sub['value'] = $item->pembelianbarang_id;
				$sub['tglpembelian'] = MyFormatter::formatDateTimeForUser($sub['tglpembelian']);
				array_push($res, $sub);
			}
			
			echo CJSON::encode($res);
		}
		Yii::app()->end();
	}
	
	public function actionLoadBarang() {
		if(Yii::app()->request->isAjaxRequest) {
			$res = array();
			
			$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$_POST['id']));
			$modDetails = array();
			$col = "";
			foreach ($modDetailBeli as $i => $item) {
				$modBarang = BarangM::model()->findByPk($item->barang_id);
				$modDetails[$i] = new TerimapersdetailT();
				$modDetails[$i]->attributes = $item->attributes;
				$modDetails[$i]->jmlterima = $item->jmlbeli;
				$modDetails[$i]->jmlbeli = $item->jmlbeli;
				$modDetails[$i]->jmldalamkemasan = (!empty($item->jmldlmkemasan)? $item->jmldlmkemasan : 1); //$row->barang->barang_jmldlmkemasan;
			
				$col .= $this->renderPartial('_detailPenerimaanPersediaanBarang', array('modDetail'=>$modDetails[$i], 'modBarang'=>$modBarang), true);
				
			}
			
			$res['tab'] = $col;
			
			echo CJSON::encode($res);
		}
		
		Yii::app()->end();
	}
        
    
    public function actionPrintInformasi($caraPrint) {
        $model=new GUTerimapersediaanT('search');
//		$model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
        if(isset($_GET['GUTerimapersediaanT'])){
            $model->attributes=$_GET['GUTerimapersediaanT'];
            $format = new MyFormatter();
            $model->supplier_id=$_GET['GUTerimapersediaanT']['supplier_id'];
            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
        }
        
        $this->printFunction($model, $caraPrint, "Informasi Penerimaan Persediaan Barang", "printInformasi");
		
    }
    
    
    protected function printFunction($model, $caraPrint, $judulLaporan, $target)
    {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
//            //$mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
           
            
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        } else if ($caraPrint == "CSV") {
            CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
        }
    }

    public function actionAutoCompleteSupplier($term = null) {
      if (!Yii::app()->request->isAjaxRequest) {
          Yii::app()->end();
      }
      
      $criteria = new CDbCriteria;
      $criteria->compare('lower(supplier_nama)', strtolower($term), true);
      $criteria->compare('lower(supplier_jenis)', strtolower(Params::SUPPLIER_JENIS_UMUM), false);
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
    $modJurnalRekening->noreferensi = $model->nopenerimaan;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglterima);
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Penerimaan Pembelian ' . $ruangan->ruangan_nama.' - '. (!empty($modOa->jenisbarang) ? $modOa->jenisbarang->jenisbarang_nama : "") . " " . $modOa->barang_nama . " - " . $model->nopenerimaan;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->terimapersediaan_id = $model->terimapersediaan_id;

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

  public function updateHargaBarang($detail)
  {

    $barang = BarangM::model()->findByPk($detail['barang_id']);
    $barang->barang_persendiskon = (!empty($detail['persendiscount']) ? $detail['persendiscount'] : 0);
    $barang->barang_ppn = (!empty($detail['jmlppn']) ? $detail['jmlppn'] : 0);
    $jmlDiskon = (($detail['hargasatuan'] * $detail['persendiscount']) / 100);
    $jmlPpn = ((($detail['hargasatuan'] - $jmlDiskon) * $detail['persenppn']) / 100);
    $jmlPph = ((($detail['hargasatuan'] - $jmlDiskon) * $detail['persenpph']) / 100);

    $updateHarganetto = false;

    if ($barang->barang_harganetto != $detail['hargasatuan']) {
      if ($detail['hppcheck'] > 0) {
        $updateHarganetto = true;
      }
    }
    if ($updateHarganetto) {
      $barang->barang_harganetto = $detail['hargasatuan'];
      $judul = 'Perubahan Harga Netto Barang';
      $isi = $barang->barang_nama;
      CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => Params::INSTALASI_ID_LOGISTIK, 'ruangan_id' => Params::RUANGAN_ID_LOGISTIK, 'modul_id' => Params::MODUL_ID_GUDANGUMUM),
      ));
    }

    $hpp = ($detail['hargasatuan'] - $jmlDiskon + $jmlPpn - $jmlPph);
    $barang->barang_hpp = $hpp;
    $barang->barang_hargajual = $hpp;
    $barang->barang_jmldlmkemasan = $detail['jmldalamkemasan'];
    $barang->save();
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
    $modJurnalRekening->urianjurnal = 'Faktur Pembelian ' . (!empty($dtFakturDetail->barang->jenisbarang_id) ? $dtFakturDetail->barang->jenisbarang->jenisbarang_nama : "") . " " . $dtFakturDetail->barang->barang_nama . " - " . $modPenUmum->supplier->supplier_nama . " - " . $modPenUmum->nofaktur;

    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $modPenUmum->ruangan_id;
    $modJurnalRekening->terimapersediaan_id = $modPenUmum->terimapersediaan_id;

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
}
