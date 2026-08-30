<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfkonfigfarmasi-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'persenppn'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="col-sm-6">
    <div class="control-group">
        <div class="control-label">
            <?php echo CHtml::label('Tgl. Berlaku', 'tgl_awal'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglberlaku',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
            ));
            ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'persenppn'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'persenppn', array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:40px;'
            )); ?> %
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'persenpph'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'persenpph', array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:40px;'
            )); ?> %
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'persehargajual'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'persehargajual', array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:40px;'
            )); ?> %
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'totalpersenhargajual'); ?>
        </div>
        <div class="controls">
            <?php echo CHtml::textField('persenhj', 100, array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:40px;'
            )); ?> % +
            <?php echo CHtml::textField('totalphj', ($model->totalpersenhargajual - 100 < 0  ? 0 : $model->totalpersenhargajual - 100), array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:40px;'
            )); ?> %
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'persjualbebas'); ?>
        </div>
        <div class="controls">
            <?php echo CHtml::textField('persenjb', 100, array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:40px;'
            )); ?> % +
            <?php echo CHtml::textField('totalpjb', ($model->persjualbebas - 100 < 0  ? 0 : $model->persjualbebas - 100), array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:40px;'
            )); ?> %
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'administrasi'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'administrasi', array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:50px;'
            )); ?> Rupiah
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'admracikan'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'admracikan', array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:50px;'
            )); ?> Rupiah
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'marginresep'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'marginresep', array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:50px;'
            )); ?> %
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'marginnonresep'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'marginnonresep', array(
                'class' => 'span2 numbersOnly',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:50px;'
            )); ?> %
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->checkBoxRow(
            $model,
            'hargajualglobal',
            array('onkeypress' => "return $(this).focusNextInputField(event);")
        ); ?>
    </div>
</div>
<div class="col-sm-6">
    <?php echo $form->textAreaRow($model, 'pesandistruk', array('rows' => 3, 'cols' => 10, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($model, 'pesandifaktur', array('rows' => 3, 'cols' => 10, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'formulajasadokter', array('class' => 'span2', 'style' => 'width:40px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'formulajasaparamedis', array('class' => 'span2', 'style' => 'width:40px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'hargaygdigunakan', array('class' => 'span2', 'style' => 'width:60px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <?php echo $form->textFieldRow($model, 'pembulatanharga', array('class' => 'span2 numbersOnly', 'style' => 'width:40px;', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->checkBoxRow($model,'konfigfarmasi_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);"));
    ?>

</div>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/konfigfarmasiK/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('gudangFarmasi.views.tips.tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Konfigurasi Farmasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangFarmasi/presentasiHargaJual/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('angka', "
$(document).ready(function () {
        $('.numbersOnly').keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode
                if ((charCode >= 48 && charCode <= 57)
                        || charCode == 46
                        || charCode == 44)
                        return true;
                return false;
        });
});
", CClientScript::POS_HEAD); ?>
