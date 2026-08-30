
<?php
// dialog peneliti
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPendaftaran',
    'options' => array(
        'title' => 'Pendaftaran',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 500,
        'height' => 290,
        'resizable' => false,
        'close'=>"js:function(){ $.fn.yiiGridView.update('informasi-stok-grid', {
            data: $('#informasisampel-r-search').serialize()
        }); }",
    ),
));
echo '<div id="div-form-pendaftaran" class="form-horizontal"></div>';
$this->endWidget();



$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPendaftaran2',
    'options' => array(
        'title' => 'Pendaftaran',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 500,
        'height' => 290,
        'resizable' => false,
        'close'=>"js:function(){ $.fn.yiiGridView.update('informasi-stok-grid', {
            data: $('#informasisampel-r-search').serialize()
        }); }",
    ),
));
echo '<div id="div-form-pendaftaran2" class="form-horizontal"></div>';
$this->endWidget();

$jscript = <<< JS
   
    
        
JS;

Yii::app()->clientScript->registerScript('informasi-dialog-js',$jscript, CClientScript::POS_HEAD);
?>


