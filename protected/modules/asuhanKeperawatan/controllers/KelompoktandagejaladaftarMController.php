<?php

/**
 * Master Kelompok Tanda Gejala
 * 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 */
class KelompoktandagejaladaftarMController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $simpan = true;
    public $path_view = 'asuhanKeperawatan.views.kelompoktandagejaladaftarM.';

    /**
     * Halaman utama master kelompok tanda gejala
     */
    public function actionIndex() {
        $model = new ASKelompoktandagejaladaftarM('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ASKelompoktandagejaladaftarM'])) {
            $model->attributes = $_GET['ASKelompoktandagejaladaftarM'];
            $model->tandagejala_daftar_nama = $_GET['ASKelompoktandagejaladaftarM']['tandagejala_daftar_nama'];
            $model->jenistandagejaladaftar_aktif = $_GET['ASKelompoktandagejaladaftarM']['jenistandagejaladaftar_aktif'];
        }
        $this->render($this->path_view . 'index', array(
            'model' => $model,
        ));
    }

    /**
     * Get data kelompok tanda gejala yang sudah pernah diinputkan
     * @param type $jenistandagejala_id
     */
    public function actionGetData($jenistandagejala_id) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data['form'] = "";

            $modDet = KelompoktandagejaladaftarM::model()->findAllByAttributes(array('jenistandagejala_id' => $jenistandagejala_id), array('order' => 'jenistandagejala_id'));
            if (count($modDet) > 0) {
                foreach ($modDet as $det) {
                    $cekkelompok = KelompoktandagejaladaftarM::model()->findByPk($det->kelompoktandagejaladaftar_id);
                    if (!empty($cekkelompok->tandagejala_daftar_id)) {
                        $cekJenis = TandagejalaDaftarM::model()->findByPk($cekkelompok->tandagejala_daftar_id);
                        if (!empty($cekJenis)) {
                            $det->tandagejala_daftar_nama = $cekJenis->tandagejala_daftar_nama;
                        }
                    }
                    $data['form'] .= $this->renderPartial($this->path_view . '_rowGejala', array('model' => $det), true);
                }
            }

            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Generate tanda gejala 
     */
    public function actionGetGejala() {
        if (Yii::app()->request->isAjaxRequest) {
            $jenistandagejala_id = isset($_POST['jenistandagejala_id']) ? $_POST['jenistandagejala_id'] : null;
            $tandagejala_daftar_id = isset($_POST['tandagejala_daftar_id']) ? $_POST['tandagejala_daftar_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;

            $cri = new CDbCriteria();
            if (is_array($tandagejala_daftar_id)) {
                $cri->addInCondition("t.tandagejala_daftar_id", $tandagejala_daftar_id);
            } else {
                $cri->addCondition("t.tandagejala_daftar_id = '" . $tandagejala_daftar_id . "' ");
            }
            $modGejala = TandagejalaDaftarM::model()->findAll($cri);

            $tr = '';
            foreach ($modGejala as $det) {
                $model = new KelompoktandagejaladaftarM();
                $model->jenistandagejaladaftar_aktif = $status;
                $model->jenistandagejala_id = $jenistandagejala_id;
                $model->tandagejala_daftar_id = $det->tandagejala_daftar_id;
                $model->tandagejala_daftar_nama = $det->tandagejala_daftar_nama;
                $tr .= $this->renderPartial($this->path_view . '_rowGejala', array('model' => $model), true);
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * Halaman tambah master kelompok tanda gejala
     */
    public function actionCreate() {
        $model = new ASKelompoktandagejaladaftarM();
        $modDetail = new ASKelompoktandagejaladaftarM;
        $modDet = new KelompoktandagejaladaftarM;
        if (isset($_POST['KelompoktandagejaladaftarM'])) {
            echo '<pre>';
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                foreach ($_POST['KelompoktandagejaladaftarM'] as $key => $val) {
                    if (!empty($val['kelompoktandagejaladaftar_id'])) {
                        $model = KelompoktandagejaladaftarM::model()->findByPk($val['kelompoktandagejaladaftar_id']);
                        $model->update_time = date('Y-m-d H:i:s');
                        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    } else {
                        $model = new KelompoktandagejaladaftarM;
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    }
                    $model->attributes = $val;
                    $model->jenistandagejala_id = $val['jenistandagejala_id'];
                    $model->tandagejala_daftar_id = $val['tandagejala_daftar_id'];
                    $model->jenistandagejaladaftar_aktif = $val['jenistandagejaladaftar_aktif'];

                    $ok = $ok && $model->save();
                }

                if ($ok) {
                    $transaction->commit();
                    $this->redirect(array('index', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
            }
        }
        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'modDetail' => $modDetail,
            'modDet' => $modDet
        ));
    }

    /**
     * Halaman ubah master kelompok tanda gejala
     * @param type $id
     */
    public function actionUpdate($id) {
        $model = ASKelompoktandagejaladaftarM::model()->findByPk($id);
        $modDet = new KelompoktandagejaladaftarM;
        if (isset($_POST['KelompoktandagejaladaftarM'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try {
                foreach ($_POST['KelompoktandagejaladaftarM'] as $key => $val) {
                    if (!empty($val['kelompoktandagejaladaftar_id'])) {
                        $model = KelompoktandagejaladaftarM::model()->findByPk($val['kelompoktandagejaladaftar_id']);
                        $model->update_time = date('Y-m-d H:i:s');
                        $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    } else {
                        $model = new KelompoktandagejaladaftarM;
                        $model->create_time = date('Y-m-d H:i:s');
                        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    }
                    $model->attributes = $val;
                    $model->jenistandagejala_id = $val['jenistandagejala_id'];
                    $model->tandagejala_daftar_id = $val['tandagejala_daftar_id'];
                    $model->jenistandagejaladaftar_aktif = $val['jenistandagejaladaftar_aktif'];

                    $ok = $ok && $model->save();
                }

                if ($ok) {
                    $transaction->commit();
                    $this->redirect(array('index', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render($this->path_view . 'update', array(
            'model' => $model,
            'modDet' => $modDet
        ));
    }

    /**
     * halaman detail master kelompok tanda gejala
     * @param type $id
     */
    public function actionView($id) {
        $model = KelompoktandagejaladaftarM::model()->findByAttributes(array('kelompoktandagejaladaftar_id' => $id));

        $this->render($this->path_view . 'view', array(
            'model' => $model,
        ));
    }

    /**
     * Fungsi hapus master kelompok tanda gejala
     * @throws CHttpException
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            $id = $_POST['id'];
            KelompoktandagejaladaftarM::model()->deleteByPk($id);
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
                ));
                exit;
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Mengubah status aktif menjadi nonaktif
     * @param type $id 
     */
    public function actionremoveTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = KelompoktandagejaladaftarM::model()->updateByPk($id, array('jenistandagejaladaftar_aktif' => false));
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                    ));
                    exit;
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                ));
                exit;
            }
        }
    }

    /**
     * Mengubah status nonaktif menjadi aktif
     * @param type $id 
     */
    public function actionaddTemporary() {
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
            $update = KelompoktandagejaladaftarM::model()->updateByPk($id, array('jenistandagejaladaftar_aktif' => true));
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                    ));
                    exit;
                }
            }
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                ));
                exit;
            }
        }
    }

    /**
     * Fungsi Print
     */
    public function actionPrint() {
        $model = new ASKelompoktandagejaladaftarM;
        $model->attributes = $_REQUEST['ASKelompoktandagejaladaftarM'];
        $model->tandagejala_daftar_nama = $_REQUEST['ASKelompoktandagejaladaftarM']['tandagejala_daftar_nama'];
        $judulLaporan = 'Data Kelompok Tanda dan Gejala';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

}
