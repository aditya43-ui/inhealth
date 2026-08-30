<?php
/**
 * Transaksi Risk Register
 * @author      Elham Budianto <elhambudianto1@gmail.com>
 * @author      Tantowi J <tantowijaya@.com>
 * @author      Andyka Putra <andykaputra@.com>
 * @package     application.modules.penelitianKesehatan
 * @subpackage  controllers
 */
class RiskregisterTController extends MyAuthController{
    
    /**
     * Default menu transaksi penelitian
     * @param integer $penelitian_id
     */
    public function actionIndex($riskregister_id = null){
        $format = new MyFormatter;
        $model = new RiskregisterM;
        
        if(!empty($riskregister_id)){
            $model = RiskregisterM::model()->findByPk($riskregister_id);
        }
        
        if(isset($_POST['RiskregisterM'])){                  
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['RiskregisterM'];
                $model->riskregister_tanggalmulai= MyFormatter::formatDateTimeForDb($model->riskregister_tanggalmulai);
                $model->riskregister_tanggaltinjauan= MyFormatter::formatDateTimeForDb($model->riskregister_tanggaltinjauan);
                if($model->save()){
                    $trans->commit();
                    if(!empty($riskregister_id)){
                        $this->redirect(array('informasiRiskRegister/index','sukses'=>1));
                    }else{
                        $this->redirect(array('index','sukses'=>1,'riskregister_id'=>$model->riskregister_id));
                    }
                }else{
                    $trans->rollback();
                    Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
                    
                }
            } catch (Exception $ex) {   
                $trans->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                
            }
        }
        
        $this->render('index',array(
            'model'=>$model,
        ));
    }
    
    
    /**
     * Mendapatkan data peluang dari inputan user
     */
    public function actionGetBobotPeluang() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $model = PeluangM::model()->findByPk($id);
            if(!empty($model)){
                $data['return'] = $model->peluang_bobotdescriptor;
            }else{
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
            $model = KonsekuensiM::model()->findByPk($id );
            if(!empty($model)){
                $data['return'] = $model->konsekuensi_bobot;
            }else{
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
            $model = DetectabilityM::model()->findByPk($id );
            if(!empty($model)){
                $data['return'] = $model->detectability_bobot;
            }else{
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
            $model = GradingrisikoM::model()->findByAttributes(array('konsekuensi_id'=>$konsekuensi_id, 'peluang_id'=>$peluang_id));
            if(!empty($model)){
                $data['return'] = $model->tingkatrisiko->tingkatrisiko_nama;
            }else{
                $data['return'] = "";
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
    public function actionGetKonsekuensi($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $domain = $_POST['RiskregisterM']['domain_id'];
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(konsekuensi_domain)', strtolower($domain),true);
            $criteria->addCondition('konsekuensi_aktif = true');
            $konsekuensi = KonsekuensiM::model()->findAll($criteria);
            
            $namabobot=CHtml::listData($konsekuensi,'konsekuensi_id','konsekuensi_namabobot');
            
            if(empty($namabobot)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count($namabobot)>=1){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count($namabobot)==0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                
                foreach($namabobot as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }
    
    /**
     * Default menu transaksi risk resgister
     * @author Andyka Putra <andykaputra@.com>
     * @param type $riskregister_id
     */
    public function actionDetail($riskregister_id){
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter;
        $model = new RiskregisterM;
        
        if(!empty($riskregister_id)){
            $model = RiskregisterM::model()->findByPk($riskregister_id);
        }
        
        $this->render('detail',array(
            'model'=>$model,
        ));
    }
    
}