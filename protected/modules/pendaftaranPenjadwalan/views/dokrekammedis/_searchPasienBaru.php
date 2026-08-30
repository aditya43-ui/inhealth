<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model, 'tglrekammedis', array('class' => 'span3')); 
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglrekammedis', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $model->tgl_rekam_medik = $format->formatDateTimeForUser($model->tgl_rekam_medik); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_rekam_medik',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'form-control span2',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php $model->tgl_rekam_medik = $format->formatDateTimeForDb($model->tgl_rekam_medik); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'form-control span3 numbers-only', 'maxlength' => 6, 'placeholder' => 'No. Rekam Medik Awal', 'style' => 'text-align:right;')); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'form-control span3 hurufs-only', 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'form-control span3 angkahuruf-only', 'maxlength' => 20, 'placeholder' => 'No. Pendaftaran')); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'statusrekammedis',
            LookupM::getItems('statusrekammedis'),
            array('empty' => '-- Pilih --', 'class' => 'span3  form-control', 'maxlength' => 10)
        ); ?>

    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Sampai dengan</label>
            <?php // echo $form->labelEx($model, 'tgl_rekam_medik_akhir', array('class' => 'control-label')) 
            ?>
            <div class="controls">
                <?php $model->tgl_rekam_medik_akhir = $format->formatDateTimeForUser($model->tgl_rekam_medik_akhir); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_rekam_medik_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'form-control span2',),
                ));
                ?>
                <?php $model->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($model->tgl_rekam_medik_akhir); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Sampai dengan</label>
            <div class="controls">
                <?php echo $form->textField($model, 'no_rekam_medik_akhir', array('class' => 'form-control span3 numbers-only', 'maxlength' => 6, 'placeholder' => 'No. Rekam Medik Akhir', 'style' => 'text-align:right;')); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama"), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 form-control', 'onchange' => 'getRuangan();')); ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama"), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 form-control', 'maxlength' => 50)); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function getRuangan() {
        var value = $('#<?php echo CHtml::activeId($model, 'instalasi_id'); ?>').val();
        if (jQuery.isNumeric(value)) {
            $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {
                instalasi_id: value
            }, function(data) {
                $('#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>').html('<option value="">-- Pilih --</option>' + data.dropDown);
            }, 'json');
        } else {

        }
    }
</script>