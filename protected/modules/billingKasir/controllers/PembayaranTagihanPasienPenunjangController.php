<?php
Yii::import('billingKasir.controllers.PembayaranTagihanPasienController');
/**
 * action ini digunakan untuk mengelola transaksi penunjang, dimana beberapa fungsinya diambil dari controller lain
 *
 * @package application.modules.billingKasir
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class PembayaranTagihanPasienPenunjangController extends PembayaranTagihanPasienController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';

    /**
     * Membuat dan menyimpan data baru.
     * jika dari informasi menggunakan
     * @params type $id
     * - $_GET['instalasi_id']
     * - $_GET['pendaftaran_id']
     * layout frame=1 -> frameDialog
     */
    public function actionIndex($id=null)
    {
        $format = new MyFormatter();
        $modKunjungan=new BKPasienmasukpenunjangV;
        $model=new BKPembayaranpelayananT;
        $modTandabukti = new BKTandabuktibayarT;
        $modTandabukti->is_menggunakankartu = 0;
        $modTindakansudahbayar = new BKTindakansudahbayarT;
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modBayarangsuran = new BKBayarangsuranpelayananT;
        $dataTindakanPenunjangs = array();
        $modAntrian=new BKAntrianT;

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

        $modPiutangAsuransi = new BKPiutangasuransiT();

        // Uncomment the following line if AJAX validation is needed

        if(isset($_GET['instalasi_id']) && isset($_GET['pendaftaran_id'])){
            $modKunjungan = BKPasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));
            $modInstalasi = InstalasiM::model()->findByPk($_GET['instalasi_id']);
            $modKunjungan->instalasi_id = $modInstalasi->instalasi_id;
            $modKunjungan->instalasi_nama = $modInstalasi->instalasi_nama;
        }

        if(!empty($_GET['pembayaranpelayanan_id'])){
            $model = BKPembayaranpelayananT::model()->findByPk($_GET['pembayaranpelayanan_id']); 

            if(empty($model)){
                $model=new BKPembayaranpelayananT;
            }
        }

        if(!empty($_GET['tandabuktibayar_id'])){
            $modTandabukti = BKTandabuktibayarT::model()->findByPk($_GET['tandabuktibayar_id']); 

            if(empty($modTandabukti)){
                $modTandabukti = new BKTandabuktibayarT;
            }
        }


        if(isset($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }


        if(isset($_POST['pendaftaran_id']) && isset($_POST['BKPembayaranpelayananT']) && (isset($_POST['BKTindakanPelayananT']) || isset($_POST['BKObatalkesPasienT'])))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
               
                if(!empty($_POST['BKPiutangasuransiT'])){
                    foreach($_POST['BKPiutangasuransiT'] as $piutang){
                        $modKunjungan->attributes = $_POST;
                        $model=$this->simpanPembayaranPelayanan($model,$_POST['BKPembayaranpelayananT'], $piutang);

                        $modPiutangAsuransi = new BKPiutangasuransiT();
                        $modPiutangAsuransi->attributes = $piutang;
                        $modPiutangAsuransi->pembayaranpelayanan_id = $model->pembayaranpelayanan_id;
                        $modPiutangAsuransi->save();

                        if (isset($_POST['BKPembayaranpelayananT']['total_inacbg_2'])) {
                            $this->simpanAsuransiKelas($model, $_POST['BKPembayaranpelayananT']['total_inacbg_2']);
                        }
                        
                        // $modTandabukti = new BKTandabuktibayarT;
                        $modTandabukti=$this->simpanTandaBuktiBayar($model,$modTandabukti,$_POST['BKTandabuktibayarT']);
                        if($_POST['BKPemakaianuangmukaT']['pemakaianuangmuka'] > 0){ //jika ada pemakaian uang muka
                            $modPemakaianuangmuka=$this->simpanPemakaianUangMuka($model,$modPemakaianuangmuka,$_POST['BKPemakaianuangmukaT']);
        
                            TandabuktibayarT::model()->updateByPk($modTandabukti->tandabuktibayar_id, array(
                                'bayaruangmuka_id'=>$modPemakaianuangmuka->bayaruangmuka_id,
                            ));
                        }else{
                            $this->pemakaianuangmuka_tersimpan = true; //bypass uang muka
                        }
        
                         if (isset($_POST['BKPembayaranpelayananT']['totalsisatagihan'])){
                            if($_POST['BKPembayaranpelayananT']['totalsisatagihan'] > 0) {
                                $modBayarangsuran=$this->simpanBayarAngsuran($model,$modTandabukti,$modBayarangsuran);
                            }else{
                                $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
                            }
                        }else{
                            $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
                        }

                        if(isset($_POST['BKTindakanPelayananT'])){
                            if (count((array)$_POST['BKTindakanPelayananT']) > 0){
                                foreach($_POST['BKTindakanPelayananT'] AS $i => $tindakanPenunjang){
                                    $dataTindakanPenunjangs[$i] = $this->simpanBayarTindakans($model, $modTindakansudahbayar, $tindakanPenunjang);
                                }
                            }
                        }else{
                            $this->tindakansudahbayar_tersimpan = true; //bypass tindakan jika tidak ada
                        }
                        
                        $td = TindakanpelayananT::model()->findByAttributes(array(
                                'pendaftaran_id'=>$model->pendaftaran_id
                        ), array(
                                'condition'=>'tindakansudahbayar_id is null and qty_tindakan <> 0'
                        ));
                        $this->bayarsemuatindakanoa = empty($td);
        
                        if($this->bayarsemuatindakanoa){//jika semua terbayar
                            if(!empty($model->pasienadmisi_id)){
                              $modUpdateAdmisi = PasienadmisiT::model()->updateByPk($model->pasienadmisi_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                            }else{
                              $modUpdatePendaftaran = PendaftaranT::model()->updateByPk($model->pendaftaran_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                            }
                        }
        
        
                        if (!empty($model->pembayaranpelayanan_id)) {
                            $rek = JurnalrekeningT::model()->findByAttributes(array(
                                'tandabuktibayar_id' => $modTandabukti->tandabuktibayar_id,
                            ));
                            if (!empty($rek)) {
                                JurnaldetailT::model()->deleteAllByAttributes(array(
                                    'jurnalrekening_id' => $rek->jurnalrekening_id,
                                ));
                                JurnalrekeningT::model()->deleteByPk($rek->jurnalrekening_id);
                                // ----- end hapus jurnal rekening
                            }

                            $res = Yii::app()->db
                                ->createCommand("select setpembayaran_fix_bkm3(".$model->pembayaranpelayanan_id.") as simpan")
                                ->queryRow();
        
                            if (!empty($res)) {
                                $this->pembayaranpelayanan_tersimpan = $this->pembayaranpelayanan_tersimpan && $res['simpan'];
                            }
                        }

                    }
                }else{
                    $modKunjungan->attributes = $_POST;
                    $model=$this->simpanPembayaranPelayanan($model,$_POST['BKPembayaranpelayananT']);

                    if (isset($_POST['BKPembayaranpelayananT']['total_inacbg_2'])) {
                        $this->simpanAsuransiKelas($model, $_POST['BKPembayaranpelayananT']['total_inacbg_2']);
                    }

                    $modTandabukti=$this->simpanTandaBuktiBayar($model,$modTandabukti,$_POST['BKTandabuktibayarT']);
                    if($_POST['BKPemakaianuangmukaT']['pemakaianuangmuka'] > 0){ //jika ada pemakaian uang muka
                        $modPemakaianuangmuka=$this->simpanPemakaianUangMuka($model,$modPemakaianuangmuka,$_POST['BKPemakaianuangmukaT']);

                        TandabuktibayarT::model()->updateByPk($modTandabukti->tandabuktibayar_id, array(
                            'bayaruangmuka_id'=>$modPemakaianuangmuka->bayaruangmuka_id,
                        ));
                    }else{
                        $this->pemakaianuangmuka_tersimpan = true; //bypass uang muka
                    }

                    if (isset($_POST['BKPembayaranpelayananT']['totalsisatagihan'])){
                        if($_POST['BKPembayaranpelayananT']['totalsisatagihan'] > 0) {
                            $modBayarangsuran=$this->simpanBayarAngsuran($model,$modTandabukti,$modBayarangsuran);
                        }else{
                            $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
                        }
                    }else{
                        $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
                    }

    //                if($modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_CICILAN || $modTandabukti->carapembayaran == Params::CARAPEMBAYARAN_HUTANG){
    //                    $modBayarangsuran=$this->simpanBayarAngsuran($model,$modTandabukti,$modBayarangsuran);
    //                }else{
    //                    $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
    //                }
                    if(isset($_POST['BKTindakanPelayananT'])){
                        if (count((array)$_POST['BKTindakanPelayananT']) > 0){
                            foreach($_POST['BKTindakanPelayananT'] AS $i => $tindakanPenunjang){
                                $dataTindakanPenunjangs[$i] = $this->simpanBayarTindakans($model, $modTindakansudahbayar, $tindakanPenunjang);
                            }
                        }
                    }else{
                        $this->tindakansudahbayar_tersimpan = true; //bypass tindakan jika tidak ada
                    }
                    
                    $td = TindakanpelayananT::model()->findByAttributes(array(
                            'pendaftaran_id'=>$model->pendaftaran_id
                    ), array(
                            'condition'=>'tindakansudahbayar_id is null and qty_tindakan <> 0'
                    ));
                    $this->bayarsemuatindakanoa = empty($td);

                    if($this->bayarsemuatindakanoa){//jika semua terbayar
                        if(!empty($model->pasienadmisi_id)){
                        $modUpdateAdmisi = PasienadmisiT::model()->updateByPk($model->pasienadmisi_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                        }else{
                        $modUpdatePendaftaran = PendaftaranT::model()->updateByPk($model->pendaftaran_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
                        }
                    }


                    if (!empty($model->pembayaranpelayanan_id)) {
                        $res = Yii::app()->db
                            ->createCommand("select setpembayaran_fix_bkm3(".$model->pembayaranpelayanan_id.") as simpan")
                            ->queryRow();

                        if (!empty($res)) {
                            $this->pembayaranpelayanan_tersimpan = $this->pembayaranpelayanan_tersimpan && $res['simpan'];
                        }
                    }
                }
                

                if($this->pembayaranpelayanan_tersimpan && $this->tandabuktibayar_tersimpan && $this->tindakansudahbayar_tersimpan && $this->pemakaianuangmuka_tersimpan && $this->bayarangsuran_tersimpan){
                    //Di set di form >> Yii::app()->user->setFlash('success', 'Data pembayaran berhasil disimpan !');
                    
                    if(!empty($modKunjungan->pasienmasukpenunjang_id)){
                        $modPenunjangfind = PasienmasukpenunjangT::model()->findByPk($modKunjungan->pasienmasukpenunjang_id);

                        if(isset($modPenunjangfind)){
                            if($modPenunjangfind->ruangan_id == 90){ //Fisioterapi
                                PasienmasukpenunjangT::model()->updateByPk($modPenunjangfind->pasienmasukpenunjang_id, array('statusperiksa'=> Params::STATUSPERIKSA_SUDAH_PULANG));
                            }
                        }
                    }


                    // SMS GATEWAY
                    $modPasien = $model->pasien;
                    $sms = new Sms();
                    $smspasien = 1;
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

                        $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modTandabukti->tglbuktibayar),$isiPesan);

                        if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                            if(!empty($modPasien->no_mobile_pasien)){
                                $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                            }else{
                                $smspasien = 0;
                            }
                        }

                    }
                    // END SMS GATEWAY

                    $transaction->commit();
                    $this->redirect(array('index','id'=>$model->pembayaranpelayanan_id,'instalasi_id'=>$_POST['instalasi_id'],'pendaftaran_id'=>$_POST['pendaftaran_id'],'sukses'=>1,'smspasien'=>$smspasien));
                }else{
                    Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
                    $model->isNewRecord = true;
                    $model->pembayaranpelayanan_id = null;
                    $transaction->rollback();
//                    echo "1.". $this->pembayaranpelayanan_tersimpan."<br>";
//                    echo "2.". $this->tandabuktibayar_tersimpan."<br>";
//                    echo "3.". $this->tindakansudahbayar_tersimpan."<br>";
//                    echo "4.". $this->pemakaianuangmuka_tersimpan."<br>";
//                    echo "5.". $this->bayarangsuran_tersimpan."<br>";
//                    exit;
                }
            }catch (Exception $exc) {
//                var_dump($exc->getMessage(), $exc->getTrace()); die;
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

        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render('index',array(
            'model'=>$model,
            'modTandabukti'=>$modTandabukti,
            'modKunjungan'=>$modKunjungan,
            'dataTindakanPenunjangs'=>$dataTindakanPenunjangs,
            'modPemakaianuangmuka'=>$modPemakaianuangmuka,
            'modAntrian'=>$modAntrian,
            'modPiutangAsuransi'=>$modPiutangAsuransi
        ));
    }

    /**
     * form verifikasi sebelum submit
     */
    public function actionVerifikasi()
    {
        if (Yii::app()->request->isAjaxRequest){
            $this->layout = '//layouts/iframe';
            if(isset($_POST['BKPembayaranpelayananT'])){
                $format = new MyFormatter();
                $criteria=new CdbCriteria();
                $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $admisi = null;

                $model = new BKPasienmasukpenunjangV;
                $model->instalasi_id = $instalasi_id;
                $criteria = $model->criteriaGroupByPendaftaran();
				if(!empty($pendaftaran_id)){
					$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
				}
                $modKunjungan = $model->find($criteria);

                if (empty($modKunjungan)) {
                    $modKunjungan = BKPasienmasukpenunjangV::model()->findByAttributes(array(
                        'pendaftaran_id'=>$pendaftaran_id
                    ));
                }

                $modKunjungan->instalasi_nama = InstalasiM::model()->findByPk($instalasi_id)->instalasi_nama;
                $model = new BKPembayaranpelayananT;
                $modTandabukti = new BKTandabuktibayarT;
                $modPemakaianuangmuka = new BKPemakaianuangmukaT;

                $model->attributes = $_POST['BKPembayaranpelayananT'];
                $modTandabukti->attributes = $_POST['BKTandabuktibayarT'];
                $modTandabukti->is_menggunakankartu = $_POST['BKTandabuktibayarT']['is_menggunakankartu'];
                $modPemakaianuangmuka->attributes = $_POST['BKPemakaianuangmukaT'];

            }

            $modJenisPembayaran = array();
            echo CJSON::encode(array(
                'content'=>$this->renderPartial($this->path_view.'verifikasi',array(
                    'format'=>$format,
                    'modKunjungan'=>$modKunjungan,
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
    * untuk menampilkan data kunjungan dari autocomplete
    * - no_pendaftaran
    * - no_rekam_medik
    * - nama_pasien
    */
    public function actionAutocompleteKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $model = new BKPasienmasukpenunjangV;
            $model->instalasi_id = $instalasi_id;
            $criteria = $model->criteriaGroupByPendaftaran();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = $model->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran.' - '.$model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
                $returnVal[$i]['value'] = $model->no_pendaftaran;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    /**
     * Mengurai data kunjungan berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $notif = array('ok'=>1, 'msg'=>'');

            $criteria = new CDbCriteria();
            $model = new BKPasienmasukpenunjangV;
            $model->instalasi_id = $instalasi_id;
            $criteria = $model->criteriaGroupByPendaftaran();
			if(!empty($pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($no_pendaftaran));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($no_rekam_medik));
            $model = $model->find($criteria);

            if (empty($model)) {
                $model = BKPasienmasukpenunjangV::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran_id
                ));
            }

            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $modPenunjangAkhir = $model->getPenunjangAkhir();
            $returnVal["ruangan_id"] = $modPenunjangAkhir->ruangan_id;
            $returnVal["ruangan_nama"] = $modPenunjangAkhir->ruangan_nama;

            $carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
            $returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);

            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);


            //load uang muka
            $crit_uangmuka = new CDbCriteria();
			if(!empty($model->pendaftaran_id)){
				$crit_uangmuka->addCondition("pendaftaran_id = ".$model->pendaftaran_id);
			}
			if(!empty($model->pasienadmisi_id)){
				$crit_uangmuka->addCondition("pasienadmisi_id = ".$model->pasienadmisi_id);
			}
            $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
            $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
            $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
            $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
            $returnVal["notif"] = $notif;


            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * menampilkan form rincian tagihan tindakan penunjang
     */
    public function actionSetRincianTindakanPenunjang(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id=(isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
            $pendaftaran_id=(isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $kelaspelayanan_id=(isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $pembayaranpelayanan_id = (isset($_POST['pembayaranpelayanan_id']) ? $_POST['pembayaranpelayanan_id'] : null);

            $form='';
            $dataTindakanPenunjangs = array();
            $dataPenunjangs = array();


            if(!empty($pendaftaran_id)){
                $criteria = new CDbCriteria();
                $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
                if(!empty($instalasi_id)){
                    $ruangan_ids = array();
                    $modRuangans = RuanganM::model()->findAllByAttributes(array("instalasi_id"=>$instalasi_id), "ruangan_aktif = true");
                    if (count((array)$modRuangans) > 0){
                        foreach($modRuangans AS $i => $ruangan){
                            $ruangan_ids[$i] = $ruangan->ruangan_id;
                        }
                        // $criteria->addInCondition("ruangan_id", $ruangan_ids);
                    }
                }
                $modPasienMasukPenunjangs = BKPasienmasukpenunjangV::model()->findAll($criteria);
                if (count((array)$modPasienMasukPenunjangs) > 0){
                    foreach ($modPasienMasukPenunjangs AS $i => $penunjang){
                        if(!empty($pembayaranpelayanan_id)){
                            $modTindakansudah = TindakansudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id'=>$pembayaranpelayanan_id));
                            if(!empty($modTindakansudah)){
                                foreach($modTindakansudah as $j=> $tdsudah){
                                    $tindakanpel = BKTindakanPelayananT::model()->findByAttributes(array('tindakanpelayanan_id'=>$tdsudah->tindakanpelayanan_id,'pasienmasukpenunjang_id'=>$penunjang->pasienmasukpenunjang_id));
                
                                    if(!empty($tindakanpel)){
                                        $dataTindakanPenunjangs[$i][$j]= $tindakanpel;
                                    }
                                }
                            }
                        }else{
                            $criteria = new CdbCriteria();
                            $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
                            $criteria->addCondition("pasienmasukpenunjang_id = ".$penunjang->pasienmasukpenunjang_id);
                            $criteria->addCondition("tindakansudahbayar_id IS NULL");
                            $dataTindakanPenunjangs[$i]=BKTindakanPelayananT::model()->findAll($criteria);
                        }

                        $dataPenunjangs[$i]['ruangan_nama'] = $penunjang->ruangan_nama;
                        $dataPenunjangs[$i]['no_masukpenunjang'] = $penunjang->no_masukpenunjang;
                        $dataPenunjangs[$i]['tglmasukpenunjang'] = $format->formatDateTimeForUser($penunjang->tglmasukpenunjang);
                        $dataPenunjangs[$i]['jeniskasuspenyakit_nama'] = $penunjang->jeniskasuspenyakit_nama;
                        $dataPenunjangs[$i]['kelaspelayanan_nama'] = $penunjang->kelaspelayanan_nama;
                    }
                }
            }
            $form = $this->renderPartial('_formRincianTindakanPenunjang',array('dataPenunjangs'=>$dataPenunjangs,'dataTindakanPenunjangs'=>$dataTindakanPenunjangs, 'penjamin_id'=>$penjamin_id),true);
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
        $criteria->compare('instalasi_id', $instalasi_id);
        $criteria->order = 'ruangan_id';
        $nopembayaran = '';
        $nama_perusahaan= '';
        $noasuransi = '';
        $penjamin_nama = '';
        $modPenanggungjawab=PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        $subsidiasuransi_tindakan = ''; 
        $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAll($criteria);
        $modPembayaran = PembayaranpelayananT::model()->findByPk($modPendaftaran->pembayaranpelayanan_id);
        $subsidiasuransi_tindakan = ''; 
        // var_dump($modPenanggungjawab);die;
        if (count((array)$modPembayaran)>0){
            foreach ($modPembayaran as $mod => $items){
                $nopembayaran = $items->nopembayaran;
            }
        }
        if (count((array)$modRincian)>0){
            foreach ($modRincian as $mod => $items){
                $nama_perusahaan = $items->namaperusahaan;
                $noasuransi = $items->no_asuransi;
                $subsidiasuransi_tindakan= $items->subsidiasuransi_tindakan;
                $penjamin_nama = $items->penjamin_nama;
            }
        }
        // var_dump($nopembayaran);die;
        $this->render('printRincianPenunjangBelumBayar', array('modPembayaran'=>$modPembayaran,'penjamin_nama'=>$penjamin_nama,'modPenanggungjawab'=>$modPenanggungjawab,'subsidiasuransi_tindakan'=>$subsidiasuransi_tindakan,'noasuransi'=>$noasuransi,'nama_perusahaan'=>$nama_perusahaan,'nopembayaran'=>$nopembayaran,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modRincian'=>$modRincian, 'data'=>$data));

    }
    
    
    protected function simpanBayarTindakans($model, $modTindakansudahbayar, $posts)
    {
        foreach ($posts as $i => $post) {
            $posts[$i]['tarif_satuan'] = is_numeric($post['tarif_satuan']) ? $post['tarif_satuan'] : MyFormatter::formatRupiahForDB($post['tarif_satuan']);
            $posts[$i]['tarifcyto_tindakan'] = is_numeric($post['tarifcyto_tindakan']) ? $post['tarifcyto_tindakan'] : MyFormatter::formatRupiahForDB($post['tarifcyto_tindakan']);
            $posts[$i]['discount_tindakan'] = is_numeric($post['discount_tindakan']) ? $post['discount_tindakan'] : MyFormatter::formatRupiahForDB($post['discount_tindakan']);
            $posts[$i]['pembebasan_tindakan'] = is_numeric($post['pembebasan_tindakan']) ? $post['pembebasan_tindakan'] : MyFormatter::formatRupiahForDB($post['pembebasan_tindakan']);
            $posts[$i]['subsidiasuransi_tindakan'] = is_numeric($post['subsidiasuransi_tindakan']) ? $post['subsidiasuransi_tindakan'] : MyFormatter::formatRupiahForDB($post['subsidiasuransi_tindakan']);
            $posts[$i]['subsisidirumahsakit_tindakan'] = is_numeric($post['subsisidirumahsakit_tindakan']) ? $post['subsisidirumahsakit_tindakan'] : MyFormatter::formatRupiahForDB($post['subsisidirumahsakit_tindakan']);
            $posts[$i]['subsidipemerintah_tindakan'] = is_numeric($post['subsidipemerintah_tindakan']) ? $post['subsidipemerintah_tindakan'] : MyFormatter::formatRupiahForDB($post['subsidipemerintah_tindakan']);
            $posts[$i]['iurbiaya_tindakan'] = is_numeric($post['iurbiaya_tindakan']) ? $post['iurbiaya_tindakan'] : MyFormatter::formatRupiahForDB($post['iurbiaya_tindakan']);
            $posts[$i]['iurbiaya_tindakan_temporary'] = is_numeric($post['iurbiaya_tindakan_temporary']) ? $post['iurbiaya_tindakan_temporary'] : MyFormatter::formatRupiahForDB($post['iurbiaya_tindakan_temporary']);
            $posts[$i]['jmlselisihbpjs'] = is_numeric($post['jmlselisihbpjs']) ? $post['jmlselisihbpjs'] : MyFormatter::formatRupiahForDB($post['jmlselisihbpjs']);
            $posts[$i]['subtotal'] = is_numeric($post['subtotal']) ? $post['subtotal'] : MyFormatter::formatRupiahForDB($post['subtotal']);
            $posts[$i]['jmlbayar_iurtindakan'] = is_numeric($post['jmlbayar_iurtindakan']) ? $post['jmlbayar_iurtindakan'] : MyFormatter::formatRupiahForDB($post['jmlbayar_iurtindakan']);
            $posts[$i]['penjamin_id'] = (!empty($post['penjamin_id'])?$post['penjamin_id']:null);
        }
        
        // var_dump($posts); die;
        return parent::simpanBayarTindakans($model, $modTindakansudahbayar, $posts);

//        var_dump($post); die;
    }

    /**
     * menampilkan form antrian dari request ajax
     * @param type $record
     * @param type $noantrian
     * @throws CHttpException
     */
    public function actionSetFormAntrian(){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $record = (isset($_POST['record']) ? $_POST['record'] : "");
            $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
            $antrian_id = (isset($_POST['antrian_id']) ? $_POST['antrian_id'] : "");
            $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);


            $last = AntrianT::model()->findByAttributes(array(
                'modelantrian_id'=>$loket_id,
            ), array(
                'condition'=>'pendaftaran_id is not null',
                'order'=>'antrian_id desc',
            ));

            if(empty($antrian_id)){ //antrian baru
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria->addCondition("pendaftaran_id IS NULL");
                // $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
                $criteria->compare('modelantrian_id', $loket_id);
                if (!empty($last)) {
                    $criteria->addCondition('antrian_id > '.$last->antrian_id);
                }
                if($record == "reset"){
                    $criteria->addCondition("panggil_flaq = false");
                }
                $criteria->order = "noantrian ASC";
                $criteria->limit = 1;
                $modAntrian =  BKAntrianT::model()->find($criteria);
            }else{
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                // $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
                if(!empty($antrian_id)){$criteria->addCondition("antrian_id = ".$antrian_id); }
                $cari =  BKAntrianT::model()->find($criteria);
                if($record == 'next'){
                    $modAntrian = $cari->AntrianBerikut;
                }else if($record == 'prev'){
                    $modAntrian = $cari->AntrianSebelum;
                }else{
                    $modAntrian = $cari;
                }
            }

            if(!isset($modAntrian)){
                $modAntrian = new BKAntrianT;
                $data['pesan'] = "Antrian Habis !";
            }
            $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
            $modAntrian->modelantrian_id = $loket_id;
            $data['form_antrian'] = $this->renderPartial($this->path_view.'_formPanggilAntrian',array('modAntrian'=>$modAntrian),true);
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


        /**
     * action ketika tombol panggil di klik
     * @param type $antrian_id
     * @param type $loket_id
     * @param type $ket
     * @throws CHttpException
     */
    public function actionPanggil($antrian_id,$loket_id,$ket=null){
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            $data = array();
            $data['pesan']="";
            $modAntrian =  BKAntrianT::model()->findByPk($antrian_id);
            if(isset($modAntrian)){
                /*
                if($modAntrian->panggil_flaq == true){
                    if($ket == "batal"){
                        $modAntrian->panggil_flaq = false;
                        if($modAntrian->update()){
    //                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
                        }
                    }else{
                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." sudah dipanggil sebelumnya !";
                    }
                }else{
                 *
                 */
                    // $modAntrian->panggil_flaq = true;
                    $modAntrian->panggil_flaq = true;
                    $modAntrian->loket_id = $loket_id;
                    if($modAntrian->update()){
                            $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
                    }
                // }
            }
            $attributes = $modAntrian->attributeNames();
            foreach($attributes as $i=>$attribute) {
                $data["$attribute"] = $modAntrian->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

}
