<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    

<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo');
    echo $this->renderPartial('printout/template',[
        'model'=>$model, 
        'print'=>1,
        'modPendaftaran'=>$modPendaftaran,
        'modPasien'=>$modPasien
    ], true);
?>
  

