<?php

class KelengkapanDokumenRekamMedisMController extends MyAuthController
{
    function actionIndex() {
        $model = new KelengkapandokumenRmM('searchTable');
        $model->kelengkapandokumen_aktif = true;
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'kelengkapandokumen-m-grid') {
            if(isset($_GET['KelengkapandokumenRmM'])) {
                $model->attributes = $_GET['KelengkapandokumenRmM'];
                
                $this->renderPartial('_table', [
                    'model' => $model
                ]);
                Yii::app()->end();
            }
        }
        $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionView($id)
    {
        $this->render('view', array(
        'model' => $this->loadModel($id),
        ));
    }

    function actionUbahStatus() {
        $data['status'] = 0;
        if(isset($_POST['id']) && isset($_POST['status'])) {
            $model =  $this->loadModel($_POST['id']);
            if(!empty($model)) {
                if($model->kelengkapandokumen_aktif == true) {
                   $model->kelengkapandokumen_aktif = false;
                } else {
                   $model->kelengkapandokumen_aktif = true;
                }
                if($model->save()) {
                    $data['status'] = 1;
                }
            }
        }
        echo json_encode($data);
    }

    

    function actionCreate($id = null) {
        $model = new KelengkapandokumenRmM();

        if(!empty($id)) {
            $model = KelengkapandokumenRmM::model()->findByPk($id);
        }
        // echo '<pre>';var_dump($model);die;

        if(empty($model)) {
            $model = new KelengkapandokumenRmM();
        }

        if(isset($_POST['KelengkapandokumenRmM'])) {
            $model->attributes = $_POST['KelengkapandokumenRmM'];
            $model->tipe = !empty($_POST['KelengkapandokumenRmM']['tipe']) ? $_POST['KelengkapandokumenRmM']['tipe'] : null;
            $model->kelompok_dokumen = !empty($_POST['KelengkapandokumenRmM']['kelompok_dokumen']) ? $_POST['KelengkapandokumenRmM']['kelompok_dokumen'] : null;
            try {
                if($model->validate()) {
                    if($model->save()) {
                        Yii::app()->user->setFlash('success', "Data " . $model->nama_dokumen . " berhasil disimpan");
                        $this->redirect(['index']);
                    } else {
                        Yii::app()->user->setFlash('error', "Data gagal disimpan [save]");
                    }   
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan [validasi]");
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                // echo '<pre>';var_dump($exc);die;
            }

        }

        $this->render('create', [
            'model' => $model
        ]);
    }

    function actionGetKelompokDokumen() {
        $data = [];
        $model = KelengkapandokumenRmM::model()->findAll('level_dokumen = 1 and kelengkapandokumen_aktif = true');
        $option = "<option value=''> --- Pilih --- </option>";
        if(!empty($model) && isset($_GET['level']) && !empty($_GET['level'])) {
            foreach ($model as $mod)
            {                     
                $option .= "<option value='$mod->nama_dokumen'>$mod->nama_dokumen</option>";
            }  
        }
        $data['option'] = $option;

        echo json_encode($data);
    }

    function actionDelete() {
        $data['ok'] = 0;
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            $model = KelengkapandokumenRmM::model()->findByPk($id);
            if($model->delete()) {
                $data['ok'] = 1;
            }
        }

        echo json_encode($data);


    }

    function loadModel($id)
    {
        $model = KelengkapandokumenRmM::model()->findByPk($id);
        if ($model === null)
        throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    function actionPrint() {
        $model = new KelengkapandokumenRmM();
        $model->attributes = $_REQUEST['KelengkapandokumenRmM'];
        $judulLaporan = 'Data Master Kelengkapan Dokumen Rekam Medis';
        $caraPrint = $_REQUEST['caraPrint'];

        if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output();
        }
    }
    
    
}
