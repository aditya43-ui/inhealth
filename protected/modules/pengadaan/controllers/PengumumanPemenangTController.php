<?php
/**
 * Controller untuk Transaksi Pengumuman Pemenang
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class PengumumanPemenangTController extends MyAuthController{
    
    /**
     * Load halaman index
     * @param type $id
     */
    public function actionIndex($id = null){
        $this->layout = '//layouts/iframe';
        $cekPenetapan = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        if (!empty($cekPenetapan)) {
            $cekPengumuman = PengumumanpemenangT::model()->findByAttributes(array('penetapanpemenang_id' => $cekPenetapan->penetapanpemenang_id, 'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekPengumuman)) {
                $model = PengumumanpemenangT::model()->findByAttributes(array('penetapanpemenang_id' => $cekPenetapan->penetapanpemenang_id, 'isbatal' => false, 'isaddendum' => true));
            } else {
                $model = new PengumumanpemenangT();
                $model->pengumumanpemenang_tanggal = date('d M Y H:i:s');
                $model->pengumumanpemenang_nomor = '-- Otomatis --';
                $model->peg_jabatan = "Pejabat Pengadaan Penunjang";
            }
            $model->persiapanpengadaan_id = $id;
            $model->supplier_id = $cekPenetapan->supplier_id;
            $model->supplier_nama = !empty($cekPenetapan->supplier->supplier_nama) ? $cekPenetapan->supplier->supplier_nama : "-";
            $model->direktursupplier = !empty($cekPenetapan->supplier->direktursupplier) ? $cekPenetapan->supplier->direktursupplier : "-";
            $model->supplier_alamat = !empty($cekPenetapan->supplier->supplier_alamat) ? $cekPenetapan->supplier->supplier_alamat : "-";
            $model->supplier_npwp = !empty($cekPenetapan->supplier->supplier_npwp) ? $cekPenetapan->supplier->supplier_npwp : "-";
            $model->penetapanpemenang_id = $cekPenetapan->penetapanpemenang_id;
            $model->penetapanpemenang_nomor = $cekPenetapan->penetapanpemenang_nomor;
            $model->penetapanpemenang_tanggal = MyFormatter::formatDateTimeForUser($cekPenetapan->penetapanpemenang_tanggal);
            if (!empty($cekPenetapan->pegawai_id)) {
                $model->pegawai_id = $cekPenetapan->pegawai_id;
                $model->pegawai_nama = $cekPenetapan->pegawai->namaLengkap;
                $model->nomorindukpegawai = $cekPenetapan->pegawai->nomorindukpegawai;
                $model->jabatan = !empty($cekPenetapan->pegawai->jabatan_id) ? $cekPenetapan->pegawai->jabatan->jabatan_nama : "-";
            }
            $model->harga_negosiasi = MyFormatter::formatNumberForPrint($cekPenetapan->harga_negosiasi, 2);
            $model->cekPenetapan = true;
            $model->peg_jabatan = $cekPenetapan->peg_jabatan;
        } else {
            $model = new PengumumanpemenangT();
            $model->cekPenetapan = false;
            $model->pengumumanpemenang_nomor = '-- Otomatis --';
            $model->pengumumanpemenang_tanggal = date('d M Y H:i:s');
            $model->penetapanpemenang_tanggal = date('d M Y');
            $model->peg_jabatan = "Pejabat Pengadaan Penunjang";
        }
        
        if (isset($_POST['PengumumanpemenangT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['PengumumanpemenangT'];
                $model->pengumumanpemenang_tanggal = MyFormatter::formatDateTimeForDb($model->pengumumanpemenang_tanggal);
                $model->penetapanpemenang_tanggal = MyFormatter::formatDateTimeForDb($model->penetapanpemenang_tanggal);
                if (empty($cekPengumuman)) {
                    $model->pengumumanpemenang_nomor = MyGenerator::noPengumumanPemenang();
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                    $model->nama_pekerjaan = $cekPenetapan->nama_pekerjaan;
                    $model->harga_negosiasi = MyFormatter::formatNumberForDb($cekPenetapan->harga_negosiasi); 
                    
                } else {
                    $model->harga_negosiasi = MyFormatter::formatNumberForDb($model->harga_negosiasi);
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if(!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->pengumumanpemenang_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathPengumumanPemenangDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathPengumumanPemenangDirectory())){
                        mkdir(Params::pathPengumumanPemenangDirectory(), 0755, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = PengumumanpemenangT::model()->findByAttributes(array('penetapanpemenang_id' => $cekPenetapan->penetapanpemenang_id, 'isbatal' => false, 'isaddendum' => true));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                $ok = $ok && $model->save();

                //Untuk SMS
                $modPersiapan   = PersiapanpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id));
                $modInfo        = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $modPersiapan->persiapanpengadaan_id));

                // Kirim SMS Ke PPK (Pembuatan SPK oleh PPK)
                $nama_modul = Yii::app()->controller->module->id;
                $nama_controller = Yii::app()->controller->id;
                $nama_action = Yii::app()->controller->action->id;
                $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
                //LoadSMS
                $criteria = new CDbCriteria;
                $criteria->compare('modul_id', $modul_id);
                $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
                $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
                $criteria->addCondition(" statussms = true AND tujuansms = 'pegawai' ");
                $modSmsgateway = SmsgatewayM::model()->find($criteria);

                if (!empty($modSmsgateway)) {
                    $template = $modSmsgateway->templatesms;
                } else {
                    $template = "To PPK: Persiapan Pengadaan nomor {{nomor_pp}} tanggal {{tanggal_pp}} dengan metode {{metode_pengadaan}} nama unit kerja {{nama_unitkerja}} pekerjaan {{nama_pekerjaan}}. Mohon untuk segera mengisi Kelengkapan Dokumen Pengadaan.";
                }

                $modPejabatPpk     = PegawaiM::model()->findByPk($modInfo->pegppk_id);

                if (!empty($modPejabatPpk)) {
                    $isiPesan = $template;
                    $attributes = $model->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                        $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        $isiPesan = str_replace("{{nomor_pp}}", $modPersiapan->persiapanpengadaan_nomor, $isiPesan);
                        $isiPesan = str_replace("{{tanggal_pp}}", $modPersiapan->persiapanpengadaan_tanggal, $isiPesan);
                        $isiPesan = str_replace("{{metode_pengadaan}}", $modPersiapan->metodepengadaan_nama, $isiPesan);
                        $isiPesan = str_replace("{{nama_unitkerja}}", $modPersiapan->unitkerja->namaunitkerja, $isiPesan);
                        $isiPesan = str_replace("{{nama_pekerjaan}}", $modPersiapan->rencanaumumpengadaan->nama_pekerjaan, $isiPesan);
                    }
                    $api = new MyAPI();
                    if (!empty($modPejabatPpk->nomobile_pegawai)) {
                        $res = $api->smsBlastSend(array($modPejabatPpk->nomobile_pegawai), 'RSDrSoetomo', $isiPesan);
                        CustomFunction::addSentItem($res, 'RSDrSoetomo', $isiPesan);
                    }//END OF if (!empty($modPejabatPengadaan->nomobile_pegawai))
                }//END of if (!empty($modPejabatPengadaan))
                //END OF Kirim SMS Ke PPK (Pembuatan SPK oleh PPK)

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $cekPenetapan->persiapanpengadaan_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model));
    }
    
    /**
     * Cetak surat pengumuman pemenang
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = PengumumanpemenangT::model()->findByPk($id);
        $modPenetapan = PenetapanpemenangT::model()->findByPk($model->penetapanpemenang_id);
        if(!empty($model->pengumumanpemenang_t)){
            $isiPesan = "-";
            $criteria = new CDbCriteria;
            $criteria->addCondition("konfigtemplatesurat_aktif=true");
            $criteria->addCondition("konfigtemplatesurat_id=".$model->konfigtemplatesurat_id);
            $modTemplate = KonfigtemplatesuratK::model()->findAll($criteria);
            foreach ($modTemplate as $i => $templateTugas) {
                $isiPesan = $templateTugas->konfigtemplatesurat_isi;
                $isiPesan = "${isiPesan}";
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_penetapan}}", $modPenetapan->penetapanpemenang_nomor, $isiPesan);
                    
                    $isiPesan = str_replace("{{penetapanpemenang_tanggal}}", date('d', strtotime($modPenetapan->penetapanpemenang_tanggal))." ".MyFormatter::getMonthId(date('m', strtotime($modPenetapan->penetapanpemenang_tanggal))).date(' Y', strtotime($modPenetapan->penetapanpemenang_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{dasar_tanggal}}", MyFormatter::formatDateTimeForUser($model->pengumumanpemenang_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{harga_terbilang}}", "(". ucwords(MyFormatter::kataTerbilang($model->harga_negosiasi))." rupiah)", $isiPesan);
                    $isiPesan = str_replace("{{harga_negosiasi}}", "Rp ".MyFormatter::formatNumberForPrint($model->harga_negosiasi, 2), $isiPesan);
                }
                $modPenawaran = PenawaranpenyediaT::model()->findByPk($modPenetapan->penawaranpenyedia_id);
                $attributes = $modPenawaran->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                
                $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
                $attributes = $modSupplier->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                } 
            }
            $model->dasar=$isiPesan;
        }
        $this->render('print', array('model' => $model));
    }
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = PengumumanpemenangT::model()->findByPk($id);
        $path = Params::pathPengumumanPemenangDirectory()."/".$filename->dokumen_pendukung;
        if (!empty($filename->dokumen_pendukung)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->dokumen_pendukung, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Yii::getPathOfAlias('webroot').'/data/'.'file_tidak_ditemukan.txt'));   
        }
    }
}

