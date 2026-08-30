<?php
/**
 * Fungsi Rencana Anestesi untuk tabulasi pada Pra Anestesi / Pra Sedasi 
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class EvaluasiPrainduksiTController extends MyAuthController{
    
    public $path_view = 'anestesi.views.evaluasiPrainduksiT.';
    public $layout='//layouts/iframe';
    
    /**
     * Load form index dan menyimpan data evaluasi prainduksi
     * @param type $pasienanastesi_id
     */
    public function actionIndex($pasienanastesi_id = null){
        
        $modEvaluasi = EvaluasiPrainduksiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
        if(!empty($modEvaluasi)){
            $model = $modEvaluasi;
            
            if($model->masalahsaatinduksi_ada == false){
                $model->masalahsaatinduksi_ada = 'Tidak Ada';
            }elseif($model->masalahsaatinduksi_ada == true){
                $model->masalahsaatinduksi_ada = 'Ada';
            }
            if($model->perubahanrencanaanestesi_ada == false){
                $model->perubahanrencanaanestesi_ada = 'Tidak Ada';
            }elseif($model->perubahanrencanaanestesi_ada == true){
                $model->perubahanrencanaanestesi_ada = 'Ada';
            }
            if (isset($_POST['EvaluasiPrainduksiT'])) {
                try{

                    $model->attributes = $_POST['EvaluasiPrainduksiT'];
                    $model->tglevaluasi_praanestesi = MyFormatter::formatDateTimeForDb($model->tglevaluasi_praanestesi);
                    $model->makanterakhir = MyFormatter::formatDateTimeForDb($model->makanterakhir);
                    $model->minumterakhir = MyFormatter::formatDateTimeForDb($model->minumterakhir);
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    
                    if($model->masalahsaatinduksi_ada == 'Tidak Ada'){
                        $model->masalahsaatinduksi_ada = false;
                        $model->masalahsaatinduksi_tidakada = true;
                    }elseif($model->masalahsaatinduksi_ada == 'Ada'){
                        $model->masalahsaatinduksi_ada = true;
                        $model->masalahsaatinduksi_tidakada = false;
                    }

                    if($model->perubahanrencanaanestesi_ada == 'Tidak Ada'){
                        $model->perubahanrencanaanestesi_ada = false;
                        $model->perubahanrencanaanestesi_tidakada = true;
                    }elseif($model->perubahanrencanaanestesi_ada == 'Ada'){
                        $model->perubahanrencanaanestesi_ada = true;
                        $model->perubahanrencanaanestesi_tidakada = false;
                    }

                    if($model->validate() && $model->update()){
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $sukses = 1;
                        $this->redirect(array('index', 'pasienanastesi_id'=>$model->pasienanastesi_id,'evaluasi_prainduksi_id' => $model->evaluasi_prainduksi_id, 'sukses' => $sukses));
                    }else{
                        Yii::app()->user->setFlash('error',"Data gagal disimpan !");
                    }
                } catch (Exception $ex) {
                    Yii::app()->user->setFlash('error',"Data gagal disimpan !".MyExceptionMessage::getMessage($ex,true));
                }

            }
        }else{
            $model = new EvaluasiPrainduksiT();
            $modEvaluasi = EvaluasiPrainduksiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            $modAnestesi = InformasipasienanestesiV::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            $model->tglevaluasi_praanestesi = date('d M Y H:i:s');
            $model->masalahsaatinduksi_ada = 'Tidak Ada';
            $model->perubahanrencanaanestesi_ada = 'Tidak Ada';
            if (isset($_POST['EvaluasiPrainduksiT'])) {
                try{

                    $model->attributes = $_POST['EvaluasiPrainduksiT'];
                    $model->tglevaluasi_praanestesi = MyFormatter::formatDateTimeForDb($model->tglevaluasi_praanestesi);
                    $model->makanterakhir = MyFormatter::formatDateTimeForDb($model->makanterakhir);
                    $model->minumterakhir = MyFormatter::formatDateTimeForDb($model->minumterakhir);
                    $model->pasien_id = $modAnestesi->pasien_id;
                    $model->pendaftaran_id = $modAnestesi->pendaftaran_id;
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->pasienanastesi_id = $pasienanastesi_id;
                    if($model->masalahsaatinduksi_ada == 'Tidak Ada'){
                        $model->masalahsaatinduksi_ada = false;
                        $model->masalahsaatinduksi_tidakada = true;
                    }elseif($model->masalahsaatinduksi_ada == 'Ada'){
                        $model->masalahsaatinduksi_ada = true;
                        $model->masalahsaatinduksi_tidakada = false;
                    }

                    if($model->perubahanrencanaanestesi_ada == 'Tidak Ada'){
                        $model->perubahanrencanaanestesi_ada = false;
                        $model->perubahanrencanaanestesi_tidakada = true;
                    }elseif($model->perubahanrencanaanestesi_ada == 'Ada'){
                        $model->perubahanrencanaanestesi_ada = true;
                        $model->perubahanrencanaanestesi_tidakada = false;
                    }

                    if($model->validate() && $model->save()){
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                        $sukses = 1;
                        $this->redirect(array('index', 'pasienanastesi_id'=>$model->pasienanastesi_id, 'evaluasi_prainduksi_id' => $model->evaluasi_prainduksi_id, 'sukses' => $sukses));
                    }else{
                        Yii::app()->user->setFlash('error',"Data gagal disimpan !");
                    }
                } catch (Exception $ex) {
                    Yii::app()->user->setFlash('error',"Data gagal disimpan !".MyExceptionMessage::getMessage($ex,true));
                }

            }
        }
        
        $this->render($this->path_view.'index', array('model' => $model));
    }
}

