
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvasetlain-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#',
));
?>


<div>
    <p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <?php $this->renderPartial('_dataLainLain', array('form'=>$form, 'modBarang' => $modBarang, 'model' => $model, 'jenisAset'=>'05')); ?>
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">											
                <i class="glyphicon glyphicon-file"></i> Data Inventarisai Aset Lainnya																	
            </div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-6">
                    <?php echo $form->dropDownListRow($model, 'pemilikbarang_id', CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    <?php echo $form->hiddenField($model, 'barang_id'); ?>
                    <?php echo $form->hiddenField($model, 'barang_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'asalaset_id', CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'lokasi_id', array(
                            'class' => 'control-label',
                        )); ?>
                        <div class="controls">
                            <?php echo CHtml::activeHiddenField($model, 'lokasi_id', array(
                                'id' => 'lokasi_id'
                            )); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'lokasi_nama',
                                //'name'=>'barang_nama',
                                //'value'=>$modBarang->barang_nama,
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                        url: "' . Yii::app()->createUrl('ActionAutoComplete/getLokasiAset') . '",
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
                                                        $("#lokasi_id").val(ui.item.lokasi_id);
                                                        $("#lokasi_nama").val(ui.item.lokasiaset_namalokasi);
                                                        $("#alamat_lokasi").val(ui.item.alamat_lokasi);
                                                        return false;
                                                    }',
                                                ),
                                                'htmlOptions'=>array(
                                                    'id'=>'lokasi_nama',
                                                    'class'=>'span3',
                                                    'placeholder'=>'Ketik Lokasi',
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                                                'tombolDialog'=>array('idDialog'=>'dialogLokasiAset'),
                                            )); 
                            ?>
                        </div>
                    </div>



                    <?php //echo $form->dropDownListRow($model, 'lokasi_id', CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); 
                    ?>

                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'invasetlain_noregister', array(
                            'class' => 'control-label',
                            'label' => 'Kode Lokasi',
                        )); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'invasetlain_noregister', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>
                    
                    <?php echo $form->textFieldRow($model, 'invasetlain_harga', array('id'=>'harga_tanah', 'class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'pembelian', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'pembelian',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'pembelian'); ?>
                        </div>
                    </div>
                    <?php // echo $form->textFieldRow($model, 'invasetlain_akumsusut', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php echo $form->textFieldRow($model, 'invasetlain_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>


                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'invasetlain_judulbuku', array(
                            'class' => 'control-label',
                        )); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'invasetlain_judulbuku', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'invasetlain_spesifikasibuku', array(
                            'class' => 'control-label',
                        )); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'invasetlain_spesifikasibuku', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>

                    <?php echo $form->textFieldRow($model, 'invasetlain_thncetak', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)); ?>


                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'invasetlain_jenishewan_tum', array(
                            'class' => 'control-label',
                        )); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'invasetlain_jenishewan_tum', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>



                </div>
                <div class="clear"></div>
            </div>
            <div class="detail_inv">

            </div>
        </div>
    </div>
    <div class="panel panel-primary panel-success" hidden>
        <div class="panel-heading">
            <div class="panel-title">
                Penjurnalan
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_penjurnalan', array('model' => $model, 'form' => $form,)); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
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
        'pemilikbarang_id',
        'pemilikbarang_kode',
        'pemilikbarang_nama',
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
        'asalaset_id',
        'asalaset_nama',
        'asalaset_singkatan',
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
        'title' => 'Lokasi Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modLokasiAset = new MALokasiasetM('search');
$modLokasiAset->unsetAttributes();
if (isset($_GET['MALokasiasetM'])) {
    $modLokasiAset->attributes = $_GET['MALokasiasetM'];
    $modLokasiAset->jenis_lokasi = $_GET['MALokasiasetM']['jenis_lokasi'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'lokasiaset-m-grid',
    'dataProvider' => $modLokasiAset->search(),
    'filter' => $modLokasiAset,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectBidang",
                            "onClick" => "
                            $(\"#lokasi_id\").val(\'$data->lokasi_id\');
                            $(\"#lokasi_nama\").val(\'$data->lokasiaset_namalokasi\');
                            $(\"#alamat_lokasi\").val(\'$data->alamat_lokasi\');
                            $(\'#dialogLokasiAset\').dialog(\'close\');return false;"))'
        ),
        'lokasiaset_kode',
        array(
            'header' => 'Nama Lokasi',
            'name' => 'lokasiaset_namalokasi',
        ),
        //'lokasiaset_namainstalasi',
        array(
            'name' => 'jenis_lokasi',
            'filter' => CHtml::activeDropDownList($modLokasiAset, 'jenis_lokasi', LookupM::getItems('jenis_lokasiaset'), array(
                'empty' => '-- Pilih --'
            )),
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
                $('#MAInvasetlainT_invasetlain_noregister').val(data.value);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
    $(document).ready(function() {
        cekDisabled($('#guinvasetlain-t-form'));
        <?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr('disabled', true);
        <?php } ?>
    });

    function cekSelisihTerimaInventarisasi(jml, barang_id, terimapersdetail_id) {
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
                $("#<?php echo CHtml::activeId($modBarang, 'register_akhir'); ?>").val(data.akhir);
                setDetailInvAlat(jml, barang_id, terimapersdetail_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setDetailInvAlat(jml, barang_id, terimapersdetail_id) {
        $('.detail_inv').html('');
        var jumlah = $("#<?php echo CHtml::activeId($modBarang, 'jmlterima'); ?>").val();
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('LoadDetailInvAlat'); ?>',
            data: {
                jumlah: jumlah,
                barang_id: barang_id,
                terimapersdetail_id: terimapersdetail_id
            },
            dataType: "json",
            success: function(data) {
                $('.detail_inv').append(data.rows);
                renameAsetDetail();
                $('.detail_inv .float2').maskMoney({
                    "symbol": "",
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": "",
                    "precision": 2
                });
                $('.detail_inv .numbersOnly').maskMoney({
                    "symbol": "",
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": "",
                    "precision": 0
                });
                jQuery('.invasetlain_tglguna').datepicker(
                    jQuery.extend({
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'], {
                            'dateFormat': 'dd M yy',
                            'showSecond': false,
                            'timeOnlyTitle': 'Pilih Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'yearRange': '-80y:+20y',
                        }
                    )
                );

                $(".invasetlain_tglguna").parents(".input-append").find(".add-on").click(function() {
                    $(this).parents(".input-append").find(".invasetlain_tglguna").focus();
                });

                $("#MAInvasetlainT_invasetlain_noregister").blur();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }


    function renameAsetDetail() {
        var x = 1;
        $('.urutan_aset_det').each(function() {
            $(this).html(x);
            x++;
        });
    }
</script>