<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'warnadokrm-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'warnadokrm_namawarna',array('class'=>'span3','maxlength'=>20)); ?>
	<?php echo $form->checkBoxRow($model,'warnadokrm_aktif', array('checked'=>'warnadokrm_aktif')); ?>        
    </div>
    <div class="col-sm-6">
	<?php echo $form->textAreaRow($model,'warnadokrm_fungsi',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>        
    </div>
</div>
<?php // echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span3 numbers-only')); ?>
<?php // echo $form->textFieldRow($model,'warnadokrm_kodewarna',array('class'=>'span3','maxlength'=>20)); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>
