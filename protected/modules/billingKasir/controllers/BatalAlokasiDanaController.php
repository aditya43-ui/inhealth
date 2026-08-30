<?php


class BatalAlokasiDanaController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'billingKasir.views.batalAlokasiDana.';
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



        if (isset($_GET['frame'])) {
            $this->layout = "//layouts/iframe";
        }

        // var_dump($_POST); die;
        if (isset($_POST['pendaftaran_id']) && isset($_POST['OrderbatalalokasiT'])) {


            // var_dump($_POST); die;

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $pendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
                $ok = true;

                // var_dump($_POST); die;

                foreach ($_POST['OrderbatalalokasiT'] as $tglpembayaran => $item) {

                    if (!isset($item['ceklis']) || $item['ceklis'] != "1") {
                        continue;
                    }


                    $arr_alokasi = AlokasidanaT::model()->findAllByAttributes(array(
                        'tglpembayaran'=>$tglpembayaran,
                        'pendaftaran_id'=>$_POST['pendaftaran_id'],
                    ));

                    foreach ($arr_alokasi as $alokasi) {

                        $detTindakan = CHtml::listData(AlokasidanadetailtindakanT::model()->findAllByAttributes(array(
                            'alokasidana_id'=>$alokasi->alokasidana_id
                        )), 'alokasidanadetailtindakan_id', 'alokasidanadetailtindakan_id');
                        $detOa = CHtml::listData(AlokasidanadetailoaT::model()->findAllByAttributes(array(
                            'alokasidana_id'=>$alokasi->alokasidana_id
                        )), 'alokasidanadetailoa_id', 'alokasidanadetailoa_id');
                        $modBatal = new OrderbatalalokasiT;
                        $modBatal->attributes = $pendaftaran->attributes;
                        $modBatal->alokasidana_id = $alokasi->alokasidana_id;
                        $modBatal->penjamin_id = $alokasi->penjamin_id;

                        if ($modBatal->isNewRecord) {
                            $modBatal->create_time = date('Y-m-d H:i:s');
                            $modBatal->create_loginpemakai = Yii::app()->user->id;
                        }
                        $modBatal->update_time = date('Y-m-d H:i:s');
                        $modBatal->update_loginpemakai = Yii::app()->user->id;
                        
                        $ok = $ok && $modBatal->save();

                        /*
                        $crUpdateTindakan = new CDbCriteria;
                        $crUpdateTindakan->addInCondition("alokasidanadetailtindakan_id", $detTindakan);
                        TindakanpelayananT::model()->updateAll(array(
                            'alokasidanadetailtindakan_id'=>null
                        ), $crUpdateTindakan);

                        $crUpdateOa = new CDbCriteria;
                        $crUpdateOa->addInCondition("alokasidanadetailoa_id", $detOa);
                        ObatalkespasienT::model()->updateAll(array(
                            'alokasidanadetailoa_id'=>null
                        ), $crUpdateOa);
                        */

                        // var_dump($modBatal->attributes);
                    }
                }

                // die;


         
                if ($this->ok) {

                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                    $transaction->commit();
                    $this->redirect(array('index'));

                } else {

                    Yii::app()->user->setFlash('error', 'Data alokasi gagal dibatalkan !');
                    $transaction->rollback();

                }
            } catch (Exception $exc) {
                $transaction->rollback();
                echo $exc->getMessage() . "<br/><br/>" . $exc->getTraceAsString();
                die;

                Yii::app()->user->setFlash('error', "Data alokasi gagal dibatalkan " . $exc->getMessage());
                $this->redirect(array('index'));
            }
        }

        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modKunjungan' => $modKunjungan,
            'dataTindakans' => $dataTindakans,
            'dataOas' => $dataOas,
        ));
    }

    public function actionInformasi() {
        $model = new BKInformasiorderbatalalokasiV;
        $model->unsetAttributes();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_GET['BKInformasiorderbatalalokasiV'])) {
            $model->attributes = $_GET['BKInformasiorderbatalalokasiV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDB($_GET['BKInformasiorderbatalalokasiV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDB($_GET['BKInformasiorderbatalalokasiV']['tgl_akhir']);
        }

        $this->render($this->path_view . "informasi/index", array(
            'model'=>$model,
        ));
    }

    public function actionDetailAlokasi($id) {

        $this->layout = "//layouts/iframe";

        $alokasi = AlokasidanaT::model()->findByPk($id);
        $pendaftaran = PendaftaranT::model()->findByPk($alokasi->pendaftaran_id);
        $tindakan = AlokasidanadetailtindakanT::model()->findAllByAttributes(array(
            'alokasidana_id'=>$alokasi->alokasidana_id
        ));
        $oa = AlokasidanadetailoaT::model()->findAllByAttributes(array(
            'alokasidana_id'=>$alokasi->alokasidana_id
        ));

        $this->render($this->path_view."detailAlokasi", array(
            'pendaftaran'=>$pendaftaran,
            'alokasi'=>$alokasi,
            'tindakan'=>$tindakan,
            'oa'=>$oa,
        ));
    }


    public function actionLoadAlokasi() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $id = $_POST['pendaftaran_id'];
        $tgl_alokasi = $_POST['tgl_alokasi'];
        
        $cr = new CDbCriteria;
        $cr->join = "left join pembayaranpelayanan_t p on p.alokasidana_id = t.alokasidana_id and p.orderbatalpembayaranpelayanan_id is null
        left join orderbatalalokasi_t ba on ba.alokasidana_id = t.alokasidana_id
        ";
        $cr->addCondition("p.alokasidana_id is null and ba.alokasidana_id is null");
        $cr->compare("t.pendaftaran_id", $id);
        $cr->compare("t.tglpembayaran", $tgl_alokasi);
        $cr->order = "tglpembayaran desc, carabayar_id asc";

        $alokasi = AlokasidanaT::model()->findAll($cr);

        $arr_alokasi = array();

        foreach ($alokasi as $item) {
            if (empty($arr_alokasi[$item->tglpembayaran])) {
                $arr_alokasi[$item->tglpembayaran] = array(
                    'row'=>$item,
                    'det'=>array(),
                );
            }
            $arr_alokasi[$item->tglpembayaran]['det'][] = $item;
        }


        echo CJSON::encode(array(
            'html'=>$this->renderPartial($this->path_view . "_tabAlokasi", array(
                'arr_alokasi' => $arr_alokasi
            ), true)
        ));
    }

    /**
     * form verifikasi sebelum submit
     */
    public function actionVerifikasi()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $trans = Yii::app()->db->beginTransaction();

        try {
            $ok = true;
    

            $pendaftaran_id = $_POST['pendaftaran_id'];
            $tgl_alokasi = $_POST['tgl_alokasi'];

            $arr_alokasi = AlokasidanaT::model()->findAllByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
                'tglpembayaran'=>$tgl_alokasi
            ));

            foreach ($arr_alokasi as $alokasi) {

                $bayar = PembayaranpelayananT::model()->findByAttributes(array(
                    'alokasidana_id'=>$alokasi->alokasidana_id
                ), array(
                    'condition'=>'orderbatalpembayaranpelayanan_id is null',
                ));

                if (!empty($bayar)) {
                    $trans->rollback();
                    echo CJSON::encode(array(
                        'ok'=>1,
                        'msg'=>'Pasien sudah dilakukan pembayaran.',
                    ));

                    Yii::app()->end();
                }

                $batal = OrderbatalalokasiT::model()->findByAttributes(array(
                    'alokasidana_id'=>$alokasi->alokasidana_id
                ));

                $tindakan = AlokasidanadetailtindakanT::model()->findAllByAttributes(array(
                    'alokasidana_id'=>$alokasi->alokasidana_id
                ));
                $oa = AlokasidanadetailoaT::model()->findAllByAttributes(array(
                    'alokasidana_id'=>$alokasi->alokasidana_id
                ));

                foreach ($tindakan as $item) {
                    $item->orderbatalalokasi_id = $batal->orderbatalalokasi_id;
                    $ok = $ok && $item->save(false, array('orderbatalalokasi_id'));

                    // var_dump($item->attributes);

                    $modTindakan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
                    $modTindakan->alokasidanadetailtindakan_id = null;
                    $modTindakan->save(false, array('alokasidanadetailtindakan_id'));

                    // var_dump($modTindakan->attributes);
                }
        
                foreach ($oa as $item) {
                    $item->orderbatalalokasi_id = $batal->orderbatalalokasi_id;
                    $ok = $ok && $item->save(false, array('orderbatalalokasi_id'));

                    $modOa = ObatalkespasienT::model()->findByPk($item->obatalkespasien_id);
                    $modOa->alokasidanadetailoa_id = null;
                    $modOa->save(false, array('alokasidanadetailoa_id'));

                    // var_dump($modOa->attributes);
                }

            }


            // var_dump($ok); die;


    
            
    
            
    

            if ($ok) {
                $trans->commit();
                echo CJSON::encode(array(
                    'ok'=>1,
                    'msg'=>'Order batal berhasil di-update. ',
                ));
            } else {
                $trans->rollback();
                echo CJSON::encode(array(
                    'ok'=>1,
                    'msg'=>'Order batal gagal di-update. ',
                ));
            }

            // var_dump($ok, $_POST); die;

        } catch (Exception $e) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Order batal gagal di-update. '.$e->getMessage(),
            ));
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
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            if ($instalasi_id == Params::INSTALASI_ID_RJ) {
                $models = BKInformasikasirrawatjalanV::model()->findAll($criteria);
            } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
                $models = BKInformasikasirrdpulangV::model()->findAll($criteria);
            } else if (in_array($instalasi_id, Params::grupInstalasiRIID())) {
                $models = BKInformasikasirinappulangV::model()->findAll($criteria);
            }
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
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

            if (!empty($asuransi)) {
                $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id;
                $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama;
                $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id);
                if (!empty($asuransi->nopeserta)) {
                    $bpjs = new BpjsVklaim;
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
                        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
                        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id ?? null;
                        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama ?? "";
                        $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id) ?? 0;
                    }
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
            $modBayarUangMuka = BKBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if (!empty($modBayarUangMuka)) {
                // $modPemakaianUangMuka = PemakaianuangmukaT::model()->findByAttributes(array('bayaruangmuka_id'=>$modBayarUangMuka->bayaruangmuka_id),array('order'=>'pemakaianuangmuka_id DESC','limit'=>1));
                // if (!empty($modPemakaianUangMuka)){
                //     $returnVal["jumlahuangmuka"] = (isset($modPemakaianUangMuka->sisauangmuka) ? $modPemakaianUangMuka->sisauangmuka : 0);
                // }else{
                //     $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
                //     $crit_uangmuka->addCondition("pembatalanuangmuka_id IS NULL");
                //     $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
                //     $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
                //     $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
                // }
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
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
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


    public function getPenjaminById($arr_penjamin_id)
    {
        $criteria = new CdbCriteria();
        $criteria->addInCondition('penjamin_id', $arr_penjamin_id);

        return PenjaminpasienM::model()->findAll($criteria);
    }

}
