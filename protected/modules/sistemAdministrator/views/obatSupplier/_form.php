<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfobatsupplier-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($modObatSupplier, 'supplier_id'),
)); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>
<!--<legend class="rim">Data Obat Supplier</legend>-->
<div class="row">
    <?php if ($form->errorSummary($modObatSupplier)) {
        echo '<div class="alert alert-block alert-error">' . $form->errorSummary($modObatSupplier) . '</div>';
    } ?>
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Supplier <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modObatSupplier, 'supplier_id', CHtml::listData(SupplierM::model()->findAll(), 'supplier_id', 'supplier_nama'), array('style' => 'width:160px;', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Obat Alkes', 'obatAlkes', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $modObatSupplier,
                    'attribute' => 'obatAlkes',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/ObatAlkes'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'select' => 'js:function( event, ui ) {
							$("#obatalkes_id").val(ui.item.obatalkes_id);
						}',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "if(event.keyCode == 13 ){submitObat();}return $(this).focusNextInputField(event)",
                        //                                            'onclick'=>'submitObat(); return false;',
                        'class' => 'span2',
                        'placeholder' => 'Obat Alkes',
                    ), 'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                )); ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Obat Supplier</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tableobatSupplier" class="table table-bordered table-condensed middle-center">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Supplier</th>
                    <th>Nama Obat Alkes</th>
                    <th>Satuan Kecil</th>
                    <th>Satuan Besar</th>
                    <th>Harga Beli <br> Satuan Besar</th>
                    <th>Harga Beli <br> Satuan Kecil</th>
                    <th>Keringanan (%)</th>
                    <th>Ppn (%)</th>
                    <th>Batal</th>
                </tr>
                <thead>
                <tbody>
                </tbody>
        </table>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $modObatSupplier->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/ObatSupplier/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Obat Supplier', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl(
            Yii::app()->controller->id . '/admin',
            array('modul_id' => Yii::app()->session['modul_id'])
        ),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tips.tipsaddedit3', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modObatAlkes = new ObatalkesfarmasiV('search');
$modObatAlkes->unsetAttributes();
if (isset($_GET['ObatalkesfarmasiV'])) {
    $modObatAlkes->attributes = $_GET['ObatalkesfarmasiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkes-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modObatAlkes->search(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
                                                          $(\"#' . CHtml::activeId($modObatSupplier, 'obatAlkes') . '\").val(\"$data->obatalkes_nama\");
                                                        submitObat();
                                                          $(\"#dialogObatAlkes\").dialog(\"close\");    
                                                "))',
        ),
        array(
            'header' => 'Sumber Dana',
            'name' => 'sumberdana_nama',
            'value' => '$data->sumberdana_nama',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[sumberdana_nama]', $modObatAlkes->sumberdana_nama, CHtml::listData($modObatAlkes->getSumberDanaItems(), 'sumberdana_nama', 'sumberdana_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisobatalkes_nama',
            'value' => '$data->jenisobatalkes_nama',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[jenisobatalkes_nama]', $modObatAlkes->jenisobatalkes_nama, CHtml::listData($modObatAlkes->getJenisObatAlkesItems(), 'jenisobatalkes_nama', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kategori',
            'name' => 'obatalkes_kategori',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[obatalkes_kategori]', $modObatAlkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Golongan',
            'name' => 'obatalkes_golongan',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[obatalkes_golongan]', $modObatAlkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        'obatalkes_kadarobat',
        //'kemasanbesar',
        'kekuatan',
        // 'tglkadaluarsa',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>
<?php
$urlGetObatAlkesSupplier = Yii::app()->createUrl('sistemAdministrator/obatSupplier/getObatAlkesSupplier');
$supplier_id = CHtml::activeId($modObatSupplier, 'supplier_id');

$jscript = <<< JS
function submitObat()
{
    obatalkes_id = $('#obatalkes_id').val();
    supplier_id = $('#${supplier_id}').val();

    if(supplier_id =='')
    {
        myAlert('Silakan pilih supplier terlebih dahulu!');
    }else if(obatalkes_id==''){
        myAlert('Silakan pilih obat terlebih dahulu!');
    }else{
            $.post("${urlGetObatAlkesSupplier}", { obatalkes_id: obatalkes_id, supplier_id:supplier_id},
            function(data){
                $("#tableobatSupplier tbody tr:last").find('.numbersOnly').maskMoney({"defaultZero":true, "allowZero":true, "decimal":",", "thousands":".", "symbol":null, "precision":0});
                $('#tableobatSupplier tbody').append(data.tr);
                clear();
                
            }, "json");
    }   
}

function remove(obj) {
    $(obj).parents('tr').remove();
}

function clear(){
    
    urut = 1;
    $(".noUrut").each(function(){
        $("#ObatsupplierM_obatAlkes").val("");
        $("#SAObatSupplierM_supplier_id").val();
            $(this).val(urut);
             urut++;
    });
}
JS;
Yii::app()->clientScript->registerScript('obatAlkes', $jscript, CClientScript::POS_HEAD);
?>
<script>
    function setHargaJual(obj) {

        var harganettoppn = parseFloat(obj.value);
        var konfigFarmasi = parseFloat(<?php echo Yii::app()->user->getState('totalpersenhargajual') ?>);
        hargajual = parseFloat(harganettoppn) * parseFloat(konfigFarmasi / 100);
        $(obj).parents('tr').find('.hargajual').val(hargajual);

    }
</script>