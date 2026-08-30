<?php

/**
 * Digunakan untuk mengakses transaksi identifikasi resiko
 * 
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @package    application.modules.yankesMasyarakat
 * @subpackage controller
 * RSST-5696
 */
class ProgressmonevindentifikasirisikoTController extends MyAuthController {

    /**
     * Default menu transaksi identifikasi resiko
     * @param integer $identifikasiresiko_id
     */
    public function actionIndex($identifikasiresiko_id = null, $progressmonevindentifikasirisiko_id = null) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter;
        $model = new YKMIdentifikasiresikoT();
        if (!empty($identifikasiresiko_id)) {//jika sudah ada data
            $model = YKMIdentifikasiresikoT::model()->findByPk($identifikasiresiko_id);

            if (!empty($model->tingkatrisiko_id)) {
                $namaresiko = TingkatrisikoRiskregisterM::model()->findByPk($model->tingkatrisiko_id);
                if (!empty($namaresiko)) {
                    $model->tingkatrisiko_nama = $namaresiko->tingkatrisiko_nama;
                }
            }
            
            $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
            $model->ruangan_nama = $modRuangan->ruangan_nama;
            if (!empty($model->unitkerja_id)) {
                $modUnit = UnitkerjaM::model()->findByPk($model->unitkerja_id);
                $model->namaunitkerja = $modUnit->namaunitkerja;
            }
            $modEvaluasi = YKMEvaluasiidentifikasirisikoT::model()->findByAttributes(array('identifikasirisiko_id' => $identifikasiresiko_id));
            if (!empty($modEvaluasi)) {
                $modEvaluasi->tgl_mulai = $format->formatDateTimeForUser(date('d-m-Y', strtotime($modEvaluasi->tgl_mulai)));
                $modEvaluasi->tgl_tinjauan = $format->formatDateTimeForUser(date('d-m-Y', strtotime($modEvaluasi->tgl_tinjauan)));
                $modPegawai = PegawaiM::model()->findByPk($modEvaluasi->pegawai_id);
                $modEvaluasi->pegawai_nama = $modPegawai->namaLengkap;
            } else {
                $modEvaluasi = new YKMEvaluasiidentifikasirisikoT();
            }
            $modProgress = YKMProgressmonevindentifikasirisikoT::model()->findByAttributes(array('identifikasiresiko_id' => $identifikasiresiko_id));
            if (empty($modProgress)) {
                $modProgress = new YKMProgressmonevindentifikasirisikoT();
                $modProgress->rpn_sisa = $model->rpn_score;
            }
        }


