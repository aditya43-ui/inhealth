<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END);

    $this->widget('bootstrap.widgets.BootAlert');
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'observasi-pendonor-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));

    echo $this->renderPartial($this->path_view.'pendonor/form/_formObservasi',array('model'=>$model,'form'=>$form,'modDaftarDonasi'=>$modDaftarDonasi,'getCeklis'=>$getCeklis,'modPenggunaan'=>$modPenggunaan, 'cekKantong'=>$cekKantong,),true);

    echo $this->renderPartial($this->path_view.'pendonor/_dialog',array('model'=>$model,'form'=>$form),true);
    
    echo $this->renderPartial($this->path_view.'pendonor/_jsFunctions',array('model'=>$model),true);
    
    $this->endWidget();               
?>


