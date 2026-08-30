
<?php

class StockOpnameObatAlkesController extends MyAuthController
{
    public $path_view = 'gudangFarmasi.views.stockOpnameObatAlkes.';
    public $stokobatalkestersimpan = true; //looping
    public $stokopnameobattersimpan = true; //looping
    public $updateformulirstokdetailtersimpan = true; //looping

    public function actionIndex($formuliropname_id = null,$stokopname_id = null, $linkHalaman = null)
    {
      
        $format = new MyFormatter();
        $modObat = new GFInformasistokobatalkesV('search');
        $model = new GFStokopnameT;
        $modFormulir = new GFFormuliropnameR;
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modDetailFormulir = array();
        $modDetails = array();
        $modDet = new GFStokopnamedetT;
     
        if (!empty($formuliropname_id)){
            $modFormulir = GFFormuliropnameR::model()->find('formuliropname_id ='.$formuliropname_id.' and stokopname_id is null');
            if (!empty($modFormulir)){
                $model->formuliropname_id = $modFormulir->formuliropname_id;
                $modDetailFormulir = GFFormstokopnameR::model()->findAll('formuliropname_id = '.$modFormulir->formuliropname_id.' and stokopnamedet_id is null');
            }
        }

        //$modObat->jenisstokopname = Params::JENISSTOKOPNAME_PENYESUAIAN;
        $model->totalharga = 0;
        $model->totalnetto = 0;
        $model->tglstokopname = date('Y-m-d H:i:s');
		$model->jenisstokopname = Params::JENISSTOKOPNAME_PENYESUAIAN;
        $model->nostokopname = "- Otomatis -";
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->petugas1_id = Yii::app()->user->getState('pegawai_id');
        $model->petugas1_nama = Yii::app()->user->getState('nama_pegawai');

        if (!empty($stokopname_id)){
            $model = GFStokopnameT::model()->findByPk($stokopname_id);
            if ($model){
                $modDetails = GFStokopnamedetT::model()->findAllByAttributes(array('stokopname_id'=>$model->stokopname_id));
				$model->mengetahui_nama = (isset($model->mengetahui) ? $model->mengetahui->NamaLengkap : "");
				$model->petugas2_nama = (isset($model->petugas2) ? $model->petugas2->NamaLengkap : "");
				$model->totalharga = $format->formatNumberForUser($model->totalharga);
				$model->totalnetto = $format->formatNumberForUser($model->totalnetto);
            }
        }
        
        if(isset($_POST['GFStokopnameT']))
        {
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['GFStokopnameT'];
				$model->tglstokopname = $format->formatDateTimeForDb($_POST['GFStokopnameT']['tglstokopname']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$model->jenisstokopname = (empty($model->jenisstokopname) ? Params::JENISSTOKOPNAME_PENYESUAIAN : $model->jenisstokopname);
				$model->isstokawal = ($model->jenisstokopname == Params::JENISSTOKOPNAME_PENYESUAIAN ? false : true);
				$model->nostokopname = MyGenerator::noStokOpname(Params::INSTALASI_ID_FARMASI);
				if ($model->validate()){
					if($model->save()){
                        if(count((array)$_POST['GFStokopnamedetT']) > 0){
                            foreach($_POST['GFStokopnamedetT'] AS $i => $postOa){
                                if(isset($postOa['cekList'])){
                                    $modDetails[$i] = $this->simpanObatAlkesOpname($model,$postOa);
                                    if (!empty($model->formuliropname_id)){
                                        $modFormulir = GFFormuliropnameR::model()->updateByPk($model->formuliropname_id, array('stokopname_id'=>$model->stokopname_id));
                                        $modDetailFormulir = GFFormstokopnameR::model()->find('formuliropname_id = '.$model->formuliropname_id.' and obatalkes_id = '.$modDetails[$i]->obatalkes_id)->formstokopname_id;
                                        $this->updateFormsStokOpname($model, $modDetails[$i]);
                                    }
                                    if ($model->isstokawal){
										
										$this->simpanStokObatAlkes($modDetails[$i],$modDetails[$i]->volume_fisik);
                                    }else{ //Penyesuaian
									

                                        $this->simpanStokObatAlkesBaru($modDetails[$i]);

                                        
                                    }
                                }

                            }
                        }
                    }

                    if (Yii::app()->user->getState('isjurnalotomatis') && !empty($model->stokopname_id)) {
                        $res = Yii::app()->db
                            ->createCommand("select set_afterstokopname_fix(".$model->stokopname_id.") as simpan")
                            ->queryRow();

                        if (!empty($res)) {
                            $this->stokopnameobattersimpan = $this->stokopnameobattersimpan && $res['simpan'];
                        }

                    // var_dump($res);
                    }

                    // var_dump($this->stokopnameobattersimpan, $this->stokobatalkestersimpan, $this->updateformulirstokdetailtersimpan);
                    // die;
                    if($this->stokopnameobattersimpan && $this->stokobatalkestersimpan && $this->updateformulirstokdetailtersimpan){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil Disimpan ");
                        $this->redirect(array('index', 'stokopname_id'=>$model->stokopname_id,'sukses'=>1));
                    }
                    else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data Gagal Disimpan ");
                    }
				}
			}catch(Exception $ex){
                            // echo "Kick"; die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.'.MyExceptionMessage::getMessage($ex, true));
                }
        }

