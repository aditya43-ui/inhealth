<?php

class FakturPembelianController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'gudangFarmasi.views.fakturPembelian.';
    public $fakturpembeliantersimpan = true;
    public $fakturpembeliandetailtersimpan = true;
    public $succesSave = true;
    public $successSave = true;
    public $pesan = "";
    
    public function actionIndex($penerimaanbarang_id = null, $fakturpembelian_id = null){
        $format = new MyFormatter();
        $modPenerimaanBarang = new GFPenerimaanBarangT;
        $modFakturPembelian = new GFFakturpembelianT;
        $modUangmuka = new UangmukabeliT();
        $modDetails = array();
        
        $modFakturPembelian->tglfaktur = date('Y-m-d H:i:s');
        $modFakturPembelian->tgljatuhtempo = date('Y-m-d 00:00:00');
        $modFakturPembelian->biayamaterai = 0;        
        
        if(!empty($penerimaanbarang_id)){
            $modPenerimaanBarang= GFPenerimaanBarangT::model()->findByPk($penerimaanbarang_id);
            $modPenerimaanBarang->supplier_nama = $modPenerimaanBarang->supplier->supplier_nama;
            $modPenerimaanBarang->pegawai_nama = $modPenerimaanBarang->pegawai->namaLengkap;
            $modPenerimaanBarang->menyetujui_nama = empty($modPenerimaanBarang->pegawaimenyetujui) ? "" : $modPenerimaanBarang->pegawaimenyetujui->namaLengkap;
            $modPenerimaanBarang->mengetahui_nama = empty($modPenerimaanBarang->pegawaimengetahui) ? "" : $modPenerimaanBarang->pegawaimengetahui->namaLengkap;			
            $modPenerimaanBarang->tglterima = MyFormatter::formatDateTimeForUser($modPenerimaanBarang->tglterima);
            $modPenerimaanBarang->jmldiscount = number_format($modPenerimaanBarang->jmldiscount,0,"",".");
            $modPenerimaanBarang->totalharga = number_format($modPenerimaanBarang->totalharga,0,"",".");
            $modPenerimaanBarang->totalpajakppn = number_format($modPenerimaanBarang->totalpajakppn,0,"",".");
            $modPenerimaanBarang->harganetto = number_format($modPenerimaanBarang->harganetto,0,"",".");
			
            $modDetails = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
			
            if (!empty($modPenerimaanBarang->permintaanpembelian_id)) {
                $permintaan = PermintaanpembelianT::model()->findByPk($modPenerimaanBarang->permintaanpembelian_id);
                $modFakturPembelian->syaratbayar_id = $permintaan->syaratbayar_id;
            }
        }
        
        if(!empty($fakturpembelian_id)){
            $modFakturPembelian = GFFakturpembelianT::model()->findByPk($fakturpembelian_id);
            $modFakturPembelianDetail = GFFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
            $modDetails = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$modFakturPembelian->penerimaanbarang_id));
        }
        
        if (isset($_POST['GFFakturpembelianT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
               
                $modFakturPembelian->attributes=$_POST['GFFakturpembelianT'];
                $modFakturPembelian->penerimaanbarang_id = $_POST['GFPenerimaanBarangT']['penerimaanbarang_id'];
                $modFakturPembelian->supplier_id = $_POST['GFPenerimaanBarangT']['supplier_id'];
                $modFakturPembelian->tglfaktur = $format->formatDateTimeForDb($modFakturPembelian->tglfaktur);
                $modFakturPembelian->tgljatuhtempo = $format->formatDateTimeForDb($modFakturPembelian->tgljatuhtempo);
                $modFakturPembelian->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modFakturPembelian->create_time = date('Y-m-d H:i:s');
                $modFakturPembelian->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modFakturPembelian->create_ruangan = Yii::app()->user->getState('create_ruangan');
                $modFakturPembelian->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $modFakturPembelian->pegawaimengetahui_id = $_POST['GFPenerimaanBarangT']['pegawaimengetahui_id'];
                $modFakturPembelian->pegawaimenyetujui_id = $_POST['GFPenerimaanBarangT']['pegawaimenyetujui_id'];
                
                if ($modFakturPembelian->validate()) {
                    if($modFakturPembelian->save()){
                       $updatePenerimaanBarang = GFPenerimaanBarangT::model()->findByPk($_POST['GFPenerimaanBarangT']['penerimaanbarang_id']);
                        if(isset($updatePenerimaanBarang)){
                            $updatePenerimaanBarang->fakturpembelian_id = $modFakturPembelian->fakturpembelian_id;
                            $updatePenerimaanBarang->tglterimafaktur = $modFakturPembelian->tglfaktur;

                            if($updatePenerimaanBarang->harganetto != $modFakturPembelian->totharganetto){
                                $updatePenerimaanBarang->harganetto = $modFakturPembelian->totharganetto;
                            }

                             if($updatePenerimaanBarang->jmldiscount != $modFakturPembelian->jmldiscount){
                                $updatePenerimaanBarang->jmldiscount = $modFakturPembelian->jmldiscount;
                            }

                            if($updatePenerimaanBarang->persendiscount != $modFakturPembelian->persendiscount){
                                $updatePenerimaanBarang->persendiscount = $modFakturPembelian->persendiscount;
                            }

                            if($updatePenerimaanBarang->totalpajakppn != $modFakturPembelian->totalpajakppn){
                                $updatePenerimaanBarang->totalpajakppn = $modFakturPembelian->totalpajakppn;
                            }

                            if($updatePenerimaanBarang->totalharga != $modFakturPembelian->totalhargabruto){
                                $updatePenerimaanBarang->totalharga = $modFakturPembelian->totalhargabruto;
                            }
                            $updatePenerimaanBarang->save();
                        }

    //                    $updatePenerimaanBarang = GFPenerimaanBarangT::model()->updateByPk($_POST['GFPenerimaanBarangT']['penerimaanbarang_id'],array('fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id, 'tglterimafaktur'=>$modFakturPembelian->tglfaktur));
                        if(count((array)$_POST['GFPenerimaanDetailT']) > 0){
                           foreach($_POST['GFPenerimaanDetailT'] AS $i => $postFakturDetail){
                               $modDetails[$i] = $this->simpanFakturDetail($postFakturDetail,$modFakturPembelian);
                           }
                        } 
                    }
                    
                } else {
                    $this->fakturpembeliantersimpan = false;
                }
              
                if($this->fakturpembeliantersimpan && $this->fakturpembeliandetailtersimpan){
                    
                    
                    if(Yii::app()->user->getState('isjurnalotomatis') == true){
                        
                        $checkDatadetail = 0;
                        $modDetailFaktur = FakturdetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id));
                        
                        if(count((array)$modDetailFaktur)>0){
                            foreach ($modDetailFaktur as $dtFakturDetail){
                                $modObatAlkesM = ObatalkesM::model()->findByPk($dtFakturDetail->obatalkes_id);
                                if(isset($modObatAlkesM)){
                                    $modJenisObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modObatAlkesM->jenisobatalkes_id, 'ispenerimaanoa'=>true));
                                
                                    if(count((array)$modJenisObatRek)>0){
                                        $checkDatadetail++;
                                    }else{
                                        if($checkDatadetail > 1){
                                            $checkDatadetail--;
                                        }
                                    }
                                }
                            }
                        }
                        
                        if($checkDatadetail > 0){
                            foreach ($modDetailFaktur as $dtFakturDetail){
                                $modObatAlkesM = ObatalkesM::model()->findByPk($dtFakturDetail->obatalkes_id);
                                if(isset($modObatAlkesM)){
                                    $modJenisObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modObatAlkesM->jenisobatalkes_id, 'ispenerimaanoa'=>true));
                                    if(count((array)$modJenisObatRek) >0){
                                        $modJurnalRekening = $this->saveJurnalRekening($modFakturPembelian, $dtFakturDetail);
                                        foreach ($modJenisObatRek as $dtJenisrek){
                                            $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $dtJenisrek);
                                        }
                                        if($modFakturPembelian->totalpajakppn > 0){
                                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '".Params::REKENINGCOLUMN_TABLE_FAKTURDETAILT."' AND column_name = '".Params::REKENINGCOLUMN_COLUMN_OBATALKESID."'");
                                            if(isset($rekeningcolumn)){
                                                $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $rekeningcolumn,true);
                                            }
                                        }
                                        
                                        if($modFakturPembelian->totalpajakpph > 0){
                                             $modPajak = PajakM::model()->findByPk($modFakturPembelian->pajak_id);

                                                if(isset($modPajak)){
                                                   if(!empty($modPajak->rekening5_id)){
                                                      $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $modPajak,null,true);
                                                   }
                                                }
                                            
                                            
//                                            $rekeningcolumn = RekeningcolumnM::model()->find("table_name = '".Params::REKENINGCOLUMN_TABLE_FAKTURDETAILT."' AND column_name = '".Params::REKENINGCOLUMN_COLUMN_PERSENPPHFAKTUR."'");
//                                            if(isset($rekeningcolumn)){
//                                                $this->saveJurnalDetail($modJurnalRekening, $dtFakturDetail, $rekeningcolumn,null,true);
//                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                        $modJurnalFaktuAfter = JurnalrekeningT::model()->findAllByAttributes(array('fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id));
                        
                        if(count((array)$modJurnalFaktuAfter) > 0){
                            $rekening_id = null;
                            
                            foreach ($modJurnalFaktuAfter as $dataFakturAf){
                                $criteriaJud = new CDbCriteria();
                                $criteriaJud->addCondition('jurnalrekening_id = '.$dataFakturAf->jurnalrekening_id);
                                $criteriaJud->addCondition('saldokredit > 0');
                                $criteriaJud->order = "nourut DESC";
                                $criteriaJud->limit=1;
                                $modFakturJurDetAfter = JurnaldetailT::model()->find($criteriaJud);
                                
                                if(isset($modFakturJurDetAfter)){
                                    $rekening_id = $modFakturJurDetAfter->rekening5_id;
                                }
                            }
                            
                            if(!empty($modFakturPembelian->jmluangmukabeli) && $modFakturPembelian->jmluangmukabeli > 0){
                                $modJurnalRekening = $this->saveJurnalRekeningUangMuka($modFakturPembelian);
                                
                                $modRekening5 = Rekening5M::model()->findByPk($rekening_id);
                                
                                if(isset($modRekening5)){
                                    $this->saveJurnalDetailUangMuka($modJurnalRekening, $modRekening5, $modFakturPembelian->jmluangmukabeli,'D', 1);
                                }
                                
                                $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=> Params::REKENINGCOLUMN_TABLE_FAKTURPEMBELIANT,'column_name'=>Params::REKENINGCOLUMN_COLUMN_JMLUANGMUKABELI));
                                if (isset($rekeningcolumn)) {
                                    $this->saveJurnalDetailUangMuka($modJurnalRekening, $rekeningcolumn, $modFakturPembelian->jmluangmukabeli,'K', 2);
                                }
                                
                            }
                        }
                    }
                    
                    $this->notifFaktur($modFakturPembelian);
                    
                    $transaction->commit();
                    
                    $modFakturPembelian->isNewRecord = FALSE;
                    $this->redirect(array('index','fakturpembelian_id'=>$modFakturPembelian->fakturpembelian_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Faktur Pembelian gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Faktur Pembelian gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }
        
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'modPenerimaanBarang'=>$modPenerimaanBarang,
            'modFakturPembelian'=>$modFakturPembelian,
            'modDetails'=>$modDetails,
            'modUangmuka'=>$modUangmuka
        ));
    }
    
    protected function notifFaktur($model) {
        
        //print_r($model->attributes); die;
        
        
        $judul = "Faktur Pembelian Farmasi - ".$model->nofaktur;
        
        $isi = "Tgl. Faktur : ".MyFormatter::formatDateTimeForUser($model->tglfaktur)."<br/>";
        $isi .= "Total Bruto : ".MyFormatter::formatNumberForPrint($model->totalhargabruto)."<br/>";
        
        $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
        //$ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
        
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>$ruanganKeuangan->instalasi_id, 'ruangan_id'=>$ruanganKeuangan->ruangan_id, 'modul_id'=>$ruanganKeuangan->modul_id),
            //array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
        ));
        
        
    }
    
    /**
     * simpan GFFakturDetailT
     * @param type $modPenerimaanBarang
     * @param type $post
     * @return \GFPenerimaanDetailT
     */
    public function simpanFakturDetail($postFakturDetail,$modFakturPembelian){
        $format = new MyFormatter();        
        $modFakturDetail = new GFFakturDetailT;
        $modStok = GFStokObatAlkesT::model()->findByAttributes(array('penerimaandetail_id'=>$postFakturDetail['penerimaandetail_id']));
        
        $modFakturDetail->attributes = $postFakturDetail;
        $modFakturDetail->penerimaandetail_id = $postFakturDetail['penerimaandetail_id'];
        $modFakturDetail->fakturpembelian_id = $modFakturPembelian->fakturpembelian_id;
        $modFakturDetail->harganettofaktur = $postFakturDetail['harganettoper'];
        $modFakturDetail->persenppnfaktur = $postFakturDetail['persenppn'];
        $modFakturDetail->persenpphfaktur = $postFakturDetail['persenpph'];
        $modFakturDetail->persendiscount = $postFakturDetail['persendiscount'];
        $modFakturDetail->jmldiscount = $postFakturDetail['jmldiscount'];
        $modFakturDetail->hargasatuan = $postFakturDetail['hargasatuanper'];
        $modFakturDetail->kemasanbesar = isset($postFakturDetail['kemasanbesar'])?$postFakturDetail['kemasanbesar']:null;
        $modFakturDetail->tglkadaluarsa = $format->formatDateTimeForDb($modFakturDetail['tglkadaluarsa']);
        $modFakturDetail->jmldiscount = $modFakturDetail['jmldiscount'];
        $modFakturDetail->hargasatuan = $modFakturDetail['hargasatuan'];
        $modFakturDetail->harganettofaktur = $modFakturDetail['harganettofaktur'];
              
        if($modFakturDetail->validate()) { 
            $modFakturDetail->save();						
            $updatePenerimaan = GFPenerimaanDetailT::model()->findByPk($modFakturDetail->penerimaandetail_id);

            if(isset($updatePenerimaan)){
                $updatePenerimaan->fakturdetail_id = $modFakturDetail->fakturdetail_id;
                
                if($updatePenerimaan->persendiscount != $modFakturDetail->persendiscount){
                    $updatePenerimaan->persendiscount = $modFakturDetail->persendiscount;
                }
                
                if($updatePenerimaan->jmldiscount != $modFakturDetail->jmldiscount){
                    $updatePenerimaan->jmldiscount = $modFakturDetail->jmldiscount;
                }
                
                if($updatePenerimaan->harganettoper != $modFakturDetail->harganettofaktur){
                    $updatePenerimaan->harganettoper = $modFakturDetail->harganettofaktur;
                }
                
                if($updatePenerimaan->persenppn != $modFakturDetail->persenppnfaktur){
                    $updatePenerimaan->persenppn = $modFakturDetail->persenppnfaktur;
                }
                
                if($updatePenerimaan->hargasatuanper != $modFakturDetail->hargasatuan){
                    $updatePenerimaan->hargasatuanper = $modFakturDetail->hargasatuan;
                }
                
                if($updatePenerimaan->save()){
                    $loadObatAlkes = ObatalkesM::model()->findByPk($updatePenerimaan->obatalkes_id);
                    $harganettolama = $loadObatAlkes->harganetto;
                    $hargajuallama = $loadObatAlkes->hargajual;
                    $hargaBerubah = false;
                     $updateHarganetto = false;
                    
                    if ($loadObatAlkes->harganetto != $updatePenerimaan->harganettoper){
//                        $loadObatAlkes->harganetto = $updatePenerimaan->harganettoper;
                        $hargaBerubah = true;
                        if($postFakturDetail['hppcheck']>0){
                            $updateHarganetto = true;
                        }
                    }
                    
                    if ($loadObatAlkes->ppn_persen != $updatePenerimaan->persenppn){
                        $loadObatAlkes->ppn_persen = $updatePenerimaan->persenppn;
                        $hargaBerubah = true;
                    }
                    
                    if ($loadObatAlkes->discount != $updatePenerimaan->persendiscount){
                        $loadObatAlkes->discount = $updatePenerimaan->persendiscount;
                        $hargaBerubah = true;
                    }
                    if($hargaBerubah){
                        if($updateHarganetto){
                            $loadObatAlkes->harganetto = $updatePenerimaan->harganettoper;
                            
                            $judul = 'Perubahan Harga Netto Obat Alkes';
                            $isi = $loadObatAlkes->obatalkes_nama;
                            CustomFunction::broadcastNotif($judul, $isi, array(				   
                                array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=> Params::RUANGAN_ID_GUDANG_FARMASI, 'modul_id'=>Params::MODUL_ID_GUDANGFARMASI),											   
                            ));
                        }
                        
                        
                        $loadObatAlkes->hpp = $loadObatAlkes->JumHPP;
                        $hargajual = round(($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->margin / 100)),2);
                        if($hargajual > $loadObatAlkes->hargamaksimum){
                            $loadObatAlkes->hargamaksimum = $hargajual;
                        }
                        if($loadObatAlkes->hargaminimum <= 0 || $hargajual < $loadObatAlkes->hargaminimum){
                            $loadObatAlkes->hargaminimum = $hargajual;
                        }
                        if($loadObatAlkes->hargaaverage > 0 && $hargajual > 0){
                            $loadObatAlkes->hargaaverage = round((($loadObatAlkes->hargaaverage + round($hargajual)) / 2),2);
                        }else{
                            $loadObatAlkes->hargaaverage = $hargajual;
                        }

                        $loadObatAlkes->hargajual = $hargajual;
                        $loadObatAlkes->hjaresep = round(($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->marginresep / 100)),2);
                        $loadObatAlkes->hjanonresep = round(($loadObatAlkes->hpp + ($loadObatAlkes->hpp * $loadObatAlkes->marginnonresep / 100)),2);

                        if($loadObatAlkes->save()){

                            $ubah = new UbahhargaobatR();
                            $ubah->obatalkes_id = $loadObatAlkes->obatalkes_id;
                            $ubah->loginpemakai_id = Yii::app()->user->id;
                            $ubah->sumberdana_id = $loadObatAlkes->sumberdana_id;
                            $ubah->tglperubahan = date('Y-m-d');
                            $ubah->alasanperubahan = "Penerimaan Supplier ".$updatePenerimaan->penerimaanbarang->supplier->supplier_nama." - ".$updatePenerimaan->penerimaanbarang->noterima;
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
                }
            }
            
            
                
//            $updatePenerimaan = GFPenerimaanDetailT::model()->updateByPk($modFakturDetail->penerimaandetail_id,array('fakturdetail_id'=>$modFakturDetail->fakturdetail_id));            
            $modStok->tglkadaluarsa = !empty($modFakturDetail->tglkadaluarsa) ? $format->formatDateTimeForDb($modFakturDetail->tglkadaluarsa) : null;
            $modStok->nobatch = "";
            
            $jmlKms = 0;
            
            if(!empty($modFakturDetail->satuanbesar_id)){
                if($modFakturDetail->kemasanbesar > 0){
                    $jmlKms = ($modFakturDetail->jmlterima * $modFakturDetail->kemasanbesar);
                }else{
                    $jmlKms = $modFakturDetail->jmlterima;
                }
            }else{
               $jmlKms = $modFakturDetail->jmlterima;
            }
            
            $modStok->qtystok_in = $jmlKms;
            $modStok->qtystok_out = 0;
            $modStok->tglstok_in = date("Y-m-d H:i:s");
            $modStok->tglstok_out = null;
            $modStok->harganetto = $modFakturDetail->harganettofaktur;
            $modStok->persendiscount = $modFakturDetail->persendiscount;
            $modStok->jmldiscount = $modFakturDetail->jmldiscount;
            $modStok->persenppn = $modFakturDetail->persenppnfaktur;
            $modStok->persenpph = $modFakturDetail->persenpphfaktur;
            //$modStok->jmlmargin = 0;
			$jmlmargin = $modFakturDetail->hargasatuan * ($modStok->persenmargin/100);
			$modStok->jmlmargin = round($jmlmargin);
			
            $modStok->update_time = date('Y-m-d H:i:s');
            $modStok->update_loginpemakai_id = Yii::app()->user->id;
            
            // var_dump($modStok->attributes); die;
            
            $modStok->save();
        } else {
            $this->fakturpembeliandetailtersimpan &= false;
        }
        
        // die;
        
        return $modFakturDetail;
    }

    
    /**
     * untuk print data penerimaan barang farmasi
     */
    public function actionPrint($fakturpembelian_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modFakturPembelian = GFFakturpembelianT::model()->findByPk($fakturpembelian_id);     
        $modFakturPembelianDetail = GFFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
        $modPenerimaanBarang = GFPenerimaanBarangT::model()->findByAttributes(array('fakturpembelian_id'=>$fakturpembelian_id));
        $modPermintaanPembelian = GFPermintaanPembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$modPenerimaanBarang->permintaanpembelian_id));
        
        

        $judul_print = 'Faktur Pembelian';
                
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
                'modFakturPembelian'=>$modFakturPembelian,
                'modFakturPembelianDetail'=>$modFakturPembelianDetail,
                'modPenerimaanBarang'=>$modPenerimaanBarang,
                'modPermintaanPembelian'=>$modPermintaanPembelian,
                'caraPrint'=>$caraPrint
        ));
    }
	
	public function actionLoadPenerimaanBarang()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $penerimaanbarang_id = $_POST['penerimaanbarang_id'];
			
            $form = "";
            $pesan = "";
            $modPenerimaan = PenerimaanbarangT::model()->findByPk($penerimaanbarang_id);
            $pajak_id = (isset($modPenerimaan->permintaanpembelian)?$modPenerimaan->permintaanpembelian->pajak_id:null);
            $pajak_nama = (isset($modPenerimaan->permintaanpembelian)?(isset($modPenerimaan->permintaanpembelian->pajak)? $modPenerimaan->permintaanpembelian->pajak->pajak_nama:""):"");
            $modPenerimaanDetail = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$penerimaanbarang_id));
            $dataUangMuka = array();
            $checkuangmuka = false;
            
            if(!empty($modPenerimaan->permintaanpembelian_id)){
                $modUangMuka = UangmukabeliT::model()->findByAttributes(array('permintaanpembelian_id'=>$modPenerimaan->permintaanpembelian_id));        
                if(isset($modUangMuka)){
                    $checkuangmuka = true;
                    $dataUangMuka['jumlahuang'] = $modUangMuka->jumlahuang;
                    $dataUangMuka['tgluangmukabeli'] = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
                    $dataUangMuka['nopembayaran'] = $modUangMuka->nopembayaran;
                }
            }
            
            if(count((array)$modPenerimaanDetail) > 0){
                foreach($modPenerimaanDetail AS $i => $penerimaandetail){
                  //   $penerimaandetail->jmlterima = number_format($penerimaandetail->jmlterima,2,",",".");
                  //  $penerimaandetail->harganettoper = MyFormatter::formatNumberForPrint($penerimaandetail->harganettoper,2);
//                    $penerimaandetail->hargasatuanper = MyFormatter::formatNumberForPrint($penerimaandetail->hargasatuanper,2);
//                    $penerimaandetail->persenppn = (($penerimaandetail->persenppn > 0)?$penerimaandetail->persenppn:10);
                    $form .= $this->renderPartial($this->path_view.'_rowObatPenerimaanBarang', array('modFakturDetail'=>$penerimaandetail), true);
                }
            }else{
                $pesan = "Tidak ditemukan data detail faktur obat alkes!";
            }
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan,'dataUangMuka'=>$dataUangMuka,'checkuangmuka'=>$checkuangmuka,'pajak_id'=>$pajak_id,'pajak_nama'=>$pajak_nama));
            Yii::app()->end(); 
        }
    }
	
	public function actionAutoCompletePenerimaanBarang(){
		if(Yii::app()->request->isAjaxRequest) {
            $criteria = GFInformasipenerimaanbarangV::model()->searchDialog()->criteria;
            $criteria->compare('LOWER(t.noterima)', strtolower($_GET['term']), true);
            $criteria->order = 'noterima';
            $criteria->limit = 5;
			// var_dump($criteria); die;
			//$criteria->
            $models = GFInformasipenerimaanbarangV::model()->findAll($criteria);
            $returnVal = array();
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->noterima." - ".MyFormatter::formatDateTimeForUser($model->tglterima);
                $returnVal[$i]['value'] = $model->noterima;
                $returnVal[$i]['tglterima'] = $model->tglterima;
                $returnVal[$i]['supplier_nama'] = $model->supplier_nama;
                $returnVal[$i]['supplier_id'] = $model->supplier_id;
                $returnVal[$i]['penerimaanbarang_id'] = $model->penerimaanbarang_id;								
				
				$returnVal[$i]['pegawaimengetahui_nama'] = $model->PegawaimengetahuiLengkap;
				$returnVal[$i]['pegawaimenyetujui_nama'] = $model->PegawaimenyetujuiLengkap;
				$returnVal[$i]['pegawaipenerima_nama'] = $model->PegawaiPenerima;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
	}
	
        protected function saveJurnalRekening($modPenUmum, $dtFakturDetail)
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
            $modJurnalRekening->urianjurnal = 'Faktur Pembelian '. (!empty($dtFakturDetail->obatalkes->jenisobatalkes_id)?$dtFakturDetail->obatalkes->jenisobatalkes->jenisobatalkes_nama:"") ." " .$dtFakturDetail->obatalkes->obatalkes_nama ." - ". $modPenUmum->supplier->supplier_nama ." - ". $modPenUmum->nofaktur;
		
            $periodeID = $period;
            $modJurnalRekening->rekperiod_id = $periodeID;
            $modJurnalRekening->create_time = $format->formatDateTimeForDB($modPenUmum->tglfaktur);
            $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
            $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modJurnalRekening->ruangan_id = $modPenUmum->ruangan_id;
            $modJurnalRekening->fakturpembelian_id = $modPenUmum->fakturpembelian_id;

            if($modJurnalRekening->validate()){
                $modJurnalRekening->save();
                $this->succesSave = true;
            } else {
                $this->succesSave = false;
                $this->pesan = $modJurnalRekening->getErrors();
            }
            return $modJurnalRekening;
        }

        public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modJenisObatRek, $isPPN=null, $ispph=null){
            $valid = true;
//            $modJurnalPosting = null;
            $jmlTerima = 0;
            
//            $modFaktur = FakturpembelianT::model()->findByAttributes(array('fakturpembelian_id'=>$postRekenings->fakturpembelian_id));
//            if(Yii::app()->user->getState('ispostingotomatis'))
//            {
//                $modJurnalPosting = new JurnalpostingT;
//                $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
//                $modJurnalPosting->keterangan = "Posting automatis";
//                $modJurnalPosting->create_time = date('Y-m-d H:i:s');
//                $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
//                $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
//                if($modJurnalPosting->validate()){
//                    $modJurnalPosting->save();
//                }
//            }
           
            $modelJurnalDetail = new JurnaldetailT();
//            $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
            $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
            $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
            $modelJurnalDetail->rekening5_id = $modJenisObatRek->rekening5_id;
            $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
            
            if(!empty($postRekenings->satuanbesar_id)){
                $jmlTerima = ($postRekenings->jmlterima * $postRekenings->kemasanbesar);
            }else{
                $jmlTerima = $postRekenings->jmlterima;
            }
            
            $jmlHargaQty = ($postRekenings->harganettofaktur * $jmlTerima);
            $jmlDiskon = ($jmlHargaQty * ($postRekenings->persendiscount/100));
            $hargaNettoDiskon = ($jmlHargaQty - $jmlDiskon);
            $jmlPPn = ($hargaNettoDiskon * ($postRekenings->persenppnfaktur/100));
            $jmlPPh = ($hargaNettoDiskon * ($postRekenings->persenpphfaktur/100));
            $jmlAll = ($hargaNettoDiskon + $jmlPPn - $jmlPPh);
            
            if($modJenisObatRek->debitkredit == 'K'){
                if(!empty($isPPN)){
                    $modelJurnalDetail->nourut = 3;
                    $modelJurnalDetail->saldokredit = $jmlPPn;
                }

                if(!empty($ispph)){
                    $modelJurnalDetail->nourut = 4;
                    $modelJurnalDetail->saldokredit = $jmlPPh;
                }
                
                if(empty($isPPN) && empty($ispph)){
                  $modelJurnalDetail->nourut = 5;
                  $modelJurnalDetail->saldokredit = $jmlAll;
                }
                  
                  $modelJurnalDetail->saldodebit = 0;
            }else if($modJenisObatRek->debitkredit == 'D'){
                if(!empty($isPPN)){
                    $modelJurnalDetail->nourut = 2;
                    $modelJurnalDetail->saldodebit = $jmlPPn;
                }

                if(!empty($ispph)){
                    $modelJurnalDetail->nourut = 3;
                    $modelJurnalDetail->saldodebit = $jmlPPh;
                } 
                if(empty($isPPN) && empty($ispph)){
                    $modelJurnalDetail->nourut = 1;
                    $modelJurnalDetail->saldodebit = $hargaNettoDiskon;
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
        
        public function actionLoadJatuhTempo()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $tglfaktur = (isset($_POST['tgl_faktur'])? MyFormatter::formatDateTimeForDb($_POST['tgl_faktur']):date('Y-m-d H:i:s'));
            $supplier_id = $_POST['supplier_id'];
			
            $dateJatuhTempo = date('d/m/Y H:i:s');
            $termin = 0;
            
            $modSupplier = SupplierM::model()->findByPk($supplier_id);
            
            if(isset($modSupplier)){
                $termin = $modSupplier->terminpembayaran;
            }
            if($termin > 0){
                $dateJatuhTempo = date('d/m/Y H:i:s',strtotime('+'.$termin.' days', strtotime($tglfaktur)));
            }
            echo CJSON::encode(array('value'=>$dateJatuhTempo));
            Yii::app()->end(); 
        }
    }
    
    protected function saveJurnalRekeningUangMuka($model) {
        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }

        $format = new MyFormatter();
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
        $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglfaktur);
        $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $model->nofaktur;
        $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglfaktur);
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = 'Pengurangan Hutang Usaha dari Uang Muka';

        $periodeID = $period;
        $modJurnalRekening->rekperiod_id = $periodeID;
        $modJurnalRekening->create_time = $format->formatDateTimeForDB($model->tglfaktur);
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->ruangan_id = $model->create_ruangan;
        $modJurnalRekening->fakturpembelian_id = $model->fakturpembelian_id;

        if ($modJurnalRekening->validate()) {
            $modJurnalRekening->save();
            $this->successSave = true;
        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
        }
        return $modJurnalRekening;
    }
    
    public function saveJurnalDetailUangMuka($modJurnalRekening, $modelRek, $nilai, $saldonormal, $nourut) {
        $valid = true;
//        $modJurnalPosting = null;

        if (empty($modelRek)) {
            return true;
        }

        $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
        $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
        if(empty($rekening4->rekening3_id)){
            $rekening3 = new Rekening3M();
        }else{
            $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
        }
        $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);



