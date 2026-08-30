<?php
/**
 * Controller untuk Penetapan Pemenang
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class PenetapanPemenangTController extends MyAuthController{
    
    /**
     * Load halaman penetapan pemenang
     * @param type $id
     */
    public function actionIndex($id = null){
        $this->layout = '//layouts/iframe';
        $cekPenetapan = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        if (!empty($cekPenetapan)) {
            $model = PenetapanpemenangT::model()->findByPk($cekPenetapan->penetapanpemenang_id);
            $model->penetapanpemenang_tanggal = MyFormatter::formatDateTimeForUser($model->penetapanpemenang_tanggal);
            $model->dasar_tanggal = MyFormatter::formatDateTimeForUser($model->dasar_tanggal);
            $model->penawaran_tanggal = MyFormatter::formatDateTimeForUser($model->penawaran_tanggal);
            $cekHarga = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekHarga)) {
                $model->harga_negosiasi = number_format($cekHarga->pembulatan_negosiasi, 2, ",", ".");
            }
            if (!empty($model->penetapanpemenang_id)) {
                $model->harga_negosiasi = number_format($cekPenetapan->harga_negosiasi, 2, ",", ".");
            }
            $model->supplier_id = $model->supplier_id;
            $model->supplier_nama = $model->supplier->supplier_nama;
            $model->supplier_alamat = $model->supplier->supplier_alamat;
            $model->direktursupplier = $model->supplier->direktursupplier;
            $model->supplier_npwp = !empty($model->supplier->supplier_npwp) ? $model->supplier->supplier_npwp : "";
            $model->npwp = !empty($model->supplier->supplier_npwp) ? $model->supplier->supplier_npwp : "-";
        } else {
            $model = new PenetapanpemenangT();
            $model->penetapanpemenang_tanggal = date('d M Y H:i:s');
            $cekBapengadaanlangsungT = BapengadaanlangsungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekBapengadaanlangsungT)) {
                $model->dasar_nomor = !empty($cekBapengadaanlangsungT->nomor_beritaacara) ? $cekBapengadaanlangsungT->nomor_beritaacara : '';
                $model->dasar_tanggal = !empty($cekBapengadaanlangsungT->bapengadaanlangsung_tanggal) ? date('d M Y', strtotime($cekBapengadaanlangsungT->bapengadaanlangsung_tanggal)) : '';
            }else{
                $model->dasar_tanggal = date('d M Y');
            }
            $cekPenawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekPenawaran)) {
                $model->penawaranpenyedia_id = $cekPenawaran->penawaranpenyedia_id;
                $model->penawaran_tanggal = MyFormatter::formatDateTimeForUser($cekPenawaran->penawaranpenyedia_tanggal);
                $model->penawaran_nomor = $cekPenawaran->penawaranpenyedia_nomor;
                $model->supplier_id = $cekPenawaran->supplier_id;
                $model->supplier_nama = $cekPenawaran->supplier->supplier_nama;
                $model->supplier_alamat = $cekPenawaran->supplier->supplier_alamat;
                $model->direktursupplier = $cekPenawaran->supplier->direktursupplier;
                $model->npwp = !empty($cekPenawaran->supplier->supplier_npwp) ? $cekPenawaran->supplier->supplier_npwp : "";
                $cekHarga = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $cekPenawaran->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                    if (!empty($cekHarga)) {
                        $model->harga_negosiasi = number_format($cekHarga->total_negosiasi, 2, ",", ".");
                    } else {
                        $model->harga_negosiasi = number_format($cekPenawaran->penawaranpenyedia_harga, 2, ",", ".");
                    }
                $model->cekpenawaran = true;
            } else {
                $model->cekpenawaran = false;
            }
            $model->penetapanpemenang_nomor = '-- Otomatis --';
        }
        $modInfo = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
        if (!empty($modInfo)) {
            $model->infoumumpengadaan_id = $modInfo->infoumumpengadaan_id;
            if (!empty($modInfo->pegpengadaan_id)) {
                $model->pegawai_id = $modInfo->pegpengadaan_id;
                $model->pegawai_nama = $modInfo->pegpengadaan->namaLengkap;
                $model->nomorindukpegawai = $modInfo->pegpengadaan->nomorindukpegawai;
                $model->jabatan = $modInfo->jabatan_pengadaan;
                $model->peg_jabatan = $modInfo->jabatan_pengadaan;
            }
        }
        
        $model->persiapanpengadaan_id = $_GET['id'];
        if (isset($_POST['PenetapanpemenangT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['PenetapanpemenangT'];
                if (empty($cekPenetapan)) {
                    $modPersiapan = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                    $model->persiapanpengadaan_id = $_GET['id'];
                    $model->penetapanpemenang_nomor = MyGenerator::noPenetapanPemenang();
                    $model->nama_pekerjaan = $modPersiapan->nama_pekerjaan;
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                    if(substr($_POST['PenetapanpemenangT']["harga_negosiasi"], -2) == 00){
                    $model->harga_negosiasi = $_POST['PenetapanpemenangT']["harga_negosiasi"];
                        }else{
                            $model->harga_negosiasi = substr($_POST['PenetapanpemenangT']["harga_negosiasi"], 0, -2).substr($_POST['PenetapanpemenangT']["harga_negosiasi"], -2);
                        }
                    $model->dasar_tanggal = MyFormatter::formatDateTimeForDb($model->dasar_tanggal);
                    $model->penawaran_tanggal = MyFormatter::formatDateTimeForDb($model->penawaran_tanggal);
                    $model->penetapanpemenang_tanggal = MyFormatter::formatDateTimeForDb($model->penetapanpemenang_tanggal);
                } else {
                    $model->dasar_tanggal = MyFormatter::formatDateTimeForDb($model->dasar_tanggal);
                    $model->penawaran_tanggal = MyFormatter::formatDateTimeForDb($model->penawaran_tanggal);
                    $model->penetapanpemenang_tanggal = MyFormatter::formatDateTimeForDb($model->penetapanpemenang_tanggal);
                    if(substr($_POST['PenetapanpemenangT']["harga_negosiasi"], -2) == 00){
                    $model->harga_negosiasi = $_POST['PenetapanpemenangT']["harga_negosiasi"];
                        }else{
                            $model->harga_negosiasi = substr($_POST['PenetapanpemenangT']["harga_negosiasi"], 0, -2).substr($_POST['PenetapanpemenangT']["harga_negosiasi"], -2);
                        }
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                $model->dokumen_pendukung = CUploadedFile::getInstance($model, 'dokumen_pendukung');
                
                if (!empty($model->dokumen_pendukung)) {
                    $file = $model->dokumen_pendukung;
                    if(!empty($model->dokumen_pendukung)) {
                        $fullDocName = $model->penetapanpemenang_nomor . '.' .  $model->dokumen_pendukung->getExtensionName();
                        $fullDocSource = Params::pathPenetapanPemenangDirectory() . $fullDocName;
                        $model->dokumen_pendukung = $fullDocName;
                    }
                    
                    if (!file_exists(Params::pathPenetapanPemenangDirectory())){
                        mkdir(Params::pathPenetapanPemenangDirectory(), 0775, true);
                    }
                    
                    $file->saveAs($fullDocSource);
                }else{
                    $cekmodel = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'isbatal' => false, 'isaddendum' => true));
                    $model->dokumen_pendukung = !empty($cekmodel->dokumen_pendukung) ? $cekmodel->dokumen_pendukung : '';
                }
                $ok = $ok && $model->save();
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'id' => $_GET['id'],'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                echo "a";
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model));
    }
    
    /**
     * Cetak Dokumen Penetapan Pemenang
     * @param type $id
     */
    public function actionPrint($id){
        $this->layout = '//layouts/printWindows';
        $model = PenetapanpemenangT::model()->findByPk($id);
        if(!empty($model->penetapanpemenang_id)){
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
                    $isiPesan = str_replace("{{dasar_tanggal}}", MyFormatter::formatDateTimeForUser($model->dasar_tanggal), $isiPesan);
                    $isiPesan = str_replace("{{harga_terbilang}}", ucwords(MyFormatter::kataTerbilang($model->harga_negosiasi))." rupiah", $isiPesan);
                    $isiPesan = str_replace("{{harga_negosiasi}}", "Rp ".number_format($model->harga_negosiasi,2, ',', '.'), $isiPesan);
                }
                $modPenawaran = PenawaranpenyediaT::model()->findByPk($model->penawaranpenyedia_id);
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
     * Autocomplete pegawai
     */
    public function actionGetPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition(" pegawai_aktif = TRUE ");
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawaiV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                $returnVal[$i]['nomorindukpegawai'] = $model->nomorindukpegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
                if (!empty($model->jabatan_id)) {
                    $returnVal[$i]['jabatan_nama'] = JabatanM::model()->findByPk($model->jabatan_id)->jabatan_nama;
                } else {
                    $returnVal[$i]['jabatan_nama'] = '';
                }
                $returnVal[$i]['nosk'] = $model->getNoKeputusan();
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Fungsi unduh dokumen pendukung
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = PenetapanpemenangT::model()->findByPk($id);
        $path = Params::pathPenetapanPemenangDirectory()."/".$filename->dokumen_pendukung;
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