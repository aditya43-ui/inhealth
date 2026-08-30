<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Hukum Disiplin berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'data-riwayat',
    'content' => array(
        'content-datariwayat' => array(
            'header' => '<b>Riwayat Hukum Disiplin</b>',
            'isi' => $this->renderPartial('_riwayat', array(), true),
            'active' => false,
        ),
    ),
));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<?php echo $form->errorSummary($model); ?>
<fieldset class="box" id="tableHukdisiplin">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Hukuman Disiplin <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="row">
                <div class="col-sm-6">
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $modHukdisiplin->pegawai_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                    <?php echo $form->dropDownListRow($modHukdisiplin, 'jnshukdisiplin_id', CHtml::listData($modHukdisiplin->getJnshukdisiplinItems(), 'jnshukdisiplin_id', 'jnshukdisiplin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
                    <?php echo $form->dropDownListRow($modHukdisiplin, 'hukdisiplin_jabatan', CHtml::listData($modHukdisiplin->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), array('class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'empty' => '-- Pilih ')) ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modHukdisiplin, 'hukdisiplin_tglhukuman', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modHukdisiplin,
                                'attribute' => 'hukdisiplin_tglhukuman',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($modHukdisiplin, 'hukdisiplin_ruangan', CHtml::listData($modHukdisiplin->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
                    <?php echo $form->textFieldRow($modHukdisiplin, 'hukdisiplin_nosk', array('class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modHukdisiplin, 'hukdisiplin_lama', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modHukdisiplin, 'hukdisiplin_lama', array('class' => 'span1', 'onkeypress' => 'return $(this).focusNextInputField(event)')) . ' &nbsp;';  ?><?php echo $form->dropDownList(
                                                                                                                                                                                                            $modHukdisiplin,
                                                                                                                                                                                                            'hukdisiplin_satuanlama',
                                                                                                                                                                                                            LookupM::getItems('hukdisiplin_satuanlama'),
                                                                                                                                                                                                            array('class' => 'span2', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                                                                                                                                                                                                        ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textAreaRow($modHukdisiplin, 'hukdisiplin_keterangan', array('rows' => 4, 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modHukdisiplin, 'hukdisiplin_mengetahui_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modHukdisiplin, 'hukdisiplin_mengetahui_id', array('readonly' => true)); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modHukdisiplin,
                                'attribute' => 'pegawaimengetahui_nama',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $("#' . Chtml::activeId($modHukdisiplin, 'hukdisiplin_mengetahui_id') . '").val(ui.item.pegawai_id); 
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'span3 pegawaimengetahui_nama',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modHukdisiplin, 'hukdisiplin_mengetahui_id') . '").val(""); '
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modHukdisiplin, 'hukdisiplin_mengetahui_tgl', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modHukdisiplin,
                                'attribute' => 'hukdisiplin_mengetahui_tgl',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modHukdisiplin, 'hukdisiplin_menyetujui_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modHukdisiplin, 'hukdisiplin_menyetujui_id', array('readonly' => true)); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modHukdisiplin,
                                'attribute' => 'pegawaimenyetujui_nama',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $("#' . Chtml::activeId($modHukdisiplin, 'hukdisiplin_menyetujui_id') . '").val(ui.item.pegawai_id); 
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'span3 pegawaimenyetujui_nama',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modHukdisiplin, 'hukdisiplin_menyetujui_id') . '").val(""); '
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modHukdisiplin, 'hukdisiplin_menyetujui_tgl', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modHukdisiplin,
                                'attribute' => 'hukdisiplin_menyetujui_tgl',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitHukdisiplin')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            '#',
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['KPPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiMengetahui(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($modHukdisiplin, 'hukdisiplin_mengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($modHukdisiplin, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pencarian Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMenyetujui = new KPPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['KPPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['KPPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchPegawaiMenyetujui(),
    'filter' => $modPegawaiMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($modHukdisiplin, 'hukdisiplin_menyetujui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($modHukdisiplin, 'pegawaimenyetujui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>

<?php
$this->endWidget();
$urlGetHukdisiplin = $this->createUrl('GetHukdisiplin');
$pegawai_id = $_GET['pegawai_id'];
$js = <<< JS

function Hukdisiplindata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetHukdisiplin}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatHukdisiplin").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewRiwayatHukdisiplin() {
    
    if ($("#cekRiwayatHukdisiplin").is(":checked")) {
        Hukdisiplindata();
        $("#tableRiwayatHukdisiplin").slideDown(60);
    } else {
        $("#tableRiwayatHukdisiplin").children("tbody").children("tr").remove();
        $("#tableRiwayatHukdisiplin").slideUp(60);
    }
}

$(document).ready(function(){
    Hukdisiplindata();
});

JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function hapus(obj) {
        myConfirm('Anda yakin akan menghapus item ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    url = $(obj).attr('href');
                    $(location).attr('href', url);
                }
            });

    }
</script>