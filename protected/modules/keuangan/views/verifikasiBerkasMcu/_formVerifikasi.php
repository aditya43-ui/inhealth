<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'dataverifikasi-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )
);
?>
<fieldset class="box" id="form-databerkas">
    <legend class="rim">Data Berkas</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'nosurat_rs', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nosurat_rs', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'namarumahsakit', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'namarumahsakit', array('class' => 'span4')); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglberkasmcumasuk', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tglberkasmcumasuk = (!empty($model->tglberkasmcumasuk) ? date('d/m/Y H:i:s',  strtotime($model->tglberkasmcumasuk)) : null);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglberkasmcumasuk',
                            'mode' => 'datetime',
                            'options' => array(
                                'showOn' => false,
                                'maxDate' => 'd',
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2 datetimemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'totaltagihanmcu', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'totaltagihanmcu', array('class' => 'span2 integer', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="box" id="form-dataverifikasi">
    <legend class="rim">Verifikasi Berkas</legend>
    <div class="row">
        <div class="span3">
            <?php echo $form->checkBoxRow($model, 'berkas_1', array('class' => 'inputFormTabel lebar1')); ?>
            <?php echo $form->checkBoxRow($model, 'berkas_2', array('class' => 'inputFormTabel lebar1')); ?>
            <?php echo $form->checkBoxRow($model, 'berkas_3', array('class' => 'inputFormTabel lebar1')); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->radioButtonListInlineRow($model, 'statusverifikasiberkas', LookupM::getItems('statusberkasmcu'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setJatuhTempo(this);')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglverifikasiberkasmcu', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tglverifikasiberkasmcu = (!empty($model->tglverifikasiberkasmcu) ? date('d/m/Y H:i:s',  strtotime($model->tglverifikasiberkasmcu)) : null);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglverifikasiberkasmcu',
                        'mode' => 'datetime',
                        'options' => array(
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'class' => 'dtPicker2 datetimemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tgljatuhtempo', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tgljatuhtempo = (!empty($model->tgljatuhtempo) ? date('d/m/Y H:i:s',  strtotime($model->tgljatuhtempo)) : null);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgljatuhtempo',
                        'mode' => 'datetime',
                        'options' => array(
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'class' => 'dtPicker2 datetimemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="span3"></div>
    </div>
</fieldset>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onkeypress' => 'verifikasi();', 'onclick' => 'verifikasi();'));
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onClick' => 'closeDialog();')
    );
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function closeDialog() {
        $('#dialogVerifikasiBerkas').dialog('close');
    }

    function setJatuhTempo(obj) {
        var status = obj.value;
        var tglverifikasi = $('#<?php echo CHtml::activeId($model, 'tglverifikasiberkasmcu'); ?>').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setJatuhTempo'); ?>',
            data: {
                status: status,
                tglverifikasi: tglverifikasi
            },
            dataType: "json",
            success: function(data) {
                $('#<?php echo CHtml::activeId($model, 'tgljatuhtempo'); ?>').val(data.tgl_jatuhtempo);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran)); ?>