<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SbarController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    protected $path_view = 'rawatJalan.views.sbar.';

    public function actionIndex($pendaftaran_id, $sbar_id = null) {
        // if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) {
        //     $this->layout = '//layouts/mainNeonSidebar';
        // }

        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

        if (!empty($sbar_id)) {
            $model = RJSbarT::model()->findByPk($sbar_id);
        } else {
            $model = new RJSbarT();
            $model->tgl_sbar = date('d M Y H:i:s');
        }
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPasien->pasien_id;

        if (isset($_POST['RJSbarT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RJSbarT'];
                $model->tgl_sbar = MyFormatter::formatDateTimeForDB($_POST['RJSbarT']['tgl_sbar']);
                $model->tindakan = "-";
                $model->istruksi_dokter = "-";

                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1, 'type'=>$_GET['type'],'frame'=>$_GET['frame']));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal disimpan. ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien
            )
        );
    }

    public function actionLoadJenisPenginputan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $jenispenginputan = $_POST['jenispenginputan'];
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $returnVal = array();

            $diagnosaMasuk = "";
            $keluhan = "";
            $ruanganPerawatan = $modPendaftaran->ruangan->ruangan_nama;

            $riwayatPenyakitTerdahulu = "";
            $riwayatAlergi = "";
            $terapiDpjp = $modPendaftaran->pegawai->namaLengkap;

            $kesadaran = "";
            $tekananDarah = "";
            $nadi = "";
            $rr = "";
            $suhu = "";
            $gcsEye = "";
            $gcsVerbal = "";
            $gcsMotorik = "";

            $modPasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));

            if (count($modPasienMorbid) > 0) {
                foreach ($modPasienMorbid as $i => $morbid) {
                    if ($i > 0) {
                        $diagnosaMasuk .= ", ";
                    }
                    $diagnosaMasuk .= $morbid->diagnosa->diagnosa_nama;
                }
            }

            $anamnesaAwal = AnamnesisawalT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan_id' => $ruangan_id));

            if (count($anamnesaAwal) > 0) {
                foreach ($anamnesaAwal as $i => $anamnesa) {
                    if ($i > 0) {
                        $keluhan .= ", ";
                        $riwayatPenyakitTerdahulu .= ", ";
                        if ($anamnesa->isada_riwayatalergi == true) {
                            $riwayatAlergi .= ", ";
                        }
                    }
                    $keluhan .= $anamnesa->keluhanutama;
                    $riwayatPenyakitTerdahulu .= $anamnesa->riwayatpenyakit_terdahulu;
                    if ($anamnesa->isada_riwayatalergi == true) {
                        $riwayatAlergi .= $anamnesa->riwayatalergi_obat;
                        $riwayatAlergi .= $anamnesa->riwayatalergi_makanan;
                        $riwayatAlergi .= $anamnesa->riwayatalergi_lainnya;
                    }
                }
            }

            $asesmenAwalKeperawatan = AsesmenawalkeperawatanT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan_id' => $ruangan_id), array('condition' => "(jenisasesmen = 'asesmen_dewasa' OR jenisasesmen = 'asesmen_anak')"));

            if (isset($asesmenAwalKeperawatan) && !empty($asesmenAwalKeperawatan)) {
                if ($jenispenginputan == 'Perawat') {
                    $keluhan .= $asesmenAwalKeperawatan->keluhanutama;
                    $keluhan .= ", " . $asesmenAwalKeperawatan->keluhantambahan;
                    $riwayatPenyakitTerdahulu .= $asesmenAwalKeperawatan->riwayatpenyakitterdahulu;
                    $riwayatAlergi .= $asesmenAwalKeperawatan->riwayatalergiobat;

                    $kesadaran = $asesmenAwalKeperawatan->kesadaranpasien;
                    $tekananDarah = $asesmenAwalKeperawatan->tekanandarah;
                    $nadi = $asesmenAwalKeperawatan->detaknadi;
                    $rr = $asesmenAwalKeperawatan->pernapasan;
                    $suhu = $asesmenAwalKeperawatan->suhutubuh;
                }
            }

            $anamnesa = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => $ruangan_id));

            if (count($anamnesa) > 0) {
                if (count($anamnesaAwal) > 0) {
                    $keluhan .= ", ";
                }

                foreach ($anamnesa as $i => $oriAnamnesa) {
                    if ($i > 0) {
                        $keluhan .= ", ";
                    }
                    $keluhan .= $oriAnamnesa->keluhantambahan;
                }
            }

            $periksaFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => $ruangan_id));

            if (isset($periksaFisik) && !empty($periksaFisik)) {
                if ($jenispenginputan == 'Dokter') {
                    $tekananDarah = $periksaFisik->tekanandarah;
                    $nadi = $periksaFisik->detaknadi;
                    $rr = $periksaFisik->pernapasan;
                    $suhu = $periksaFisik->suhutubuh;
                }

                $gcsEye = $periksaFisik->gcs_eye;
                $gcsVerbal = $periksaFisik->gcs_verbal;
                $gcsMotorik = $periksaFisik->gcs_motorik;
            }

            $situation = "Diagnosa Masuk : " . $diagnosaMasuk . '<br/><br/> Keluhan Saat ini : ' . $keluhan . ' <br/><br/> Ruangan Perawatan : ' . $ruanganPerawatan . ' <br/><br/> Lainnya : ';
            $background = "Riwayat Penyakit Terdahulu : " . $riwayatPenyakitTerdahulu . '<br/><br/> Alergi : ' . $riwayatAlergi . ' <br/><br/> Terapi DPJP : ' . $terapiDpjp . ' <br/><br/> Lainnya : ';
            $asesmen = "Kesadaran : " . $kesadaran . '<br/> TD : ' . $tekananDarah . ' <br/> Nadi : ' . $nadi . ' <br/> Respirasi : ' . $rr . ' <br/> Suhu : ' . $suhu . ' <br/><br/> GCS EYE : ' . $gcsEye . ' <br/> GCS VERBAL : ' . $gcsVerbal . ' <br/> GCS MOTORIK : ' . $gcsMotorik . ' <br/> Lainnya : ';

            $returnVal['situation'] = $situation;
            $returnVal['background'] = $background;
            $returnVal['asesmen'] = $asesmen;

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionPrintRiwayat() {
        $this->layout = '//layouts/printWindows_baru';
        $pendaftaran_id = $_GET['pendaftaran_id'];
        $caraPrint = $_GET['caraPrint'];

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = RJSbarT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

        $this->render($this->path_view . 'print',
            array('model' => $model,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien
        ));
    }

    public function actionVerifikasi($sbar_id) {
        $this->layout = '//layouts/iframe';
        $model = RJSbarT::model()->findByPk($sbar_id);

        $pegawaiMod = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->tgl_verifikasi = date('d M Y H:i:s');

        if (isset($pegawaiMod)) {
            $model->pegawaiverifikasi_id = $pegawaiMod->pegawai_id;
            $model->pegawaiverifikasi_nama = $pegawaiMod->namaLengkap;
        }

        if (isset($_POST['RJSbarT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['RJSbarT'];
                $model->tgl_verifikasi = MyFormatter::formatDateTimeForDB($_POST['RJSbarT']['tgl_verifikasi']);
                $model->isstatusverifikasi = true;

                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('verifikasi', 'sbar_id' => $sbar_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Gagal disimpan. ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'verifikasi', array(
            'model' => $model
        ));
    }

    public function actionDetailVerifikasi($sbar_id) {
        $this->layout = '//layouts/iframe';
        $model = RJSbarT::model()->findByPk($sbar_id);

        $this->render($this->path_view . 'detailverifikasi', array(
            'model' => $model
        ));
    }

    public function actionHapusSbar() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $trans = Yii::app()->db->beginTransaction();
        $ok = 1;
        $msg = "Data berhasil dihapus";

        try {
            $id = $_POST['id'];
            RJSbarT::model()->deleteByPk($id);
            $trans->commit();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data gagal dihapus. " . $ex->getMessage();
        }

        echo CJSON::encode(array(
            'ok' => $ok,
            'msg' => $msg,
        ));
    }
    
    public function actionGetPegawaiSBAR($term = '') {
        
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $peg = new PegawairuanganV;
        $peg->unsetAttributes();
        $peg->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $peg->nama_pegawai = $term;
        
        $prov = $peg->search();
        $prov->sort->defaultOrder = 'nama_pegawai';
        $prov->pagination = false;
        
        $res = [];
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
        
    }
    
}
