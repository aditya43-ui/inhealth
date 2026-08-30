<?php

class InformasiPasienResepRIController extends MyAuthController {

    public function actionIndex() {
        $model = new InformasiresepturrawatinapV('searchInformasiPasienResep');
        $model->unsetAttributes();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        $model->status_terpenuhi = 'Belum Terpenuhi';
        $model->statusJual = 2;
        if (isset($_POST['InformasiresepturrawatinapV'])) {
            $format = new MyFormatter();
            $model->attributes = $_POST['InformasiresepturrawatinapV'];
            $model->statusJual = isset($_POST['InformasiresepturrawatinapV']['statusJual']) ? $_POST['InformasiresepturrawatinapV']['statusJual'] : null;
            $model->statusperiksa = isset($_POST['InformasiresepturrawatinapV']['statusperiksa']) ? $_POST['InformasiresepturrawatinapV']['statusperiksa'] : null;
            $model->status_terpenuhi = isset($_POST['InformasiresepturrawatinapV']['status_terpenuhi']) ? $_POST['InformasiresepturrawatinapV']['status_terpenuhi'] : null;
            $model->tgl_awal = $format->formatDateTimeForDb($_POST['InformasiresepturrawatinapV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_POST['InformasiresepturrawatinapV']['tgl_akhir']);
            $model->is_tgl = $_POST['InformasiresepturrawatinapV']['is_tgl'];
            $model->statusJual = $_POST['InformasiresepturrawatinapV']['statusJual'];
        }

        $this->render('index', array('model' => $model));
    }

    public function actionPrintResepDokter() {
        if (isset($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        } else {
            $this->layout = '//layouts/printWindows';
        }

        $reseptur_id = $_GET['id'];
        $modReseptur = FAResepturT::model()->findByPk($reseptur_id);
        $pendaftaran_id = $modReseptur->pendaftaran_id;
        $criteria = new CDbCriteria;
        $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
        $maxtime = FAResepturT::model()->find($criteria);
        $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
        $modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

        $judulLaporan = '';

        $criteriakl = new CDbCriteria;
        $criteriakl->addCondition("reseptur_id = " . $reseptur_id);
        $criteriakl->select = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
        $criteriakl->group = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
        if (isset($_GET['racikan_id'])) {
            $criteriakl->compare('racikan_id', $_GET['racikan_id']);
        }
        $kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);

        $this->render('Print', array(
            'modPendaftaran' => $modPendaftaran,
            'judulLaporan' => $judulLaporan,
            "modDetailResep" => $modDetailResep,
            'modReseptur' => $modReseptur,
            'kerangkaLooping' => $kerangkaLooping
        ));
    }

    /**
     * action ketika tombol panggil di klik
     */
    public function actionPanggilAntrian() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $antrianfarmasi_id = ($_POST['antrianfarmasi_id']);
            $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
            $modAntrianFarmasi = AntrianfarmasiT::model()->findByPk($antrianfarmasi_id);
            $modReseptur = ResepturT::model()->findByPk($modAntrianFarmasi->reseptur_id);

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
            $data['smspasien'] = 1;
            $data['nama_pasien'] = '';

            if (isset($modReseptur)) {
                if (isset($modAntrianFarmasi)) {
                    if (($modAntrianFarmasi->panggilantrian == true && $modAntrianFarmasi->jumlah_panggil == 3)) {
                        if ($keterangan == "batal") {
                            $modAntrianFarmasi->panggilantrian = false;
                            if ($modAntrianFarmasi->update()) {
                                // SMS GATEWAY
                                $modPasien = $modPenjualanResep->pasien;
                                $sms = new Sms();
                                $smspasien = 1;
                                foreach ($modSmsgateway as $i => $smsgateway) {
                                    $isiPesan = $smsgateway->templatesms;

                                    $attributes = $modPasien->getAttributes();
                                    foreach ($attributes as $attributes => $value) {
                                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                    }
                                    $attributes = $modReseptur->getAttributes();
                                    foreach ($attributes as $attributes => $value) {
                                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                    }
                                    $attributes = $modAntrianFarmasi->getAttributes();
                                    foreach ($attributes as $attributes => $value) {
                                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                    }

                                    if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                                        if (!empty($modPasien->no_mobile_pasien)) {
                                            $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                                        } else {
                                            $smspasien = 0;
                                        }
                                    }
                                }
                                // END SMS GATEWAY
                                $data['smspasien'] = $smspasien;
                                $data['nama_pasien'] = $modPasien->nama_pasien;
                                $data['pesan'] = "Pemanggilan no. antrian " . $modAntrianFarmasi->noantrian . " dibatalkan !";
                            }
                        } else {
                            $data['pesan'] = "No. antrian " . $modAntrianFarmasi->noantrian . " sudah dipanggil sebelumnya !";
                        }
                    } else {
                        $modAntrianFarmasi->panggilantrian = true;
                        $modAntrianFarmasi->jumlah_panggil++;
                        if ($modAntrianFarmasi->update()) {
                            $data['pesan'] = "No. antrian " . $modAntrianFarmasi->noantrian . " dipanggil! (" . $modAntrianFarmasi->jumlah_panggil . " kali)";
                        }
                    }
                } else {
                    $data['pesan'] = "Pasien tidak ada dalam No. Antrian";
                }
            }

            if (isset($antrianfarmasi_id)) {
                $attributes = $modAntrianFarmasi->attributeNames();
                foreach ($attributes as $i => $attribute) {
                    $data["$attribute"] = $modAntrianFarmasi->$attribute;
                }
                $data['racikan_singkatan'] = !empty($modAntrianFarmasi)?$modAntrianFarmasi->racikan->racikan_singkatan:'';
                $data['kronis_singkatan'] = !empty($modAntrianFarmasi)?$modAntrianFarmasi->kronis->kronis_singkatan:'';
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * riwayat obat alkes
     */
    public function actionRiwayat($id, $pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $modReseptur = FAResepturT::model()->findByPk($id);

        $modPendaftaran = FAPendaftaranT::model()->findByPk($pendaftaran_id);
        // var_dump($modPendaftaran);die;

        $criteria = new CDbCriteria;
        if (!empty($modPendaftaran->pasien_id)) {
            $criteria->addCondition("pasien_id =  " . $modPendaftaran->pasien_id);
        } else {
            $criteria->addCondition("pendaftaran_id = " . $modPendaftaran->pendaftaran_id);
        }


        $modpenjualanresep = FAPenjualanResepT::model()->findAll($criteria);
        // var_dump($modpenjualanresep);die;

        $this->render('_riwayat', array(
            'modPendaftaran' => $modPendaftaran,
            'modReseptur' => $modReseptur,
            'modPenjualanResep' => $modpenjualanresep
        ));
    }

    public function actionCloseResep() {
        if (Yii::app()->request->isAjaxRequest) {

            $id = $_POST['id'];

            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $reseptur = ResepturT::model()->findByPk($id);
                $reseptur->isclose = true;
                $reseptur->petugasclose_id = Yii::app()->user->getState('pegawai_id');
                $reseptur->waktu_close = date('Y-m-d H:i:s');
                $ok &= $reseptur->update(['isclose','petugasclose_id','waktu_close']);                                

                if ($ok) {
                    $trans->commit();
                } else {
                    $trans->rollback();
                }
            } catch (Exception $e) {
                $ok &= false;
                $trans->rollback();
            }

            echo json_encode([
                'sukses' => $ok ? 1 : 0
            ]);
            Yii::app()->end();
        }
    }
    
    /**
     * suara panggilan MULTI no antrian (array) dan loket (array)
     * akses dengan ajax
     */
    public function actionSuaraPanggilan() {
     
        $this->layout = "//layouts/antrian";
        $kodeantrian = $_POST["kodeantrians"];
        $noantrian = $_POST["noantrians"];
        $loket = isset($_POST["loket"]) ? $_POST['loket'] : null;
        
        $res = array();
        $res['suarapanggilan'] = $this->renderPartial('antrian.views.tampilAntrianKeFarmasi.suaraPanggilan', array(
            'kodeantrian' => $kodeantrian,
            'noantrian' => $noantrian,
            'loket' => $loket,                
                ), true);

        echo CJSON::encode($res);

        Yii::app()->end();
    }

}