        if(isset($_GET['GFInformasistokobatalkesV']))
        {
                $modObat->unsetAttributes();
                $modObat->attributes=$_GET['GFInformasistokobatalkesV'];
                $modObat->jenisstokopname=$_GET['GFInformasistokobatalkesV']['jenisstokopname'];
        }
        
        if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1287);

        $this->render($this->path_view.'index',array(
                'model'=>$model,
                'modObat'=>$modObat,
                'modDetails'=>$modDetails,
                'modFormulir'=>$modFormulir,
                'modDetailFormulir'=>$modDetailFormulir,
                'format'=>$format,
                'modDet'=>$modDet,
                'linkHalaman' => $linkHalaman
        ));
    }

    /**
        * simpan GFStockopnamedetT
        * @param type $model
        * @param type $post
        * @return \GFStockopnamedetT
    */
    public function simpanObatAlkesOpname($model ,$post){
        $format = new MyFormatter();
        $obatAlkes = GFObatalkesM::model()->findByPk($post['obatalkes_id']);
        $modDetailOpname = new GFStokopnamedetT;

//        echo '<pre>';
//        print_r($post);
//        exit();

        $modDetailOpname->attributes = $post;
        $modDetailOpname->stokopname_id = $model->stokopname_id;
		//AGAR STOK REALTIME
//        $modDetailOpname->volume_sistem = StokobatalkesT::getJumlahStok($modDetailOpname->obatalkes_id, $modDetailOpname->stokopname->ruangan_id);
       //  $modDetailOpname->volume_sistem = ($modDetailOpname->volume_fisik - $modDetailOpname->volume_sistem);
       //  if($modDetailOpname->kondisibarang == 'Baik'){
       //      if ($modDetailOpname->volume_sistem < $modDetailOpname->volume_fisik) {
       //          $modDetailOpname->volume_sistem = ($modDetailOpname->volume_fisik - $modDetailOpname->volume_sistem);
       //     } else {
       //         $modDetailOpname->volume_sistem = ($modDetailOpname->volume_sistem + $modDetailOpname->volume_fisik);
       //     }
       // }else{
       //     $modDetailOpname->volume_sistem = ($modDetailOpname->volume_sistem - $modDetailOpname->volume_fisik);
       // }

        $modDetailOpname->jumlahharga = $modDetailOpname->hargasatuan*$modDetailOpname->volume_fisik;
        $modDetailOpname->jumlahnetto = $modDetailOpname->harganetto*$modDetailOpname->volume_fisik;
        $modDetailOpname->satuankecil_id = $obatAlkes->satuankecil_id;
        $modDetailOpname->sumberdana_id = $obatAlkes->sumberdana_id;
        if (empty($modDetailOpname->tglkadaluarsa)){
            $tglkadaluarsa = date('Y-m-d', time() + (3600 * 24 * 365.25));
        }else{
            $tglkadaluarsa = $format->formatDateTimeForDb($modDetailOpname->tglkadaluarsa);
        }
        //?date('Y-m-d', time() + (3600 * 24 * 365.25)):$format->formatDateTimeForDb($obatAlkes->tglkadaluarsa);
        $modDetailOpname->tglkadaluarsa = $tglkadaluarsa;
        $modDetailOpname->tglperiksafisik = $format->formatDateTimeForDb($modDetailOpname->tglperiksafisik);

        if ($modDetailOpname->volume_sistem < $modDetailOpname->volume_fisik) {
            $modDetailOpname->jmlselisihstok = $modDetailOpname->volume_fisik - $modDetailOpname->volume_sistem;
        } else {
            $modDetailOpname->jmlselisihstok = $modDetailOpname->volume_sistem - $modDetailOpname->volume_fisik;
        }
//        echo '=== '.$modDetailOpname->volume_fisik;
//        echo '<br/>=== '.$modDetailOpname->volume_sistem;
//        echo '<br/>=== '.$modDetailOpname->jmlselisihstok;
//        exit();

//        $modDetailOpname->jmlselisihstok = $modDetailOpname->volume_fisik - $modDetailOpname->volume_sistem; //$modDetailOpname->getJmlSelisihStok($modDetailOpname->stokopname->ruangan_id);

        // var_dump($modDetailOpname->attributes); die;

       if($modDetailOpname->validate()) {
           $modDetailOpname->save();
       } else {
           $this->stokopnameobattersimpan  &= false;
       }
       return $modDetailOpname;
    }

    function setSelisih($det)
    {
        if ($det->volume_sistem < 0) {
            $sis = $det->volume_sistem;
            if (abs($sis) == $det->volume_fisik) {
                $det->jmlselisihstok = 0;
            } else if (abs($sis) < $det->volume_fisik) {
                $det->jmlselisihstok = $det->volume_fisik - abs($sis);
            } else {
                $det->jmlselisihstok = abs($sis);
            }
        }
        $det->save();
        // var_dump($det->attributes, $det->save());
    }

    public function updateFormsStokOpname($model ,$modStokOpnameDet){
        $format = new MyFormatter();
        $modFormulir = GFFormuliropnameR::model()->findByAttributes(array('stokopname_id'=>$model->stokopname_id));
        $modDetailFormulir = GFFormstokopnameR::model()->find('formuliropname_id = '.$modFormulir->formuliropname_id.' and obatalkes_id = '.$modStokOpnameDet->obatalkes_id.'');

        $modDetailFormulir->stokopnamedet_id = $modStokOpnameDet->stokopnamedet_id;

       if($modDetailFormulir->validate()) {
           $modDetailFormulir->save();
           GFStokopnamedetT::model()->updateByPk($modStokOpnameDet->stokopnamedet_id,array('formstokopname_id'=>$modDetailFormulir->formstokopname_id));
       } else {
           $this->updateformulirstokdetailtersimpan  &= false;
       }
       return $modDetailFormulir;
    }

    public function simpanStokObatAlkes($modDetailOpname,$selisih){

        $format = new MyFormatter;
        $modStok = new GFStokObatAlkesT;

        $loadObatAlkes = GFObatAlkesM::model()->findByPk($modDetailOpname->obatalkes_id);
        $modStok->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStok->tglkadaluarsa = !empty($modDetailOpname->tglkadaluarsa) ? $format->formatDateTimeForDb($modDetailOpname->tglkadaluarsa) : null;
        $modStok->obatalkes_id = $modDetailOpname->obatalkes_id;
        $modStok->stokopnamedet_id = $modDetailOpname->stokopnamedet_id;
        $modStok->nobatch = "";
        $modStok->tglstok_in = date('Y-m-d H:i:s');
        $modStok->tglstok_out = NULL;
		$modStok->persenppn = $loadObatAlkes->ppn_persen;
		$modStok->persenmargin = $loadObatAlkes->margin;

        if(!empty($modDetailOpname->satuanbesar_id)){
            $modStok->qtystok_in = $selisih;
            //$modStok->harganetto = ($modDetailOpname->harganetto / $modStok->qtystok_in);
			$modStok->harganetto = $modDetailOpname->harganetto;
			//$modStok->jmlmargin = ($modDetailOpname->hargasatuan - $modDetailOpname->harganetto) / $modStok->qtystok_in;
        }else{
            $modStok->qtystok_in = $selisih;
            $modStok->harganetto = $modDetailOpname->harganetto;
			//$modStok->jmlmargin = $modDetailOpname->hargasatuan - $modDetailOpname->harganetto;
        }

        $modStok->qtystok_out = 0;
        $modStok->create_time = date('Y-m-d H:i:s');
        $modStok->update_time = date('Y-m-d H:i:s');
        $modStok->create_loginpemakai_id = Yii::app()->user->id;
        $modStok->update_loginpemakai_id = Yii::app()->user->id;
        $modStok->create_ruangan = Yii::app()->user->ruangan_id;
        $modStok->tglterima = date('Y-m-d H:i:s');
        $modStok->satuankecil_id = (isset($modDetailOpname->satuankecil_id) ? $modDetailOpname->satuankecil_id : $loadObatAlkes->satuankecil_id);
        // var_dump($modStok->attributes, $modStok->validate(), $modStok->errors); die;
        if($modStok->validate()) {
            $modStok->save();
            $loadObatAlkes->tglkadaluarsa = $modStok->tglkadaluarsa;
            $loadObatAlkes->harganetto = $modStok->harganetto;
            //$loadObatAlkes->discount = (($modStok->jmldiscount > 0) ? $modStok->jmldiscount : $modStok->harganetto * $modStok->persendiscount / 100) ;
            $loadObatAlkes->ppn_persen = $modStok->persenppn;
			$loadObatAlkes->hpp = $loadObatAlkes->JumHPP;
            $loadObatAlkes->satuankecil_id =$modStok->satuankecil_id;
			$loadObatAlkes->satuanbesar_id = (!empty($loadObatAlkes->satuanbesar_id) ? $loadObatAlkes->satuanbesar_id : Params::DEFAULT_SATUANBESAR_ID);
			$loadObatAlkes->satuanbesar_id = (!empty($modStok->satuanbesar_id) ? $modStok->satuanbesar_id : $loadObatAlkes->satuanbesar_id);

			if($modStok->persenmargin > 0){
				$hargajual = ($loadObatAlkes->hpp + ($loadObatAlkes->hpp * ($loadObatAlkes->margin/100) ));
				//$hargajual = round((round($modStok->HPP) + (round($modStok->HPP) * ($modStok->persenmargin / 100))));
			}else{
				$hargajual = ($loadObatAlkes->hpp);
			}

			if($hargajual > $loadObatAlkes->hargamaksimum){
				$loadObatAlkes->hargamaksimum = ($hargajual);
			}
			if($loadObatAlkes->hargaminimum <= 0 || $hargajual < $loadObatAlkes->hargaminimum){
				$loadObatAlkes->hargaminimum = ($hargajual);
			}
			if($loadObatAlkes->hargaaverage > 0 && $hargajual > 0){
				$loadObatAlkes->hargaaverage = (($loadObatAlkes->hargaaverage + $hargajual) / 2);
			}else{
				$loadObatAlkes->hargaaverage = ($hargajual);
			}
			$loadObatAlkes->hargajual = ($hargajual);

            if($loadObatAlkes->save()){

			}else{
				$this->stokobatalkestersimpan &= false;
			}

        } else {
            $this->stokobatalkestersimpan &= false;
        }

        return $modStok;
    }

    protected function simpanStokObatAlkesBaru($opnamedet){
        $format = new MyFormatter;
        $oa = ObatalkesM::model()->findByPk($opnamedet->obatalkes_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk

        $qtyStokIn = 0;
        $qtyStokOut = 0;

        // if($opnamedet->volume_fisik > $opnamedet->volume_sistem){
        //     if($opnamedet->kondisibarang == 'Baik'){
        //         $qtyStokIn = $opnamedet->volume_sistem;
        //         if ($opnamedet->volume_sistem > $opnamedet->volume_fisik) {
        //           $qtyStokOut = ($opnamedet->volume_sistem - $opnamedet->volume_fisik);
        //         }
        //     }
        // }else if($opnamedet->volume_fisik < $opnamedet->volume_sistem){
            if($opnamedet->kondisibarang == 'Baik'){

                // $qtyStokOut = 0;
                if ($opnamedet->volume_sistem < $opnamedet->volume_fisik) {
                    $qtyStokIn = $opnamedet->jmlselisihstok;
                } else {
                    $qtyStokOut = $opnamedet->jmlselisihstok;
                }
                // if ($opnamedet->volume_sistem < $opnamedet->volume_fisik) {
                //   $qtyStokOut = 0;
                // }else{
                //   $qtyStokOut = ($opnamedet->volume_sistem - $opnamedet->volume_fisik);
                // }
            }
            else if($opnamedet->kondisibarang == 'Dalam Perbaikan'){
                $qtyStokIn = 0;
                $qtyStokOut = $opnamedet->volume_fisik;
            }
            else if($opnamedet->kondisibarang == 'Rusak'){
                $qtyStokIn = 0;
                $qtyStokOut = $opnamedet->volume_fisik;
            }
        // }

        $modStokOaNew->qtystok_in = $qtyStokIn;
        $modStokOaNew->qtystok_out = $qtyStokOut;


//        $modStokOaNew->qtystok_in = 0;
//        $modStokOaNew->qtystok_out = $jumlah;
		$modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStokOaNew->tglterima = $opnamedet->tglperiksafisik;
        $modStokOaNew->stokopnamedet_id = $opnamedet->stokopnamedet_id;
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
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $jumlah = jumlah yang dikeluarkan untuk penyesuaian stok
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut2($opnamedet, $jumlah){
        $format = new MyFormatter;
        $oa = ObatalkesM::model()->findByPk($opnamedet->obatalkes_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $oa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $jumlah;
		$modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = $modStokOaNew->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modStokOaNew->tglterima = $opnamedet->tglperiksafisik;
        $modStokOaNew->stokopnamedet_id = $opnamedet->stokopnamedet_id;
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
     * simpan StokobatalkesT Jumlah Out
     * @param type $stokobatalkesasal_id
     * @param type $jumlah = jumlah yang dikeluarkan untuk penyesuaian stok
     * @return \StokobatalkesT
     */
    protected function simpanStokObatAlkesOut($stokobatalkesasal_id,$jumlah){
        $format = new MyFormatter;
        $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
		$oa = ObatalkesM::model()->findByPk($modStokOa->obatalkes_id);
        $modStokOaNew = new StokobatalkesT;
        $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
        $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qtystok_in = 0;
        $modStokOaNew->qtystok_out = $jumlah;
		$modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
        $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
        $modStokOaNew->create_time = date('Y-m-d H:i:s');
        $modStokOaNew->update_time = date('Y-m-d H:i:s');
        $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
		$modStokOaNew->persenppn = $oa->ppn_persen;
		$modStokOaNew->persenmargin = $oa->margin;

        if($modStokOaNew->validateStok()){
            $modStokOaNew->save();
            $modStokOaNew->setStokOaAktifBerdasarkanStok();
        } else {
            $this->stokobatalkestersimpan &= false;
        }
        return $modStokOaNew;
    }

    public function actionPrint($stokopname_id = null)
    {
        $format = new MyFormatter();
        $model = GFStokopnameT::model()->findByPK($stokopname_id);
        $modDetails = GFStokopnamedetT::model()->findAllByAttributes(array('stokopname_id'=>$stokopname_id));

        $judulLaporan='Data Stock Obat Alkes Opname';
        $caraPrint=isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

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
                    'model'=>$model,
                    'judulLaporan'=>$judulLaporan,
                    'caraPrint'=>$caraPrint,
                    'modDetails'=>$modDetails,
                    'format'=>$format
            ));

    }

}
