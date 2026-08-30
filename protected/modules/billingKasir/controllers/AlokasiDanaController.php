<?php

/**
 * action ini digunakan untuk mengelola transaksi penunjang, dimana beberapa fungsinya diambil dari controller lain
 *
 * @package application.modules.billingKasir
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class AlokasiDanaController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';
    public $path_view_apotek = 'billingKasir.views.informasipenjualanresep.';

    public $pembayaranpelayanan_tersimpan = false;
    public $tandabuktibayar_tersimpan = false;
    public $tindakansudahbayar_tersimpan = false;
    public $oasudahbayar_tersimpan = false;
    public $pemakaianuangmuka_tersimpan = false;
    public $bayarangsuran_tersimpan = false;
    public $bayarsemuatindakanoa = false;

    public $isbayarkarcis = false;
    protected $ok = true;

    /**
     * Membuat dan menyimpan data baru.
     * jika dari informasi menggunakan
     * @params type $id
     * - $_GET['instalasi_id']
     * - $_GET['pendaftaran_id']
     * - $_GET['pasienadmisi_id'] (untuk RI saja)
     * layout frame=1 -> frameDialog
     */
    public function actionIndex($id = null)
    {
        $format = new MyFormatter();
        $modKunjungan = new BKInformasikasirinappulangV;
        $modKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
        $model = new BKPembayaranpelayananT;
        $modTandabukti = new BKTandabuktibayarT;
        $modTandabukti->is_menggunakankartu = 0;
        $modTindakansudahbayar = new BKTindakansudahbayarT;
        $modOasudahbayar = new BKOasudahbayarT;
        $modBayaruangmuka = new BKBayaruangmukaT;
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
        $modBayarangsuran = new BKBayarangsuranpelayananT;
        $modAntrian = new BKAntrianT;
        $dataTindakans = array();
        $dataOas = array();

        $modPiutangAsuransi = new BKPiutangasuransiT();

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);

        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        $modTanggungan = new TanggunganpenjaminM();
        $penjamin_id = null;


        // Uncomment the following line if AJAX validation is needed

        if (isset($_GET['instalasi_id'])) {
            if ($_GET['instalasi_id'] == Params::INSTALASI_ID_RJ) {
                $loadKunjungan = BKInformasikasirrawatjalanV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_RD) {
                $loadKunjungan = BKInformasikasirrdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));;
            } else if (in_array($_GET['instalasi_id'], Params::grupInstalasiRIID())) {
                $pulang = PasienpulangT::model()->findByAttributes(array(
                    'pasienadmisi_id' => isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : $model->pasienadmisi_id,
                ));

                if (!empty($pulang) && $pulang->carakeluar_id == Params::CARAKELUAR_ID_MELARIKANDIRI) {
                    $loadKunjungan = BKInfokunjunganRIV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
                } else {
                    $loadKunjungan = BKInformasikasirinappulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'pasienadmisi_id' => isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : $model->pasienadmisi_id));
                }
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_MCU2) {
                $loadKunjungan = BKInformasikasirmcuV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_HD) {
                $loadKunjungan = BKInformasikasirhdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_PERSALINAN) {
                $loadKunjungan = BKInformasikasirrdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_REHAB) {
                $loadKunjungan = BKInformasikasirfisioterapiV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
            }
            if (isset($loadKunjungan)) {
                $modKunjungan = $loadKunjungan;
            }
        }


        if (!empty($_GET['pembayaranpelayanan_id'])) {
            $model = BKPembayaranpelayananT::model()->findByPk($_GET['pembayaranpelayanan_id']);

            if (empty($model)) {
                $model = new BKPembayaranpelayananT;
            }
        }

        if (!empty($_GET['tandabuktibayar_id'])) {
            $modTandabukti = BKTandabuktibayarT::model()->findByPk($_GET['tandabuktibayar_id']);
            // echo "<pre>";
            // var_dump($modTandabukti);die; 

            if (empty($modTandabukti)) {
                $modTandabukti = new BKTandabuktibayarT;
            }
        }

        if (isset($_GET['frame'])) {
            $this->layout = "//layouts/iframe";
        }

        if (isset($_POST['pendaftaran_id']) && isset($_POST['BKPembayaranpelayananT']) && (isset($_POST['BKTindakanPelayananT']) || isset($_POST['BKObatalkesPasienT']))) {


            // var_dump($_POST); die;

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $tglpembayaran = date('Y-m-d H:i:s');
                $pendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
                $ok = true;

                $carabayar_map = CHtml::listData(PenjaminpasienM::model()->findAll(
                    'penjamin_aktif = true'
                ), 'penjamin_id', 'carabayar_id');

                // var_dump($_POST['BKPiutangasuransiT']);

                foreach ($_POST['BKPiutangasuransiT'] as $idx => $multi) {
                    $alokasidana = new AlokasidanaT;

                    $post_tindakan = $_POST['BKTindakanPelayananT'] ?? array();
                    $post_oa = $_POST['BKObatalkesPasienT'] ?? array();

                    $arr_tindakan = array();
                    $arr_oa = array();

                    foreach ($post_tindakan as $item) {
                        // if ($item['subsidiasuransi_tindakan'][$idx] == 0) {
                        //     continue;
                        // }
                        $sub = $item;
                        $sub['subsidiasuransi_tindakan'] = $item['subsidiasuransi_tindakan'][$idx];

                        $arr_tindakan[] = $sub;
                    }

                    foreach ($post_oa as $item) {
                        // if($item['subsidiasuransi_tindakan'][$idx] == 0) {
                        //     continue;
                        // }

                        $sub = $item;
                        $sub['subsidiasuransi'] = $item['subsidiasuransi'][$idx];

                        $arr_oa[] = $sub;
                    }
                    $inacbgs_kelas_perawatan = 0;
                    $inacbgs_kelas_tanggungan = 0;
                    if(isset($_POST['Alokasi']['totalinacbg_naikkelasperawatan'])) {
                        $inacbgs_kelas_perawatan = $_POST['Alokasi']['totalinacbg_naikkelasperawatan'];
                        $inacbgs_kelas_tanggungan = $_POST['Alokasi']['total_inacbgs'];
                    }
                    $alokasidana = new AlokasidanaT;
                    $alokasidana->attributes = $pendaftaran->attributes;
                    $alokasidana->penjamin_id = $multi['penjamin_id'];
                    $alokasidana->carabayar_id = $carabayar_map[$alokasidana->penjamin_id];
                    $alokasidana->tglpembayaran = $tglpembayaran;
                    $alokasidana->totalbiayatindakan = 0; //$_POST['tot_tarif_tindakan'];
                    $alokasidana->totalbiayapelayanan = 0; //$_POST['BKPembayaranpelayananT']['totalbiayapelayanan'];
                    $alokasidana->totalbiayaoa = 0; //$_POST['total_oa'];
                    $alokasidana->total_inacbg = 0; // MyFormatter::formatNumberForDb($inacbgs_kelas_tanggungan); //$_POST['tot_inacbg'];
                    $alokasidana->totalsubsidiasuransi = 0; //$_POST['tot_subsidiasuransi_semua'];
                    $alokasidana->totalsubsidirs = 0;
                    $alokasidana->totaliurbiaya = 0; //$_POST['tot_iurbiaya_semua'];
                    $alokasidana->totalbayartindakan = 0; //$_POST['total_tindakan'];
                    $alokasidana->totalinacbg_naikkelasperawatan = 0; //MyFormatter::formatNumberForDb($inacbgs_kelas_perawatan);


                    $alokasidana->totalbiayatindakan = $multi['jmltindakanasuransi'];
                    $alokasidana->totalbiayaoa = $multi['jmloaasuransi'];
                    $alokasidana->totalbiayapelayanan = $multi['jmlpiutangasuransi'];

                    if (isset($_POST['instalasi_id']) && $_POST['instalasi_id'] != 4) {
                        $alokasidana->pasienadmisi_id = null;
                    }

                    // var_dump($alokasidana->attributes, $_POST); die;
                    // var_dump($arr_tindakan, $arr_oa); die;
                    // /*
                    foreach ($arr_tindakan as $item) {

                        if (!isset($item['is_pilihtindakan']) || $item['is_pilihtindakan'] != 1) {
                            continue;
                        }

                        if ($multi['carabayar_id'] != Params::CARABAYAR_ID_MEMBAYAR) {
                            $alokasidana->totalsubsidiasuransi += $item['subsidiasuransi_tindakan'];
                            $alokasidana->totaliurbiaya += 0; // $item['jmlbayar_iurtindakan'];
                            $alokasidana->totalbayartindakan += 0; // $item['jmlbayar_iurtindakan'];
                        } else {
                            $alokasidana->totalsubsidiasuransi += 0; // $item['subsidiasuransi_tindakan'];
                            $alokasidana->totaliurbiaya += $item['jmlbayar_iurtindakan'];
                            $alokasidana->totalbayartindakan += $item['jmlbayar_iurtindakan'];

                            // var_dump($item['jmlbayar_iurtindakan']);
                        }

                        //var_dump($item);
                    }


                    // var_dump($multi, $alokasidana->attributes, $arr_tindakan, $arr_oa); die;

                    foreach ($arr_oa as $item) {

                        if (!isset($item['is_pilihoa']) || $item['is_pilihoa'] != 1) {
                            continue;
                        }

                        if ($multi['carabayar_id'] != Params::CARABAYAR_ID_MEMBAYAR) {
                            $alokasidana->totalsubsidiasuransi += $item['subsidiasuransi'];
                            $alokasidana->totaliurbiaya += 0; //$item['iurbiaya'];
                            $alokasidana->totalbayartindakan += 0; // $item['iurbiaya'];
                        } else {
                            $alokasidana->totalsubsidiasuransi += 0; // $item['subsidiasuransi'];
                            $alokasidana->totaliurbiaya += $item['subtotaloa'];
                            $alokasidana->totalbayartindakan += $item['subtotaloa'];
                        }

                    }

                    if ($multi['carabayar_id'] == Params::CARABAYAR_ID_MEMBAYAR) {
                        $alokasidana->totalsubsidiasuransi = 0; // $item['subsidiasuransi'];
                        $alokasidana->totaliurbiaya = $multi['jmlpiutangasuransi'];
                        $alokasidana->totalbayartindakan  = $multi['jmlpiutangasuransi'];
                    }

                    if (
                        $multi['carabayar_id'] == Params::CARABAYAR_ID_BPJS 
                        && isset($_POST['Alokasi']['is_naikkelas'])
                        && $_POST['Alokasi']['is_naikkelas'] == 1
                    ) {
                        // $alokasidana->totaliurbiaya = $_POST['Alokasi']['totaliurbiaya'];
                        $alokasidana->totalinacbg_naikkelasperawatan =  $_POST['Alokasi']['totaliurbiaya'];
                        $alokasidana->inacbg_kelastanggungan =  $_POST['Alokasi']['inacbg_kelastanggungan'];
                        $alokasidana->inacbg_kelasperawatan =  $_POST['Alokasi']['inacbg_kelasperawatan'];
                        $alokasidana->iurbeatujuhpuluhpersen =  $_POST['Alokasi']['iurbeatujuhpuluhpersen'];
                        $alokasidana->totalselisihkelastanggunganperawatan =  $_POST['Alokasi']['totalselisihkelastanggunganperawatan'];
                        $alokasidana->iurbea_id =  $_POST['Alokasi']['iurbea_id'];
                        // var_dump($alokasidana->attributes, $_POST['Alokasi']); die;
                    } 



                    $alokasidana->create_time = date('Y-m-d H:i:s');
                    $alokasidana->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                    $alokasidana->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    $this->ok = $this->ok && $alokasidana->save();

                    // var_dump($alokasidana->attributes);

                    if ($this->ok) {

                        $modDetTindakan = new AlokasidanadetailtindakanT;
                        $modDetOa = new AlokasidanadetailoaT;

                        $this->simpanAlokasiTindakan($modDetTindakan, $arr_tindakan, $pendaftaran, $alokasidana);
                        $this->simpanAlokasiOa($modDetOa, $arr_oa, $pendaftaran, $alokasidana);
                    }



                    // var_dump($alokasidana->attributes, $multi);

                    // die;

                }

                // var_dump($this->ok);
                // die;



         
                if ($this->ok) {

                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                    $transaction->commit();

                } else {

                    Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
                    $model->isNewRecord = true;
                    $model->pembayaranpelayanan_id = null;
                    $transaction->rollback();

                }
            } catch (Exception $exc) {
                $transaction->rollback();
                echo $exc->getMessage() . "<br/><br/>" . $exc->getTraceAsString();
                die;

                Yii::app()->user->setFlash('error', "Data pembayaran gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'instalasi_id' => $modKunjungan->instalasi_id));
            }
        }

        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render($this->path_view . 'indexAlokasi', array(
            'model' => $model,
            'modTandabukti' => $modTandabukti,
            'modKunjungan' => $modKunjungan,
            'dataTindakans' => $dataTindakans,
            'dataOas' => $dataOas,
            'modPemakaianuangmuka' => $modPemakaianuangmuka,
            'modAntrian' => $modAntrian,
            'modPiutangAsuransi' => $modPiutangAsuransi
        ));
    }


    /**
     * untuk menyimpan data asuransi pasien
     * @param type $model
     * @param type $post
     */
    public function simpanAlokasiTindakan($model, $post, $pendaftaran, $alokasi)
    {

        // echo '<pre>';

        foreach($post as $i => $tindakan) {

            if($tindakan['is_pilihtindakan']) {

                // var_dump($tindakan); die;

                $model = new AlokasidanadetailtindakanT;
                $model->attributes = $tindakan;
                $model->ruangan_id = $pendaftaran->ruangan_id;
                $model->jmlsubsidi_rs = 0;
                $model->jmlsisabayar_tindakan = 0;
                $model->alokasidana_id = $alokasi->alokasidana_id;
                
                if ($alokasi->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                    $model->jmlsubsidi_asuransi = 0; //$tindakan['subsidiasuransi_tindakan'];
                    $model->jmlbiaya_tindakan = $tindakan['subtotal'];
                    $model->jmliurbiaya = $tindakan['subtotal'];
                    $model->jmlbayar_tindakan = $tindakan['subtotal'];
                } else {
                    $model->jmlsubsidi_asuransi = $tindakan['subsidiasuransi_tindakan'];
                    $model->jmlbiaya_tindakan = 0; // $tindakan['subtotal'];
                    $model->jmliurbiaya = 0; // $tindakan['subtotal'];
                    $model->jmlbayar_tindakan = 0; // $tindakan['subtotal'];
                }
                

                $this->ok &= $model->save();

                if($model->save()) {
                    $tin = TindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                    $tin->alokasidanadetailtindakan_id = $model->alokasidanadetailtindakan_id;
                    $this->ok = $tin->save();
                }

                // var_dump($model->attributes);
                // var_dump($model->attributes, $model->getErrors(), $tindakan);


            }

            // die;

        }

        // die;
    }

        /**
     * untuk menyimpan data asuransi pasien
     * @param type $model
     * @param type $post
     */
    public function simpanAlokasiOa($model, $post, $pendaftaran, $alokasi)
    {

        // echo '<pre>';
        foreach($post as $i => $oa) {

            if($oa['is_pilihoa']) {


                // var_dump($oa);

                $model = new AlokasidanadetailoaT;
                $model->attributes = $oa;
                $model->ruangan_id = $pendaftaran->ruangan_id;
                $model->jmlsubsidi_rs = 0;
                $model->jmlsisabayar_oa = 0;
                $model->alokasidana_id = $alokasi->alokasidana_id;
                $model->hargasatuan = $oa['hargasatuan_oa'];
                // $model->jmlbiaya_tindakan = $oa['subtotal'];


                if ($alokasi->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                    $model->jmlsubsidi_asuransi = 0; //$oa['subsidiasuransi'];
                    $model->jmliurbiaya = $oa['subtotaloa'];
                    $model->jmlbayar_oa = $oa['subtotaloa'];

                } else {
                    $model->jmlsubsidi_asuransi = $oa['subsidiasuransi'];
                    $model->jmliurbiaya = 0; // $oa['jmlbayar_oa'];
                    $model->jmlbayar_oa = 0; // $oa['iurbiaya'];

                }
                
                
                // $model->jmlbayar_tindakan = $oa['subtotal'];

                $this->ok &= $model->save();

                if($model->save()) {
                    $oap = ObatalkespasienT::model()->findByPk($oa['obatalkespasien_id']);
                    $oap->alokasidanadetailoa_id = $model->alokasidanadetailoa_id;
                    $this->ok = $oap->save();
                }

                // var_dump($model->attributes, $model->getErrors());


            }

        }

        // die;

    }

    /**
     * untuk menyimpan data asuransi pasien
     * @param type $model
     * @param type $post
     */
    public function simpanAsuransiKelas($model, $post)
    {


        $tot = 0;
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);

        $asuransi = null;
        if (!empty($pendaftaran->asuransipasien_id)) {
            $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);
        }

        // $tot_asu = 0;


        foreach ($post as $kelas_id => $val) {

            if ($val == 0) continue;

            /*
            if (!empty($asuransi) && $kelas_id == $asuransi->kelastanggunganasuransi_id) {
                $tot_asu = $val;
            }
             *
             */

            // $tot += $val;

            $mod = SubsidikelasT::model()->findByAttributes(array('pembayaranpelayanan_id' => $model->pembayaranpelayanan_id));
            if (empty($mod)) {
                $mod = new SubsidikelasT;
            }
            $mod->pembayaranpelayanan_id = $model->pembayaranpelayanan_id;
            $mod->kelaspelayanan_id = $kelas_id;
            $mod->subsidiasuransi = $val;

            $mod->save();

            // var_dump($mod->attributes);
        }
    }

    /**
     * mengenerate notifikasi dan dikirim ke rawat jalan (+ Penunjang)
     * @param type $modKunjungan
     * @param type $pendaftaran
     * @param type $model
     * @return type
     */
    public function broadcastNotifBayarTagihanRJ($modKunjungan, $pendaftaran, $model)
    {
        $judul = "Pasien Sudah Bayar";
        $isi = $isi = $modKunjungan->no_rekam_medik . " - " . $modKunjungan->namadepan . $modKunjungan->nama_pasien;

        $ruangan = RuanganM::model()->findByPk($pendaftaran->ruangan_id);
        $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
        $kasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

        $cur = array();
        if (!empty($ruangan->modul_id)) {
            $cur[] = array('instalasi_id' => $pendaftaran->instalasi_id, 'ruangan_id' => $pendaftaran->ruangan_id, 'modul_id' => $ruangan->modul_id);
        }


        if ($pendaftaran->instalasi_id == Params::INSTALASI_ID_RJ) {
            $cur[] = array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK);
        }

        $cur[] = array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id);
        $cur[] = array('instalasi_id' => $kasir->instalasi_id, 'ruangan_id' => $kasir->ruangan_id, 'modul_id' => $kasir->modul_id);

        return CustomFunction::broadcastNotif($judul, $isi, $cur);
    }

    /**
     * mengenerate notifikasi dan dikirim ke rawat darurat atau inap
     * @param type $modKunjungan
     * @param type $pendaftaran
     * @param type $model
     * @return type
     */
    public function broadcastNotifBayarTagihanRDRI($modKunjungan, $pendaftaran, $model)
    {
        $judul = "Pasien Sudah Bayar";
        $isi = $isi = $modKunjungan->no_rekam_medik . " - " . $modKunjungan->namadepan . $modKunjungan->nama_pasien;
        $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
        $kasir = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

        $modul_id = Params::MODUL_ID_RD;
        $ruangan_id = 0;

        if ($modKunjungan->instalasi_id == Params::INSTALASI_ID_RD) {
            $modul_id = Params::MODUL_ID_RD;
            $ruangan_id = $pendaftaran->ruangan_id;
        } else if (in_array($modKunjungan->instalasi_id, Params::grupInstalasiRIID())) {
            $modul_id = Params::MODUL_ID_RI;
            $admisi = PasienadmisiT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
            ));
            $ruangan_id = $admisi->ruangan_id;
        } else if ($modKunjungan->instalasi_id == Params::INSTALASI_ID_ICU) {
            $modul_id = Params::MODUL_ID_ICU;
            $admisi = PasienadmisiT::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
            ));
            $ruangan_id = $admisi->ruangan_id;
        }


        $cur = array(
            array('instalasi_id' => $modKunjungan->instalasi_id, 'ruangan_id' => $ruangan_id, 'modul_id' => $modul_id),
            array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
            array('instalasi_id' => $kasir->instalasi_id, 'ruangan_id' => $kasir->ruangan_id, 'modul_id' => $kasir->modul_id)
        );

        // var_dump($modKunjungan->attributes); die;

        // var_dump($judul, $isi, $cur, $modKunjungan->attributes); die;

        return CustomFunction::broadcastNotif($judul, $isi, $cur);
    }

    /**
     * notifikasi pembayaran tagihan pasien
     * @param type $modKunjungan
     * @param type $model
     */
    protected function broadcastNotifBayarTagihanPasien($modKunjungan, $model)
    {
        //$judul = "Pembayaran Tagihan Pasien";
        //$isi = $isi = $modKunjungan->no_rekam_medik." - ".$modKunjungan->namadepan.$modKunjungan->nama_pasien." - ".MyFormatter::formatNumberForPrint($model->totalbiayapelayanan);

        //var_dump($modKunjungan->attributes); die;


        //$cur = array(
        //    array('instalasi_id'=>Params::INSTALASI_ID_RJ, 'ruangan_id'=>$pendaftaran->ruangan_id, 'modul_id'=>5),
        //);
    }

    /**
     * mengenerate notifikasi untuk pembayaran karcis
     * @param type $modKunjungan
     * @param type $model
     */
    protected function broadcastNotifBayarKarcisUmum($modKunjungan, $model)
    {
        $judul = "Pembayaran Karcis Pasien Umum";
        $isi = "";

        if ($modKunjungan->penjamin_id == Params::PENJAMIN_ID_UMUM && $modKunjungan->instalasi_id == Params::INSTALASI_ID_RJ) {
            $pendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
            if (!empty($pendaftaran->karcis_id)) {
                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                    'karcis_id' => $pendaftaran->karcis_id,
                ));
            } else {
                if (empty($tindakan)) {
                    $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                        'ruangan_id' => 2,
                    ), array(
                        'condition' => 'karcis_id is not null'
                    ));
                }
            }

            if (!empty($tindakan)) {
                if (!empty($tindakan->tindakansudahbayar_id)) {
                    $sb = TindakansudahbayarT::model()->findByPk($tindakan->tindakansudahbayar_id);
                    if ($sb->pembayaranpelayanan_id == $model->pembayaranpelayanan_id) {
                        $isi = $modKunjungan->no_rekam_medik . " - " . $modKunjungan->namadepan . $modKunjungan->nama_pasien . " - " . MyFormatter::formatNumberForPrint($model->totalbiayapelayanan);
                        // echo $isi;

                        CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id' => Params::INSTALASI_ID_RJ, 'ruangan_id' => $pendaftaran->ruangan_id, 'modul_id' => 5),
                        ));

                        $this->isbayarkarcis = true;
                    }

                    // return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien belum membayar karcis.'); return false;"));
                }
            }
        }
    }

    /**
     * simpan BKPembayaranpelayananT
     * @param type $model
     * @param type $post
     * @return type
     */
    protected function simpanPembayaranPelayanan($model, $post, $piutangasuransi = null)
    {
        // echo "<pre>";
        //var_dump($post); die;
        $carabayar_id = $_POST['carabayar_id'];
        $penjamin_id = $_POST['penjamin_id'];
        $totaltagihan = round($post['totalbiayapelayanan']);
        $totaltindakan = round($post['totalbiayatindakan']);
        $totaloa = round($post['totalbiayaoa']);

        if (!empty($piutangasuransi)) {
            $carabayar_id = $piutangasuransi['carabayar_id'];
            $penjamin_id = $piutangasuransi['penjamin_id'];
            $totaltagihan = round($piutangasuransi['jmlpiutangasuransi']);
            $totaltindakan = round($piutangasuransi['jmltindakanasuransi']);
            $totaloa = round($piutangasuransi['jmloaasuransi']);
        }

        // $model = new $model;
        $model->attributes = $post;
        $model->totalsisatagihan = 0;
        $model->tglpembayaran = MyFormatter::formatDateTimeForDB(empty($model->tglpembayaran) ? date("Y-m-d H:i:s") : $model->tglpembayaran);
        if (empty($model->pembayaranpelayanan_id)) {
            $model->nopembayaran = MyGenerator::noPembayaran();
        }

        $model->ruanganpelakhir_id = $_POST['ruangan_id'];
        $model->carabayar_id = $carabayar_id;
        $model->penjamin_id = $penjamin_id;
        $model->pendaftaran_id = $_POST['pendaftaran_id'];
        $model->pasien_id = $_POST['pasien_id'];
        $model->pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;

        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

        if (!empty($model->pembayaranpelayanan_id)) {
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->id;
        } else {
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->update_time = null;
            $model->update_loginpemakai_id = null;
        }
        //        $model->totalsisatagihan = 0;
        if (empty($model->totalsubsidiasuransi)) {
            $model->totalsubsidiasuransi = 0;
        }
        $model->totalsubsidipemerintah = 0;
        $model->totalbiayapelayanan = $totaltagihan;
        $model->totalbiayatindakan = $totaltindakan;
        $model->totalbiayaoa = $totaloa;


        $totals = $model->totalbiayapelayanan;
        $totals = str_replace('.', '', $totals);
        $totals = str_replace(',', '.', $totals);
        $totals = (int)$totals;
        if (isset($_POST['BKTandabuktibayarT']['biayaadministrasi'])) {

            // $totals = preg_replace("/[^0-9]/", "", $totals);
            // echo $totals."<br>";
            // echo $totals = (int)$totals + (int)$_POST['BKTandabuktibayarT']['biayaadministrasi'];die;
            $totals += (int)$_POST['BKTandabuktibayarT']['biayaadministrasi'];
        }
        // $totals += $model->totaldiscount;

        if ($totals != 0) {
            $model->persendiscount = ceil((float)$model->totaldiscount * 10000 / $totals) / 100;
        } else {
            $model->persendiscount = 0;
        }

        if ($model->totalbiayapelayanan != 0) {
            $model->persensubsidipemerintah = ceil((float)$model->totalsubsidipemerintah * 10000 / (float)$model->totalbiayapelayanan) / 100;
            $model->persensubsidirs = ceil((float)$model->totalsubsidirs * 10000 / (float)$model->totalbiayapelayanan) / 100;
            $model->persensubsidiasuransi = ceil((float)$model->totalsubsidiasuransi * 10000 / (float)$model->totalbiayapelayanan) / 100;
        } else {
            $model->persensubsidipemerintah = 0;
            $model->persensubsidirs = 0;
            $model->persensubsidiasuransi = 0;
        }




        // var_dump($model->attributes); die;
        if ($model->totalsisatagihan == 0) {
            $model->statusbayar = Params::STATUSBAYAR_LUNAS;
        } else {
            $model->statusbayar = Params::STATUSBAYAR_BELUM_LUNAS;
        }

        // $model->totalbayartindakan = (ceil($model->totalbiayapelayanan/100) * 100) - $model->totalsisatagihan;
        // var_dump($model->totalbayartindakan);
        $model->totalbayartindakan = ((int)$model->totalbiayapelayanan - (int)$model->totaldiscount) - (int)$model->totalsisatagihan;

        if (isset($_POST['tot_inacbg'])) {
            $model->total_inacbg = $_POST['tot_inacbg'];
        }

        /*
        var_dump($post, $model->attributes);
        die;
        // *
        // */

        if ($model->save()) {
            $this->pembayaranpelayanan_tersimpan = true;
            if (isset($post['antrian_id']) && !empty($post['antrian_id']))
                AntrianT::model()->updateByPk($post['antrian_id'], array(
                    'pendaftaran_id' => $model->pendaftaran_id
                ));
        }

        // var_dump($model->attributes); die;

        return $model;
    }
    /**
     * simpan BKTandabuktibayarT
     * ubah BKPembayaranpelayananT.tandabuktibayar_id
     * @param type $model
     * @param type $modTandabukti
     * @param type $post
     * @return type
     */
    protected function simpanTandaBuktiBayar($model, $modTandabukti, $post)
    {
        $modTandabukti->attributes = $model->attributes;
        $modTandabukti->attributes = $post;
        $modTandabukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
        if (empty($modTandabukti->tandabuktibayar_id)) {
            $modTandabukti->nourutkasir = MyGenerator::noUrutKasir($modTandabukti->ruangan_id);
            $modTandabukti->nobuktibayar = MyGenerator::noBuktiBayarNew();
        }
        
        // var_dump($modTandabukti->nobuktibayar);die;
        $modTandabukti->shift_id = Yii::app()->user->getState('shift_id');
        $modTandabukti->tglbuktibayar = $model->tglpembayaran;

        $modTandabukti->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if (!empty($modTandabukti->tandabuktibayar_id)) {
            $modTandabukti->update_time = date('Y-m-d H:i:s');
            $modTandabukti->update_loginpemakai_id = Yii::app()->user->id;
        } else {
            $modTandabukti->create_time = date('Y-m-d H:i:s');
            $modTandabukti->create_loginpemakai_id = Yii::app()->user->id;
            $modTandabukti->update_time = null;
            $modTandabukti->update_loginpemakai_id = null;
        }

        $modTandabukti->jmlpembulatan = 0;
        // $modTandabukti->uangkembalian = 0;

        // var_dump($modTandabukti->validate(), $modTandabukti->errors, $modTandabukti->attributes);
        // die;

        if (!$post['is_menggunakankartu']) { //jika tidak menggunakan kartu
            $modTandabukti->dengankartu = null;
            $modTandabukti->bankkartu = null;
            $modTandabukti->nokartu = null;
            $modTandabukti->nostrukkartu = null;
        }
        if (isset($_POST['BKTandabuktibayarT']['jmlpembulatan'])) {
            $modTandabukti->jmlpembulatan = $_POST['BKTandabuktibayarT']['jmlpembulatan'];
        }

        if ($model->totaliurbiaya == $modTandabukti->bank_nominal) {
            $modTandabukti->jmlpembulatan = 0;
        }

        if ($modTandabukti->save()) {
            $model->tandabuktibayar_id = $modTandabukti->tandabuktibayar_id;
            if ($model->save()) {
                $this->tandabuktibayar_tersimpan = true;
                $this->simpanDetailPembayaran($modTandabukti, $model);
            }
        }
        //        var_dump($post); die;

        //        die;

        return $modTandabukti;
    }

    protected function simpanDetailPembayaran($modTandaBukti, $model = null)
    {

        // var_dump($modTandaBukti->attributes); die;

        //         if (isset($_POST['PembayaranemoneyT']['detail'])) {
        // //            var_dump($_POST['PembayaranemoneyT']['detail']);
        // //
        //             $nominal = 0;
        // //
        // //            die;
        // //             foreach ($_POST['PembayaranemoneyT']['detail'] as $item) {
        // //
        // //
        // //
        // //                 $det = PembayaranemoneyT::model()->findByAttributes(array(
        // //                     'no_order'=>$item['no_order']
        // //                 ));
        // //
        // //                 if (!empty($det)) {
        // //                     $det->pembayaranpelayanan_id = $modTandaBukti->pembayaranpelayanan_id;
        // //                     $det->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
        // //                     $det->bayaruangmuka_id = $modTandaBukti->bayaruangmuka_id;
        // //
        // //                     $this->tandabuktibayar_tersimpan = $this->tandabuktibayar_tersimpan && $det->save();
        // //
        // //
        // //                     $nominal += $det->jumlahpembayaran;
        // //
        // //                 }
        // //
        // //
        // //
        // //
        // // //                var_dump($modTandaBukti->attributes); die;
        // //
        // //             }
        //
        // //            die;
        //         }

        // $payment = new Payment;
        // echo '<pre>';
        // print_r($_POST);
        // exit();
        $nominal = 0;
        if (
            isset($_POST['JenispembayaranT']['detail'])
            && count((array)$_POST['JenispembayaranT']['detail']) > 0
            && isset($_POST['BKTandabuktibayarT']['is_menggunakankartu'])
            && $_POST['BKTandabuktibayarT']['is_menggunakankartu'] == 1
        ) {
            $jenis = JenispembayaranT::model()->deleteAll('tandabuktibayar_id = ' . $modTandaBukti->tandabuktibayar_id);
            foreach ($_POST['JenispembayaranT']['detail'] as $item) {
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
                    //                    var_dump($jenis->getErrors(), $jenis->attributes);
                    $this->tandabuktibayar_tersimpan = false;
                }

                $nominal += $jenis->jumlahpembayaran;
                // var_dump($this->tandabuktibayar_tersimpan, $jenis->attributes, $item, $modTandaBukti->attributes);
            }
        }


        $modTandaBukti->bank_nominal = $nominal;
        $modTandaBukti->save();
        //        var_dump($modTandaBukti->attributes);
        //        die;


    }

    /**
     * simpan BKPemakaianuangmukaT
     * @param type $model
     * @param type $modTandabukti
     * @param type $post
     * @return type
     */
    protected function simpanPemakaianUangMuka($model, $modPemakaianuangmuka, $post, $bayaruangmuka)
    {
        $modPemakaianuangmuka->attributes = $model->attributes;
        $modPemakaianuangmuka->attributes = $post;
        $modPemakaianuangmuka->pendaftaran_id = $model->pendaftaran_id; //RSN-1195
        $modPemakaianuangmuka->bayaruangmuka_id = $bayaruangmuka->bayaruangmuka_id; //RSN-1195
        $modPemakaianuangmuka->tglpemakaian = date("Y-m-d H:i:s");
        $modPemakaianuangmuka->create_time = date('Y-m-d H:i:s');
        $modPemakaianuangmuka->create_loginpemakai_id = Yii::app()->user->id;
        $modPemakaianuangmuka->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modPemakaianuangmuka->save()) {
            $crit_uangmuka = new CDbCriteria();
            if (!empty($model->pendaftaran_id)) {
                $crit_uangmuka->addCondition("pendaftaran_id = " . $model->pendaftaran_id);
            }
            if (!empty($model->pasienadmisi_id)) {
                $crit_uangmuka->addCondition("pasienadmisi_id = " . $model->pasienadmisi_id);
            }
            $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL and pembatalanuangmuka_id is null");

            $this->setPemakaianUangMuka($modPemakaianuangmuka, $crit_uangmuka);

            BayaruangmukaT::model()->updateAll(array('pemakaianuangmuka_id' => $modPemakaianuangmuka->pemakaianuangmuka_id), $crit_uangmuka);
            $this->pemakaianuangmuka_tersimpan = true;
        }
        return $modPemakaianuangmuka;
    }


    public function setPemakaianUangMuka($modPemakaianuangmuka, $crit_uangmuka)
    {

        $crit = clone $crit_uangmuka;
        $crit->order = "bayaruangmuka_id asc";

        $uangmuka = BayaruangmukaT::model()->findAll($crit);
        $total = $modPemakaianuangmuka->pemakaianuangmuka;

        foreach ($uangmuka as $item) {

            $selisih = $item->jumlahuangmuka - $item->uangmukadipakai;

            if ($selisih < $total) {
                $item->uangmukadipakai += $selisih;
                $total -= $selisih;
            } else {
                $item->uangmukadipakai += $total;
                $total = 0;
            }

            $item->save();
        }
    }

    /**
     * simpan BKBayarangsuranpelayananT
     * ubah BKPembayaranpelayananT.statusbayar
     * @param type $model
     * @param type $modTandabukti
     * @param modBayarangsuran $modBayarangsuran
     */
    protected function simpanBayarAngsuran($model, $modTandabukti, $modBayarangsuran)
    {
        $modBayarangsuran = BayarangsuranpelayananT::model()->findByAttributes(array('tandabuktibayar_id' => $modTandabukti->tandabuktibayar_id, 'pembayaranpelayanan_id' => $model->pembayaranpelayanan_id));

        if (empty($modBayarangsuran)) {
            $modBayarangsuran = new $modBayarangsuran;
        }


        $modBayarangsuran->tandabuktibayar_id = $modTandabukti->tandabuktibayar_id;
        $modBayarangsuran->pembayaranpelayanan_id = $model->pembayaranpelayanan_id;
        $modBayarangsuran->tglbayarangsuran = date("Y-m-d H:i:s");
        $modBayarangsuran->bayarke = 1;
        $modBayarangsuran->jmlbayarangsuran = $modTandabukti->uangditerima;
        $modBayarangsuran->sisaangsuran = $model->totalsisatagihan;
        $modBayarangsuran->create_time = date('Y-m-d H:i:s');
        $modBayarangsuran->create_loginpemakai_id = Yii::app()->user->id;
        $modBayarangsuran->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($modBayarangsuran->save()) {
            $model->statusbayar = Params::STATUSBAYAR_BELUM_LUNAS;
            if ($model->save()) {
                $this->bayarangsuran_tersimpan = true;
            }
        }
    }
    /**
     * simpan BKTindakansudahbayarT
     * ubah BKTindakanpelayananT.tindakansudahbayar_id
     * @param type $model
     * @param type $modTindakansudahbayar
     * @param type $dataTindakans
     * @return array $dataTindakans (BKTindakanpelayananT)
     */
    protected function simpanBayarTindakans($model, $modTindakansudahbayar, $posts)
    {
        $dataTindakans = array();
        $this->bayarsemuatindakanoa = true;

        if (count((array)$posts) > 0) {
            $this->tindakansudahbayar_tersimpan = true; //set true karna akan di looping
            foreach ($posts as $i => $post) {
                $modTindakan = BKTindakanPelayananT::model()->findByPk($post['tindakanpelayanan_id']);
                $dataTindakans[$i] = $modTindakan;
                $dataTindakans[$i]->attributes = $post;
                $this->ubahTindakanPelayanan($post);

                if ($post['is_pilihtindakan']) { //jika di ceklis
                    if (!empty($post['tindakansudahbayar_id'])) {
                        $modTindakansudahbayar = TindakansudahbayarT::model()->findByAttributes(array('tindakansudahbayar_id' => $post['tindakansudahbayar_id']));
                        if (empty($modTindakansudahbayar)) {
                            $modTindakansudahbayar = new TindakansudahbayarT;
                        }
                    } else {
                        $modTindakansudahbayar = new TindakansudahbayarT;
                    }

                    $modTindakansudahbayar->attributes = $post;

                    $modTindakansudahbayar->pembayaranpelayanan_id = $model->pembayaranpelayanan_id;
                    $modTindakansudahbayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $modTindakansudahbayar->jmlbiaya_tindakan = ($post['qty_tindakan'] * $post['tarif_satuan']) +  $post['tarifcyto_tindakan'];
                    $modTindakansudahbayar->jmlpembebasan = $post['pembebasan_tindakan'];
                    $modTindakansudahbayar->jmlsubsidi_asuransi = $post['subsidiasuransi_tindakan'];
                    $modTindakansudahbayar->jmlsubsidi_pemerintah = $post['subsidipemerintah_tindakan']; //tidak digunakan lagi
                    $modTindakansudahbayar->jmlsubsidi_rs = $post['subsisidirumahsakit_tindakan'];
                    $modTindakansudahbayar->jmliurbiaya = $post['iurbiaya_tindakan'];
                    $modTindakansudahbayar->jmlbayar_tindakan = $post['jmlbayar_iurtindakan'];
                    $modTindakansudahbayar->jmlselisihbpjs = $post['jmlselisihbpjs'];
                    $modTindakansudahbayar->jmlsisabayar_tindakan = ($modTindakansudahbayar->jmliurbiaya - $modTindakansudahbayar->jmlbayar_tindakan);
                    if ($modTindakansudahbayar->save()) {
                        if (TindakanpelayananT::model()->updateByPk($post['tindakanpelayanan_id'], array('tindakansudahbayar_id' => $modTindakansudahbayar->tindakansudahbayar_id))) {
                            $this->tindakansudahbayar_tersimpan = $this->tindakansudahbayar_tersimpan && true;
                        } else {
                            $this->tindakansudahbayar_tersimpan = false;
                        }
                    }
                } else {
                    $this->bayarsemuatindakanoa = false; //ada yg di uncheck berarti belum lunas
                }
            }
        }
        // die;
        // var_dump($dataTindakans);die;
        return $dataTindakans;
    }

    /**
     * untuk mengubah data tindakan pelayanan
     * @param type $post
     */
    protected function ubahTindakanPelayanan($post)
    {
        $modTindakan = BKTindakanPelayananT::model()->findByPk($post['tindakanpelayanan_id']);
        $modTindakan->attributes = $post;
        $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($modTindakan->tgl_tindakan);
        if ($modTindakan->update()) {
            $this->ubahTindakanKomponen($modTindakan);
        }
    }

    /**
     * ubah nilai tindakan komponen
     * @param type $modTindakan
     */
    protected function ubahTindakanKomponen($modTindakan)
    {
        // var_dump($modTindakan->attributes);
        // $dataTarif = $this->getDataTarifTindakanKomponen($modTindakan);
        $modKomponens = BKTindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));
        // if (count((array)$dataTarif)>0){
        // if($dataTarif[Params::KOMPONENTARIF_ID_TOTAL]['harga_tariftindakan']==$modTindakan->subsidiasuransi_tindakan){
        //    foreach ($modKomponens as $i => $komponen){
        //        $komponen->subsidiasuransikomp =  $dataTarif[$komponen->komponentarif_id]['harga_tariftindakan'];
        // var_dump($komponen->attributes); die;
        //        $komponen->update();
        //    }
        // }else{
        foreach ($modKomponens as $i => $komponen) {
            $komponen->subsidiasuransikomp = (($modTindakan->qty_tindakan * $modTindakan->tarif_satuan) == 0) ? 0 : (($komponen->tarif_kompsatuan * $modTindakan->subsidiasuransi_tindakan) / ($modTindakan->qty_tindakan * $modTindakan->tarif_satuan));
            $komponen->subsidipemerintahkomp = (($modTindakan->qty_tindakan * $modTindakan->tarif_satuan) == 0) ? 0 : (($komponen->tarif_kompsatuan * $modTindakan->subsidipemerintah_tindakan) / ($modTindakan->qty_tindakan * $modTindakan->tarif_satuan));
            $komponen->subsidirumahsakitkomp = (($modTindakan->qty_tindakan * $modTindakan->tarif_satuan) == 0) ? 0 : (($komponen->tarif_kompsatuan * $modTindakan->subsisidirumahsakit_tindakan) / ($modTindakan->qty_tindakan * $modTindakan->tarif_satuan));
            $komponen->iurbiayakomp = $komponen->tarif_tindakankomp - ($komponen->subsidiasuransikomp + $komponen->subsidipemerintahkomp + $komponen->subsidirumahsakitkomp); //($komponen->tarif_kompsatuan * $modTindakan->subsisidirumahsakit_tindakan)/($modTindakan->qty_tindakan*$modTindakan->tarif_satuan);
            // var_dump($komponen->attributes);
            $komponen->update();
        }
        // }
        // }
    }

    /**
     * mencarri nilai tarif tindakan komponen
     * @param type $modTindakan
     * @return type
     */
    protected function getDataTarifTindakanKomponen($modTindakan)
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($modTindakan->pendaftaran_id);
        $modAsuransipasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
        $tarif = array();
        if ($modAsuransipasien) {
            $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransipasien->kelastanggunganasuransi_id, 'penjamin_id' => $modAsuransipasien->penjamin_id));
            if ($modTanggungan) {
                $sql_tarif = "SELECT tariftindakan_m.*
                        FROM tariftindakan_m
                        JOIN jenistarifpenjamin_m ON jenistarifpenjamin_m.jenistarif_id = tariftindakan_m.jenistarif_id
                        WHERE daftartindakan_id = " . $modTindakan->daftartindakan_id . "
                        AND tariftindakan_m.kelaspelayanan_id = " . $modTanggungan->kelaspelayanan_id . "
                        AND jenistarifpenjamin_m.penjamin_id = " . $modTanggungan->penjamin_id;
                $dataTarifs = Yii::app()->db->createCommand($sql_tarif)->queryAll();
                if (count((array)$dataTarifs) > 0) {
                    foreach ($dataTarifs as $i => $data) {
                        $tarif[$data['komponentarif_id']] = $data;
                    }
                }
            }
        }

        return $tarif;
    }

    /**
     * simpan BKOasudahbayarT
     * ubah BKObatalkesPasienT.oasudahbayar_id
     * @param type $model
     * @param $modOasudahbayar $modOasudahbayar
     * @param type $posts
     * @return type
     */
    protected function simpanBayarOas($model, $modOasudahbayar, $posts)
    {
        $dataOas = array();
        $this->bayarsemuatindakanoa = true;
        if (count((array)$posts) > 0) {
            $dataTindakans = $posts;
            $this->oasudahbayar_tersimpan = true; //set true karna akan di looping
            foreach ($posts as $i => $post) {
                $modOaPasien = BKObatalkesPasienT::model()->findByPk($post['obatalkespasien_id']);
                $dataOas[$i] = $modOaPasien;
                $dataOas[$i]->attributes = $post;
                if ($post['is_pilihoa']) { //jika di ceklis
                    if (!empty($post['oasudahbayar_id'])) {
                        $modOasudahbayar = OasudahbayarT::model()->findByAttributes(array('oasudahbayar_id' => $post['oasudahbayar_id']));
                        if (empty($modOasudahbayar)) {
                            $modOasudahbayar = new OasudahbayarT;
                        }
                    } else {
                        $modOasudahbayar = new OasudahbayarT;
                    }

                    $modOasudahbayar->attributes = $post;
                    $modOasudahbayar->pembayaranpelayanan_id = $model->pembayaranpelayanan_id;
                    $modOasudahbayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $modOasudahbayar->qty_oa = $post['qty_oa'];
                    $modOasudahbayar->hargasatuan = $post['hargasatuan_oa'];
                    $modOasudahbayar->jmlsubsidi_asuransi = $post['subsidiasuransi'];
                    $modOasudahbayar->jmlsubsidi_pemerintah = $post['subsidipemerintah']; //tidak digunakan lagi
                    $modOasudahbayar->jmlsubsidi_rs = $post['subsidirs'];
                    $modOasudahbayar->jmliurbiaya = $post['iurbiaya'];
                    $modOasudahbayar->jmlbayar_oa = $post['jmlbayar_oa'];
                    $modOasudahbayar->jmlselisihbpjs = $post['jmlselisihbpjs'];
                    $modOasudahbayar->jmlsisabayar_oa = ($modOasudahbayar->jmliurbiaya - $modOasudahbayar->jmlbayar_oa);
                    $modOasudahbayar->qty_oa = MyFormatter::formatRupiahForDb($modOasudahbayar->qty_oa);


                    // var_dump($modOasudahbayar->attributes);

                    if ($modOasudahbayar->save()) {
                        if (ObatalkespasienT::model()->updateByPk($post['obatalkespasien_id'], array(
                            'oasudahbayar_id' => $modOasudahbayar->oasudahbayar_id,
                            'subsidiasuransi' => $post['subsidiasuransi'],
                            'subsidipemerintah' => $post['subsidipemerintah'],
                            'subsidirs' => $post['subsidirs'],
                            'iurbiaya' => $post['iurbiaya'],
                        ))) {
                            $this->oasudahbayar_tersimpan = $this->oasudahbayar_tersimpan && true;
                        } else {
                            $this->oasudahbayar_tersimpan = false;
                        }
                    }
                } else {
                    $this->bayarsemuatindakanoa = false; //ada yg di uncheck berarti belum lunas
                }
            }
        }


        // die;

        return $dataOas;
    }
    /**
     * form verifikasi sebelum submit
     */
    public function actionVerifikasi()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = '//layouts/iframe';

            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $admisi = null;
            $antri = false;
            $antri = 0;

            if (isset($_POST['BKPembayaranpelayananT'])) {
                $format = new MyFormatter();
                $criteria = new CdbCriteria();
                $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
                if (!empty($pendaftaran_id)) {
                    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
                }
                if (!empty($pasienadmisi_id)) {
                    $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
                }
                if ($_POST['instalasi_id'] == Params::INSTALASI_ID_RJ) {
                    $modKunjungan = BKInformasikasirrawatjalanV::model()->find($criteria);
                } else if ($_POST['instalasi_id'] == Params::INSTALASI_ID_RD || $_POST['instalasi_id'] == Params::INSTALASI_ID_PERSALINAN) {
                    $modKunjungan = BKInformasikasirrdpulangV::model()->find($criteria);
                } else if (in_array($_POST['instalasi_id'], Params::grupInstalasiRIID())) {
                    $modKunjungan = BKInformasikasirinappulangV::model()->find($criteria);
                    $admisi = PasienadmisiT::model()->findByPk($modKunjungan->pasienadmisi_id);
                } else if ($_POST['instalasi_id'] == Params::INSTALASI_ID_MCU2) {
                    $modKunjungan = BKInformasikasirmcuV::model()->find($criteria);
                } else if ($_POST['instalasi_id'] == Params::INSTALASI_ID_HD) {
                    $modKunjungan = InformasikasirhemodialisaV::model()->find($criteria);
                } else if ($_POST['instalasi_id'] == Params::INSTALASI_ID_REHAB) {
                    $modKunjungan = BKPembayarantagihanpenunjangV::model()->find($criteria);
                } else {
                    $modKunjungan = BKPasienmasukpenunjangV::model()->find($criteria);
                }
                $model = new BKPembayaranpelayananT;
                $modTandabukti = new BKTandabuktibayarT;
                $modPemakaianuangmuka = new BKPemakaianuangmukaT;

                $model->attributes = $_POST['BKPembayaranpelayananT'];
                $model->total_inacbg = (!empty($_POST['BKPembayaranpelayananT']['total_inacbg']) ? $_POST['BKPembayaranpelayananT']['total_inacbg'] : 0);
                $model->totalsubsidiasuransi = (!empty($_POST['BKPembayaranpelayananT']['totalsubsidiasuransi']) ? $_POST['BKPembayaranpelayananT']['totalsubsidiasuransi'] : 0);
                // $model->totalbiayapelayanan = MyFormatter::formatRupiahForDb($_POST['BKPembayaranpelayananT']['totalbiayapelayanan']);

                $modTandabukti->attributes = $_POST['BKTandabuktibayarT'];
                // $modTandabukti->biayaadministrasi = MyFormatter::formatRupiahForDb($_POST['BKTandabuktibayarT']['biayaadministrasi']);
                // $modTandabukti->biayamaterai = MyFormatter::formatRupiahForDb($_POST['BKTandabuktibayarT']['biayamaterai']);
                // $modTandabukti->jmlpembayaran = MyFormatter::formatRupiahForDb($_POST['BKTandabuktibayarT']['jmlpembayaran']);
                // $modTandabukti->uangditerima = MyFormatter::formatRupiahForDb($_POST['BKTandabuktibayarT']['uangditerima']);
                // $mo  dTandabukti->uangkembalian = MyFormatter::formatRupiahForDb($_POST['BKTandabuktibayarT']['uangkembalian']);
                // $modTandabukti->bank_nominal = (isset($_POST['BKTandabuktibayarT']['bank_nominal'])? MyFormatter::formatRupiahForDb($_POST['BKTandabuktibayarT']['bank_nominal']):0);

                $modTandabukti->is_menggunakankartu = $_POST['BKTandabuktibayarT']['is_menggunakankartu'];
                $modPemakaianuangmuka->attributes = $_POST['BKPemakaianuangmukaT'];
                // $modPemakaianuangmuka->pemakaianuangmuka = MyFormatter::formatRupiahForDb($_POST['BKPemakaianuangmukaT']['pemakaianuangmuka']);

                $model->totaliurbiaya = $modTandabukti->uangditerima = $_POST['total_semua'] ?? $model->totaliurbiaya;
                $modTandabukti->jmlpembulatan = 0;
                $modTandabukti->biayaadministrasi = 0;
                $modTandabukti->jmlpembayaran = $model->totalbiayapelayanan;
                
                /**
                 * Muncul alert jika pasien memenuhi semua kriteria:
                 * - Pasien Poli (RAWAT JALAN)
                 * - Status Periksa ANTRIAN
                 * - Penjamin Selain UMUM
                 * - Belum ada tindakan poli
                 */
                $antri = 0;
                if (!empty($pendaftaran_id)) {
                    $p = PendaftaranT::model()->findByAttributes(array(
                        'pendaftaran_id' => $pendaftaran_id,
                        'statusperiksa' => Params::STATUSPERIKSA_ANTRIAN,
                        'instalasi_id' => Params::INSTALASI_ID_RJ,
                    ), array(
                        'condition' => 'penjamin_id <> ' . Params::PENJAMIN_ID_UMUM,
                    ));
                    if (!empty($p)) {
                        $t = TindakanpelayananT::model()->findByAttributes(array(
                            'pendaftaran_id' => $pendaftaran_id,
                            'ruangan_id' => $p->ruangan_id,
                        ));
                        if (empty($t))
                            $antri = 1;
                    }
                }
            }
            $modJenisPembayaran = array();
            $indexJns = 1;
            if (isset($_POST['JenispembayaranT']['detail']) && count((array) $_POST['JenispembayaranT']['detail']) > 0) {
                foreach ($_POST['JenispembayaranT']['detail'] as $jnsPem) {
                    $jnsPembyr = JnspembayarM::model()->findByPk($jnsPem['jenispembayaran']);
                    $banknama = "";
                    if (isset($jnsPem['bankpenerima_id'])) {
                        $bankPen = BankM::model()->findByPk($jnsPem['bankpenerima_id']);
                        $banknama = (isset($bankPen) ? $bankPen->namabank : "");
                    }

                    $jenisPm = array(
                        'jnspembayar_nama' => (isset($jnsPembyr) ? $jnsPembyr->jnspembayar_nama : ""),
                        'bank_nama' => $banknama,
                        'tgltransaksi' => $jnsPem['tgltransaksi'],
                        'nominal' => $jnsPem['jumlahpembayaran'],
                        'bayarke' => $indexJns
                    );
                    $indexJns += 1;

                    $modJenisPembayaran[] = $jenisPm;
                }
            }

            echo CJSON::encode(array(
                'antri' => $antri,
                'content' => $this->renderPartial($this->path_view . 'verifikasi', array(
                    'format' => $format,
                    'modKunjungan' => $modKunjungan,
                    'model' => $model,
                    'modTandabukti' => $modTandabukti,
                    'modPemakaianuangmuka' => $modPemakaianuangmuka,
                    'admisi' => $admisi,
                    'modJenisPembayaran' => $modJenisPembayaran
                ), true)
            ));
            exit;
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bkpembayaranpelayanan-t-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
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
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 't.no_pendaftaran, t.no_rekam_medik, t.nama_pasien';


            $criteria->join = "left join (
                select distinct on (a.pendaftaran_id, a.pasienadmisi_id) a.pendaftaran_id, a.pasienadmisi_id, a.update_time, a.verifikasitagihan_id
                from verifikasitagihan_t a order by a.pendaftaran_id, a.pasienadmisi_id, a.update_time desc, a.verifikasitagihan_id desc
            ) v on v.pendaftaran_id = t.pendaftaran_id 
            left join (
                select b.pendaftaran_id from tindakanpelayanan_t b 
                where b.verifrenctindakan_id IS NOT NULL and b.alokasidanadetailtindakan_id IS NULL
                group by b.pendaftaran_id
            ) vt on vt.pendaftaran_id = t.pendaftaran_id
            left join (
                select b.pendaftaran_id from obatalkespasien_t b 
                where b.qty_oa > 0 and b.verifikasitagihan_id is not null and b.alokasidanadetailoa_id IS NULL
                group by b.pendaftaran_id
            ) vo on vo.pendaftaran_id = t.pendaftaran_id";

            $criteria->addCondition("vt.pendaftaran_id is not null or vo.pendaftaran_id is not null");


            $criteria->limit = 50;
            if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                $criteria->compare('t.instalasi_id', $instalasi_id);
                $models = BKInformasikasirrawatjalanV::model()->findAll($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
                $criteria->compare('t.instalasi_id', $instalasi_id);
                $models = BKInformasikasirrdpulangV::model()->findAll($criteria);
            } else if (in_array($instalasi_id, Params::grupInstalasiRIID())) {
                $criteria->compare('t.instalasi_id', Params::grupInstalasiRIID());
                $criteria->addCondition('(t.tglpasienpulang is null or t.carakeluar_id = 4)');
                $models = BKInformasikasirinappulangV::model()->findAll($criteria);
            }

            $list_id = array();
            $len = 0;

            foreach ($models as $i => $model) {

                if ($len == 5) {
                    break;
                }

                if (in_array($model->pendaftaran_id, $list_id)) {
                    continue;
                }
                $list_id[] = $model->pendaftaran_id;

                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
                $returnVal[$i]['value'] = $model->no_pendaftaran;
                
                $len++;
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
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $notif = array('ok' => 1, 'msg' => '');
            $pesan = "";
            $ok = true;
            $criteria = new CDbCriteria();
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
            }
            if (!empty($pasienadmisi_id)) {
                $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
            }
            if (!empty($instalasi_id)) {
                $criteria->addCondition("instalasi_id = " . $instalasi_id);
            }
            $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));


            $returnVal['dpjp1'] = "";
            $returnVal['dpjp2'] = "";
            $returnVal['dpjp3'] = "";
            $returnVal['dokterpenerima'] = "";
            $returnVal['persen_diskon'] = '0';
            $returnVal['persen_admin'] = '0';
            $returnVal['nilai_admin'] = '0';

            $reseptur = ResepturT::model()->findAllByAttributes(array(
                'pendaftaran_id' => $pendaftaran_id,
            ), array(
                'condition' => 'penjualanresep_id is null',
            ));

            $konfig = KonfigsystemK::model()->find();

            $is_rawatinap = false;

            // if ($instalasi_id == Params::INSTALASI_ID_RJ && $konfig->isonestopbilling) {
            if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                $model = BKInformasikasirrawatjalanV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

                if (!empty($penjamin->diskon_tagihan)) {
                    $returnVal['persen_diskon'] = number_format($penjamin->diskon_tagihan, 2, ",", "");
                }

                if (!empty($penjamin->diskon_rj)) {
                    $returnVal['persen_diskon'] = number_format($penjamin->diskon_rj, 2, ",", "");
                }
                $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");

            } else if ($instalasi_id == Params::INSTALASI_ID_MCU2) {
                $model = BKInformasikasirmcuV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

            } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
                $model = InformasikasirhemodialisaV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

                // $returnVal['persen_diskon'] = number_format($penjamin->diskon_rj, 2, ",", "");
                // $returnVal['persen_admin'] = number_format($penja    min->biaya_administrasi, 2, ",", "");
                // /*
                if ($model->status_hd != Params::STATUS_HD_SELESAI) {
                    if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $ok &= 9;
                        $pesan .= "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
                    } else {
                        $ok &= 0;
                        $pesan .= "Pasien ${nama} (${no_rm}) masih dalam status ${status}"
                            . " di ${ruangan}";
                    }
                }

            } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
                $model = BKInformasikasirrdpulangV::model()->find($criteria);

                $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;

                if ($instalasi_id == Params::INSTALASI_ID_RD) {
                    if (!empty($penjamin->diskon_tagihan)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_tagihan, 2, ",", "");
                    }

                    if (!empty($penjamin->diskon_rd)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_rd, 2, ",", "");
                    }

                    $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");
                }

            } else if (in_array($instalasi_id, Params::grupInstalasiRIID())) {

                $is_rawatinap = true;

                $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                $pulang = PasienpulangT::model()->findByAttributes(array(
                    'pasienadmisi_id' => $pendaftaran->pasienadmisi_id,
                ));

                if (!empty($pulang) && $pulang->carakeluar_id == Params::CARAKELUAR_ID_MELARIKANDIRI) {
                    $model = BKInfokunjunganRIV::model()->find($criteria);
                } else {
                    $model = BKInformasikasirinappulangV::model()->find($criteria);
                }



                $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
                $nama = $model->namadepan . $model->nama_pasien;
                $ruangan = $model->ruangan_nama;


                $penjamin = PenjaminpasienM::model()->findByPk($admisi->penjamin_id);

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

                if (in_array($instalasi_id, Params::grupInstalasiRIID())) {
                    if (!empty($penjamin->diskon_tagihan)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_tagihan, 2, ",", "");
                    }

                    if (!empty($penjamin->diskon_ri)) {
                        $returnVal['persen_diskon'] = number_format($penjamin->diskon_ri, 2, ",", "");
                    }
                    $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");
                }

                $returnVal['nilai_admin'] = 0;

                $verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
                    'pendaftaran_id' => $model->pendaftaran_id,
                ), array(
                    'order' => 'verifikasitagihan_id desc',
                ));

                if (!empty($verifikasi) && $verifikasi->biaya_administrasi != 0) {
                    $returnVal['persen_admin'] = "0,00";
                    $returnVal['nilai_admin'] = MyFormatter::formatNumberForPrint($verifikasi->biaya_administrasi);
                }

            } else if ($instalasi_id == Params::INSTALASI_ID_REHAB) {
                // $model = BKInformasikasirfisioterapiV::model()->find($criteria);

                // $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);
                $model = BKPembayarantagihanpenunjangV::model()->find($criteria);
                $modPendaftaran = BKPendaftaranT::model()->findByPk($model->pendaftaran_id);
                $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);

                $no_rm = $model->no_rekam_medik;
                $nama = $model->namadepan . $model->nama_pasien;
                $status = $model->statusperiksa;
                $ruangan = $model->ruangan_nama;
                $model->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $model->carabayar_id = $modPendaftaran->carabayar_id;
                $model->tanggal_lahir = $modPendaftaran->pasien->tanggal_lahir;
                $model->nama_pegawai = $modPendaftaran->pegawai->nama_pegawai;
                $model->penjamin_id = $penjamin->penjamin_id;

                $returnVal['alamat_pasien'] = $modPendaftaran->pasien->alamat_pasien;
                $returnVal['ruangan_id'] = $modPendaftaran->ruangan_id;
                $returnVal['pasien_id'] = $modPendaftaran->pasien_id;

            } else if ($instalasi_id == Params::INSTALASI_ID_LAB || $instalasi_id == Params::INSTALASI_ID_RAD) {
                // $criteria = new CDbCriteria();
                $model = new BKPasienmasukpenunjangV;
                $model->instalasi_id = $instalasi_id;
                $criteria = $model->criteriaGroupByPendaftaran();
                if (!empty($pendaftaran_id)) {
                    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
                }
                if (!empty($pasienadmisi_id)) {
                    $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
                }
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran));
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik));
                $model = $model->find($criteria);
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
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
                if (!empty($model->pendaftaran_id)) {
                    $crit_uangmuka->addCondition("pendaftaran_id = " . $model->pendaftaran_id);
                }
                if (!empty($model->pasienadmisi_id)) {
                    $crit_uangmuka->addCondition("pasienadmisi_id = " . $model->pasienadmisi_id);
                }
                $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
                $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
                $returnVal["notif"] = $notif;
            }

            $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
            $returnVal['jumlah_tindakan'] = TindakanpelayananT::model()->countByAttributes(array(
                'pendaftaran_id' => $model->pendaftaran_id,
            ), array(
                'condition' => 'tindakansudahbayar_id is null',
            ));
            $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

            $attributes = $model->attributeNames();

            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }


            $returnVal['kelastanggungan_id'] = null;
            $returnVal['kelastanggungan_nama'] = null;

            $returnVal['kelastanggungan_nilai'] = null;
            $returnVal['kelaspelayanan_nilai'] = Params::kelasPelayananNilai($model->kelaspelayanan_id);
            $returnVal['pasiennaikkelas'] = null;
            // cek naik kelas 

            if(!empty($asuransi) && !empty($pendaftaran->admisi)) {
                if($asuransi->kelastanggunganasuransi_id != $pendaftaran->admisi->kelaspelayanan_id) {
                    $returnVal['pasiennaikkelas'] = 1;
                }
            }
            if (!empty($asuransi)) {
                $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id;
                $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama;
                $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id);
                if (!empty($asuransi->nopeserta)) {
                    $bpjs = new BpjsVklaim;
                    /*
                    $dataPeserta = CJSON::decode($bpjs->search_kartu($asuransi->nopeserta));
                    if (!empty($dataPeserta['response'] && $dataPeserta['metaData']['code'] == 200)) {
                        // var_dump($dataPeserta);
                        $returnVal['kelas_hak_bpjs'] = $dataPeserta['response']['peserta']['hakKelas']['keterangan'];
                        $returnVal['kelas_hak_kode'] = $dataPeserta['response']['peserta']['hakKelas']['kode'];
                        $criteria_asuransi = new CDbCriteria();
                        $criteria_asuransi->compare('kelasbpjs_id', $returnVal['kelas_hak_kode']);
                        
                        // var_dump($returnVal['kelas_hak_bpjs'], $criteria_asuransi); die;
                        
                        
                        $kelas = KelaspelayananM::model()->find($criteria_asuransi);
                        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id ?? null;
                        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama ?? "";
                    } else {
                    */
                        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id ?? null;
                        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama ?? "";
                        $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id) ?? 0;
                    // }
                }
            }

            $carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
            $returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);


            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["notif"] = $notif;
            //load uang muka
            $crit_uangmuka = new CDbCriteria();
            if (!empty($model->pendaftaran_id)) {
                $crit_uangmuka->addCondition("pendaftaran_id = " . $model->pendaftaran_id);
            }
            if (!empty($model->pasienadmisi_id)) {
                $crit_uangmuka->addCondition("pasienadmisi_id = " . $model->pasienadmisi_id);
            }

            //perubahan pengambilan uang muka (RSN-1195)
            $modBayarUangMuka = BKBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array(
                'condition'=>'pembatalanuangmuka_id is null'
            ));
            if (!empty($modBayarUangMuka)) {
                if (!empty($modBayarUangMuka->pembatalanuangmuka_id) && empty($modBayarUangMuka->pembatalanuangmuka_id)) {
                    $returnVal["jumlahuangmuka"] = 0;
                } else if (empty($modBayarUangMuka->pembatalanuangmuka_id) && !empty($modBayarUangMuka->pemakaianuangmuka_id)) {
                    // $returnVal["jumlahuangmuka"] = (isset($modPemakaianUangMuka->sisauangmuka) ? $modPemakaianUangMuka->sisauangmuka : 0);
                    $total = 0;
                    foreach ($modBayarUangMuka as $i) {
                        $total += $i->jumlahuangmuka - $i->uangmukadipakai;
                    }
                    $returnVal["jumlahuangmuka"] = $total;
                } else {
                    $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
                    $crit_uangmuka->addCondition("pembatalanuangmuka_id IS NULL");
                    $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                    $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                    $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
                }
            }

            $returnVal['belumVerifBatalUangMuka'] = 0;
            foreach ($modBayarUangMuka as $item) {
                $orderBatal = OrderbataluangmukaT::model()->findByAttributes(array(
                    'bayaruangmuka_id'=>$item->bayaruangmuka_id
                ));
    
                if (
                    $returnVal['carabayar_id'] == Params::CARABAYAR_ID_BPJS
                    && !empty($returnVal['pasienadmisi_id'] 
                    && !empty($returnVal['kelastanggungan_id']) 
                    && $returnVal['kelastanggungan_id'] != Params::KELASPELAYANAN_ID_KELAS_III
                    && !empty($orderBatal))
                ) {
                    $returnVal['belumVerifBatalUangMuka'] = 1;
                }
            }

            // cek iurbiaya
            $returnVal['ada_iurbea'] = 1;
            $iurbea = null;


            if (!empty($returnVal['kelastanggungan_id']) & in_array($returnVal['kelastanggungan_id'], array(
                Params::KELASPELAYANAN_ID_KELAS_I,
                Params::KELASPELAYANAN_ID_KELAS_II,
            )) && $returnVal['carabayar_id'] == Params::CARABAYAR_ID_BPJS && !empty($returnVal['pasienadmisi_id'])) {
                $iurbea = IurbeaT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$model->pendaftaran_id,
                ), array(
                    'condition'=>'is_approvalbatal = false'
                ));
                $modBayarUangMuka = BKBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), array(
                    'condition'=>'pembatalanuangmuka_id is null and pemakaianuangmuka_id is null'
                ));

                $is_uangmuka_kosong = empty($modBayarUangMuka);
                $is_bea_kosong = empty($iurbea) && $returnVal['kelastanggungan_id'] != $returnVal['kelaspelayanan_id'];

                // if (!empty($iurbea)) {
                    
                    // if ($is_bea_kosong) { // && !$is_uangmuka_kosong) {
                    //     $returnVal['ada_iurbea'] = 0;
                    //     $returnVal['ada_iurbea_pesan'] = "Iur bea belum dilakukan perhitungan, silahkan hubungi unit terkait.";
                    // } else if (!$is_bea_kosong && $is_uangmuka_kosong) {
                    //     $returnVal['ada_iurbea'] = 0;
                    //     $returnVal['ada_iurbea_pesan'] = "Uang muka belum terverifikasi, silahkan hubungi unit terkait.";
                    // }

                // } else {
                if ($is_bea_kosong) {
                    $returnVal['ada_iurbea'] = 0;
                    $returnVal['ada_iurbea_pesan'] = "Iur Bea belum dilakukan perhitungan, silahkan hubungi unit terkait.";
                }
            }

            /*
            if (
                $returnVal['carabayar_id'] == Params::CARABAYAR_ID_BPJS
                && !empty($returnVal['kelastanggungan_id']) 
                && $returnVal['kelastanggungan_id'] != Params::KELASPELAYANAN_ID_KELAS_III
                && !empty($returnVal['pasienadmisi_id'])
            ) {
                $iurbea = IurbeaT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$returnVal['pendaftaran_id'],
                ), array(
                    'condition'=>'is_approvalbatal = false'
                ));

                if (empty($iurbea) && count($modBayarUangMuka) > 0) {
                    $returnVal['ada_iurbea'] = 0;
                }
            }
            */

            if (empty($iurbea)) {
                $iurbea = new IurbeaT;
            }
            $returnVal['iurbea'] = $iurbea->attributes;


            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }


    /**
     * verifikasi laboratorium
     * @param type $model
     * @return boolean
     */
    protected function cekVerifikasiLab($model)
    {
        $kirim = PasienkirimkeunitlainT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $model->pendaftaran_id,
            'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK
        ), array(
            'condition' => 'pasienmasukpenunjang_id is null',
        ));

        if (count((array)$kirim) > 0) {
            $this->kirimNotifPasienKirimKeUnitLainLab($model, $kirim);

            return true;
        }

        return false;
    }

    /**
     * verifikasi radiologi
     * @param type $model
     * @return boolean
     */
    protected function cekVerifikasiRad($model)
    {
        $kirim = PasienkirimkeunitlainT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $model->pendaftaran_id,
            'ruangan_id' => Params::RUANGAN_ID_RAD
        ), array(
            'condition' => 'pasienmasukpenunjang_id is null',
        ));

        if (count((array)$kirim) > 0) {
            $this->kirimNotifPasienKirimKeUnitLainRad($model, $kirim);

            return true;
        }

        return false;
    }

    /**
     * mengirimkan notifikasi ke farmasi apotek
     * @param type $model
     * @param type $reseptur
     */
    protected function breadcastNotifResepturPasien($model, $reseptur)
    {
        $judul = "Verifikasi Reseptur Rawat Inap";
        $msg = "Harap Reseptur dibawah ini di diselesaikan :<br/>";
        $noresep = array();
        foreach ($reseptur as $item) {
            $msg .= "- " . $item->noresep . '<br/>';
            $noresep[] = $item->noresep;
        }

        $link = $this->createUrl('/farmasiApotek/InformasiPasienResep/Index', array(
            'FAInformasiresepturV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'FAInformasiresepturV[tgl_akhir]' => date('Y-m-d'),
            'FAInformasiresepturV[no_pendaftaran]' => $model->no_pendaftaran,
            'FAInformasiresepturV[statusJual]' => 2,

        ));

        $cur = array(
            array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK, 'link_proses' => $link),
        );
    }

    /**
     * mengirim notifikasi ke unit radiologi
     * @param type $model
     * @param type $kirim
     * @return type
     */
    protected function kirimNotifPasienKirimKeUnitLainRad($model, $kirim)
    {
        $judul = "Verifikasi Pemeriksaan Rujukan ke Radiologi";
        $msg = $model->no_rekam_medik . " - " . $model->nama_pasien . "<br/>";
        $msg .= "Harap Rujukan Pemeriksaan dibawah ini di diselesaikan :<br/>";
        foreach ($kirim as $item) {
            $msg .= "- " . MyFormatter::formatDateTimeForUser($item->tgl_kirimpasien) . '<br/>';
        }


        $link = $this->createUrl('/radiologi/RujukanPenunjang/Index', array(
            'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d'),
            'PasienkirimkeunitlainV[no_pendaftaran]' => $model->no_pendaftaran,
        ));

        $cur = array(
            array('instalasi_id' => Params::INSTALASI_ID_RAD, 'ruangan_id' => Params::RUANGAN_ID_RAD, 'modul_id' => Params::MODUL_ID_RAD, 'link_proses' => $link),
        );

        // var_dump($modKunjungan->attributes); die;

        // var_dump($judul, $isi, $cur, $modKunjungan->attributes); die;

        return CustomFunction::broadcastNotif($judul, $msg, $cur);
    }

    /**
     * mengirimlan notifikasi ke unit laboratorium
     * @param type $model
     * @param type $kirim
     * @return type
     */
    protected function kirimNotifPasienKirimKeUnitLainLab($model, $kirim)
    {
        $judul = "Verifikasi Pemeriksaan Rujukan ke Laboratorium";
        $msg = $model->no_rekam_medik . " - " . $model->nama_pasien . "<br/>";
        $msg .= "Harap Rujukan Pemeriksaan dibawah ini di diselesaikan :<br/>";
        foreach ($kirim as $item) {
            $msg .= "- " . MyFormatter::formatDateTimeForUser($item->tgl_kirimpasien) . '<br/>';
        }


        $link = $this->createUrl('/laboratorium/rujukanPenunjang/Index', array(
            'LBPasienKirimKeUnitLainV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'LBPasienKirimKeUnitLainV[tgl_akhir]' => date('Y-m-d'),
            'LBPasienKirimKeUnitLainV[prefix_pendaftaran]' => '',
            'LBPasienKirimKeUnitLainV[no_pendaftaran]' => substr($model->no_pendaftaran, -10),
        ));

        $cur = array(
            array('instalasi_id' => Params::INSTALASI_ID_LAB, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK, 'modul_id' => Params::MODUL_ID_LAB, 'link_proses' => $link),
        );

        // var_dump($modKunjungan->attributes); die;

        // var_dump($judul, $isi, $cur, $modKunjungan->attributes); die;

        return CustomFunction::broadcastNotif($judul, $msg, $cur);
    }

    /**
     * menampilkan form rincian tagihan tindakan
     */
    public function actionSetRincianTindakan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $pembayaranpelayanan_id = (isset($_POST['pembayaranpelayanan_id']) ? $_POST['pembayaranpelayanan_id'] : null);
            $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);

            $modPendaftaran = new PendaftaranT;
            $modAsuransiPasien = new AsuransipasienM;
            $modTanggungan = new TanggunganpenjaminM;
            $form = '';
            if (!empty($pendaftaran_id)) {
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
                    $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'penjamin_id' => $penjamin_id));
                } else if (isset($modPendaftaran->asuransipasien_id)) {
                    $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                    if (isset($modAsuransiPasien->kelastanggunganasuransi_id) && !empty($penjamin_id)) {
                        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasien->kelastanggunganasuransi_id, 'penjamin_id' => $penjamin_id));
                    } else {
                        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasien->kelastanggunganasuransi_id));
                    }
                }
            }
            $dataTindakans = array();
            $cekdata = false;

            if (!empty($pembayaranpelayanan_id)) {
                $modTindakansudah = TindakansudahbayarT::model()->findAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
                if (!empty($modTindakansudah)) {
                    foreach ($modTindakansudah as $tdsudah) {
                        $tindakanpel = BKTindakanPelayananT::model()->findByAttributes(array('tindakanpelayanan_id' => $tdsudah->tindakanpelayanan_id));

                        if (!empty($tindakanpel)) {
                            $dataTindakans[] = $tindakanpel;
                        }
                    }
                }
            } else {
                if (!empty($pendaftaran_id) && $cekdata == false) {
                    $criteria = new CdbCriteria();
                    $criteria->join = "join verifikasitagihan_t v on v.verifikasitagihan_id = t.verifikasitagihan_id";

                    if ($instalasi_id == Params::INSTALASI_ID_RI) {
                        $criteria->addCondition('v.pasienadmisi_id is not null');
                    } else {
                        $criteria->addCondition('v.pasienadmisi_id is null');
                    }

                    $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
                    $criteria->addCondition("t.verifrenctindakan_id IS NOT NULL");
                    $criteria->addCondition("t.alokasidanadetailtindakan_id IS NULL");
                    $criteria->order = "ruangan_id, tgl_tindakan";
                    $dataTindakans = BKTindakanPelayananT::model()->findAll($criteria);
                    // $dataTindakans =
                }
            }


            $form = $this->renderPartial($this->path_view . '_formRincianTindakan', array('modPendaftaran' => $modPendaftaran, 'dataTindakans' => $dataTindakans, 'modTanggungan' => $modTanggungan, 'penjamin_id' => $penjamin_id), true);
            $data['form'] = $form;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * menampilkan form rincian tagihan obat alkes
     */
    public function actionSetRincianObatalkes()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $instalasi_id = (isset($_POST['penjamin_id']) ? $_POST['instalasi_id'] : null);
            $form = '';
            $modPendaftaran = new PendaftaranT;
            $modTanggungan = null;
            $biaya_embalase = 0;
            if (!empty($pendaftaran_id)) {
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
                    $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'penjamin_id' => $penjamin_id));
                } else if (isset($modPendaftaran->asuransipasien_id)) {
                    $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                    if (isset($modAsuransiPasien->kelastanggunganasuransi_id) && isset($penjamin_id)) {
                        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasien->kelastanggunganasuransi_id, 'penjamin_id' => $penjamin_id));
                    }
                }
            }
            $dataOas = array();
            $penjualanresep_id = array();
            if (!empty($pendaftaran_id)) {
                $criteria = new CdbCriteria();
                $criteria->select = "t.*";
                $criteria->join = "join verifikasitagihan_t v on v.verifikasitagihan_id = t.verifikasitagihan_id";

                if ($instalasi_id == Params::INSTALASI_ID_RI) {
                    $criteria->addCondition('v.pasienadmisi_id is not null');
                } else {
                    $criteria->addCondition('v.pasienadmisi_id is null');
                }
                $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
                //                ADA BEBERAPA TINDAKAN YG TIDAK TERBAYAR >> RND-3592
                //                TINDAKAN SELAIN ADMISI JUGA BOLEH DI BAYARKAN DISINI
                //                if(!empty($pasienadmisi_id)){
                //                    $criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);
                //                }else{
                //                    $criteria->addCondition("pasienadmisi_id IS NULL");
                //                }

                if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                    $criteria->addCondition('t.verifikasitagihan_id is not null');
                }
                $criteria->addCondition("t.oasudahbayar_id IS NULL and t.qty_oa > 0");
                $criteria->addCondition("t.alokasidanadetailoa_id IS NULL");

                $criteria->order = "t.tglpelayanan";
                $dataOas = BKObatalkesPasienT::model()->findAll($criteria);
            }

            if (!empty($dataOas)) {
                foreach ($dataOas as $key => $det) {
                    $penjualanresep_id[] = $det['penjualanresep_id'];
                }
            }

            if (!empty($penjualanresep_id)) {
                $crit = new CdbCriteria();
                $crit->select = "t.*";
                $crit->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
                $crit->addInCondition("t.penjualanresep_id", $penjualanresep_id);
                $modPenjualan = PenjualanresepT::model()->findAll($crit);
                if (!empty($modPenjualan)) {
                    foreach ($modPenjualan as $key => $det) {
                        if ($det->jasaembalase != 0) {
                            $biaya_embalase += $det->jasaembalase;
                        }
                    }
                }
            }

            $data['jasaembalase'] = $biaya_embalase;

            $form = $this->renderPartial($this->path_view . '_formRincianObatalkes', array('modPendaftaran' => $modPendaftaran, 'modTanggungan' => $modTanggungan, 'dataOas' => $dataOas, 'penjamin_id' => $penjamin_id), true);
            $data['form'] = $form;
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
    public function actionPrintRincianBelumBayar($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
        // var_dump($modRincians);die;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $nopembayaran = '';
        $noasuransi = '';
        $nama_perusahaan = '';
        $penjamin_nama = '';
        // $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
        // $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($modPendaftaran->pembayaranpelayanan_id);
        $modBayarUangMuka = BKBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('condition' => 'pembatalanuangmuka_id is null'));
        // if(!empty($modPembayaran->tandabuktibayar_id)){
        // $modUangMuka = BayaruangmukaT::model()->findAllByAttributes(['pasien_id'=> $modPembayaran->pasien_id]);
        // var_dump($modUangMuka);die;
        // }else{
        //     $modUangMuka = new BayaruangmukaT();
        // }

        // var_dump($modUangMuka->jumlahuangmuka);die;
        if (count((array)$modPembayaran) > 0) {
            foreach ($modPembayaran as $mod => $items) {
                $nopembayaran = $items->nopembayaran;
            }
        }

        // // var_dump($modPenanggungjawab);die;


        if (count((array)$modRincians) > 0) {
            foreach ($modRincians as $mod => $items) {
                $nama_perusahaan = $items->namaperusahaan;
                $noasuransi = $items->no_asuransi;
                $subsidiasuransi_tindakan = isset($items->subsidiasuransi_tindakan) ? $items->subsidiasuransi_tindakan : "";
                $penjamin_nama = $items->penjamin_nama;
            }
        }
        // var_dump($modPembayaran);die;
        /*
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
			$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_ICU){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $criteria->order = 'tgl_tindakan';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }
         *
         */

        $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);
        $this->render($this->path_view . 'printRincianBelumBayarV3', array('penjamin_nama' => $penjamin_nama, 'modPenanggungjawab' => $modPenanggungjawab, 'subsidiasuransi_tindakan' => $subsidiasuransi_tindakan, 'noasuransi' => $noasuransi, 'nama_perusahaan' => $nama_perusahaan, 'nopembayaran' => $nopembayaran, 'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modInstalasi' => $modInstalasi, 'modPembayaran' => $modPembayaran, 'modBayarUangMuka' => $modBayarUangMuka));
    }




    public function actionPrintRincianBelumBayarRD($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
        // var_dump($modRincians);die;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $nopembayaran = '';
        $noasuransi = '';
        $nama_perusahaan = '';
        $penjamin_nama = '';
        $subsidiasuransi_tindakan = '';
        // $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
        // $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($modPendaftaran->pembayaranpelayanan_id);
        $modBayarUangMuka = BKBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('condition' => 'pembatalanuangmuka_id is null'));
        // if(!empty($modPembayaran->tandabuktibayar_id)){
        // $modUangMuka = BayaruangmukaT::model()->findAllByAttributes(['pasien_id'=> $modPembayaran->pasien_id]);
        // var_dump($modUangMuka);die;
        // }else{
        //     $modUangMuka = new BayaruangmukaT();
        // }

        // var_dump($modUangMuka->jumlahuangmuka);die;
        if (count((array)$modPembayaran) > 0) {
            foreach ($modPembayaran as $mod => $items) {
                $nopembayaran = $items->nopembayaran;
            }
        }

        // echo ''; var_dump($modRincians); die;


        // // var_dump($modPenanggungjawab);die;


        if (count((array)$modRincians) > 0) {
            foreach ($modRincians as $mod => $items) {
                $nama_perusahaan = $items->namaperusahaan;
                $noasuransi = $items->no_asuransi;
                $subsidiasuransi_tindakan = isset($items->subsidiasuransi_tindakan) ? $items->subsidiasuransi_tindakan : "";
                $penjamin_nama = $items->penjamin_nama;
            }
        }
        // var_dump($modPembayaran);die;
        /*
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
			$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_ICU){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $criteria->order = 'tgl_tindakan';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }
         *
         */


        $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);
        $this->render($this->path_view . 'printRincianBelumBayarV3', array('penjamin_nama' => $penjamin_nama, 'modPenanggungjawab' => $modPenanggungjawab, 'subsidiasuransi_tindakan' => $subsidiasuransi_tindakan, 'noasuransi' => $noasuransi, 'nama_perusahaan' => $nama_perusahaan, 'nopembayaran' => $nopembayaran, 'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modInstalasi' => $modInstalasi, 'modPembayaran' => $modPembayaran, 'modBayarUangMuka' => $modBayarUangMuka));
    }

    public function actionPrintRincianBelumBayarRI($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';

        $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);
        $this->render($this->path_view . 'printRincianBelumBayarRI', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modInstalasi' => $modInstalasi));
    }

    /**
     * actionPrintRincianBelumBayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintRincianBelumBayarGrup($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';

        $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        /*
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
			$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_ICU){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $criteria->order = 'tgl_tindakan';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }
         *
         */

        $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);
        $this->render($this->path_view . 'printRincianBelumBayarBaru', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modInstalasi' => $modInstalasi));
    }


    /**
     * actionPrintDetailRincianBelumBayar
     * @params $instalasi_id = RJ / RD / RI
     * @params $pendaftaran_id
     * @params $pasienadmisi_id (RI saja)
     */
    public function actionPrintDetailRincianBelumBayar($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        if ($instalasi_id == Params::INSTALASI_ID_RJ) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
        } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        } else if (in_array($instalasi_id, Params::grupInstalasiRIID())) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
        }
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $this->render($this->path_view . 'printDetailRincianBelumBayar', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran));
    }

    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * NOTE : RINCIAN TAMPILAN BARU
     * @params $instalasi_id = RJ / RD / RI
     * @params $pembayaran_id
     */
    public function actionPrintRincianSudahBayar($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, daftartindakan_nama';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);

        $view_sudahbayar = 'printRincianSudahBayarGrup';

        if ($modPendaftaran->penjamin_id != Params::PENJAMIN_ID_UMUM) {
            $view_sudahbayar = 'printRincianSudahBayarGrup';
        }

        $caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : '';
        if ($caraPrint == 'EXCEL') {
            $this->render($this->path_view . $view_sudahbayar . 'Excel', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran));
        } else {
            $this->render($this->path_view . $view_sudahbayar, array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran));
        }
    }
    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * NOTE : RINCIAN TAMPILAN BARU
     * @params $pembayaranpelayanan_id
     */
    public function actionPrintRincianSudahBayarFarmasi($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $criteria->addCondition('is_alkes = true');
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);

        $modPenjualan = PenjualanresepT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $modPembayaran->pendaftaran_id,
        ), array(
            'order' => 'tglpenjualan asc',
        ));

        $view_sudahbayar = 'printRincianSudahBayarFarmasi';

        if ($modPendaftaran->penjamin_id != Params::PENJAMIN_ID_UMUM) {
            $view_sudahbayar = 'printRincianSudahBayarFarmasi';
        }

        $caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : '';
        if ($caraPrint == 'EXCEL') {
            $this->render($this->path_view . $view_sudahbayar . 'Excel', array('modPenjualan' => $modPenjualan, 'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran));
        } else {
            $this->render($this->path_view . $view_sudahbayar, array('modPenjualan' => $modPenjualan, 'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran));
        }
    }
    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * NOTE : RINCIAN TAMPILAN LAMA
     * @params $pembayaranpelayanan_id
     */
    public function actionPrintRincianSudahBayar2($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        // var_dump($modPembayaran);die;
        $jenispembayaran = JenispembayaranT::model()->findByPk($modPembayaran->tandabuktibayar_id);
        // var_dump($jenispembayaran);die;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        foreach ($modRincians as $i) {
            $modTindakan = TindakanpelayananT::model()->findByPk($i->tindakanpelayanan_id);
            // echo '<pre>';
            // var_dump($modTindakan);die;
        }
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        // var_dump($modPenanggungjawab);die;
        $noasuransi = '';
        $penanggung = '';
        $subsidiasuransi_tindakan = '';
        $penjamin = PenjaminpasienM::model()->findByPk($modPembayaran->penjamin_id);
        $petugas = InformasipasiensudahbayarV::model()->findByAttributes(array('pendaftaran_id' => $modPembayaran->pendaftaran_id));
        $tindakan = TandabuktibayarT::model()->findByAttributes(['pembayaranpelayanan_id' => $pembayaranpelayanan_id]);
        // if(!empty($modPembayaran->tandabuktibayar_id)){
        //     $modUangMuka = BayaruangmukaT::model()->findAllByAttributes(['tandabuktibayar_id'=> $modPembayaran->tandabuktibayar_id]);
        //     foreach($modUangMuka as $modUangMuka){

        //     }
        // }else{
        //     $modUangMuka = new BayaruangmukaT();
        //     foreach($modUangMuka as $modUangMuka){

        //     }
        // }
        // var_dump($tindakan);die;
        // var_dump($petugas);die;
        $carabayar = CarabayarM::model()->findAllByPk($modPembayaran->carabayar_id);
        // var_dump($carabayar);die;
        // var_dump($modRincians[0]->namaperusahaan);die;
        if (count((array)$modRincians) > 0) {
            foreach ($modRincians as $mod => $items) {
                $noasuransi = $items->no_asuransi;
                $penanggung = $items->namapemilik_asuransi;
                $subsidiasuransi_tindakan = $items->subsidiasuransi_tindakan;
                $penjamin_nama = $items->penjamin_nama;
            }
        }
        $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
        // var_dump($modAsuransi);die;

        $caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : '';
        if ($caraPrint == 'EXCEL') {
            $this->render($this->path_view . 'printRincianSudahBayarExcel', array('modAsuransi' => $modAsuransi, 'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran, 'subsidiasuransi_tindakan' => $subsidiasuransi_tindakan, 'noasuransi' => $noasuransi, 'penanggung' => $penanggung));
        } else {
            $this->render($this->path_view . 'printRincianSudahBayarV2', array('petugas' => $petugas, 'modAsuransi' => $modAsuransi, 'penjamin' => $penjamin, 'penjamin_nama' => $penjamin_nama, 'modPenanggungjawab' => $modPenanggungjawab, 'subsidiasuransi_tindakan' => $subsidiasuransi_tindakan, 'noasuransi' => $noasuransi, 'penanggung' => $penanggung, 'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran, 'tindakan' => $tindakan, 'modTindakan' => $modTindakan));
        }
    }

    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * NOTE : RINCIAN TAMPILAN LAMA
     * @params $pembayaranpelayanan_id
     */
    public function actionPrintRincianSudahBayarKwitansi($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        // var_dump($modPembayaran);die;
        $jenispembayaran = JenispembayaranT::model()->findByPk($modPembayaran->tandabuktibayar_id);
        // var_dump($jenispembayaran);die;
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        foreach ($modRincians as $i) {
            $modTindakan = TindakanpelayananT::model()->findByPk($i->tindakanpelayanan_id);
            // echo '<pre>';
            // var_dump($modTindakan);die;
        }
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        // var_dump($modPenanggungjawab);die;
        $noasuransi = '';
        $penanggung = '';
        $subsidiasuransi_tindakan = '';
        $penjamin = PenjaminpasienM::model()->findByPk($modPembayaran->penjamin_id);
        $petugas = InformasipasiensudahbayarV::model()->findByAttributes(array('pendaftaran_id' => $modPembayaran->pendaftaran_id));
        $tindakan = TandabuktibayarT::model()->findByAttributes(['pembayaranpelayanan_id' => $pembayaranpelayanan_id]);
    
        $carabayar = CarabayarM::model()->findAllByPk($modPembayaran->carabayar_id);
        // var_dump($carabayar);die;
        // var_dump($modRincians[0]->namaperusahaan);die;
        if (count((array)$modRincians) > 0) {
            foreach ($modRincians as $mod => $items) {
                $noasuransi = $items->no_asuransi;
                $penanggung = $items->namapemilik_asuransi;
                $subsidiasuransi_tindakan = $items->subsidiasuransi_tindakan;
                $penjamin_nama = $items->penjamin_nama;
            }
        }
        $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);

        $this->render($this->path_view . 'printKuitansiKarcisInvoice', array('modAsuransi' => $modAsuransi, 'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran, 'subsidiasuransi_tindakan' => $subsidiasuransi_tindakan, 'noasuransi' => $noasuransi, 'penanggung' => $penanggung));

    }

    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * NOTE : RINCIAN TAMPILAN GRUP
     * @params $pembayaranpelayanan_id
     */
    public function actionPrintRincianSudahBayarGrup($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        $this->render($this->path_view . 'printRincianSudahBayarGrup', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran));
    }
    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * @params $pembayaranpelayanan_id
     */
    public function actionPrintRincianRSSudahBayar($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        $this->render($this->path_view . 'printRincianRSSudahBayar', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran));
    }

    /**
     * actionPrintRincianSudahBayar = menampilkan rincian yang sudah lunas /bayar
     * @params $pembayaranpelayanan_id
     */
    public function actionPrintRincianRSSudahBayar2($pembayaranpelayanan_id)
    {
        $this->layout = '//layouts/printWindows';
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $modRincians = null;
        $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
        $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
        $this->render($this->path_view . 'printRincianRSSudahBayar', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran));
    }

    /**
     * method untuk print kwitansi
     * @param int $pembayaranpelayanan_id pembayaranpelayanan_id
     */
    public function actionPrintKuitansi($pembayaranpelayanan_id)
    {
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        $judulKuitansi = '----- KUITANSI -----';
        $format = new MyFormatter();
        $modBayar = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
        $criteria = new CdbCriteria();
        $criteria->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
        $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria);
        if (!empty($modBayar->pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
            $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
        } else {
            $modPendaftaran = new PendaftaranT;
        }
        $rincianpembayaran = array();
        $tindakan = array();
        $harga = 0;
        $discount = 0;
        $totalsemua = 0;
        if (count((array)$tindakanSudahBayar) > 0) {
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
        $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
        $oa = array();
        if (count((array)$oaSudahBayar) > 0) {
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

        if ($modTandaBukti->jmlpembayaran == 0 && $modBayar->carabayar_id != 2) { //jika jmlpembayaran nol
            $modTandaBukti->jmlpembayaran = $totalsemua;
        }

        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint) {

            if ($caraPrint == 'PRINT') {
                $this->layout = '//layouts/printWindows';
                $this->render($this->path_view . 'printKuitansi', array(
                    'modPendaftaran' => $modPendaftaran, 'judulKuitansi' => $judulKuitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
                    'modTandaBukti' => $modTandaBukti, 'tindakanSudahBayar' => $tindakanSudahBayar,
                    'modBayar' => $modBayar
                ));
                //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            } else if ($caraPrint == 'EXCEL') {
                $this->layout = '//layouts/printExcel';
                $this->render($this->path_view . 'printKuitansi', array(
                    'modPendaftaran' => $modPendaftaran, 'judulKuitansi' => $judulKuitansi, 'caraPrint' => $caraPrint, 'rincianpembayaran' => $rincianpembayaran,
                    'modTandaBukti' => $modTandaBukti, 'tindakanSudahBayar' => $tindakanSudahBayar,
                    'modBayar' => $modBayar
                ));
            } else if ($caraPrint == 'PDF') {
                //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                //$mpdf = new MyPDF60('',$ukuranKertasPDF);
                //$mpdf = new MyPDF60('','B5-L');
                $mpdf = new MyPDF60('', '', '15', '', 15, 15, 16, 16, 9, 9, 'B5');
                //$mpdf->useOddEven = 2;
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet, 1);
                /*
                    * cara ambil margin
                    * tinggi_header * 72 / (72/25.4)
                    *  tinggi_header = inchi
                    */

                /*font-family: tahoma;*/
                // $header = 0.50 * 72 / (72/25.4);
                $header = 0.3 * 72 / (72 / 25.4);
                $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
                $mpdf->WriteHTML(
                    $this->renderPartial(
                        $this->path_view . 'printKuitansiPdf',
                        array(
                            'modPendaftaran' => $modPendaftaran,
                            'judulKuitansi' => $judulKuitansi,
                            'caraPrint' => $caraPrint,
                            'rincianpembayaran' => $rincianpembayaran,
                            'modTandaBukti' => $modTandaBukti,
                            'modBayar' => $modBayar,
                            'rincianpembayaran' => $rincianpembayaran
                        ),
                        true
                    )
                );
                $mpdf->Output();
            }
        } else {

            $this->render($this->path_view . 'printKuitansi', array(
                // 'model'=>$model,
                // 'pembayarans'=>$pembayarans,
                'modPendaftaran' => $modPendaftaran,
                'judulKuitansi' => $judulKuitansi,
                'caraPrint' => $caraPrint,
                'rincianpembayaran' => $rincianpembayaran,
                'modTandaBukti' => $modTandaBukti,
                'modBayar' => $modBayar
            ));
        }
    }

    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     *
     * Mengabil input Tanggungan Asuransi.
     * Pertama2, diperiksa dulu apakan Pasien BPJS Rawat Inap atau Tidak.
     * Jika tidak, maka menggunakan Input "Total Tanggungan Asuransi" dan input-nya
     * readonly.
     * Jika iya, maka akan ditampilkan Input INA berdasarkan Kelas Pelayanan dan
     * Kelas Tanggungan dengan
     */
    public function actionSetKelasAsuransi()
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();

        $pendaftaran_id = $_POST['pendaftaran_id'];
        $carabayar_id = $_POST['carabayar_id'];
        $penjamin_id = $_POST['penjamin_id'];

        $labelIncbgTot = "INACBG";
        $row = "";

        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);


        if ($carabayar_id == Params::CARABAYAR_ID_BPJS) {

            if (!empty($pendaftaran->pasienadmisi_id)) {

                $pkelaspelayanan_id = null;
                $pkelastanggungan_id = null;
                $bpjs_row = "";


                $admisi = BKInformasikasirinappulangV::model()->findByAttributes(array(
                    'pendaftaran_id' => $pendaftaran_id,
                ));

                $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

                $pkelaspelayanan_id = $admisi->kelaspelayanan_id;

                if (!empty($asuransi)) {
                    $pkelastanggungan_id = $asuransi->kelastanggunganasuransi_id;

                    // asumsi-nya pasien hanya pindah pada 2 kelas
                    $masuk = MasukkamarT::model()->findByAttributes(array(
                        'pasienadmisi_id' => $pendaftaran->pasienadmisi_id,
                    ), array(
                        'condition' => "kelaspelayanan_id <> " . $pkelastanggungan_id,
                        'order' => 'masukkamar_id',
                    ));

                    if (!empty($masuk)) {
                        $pkelaspelayanan_id = $masuk->kelaspelayanan_id;
                    }
                }


                if (!empty($pkelaspelayanan_id) && !empty($pkelastanggungan_id)) {
                    $kelas_pelayanan = KelaspelayananM::model()->findByPk($pkelaspelayanan_id);
                    $kelas_tanggungan = KelaspelayananM::model()->findByPk($pkelastanggungan_id);

                    //var_dump($kelas_pelayanan->urutankelas, $kelas_tanggungan->urutankelas); die;

                    if (Params::kelasPelayananNilai($pkelaspelayanan_id) > Params::kelasPelayananNilai($pkelastanggungan_id)) {
                        $row .= $this->renderPartial($this->path_view . '_formRincianTotalInacbg', array(
                            'readonly' => false,
                            'kelas_tanggungan' => $kelas_tanggungan
                        ), true);

                        $row .= $this->renderPartial($this->path_view . '_formRincianAsuransiINACBG', array(
                            'kelaspelayanan' => $kelas_pelayanan,
                            'carabayar_id' => $carabayar_id,
                            'idx' => 1,
                            'readonly' => false,
                        ), true);
                        $labelIncbgTot = (isset($kelas_tanggungan) && !empty($kelas_tanggungan->kelaspelayanan_id) ? "INA " . $kelas_tanggungan->kelaspelayanan_nama : "INACBG");
                    }
                }
            } else {
                $row .= $this->renderPartial($this->path_view . '_formRincianTotalInacbg', array(
                    'readonly' => false,
                ), true);
            }
        } else if ($carabayar_id == Params::CARABAYAR_ID_ASURANSI) {
            $row .= $this->renderPartial($this->path_view . '_formRincianAsuransi', array(
                'readonly' => false,
            ), true);
        } else {
            $row .= $this->renderPartial($this->path_view . '_formRincianAsuransi', array(
                'readonly' => true,
            ), true);
        }

        echo CJSON::encode(array('row' => $row, 'carabayar_id' => $carabayar_id, 'labelIncbgTot' => $labelIncbgTot));
    }

    /**
     * menampilkan form antrian dari request ajax
     * @param type $record
     * @param type $noantrian
     * @throws CHttpException
     */
    public function actionSetFormAntrian()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $record = (isset($_POST['record']) ? $_POST['record'] : "");
            $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
            $antrian_id = (isset($_POST['antrian_id']) ? $_POST['antrian_id'] : "");
            $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);


            $last = AntrianT::model()->findByAttributes(array(
                'modelantrian_id' => $loket_id,
            ), array(
                'condition' => 'pendaftaran_id is not null',
                'order' => 'antrian_id desc',
            ));

            if (empty($antrian_id)) { //antrian baru
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                $criteria->addCondition("pendaftaran_id IS NULL");
                // $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
                $criteria->compare('modelantrian_id', $loket_id);
                if (!empty($last)) {
                    $criteria->addCondition('antrian_id > ' . $last->antrian_id);
                }
                if ($record == "reset") {
                    $criteria->addCondition("panggil_flaq = false");
                }
                $criteria->order = "noantrian ASC";
                $criteria->limit = 1;
                $modAntrian =  BKAntrianT::model()->find($criteria);
            } else {
                $criteria = new CDbCriteria();
                $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                // $criteria->addCondition("ruangan_id =". Yii::app()->user->getState('ruangan_id'));
                if (!empty($antrian_id)) {
                    $criteria->addCondition("antrian_id = " . $antrian_id);
                }
                $cari =  BKAntrianT::model()->find($criteria);
                if ($record == 'next') {
                    $modAntrian = $cari->AntrianBerikut;
                } else if ($record == 'prev') {
                    $modAntrian = $cari->AntrianSebelum;
                } else {
                    $modAntrian = $cari;
                }
            }

            if (!isset($modAntrian)) {
                $modAntrian = new BKAntrianT;
                $data['pesan'] = "Antrian Habis !";
            }
            $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
            $modAntrian->modelantrian_id = $loket_id;
            $data['form_antrian'] = $this->renderPartial($this->path_view . '_formPanggilAntrian', array('modAntrian' => $modAntrian), true);
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * action ketika tombol panggil di klik
     * @param type $antrian_id
     * @param type $loket_id
     * @param type $ket
     * @throws CHttpException
     */
    public function actionPanggil($antrian_id, $loket_id, $ket = null)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $modAntrian =  BKAntrianT::model()->findByPk($antrian_id);
            if (isset($modAntrian)) {
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
                if ($modAntrian->update()) {
                    $data['pesan'] = "No. antrian " . $modAntrian->noantrian . " dipanggil !";
                }
                // }
            }
            $attributes = $modAntrian->attributeNames();
            foreach ($attributes as $i => $attribute) {
                $data["$attribute"] = $modAntrian->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * cek tanggungan pasien
     * @param type $tindakan
     * @return int
     */
    function periksaTanggunganPasien($tindakan)
    {
        $isAdmisiKosong = empty($tindakan->pendaftaran->pasienadmisi_id);
        $isKarcisKosong = empty($tindakan->karcis_id);
        if (Params::SUBSIDI_RS_UNTUK_RD) {
            if ($tindakan->pendaftaran->instalasi_id == Params::INSTALASI_ID_RD && $isAdmisiKosong && $isKarcisKosong) {
                return ($tindakan->qty_tindakan * $tindakan->tarif_satuan) - ($tindakan->subsidiasuransi_tindakan + $tindakan->subsidipemerintah_tindakan);
            }
        }
        return 0;
    }

    /**
     * periksa tanggungan oa pasien
     * @param type $oa
     * @return int
     */
    function periksaTanggunganOAPasien($oa)
    {
        $isAdmisiKosong = empty($oa->pendaftaran->pasienadmisi_id);
        if (Params::SUBSIDI_RS_UNTUK_RD) {
            if ($oa->pendaftaran->instalasi_id == Params::INSTALASI_ID_RD && $isAdmisiKosong) {
                return ($oa->qty_oa * $oa->hargasatuan_oa) - ($oa->subsidiasuransi + $oa->subsidipemerintah);
            }
        }
        return 0;
    }


    public function actionSetDropdownLoket()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id_nama_loket = $_POST["idModelantrian"];
            $data = array();
            $data['diLoket_antrian'] = '';
            if (empty($id_nama_loket)) {
                $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', array(), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;'));
            } else {
                $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', CHtml::listData(LoketM::model()->findAllByAttributes(array('modelantrian_id' => $id_nama_loket, 'iskasir' => TRUE, 'loket_aktif' => TRUE), array('order' => 'loket_nama ASC')), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;', 'onchange' => 'setFormAntrian("reset");'));
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }


    public function actionGetCaraPembayaranLookup()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $carapembayaran = $_POST["carapembayaran"];
            $carabayar = "";
            $modMaster = LookupM::model()->findByAttributes(array('lookup_type' => 'carapembayaran', 'lookup_value' => $carapembayaran));
            if (isset($modMaster)) {
                $carabayar = $modMaster->lookup_name;
            }
            $data['value'] = $carabayar;
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    public function actionListBayarBank()
    {
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
                'jnspembayar_id' => $_POST['id'],
                'bank_id' => $item->bank_id,
                'debitkredit' => 'D',
            ), array(
                'order' => 'jnspembrek_id asc'
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

            $bank_list .= '<option value="' . $item->bank_id . '" data-rekening="' . $rek5->kdrekening5 . ' - ' . $rek5->nmrekening5 . '">' . $data_bank->bankNoRekening . '</option>';
        }

        echo CJSON::encode(array(
            'list' => $bank_list,
        ));
    }

    public function actionSetMultiPenjamin()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pendaftaran_id = (!empty($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $naikkelas = (!empty($_POST['naikkelas']) ? $_POST['naikkelas'] : null);
            $form = '';
            $data['ismembayar'] = false;
            $modPiutangAsuransi = new BKPiutangasuransiT();
            $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
            // if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
                $data['ismembayar'] = true;
            // }

            $modPiutangAsuransi->carabayar_id = $modPendaftaran->carabayar_id;
            $modPiutangAsuransi->penjamin_id = $modPendaftaran->penjamin_id;
            if($naikkelas == 1) {
                $modPiutangAsuransi->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
                $modPiutangAsuransi->penjamin_id = Params::PENJAMIN_ID_UMUM;
            }
            $form = $this->renderPartial($this->path_view . '_rowsMultiPenjaminDana', array('modPiutangAsuransi' => $modPiutangAsuransi, 'firstRow' => true, 'naikkelas'=>$naikkelas), true);
            $data['form'] = $form;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionSetDropdownPenjamin()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PenjaminpasienM;
            $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($_POST['carabayar_id'])) {
                $carabayar_id = $_POST['carabayar_id'];
                $data = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
                $data = CHtml::listData($data, 'penjamin_id', 'penjamin_nama');
                foreach ($data as $value => $name) {
                    $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
            $dataList['listPenjamin'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function actionSetDropDownPenjaminOnList()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PenjaminpasienM;
            $arr_penjamin_id = $_POST['arr_penjamin_id'];
            $penjamin_id = $_POST['penjamin_id'];
            $data = array();
            $option = '';
            $data = $this->getPenjaminById($arr_penjamin_id);
            $data = CHtml::listData($data, 'penjamin_id', 'penjamin_nama');
            foreach ($data as $value => $name) {
                $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            $dataList['listPenjamin'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function getPenjaminById($arr_penjamin_id)
    {
        $criteria = new CdbCriteria();
        $criteria->addInCondition('penjamin_id', $arr_penjamin_id);

        return PenjaminpasienM::model()->findAll($criteria);
    }

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
        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
        $penjamin = PenjaminpasienM::model()->findByPk($modPembayaran->penjamin_id);
        $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
        $namaFile = $modPendaftaran->pasien->no_rekam_medik . " K " . date("dmY", strtotime($modPendaftaran->tgl_pendaftaran));
        $noasuransi = '';
        $penanggung = '';
        if (count((array)$modRincians) > 0) {
            foreach ($modRincians as $mod => $items) {
                $noasuransi = $items->no_asuransi;
                $penanggung = $items->namapemilik_asuransi;
                $subsidiasuransi_tindakan = $items->subsidiasuransi_tindakan;
                $penjamin_nama = $items->penjamin_nama;
            }
        }
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
                                'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran,  'noasuransi' => $noasuransi, 'penjamin' => $penjamin, 'modAsuransi' => $modAsuransi, 'tandabukti' => $tandabukti
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
                        $modPenanggungjawab = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
                        $penjamin = PenjaminpasienM::model()->findByPk($modPembayaran->penjamin_id);
                        $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
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
                                $this->path_view_apotek . 'fakturPembayaranApotekPDF',
                                array(
                                    'modPenjualan' => $modPenjualan, 'daftar' => $daftar, 'pasien' => $pasien, 'modPegawaiDokter' => $modPegawaiDokter, 'modInstalasi' => $modInstalasi, 'obatAlkes' => $obatAlkes, 'tandabukti' => $tandabukti, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'loadData' => $loadData, 'modPenanggungjawab' => $modPenanggungjawab, 'penjamin' => $penjamin, 'modAsuransi' => $modAsuransi
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
                                $this->path_view . 'printRincianSudahBayar_new',
                                array(
                                    'modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modPembayaran' => $modPembayaran, 'modPenanggungjawab' => $modPenanggungjawab, 'noasuransi' => $noasuransi, 'penjamin' => $penjamin, 'modAsuransi' => $modAsuransi, 'tandabukti' => $tandabukti
                                ),
                                true
                            )
                        );
                    }
                }
            }
        }

        $mpdf->Output($namaFile . '.pdf', 'I');
    }
}
