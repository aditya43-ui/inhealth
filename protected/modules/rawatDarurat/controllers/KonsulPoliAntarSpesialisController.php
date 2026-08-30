<?php
Yii::import('rawatJalan.controllers.KonsulPoliController');
Yii::import('rawatJalan.models.*');
class KonsulPoliAntarSpesialisController extends KonsulPoliController
{
    public $path_view_rd = 'rawatDarurat.views.konsulPoliAntarSpesialis.';

    public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null, $idKonsulPoli = null)
    {
        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis' => true));

        $modKonsul = new RJKonsulPoliT;
        $modelPendaftaran = new RJPendaftaranT;
        $modKonsul->pasien_id = $modPendaftaran->pasien_id;
        $modKonsul->pendaftaran_id = $pendaftaran_id;
        // $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
        $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
        $modKonsul->asalpoliklinikkonsul_id = $ruangan_id;

        $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

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

        if (isset($idPasienKirimKeUnitLain)) {
            $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
            $modPasien = $modKirimKeUnitLain->pasien;
        }

        if (!empty($idKonsulPoli)) {
            $modKonsulPoli = RJKonsulPoliT::model()->findByPk($idKonsulPoli);
        } else {
            $modKonsulPoli = new RJKonsulPoliT();
        }

        // echo '<pre>'; var_dump($modKonsulPoli->konsulpoli_id); die;

        if (isset($_POST['RJKonsulPoliT'])) {


            // var_dump($_POST);die;

            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;

            // if (isset($_POST['RJKonsulPoliT']['ruangan_id'])) {
                $modKonsul = new RJKonsulPoliT;
                $modKonsul->attributes = $_POST['RJKonsulPoliT'];

                $modelPendaftaran->pasienpulang_id = $modPendaftaran->pasienpulang_id;
                $modelPendaftaran->pasienbatalperiksa_id = $modPendaftaran->pasienbatalperiksa_id;
                if (empty($modelPendaftaran->penanggungjawab_id)) {
                    $penanggungjawab = 1;
                } else {
                    $penanggungjawab = $modPendaftaran->penanggungjawab_id;
                }
                //		$modKonsul->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($modKonsul->ruangan_id);
                // $modKonsul->no_antriankonsul = MyGenerator::noAntrianPPKonsul(null); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
                $modKonsul->pegawaikonsul_id = $modKonsul->pegawai_id;
                $modKonsul->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modKonsul->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                // $modKonsul->ruangan_id = $ruangantujuan_id;
                $modKonsul->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modKonsul->pasien_id = $modPendaftaran->pasien_id;
                $modKonsul->daftartindakan_id = 11894;

                // $modKonsul->asalpoliklinikkonsul_id =  $modPendaftaran->pasienadmisi->ruangan_id ?? $modPendaftaran->ruangan_id;
                $modKonsul->asalpoliklinikkonsul_id =  $ruangan_id;

                $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;

                $modKonsul->uraian_konsul = isset($_POST['RJKonsulPoliT']['uraian_konsul']) ? $_POST['RJKonsulPoliT']['uraian_konsul'] : '';

            
                // var_dump($modKonsul->attributes, $_POST); die;
            
                if ($modKonsul->validate()) {
                    if ($modKonsul->save()) {
            
                    $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                    // $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
            
                    /* ================================================ */
                    /* Proses update status periksa KonsulPoli EHS-179  */
                    /* ================================================ */
                    $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
                    if (!empty($konsulPoli)) {
                        $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
                    }
                    /* ================================================ */
            
                    PendaftaranT::model()->updateByPk(
                        $pendaftaran_id,
                        array(
                        'pembayaranpelayanan_id' => null
                        )
                    );
            
                    $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id)->jenistarif_id;
            
                    $criteria = new CDbCriteria();
                    $criteria->addCondition('t.komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
                    $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
                    $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";
                    $criteria->addCondition("kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
                    $criteria->addCondition("jenistarif_id = " . $jenistarif);
            
                    $modTarif = RJTariftindakanM::model()->find($criteria);
                    if (!empty($modTarif)) {
                        $modTindakanPelayanan =  new RJTindakanPelayananT;
                        $modTindakanPelayanan->konsulpoli_id = $modKonsul->konsulpoli_id;
                        $modTindakanPelayanan->pasien_id = $modPendaftaran->pasien_id;
                        $modTindakanPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                        $modTindakanPelayanan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                        $modTindakanPelayanan->shift_id     = $modPendaftaran->shift_id;
                        $modTindakanPelayanan->carabayar_id = $modPendaftaran->carabayar_id;
                        $modTindakanPelayanan->penjamin_id = $modPendaftaran->penjamin_id;
                        $modTindakanPelayanan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                        $modTindakanPelayanan->ruangan_id   = $modKonsul->ruangan_id;
                        $modTindakanPelayanan->instalasi_id = $modTindakanPelayanan->ruangan->instalasi_id;
                        $modTindakanPelayanan->cyto_tindakan = 0;
                        $modTindakanPelayanan->tarifcyto_tindakan = 0;
                        $modTindakanPelayanan->discount_tindakan = 0;
                        $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
                        $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
                        $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
                        $modTindakanPelayanan->iurbiaya_tindakan = 0;
                        $modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
                        $modTindakanPelayanan->create_ruangan = $modKonsul->ruangan_id;
                        $modTindakanPelayanan->create_time =  date('Y-m-d H:i:s');
                        $modTindakanPelayanan->satuantindakan = "Hari";
            
                        $modTindakanPelayanan->daftartindakan_id = $modTarif->daftartindakan_id;
                        $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
            
                        $modTindakanPelayanan->tarif_satuan = (isset($modTarif->harga_tariftindakan) ? $modTarif->harga_tariftindakan : 0);
                        $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;
            
                        if ($modTindakanPelayanan->validate()) {
                        if ($modTindakanPelayanan->save()) {
                            $valid = true;
                            $modTindakanPelayanan->saveTindakanKomponen();
                        }
                        }
                    }
                    /* ================================================ */
            
                    /** AWAL
                     * Notifikasi Antar Poliklinik, notifikasi ditampilkan ke polik tujuan
                     * 
                     * 
                     */
                    // echo '<pre>';var_dump($modKonsul);die;
                    $modRuangan = RuanganM::model()->findByPk(1065);
                    $judul = 'Pasien Konsul Dokter Spesialis';
            
                    $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' telah dikonsul ke ' . $modRuangan->ruangan_nama . ' pada ' . $modKonsul->tglkonsulpoli . ' dari ' . $modKonsul->poliasals->ruangan_nama;
            
                    if($modKonsul->pegawai->spesialis_id == 459 && isset($_GET['pasienadmisi_id'])) {
                        $this->sendNotif($judul, $isi, $modRuangan->ruangan_id);
                    }


                    // notif konsul internal
                    $judul = 'Pasien Konsultasi Internal';

                    $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' telah dilakukan konsul internal di ' . $modKonsul->poliasals->ruangan_nama . ' pada ' . $modKonsul->tglkonsulpoli;

                    if($modKonsul->pegawai->spesialis_id == 459) {
                        $this->sendNotif($judul, $isi, Yii::app()->user->getState('ruangan_id'));
                    } else {
                        $this->sendNotif($judul, $isi, Yii::app()->user->getState('ruangan_id'), $modKonsul->pegawai_id);
                    }
                    /*
                    $ruangan = RuanganM::model()->findByPk($modKonsul->ruangan_id);
            
            
                    $ok_notif = CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
                    ));
                    */
            
                    /** AKHIR **/
            
            
                    // SMS GATEWAY
                    /*
                    $modPegawai = $modPendaftaran->pegawai;
                    $modRuangan = $modKonsul->politujuan;
                    $sms = new Sms();
                    $smspasien = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;
            
                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPendaftaran->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modKonsul->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modRuangan->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKonsul->tglkonsulpoli), $isiPesan);
            
                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                        if (!empty($modPasien->no_mobile_pasien)) {
                            $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                        } else {
                            $smspasien = 0;
                        }
                        }
                    }
                    */
            
                    } else {
                    //  var_dump($modKonsul->errors);
                    $ok = false;
                    }
                } else {
                    // var_dump($modKonsul->errors);
                    $ok = false;
                }
                
                
                
            // }

            $ok &= $this->simpanTindakan($modPendaftaran, $modPasien, $modKonsul);

            // vaR_dump($ok); die;

            if ($ok) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1, 'idKonsulPoli' => $modKonsul->konsulpoli_id));
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
        }
    
    // $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'asalpoliklinikkonsul_id' => $ruangan_id));
        $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), ['order' => 'tglkonsulpoli desc']);


        $this->render($this->path_view_rd . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modKonsul' => $modKonsul,
            'karcisTindakan' => $karcisTindakan,
            'modRiwayatKonsul' => $modRiwayatKonsul,
            'modelPendaftaran' => $modelPendaftaran,
            'modKonsulPoli' => $modKonsulPoli, //added  - data ini digunakan untuk membuat notifikasi yang dikirim untuk ruangan asal
            'modJenisTarif' => $modJenisTarif
        ));
    }

    public function actionAjaxBatal()
    {
        if (Yii::app()->request->isAjaxRequest) {
        $konsulantarpoli_id = (isset($_POST['idKonsulAntarPoli']) ? $_POST['idKonsulAntarPoli'] : null);
        $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);

        $tindakanpelayanan = RJTindakanPelayananT::model()->findByAttributes(array('konsulpoli_id' => $konsulantarpoli_id));
        $data['pesan'] = '';
        $data['status'] = 1;
        if (!empty($tindakanpelayanan)) {
            $cekOrderBatal = InfoorderbataltindakanV::model()->find("tindakanpelayanan_id = $tindakanpelayanan->tindakanpelayanan_id and petugasbatal_id is not null and petugas_verif_id is not null");
            if(!empty($cekOrderBatal)) {
            // TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayanan->tindakanpelayanan_id));
            // RJTindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);

                RJKonsulPoliT::model()->deleteByPk($konsulantarpoli_id);
            } else {
            $data['status'] = 0;
            $data['pesan'] = 'Hapus konsultasi harus di verifikasi order batal tindakan dahulu.';
            }
        }

        $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), ['order' => 'tglkonsulpoli desc']);

        $data['result'] = $this->renderPartial('_listKonsulPoli', array('modRiwayatKonsul' => $modRiwayatKonsul), true);

        echo json_encode($data);
        Yii::app()->end();
        }
    }

    function sendNotif($judul, $isi, $ruangan_id_tujuan, $pegawai_id = null) {
        $modRuangan = RuanganM::model()->findByPk($ruangan_id_tujuan);
        if(!empty($pegawai_id)) {
            CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $modRuangan->instalasi_id, 'ruangan_id' => $ruangan_id_tujuan, 'modul_id' => $modRuangan->modul_id, 'pegawai_id' => $pegawai_id),
            ));
        } else {
            CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $modRuangan->instalasi_id, 'ruangan_id' => $ruangan_id_tujuan, 'modul_id' => $modRuangan->modul_id),
            ));
        }
    }
}