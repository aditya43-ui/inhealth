<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'gradinginsidenrs-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#',
)); ?>
<div class="row">
    <?php echo $this->renderPartial($this->path_grading.'/_gradingForm', array(
        'model'=>$model,
    )); ?>
</div>
<?php $this->endWidget(); ?>