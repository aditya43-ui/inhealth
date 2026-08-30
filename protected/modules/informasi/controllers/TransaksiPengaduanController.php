<?php

/**
 * Digunakan sebagai transaksi pengaduan
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.informasi
 * @subpackage controllers
 * 
 */
class TransaksiPengaduanController extends MyAuthController {

    public $path_view = 'informasi.views.transaksiPengaduan.';

    /**
     * fungsi insert data
     * @param integer $kepuasanpasien_id
     */
    public function actionIndex($kepuasanpasien_id = null) {
        $this->pageTitle = Yii::app()->name . " - Pengaduan";
        
        if (!empty($kepuasanpasien_id)) {
            $model = INKepuasanpasienT::model()->findByPk($kepuasanpasien_id);
            $ruangan = RuanganM::model()->findByAttributes(array(
                'ruangan_nama' => $model->kp_namaunit,
            ));
            $pasien = PasienM::model()->findByPk($model->pasien_id);
            
            if (!empty($ruangan)) {
                $model->ruangan_id = $ruangan->ruangan_id;
                $model->instalasi_id = $ruangan->instalasi_id;
            }
            
            if (!empty($pasien)) {
                $model->no_rekam_medik = $pasien->no_rekam_medik;
                $model->nama_pasien = $pasien->nama_pasien;
            }
            
        } else {
            $model = new INKepuasanpasienT();
            $model->kepuasanpasien_tgl = date('Y-m-d');
            $model->kp_tindaklanjut_tgl = date('Y-m-d');
            $model->pasien_id = $model->kepuasanpasien_id;
        }
        

        if (isset($_POST['INKepuasanpasienT'])) {
            $format = new MyFormatter();
            if (isset($_POST['layanansurveiicon']) && count((array) $_POST['layanansurveiicon']) > 0) {
                
                $trans = Yii::app()->db->beginTransaction();
                $ok = true;
                try {
                    
                    foreach ($_POST['layanansurveiicon'] as $dataSurvei) {
                        if ($dataSurvei['kp_sangatpuas'] == '1' || $dataSurvei['kp_puas'] == '1' || $dataSurvei['kp_tidakpuas'] == '1' || $dataSurvei['kp_sangattidakpuas'] == '1') {
                            
                            if (!$model->isNewRecord) {
                                $modelDet = $model;
                            } else {
                                $modelDet = new INKepuasanpasienT();
                            }
                            
                            $modelDet->attributes = $_POST['INKepuasanpasienT'];
                            $modelDet->layanansurvei_id = $dataSurvei['layanansurvei_id'];
                            $modelDet->kepuasanpasien_tgl = $format->formatDateTimeForDb($_POST['INKepuasanpasienT']['kepuasanpasien_tgl']);
                            $modelDet->kp_tindaklanjut_tgl = $format->formatDateTimeForDb($_POST['INKepuasanpasienT']['kp_tindaklanjut_tgl']);
                            
                            $modelDet->kp_platform = $_SERVER['HTTP_USER_AGENT'];
                            $modelDet->kp_iphost = Yii::app()->request->getUserHostAddress();
                            $modelDet->kp_namamodul = 'Informasi';
                            $modelDet->kp_sangatpuas = $dataSurvei['kp_sangatpuas'];
                            $modelDet->kp_puas = $dataSurvei['kp_puas'];
                            $modelDet->kp_tidakpuas = $dataSurvei['kp_tidakpuas'];
                            $modelDet->kp_sangattidakpuas = $dataSurvei['kp_sangattidakpuas'];
                            $modelDet->keterangankepuasan = $dataSurvei['keterangankepuasan'];
                            // $modelDet->kp_deskripsi_aduan = isset($dataSurvei['kp_deskripsi_aduan']) ? $dataSurvei['kp_deskripsi_aduan'] : 'N/A';
                            
                            $ruanganmod = RuanganM::model()->findByPk($_POST['INKepuasanpasienT']['ruangan_id']);
                            $ruangan_nama = (isset($ruanganmod) ? $ruanganmod->ruangan_nama : "");
                            $modelDet->kp_namaunit = $ruangan_nama;
                            if ($modelDet->validate()) {
                                $ok = $ok && $modelDet->save();
                            } else {
                                $ok = false;
                            }
                        }
                    }
                    
                    if ($ok) {
                        $trans->commit();
                        Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                        $this->redirect(array('index', 'sukses' => 1));
                    } else {
                        $trans->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan");
                    }
                } catch (Exception $exc) {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
                }
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
                //'format'=>$format  
        ));
    }

    /**
     * fungsi untuk dropdown
     * @param type $encode
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownLayananSurvei($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modLayanan = new LayanansurveiM();
            if ($model_nama !== '' && $attr == '') {
                $kp_namaunit = $_POST["$model_nama"]['kp_namaunit'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kp_namaunit = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kp_namaunit = $_POST["$model_nama"]["$attr"];
            }
            $layananSurvei = null;
            // var_dump($kp_namaunit);die;
            if ($kp_namaunit) {
                $layananSurvei = $modLayanan->getLayananItems($kp_namaunit);

                $layananSurvei = CHtml::listData($layananSurvei, 'layanansurvei_id', 'layanansurvei_nama');
            }
            if ($encode) {
                echo CJSON::encode($layananSurvei);
            } else {
                if (empty($layananSurvei)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);

                    foreach ($layananSurvei as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * fungsi autocomplete
     */
    public function actionAutocompletePasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
            if (!empty($no_rekam_medik)) {
                $criteria->addCondition("no_rekam_medik = '" . $no_rekam_medik . "'");
            }
            $criteria->addCondition('ispasienluar = FALSE');
            $criteria->limit = 5;
            $models = PasienM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
                $returnVal[$i]['value'] = $model->no_rekam_medik;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * fungsi print
     * @param integer $kepuasanpasien_id
     */
    public function actionPrint($kepuasanpasien_id) {
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter();
        $model = INKepuasanpasienT::model()->findByPk($kepuasanpasien_id);
        $pasien = PasienM::model()->findByPk($model->pasien_id);

        $this->render($this->path_view . 'print', array(
            'model' => $model,
            'pasien' => $pasien,
            'format' => $format,
        ));
    }

    /**
     * fungsi dropdown
     * @param type $encode
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownInstalasiSurvei($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $modLayanan = new LayanansurveiM();
            if ($model_nama !== '' && $attr == '') {
                $kp_namaunit = $_POST["$model_nama"]['layanansurvei_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $kp_namaunit = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $kp_namaunit = $_POST["$model_nama"]["$attr"];
            }
            $layananSurvei = null;
            if ($kp_namaunit) {
                $modnama = LayanansurveiM::model()->findByPk($kp_namaunit);
                $layananSurvei = $modLayanan->getInstalasiItems($modnama->layanansurvei_nama);

                $layananSurvei = CHtml::listData($layananSurvei, 'instalasi_id', 'instalasi_nama');
            }
            if ($encode) {
                echo CJSON::encode($layananSurvei);
            } else {
                if (empty($layananSurvei)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);

                    foreach ($layananSurvei as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    public function actionGetDate() {
        $id = $_POST['id'];
        $tgl = MyFormatter::formatDateTimeForDb($_POST['tgl']);

        $model = KategoriPengaduanM::model()->findByPk($id);
        $days = '+' . $model->estimasipenyelesaian . ' days';

        $kp_tindaklanjut_tgl = date('Y-m-d', strtotime($days, strtotime($tgl)));
        
        $data['kp_tindaklanjut_tgl'] = MyFormatter::formatDateTimeForUser($kp_tindaklanjut_tgl);

        echo json_encode($data);
    }

}
