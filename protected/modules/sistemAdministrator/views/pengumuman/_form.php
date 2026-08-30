<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapengumuman-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="span12">
        <?php echo $form->textFieldRow($model, 'judul', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 150)); ?>
        <?php //echo $form->textAreaRow($model,'isi',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'isi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'isi', 'toolbar' => 'mini', 'height' => '150px', 'htmlOptions' => array('class' => 'span3',))) ?>
                <?php echo $form->error($model, 'isi'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Dokumen', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->fileField($model,'dokumen', array('class'=>'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'status_publish', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'status_publish', array('rel' => 'tooltip', 'title' => 'Centang untuk mengaktifkan', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pengumuman', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));
    ?>
</div>

<?php $this->endWidget(); ?>