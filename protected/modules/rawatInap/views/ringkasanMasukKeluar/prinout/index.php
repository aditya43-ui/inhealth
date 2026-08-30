<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    

<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo',[
        'nodokrm'=>'RM 78.21',
        'identitaspasien'=>true
    ], true);
    echo $this->renderPartial('prinout/template',[
        'model'=>$model, 
        'modDaftar'=>$modPendaftaran,
        'modPas'=>$modPasien,
        'modAdmisi'=>!empty($modPendaftaran->pasienadmisi)?$modPendaftaran->pasienadmisi:new PasienadmisiT,
        'print'=>1
        ], true);
?>
  

