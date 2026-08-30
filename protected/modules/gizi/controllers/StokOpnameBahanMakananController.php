<?php

class StokOpnameBahanMakananController extends MyAuthController {

    public $path_view = "gizi.views.stokOpnameBahanMakanan.";


    public $stokopnamebahanmakanantersimpan = true;
    public $stokbahanmakanantersimpan = true;
    public $updateformulirstokdetailtersimpan = true;

    public function actionIndex($stokopnamegizi_id = null, $formuliropnamegizi_id = null) {
        $modMakanan = new StokbahanmakananT('search');
        $model = new StokopnamegiziT;
        $modDetail = array();
        $modFormulir = new FormuliropnamegiziR;
        $modDetailFormulir = new FormuliropnamegizidetR;

        $model->tglstokopnamegizi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        $model->nostokopnamegizi = "- Otomatis -";
        // $model->jenisstokopnamegizi = Params::JENISSTOKOPNAME_PENYESUAIAN;

        if (!empty($formuliropnamegizi_id)){
            $modFormulir = FormuliropnamegiziR::model()->find('formuliropnamegizi_id ='.$formuliropnamegizi_id.' and stokopnamegizi_id is null');
            if (!empty($modFormulir)){
                $model->formuliropnamegizi_id = $modFormulir->formuliropnamegizi_id;
                $modDetailFormulir = FormuliropnamegizidetR::model()->findAll('formuliropnamegizi_id = '.$modFormulir->formuliropnamegizi_id.' and stokopnamegizidet_id is null');
            }
        }


        if (!empty($stokopnamegizi_id)){
            $model = StokopnamegiziT::model()->findByPk($stokopnamegizi_id);
            if ($model){
                $modDetails = StokopnamegizidetT::model()->findAllByAttributes(array('stokopnamegizi_id'=>$model->stokopnamegizi_id));
				$model->mengetahui_nama = (isset($model->mengetahui) ? $model->mengetahui->NamaLengkap : "");
				$model->petugas1_nama = (isset($model->petugas1) ? $model->petugas1->NamaLengkap : "");
				$model->petugas2_nama = (isset($model->petugas2) ? $model->petugas2->NamaLengkap : "");
				//$model->totalharga = MyFormatter::formatNumberForUser($model->totalharga);
				//$model->totalnetto = MyFormatter::formatNumberForUser($model->totalnetto);
            }
        }


        if (isset($_POST['StokopnamegiziT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['StokopnamegiziT'];
                $model->tglstokopnamegizi = MyFormatter::formatDateTimeForDb($_POST['StokopnamegiziT']['tglstokopnamegizi']);
                $model->create_time = date("Y-m-d H:i:s");
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->jenisstokopnamegizi = (empty($model->jenisstokopnamegizi) ? Params::JENISSTOKOPNAME_PENYESUAIAN : $model->jenisstokopnamegizi);
                $model->isstokawal = ($model->jenisstokopnamegizi == Params::JENISSTOKOPNAME_PENYESUAIAN ? false : true);
                $model->nostokopnamegizi = MyGenerator::noStokOpnameGizi();
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                
                if ($model->validate()) {
                    if ($model->save()) {
                        if (!empty($model->formuliropnamegizi_id)) {
                            $modFormulir = FormuliropnamegiziR::model()->updateByPk($model->formuliropnamegizi_id, array('stokopnamegizi_id' => $model->stokopnamegizi_id));
                        }
                        if (count((array)$_POST['StokopnamegizidetT']) > 0) {
                            foreach ($_POST['StokopnamegizidetT'] AS $i => $postOa) {
                                if (isset($postOa['cekList']) && $postOa['cekList'] == 1) {

                                    $modDetails[$i] = $this->simpanBahanMakananOpname($model, $postOa);

                                    if (!empty($model->formuliropnamegizi_id)) {
                                        $this->updateFormsStokOpname($model, $modDetails[$i]);
                                    }
                                    if ($model->isstokawal) {
                                        $this->simpanStokBahanMakanan($modDetails[$i], $modDetails[$i]->volume_fisik);
                                    } else { //Penyesuaian
                                        $this->simpanStokBahanMakananPenyesuaian($modDetails[$i]);
                                    }
                                }
                            }
                        }
                    }
                    
//                    die;

                    if (Yii::app()->user->getState('isjurnalotomatis') && !empty($model->stokopnamegizi_id)) {
                        $res = Yii::app()->db
                                ->createCommand("select set_afterstokopnamegizi_fix(" . $model->stokopnamegizi_id . ") as simpan")
                                ->queryRow();

                        if (count((array)$res) != 0) {
                            $this->stokopnamebahanmakanantersimpan = $this->stokopnamebahanmakanantersimpan && $res['simpan'];
                        }
                    }
                    
                    if ($this->stokopnamebahanmakanantersimpan && $this->stokbahanmakanantersimpan && $this->updateformulirstokdetailtersimpan) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
                        $this->redirect(array('index', 'stokopnamegizi_id' => $model->stokopnamegizi_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data Gagal Disimpan ");
                    }
                }
            } catch (Exception $ex) {
                // echo "Kick"; die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
            }
        }


        if (isset($_GET['StokbahanmakananT'])) {
            $modMakanan->unsetAttributes();
            $modMakanan->jenis_opname = $_GET['StokbahanmakananT']['jenis_opname'];
            $modMakanan->attributes = $_GET['StokbahanmakananT'];
            // $modMakanan->jenisbahanmakanan = $_GET['StokbahanmakananT']['jenisbahanmakanan'];
            // $modMakanan->golbahanmakanan_id = $_GET['StokbahanmakananT']['golbahanmakanan_id'];
            $modMakanan->kelbahanmakanan = $_GET['StokbahanmakananT']['kelbahanmakanan'];
            $modMakanan->namabahanmakanan = $_GET['StokbahanmakananT']['namabahanmakanan'];
            $modMakanan->satuanbahan = $_GET['StokbahanmakananT']['satuanbahan'];
        }




        $this->render($this->path_view . 'index', array(
            'modMakanan' => $modMakanan,
            'model' => $model,
            'modDetail' => $modDetail,
            'modFormulir'=>$modFormulir,
            'modDetailFormulir'=>$modDetailFormulir,
        ));
    }

    public function actionInformasi() {
        $this->render('informasi');
    }

    public function actionPrint($stokopnamegizi_id) {
        $format = new MyFormatter();
        $model = StokopnamegiziT::model()->findByPK($stokopnamegizi_id);
        $modDetails = StokopnamegizidetT::model()->findAllByAttributes(array('stokopnamegizi_id'=>$stokopnamegizi_id));

        $judulLaporan='Data Stok Bahan Makanan Opname';
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

        $this->render($this->path_view.'print', array(
                'model'=>$model,
                'judulLaporan'=>$judulLaporan,
                'caraPrint'=>$caraPrint,
                'modDetails'=>$modDetails,
                'format'=>$format
        ));
    }

    public function updateFormsStokOpname($model ,$modStokOpnameDet){
        $format = new MyFormatter();
        $modFormulir = FormuliropnamegiziR::model()->findByAttributes(array('stokopnamegizi_id'=>$model->stokopnamegizi_id));
        $modDetailFormulir = FormuliropnamegizidetR::model()->find('formuliropnamegizi_id = '.$modFormulir->formuliropnamegizi_id.' and bahanmakanan_id = '.$modStokOpnameDet->bahanmakanan_id.'');
        $modDetailFormulir->stokopnamegizidet_id = $modStokOpnameDet->stokopnamegizidet_id;

       if($modDetailFormulir->validate()) {
           $modDetailFormulir->save();
           StokopnamegizidetT::model()->updateByPk($modStokOpnameDet->stokopnamegizidet_id,array('formuliropnamegizidet_id'=>$modDetailFormulir->formuliropnamegizidet_id));
       } else {
           $this->updateformulirstokdetailtersimpan  &= false;
       }
       return $modDetailFormulir;
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
    }

    public function simpanBahanMakananOpname($model, $post) {
        $format = new MyFormatter();
        $obatAlkes = BahanmakananM::model()->findByPk($post['bahanmakanan_id']);
        $modDetailOpname = new StokopnamegizidetT;
        // var_dump($post);

        $modDetailOpname->attributes = $post;
        $modDetailOpname->stokopnamegizi_id = $model->stokopnamegizi_id;

       //  if($modDetailOpname->kondisibarang == 'Baik'){
       //      if ($modDetailOpname->volume_sistem < $modDetailOpname->volume_fisik) {
       //          $modDetailOpname->volume_sistem = ($modDetailOpname->volume_fisik - $modDetailOpname->volume_sistem);
       //     } else {
       //         $modDetailOpname->volume_sistem = ($modDetailOpname->volume_sistem + $modDetailOpname->volume_fisik);
       //     }
       // }else{
       //     $modDetailOpname->volume_sistem = ($modDetailOpname->volume_sistem - $modDetailOpname->volume_fisik);
       // }

        $modDetailOpname->tglperiksafisik = $format->formatDateTimeForDb($modDetailOpname->tglperiksafisik);
        $modDetailOpname->tglkadaluarsa =  (!empty($modDetailOpname->tglkadaluarsa)? $format->formatDateTimeForDb($modDetailOpname->tglkadaluarsa) : null);
        $modDetailOpname->volume_sistem = $modDetailOpname->volume_sistem;
        $modDetailOpname->volume_fisik = $modDetailOpname->volume_fisik;

        if ($modDetailOpname->volume_sistem < $modDetailOpname->volume_fisik) {
            $modDetailOpname->jmlselisihstok = $modDetailOpname->volume_fisik - $modDetailOpname->volume_sistem;
        } else {
            $modDetailOpname->jmlselisihstok = $modDetailOpname->volume_sistem - $modDetailOpname->volume_fisik;
        }
        

        if ($modDetailOpname->validate()) {
            $modDetailOpname->save();
        } else {
            $this->stokopnamebahanmakanantersimpan &= false;
        }
        
        
//        var_dump($modDetailOpname->attributes);
        
        return $modDetailOpname;
    }

    public function simpanStokBahanMakanan($modDetailOpname, $selisih) {

        $format = new MyFormatter;
        $modStok = new StokbahanmakananT();

        $modStok->bahanmakanan_id = $modDetailOpname->bahanmakanan_id;
        $modStok->stokopnamegizidet_id = $modDetailOpname->stokopnamegizidet_id;
        $modStok->tgltransaksi = date('Y-m-d H:i:s');

        if (!empty($modDetailOpname->satuanbesar_id)) {
            $modStok->qty_masuk = $selisih;
        } else {
            $modStok->qty_masuk = $selisih;
        }

        $modStok->qty_keluar = 0;
        $modStok->qty_current = $modStok->qty_masuk - $modStok->qty_keluar;

        if ($modStok->validate()) {
            $modStok->save();
            $this->stokbahanmakanantersimpan = true;
        } else {
            $this->stokbahanmakanantersimpan &= false;
        }

        return $modStok;
    }


    public function simpanStokBahanMakananPenyesuaian($modDetailOpname) {

        $modStok = new StokbahanmakananT();

        $modStok->bahanmakanan_id = $modDetailOpname->bahanmakanan_id;
        $modStok->stokopnamegizidet_id = $modDetailOpname->stokopnamegizidet_id;
        $modStok->tgltransaksi = date('Y-m-d H:i:s');

//        if (!empty($modDetailOpname->satuanbesar_id)) {
//            $modStok->qty_masuk = $selisih;
//        } else {
//            $modStok->qty_masuk = $selisih;
//        }

//        $modStok->qty_keluar = 0;
        $qtyStokIn = 0;
        $qtyStokOut = 0;

        // if($modDetailOpname->volume_fisik > $modDetailOpname->volume_sistem){
        //     if($modDetailOpname->kondisibarang == 'Baik'){
        //         // $qtyStokIn = $modDetailOpname->volume_sistem;
        //         // $qtyStokOut = 0;
        //         if ($modDetailOpname->volume_sistem < $modDetailOpname->volume_fisik) {
        //             $qtyStokIn = $modDetailOpname->jmlselisihstok;
        //         } else {
        //             $qtyStokOut = $modDetailOpname->jmlselisihstok;
        //         }
        //     }
        // }else if($modDetailOpname->volume_fisik < $modDetailOpname->volume_sistem){
            if($modDetailOpname->kondisibarang == 'Baik'){
                // $qtyStokIn = $modDetailOpname->volume_fisik;
                // $qtyStokOut = 0;
                if ($modDetailOpname->volume_sistem < $modDetailOpname->volume_fisik) {
                    $qtyStokIn = $modDetailOpname->jmlselisihstok;
                } else {
                    $qtyStokOut = $modDetailOpname->jmlselisihstok;
                }
            }
            else if($modDetailOpname->kondisibarang == 'Rusak'){
                $qtyStokIn = 0;
                $qtyStokOut = $modDetailOpname->volume_fisik;
            }
        // }
        $modStok->qty_masuk = $qtyStokIn;
        $modStok->qty_keluar = $qtyStokOut;
        $modStok->qty_current = $modStok->qty_masuk - $modStok->qty_keluar;

        if ($modStok->validate()) {
            $modStok->save();
            $this->stokbahanmakanantersimpan = true;
        } else {
            $this->stokbahanmakanantersimpan &= false;
        }

//        var_dump($modDetailOpname->attributes, $modStok->attributes); die;
        
        return $modStok;
    }

    protected function simpanStokBahanMakananOut($opnamedet, $jumlah) {
        $format = new MyFormatter;
        $oa = BahanmakananM::model()->findByPk($opnamedet->bahanmakanan_id);
        $modStokOaNew = new StokbahanmakananT();
        $modStokOaNew->attributes = $oa->attributes; //duplicate
        // $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
        $modStokOaNew->qty_masuk = 0;
        $modStokOaNew->qty_keluar = $jumlah;
        $modStokOaNew->qty_current = $modStokOaNew->qty_masuk - $modStokOaNew->qty_keluar;
        // $modStokOaNew->create_time = date('Y-m-d H:i:s');
        // $modStokOaNew->update_time = date('Y-m-d H:i:s');
        // $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
        // $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
        // $modStokOaNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modStokOaNew->tgltransaksi = $opnamedet->tglperiksafisik;
        $modStokOaNew->stokopnamegizidet_id = $opnamedet->stokopnamegizidet_id;

        if ($modStokOaNew->validate()) {
            $modStokOaNew->save();
        } else {
            $this->stokbahanmakanantersimpan &= false;
        }
        return $modStokOaNew;
    }

}
