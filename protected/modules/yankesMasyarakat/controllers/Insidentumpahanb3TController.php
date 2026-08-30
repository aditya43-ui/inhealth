<?php
/**
 * Controller Insiden Tumpahan B3
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controller
 */
class Insidentumpahanb3TController extends MyAuthController{
    
    public $path_view = "yankesMasyarakat.views.insidentumpahanb3T";
    
    /**
     * Halaman Index
     * @param type $insidentumpahanb3_id
     * @param type $is_edit
     * @param type $is_detail
     */
    public function actionIndex($insidentumpahanb3_id = null, $is_edit = null, $is_detail = null){
        if(!empty($is_edit) || !empty($is_detail)){
            $this->layout = '//layouts/iframe';
        }
        if (empty($insidentumpahanb3_id)) {
            $model = new YKMInsidentumpahanb3T();
            $model->tgl_pelaporan = date("d M Y H:i:s"); 
            $model->tgl_kejadian = date("d M Y H:i:s"); 
            $model->no_revisi = '00'; 
            $model->no_dokumen = MyGenerator::noInsidenTumpahanB3(); 
            
        } else {
            $model = YKMInsidentumpahanb3T::model()->findByPk($insidentumpahanb3_id);
            $model->pelapor_nama = $model->pegawai_pelapor->namaLengkap;
            $model->mengetahuipegawai_nama = $model->pegawai_mengetahui->namaLengkap;
            $model->unitkerja_kejadian_nama = $model->unitkerja->namaunitkerja;
            $model->tgl_pelaporan = MyFormatter::formatDateTimeForUser($model->tgl_pelaporan);
            $model->tgl_kejadian = MyFormatter::formatDateTimeForUser($model->tgl_kejadian);
        }
        $modRevisi = new RevisiInsidentumpahanb3R();
        if (isset($_POST['YKMInsidentumpahanb3T'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['YKMInsidentumpahanb3T'];
                $model->tgl_pelaporan = MyFormatter::formatDateTimeForDb($model->tgl_pelaporan);
                $model->tgl_kejadian = MyFormatter::formatDateTimeForDb($model->tgl_kejadian);
                if (empty($insidentumpahanb3_id)) {
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                } else {
                    $model->no_revisi = MyGenerator::noRevisiTumpahanB3($insidentumpahanb3_id); 
                    $model->is_revisi = true;
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date ('Y-m-d H:i:s');
                    $modRevisi = new RevisiInsidentumpahanb3R();
                    $modRevisi->insidentumpahanb3_id = $model->insidentumpahanb3_id;
                    $modRevisi->tgl_pelaporan = $model->tgl_pelaporan;
                    $modRevisi->no_dokumen = $model->no_dokumen;
                    $modRevisi->no_revisi = $model->no_revisi;
                    $modRevisi->mengetahuipegawai_id = $model->mengetahuipegawai_id;
                    $modRevisi->pelapor_id = $model->pelapor_id;
                    $modRevisi->nomorindukpegawai = $model->nomorindukpegawai;
                    $modRevisi->saksi1 = $model->saksi1;
                    $modRevisi->saksi2 = $model->saksi2;
                    $modRevisi->saksi3 = $model->saksi3;
                    $modRevisi->tgl_kejadian = $model->tgl_kejadian;
                    $modRevisi->unitkerja_kejadian_id = $model->unitkerja_kejadian_id;
                    $modRevisi->lokasikejadian = $model->lokasikejadian;
                    $modRevisi->kronologistumpahanb3 = $model->kronologistumpahanb3;
                    $modRevisi->penyebabtumpahanb3 = $model->penyebabtumpahanb3;
                    $modRevisi->kerugiantumpahanb3 = $model->kerugiantumpahanb3;
                    $modRevisi->upayayangdilakukan = $model->upayayangdilakukan;
                    $modRevisi->usulanperbaikan = $model->usulanperbaikan;
                    $modRevisi->tglverifikasi_pelaporan = $model->tglverifikasi_pelaporan;
                    $modRevisi->is_revisi = true;
                    $modRevisi->create_time = date('Y-m-d H:i:s');
                    $modRevisi->update_time = date('Y-m-d H:i:s');
                    $modRevisi->create_loginpemakai_id = Yii::app()->user->id;
                    $modRevisi->update_loginpemakai_id = Yii::app()->user->id;
                    $modRevisi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modRevisi->save();
                }
                $ok = $ok && $model->save();
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if(!empty($is_edit)){
                        $this->redirect(array('index', 'insidentumpahanb3_id' => $model->insidentumpahanb3_id, 'revisi_insidentumpahanb3_id' => $modRevisi->revisi_insidentumpahanb3_id, 'is_edit' => 1, 'sukses' => 1));
                    }else{
                        $this->redirect(array('index', 'insidentumpahanb3_id' => $model->insidentumpahanb3_id, 'sukses' => 1));
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
}

