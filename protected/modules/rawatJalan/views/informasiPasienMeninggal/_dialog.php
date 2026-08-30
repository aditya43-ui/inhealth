<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogSuratKematian',
    'options' => array(
        'title' => 'Buat Surat Kematian',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,        
    ),
));
?>

<iframe id="frameSuratKematian" name='frameSuratKematian' style="width: 100%; height: 98%;"></iframe>

<?php $this->endWidget(); 


$jscript = <<< JS
       
   
        
JS;

Yii::app()->clientScript->registerScript('surat-kematian-dialog',$jscript, CClientScript::POS_HEAD);
?>


