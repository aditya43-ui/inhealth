<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bataljadwal-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert');
echo $form->errorSummary(array($modBatal));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien dan Penjadwalan Rehab Medis Sebelumnya</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <?php echo CHtml::hiddenField('jadwalrehabmedis_id', $modJadwal->jadwalrehabmedis_id); ?>
            <?php echo CHtml::hiddenField('jadwalrehabmedis_tgl_ke', $modJadwal->jadwalrehabmedis_tgl_ke); ?>
            <?php echo CHtml::hiddenField('pasien_id', $modPasien->pasien_id); ?>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?> </td>
                <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('disabled' => 'disabled', 'class' => 'span3')) ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::label('Hari', '', array('class' => 'control-label')); ?> </td>
                <td><?php echo CHtml::activeTextField($modJadwal, 'jadwalrehabmedis_hari', array('disabled' => 'disabled', 'class' => 'span3')) ?></td>

                <td><?php echo CHtml::label('Shift', '', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modJadwal, 'shift_id', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modJadwal, 'jadwalrehabmedis_tgl_ke_2', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>

                <td><?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modJadwal, 'ruangan_id', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Alasan Pembatalan Jadwal Rehab Medis
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modBatal, 'bataljadwalrh_tgl', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modBatal,
                            'attribute' => 'bataljadwalrh_tgl',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'minDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => 'dtPicker3 span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modBatal, 'bataljadwalrh_alasan', array('placeholder' => 'Alasan', 'class' => 'span3')); ?>
            </div>
            <div class="col-sm-6">

                <?php echo $form->textAreaRow($modBatal, 'bataljadwalrh_desc', array('placeholder' => 'Deskripsi', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $modBatal->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php
            // echo CHtml::htmlButton(
            //     Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            //     array('title' => 'Batal', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin membatalkan ini?","Perhatian!",function(r){if(r) parent.location.reload();});')
            // );
            ?>
        </div>
    </div>
</div>

<?php
$this->endWidget();
if ($tersimpan == 'Ya') {
?>
    <script>
        parent.location.reload();
    </script>
<?php
}
?>