<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapenjamin-pasien-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'carabayar_id'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id',  CHtml::listData($model->CarabayarItems, 'carabayar_id', 'carabayar_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penjamin_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penjamin_nama', array('placeholder' => 'Nama Penjamin', 'class' => 'span3',  'onkeyup' => 'namaLain(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 150)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penjamin_namalainnya', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penjamin_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 150)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penjamin_cp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penjamin_cp', array('placeholder' => 'Contact Person', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penjamin_nomobile', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penjamin_nomobile', array('placeholder' => 'No. Telepon', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'lama_tempo', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'lama_tempo', array('class' => 'span1 integer2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> Hari
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'path_logoasuransi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'path_logoasuransi', array('accept' => 'image/*', 'maxlength' => 150)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'lampiranpks', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'lampiranpks', array('accept' => '.pdf', 'maxlength' => 150)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'penjamin_aktif', array('checked' => 'penjamin_aktif')); ?>
                <label for="SAPenjaminPasienM_penjamin_aktif">Aktif</label>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diskon_tagihan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diskon_tagihan', array('group' => 'group1', 'class' => 'span2 float2', 'onkeyup' => 'validDesimal(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> %
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diskon_klaim', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diskon_klaim', array('group' => 'group1', 'class' => 'span2 float2', 'onkeyup' => 'validDesimal(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> %
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diskon_rj', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diskon_rj', array('group' => 'group1', 'class' => 'span2 float2', 'onkeyup' => 'validDesimal(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> %
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diskon_ri', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diskon_ri', array('group' => 'group1', 'class' => 'span2 float2', 'onkeyup' => 'validDesimal(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> %
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diskon_rd', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diskon_rd', array('group' => 'group1', 'class' => 'span2 float2', 'onkeyup' => 'validDesimal(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> %
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'biaya_administrasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'biaya_administrasi', array('class' => 'span2 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> %
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kode COB INACBG', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kode_cob_inacbg', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama COB INACBG', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_cob_inacbg', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/PenjaminPasienMAS/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<script>
    function namaLain(nama) {
        document.getElementById('SAPenjaminPasienM_penjamin_namalainnya').value = nama.value.toUpperCase();
    }

    // untuk validasi agar inputan tidak lebih dari 100
    function validDesimal(obj) {
        //console.log($(obj).val());
        var data = $(obj).val().replace('.', '');
        data = data.replace(',', '.')
        //console.log(parseFloat(100));
        //console.log(parseFloat(data));

        if (parseFloat(data) > parseFloat(100)) {
            alert("Data tidak bisa lebih dari 100,00");
            $(obj).val(0);
        } else {
            console.log("data tidak masuk");
        }

    }

    $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
    });
</script>