<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakonfigfarmasi-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-4">
        <?php // echo $form->textFieldRow($model,'tglberlaku',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>

        <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::label('Tgl. Berlaku', 'tgl_awal'); ?>
            </div>
            <div class="controls">
                <?php
                $model->tglberlaku = MyFormatter::formatDateTimeForUser($model->tglberlaku);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglberlaku',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tglberlaku')),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->checkBoxRow($model, 'konfigfarmasi_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('konfigfarmasi_aktif'))); ?>

        <?php echo $form->textFieldRow($model, 'persenppn', array('class' => 'integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persenppn'))); ?>
        <?php echo $form->textFieldRow($model, 'persenpph', array('class' => 'integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persenpph'))); ?>

        <?php echo $form->checkBoxRow($model, 'bayarlangsung', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('bayarlangsung'))); ?>

        <?php echo $form->textAreaRow($model, 'pesandistruk', array('rows' => 6, 'cols' => 50, 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('pesandistruk'))); ?>
        <?php echo $form->textAreaRow($model, 'pesandifaktur', array('rows' => 6, 'cols' => 50, 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('pesandifaktur'))); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'formulajasadokter', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('formulajasadokter'))); ?>
        <?php echo $form->textFieldRow($model, 'formulajasaparamedis', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('formulajasaparamedis'))); ?>

        <?php echo $form->dropDownListRow($model, 'hargaygdigunakan', LookupM::getItems('hargaygdigunakan'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hargaygdigunakan'))); ?>

        <?php echo $form->textFieldRow($model, 'pembulatanharga', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('pembulatanharga'))); ?>

        <?php echo $form->textFieldRow($model, 'ri_persjualppn', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ri_persjualppn'))); ?>
        <?php echo $form->textFieldRow($model, 'rd_persjualppn', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('rd_persjualppn'))); ?>
        <?php echo $form->textFieldRow($model, 'rj_persjualppn', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('rj_persjualppn'))); ?>

        <?php echo $form->textFieldRow($model, 'nilai_vital', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ri_persjualppn'))); ?>
        <?php echo $form->textFieldRow($model, 'nilai_esensial', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('rd_persjualppn'))); ?>
        <?php echo $form->textFieldRow($model, 'nilai_nonesensial', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('rj_persjualppn'))); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'administrasi', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('administrasi'))); ?>
        <?php echo $form->textFieldRow($model, 'persjualbebas', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persjualbebas'))); ?>
        <?php echo $form->checkBoxRow($model, 'hargajualglobal', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hargajualglobal'))); ?>
        <?php echo $form->textFieldRow($model, 'persdiskpasien', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persdiskpasien'))); ?>
        <?php echo $form->checkBoxRow($model, 'otomatismargin', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('otomatismargin'))); ?>
        <?php echo $form->textFieldRow($model, 'persenmargin', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persenmargin'))); ?>
        <?php echo $form->dropDownListRow($model, 'metodeantrian', LookupM::getItems('metodeantrian'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('metodeantrian'))); ?>

        <?php echo $form->textFieldRow($model, 'nilai_a_persen', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ri_persjualppn'))); ?>
        <?php echo $form->textFieldRow($model, 'nilai_b_persen', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('rd_persjualppn'))); ?>
        <?php echo $form->textFieldRow($model, 'nilai_c_persen', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('rj_persjualppn'))); ?>

    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Farmasi', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)) . "&nbsp";
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
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