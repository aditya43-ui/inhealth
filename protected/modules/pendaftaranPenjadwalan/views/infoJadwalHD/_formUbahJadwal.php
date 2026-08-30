<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gantijadwal-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert');
echo $form->errorSummary(array($modUbah));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien dan Penjadwalan Hemodialisa Sebelumnya</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <?php echo CHtml::hiddenField('jadwalhemodialisa_id', $modJadwal->jadwalhemodialisa_id); ?>
            <?php echo CHtml::hiddenField('jadwalhemodialisa_tgl_ke', $modJadwal->jadwalhemodialisa_tgl_ke); ?>
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
                <td><?php echo CHtml::activeTextField($modJadwal, 'jadwalhemodialisa_hari', array('disabled' => 'disabled', 'class' => 'span3')) ?></td>

                <td><?php echo CHtml::label('Shift', '', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modJadwal, 'shift_id', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modJadwal, 'jadwalhemodialisa_tgl_ke_2', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>

                <td><?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modJadwal, 'ruangan_id', array('disabled' => 'disabled', 'class' => 'span3')); ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Jadwal Hemodialisa Baru</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Hari', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modJadwal, 'jadwalhari_id', CHtml::listData($modJadwal->getJadwalHariItems(), 'jadwalhari_id', 'jadwalhari_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modJadwal, 'jadwalhemodialisa_tgl_ke', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modJadwal,
                            'attribute' => 'jadwalhemodialisa_tgl_ke',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'minDate' => $modJadwal->jadwalhemodialisa_tgl_ke,
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
                <div class="control-group">
                    <?php echo CHtml::label('Shift', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modJadwal, 'shift_id', CHtml::listData($modJadwal->getShiftItems(), 'shift_id', 'shift_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modJadwal, 'ruangan_id', CHtml::listData($modJadwal->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modUbah, 'gantijadwalhd_tgl', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modUbah,
                            'attribute' => 'gantijadwalhd_tgl',
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
                <?php echo $form->textAreaRow($modUbah, 'gantijadwalhd_alasan', array('class' => 'span3',)); ?>
                <?php echo $form->textAreaRow($modUbah, 'gantijadwalhd_desc', array('class' => 'span3',)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($modUbah->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'myConfirm("Apakah Anda ingin membatalkan ini?","Perhatian!",function(r){if(r) parent.location.reload();});'));
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