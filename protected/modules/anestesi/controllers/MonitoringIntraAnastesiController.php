<?php

/**
 * 
 * controller utama transaksi monitoring intra anestesi
 * 
 * @package     application.modules.anestesi
 * @subpackage  controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Andyka Putra <andykaputra@.com>
 * @author      Elham Budianto <elhambudianto@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class MonitoringIntraAnastesiController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.monitoringIntraAnastesi.';
    public $init = '';
    public $simpan_monitoring = true;
    public $simpan_input = true;
    public $simpan_output = true;

    /**
     * Digunakan untuk menambahkan monitoring intraanastesi_id
     * @param type $pasienanastesi_id
     * @param type $monitoringintraanastesi_id
     */
    public function actionIndex($pasienanastesi_id = null, $monitoringintraanastesi_id = null) {


        $model = new ATMonitoringintraanastesiT();
        $modOutput = new ATOutputintraanastesiT();
        $modInput = new ATInputintraanastesiT();
        $modKunjungan = new ATInformasipasienanestesiV;

        $loadInput = array();
        $loadOutput = array();

        $modKunjungan = new ATInformasipasienanestesiV();

        if (!empty($monitoringintraanastesi_id)) {
            $model = ATMonitoringintraanastesiT::model()->findByPk($monitoringintraanastesi_id);

            $input = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $monitoringintraanastesi_id));

            foreach ($input as $dt) {
                $sub = !empty(trim($dt->sub_jenis_input)) ? trim($dt->sub_jenis_input) : '';

                $loadInput[$dt->jenis_input]['jenis'] = $dt->jenis_input;
                $loadInput[$dt->jenis_input]['det'][$sub]['sub_jenis'] = $dt->sub_jenis_input;
                $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['id'] = $dt->inputintraanastesi_id;
                $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['nama_input'] = $dt->nama_input;
                $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['ukuran'] = $dt->ukuran;
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition('pasienanastesi_id = ' . $model->pasienanastesi_id);
            $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);
        }

        if (!empty($pasienanastesi_id)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            $cekKunjungan = ATInformasipasienanestesiV::model()->find($criteria);

            if (!empty($cekKunjungan)) {
                $modKunjungan = $cekKunjungan;
                $model->pendaftaran_id = $modKunjungan->pendaftaran_id;
                $model->pasien_id = $modKunjungan->pasien_id;
                $model->pasienanastesi_id = $modKunjungan->pasienanastesi_id;
            }
        }

        if (isset($_POST['ATMonitoringintraanastesiT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {

                $simpanMonitor = $this->saveMonitoring($model, $_POST['ATMonitoringintraanastesiT']);

                $this->saveOutput($modOutput, $model, $_POST['ATOutputintraanastesiT']);

                $this->saveInput($modInput, $model, $_POST['ATInputintraanastesiT']);

                if ($this->simpan_monitoring && $this->simpan_input && $this->simpan_output) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'monitoringintraanastesi_id' => $simpanMonitor->monitoringintraanastesi_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modOutput' => $modOutput,
            'modInput' => $modInput,
            'modKunjungan' => $modKunjungan,
            'loadInput' => $loadInput,
            'loadOutput' => $loadOutput
        ));
    }

    /**
     * fungsi simpan monitoring
     * @param type $model
     * @param type $post
     * @return type
     */
    public function saveMonitoring($model, $post) {
        $model->attributes = $post;
        $model->pendaftaran_id = $model->pendaftaran_id;
        $model->pasienanastesi_id = $model->pasienanastesi_id;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $this->simpan_monitoring = $this->simpan_monitoring && $model->save();

        return $model;
    }

    /**
     * fungsi simpan output
     * @param ATOutputintraanastesiT $modOutput
     * @param type $model
     * @param type $post
     * @return \ATOutputintraanastesiT
     */
    public function saveOutput($modOutput, $model, $post) {
        foreach ($post['det'] as $det) {
            $modOutput = new ATOutputintraanastesiT();
            $modOutput->attributes = $det;
            $modOutput->pasien_id = $model->pasien_id;
            $modOutput->pendaftaran_id = $model->pendaftaran_id;
            $modOutput->pasienanastesi_id = $model->pasienanastesi_id;
            $modOutput->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
            $modOutput->jam_ke = $post['jam_ke'];
            $modOutput->create_time = date('Y-m-d H:i:s');
            $modOutput->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modOutput->create_ruangan = Yii::app()->user->getState('ruangan_id');

            $this->simpan_output = $this->simpan_output && $modOutput->save();
        }

        return $modOutput;
    }

    /**
     * save input
     * @param type $modInput
     * @param type $model
     * @param type $post
     * @return \ATInputintraanastesiT
     */
    public function saveInput($modInput, $model, $post) {

        foreach ($post['det'] as $det) {
            $modInput = new ATInputintraanastesiT();
            $modInput->attributes = $det;
            $modInput->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
            $modInput->create_time = date('Y-m-d H:i:s');
            $modInput->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modInput->create_ruangan = Yii::app()->user->getState('ruangan_id');

            $this->simpan_input = $this->simpan_input && $modInput->save();

            if (isset($det['det'])) {
                foreach ($det['det'] as $d) {
                    if (!empty($d['sub_jenis_input'])) {
                        $modInput = new ATInputintraanastesiT();
                        $modInput->attributes = $d;
                        $modInput->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
                        $modInput->create_time = date('Y-m-d H:i:s');
                        $modInput->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                        $modInput->create_ruangan = Yii::app()->user->getState('ruangan_id');

                        $this->simpan_input = $this->simpan_input && $modInput->save();
                    }
                }
            }
        }

        return $modInput;
    }

    /**
     * load data kunjungan pasien anestesi
     */
    public function actionGetDataKunjungan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $returnVal['pesan'] = "";
            $criteria = new CDbCriteria();

            $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;

            if (!empty($pasienmasukpenunjang_id)) {
                $criteria->addCondition('pasienmasukpenunjang_id =' . $pasienmasukpenunjang_id);
            }
            if (!empty($pendaftaran_id)) {
                $criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
            }
            if (!empty($pasienanastesi_id)) {
                $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            }

            $model = ATInformasipasienanestesiV::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            $returnVal["tglanastesi"] = $format->formatDateTimeForUser($model->tglanastesi);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * load data pasien anestesi, sesuai yang diketikkan
     */
    public function actionAutocompleteKunjungan() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $noanestesi = isset($_GET['noanestesi']) ? $_GET['noanestesi'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;

            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(noanestesi)', strtolower($noanestesi), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->addCondition("DATE(tglanestesi) = '" . date("Y-m-d") . "'");
            $criteria->limit = 5;

            $models = ATInformasipasienanestesiV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->noanestesi . "-" . $model->no_masukpenunjang . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Digunakan untuk menambahkan data monitoring berdasarkan pasienanastesi_id
     * @author Andyka Putra <andykaputra@.com>
     * @param type $pasienanastesi_id
     * @param type $monitoringintraanastesi_id
     */
    public function actionTambah($pasienanastesi_id, $monitoringintraanastesi_id = null, $frame = null) {

        if (!empty($frame)) {
            $this->layout = '//layouts/iframe';
        }
        $model = new ATMonitoringintraanastesiT();
        $modOutput = new ATOutputintraanastesiT();
        $modInput = new ATInputintraanastesiT();
        $modKunjungan = new ATInformasipasienanestesiV;

        $loadInput = array();
        $loadOutput = array();

        $modKunjungan = new ATInformasipasienanestesiV();

        if (!empty($monitoringintraanastesi_id)) {
            $model = ATMonitoringintraanastesiT::model()->findByPk($monitoringintraanastesi_id);

            $input = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $monitoringintraanastesi_id));

            foreach ($input as $dt) {
                $sub = !empty(trim($dt->sub_jenis_input)) ? trim($dt->sub_jenis_input) : '';

                $loadInput[$dt->jenis_input]['jenis'] = $dt->jenis_input;
                $loadInput[$dt->jenis_input]['det'][$sub]['sub_jenis'] = $dt->sub_jenis_input;
                $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['inputintraanastesi_id'] = $dt->inputintraanastesi_id;
                $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['nama_input'] = $dt->nama_input;
                $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['ukuran'] = $dt->ukuran;
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition('pasienanastesi_id = ' . $model->pasienanastesi_id);
            $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);
        }

        if (isset($_POST['ATMonitoringintraanastesiT'])) {
//            echo '<pre>';
//            var_dump($_POST['ATInputintraanastesiT']);die();
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {

                $simpanMonitor = $this->saveMonitoring($model, $_POST['ATMonitoringintraanastesiT']);

                $this->saveOutput($modOutput, $model, $_POST['ATOutputintraanastesiT']);

                //Input Cairan Obat
                ATInputintraanastesiT::model()->deleteAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'OBAT'));
                if (isset($_POST['ATInputintraanastesiT']['OBAT'])) {
                    foreach ($_POST['ATInputintraanastesiT']['OBAT'] as $i => $item) {
                        if (is_integer($i)) {
                            $modInputObat = new ATInputintraanastesiT;
                            if (isset($_POST['ATInputintraanastesiT']['OBAT'][$i])) {
                                $modInputObat->attributes = $_POST['ATInputintraanastesiT']['OBAT'][$i];
                                $modInputObat->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
                                $modInputObat->create_time = date('Y-m-d H:i:s');
                                $modInputObat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modInputObat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modInputObat->save();
                            }
                        }
                    }
                }

                //Input Cairan Kristaloid
                ATInputintraanastesiT::model()->deleteAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'KRISTALOID'));
                if (isset($_POST['ATInputintraanastesiT']['KRISTALOID'])) {
                    foreach ($_POST['ATInputintraanastesiT']['KRISTALOID'] as $i => $item) {
                        if (is_integer($i)) {
                            $modInputObat = new ATInputintraanastesiT;
                            if (isset($_POST['ATInputintraanastesiT']['KRISTALOID'][$i])) {
                                $modInputObat->attributes = $_POST['ATInputintraanastesiT']['KRISTALOID'][$i];
                                $modInputObat->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
                                $modInputObat->create_time = date('Y-m-d H:i:s');
                                $modInputObat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modInputObat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modInputObat->save();
                            }
                        }
                    }
                }

                //Input Cairan Kolloid
                ATInputintraanastesiT::model()->deleteAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'KOLLOID'));
                if (isset($_POST['ATInputintraanastesiT']['KOLLOID'])) {
                    foreach ($_POST['ATInputintraanastesiT']['KOLLOID'] as $i => $item) {
                        if (is_integer($i)) {
                            $modInputObat = new ATInputintraanastesiT;
                            if (isset($_POST['ATInputintraanastesiT']['KOLLOID'][$i])) {
                                $modInputObat->attributes = $_POST['ATInputintraanastesiT']['KOLLOID'][$i];
                                $modInputObat->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
                                $modInputObat->create_time = date('Y-m-d H:i:s');
                                $modInputObat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modInputObat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modInputObat->save();
                            }
                        }
                    }
                }

                //Input Cairan Lain2
                ATInputintraanastesiT::model()->deleteAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'LAIN_LAIN'));
                if (isset($_POST['ATInputintraanastesiT']['LAIN_LAIN'])) {
                    foreach ($_POST['ATInputintraanastesiT']['LAIN_LAIN'] as $i => $item) {
                        if (is_integer($i)) {
                            $modInputObat = new ATInputintraanastesiT;
                            if (isset($_POST['ATInputintraanastesiT']['LAIN_LAIN'][$i])) {
                                $modInputObat->attributes = $_POST['ATInputintraanastesiT']['LAIN_LAIN'][$i];
                                $modInputObat->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
                                $modInputObat->create_time = date('Y-m-d H:i:s');
                                $modInputObat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modInputObat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modInputObat->save();
                            }
                        }
                    }
                }

                //Input Darah TC
                ATInputintraanastesiT::model()->deleteAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'DARAH'));
                if (isset($_POST['ATInputintraanastesiT']['DARAH'])) {
                    foreach ($_POST['ATInputintraanastesiT']['DARAH'] as $i => $item) {
                        if (is_integer($i)) {
                            $modInputObat = new ATInputintraanastesiT;
                            if (isset($_POST['ATInputintraanastesiT']['DARAH'][$i])) {
                                $modInputObat->attributes = $_POST['ATInputintraanastesiT']['DARAH'][$i];
                                $modInputObat->monitoringintraanastesi_id = $model->monitoringintraanastesi_id;
                                $modInputObat->create_time = date('Y-m-d H:i:s');
                                $modInputObat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                $modInputObat->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modInputObat->save();
                            }
                        }
                    }
                }

                if ($this->simpan_monitoring && $this->simpan_input && $this->simpan_output) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");

                    if (!empty($frame)) {
                        $this->redirect(array('tambah', 'pasienanastesi_id' => $pasienanastesi_id, 'monitoringintraanastesi_id' => $simpanMonitor->monitoringintraanastesi_id, 'frame' => 1, 'sukses' => 1));
                    } else {
                        $this->redirect(array('tambah', 'pasienanastesi_id' => $pasienanastesi_id, 'monitoringintraanastesi_id' => $simpanMonitor->monitoringintraanastesi_id, 'sukses' => 1));
                    }
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'form.tambah_form', array(
            'model' => $model,
            'modOutput' => $modOutput,
            'modInput' => $modInput,
            'modKunjungan' => $modKunjungan,
            'loadInput' => $loadInput,
            'loadOutput' => $loadOutput
        ));
    }

    /**
     * Digunakan untuk melihat detail cairan
     * @author Andyka Putra <andykaputra@.com>
     * @param type $monitoringintraanastesi_id
     */
    public function actionDetailCairan($monitoringintraanastesi_id) {
        $this->layout = '//layouts/iframe';

        $model = ATMonitoringintraanastesiT::model()->findByPk($monitoringintraanastesi_id);

        $input = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $monitoringintraanastesi_id));

        foreach ($input as $dt) {
            $sub = !empty(trim($dt->sub_jenis_input)) ? trim($dt->sub_jenis_input) : '';

            $loadInput[$dt->jenis_input]['jenis'] = $dt->jenis_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['sub_jenis'] = $dt->sub_jenis_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['inputintraanastesi_id'] = $dt->inputintraanastesi_id;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['nama_input'] = $dt->nama_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['ukuran'] = $dt->ukuran;
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('pasienanastesi_id = ' . $model->pasienanastesi_id);
        $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);

        $this->render($this->path_view . 'form.detailCairan', array(
            'model' => $model,
            'modKunjungan' => $modKunjungan,
        ));
    }

    /**
     * Digunakan untuk melihat detail Obat
     * @author Andyka Putra <andykaputra@.com>
     * @param type $monitoringintraanastesi_id
     */
    public function actionDetailObat($monitoringintraanastesi_id) {
        $this->layout = '//layouts/iframe';

        $model = ATMonitoringintraanastesiT::model()->findByPk($monitoringintraanastesi_id);

        $input = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $monitoringintraanastesi_id));

        foreach ($input as $dt) {
            $sub = !empty(trim($dt->sub_jenis_input)) ? trim($dt->sub_jenis_input) : '';

            $loadInput[$dt->jenis_input]['jenis'] = $dt->jenis_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['sub_jenis'] = $dt->sub_jenis_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['inputintraanastesi_id'] = $dt->inputintraanastesi_id;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['nama_input'] = $dt->nama_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['ukuran'] = $dt->ukuran;
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('pasienanastesi_id = ' . $model->pasienanastesi_id);
        $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);

        $this->render($this->path_view . 'form.detailObat', array(
            'model' => $model,
            'modKunjungan' => $modKunjungan,
        ));
    }

    /**
     * Digunakan untuk melihat detail output
     * @author Andyka Putra <andykaputra@.com>
     * @param type $monitoringintraanastesi_id
     */
    public function actionDetailOutput($monitoringintraanastesi_id) {
        $this->layout = '//layouts/iframe';

        $model = ATMonitoringintraanastesiT::model()->findByPk($monitoringintraanastesi_id);

        $input = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $monitoringintraanastesi_id));

        foreach ($input as $dt) {
            $sub = !empty(trim($dt->sub_jenis_input)) ? trim($dt->sub_jenis_input) : '';

            $loadInput[$dt->jenis_input]['jenis'] = $dt->jenis_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['sub_jenis'] = $dt->sub_jenis_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['inputintraanastesi_id'] = $dt->inputintraanastesi_id;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['nama_input'] = $dt->nama_input;
            $loadInput[$dt->jenis_input]['det'][$sub]['det'][$dt->inputintraanastesi_id]['ukuran'] = $dt->ukuran;
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('pasienanastesi_id = ' . $model->pasienanastesi_id);
        $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);

        $this->render($this->path_view . 'form.detailOutput', array(
            'model' => $model,
            'modKunjungan' => $modKunjungan,
        ));
    }

}
