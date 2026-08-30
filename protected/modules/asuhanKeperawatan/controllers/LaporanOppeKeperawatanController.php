<?php
/**
 * Controller untuk Laporan OPPE
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controllers
 */
class LaporanOppeKeperawatanController extends MyAuthController {

    /**
     * Halaman index
     */
    public function actionIndex() {
        $model = new ASLaporanoppekeperawatanV('searchLaporan');
        $model->tgl_awal = MyFormatter::formatMonthForUser(date('Y-m-d'));
        $model->tgl_akhir = MyFormatter::formatMonthForUser(date('Y-m-d'));
        $modKepalaUnit = UnitkerjaM::model()->findByAttributes(array('unitkerja_id' => Params::UNITKERJA_ID_SEKSI_PENGEMBANGAN_MUTU_KEPERAWATAN));
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $modUnit = UnitkerjaM::model()->findByPk($modPegawai->unitkerja_id);
        if (!empty($modKepalaUnit) && $modKepalaUnit->kepalaunitpeg_id == Yii::app()->user->getState('pegawai_id')) {
            $model->jenis = 'Semua';
        } else {
            $model->jenis = 'Unit';
            $model->pegawai_id = !empty($modUnit->unitkerja_id) ? $modUnit->unitkerja_id : null;
            $model->nama_perawat = !empty($modUnit->namaunitkerja) ? $modUnit->namaunitkerja : null;
        }

        if (!empty($_GET['ASLaporanoppekeperawatanV'])) {
            $model->attributes = $_GET['ASLaporanoppekeperawatanV'];
            $model->jenis = $_GET['ASLaporanoppekeperawatanV']['jenis'];
            $model->tgl_awal = $_GET['ASLaporanoppekeperawatanV']['tgl_awal'];
            $model->tgl_akhir = $_GET['ASLaporanoppekeperawatanV']['tgl_akhir'];
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * Digunakan untuk cetak laporan
     */
    public function actionPrint() {
        $model = new ASLaporanoppekeperawatanV('searchLaporan');

        $format = new MyFormatter();
        $judulLaporan = 'Laporan OPPE Keperawatan';
        $data['title'] = 'Grafik Laporan OPPE Keperawatan';
        $data['type'] = $_REQUEST['type'];
        if (!empty($_GET['ASLaporanoppekeperawatanV'])) {
            $model->attributes = $_GET['ASLaporanoppekeperawatanV'];
            $model->jenis = $_GET['ASLaporanoppekeperawatanV']['jenis'];
            $model->tgl_awal = $_GET['ASLaporanoppekeperawatanV']['tgl_awal'];
            $model->tgl_akhir =$_GET['ASLaporanoppekeperawatanV']['tgl_akhir'];
        }
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'Print';

        $this->printFunction($model, $caraPrint, $judulLaporan, $target, $data);
    }

    /**
     * Fungsi untuk mencetak laporan
     * @param type $model
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $data
     */
    protected function printFunction($model, $caraPrint, $judulLaporan, $target, $data) {
        $format = new MyFormatter();
        $tgl_awal = date('Y-m-01', strtotime(MyFormatter::formatMonthForDb($model->tgl_awal)));
        $tgl_akhir = date('Y-m-t', strtotime(MyFormatter::formatMonthForDb($model->tgl_akhir)));
        $awal = MyFormatter::getMonthId(date('m', strtotime($tgl_awal))).' '.date('Y', strtotime($tgl_awal));
        $akhir = MyFormatter::getMonthId(date('m', strtotime($tgl_akhir))).' '.date('Y', strtotime($tgl_akhir));
        $periode = $awal . ' s/d ' . $akhir;

        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'data' => $data, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF60('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 55, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

    /**
     * Grafik OPPE
     */
    public function actionFrameGrafikOppe() {
        $this->layout = '//layouts/iframe';
        $model = new ASLaporanoppekeperawatanV('searchGrafik');

        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date("d M Y");

        //Data Grafik
        $data['title'] = 'Grafik Laporan OPPE Keperawatan';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_GET['ASLaporanoppekeperawatanV'])) {
            $model->attributes = $_GET['ASLaporanoppekeperawatanV'];
            $model->jenis = $_GET['ASLaporanoppekeperawatanV']['jenis'];
            $model->tgl_awal =$_GET['ASLaporanoppekeperawatanV']['tgl_awal'];
            $model->tgl_akhir = $_GET['ASLaporanoppekeperawatanV']['tgl_akhir'];
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    /**
     * Autocomplete pegawai 
     */
    public function actionGetPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $kelompokpegawai = [Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN];
            $criteria->addInCondition('t.kelompokpegawai_id', $kelompokpegawai);
            $criteria->addCondition('pegawai_aktif IS TRUE');
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
     * Autocomplete Unit Kerja
     * @author Andyka Putra <andykaputra@.com>
     */
    public function actionAutocompleteUnitKerja() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(namaunitkerja)', strtolower($_GET['term']), true);
            $criteria->addCondition("unitkerja_aktif IS TRUE");
            $criteria->order = 'namaunitkerja';
            $criteria->limit = 10;
            $models = UnitkerjaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaunitkerja;
                $returnVal[$i]['value'] = $model->unitkerja_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
