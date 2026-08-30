<?php
/**
 * Fungsi Rencana Anestesi untuk tabulasi pada Pra Anestesi / Pra Sedasi 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.anestesi
 * @subpackage controllers
 */
class RencanaAnestesiTController extends MyAuthController{
    
    public $path_view = 'anestesi.views.rencanaAnestesiT.';
    public $layout='//layouts/iframe';
    
    /**
     * Load form index dan menyimpan data rencana anestesi
     * @param type $pasienanastesi_id
     */
    public function actionIndex($pasienanastesi_id = null){
        $cekRencana = RencanaanestesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
        if (empty($cekRencana)) {
            $model = new RencanaanestesiT;
            $model->tglrencanaanestesi = date('d M Y H:i:s');
        } else {
            $model = RencanaanestesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
            $model->tglrencanaanestesi = MyFormatter::formatDateTimeForUser($model->tglrencanaanestesi);
        }
            
        $modAnestesi = InformasipasienanestesiV::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id));
        if (isset($_POST['RencanaanestesiT'])) {
            try{
                $model->attributes = $_POST['RencanaanestesiT'];
                $model->tglrencanaanestesi = MyFormatter::formatDateTimeForDb($model->tglrencanaanestesi);
                $model->pasien_id = $modAnestesi->pasien_id;
                $model->pendaftaran_id = $modAnestesi->pendaftaran_id;
                $model->pasienanastesi_id = $pasienanastesi_id;
                if (empty($cekRencana)) {
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                    $model->update_time = date ('Y-m-d H:i:s');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                
                if($model->validate() && $model->save()){
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $sukses = 1;
                    $this->redirect(array('index', 'pasienanastesi_id' => $model->pasienanastesi_id, 'sukses' => $sukses));
                }else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan !");
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error',"Data gagal disimpan !".MyExceptionMessage::getMessage($ex,true));
            }
            
        }
        $this->render($this->path_view.'index', array('model' => $model));
    }
}

