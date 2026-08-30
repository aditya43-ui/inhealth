<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jenisbarang-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisbarang_nama', array('placeholder' => 'Nama Jenis Barang', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jenisbarang_namalain', array('placeholder' => 'Nama Lain Jenis Barang', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php // echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php if (!$model->isNewRecord) : ?>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'jenisbarang_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <label for="JenisbarangM_jenisbarang_aktif">Aktif</label>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'jenisbarang_deskripsi', array('placeholder' => 'Deskripsi', 'rows' => 4, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>