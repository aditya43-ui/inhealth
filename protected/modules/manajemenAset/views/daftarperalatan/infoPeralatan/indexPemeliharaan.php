<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemeliharaan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

echo $this->renderPartial($this->path_view.'.infoPeralatan/_tabMenuPemeliharaan', array(

), true);                        
?>
<div>
    <iframe class="biru" id="frame_pemeliharaan" src="" width='100%' frameborder="0" ></iframe>
</div>
<?php
$this->endWidget(); 

echo $this->renderPartial($this->path_view.'.infoPeralatan/_jsFunctionPemeliharaan', array(), true);

?>
        