<?php
/**
 * Controller Insiden Kebakaran
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage controllers
 * @category controller
 */
class InsidenKebakaranTController extends MyAuthController{
    
    public $path_view = "yankesMasyarakat.views.insidenKebakaranT";
    
    /**
     * Halaman Index
     * @param type integergit  $insidenkebakaran_id
     */
    public function actionIndex($insidenkebakaran_id = null){
        if (!empty($_GET['frame'])) {
            $this->layout = '//layouts/iframe';
        }
        if (empty($insidenkebakaran_id)) {
            $model = new YKMInsidenkebakaranT();
            $model->tgl_pelaporan = date("d M Y H:i:s"); 
            $model->tgl_kejadian = date("d M Y H:i:s"); 
            $model->no_revisi = '00'; 
            $model->no_dokumen = MyGenerator::noInsidenKebakaran();
        } else {
            $model = YKMInsidenkebakaranT::model()->findByPk($insidenkebakaran_id);
            $model->pelapor_nama = $model->pegawai_pelapor->namaLengkap;
            $model->mengetahuipegawai_nama = $model->pegawai_mengetahui->namaLengkap;
            $model->unitkerja_kejadian_nama = !empty($model->unitkeja_kejadian_id) ? $model->unitkerja->namaunitkerja : "";
            $model->tgl_pelaporan = MyFormatter::formatDateTimeForUser($model->tgl_pelaporan);
            $model->tgl_kejadian = MyFormatter::formatDateTimeForUser($model->tgl_kejadian);
            $modRevisi = new RevisiInsidenkebakaranR(); 
            $modRevisi->attributes = $model->attributes;
            $modRevisi->tgl_pelaporan = MyFormatter::formatDateTimeForDb($model->tgl_pelaporan);
            $modRevisi->tgl_kejadian = MyFormatter::formatDateTimeForDb($model->tgl_kejadian);
        }
        
        if (isset($_POST['YKMInsidenkebakaranT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $ok = true;
            try{
                $model->attributes = $_POST['YKMInsidenkebakaranT'];
               
                $model->tgl_pelaporan = MyFormatter::formatDateTimeForDb($model->tgl_pelaporan);
                $model->tgl_kejadian = MyFormatter::formatDateTimeForDb($model->tgl_kejadian);
                if (empty($insidenkebakaran_id)) {
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date ('Y-m-d H:i:s');
                } else {
                    $modRevisi->save(); 
                    if ($model->no_revisi >= 10) {
                        $model->no_revisi++;
                    } else {
                        $no = substr($model->no_revisi, 1, 2) +1;
                        $model->no_revisi = "0".$no;
                    }
                    $model->is_revisi = true;
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date ('Y-m-d H:i:s');
                }
                    
                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    if(!empty(!empty($_GET['is_edit']))){
                        $this->redirect(array('index', 'insidenkebakaran_id' => $model->insidenkebakaran_id, 'is_edit' => 1, 'sukses' => 1, 'frame' => 3));
                    }else{
                        $this->redirect(array('index', 'insidenkebakaran_id' => $model->insidenkebakaran_id, 'sukses' => 1));
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

