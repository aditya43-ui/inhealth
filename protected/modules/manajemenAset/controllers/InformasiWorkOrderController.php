<?php

/**
 * Digunakan sebagai informasi work order 
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.manajemenAset
 * @subpackage controllers
 * @category controller
 */
class InformasiWorkOrderController extends MyAuthController {

    /**
     * Halama index untuk informasi work order
     */
    public function actionIndex() {
        $model = new MAInfoworkorderV('searchInformasi');
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['MAInfoworkorderV'])) {
            $model->attributes = $_GET['MAInfoworkorderV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInfoworkorderV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInfoworkorderV']['tgl_akhir']);
        }
        
        $aset = PenanggungjawabasetM::model()->find(" pegawai_id = ".Yii::app()->user->getState('pegawai_id')." AND penanggungjawabaset_aktif = TRUE ");
        if (!empty($aset)){
            $model->is_pj_asset = true;
            $model->pj_pemeliharaan_id = Yii::app()->user->getState('pegawai_id');
        }
                
        $this->render('index', array(
            'model' => $model,
                )
        );
    }

    /**
     * Mengubah status menjadi in progres 
     * @throws CHttpException
     */
    public function actionUbahStatusInProgress() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $model = WorkorderT::model()->findByPk($id);
            $model->pegprogress_id = Yii::app()->user->getState('pegawai_id');
            $model->status_pemeliharaan = ParamsConst::STATUS_WO_PROGRESS;
            $model->wo_progress = date("Y-m-d H:i:s");
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                
            $model->save();
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil ditambahkan.</div>",
                ));
                exit;
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
    
    /**
     * Mengubah status menjadi in progres 
     * @throws CHttpException
     */
    public function actionUbahStatusClose() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            $model = WorkorderT::model()->findByPk($id);
            $model->wo_close = date("Y-m-d H:i:s");
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $model->status_pemeliharaan = ParamsConst::STATUS_WO_CLOSE;
            $model->save();
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil ditambahkan.</div>",
                ));
                exit;
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Halaman detail 
     * @param type $id
     */
    public function actionDetail($id,$frame='') {

        if ($frame != 'not'){                    
            $this->layout = '//layouts/iframe';
        }
        $modelView = InfoworkorderV::model()->findByAttributes(array('workorder_id' => $id));
        $model = WorkorderT::model()->findByPk($modelView->workorder_id);
        $model->tglpemeliharaan = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tglpemeliharaan)));
        if (!empty($model->tglpemeliharaan_selesai)) {
            $model->tglpemeliharaan_selesai = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tglpemeliharaan_selesai)));
        } else {
            $model->tglpemeliharaan_selesai = '-';
        }
        if ($model->jenisteknisi == 'EKSTERNAL') {
            $teknisi = TeknisiperalatanM::model()->findByPk($model->teknisiperalatan_id);
            if (!empty($teknisi)) {
                $model->teknisiperalatan_nama = $teknisi->namateknisi;
            } else {
                $model->teknisiperalatan_nama = '-';
            }
        } else if ($model->jenisteknisi == 'INTERNAL') {
            $pegawai = PegawaiM::model()->findByPk($model->teknisiint_id);
            if (!empty($pegawai)) {
                $model->teknisiperalatan_nama = $pegawai->nama_pegawai;
            } else {
                $model->teknisiperalatan_nama = '-';
            }
        } else {
            $model->teknisiperalatan_nama = '-';
        }

        $this->render('_detail', array(
            'model' => $model,
            'modelView' => $modelView,
                )
        );
    }

    /**
     * Mengisi tanggal pemeliharaan 
     * @param type $id
     */
    public function actionIsiPemeliharaan($id) {
        $this->layout = '//layouts/iframe';
        $modelView = InfoworkorderV::model()->findByAttributes(array('workorder_id' => $id));
        $model = WorkorderT::model()->findByPk($modelView->workorder_id);
        $model->tglpemeliharaan = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tglpemeliharaan)));
        $model->tglpemeliharaan_selesai = (date("Y-m-d"));
        if (!empty($model->teknisiint_id)){
            $model->jenisteknisi = strtoupper(ParamsConst::JENIS_TEKNISI_INTERNAL);
            $model->pegawai_nama = $model->teknisiint->namaLengkap;            
        }else{
            $model->jenisteknisi = strtoupper(ParamsConst::JENIS_TEKNISI_EKSTERNAL);
            $model->teknisiperalatan_nama = $model->teknisiperalatan->namateknisi;
        }
        if (!empty($model->tglpemeliharaan_selesai)) {
            $model->tglpemeliharaan_selesai = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tglpemeliharaan_selesai)));
        } else {
            $model->tglpemeliharaan_selesai = '-';
        }

        $this->render('_isiPemeliharaan', array(
            'model' => $model,
            'modelView' => $modelView,
                )
        );
    }

    /**
     * Menyimpan progres pemeliharaan 
     */
    public function actionAjaxSimpanPemeliharaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['WorkorderT']['workorder_id'];
            $model = WorkorderT::model()->findByPk($id);
            $modPeralatan = InvperalatanT::model()->findByPk($model->invperalatan_id);

            if (isset($_POST['WorkorderT'])) {
                $model->attributes = $_POST['WorkorderT'];
                if ($_POST['WorkorderT']['jenisteknisi'] == 'EKSTERNAL') {
                    $model->teknisiperalatan_id = $_POST['WorkorderT']['teknisiperalatan_id'];
                } else {
                    $model->teknisiint_id = $_POST['WorkorderT']['teknisiint_id'];
                }
                $model->tglpemeliharaan = MyFormatter::formatDateTimeForDb($_POST['WorkorderT']['tglpemeliharaan']);
                $model->tglpemeliharaan_selesai = MyFormatter::formatDateTimeForDb($_POST['WorkorderT']['tglpemeliharaan_selesai']);
                $model->status_pemeliharaan = ParamsConst::STATUS_WO_FINISH;
                $model->pegfinish_id = Yii::app()->user->getState('pegawai_id');
                $model->wo_finish = date("Y-m-d H:i:s");
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            
                $model->save();
                if ($model->save()) {
                    $modPeralatan->invperalatan_keadaan = $_POST['WorkorderT']['kondisi_barang'];
                    $modPeralatan->save();
                }
            }
            Yii::app()->end();
        }
    }

    /**
     * Auto complete teknisi 
     */
    public function actionAutocompleteTeknisi() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_teknisi = isset($_GET['teknisiperalatan_nama']) ? $_GET['teknisiperalatan_nama'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(namateknisi)', strtolower($nama_teknisi), true);
            $criteria->limit = 5;

            $models = TeknisiperalatanM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namateknisi;
                $returnVal[$i]['value'] = $model->teknisiperalatan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Auto complete pegawai 
     */
    public function actionAutocompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_teknisi = isset($_GET['pegawai_nama']) ? $_GET['pegawai_nama'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_teknisi), true);
            $criteria->limit = 5;

            $models = PegawaiM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    
    /**
     * cetak
     */
    public function actionPrintInfo() {        
        $model = new MAInfoworkorderV('searchInformasi');
        
        if (isset($_GET['MAInfoworkorderV'])) {
            $model->attributes = $_GET['MAInfoworkorderV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MAInfoworkorderV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MAInfoworkorderV']['tgl_akhir']);
        }
        
        $aset = PenanggungjawabasetM::model()->find(" pegawai_id = ".Yii::app()->user->getState('pegawai_id')." AND penanggungjawabaset_aktif = TRUE ");
        if (!empty($aset)){
            $model->is_pj_asset = true;
            $model->pj_pemeliharaan_id = Yii::app()->user->getState('pegawai_id');
        }
        
        $judulLaporan = 'Data Work Order';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render( 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 20, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
        }
    }

}
