<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'monitoringgiziranap-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'asesmengizi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'instalasi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'ahligiziranap_id', array('id' => 'ahligiziranap_id', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Asuhan Gizi
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-border table-condensed">
            <thead>
                <tr>
                    <th>Tgl. Asasmen</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo MyFormatter::formatDateTimeForUser($asesmen->tgl_konsultasi); ?></td>
                    <td style="text-align: center;"><?php echo CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('asesmenGiziRI/detail', array(
                                                        'pendaftaran_id' => $model->pendaftaran_id,
                                                        'pasienadmisi_id' => $model->pasienadmisi_id,
                                                    )), array(
                                                        'target' => 'frameDetailAsuhan',
                                                        'onclick' => "$('#dialogDetailAsuhan').dialog('open');",
                                                    )); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Monitoring</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . "_listMonitoringGizi", array(
            'model' => $model,
        ), true); ?>
    </div>
</div>
<br>
<div class="panel panel-dark">
    <span class="group-title">
        Monitoring dan Evaluasi Asuhan Gizi
    </span>
    <div class="panel-body" id="form-partografkontrol">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($model, 'tglmonitoringgizi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglmonitoringgizi',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>

        </div>
        <!-- ./col -->

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Ahli Gizi", 'pegawai_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $peg = PegawaiM::model()->findByPk($model->ahligiziranap_id);

                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'ahligizi_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/ActionAutoComplete/autocompleteAhliGizi') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $("#ahligizi_nama").val(ui.item.label);
                                $("#ahligiziranap_id").val(ui.item.value);                                    
                                return false;
                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogAhliGizi'),
                        'htmlOptions' => array('class' => 'span3 required', 'id' => 'ahligizi_nama')
                    ));
                    ?>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($model, 'dietintake', array('class' => 'control-label', 'label' => 'Terapi Gizi/Diet')) ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'dietintake', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($model, 'rencanapenatalaksanaan_diet', array('class' => 'control-label', 'label' => 'Asupan/Intake Makanan')) ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'rencanapenatalaksanaan_diet', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($model, 'antropometri', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'antropometri', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </div>
            </div>
            <div>
                <?php echo $form->label($model, 'laboratorium', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'laboratorium', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($model, 'fisik_klinis', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'fisik_klinis', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </div>
            </div>
            <div>
                <?php echo $form->label($model, 'lainlain', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'lainlain', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </div>
            </div>
        </div>
        <div class="clear">
        </div>
    </div>
</div>

<br>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan MonitoringgiziranapT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
<?php $this->endWidget(); ?>


<?php
//=============================== Dialog AHLI GIZI =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogAhliGizi',
        'options' => array(
            'title' => 'Ahli Gizi',
            'autoOpen' => false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modAhliGizi = new PegawaiV('search');
$modAhliGizi->unsetAttributes();
$modAhliGizi->ruangan_id = Params::RUANGAN_ID_GIZI;
$modAhliGizi->jabatan_id = Params::JABATAN_ID_AHLI_GIZI;
$modAhliGizi->pegawai_aktif = true;

if (isset($_GET['PegawaiV'])) {
    $modAhliGizi->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modAhliGizi->search(),
    'filter' => $modAhliGizi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => ""
                        . "$(\"#ahligizi_nama\").val(\"" . $data->namaLengkap . "\");
                        $(\"#ahligiziranap_id\").val(\"" . $data->pegawai_id . "\");"
                        . "$(\"#dialogAhliGizi\").dialog(\"close\");"
                        . "; return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END AHLI GIZI =======================================

$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDetailAsuhan',
        'options' => array(
            'title' => 'Detail Asuhan Gizi',
            'autoOpen' => false,
            'width' => 840,
            'height' => 500,
            'resizable' => true,
        ),
    )
);
?>
<iframe name='frameDetailAsuhan' style="width: 100%; height: 98%;"></iframe>
<?php

$this->endWidget();
?>