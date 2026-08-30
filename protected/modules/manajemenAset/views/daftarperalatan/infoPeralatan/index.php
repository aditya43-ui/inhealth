<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'resikojatuh-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

echo $this->renderPartial($this->path_view.'.infoPeralatan/_tabMenu', array(

), true);                        
?>
<div>
<iframe class="biru" id="frame" src="" style="min-height: 700px;" width='100%' frameborder="0" ></iframe>
</div>
<?php
$this->endWidget(); 

echo $this->renderPartial($this->path_view.'.infoPeralatan/_jsFunction', array(), true);

?>
        