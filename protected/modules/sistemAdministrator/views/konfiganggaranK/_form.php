<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'agkonfiganggaran-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6"><br><br>
        <?php $model->tglanggaran  = $format->formatDateTimeForUser($model->tglanggaran); ?>
        <?php echo $form->labelEx($model, 'Periode Anggaran', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglanggaran',
                'mode' => 'date',
                'options' => array(
                    //'maxDate'=>'d',
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'dtPicker2',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>

        </div>
        <?php $model->sd_tglanggaran = $format->formatDateTimeForUser($model->sd_tglanggaran); ?>
        <?php echo CHtml::label('Sampai Dengan', ' Sampai Dengan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'sd_tglanggaran',
                'mode' => 'date',
                'options' => array(
                    // 'maxDate'=>'d',
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'dtPicker2',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
        <?php echo $form->textAreaRow($model, 'deskripsiperiode', array('placeholder' => 'Deskripsi Periode', 'rows' => 4, 'cols' => 35, 'maxlength' => 100, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->textFieldRow($model,'deskripsiperiode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
        ?>
    </div>
    <div class="col-sm-6">
        <fieldset class="box">
            <legend class="rim">Setting Umum</legend>
            <?php $model->tglrencanaanggaran  = $format->formatDateTimeForUser($model->tglrencanaanggaran); ?>
            <?php echo $form->labelEx($model, 'Rencana Anggaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglrencanaanggaran',
                    'mode' => 'date',
                    'options' => array(
                        //'maxDate'=>'d',
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'dtPicker2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>

            </div>
            <?php $model->sd_tglrencanaanggaran = $format->formatDateTimeForUser($model->sd_tglrencanaanggaran); ?>
            <?php echo CHtml::label('Sampai Dengan', ' Sampai Dengan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'sd_tglrencanaanggaran',
                    'mode' => 'date',
                    'options' => array(
                        //'maxDate'=>'d',
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'dtPicker2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
            <?php $model->tglrevisianggaran  = $format->formatDateTimeForUser($model->tglrevisianggaran); ?>
            <?php echo $form->labelEx($model, 'Revisi Anggaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglrevisianggaran',
                    'mode' => 'date',
                    'options' => array(
                        //'maxDate'=>'d',
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'dtPicker2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>

            </div>
            <?php $model->sd_tglrevisianggaran = $format->formatDateTimeForUser($model->sd_tglrevisianggaran); ?>
            <?php echo CHtml::label('Sampai Dengan', ' Sampai Dengan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'sd_tglrevisianggaran',
                    'mode' => 'date',
                    'options' => array(
                        //'maxDate'=>'d',
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'dtPicker2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Closing Anggaran', ' Closing Anggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'isclosing_anggaran'); ?>
                </div>
            </div>
        </fieldset>
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
        Yii::t('mds', '{icon} Pengaturan Konfigurasi Anggaran', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/add', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>