<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'guinvgedung-t-search',
        'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'invgedung_kode',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik kode gedung')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'invgedung_noregister',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik no. gedung')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class'=>'btn btn-default',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>								
    <?php  
        $content = $this->renderPartial('/tips/informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>

<?php $this->endWidget(); ?>
