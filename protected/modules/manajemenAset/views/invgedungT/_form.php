<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvgedung-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
    'focus' => '#',
));
?>

<div>
    <p class="help-block"style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <?php $this->renderPartial('_dataBarang', array('modBarang' => $modBarang, 'model' => $model, 'jenisAset' => '"' . ParamsConst::KODE_GOLONGAN_GEDUNG_BANGUNAN . '"')); ?>
    <?php // $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model, 'jenisAset'=>'"03"')); ?>
    <div>
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    <i class="glyphicon glyphicon-file"></i> Data Inventarisasi Gedung dan Bangunan																	
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->hiddenField($model, 'barang_id'); ?>
                        <?php echo $form->hiddenField($model, 'terimapersdetail_id'); ?>
                        <?php echo $form->hiddenField($model, 'barang_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownListRow($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($model, 'lokasi_id', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->textAreaRow($model, 'invgedung_alamat', array('rows' => 5, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'invgedung_kode', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'invgedung_noregister', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'invgedung_namabrg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'invgedung_tglguna', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'invgedung_tglguna',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:182px;'
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($model, 'invgedung_tglguna'); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'invgedung_nodokumen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        <?php echo $form->textFieldRow($model, 'invgedung_harga', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'invgedung_akumsusut', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'umurekonomis', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class="col-sm-6">

                        <?php echo $form->textFieldRow($model, 'invgedung_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'status_tanah', array('class' => 'control-label'));
                            ?>
                            <div class="controls radio-inline">
                                <?php
                                echo $form->radioButtonList($model, 'status_tanah', array('Tanah Milik Pemda' => 'Tanah Milik Pemda', 'Tanah Negara' => 'Tanah Negara', 'Tanah Hak Ulayat' => 'Tanah Hak Ulayat', 'Tanah Hak' => 'Tanah Hak(Tanah Perorangan atau Badan Hukum),<br>Hak Guna Bangunan, Hak Pakai Atau Hak Pengolahan'), array(
                                    'template' => '{input}{label}</br>',
                                    'seperator' => '',
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo CHtml::label("Kondisi Fisik Bangunan", 'kondisifisikbangunan', array('class' => 'control-label')); ?>
                            <div class="controls radio-inline">
                                <?php
                                echo $form->radioButtonList($model, 'kondisifisikbangunan', array('Baik' => 'Baik', 'Kurang Baik' => 'Kurang Baik', 'Rusak Berat' => 'Rusak Berat'), array(
                                    'template' => '{input}{label}</br>',
                                    'seperator' => '',
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'kontruksi_bangunan', array('class' => 'control-label')); ?>
                            <div class="controls radio-inline">
                                <?php
                                echo $form->radioButtonList($model, 'kontruksi_bangunan', array('Bertingkat' => 'Bertingkat', 'Tidak Bertingkat' => 'Tidak Bertingkat', 'Beton' => 'Beton', 'Bukan Beton' => 'Bukan Beton'), array(
                                    'template' => '{input}{label}</br>',
                                    'seperator' => '',
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'luas', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        <?php echo $form->textFieldRow($model, 'kd_tanah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label("Dalam Kontruksi", 'dalam_kontruksi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'dalam_kontruksi', array()); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
<!--        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    Penjurnalan																	
                </div>
            </div>
            <div class="panel-body">
                <?php // $this->renderPartial('_penjurnalan', array('model' => $model, 'form' => $form,)); 
                ?>		
            </div>
        </div>-->

    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => 'disabled'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Create'), array('class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Create') . '";} ); return false;'));
        ?>
        <?php
        $content = $this->renderPartial('tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<?php
//========= Dialog buat cari data Pemilik Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemilikBarang',
    'options' => array(
        'title' => 'Pemilik Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPemilik = new MAPemilikbarangM('search');
$modPemilik->unsetAttributes();
if (isset($_GET['MAPemilikbarangM']))
    $modPemilik->attributes = $_GET['MAPemilikbarangM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modPemilik->search(),
    'filter' => $modPemilik,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        'pemilikbarang_id',
        'pemilikbarang_kode',
        'pemilikbarang_nama',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'pemilikbarang_id') . '\").val(\'$data->pemilikbarang_id\');
                                    $(\"#pemilikNama\").val(\'$data->pemilikbarang_nama\');
                                    $(\'#dialogPemilikBarang\').dialog(\'close\');return false;"))'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Asal Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAsalAset',
    'options' => array(
        'title' => 'Asal Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modAsalAset = new MAAsalasetM('search');
$modAsalAset->unsetAttributes();
if (isset($_GET['MAAsalasetM']))
    $modAsalAset->attributes = $_GET['MAAsalasetM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modAsalAset->search(),
    'filter' => $modAsalAset,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        'asalaset_id',
        'asalaset_nama',
        'asalaset_singkatan',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'asalaset_id') . '\").val(\'$data->asalaset_id\');
                                    $(\"#asalAsetNama\").val(\'$data->asalaset_nama\');
                                    $(\'#dialogAsalAset\').dialog(\'close\');return false;"))'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Lokasi Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLokasiAset',
    'options' => array(
        'title' => 'Asal Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modLokasiAset = new MALokasiasetM('search');
$modLokasiAset->unsetAttributes();
if (isset($_GET['MALokasiasetM']))
    $modAsalAset->attributes = $_GET['MALokasiasetM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modLokasiAset->search(),
    'filter' => $modLokasiAset,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        'lokasiaset_namalokasi',
        'lokasiaset_namainstalasi',
        'lokasiaset_namabagian',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'lokasi_id') . '\").val(\'$data->lokasi_id\');
                                    $(\"#lokasiAsetNama\").val(\'$data->lokasiaset_namalokasi\');
                                    $(\'#dialogLokasiAset\').dialog(\'close\');return false;"))'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>

<script>
    function setKodeRegister(barang_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetkodeRegister'); ?>',
            data: {
                barang_id: barang_id
            },
            dataType: "json",
            success: function(data) {
                $('#MAInvgedungT_kode_wilayah').val(data.kd_wilayah);
                $('#MAInvgedungT_invgedung_noregister').val(data.value);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

    function cekKodeAset(obj) {
        var barang_id = $('#MAInvgedungT_barang_id').val();
        var noregister = $('#MAInvgedungT_invperalatan_noregister').val();
        var kode = $(obj).val();
        var jml_duplikat = 0;
        $('.kode_aset').each(function() {
            if ($(this).val() != '') {
                if ($(obj).val() == $(this).val()) {
                    jml_duplikat++;
                }
                if (jml_duplikat >= 2) {
                    myAlert("Kode yang dimasukan sudah digunakan");
                    $(obj).val('');
                    return false;
                }
            }
        });
        if (jml_duplikat < 2) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('CekKodeAset'); ?>',
                data: {
                    barang_id: barang_id,
                    noregister: noregister,
                    kode: kode
                },
                dataType: "json",
                success: function(data) {
                    if (data.status != 'OK') {
                        myAlert("Kode yang dimasukan sudah digunakan");
                        $(obj).val('');
                        return false;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function cekSelisihTerimaInventarisasi(jml, barang_id, terimapersdetail_id) {
        var subsubkelompok_kode = $("#<?php echo CHtml::activeId($modBarang, 'subsubkelompok_kode'); ?>").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('CekSelisihInv'); ?>',
            data: {
                terimapersdetail_id: terimapersdetail_id,
                barang_id: barang_id,
                jml: jml
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modBarang, 'jmlterima'); ?>").val(data.jumlah);
                $("#<?php echo CHtml::activeId($modBarang, 'register_awal'); ?>").val(data.awal);
                $("#<?php echo CHtml::activeId($model, 'invgedung_kode'); ?>").val(data.invgedung_kode);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function() {
        cekDisabled($('#guinvgedung-t-form'));
        <?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });
</script>