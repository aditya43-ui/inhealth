<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfpbf-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'pbf_kode'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pbf_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'pbf_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pbf_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'pbf_alamat', array('placeholder' => 'Alamat', 'rows' => 4, 'cols' => 50, 'class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <?php echo $form->dropDownListRow(
            $model,
            'pbf_propinsi',
            CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'),
            array(
                'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'empty' => '-- Pilih --',
            )
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'pbf_kabupaten',
            CHtml::listData($model->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'),
            array(
                'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'empty' => '-- Pilih --',
            )
        ); ?>
        <div>
            <?php echo $form->checkBoxRow($model, 'pbf_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan PBF', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>