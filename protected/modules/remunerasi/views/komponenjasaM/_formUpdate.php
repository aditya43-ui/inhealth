<legend class="rim">Update Komponen Jasa </legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'komponenjasa-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model, 'komponentarif_id', CHtml::listData($model->getKomponentarifItems(), 'komponentarif_id', 'komponentarif_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')) ?>
            <?php //golongan
            echo $form->dropDownListRow(
                $model,
                'jenistarif_id',
                CHtml::listData($model->getJenistarifItems(), 'jenistarif_id', 'jenistarif_nama'),
                array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/ActionDynamic/GetCaraBayar', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => "#" . CHtml::activeId($model, 'carabayar_id'),
                    ),
                    //    'onchange'=>"setClearBidang();setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",
                )
            ); ?>

            <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCarabayarItems(), 'carabayar_id', 'carabayar_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')) ?>


            <?php echo $form->dropDownListRow($model, 'kelompoktindakan_id', CHtml::listData($model->getKelompoktindakanItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model, 'komponenjasa_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
            <?php echo $form->textFieldRow($model, 'komponenjasa_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'komponenjasa_singkatan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            <?php echo $form->textFieldRow($model, 'besaranjasa', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model, 'potongan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'jasadireksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'kuebesar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'jasadokter', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'jasaparamedis', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'jasaunit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'jasabalanceins', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'jasaemergency', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'biayaumum', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->checkBoxRow($model, 'komponenjasa_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/komponenjasaM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Komponen Jasa', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>