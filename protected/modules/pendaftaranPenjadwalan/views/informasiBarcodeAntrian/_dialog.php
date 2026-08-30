<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisKunjungan',
    'options' => array(
        'title' => 'Form Jenis Kunjungan',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 550,
        'height' => 350,
        'resizable' => false,
    ),
));

echo "<div class='form-horizontal' id='form-jenis-kunjungan' style='padding:20px;'>";

//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'setDialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien Apotek',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>950,
        'height'=>650,
        'resizable'=>false,
    ),
));

$this->renderPartial('_listAntrian',[]);

$this->endWidget();

echo "</div>";

$this->endWidget();


$jscript = <<< JS
       
     
    
JS;

Yii::app()->clientScript->registerScript('informasi-barcode-antrian-dialog',$jscript, CClientScript::POS_HEAD);
?>


