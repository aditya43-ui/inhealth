<?php

class EvaluasiPemberianObatController extends MyAuthController
{
    public function actionIndex()
    {
          $modInfoRI = new PCInfopasienmasukkamarV;
		  
		  if (isset($_GET['pendaftaran_id'])){
		  $modInfoRI = PCInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'])); 
		  }
		  
		$this->render('index',array(
			'modInfoRI'=>$modInfoRI,
		));
    }
	

    /**
     * Mengurai data pasien berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataInfoPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
			if(!empty($pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);						
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);						
			}
			if(!empty($instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$instalasi_id);						
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
            if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = PCInfoKunjunganRDV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = PCInfoKunjunganRJV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = PCInfopasienmasukkamarV::model()->find($criteria);
            }
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}