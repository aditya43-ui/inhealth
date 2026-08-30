<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpjamkerja-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll(array('order' => 'shift_nama')), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
        <?php echo $form->textFieldRow($model, 'jamkerja_nama', array('placeholder' => 'Nama Jam Kerja', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jammasuk', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammasuk',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jampulang', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jampulang',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", 'jamkerja_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jamkerja_aktif'); ?>
                <label for="KPJamkerjaM_jamkerja_aktif">Aktif</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'jamisitrahat', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamisitrahat',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jammasukistirahat', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammasukistirahat',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jammulaiscanmasuk', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulaiscanmasuk',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jamakhirscanmasuk', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamakhirscanmasuk',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jammulaiscanplng', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulaiscanplng',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jamakhirscanplng', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamakhirscanplng',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 dtPicker3',
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'toleransiterlambat', array('class' => 'span1', 'placeholder' => 'Menit', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'toleransiplgcpt', array('class' => 'span1', 'placeholder' => 'Menit', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jam Kerja', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit4c', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>