<?php

/**
 * Digunakan untuk informasi rencana umum pengadaan
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @author Andyka Putra <andykaputra@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * 
 */
class InformasiRencanaUmumController extends MyAuthController {

    public $path_view_ubah = 'pengadaan.views.informasiRencanaUmum.update.';
    public $path_view_revisi = 'pengadaan.views.informasiRencanaUmum.revisi.';
    public $path_view_detail = 'pengadaan.views.informasiRencanaUmum.detail.';
    public $simpan = true;
    public $ubah_metode = false;
    public $ubah_jenis = false;

    /**
     * Digunakan untuk menampilkan data rencana umum
     */
    public function actionIndex() {
        $model = new ADInformasirencanaumumpengadaanV('searchInformasi');
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        $modDokumen = new PengadaandokumenpendukungT();
        if (isset($_GET['ADInformasirencanaumumpengadaanV'])) {
            $model->attributes = $_GET['ADInformasirencanaumumpengadaanV'];
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['instalasi_nama'])) {
                $model->instalasi_nama = $_GET['ADInformasirencanaumumpengadaanV']['instalasi_nama'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['nama_pekerjaan'])) {
                $model->nama_pekerjaan = $_GET['ADInformasirencanaumumpengadaanV']['nama_pekerjaan'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_kategori'])) {
                $model->rencanaumumpengadaan_kategori = $_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_kategori'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['daftarjenispengadaan'])) {
                $model->daftarjenispengadaan = $_GET['ADInformasirencanaumumpengadaanV']['daftarjenispengadaan'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['metode_pengadaan'])) {
                $model->metode_pengadaan = $_GET['ADInformasirencanaumumpengadaanV']['metode_pengadaan'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_status'])) {
                $model->rencanaumumpengadaan_status = $_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_status'];
            }
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['ADInformasirencanaumumpengadaanV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['ADInformasirencanaumumpengadaanV']['tgl_akhir']);
        }
        $this->render('index', array(
            'model' => $model,
            'modDokumen' => $modDokumen,
                )
        );
    }

    /**
     * Digunakan untuk mencetak dokumen
     */
    public function actionPrint() {
        $model = new ADInformasirencanaumumpengadaanV;
        if (isset($_REQUEST['ADInformasirencanaumumpengadaanV'])) {
            $model->attributes = $_REQUEST['ADInformasirencanaumumpengadaanV'];
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['instalasi_nama'])) {
                $model->instalasi_nama = $_GET['ADInformasirencanaumumpengadaanV']['instalasi_nama'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['nama_pekerjaan'])) {
                $model->nama_pekerjaan = $_GET['ADInformasirencanaumumpengadaanV']['nama_pekerjaan'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_kategori'])) {
                $model->rencanaumumpengadaan_kategori = $_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_kategori'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['daftarjenispengadaan'])) {
                $model->daftarjenispengadaan = $_GET['ADInformasirencanaumumpengadaanV']['daftarjenispengadaan'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['metode_pengadaan'])) {
                $model->metode_pengadaan = $_GET['ADInformasirencanaumumpengadaanV']['metode_pengadaan'];
            }
            if (!empty($_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_status'])) {
                $model->rencanaumumpengadaan_status = $_GET['ADInformasirencanaumumpengadaanV']['rencanaumumpengadaan_status'];
            }
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['ADInformasirencanaumumpengadaanV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['ADInformasirencanaumumpengadaanV']['tgl_akhir']);
        }
        $judulLaporan = 'Data Rencana Umum Pengadaan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    /**
     * Tampilan input nomor SiRUP
     * @param type $id
     */
    public function actionIsiNomor($id) {

        $this->layout = '//layouts/iframe';
        $model = RencanaumumpengadaanT::model()->findByPk($id);
        $this->render('_isiNomor', array(
            'model' => $model,
                )
        );
    }

    /**
     * Fungsi untuk menyimpan nomor rencana umum pengadaan
     */
    public function actionAjaxSimpanNomor() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['RencanaumumpengadaanT']['rencanaumumpengadaan_id'];
            $model = RencanaumumpengadaanT::model()->findByPk($id);
            $modPemetaan = PemetaansubkegiatanpengadaanM::model()->findByAttributes(array('subkegiatanprogram_id' => $model->subkegiatanprogram_id));
            if (isset($_POST['RencanaumumpengadaanT'])) {
                $model->kode_rup = $_POST['RencanaumumpengadaanT']['kode_rup'];
                $model->save();
                $riwayat = new RiwayatpengadaanR;
                $riwayat->rencanaumumpengadaan_id = $id;
                $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $riwayat->pegawai_id = $pegawai->pegawai_id;
                $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $riwayat->pegawai_id));
                $riwayat->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
                $riwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
                $riwayat->status_berkas = 'Kode SIRUP dimasukkan';
                $riwayat->create_time = date('Y-m-d H:i:s');
                $riwayat->tanggal_update = date('Y-m-d H:i:s');
                $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $riwayat->save();

                if (strtolower($model->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)) {
                    // Kirim SMS Dari Drafter ke PPTK Setelah Masukkan Kode SIRUP
                    $nama_modul = Yii::app()->controller->module->id;
                    $nama_controller = Yii::app()->controller->id;
                    $nama_action = Yii::app()->controller->action->id;
                    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                    $criteria = new CDbCriteria;
                    $criteria->compare('modul_id', $modul_id);
                    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                    $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                    $modSmsgateway = SmsgatewayM::model()->find($criteria);

                    if (!empty($modSmsgateway)) {
                        $template = $modSmsgateway->templatesms;
                    } else {
                        $template = "To PPTK: RUP nomor {{nomor_rup}} tanggal {{tanggal_rup}} kategori pengadaan {{kategori_pengadaan}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera dibuatkan nota dinas PPTK.";
                    }

                    $modPegawaiPPTK = PegawaiM::model()->findByPk($modPemetaan->pptk_id);

                    if (!empty($modPegawaiPPTK)) {
                        $isiPesan = $template;
                        $attributes = $model->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            $isiPesan = str_replace("{{nomor_rup}}", $model->rencanaumumpengadaan_nomor, $isiPesan);
                            $isiPesan = str_replace("{{tanggal_rup}}", $model->rencanaumumpengadaan_tanggal, $isiPesan);
                            $isiPesan = str_replace("{{kategori_pengadaan}}", $model->rencanaumumpengadaan_kategori, $isiPesan);
                            $isiPesan = str_replace("{{metode_pengadaan}}", $model->metode_pengadaan, $isiPesan);
                            $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                            $isiPesan = str_replace("{{nama_pekerjaan}}", $model->nama_pekerjaan, $isiPesan);
                        }
                        $api = new MyAPI();
                        if (!empty($modPegawaiPPTK->nomobile_pegawai)) {
                            $res = $api->smsBlastSend(array($modPegawaiPPTK->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                            CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                        }//END OF if (!empty($modPegawaiPPTK->nomobile_pegawai))
                    }//END of if (!empty($modPegawaiPPTK))
                    //END OF Kirim SMS Dari Drafter ke PPTK Setelah Masukkan Kode SIRUP
                }//END OF (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA))

                if (strtolower($model->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)) {
                    // Kirim SMS Dari Drafter ke PPK Setelah Masukkan Kode SIRUP
                    $nama_modul = Yii::app()->controller->module->id;
                    $nama_controller = Yii::app()->controller->id;
                    $nama_action = Yii::app()->controller->action->id;
                    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                    $criteria = new CDbCriteria;
                    $criteria->compare('modul_id', $modul_id);
                    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                    $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                    $modSmsgateway = SmsgatewayM::model()->find($criteria);

                    if (!empty($modSmsgateway)) {
                        $template = $modSmsgateway->templatesms;
                    } else {
                        $template = "To PPK: RUP nomor {{nomor_rup}} tanggal {{tanggal_rup}} kategori pengadaan {{kategori_pengadaan}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera dibuat Persiapan Pengadaan.";
                    }

                    $modPegawaiPpk = PegawaiM::model()->findByPk($model->pegawaippk_id);


                    if (!empty($modPegawaiPpk)) {
                        $isiPesan = $template;
                        $attributes = $model->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            $isiPesan = str_replace("{{nomor_rup}}", $model->rencanaumumpengadaan_nomor, $isiPesan);
                            $isiPesan = str_replace("{{tanggal_rup}}", $model->rencanaumumpengadaan_tanggal, $isiPesan);
                            $isiPesan = str_replace("{{kategori_pengadaan}}", $model->rencanaumumpengadaan_kategori, $isiPesan);
                            $isiPesan = str_replace("{{metode_pengadaan}}", $model->metode_pengadaan, $isiPesan);
                            $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                            $isiPesan = str_replace("{{nama_pekerjaan}}", $model->nama_pekerjaan, $isiPesan);
                        }
                        $api = new MyAPI();
                        if (!empty($modPegawaiPpk->nomobile_pegawai)) {
                            $res = $api->smsBlastSend(array($modPegawaiPpk->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                            CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                        }//END OF if (!empty($modPegawaiPpk->nomobile_pegawai))
                    }//END of if (!empty($modPegawaiPpk))
                    //END OF Kirim SMS Dari Drafter ke PPK Setelah Masukkan Kode SIRUP
                }//END of (strtolower($model->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA))
            }//END OF (isset($_POST['RencanaumumpengadaanT']))
            Yii::app()->end();
        }
    }

    /**
     * Digunakan untuk mengumumkan rencana umum pengadaan
     */
    public function actionUmumkan() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $model = RencanaumumpengadaanT::model()->findByPk($id);
            $model->rencanaumumpengadaan_status = 'RUP Diumumkan';
            $model->save();
            $riwayat = new RiwayatpengadaanR;
            $riwayat->rencanaumumpengadaan_id = $id;
            $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $riwayat->pegawai_id = $pegawai->pegawai_id;
            $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $riwayat->pegawai_id));
            $riwayat->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
            $riwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
            $riwayat->status_berkas = 'RUP Diumumkan';
            $riwayat->create_time = date('Y-m-d H:i:s');
            $riwayat->tanggal_update = date('Y-m-d H:i:s');
            $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $riwayat->save();

            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil diubah.</div>",
                ));
                exit;
            }//if (Yii::app()->request->isAjaxRequest)
        }//if (Yii::app()->request->isPostRequest)
        else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Digunakan untuk mengumumkan rencana umum pengadaan lebih dari satu
     */
    public function actionUmumkanSemua() {
        $this->layout = '//layouts/iframe';
        $riwayat = new RiwayatpengadaanR;
        $cri = new CDbCriteria();
        $cri->addInCondition(" rencanaumumpengadaan_id ", $_GET['RencanaumumpengadaanT']['id']);
        $modRup = RencanaumumpengadaanT::model()->findAll($cri);

        if (isset($_POST['RencanaumumpengadaanT'])) {
            $trans = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $url = '';
                foreach ($_POST['RencanaumumpengadaanT'] as $det) {
                    $url .= '&RencanaumumpengadaanT[id][]=' . $det['rencanaumumpengadaan_id'];
                    $modRup = RencanaumumpengadaanT::model()->findByPk($det['rencanaumumpengadaan_id']);
                    $modRup->attributes = $det;

                    $model = RencanaumumpengadaanT::model()->findByPk($det['rencanaumumpengadaan_id']);
                    $model->rencanaumumpengadaan_status = 'RUP Diumumkan';
                    $ok = $ok && $model->save();

                    $riwayat = new RiwayatpengadaanR;
                    $riwayat->rencanaumumpengadaan_id = $det['rencanaumumpengadaan_id'];

                    $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    $riwayat->pegawai_id = $pegawai->pegawai_id;

                    $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $riwayat->pegawai_id));
                    $riwayat->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
                    $riwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
                    $riwayat->status_berkas = 'RUP Diumumkan';
                    $riwayat->create_time = date('Y-m-d H:i:s');
                    $riwayat->tanggal_update = date('Y-m-d H:i:s');
                    $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $ok = $ok && $riwayat->save();

                    // Kirim SMS Dari PA ke Drafter Setelah Klik Diumumkan
                    $nama_modul = Yii::app()->controller->module->id;
                    $nama_controller = Yii::app()->controller->id;
                    $nama_action = Yii::app()->controller->action->id;
                    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                    $criteria = new CDbCriteria;
                    $criteria->compare('modul_id', $modul_id);
                    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                    $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                    $modSmsgateway = SmsgatewayM::model()->find($criteria);

                    if (!empty($modSmsgateway)) {
                        $template = $modSmsgateway->templatesms;
                    } else {
                        $template = "To Drafter: RUP nomor {{nomor_rup}} tanggal {{tanggal_rup}} kategori pengadaan {{kategori_pengadaan}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera dimasukkan nomer SIRUPnya.";
                    }

                    $modPegawaiPembuat = PegawaiM::model()->findByPk($model->pegawaipembuat_id);

                    if (!empty($modPegawaiPembuat)) {
                        $isiPesan = $template;
                        $attributes = $model->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            $isiPesan = str_replace("{{nomor_rup}}", $model->rencanaumumpengadaan_nomor, $isiPesan);
                            $isiPesan = str_replace("{{tanggal_rup}}", $model->rencanaumumpengadaan_tanggal, $isiPesan);
                            $isiPesan = str_replace("{{kategori_pengadaan}}", $model->rencanaumumpengadaan_kategori, $isiPesan);
                            $isiPesan = str_replace("{{metode_pengadaan}}", $model->metode_pengadaan, $isiPesan);
                            $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                            $isiPesan = str_replace("{{nama_pekerjaan}}", $model->nama_pekerjaan, $isiPesan);
                        }
                        $api = new MyAPI();
                        if (!empty($modPegawaiPembuat->nomobile_pegawai)) {
                            $res = $api->smsBlastSend(array($modPegawaiPembuat->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                            CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                        }//END OF if (!empty($modPegawaiPembuat->nomobile_pegawai))
                    }//END of if (!empty($modPegawaiPembuat))
                    //END OF Kirim SMS Dari PA ke Drafter 
                }

                if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('umumkanSemua' . $url, 'sukses' => 1));
                } else {
                    $cri = new CDbCriteria();
                    $cri->addInCondition(" rencanaumumpengadaan_id ", $_GET['RencanaumumpengadaanT']['id']);
                    $modRup = RencanaumumpengadaanT::model()->findAll($cri);

                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($riwayat));
                }
            } catch (Exception $e) {
                $cri = new CDbCriteria();
                $cri->addInCondition(" rencanaumumpengadaan_id ", $_GET['RencanaumumpengadaanT']['id']);
                $modRup = RencanaumumpengadaanT::model()->findAll($cri);

                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
            }

            $this->render('pengadaan.views.informasiRencanaUmum.test');
        }
        // else
        // {
        // }

        $this->render('pengadaan.views.informasiRencanaUmum.detailRup', array('modRup' => $modRup));
    }

    /**
     * Digunakan untuk menampilkan halaman detail
     * @author Andyka Putra <andykaputra@.com>
     * @param type $id
     * @param type $iframe
     */
    public function actionDetail($id, $iframe = null) {

        if (!empty($iframe)) {
            $this->layout = '//layouts/iframe';
        }

        $modLokasi = new PengadaanlokasiT;
        $modSumberDana = new PengadaansumberdanaT;
        $modJenis = new PengadaanjenisT;
        $arrLokasi = array();
        $arrSumberDana = array();
        $arrJenis = array();
        $loadRiwayat = array();

        $model = ADRencanaumumpengadaanT::model()->findByPk($id);
        $model->pegawaipembuat_nama = $model->pegawaipembuat->namaLengkap;
        $model->unitkerja_nama = $model->unitkerja->namaunitkerja;
        $model->subprogram_nama = $model->subprogram->subprogramkerja_nama;
        $model->subkegiatanprogram_nama = $model->subkegiatanprogram->subkegiatanprogram_nama;
        $model->is_hutang = !empty($model->is_hutang) ? 1 : 0;
        if (!empty($model->pegawaipembuat_id)) { //Load data pegawai dari Log-In serta Unit Kerja
            $pegawai = PegawaiM::model()->findByPk($model->pegawaipembuat_id);
            $model->pegawaipembuat_nama = $pegawai->namaLengkap;
            $model->unitkerja_id = $pegawai->unitkerja_id;
            $model->unitkerja_nama = !empty($model->unitkerja_id) ? UnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja : "-";
        }
        $arrLokasi = PengadaanlokasiT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $arrSumberDana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $arrJenis = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));

        $modRAB = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modRiwayat = new ADRiwayatpengadaanR('searchRiwayat2');

        $loadRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));


        $this->render('detail', array(
            'model' => $model,
            'modLokasi' => $modLokasi,
            'modRAB' => $modRAB,
            'modSumberDana' => $modSumberDana,
            'modRiwayat' => $modRiwayat,
            'modJenis' => $modJenis,
            'arrLokasi' => $arrLokasi,
            'arrSumberDana' => $arrSumberDana,
            'arrJenis' => $arrJenis,
            'loadRiwayat' => $loadRiwayat
        ));
    }

    /**
     * Fungsi unduh lampiran riwayat
     * @author Andyka Putra <andykaputra@.com>
     * @param integer $riwayatpengadaan_id
     */
    public function actionUnduhLampiran($riwayatpengadaan_id) {

        $filename = ADRiwayatpengadaanR::model()->findByPk($riwayatpengadaan_id);

        $path = Params::pathLampiranRiwayatPengadaanDirectory() . $filename->riwayatpengadaan_lampiran;

        if (!empty($filename->riwayatpengadaan_lampiran)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->riwayatpengadaan_lampiran, file_get_contents($path));
            } else {
                $path2 = Params::pathDokRencanaUmumPengadaanDirectory() . "/" . $filename->riwayatpengadaan_lampiran;
                if (!empty($filename->riwayatpengadaan_lampiran)) {
                    if (file_exists($path2)) {
                        Yii::app()->getRequest()->sendFile($filename->riwayatpengadaan_lampiran, file_get_contents($path2));
                    } else {
                        Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathDokRencanaUmumPengadaanDirectory() . 'file_tidak_ditemukan.txt'));
                    }
                } else {
                    Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
                }
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
        }
    }

    /**
     * Fungsi unduh dokumen pendukung
     * @author Andyka Putra <andykaputra@.com>
     * @param integer $dokumenpendukungpengadaan_id
     */
    public function actionUnduhDokDukung($dokumenpendukungpengadaan_id) {

        $filename = ADPengadaandokumenpendukungT::model()->findByPk($dokumenpendukungpengadaan_id);

        $path = Params::pathDokPersiapanPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;

        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' .'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' .'file_tidak_ditemukan.txt'));
        }
    }

    /**
     * Fungsi unduh dokumen pendukung
     * @param type $dokumenpendukungpengadaan_id
     */
    public function actionUnduhDokDukungRUP($dokumenpendukungpengadaan_id) {

        $filename = ADPengadaandokumenpendukungT::model()->findByPk($dokumenpendukungpengadaan_id);

        $path = Params::pathDokRencanaUmumPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;

        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
        }
    }

    /**
     * Digunakan untuk menampilkan halaman review
     * @author Andyka Putra <andykaputra@.com>
     * @param type $id
     */
    public function actionReview($id) {
        $ok = true;
        $modLokasi = new PengadaanlokasiT;
        $modSumberDana = new PengadaansumberdanaT;
        $modJenis = new PengadaanjenisT;
        $arrLokasi = array();
        $arrSumberDana = array();
        $arrJenis = array();
        $loadRiwayat = array();
        
        $konfig = KonfigsystemK::model()->find();

        $model = ADRencanaumumpengadaanT::model()->findByPk($id);
        $model->pegawaipembuat_nama = $model->pegawaipembuat->namaLengkap;
        $model->unitkerja_nama = $model->unitkerja->namaunitkerja;
        $model->subprogram_nama = $model->subprogram->subprogramkerja_nama;
        $model->subkegiatanprogram_nama = $model->subkegiatanprogram->subkegiatanprogram_nama;

        $status_sebelum = $model->rencanaumumpengadaan_status;
        $model->is_hutang = !empty($model->is_hutang) ? 1 : 0;
        
        if (!empty($model->pegawaipembuat_id)) { //Load data pegawai dari Log-In serta Unit Kerja
            $pegawai = PegawaiM::model()->findByPk($model->pegawaipembuat_id);
            $model->pegawaipembuat_nama = $pegawai->namaLengkap;
            $model->unitkerja_id = $pegawai->unitkerja_id;
            $model->unitkerja_nama = !empty($model->unitkerja_id) ? UnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja : "-";
        }

        $arrLokasi = PengadaanlokasiT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $arrSumberDana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $arrJenis = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));

        $modRAB = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modRiwayat = new ADRiwayatpengadaanR('searchRiwayat2');

        $loadRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modRiwayatPengadaan = new RiwayatpengadaanR();
        if (isset($_POST['RiwayatpengadaanR'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modRiwayatPengadaan->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $peg = ADPegawaiM::model()->findByPk($modRiwayatPengadaan->pegawai_id);
                $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modRiwayatPengadaan->pegawai_id));
                $modRiwayatPengadaan->nama_pegawai = !empty($peg) ? $peg->namaLengkap : '';
                $modRiwayatPengadaan->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
                $modRiwayatPengadaan->create_time = date('Y-m-d H:i:s');
                $modRiwayatPengadaan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modRiwayatPengadaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modRiwayatPengadaan->tanggal_update = date('Y-m-d H:i:s');
                $modRiwayatPengadaan->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                $modRiwayatPengadaan->status_berkas = $model->rencanaumumpengadaan_status;
                $modRiwayatPengadaan->riwayatpengadaan_catatan = $_POST['RiwayatpengadaanR']['riwayatpengadaan_catatan'];
                $modRiwayatPengadaan->riwayatpengadaan_lampiran = CUploadedFile::getInstance($modRiwayatPengadaan, 'riwayatpengadaan_lampiran');

                if (!empty($modRiwayatPengadaan->riwayatpengadaan_lampiran)) {
                    $file = $modRiwayatPengadaan->riwayatpengadaan_lampiran;
                    if (!empty($modRiwayatPengadaan->riwayatpengadaan_lampiran)) {
                        $fullDocName = str_replace(' ', '_', strtolower(date('dmY_s') . $file));
                        $fullDocSource = Params::pathLampiranRiwayatPengadaanDirectory() . $fullDocName;
                        $modRiwayatPengadaan->riwayatpengadaan_lampiran = $fullDocName;
                        $modRiwayatPengadaan->save();
                    }
                    
                    if (!file_exists(Params::pathLampiranRiwayatPengadaanDirectory())){
                        mkdir(Params::pathLampiranRiwayatPengadaanDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }

                $riwayat = new RiwayatpengadaanR;
                $modRencana = RencanaumumpengadaanT::model()->findByPk($id);
                $riwayat->rencanaumumpengadaan_id = $id;
                $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $riwayat->pegawai_id = $pegawai->pegawai_id;
                $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $riwayat->pegawai_id));
                $riwayat->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
                $riwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';

                if ($_POST['RiwayatpengadaanR']['statusnya'] == Params::STATUS_PENGAJUAN_DISETUJUI) {
                    if (strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK)) {
                        
                        if ($konfig->is_simplifikasipengadaan == true){
                            $riwayat->status_berkas = Params::STATUS_RENCANA_UMUM_RUP_DIUMUMKAN;
                            $modRencana->rencanaumumpengadaan_status = Params::STATUS_RENCANA_UMUM_RUP_DIUMUMKAN;
                        }else{
                            $riwayat->status_berkas = "Disetujui PPK";
                            $modRencana->rencanaumumpengadaan_status = 'Persetujuan KPA';
                        }

                        // Kirim SMS Dari PPK ke KPA 
                        $nama_modul = Yii::app()->controller->module->id;
                        $nama_controller = Yii::app()->controller->id;
                        $nama_action = Yii::app()->controller->action->id;
                        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                        $criteria = new CDbCriteria;
                        $criteria->compare('modul_id', $modul_id);
                        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                        $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                        $modSmsgateway = SmsgatewayM::model()->find($criteria);

                        if (!empty($modSmsgateway)) {
                            $template = $modSmsgateway->templatesms;
                        } else {
                            $template = "To KPA: RUP nomor {{nomor_rup}} tanggal {{tanggal_rup}} kategori pengadaan {{kategori_pengadaan}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera diverifikasi.";
                        }

                        $modPegawaiKpa = PegawaiM::model()->findByPk($model->pegawaikpa_id);

                        if (!empty($modPegawaiKpa)) {
                            $isiPesan = $template;
                            $attributes = $model->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                $isiPesan = str_replace("{{nomor_rup}}", $model->rencanaumumpengadaan_nomor, $isiPesan);
                                $isiPesan = str_replace("{{tanggal_rup}}", $model->rencanaumumpengadaan_tanggal, $isiPesan);
                                $isiPesan = str_replace("{{kategori_pengadaan}}", $model->rencanaumumpengadaan_kategori, $isiPesan);
                                $isiPesan = str_replace("{{metode_pengadaan}}", $model->metode_pengadaan, $isiPesan);
                                $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                                $isiPesan = str_replace("{{nama_pekerjaan}}", $model->nama_pekerjaan, $isiPesan);
                            }
                            $api = new MyAPI();
                            if (!empty($modPegawaiKpa->nomobile_pegawai)) {
                                $res = $api->smsBlastSend(array($modPegawaiKpa->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                                CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                            }//END OF if (!empty($modPegawaiKpa->nomobile_pegawai))
                        }//END of if (!empty($modPegawaiKpa))
                        //END OF  Kirim SMS Dari PPK ke KPA 
                    } else if (strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_KPA)) {
                        $riwayat->status_berkas = "Disetujui KPA";
                        $modRencana->rencanaumumpengadaan_status = 'Persetujuan PA';

                        // Kirim SMS Dari KPA ke PA 
                        $nama_modul = Yii::app()->controller->module->id;
                        $nama_controller = Yii::app()->controller->id;
                        $nama_action = Yii::app()->controller->action->id;
                        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                        $criteria = new CDbCriteria;
                        $criteria->compare('modul_id', $modul_id);
                        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                        $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                        $modSmsgateway = SmsgatewayM::model()->find($criteria);

                        if (!empty($modSmsgateway)) {
                            $template = $modSmsgateway->templatesms;
                        } else {
                            $template = "To PA: RUP nomor {{nomor_rup}} tanggal {{tanggal_rup}} kategori pengadaan {{kategori_pengadaan}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera diverifikasi.";
                        }

                        $modPegawaiPa = PegawaiM::model()->findByPk($model->pegawaipa_id);

                        if (!empty($modPegawaiPa)) {
                            $isiPesan = $template;
                            $attributes = $model->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                $isiPesan = str_replace("{{nomor_rup}}", $model->rencanaumumpengadaan_nomor, $isiPesan);
                                $isiPesan = str_replace("{{tanggal_rup}}", $model->rencanaumumpengadaan_tanggal, $isiPesan);
                                $isiPesan = str_replace("{{kategori_pengadaan}}", $model->rencanaumumpengadaan_kategori, $isiPesan);
                                $isiPesan = str_replace("{{metode_pengadaan}}", $model->metode_pengadaan, $isiPesan);
                                $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                                $isiPesan = str_replace("{{nama_pekerjaan}}", $model->nama_pekerjaan, $isiPesan);
                            }
                            $api = new MyAPI();
                            if (!empty($modPegawaiPa->nomobile_pegawai)) {
                                $res = $api->smsBlastSend(array($modPegawaiPa->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                                CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                            }//END OF if (!empty($modPegawaiPa->nomobile_pegawai))
                        }//END of (!empty($modPegawaiPa))
                        //END OF  Kirim SMS Dari KPA ke PA

                        $modPegawaiPa = PegawaiM::model()->findByPk($model->pegawaipa_id);

                        if (!empty($modPegawaiPa)) {
                            $isiPesan = $template;
                            $attributes = $model->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                $isiPesan = str_replace("{{nomor_rup}}", $model->rencanaumumpengadaan_nomor, $isiPesan);
                                $isiPesan = str_replace("{{tanggal_rup}}", $model->rencanaumumpengadaan_tanggal, $isiPesan);
                                $isiPesan = str_replace("{{kategori_pengadaan}}", $model->rencanaumumpengadaan_kategori, $isiPesan);
                                $isiPesan = str_replace("{{metode_pengadaan}}", $model->metode_pengadaan, $isiPesan);
                                $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                                $isiPesan = str_replace("{{nama_pekerjaan}}", $model->nama_pekerjaan, $isiPesan);
                            }
                            $api = new MyAPI();
                            if (!empty($modPegawaiPa->nomobile_pegawai)) {
                                $res = $api->smsBlastSend(array($modPegawaiPa->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                                CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                            }//END OF if (!empty($modPegawaiPa->nomobile_pegawai))
                        }//END of Kirim SMS ke PA 
                        //END OF  Kirim SMS Sebagai PPK ke PA
                    } else {
                        $riwayat->status_berkas = "Disetujui PA";
                        $modRencana->rencanaumumpengadaan_status = 'RUP Final';
                    }// ENF OF else {
                } else {
//                    $riwayat->status_berkas = Params::STATUS_PERSIAPAN_REVISI;
                    $cekLogin = Yii::app()->user->getState('pegawai_id');
                    if (($model->rencanaumumpengadaan_status == 'Persetujuan PPK' && $model->pegawaippk_id == $cekLogin)) {
                        $riwayat->status_berkas = 'Revisi TPP-RUP';
                        $modRencana->rencanaumumpengadaan_status = 'Revisi TPP-RUP';
                    } else if (($model->rencanaumumpengadaan_status == 'Persetujuan PA' && $model->pegawaipa_id == $cekLogin)) {
                        $riwayat->status_berkas = 'Revisi PPK';
                        $modRencana->rencanaumumpengadaan_status = 'Revisi PPK';
                    } else if (($model->rencanaumumpengadaan_status == 'Persetujuan KPA' && $model->pegawaikpa_id == $cekLogin)) {
                        $riwayat->status_berkas = 'Revisi PPK';
                        $modRencana->rencanaumumpengadaan_status = 'Revisi PPK';
                    }
                }

                $riwayat->create_time = date('Y-m-d H:i:s');
                $riwayat->tanggal_update = date('Y-m-d H:i:s');
                $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $ok = $modRiwayatPengadaan->save() && $riwayat->save() && $modRencana->update();
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('review', 'id' => $id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan!</strong> ');
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan." . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('review', array(
            'model' => $model,
            'modLokasi' => $modLokasi,
            'modRAB' => $modRAB,
            'modSumberDana' => $modSumberDana,
            'modRiwayat' => $modRiwayat,
            'modJenis' => $modJenis,
            'arrLokasi' => $arrLokasi,
            'arrSumberDana' => $arrSumberDana,
            'arrJenis' => $arrJenis,
            'loadRiwayat' => $loadRiwayat,
            'modRiwayatPengadaan' => $modRiwayatPengadaan
        ));
    }

    /**
     * Digunakan untuk menampilkan halaman update
     * @author Aida Rahmawati <aidarahmawati@.com>
     * @param type $id
     */
    public function actionUbah($id) {
        $modLokasi = new PengadaanlokasiT;
        $lokasi = new PengadaanlokasiT;
        $modSumberDana = new PengadaansumberdanaT;
        $modDana = new PengadaansumberdanaT;
        $modJenis = new PengadaanjenisT;
        $jenis = new PengadaanjenisT();
        $arrLokasi = array();
        $arrSumberDana = array();
        $arrJenis = array();
        $loadRiwayat = array();
        
        $konfig = KonfigsystemK::model()->find();
        
        $ok = true;
        $modDokumen = new PengadaandokumenpendukungT();
        $model = ADRencanaumumpengadaanT::model()->findByPk($id);
        $model->pegawaipembuat_nama = $model->pegawaipembuat->namaLengkap;
        $model->unitkerja_nama = $model->unitkerja->namaunitkerja;
        $model->subprogram_nama = $model->subprogram->subprogramkerja_nama;
        $model->isprodukdalamnegeri = ($model->isprodukdalamnegeri) ? 1 : 0;
        $model->isusahakecil = ($model->isusahakecil) ? 1 : 0;
        $model->is_hutang = !empty($model->is_hutang) ? 1 : 0;
        $model->subkegiatanprogram_nama = $model->subkegiatanprogram->subkegiatanprogram_nama;
        $model->dpa_pagu_temp = $model->dpa_pagu;
        $model->pegawaipa_nama = !empty($model->pegawaipa_id) ? $model->pegawaipa->namaLengkap : '';
        $model->pegawaikpa_nama = !empty($model->pegawaikpa_id) ? $model->pegawaikpa->namaLengkap : '';
        $model->pegawaippk_nama = !empty($model->pegawaippk_id) ? $model->pegawaippk->namaLengkap : '';
        //$model->statusnya = $model->rencanaumumpengadaan_status;

        if (!empty($model->pegawaipembuat_id)) { //Load data pegawai dari Log-In serta Unit Kerja
            $pegawai = PegawaiM::model()->findByPk($model->pegawaipembuat_id);
            $model->pegawaipembuat_nama = $pegawai->namaLengkap;
            $model->unitkerja_id = $pegawai->unitkerja_id;
            $model->unitkerja_nama = !empty($model->unitkerja_id) ? UnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja : "-";
        }

        if ($model->isprodukdalamnegeri == false) {
            $model->isprodukdalamnegeri = 0;
        } else if ($model->isprodukdalamnegeri == true) {
            $model->isprodukdalamnegeri = 1;
        }

        if ($model->isusahakecil == false) {
            $model->isusahakecil = 0;
        } else if ($model->isusahakecil == true) {
            $model->isusahakecil = 1;
        }

        if ($model->ispradpa == false) {
            $model->ispradpa = 0;
        } else if ($model->ispradpa == true) {
            $model->ispradpa = 1;
        }

        if ($model->isdikecualikan === false) {
            $model->isdikecualikan = '0';
        } elseif ($model->isdikecualikan === true) {
            $model->isdikecualikan = '1';
        }

        if ($model->ispaket === false) {
            $model->ispaket = 'tidak';
        } elseif ($model->ispaket === true) {
            $model->ispaket = 'ada';
        }

        $modRAB = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modRiwayat = new ADRiwayatpengadaanR('searchRiwayat2');

        $loadRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modRiwayatPengadaan = new RiwayatpengadaanR();
//        $modRiwayatPengadaan->riwayatpengadaan_catatan = 'Mengubah Rencana Umum Pengadaan';
        $model->metodepengadaan_id_awal = $model->metodepengadaan_id;
        if (isset($_POST['ADRencanaumumpengadaanT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = ADRencanaumumpengadaanT::model()->findByPk($id);
                $model->attributes = $_POST['ADRencanaumumpengadaanT'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;

                $model->total_pagu = $_POST['total_hargaseluruhnya'];
                $model->dpa_pagu = $_POST['ADRencanaumumpengadaanT']['dpa_pagu'];
                if ($model->ispaket == 'ada') {
                    $model->ispaket = true;
                } else {
                    $model->ispaket = false;
                }
                
                if (!empty($model->metodepengadaan_id)) {
                    $modMetode = MetodepengadaanM::model()->findByPk($model->metodepengadaan_id);
                    $model->metode_pengadaan = $modMetode->metodepengadaan_nama; 
                    
                    if ($model->metodepengadaan_id !== $_POST['ADRencanaumumpengadaanT']['metodepengadaan_id_awal']) {
                        $this->ubah_metode = true;
                    }
                }                   
                
                $ok = $ok && $model->save();

                if (isset($_POST['PengadaanlokasiT'])) {
                    foreach ($_POST['PengadaanlokasiT'] as $key => $value) {
                        $modLokasi = PengadaanlokasiT::model()->findByPk($value['pengadaanlokasi_id']);
                        if (empty($modLokasi)) {
                            $modLokasi = new PengadaanlokasiT;
                        }
                        $modLokasi->attributes = $value;
                        $modLokasi->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                        $ok = $ok && $modLokasi->save();
                    }
                }

                /*  hapus rab */
                if (isset($_POST['delete']['lokasi'])) {
                    $idDel = array();
                    foreach ($_POST['delete']['lokasi'] as $del) {
                        $idDel[] = $del;
                    }

                    $criDel = new CDbCriteria();
                    $criDel->addInCondition("pengadaanlokasi_id", $idDel);
                    $ok = $ok && PengadaanlokasiT::model()->deleteAll($criDel);
                }

                if (isset($_POST['PengadaansumberdanaT'])) {
                    foreach ($_POST['PengadaansumberdanaT'] as $key => $value) {
                        $modSumberDana = PengadaansumberdanaT::model()->findByPk($value['pengadaansumberdana_id']);
                        if (empty($modSumberDana)) {
                            $modSumberDana = new PengadaansumberdanaT;
                        }
                        $modSumberDana->attributes = $value;
                        $modSumberDana->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                        $ok = $ok && $modSumberDana->save();
                    }
                }

                /*  hapus rab */
                if (isset($_POST['delete']['sumberdana'])) {
                    $idDel = array();
                    foreach ($_POST['delete']['sumberdana'] as $del) {
                        $idDel[] = $del;
                    }

                    $criDel = new CDbCriteria();
                    $criDel->addInCondition("pengadaansumberdana_id", $idDel);
                    $ok = $ok && PengadaansumberdanaT::model()->deleteAll($criDel);
                }

                /* Simpan jenis pengadaan */
                if (isset($_POST['PengadaanjenisT'])) {
                    foreach ($_POST['PengadaanjenisT'] as $key => $value) {
                        $modJenis = PengadaanjenisT::model()->findByPk($value['pengadaanjenis_id']);
                        if (empty($modJenis)) {
                            $modJenis = new PengadaanjenisT;
                        }
                        $modJenis->attributes = $value;
                        if ($value['pengadaanjenis_id_awal'] != $modJenis->jenispengadaan_id) {
                            $this->ubah_jenis = true;
                        }
                        
                        $modJenis->attributes = $value;
                        $modJenis->rencanaumumpengadaan_id = $id;
                        $modJenis->jenispengadaan_nama = !empty($modJenis->jenispengadaan_id) ? $modJenis->jenispengadaan->jenispengadaan_nama : null;
                        $ok = $ok && $modJenis->save();
                    }
                }
                
                /*  hapus jenis pengadaan */
                if (isset($_POST['delete']['jenis'])) {
                    $idDel = array();
                    foreach ($_POST['delete']['jenis'] as $del) {
                        $idDel[] = $del;
                    }

                    $criDel = new CDbCriteria();
                    $criDel->addInCondition("pengadaanjenis_id", $idDel);
                    $ok = $ok && PengadaanjenisT::model()->deleteAll($criDel);
                }

                /* Simpan rencana umum pengadaan */
                if (isset($_POST['RencanaumumpengadaandetT'])) {
                    foreach ($_POST['RencanaumumpengadaandetT']['detail'] as $key => $value) {
                        $modDet = new RencanaumumpengadaandetT;
                        if (!empty($value['rencanaumumpengadaandet_id'])) {
                            $cekDet = RencanaumumpengadaandetT::model()->findByPk($value['rencanaumumpengadaandet_id']);
                            $temp_jum = $cekDet->rencanaumumpengadaandet_jumlah;
                            $temp_vol = $cekDet->rencanaumumpengadaandet_volume;
                            $modDet = $cekDet;
                            if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Draft' || $_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Pengajuan') {
                                $modDet->attributes = $value;
                                $modDet->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                                $modDpadet = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);
                                $selisih_pagu = $value['rencanaumumpengadaandet_jumlah'];
                                $selisih_volume = $value['rencanaumumpengadaandet_volume'];

                                $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan + $temp_jum - $selisih_pagu;
                                $modDpadet->sisavolume_pengadaan = $modDpadet->sisavolume_pengadaan + $temp_vol - $selisih_volume;

                                if ($modDpadet->sisapagu_pengadaan == 0) {
                                    if ($modDpadet->harga_satuan > 0 && $modDpadet->volume > 0) {
                                        $modDpadet->pengadaan_status = true;
                                    }
                                } else if ($modDpadet->sisapagu_pengadaan > 0) {
                                    $modDpadet->pengadaan_status = false;
                                }
                                $modDpadet->save();

                                // Kirim SMS Dari Drafter ke PPK
                                $nama_modul = Yii::app()->controller->module->id;
                                $nama_controller = Yii::app()->controller->id;
                                $nama_action = Yii::app()->controller->action->id;
                                $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                                $criteria = new CDbCriteria;
                                $criteria->compare('modul_id', $modul_id);
                                $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                                $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                                $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                                $modSmsgateway = SmsgatewayM::model()->find($criteria);

                                if (!empty($modSmsgateway)) {
                                    $template = $modSmsgateway->templatesms;
                                } else {
                                    $template = "To PPK: RUP nomor {{nomor_rup}} tanggal {{tanggal_rup}} kategori pengadaan {{kategori_pengadaan}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera diverifikasi.";
                                }

                                $modPegawaiPpk = PegawaiM::model()->findByPk($model->pegawaippk_id);

                                if (!empty($modPegawaiPpk)) {
                                    $isiPesan = $template;
                                    $attributes = $model->getAttributes();
                                    foreach ($attributes as $attributes => $value) {
                                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                                        $isiPesan = str_replace("{{nomor_rup}}", $model->rencanaumumpengadaan_nomor, $isiPesan);
                                        $isiPesan = str_replace("{{tanggal_rup}}", $model->rencanaumumpengadaan_tanggal, $isiPesan);
                                        $isiPesan = str_replace("{{kategori_pengadaan}}", $model->rencanaumumpengadaan_kategori, $isiPesan);
                                        $isiPesan = str_replace("{{metode_pengadaan}}", $model->metode_pengadaan, $isiPesan);
                                        $isiPesan = str_replace("{{nama_unitkerja}}", $model->unitkerja->namaunitkerja, $isiPesan);
                                        $isiPesan = str_replace("{{nama_pekerjaan}}", $model->nama_pekerjaan, $isiPesan);
                                    }
                                    $api = new MyAPI();
                                    if (!empty($modPegawaiPpk->nomobile_pegawai)) {
                                        $res = $api->smsBlastSend(array($modPegawaiPpk->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                                        CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                                    }//END OF if (!empty($modPegawaiPpk))
                                }//END of // Kirim SMS Dari Drafter Ke PPK
                                //END OF  Kirim SMS Dari Drafter Ke PPK
                            }//if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Draft'
                        } else {
                            if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Draft' || $_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Pengajuan') {
                                $modDpadet = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);

                                $selisih_pagu = $value['rencanaumumpengadaandet_jumlah'] - 0;
                                $selisih_volume = $value['rencanaumumpengadaandet_volume'] - 0;

                                $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan - $selisih_pagu;
                                $modDpadet->sisavolume_pengadaan = $modDpadet->sisavolume_pengadaan - $selisih_volume;
                                if ($modDpadet->sisapagu_pengadaan == 0) {
                                    if ($modDpadet->harga_satuan > 0 && $modDpadet->volume > 0) {
                                        $modDpadet->pengadaan_status = true;
                                    }
                                } else if ($modDpadet->sisapagu_pengadaan > 0) {
                                    $modDpadet->pengadaan_status = false;
                                }
                                $modDpadet->save();
                            }
                            $modDet = new RencanaumumpengadaandetT;
                            $modDet->attributes = $value;
                            $modDet->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                            $modDet->paketpekerjaan_id = !empty($value['paketpekerjaan_id']) ? $value['paketpekerjaan_id'] : null;
                        }
                        $ok = $ok && $modDet->save();

                        if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Pengajuan') {
                            //if ($model->rencanaumumpengadaan_status == 'Revisi') {
//                                if (!empty($modDet->dokumenpelaksanaananggarandet_id)){
//                                    $modDokAnggaranDet = DokumenpelaksanaananggarandetT::model()->findByPk($modDet->dokumenpelaksanaananggarandet_id);
//                                    $modDokAnggaranDet->pengadaan_status = true;
//                                    $modDokAnggaranDet->save();
//                                }
                            //} 
                        }
                    }
                }

                /*  hapus rab */
                if (isset($_POST['delete']['rab'])) {
                    $idDel = array();
                    foreach ($_POST['delete']['rab'] as $del) {
                        $idDel[] = $del;
                    }

                    $criDel = new CDbCriteria();
                    $criDel->addInCondition("rencanaumumpengadaandet_id", $idDel);
                    $cekDet = RencanaumumpengadaandetT::model()->findAll($criDel);

                    foreach ($cekDet as $value) {
                        $modDpadet = DokumenpelaksanaananggarandetT::model()->findByPk($value->dokumenpelaksanaananggarandet_id);

                        $selisih_pagu = $value->rencanaumumpengadaandet_jumlah;
                        $selisih_volume = $value->rencanaumumpengadaandet_volume;

                        $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan + $selisih_pagu;
                        $modDpadet->sisavolume_pengadaan = $modDpadet->sisavolume_pengadaan + $selisih_volume;
                        if ($modDpadet->sisapagu_pengadaan == 0) {
                            $modDpadet->pengadaan_status = true;
                        } else if ($modDpadet->sisapagu_pengadaan > 0) {
                            $modDpadet->pengadaan_status = false;
                        }
                        $modDpadet->save();
                    }

                    $ok = $ok && RencanaumumpengadaandetT::model()->deleteAll($criDel);
                }

                if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Persetujuan PPK') {
                    /* Update Dokumen pelaksanaan anggaran det */
                    if (isset($_POST['RencanaumumpengadaandetT'])) {
                        foreach ($_POST['RencanaumumpengadaandetT'] as $key => $value) {
                            $modDok = DokumenpelaksanaananggarandetT::model()->findByAttributes(array('subkegiatanprogram_id' => $model->subkegiatanprogram_id, 'barang_id' => $value['barang_id']));
                            if ($modDok->harga_satuan > 0 && $modDok->volume > 0) {
                                $modDok->pengadaan_status = true;
                            }

                            $ok = $ok && $modDet->save();
                        }//END OF foreach ($_POST['RencanaumumpengadaandetT']
                    }//END OF if (isset($_POST['RencanaumumpengadaandetT']))
                }//END OF if($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Persetujuan PPK')

                $temp = '';
                if (isset($_POST['PengadaandokumenpendukungT'])) {
                    if ($this->ubah_metode == true || $this->ubah_jenis == true) { // hapus seluruh dokumen jika metode atau jenis pengadan berubah 
                        PengadaandokumenpendukungT::model()->deleteAllByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
                    } 
                    
                    foreach ($_POST['PengadaandokumenpendukungT'] as $i => $load) {
                            $dokumen_pendukung = null;
                            $modDok = PengadaandokumenpendukungT::model()->findByPk($load['dokumenpendukungpengadaan_id']);
                            if (empty($modDok)) {
                                $modDok = new PengadaandokumenpendukungT();
                                $modDok->attributes = $model->attributes;
                                $modDok->attributes = $load;
                                $modDok->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                                $modDok->create_time = date('Y-m-d H:i:s');
                                $modDok->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDok->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modDok->dokumenpendukungpengadaan_file = CUploadedFile::getInstance($modDok, '[' . $i . ']dokumenpendukungpengadaan_file');
                                if (!empty($modDok->dokumenpendukungpengadaan_file)) {
                                    $dokumen_pendukung = $modDok->dokumenpendukungpengadaan_file;
                                    $fullImgName = $modDok->dokumenpendukungpengadaan_nama . "_" . $model->rencanaumumpengadaan_nomor . '.' . $dokumen_pendukung->getExtensionName();
                                    $fullImgSource = Params::pathDokRencanaUmumPengadaanDirectory() . $fullImgName;
                                    $modDok->dokumenpendukungpengadaan_file = $fullImgName;
                                    $ok = $ok && $modDok->save();
                                }
                            } else {
                                $modDok->attributes = $model->attributes;
                                $modDok->attributes = $load;
                                $modDok->update_time = date('Y-m-d H:i:s');
                                $modDok->dokumenpendukungpengadaan_file = $modDok->temp_file;
                                $modDok->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDok->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                                $modDok->create_time = date('Y-m-d H:i:s');
                                $modDok->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDok->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modDok->dokumenpendukungpengadaan_file = CUploadedFile::getInstance($modDok, '[' . $i . ']dokumenpendukungpengadaan_file');

                                if (!empty($modDok->dokumenpendukungpengadaan_file)) {
                                    $dokumen_pendukung = $modDok->dokumenpendukungpengadaan_file;
                                    $fullImgName = $modDok->dokumenpendukungpengadaan_nama . "_" . $model->rencanaumumpengadaan_nomor . '.' . $dokumen_pendukung->getExtensionName();
                                    $fullImgSource = Params::pathDokRencanaUmumPengadaanDirectory() . $fullImgName;

                                    $modDok->dokumenpendukungpengadaan_file = $fullImgName;

                                    $ok = $ok && $modDok->save();
                                } else {
                                    
                                }
                            }

                            if (!empty($dokumen_pendukung)) {        //     
                                
                                if (!file_exists(Params::pathDokRencanaUmumPengadaanDirectory())){
                                    mkdir(Params::pathDokRencanaUmumPengadaanDirectory(), 0775, true);
                                }
                                
                                $dokumen_pendukung->saveAs($fullImgSource);
                            }
                    }
                }

                $temp = '';
                $dokumen_pendukung = null;
                if (isset($_POST['RiwayatpengadaanR'])) {
                    $modRiwayatPengadaan->pegawai_id = Yii::app()->user->getState('pegawai_id');
                    $pegawai = PegawaiM::model()->findByPk($modRiwayatPengadaan->pegawai_id);
                    $modRiwayatPengadaan->nama_pegawai = $pegawai->namaLengkap;
                    $modRiwayatPengadaan->tanggal_update = date('Y-m-d H:i:s');
                    $modRiwayatPengadaan->riwayatpengadaan_catatan = $_POST['RiwayatpengadaanR']['riwayatpengadaan_catatan'];
                    $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modRiwayatPengadaan->pegawai_id));
                    $jabppk = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $modRiwayatPengadaan->pegawai_id, 'jabatan_pengadaan' => 'PPK'));
                    if (!empty($jabppk)) {
                        $modRiwayatPengadaan->jabatan_pengadaan = !empty($jabppk) ? $jabppk->jabatan_pengadaan : '';
                    } else {
                        $modRiwayatPengadaan->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
                    }
                    $modRiwayatPengadaan->create_time = date('Y-m-d H:i:s');
                    $modRiwayatPengadaan->tanggal_update = date('Y-m-d H:i:s');
                    $modRiwayatPengadaan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modRiwayatPengadaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modRiwayatPengadaan->rencanaumumpengadaan_id = $id;
                    $status = 1;
                    if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Draft') {
                        $modRiwayatPengadaan->status_berkas = $model->rencanaumumpengadaan_status;
                    } else if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Pengajuan') {
                        if ($model->rencanaumumpengadaan_status == 'Revisi TPP-RUP') {
                            $modRiwayatPengadaan->status_berkas = 'Revisi TPP-RUP';
                            $status = 'Persetujuan PPK';
                        } elseif (strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DRAFT)) {
                            $modRiwayatPengadaan->status_berkas = Params::STATUS_RENCANA_UMUM_PENGADAAN_DRAFT;
                            $status = 'Persetujuan PPK';
                        }elseif (strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK) && $konfig->is_simplifikasipengadaan == true) {
                            //$modRiwayatPengadaan->status_berkas = Params::STATUS_RENCANA_UMUM_RUP_DIUMUMKAN;
                            $modRiwayatPengadaan->status_berkas = Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK;
                            $status = Params::STATUS_RENCANA_UMUM_RUP_DIUMUMKAN;
                        } else if (strtolower($model->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK) && $konfig->is_simplifikasipengadaan == false) {
                            $modRiwayatPengadaan->status_berkas = Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK;
                            $status = Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_KPA;
                        }
                    } else if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Revisi TPP-RUP') {
                        $status = 'Revisi TPP-RUP';
                    } else if ($_POST['ADRencanaumumpengadaanT']['statusnya'] == 'Revisi PPK') {
                        $modRiwayatPengadaan->status_berkas = 'Revisi PPK';
                        $status = 'Persetujuan KPA';
                    }
                }

                $modRiwayatPengadaan->riwayatpengadaan_lampiran = CUploadedFile::getInstance($modRiwayatPengadaan, 'riwayatpengadaan_lampiran');
                if (!empty($modRiwayatPengadaan->riwayatpengadaan_lampiran)) {
                    $dokumen_pendukung = $modRiwayatPengadaan->riwayatpengadaan_lampiran;

                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY H:i:s') . $dokumen_pendukung));
                    $fullImgSource = Params::pathLampiranRiwayatPengadaanDirectory() . $fullImgName;

                    $modRiwayatPengadaan->riwayatpengadaan_lampiran = $fullImgName;

                    if (!empty($dokumen_pendukung)) {
                        if ($modRiwayatPengadaan->riwayatpengadaan_lampiran != $temp) {
                            if (!empty($temp)) {
                                if (file_exists(Params::pathLampiranRiwayatPengadaanDirectory() . $temp)) {
                                    unlink(Params::pathLampiranRiwayatPengadaanDirectory() . $temp);
                                }
                            }
                        }
                        
                        if (!file_exists(Params::pathLampiranRiwayatPengadaanDirectory())){
                            mkdir(Params::pathLampiranRiwayatPengadaanDirectory(), 0775, true);
                        }
                        
                        $dokumen_pendukung->saveAs($fullImgSource);
                    }
                }

                if ($status != 1) {
                    $model->rencanaumumpengadaan_status = $status;
                    $ok = $ok && $model->save() && $modRiwayatPengadaan->save() && $this->simpanRiwayatBaru($status, $id);
                } else {
                    $ok = $ok && $model->save() && $modRiwayatPengadaan->save();
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('ubah', 'id' => $model->rencanaumumpengadaan_id));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan.");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan." . MyExceptionMessage::getMessage($ex, true));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial($this->path_view_ubah . 'index', array(
                'model' => $model,
                'modLokasi' => $modLokasi,
                'lokasi' => $lokasi,
                'modRAB' => $modRAB,
                'modSumberDana' => $modSumberDana,
                'modDana' => $modDana,
                'modRiwayat' => $modRiwayat,
                'modJenis' => $modJenis,
                'jenis' => $jenis,
                'arrLokasi' => $arrLokasi,
                'arrSumberDana' => $arrSumberDana,
                'arrJenis' => $arrJenis,
                'loadRiwayat' => $loadRiwayat,
                'modRiwayatPengadaan' => $modRiwayatPengadaan,
                'modDokumen' => $modDokumen
            ));
        } else {
            $this->render($this->path_view_ubah . 'index', array(
                'model' => $model,
                'modLokasi' => $modLokasi,
                'lokasi' => $lokasi,
                'modRAB' => $modRAB,
                'modSumberDana' => $modSumberDana,
                'modDana' => $modDana,
                'modRiwayat' => $modRiwayat,
                'modJenis' => $modJenis,
                'jenis' => $jenis,
                'arrLokasi' => $arrLokasi,
                'arrSumberDana' => $arrSumberDana,
                'arrJenis' => $arrJenis,
                'loadRiwayat' => $loadRiwayat,
                'modRiwayatPengadaan' => $modRiwayatPengadaan,
                'modDokumen' => $modDokumen
            ));
        }
    }

    /**
     * Simpan Riwayat Pengadaan
     * @param type $status
     * @param type $id
     * @return boolean
     */
    public function simpanRiwayatBaru($status, $id) {
        $riwayat = new RiwayatpengadaanR;
        $riwayat->rencanaumumpengadaan_id = $id;
        $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $riwayat->pegawai_id = $pegawai->pegawai_id;
        $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $riwayat->pegawai_id));
        $jabppk = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $riwayat->pegawai_id, 'jabatan_pengadaan' => 'PPK'));
        $riwayat->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
        $riwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
        if (!empty($jabppk)) {
            $riwayat->jabatan_pengadaan = !empty($jabppk) ? $jabppk->jabatan_pengadaan : '';
        } else {
            $riwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
        }
        $riwayat->status_berkas = $status;
        $riwayat->create_time = date('Y-m-d H:i:s');
        $riwayat->tanggal_update = date('Y-m-d H:i:s');
        $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $riwayat->save();
        if (!$riwayat->save()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Load Form Sumber Dana
     */
    public function actionGetSumberDana() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PengadaansumberdanaT;
            $data['form'] = "";
            $models = $this->loadModelSumberDana($_POST['rencana_id']);
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $model->nmrekening5 = !empty($model->mappingrekeninganggaran_id) ? $model->mappingrekeninganggaran->nama_rekeninganggaran5 : null;
                    $model->kode_rekening = !empty($model->mappingrekeninganggaran_id) ? $model->mappingrekeninganggaran->kodeanggaran . ' - ' . $model->mappingrekeninganggaran->nama_rekeninganggaran5 : "";
                    $model->pagu = MyFormatter::formatNumberForPrint($model->pagu, 2);
                    $data['form'] .= $this->renderPartial($this->path_view_ubah . '_rowSumberDana', array('modSumberDana' => $model), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view_ubah . '_rowSumberDana', array('modSumberDana' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load data sumber Dana
     * @param type $rencana_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelSumberDana($rencana_id) {
        $model = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencana_id));

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Load lokasi pengadaan
     */
    public function actionGetLokasi() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PengadaanlokasiT;
            $data['form'] = "";
            $models = $this->loadModelLokasi($_POST['rencana_id']);
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $data['form'] .= $this->renderPartial($this->path_view_ubah . '_rowLokasiPekerjaan', array('modLokasi' => $model), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view_ubah . '_rowLokasiPekerjaan', array('modLokasi' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load lokasi Pengadaan
     * @param type $rencana_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelLokasi($rencana_id) {
        $model = PengadaanlokasiT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencana_id));

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Load row dokumen
     */
    public function actionGetJenis() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PengadaanjenisT;
            $data['form'] = "";
            $models = $this->loadModelJenis($_POST['rencana_id']);
            if (count($models) > 0) {
                foreach ($models AS $i => $model) {
                    $model->jumlahpagu = MyFormatter::formatNumberForPrint($model->jumlahpagu, 2);
                    $model->pengadaanjenis_id_awal = $model->jenispengadaan_id;
                    $data['form'] .= $this->renderPartial($this->path_view_ubah . '_rowJenisPengadaan', array('modJenis' => $model), true);
                }
            } else {
                $data['form'] .= $this->renderPartial($this->path_view_ubah . '_rowJenisPengadaan', array('modJenis' => $model), true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Load Jenis Pengadaan 
     * @param type $rencana_id
     * @return type
     * @throws CHttpException
     */
    private function loadModelJenis($rencana_id) {
        $model = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencana_id));

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Get data kabupaten berdasarkan propinsi_id
     */
    public function actionSetDropdownKabupaten() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal['form'] = "";
            $kabupaten = null;
            $criteria = new CDbCriteria();
            $criteria->addCondition("propinsi_id = " . $_POST['propinsi_id']);

            $criteria->compare('kabupaten_aktif', true);
            $criteria->order = 'kabupaten_nama';
            $models = KabupatenM::model()->findAll($criteria);
            $kabupaten = CHtml::listData($models, 'kabupaten_id', 'kabupaten_nama');

            if (!empty($kabupaten)) {
                foreach ($kabupaten as $value => $name) {
                    $returnVal['form'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $data['sukses'] = 0;
            $data['pesan'] = "Data gagal dihapus!";
            $mod = RencanaumumpengadaandetT::model()->findByPk($id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($mod->delete()) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data berhasil dihapus!";
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data yang sudah digunakan di Transaksi Persiapan Pengadaan tidak dapat dihapus";
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = "Data yang sudah digunakan di Transaksi Persiapan Pengadaan tidak dapat dihapus";
            }
            echo CJSON::encode($data);
            Yii::app()->end();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Load row dokumen
     */
    public function actionLoadDokumen() {
        if (Yii::app()->request->isAjaxRequest) {
            $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : null;
            $rencanaumumpengadaan_id = isset($_POST['rencanaumumpengadaan_id']) ? $_POST['rencanaumumpengadaan_id'] : null;
            $jenispengadaan_id = isset($_POST['jenispengadaan_id']) ? $_POST['jenispengadaan_id'] : null;
            $metodepengadaan_id = isset($_POST['metodepengadaan_id']) ? $_POST['metodepengadaan_id'] : null;

            $cri = new CDbCriteria();
            $cri->join = " JOIN dokumenpengadaan_m dp ON dp.dokumenpengadaan_id = t.dokumenpengadaan_id ";
            if ($tipe == 'load') {
                $cri->addCondition(" t.rencanaumumpengadaan_id = " . $rencanaumumpengadaan_id . " ");
            } else {
                $cri->addCondition(" t.rencanaumumpengadaan_id = " . $rencanaumumpengadaan_id . " AND dp.jenispengadaan_id = " . $jenispengadaan_id . " ");
            }

            $jenis = PengadaandokumenpendukungT::model()->findAll($cri);
            $jnspengadaan = PengadaanjenisT::model()->findAll(" t.rencanaumumpengadaan_id = " . $rencanaumumpengadaan_id . " ");

            $modRencana = RencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);
            $jumlah_rup = 0;
            $jumlah_rup = $modRencana->total_harga + $modRencana->total_pajak;
            $jenis_id = array();
            $loadData = array();

            if (!empty($jenis)) {
                foreach ($jenis as $j) {
                    $loadData[$j->dokumenpengadaan_id]['dok_id'] = $j->dokumenpengadaan_id;
                    $loadData[$j->dokumenpengadaan_id]['nama'] = $j->dokumenpendukungpengadaan_nama;
                    $loadData[$j->dokumenpengadaan_id]['det'][$j->dokumenpendukungpengadaan_id]['file'] = $j->dokumenpendukungpengadaan_file;
                    $loadData[$j->dokumenpengadaan_id]['det'][$j->dokumenpendukungpengadaan_id]['id'] = $j->dokumenpendukungpengadaan_id;
                }
            }

            if (!empty($jnspengadaan)) {
                if ($tipe == 'load') {
                    foreach ($jnspengadaan as $p) {
                        $jenis_id[] = $p->jenispengadaan_id;
                    }
                } else {
                    $jenis_id[] = $jenispengadaan_id;
                }
            }

            $kategori = $modRencana->rencanaumumpengadaan_kategori;

            $trDok = '';

            $cri = new CDbCriteria();

            if (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)) {
                if (!empty($jenis_id)) {
                    $cri->addInCondition(" jenispengadaan_id ", $jenis_id);
                } else {
                    $cri->addCondition(" dokumenpengadaan_id is null ");
                }
            } elseif (strtolower($kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)) {
                $cri->addCondition(" jenispengadaan_id IS NULL ");
            } else {
                $cri->addCondition(" dokumenpengadaan_id is null ");
            }
            if(!empty($metodepengadaan_id)){
                $cri->addCondition(" metodepengadaan_id = " . $metodepengadaan_id);
            } else if (!empty($modRencana->metodepengadaan_id)) {
                $cri->addCondition(" metodepengadaan_id = " . $modRencana->metodepengadaan_id);
            } else {
                $cri->addCondition(" dokumenpengadaan_id is null  ");
            }
            $cri->addCondition(" dokumenpengadaan_aktif = TRUE AND dokumenpengadaan_jenistransaksi ilike '" . Params::DOKUMEN_PENGADAAN_RENCANA_UMUM_PENGADAAN . "' ");
            $cri->order = " dokumenpengadaan_urutan ASC ";
            $dok = ADDokumenpengadaanM::model()->findAll($cri);

            if (!empty($dok)) {
                foreach ($dok as $i => $d) {
                    $class = '';
                    $jenis = array();
                    $tipe = array();
                    $dok_det = array();

                    if ($d->file_zip) {
                        $tipe[] = '.zip';
                        $jenis[] = 'zip';
                    }

                    if ($d->file_rar) {
                        $tipe[] = '.rar';
                        $jenis[] = 'rar';
                    }

                    if ($d->file_word) {
                        $tipe[] = '.doc';
                        $tipe[] = '.docx';
                        $jenis[] = 'word';
                    }

                    if ($d->file_pdf) {
                        $tipe[] = '.pdf';
                        $jenis[] = 'pdf';
                    }

                    if ($d->file_excel) {
                        $tipe[] = '.xls';
                        $tipe[] = '.xlsx';
                        $jenis[] = 'excel';
                    }

                    if ($d->file_image) {
                        $tipe[] = 'image/*';
                        $jenis[] = 'image';
                    }


                    if ($jumlah_rup > 10000000) {
                        if ($d->dokumenpengadaan_wajib) { // dokumen wajib hanya ketika jumlah RUP > 10.000.000
                            $class = ' required ';
                        }
                    }

                    $modDok = new PengadaandokumenpendukungT();
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;
                    $modDok->dokumenpendukungpengadaan_nama = $d->dokumenpengadaan_nama;
                    $modDok->jenispengadaan_id = $d->jenispengadaan_id;

                    if (isset($loadData[$d->dokumenpengadaan_id]['det'])) {
                        if (!empty($loadData[$d->dokumenpengadaan_id]['det'])) {
                            $dok_det = $loadData[$d->dokumenpengadaan_id]['det'];
                        }
                    } else {
                        $dok_det[0]['id'] = null;
                        $dok_det[0]['file'] = null;
                    }

                    $trDok .= $this->renderPartial($this->path_view_ubah . '_rowDokDukung', array('jenis' => $jenis, 'tipe' => $tipe, 'required' => $class, 'modDok' => $modDok, 'i' => $i, 'det' => $dok_det), true);
                }
            }

            $data['dokDukung'] = $trDok;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Validasi dokumen pengadaan untuk dokumen dengan total > 10.000.000
     */
    function actionSetValidasiDokumen() {
        if (Yii::app()->request->isAjaxRequest) {
            $total = MyFormatter::formatNumberForDb($_POST['total_hargaseluruhnya']);
            $dokumenpengadaan_id = isset($_POST['dokumenpengadaan_id']) ? $_POST['dokumenpengadaan_id'] : null;
            $class = ' ';
            $tr = '';
            if (!empty($dokumenpengadaan_id)) {
                foreach ($dokumenpengadaan_id as $dok['dok_id']) {
                    $modDokumen = DokumenpengadaanM::model()->findByPk($dok['dok_id']);
                    if ($total > 10000000) {
                        if ($modDokumen->dokumenpengadaan_wajib == true) { // dokumen wajib hanya ketika jumlah RUP > 10.000.000
                            $tr .= $modDokumen->dokumenpengadaan_id . ",";
                        }
                    }
                }
            }
            $data['tr'] = $tr;
            $data['html'] = $total;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Proses unduh dokumen pendukung
     * @param integer $dokumenpendukungpengadaan_id
     */
    public function actionUnduhDok($dokumenpendukungpengadaan_id) {

        $filename = ADPengadaandokumenpendukungT::model()->findByPk($dokumenpendukungpengadaan_id);

        $path = Params::pathDokRencanaUmumPengadaanDirectory() . $filename->dokumenpendukungpengadaan_file;

        if (!empty($filename->dokumenpendukungpengadaan_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->dokumenpendukungpengadaan_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
        }
    }

    /**
     * Autocomplete Rekening 5
     */
    public function actionAutocompleteRekening() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nmrekening5)', strtolower($_GET['term']), true);
            $criteria->order = 'nourutrek';
            $criteria->limit = 5;
            $models = Rekening5M::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kdrekening5 . ' - ' . $model->nmrekening5;
                $returnVal[$i]['value'] = $model->rekening5_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * digunakan untuk men set dokumenpelaksaananggarandet_id yang dipilih
     */
    public function actionSetDokumenDet() {
        if (Yii::app()->request->isAjaxRequest) {
            $dokumenpelaksanaananggarandet_id = isset($_POST['dokumenpelaksanaananggarandet_id']) ? $_POST['dokumenpelaksanaananggarandet_id'] : null;
            $jenis = isset($_POST['jenis_trans']) ? $_POST['jenis_trans'] : null;
            $html = '';
            if (!empty($dokumenpelaksanaananggarandet_id)) {
                $cri = new CDbCriteria();
                $cri->addInCondition("dokumenpelaksanaananggarandet_id", $dokumenpelaksanaananggarandet_id);
//                $cri->addCondition('pengadaan_status IS FALSE');
                $modDokumen = DokumenpelaksanaananggarandetT::model()->findAll($cri);

                foreach ($modDokumen as $dok) {
                    $modRAB = new RencanaumumpengadaandetT;
                    $modRAB->barang_id = $dok->barang_id;
                    $modRAB->rencanaumumpengadaandet_pajak = 10;
                    $modRAB->persenawal = 0;
                    if ($dok->sisavolume_pengadaan != 0) {
                        $harga_satuan = ((100 / 110) * $dok->jumlah) / $dok->sisavolume_pengadaan;
                    } else {
                        $harga_satuan = 0;
                    }
                    $hit_persen = 0;
                    $hit_persen = ($modRAB->rencanaumumpengadaandet_pajak * $harga_satuan * $dok->sisavolume_pengadaan) / 100;
                    $modRAB->rencanaumumpengadaandet_jmlpajak = number_format($hit_persen, 2, ',', '.');
                    $modRAB->rencanaumumpengadaandet_volume = number_format($dok->sisavolume_pengadaan, 2, ',', '.');
                    $modRAB->volumeawal = $modRAB->rencanaumumpengadaandet_volume;
                    $modRAB->rencanaumumpengadaandet_harga = number_format((float) $harga_satuan, 2, ",", ".");
                    $modRAB->hargaawal = $modRAB->rencanaumumpengadaandet_harga;
                    $modRAB->jenis_barang = $dok->jenis_barang;
                    $modRAB->rencanaumumpengadaandet_nama = $dok->uraian;
                    $modRAB->rencanaumumpengadaandet_satuan = $dok->satuan;
                    if ($jenis == 'paket') {
                        $modRAB->paketpekerjaan_id = $dok->paketpekerjaan_id;
                    }
                    $modRAB->dokumenpelaksanaananggarandet_id = $dok->dokumenpelaksanaananggarandet_id;
                    $modRAB->sisapagu_pengadaan = MyFormatter::formatNumberForPrint($dok->sisapagu_pengadaan, 2);
                    $modRAB->rencanaumumpengadaandet_jumlah = number_format($dok->jumlah, 2, ',', '.');
                    $html .= $this->renderPartial($this->path_view_ubah . '_rowRABHPS', array('model' => $modRAB), true);
                }
            }
            $data['sukses'] = 1;
            $data['html'] = $html;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Pembatalan Rencana Umum Pengadaan
     * @param type $rencanaumumpengadaan_id
     */
    public function actionBatal($rencanaumumpengadaan_id) {
        $this->layout = '//layouts/iframe';
        $model = RencanaumumpengadaanT::model()->findByPk($rencanaumumpengadaan_id);
        $model->temp_file = $model->batal_dokumen;
        $file_dok = $model->batal_dokumen;
        if (isset($_POST['RencanaumumpengadaanT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['RencanaumumpengadaanT'];
                $model->rencanaumumpengadaan_status = Params::STATUS_RENCANA_UMUM_PENGADAAN_DIBATALKAN;
                $model->batal_alasan = $_POST['RencanaumumpengadaanT']['batal_alasan'];
                $model->batalpeg_id = Yii::app()->user->getState('pegawai_id');
                $model->batal_tanggal = date("d M Y H:i:s");
                $model->batal_dokumen = CUploadedFile::getInstance($model, 'batal_dokumen');
                $file = $model->batal_dokumen;
                if (!empty($file) && $file !== $model->temp_file) {
                    if (!empty($model->batal_dokumen)) {
                        $fullDocName = date('His') . "_" . $file;
                        $fullDocName = str_replace(' ', '_', strtolower(date('dmY_s') . $file));
                        $fullDocSource = Params::pathDokRencanaUmumPengadaanDirectory() . $fullDocName;
                        $model->batal_dokumen = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathDokRencanaUmumPengadaanDirectory())){
                        mkdir(Params::pathDokRencanaUmumPengadaanDirectory(), 0775, true);
                    }
                    
                    $ok = $ok && $model->save() && $file->saveAs($fullDocSource);
                    if (!empty($file_dok) && file_exists(Params::pathDokRencanaUmumPengadaanDirectory() . $file_dok)) {
                        unlink(Params::pathDokRencanaUmumPengadaanDirectory() . $file_dok);
                    }
                } else {
                    $model->batal_dokumen = $model->temp_file;
                    $ok = $ok && $model->save();
                }

                $cekpegawaibatal = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

                $modRiwayat = new RiwayatpengadaanR;
                $modRiwayat->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $modRiwayat->nama_pegawai = $cekpegawaibatal->namaLengkap;
                $modRiwayat->tanggal_update = date("d M Y H:i:s");
                $modRiwayat->status_berkas = 'Dibatalkan';
                $modRiwayat->riwayatpengadaan_catatan = $_POST['RencanaumumpengadaanT']['batal_alasan'];
                $modRiwayat->jabatan_pengadaan = 'PPK';
                $modRiwayat->rencanaumumpengadaan_id = $rencanaumumpengadaan_id;
                $modRiwayat->persiapanpengadaan_id = null;
                $modRiwayat->create_time = date("d M Y H:i:s");
                $modRiwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modRiwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modRiwayat->riwayatpengadaan_lampiran = CUploadedFile::getInstance($model, 'batal_dokumen');

                $file2 = $modRiwayat->riwayatpengadaan_lampiran;
                if (!empty($file2)) {
                    if (!empty($modRiwayat->riwayatpengadaan_lampiran)) {
                        $fullDocName = date('His') . "_" . $file2;
                        $fullDocName = str_replace(' ', '_', strtolower(date('dmY_s') . $file2));
                        $fullDocSource = Params::pathLampiranRiwayatPengadaanDirectory() . $fullDocName;
                        $modRiwayat->riwayatpengadaan_lampiran = $fullDocName;
                        
                        if (!file_exists(Params::pathLampiranRiwayatPengadaanDirectory())){
                            mkdir(Params::pathLampiranRiwayatPengadaanDirectory(), 0775, true);
                        }
                    }
                    $ok = $ok && $modRiwayat->save();
                    
                    if (!empty($file_dok) && file_exists(Params::pathLampiranRiwayatPengadaanDirectory() . $file_dok)) {
                        unlink(Params::pathLampiranRiwayatPengadaanDirectory() . $file_dok);
                    }
                } else {
                    $ok = $ok && $modRiwayat->save();
                }

                $criteria = new CDbCriteria();
                $criteria->addCondition('persiapanpengadaan_id IS NOT NULL');
                $criteria->addCondition('rencanaumumpengadaan_id = ' . $rencanaumumpengadaan_id);

                $cekPersiapan = InformasidokumenpengadaanV::model()->find($criteria);
                if (!empty($cekPersiapan)) {
                    $modPersiapan = PersiapanpengadaanT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));
                    $modPersiapan->persiapanpengadaan_status = Params::STATUS_PERSIAPAN_DIBATALKAN;
                    $ok = $ok && $modPersiapan->save();

                    $modRiwayat = new RiwayatpengadaanR;
                    $modRiwayat->pegawai_id = Yii::app()->user->getState('pegawai_id');
                    $modRiwayat->nama_pegawai = $cekpegawaibatal->namaLengkap;
                    $modRiwayat->tanggal_update = date("d M Y H:i:s");
                    $modRiwayat->status_berkas = 'Dibatalkan';
                    $modRiwayat->riwayatpengadaan_catatan = $_POST['RencanaumumpengadaanT']['batal_alasan'];
                    $modRiwayat->jabatan_pengadaan = 'PPK';
                    $modRiwayat->rencanaumumpengadaan_id = null;
                    $modRiwayat->persiapanpengadaan_id = $modPersiapan->persiapanpengadaan_id;
                    $modRiwayat->create_time = date("d M Y H:i:s");
                    $modRiwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modRiwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modRiwayat->riwayatpengadaan_lampiran = CUploadedFile::getInstance($model, 'batal_dokumen');

                    $file2 = $modRiwayat->riwayatpengadaan_lampiran;
                    if (!empty($file2)) {
                        if (!empty($modRiwayat->riwayatpengadaan_lampiran)) {
                            $fullDocName = date('His') . "_" . $file2;
                            $fullDocName = str_replace(' ', '_', strtolower(date('dmY_s') . $file2));
                            $fullDocSource = Params::pathLampiranRiwayatPengadaanDirectory() . $fullDocName;
                            $modRiwayat->riwayatpengadaan_lampiran = $fullDocName;
                            
                            if (!file_exists(Params::pathLampiranRiwayatPengadaanDirectory())){
                                mkdir(Params::pathLampiranRiwayatPengadaanDirectory(), 0775, true);
                            }
                        }
                        $ok = $ok && $modRiwayat->save();
                        if (!empty($file_dok) && file_exists(Params::pathLampiranRiwayatPengadaanDirectory() . $file_dok)) {
                            unlink(Params::pathLampiranRiwayatPengadaanDirectory() . $file_dok);
                        }
                    } else {
                        $ok = $ok && $modRiwayat->save();
                    }

                    $cekDet = PersiapanpengadaandetT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $modPersiapan->persiapanpengadaan_id));
                    foreach ($cekDet as $key => $value) {
                        $modDpadet = DokumenpelaksanaananggarandetT::model()->findByPk($value->dokumenpelaksanaananggarandet_id);
                        $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan + $value->jumlah_harga;
                        $modDpadet->sisavolume_pengadaan = $modDpadet->sisavolume_pengadaan + $value->persiapanpengadaandet_volume;

                        if ($modDpadet->sisapagu_pengadaan == 0) {
                            if ($modDpadet->harga_satuan > 0 && $modDpadet->volume > 0) {
                                $modDpadet->pengadaan_status = true;
                            }
                        } else if ($modDpadet->sisapagu_pengadaan > 0) {
                            $modDpadet->pengadaan_status = false;
                        }

                        $ok = $ok && $modDpadet->save();
                    }
                }//if(!empty($cekPersiapan)){
                else {
                    $cekDet = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $rencanaumumpengadaan_id));
                    foreach ($cekDet as $key => $value) {
                        $modDpadet = DokumenpelaksanaananggarandetT::model()->findByPk($value->dokumenpelaksanaananggarandet_id);
                        $modDpadet->sisapagu_pengadaan = $modDpadet->sisapagu_pengadaan + $value->rencanaumumpengadaandet_jumlah;
                        $modDpadet->sisavolume_pengadaan = $modDpadet->sisavolume_pengadaan + $value->rencanaumumpengadaandet_volume;

                        if ($modDpadet->sisapagu_pengadaan == 0) {
                            if ($modDpadet->harga_satuan > 0 && $modDpadet->volume > 0) {
                                $modDpadet->pengadaan_status = true;
                            }
                        } else if ($modDpadet->sisapagu_pengadaan > 0) {
                            $modDpadet->pengadaan_status = false;
                        }

                        $ok = $ok && $modDpadet->save();
                    }
                }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('Batal', 'rencanaumumpengadaan_id' => $rencanaumumpengadaan_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('formPembatalan', array('model' => $model));
    }

    /**
     * Fungsi unduh file dokumen pendukung Pembatalan
     * @param type $id
     */
    public function actionUnduhDokumen($id) {
        $filename = RencanaumumpengadaanT::model()->findByPk($id);
        $path = Params::pathDokRencanaUmumPengadaanDirectory() . "/" . $filename->batal_dokumen;
        if (!empty($filename->batal_dokumen)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->batal_dokumen, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'. 'file_tidak_ditemukan.txt'));
        }
    }

    /**
     * Cek apakah sudah ada persiapan pengadaan untuk RUP yang dimaksud 
     */
    public function actionCekPersiapan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        $ok = 1;
        $msg = "";
        $id = $_POST['id'];
        $modPersiapan = PersiapanpengadaanT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $id));

        if (!empty($modPersiapan)) {
            $ok = 0;
            $msg = "Data Persiapan Pengadaan untuk RUP ini sudah dibuat dengan nomor <b>" . $modPersiapan->persiapanpengadaan_nomor . "</b>";
        }

        echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
        Yii::app()->end();
    }

    /**
     * Revisi Rencana Umum Pengadaan 
     * Hanya dapat diakses jika rencanaumumpengadaan_kategori = Swakelola dan rencanaumumpengadaan_status = 'Diumumkan'
     * Halaman ini hanya dapat diakses oleh PPK 
     * @param type $id
     * @param type $revisi
     */
    public function actionRevisi($id, $revisi = null) {
        $modLokasi = new PengadaanlokasiT;
        $lokasi = new PengadaanlokasiT;
        $modSumberDana = new PengadaansumberdanaT;
        $modDana = new PengadaansumberdanaT;
        $modJenis = new PengadaanjenisT;
        $jenis = new PengadaanjenisT();
        $arrLokasi = array();
        $arrSumberDana = array();
        $arrJenis = array();
        $loadRiwayat = array();
        $ok = true;
        $modDokumen = new PengadaandokumenpendukungT();
        $model = ADRencanaumumpengadaanT::model()->findByPk($id);
        $model->pegawaipembuat_nama = $model->pegawaipembuat->namaLengkap;
        $model->unitkerja_nama = $model->unitkerja->namaunitkerja;
        $model->subprogram_nama = $model->subprogram->subprogramkerja_nama;
        $model->isprodukdalamnegeri = ($model->isprodukdalamnegeri) ? 1 : 0;
        $model->isusahakecil = ($model->isusahakecil) ? 1 : 0;
        $model->is_hutang = !empty($model->is_hutang) ? 1 : 0;
        $model->subkegiatanprogram_nama = $model->subkegiatanprogram->subkegiatanprogram_nama;
        $model->dpa_pagu_temp = $model->dpa_pagu;
        $model->pegawaipa_nama = !empty($model->pegawaipa_id) ? $model->pegawaipa->namaLengkap : '';
        $model->pegawaikpa_nama = !empty($model->pegawaikpa_id) ? $model->pegawaikpa->namaLengkap : '';
        $model->pegawaippk_nama = !empty($model->pegawaippk_id) ? $model->pegawaippk->namaLengkap : '';
        //$model->statusnya = $model->rencanaumumpengadaan_status;
        $sirup_awal = $model->kode_rup;
        if (!empty($model->pegawaipembuat_id)) { //Load data pegawai dari Log-In serta Unit Kerja
            $pegawai = PegawaiM::model()->findByPk($model->pegawaipembuat_id);
            $model->pegawaipembuat_nama = $pegawai->namaLengkap;
            $model->unitkerja_id = $pegawai->unitkerja_id;
            $model->unitkerja_nama = !empty($model->unitkerja_id) ? UnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja : "-";
        }

        if ($model->isprodukdalamnegeri == false) {
            $model->isprodukdalamnegeri = 0;
        } else if ($model->isprodukdalamnegeri == true) {
            $model->isprodukdalamnegeri = 1;
        }

        if ($model->isusahakecil == false) {
            $model->isusahakecil = 0;
        } else if ($model->isusahakecil == true) {
            $model->isusahakecil = 1;
        }

        if ($model->ispradpa == false) {
            $model->ispradpa = 0;
        } else if ($model->ispradpa == true) {
            $model->ispradpa = 1;
        }

        if ($model->isdikecualikan === false) {
            $model->isdikecualikan = '0';
        } elseif ($model->isdikecualikan === true) {
            $model->isdikecualikan = '1';
        }

        if ($model->ispaket === false) {
            $model->ispaket = 'tidak';
        } elseif ($model->ispaket === true) {
            $model->ispaket = 'ada';
        }

        $modRAB = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modRiwayat = new ADRiwayatpengadaanR('searchRiwayat2');
        $arrLokasi = PengadaanlokasiT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $arrSumberDana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $arrJenis = PengadaanjenisT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));

        $loadRiwayat = ADRiwayatpengadaanR::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $id));
        $modRiwayatPengadaan = new RiwayatpengadaanR();
        $modRiwayatPengadaan->riwayatpengadaan_catatan = "Melakukan revisi RUP";
        $modRevisi = new RevisirencanaumumpengadaanR();
        $modRevisi->revisi_alasan = $modRiwayatPengadaan->riwayatpengadaan_catatan;
        $modPeg = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $modRevisi->pegawai_id = $modPeg->pegawai_id;
        $modRevisi->pegawai_revisi = $modPeg->namaLengkap;
        $modRevisi->revisi_tanggal = MyFormatter::formatDateTimeForUser(date("d M Y H:i:s"));
        $modRevisi->create_time = date('Y-m-d H:i:s');
        $modRevisi->create_loginpemakai_id = Yii::app()->user->id;
        $modRevisi->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (isset($_POST['RencanaumumpengadaandetT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['ADRencanaumumpengadaanT'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->id;
                $model->total_pagu = $_POST['total_hargaseluruhnya'];
                $model->dpa_pagu = $_POST['ADRencanaumumpengadaanT']['dpa_pagu'];
                if ($model->ispradpa == 'TIDAK') {
                    $model->ispradpa = false;
                } else {
                    $model->ispradpa = true;
                }
                $ok = $ok && $model->save();

                $modRevisi->attributes = $_POST['RevisirencanaumumpengadaanR'];
                $modRevisi->sirup_awal = $sirup_awal;
                $modRevisi->sirup_revisi = $model->kode_rup;
                $modRevisi->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                $modRevisi->revisi_file = CUploadedFile::getInstance($modRevisi, 'revisi_file');
                $modRevisi->revisi_tanggal = MyFormatter::formatDateTimeForDb($modRevisi->revisi_tanggal);
                if (!empty($modRevisi->revisi_file)) {
                    $file = $modRevisi->revisi_file;
                    if (!empty($modRevisi->revisi_file)) {
                        $fullDocName = "REVISI_" . date("d-m-Y H:i:s") . '.' . $modRevisi->revisi_file->getExtensionName();
                        $fullDocSource = Params::pathDokRencanaUmumPengadaanDirectory() . $fullDocName;
                        $modRevisi->revisi_file = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathDokRencanaUmumPengadaanDirectory())){
                        mkdir(Params::pathDokRencanaUmumPengadaanDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }
                $riwayat = new RiwayatpengadaanR;
                $riwayat->rencanaumumpengadaan_id = $id;
                $pegawai = ADPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $riwayat->pegawai_id = $pegawai->pegawai_id;
                $jab = PejabatpengadaanM::model()->findByAttributes(array('pegawai_id' => $riwayat->pegawai_id));
                $riwayat->nama_pegawai = !empty($pegawai) ? $pegawai->namaLengkap : '';
                $riwayat->jabatan_pengadaan = !empty($jab) ? $jab->jabatan_pengadaan : '';
                $riwayat->status_berkas = $model->rencanaumumpengadaan_status;
                $riwayat->create_time = date('Y-m-d H:i:s');
                $riwayat->riwayatpengadaan_catatan = $modRevisi->revisi_alasan;
                $riwayat->tanggal_update = date('Y-m-d H:i:s');
                $riwayat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $riwayat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $ok = $ok && $modRevisi->save() && $riwayat->save();

                if (isset($_POST['PengadaansumberdanaT'])) {
                    foreach ($_POST['PengadaansumberdanaT'] as $key => $value) {
                        $modSumberDana = PengadaansumberdanaT::model()->findByPk($value['pengadaansumberdana_id']);
                        if (empty($modSumberDana)) {
                            $modSumberDana = new PengadaansumberdanaT;
                        }
                        $modSumberDana->attributes = $value;
                        $modSumberDana->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                        $modSumberDana->pagu = $value['pagus'];
                        $ok = $ok && $modSumberDana->save();
                    }
                }

                foreach ($_POST['RencanaumumpengadaandetT']['detail'] as $value) {
                    if (!empty($value['rencanaumumpengadaandet_id'])) {
                        $modRUP = RencanaumumpengadaandetT::model()->findByPk($value['rencanaumumpengadaandet_id']);
                    } else {
                        $modRUP = new RencanaumumpengadaandetT();
                        $modRUP->rencanaumumpengadaan_id = $model->rencanaumumpengadaan_id;
                    }
                    $modRUP->attributes = $value;

                    /**
                     * status = 1 data dihapus
                     * jika dihapus maka set value = 0 
                     */
                    if (!empty($value['status']) && $value['status'] == 1) {
                        $modRUP->rencanaumumpengadaandet_volume = 0;
                        $modRUP->rencanaumumpengadaandet_harga = 0;
                        $modRUP->rencanaumumpengadaandet_pajak = 0;
                        $modRUP->rencanaumumpengadaandet_jumlah = 0;
                        $modRUP->rencanaumumpengadaandet_jmlpajak = 0;
                    }

                    $ok = $ok && $modRUP->save();
                    
                    if ($ok) {
                        $modRevisiDet = new RevisirencanaumumpengadaandetR();
                        $modRevisiDet->revisirencanaumumpengadaan_id = $modRevisi->revisirencanaumumpengadaan_id;
                        $modRevisiDet->attributes = $value;
                        $modRevisiDet->satuan = $value['rencanaumumpengadaandet_satuan'];
                        $modRevisiDet->uraian = $value['rencanaumumpengadaandet_nama'];
                        $modRevisiDet->rup_volume = $value['rencanaumumpengadaandet_volumeawal'];
                        $modRevisiDet->rup_harga = $value['rencanaumumpengadaandet_estimasiawal'];
                        $modRevisiDet->rup_pajak = $value['rencanaumumpengadaandet_persenpajakawal'];
                        $modRevisiDet->rup_jumlah = $value['rencanaumumpengadaandet_totalawal'];
                        $modRevisiDet->rencanaumumpengadaandet_id = $modRUP->rencanaumumpengadaandet_id;
                        if (!empty($value['status']) && $value['status'] == 1) {
                            $modRevisiDet->revisi_volume = 0;
                            $modRevisiDet->revisi_harga = 0;
                            $modRevisiDet->revisi_pajak = 0;
                            $modRevisiDet->revisi_jumlah = 0;
                        } else {
                            $modRevisiDet->revisi_volume = $value['rencanaumumpengadaandet_volume'];
                            $modRevisiDet->revisi_harga = $value['rencanaumumpengadaandet_harga'];
                            $modRevisiDet->revisi_pajak = $value['rencanaumumpengadaandet_pajak'];
                            $modRevisiDet->revisi_jumlah = $value['rencanaumumpengadaandet_jumlah'];
                        }
                        $modRevisiDet->sisapagu = $value['sisapagu_pengadaan'];
                        $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);
                        $modDPA->sisapagu_pengadaan = $modDPA->sisapagu_pengadaan + $modRevisiDet->rup_jumlah - $modRevisiDet->revisi_jumlah;
                        $modDPA->sisavolume_pengadaan = $modDPA->sisavolume_pengadaan + $modRevisiDet->rup_volume - $modRevisiDet->revisi_volume;
                        if ($modDPA->sisapagu_pengadaan == 0) {
                            if ($modDPA->harga_satuan > 0 && $modDPA->volume > 0) {
                                $modDPA->pengadaan_status = true;
                            }
                        } else if ($modDPA->sisapagu_pengadaan > 0) {
                            $modDPA->pengadaan_status = false;
                        }
                        $ok = $ok && $modDPA->update() && $modRevisiDet->save();
                    }
                }
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('revisi', 'id' => $model->rencanaumumpengadaan_id, 'revisi' => 1, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan.");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Gagal! Data Gagal Disimpan." . MyExceptionMessage::getMessage($ex, true));
            }
        }
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial($this->path_view_revisi . 'index', array(
                'model' => $model,
                'modLokasi' => $modLokasi,
                'lokasi' => $lokasi,
                'modRAB' => $modRAB,
                'modSumberDana' => $modSumberDana,
                'modDana' => $modDana,
                'modRiwayat' => $modRiwayat,
                'modJenis' => $modJenis,
                'jenis' => $jenis,
                'arrLokasi' => $arrLokasi,
                'arrSumberDana' => $arrSumberDana,
                'arrJenis' => $arrJenis,
                'loadRiwayat' => $loadRiwayat,
                'modRiwayatPengadaan' => $modRiwayatPengadaan,
                'modDokumen' => $modDokumen,
                'modRevisi' => $modRevisi,
            ));
        } else {
            $this->render($this->path_view_revisi . 'index', array(
                'model' => $model,
                'modLokasi' => $modLokasi,
                'lokasi' => $lokasi,
                'modRAB' => $modRAB,
                'modSumberDana' => $modSumberDana,
                'modDana' => $modDana,
                'modRiwayat' => $modRiwayat,
                'modJenis' => $modJenis,
                'jenis' => $jenis,
                'arrLokasi' => $arrLokasi,
                'arrSumberDana' => $arrSumberDana,
                'arrJenis' => $arrJenis,
                'loadRiwayat' => $loadRiwayat,
                'modRiwayatPengadaan' => $modRiwayatPengadaan,
                'modDokumen' => $modDokumen,
                'modRevisi' => $modRevisi,
            ));
        }
    }

    /**
     * digunakan untuk men set dokumenpelaksaananggarandet_id yang dipilih
     * render dokumen revisi dibedakan karena ada sisa pagu pengadaan 
     */
    public function actionSetDokumenRevisi() {
        if (Yii::app()->request->isAjaxRequest) {
            $dokumenpelaksanaananggarandet_id = isset($_POST['dokumenpelaksanaananggarandet_id']) ? $_POST['dokumenpelaksanaananggarandet_id'] : null;
            $jenis = isset($_POST['jenis_trans']) ? $_POST['jenis_trans'] : null;
            $rencanaumumpengadaan_id = isset($_POST['rencanaumumpengadaan_id']) ? $_POST['rencanaumumpengadaan_id'] : null;
            $html = '';
            if (!empty($dokumenpelaksanaananggarandet_id)) {
                $cri = new CDbCriteria();
                $cri->addInCondition("dokumenpelaksanaananggarandet_id", $dokumenpelaksanaananggarandet_id);
//                $cri->addCondition('pengadaan_status IS FALSE');
                $modDokumen = DokumenpelaksanaananggarandetT::model()->findAll($cri);

                foreach ($modDokumen as $dok) {
                    $modRAB = new RencanaumumpengadaandetT;
                    $modRAB->barang_id = $dok->barang_id;
                    $modRAB->rencanaumumpengadaandet_pajak = 10;
                    $modRAB->persenawal = 0;
                    //$modRAB->rencanaumumpengadaandet_jmlpajak = 0;
                    $modRAB->rencanaumumpengadaandet_volume = number_format($dok->sisavolume_pengadaan, 2, ',', '.');
                    $modRAB->volumeawal = $modRAB->rencanaumumpengadaandet_volume;
                    //$harga_satuan = ($dok->jumlah - (($dok->jumlah/$modRAB->rencanaumumpengadaandet_volume)/11))/$modRAB->rencanaumumpengadaandet_volume;                    
                    if ($dok->sisavolume_pengadaan != 0) {
                        $harga_satuan = ((100 / 110) * $dok->jumlah) / $dok->sisavolume_pengadaan;
                    } else {
                        $harga_satuan = 0;
                    }
                    $modRAB->rencanaumumpengadaandet_jmlpajak = number_format((($harga_satuan * $modRAB->rencanaumumpengadaandet_pajak) / 100) * $dok->sisavolume_pengadaan, 2, ',', '.');
                    $serapan = 0;
                    $critNota = new CDbCriteria();
                    $critNota->join = "join notadinaspptk_t nota on t.notadinaspptk_id = nota.notadinaspptk_id";
                    $critNota->addCondition('nota.rencanaumumpengadaan_id = ' . $rencanaumumpengadaan_id . " and dokumenpelaksanaananggarandet_id = " . $dok['dokumenpelaksanaananggarandet_id']);
                    $modNota = NotadinaspptkdetT::model()->findAll($critNota);

                    if (!empty($modNota)) {
                        foreach ($modNota as $det) {
                            $serapan += $det['jumlahditerima'];
                        }
                    }
                    $modRAB->serapan = MyFormatter::formatNumberForPrint($serapan, 2);
                    $modRAB->rencanaumumpengadaandet_harga = number_format((float) $harga_satuan, 2, ",", ".");
                    $modRAB->hargaawal = $modRAB->rencanaumumpengadaandet_harga;
                    $modRAB->jenis_barang = $dok->jenis_barang;
                    $modRAB->rencanaumumpengadaandet_nama = $dok->uraian;
                    $modRAB->rencanaumumpengadaandet_satuan = $dok->satuan;
                    if ($jenis == 'paket') {
                        $modRAB->paketpekerjaan_id = $dok->paketpekerjaan_id;
                    }
                    $modRAB->dokumenpelaksanaananggarandet_id = $dok->dokumenpelaksanaananggarandet_id;
                    $modRAB->sisapagu_pengadaan = $dok->sisapagu_pengadaan;
                    $modRAB->rencanaumumpengadaandet_jumlah = number_format($dok->jumlah, 2, ',', '.');
                    $html .= $this->renderPartial($this->path_view_revisi . '_rowRABHPS', array('model' => $modRAB), true);
                }
            }
            $data['sukses'] = 1;
            $data['html'] = $html;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
}