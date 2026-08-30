<?php
/**
 * Controller untuk jadwal hemodialisa
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.hemodialisa
 * @category controllers
 */
class InfoJadwalController extends MyAuthController {

    public $layout = '//layouts/column1';

    /**
     * Load halaman informasi 
     */
    function actionIndex() {
        $model = new JadwalhemodialisaV();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if (isset($_REQUEST['JadwalhemodialisaV'])) {
            $model->attributes = $_REQUEST['JadwalhemodialisaV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_REQUEST['JadwalhemodialisaV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_REQUEST['JadwalhemodialisaV']['tgl_akhir']);
        }

        $dataProvider = $model->searchInfoJadwal();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Update jadwal
     * @param type $jadwalhemodialisa_id
     */
    function actionUpdate($jadwalhemodialisa_id = null) {
        $this->layout = '//layouts/iframe';
        if (!empty($jadwalhemodialisa_id)) {
            $model = JadwalhemodialisaT::model()->findByPk($jadwalhemodialisa_id);
            $model->pasien_nama = $model->pasienrl->nama_pasien;
            $model->no_rekam_medik = $model->pasienrl->no_rekam_medik;
            $model->jadwalhemodialisa_tgl_ke = MyFormatter::formatDateTimeForUser($model->jadwalhemodialisa_tgl_ke);
        }

        if (isset($_POST['JadwalhemodialisaT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = JadwalhemodialisaT::model()->findByPk($jadwalhemodialisa_id);
                $model->attributes = $_POST['JadwalhemodialisaT'];
                $model->jadwalhemodialisa_tgl_ke = MyFormatter::formatDateTimeForDb($_POST['JadwalhemodialisaT']['jadwalhemodialisa_tgl_ke']);

                if ($model->update()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('update', 'jadwalhemodialisa_id' => $jadwalhemodialisa_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    /**
     * Batal Jadwal 
     */
    function actionBatalJadwal() {
        if (Yii::app()->request->isAjaxRequest) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            $id = $_POST['id'];
            try {
                $cek = MonitoringPostHdT::model()->findAll("jadwalhemodialisa_id = " . $id);
                if (!empty($cek)) {
                    foreach ($cek as $value) {
                        $modMonitoringpost = MonitoringPostHdT::model()->findByPk($value->monitoring_post_hd_id);
                        $modMonitoringpost->jadwalhemodialisa_id = null;

                        $ok = $ok && $modMonitoringpost->update();
                    }
                }
                $ok = $ok && JadwalhemodialisaT::model()->deleteByPk($id);
                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data Berhasil dihapus!';
                    $trans->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data Gagal dihapus!';
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = 'Data Gagal dihapus!';
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Cetak laporan 
     */
    public function actionPrint() {
        $model = new JadwalhemodialisaV('searchLaporan');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $judulLaporan = 'Laporan Shift Hemodialisa';
        if (isset($_REQUEST['JadwalhemodialisaV'])) {
            $model->attributes = $_REQUEST['JadwalhemodialisaV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_REQUEST['JadwalhemodialisaV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_REQUEST['JadwalhemodialisaV']['tgl_akhir']);
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = 'Print';

        $tabel = $model->generateLaporan();
        $kertas = Params::getUkuranKertas();
        $ukuranKertasPDF = $kertas['F4'];
        $posisi = 'L';
        $mpdf = new MyPDF('', $ukuranKertasPDF, 0, '', 15, 15, 16, 16, 9, 9, 'L');
        $footer = '
        <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
        <td width="50%"></td>
        <td width="50%" align="right">{PAGENO}/{nb}</td>
        </tr></table>
        ';
        $mpdf->SetHTMLFooter($footer);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 5);
        $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'tabel' => $tabel, 'caraPrint' => $caraPrint), true));

        $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }

}
