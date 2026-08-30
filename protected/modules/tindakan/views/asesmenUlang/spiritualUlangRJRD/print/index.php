<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout.css">    

<?php 
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo',[
        'identitaspasien' => true,
        'modPasien' => $model->pasien,
        'nodokrm'=>'RM 2.f'
    ]);
    echo '<div style="padding:20px;">';
    echo $this->renderPartial($model->jenis.'/print/template',['model'=>$model, 'print'=>1], true);
    echo '</div>';
?>
  

