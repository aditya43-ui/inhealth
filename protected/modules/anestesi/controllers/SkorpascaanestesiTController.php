<?php

/**
 * Fungsi Pasca Anestesi untuk tabulasi pada Skor
 * @author Elham Budianto <elhambudianto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class SkorpascaanestesiTController extends MyAuthController {

    public $path_view = 'anestesi.views.skorpascaanestesiT.';
    public $layout = '//layouts/iframe';

    /**
     * Load form index dan menyimpan data rencana anestesi
     * @param type $pasienanastesi_id
     */
    public function actionIndex($pasienanastesi_id = null) {
        $model = new SkorpascaanastesiT;
        $model->waktu = MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s"));
        $modAldrette = new SkoraldretteT();
        $modEvaluasiNyeri = new EvaluasinyeriT();
        $modBromage = new SkorbromageT();
        $modGambarTubuh = new ATGambartubuhM();

        $criteria = new CDbCriteria();
        $criteria->addCondition("lookup_type = 'skor aldrette'");
        $criteria->addCondition("lookup_aktif = true");
        $nilaiAldrette = LookupM::model()->findAll($criteria);

        $criteria2 = new CDbCriteria();
        $criteria2->addCondition("lookup_type = 'evaluasi nyeri'");
        $criteria2->addCondition("lookup_aktif = true");
        $nilaiEvaluasiNyeri = LookupM::model()->findAll($criteria2);

        $criteria3 = new CDbCriteria();
        $criteria3->addCondition("lookup_type = 'skor bromage'");
        $criteria3->addCondition("lookup_aktif = true");
        $nilaiBromage = LookupM::model()->findAll($criteria3);

        $modAnestesi = InformasipasienanestesiV::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
        //$model->tglrencanaanestesi = date('d M Y H:i:s');

        $cekdata = SkorpascaanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
        if (!empty($cekdata)) {
            $model = SkorpascaanastesiT::model()->findByPk($cekdata->skorpascaanastesi_id);
            $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
            $model->pegawai_nama = !empty($cekPegawai->nama_pegawai) ? $cekPegawai->nama_pegawai : '';

            $modBromage = SkorbromageT::model()->findByAttributes(array('skorpascaanastesi_id' => $cekdata->skorpascaanastesi_id));
            $modEvaluasiNyeri = EvaluasinyeriT::model()->findByAttributes(array('skorpascaanastesi_id' => $cekdata->skorpascaanastesi_id));
            $modAldrette = SkoraldretteT::model()->findByAttributes(array('skorpascaanastesi_id' => $cekdata->skorpascaanastesi_id));
        }

        if (isset($_POST['SkorpascaanastesiT'])) {
            try {
                $model->attributes = $_POST['SkorpascaanastesiT'];
                $model->pegawai_id = $_POST['SkorpascaanastesiT']['pegawai_id'];
                $model->waktu = MyFormatter::formatDateTimeForDb($model->waktu);
                $model->pasien_id = $modAnestesi->pasien_id;
                $model->pendaftaran_id = $modAnestesi->pendaftaran_id;
                if (!empty($cekdata)) {
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_pengguna_id = Yii::app()->user->getState('loginpemakai_id');
                } else {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_pengguna_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }
                $model->pasienanastesi_id = $pasienanastesi_id;
                if ($model->save()) {
                    if (isset($_POST['SkoraldretteT'])) {
                        $modAldrette->attributes = $_POST['SkoraldretteT'];
                        $modAldrette->aldrette_sirkulasi_jam = !empty($_POST['SkoraldretteT']['aldrette_sirkulasi_jam']) ? $_POST['SkoraldretteT']['aldrette_sirkulasi_jam'] : null;
                        $modAldrette->aldrette_kesadaran_jam = !empty($_POST['SkoraldretteT']['aldrette_kesadaran_jam']) ? $_POST['SkoraldretteT']['aldrette_kesadaran_jam'] : null;
                        $modAldrette->aldrette_oksigensi_jam = !empty($_POST['SkoraldretteT']['aldrette_oksigensi_jam']) ? $_POST['SkoraldretteT']['aldrette_oksigensi_jam'] : null;
                        $modAldrette->aldrette_pernafasan_jam = !empty($_POST['SkoraldretteT']['aldrette_pernafasan_jam']) ? $_POST['SkoraldretteT']['aldrette_pernafasan_jam'] : null;
                        $modAldrette->aldrette_aktifitas_jam = !empty($_POST['SkoraldretteT']['aldrette_aktifitas_jam']) ? $_POST['SkoraldretteT']['aldrette_aktifitas_jam'] : null;
                        $modAldrette->skorpascaanastesi_id = $model->skorpascaanastesi_id;
                        if (!empty($cekdata)) {
                            $modAldrette->update_time = date('Y-m-d H:i:s');
                            $modAldrette->update_pengguna_id = Yii::app()->user->getState('loginpemakai_id');
                        } else {
                            $modAldrette->create_time = date('Y-m-d H:i:s');
                            $modAldrette->create_pengguna_id = Yii::app()->user->getState('loginpemakai_id');
                            $modAldrette->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        }
                    }

                    if (isset($_POST['EvaluasinyeriT'])) {
                        $modEvaluasiNyeri->attributes = $_POST['EvaluasinyeriT'];
                        $modEvaluasiNyeri->nyeri_jam = !empty($_POST['EvaluasinyeriT']['nyeri_jam']) ? $_POST['EvaluasinyeriT']['nyeri_jam'] : null;
                        if (!empty($_POST['EvaluasinyeriT']['keluhan_nyeri'])) {
                            if ($_POST['EvaluasinyeriT']['keluhan_nyeri'] == 1) {
                                $modEvaluasiNyeri->keluhan_nyeri_ada = true;
                                $modEvaluasiNyeri->keluhan_nyeri_tidak_ada = false;
                            } else {
                                $modEvaluasiNyeri->keluhan_nyeri_ada = false;
                                $modEvaluasiNyeri->keluhan_nyeri_tidak_ada = true;
                            }
                        }
                        $modEvaluasiNyeri->skorpascaanastesi_id = $model->skorpascaanastesi_id;
                    }

                    if (isset($_POST['SkorbromageT'])) {
                        $modBromage->attributes = $_POST['SkorbromageT'];
                        $modBromage->jam = !empty($_POST['SkorbromageT']['jam']) ? $_POST['SkorbromageT']['jam'] : null;
                        $modBromage->skorpascaanastesi_id = $model->skorpascaanastesi_id;
                    }
                }
                if ($model->save() && $modAldrette->save() && $modEvaluasiNyeri->save() && $modBromage->save()) {
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $sukses = 1;
                    $this->redirect(array('index', 'pasienanastesi_id' => $model->pasienanastesi_id, 'sukses' => $sukses));
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "Data gagal disimpan !" . MyExceptionMessage::getMessage($ex, true));
            }
        }
        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modAldrette' => $modAldrette,
            'modEvaluasiNyeri' => $modEvaluasiNyeri,
            'modBromage' => $modBromage,
            'nilaiAldrette' => $nilaiAldrette,
            'nilaiEvaluasiNyeri' => $nilaiEvaluasiNyeri,
            'nilaiBromage' => $nilaiBromage,
            'modGambarTubuh' => $modGambarTubuh
        ));
    }

    /**
     * Autocomplete pegawai
     */
    public function actionAutocompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            
            $r = PegawairuanganV::model()->findAll("ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");

            $id = array();
            foreach ($r as $v) {
                $id[] = $v->pegawai_id;
            }

            $criteria->addInCondition("t.pegawai_id", $id);
            
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawaiM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
