<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'pending-form',
    'type'=>'horizontal',
    'htmlOptions' => [
        'class' => 'form-data'
    ]
)); 
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-sm-12">
        <?= $form->textFieldRow($model,'create_time',['readonly'=>true]) ?>
        <?= $form->textAreaRow($model,'keterangan',['class'=>'required']) ?>       
    </div>    
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>"simpanPending(".$model->korektifmainten_id.",'simpan');")); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        'javascript:;', 
        array(
            'style'=>'color:#fff;',
            'class'=>'btn btn-danger',
            'onclick'=>"$('#dialogPending').dialog('close')")); ?>   
</div>

<?php $this->endWidget(); ?>
