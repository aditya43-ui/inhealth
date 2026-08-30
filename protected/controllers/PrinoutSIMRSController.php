<?php
Yii::import('rekamMedis.models.*');
Yii::import('billingKasir.models.*');
class PrinoutSIMRSController extends Controller {

    public $layout = '//layouts/iframe';

    /**
     * 
     * @param type $sep_id
     */
    public function actionSep($sep_id){
        $format = new MyFormatter;
        $modRujukanBpjs = new RujukanT;
        $modSep = SepT::model()->findByPk($sep_id);
        $modPendaftaran = PendaftaranT::model()->findByAttributes(['sep_id'=>$sep_id]);
       
        $modAsuransiPasienBpjs = AsuransipasienM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
        $modJenisPeserta = JenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (isset($modSep->norujukan)) {
            $modRujukanBpjs = RujukanT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
        }
        $modPendaftaran = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);

        $path = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";

        $judul_print = 'SURAT ELIGIBILITAS PESERTA';
        $render =  $this->renderPartial($path . 'printSep_baru', array(
                'format' => $format,
                'modSep' => $modSep,
                'judul_print' => $judul_print,
                'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
                'modRujukanBpjs' => $modRujukanBpjs,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'modJenisPeserta' => $modJenisPeserta,
                'modRujukan' => $modRujukan,
        ), true);
        
