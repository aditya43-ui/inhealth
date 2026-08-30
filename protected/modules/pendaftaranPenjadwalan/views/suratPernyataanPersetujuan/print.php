<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    

<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo');
    echo $this->renderPartial('template',['model'=>$model, 'print'=>1], true);


?>
  

