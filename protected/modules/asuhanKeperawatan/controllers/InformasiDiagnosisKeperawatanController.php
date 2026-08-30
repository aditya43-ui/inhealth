<?php

/**
 * Informasi Diagnosis Keperawatan
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class InformasiDiagnosisKeperawatanController extends MyAuthController {

    public $path_view = 'asuhanKeperawatan.views.informasiDiagnosisKeperawatan.';

    /**
     * Fungsi untuk mengakses halaman utama informasi diagnosis
     */
    public function actionIndex() {
        $format = new MyFormatter();
        $model = new ASDiagnosisaskepT('search');
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");

        if (isset($_GET['ASDiagnosisaskepT'])) {
            $model->attributes = $_GET['ASDiagnosisaskepT'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ASDiagnosisaskepT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ASDiagnosisaskepT']['tgl_akhir']);
            $model->ruangan_id = $_GET['ASDiagnosisaskepT']['ruangan_id'];
            $model->nama_pegawai = $_GET['ASDiagnosisaskepT']['nama_pegawai'];
            $model->no_diagnosisaskep = $_GET['ASDiagnosisaskepT']['no_diagnosisaskep'];
        }

        $this->render($this->path_view . 'index', array(
            'format' => $format,
            'model' => $model
        ));
    }

    /**
     * Fungsi untuk melihat detail diagnosis
     * @param type $diagnosisaskep_id
     */
    public function actionDetail($diagnosisaskep_id = null) {
        $this->layout = "//layouts/iframe";

        $model = ASDiagnosisaskepT::model()->findByAttributes(array('diagnosisaskep_id' => $diagnosisaskep_id));
        $modDetail = ASDiagnosisaskepdetT::model()->findAllByAttributes(array('diagnosisaskep_id' => $diagnosisaskep_id));
        $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
        $model->pegawai_id = !empty($cekPegawai->pegawai_id) ? $cekPegawai->pegawai_id : '';
        $model->nama_pegawai = !empty($cekPegawai->nama_pegawai) ? $cekPegawai->nama_pegawai : '';
        $model->attributes = $model;

        $modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);

        if ($modPengkajian->iskeperawatan == 1) {
            $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        } else {
            $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        }

        $this->render($this->path_view . 'detailDiagnosis', array(
            'model' => $model,
            'modPasien' => $modPasien,
            'modPengkajian' => $modPengkajian,
            'modDetail' => $modDetail
        ));
    }

    /**
     * Fungsi untuk cetak detail diagnosis
     */
    public function actionPrintDetail() {
        $model = ASDiagnosisaskepT::model()->findByAttributes(array('diagnosisaskep_id' => $_REQUEST['diagnosisaskep_id']));
        $model->attributes = $model;
        $modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);

        if ($modPengkajian->iskeperawatan == 1) {
            $modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        } else {
            $modPasien = ASInfopengkajiankebidananV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
        }

        $modDetail = new ASDiagnosisaskepdetT;
        $judulLaporan = 'Diagnosis Keperawatan';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/printoutrsiaks-normal.css');
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage('L', '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if ($model_nama !== '' && $attr == '') {
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            } else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            } else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(ASRuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

            if ($encode) {
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                if (count($models) > 0) {
                    foreach ($models as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    public function actionHapusData(){
        if(Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $trans = Yii::app()->db->beginTransaction();
            try{
                $cri_del = new CDbCriteria();
                $cri_del->join = " JOIN diagnosisaskepdet_t det ON det.diagnosisaskepdet_id = t.diagnosisaskepdet_id ";
                $cri_del->addCondition(" det.diagnosisaskep_id = ".$id." ");
                $del_pilih = ASPilihdiagnosisaskepT::model()->findAll($cri_del);
                
                if (!empty($del_pilih)){
                    foreach($del_pilih as $del){
                        $del->delete();
                    }
                }

                $cri_del = new CDbCriteria();
                $cri_del->addCondition(" diagnosisaskep_id = ".$id." ");
                $del_det = ASDiagnosisaskepdetT::model()->deleteAll($cri_del);

                $del_diag = ASDiagnosisaskepT::model()->deleteByPk($id);
                
                $trans->commit();
                $data['sukses'] = 1;
                
            }catch(Exception $e){                
                $trans->rollback();
                $data['sukses'] = 0;
            }
            
            
            
            echo json_encode($data);
        }
        Yii::app()->end();
    }

}
