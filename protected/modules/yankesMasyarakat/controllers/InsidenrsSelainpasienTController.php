<?php
/**
 * Controller Insiden Selain Pasien
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controller
 */
class InsidenrsSelainpasienTController extends MyAuthController{
    
    public $path_view = 'yankesMasyarakat.views.insidenrsSelainpasienT.';
    
    /**
     * Halaman Index Insiden RS Selain Pasien
     * @param type $insidenrs_selainpasien_id
     * @param type $is_edit
     * @param type $is_detail
     */
    public function actionIndex($insidenrs_selainpasien_id = null, $is_edit = null, $is_detail = null){
        if(!empty($is_edit) || !empty($is_detail)){
            $this->layout = '//layouts/iframe';
        }
        if (empty($insidenrs_selainpasien_id)) {
            $model = new YKMInsidenrsSelainpasienT();
            $model->tgl_pelaporan = date("d M Y H:i:s");
            $model->tgl_kejadian = date("d M Y H:i:s");
            $model->no_kejadian = MyGenerator::noInsidenSelainPasien();
            $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $model->pelapor_id = $modPegawai->pegawai_id;
            $model->pelapor_nama = $modPegawai->namaLengkap; 
            $model->pegawai_mengetahui1_id = $modPegawai->pegawai_id;
            $model->pegawai_mengetahui1_nama = $modPegawai->namaLengkap; 
            $modUnit = UnitkerjaM::model()->findByAttributes(array('namaunitkerja' => 'KOMITE KESEHATAN DAN KESELAMATAN KERJA RUMAH SAKIT'));
            if (!empty($modUnit->kepalaunitpeg_id)) {
                $modPegawaiK3 = PegawaiM::model()->findByPk($modUnit->kepalaunitpeg_id);
                $model->pegawai_mengetahui2_id = $modPegawaiK3->pegawai_id;
                $model->pegawai_mengetahui2_nama = $modPegawaiK3->namaLengkap;
            }
        } else {
            $model = YKMInsidenrsSelainpasienT::model()->findByPk($insidenrs_selainpasien_id);
            $model->tgl_pelaporan = MyFormatter::formatDateTimeForUser($model->tgl_pelaporan);
            $model->tgl_kejadian = MyFormatter::formatDateTimeForUser($model->tgl_kejadian);
            $modPegawai = PegawaiM::model()->findByPk($model->pelapor_id);
            $model->pelapor_id = $modPegawai->pegawai_id;
            $model->pelapor_nama = $modPegawai->namaLengkap; 
            $model->pegawai_mengetahui1_nama = $model->pegawai_mengetahui1->namaLengkap;
            $model->pegawai_mengetahui2_nama = $model->pegawai_mengetahui2->namaLengkap;
            $model->unitkerja_pelapor_nama = $model->unitkerja->namaunitkerja;
            $model->pegawai_mengetahuikejadian_nama = !empty($model->pegawai_mengetahuikejadian_id) ? $model->pegawai_mengetahuikejadian->namaLengkap : null; 
        }
        if (isset($_POST['YKMInsidenrsSelainpasienT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['YKMInsidenrsSelainpasienT']; 
                $model->pelapor_id = $modPegawai->pegawai_id;
                $model->tgl_pelaporan = MyFormatter::formatDateTimeForDb($model->tgl_pelaporan);
                $model->tgl_kejadian = MyFormatter::formatDateTimeForDb($model->tgl_kejadian);
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->create_time = date ('Y-m-d H:i:s');
                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if(!empty($is_edit)){
                        $this->redirect(array('index', 'insidenrs_selainpasien_id' => $model->insidenrs_selainpasien_id, 'is_edit' => 1, 'sukses' => 1));
                    }else{
                        $this->redirect(array('index', 'insidenrs_selainpasien_id' => $model->insidenrs_selainpasien_id, 'sukses' => 1));
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }
        // var_dump($model);die;
        $this->render('index', array('model' => $model));
    }
    
    /**
     * Load data autocomplete unit kerja
     */
    public function actionAutocompleteUnitKerja() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            $criteria->compare('LOWER(namaunitkerja)', strtolower($_GET['term']), true);

            $criteria->order = 'namaunitkerja';
            $criteria->limit = 5;
            $models = UnitkerjaM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['unitkerjapenyebab_nama'] = $model->namaunitkerja;
                $returnVal[$i]['unitkerjapenyebab_id'] = $model->unitkerja_id;
                $returnVal[$i]['value'] = $model->unitkerja_id;
                $returnVal[$i]['label'] = $model->namaunitkerja;
                
                if(!empty($model->kepalaunitpeg_id)){
                    $modPegawai = PegawaiM::model()->findByPk($model->kepalaunitpeg_id);
                    $returnVal[$i]['pegawai_id'] = $modPegawai->pegawai_id;
                    $returnVal[$i]['nama_pegawai'] = $modPegawai->namaLengkap;
                }else{
                    $returnVal[$i]['pegawai_id'] = null;
                    $returnVal[$i]['nama_pegawai'] = null;
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete pegawai
     */
    public function actionGetPegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $returnVal = array(); 
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition(" pegawai_aktif = TRUE ");
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawaiV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete pelapor 
     */
    public function actionGetPegawaiPelapor() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $returnVal = array(); 
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition(" pegawai_aktif = TRUE ");
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawaiV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Autocomplete ketua tim K3
     */
    public function actionGetPegawaiK3() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $returnVal = array(); 
            if (!isset($_GET['term'])) {
                $_GET['term'] = null;
            }

            if (isset($_GET['pegawai_id'])) {
                if (!empty($_GET['pegawai_id'])) {
                    $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
                }
            }

            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition(" pegawai_aktif = TRUE ");
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $models = PegawaiV::model()->findAll($criteria);

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
                $returnVal[$i]['nama_pegawai'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}