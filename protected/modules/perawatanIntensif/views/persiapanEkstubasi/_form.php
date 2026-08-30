<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'cryopreservasi-sel-punca-form',
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

    <?= $this->renderPartial('form/_1_riwayat_persiapan_ekstubasi',['model'=>$model, 'form'=>$form], true) ?>
    
    <div class="dis-form">
        <?= $this->renderPartial('form/_2_form_ekstubasi',['model'=>$model, 'form'=>$form], true) ?>
        
        <?= $this->renderPartial('form/_3_form_kriteria',['model'=>$model, 'form'=>$form], true) ?>


        <div class="form-actions">
            <?= $this->renderPartial('_button',['model'=>$model]); ?>
        </div>
    </div>
    
<?php $this->endWidget(); 

?>