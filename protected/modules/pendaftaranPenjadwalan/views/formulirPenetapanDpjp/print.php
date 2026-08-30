<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    

<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo');
    echo $this->renderPartial('templateDpjp',['model'=>$model,  'print'=>1], true);
    
    echo '<div style="page-break-after: always;"></div>';
    
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo');
    echo $this->renderPartial('templateKebutuhanPrivasi',['model'=>$model,  'print'=>1], true);
    
    echo '<div style="page-break-after: always;"></div>';
    
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo',['identitaspasien'=>true, 'modPasien'=>$model->pasien]);
    echo $this->renderPartial('templatePermintaanKerohanian',['model'=>$model,  'print'=>1], true);


?>
  

