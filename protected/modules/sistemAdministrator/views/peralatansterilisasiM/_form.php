<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'peralatansterilisasi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'peralatansterilisasi_nama', array('placeholder' => 'Nama Peralatan Sterilisasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'peralatansterilisasi_namalain', array('placeholder' => 'Nama Lain Peralatan Sterilisasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'peralatansterilisasi_jml', array('placeholder' => 'Jumlah Peralatan Steriliasi', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Peralatan', 'jenisperalatan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisperalatan', LookupM::getItems('jenisperalatan'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'peralatansterilisasi_maks', array('placeholder' => '00', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo CHtml::label("Gambar Peralatan Sterilisasi", 'pathgbr', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'peralatansterilisasi_pathgbr', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan File lampiran')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'peralatansterilisasi_reuse', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'peralatansterilisasi_reuse', array('rel' => 'tooltip', 'title' => 'Klik untuk memilih peralatan sterilisasi yang dapat di-re use', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label for="SAPeralatansterilisasiM_peralatansterilisasi_reuse">Aktif</label>
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
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Peralatan Sterilisasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>