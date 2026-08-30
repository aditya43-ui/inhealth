<?php

Yii::import("billingKasir.controllers.PembayaranTagihanPasienController");

/**
 * Form Bayar Angsuran
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.billingKasir
 * @subpackage controllers
 * @category Controller
 */
class BayarAngsuranController extends PembayaranTagihanPasienController
{
        protected $successSave = false;

        /**
         *
         * Menampilkan form bayar angsuran
         *
         * @param type $view
         * @param type $id
         * @param type $sukses
         * @param type $frame
         * @param type $idPembayaran
         */
        public function actionIndex($view=null, $id=null, $sukses=null, $frame=null, $idPembayaran=null)
	{
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
            $modAngsuran = new BKBayarAngsuranPelayananT;
            // $modAngsuran->pembayaranpelayanan_id = $idPembayaran;
            // $modAngsuran->tandabuktibayar_id = $modPembayaran->tandabuktibayar_id;
            $modAngsuran->sisaangsuran = 0;
            $modAngsuran->tglbayarangsuran = date('d M Y H:i:s');
            $modAngsuran->jmlbayarangsuran = 0;

            $modTandaBukti = new TandabuktibayarT;

            $modPembayaran = new PembayaranpelayananT;
            // isset($_GET['frame'])
            if(!empty($_GET['idPembayaran']))
            {
                // $this->layout = '//layouts/iframe';
                $idPembayaran = $_GET['idPembayaran'];

                $modPembayaran = BKPembayaranpelayananT::model()->findByPk($idPembayaran);
                $tandaBukti = BKTandabuktibayarT::model()->findByPk($modPembayaran->tandabuktibayar_id);
                $model = BKBayarAngsuranPelayananT::model()->findByAttributes(
                    array('pembayaranpelayanan_id'=>$idPembayaran),
                    array('order'=>'bayarke DESC')
                );

                $modSudahBayar = BKBayarAngsuranPelayananT::model()->findAllByAttributes( array('pembayaranpelayanan_id'=>$idPembayaran));

                $totalsudahabayar = 0;
                foreach($modSudahBayar as $m){
                    $totalsudahabayar += $m->jmlbayarangsuran;
                }

                $modAngsuran = new BKBayarAngsuranPelayananT;
                $modAngsuran->pembayaranpelayanan_id = $idPembayaran;
                $modAngsuran->tandabuktibayar_id = $modPembayaran->tandabuktibayar_id;
                $modAngsuran->sisaangsuran = $modPembayaran->totalsisatagihan;
                $modAngsuran->tglbayarangsuran = date('d M Y H:i:s');
                $modAngsuran->jmlbayarangsuran = 0;
                $modAngsuran->jmltelahbayar = $totalsudahabayar;
              //  var_dump($modAngsuran->tandabuktibayar_id);
                $modTandaBukti = new BKTandabuktibayarT;
                $modTandaBukti->attributes = $tandaBukti->attributes;
                $modTandaBukti->biayaadministrasi = 0;
                $modTandaBukti->biayamaterai = 0;
                $modTandaBukti->jmlpembulatan = 0;
                $modTandaBukti->carapembayaran = 'CICILAN';
                $modTandaBukti->tglbuktibayar = date('Y-m-d H:i:s');
                //$modTandaBukti->jmlpembayaran = $modPembayaran->totalsisatagihan;
                //$modTandaBukti->uangditerima = $modPembayaran->totalsisatagihan;
                $modTandaBukti->uangkembalian = '0';

                if(!empty($model))
                {
                    $modAngsuran->bayarke = $model->bayarke + 1;
                }

            }

            if(isset($_POST['BKBayarAngsuranPelayananT']))
            {

                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $tandaBukti = $this->saveTandabuktiBayarAngsuran($_POST['BKTandabuktibayarT'],$idPembayaran);
                    $modAngsuran = $this->saveBayarAngsuran($_POST['BKBayarAngsuranPelayananT'], $tandaBukti);
                    $this->updatePembayaran($idPembayaran, $_POST['BKBayarAngsuranPelayananT']['sisaangsuran'], $_POST['BKBayarAngsuranPelayananT']['jmlbayarangsuran']);

                    if (!empty($model->pembayaranpelayanan_id)) {
                        $res = Yii::app()->db
                            ->createCommand("select set_bayarangsuran_fix(".$tandaBukti->tandabuktibayar_id.") as simpan")
                            ->queryRow();

                        if (!empty($res)) {
                            $this->successSave = $this->successSave && $res['simpan'];
                        }
                    }

                    // $this->updateTindakanSudahBayar($idPembayaran, $tandaBukti);
                    // $this->updateOASudahBayar($idPembayaran, $tandaBukti);

                    // var_dump($tandaBukti->attributes, $modAngsuran->attributes, $this->successSave); die;
                    // die;
                    if($this->successSave)
                    {
                        // $modJurnalRek = $this->saveJurnalRekening($modAngsuran,$tandaBukti);

                        // if ($modJurnalRek) {
                        //     // $this->saveJurnalDetail();
                        //     if($tandaBukti->biayaadministrasi > 0){
                        //         $nourutJurnal = 3;
                        //         //Debit administrasi
                        //         $rekeningcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_TANDABUKTIKELUART, 'column_name'=>Params::REKENINGCOLUMN_COLUMN_BIAYAADMINISTRASI,'debitkredit'=>'K'));
                        //         if(isset($rekeningcolumn)){
                        //                 $this->saveJurnalDetail($modJurnalRek, $rekeningcolumn->rekening5_id, $tandaBukti->biayaadministrasi,'D',2);
                        //         }
                        //     }
                        // }
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                        $this->redirect(array(
                            'index',
                            'frame'=>$frame,
                            'idPembayaran'=>$idPembayaran,
                            'sukses'=>1,
                            'idAngsuran'=>$modAngsuran->bayarangsuranpelayanan_id,
                        ));
                    }else{
                        Yii::app()->user->setFlash('error',"Data gagal disimpan "."<pre>".print_r($modAngsuran->getErrors(),1)."</pre>");
                        $transaction->rollback();
                    }
                } catch (Exception $exc) {
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                    $transaction->rollback();
                }
            }

