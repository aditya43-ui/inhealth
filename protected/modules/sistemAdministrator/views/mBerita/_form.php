<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'samberita-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'mkategoriberita_id', CHtml::listData(SAMkategoriberitaM::model()->getKategoriBerita(), 'mkategoriberita_id', 'kategoriberita'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'judulberita', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'ringkasanberita', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'isiberita', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'isiberita', 'toolbar' => 'mini', 'height' => '100px', 'htmlOptions' => array('class' => 'span3',))) ?>
                <?php echo $form->error($model, 'isiberita'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'gambarberita_path', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php if (isset($model->gambarberita_path)) { ?>
                    <img src="<?php echo Params::urlBerita() . $model->gambarberita_path; ?>" width="200px" height="200px;"><br>
                <?php } ?>
                <?php echo $form->fileField($model, 'gambarberita_path', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'maxlength' => 300)); ?>
                <?php echo $form->error($model, 'gambarberita_path'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'gambarberita_text', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($model, 'keteranganberita', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'waktutampilberita', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->waktutampilberita = (!empty($model->waktutampilberita) ? date("d/m/Y", strtotime($model->waktutampilberita)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'waktutampilberita',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'waktutampilberita'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'waktutampilberita', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->waktuselesaitampil = (!empty($model->waktuselesaitampil) ? date("d/m/Y", strtotime($model->waktuselesaitampil)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'waktuselesaitampil',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'waktuselesaitampil'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'beritaterkait', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                    'model' => $model,
                    'attribute' => 'beritaterkait',
                    'data' => explode(',', $model->beritaterkait),
                    'debugMode' => true,
                    'options' => array(
                        'addontab' => true,
                        'maxitems' => 10,
                        'input_min_size' => 0,
                        'cache' => true,
                        'newel' => true,
                        'addoncomma' => true,
                        'select_all_text' => "",
                        'autoFocus' => true,
                    ),
                    'htmlOptions' => array('id' => 'beritaterkait'),
                ));
                ?>
                <?php echo $form->error($model, 'beritaterkait'); ?>
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
        Yii::t('mds', '{icon} Pengaturan Berita', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('tips/create', array(), true);
    $this->widget('UserTips', array('type' => 'create', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>