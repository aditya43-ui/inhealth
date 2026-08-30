<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    
<style type="text/css">
    table th{
        text-align: right !important;
    }
</style>
<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo');
    echo $this->renderPartial('print/template',['model'=>$model, 'print'=>1], true);
?>
  

