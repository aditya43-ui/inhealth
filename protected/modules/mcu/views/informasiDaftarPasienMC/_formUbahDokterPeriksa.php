<div class="col-sm-12">
    <?php
    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'id' => 'ubahKelPenyakit-form',
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
    <?php echo $form->errorSummary(array($model, $modUbahDokter)); ?>
    <?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true)); ?>
    <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('readonly' => true, 'class' => 'span4',)); ?>
    <div class="control-group">
        <?php echo CHtml::label('Nama Pasien', 'np', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('np', '', array('readonly' => true, 'class' => 'span4',)); ?>
        </div>
    </div>
    <?php
    echo $form->dropDownListRow(
        $model,
        'ruangan_id',
        CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),
        array('empty' => '-- Pilih --', 'disabled' => 'disabled', 'class' => 'span4',)
    );
    ?>
    <div class="control-group">
        <?php echo CHtml::label('Dokter Lama', 'dp', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('dp', 'dp', array('readonly' => true, 'class' => 'span4',)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Dokter Baru', 'db', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList(
                $model,
                'pegawai_id',
                CHtml::listData(
                    $model->getDokterItems($model->ruangan_id),
                    'pegawai_id',
                    'nama_pegawai'
                ),
                array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")
            );
            ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alasan Perubahan', 'ap', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modUbahDokter,
                'alasanperubahandokter',
                LookupM::getItems('alasanperubahandokter'),
                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4', 'style' => 'float:left; width:220px')
            ); ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'k', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modUbahDokter, 'dokterlama_id', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textArea($modUbahDokter, 'keterangan', array('placeholder' => 'Keterangan', 'rows' => 2, 'cols' => 60, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
        ?>
        <?php
        // echo CHtml::htmlButton(
        //     Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        //     array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onClick' => 'closeDialog();')
        // );
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>