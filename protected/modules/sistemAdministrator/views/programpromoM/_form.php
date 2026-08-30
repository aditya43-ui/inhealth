<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saprogram-promo-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'enctype' => 'multipart/form-data',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#SAProgrampromoM_namaprogrampromo',
)); ?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldRow($model, 'namaprogrampromo', array('placeholder' => 'Nama Program Promo', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo $form->labelex($model, 'Deskripsi <span class="required">*</span>', array('class' => "control-label required")) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'deskripsi', array('placeholder' => 'Deskripsi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'keterangan', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'gambarpromo', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event)")) ?>
            <?php if (!empty($model->gambarpromo)) { ?>
                <img src="<?php echo Params::urlPromoDirectory() . $model->gambarpromo ?> " style="width: 20%;padding:10px;display: block;">
            <?php } else {
                echo "<span style='padding:10px 25px;'> Gambar Promo Belum Diset</span>";
            } ?>
            <div class="controls">
                <?php echo Chtml::activeFileField($model, 'gambarpromo', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Gambar Promo')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-floppy"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="fa fa-refresh"></i>')),
        Yii::app()->createUrl($this->module->id . '/Programpromo/admin'),
        array(
            'class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );  ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Program Promo', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('ProgrampromoM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAProgrampromoM_namalainnya').value = nama.value.toUpperCase();
    }
</script>