            $this->render('index',
                array(
                    'modAngsuran'=>$modAngsuran,
                    'modTandaBukti'=>$modTandaBukti,
                    'modPembayaran'=>$modPembayaran
                )
            );
	}


        /**
         * Simpan tanda bukti bayar untuk Bayar Angsuran
         *
         * @param type $postTandaBuktiBayar
         * @param type $idPembayaran
         * @return \TandabuktibayarT
         */
        protected function saveTandabuktiBayarAngsuran($postTandaBuktiBayar,$idPembayaran)
        {
            $modTandaBukti = new TandabuktibayarT;
            $modTandaBukti->attributes = $postTandaBuktiBayar;

            if($modTandaBukti->carapembayaran == 'HUTANG')
            {
                $modTandaBukti->uangditerima = 0;
            }

            // var_dump( $postTandaBuktiBayar['carapembayaran']);die;
            $modTandaBukti->carapembayaran  = $postTandaBuktiBayar['carapembayaran'];
            $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
            $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
            $modTandaBukti->pembayaranpelayanan_id = $idPembayaran;
            $modTandaBukti->create_time=date('Y-m-d H:i:s');
            $modTandaBukti->create_loginpemakai_id=Yii::app()->user->id;
            $modTandaBukti->create_ruangan=Yii::app()->user->getState('ruangan_id');
            $modTandaBukti->shift_id=Yii::app()->user->getState('shift_id');
            $modTandaBukti->tglbuktibayar = MyFormatter::formatDateTimeForDb($modTandaBukti->tglbuktibayar);
            $modTandaBukti->bank_nama = $modTandaBukti->bankkartu;

            if($modTandaBukti->validate())
            {
                if($modTandaBukti->save()){
                  $this->tandabuktibayar_tersimpan = true;
                    $this->simpanDetailPembayaran($modTandaBukti);
                }else{
                  echo "Pembayaran Cicilan tidak valid";
                  echo "<pre>".print_r($modTandaBukti->errors,1)."</pre>";
                  echo "<pre>".print_r($modTandaBukti->attributes,1)."</pre>";
                }
            } else {
                echo "Pembayaran Cicilan tidak valid";
                echo "<pre>".print_r($modTandaBukti->errors,1)."</pre>";
                echo "<pre>".print_r($modTandaBukti->attributes,1)."</pre>";
            }

            return $modTandaBukti;
        }

        /**
         * Simpan data bayar angsuran
         *
         * @param type $postAngsuran
         * @param type $modTandaBukti
         * @return \BKBayarAngsuranPelayananT
         */
        protected function saveBayarAngsuran($postAngsuran,$modTandaBukti)
        {
            $modAngsuran = new BKBayarAngsuranPelayananT;
            $modAngsuran->attributes = $postAngsuran;
            $modAngsuran->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;

            if($modAngsuran->validate())
            {
                if($modAngsuran->save())
                    $this->successSave = true;
            }

            return $modAngsuran;
        }



    protected function simpanDetailPembayaran($modTandaBukti, $model = null) {
        $nominal = 0;
        $bank_id ='';
        $bank_nama ='';

        // var_dump($_POST['BKTandabuktibayarT']['is_menggunakankartu']);die;
        if (isset($_POST['JenispembayaranT']['detail'])
            && count((array)$_POST['JenispembayaranT']['detail']) > 0
            && isset($_POST['BKTandabuktibayarT']['is_menggunakankartu'])
            && $_POST['BKTandabuktibayarT']['is_menggunakankartu'] == 1) {

            foreach ($_POST['JenispembayaranT']['detail'] as $item) {

                // var_dump($item);die;
                $jenis = new JenispembayaranT;
                $jenis->attributes = $item;
                $jenis->jnspembayar_id = $item['jenispembayaran'];
                $jenis->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;

                if (!empty($jenis->tgltransaksi)) {
                    $jenis->tgltransaksi = MyFormatter::formatDateTimeForDB($jenis->tgltransaksi);
                }

                if (!empty($jenis->tgljatuhtempo)) {
                    $jenis->tgljatuhtempo = MyFormatter::formatDateTimeForDB($jenis->tgljatuhtempo);
                }

                // $master_jenis = JnspembayarM::model()->findByPk($jenis->jnspembayar_id);
                // if (!empty($master_jenis)) {
                //     $jenis->jenispembayaran = $master_jenis->jnspembayar_nama;
                // }
                // var_dump($jenis->attributes); die;
//                var_dump($jenis->attributes, $item, $jenis->save()); die;
                if ($jenis->validate()) {
                    $jenis->save();
//                    if ($jenis->jenispembayaran == "OVO") {
//                        $respons = CJSON::decode($payment->requestOVO($jenis->jumlahpembayaran, 'OVOE', $modTandaBukti->sebagaipembayaran_bkm." - ".$modTandaBukti->darinama_bkm, $jenis->noovo));
//
//                        if ($respons['resultCd'] == "0000") {
//                            $jenis->referensi = $respons['tXid'];
//                            $jenis->save();
//                        } else {
//                            $jenis->addError('jenispembayaran', "API : ".$respons['resultMsg']);
//                            $this->tandabuktibayar_tersimpan = false;
//                        }
//
//
//                    }


//                    var_dump($jenis->attributes);


                } else {
                //    var_dump($jenis->getErrors(), $jenis->attributes);
                    $this->tandabuktibayar_tersimpan = false;
                }

                $nominal += (float)$jenis->jumlahpembayaran;
                // $bank_id = $jenis->jnspembayar_id;

            }

        }

        $modTandaBukti->bank_nominal = $nominal;
        // $modTandaBukti->bank_id = $bank_id;
        // $modTandaBukti->bank_nama = $nominal;
        $modTandaBukti->save();
        }

        /**
         * Update Pembayaran Pelayanan Pasien
         *
         * @param type $idPembayaran
         * @param type $sisaTagihan
         * @param type $jmlbayar
         */
        protected function updatePembayaran($idPembayaran,$sisaTagihan, $jmlbayar)
        {
            $updateTotal = PembayaranpelayananT::model()->findByPk($idPembayaran);
            $statusBayar = $this->cekStatusBayar($sisaTagihan);

            // var_dump($statusBayar); die;

            BKPembayaranpelayananT::model()->updateByPk(
                $idPembayaran,
                array(
                    'totalsisatagihan'=>$sisaTagihan,
                    'totalbayartindakan' => $jmlbayar + $updateTotal->totalbayartindakan,
                    'statusbayar'=>$statusBayar
                )
            );
        }

        /**
         * Update OA Sudah Bayar
         *
         * @param type $idPembayaran
         * @param type $modTandaBukti
         */
        protected function updateOASudahBayar($idPembayaran,$modTandaBukti)
        {
            $modOaSudahbayar = OasudahbayarT::model()->findAllByAttributes(
                array(
                    'pembayaranpelayanan_id'=>$idPembayaran
                )
            );
            foreach ($modOaSudahbayar as $i => $oaSudahbayar) {
                $biayaOa = $oaSudahbayar->jmliurbiaya;
                $jmlBayar = $oaSudahbayar->jmlbayar_oa;
                $bayarOa = $modTandaBukti->jmlpembayaran / $_POST['totTagihan'] * $biayaOa;
                $jmlBayar = $jmlBayar + $bayarOa;
                $sisaBayar = $biayaOa - $jmlBayar;
                OasudahbayarT::model()->updateByPk(
                    $oaSudahbayar->oasudahbayar_id,
                    array(
                        'jmlbayar_oa'=>$jmlBayar,
                        'jmlsisabayar_oa'=>$sisaBayar
                    )
                );
            }
        }

        /**
         * Update tindakan sudah bayar
         *
         * @param type $idPembayaran
         * @param type $modTandaBukti
         */
        protected function updateTindakanSudahBayar($idPembayaran,$modTandaBukti)
        {
            $modTindakan = TindakansudahbayarT::model()->findAllByAttributes(
                array(
                    'pembayaranpelayanan_id'=>$idPembayaran
                )
            );
            foreach ($modTindakan as $i => $tindSudahbayar) {
                $biayaTindakan = $tindSudahbayar->jmlbiaya_tindakan;
                $jmlBayar = $tindSudahbayar->jmlbayar_tindakan;
                $bayarTindakan = $modTandaBukti->jmlpembayaran / $_POST['totTagihan'] * $biayaTindakan;
                $jmlBayar = $jmlBayar + $bayarTindakan;
                $sisaBayar = $biayaTindakan - $jmlBayar;
                TindakansudahbayarT::model()->updateByPk(
                    $tindSudahbayar->tindakansudahbayar_id,
                    array(
                        'jmlbayar_tindakan'=>$jmlBayar,
                        'jmlsisabayar_tindakan'=>$sisaBayar
                    )
                );
            }
        }

        protected function cekStatusBayar($sisaTagihan)
        {
            if($sisaTagihan>0){
                return 'BELUM LUNAS';
            } else {
                return 'LUNAS';
            }
        }


    /**
     * method untuk print kwitansi
     * @param int $pembayaranpelayanan_id pembayaranpelayanan_id
     */
    public function actionPrintKuitansiAngsuran($bayarangsuranpelayanan_id)
    {
        $modAngsuran = BayarangsuranpelayananT::model()->findByPk($bayarangsuranpelayanan_id);
        $pembayaranpelayanan_id = $modAngsuran->pembayaranpelayanan_id;

        $judulKuitansi = '----- KUITANSI -----';
        $format = new MyFormatter();
        $modBayar = PembayaranpelayananT::model()->findByPk($modAngsuran->pembayaranpelayanan_id);
        $modTandaBukti = TandabuktibayarT::model()->findByPk($modAngsuran->tandabuktibayar_id);
        $criteria = new CdbCriteria();
        $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria);
        if(!empty($modBayar->pendaftaran_id)){
            $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
            $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
        }else{
            $modPendaftaran = new PendaftaranT;
        }
        $rincianpembayaran = array();
        $tindakan = array();
        $harga = 0;
		$discount = 0;
		$totalsemua = 0;
        if (count((array)$tindakanSudahBayar) > 0){
            $totalTindakan=0;
            foreach ($tindakanSudahBayar as $key => $value) {
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
                $harga += $value->jmlbiaya_tindakan;
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = $harga;
                $discount += $value->tindakanpelayanan->discount_tindakan;
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = $discount;
                $totalTindakan += ($value->jmlbiaya_tindakan - $value->tindakanpelayanan->discount_tindakan);
            }
            $rincianpembayaran['tindakan'] = $tindakan;
            $rincianpembayaran['tindakan']['totalTindakan'] = $totalTindakan;
			$totalsemua += $totalTindakan;
        }
        $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
        $oa = array();
        if (count((array)$oaSudahBayar) > 0 ){
            $totalOa=0;
            $oa[0]['harga'] = 0;
            $oa[0]['discount'] = 0;
            $oa[0]['biayaadministrasi'] = 0;
            $oa[0]['biayaservice'] = 0;
            $oa[0]['biayakonseling'] = 0;
            foreach ($oaSudahBayar as $key => $value) {
                    $oa[0]['kelompoktindakan'] = ($value->obatalkes->jenisobatalkes) ? $value->obatalkes->jenisobatalkes->jenisobatalkes_nama : "-";
                    $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                    $discount = ($value->obatalkespasien->discount > 0 ) ? $value->obatalkespasien->discount/100 : 0 ;
                    $oa[0]['discount'] += ($discount*$value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                    $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
                    $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
                    $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
                    $totalOa += (($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa) - $oa[0]['discount'] + $oa[0]['biayaadministrasi'] + $oa[0]['biayaservice'] + $oa[0]['biayakonseling']);
            }
            $rincianpembayaran['oa'] = $oa;
            $rincianpembayaran['oa']['totalOa'] = $totalOa;
			$totalsemua += $totalOa;
        }

        if($modTandaBukti->jmlpembayaran == 0 && $modBayar->carabayar_id != 2)
        { //jika jmlpembayaran nol
            $modTandaBukti->jmlpembayaran = $totalsemua;
        }

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'printKuitansi', array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint, 'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar,
                                   'modAngsuran'=>$modAngsuran
            ));
            //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'printKuitansi',array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint,'rincianpembayaran'=>$rincianpembayaran,
                                   'modTandaBukti'=>$modTandaBukti,
                                   'modBayar'=>$modBayar,
                                   'modAngsuran'=>$modAngsuran
            ));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
