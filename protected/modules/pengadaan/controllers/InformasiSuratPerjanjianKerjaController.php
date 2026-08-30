<?php

/**
 * Digunakan untuk mengakses informasi surat perjanjian kerja
 * 
 * @author Andyka <andykaputra@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 */
class InformasiSuratPerjanjianKerjaController extends MyAuthController {

    public $simpandetail = false;
    public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.informasiSuratPerjanjianKerja.';

    /**
     * Halaman utama Informasi surat perjanjian kerja
     */
    public function actionIndex() {
        $this->layout = '//layouts/mainNeonSidebar';

        $model = new ADSuratperjanjiankerjaT();
        $model->tanggal_awal = date("Y-m-d");
        $model->tanggal_akhir = date("Y-m-d");
        if (isset($_GET['ADSuratperjanjiankerjaT'])) {
            $model->attributes = $_GET['ADSuratperjanjiankerjaT'];
            $model->namapekerjaan = $_GET['ADSuratperjanjiankerjaT']['namapekerjaan'];
            $model->supplier_nama = $_GET['ADSuratperjanjiankerjaT']['supplier_nama'];
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['ADSuratperjanjiankerjaT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['ADSuratperjanjiankerjaT']['tanggal_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial($this->path_view . 'index', array(
                'model' => $model,
            ));
        }else{
            $this->render($this->path_view . 'index', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Digunakan untuk mencetak data
     */
    public function actionPrint() {
        $model = new ADSuratperjanjiankerjaT();

        if (isset($_GET['ADSuratperjanjiankerjaT'])) {
            $model->attributes = $_GET['ADSuratperjanjiankerjaT'];
            $model->namapekerjaan = $_GET['ADSuratperjanjiankerjaT']['namapekerjaan'];
            $model->supplier_nama = $_GET['ADSuratperjanjiankerjaT']['supplier_nama'];
            $model->tanggal_awal = MyFormatter::formatDateTimeForDb($_GET['ADSuratperjanjiankerjaT']['tanggal_awal']);
            $model->tanggal_akhir = MyFormatter::formatDateTimeForDb($_GET['ADSuratperjanjiankerjaT']['tanggal_akhir']);
        }

        $judulLaporan = 'Data Kontrak';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
        }
    }

    /**
     * Pembatalan Surat Perjanjian Kerja
     * @param type $suratperjanjiankerja_id
     */
    public function actionBatal($suratperjanjiankerja_id) {
        $this->layout = '//layouts/iframe';
        $model = SuratperjanjiankerjaT::model()->findByPk($suratperjanjiankerja_id);
        $model->temp_file = $model->batal_file;
        $file_dok = $model->batal_file;

        if (isset($_POST['SuratperjanjiankerjaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                $model->attributes = $_POST['SuratperjanjiankerjaT'];
                $model->suratperjanjiankerja_id = $suratperjanjiankerja_id;
                $model->suratperjanjiankerja_status = 'Dibatalkan';
                $model->isbatal = true;
                $model->batal_alasan = $_POST['SuratperjanjiankerjaT']['batal_alasan'];
                $model->batalpeg_id = Yii::app()->user->getState('pegawai_id');
                $model->batal_tanggal = date("d M Y H:i:s");
                $model->batal_file = CUploadedFile::getInstance($model, 'batal_file');
                $file = $model->batal_file;
                if (!empty($file) && $file !== $model->temp_file) {
                    if (!empty($model->batal_file)) {
                        $fullDocName = date('His') . "_" . $file;
                        $fullDocSource = Params::pathdokumenSpkDirectory() . $fullDocName;
                        $model->batal_file = $fullDocName;
                        
                        if (!file_exists(Params::pathdokumenSpkDirectory())){
                            mkdir(Params::pathdokumenSpkDirectory(), 0775, true);
                        }
                    }
                    $ok = $ok && $model->save() && $file->saveAs($fullDocSource);
                    if (!empty($file_dok) && file_exists(Params::pathdokumenSpkDirectory() . $file_dok)) {
                        unlink(Params::pathdokumenSpkDirectory() . $file_dok);
                    }
                } else {
                    $model->batal_file = $model->temp_file;
                    $ok = $ok && $model->save();
                }
                                
                
                $modDetail = SuratperjanjiankerjarincianT::model()->findAllByAttributes(['suratperjanjiankerja_id' => $model->suratperjanjiankerja_id]);
                if (!empty($modDetail)) {
                    foreach($modDetail as $det){
                        $modPersiapan = PersiapanpengadaandetT::model()->findByAttributes(['persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'dokumenpelaksanaananggarandet_id' => $det['dokumenpelaksanaananggarandet_id']]);
                        $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($det['dokumenpelaksanaananggarandet_id']);
                        $modDPA->sisapagu_pengadaan = $modDPA->sisapagu_pengadaan + $det['barang_total'] - $modPersiapan->jumlah_harga;
                        $modDPA->sisavolume_pengadaan = $modDPA->sisavolume_pengadaan + $det['barang_jumlah'] - $modPersiapan->persiapanpengadaandet_volume;
                        $ok = $ok && $modDPA->save();
                    }
                }
                
                $cekInfoumumpengadaanT = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                $cekPenawaranpenyediaT = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                $cekBapengadaanlangsungT = BapengadaanlangsungT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                $cekBanegosiasiT = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                $cekPenetapanpemenangT = PenetapanpemenangT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                if (!empty($cekPenetapanpemenangT)) {
                    $cekPengumumanpemenangT = PengumumanpemenangT::model()->findByAttributes(array('penetapanpemenang_id' => $cekPenetapanpemenangT->penetapanpemenang_id, 'isbatal' => false, 'isaddendum' => true));
                }
                $cekNotadinaspengadaanT = NotadinaspengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                $cekPenunjukanpenyediaT = PenunjukanpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                $cekPembukaanPenawaran = PembukaanpenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                $cekEvaluasiPenawaran = EvaluasipenawaranT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                
                $modbatalspk = new BatalspkR;
                $modbatalspk->persiapanpengadaan_id = $model->persiapanpengadaan_id;
                $modbatalspk->suratperjanjiankerja_id = $model->suratperjanjiankerja_id;
                $modbatalspk->infoumumpengadaan_id = !empty($cekInfoumumpengadaanT->infoumumpengadaan_id) ? $cekInfoumumpengadaanT->infoumumpengadaan_id : "";
                $modbatalspk->penawaranpenyedia_id = !empty($cekPenawaranpenyediaT->penawaranpenyedia_id) ? $cekPenawaranpenyediaT->penawaranpenyedia_id : "";
                $modbatalspk->bapengadaanlangsung_id = !empty($cekBapengadaanlangsungT->bapengadaanlangsung_id) ? $cekBapengadaanlangsungT->bapengadaanlangsung_id : "";
                $modbatalspk->banegosiasi_id = !empty($cekBanegosiasiT->banegosiasi_id) ? $cekBanegosiasiT->banegosiasi_id : "";
                $modbatalspk->penetapanpemenang_id = !empty($cekPenetapanpemenangT->penetapanpemenang_id) ? $cekPenetapanpemenangT->penetapanpemenang_id : "";
                $modbatalspk->pengumumanpemenang_id = !empty($cekPengumumanpemenangT->pengumumanpemenang_t) ? $cekPengumumanpemenangT->pengumumanpemenang_t : "";
                $modbatalspk->penunjukanpenyedia_id = !empty($cekPenunjukanpenyediaT->penunjukanpenyedia_id) ? $cekPenunjukanpenyediaT->penunjukanpenyedia_id : "";
                $modbatalspk->notadinaspengadaan_id = !empty($cekNotadinaspengadaanT->notadinaspengadaan_id) ? $cekNotadinaspengadaanT->notadinaspengadaan_id : "";
                $modbatalspk->pembukaanpenawaran_id = !empty($cekPembukaanPenawaran->pembukaanpenawaran_id) ? $cekPembukaanPenawaran->pembukaanpenawaran_id : "";
                $modbatalspk->evaluasipenawaran_id = !empty($cekEvaluasiPenawaran->evaluasipenawaran_id) ? $cekEvaluasiPenawaran->evaluasipenawaran_id : "";
                $ok = $ok && $modbatalspk->save();
                
                $modInfoumumpengadaanT = InfoumumpengadaanT::model()->findByPk($modbatalspk->infoumumpengadaan_id);
                if (!empty($modInfoumumpengadaanT)) {
                    $modInfoumumpengadaanT->isbatal = true;
                    $ok = $ok && $modInfoumumpengadaanT->update();
                }
                
                $modPenawaranpenyediaT = PenawaranpenyediaT::model()->findByPk($modbatalspk->penawaranpenyedia_id);
                if (!empty($modPenawaranpenyediaT)) {
                    $modPenawaranpenyediaT->isbatal = true;
                    $ok = $ok && $modPenawaranpenyediaT->update();
                }
                
                $modBapengadaanlangsungT = BapengadaanlangsungT::model()->findByPk($modbatalspk->bapengadaanlangsung_id);
                if (!empty($modBapengadaanlangsungT)) {
                    $modBapengadaanlangsungT->isbatal = true;
                    $ok = $ok && $modBapengadaanlangsungT->update();
                }
                
                $modBanegosiasiT = BanegosiasiT::model()->findByPk($modbatalspk->banegosiasi_id);
                if (!empty($modBanegosiasiT)) {
                    $modBanegosiasiT->isbatal = true;
                    $ok = $ok && $modBanegosiasiT->update();
                }
                    
                $modPenetapanpemenangT = PenetapanpemenangT::model()->findByPk($modbatalspk->penetapanpemenang_id);
                if (!empty($modPenetapanpemenangT)) {
                    $modPenetapanpemenangT->isbatal = true;
                    $ok = $ok && $modPenetapanpemenangT->update();
                }
                    
                $modPengumumanpemenangT = PengumumanpemenangT::model()->findByPk($modbatalspk->pengumumanpemenang_id);
                if (!empty($modPengumumanpemenangT)) {
                    $modPengumumanpemenangT->isbatal = true;
                    $ok = $ok && $modPengumumanpemenangT->update();
                }
                
                $modNotadinaspengadaanT = NotadinaspengadaanT::model()->findByPk($modbatalspk->notadinaspengadaan_id);
                if (!empty($modNotadinaspengadaanT)) {
                    $modNotadinaspengadaanT->isbatal = true;
                    $ok = $ok && $modNotadinaspengadaanT->update();
                }
                    
                $modPenunjukanpenyediaT = PenunjukanpenyediaT::model()->findByPk($modbatalspk->penunjukanpenyedia_id);
                if (!empty($modPenunjukanpenyediaT)) {
                    $modPenunjukanpenyediaT->isbatal = true;
                    $ok = $ok && $modPenunjukanpenyediaT->update();
                }
                
                $modEvaluasi = EvaluasipenawaranT::model()->findByPk($modbatalspk->evaluasipenawaran_id);
                if (!empty($modEvaluasi)) {
                    $modEvaluasi->isbatal = true;
                    $ok = $ok && $modEvaluasi->update();
                }
                
                $modPembukaan = PembukaanpenawaranT::model()->findByPk($modbatalspk->pembukaanpenawaran_id);
                if (!empty($modPembukaan)) {
                    $modPembukaan->isbatal = true;
                    $ok = $ok && $modPembukaan->update();
                }                    
                
                $modSyaratkhususkontrakT = SyaratkhususkontrakT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                if(!empty($modSyaratkhususkontrakT)){
                    $modSyaratkhususkontrakT->isbatal = true;
                    $ok = $ok && $modSyaratkhususkontrakT->update();
                }
                
                $modPerintahmulaikerjaT = PerintahmulaikerjaT::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                if(!empty($modPerintahmulaikerjaT)){
                    $modPerintahmulaikerjaT->isbatal = true;
                    $ok = $ok && $modPerintahmulaikerjaT->update();
                }
                $modPerintahpengirimanT = PerintahpengirimanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                if(!empty($modPerintahpengirimanT)){
                    foreach ($modPerintahpengirimanT as $val){
                        $val->isbatal = true;
                        $val->save();
                        $ok = $ok && $val->save();
                    }
                }
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('batal', 'suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render($this->path_view . 'formPembatalan', array('model' => $model));
    }

    /**
     * Fungsi unduh file batal file
     * @param type $id
     */
    public function actionUnduhDokumen($id) {
        $filename = SuratperjanjiankerjaT::model()->findByPk($id);
        $path = Params::pathdokumenSpkDirectory() . "/" . $filename->batal_file;
        if (!empty($filename->batal_file)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->batal_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('no_photo.jpeg', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' .  'no_photo.jpeg'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('no_photo.jpeg', file_get_contents(Yii::getPathOfAlias('webroot').'/data/' . 'no_photo.jpeg'));
        }
    }
}
