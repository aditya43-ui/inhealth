<?php

/**
 * Controller untuk redirect ketika login sebagai supplier
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class RegistrasiSupplierController extends MyAuthController{
    public $penyediaTersimpan = true;
    public $layout = '//layouts/columnPenyedia';
    public $khusus_supplier = true;
    
    /**
     * Halaman index untuk registrasi supplier
     */
    public function actionIndex(){
        $this->layout = '//layouts/columnPenyedia';
        $model = SupplierM::model()->findByPk(Yii::app()->user->getState('supplier_id'));
        $modDok = new PengadaandokumenpenyediaM;
        $modPenawaran = new PenawaranpenyediaT();
        $modPenawaran->penawaranpenyedia_tanggal = date('d M Y H:i:s');

        $model->pbf_nama = !empty($model->pbf_id) ? $model->pbf->pbf_nama : "";
        
        if (isset($_POST['SupplierM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                if (isset($_POST['PenawaranpenyediaT'])) {
                    $files = $_FILES['PenawaranpenyediaT'];
                    $modPenawaran->attributes = $_POST['PenawaranpenyediaT'];
                    if (empty($cekPenawaran)) {
                        $modPenawaran->penawaranpenyedia_nomor = MyGenerator::noPenawaranPenyedia();
                    } else {
                        $modPenawaran->penawaranpenyedia_nomor = $modPenawaran->penawaranpenyedia_nomor;
                    }
                        
                    $modPenawaran->penawaranpenyedia_tanggal = MyFormatter::formatDateTimeForDb($modPenawaran->penawaranpenyedia_tanggal);
                    $modPenawaran->supplier_id = $model->supplier_id;
                    $modPenawaran->penawaranpenyedia_status = "Diajukan";
                    $modPenawaran->ispemenang = true;
                    $modPenawaran->penawaranpenyedia_harga = MyFormatter::formatNumberForDb($_POST['PenawaranpenyediaT']['penawaranpenyedia_harga']);
                    if(!empty($files["tmp_name"]['penawaranpenyedia_file'])){
                        $modPenawaran->penawaranpenyedia_file = CUploadedFile::getInstance($modPenawaran, 'penawaranpenyedia_file');
                        if (!empty($modPenawaran->penawaranpenyedia_file)) {
                            $filePDF = $modPenawaran->penawaranpenyedia_file;

                            $fileName = $modPenawaran->penawaranpenyedia_nomor.".pdf";
                            $filePath = Params::pathPenawaranPenyediaFileDirectory() . $fileName;

                            $filePDF->saveAs($filePath);
                            $modPenawaran->penawaranpenyedia_file = $fileName;
                        }
                    }
                    $ok = $ok && $modPenawaran->save();
                }
                
                if (isset($_POST['PengadaandokumenpenyediaM'])) {
                    foreach ($_POST['PengadaandokumenpenyediaM'] as $i => $dokumen) {
                        $temp = '';
                        if (!empty($dokumen['nomor_dokumen'])) {
                            if (!empty($dokumen['pengadaandokumenpenyedia_id'])) {
                                $modDok = PengadaandokumenpenyediaM::model()->findByPk($dokumen['pengadaandokumenpenyedia_id']);
                                $modDok->attributes = $dokumen;
                                $modDok->dokumenpengadaan_id = $dokumen['dokumenpengadaan_id'];
                                $modDok->jenis_dokumen = $dokumen['jenis_dokumen'];
                                $modDok->nomor_dokumen = $dokumen['nomor_dokumen'];
                                $modDok->supplier_id = $model->supplier_id;
                                
                                $temp = $dokumen['temp_file'];
                                $modDok->pengadaandokumenpenyedia_file = CUploadedFile::getInstance($modDok, '['.$i.']pengadaandokumenpenyedia_file');

                                if (!empty($modDok->pengadaandokumenpenyedia_file)){
                                    $dokumen_pendukung = $modDok->pengadaandokumenpenyedia_file;

                                    $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumen_pendukung));
                                    $fullImgSource = Params::pathDokRegistrasiPenyediaDirectory() . $fullImgName;

                                    $modDok->pengadaandokumenpenyedia_file = $fullImgName;                                                                                                
                                }else{
                                    $modDok->pengadaandokumenpenyedia_file = $temp;
                                }
                            } else {
                                $modDok = new PengadaandokumenpenyediaM;
                                $modDok->attributes = $dokumen;
                                $modDok->dokumenpengadaan_id = $dokumen['dokumenpengadaan_id'];
                                $modDok->supplier_id = $model->supplier_id;
                                $modDok->jenis_dokumen = $dokumen['jenis_dokumen'];
                                $modDok->nomor_dokumen = $dokumen['nomor_dokumen'];
                                $modDok->pengadaandokumenpenyedia_file = CUploadedFile::getInstance($modDok, '['.$i.']pengadaandokumenpenyedia_file');

                                if (!empty($modDok->pengadaandokumenpenyedia_file)){
                                    $dokumen_pendukung = $modDok->pengadaandokumenpenyedia_file;

                                    $fullImgName = str_replace(' ','_',strtolower(date('dmY_s').$dokumen_pendukung));
                                    $fullImgSource = Params::pathDokRegistrasiPenyediaDirectory() . $fullImgName;

                                    $modDok->pengadaandokumenpenyedia_file = $fullImgName;
                                    
                                    $dokumen_pendukung->saveAs($fullImgSource);
                                }
                            }
                        }
                        $ok = $ok && $modDok->save();
                        
                        if (!empty($dokumen_pendukung)){		
                            if ($modDok->pengadaandokumenpenyedia_file != $temp){
                                if (!empty($temp)){
                                    if (file_exists(Params::pathDokRegistrasiPenyediaDirectory().$temp)){
                                        unlink(Params::pathDokRegistrasiPenyediaDirectory().$temp);
                                    }
                                }
                            }
                            
                            $dokumen_pendukung->saveAs($fullImgSource);
                        }
                    }
                }
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model, $modPenawaran, $modDok));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render('index', array('model' => $model, 'modDok' => $modDok, 'modPenawaran' => $modPenawaran));
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
                $loadDok = PengadaandokumenpenyediaM::model()->findAllByAttributes(array('supplier_id'=>$id));
                if (!empty($loadDok)){
                    foreach($loadDok as $file){
                        $cekDok[$file->supplier_id][$file->dokumenpengadaan_id]['id'] = $file->pengadaandokumenpenyedia_id;
                        $cekDok[$file->supplier_id][$file->dokumenpengadaan_id]['file'] = $file->pengadaandokumenpenyedia_file;
                        $cekDok[$file->supplier_id][$file->dokumenpengadaan_id]['nomor'] = $file->nomor_dokumen;
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

                    $modDok = new PengadaandokumenpenyediaM;
                    
                    if (isset($cekDok[$id][$d->dokumenpengadaan_id]['id'])){
                        $modDok->pengadaandokumenpenyedia_id = $cekDok[$id][$d->dokumenpengadaan_id]['id'];
                        $modDok->pengadaandokumenpenyedia_file = $cekDok[$id][$d->dokumenpengadaan_id]['file'];
                        $modDok->nomor_dokumen = $cekDok[$id][$d->dokumenpengadaan_id]['nomor'];
                    }
                    
                    $modDok->jenis_dokumen = $d->dokumenpengadaan_nama;
                    $modDok->dokumenpengadaan_id = $d->dokumenpengadaan_id;
                    $modDok->supplier_id = $id;
                    $modDok->temp_file = $modDok->pengadaandokumenpenyedia_file;

                    $trDok .= $this->renderPartial('_rowDokDukung', array('jenis' => $jenis, 'tipe' => $tipe, 'required' => $class, 'modDok' => $modDok, 'i' => $i), true);       
                }
            }
            $data['tr'] = $tr;
            $data['dokDukung'] = $trDok;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Proses unduh dokumen penyedia
     * @param integer $pengadaandokumenpenyedia_id
     */
    public function actionUnduhDok($pengadaandokumenpenyedia_id) {

        $filename = PengadaandokumenpenyediaM::model()->findByPk($pengadaandokumenpenyedia_id);

        $path = Params::pathDokRegistrasiPenyediaDirectory() . $filename->pengadaandokumenpenyedia_file;

        if (!empty($filename->pengadaandokumenpenyedia_file)) {
            if (file_exists($path)) {

                Yii::app()->getRequest()->sendFile($filename->pengadaandokumenpenyedia_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathDokRegistrasiPenyediaDirectory() . 'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathDokRegistrasiPenyediaDirectory() . 'file_tidak_ditemukan.txt'));
        }
    }
}
