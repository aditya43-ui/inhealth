<?php
/**
 * digunakan pada transaksi pemesanan pasca anastesi
 * @author rusdiyanto <rusdiyanto@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class PesananPascaAnastesiController extends MyAuthController {
    
    public $path_view = 'anestesi.views.pesananPascaAnastesi.';
    public $layout='//layouts/iframe';
    /**
     * fungsi insert
     * @param integer $pasienanastesi_id
     * @param integer $pasienmasukpenunjang_id
     */
    public function actionIndex($pasienanastesi_id,$pasienmasukpenunjang_id = null) {
        $arrTerapi = array();
        $model = ATPesananpascaanastesiT::model()->findByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id));
        if(empty($model->pasienanastesi_id)){
            $model = new ATPesananpascaanastesiT();
        }else{
            $model->pegawai_nama = !empty($model->pegawai_id)? PegawaiM::model()->findByPk($model->pegawai_id)->nama_pegawai : null;
            $arrTerapi = ATTerapipascaanastesiT::model()->findAllByAttributes(array('pesananpascaanastesi_id' => $model->pesananpascaanastesi_id));            
        }
        $modTerapi = new ATTerapipascaanastesiT();
        $format = new MyFormatter();
        $diagnosis = null;
        if(isset($pasienanastesi_id)) {
            $modPasienAnestesi = PasienanastesiT::model()->findByPk($pasienanastesi_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
            $modMonitoring = MonitoringpascaanastesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            if(!empty($modMonitoring->diagnosa_id)){
                $diagnosis = $modMonitoring->diagnosa->diagnosa_nama;
            }
        }
        if(isset($_POST['ATPesananpascaanastesiT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            $simpan_pesanan = false;
            $simpan_terapi = false;
            try{
                $model->attributes = $_POST['ATPesananpascaanastesiT'];
                $model->puasa = $format->formatDateTimeForDb($_POST['ATPesananpascaanastesiT']['puasa']);
                $model->jam_minum = empty(!$model->jam_minum)? $model->jam_minum : null;
                $model->jam_makan = empty(!$model->jam_makan)? $model->jam_makan : null;
                $model->create_time = date('Y-m-d H:i:s');
		$model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $model->pendaftaran_id = $modPasienAnestesi->pendaftaran_id;
                $model->pasienanastesi_id = $modPasienAnestesi->pasienanastesi_id;
                $model->pasien_id = $modPendaftaran->pasien_id;
                
                if($model->save()) {
                    $simpan_pesanan = true;
                    
                    if(isset($_POST['ATTerapipascaanastesiT'])) {
                        if(count($_POST['ATTerapipascaanastesiT']) > 0){
                            $delete_tindakananestesi = ATTerapipascaanastesiT::model()->deleteAllByAttributes(array('pesananpascaanastesi_id'=>$model->pesananpascaanastesi_id));
                            foreach ($_POST['ATTerapipascaanastesiT'] as $data) {
                                if(!empty($data['nama_terapi'])){
                                    $modSimpanTerapi = new ATTerapipascaanastesiT();
                                    $modSimpanTerapi->pesananpascaanastesi_id = $model->pesananpascaanastesi_id;
                                    $modSimpanTerapi->nama_terapi = $data['nama_terapi'];

                                    if($modSimpanTerapi->save()) {
                                        $simpan_terapi = true;
                                    }
                                }else{
                                    $simpan_terapi = true;
                                }
                            }
                        }
                    }
                }
                if($simpan_pesanan == true || $simpan_terapi == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash("success", "<strong>Berhasil!</strong> Data berhasil disimpan.");          
                    $this->redirect(array('index','pasienanastesi_id'=>$model->pasienanastesi_id,'sukses'=>1));                        
                    } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash("gagal", "Data gagal disimpan.");    
                    $this->refresh();
                    }
                    
            } catch (Exception $ex) {                
                var_dump($ex->getMessage());die;
                $transaction->rollback();
                Yii::app()->user->setFlash("error", "Error! Data gagal disimpan. ".MyExceptionMessage::getMessage($ex,true));
            }
        }
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'model'=>$model,
            'modTerapi'=>$modTerapi,
            'diagnosis'=>$diagnosis,
            'arrTerapi'=>$arrTerapi,
        ));
    }
    
    /**
     * Autocompelte Pegawai
     * @param string $term.
     */
    public function actionAutocompletePegawai($term = '') {
        if(Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->join = "JOIN ruanganpegawai_m on ruanganpegawai_m.pegawai_id=t.pegawai_id";
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition("ruangan_id= " . Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = PegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}