        if (isset($_POST['YKMProgressmonevindentifikasirisikoT'])) {

            $trans = Yii::app()->db->beginTransaction();
            try {
                $modProgress->attributes = $_POST['YKMProgressmonevindentifikasirisikoT'];
                $modProgress->identifikasiresiko_id = $identifikasiresiko_id;
                $modProgress->evaluasiidentifikasirisiko_id = $modEvaluasi->evaluasiidentifikasirisiko_id;
                if (empty($modProgress->progressmonevindentifikasirisiko_id)) {
                    $modProgress->create_time = date('Y-m-d H:i:s');
                    $modProgress->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modProgress->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $modProgress->update_time = date('Y-m-d H:i:s');
                    $modProgress->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }
                if ($modProgress->save()) {
                    $trans->commit();
                    $this->redirect(array('index', 'sukses' => 1, 'identifikasiresiko_id' => $identifikasiresiko_id, 'progressmonevindentifikasirisiko_id' => $modProgress->progressmonevindentifikasirisiko_id));
                } else {

                    $trans->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
                }
            } catch (Exception $ex) {

                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render('index', array(
            'model' => $model,
            'modEvaluasi' => $modEvaluasi,
            'modProgress' => $modProgress,
        ));
    }

    /**
     * Mendapatkan data peluang dari inputan user
     */
    public function actionGetBobotPeluang() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $model = PeluangM::model()->findByPk($id);
            if (!empty($model)) {
                $data['return'] = $model->peluang_bobotdescriptor;
            } else {
                $data['return'] = 0;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mendapatkan data konsekuensi dari inputan user
     */
    public function actionGetBobotKonsekuensi() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $model = KonsekuensiM::model()->findByPk($id);
            if (!empty($model)) {
                $data['return'] = $model->konsekuensi_bobot;
            } else {
                $data['return'] = 0;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mendapatkan data detectability dari inputan user
     */
    public function actionGetBobotDetectability() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $model = DetectabilityM::model()->findByPk($id);
            if (!empty($model)) {
                $data['return'] = $model->detectability_bobot;
            } else {
                $data['return'] = 0;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mendapatkan data tingkat risiko dara mapping master grading risiko
     */
    public function actionGetTingkatRisiko() {
        if (Yii::app()->request->isAjaxRequest) {
            $konsekuensi_id = $_POST['konsekuensi_id'];
            $peluang_id = $_POST['peluang_id'];
            $detect_id = $_POST['detect_id'];

            $modKons = KonsekuensiM::model()->findByPk($konsekuensi_id);
            $modPel = PeluangM::model()->findByPk($peluang_id);
            $modDetect = DetectabilityM::model()->findByPk($detect_id);

            $k_bobot = !empty($modKons) ? $modKons->konsekuensi_bobot : 0;
            $p_bobot = !empty($modPel) ? $modPel->peluang_bobotdescriptor : 0;

            $skor = $k_bobot * $p_bobot;

            $data['konsekuensi_skor'] = !empty($modKons) ? $modKons->konsekuensi_bobot : 0;
            $data['peluang_skor'] = !empty($modPel) ? $modPel->peluang_bobotdescriptor : 0;
            $data['skor_cl'] = $skor;
            $data['detectability_skor'] = !empty($modDetect) ? $modDetect->detectability_bobot : 0;

            $rpn = $data['skor_cl'] * $data['detectability_skor'];

            $data['rpn_score'] = $rpn;

            $modSum = TingkatrisikoRiskregisterM::model()->find(" (" . $rpn . " >= tingkatrisiko_batasbawah::int  AND " . $rpn . " <= tingkatrisiko_batasatas::int )  AND tingkatrisiko_aktif = TRUE ");

            if (!empty($modSum)) {
                $data['tingkatresiko_id'] = $modSum->tingkatrisiko_riskregister_id;
                $data['tingkatrisiko_nama'] = $modSum->tingkatrisiko_nama;
                $data['target_rpn'] = $modSum->tingkatrisiko_batasatas;
            } else {
                $data['tingkatresiko_id'] = null;
                if (!empty($modDetect)) {
                    $data['tingkatrisiko_nama'] = 'Master risk risiko belum di set';
                } else {
                    $data['tingkatrisiko_nama'] = '';
                }
                $data['target_rpn'] = 0;
            }


            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mendapatkan data subtiperesiko
     */
    public function actionGetSubTipeRisiko() {
        if (Yii::app()->request->isAjaxRequest) {
            $tiperesiko_id = $_POST['tiperesiko_id'];
            $model = SubtiperesikoM::model()->findByAttributes(array('tiperesiko_id' => $tiperesiko_id));
            if (!empty($model)) {
                $data['subtiperesiko_id'] = $model->subtiperesiko_id;
            } else {
                $data['subtiperesiko_id'] = "";
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Meload dropodown data dari konsekuensi
     * @param type $encode
     * @param type $namaModel
     */
    public function actionGetKonsekuensi($encode = false, $namaModel = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $domain = $_POST['RiskregisterM']['domain_id'];
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(konsekuensi_domain)', strtolower($domain), true);
            $criteria->addCondition('konsekuensi_aktif = true');
            $konsekuensi = KonsekuensiM::model()->findAll($criteria);

            $namabobot = CHtml::listData($konsekuensi, 'konsekuensi_id', 'konsekuensi_namabobot');

            if (empty($namabobot)) {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
                if (count($namabobot) >= 1) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } elseif (count($namabobot) == 0) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                }

                foreach ($namabobot as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Ruangan
     */
    public function actionAutocompleteRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->select = "t.*";
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($_GET['term']), true);
            $criteria->addCondition("t.ruangan_aktif is true");
            $criteria->order = 't.ruangan_nama ASC';
            $criteria->limit = 10;
            $models = RuanganM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ruangan_nama;
                $returnVal[$i]['value'] = $model->ruangan_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete Unit Kerja
     * Filter berdasarkan ruangan 
     */
    public function actionAutocompleteUnitKerjaRuangan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();

            $criteria = new CDbCriteria();
            $criteria->select = "t.*, unitkerja_m.*";
            $criteria->join = "join unitkerja_m on t.unitkerja_id = unitkerja_m.unitkerja_id "
                    . "join ruangan_m on t.ruangan_id = ruangan_m.ruangan_id ";
            $criteria->compare('LOWER(unitkerja_m.namaunitkerja)', strtolower($_GET['term']), true);
            $criteria->addCondition("unitkerja_m.unitkerja_aktif is true");
            if (empty($_GET['ruangan_id'])) {
                $criteria->addCondition('t.ruangan_id is null');
            } else {
                $criteria->addCondition('t.ruangan_id = ' . $_GET['ruangan_id']);
            }
            $criteria->order = 'unitkerja_m.namaunitkerja ASC';
            $criteria->limit = 10;
            $models = UnitkerjaruanganM::model()->findAll($criteria);
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
