<?php
/**
 * Informasi Pengadaan untuk Penyedia.
 * Juga proses detail dan penawaran penyedia.
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Tantowi J <tantowijaya@.com>
 * 
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class InformasiPengadaanPenyediaController extends MyAuthController{
    
    public $path_view = 'pengadaan.views.informasiPengadaanPenyedia.';
    public $layout = '//layouts/column1';

    /**
     * Index Informasi Pengadaan untuk Penyedia
     */
    public function actionIndex(){
         if (empty(Yii::app()->user->getState('supplier_id'))) {
            $this->layout = $this->layout;
        } else {
            $this->layout = '//layouts/columnPenyedia';
        }
        $model = new ADInformasipersiapanpengadaanV(); 
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['ADInformasipersiapanpengadaanV'])){
            $model->attributes = $_GET['ADInformasipersiapanpengadaanV'];
            if(!empty($_GET['ADPersiapanpengadaanT']['nama_pekerjaan'])){
                $model->nama_pekerjaan = $_GET['ADInformasipersiapanpengadaanV']['nama_pekerjaan'];    
            }
            if(!empty($_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_nomor'])){
                $model->rencanaumumpengadaan_nomor = $_GET['ADInformasipersiapanpengadaanV']['rencanaumumpengadaan_nomor'];    
            }
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['ADInformasipersiapanpengadaanV']['tgl_awal']);    
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['ADInformasipersiapanpengadaanV']['tgl_akhir']); 
        }
        $this->render($this->path_view.'index', array('model' => $model));
    }
    
    /**
     * Detail Informasi Pengadaan
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = ADPersiapanpengadaanT::model()->findByPk($id);
        $model->diumumkan_tanggal = MyFormatter::formatDateTimeForUser($model->diumumkan_tanggal);
        $modRencana = RencanaumumpengadaanT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenisPengadaan = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenis = JenispengadaanM::model()->findByPk($modJenisPengadaan->jenispengadaan_id);
        $modDokumen = PengadaandokumenpendukungT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $id, 'dokumenpendukungpengadaan_nama' => Params::DOKUMEN_PENGADAAN_PENYEDIA));
        
        $this->render($this->path_view.'detail', 
                array(
                        'model' => $model, 
                        'modRencana' => $modRencana, 
                        'modJenisPengadaan' => $modJenisPengadaan, 
                        'modJenis' => $modJenis,
                        'modDokumen' => $modDokumen));
    } 
    
    /**
     * Pengajuan Penawaran 
     * @param type $id
     */
    public function actionPenawaran($id){
        $this->layout = '//layouts/iframe';
        $model = ADPersiapanpengadaanT::model()->findByPk($id);
        $model->diumumkan_tanggal = MyFormatter::formatDateTimeForUser($model->diumumkan_tanggal);
        $modRencana = RencanaumumpengadaanT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenisPengadaan = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenis = JenispengadaanM::model()->findByPk($modJenisPengadaan->jenispengadaan_id);
        $modDokumen = PengadaandokumenpendukungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'dokumenpendukungpengadaan_nama' => Params::DOKUMEN_PENGADAAN_PENYEDIA));
        $modPenawaran = new PenawaranpenyediaT();
        $modPenyedia = new PenyediaM;
        
        $modPenawaran->penawaranpenyedia_tanggal = date('d M Y H:i:s');
        
        if(!empty($_GET['loginpemakai_id'])){
            $login = LoginpemakaiK::model()->findByPk($_GET['loginpemakai_id']);
            if(!empty($login->penyedia_id)){
                $modPenyedia = PenyediaM::model()->findByPk($login->penyedia_id);
            }
        }
        
        if(isset($_POST['PenawaranpenyediaT'])){
            try {
                $files = $_FILES['PenawaranpenyediaT'];
                $transaction = Yii::app()->db->beginTransaction();
                $modPenawaran->attributes = $_POST['PenawaranpenyediaT'];
                $modPenawaran->penawaranpenyedia_tanggal = MyFormatter::formatDateTimeForDb($modPenawaran->penawaranpenyedia_tanggal);
                $modPenawaran->penawaranpenyedia_nomor = MyGenerator::noPenawaranPenyedia();
                $modPenawaran->persiapanpengadaan_id = $model->persiapanpengadaan_id;
                $modPenawaran->penyedia_id = $modPenyedia->penyedia_id;
                $modPenawaran->penawaranpenyedia_status = "Diajukan";
                $modPenawaran->ispemenang = false;
                
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
                
                if($modPenawaran->save()){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
                    $this->redirect(array('penawaran', 'id' => $id, 'loginpemakai_id' => $login->penyedia_id, 'sukses' => 1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
                }
            
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan'.$ex);
            }
        }
        
        $this->render($this->path_view.'penawaran', 
            array(
                'model' => $model, 
                'modRencana' => $modRencana, 
                'modJenisPengadaan' => $modJenisPengadaan, 
                'modJenis' => $modJenis,
                'modDokumen' => $modDokumen,
                'modPenawaran' => $modPenawaran,
                'modPenyedia' => $modPenyedia
            ));
    }
    
    /**
     * Fungsi unduh lampiran Dokumen Pengadaan
     * @param type $id
     */
    public function actionUnduh($id) {
        $filename = PengadaandokumenpendukungT::model()->findByAttributes(array('dokumenpendukungpengadaan_id' => $id));
        $path = Params::pathDokPersiapanPengadaanDirectory()."/".$filename->dokumenpendukungpengadaan_nama;
        if (!empty($filename->lisensi_file)) {
            if (file_exists($path)) {
                Yii::app()->getRequest()->sendFile($filename->lisensi_file, file_get_contents($path));
            } else {
                Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathDokPersiapanPengadaanDirectory().'file_tidak_ditemukan.txt'));
            }
        } else {
            Yii::app()->getRequest()->sendFile('file_tidak_ditemukan.txt', file_get_contents(Params::pathDokPersiapanPengadaanDirectory().'file_tidak_ditemukan.txt'));   
        }
    }
    
    /**
     * submit login penyedia dari dialog login
     */
    public function actionAjaxLogin() {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $data['pesan'] = '';
            $data['loginpemakai_id'] = null;
            $data['urlPenawaran'] = null;

            $criteria = new CDbCriteria;
            $criteria->addCondition("nama_pemakai = :nama_pemakai");
            $criteria->params[':nama_pemakai'] = $_POST['username'];
            $criteria->addCondition('loginpemakai_aktif IS TRUE');
            $criteria->addCondition('penyedia_id IS NOT NULL');
            $log = LoginpemakaiK::model()->find($criteria);
            if(!empty($log)){
                $cek = $log->cekPassword3($_POST['password']);
                if ($cek) {
                    $data['sukses'] = 1;
                    $data['loginpemakai_id'] = $log->loginpemakai_id;
                    $data['urlPenawaran'] = 'pengadaan/'.Yii::app()->controller->id.'/penawaran&id='.$_POST['persiapanpengadaan_id'].'&loginpemakai_id='.$log->loginpemakai_id;
                } else {
                    $data['pesan'] = 'Login gagal! Silahkan masukan nama pemakai dan kata kunci dengan benar!';
                }
            }else{
                $data['pesan'] = 'Login gagal! Nama pemakai tidak ditemukan!';
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Login halaman detail
     */
    public function actionajaxLoginDetail() {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $data['pesan'] = '';
            $data['loginpemakai_id'] = null;
            $data['urlDetail'] = null;

            $criteria = new CDbCriteria;
            $criteria->addCondition("nama_pemakai = :nama_pemakai2");
            $criteria->params[':nama_pemakai2'] = $_POST['username'];
            $criteria->addCondition('loginpemakai_aktif IS TRUE');
            $criteria->addCondition('penyedia_id IS NOT NULL');
            $log = LoginpemakaiK::model()->find($criteria);
            if(!empty($log)){
                $cek = $log->cekPassword3($_POST['password']);
                if ($cek) {
                    $data['sukses'] = 1;
                    $data['loginpemakai_id'] = $log->loginpemakai_id;
                    $data['urlDetail'] = 'pengadaan/informasiPengadaanPenyedia/detail&id='.$_POST['persiapan'].'&loginpemakai_id='.$log->loginpemakai_id;
                } else {
                    $data['pesan'] = 'Login gagal! Silahkan masukan nama pemakai dan kata kunci dengan benar!';
                }
            }else{
                $data['pesan'] = 'Login gagal! Nama pemakai tidak ditemukan!';
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }

}