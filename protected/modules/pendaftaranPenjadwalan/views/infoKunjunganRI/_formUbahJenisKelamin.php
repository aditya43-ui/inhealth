<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-user"></i> Data <b>Jenis Kelamin</b>
        </div>
    </div>
    <div class="panel-body">-->
<div class="col-sm-12">
    <?php
    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'id' => 'ubahJenisKelamin-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )
    );
    ?>
    <p class="help-block">
        <?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?>
    </p>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model, 'pasien_id', array('readonly' => true)); ?>
    <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('readonly' => true)); ?>
    <?php echo $form->textFieldRow($model, 'nama_pasien', array('readonly' => true)); ?>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Kelamin', 'jk', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('jk', 'jk', array('readonly' => true)); ?>
        </div>
    </div>
    <?php
    echo $form->radioButtonListInlineRow(
        $model,
        'jeniskelamin',
        LookupM::getItems('jeniskelamin'),
        array('onkeypress' => "return $(this).focusNextInputField(event)")
    );
    ?>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<!--</div>
</div>-->

<script type="text/javascript">
    function loadDataPasien() {
        var noRekamMedik = $('#temp_norekammedik').val();
        $.post("<?php echo $this->createUrl('cariPasien') ?>", {
                norekammedik: noRekamMedik
            },
            function(data) {
                $('#PasienM_no_rekam_medik').val(data.no_rekam_medik);
                $('#PasienM_nama_pasien').val(data.nama_pasien);
                $('#PasienM_pasien_id').val(data.pasien_id);
                $('#jk').val(data.jeniskelamin);
            }, "json");
    }
    loadDataPasien();
</script>