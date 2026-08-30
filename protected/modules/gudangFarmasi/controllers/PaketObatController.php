<?php
/**
 * Controller untuk master paket obat
 * @author M Iqbal Laksana <iqbal.laksanao@piindonesia.co.id>
 * @package application.modules.farmasiApotek
 * @subpackage controller
 */
class PaketObatController extends MyAuthController {
    
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'gudangFarmasi.views.paketObat.';    
    public $simpan_paket = true;
    public $simpan_paketdet = true;
    public $simpan_deldetail = true; 

    /* Autocomplate nama obat */
    public function actionAutocompleteObatalkes(){
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            if (isset($_GET['term'])){
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
            }
            $criteria->order = 'obatalkes_nama';
            $criteria->select = 'obatalkes_nama';
            $criteria->group = 'obatalkes_nama';
            $models = ObatalkesM::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->obatalkes_nama;
                $returnVal[$i]['value'] = $model->obatalkes_nama;
                
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
	}
    
    /**
     * Menampilkan detail data.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $modDetail = GFPaketobatdetailM::model()->findAllByAttributes(array('paketobat_id'=>$id));
        $model = $this->loadModel($id);
        $this->render($this->path_view . 'view', array(
            'model' => $model,
            'modDetail' => $modDetail,
        ));
    }

    /**
     * Membuat dan menyimpan data baru.
     */
    public function actionCreate() {
        
        $model = new GFPaketobatM;
        $modDetail = new GFPaketobatdetailM;
        $model->is_paketbmhp = false;
        
        if (isset($_POST['GFPaketobatM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['GFPaketobatM'];
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $this->simpan_paket &= $model->save();
                
                if($this->simpan_paket){
                    if (isset($_POST['GFPaketobatdetailM'])){
                        foreach($_POST['GFPaketobatdetailM'] as $post){
                            $modDetail = new GFPaketobatdetailM();
                            $modDetail->attributes = $post;                            
                            $modDetail->paketobat_id = $model->paketobat_id;
                            $modDetail->create_time = date('Y-m-d H:i:s');
                            $modDetail->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                            $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            
                            $this->simpan_paketdet &= $modDetail->save();                                                        
                        }
                    }
                }

                if ($this->simpan_paketdet && $this->simpan_paketdet) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                    $sukses = 1;
                    $this->redirect(array('admin', 'id' => $model->paketobat_id));
                }else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'modDetail' => $modDetail,
        ));
    }

    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->nama_pegawai = !empty($model->dokter_id)?$model->pegawai->namaLengkap:null;
                
        $modDetail = GFPaketobatdetailM::model()->findAllByAttributes(array('paketobat_id'=>$model->paketobat_id));
        if (isset($_POST['GFPaketobatM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['GFPaketobatM'];
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                
                $this->simpan_paket &= $model->save();
                
                if($this->simpan_paket){
                    if (isset($_POST['GFPaketobatdetailM'])){
                        foreach($_POST['GFPaketobatdetailM'] as $post){                            
                            $modDetail = new GFPaketobatdetailM();
                            $cekDet = GFPaketobatdetailM::model()->findByPk($post['paketobatdetail_id']);
                            if (!empty($cekDet)){
                                $modDetail = $cekDet;
                            }
                            $modDetail->attributes = $post;                            
                            $modDetail->paketobat_id = $model->paketobat_id;
                            $modDetail->update_time = date('Y-m-d H:i:s');
                            $modDetail->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');        
                            if(empty($post['paketobatdetail_id'])){
                                $modDetail->create_time = date('Y-m-d H:i:s');
                                $modDetail->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');        
                            }
                            
                            $this->simpan_paketdet &= $modDetail->save();                                                        
                        }
                    }
                    
                    
                    // echo '<pre>'; var_dump($post['paketobatdetail_id']); die;
                    if (isset($_POST['del_obat'])){
                        $criDel = new CDbCriteria();
                        $criDel->addInCondition("paketobatdetail_id", $_POST['del_obat']);
                        $this->simpan_deldetail &=  GFPaketobatdetailM::model()->deleteAll($criDel);
                        
                        
                    }
                }
                
                if ($this->simpan_paketdet && $this->simpan_paketdet && $this->simpan_deldetail) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                    $sukses = 1;
                    $this->redirect(array('admin', 'id' => $model->paketobat_id));
                }else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
            'modDetail' => $modDetail,
        ));
    }

    /**
     * Memanggil dan Menghapus data.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {
        $id = $_REQUEST['id'];
        if (isset($_REQUEST['id'])) {
            $deleteDetail = PaketobatdetailM::model()->deleteAllByAttributes(array('paketobat_id'=>$id));
            $delete = $this->loadModel($id)->delete();
            if ($delete) {
                $status = 'proses_form';
                $konfirmasi = 'Data berhasil dihapus.';
            }else{
                $status = 'gagal_form';
                $konfirmasi = 'Data gagal dihapus.';
            }

            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => $status,
                    'konfirmasi' => $konfirmasi,
                ));
                exit;
            }
        }
    }
    
    /**     

    /**
     * Memanggil dan menonaktifkan status 
     */
    public function actionNonActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            
            $data['sukses'] = 0;
            $model = $this->loadModel($id);            
            $model->is_aktif = false;
            
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }

    /**
     * Memanggil dan mengaktifkan status 
     */
    public function actionActive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $data['sukses'] = 0;
            $model = $this->loadModel($id);            
            $model->is_aktif = true;
            if ($model->save()) {
                $data['sukses'] = 1;
            }
            echo CJSON::encode($data);
        }
    }
    

    /**
     * Pengaturan data.
     */
    public function actionAdmin() {
        $model = new GFPaketobatM('search');
        $model->unsetAttributes();  // clear any default values
        $model->is_aktif = true;
        if (isset($_GET['GFPaketobatM'])) {
            $model->attributes = $_GET['GFPaketobatM'];
            $model->nama_pegawai = isset($_GET['GFPaketobatM']['nama_pegawai'])?$_GET['GFPaketobatM']['nama_pegawai']:null;
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
        $model = GFPaketobatM::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gftemplateobat-m-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Mencetak data
     */
    public function actionPrint() {
        $model = new GFPaketobatM;
        $model->attributes = $_REQUEST['GFPaketobatM'];
        $judulLaporan = 'Data Master Paket Obat';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }
    
    /**
     * untuk menampilkan set data anggota shift
     */
    public function actionSetObatAlkes()
    {
        if(Yii::app()->request->isAjaxRequest) {          
            $obatalkes_id = isset($_POST['obatalkes_id'])?$_POST['obatalkes_id']:null;
            
            $obatalkes = ObatalkesM::model()->findByPk($obatalkes_id);
            $modDetail = new GFPaketobatdetailM();
            $modDetail->obatalkes_id = $obatalkes->obatalkes_id;
            $modDetail->obatalkes_nama = $obatalkes->obatalkes_nama;
            $modDetail->satuankecil_id = $obatalkes->satuankecil_id;
            $modDetail->satuankecil_nama = !empty($obatalkes->satuankecil_id)?$obatalkes->satuankecil->satuankecil_nama:null;
            $modDetail->jumlah = 1;            
            $form = $this->renderPartial($this->path_view.'_rowDetailObat', 
                    array('modDetail'=>$modDetail), true);
            echo CJSON::encode(array('form'=>$form));
            Yii::app()->end(); 
        }
    }

}
