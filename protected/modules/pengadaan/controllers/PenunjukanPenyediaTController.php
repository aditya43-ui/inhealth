<?php
/**
 * Controller untuk penunjukan penyedia di Surat Perjanjian Kerja
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class PenunjukanPenyediaTController extends MyAuthController{
   
    /**
     * Load halaman index penunjukan penyedia 
     * @param type $id
     */
    public function actionIndex($id = null){
        $this->layout = '//layouts/iframe';
        $model = new PenunjukanpenyediaT();
        $disabled = false;
        $cekPenunjukan = PenunjukanpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        $cekNotaDinas = NotadinaspengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id,'isbatal' => false, 'isaddendum' => true));        
        if (empty($cekPenunjukan)) {
            $model = new PenunjukanpenyediaT();
            $model->penunjukanpenyedia_tanggal = date('d M Y H:i:s');
            $model->dasar_tanggal = date('d M Y');
            $modPersiapan = PersiapanpengadaanT::model()->findByPk($id);
            $model->tanggal_awal = MyFormatter::formatDateTimeForUser($modPersiapan->pelaksanaankontrak_tglawal);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForUser($modPersiapan->pelaksanaankontrak_tglakhir);
            $model->jangka_pelaksanaan = CustomFunction::hitungHari($modPersiapan->pelaksanaankontrak_tglawal, $modPersiapan->pelaksanaankontrak_tglakhir) + 1;
            $model->pejabat_pembuatkomitmen = $modPersiapan->rencanaumumpengadaan->pegawaippk->namaLengkap;
            $model->penunjukanpenyedia_nomor = '-- Otomatis --';
            $modPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $modPenetapan = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            if (!empty($modPenawaran)) {
                $model->penawaranpenyedia_id = $modPenawaran->penawaranpenyedia_id;
                $model->penawaran_nomor = $modPenawaran->penawaranpenyedia_nomor;
                $model->penawaran_tanggal = date('d M Y', strtotime($modPenawaran->penawaranpenyedia_tanggal));
                $model->harga_negosiasi = !empty($modPenetapan->harga_negosiasi) ? MyFormatter::formatNumberForPrint($modPenetapan->harga_negosiasi, 2) : "";
                $model->supplier_id = $modPenawaran->supplier_id;
                $model->supplier_nama = $modPenawaran->supplier->supplier_nama;
                $model->supplier_alamat = $modPenawaran->supplier->supplier_alamat;
                $model->direktursupplier = $modPenawaran->supplier->direktursupplier;
                $model->cekpenawaran = true;
                $disabled = true;
            } else {
                $model->cekpenawaran = false;
            }
            
            if (!empty($cekNotaDinas)){
                $model->dasar_nomor = $cekNotaDinas->nomor_notadinas;
                $model->dasar_tanggal = MyFormatter::formatDateTimeForUser($cekNotaDinas->notadinaspengadaan_tanggal);
            }
        } else {
            $model = PenunjukanpenyediaT::model()->findByPk($cekPenunjukan->penunjukanpenyedia_id);
            $modPersiapan = PersiapanpengadaanT::model()->findByPk($id);
            $modPenetapan = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            $model->dasar_tanggal = MyFormatter::formatDateTimeForUser($model->dasar_tanggal);
            $model->tanggal_awal = MyFormatter::formatDateTimeForUser($model->tanggal_awal);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForUser($model->tanggal_akhir);
            $model->penunjukanpenyedia_tanggal = MyFormatter::formatDateTimeForUser($model->penunjukanpenyedia_tanggal);
            $model->penawaran_tanggal = MyFormatter::formatDateTimeForUser($model->penawaran_tanggal);
            $model->pejabat_pembuatkomitmen = $modPersiapan->rencanaumumpengadaan->pegawaippk->namaLengkap;
            $model->harga_negosiasi = MyFormatter::formatNumberForPrint($model->harga_negosiasi, 2);
            $modPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            
            if (!empty($modPenawaran)) {
                $model->penawaranpenyedia_id = $modPenawaran->penawaranpenyedia_id;
                $model->penawaran_nomor = $modPenawaran->penawaranpenyedia_nomor;
                $model->penawaran_tanggal = date('d M Y', strtotime($modPenawaran->penawaranpenyedia_tanggal));
                $model->supplier_id = $modPenawaran->supplier_id;
                $model->supplier_nama = $modPenawaran->supplier->supplier_nama;
                $model->supplier_alamat = $modPenawaran->supplier->supplier_alamat;
                $model->direktursupplier = $modPenawaran->supplier->direktursupplier;
                $disabled = true;
            } else {
                $model->supplier_id = $model->supplier_id;
                $model->supplier_nama = $model->supplier->supplier_nama;
                $model->supplier_alamat = $model->supplier->supplier_alamat;
                $model->direktursupplier = $model->supplier->direktursupplier;
            }
        }
        if (isset($_POST['PenunjukanpenyediaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['PenunjukanpenyediaT'];
                if (empty($cekPenunjukan)) {
                    $model->persiapanpengadaan_id = $id;
                    $model->penunjukanpenyedia_nomor = MyGenerator::noPenunjukanPenyedia();
                    $model->tanggal_awal = MyFormatter::formatDateTimeForDb($model->tanggal_awal); 
                    $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($model->tanggal_akhir); 
                    $model->penunjukanpenyedia_tanggal = MyFormatter::formatDateTimeForDb($model->penunjukanpenyedia_tanggal); 
                    $model->dasar_tanggal = MyFormatter::formatDateTimeForDb($model->dasar_tanggal); 
                    $model->penawaran_tanggal = MyFormatter::formatDateTimeForDb($model->penawaran_tanggal); 
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                    $model->harga_negosiasi = MyFormatter::formatNumberForDb($_POST['PenunjukanpenyediaT']['harga_negosiasi']);
                } else {
                    $model->tanggal_awal = MyFormatter::formatDateTimeForDb($model->tanggal_awal); 
                    $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($model->tanggal_akhir); 
                    $model->penunjukanpenyedia_tanggal = MyFormatter::formatDateTimeForDb($model->penunjukanpenyedia_tanggal); 
                    $model->dasar_tanggal = MyFormatter::formatDateTimeForDb($model->dasar_tanggal); 
                    $model->penawaran_tanggal = MyFormatter::formatDateTimeForDb($model->penawaran_tanggal); 
                    $model->harga_negosiasi = MyFormatter::formatNumberForDb($_POST['PenunjukanpenyediaT']['harga_negosiasi']);
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if(!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->penunjukanpenyedia_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathPenunjukanPenyediaDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathPenunjukanPenyediaDirectory())){
                        mkdir(Params::pathPenunjukanPenyediaDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = PenunjukanpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                $ok = $ok && $model->save();
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $modPersiapan->persiapanpengadaan_id ,'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model, 'disabled' => $disabled));
    }
    
    /**
     * Cetak Dokumen Penunjukan Penyedia
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = PenunjukanpenyediaT::model()->findByPk($id);
        $modPersiapan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        $modPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        $modPegawai = PegawaiM::model()->findByPk($modPersiapan->pegawaippk_id);
        if(!empty($model)){
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
                    $isiPesan = str_replace("{{dasar_tanggal}}",date('d ', strtotime($model->dasar_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->dasar_tanggal))) . date(' Y', strtotime($model->dasar_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{penawaran_tanggal}}",date('d ', strtotime($model->penawaran_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->penawaran_tanggal))) . date(' Y', strtotime($model->penawaran_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{penunjukanpenyedia_tanggal}}",date('d ', strtotime($model->penunjukanpenyedia_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->penunjukanpenyedia_tanggal))) . date(' Y', strtotime($model->penunjukanpenyedia_tanggal)), $isiPesan);
                    $isiPesan = str_replace("{{harga_terbilang}}", "(". ucwords(MyFormatter::kataTerbilang($model->harga_negosiasi))." rupiah)", $isiPesan);
                    $isiPesan = str_replace("{{harga_negosiasi}}", "Rp ".number_format($model->harga_negosiasi,2, ',', '.'), $isiPesan);
                    $isiPesan = str_replace("{{jangka_pelaksanaan_terbilang}}", "(".MyFormatter::kataTerbilang($model->jangka_pelaksanaan).")", $isiPesan);
                    $isiPesan = str_replace("{{nama_program}}", $modPersiapan->programkerja_nama, $isiPesan);
                    $isiPesan = str_replace("{{nama_pekerjaan}}", $modPersiapan->nama_pekerjaan, $isiPesan);
                    $isiPesan = str_replace("{{nomor_dokumen_penawaran}}", $modPenawaran->penawaranpenyedia_nomorsurat, $isiPesan);
                }
                $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
                $attributes = $modSupplier->getAttributes();
                foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                } 
            }
            $model->dasar=$isiPesan;
        }
        $this->render('print', array('model' => $model, 'modPegawai' => $modPegawai));
    }
    
    
    /**
     * menghitung jangka waktu kontrak berdasarkan 2 tanggal
     */
    public function actionCekTanggal()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['hari'] = null;
            $awal = MyFormatter::formatDateTimeForDb($_POST['tgl_awal']);
            $akhir = MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']);
            if(isset($_POST['tgl_awal']) && !empty($_POST['tgl_akhir'])){
                $data['hari'] = CustomFunction::hitungHari($awal, $akhir) + 1;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = PenunjukanpenyediaT::model()->findByPk($id);
        $path = Params::pathPenunjukanPenyediaDirectory().$filename->dokumen_pendukung;
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