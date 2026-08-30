<?php

/**
 * Controller untuk halaman penyedia 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class PenyediaMController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'pengadaan.views.penyediaM.';
    public $penyediaTersimpan = true;

    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $modDetail = PengadaandokumenpenyediaM::model()->findAllByAttributes(array('penyedia_id' => $id));
        $this->render($this->path_view . 'view', array(
            'model' => $model,
            'modDetail' => $modDetail
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        if (!empty(Yii::app()->user->getState('ruangan_id'))) {
            $this->layout = $this->layout;
        } else {
            $this->layout = '//layouts/columnPenyedia';
        }
            
        $model = new PenyediaM;
        $modDok = new PengadaandokumenpenyediaM;
        $model->penyedia_statusverifikasi = Params::STATUS_PERSIAPAN_DIAJUKAN;
        $model->penyedia_aktif = false;
        if (isset($_POST['PenyediaM'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $model = new PenyediaM;
                $modDok = new PengadaandokumenpenyediaM();
                if (isset($_POST['PenyediaM'])) {
                    $model->attributes = $_POST['PenyediaM'];
                    $model->penyedia_kode = MyGenerator::registrasiPenyedia();
                    $model->penyedia_statusverifikasi = Params::STATUS_PERSIAPAN_DIAJUKAN;
                    if (empty($model->penyedia_aktif)) {
                        $model->penyedia_aktif = false;
                    } else {

                        $model->penyedia_aktif = true;
                    }
                    $ok = $ok && $model->save();
                    if(!empty($_POST['PengadaandokumenpenyediaM'])){
                        $this->updatePenyedia($model->penyedia_id, $_POST['PengadaandokumenpenyediaM']);
                    }
                }
                if ($ok) {
                    $trans->commit();
                    $this->notifPenyedia($model);
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('admin', 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model) . CHtml::errorSummary($modDok));
                }
            } catch (Exception $ex) {
                $trans->commit();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'modDok' => $modDok
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modDok = PengadaandokumenpenyediaM::model()->findAllByAttributes(array('penyedia_id' => $id));
        // Uncomment the following line if AJAX validation is needed

        if (isset($_POST['PenyediaM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['PenyediaM'];
                $model->save();

                if(!empty($_POST['PengadaandokumenpenyediaM'])){
                    $this->updatePenyedia($id, $_POST['PengadaandokumenpenyediaM']);
                }
                
                if ($model->save() && $this->penyediaTersimpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1));
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>a!</strong> Data gagal disimpan!');
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>b!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($ex));
            }
        }
        if (isset($_POST['PenyediaM'])) {
            $model->attributes = $_POST['PenyediaM'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('view', 'id' => $model->penyedia_id));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
            'modDok' => $modDok
        ));
    }

    /**
     * Menghapus Data
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $modDokumen = PengadaandokumenpenyediaM::model()->findAllByAttributes(array('penyedia_id' => $id));
            foreach ($modDokumen as $mod) {
                $mod->delete();
            }
            $this->loadModel($id)->delete();
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Mengubah status aktif menjadi nonaktif
     */
    public function actionRemoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = PenyediaM::model()->updateByPk($id, array('penyedia_aktif' => false));
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                    ));
                    exit;
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                ));
                exit;
            }
        }
    }

    /**
     * Melihat daftar data.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PenyediaM');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new PenyediaM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PenyediaM'])) {
            $model->attributes = $_GET['PenyediaM'];
        }
        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }

    /**
     * Memanggil data dari model.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PenyediaM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'penyedia-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new PenyediaM;
        $model->attributes = $_REQUEST['PenyediaM'];
        $judulLaporan = 'Data Penyedia';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Load row dokumen
     */
    public function actionLoadDokumen() {
        if (Yii::app()->request->isAjaxRequest) {
            $jenis = $_POST['jenis'];
            $id = isset($_POST['id'])?$_POST['id']:null;
            $tr = '';
            $trDok = '';
            $cri = new CDbCriteria();
            $cri->addCondition(" dokumenpengadaan_aktif = TRUE AND dokumenpengadaan_jenistransaksi = '" . $jenis . "' ");
            $cri->order = " dokumenpengadaan_urutan ASC ";
            $dok = ADDokumenpengadaanM::model()->findAll($cri);
            
            
            $cekDok = array();
            
            if (!empty($id)){
                $loadDok = PengadaandokumenpenyediaM::model()->findAllByAttributes(array('penyedia_id'=>$id));
                
                if (!empty($loadDok)){
                    foreach($loadDok as $file){
//                        echo '<pre';
//                        var_dump($file);
//                        die;
                        $cekDok[$file->penyedia_id][$file->dokumenpengadaan_id]['file'] = $file->pengadaandokumenpenyedia_file;
                        $cekDok[$file->penyedia_id][$file->dokumenpengadaan_id]['id'] = $file->pengadaandokumenpenyedia_id;
                        $cekDok[$file->penyedia_id][$file->dokumenpengadaan_id]['nomor'] = $file->nomor_dokumen;
                    }
                }
            }
            
            if (!empty($dok)) {
                foreach ($dok as $i => $d) {
                    $class = '';
                    $jenis = array();
                    $tipe = array();

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

                    if ($d->dokumenpengadaan_wajib) {
                        $class = ' required ';
                    }
                    $modDok = new PengadaandokumenpenyediaM();
                    if (empty($id)) {
                        $modPenyedia = new PenyediaM();
                    } else {
                        $modPenyedia = PenyediaM::model()->findByPk($id);
                    }
                    
                    if (!empty($cekDok[$file->penyedia_id][$file->dokumenpengadaan_id]['file'])){
                        $modDok->pengadaandokumenpenyedia_file = $cekDok[$file->penyedia_id][$file->dokumenpengadaan_id]['file'];
                        $modDok->pengadaandokumenpenyedia_id = $cekDok[$file->penyedia_id][$file->dokumenpengadaan_id]['id'];
                        $modDok->nomor_dokumen = $cekDok[$file->penyedia_id][$file->dokumenpengadaan_id]['nomor'];
                    }
                    
                    $modDok->jenis_dokumen = $d->dokumenpengadaan_nama;
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;
                    $modDok->penyedia_id = $modPenyedia->penyedia_id;
                    $modDok->temp_file = $modDok->pengadaandokumenpenyedia_file;

                    $trDok .= $this->renderPartial($this->path_view . '_rowDokDukung', array('jenis' => $jenis, 'tipe' => $tipe, 'required' => $class, 'modDok' => $modDok, 'i' => $i), true);       
                }
            }
            $data['tr'] = $tr;
            $data['dokDukung'] = $trDok;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new PasienM;
            if ($model_nama !== '' && $attr == '') {
                $propinsi_id = $_POST["$model_nama"]['penyedia_propinsi'];
            } elseif ($model_nama == '' && $attr !== '') {
                $propinsi_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $propinsi_id = $_POST["$model_nama"]["$attr"];
            }
            $kabupaten = null;

            $kabupaten = $modPasien->getKabupatenItems($_POST['PenyediaM']['penyedia_propinsi']);
            $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
            if ($encode) {
                echo CJSON::encode($kabupaten);
            } else {
                if (empty($kabupaten)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kabupaten as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Kirim Notifikasi Transaksi ke ruangan dengan instalasi pengadaan
     * @param type $modPenyedia
     * @return type
     */
    public function notifPenyedia($modPenyedia) {
        $penyedia = PenyediaM::model()->findByPk($modPenyedia->penyedia_id);

        $judul = 'Pendaftaran Penyedia Baru';

        $isi = $penyedia->penyedia_kode . ' ' . $penyedia->penyedia_nama . '<br/>'
                . 'Terdaftar sebagai penyedia ' . $penyedia->penyedia_jenis;

        $ok = true;

        $cri = new CDbCriteria();
        $cri->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
        $cri->addCondition(" i.instalasi_aktif = TRUE AND t.ruangan_aktif = TRUE ");
        $r = RuanganM::model()->findAll($cri);

        foreach ($r as $d) {
            if (!empty($d->modul_id)) {
                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id' => Params::INSTALASI_ID_BAGIAN_TU, 'ruangan_id' => $d->ruangan_id, 'modul_id' => Params::MODUL_ID_PENGADAAN),
                ));
            }
        }
        return $ok;
    }

    /**
     * Verifikasi Penyedia
     * @param type $id
     */
    public function actionVerifikasi($id) {
        $model = PenyediaM::model()->findByPk($id);
        $modDetail = PengadaandokumenpenyediaM::model()->findAllByAttributes(array('penyedia_id' => $id));
        if (isset($_POST['PenyediaM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $update = PenyediaM::model()->updateByPk($id, array('penyedia_aktif' => true, 'penyedia_statusverifikasi' => Params::STATUS_MUTASIBARANG_DISETUJUI));
                if(!empty($_POST['PengadaandokumenpenyediaM'])){
                    $this->updatePenyedia($id, $_POST['PengadaandokumenpenyediaM']);
                }
                
                if ($update && $this->penyediaTersimpan) {
                    $transaction->commit();
                    $this->redirect(array('admin', 'sukses' => 1));
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>a!</strong> Data gagal disimpan!');
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>b!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($ex));
            }
        }
        $this->render($this->path_view . 'verifikasi', array('model' => $model, 'modDetail' => $modDetail));
    }

    /**
     * Menyimpan data Dokumen Penyedia 
     * @param type $id
     * @param type $post
     */
    public function updatePenyedia($id, $post) {
        foreach ($post as $i => $dokumen) {
            $temp = '';
            if (!empty($_GET['id'])) {
                $mod = PengadaandokumenpenyediaM::model()->findByAttributes(array('penyedia_id' => $id));
                $mod->dokumenpengadaan_id = $dokumen['dokumenpengadaan_id'];
                $mod->jenis_dokumen = $dokumen['jenis_dokumen'];
                $mod->nomor_dokumen = $dokumen['nomor_dokumen'];
                $mod->penyedia_id = $id;
                $mod->pengadaandokumenpenyedia_file = $dokumen['pengadaandokumenpenyedia_file'];
                $mod->attributes = $dokumen;
                $mod->pengadaandokumenpenyedia_file = CUploadedFile::getInstance($mod, '[' . $i . ']pengadaandokumenpenyedia_file');
                if (!empty($mod->pengadaandokumenpenyedia_file)) {
                    $dokumen_pendukung = $mod->pengadaandokumenpenyedia_file;

                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY H:i:s') . $dokumen_pendukung));
                    $fullImgSource = Params::pathDokRegistrasiPenyediaDirectory() . $fullImgName;

                    $mod->pengadaandokumenpenyedia_file = $fullImgName;

                    if (file_exists(Params::pathDokRegistrasiPenyediaDirectory())){
                        mkdir(Params::pathDokRegistrasiPenyediaDirectory(), 0755, true);
                    }
                    
                    if (!empty($dokumen_pendukung)) {
                        if ($mod->pengadaandokumenpenyedia_file != $temp) {
                            if (!empty($temp)) {
                                if (file_exists(Params::pathDokRegistrasiPenyediaDirectory() . $temp)) {
                                    unlink(Params::pathDokRegistrasiPenyediaDirectory() . $temp);
                                }
                            }
                        }
                        $dokumen_pendukung->saveAs($fullImgSource);
                    }
                }
                $mod->save();
            } else {
                $model = new PengadaandokumenpenyediaM;
                $model->attributes = $dokumen;
                $model->penyedia_id = $id;
                $files = $_FILES['PengadaandokumenpenyediaM'];
                if (!empty($files)) {
                    $model->pengadaandokumenpenyedia_file = CUploadedFile::getInstance($model, '[' . $i . ']pengadaandokumenpenyedia_file');
                    $dokumen_pendukung = $model->pengadaandokumenpenyedia_file;
                    $fullImgName = str_replace(' ', '_', strtolower(date('dmY H:i:s') . $dokumen_pendukung));
                    $fullImgSource = Params::pathDokRegistrasiPenyediaDirectory() . $fullImgName;
                    $model->pengadaandokumenpenyedia_file = $fullImgName;

                    if (file_exists(Params::pathDokRegistrasiPenyediaDirectory())){
                        mkdir(Params::pathDokRegistrasiPenyediaDirectory(), 0755, true);
                    }
                    
                    if (!empty($dokumen_pendukung)) {
                        if ($model->pengadaandokumenpenyedia_file != $temp) {
                            if (!empty($temp)) {
                                if (file_exists(Params::pathDokRegistrasiPenyediaDirectory() . $temp)) {
                                    unlink(Params::pathDokRegistrasiPenyediaDirectory() . $temp);
                                }
                            }
                        }
                        $dokumen_pendukung->saveAs($fullImgSource);
                    }
                }
                $model->save();
            }
        }
    }

    /**
     * Persetujuan Penyedia
     * @throws CHttpException
     */
    public function actionSetSetuju() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $model = PenyediaM::model()->findByPk($id);
            $model->penyedia_aktif = true;
            $model->penyedia_statusverifikasi = Params::STATUS_TERIMAOA_DISETUJUI;
            if ($model->save()) {
                $this->notifBuatUserPenyedia($model);
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-success'>Pembatalan berhasil disimpan.</div>",
                    ));
                    exit;
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'gagal_form',
                        'div' => "<div class='flash-danger'>Pembatalan gagal disimpan.</div>",
                    ));
                    exit;
                }
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Tolak Penyedia
     * @throws CHttpException
     */
    public function actionSetTolak() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $model = PenyediaM::model()->findByPk($id);
            $model->penyedia_statusverifikasi = Params::STATUS_TERIMAOA_DITOLAK;
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-success'>Pembatalan berhasil disimpan.</div>",
                    ));
                    exit;
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'gagal_form',
                        'div' => "<div class='flash-danger'>Pembatalan gagal disimpan.</div>",
                    ));
                    exit;
                }
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Kirim Notifikasi Transaksi ke Sistem Administrator
     * @param type $model
     * @return type
     */
    public function notifBuatUserPenyedia($model) {
        $penyedia = PenyediaM::model()->findByPk($model->penyedia_id);

        $judul = 'Pembuatan User Penyedia';

        $isi = 'Penyedia ' .$penyedia->penyedia_nama .' dengan kode '. $penyedia->penyedia_kode . ' '
                . 'sebagai penyedia ' . $penyedia->penyedia_jenis . ' sudah disetujui. Mohon untuk segera membuat user Penyedia tersebut.';

        $ok = true;

        $cri = new CDbCriteria();
        $cri->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
        $cri->addCondition(" i.instalasi_aktif = TRUE AND t.ruangan_aktif = TRUE ");
        $r = RuanganM::model()->findAll($cri);

        foreach ($r as $d) {
            if (!empty($d->modul_id)) {
                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id' => Params::INSTALASI_ID_SISADMIN, 'ruangan_id' => $d->ruangan_id, 'modul_id' => Params::MODUL_ID_SISADMIN),
                ));
            }
        }
        return $ok;
    }
    
    /**
     * Fungsi unduh lampiran lisensi 
     * @param type $lisensi_id
     */
    public function actionUnduh($id) {
        $filename = PengadaandokumenpenyediaM::model()->findByPk($id);
        $path = Params::pathDokRegistrasiPenyediaDirectory()."/".$filename->pengadaandokumenpenyedia_file;
        if (!empty($filename->pengadaandokumenpenyedia_file)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->pengadaandokumenpenyedia_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathDokRegistrasiPenyediaDirectory().'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathDokRegistrasiPenyediaDirectory().'file_tidak_ditemukan.txt'));   
        }
    }
}
