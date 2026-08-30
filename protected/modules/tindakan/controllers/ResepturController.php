<?php
class ResepturController extends MyAuthController
{
    public $layout = '//layouts/iframe';
    public $path_view = 'rawatJalan.views.reseptur.';
    public $successSave = false;
    public $reseptur_id;
    public $modSMS = null;
    public $keterangan = '';
    public $is_obatkronis = '';

    public function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $salin = null)
    {
        if (empty($pasienadmisi_id)) {
            $pasienadmisi_id = null;
        }
        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
        $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

        $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
            'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
        ), array(
            'order' => 'tglkonsulpoli desc',
        ));

        if (!empty($konsul)) {
            $modPendaftaran->pegawai_id = $konsul->pegawai_id;
        }

        $modPaketObat = new PaketobatM();

        $modul = ModulK::model()->findByAttributes(array('url_modul' => $this->module->id));

        $cr = new CDbCriteria();
        $cr->compare("trim(lower(tujuansms))", strtolower(Params::TUJUANSMS_PASIEN));
        $cr->compare('modul_id', $modul->modul_id);
        $cr->compare('trim(lower(modcontroller))', strtolower($this->id . "controller"));
        $cr->compare('trim(lower(modaction))', strtolower($this->action->id));
        $cr->addCondition('statussms = true');

        $this->modSMS = SmsgatewayM::model()->find($cr);

        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modObatAlkesPasien = array();
        $modResepturDetail = array();
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modReseptur = new RJResepturT;
        $modReseptur->noresep = MyGenerator::noResepReseptur();
        $modReseptur->pegawai_id = (!empty($pasienadmisi_id)) ? $modAdmisi->pegawai_id : $modPendaftaran->pegawai_id;
        $kelompokpegawai_id = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->kelompokpegawai_id;
        if ($kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP) {
            $modReseptur->pegawai_id = Yii::app()->user->getState('pegawai_id');
        }

        $ruanganDepo = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

        $modReseptur->ruanganreseptur_id = $ruangan_id;

        if ($modPendaftaran->carabayar_id == 1) {
            $modReseptur->ruangan_id = 237;
        } else if ($modPendaftaran->carabayar_id == 2) {
            $modReseptur->ruangan_id = 235;
        }

        $modReseptur->penjamin_id = (!empty($pasienadmisi_id)) ? $modAdmisi->penjamin_id : $modPendaftaran->penjamin_id;

        if (!empty($this->modSMS)) {
            $modReseptur->kirim_sms_pasien = true;
        }

        if (isset($_GET['reseptur_id']) || !empty($salin)) {
            $reseptur_id = isset($_GET['reseptur_id']) ? $_GET['reseptur_id'] : $salin;

            $modReseptur = RJResepturT::model()->findByPk($reseptur_id);
            $modObatAlkesPasien = RJObatalkesPasienT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            $modResepturDetail = RJResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $reseptur_id));
        }
        $modPenjualanResep = new RJPenjualanresepT();
        $modPenjualanResep->pasien_id = $modPasien->pasien_id;

        $modRiwatReseptur = new RJResepturT;
        $modRiwatReseptur->pasien_id = $modPasien->pasien_id;

        $modAnamnesa = new RJAnamnesaT;
        $modAnamnesa->pasien_id = $modPasien->pasien_id;

        $modCPPT = new RJCpptpasienT;
        $modCPPT->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modCPPT->dpjp_id = Yii::app()->user->getState('pegawai_id');
        $modCPPT->pegawaippa_id = Yii::app()->user->getState('pegawai_id');


        if (isset($_GET['sukses'])) {
            $modResepturAntrol = ResepturT::model()->findByPk($_GET['reseptur_id']);
            $this->tambahAntrianFarmasi($modResepturAntrol);
        }
        if (isset($_POST['RJResepturT'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $this->saveReseptur($_POST, $modPendaftaran);
              
                $this->broadcastNotifReseptur($modPendaftaran);

                if ($this->successSave) {
                    Yii::app()->user->setFlash('success', "Data Resep berhasil disimpan");
                    $transaction->commit();
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'reseptur_id' => $this->reseptur_id, 'sukses' => 1, 'is_obatkronis' => $this->is_obatkronis));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }


        $modObatAlkesPasien = RJObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modRiwayatResep = RJResepturT::model()->findAllByAttributes(array('pasien_id' => $modPendaftaran->pasien_id, 'pasienadmisi_id' => $pasienadmisi_id, 'ruanganreseptur_id' => $ruangan_id), array('order' => 't.create_time DESC'));
        $modRiwayatResepPertama = RJResepturT::model()->findAllByAttributes(array('pasien_id' => $modPendaftaran->pasien_id, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'tglreseptur ASC limit 1'));
        $modPaketObat = new RJPaketobatM();
        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modReseptur' => $modReseptur,
            'modRiwayatResep' => $modRiwayatResep,
            'modObatAlkesPasien' => $modObatAlkesPasien,
            'modResepturDetail' => $modResepturDetail,
            'modAdmisi' => $modAdmisi,
            'modPaketObat' => $modPaketObat,
            'modPenjualanResep' => $modPenjualanResep,
            'modRiwatReseptur' => $modRiwatReseptur,
            'modRiwayatResepPertama' => $modRiwayatResepPertama,
            'modAnamnesa' => $modAnamnesa,
            'modCPPT' => $modCPPT
        ));
    }

    public function tambahAntrianFarmasi($model)
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $modResepturDetail = ResepturdetailT::model()->findByAttributes(array('reseptur_id' => $model->reseptur_id));
        if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ) {
            $waktutunggupelayanan = WaktutunggupelayananT::model()->findByAttributes(array(
                'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                'task_id' => 5
            ));
            if (!empty($waktutunggupelayanan)) {
                $ruangan_id = $model->ruangan_id;
                $now = date('Y-m-d');
                $res = Yii::app()->db->createCommand("select get_totalantreanfarmasi(" . $ruangan_id . ",'" . $now . "') as res")->queryRow();

                $transaction = Yii::app()->db->beginTransaction();

                $modAntrianFarmasi = new AntrianfarmasiT();
                $modAntrianFarmasi->racikan_id = $modResepturDetail->racikan_id;
                $modAntrianFarmasi->ruangan_id = $ruangan_id;
                $modAntrianFarmasi->tglambilantrian = $now;
                $modAntrianFarmasi->noantrian = $res['res'] + 1;
                $modAntrianFarmasi->create_time = date('Y-m-d H:i:s');
                $modAntrianFarmasi->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                $modAntrianFarmasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modAntrianFarmasi->reseptur_id = $model->reseptur_id;

                $modAntrianFarmasi->save();
                $antrianonlinebpjs = new AntrianOnlineBpjs();
                $jenispasien = $modResepturDetail->racikan_id == 2 ? 'non racikan' : 'racikan';
                $keterangan = "-";
                $body = array("kodebooking" => $waktutunggupelayanan->kode_booking, "jenisresep" => $jenispasien, "nomorantrean" => $modAntrianFarmasi->noantrian, "keterangan" => $keterangan);

                $response = CJSON::decode($antrianonlinebpjs->tambahAntreanFarmasi($body));
                $transaction->commit();
            }
        }
    }

    protected function broadcastNotifReseptur($modPendaftaran)
    {
        $reseptur = ResepturT::model()->findByPk($this->reseptur_id);

        $rr = RuanganM::model()->findByPk($reseptur->ruanganreseptur_id);
        $dokter = PegawaiM::model()->findByPk($reseptur->pegawai_id);
        $pasien = PasienM::model()->findByPk($reseptur->pasien_id);

        $judul = "Reseptur Pasien - " . $pasien->no_rekam_medik . ' - ' . $pasien->namadepan . $pasien->nama_pasien;
        $isi = $reseptur->noresep . " - " . $rr->ruangan_nama . " - " . $dokter->namaLengkap . " - " .
            $pasien->no_rekam_medik . " - " . $pasien->namadepan . $pasien->nama_pasien;

        $link = $this->createUrl('/farmasiApotek/InformasiPasienResep/Index', array(
            'FAInformasiresepturV[tgl_awal]' => date('Y-m-d', strtotime($reseptur->tglreseptur)),
            'FAInformasiresepturV[tgl_akhir]' => date('Y-m-d', strtotime($reseptur->tglreseptur)),
            'FAInformasiresepturV[noreseptur]' => $reseptur->noresep,
            'FAInformasiresepturV[no_rekam_medik]' => $reseptur->pasien->no_rekam_medik,
            'FAInformasiresepturV[nama_pasien]' => $reseptur->pasien->nama_pasien
        ));

        $keterangan = $this->keterangan;

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => $reseptur->ruangan_id, 'modul_id' => 10, 'link_proses' => $link),
        ));
    }

    protected function saveReseptur($post, $modPendaftaran)
    {
        $reseptur = new RJResepturT;
        if (isset($_GET['salin'])) {
            $reseptur = RJResepturT::model()->findByPk($_GET['salin']);
        }
        // echo CJSON::encode($_POST);die;
        $reseptur->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $reseptur->tglreseptur = $post['RJResepturT']['tglreseptur'];

        $instalasi_id = Yii::app()->user->getState('instalasi_id');
        $reseptur->noresep = MyGenerator::noResepReseptur();
        $reseptur->pegawai_id = $post['RJResepturT']['pegawai_id'];
        $reseptur->ruangan_id = $post['RJResepturT']['ruangan_id'];
        $reseptur->ppds_id = $post['RJResepturT']['ppds_id'];
        $reseptur->ruanganreseptur_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $reseptur->pasien_id = $modPendaftaran->pasien_id;
        $reseptur->jasapelayanan_farmasi = isset($post['RJResepturT']['jasapelayanan_farmasi']) ? $post['RJResepturT']['jasapelayanan_farmasi'] : null;
        $reseptur->pasienadmisi_id = ((isset($_GET['pasienadmisi_id']) && !empty($_GET['pasienadmisi_id'])) ? $_GET['pasienadmisi_id'] : null);
        $reseptur->isterapipulang = !empty($post['RJResepturT']['isterapipulang']) ? true : false;
        $reseptur->is_cito = !empty($post['RJResepturT']['is_cito']) ? true : false;

        // $reseptur->isterapipulang =  $post['RJResepturT']['isterapipulang'] == 1 ? true : false;
        // var_dump($reseptur->isterapipulang);die;
        if (!empty($post['RJResepturT']['isterapipulang'])) {
            $reseptur->isterapipulang = $post['RJResepturT']['isterapipulang'] == 1 ? true : false;
        } else {
            $reseptur->isterapipulang = null;
        }

        if (isset($post['RJResepturT']['ispasienbaru'])) {
            $reseptur->ispasienbaru = $post['RJResepturT']['ispasienbaru'] == 1 ? true : false;
        } else {
            $reseptur->ispasienbaru = null;
        }

        if ($reseptur->validate()) {
            if ($reseptur->save()) {
                if (!in_array($instalasi_id, array(Params::INSTALASI_ID_PI, Params::INSTALASI_ID_RI))) {
                    $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
                    // $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
                    $updateStatusPeriksa = PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s')));

                    /* ================================================ */
                    /* Proses update status periksa KonsulPoli EHS-179  */
                    /* ================================================ */
                    $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id')));

                    if (!empty($konsulPoli)) {
                        $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
                    }
                }
                //        var_dump($reseptur->attributes); die;
                $modReseptur = $this->saveDetailReseptur($post, $reseptur);
                //        die;
                if (isset($post['RJResepturT']['kirim_sms_pasien']) && $post['RJResepturT']['kirim_sms_pasien'] == 1 && !empty($this->modSMS)) {
                    $modSMS = $this->modSMS;
                    $sms = new Sms();

                    $isiPesan = $modSMS->templatesms;

                    $modPasien = PasienM::model()->findByPk($reseptur->pasien_id);
                    $modRuangan = RuanganM::model()->findByPk($reseptur->ruangan_id);

                    $attributes = $modPasien->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }

                    $attributes = $modPendaftaran->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }

                    $hari = MyFormatter::getDayName($reseptur->tglreseptur);
                    $reseptur->tglreseptur = MyFormatter::formatDateTimeForUser($reseptur->tglreseptur);
                    $attributes = $reseptur->getAttributes();

                    foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }

                    $attributes = $modRuangan->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }

                    $isiPesan = str_replace("{{hari}}", $hari, $isiPesan);
                    $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

                    if (!empty($modPasien->no_mobile_pasien)) {
                        $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                    }
                }
            } else {
                $this->successSave = false;
            }
        } else {
            $this->successSave = false;
        }
    }

    protected function saveDetailReseptur($post, $reseptur)
    {
        $valid = true;
        if (isset($_GET['salin'])) {
            $deleteDetailResep = ResepturdetailT::model()->deleteAllByAttributes(array('reseptur_id' => $_GET['salin']));
        }

        foreach ($post['RJResepturDetailT'] as $i => $detailreseptur) {
            // echo "<pre>";
            // var_dump($post);die;
            $detail = new RJResepturDetailT;
            $detail->reseptur_id = $reseptur->reseptur_id;
            $detail->attributes = $detailreseptur;
            $detail->signa_reseptur = $detailreseptur['signa_reseptur'];
            $detail->iter = $detailreseptur['iter'];
            $detail->formulaobatkronis_id = !empty($detailreseptur['formulaobatkronis_id']) ? $detailreseptur['formulaobatkronis_id'] : null;
            $detail->is_obatkronis = !empty($detailreseptur['is_obatkronis']) ? $detailreseptur['is_obatkronis'] : 0;

            $detail->satuansediaan = $detailreseptur['satuansediaan'];
            $detail->satuankekuatan = !empty($detailreseptur['satuankekuatan']) ? $detailreseptur['satuankekuatan'] : null;
            if (!empty($detailreseptur['permintaan_temp'])) {
                $detail->permintaan_reseptur = $detailreseptur['permintaan_temp'];
            }

            // if($detailreseptur['obatalkes_id'] == 7862){
            // $detail->obatlain_nama = $post['obatlain'];
            // var_dump($detail->obatalkes_nama);die;
            // }
            $detail->qty_reseptur = is_numeric($detail->qty_reseptur) ? $detail->qty_reseptur : MyFormatter::formatRupiahForDB($detail->qty_reseptur);

            if (empty($detail->permintaandosis_pembilang) && empty($detail->permintaandosis_penyebut)) {
                $detail->is_permitaandosispecahan = false;
            }

            if (!empty($detailreseptur['formulaobatkronis_id'])) {
                $this->is_obatkronis = 1;
            }
           

            $this->reseptur_id = $reseptur->reseptur_id;
            $valid = $detail->validate() && $valid;

            if ($valid) {
                $valid = $valid && $detail->save();
            }
        }
        
        $this->successSave = ($valid) ? true : false;
    }



    public function actionAutocompleteObatReseptur()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $term = explode(';', $_GET['term']);
            $ruangan_id = $_GET['ruangantujuan_id'];
            $obatalkes_nama = isset($term[0]) ? $term[0] : '';
            $hargajual = isset($term[1]) ? $term[1] : '';
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
            if ($hargajual != '') {
                $criteria->addCondition('hargajual =' . $hargajual, 'or');
            }
            $criteria->addCondition('obatalkes_farmasi = TRUE');
            $criteria->addCondition('obatalkes_aktif = true');
            $criteria->order = 'obatalkes_nama';
            $criteria->limit = 15;
            $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
            $persenjual = $this->persenJualRuangan();
            $format = new MyFormatter();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();

                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                // $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, $ruangan_id);
                $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama; //." - Jumlah Stok ".$qtyStok;
                $returnVal[$i]['value'] = $model->obatalkes_nama;
                $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
                $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
                // $returnVal[$i]['qtyStok'] = $qtyStok;
                $returnVal[$i]['hargajual'] = floor(($persenjual + 100) / 100 * $model->hargajual);
                $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
                $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
                $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
                $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionGetJumlahObat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = [];
            $qty = ceil(MyFormatter::formatNumberForDb($_POST['qty']));
            $models = FormulaobatkronisM::model()->findByAttributes(['jumlahobat' => $qty]);

            $data['formulaobatkronis_id'] = !empty($models) ? $models->formulaobatkronis_id : "";

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionGetKronisObat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = [];
            $formulaobatkronis_id = $_POST['formulaobatkronis_id'];
            $models = FormulaobatkronisM::model()->findByPk($formulaobatkronis_id);

            $data['jumlahobat'] = !empty($models) ? $models->jumlahobat : 0;

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }


    protected function persenJualRuangan()
    {
        switch (Yii::app()->user->getState('instalasi_id')) {
            case Params::INSTALASI_ID_RI:
                $persen = Yii::app()->user->getState('ri_persjual');
                break;
            case Params::INSTALASI_ID_RJ:
                $persen = Yii::app()->user->getState('rj_persjual');
                break;
            case Params::INSTALASI_ID_RD:
                $persen = Yii::app()->user->getState('rd_persjual');
                break;
            default:
                $persen = 0;
                break;
        }

        return $persen;
    }

    public function actionSetDetailPaketObat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $form = "";
            $pesan = "";
            $paketobat_id = $_POST['paketobat_id'];
            $isRacikan = $_POST['isRacikan'];
            $ruangan_id = $_POST['ruangan_id'];
            $rke = $_POST['rke'];
            $postRke = $_POST['rke'];
            $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
            $is_obatkronis = isset($_POST['is_obatkronis']) ? $_POST['is_obatkronis'] : 0;
            $formulaobatkronis_id = isset($_POST['formulaobatkronis_id']) ? $_POST['formulaobatkronis_id'] : null;


            $detailPaket = RJPaketobatdetailM::model()->findAllByAttributes(['paketobat_id' => $paketobat_id]);

            $format = new MyFormatter();
            $modResepturDetail = new RJResepturDetailT;

            foreach ($detailPaket as $key => $value) {
                $obatalkes_id = $value->obatalkes_id;
                $jmlStok = StokobatalkesT::getJumlahStok($obatalkes_id, $ruangan_id);
                $modObatAlkes = RJObatAlkesM::model()->findByPk($obatalkes_id);
                $jumlah = $value->jumlah;

                if (isset($value->rke) && $rke == 1) {
                    $rke_baru = $value->rke;
                    $rk = 1;
                } else if (isset($value->rke) && $rke > 1) {
                    if ($key == 0) {
                        $rk = $rke;
                    }

                    $rke_baru = intval($value->rke) + intval($rk) - 1;
                }
                $modResepturDetail->rke = isset($rke_baru) ? $rke_baru : $rke;
                $modResepturDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
                $modResepturDetail->obatalkes_kode = $modObatAlkes->obatalkes_kode;
                $modResepturDetail->obatalkes_nama = $modObatAlkes->obatalkes_nama;
                $modResepturDetail->sumberdana_id = $modObatAlkes->sumberdana_id;
                $modResepturDetail->satuankecil_id = isset($value->satuankecil_id) ? $value->satuankecil_id : $modObatAlkes->satuankecil_id;
                $modResepturDetail->racikan_id = $value->racikan_id;
                $modResepturDetail->r = 'R/';
                $modResepturDetail->qty_reseptur = number_format($jumlah, 2, ",", "");
                $modResepturDetail->jmlstok = $jmlStok;
                $modResepturDetail->jmlkemasan_reseptur = $value->jml_permintaan;
                $modResepturDetail->permintaan_reseptur = $value->permintaan_dosis;
                $modResepturDetail->obatlain_nama = $value->obatlain_nama;
                $modResepturDetail->is_obatkronis = $value->is_obatkronis;
                $modResepturDetail->formulaobatkronis_id = $value->formulaobatkronis_id;
                $modResepturDetail->permintaan_temp = !empty($modResepturDetail->permintaan_reseptur) ? $modResepturDetail->permintaan_reseptur : '0';

                if ($value->is_permintaandosispecahan == true) {
                    $modResepturDetail->permintaan_temp = $value->permintaandosis_pembilang . " / " . $value->permintaandosis_penyebut;
                    $modResepturDetail->permintaandosis_pembilang = $value->permintaandosis_pembilang;
                    $modResepturDetail->permintaandosis_penyebut = $value->permintaandosis_penyebut;
                    $modResepturDetail->is_permitaandosispecahan = 1;
                    $modResepturDetail->is_permitaandosispecahan = 1;
                } else {
                    $modResepturDetail->permintaandosis_pembilang = null;
                    $modResepturDetail->permintaandosis_penyebut = null;
                    $modResepturDetail->is_permitaandosispecahan = 0;
                }

                // var_dump("pembilang :".$modResepturDetail->permintaandosis_pembilang);
                // var_dump("penyebut :".$modResepturDetail->permintaandosis_penyebut);

                $modResepturDetail->kekuatan_reseptur = $value->sediaan;
                $modResepturDetail->satuankekuatan = $value->satuan_permintaandosis;
                $modResepturDetail->satuansediaan = $value->satuan_jmlpermintaan;
                $modResepturDetail->etiket = $value->etiket;
                $modResepturDetail->resepturketerangan = $value->resepturketerangan;
                // var_dump($modResepturDetail);
                $isRacikan =  ($value->racikan_id == Params::RACIKAN_ID_RACIKAN) ? 1 : 0;

                if (!empty($modResepturDetail->satuankecil_id)) {
                    $satuan_nama = SatuankecilM::model()->findByPk($modResepturDetail->satuankecil_id)->satuankecil_nama;
                }

                $instalasi = Yii::app()->user->getState('instalasi_id');

                $konfigFarmasi = KonfigfarmasiK::model()->find();
                if ($instalasi == Params::INSTALASI_ID_RJ || $instalasi == Params::INSTALASI_ID_HD || $instalasi == 74) {
                    $modResepturDetail->persenppnjual = $konfigFarmasi->rj_persjualppn;
                } else if ($instalasi == Params::INSTALASI_ID_RI || $instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
                    $modResepturDetail->persenppnjual = $konfigFarmasi->ri_persjualppn;
                } else if ($instalasi == Params::INSTALASI_ID_RD || $instalasi == Params::INSTALASI_ID_PERSALINAN) {
                    $modResepturDetail->persenppnjual = $konfigFarmasi->rd_persjualppn;
                } else {
                    $modResepturDetail->persenppnjual = 0;
                }

                $konfigFarmasi = KonfigfarmasiK::model()->find();
                $modResepturDetail->hargasatuan_reseptur = $modObatAlkes->hargajual;
                $modResepturDetail->biayaadministrasi = 0;
                $modResepturDetail->persdiskon = 0;

                if ($konfigFarmasi->ishargaperpenjamin == true) {
                    if (!empty($penjamin_id)) {
                        $obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id' => $modObatAlkes->jenisobatalkes_id, 'penjamin_id' => $penjamin_id));

                        if (!empty($obatalkesPenjamin)) {
                            $marginRp = round((($modObatAlkes->hpp * $obatalkesPenjamin->persmargin) / 100), 2);
                            $hargaSatuan = round(($modObatAlkes->hpp + $marginRp), 2);
                            $modResepturDetail->hargasatuan_reseptur = $hargaSatuan;
                            $modResepturDetail->biayaadministrasi = $obatalkesPenjamin->biayaadministrasi;
                            $modResepturDetail->persdiskon = $obatalkesPenjamin->persdiskon;
                        }
                    }
                }

                $modResepturDetail->signa_reseptur = $value->signa_oa;
                $hargaQytOa = ($modObatAlkes->hargajual * $jumlah);
                $jmlPPn = (($modResepturDetail->persenppnjual * $hargaQytOa) / 100);
                $hargaSubtotal = ($hargaQytOa + $jmlPPn);
                $modResepturDetail->hargasatuan_reseptur = number_format($modResepturDetail->hargasatuan_reseptur, 2, ",", ".");
                $modResepturDetail->jumlahppn = $jmlPPn;

                $modResepturDetail->harganetto_reseptur = $modObatAlkes->harganetto;
                $modResepturDetail->hargajual_reseptur = number_format($hargaSubtotal, 2, ",", ".");

                $form .= $this->renderPartial($this->path_view . '_rowDetail', array('modResepturDetail' => $modResepturDetail, 'isRacikan' => $isRacikan, 'paketobat' => true, 'satuan_nama' => $satuan_nama), true);
                $rke++;
            }
            // var_dump($modResepturDetail->obatalkes->obatalkes_nama);die;

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    public function actionSetFormObatAlkesPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = MyFormatter::formatRupiahForDb($_POST['jumlah']);
            $isRacikan = $_POST['isRacikan'];
            $ruangan_id = $_POST['ruangan_id'];
            $therapiobat_id = isset($_POST['therapiobat_id']) ? $_POST['therapiobat_id'] : null;
            $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
            $is_obatkronis = isset($_POST['is_obatkronis']) ? $_POST['is_obatkronis'] : 0;
            $formulaobatkronis_id = isset($_POST['formulaobatkronis_id']) ? $_POST['formulaobatkronis_id'] : null;
            $satuansediaan = isset($_POST['satuansediaan']) ? $_POST['satuansediaan'] : null;
            $jmlkemasan = isset($_POST['jmlkemasan']) ? $_POST['jmlkemasan'] : 0;
            $etiketwaktu = isset($_POST['etiketwaktu']) ? $_POST['etiketwaktu'] : 0;
            $dosis = isset($_POST['dosis']) ? $_POST['dosis'] : 0;
            $resepturketerangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : null;
            $permintaan = isset($_POST['permintaan']) ? $_POST['permintaan'] : null;
            $obatlain = !empty($_POST['obatlain']) ? $_POST['obatlain'] : '';
            // var_dump($obatlain);die;

            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modResepturDetail = new RJResepturDetailT;
            $jmlStok = StokobatalkesT::getJumlahStok($obatalkes_id, $ruangan_id);

            $modObatAlkes = RJObatAlkesM::model()->findByPk($obatalkes_id);
            //if($jmlStok > 0){
            $modResepturDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
            if (!empty($obatlain)) {
                $modResepturDetail->obatlain_nama = $obatlain;
                // var_dump($modResepturDetail->obatalkes_nama);die;
            }
            $modResepturDetail->sumberdana_id = $modObatAlkes->sumberdana_id;
            $modResepturDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
            $modResepturDetail->racikan_id = ($isRacikan == 0) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
            $modResepturDetail->r = 'R/';
            $modResepturDetail->qty_reseptur = number_format($jumlah, 2, ",", "");
            $modResepturDetail->jmlstok = $jmlStok;
            $modResepturDetail->kekuatan_reseptur = $modObatAlkes->kekuatan;
            $modResepturDetail->satuankekuatan = $modObatAlkes->satuankekuatan;
            $modResepturDetail->is_obatkronis = $is_obatkronis;
            $modResepturDetail->formulaobatkronis_id = $formulaobatkronis_id;
            $modResepturDetail->dosis = $dosis;
            $modResepturDetail->etiketwaktu = $etiketwaktu;
            $modResepturDetail->permintaan_temp = $permintaan;
            // var_dump($modResepturDetail->permintaan_temp);die;
            $modResepturDetail->resepturketerangan = $resepturketerangan;

            // var_dump($modObatAlkes->hpp);
            $instalasi = Yii::app()->user->getState('instalasi_id');

            $konfigFarmasi = KonfigfarmasiK::model()->find();
            if ($instalasi == Params::INSTALASI_ID_RJ || $instalasi == Params::INSTALASI_ID_HD || $instalasi == 74) {
                $modResepturDetail->persenppnjual = $konfigFarmasi->rj_persjualppn;
            } else if ($instalasi == Params::INSTALASI_ID_RI || $instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
                $modResepturDetail->persenppnjual = $konfigFarmasi->ri_persjualppn;
            } else if ($instalasi == Params::INSTALASI_ID_RD || $instalasi == Params::INSTALASI_ID_PERSALINAN) {
                $modResepturDetail->persenppnjual = $konfigFarmasi->rd_persjualppn;
            } else {
                $modResepturDetail->persenppnjual = 0;
            }
            // var_dump($modObatAlkes->hpp);

            $konfigFarmasi = KonfigfarmasiK::model()->find();
            $modResepturDetail->hargasatuan_reseptur = $modObatAlkes->hargajual;
            $modResepturDetail->biayaadministrasi = 0;
            $modResepturDetail->persdiskon = 0;

            // var_dump($modObatAlkes->hpp);

            if ($konfigFarmasi->ishargaperpenjamin == true) {
                if (!empty($penjamin_id)) {
                    $obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id' => $modObatAlkes->jenisobatalkes_id, 'penjamin_id' => $penjamin_id));

                    if (!empty($obatalkesPenjamin)) {

                        // var_dump($modObatAlkes->hpp); die;

                        $marginRp = round((($modObatAlkes->hpp * $obatalkesPenjamin->persmargin) / 100), 2);
                        $hargaSatuan = round(($modObatAlkes->hpp + $marginRp), 2);
                        $modResepturDetail->hargasatuan_reseptur = $hargaSatuan;
                        $modResepturDetail->biayaadministrasi = $obatalkesPenjamin->biayaadministrasi;
                        $modResepturDetail->persdiskon = $obatalkesPenjamin->persdiskon;
                    }
                }
            }


            $hargaQytOa = ($modObatAlkes->hargajual * $jumlah);
            $jmlPPn = (($modResepturDetail->persenppnjual * $hargaQytOa) / 100);
            $hargaSubtotal = ($hargaQytOa + $jmlPPn);

            // var_dump(($modResepturDetail->hargasatuan_reseptur)); die;

            $modResepturDetail->hargasatuan_reseptur = number_format($modResepturDetail->hargasatuan_reseptur, 2, ",", ".");
            $modResepturDetail->jumlahppn = $jmlPPn;

            $modResepturDetail->harganetto_reseptur = $modObatAlkes->harganetto;
            $modResepturDetail->hargajual_reseptur = number_format($hargaSubtotal, 2, ",", ".");

            $modResepturDetail->therapiobat_id = $therapiobat_id;

            $modResepturDetail->total_embalase = 0;

            if (!empty($satuansediaan)) {
                $lookup = LookupM::model()->findByAttributes(array('lookup_type' => Params::LOOKUPTYPE_SEDIAANOBATRACIKAN, 'lookup_name' => $satuansediaan));

                if (!empty($lookup)) {
                    $nominal = (is_numeric($lookup->lookup_value) ? $lookup->lookup_value : 0);
                    $jmlembalase = round(($nominal * $jmlkemasan), 2);
                    $modResepturDetail->total_embalase = $jmlembalase;
                }
            }

            //    var_dump($modResepturDetail); die;

            $form .= $this->renderPartial($this->path_view . '_rowDetail', array('modResepturDetail' => $modResepturDetail, 'isRacikan' => $isRacikan), true);

            echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
            Yii::app()->end();
        }
    }

    /**
     * method to get Therapi Obat
     * made for : LNG Projects
     * LNG-321
     */
    public function actionAutoCompleteTherapiObat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $term = $_GET['term'];
            $criteria = new CDbCriteria();
            $criteria->addCondition("therapiobat_nama ILIKE '%" . $term . "%'");
            $criteria->addCondition('therapiobat_aktif = true');
            $criteria->limit = 15;
            $models = RJTherapiobatM::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();

                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->therapiobat_nama;
                $returnVal[$i]['value'] = $model->therapiobat_id;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionSetTherapiobatid()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $obatalkes_id = $_POST['obatalkes_id'];
            $modTherapi = RJTherapimapobatM::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id));
            if (!empty($modTherapi)) {
                $data = $modTherapi->therapiobat_id;
            } else {
                $data = null;
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionPrint($idReseptur = null)
    {
        $pendaftaran_id = $_GET['id'];
        $criteria = new CDbCriteria;
        if (empty($idReseptur)) {
            $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
        } else {
            $criteria->compare('reseptur_id', $idReseptur);
        }
        $maxtime = RJResepturT::model()->find($criteria);
        $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $judulLaporan = 'Reseptur';
        $caraPrint = $_REQUEST['caraPrint'];
        if (isset($_GET['idReseptur'])) {
            $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $_GET['idReseptur']));
            if ($caraPrint == 'PRINT') {
                $this->layout = '//layouts/printWindows';
                $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDetailResep' => $modDetailResep, 'modReseptur' => $maxtime));
            }
        } else {
            if ($caraPrint == 'PRINT') {
                $this->layout = '//layouts/printWindows';
                $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, "modDetailResep" => $modDetailResep, 'modReseptur' => $maxtime));
            }
        }
    }

    public function actionSetDropdownRke()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = '';
            $rmax = isset($_POST['rmax']) ? $_POST['rmax'] : null;
            if (isset($rmax)) {
                for ($i = $rmax + 1; $i <= 20; $i++) {
                    $data .=  CHtml::tag('option', array('value' => $i), CHtml::encode($i), true);
                }
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    public function actionAjaxDetailResep()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $idReseptur = $_POST['idReseptur'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modReseptur = RJResepturT::model()->findByPk($idReseptur);
            $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $idReseptur));

            $data['result'] = $this->renderPartial($this->path_view . '_viewDetailResep', array('modDetailResep' => $modDetailResep, 'modPendaftaran' => $modPendaftaran, 'modReseptur' => $modReseptur), true);

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionHapusRiwayatReseptur()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $detailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $_POST['reseptur_id']));
                $resep = ResepturT::model()->findByPk($_POST['reseptur_id']);

                if (!empty($resep->penjualanresep_id)) {
                    $data['pesan'] = "Reseptur " . $resep->noresep . " sudah terjual.";
                    $data['sukses'] = 0;
                    $transaction->rollback();
                    goto prints;
                }

                $deleteDetailResep = ResepturdetailT::model()->deleteAllByAttributes(array('reseptur_id' => $_POST['reseptur_id']));
                if ($deleteDetailResep) {
                    if ($resep->delete()) {
                        $data['pesan'] = "Riwayat Resep Termasuk Detail Resep Berhasil Dihapus!";
                        $data['sukses'] = 1;
                        $transaction->commit();
                    } else {
                        $transaction->rollback();
                        $data['pesan'] = "Gagal Menghapus Reseptur";
                        $data['sukses'] = 0;
                    }
                } else {
                    $transaction->rollback();
                    $data['pesan'] = "Gagal Menghapus Detail Reseptur";
                    $data['sukses'] = 0;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Transaksi Gagal :" . MyExceptionMessage::getMessage($exc, true);
            }
            prints:
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     *
     * Mengambil data lookup signa untuk autocomplete
     *
     * @param string $term input dari textfield autocomplete untuk memfilter nama lookup-nya.
     */
    public function actionGetSignaFarmasi($term = null)
    {
        $cr = new CDbCriteria();
        $cr->compare('lookup_type', 'signa_oa');
        $cr->compare('lower(lookup_name)', strtolower($term), true);
        $cr->addCondition('lookup_aktif = true');
        $cr->order = 'lookup_urutan';

        $signa = LookupM::model()->findAll($cr);

        $res = array();
        foreach ($signa as $item) {
            $res[] = array('label' => $item->lookup_name, 'value' => $item->lookup_name);
        }

        echo CJSON::encode($res);
    }

    public function actionGetPaketObat($term = null)
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();

        $obat = PaketobatM::model()->search();
        $obat->criteria->compare('lower(nama_paket)', strtolower($term), true);
        $obat->sort->defaultOrder = 'nama_paket';
        $obat->pagination = false;

        $res = array();

        foreach ($obat->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->nama_paket;
            $sub['value'] = $item->paketobat_id;
            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionLoadDataTarif()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $id = $_POST['id'];
            $is_paket = $_POST['is_paket'];
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modAsuransi = RJAsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
            $data['sukses'] = 1;
            $data['pesan'] = "";
            $data['total'] = 0;
            $data['carabayar_id'] = $modPendaftaran->carabayar_id;

            $total = $total_tindakan =  $total_reseptur = $total_obat = 0;
            if ($is_paket == 0) {
                $harga_obat = $this->hitungObat($id, $modPendaftaran->penjamin_id);
                $total_obat += $harga_obat;
            } else {
                $modPaket = RJPaketobatM::model()->findByAttributes(['paketobat_id' => $id]);
                $modDetPaket = RJPaketobatdetailM::model()->findAllByAttributes(['paketobat_id' => $modPaket->paketobat_id]);
                if (!empty($modDetPaket)) {
                    foreach ($modDetPaket as $key => $det) {
                        $harga_obat = $this->hitungObat($det['obatalkes_id'],  $modPendaftaran->penjamin_id);
                        $total_obat += $harga_obat;
                    }
                }
            }

            $tanggungan = !empty($modAsuransi->nominal_tanggungan) ? MyFormatter::formatNumberForDb($modAsuransi->nominal_tanggungan) : 0;
            $modTindakan = RJTindakanPelayananT::model()->findAllByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
            if (!empty($modTindakan)) {
                foreach ($modTindakan as $key => $det) {
                    $total_tindakan += MyFormatter::formatNumberForDb($det['tarif_tindakan']);
                }
            }

            $modReseptur = RJResepturT::model()->findAllByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
            if (!empty($modReseptur)) {
                foreach ($modReseptur as $key2 => $det2) {
                    $modResepturDet = RJResepturDetailT::model()->findAllByAttributes(['reseptur_id' => $det2['reseptur_id']]);
                    if (!empty($modResepturDet)) {
                        foreach ($modResepturDet as $key3 => $det3) {
                            $total_reseptur += MyFormatter::formatNumberForDb($det3['hargajual_reseptur']);
                        }
                    }
                }
            }

            $data['total_tindakan'] = $total_tindakan;
            $data['total_reseptur'] = $total_reseptur;
            $total = $total_tindakan + $total_reseptur + $total_obat;
            $data['total'] = $total;
            $data['tanggungan'] = $tanggungan;
            $data['total_obat'] = $total_obat;

            if (!empty($tanggungan)) {
                if ($tanggungan > 0) {
                    if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) {
                        if ($tanggungan < $total) {
                            $data['sukses'] = 0;
                            $data['pesan'] = "Jumlah tagihan sudah melebihi batas plafon";
                        }
                    }
                }
            }

            echo CJSON::encode($data);
        }
    }

    public static function hitungObat($id, $penjamin_id)
    {
        $modObat = RJObatAlkesM::model()->findByPk($id);

        $harga = 0;
        $ppn_persen = $margin = $c = $biaya_administrasi = $persen_discount = $jumlah_diskon = $jumlah_ppn =  0;

        $harga_satuan = $modObat->hpp;
        $konfigFarmasi = KonfigfarmasiK::model()->find();
        if ($konfigFarmasi->ishargaperpenjamin == true) {
            if (!empty($penjamin_id)) {
                $obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id' => $modObat->jenisobatalkes_id, 'penjamin_id' => $penjamin_id));
                $ppn_persen = $konfigFarmasi->rj_persjualppn;

                if (!empty($obatalkesPenjamin)) {
                    $marginRp = round((($modObat->hpp * $obatalkesPenjamin->persmargin) / 100), 2);
                    $hargaSatuan = round(($modObat->hpp + $marginRp), 2);
                    $harga_satuan = $hargaSatuan;
                    $biaya_administrasi  = $obatalkesPenjamin->biayaadministrasi;
                    $persen_discount = $obatalkesPenjamin->persdiskon;
                }
            }
        }

        $jumlah_diskon = ((($harga_satuan + $biaya_administrasi) * $persen_discount) / 100);
        $jumlah_ppn = (((($harga_satuan + $biaya_administrasi) - $jumlah_diskon) * $ppn_persen) / 100);

        $harga = (($harga_satuan + $biaya_administrasi) - $jumlah_diskon) + $jumlah_ppn;

        return $harga;
    }

    public function actionCopyReseptur()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $reseptur_id = $_POST['reseptur_id'];
            $rke = $_POST['rke'];

            $modObatAlkes = RJResepturDetailT::model()->findAllByAttributes(['reseptur_id' => $reseptur_id], ['order' => 'rke']);
            $data = array();
            $tr = '';

            if (!empty($modObatAlkes)) {
                $r = 1;
                $r_1 = $modObatAlkes[0]['rke'];

                foreach ($modObatAlkes as $key => $det) {
                    $modDet = $det;
                    $modDetResep = new RJResepturDetailT();

                    if (isset($det->rke) && $rke == 1) {
                        if ($r_1 > 1) {
                            $rke_baru = intval($det->rke) - 1;
                        } else {
                            $rke_baru = $det->rke;
                        }
                    } else {
                        if ($r_1 > 1) {
                            if ($key == 0) {
                                $rk = $rke;
                            }
                        } else {
                            $rk = $rke + 1;
                        }
                        $rke_baru = intval($det->rke) + intval($rk) - 1;
                    }

                    $modDetResep->attributes = $det->attributes;
                    $isRacikan = $det->racikan_id;
                    $modDetResep->obatalkes_kode = $det->obatalkes->obatalkes_kode;
                    $modDetResep->obatalkes_nama = $det->obatalkes->obatalkes_nama;
                    $modDetResep->rke = isset($rke_baru) ? $rke_baru : $rke;
                    $modDetResep->hargasatuan_reseptur = number_format($modDetResep->hargasatuan_reseptur, 2, ",", ".");
                    $modDetResep->hargajual_reseptur = number_format($modDetResep->hargajual_reseptur, 2, ",", ".");
                    $modDetResep->persdiskon = number_format($modDetResep->persdiskon, 2, ",", ".");

                    $tr .= $this->renderPartial($this->path_view . '_rowDetail', array('modResepturDetail' => $modDetResep, 'isRacikan' => $isRacikan, 'paketobat' => false), true);
                }
            }

            $data['tr'] = $tr;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Fungsi copy resep
     */
    public function actionCopyResep()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $penjualanresep_id = $_POST['penjualanresep_id'];
            $rke = $_POST['rke'];
            $modPenjualanResep = RJPenjualanresepT::model()->findByPk($penjualanresep_id);


            $modObatAlkes = RJObatalkesPasienT::model()->findAllByAttributes(['penjualanresep_id' => $modPenjualanResep->penjualanresep_id], ['order' => 'rke']);
            $data = array();
            $tr = '';

            if (!empty($modObatAlkes)) {
                foreach ($modObatAlkes as $key => $det) {
                    $modDetResep = new RJResepturDetailT();

                    if (isset($det->rke) && $rke == 1) {
                        $rke_baru = $det->rke;
                        $rk = 1;
                    } else if (isset($det->rke) && $rke > 1) {
                        if ($key == 0) {
                            $rk = $rke;
                        }

                        $rke_baru = intval($det->rke) + intval($rk) - 1;
                    }

                    $modDetResep->attributes = $det;
                    $isRacikan = $det->racikan_id;
                    $modDetResep->obatalkes_id = $det->obatalkes_id;
                    $modDetResep->obatalkes_kode = $det->obatalkes->obatalkes_kode;
                    $modDetResep->obatalkes_nama = $det->obatalkes->obatalkes_nama;
                    $modDetResep->penjualanresep_id = $penjualanresep_id;
                    $modDetResep->signa_reseptur = $det->signa_oa;
                    $modDetResep->etiket = $det->etiket;
                    $modDetResep->qty_reseptur = $det->qty_oa;
                    $modDetResep->permintaan_reseptur = $det->permintaan_oa;
                    $modDetResep->r = $det->r;
                    $modDetResep->kekuatan_reseptur = $det->kekuatan_oa;
                    $modDetResep->jmlkemasan_reseptur = $det->jmlkemasan_oa;
                    $modDetResep->harganetto_reseptur = $det->harganetto_oa;
                    $modDetResep->satuankekuatan = $det->satuankekuatan_oa;
                    $modDetResep->racikan_id = $det->racikan_id;
                    $modDetResep->tglkadaluarsa = !empty($det->obatalkes->tglkadaluarsa) ? $det->obatalkes->tglkadaluarsa : "";
                    $modDetResep->hargasatuan_reseptur = $det->hargasatuan_oa;
                    $modDetResep->satuankecil_id = $det->satuankecil_id;
                    $modDetResep->sumberdana_id = $det->sumberdana_id;
                    $modDetResep->rke = isset($rke_baru) ? $rke_baru : $rke;

                    $tr .= $this->renderPartial($this->path_view . '_rowDetail', array('modResepturDetail' => $modDetResep, 'isRacikan' => $isRacikan, 'paketobat' => false), true);
                }
            }

            $data['tr'] = $tr;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionGetObat()
    {
        $data = [];
        $data['sukses'] = 0;
        $data['pesan'] = 'Message : ';
        $data['obatalkes']['sukses'] = 0;
        $data['sumberdana']['sukses'] = 0;

        if(isset($_POST['kode_obat']) && isset($_POST['sumberdana']) && isset($_POST['stfornas'])) {
            $modSumberdana = SumberdanaM::model()->findByAttributes(['sumberdana_nama' => $_POST['sumberdana']]);
            if(!empty($modSumberdana)) {
                $data['sumberdana']['sukses'] = 1;
                $data['sumberdana']['id'] = $modSumberdana->sumberdana_id;
                $data['sukses'] = 1;
                $modObat = ObatalkesM::model()->findByAttributes(['kodeobat_inventory' => $_POST['kode_obat'], 'stfornas' => $_POST['stfornas'], 'sumberdana_id' => $modSumberdana->sumberdana_id], ['order' => 'obatalkes_id DESC']);
            } else {
                $data['sukses'] = 0;
                $data['pesan'] .= 'Data Sumberdana Tidak Ditemukan berdasarkan nama berikut = ' . $_POST['sumberdana'];
                $modObat = null;
            }
            
            if(!empty($modObat)) {
                $data['obatalkes']['sukses'] = 1;
                $data['obatalkes']['id'] = $modObat->obatalkes_id;
                $data['obatalkes']['nama'] = $modObat->obatalkes_nama;
                $data['obatalkes']['kode'] = $modObat->kodeobat_inventory;
                $data['obatalkes']['signa'] = $modObat->signa;
                $data['obatalkes']['harganetto'] = $modObat->harganetto;
                $data['obatalkes']['satuankecil_id'] = $modObat->satuankecil_id;
                $data['obatalkes']['satuankecil_nama'] = $modObat->satuankecil->satuankecil_nama;
                $data['obatalkes']['kekuatanObat'] = $modObat->kekuatan;
                $data['sukses'] = 1;

            } else {
                $data['sukses'] = 0;
                $data['pesan'] = 'Data Obat Tidak Ditemukan Pada Database berdasarkan kode berikut = ' . $_POST['kode_obat'];
            }

            

            
        } else {
            $data['pesan'] .= 'Tidak ada kiriman Data';
        }

        echo json_encode($data);
    }

    public function actionAjaxDetailPenjualan()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $idPenjualan = $_POST['idPenjualan'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPenjualan = RJPenjualanresepT::model()->findByPk($idPenjualan);
            $modObatAlkes = RJObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));

            $data['result'] = $this->renderPartial($this->path_view . '_viewDetailPenjualan', array(
                'modObatAlkes' => $modObatAlkes,
                'modPendaftaran' => $modPendaftaran,
                'modPenjualan' => $modPenjualan
            ), true);

            echo json_encode($data);
            Yii::app()->end();
        }
    }
}