        if (isset($_GET['return'])){
            $this->_sendResponse(200,CJSON::encode(['print'=>$render]),'application/json','');
        }else{
            echo $render;
        }
    }
    
    public function actionResumeMedis($pendaftaran_id){
        $format = new MyFormatter;
        $modResume = ResumemedisR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'resumemedis_id DESC'));
        if (empty($modResume)){
            $modResume = new ResumemedisR;
        }
        $modKunjungan = InfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'anamesa_id DESC'));
        $modPeriksaFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'pemeriksaanfisik_id DESC'));
        $modKosul = KonsulpoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'konsulpoli_id DESC'));
        $modReseptur = ResepturT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPenunjangLab = PasienmasukpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_LAB));
        $modPenunjangRad = PasienmasukpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_RAD));
        $arrayLab = array();
        $arrayRad = array();
        if (count((array) $modPenunjangLab) > 0) {
            foreach ($modPenunjangLab as $value) {
                $arrayLab[] = $value->pasienmasukpenunjang_id;
            }
        }
        if (count((array) $modPenunjangRad) > 0) {
            foreach ($modPenunjangRad as $value) {
                $arrayRad[] = $value->pasienmasukpenunjang_id;
            }
        }
        $criteriaLab = new CDbCriteria;
        $criteriaLab->addInCondition('pasienmasukpenunjang_id', $arrayLab);
        $modTindakanLab = TindakanpelayananT::model()->findAll($criteriaLab);
        $criteriaRad = new CDbCriteria;
        $criteriaRad->addInCondition('pasienmasukpenunjang_id', $arrayRad);
        $modTindakanRad = TindakanpelayananT::model()->findAll($criteriaRad);
        $modDiadnosaUtama = PasienmorbiditasT::model()->findByAttributes(array('diagnosaicdix_id' => null, 'pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id DESC'));
        $modDiadnosaTambahan = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_TAMBAH), array('order' => 'pasienmorbiditas_id DESC'));
        $pasienmorbiditas_id = isset($modDiadnosaUtama->pasienmorbiditas_id) ? $modDiadnosaUtama->pasienmorbiditas_id : null;
        $modDiadnosaTindakan = Pasienicd9cmT::model()->findAllByAttributes(array('pasienmorbiditas_id' => $pasienmorbiditas_id), array('order' => 'pasienmorbiditas_id DESC'));

        $judul_print = 'RESUME MEDIS';

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $render =  $this->renderPartial('rekamMedis.views.resumeMedis.printResumeMedis', array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modKunjungan' => $modKunjungan,
            'modAnamnesa' => $modAnamnesa,
            'modPeriksaFisik' => $modPeriksaFisik,
            'modKosul' => $modKosul,
            'modTindakanLab' => $modTindakanLab,
            'modTindakanRad' => $modTindakanRad,
            'modDiadnosaUtama' => $modDiadnosaUtama,
            'modDiadnosaTambahan' => $modDiadnosaTambahan,
            'modDiadnosaTindakan' => $modDiadnosaTindakan,
            'modResume' => $modResume,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,     
            'caraPrint' => 'resumemedis-only',
            'akses' => 'api'
        ), true);                    
        
        if (isset($_GET['return'])){
            $this->_sendResponse(200,CJSON::encode(['print'=>$render]),'application/json','');
        }else{            
            echo $render;
        }
    }
    public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';
    public $path_view_apotek = 'billingKasir.views.informasipenjualanresep.';

    public function actionCetakGabung($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $format = new MyFormatter();
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        $rincianpembayaran = array();
        $tindakan = array();
        $harga = 0;
        $discount = 0;
        $totalsemua = 0;
        $modRincians = null;
        $cetak = ['Rincian', 'Kuitansi'];

        $judulKuitansi = '----- KUITANSI -----';
        $modPembayaran = $modBayar = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);

        $namaFile = $modPendaftaran->pasien->no_rekam_medik . " K " . date("dmY", strtotime($modPendaftaran->tgl_pendaftaran));
        // simpan printed_by 
        $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
            'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id,
        ));
        $tandabukti->printed_by = $tandabukti->printed_by + 1;
        $tandabukti->update();

        if ($tandabukti->jmlpembayaran == 0 && $modBayar->carabayar_id != 2) {
            $tandabukti->jmlpembayaran = $totalsemua;
        }

        $cr = new CdbCriteria();
        $cr->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($cr);
        if (!empty($modBayar->pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
            $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
        } else {
            $modPendaftaran = new PendaftaranT;
        }

        if (count((array) $tindakanSudahBayar) > 0) {
            $totalTindakan = 0;
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
        $oaSudahBayar = OasudahbayarT::model()->findAll($cr);
        $oa = array();
        if (count((array) $oaSudahBayar) > 0) {
            $totalOa = 0;
            $oa[0]['harga'] = 0;
            $oa[0]['discount'] = 0;
            $oa[0]['biayaadministrasi'] = 0;
            $oa[0]['biayaservice'] = 0;
            $oa[0]['biayakonseling'] = 0;
            foreach ($oaSudahBayar as $key => $value) {
                $oa[0]['kelompoktindakan'] = ($value->obatalkes->jenisobatalkes) ? $value->obatalkes->jenisobatalkes->jenisobatalkes_nama : "-";
                $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                $discount = ($value->obatalkespasien->discount > 0) ? $value->obatalkespasien->discount / 100 : 0;
                $oa[0]['discount'] += ($discount * $value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
                $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
                $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
                $totalOa += (($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa) - $oa[0]['discount'] + $oa[0]['biayaadministrasi'] + $oa[0]['biayaservice'] + $oa[0]['biayakonseling']);
            }
            $rincianpembayaran['oa'] = $oa;
            $rincianpembayaran['oa']['totalOa'] = $totalOa;
            $totalsemua += $totalOa;
        }

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $ukuranKertas = Params::getUkuranKertas();
        $mpdf = new MyPDF60('', $ukuranKertas['F4']);
        foreach ($cetak as $key => $value) {
            if ($value == 'Rincian') {
                $is_kronis = 0;
                $modOa = OasudahbayarT::model()->findAllByAttributes(['pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id]);
                $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
                $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

                $instalasi_id = !empty($admisi) ? $admisi->ruangan->instalasi_id : $modPendaftaran->ruangan->instalasi_id;


                if ($modPembayaran->carabayar_id == Params::CARABAYAR_ID_BPJS && in_array($instalasi_id, array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_HD))) {

                    if (!empty($modOa)) {
                        foreach ($modOa as $key => $det) {
                            if ($det->obatalkespasien->is_obatkronis == true) {
                                $is_kronis++;
                            }
                        }
                    }
                }

                if ($is_kronis >= 1) {
                    $posisi = Params::DEFAULT_KERTAS_POSISI_PORTRAIT;
                    $mpdf->WriteHTML($stylesheet, 1);
                    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
                    $mpdf->SetHTMLFooter('<span></span>');
                    $mpdf->WriteHTML(
                        $this->renderPartial(
                            $this->path_view . 'print/printKronisMin',
                            array(
                                'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran
                            ),
                            true
                        )
                    );
                } else {
                    if ($modPembayaran->ruanganpelakhir_id == Params::RUANGAN_ID_APOTEK_1) {
                        $caraPrint = 'PDF';
                        $judulLaporan = 'Rincian Casemix';
                        $modPenjualan = PenjualanresepT::model()->findByAttributes(['noresep' => $modPembayaran->noresep, 'pendaftaran_id' => $modPembayaran->pendaftaran_id]);
                        $daftar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modPenjualan->pendaftaran_id));
                        $obatAlkes = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
                        $pasien = PasienM::model()->findByPk($modPenjualan->pasien_id);
                        $modPegawaiDokter = new PegawaikaryawanV();
                        $modInstalasi = new InstalasiM();
                        if (!empty($modPenjualan->pasienpegawai_id))
                            $modPegawaiDokter = PegawaikaryawanV::model()->findByAttributes(array('pegawai_id' => $modPenjualan->pasienpegawai_id));
                        if (!empty($modPenjualan->pasieninstalasiunit_id))
                            $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id' => $modPenjualan->pasieninstalasiunit_id));

                        $loadData = array();
                        if (!empty($obatAlkes)) {
                            $total = 0;
                            $id_pen = $modPenjualan->penjualanresep_id;
                            $loadData[$id_pen]['ruangan_nama'] = 'APOTEK';
                            $loadData[$id_pen]['total'] = 0;
                            foreach ($obatAlkes as $key => $val) {
                                $id_obat = $val['obatalkespasien_id'];

                                $jmlHargaQty = ($val->hargasatuan_oa * $val->qty_oa);
                                $jmliuran = $jmlHargaQty - $val->discount + $val->jumlahppn - $val->subsidiasuransi - $val->subsidirs - $val->subsidipemerintah;
                                $jmlSubtotal = ($jmlHargaQty - $val->discount + $val->jumlahppn);

                                $loadData[$id_pen]['det'][$id_obat]['obatalkes_kode'] = $val->obatalkes->obatalkes_kode;
                                $loadData[$id_pen]['det'][$id_obat]['obatalkes_nama'] = $val->obatalkes->obatalkes_nama;
                                $loadData[$id_pen]['det'][$id_obat]['obatalkes_nama'] = $val->obatalkes->obatalkes_nama;
                                $loadData[$id_pen]['det'][$id_obat]['qty'] = $val->qty_oa;
                                $loadData[$id_pen]['det'][$id_obat]['hargasatuan_oa'] = $val->hargasatuan_oa;
                                $loadData[$id_pen]['det'][$id_obat]['iuran'] = $jmliuran;
                                $loadData[$id_pen]['det'][$id_obat]['subsidiasuransi'] = $val->subsidiasuransi;
                                $loadData[$id_pen]['det'][$id_obat]['subtotal'] = $jmlSubtotal;
                                $total += $jmlSubtotal;
                            }
                            $loadData[$id_pen]['total'] = $total;
                        }

                        $posisi = Params::DEFAULT_KERTAS_POSISI_PORTRAIT;
                        $mpdf->WriteHTML($stylesheet, 1);
                        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
                        $mpdf->SetHTMLFooter('<span></span>');
                        $mpdf->WriteHTML(
                            $this->renderPartial(
                                $this->path_view_apotek . 'fakturPembayaranApotek',
                                array(
                                    'modPenjualan' => $modPenjualan, 'daftar' => $daftar, 'pasien' => $pasien, 'modPegawaiDokter' => $modPegawaiDokter, 'modInstalasi' => $modInstalasi, 'obatAlkes' => $obatAlkes, 'tandabukti' => $tandabukti, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'loadData' => $loadData
                                ),
                                true
                            )
                        );
                    } else {
                        $posisi = Params::DEFAULT_KERTAS_POSISI_PORTRAIT;
                        $mpdf->WriteHTML($stylesheet, 1);
                        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
                        $mpdf->SetHTMLFooter('<span></span>');
                        $mpdf->WriteHTML(
                            $this->renderPartial(
                                $this->path_view . 'printRincianSudahBayarGrupBPJS',
                                array(
                                    'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran
                                ),
                                true
                            )
                        );
                    }
                }
            } else if ($value == 'Kuitansi') {
                // $mpdf = new MyPDF60('', array(135, 210));
                if ($modPembayaran->ruanganpelakhir->instalasi_id == Params::INSTALASI_ID_RI) {
                    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                    $modUangMuka = new BKPemakaianuangmukaT();
                    $uangMuka = BKPemakaianuangmukaT::model()->findByAttributes(['pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id]);
                    if (!empty($uangMuka)) {
                        $modUangMuka = $uangMuka;
                    }

                    $posisi = Params::DEFAULT_KERTAS_POSISI_PORTRAIT;                           //Posisi L->Landscape,P->Portait
                    $mpdf->WriteHTML($stylesheet, 1);
                    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
                    $mpdf->SetHTMLFooter('<span> </span>');
                    $mpdf->WriteHTML(
                        $this->renderPartial(
                            $this->path_view . 'print/printBuktiPembayaranRI',
                            array(
                                'modPendaftaran' => $modPendaftaran,
                                'modPembayaran' => $modPembayaran,
                                'modPasien' => $modPasien,
                                'modTandaBukti' => $tandabukti,
                                'modUangMuka' => $modUangMuka,
                            ),
                            true
                        )
                    );
                } else {
                    $posisi = Params::DEFAULT_KERTAS_POSISI_LANDSCAPE;
                    $header = 0.3 * 72 / (72 / 25.4);
                    $mpdf->mirrorMargins = 0;
                    $mpdf->WriteHTML($stylesheet, 1);
                    $mpdf->AddPage('P', '', '', '', '', 3, 8, $header, 5, 0, 0);
                    $mpdf->SetHTMLFooter('<span></span>');
                    $mpdf->WriteHTML(
                        $this->renderPartial(
                            $this->path_view . 'printKuitansiPdfNew',
                            array(
                                'modPendaftaran' => $modPendaftaran,
                                'judulKuitansi' => $judulKuitansi,
                                'caraPrint' => 'PDF',
                                'rincianpembayaran' => $rincianpembayaran,
                                'modTandaBukti' => $tandabukti,
                                'modBayar' => $modBayar
                            ),
                            true
                        )
                    );
                }
            }
        }

        $mpdf->Output($namaFile . '.pdf', 'I');
    }

    public function actionBillingKasir($pendaftaran_id, $peglogin = ''){
      
        $modRincians = null;
        $modPembayaran = new PembayaranpelayananT;        
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);      
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = RinciantagihanpasienV::model()->findAll($criteria);

        
        
//        var_dump($modRincians);die;
        
        if(empty($modPendaftaran->pembayaranpelayanan_id)){
            $render = $this->renderPartial('billingKasir.views.pembayaranTagihanPasien.printRincianBelumBayar2', array('peglogin'=>$peglogin,'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'dari'=>'resumemedis','akses'=>'api'), true);
        } else {
            $modPembayaran = PembayaranpelayananT::model()->findByPk($modPendaftaran->pembayaranpelayanan_id);
            $render = $this->renderPartial('billingKasir.views.pembayaranTagihanPasien.printRincianSudahBayar_new', array('peglogin'=>$peglogin,'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran, 'dari'=>'resumemedis','akses'=>'api'), true);
        }                                          
        
        if (isset($_GET['return'])){            
            $this->_sendResponse(200,CJSON::encode(['print'=>$render]),'application/json','');
        }else{
            echo $render;
        }
    }

    
    
    public function actionSRK($pendaftaran_id){
      
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $model->tglrenkontrol = !empty($model->tglrenkontrol)?date('Y-m-d', strtotime($model->tglrenkontrol)):null;
        $model->ruangankontrol_nama = !empty($model->ruangankontrol->ruangan_nama)?$model->ruangankontrol->ruangan_nama:null;                
        $model->diagnosautama = $model->loadDiagnosaUtama();
        $modSurat = SuratketeranganR::model()->find(" pendaftaran_id = ".$model->pendaftaran_id." AND judulsurat = 'Surat Rencana Kontrol Pasien' AND suratketerangan_sebelumnya_id IS NOT NULL  ORDER BY suratketerangan_id DESC ");

        if (!empty($modSurat->suratketerangan_sebelumnya_id)){

            $modSurat = SuratketeranganR::model()->findByPk($modSurat->suratketerangan_sebelumnya_id);

            $model = PendaftaranT::model()->findByPk($modSurat->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($model->pasien_id);

            $render =  $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printSKDP',array(
                'model'=>$model,                
                'modPasien'=>$modPasien,                
                'modSurat'=>$modSurat,                
            ),true);                           
            
            if (isset($_GET['return'])){
                $this->_sendResponse(200,CJSON::encode(['print'=>$render]),'application/json','');
            }else{
                echo $render;
            }
        }
    }
    
    public function actionLaboratorium($id){   
                
        $idPenunjang = explode(',',$id);        
        
        $format = new MyFormatter();
        $judulLaporan = "Hasil Pemeriksaan Laboratorium";
        
        $cri = new CDbCriteria;
        $cri->addInCondition('pasienmasukpenunjang_id',$idPenunjang);
        $modKunjungan = PasienmasukpenunjangV::model()->findAll($cri);
        
        $render = '';                
        foreach($modKunjungan as $key => $val){
            $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $val->pasienmasukpenunjang_id));
            $modDetailHasilPemeriksaans = $this->loadHasilPemeriksaans($modHasilPemeriksaan);
            $data = array();

            foreach ($modDetailHasilPemeriksaans as $dt) {
              $jenispemeriksaanlab_id = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
              $kelompokdet = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
              $nilairujukan_id = $dt->pemeriksaandetail->nilairujukan_id;
              $dtperiksa = $dt->pemeriksaanlab_id . $dt->tindakanpelayanan_id;
              //	if (isset($data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"])){
              //	$total = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] = $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dt->pemeriksaanlab_id"]["kelompokdet"]["$kelompokdet"] + 1;
              //	}else{
              //	$total = 1;
              //	}

              $kirimsample_id = null;

              // $kirimsample = KirimsamplelabT::model()->find("tindakanpelayanan_id = $dt->tindakanpelayanan_id");

              if(!empty($kirimsample)) {
                $kirimsample_id = $kirimsample->kirimsamplelab_id;
              }


              $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_nama"] = $dt->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
              $data["$jenispemeriksaanlab_id"]["jenispemeriksaanlab_id"] = $dt->pemeriksaanlab->jenispemeriksaanlab_id;
              $data["$jenispemeriksaanlab_id"]["tindakanpelayanan_id"] = $dt->tindakanpelayanan_id;
              $data["$jenispemeriksaanlab_id"]["kirimsamplelab_id"] = $kirimsample_id;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_nama"] = $dt->pemeriksaanlab->pemeriksaanlab_nama;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["pemeriksaanlab_id"] = $dt->pemeriksaanlab_id;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["detailhasilpemeriksaanlab_id"] = $dt->detailhasilpemeriksaanlab_id;

              //change
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['kelompokdet'] = $kelompokdet;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['pemeriksaanlabdet_id'] = $dt->pemeriksaanlabdet_id;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan_id'] = $dt->pemeriksaandetail->nilairujukan_id;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['kelompokdet'] = $dt->pemeriksaandetail->nilairujukan->kelompokdet;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['namapemeriksaandet'] = $dt->pemeriksaandetail->nilairujukan->namapemeriksaandet;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['hasilpemeriksaan'] = $dt->hasilpemeriksaan;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimin'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_min;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilaimax'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_max;
              $data["$jenispemeriksaanlab_id"]["pemeriksaanlab"]["$dtperiksa"]["kelompokdet"]["$kelompokdet"]['nilairujukan']["$nilairujukan_id"]['nilairujukan'] = $dt->pemeriksaandetail->nilairujukan->nilairujukan_nama . ' ' . (($dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan != '-') ? $dt->pemeriksaandetail->nilairujukan->nilairujukan_satuan : '');
            }


            $render .= $this->renderPartial('laboratorium.views.pencatatanHasilPemeriksaan.printHasilPemeriksaan', array(
                'format' => $format,
                'modKunjungan' => $val,
                'modHasilPemeriksaan' => $modHasilPemeriksaan,
                'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
                'judulLaporan' => $judulLaporan,
                'caraPrint' => 'PRINT',
                'data' => $data,
                'popup' => '',
                'footer' => 'tidak'
            ), true);
            
            
            if (count($modKunjungan) > 1 && $key != count($modKunjungan)){
                $render .= "<div class='page-break-after: always;'></div>";
            }
        }       
                
        if (isset($_GET['return'])){
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $stylesheet .= file_get_contents(Yii::getPathOfAlias('webroot.css') . '/print-layout.css');
            $stylesheet .= 'table td,div,h6,table th{font-size:11px;} .paddingtext2{line-height:1px;}';
            $this->_sendResponse(200,CJSON::encode(['print'=>$render, 'css'=>$stylesheet]),'application/json','');
        }else{     
            echo '<link rel="stylesheet" type="text/css" href="'.Yii::app()->baseUrl .'/css/prinout.css" />';
            echo $render;
        }
    }
    
    /**
    * load LBDetailHasilPemeriksaanLabT
    * @param type $modHasilPemeriksaan
    */
    public function loadHasilPemeriksaans($modHasilPemeriksaan)
    {
        $criteria = new CDbCriteria();
        $criteria->join = "
            JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
            JOIN jenispemeriksaanlab_m ON pemeriksaanlab_m.jenispemeriksaanlab_id = jenispemeriksaanlab_m.jenispemeriksaanlab_id  
            JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
            JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
        $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id . ' AND hasilpemeriksaan IS NOT NULL ');
        $criteria->order = "jenispemeriksaanlab_m.jenispemeriksaanlab_urutan ASC, pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
        $modDetailHasilPemeriksaans = DetailhasilpemeriksaanlabT::model()->findAll($criteria);
        return $modDetailHasilPemeriksaans;
    }
    
    public function actionRadiologi($id){        
        $hasilradId = explode(',',$id);      
        $judulLaporan = '';
  

        $render = '';
        $cri = new CDbCriteria;
        $cri->addInCondition("hasilpemeriksaanrad_id", $hasilradId);
        $model = HasilpemeriksaanradT::model()->findAll($cri);

        if (!empty($model)) {                
            foreach($model as $key => $val){
                $cri = new CDbCriteria();
                $cri->select = "t.*, rhd.refhasildet_nama";
                $cri->join = " JOIN referensihasildet_m rhd ON rhd.refhasildet_id = t.refhasildet_id  "
                        . " JOIN referensihasilrad_m rhr ON rhd.refhasilrad_id = rhr.refhasilrad_id ";
                $cri->addCondition(" rhr.refhasilrad_banyak = TRUE ");
                $cri->addCondition(" t.hasilpemeriksaanrad_id = " . $val->hasilpemeriksaanrad_id . " ");
                $cri->order = " rhd.refhasildet_urut ";
                $hasDet = HasilperiksaraddetT::model()->findAll($cri);

                if (count((array) $hasDet) > 0) {
                    $render .= $this->renderPartial('radiologi.views.daftarPasien.printTemplate.printHasilDet', array('hasDet' => $hasDet, 'model' => $val, 'judulLaporan' => $judulLaporan), true);
                } else {                  
                    $render .= $this->renderPartial('radiologi.views.daftarPasien.printTemplate.print', array('model' => $val, 'judulLaporan' => $judulLaporan, 'pendaftaran_id' => $val->pendaftaran_id), true);
                }
                
                if (count($model) > 1 && $key != count($model)){
                    $render .= "<div class='page-break-after: always;'></div>";
                }
            }
        }      
        
        if (isset($_GET['return'])){
            $this->_sendResponse(200,CJSON::encode(['print'=>$render]),'application/json','');
        }else{            
            echo $render;
        }
    }
    
    /**
     * Kirim response dari rest API
     * 
     * @param type $status
     * @param type $body
     * @param type $content_type
     * @param type $message
     */
	protected function _sendResponse($status = 200, $body = '', $content_type = 'text/html', $message = '')
	{
		// set the status
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);
		// and the content type
		header('Content-type: ' . $content_type);

		// pages with body are easy
		if($body != '')
		{
			// send the body
			echo $body;
		}
		// we need to create the body if none is passed
		else
		{
			// this is purely optional, but makes the pages a little nicer to read
			// for your users.  Since you won't likely send a lot of different status codes,
			// this also shouldn't be too ponderous to maintain
            
            if (empty($message)) {
                switch($status)
                {
                    case 401:
                        $message = 'Anda harus memiliki hak akses untuk mengakses halaman ini.';
                        break;
                    case 404:
                        $message = 'URL ' . $_SERVER['REQUEST_URI'] . ' tidak ditemukan.';
                        break;
                    case 500:
                        $message = 'Terjadi error pada server ketika memproses request.';
                        break;
                    case 501:
                        $message = 'Method yang diminta belum diimplementasikan.';
                        break;
                }
            }

			// servers don't always have a signature turned on 
			// (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

			
			// this should be templated in a real-world solution
			
			if ($content_type == 'application/json') {
				$body = CJSON::encode(array(
					'response_code'=>$status,
					'message'=>$message,
				));
			} else {
			
			
			$body = '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
	</head>
	<body>
		<h1>' . $this->_getStatusCodeMessage($status) . '</h1>
		<p>' . $message . '</p>
		<hr />
		<address>' . $signature . '</address>
	</body>
	</html>';
			}

        echo $body;
		
		}
		Yii::app()->end();
    }
    
    /**
     * Menampilkan Pesan berdasarkan Kode Status.
     * 
     * @param integegr $status
     * @return string
     */
    protected function _getStatusCodeMessage($status)
    {
            // these could be stored in a .ini file and loaded
            // via parse_ini_file()... however, this will suffice
            // for an example
            $codes = Array(
                    200 => 'OK',
                    400 => 'Bad Request',
                    401 => 'Unauthorized',
                    402 => 'Payment Required',
                    403 => 'Forbidden',
                    404 => 'Not Found',
                    500 => 'Internal Server Error',
                    501 => 'Not Implemented',
            );
            return (isset($codes[$status])) ? $codes[$status] : '';
    }
}

?>