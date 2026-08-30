<div class="col-sm-12">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'id' => 'uubahKelPenyakit-form',
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
    <?php echo $form->errorSummary(array($model, $modUbahPerawat)); ?>
    <?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true)); ?>
    <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('readonly' => true, 'class' => 'span4',)); ?>
    <div class="control-group">
        <?php echo CHtml::label('Nama Pasien', 'np', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('np', 'np', array('readonly' => true, 'class' => 'span4',)); ?>
        </div>
    </div>
    <?php
    echo $form->dropDownListRow(
        $model,
        'ruangan_id',
        CHtml::listData($model->getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
        array('empty' => '-- Pilih --', 'disabled' => 'disabled', 'class' => 'span4',)
    );
    ?>
    <div class="control-group">
        <?php echo CHtml::label('Perawat Lama', 'dp', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('dp', 'dp', array('readonly' => true, 'class' => 'span4',)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Perawat Baru', 'db', array('class' => 'control-label')) ?>
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
                array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required')
            );
            ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alasan Perubahan', 'ap', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modUbahPerawat,
                'alasanperubahanperawat',
                LookupM::getItems('alasanperubahanperawat'),
                array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required',)
            ); ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'k', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modUbahPerawat, 'perawatlama_id', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textArea($modUbahPerawat, 'keterangan', array('placeholder' => 'Keterangan', 'rows' => 2, 'cols' => 60, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
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