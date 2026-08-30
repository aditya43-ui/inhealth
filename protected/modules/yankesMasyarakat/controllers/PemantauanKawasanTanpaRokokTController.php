<?php
/**
 * Controller Pemantauan Kawasan Tanpa Rokok
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controller
 */
class PemantauanKawasanTanpaRokokTController extends MyAuthController{
    
    public $path_view = 'yankesMasyarakat.views.pemantauanKawasanTanpaRokokT.';
    
    /**
     * Halaman Index Pemantauan Kawasan Tanpa Rokok
     * @param type $pemantauankawasantanparokok_id
     * @param type $is_edit
     * @param type $is_detail
     */
    public function actionIndex($pemantauankawasantanparokok_id = null, $is_edit = null, $is_detail = null){
        if(!empty($is_edit) || !empty($is_detail)){
            $this->layout = '//layouts/iframe';
        }
        if (empty($pemantauankawasantanparokok_id)) {
            $model = new YKMPemantauankawasantanparokokT();
            $model->tgl_pelaporan = date("d M Y H:i:s");
            $model->tgl_inspeksi = date("d M Y H:i:s");
            $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $model->pelapor_id = $modPegawai->pegawai_id;
            $model->pelapor_nama = $modPegawai->NamaLengkap;
        } else {
            $model = YKMPemantauankawasantanparokokT::model()->findByPk($pemantauankawasantanparokok_id);
            $model->tgl_pelaporan = MyFormatter::formatDateTimeForUser($model->tgl_pelaporan);
            $model->tgl_inspeksi = MyFormatter::formatDateTimeForUser($model->tgl_inspeksi);
            $modPegawai = PegawaiM::model()->findByPk($model->pelapor_id);
            $model->pelapor_id = $modPegawai->pegawai_id;
            $model->pelapor_nama = $modPegawai->NamaLengkap; 
            $model->unitkerja_pemantauan_nama = !empty($model->unitkerja_pemantauan_id) ? $model->unitkerja->namaunitkerja : "";
            $model->mengetahui_pegawai_nama = !empty($model->mengetahui_pegawai_id) ? $model->pegawai_mengetahui->NamaLengkap : null; 
        }
        if (isset($_POST['YKMPemantauankawasantanparokokT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['YKMPemantauankawasantanparokokT'];
                $model->tgl_pelaporan = MyFormatter::formatDateTimeForDb($model->tgl_pelaporan);
                $model->tgl_inspeksi = MyFormatter::formatDateTimeForDb($model->tgl_inspeksi);
                if (empty($pemantauankawasantanparokok_id)) {
                    $model->pelapor_id = $modPegawai->pegawai_id;
                    $model->lokasi_pemantauan = $_POST['YKMPemantauankawasantanparokokT']['lokasi_pemantauan'];
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                } else {
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date ('Y-m-d H:i:s');
                }
                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if(!empty($is_edit)){
                        $this->redirect(array('index', 'pemantauankawasantanparokok_id' => $model->pemantauankawasantanparokok_id, 'is_edit' => 1, 'sukses' => 1));
                    }else{
                        $this->redirect(array('index', 'pemantauankawasantanparokok_id' => $model->pemantauankawasantanparokok_id, 'sukses' => 1));
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