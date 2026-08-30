<?php
Yii::import('billingKasir.controllers.PembayaranTagihanPasienController');
class PembayaranPenjualanApotekController extends PembayaranTagihanPasienController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';
    public $successSave = false;
    public $pesan = "";

    /**
     * Membuat dan menyimpan data baru.
     * jika dari informasi menggunakan @params:
     * - $_GET['instalasi_id']
     * layout frame=1 -> frameDialog
     */
    public function actionIndex($id=null)
    {
        $format = new MyFormatter();
        $modPenjualan=new BKInformasipenjualanaresepV;
        $model=new BKPembayaranpelayananT;
        $modTandabukti = new BKTandabuktibayarT;
        $modTandabukti->is_menggunakankartu = 0;
        $modOasudahbayar = new BKOasudahbayarT();
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modBayarangsuran = new BKBayarangsuranpelayananT;
        $dataOas = array();

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

        // Uncomment the following line if AJAX validation is needed

	if(isset($_GET['penjualanresep_id'])){
            $modPenjualan = BKInformasipenjualanaresepV::model()->findByAttributes(array('penjualanresep_id'=>$_GET['penjualanresep_id']));
            $model->noresep = $modPenjualan->noresep;
        }

        if(isset($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }


        if(isset($_POST['penjualanresep_id']) && isset($_POST['BKPembayaranpelayananT']) && (isset($_POST['BKTindakanPelayananT']) || isset($_POST['BKObatalkesPasienT'])))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
               

                $modPenjualan->attributes = $_POST;
                $model=$this->simpanPembayaranPelayanan($model,$_POST['BKPembayaranpelayananT']);
                $modTandabukti=$this->simpanTandaBuktiBayar($model,$modTandabukti,$_POST['BKTandabuktibayarT']);
                if($_POST['BKPemakaianuangmukaT']['pemakaianuangmuka'] > 0){ //jika ada pemakaian uang muka
                    $modPemakaianuangmuka=$this->simpanPemakaianUangMuka($model,$modPemakaianuangmuka,$_POST['BKPemakaianuangmukaT']);
                }else{
                    $this->pemakaianuangmuka_tersimpan = true; //bypass uang muka
                }
                
                if($modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_CICILAN || $modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_HUTANG){
                    $modBayarangsuran=$this->simpanBayarAngsuran($model,$modTandabukti,$modBayarangsuran);
                }else{
                    $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
                }
                
                if(isset($_POST['BKObatalkesPasienT'])){
                    $dataOas = $this->simpanBayarOas($model, $modOasudahbayar, $_POST['BKObatalkesPasienT']);
                }else{
                    $this->oasudahbayar_tersimpan = true; //bypass oa jika tidak ada
                }
                
                if($this->pembayaranpelayanan_tersimpan && $this->tandabuktibayar_tersimpan && $this->oasudahbayar_tersimpan && $this->pemakaianuangmuka_tersimpan && $this->bayarangsuran_tersimpan){
                    //Di set di form >> Yii::app()->user->setFlash('success', 'Data pembayaran berhasil disimpan !');
                    if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                         if(count((array)$dataOas)){
                            $rekening5Penjualan_id = null;
                            $penjualan_id = null;
                             foreach ($dataOas as $dataOap){
                                 $criteria = new CDbCriteria();
                                 $criteria->addCondition('obatalkespasien_id ='.$dataOap->obatalkespasien_id);
                                 $criteria->compare('LOWER(urianjurnal)', strtolower('PIUTANG FARMASI'),true);
                                 $modJurnalPenjualan = JurnalrekeningT::model()->find($criteria);

                                 if(!empty($modJurnalPenjualan)){
                                    $modJurnalDetPenjualan = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id'=>$modJurnalPenjualan->jurnalrekening_id),array('order'=>'nourut DESC'));
                                    // $rekening5Penjualan_id = null;

                                    if(count((array)$modJurnalDetPenjualan) > 0){
                                         foreach ($modJurnalDetPenjualan as $jurnDetPenj){
                                            if($jurnDetPenj->saldodebit > 0){
                                                $rekening5Penjualan_id = $jurnDetPenj->rekening5_id;
                                            }
                                         }
                                    }
                                 }
                                 $penjualan_id = $dataOap->penjualanresep_id;
                            }
                            
                            
                            if(!empty($rekening5Penjualan_id) && !empty($penjualan_id)){
                                $modJurnalRekening = $this->saveJurnalRekening($model, $penjualan_id);
                                $rekening5_carabayar_id = null;
                                $rominalRek = 0;
                                $nourutJur = 1;
                                $jenispembayaranT = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$modTandabukti->tandabuktibayar_id));
                                
                                if(count((array)$jenispembayaranT)>0){
                                    foreach ($jenispembayaranT as $jnsPemb) {
                                        $criteriaJnsPem = new CDbCriteria();
                                        $criteriaJnsPem->addCondition('jnspembayar_id = '.$jnsPemb->jnspembayar_id);

                                        if(!empty($jnsPemb->bankpenerima_id)){
                                            $criteriaJnsPem->addCondition('bank_id = '.$jnsPemb->bankpenerima_id);
                                        }
                                        $criteriaJnsPem->addCondition("debitkredit = 'D'");
                                        $criteriaJnsPem->limit = 1;
                                        $jnspembRek = JnspembrekM::model()->find($criteriaJnsPem);

                                        if(isset($jnspembRek)){
                                            if(!empty($jnspembRek->rekening5_id)){
                                                $this->saveJurnalDetail($modJurnalRekening, $jnspembRek->rekening5_id, $jnsPemb->jumlahpembayaran,'D',$nourutJur);
                                                $nourutJur++;
                                            }
                                        }

                                    }
                                } else{
                                  
                                    if(!empty($modTandabukti->carapembayaran) && $modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_TUNAI){
                                        $modRekCaraByr = CarapembrekM::model()->findByAttributes(array('carapembayaran'=>$modTandabukti->carapembayaran,'debitkredit'=>'D'));
                                        $rekening5_carabayar_id = (isset($modRekCaraByr)?$modRekCaraByr->rekening5_id:null);
                                        $rominalRek = ($modTandabukti->uangditerima - $modTandabukti->uangkembalian);
                                       
                                        if(!empty($rekening5_carabayar_id) && $rekening5_carabayar_id != null){
                                            
                                                $this->saveJurnalDetail($modJurnalRekening, $rekening5_carabayar_id, $rominalRek,'D',1);
                                        }
                                       
                                    }
                                }
                                if($modTandabukti->jmlpembulatan != 0){
                                    $rekeningColumnBulat = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_TANDABUKTIBAYART, 'column_name'=>Params::REKENINGCOLUMN_COLUMN_JMLPEMBULATANBAYAR,'debitkredit'=>'K'));

                                    if(isset($rekeningColumnBulat)){
                                        if(!empty($rekeningColumnBulat->rekening5_id)){
                                            $nourutJur = ($nourutJur + 1);
                                            if($modTandabukti->jmlpembulatan > 0){
                                                $this->saveJurnalDetail($modJurnalRekening, $rekeningColumnBulat->rekening5_id, abs($modTandabukti->jmlpembulatan),'K',$nourutJur);
                                            }else{
                                                $this->saveJurnalDetail($modJurnalRekening, $rekeningColumnBulat->rekening5_id, abs($modTandabukti->jmlpembulatan),'D',$nourutJur);
                                            }
                                        }
                                    }

                                }

                                if(!empty($rekening5Penjualan_id) && $rekening5Penjualan_id != null){
                                    $nourutJur = ($nourutJur + 1);
                                    $this->saveJurnalDetail($modJurnalRekening, $rekening5Penjualan_id, $model->totaliurbiaya,'K',$nourutJur);
                                }
                            }
                        }
                    }



                    // SMS GATEWAY
                    $modPasien = $model->pasien;
                    $modPegawai = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
                    $sms = new Sms();
                    $smspasien = 1;
                    $smspegawai = 1;
                    // echo "<pre>";print_r($modPenjualan->attributes); exit();
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $modTandabukti->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        $attributes = $model->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                        }
                        if(isset($modPegawai)){
                            $attributes = $modPegawai->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                        }
                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modTandabukti->tglbuktibayar),$isiPesan);

                        if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                            if(!empty($modPasien->no_mobile_pasien)){
                                $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                            }else{
                                $smspasien = 0;
                            }
                        }
                        if($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms){
                            if(!empty($modPasien->no_mobile_pasien)){
                                $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                            }else{
                                $smspegawai = 0;
                            }
                        }

                    }
                    // END SMS GATEWAY

                    $transaction->commit();
                    $this->redirect(array('index','id'=>$model->pembayaranpelayanan_id,'penjualanresep_id'=>$modPenjualan->penjualanresep_id,'sukses'=>1,'smspasien'=>$smspasien,'smspegawai'=>$smspegawai));
                }else{
                    Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
                    $model->isNewRecord = true;
                    $model->pembayaranpelayanan_id = null;
                    $transaction->rollback();
                }
            }catch (Exception $exc) {
                Yii::app()->user->setFlash('error',"Data pembayaran gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                $transaction->rollback();
            }
        }

        if(!empty($id)){
            $model = BKPembayaranpelayananT::model()->findByPk($id);
            $modTandabukti = BKTandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
            $modTandabukti->is_menggunakankartu = 0;
            $modPemakaianuangmuka = BKPemakaianuangmukaT::model()->findByPk($model->pembayaranpelayanan_id);
            if(!isset($modPemakaianuangmuka)){
                $modPemakaianuangmuka = new BKPemakaianuangmukaT;
            }
            $modBayarangsuran = new BKBayarangsuranpelayananT;
            $modBayarangsuran = new BKBayarangsuranpelayananT;
        }

        $modPenjualan->tglpenjualan = $format->formatDateTimeForUser($modPenjualan->tglpenjualan);
        $modPenjualan->tanggal_lahir = $format->formatDateTimeForUser($modPenjualan->tanggal_lahir);

        $this->notifBayarApotek($model, $modPenjualan);

        $this->render('index',array(
            'model'=>$model,
            'modTandabukti'=>$modTandabukti,
            'modPenjualan'=>$modPenjualan,
            'dataOas'=>$dataOas,
            'modPemakaianuangmuka'=>$modPemakaianuangmuka,
        ));
    }

    protected function notifBayarApotek($model, $modPenjualan) {
        $judul = "Pembayaran ". ucwords(strtolower($modPenjualan->jenispenjualan))." - ".$modPenjualan->noresep;

        $isi = "Tgl. Pembayaran : ".MyFormatter::formatDateTimeForUser($model->tglpembayaran)."<br/>";
        $isi .= "No. Pembayaran : ".$model->nopembayaran."<br/>";

        $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
        $kasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

        $cur = array(
            array('instalasi_id'=>$ruanganAkuntansi->instalasi_id, 'ruangan_id'=>$ruanganAkuntansi->ruangan_id, 'modul_id'=>$ruanganAkuntansi->modul_id),
            array('instalasi_id'=>$kasir->instalasi_id, 'ruangan_id'=>$kasir->ruangan_id, 'modul_id'=>$kasir->modul_id)
        );
        CustomFunction::broadcastNotif($judul, $isi, $cur);


//        var_dump($judul, $isi, $modPenjualan->attributes, $model->attributes);
//
//        die;
    }

    /**
     * form verifikasi sebelum submit
     * @param type $id
     */
    public function actionVerifikasi()
    {
        $admisi = null;
        if (Yii::app()->request->isAjaxRequest){
            $this->layout = '//layouts/iframe';
            $modJenisPembayaran = array();
            if(isset($_POST['BKPembayaranpelayananT'])){
                $format = new MyFormatter();
                $criteria=new CdbCriteria();
                $jenispenjualan = (isset($_POST['jenispenjualan']) ? $_POST['jenispenjualan'] : null);
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $model = new BKInformasipenjualanaresepV;
                $model->jenispenjualan = $jenispenjualan;

                if (!empty($pendaftaran_id)) {
                    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                }

                $penjualanresep_id = $_POST['penjualanresep_id'];

                if (in_array($_POST['pasien_id'], array(3,4,5))) {
                    $criteria->addCondition("penjualanresep_id = ".$penjualanresep_id);
                } else {
                    $criteria = $model->criteriaGroupByPenjualan();
                                    if(!empty($pendaftaran_id)){
                                            $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
                                    }

                }
                $modPenjualan = $model->find($criteria);
                // var_dump($modPenjualan->attributes); die;

                if (!empty($modPenjualan->pasienpegawai_id)) {
                    $p = PegawaiM::model()->findBypk($modPenjualan->pasienpegawai_id);
                    $modPenjualan->nama_pasien = $p->namaLengkap;
                    $modPenjualan->tanggal_lahir = MyFormatter::formatDateTimeForUser($p->tgl_lahirpegawai);
                    $modPenjualan->jeniskelamin = $p->jeniskelamin;
                }


                $model = new BKPembayaranpelayananT;
                $modTandabukti = new BKTandabuktibayarT;
                $modPemakaianuangmuka = new BKPemakaianuangmukaT;

                $model->attributes = $_POST['BKPembayaranpelayananT'];
                $modTandabukti->attributes = $_POST['BKTandabuktibayarT'];
                $modTandabukti->is_menggunakankartu = $_POST['BKTandabuktibayarT']['is_menggunakankartu'];
                $modPemakaianuangmuka->attributes = $_POST['BKPemakaianuangmukaT'];


                $indexJns = 1;
                if(isset($_POST['JenispembayaranT']['detail']) && count((array)$_POST['JenispembayaranT']['detail']) > 0){
                  foreach ($_POST['JenispembayaranT']['detail'] as $jnsPem) {
                    $jnsPembyr = JnspembayarM::model()->findByPk($jnsPem['jenispembayaran']);
                    $banknama = "";
                    if(isset($jnsPem['bankpenerima_id'])){
                        $bankPen = BankM::model()->findByPk($jnsPem['bankpenerima_id']);
                        $banknama = (isset($bankPen)? $bankPen->namabank:"");
                    }

                    $jenisPm = array(
                          'jnspembayar_nama'=>(isset($jnsPembyr)?$jnsPembyr->jnspembayar_nama:""),
                          'bank_nama'=> $banknama,
                          'tgltransaksi'=>$jnsPem['tgltransaksi'],
                          'nominal'=>$jnsPem['jumlahpembayaran'],
                          'bayarke'=>$indexJns
                         );
                    $indexJns += 1;

                    $modJenisPembayaran[] = $jenisPm;
                  }
                }
            }
            echo CJSON::encode(array(
                'content'=>$this->renderPartial('verifikasi',array(
                    'format'=>$format,
                    'modPenjualan'=>$modPenjualan,
                    'model'=>$model,
                    'modTandabukti'=>$modTandabukti,
                    'modPemakaianuangmuka'=>$modPemakaianuangmuka,
                    'admisi'=>$admisi,
                    'modJenisPembayaran'=>$modJenisPembayaran
            ), true)));
            exit;
        }
    }


    /**
    * untuk menampilkan data penjualan dari autocomplete
    */
    public function actionAutocompletePenjualan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $jenispenjualan = isset($_GET['jenispenjualan']) ? $_GET['jenispenjualan'] : null;
            $noresep = isset($_GET['noresep']) ? $_GET['noresep'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $model = new BKInformasipenjualanaresepV();
            $model->jenispenjualan = $jenispenjualan;
            $criteria = $model->criteriaGroupByPenjualan();
            $criteria->compare('LOWER(noresep)', strtolower($noresep), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'noresep, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = $model->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->noresep.' - '.$model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
                $returnVal[$i]['value'] = $model->noresep;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Mengurai data penjualan
     * @throws CHttpException
     */
    public function actionGetDataPenjualan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $jenispenjualan = isset($_POST['jenispenjualan']) ? $_POST['jenispenjualan'] : null;
            $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $noresep = isset($_POST['noresep']) ? $_POST['noresep'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
            $model = new BKInformasipenjualanaresepV;
            $model->jenispenjualan = $jenispenjualan;
            $criteria = $model->criteriaGroupByPenjualan();

            $returnVal['dokterpenerima'] = '';
            $returnVal['dpjp1'] = "";
            $returnVal['dpjp2'] = "";
            $returnVal['dpjp3'] = "";

			if(!empty($penjualanresep_id)){
				$criteria->addCondition("penjualanresep_id = ".$penjualanresep_id);
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);
			}
            $criteria->compare('LOWER(noresep)',strtolower($noresep));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($no_rekam_medik));
            $model = $model->find($criteria);
            $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
            $attributes = $model->attributeNames();

            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }

            $carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
            $returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);

            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tglpenjualan"] = $format->formatDateTimeForUser($model->tglpenjualan);
            if (!empty($modPendaftaran)) {
                $returnVal["umur"] = $modPendaftaran->umur;

                if (!empty($modPendaftaran->pasienadmisi_id)) {
                    $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

                    if (!empty($admisi->dokterpenerima_id)) {
                        $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
                        $returnVal['dokterpenerima'] = $peg->namaLengkap;
                    }

                    if (!empty($admisi->pegawai_id)) {
                        $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
                        $returnVal['dpjp1'] = $peg->namaLengkap;
                    }

                    if (!empty($admisi->dpjp2_id)) {
                        $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
                        $returnVal['dpjp2'] = $peg->namaLengkap;
                    }

                    if (!empty($admisi->dpjp3_id)) {
                        $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
                        $returnVal['dpjp3'] = $peg->namaLengkap;
                    }
                }
            }
            $modPenunjangAkhir = $model->getPenunjangAkhir();
            $returnVal["ruangan_id"] = $modPenunjangAkhir->ruangan_id;
            $returnVal["ruangan_nama"] = $modPenunjangAkhir->ruangan_nama;
            if(!empty($model->pasienpegawai_id)){
                $modPegawai = PegawaiM::model()->findByPk($model->pasienpegawai_id);
                $gelardepan = (isset($modPegawai->gelardepan) ? $modPegawai->gelardepan : "");
                $gelarbelakang = (isset($modPegawai->gelarbelakang_id) ? $modPegawai->gelarbelakang->gelarbelakang_nama : "");
                $returnVal["nama_pasien"] = $gelardepan." ".$modPegawai->nama_pegawai." ".$gelarbelakang;
                $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai);
                $returnVal["jeniskelamin"] = $modPegawai->jeniskelamin;
            }
            if(isset($jenispenjualan) && $jenispenjualan =='PENJUALAN UNIT'){
                $returnVal["nama_pasien"] = $model->instalasiasal_nama;
            }



            //load uang muka
            $modUangMuka = new BKBayaruangmukaT;
            if(isset($model->pendaftaran_id)){
                $crit_uangmuka = new CDbCriteria();
				if(!empty($model->pendaftaran_id)){
					$crit_uangmuka->addCondition("pendaftaran_id = ".$model->pendaftaran_id);
				}
				if(!empty($model->pasienadmisi_id)){
					$crit_uangmuka->addCondition("pasienadmisi_id = ".$model->pasienadmisi_id);
				}
                $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
            }else{
                $returnVal["jumlahuangmuka"] = 0;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * menampilkan form rincian tagihan farmasi apotek
     */
    public function actionSetRincianObatalkes(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $jenispenjualan=(isset($_POST['jenispenjualan']) ? $_POST['jenispenjualan'] : null);
            $penjualanresep_id=(isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null);
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id=(isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $form='';
            $dataOas = array();
            $res = null;

            $jual = PenjualanresepT::model()->findByPk($penjualanresep_id);
            $oa = ObatalkespasienT::model()->findByAttributes(array('penjualanresep_id' => $jual->penjualanresep_id));
            //$pendaftaran_id = $oa->pendaftaran_id;

            if (empty($kelaspelayanan_id)) {
                $kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
            }

            $modTanggungan = null;
            if(!empty($pendaftaran_id)){
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
             
                if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
                    $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$kelaspelayanan_id,'penjamin_id'=>$penjamin_id));

                } 
                else if(!empty($modPendaftaran->asuransipasien_id)){
                    $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                    if(!empty($modAsuransiPasien->kelastanggunganasuransi_id) && !empty($penjamin_id)){
                        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modAsuransiPasien->kelastanggunganasuransi_id,'penjamin_id'=>$penjamin_id));
                    }
                }
            }

            if(!empty($penjualanresep_id)){
                $criteria = new CdbCriteria();
                $criteria->addCondition("penjualanresep_id = ".$penjualanresep_id);
                $criteria->addCondition("oasudahbayar_id IS NULL");
                $dataOas= BKObatalkesPasienT::model()->findAll($criteria);
                $res = BKPenjualanresepT::model()->findByPk($penjualanresep_id);
            }

            $form = $this->renderPartial('_formRincianPenjualanApotek',array('dataOas'=>$dataOas, 'data'=>$res, 'penjamin_id'=>$penjamin_id, 'modTanggungan'=>$modTanggungan),true);
            $data['form']=$form;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * actionPrintRincianBelumBayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintRincianApotekSudahBayar($pembayaranpelayanan_id){
        $this->layout='//layouts/printWindows';
        $modOasudahbayar = BKOasudahbayarT::model()->find('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $modObatAlkesPasien = BKObatalkesPasienT::model()->find('obatalkespasien_id = '.$modOasudahbayar->obatalkespasien_id);
        $modPenjualan = BKPenjualanresepT::model()->find('penjualanresep_id = ' . $modObatAlkesPasien->penjualanresep_id . '');
        $criteria = new CDbCriteria();
        $criteria->addCondition('penjualanresep_id = '.$modPenjualan->penjualanresep_id);
        $criteria->addCondition('oasudahbayar_id is NOT NULL');
        $obatAlkes = BKObatalkesPasienT::model()->findAll($criteria);
        $daftar = BKPendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$obatAlkes[0]->pendaftaran_id));
        $pasien = BKPasienM::model()->findByAttributes(array('pasien_id'=>$obatAlkes[0]->pasien_id));

         $judulLaporan='Laporan Penerimaan Kas';
             $this->render('PrintPenjualanApotekSudahBayar',array('modPenjualan'=>$modPenjualan, 'daftar'=>$daftar,'pasien'=>$pasien,'obatAlkes'=>$obatAlkes, 'judulLaporan'=>$judulLaporan));

    }

    /**
     * actionPrintRincianBelumBayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintRincianPenunjangBelumBayar($instalasi_id,$pendaftaran_id){
        $this->layout='//layouts/printWindows';
        $data['judulLaporan'] = 'RINCIAN BIAYA PELAYANAN';
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
        $dataUangmukas = BayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $uang_muka = 0;
        foreach($dataUangmukas as $uangmuka)
        {
            $uang_muka += $uangmuka->jumlahuangmuka;
        }
        $data['uang_muka'] = $uang_muka;
        $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        $criteria->addCondition('instalasi_id = '.$instalasi_id);
        $criteria->order = 'ruangan_id';
        $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAll($criteria);
        $this->render('printRincianPenunjangBelumBayar', array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modRincian'=>$modRincian, 'data'=>$data));

    }

    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pembayaran_id
     */
    public function actionPrintRincianSudahBayar($pembayaranpelayanan_id){
        $this->layout='//layouts/printWindows';
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $modPendaftaran = BKPendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        if(isset($modPendaftaran->pasien_id)){
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        }else{
            $modPasien = PasienM::model()->findByPk($modPembayaran->pasien_id);
        }
        $modPemakaianuangmuka = BKPemakaianuangmukaT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$pembayaranpelayanan_id));
        $data['judulLaporan'] = 'RINCIAN BIAYA ('.$modPembayaran->statusbayar.")";
        $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
        $criteria = new CDbCriteria();
        if(isset($modPendaftaran->pasien_id)){
            $criteria->addCondition('pendaftaran_id = '.$modPembayaran->pendaftaran_id);
        }else{
            $criteria->addCondition('pasien_id = '.$modPembayaran->pasien_id);
        }
        $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'ruangan_id';
        $modRincian = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $this->render('printRincianSudahBayar', array('modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'modPembayaran'=>$modPembayaran, 'modPemakaianuangmuka'=>$modPemakaianuangmuka,'modRincian'=>$modRincian, 'data'=>$data));
    }

    protected function saveJurnalRekening($model, $penjualanresep_id)
    {
        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }

        $format = new MyFormatter();
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
        $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tandabukti->tglbuktibayar);
        $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $model->nopembayaran;
        $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tandabukti->tglbuktibayar);
        $modJurnalRekening->nobku = "";

        $noresep = "";
        $namapasien = "";

        $modPenjualan = PenjualanresepT::model()->findByPk($penjualanresep_id);
        if(isset($modPenjualan)){
            $noresep = $modPenjualan->noresep;

            if(!empty($modPenjualan->pasienpegawai_id)){
                $modPeg = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);

                $namapasien = (isset($modPeg)?$modPeg->namaLengkap:"");
            }else{
                 $modPeg = PasienM::model()->findByPk($modPenjualan->pasien_id);

                $namapasien = (isset($modPeg)?$modPeg->namadepan." ". $modPeg->nama_pasien:"");
            }
        }

        $modJurnalRekening->urianjurnal = 'Pembayaran Tagihan Apotek '. $model->nopembayaran ." - ". $noresep." ".$namapasien;

        $periodeID = $period;
        $modJurnalRekening->rekperiod_id = $periodeID;
        $modJurnalRekening->create_time = date('Y-m-d H:i:s');
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->tandabuktibayar_id = $model->tandabukti->tandabuktibayar_id;

        if($modJurnalRekening->validate()){
            $modJurnalRekening->save();
            $this->successSave = true;

        } else {
            $this->successSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
        }
        return $modJurnalRekening;
    }

    public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldo, $typeSaldo, $nourut, $jnspemb_id = null, $bank_id = null){
        $valid = true;
//        $modJurnalPosting = null;
        
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
        $modelJurnalDetail->rekening5_id = $rekening5_id;
        
        $modelJurnalDetail->nourut = $nourut;
        if($typeSaldo == 'K'){
            $modelJurnalDetail->saldokredit = $nilaisaldo;
            $modelJurnalDetail->saldodebit = 0;
        }else if($typeSaldo == 'D'){
            $modelJurnalDetail->saldodebit = $nilaisaldo;
            $modelJurnalDetail->saldokredit = 0;
        }

        if(!empty($jnspemb_id)){
          $modelJurnalDetail->jnspembayar_id = $jnspemb_id;
        }
        if(!empty($bank_id)){
          $modelJurnalDetail->bank_id = $bank_id;
        }

        if($modelJurnalDetail->validate()){
                $modelJurnalDetail->save();
        }else{
//                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
            $valid = false;
        }

        return $valid;
    }
}
