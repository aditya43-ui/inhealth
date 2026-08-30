<style>
    .balance_panel input {
        text-align: right;
    }
</style>

<?php echo $this->renderPartial($this->path_view . "_riwayat", array('model' => $model), true); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kardeks-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<?php echo $form->textFieldRow($model, 'pemeriksaan_ke', array('readonly' => true, 'class' => 'span1', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'tgl_pemeriksaan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'tgl_pemeriksaan',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
            ),
            'htmlOptions' => array(
                'readonly' => true,
                'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        ));
        ?>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Hemodinamik
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label">Irama EKG</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'iramaekg', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tekanan Darah</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'hemo_dewasa_sistol', array('class' => 'span1 numbers-only txt_mmhg hemo_dewasa_sistol', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                    <label>mm /</label>
                    <?php echo $form->textField($model, 'hemo_dewasa_diastol', array('class' => 'span1 numbers-only txt_mmhg hemo_dewasa_diastol', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                    <label>Hg</label><br>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->textField($model, 'hemo_dewasa_map', array('class' => 'hemo_map', 'readonly' => true, 'style' => 'width: 60px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <label>mm/Hg</label>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::Label('', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::textField('tekananDarah', '', array('class' => 'span3 tekandarah', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Mean Arteri Pressure</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'hemo_dewasa_map2', array('class' => 'hemo_map2 span3  integer numbersOnly', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'hemo_dewasa_nadi', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
            <?php echo $form->textFieldRow($model, 'hemo_dewasa_rr', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'hemo_dewasa_suhu', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'hemo_dewasa_suhu', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                    <label>&#8451;</label>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'hemo_dewasa_spo2', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
            <?php echo $form->textFieldRow($model, 'hemo_dewasa_cvp', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'hemo_anak_suhuinkubator', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'hemo_anak_suhuinkubator', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <label>&#8451;</label>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_retraksi', LookupM::getItemsUrutan('hemo_anak_retraksi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_sianosis', LookupM::getItemsUrutan('hemo_anak_sianosis'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_grunting', LookupM::getItemsUrutan('hemo_anak_grunting'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_warnakulit', LookupM::getItemsUrutan('hemo_anak_warnakulit'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_tonusotot', LookupM::getItemsUrutan('hemo_anak_tonusotot'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_hisaplendir', LookupM::getItemsUrutan('hemo_anak_hisaplendir'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_udema', LookupM::getItemsUrutan('hemo_anak_udema'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_perut', LookupM::getItemsUrutan('hemo_anak_perut'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model, 'hemo_anak_aktifitas', LookupM::getItemsUrutan('hemo_anak_aktifitas'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">SSP</div>
            <div class="panel-config" style="padding-top: 7px; margin-left: 20px;">
                <?php echo $form->radioButtonList($model, 'kardeks_dewasa', array(1 => "Dewasa/Anak", 0 => "Bayi"), array(
                    'template' => '<span style="margin-right: 20px;">{input}{label}</span>',
                    'class' => 'cb_pilih_hemo',
                )); ?>
            </div>
        </div>
        <div class="panel-body">
            <?php

            echo $this->renderPartial($this->path_view . "_gcs", array(
                'form' => $form,
                'model' => $model,
            ), true);

            ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'ssp_pupilka_ukuran', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'ssp_pupilka_ukuran', LookupM::getItemsUrutan('ssp_pupilka_ukuran'), array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <label> Reaksi :</label>
                    <?php echo $form->radioButtonList($model, 'ssp_pupilka_reaksi', array('+' => '<i class="icon-plus icon-white"></i>', '-' => '<i class="entypo-minus"></i>'), array(
                        'template' => '{input}{label}&nbsp;'
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'ssp_pupilki_ukuran', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'ssp_pupilki_ukuran', LookupM::getItemsUrutan('ssp_pupilki_ukuran'), array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    <label> Reaksi :</label>
                    <?php echo $form->radioButtonList($model, 'ssp_pupilki_reaksi', array('+' => '<i class="icon-plus icon-white"></i>', '-' => '<i class="entypo-minus"></i>'), array(
                        'template' => '{input}{label}&nbsp;'
                    )); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'ssp_kejang', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Respirasi VENT dan AGD</div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'vent_pola', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_tidal', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_pspapasb', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_peep', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_rr', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_fio2', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_time_infirasi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_time_eksfirasi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

            </div>
            <div class="col-sm-6">
                <?php echo $form->radioButtonListRow($model, 'vent_sputum', array('1' => 'Ya', '0' => 'Tidak'), array(
                    'template' => '{input}{label}&nbsp;'
                )); ?>
                <?php echo $form->textFieldRow($model, 'vent_ph', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_pco2', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_po2', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_tco2', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_be', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_hco3', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'vent_o2saturasi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>

        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Medika Mentosa
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($model, 'medika_bolus', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'medika_oral', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'medika_infus', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'medika_lainlain', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Output
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($model, 'output_urine', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'output_muntah', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'output_bab', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'output_pendarahan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'output_drain', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Nutrisi
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->textAreaRow($model, 'nutrisi_enternal', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'nutrisi_parental', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Balance Cairan
            </div>
        </div>
        <div class="panel-body">
            <div class="balance_panel" id="balance_dewasa" data-judul="Dewasa/Anak">
                <?php echo $this->renderPartial($this->path_view . 'balance_cairan._dewasa', array('form' => $form, 'model' => $model), true); ?>
            </div>
            <div class="balance_panel" id="balance_anak" data-judul="Anak">
                <?php echo $this->renderPartial($this->path_view . 'balance_cairan._anak', array('form' => $form, 'model' => $model), true); ?>
            </div>
            <div class="balance_panel" id="balance_neonatus" data-judul="Neonatus">
                <?php echo $this->renderPartial($this->path_view . 'balance_cairan._neonatus', array('form' => $form, 'model' => $model), true); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    if ($model->isNewRecord) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('create'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
    } else {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('create', array('pendaftaran_id' => $model->pendaftaran_id)),
            array('class' => 'btn btn-danger')
        );
    }
    echo " " . CHtml::link('Preview', $this->createUrl('view', array('pendaftaran_id' => $model->pendaftaran_id)), array(
        'class' => 'btn btn-info',
    ));
    ?>
    <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan KardeksT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat diagnosa tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogGcs',
    'options' => array(
        'title' => 'Tambah GCS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 350,
        'height' => 300,
        'resizable' => false,
    ),
));
?>
<form id="form_gcs" class="form-horizontal">
    <div class="control-group">
        <label class="control-label">Singkatan</label>
        <div class="controls">
            <?php echo CHtml::textField('form_gcs[metodegcs_singkatan]', null, array('id' => 'form_gcs_metodegcs_singkatan', 'readonly' => true, 'class' => 'span1')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nama</label>
        <div class="controls">
            <?php echo CHtml::textArea('form_gcs[metodegcs_nama]', null, array('id' => 'form_gcs_metodegcs_nama', 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nilai</label>
        <div class="controls">
            <?php echo CHtml::textField('form_gcs[metodegcs_nilai]', null, array('id' => 'form_gcs_metodegcs_nilai', 'class' => 'span2 numbers-only')); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton('Simpan', array('class' => 'btn btn-danger', 'onclick' => 'tambahGCS();', 'id' => 'form_gcs_submit')); ?>
    </div>
</form>

<?php
$this->endWidget();
//========= end diagnosa tindakan =============================
?>

<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model), true); ?>