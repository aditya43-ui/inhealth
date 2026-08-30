<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailFastTrack',
    'options' => array(
        'title' => 'View Fast Track',
        'autoOpen' => false,
        //'position'=>['top',20] ,
        'modal' => true,
        'width' => 550,
        'height' => 300,
        'resizable' => false,
    ),
));
$this->renderPartial('form/detail/_detail_fasttrack',[]);
$this->endWidget();


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogUbahPoliklinik',
    'options' => array(
        'title' => 'Form Ubah Poliklinik',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 550,
        'height' => 350,
        'resizable' => false,
    ),
));

echo "<div class='form-horizontal' id='form-jenis-kunjungan' style='padding:20px;'>";
echo "</div>";

$this->endWidget();


$jscript = <<< JS
    
JS;

Yii::app()->clientScript->registerScript('pemanggilan-antrian-dialog',$jscript, CClientScript::POS_HEAD);
?>