//        if (Yii::app()->user->getState('ispostingotomatis')) {
//            $modJurnalPosting = new JurnalpostingT;
//            $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
//            $modJurnalPosting->keterangan = "Posting automatis";
//            $modJurnalPosting->create_time = date('Y-m-d H:i:s');
//            $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
//            $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
//            if ($modJurnalPosting->validate()) {
//                $modJurnalPosting->save();
//            }
//        }

        $modelJurnalDetail = new JurnaldetailT();
//        $modelJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
        $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
        $modelJurnalDetail->rekening1_id = !empty($rekening2->rekening1_id) ? $rekening2->rekening1_id : null;
        $modelJurnalDetail->rekening2_id = !empty($rekening2->rekening2_id) ? $rekening2->rekening2_id : null;
        $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
        $modelJurnalDetail->rekening4_id = !empty($rekening4->rekening4_id) ? $rekening4->rekening4_id : null;
        $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $modelJurnalDetail->nourut = $nourut;
        if($saldonormal == 'K'){
            $modelJurnalDetail->saldokredit = $nilai;
            $modelJurnalDetail->saldodebit = 0;
        }else{
            $modelJurnalDetail->saldokredit = 0;
            $modelJurnalDetail->saldodebit = $nilai;
        }
        
        if ($modelJurnalDetail->validate()) {
            $modelJurnalDetail->save();
        } else {
//                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
            $valid = false;
        }

        return $valid;
    }
}
