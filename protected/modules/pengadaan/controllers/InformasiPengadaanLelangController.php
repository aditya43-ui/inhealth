<?php
/**
 * Controller untuk Informasi Pengadaan Lelang
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class InformasiPengadaanLelangController extends MyAuthController{
    public $path_view = 'pengadaan.views.informasiPengadaanLelang.';
    public $path_detail = 'pengadaan.views.informasiPengadaanLelang.detail.';
    public $riwayatTersimpan = true;
    
    /**
     * Load halaman index informasi pengadaan lelang
     */
    public function actionIndex(){
        $model = new ADPersiapanpengadaanT();
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['ADPersiapanpengadaanT'])){
            $model->attributes = $_GET['ADPersiapanpengadaanT'];

            if(!empty($_GET['ADPersiapanpengadaanT']['nama_pekerjaan'])){
                $model->nama_pekerjaan = $_GET['ADPersiapanpengadaanT']['nama_pekerjaan'];    
            }
            if(!empty($_GET['ADPersiapanpengadaanT']['persiapanpengadaan_nomor'])){
                $model->persiapanpengadaan_nomor = $_GET['ADPersiapanpengadaanT']['persiapanpengadaan_nomor'];    
            }

            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['ADPersiapanpengadaanT']['tgl_awal']);    
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['ADPersiapanpengadaanT']['tgl_akhir']); 
        }
        $this->render('index', array('model' => $model));
    }
    
    /**
     * Halaman Detail Persiapan Pengadaan
     * @param type $id
     */
    public function actionDetailPersiapan($id){
        $this->layout = '//layouts/iframe';
        $model = ADPersiapanpengadaanT::model()->findByPk($id);
        $model->diumumkan_tanggal = MyFormatter::formatDateTimeForUser($model->diumumkan_tanggal);
        $modRencana = RencanaumumpengadaanT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenisPengadaan = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenis = JenispengadaanM::model()->findByPk($modJenisPengadaan->jenispengadaan_id);
        $modDokumen = PengadaandokumenpendukungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'dokumenpendukungpengadaan_nama' => Params::DOKUMEN_PENGADAAN_PENYEDIA));

        $this->render('detailPersiapan', 
                array(
                        'model' => $model, 
                        'modRencana' => $modRencana, 
                        'modJenisPengadaan' => $modJenisPengadaan, 
                        'modJenis' => $modJenis,
                        'modDokumen' => $modDokumen));
    }
    
    /**
     * Halaman Detail yang memuat tab menu persiapan, penawaran, seleksi dan pengumuman
     * @param type $id
     */
    public function actionDetail($id){
        $model = ADPersiapanpengadaanT::model()->findByPk($id);
        $model->diumumkan_tanggal = MyFormatter::formatDateTimeForUser($model->diumumkan_tanggal);
        $modRencana = RencanaumumpengadaanT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenisPengadaan = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenis = JenispengadaanM::model()->findByPk($modJenisPengadaan->jenispengadaan_id);
        $modDokumen = PengadaandokumenpendukungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'dokumenpendukungpengadaan_nama' => Params::DOKUMEN_PENGADAAN_PENYEDIA));

        $this->render('detail', 
                array(
                        'model' => $model, 
                        'modRencana' => $modRencana, 
                        'modJenisPengadaan' => $modJenisPengadaan, 
                        'modJenis' => $modJenis,
                        'modDokumen' => $modDokumen));
    }
    
    /**
     * Memuat halaman penyedia
     * @param type $id
     */
    public function actionPenyedia($id){
        $this->layout = '//layouts/iframe';
        $model = ADPersiapanpengadaanT::model()->findByPk($id);
        $model->diumumkan_tanggal = MyFormatter::formatDateTimeForUser($model->diumumkan_tanggal);
        $modRencana = RencanaumumpengadaanT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenisPengadaan = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
        $modJenis = JenispengadaanM::model()->findByPk($modJenisPengadaan->jenispengadaan_id);
        $modDokumen = PengadaandokumenpendukungT::model()->findByAttributes(array('persiapanpengadaan_id' => $id, 'dokumenpendukungpengadaan_nama' => Params::DOKUMEN_PENGADAAN_PENYEDIA));
        
        $this->render($this->path_detail.'penyedia', 
                array(
                        'model' => $model, 
                        'modRencana' => $modRencana, 
                        'modJenisPengadaan' => $modJenisPengadaan, 
                        'modJenis' => $modJenis,
                        'modDokumen' => $modDokumen));
        
    }
    
    /**
     * Load halaman penawaran
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
        $modRiwayatDet = array();
        $modRiwayat = new RiwayatpenawaranpenyediaR();
        
        if (isset($_POST['PenawaranpenyediaT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach ($_POST['PenawaranpenyediaT'] as $i => $post) {
                    if (isset($post['cekList']) == 1) {
                        $this->simpanRiwayat($modRiwayat, $post);
                    }
                }
                if ($this->riwayatTersimpan) {
                    $transaction->commit();
                    $this->redirect(array('index', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data Pencucian Linen gagal disimpan !");
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Pencucian Linen gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));

            }
        }
        
        $this->render($this->path_detail.'penawaran', 
                array(
                        'model' => $model, 
                        'modRencana' => $modRencana, 
                        'modJenisPengadaan' => $modJenisPengadaan, 
                        'modJenis' => $modJenis,
                        'modDokumen' => $modDokumen));
    }
    
    /**
     * Menyimpan riwayat penawaran penyedia pada tab Penawaran
     * @param type $modRiwayat
     * @param type $detail
     * @return \RiwayatpenawaranpenyediaR
     */
    public function simpanRiwayat($modRiwayat, $detail){
        $modRiwayatDet = new RiwayatpenawaranpenyediaR();
        $modRiwayatDet->attributes = $detail;
        $modRiwayatDet->penawaranpenyedia_id = $detail['penawaranpenyedia_id'];
        $modRiwayatDet->penilaian_peg = Yii::app()->user->getState('pegawai_id');
        $modRiwayatDet->create_time =  date('Y-m-d H:i:s');
        $modRiwayatDet->penilaian_waktu =  date('Y-m-d H:i:s');
        if ($modRiwayatDet->validate()) {
            $modRiwayatDet->save();
            $this->riwayatTersimpan &= true;
        } else {
            $this->riwayatTersimpan &= false;
            echo CHtml::errorSummary($modRiwayatDet);
            exit();
        }
        return $modRiwayatDet;
    }
    
    /**
     * Load tabel transaksi pada tab Penawaran
     */
    public function actionGetDokumen(){
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $id = $_POST['id'];
            $model = new PenawaranpenyediaT();
            $data['form'] = "";
            $models = PenawaranpenyediaT::model()->findAllByAttributes(['persiapanpengadaan_id' => $id]); 
            if(count($models) > 0) {
                foreach ($models AS $i => $model){
                    $cekRiwayat = RiwayatpenawaranpenyediaR::model()->findByAttributes(array('penawaranpenyedia_id' => $model->penawaranpenyedia_id));
                    if (!empty($cekRiwayat)) {
                        $modRiwayat = $cekRiwayat;
                    } else {
                        $modRiwayat = new RiwayatpenawaranpenyediaR();
                    }
                    $model->attributes = $modRiwayat->attributes;
                    $data['form'] .= $this->renderPartial($this->path_detail.'_rowPenawaran',array('model'=>$model, 'modRiwayat' => $modRiwayat, 'i' => $i),true);
                }
            }else{
                $data['form'] .= $this->renderPartial($this->path_detail.'_rowPenawaran',array('model'=>$model),true);
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    
}
