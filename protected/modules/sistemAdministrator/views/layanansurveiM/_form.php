<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'layanansurvei-m-form',
    'enableAjaxValidation' => false,
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="col-md-3">
                <?php echo CHtml::label('Nama Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                <span style="color:red">*</span>
            </div>
            <div class="col-md-3">
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array('order' => 'instalasi_nama',)), 'instalasi_id', 'instalasi_nama'), array(
                        'empty' => '-- Pilih --',
                        'onchange' => "listRuangan(this.value);",
                        'ajax' => array(),
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <div class="col-md-4">
                <?php echo CHtml::label('Ask Layanan Survei', 'layanansurvei_ask', array('class' => 'control-label')) ?>
                <span style="color:red">*</span>
            </div>
            <div class="col-md-2">
                <div class="controls">
                    <?php echo $form->textField($model, 'layanansurvei_ask', array('placeholder' => 'Ask Layanan', 'class' => 'span3')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="col-md-3">
                <?php echo CHtml::label('Nama Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <span style="color:red">*</span>
            </div>
            <div class="col-md-3">
                <div class="controls">
                    <?php //echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(array('order' => 'ruangan_nama',)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')); 
                    ?>
                    <?php
                    if (!empty($model->ruangan_id)) {
                        $data = CHtml::listData(RuanganM::model()->findAll("ruangan_aktif=true and ruangan_id='" . $model->ruangan_id . "'"), 'ruangan_id', 'ruangan_nama');
                    } else {
                        $data = array();
                    }
                    echo $form->dropDownList($model, 'ruangan_id', $data, array('empty' => '-- Pilih --', 'onblur' => 'validasiKemasanBesar(this.value)', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <div class="col-md-3">
                <?php echo CHtml::label('', 'layanansurvei_aktif', array('class' => 'control-label')) ?>
            </div>
            <div class="col-md-3">
                <div class="controls">
                    <?php echo $form->checkBox($model, 'layanansurvei_aktif', array()); ?> <label>Aktif</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="col-md-3">
                <?php echo CHtml::label('Nama Layanan', 'layanansurvei_nama', array('class' => 'control-label')) ?>
                <span style="color:red">*</span>
            </div>
            <div class="col-md-3">
                <div class="controls">
                    <?php echo $form->textField($model, 'layanansurvei_nama', array('readonly' => true, 'placeholder' => 'Nama Layanan', 'class' => 'span3')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="col-md-3">
                <?php echo CHtml::label('Deskripsi Layanan ', 'layanansurvei_desc', array('class' => 'control-label')) ?>
                <span style="color:red">*</span>
            </div>
            <div class="col-sm-6">
                <div class="controls">
                    <?php echo $form->textArea($model, 'layanansurvei_desc', array('rows' => 6, 'cols' => 50, 'placeholder' => 'Deskripsi Layanan', 'class' => 'col-sm-6')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="actions">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/karcisM/admin'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Layanan Survei', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('layanansurveiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/tips', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    function listRuangan(instalasiid) {
        $.get("<?php echo Yii::app()->createUrl('actionDynamic/SetDropdownRuangannew'); ?>", {
                instalasasi: instalasiid
            },
            function(data) {
                $('#LayanansurveiM_ruangan_id').html(data.listRuangan);
            }, "json");
    }

    function validasiKemasanBesar(ruangid) {
        var ruangan_id = ruangid;
        console.log(ruangan_id);
        $.get("<?php echo Yii::app()->createUrl('actionDynamic/GetRuanganItemsnew'); ?>", {
                ruangan_id: ruangan_id
            },
            function(data) {
                $('#LayanansurveiM_layanansurvei_nama').val("Penganduan " + data.Ruangan);
            }, "json");
    }
</script>