//                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            //$mpdf = new MyPDF60('',$ukuranKertasPDF);
            //$mpdf = new MyPDF60('','B5-L');
            $mpdf = new MyPDF60('','','15', '', 15, 15, 16, 16, 9, 9, 'B5');
            //$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);
            /*
             * cara ambil margin
             * tinggi_header * 72 / (72/25.4)
             *  tinggi_header = inchi
             */

            /*font-family: tahoma;*/
            // $header = 0.50 * 72 / (72/25.4);
            $header = 0.3 * 72 / (72/25.4);
            $mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
            $mpdf->WriteHTML(
                $this->renderPartial(
                    $this->path_view.'printKuitansiPdf',
                    array(
                        'model'=>$model,
                        'pembayarans'=>$pembayarans,
                        'modPendaftaran'=>$modPendaftaran,
                        'judulKuitansi'=>$judulKuitansi,
                        'caraPrint'=>$caraPrint,
                        'rincianpembayaran'=>$rincianpembayaran,
                               'modTandaBukti'=>$modTandaBukti,
                               'modBayar'=>$modBayar
                    ),true
                )
            );
            $mpdf->Output();
        }
    }

    public function actionRincianPembatalan($id, $idpembayaran){
        $this->layout = '//layouts/iframe';
        $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($idpembayaran);
        if (empty($modPembayaran)) {
            $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
            $modCarabayar = CarabayarM::model()->findByPk($modPendaftaran->carabayar_id);
            $modBayarangsuranpelayanan = new BayarangsuranpelayananT;
            $modSuratketjaminan = new SuratketjaminanT;
            $modTandabuktibayar = new TandabuktibayarT;
            $checkBayarAngsuranKe = new BayarangsuranpelayananT;
            $modPembayaran = new BKPembayaranpelayananT;
        } else {
            $modPenjamin = PenjaminpasienM::model()->findByAttributes(array('penjamin_id'=>$modPembayaran->penjamin_id));
            $modCarabayar = CarabayarM::model()->findByAttributes(array('carabayar_id'=>$modPembayaran->carabayar_id));
            $modBayarangsuranpelayanan = BayarangsuranpelayananT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id));
            $modSuratketjaminan = SuratketjaminanT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id));
            $modTandabuktibayar = TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id));
            $checkBayarAngsuranKe = BayarangsuranpelayananT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id),array('order'=>'bayarke DESC'));
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$id);
        $modRincian = BKRinciantagihanpasienberhutangV::model()->findAll($criteria);

        $this->render('rincianPembatalan', array(
          'modPendaftaran'=>$modPendaftaran,
           'modRincian'=>$modRincian,
             'modPembayaran'=>$modPembayaran,
             'checkBayarAngsuranKe'=>$checkBayarAngsuranKe
           ));
    }

    public function actionBatalAngsuran()
  	{
      if(Yii::app()->request->isAjaxRequest)
      {
          $transaction = Yii::app()->db->beginTransaction();
          $pesan = 'success';
          $status = 'ok';
          $keterangan = "";
          $ketPembayaran = "";

          $id = isset($_POST['id'])?$_POST['id']:null;
          $model = BayarangsuranpelayananT::model()->findByPk($id);

          try{
              if(isset($model)){
                $pembayaranpelayanan_id = $model->pembayaranpelayanan_id;

                $tandabuktikeluar_id = $model->tandabuktibayar_id;
                  $suksesBayarAngsuran = true;
                  $suksesTandabuktibayar = true;
                  $deleteOasudahbayarT = true;
                  $deleteTindakansudahbayarT = true;
                  $deleteJurnal = true;
                  $jnspembayaran = 0;
                  $checkPembayaranData = false;

                  $modPembayaran = PembayaranpelayananT::model()->findByPK($pembayaranpelayanan_id);
                  $pendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);

                  $suksesBayarAngsuran = $model->delete();

                  $findTandabuktibayar = TandabuktibayarT::model()->findByPK($tandabuktikeluar_id);
                  if(!empty($findTandabuktibayar)){
                    $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$findTandabuktibayar->tandabuktibayar_id));
                    if (isset($modJurnalBefore)){
                        foreach ($modJurnalBefore as $jurnalBef){
                            $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id'=>$jurnalBef->jurnalrekening_id));
                           if(count($jurnaldetail)>0){
                                foreach ($jurnaldetail as $jurnaldetBefor) {
                                    $jurnaldetBefor->delete();
                                }
                            }
                            $deleteJurnal = $jurnalBef->delete();
                        }
                    }

                    $findAllJnsPembayaran = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$findTandabuktibayar->tandabuktibayar_id));
                    if(count($findAllJnsPembayaran)>0){
                           foreach ($findAllJnsPembayaran as $detailjns) {
                             $jnspembayaran += $detailjns->jumlahpembayaran;
                               $detailjns->delete();
                           }
                       }

                    if(!empty($modPembayaran)){
                      if(($findTandabuktibayar->uangditerima == 0 && $jnspembayaran == 0) && $model->bayarke == 1){
                        $suksesTandabuktibayar = $findTandabuktibayar->delete();
                        $modOA = OasudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
                        if (count((array)$modOA) > 0) {
                            foreach ($modOA as $i => $modOASudahBayar) {
                                $modObatalkespasien = ObatalkespasienT::model()->findByAttributes(array('oasudahbayar_id' => $modOASudahBayar->oasudahbayar_id));
                                ObatalkespasienT::model()->updateByPk($modObatalkespasien->obatalkespasien_id, array('oasudahbayar_id' => null));
                            }
                            $deleteOasudahbayarT = OasudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
                        }

                        $modTindakanSudahBayar = TindakansudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
                        if (count((array)$modTindakanSudahBayar) > 0) {
                            foreach ($modTindakanSudahBayar as $j => $modTindakans) {
                                $modTindakanpelayanan = TindakanpelayananT::model()->findByAttributes(array('tindakansudahbayar_id' => $modTindakans->tindakansudahbayar_id));
                                $idTindakanpelayanan = (isset($modTindakanpelayanan->tindakanpelayanan_id) ? $modTindakanpelayanan->tindakanpelayanan_id : null);
                                $updateTindakanpelayananT = TindakanpelayananT::model()->updateByPk($idTindakanpelayanan, array('tindakansudahbayar_id' => null, 'subsidiasuransi_tindakan' => 0, 'subsidipemerintah_tindakan' => 0, 'subsisidirumahsakit_tindakan' => 0, 'iurbiaya_tindakan' => 0));
                            }
                        }

                        $deleteTindakansudahbayarT = TindakansudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));

                        $modPemakaianuangmukaT = PemakaianuangmukaT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
                        if (count((array)$modPemakaianuangmukaT) > 0) {
                            foreach ($modPemakaianuangmukaT as $item) {
                                $bayar_u = BayaruangmukaT::model()->findAllByAttributes(array(
                                    'pemakaianuangmuka_id'=>$item->pemakaianuangmuka_id,
                                ));
                                foreach ($bayar_u as $item_u) {
                                    BayaruangmukaT::model()->updateByPk($item_u->bayaruangmuka_id, array(
                                        "uangmukadipakai"=>0,
                                    ));
                                }
                                $deletePemakaianuangmukaT = PemakaianuangmukaT::model()->deleteByPk($item->pemakaianuangmuka_id);
                            }
                        }

                        $modPasienadmisiT = PasienadmisiT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));

                        if (!empty($modPasienadmisiT)) {
                            $updatePasienadmisiT = PasienadmisiT::model()->updateByPk($modPasienadmisiT->pasienadmisi_id, array('pembayaranpelayanan_id' => null));
                        }

                        if (!empty($pendaftaran)) {
                            if ($pendaftaran->instalasi_id == Params::INSTALASI_ID_RJ && empty($pendaftaran->pasienamdisi_id) && empty($pendaftaran->pasienpulang_id)) { //khusus untuk RJ saja Status periksa = sedang periksa
                                PendaftaranT::model()->updateByPk($pendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => null, 'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
                            } else {
                                PendaftaranT::model()->updateByPk($pendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => null));
                            }
                        }
                        $modPembayaran->delete();
                        $checkPembayaranData = true;
                      }else if(($findTandabuktibayar->uangditerima != 0 || $jnspembayaran != 0) && $model->bayarke == 1){
                          $checkPembayaranData = true;
                      }else{
                        $suksesTandabuktibayar = $findTandabuktibayar->delete();
                      }
                    }
                  }

                  if($suksesBayarAngsuran && $suksesTandabuktibayar && $deleteJurnal){
                      $checkBayarAngsuran = BayarangsuranpelayananT::model()->findByAttributes(array('pembayaranpelayanan_id'=>$pembayaranpelayanan_id),array('order'=>'bayarke DESC'));

                      if(!empty($checkBayarAngsuran)){
                        $this->updatePembayaran($pembayaranpelayanan_id, $checkBayarAngsuran->sisaangsuran, 0);
                      }
                        $keterangan = "Data Berhasil Dibatalkan! ";
                        $status = 'ok';
                        if($checkPembayaranData == true){
                            $ketPembayaran = "ok";
                        }
                        $transaction->commit();
                  }else{
                    $keterangan = "Data Gagal Dibatalkan! ";
                    $status = 'not';
                    $transaction->rollback();
                  }
              }
          } catch (Exception $ex) {
              $keterangan = "Data Gagal Dibatalkan! ".print_r($ex);
              $status = 'not';
              $transaction->rollback();
          }

          $data['pesan'] = $pesan;
          $data['status'] = $status;
          $data['keterangan'] = $keterangan;
          $data['ketPembayaran'] = $ketPembayaran;

          echo json_encode($data);
          Yii::app()->end();
      }
  	}

    public function actionListBayarBank() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $bank = JnspembayarbankM::model()->findAllByAttributes(array(
            'jnspembayar_id' => $_POST['id'],
        ));

        $bank_list = '<option value="">-- Pilih --</option>';

        foreach ($bank as $item) {
            $data_bank = BankM::model()->findByPk($item->bank_id);
            $rek = JnspembrekM::model()->findByAttributes(array(
                'jnspembayar_id'=>$_POST['id'],
                'bank_id'=>$item->bank_id,
                'debitkredit'=>'D',
            ), array(
                'order'=>'jnspembrek_id asc'
            ));

            $rek5 = new Rekening5M;
            if (!empty($rek)) {
                $rek5 = Rekening5M::model()->findByPk($rek->rekening5_id);

                if (empty($rek5)) {
                    $rek5 = new Rekening5M;
                }
            }

            if (empty($data_bank)) {
                $data_bank = new BankM;
            }

            $bank_list .= '<option value="'.$item->bank_id.'" data-rekening="'.$rek5->kdrekening5.' - '.$rek5->nmrekening5.'">'.$data_bank->bankNoRekening.'</option>';
        }

        echo CJSON::encode(array(
            'list'=>$bank_list,
        ));

    }
}
