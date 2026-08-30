<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'asesmen-ulang-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)', 
        'enctype' => 'multipart/form-data', 
        'onsubmit' => 'return requiredCheck(this);'),               
    ));

$detail = isset($detail)?$detail:'';
?>
    <?= CHtml::hiddenField('jenis_dialog',''); ?>
    <?= CHtml::hiddenField('no_row',''); ?>

    <?= $this->renderPartial($this->path_view.'spiritualUlangRJRD/form/_1_riwayat',['model'=>$model, 'form'=>$form], true) ?>
    <p></p>
    <div class="dis-form">
        <?= $this->renderPartial($this->path_view.'spiritualUlangRJRD/form/_2_data',['model'=>$modDet, 'form'=>$form], true) ?>


        <div class="form-actions">
            <?= $this->renderPartial($this->path_view.'spiritualUlangRJRD/_button',['model'=>$model]); ?>
        </div>
    </div>
    
<?php $this->endWidget(); 

?>