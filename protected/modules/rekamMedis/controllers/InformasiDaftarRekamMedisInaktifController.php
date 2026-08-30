<?php
class InformasiDaftarRekamMedisInaktifController extends MyAuthController
{
    
    public function actionIndex(){
        
        $model = new RKInfoRekamMedisInaktifV;
        
        
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['RKInfoRekamMedisInaktifV'])){
            $model->attributes = $_GET['RKInfoRekamMedisInaktifV'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['RKInfoRekamMedisInaktifV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['RKInfoRekamMedisInaktifV']['tgl_akhir']);
        }
        $this->render('index',
            array(
                'model'=>$model,
            )
        );
    }
    
    public function loadModel($id)
	{
                $idpk = InaktifrekammedisdetT::model()->findByAttributes(array('pasien_id'=>$id));
		
                $model= InaktifrekammedisdetT::model()->findByPk($idpk->inaktifrekammedisdet_id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
    public function actionDelete(){
        if(Yii::app()->request->isAjaxRequest) {
        try{
               
               $id=$_POST['id'];
               $model=$this->loadModel($_POST['id']);
           
               $updatepasien = PasienM::model()->updateByPk($id,array('statusrekammedis'=>"AKTIF"));
               $modelpk = DokrekammedisM::model()->findByAttributes(array('pasien_id'=>$id));
               
               $dok_id=$modelpk->dokrekammedis_id;
               $updatestatus = DokrekammedisM::model()->updateByPk($dok_id,array('statusrekammedis'=>"AKTIF"));
               $updatetgl = DokrekammedisM::model()->updateByPk($dok_id,array('tgl_in_aktif'=>date('Y-m-d', strtotime('+5 years'))));
               // statusrekammedis = "AKTIF" dan tgl_in_aktif = NULL
               
               if($model->delete()){
                    
                    $data['status'] = 'sukses';
                    }else{
                    $data['status'] = 'gagal';
                }
               $data['status'] = 'sukses';
        }catch(Exception $e){
            $data['status'] = 'gagal';
            Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($e,true));
           
        }   
        
        echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
}
