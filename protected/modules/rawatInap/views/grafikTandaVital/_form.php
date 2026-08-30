<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'grafiktandavital-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
    ));
    $visibility = isset($_GET['lihat']) ? 'hidden' : '';
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<div class="row-fluid">

    <div class = "col-sm-6">

        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_monitoring', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_monitoring',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'col-sm-8',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'jam_monitoring', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo $form->textField($model, 'jam_monitoring', array('class' => 'span1 integer', 'onkeyup' => "setJam(this);")); ?>
            </div>
        </div>

        

        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pernapasan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pernapasan', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label>x/Menit</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'suhu', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'suhu', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label>&deg;C</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'nadi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nadi', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label>x/Menit</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'td_systolic', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'td_systolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label>mm</label>
                <?php echo $form->textField($model, 'td_dyastolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label>Hg</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php
                echo CHtml::textField('tekanan_darah', '', array(
                    'class' => 'span2', 'disabled' => true,
                ));
                ?>
            </div>
        </div>


    </div>
    <div class = "col-sm-6">
        <?php echo $form->textFieldRow($model, 'mosokomial', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'berat_badan', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'tinggi_badan', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'bab', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'cairan_masuk', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'cairan_keluar', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($model, 'keterangan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group ">
            <?php echo CHtml::activeLabel($model, 'petugaspengisi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'petugaspengisi_nama',
                    'value' => '',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/pegawaiRuanganPI'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.namaLengkap);

                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                $("#' . CHtml::activeId($model, 'petugaspengisi_id') . '").val(ui.item.pegawai_id);
                                $(this).val(ui.item.namaLengkap);
                            }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'size' => 20,
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPegawaiDialog'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'petugaspengisi_id'); ?>

    </div>
</div>
<div class="row-fluid">
    <div class="form-actions" <?= $visibility ?>>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
            $this->createUrl('create', array('id'=>$model->pendaftaran_id)),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
        ?>
        <?php
        // echo CHtml::link(Yii::t('mds', '{icon} Print',
        //         array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')),
        //     'javascript:void(0);', array('class' => 'btn btn-info',
        //     'onclick' => "print(" . $model->pendaftaran_id . ");return false")) . "&nbsp;";
        ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian <span id="kelpeg">Dokter</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modDokter = new PegawairuanganV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modDokter->pegawai_aktif = TRUE;
if (isset($_GET['PegawairuanganV'])) {
    $modDokter->attributes = $_GET['PegawairuanganV'];
    $modDokter->pegawai_aktif = TRUE;
}

$prov = $modDokter->search();
$prov->sort->defaultOrder = 'nama_pegawai';


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $prov,
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                    $(\"#' . CHtml::activeId($model, 'petugaspengisi_nama') . '\").val(\"$data->namaLengkap\");
                    $(\"#' . CHtml::activeId($model, 'petugaspengisi_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#dialogPegawai\").dialog(\"close\");
                    return false;"
                ))',
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama',
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>

function setJam(obj) {
    
    var jam = parseInt($(obj).val());
    if(jam >= 0 && jam <= 23) {
        console.log("nilai: " + $(obj).val());

    } else {
        myAlert("Jam monitoring tidak valid");
        $(obj).val('');
        console.log("nilai1: " + $(obj).val());
    }
}

$(".float2").maskMoney(
	{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":"","precision":2}
);
</script>
