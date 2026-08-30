<?php
/**
 * Menampilkan Form, tabel detail berserta fungsi JS-nya
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 */
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Mutasi Aset
        </div>
    </div>
    <div class="panel-body">
        
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'mutasiaset-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        )); ?>
        <?php echo $this->renderPartial('_formMutasi', array(
            'model'=>$model,
            'detail'=>$detail,
            'form'=>$form,
        ), true); ?>
        <?php echo $this->renderPartial('_formPeralatan', array(
            'model'=>$model,
            'detail'=>$detail,
            'form'=>$form,
        ), true); ?>
        
        <div class="form-actions">
            <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
                'class'=>'btn btn-danger '.($model->isNewRecord ? 'submit' : ''),
                'type'=>'submit',
                'disabled'=>!$model->isNewRecord,
            )); ?>
            <?php echo CHtml::link('<i class="entypo-arrows-ccw"></i> Ulang', $this->createUrl('index'), array(
                'class'=>'btn btn-default',
            )); ?>
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php echo $this->renderPartial('_jsFunctions', array(
    'model'=>$model,
    'detail'=>$detail,
), true); 

$this->renderPartial('_dialog',['model'=>$model]);
?>