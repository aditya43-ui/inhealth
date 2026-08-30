<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InformasiBukuRegisterHDController extends MyAuthController {

    public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
    
    public function actionIndex() {

        $model = new HDBukuregisterpasien('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $modPasien = new HDPasienM;

        if (isset($_GET['HDBukuregisterpasien'])) {
            $model->attributes = $_GET['HDBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                echo $this->renderPartial('_tableBukuRegister', array('model'=>$model),true);
            }else{
                $this->render('index', array(
                'model' => $model, 'modPasien'=>$modPasien
            ));
        }
    }
    
    public function actionPrintLaporanBukuRegister() {
        $model = new HDBukuregisterpasien('search');
        $judulLaporan = 'Laporan Buku Register Pasien Gawat Darurat';

        //Data Grafik   
        $data['title'] = 'Grafik Laporan Buku Register Pasien Gawat Darurat';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['HDBukuregisterpasien'])) {
            $model->attributes = $_REQUEST['HDBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDBukuregisterpasien']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = '_printBukuRegister';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    
    public function actionFrameGrafikBukuRegister() {
        $this->layout = '//layouts/iframe';
        $model = new HDBukuregisterpasien('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Gawat Darurat';
        $data['type'] = $_GET['type'];
        if (isset($_GET['HDBukuregisterpasien'])) {
            $model->attributes = $_GET['HDBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['HDBukuregisterpasien']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionRiwayatPasien($id) {
		$modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $this->render('riwayatPasien',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
        ));
	}
    
    protected function printFunction($model,$data, $caraPrint, $judulLaporan, $target){ // $modDetail untuk apa?
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
//        echo $caraPrint;
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint ));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
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
            $modPasien = new HDPasienM;
            if ($model_nama !== '' && $attr == '') {
                $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $propinsi_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $propinsi_id = $_POST["$model_nama"]["$attr"];
            }
            $kabupaten = null;
            if ($propinsi_id) {
                $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
                $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
            }
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
     * Mengatur dropdown kecamatan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new HDPasienM;
            if ($model_nama !== '' && $attr == '') {
                $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kabupaten_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kabupaten_id = $_POST["$model_nama"]["$attr"];
            }
            $kecamatan = null;
            if ($kabupaten_id) {
                $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
                $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kecamatan);
            } else {
                if (empty($kecamatan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kecamatan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Mengatur dropdown kelurahan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modPasien = new HDPasienM;
            if ($model_nama !== '' && $attr == '') {
                $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kecamatan_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kecamatan_id = $_POST["$model_nama"]["$attr"];
            }
            $kelurahan = null;
            if ($kecamatan_id) {
                $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
            }

            if ($encode) {
                echo CJSON::encode($kelurahan);
            } else {
                if (empty($kelurahan)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kelurahan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

}
