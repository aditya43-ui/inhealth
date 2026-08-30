<?php
/**
 * 
 * controller utama transaksi monitoring pasca anestesi
 * 
 * @package      application.modules.anestesi
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class MonitoringPascaAnestesiController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'anestesi.views.pascaAnestesi.monitoring.';
    public $init = '';
    public $simpan_monitoring = true;    

    /**
     * Digunakan untuk menampilkan transaksi monoting pasca anestesi
     * @param type integer $pasienanastesi_id     
     */
    public function actionIndex($pasienanastesi_id) {
                        
        $model = new ATMonitoringpascaanastesiT();
        $model->pasienanastesi_id = $pasienanastesi_id;
        $model->jam_masuk = date('d M Y H:i:s');
        $model->jam_keluar = date('d M Y H:i:s', strtotime("+2 hours"));
                                    
        $criteria = new CDbCriteria();
        $criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
        $modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);                                                            
        
        $model->pendaftaran_id = $modKunjungan->pendaftaran_id;
        $model->pasien_id = $modKunjungan->pasien_id;
        
        $loadDet = array();
        
        $cekMonitor = ATMonitoringpascaanastesiT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'pasien_id'=>$model->pasien_id,'pasienanastesi_id'=>$model->pasienanastesi_id));
        if (!empty($cekMonitor)){
            $model = $cekMonitor;
            $model->diagnosa_nama = $model->diagnosa->diagnosa_nama;
            $model->monitoringpeg_nama = $model->monitoringpeg->namaLengkap;
            
            $loadDet = ATMonitoringpascaanastesiT::model()->findAllByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'pasien_id'=>$model->pasien_id,'pasienanastesi_id'=>$model->pasienanastesi_id));
        }
        
        if (isset($_POST['ATMonitoringpascaanastesiT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {                
                $this->saveMonitoring($model,$_POST['ATMonitoringpascaanastesiT']);
                                                    
                if ($this->simpan_monitoring) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
                    $this->redirect(array('index', 'pasienanastesi_id' => $pasienanastesi_id, 'sukses' => 1));
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
            'loadDet' => $loadDet
        ));
    }      
    
    /**
     * fungsi simpan monitoring
     * @param type $model
     * @param type $post
     * @return type
     */
    public function saveMonitoring($model,$post){      
        foreach($post['det'] as $det){
            if (empty($det['monitoringpascaanastesi_id'])){
                $model = new ATMonitoringpascaanastesiT;
                $model->attributes = $post;                 
                $model->attributes = $det;
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }else{
                $model = ATMonitoringpascaanastesiT::model()->findByPk($det['monitoringpascaanastesi_id']);
                $model->attributes = $post;                 
                $model->attributes = $det;
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                
            }

            $this->simpan_monitoring = $this->simpan_monitoring && $model->save();                        
        }
        
        return $this->simpan_monitoring;
    }   
    
    /**
     * tambah data
     */
    public function actionGenerateRow(){
        if (Yii::app()->request->isAjaxRequest){
            
            parse_str($_POST['formdata'], $arr);
            
            $model = new ATMonitoringpascaanastesiT;
            $model->attributes = $arr['ATMonitoringpascaanastesiT'];            
            $model->monitoringpascaanastesi_id = !empty($arr['ATMonitoringpascaanastesiT']['monitoringpascaanastesi_id'])?$arr['ATMonitoringpascaanastesiT']['monitoringpascaanastesi_id']:null;
                        
            $tr = $this->renderPartial($this->path_view."form/_rowMonitoring",array('model' => $model,'i'=>0),true);

            $data['sukses'] = 1;            
            $data['tr'] = $tr;
            
            echo json_encode($data);
            
            Yii::app()->end();
        }
    }
    
    /**
     * generate form data monitoring, untuk ubah data
     */
    public function actionLoadForm(){
        if (Yii::app()->request->isAjaxRequest){
            
            parse_str($_POST['formdata'], $arr);
            $id = isset($_POST['no'])?$_POST['no']:null;
            
            $model = new ATMonitoringpascaanastesiT;
            $model->attributes = $arr['ATMonitoringpascaanastesiT']['det'][$id];            
            $model->monitoringpascaanastesi_id = !empty($arr['ATMonitoringpascaanastesiT']['det'][$id]['monitoringpascaanastesi_id'])?$arr['ATMonitoringpascaanastesiT']['det'][$id]['monitoringpascaanastesi_id']:null;
                        
            $tr = $this->renderPartial($this->path_view."form/_formMonitoring",array('model' => $model,'i'=>0),true);
            
            $tr .= '<div class="clear"></div>        
                        <div class="control-group">
                            <label class="control-label">
                                '.           
                                    CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
                                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onclick'=>'ubahDataMonitor('.$id.');'))
                                .'
                            </label>           
                        </div>';

            $data['sukses'] = 1;            
            $data['tr'] = $tr;
            
            echo json_encode($data);
            
            Yii::app()->end();
        }
    }
}
