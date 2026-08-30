<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'persiapan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Laporan Permenkes</b> </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('laporanPermenkes/_tabmenu', array('model' => $model))?>
        <?php $this->renderPartial('laporanPermenkes/_jsFunction', array('model' => $model))?>
        
    </div>
</div>
<?php $this->endWidget(); ?>