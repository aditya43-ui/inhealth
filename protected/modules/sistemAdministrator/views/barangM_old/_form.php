<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabarang-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'bidang_id'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model, 'bidang_id', CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'onchange' => 'setKodeBarang();')); ?>
            <!--<div class="control-group">
                                <label class="control-label" for="bidang">Bidang</label>
                                <div class="controls">-->
            <?php //echo $form->hiddenField($model,'bidang_id'); 
            ?>
            <?php /*
              $this->widget('MyJuiAutoComplete', array(

              'name'=>'bidangNama',
              'source'=>'js: function(request, response) {
              $.ajax({
              url: "'.Yii::app()->createUrl('ActionAutoComplete/getBidang').'",
              dataType: "json",
              data: {
              term: request.term,
              },
              success: function (data) {
              response(data);
              }
              })
              }',
              'options'=>array(
              'showAnim'=>'fold',
              'minLength' => 2,
              'focus'=> 'js:function( event, ui ) {
              $(this).val( ui.item.label);
              return false;
              }',
              'select'=>'js:function( event, ui ) {
              $("#'.CHtml::activeId($model, 'bidang_id').'").val(ui.item.bidang_id);
              $("#bidangNama").val(ui.item.bidang_nama);
              return false;
              }',
              ),
              'htmlOptions'=>array(
              'onkeypress'=>"return $(this).focusNextInputField(event)",
              ),
              'tombolDialog'=>array('idDialog'=>'dialogBidang'),
              ));
             */ ?>

            <?php
            echo $form->dropDownListRow($model, 'barang_type', LookupM::getItems('barangumumtype'), array(
                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
            ));
            ?>
            <?php echo CHtml::hiddenField('tempKode', $model->barang_kode); ?>
            <?php echo $form->textFieldRow($model, 'barang_kode', array('class' => 'span2 ', 'onkeyup' => 'setKode(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,)); ?>
            <?php echo $form->textFieldRow($model, 'barang_nama', array('class' => 'span2', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'barang_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'barang_merk', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'barang_noseri', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

            <?php echo $form->textFieldRow($model, 'barang_ukuran', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->textFieldRow($model, 'barang_bahan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->textFieldRow($model, 'barang_thnbeli', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'barang_harganetto', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model, 'barang_warna', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'barang_ekonomis_thn', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'barang_ekonomis_thn', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . ' tahun '; ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model, 'barang_satuan', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
            <?php echo $form->textFieldRow($model, 'barang_jmldlmkemasan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->labelEx($model, 'barang_image', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
            <div class="controls">
                <?php echo Chtml::activeFileField($model, 'barang_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Logo')); ?>
            </div>
        </td>

        <?php //echo $form->checkBoxRow($model,'barang_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
    </tr>
</table>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/barangM/admin'), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php
    $content = $this->renderPartial('gudangUmum.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangUmum/BarangM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBidang',
    'options' => array(
        'title' => 'Bidang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modBidang = new SABidangM('search');
$modBidang->unsetAttributes();
if (isset($_GET['SABidangM']))
    $modBidang->attributes = $_GET['SABidangM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modBidang->search(),
    'filter' => $modBidang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Golongan',
            'filter' => CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
            'value' => '$data->subkelompok->kelompok->golongan->golongan_nama',
        ),
        array(
            'header' => 'Kelompok',
            'filter' => CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
            'value' => '$data->subkelompok->kelompok->kelompok_nama',
        ),
        array(
            'header' => 'Sub Kelompok',
            'filter' => CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
            'value' => '$data->subkelompok->subkelompok_nama',
        ),
        array(
            'name' => 'bidang_id',
            'filter' => CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
            'value' => '$data->bidang_nama',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'bidang_id') . '\").val(\'$data->bidang_id\');
                                    $(\"#bidangNama\").val(\'$data->bidangNama\');
                                    $(\'#dialogBidang\').dialog(\'close\');return false;"))'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php Yii::app()->clientScript->registerScript('head', '
    function setKode(obj){
        var value = $("#tempKode").val();
        var objValue = $(obj).val();
        if (objValue < value){
           $(obj).val(value);
        }
    }
', CClientScript::POS_HEAD); ?>
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

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SABarangM_barang_namalainnya').value = nama.value.toUpperCase();
    }
</script>