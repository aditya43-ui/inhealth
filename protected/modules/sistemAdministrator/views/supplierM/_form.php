<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfsupplier-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'supplier_kode'),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'supplier_kode', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_nama', array('placeholder' => 'Nama Supplier', 'class' => 'span4', 'onkeyup' => "namaLain(this)",  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php
        $module = Yii::app()->controller->module->id;
        //                if($module == 'gudangUmum') {
        //                    
        ?>
        <div class="control-group">
            <?php // echo CHtml::label('Perusahaan Besar Logistik','',array('class'=>'control-label'));
            ?>
            <div class="controls">
                <?php // echo $form->dropDownList($model,'pbf_id',
                //			CHtml::listData(SAPbfM::model()->findAll("pbf_aktif = TRUE ORDER BY pbf_nama ASC"), 'pbf_id', 'pbf_nama'),
                //			array('readonly'=>false,'class'=>'span4', 'onkeyup' => "return $(this).focusNextInputField(event)",
                //			'empty'=>'-- Pilih --',)); 
                ?>
            </div>
        </div>
        <?php //   }else{
        //                    echo $form->dropDownListRow($model,'pbf_id',
        //			CHtml::listData(SAPbfM::model()->findAll("pbf_aktif = TRUE ORDER BY pbf_nama ASC"), 'pbf_id', 'pbf_nama'),
        //			array('readonly'=>false,'class'=>'span4', 'onkeyup' => "return $(this).focusNextInputField(event)",
        //			'empty'=>'-- Pilih --',));  
        //                }

        ?>
        <?php echo $form->textFieldRow($model, 'supplier_namalain', array('placeholder' => 'Nama Lainnya', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($model, 'supplier_alamat', array('placeholder' => 'Alamat', 'rows' => 4, 'cols' => 30, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'supplier_kodepos', array('placeholder' => 'Kode Pos', 'class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'latitude', array('placeholder' => 'Latitude', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->checkBoxRow($model, 'supplier_aktif', array('checked' => 'supplier_aktif')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'supplier_propinsi', CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'ajax' => array('type' => 'POST', 'url' => $this->createUrl('GetKabupatendrNamaPropinsi', array('encode' => false, 'namaModel' => 'SASupplierM', 'attr' => 'supplier_propinsi')), 'update' => '#SASupplierM_supplier_kabupaten'))); ?>
        <?php echo $form->dropDownListRow($model, 'supplier_kabupaten', CHtml::listData($model->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'), array('class' => 'inputRequire span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_telp', array('placeholder' => 'Telepon', 'class' => 'span4 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_fax', array('placeholder' => 'Fax', 'class' => 'span4 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_npwp', array('placeholder' => 'No. NPWP', 'class' => 'span4 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100,)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_website', array('placeholder' => 'Website', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_email', array('placeholder' => 'Email', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_cp', array('placeholder' => 'Contact person', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'supplier_norekening', array('placeholder' => '00', 'class' => 'span4 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100,)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Termin Pembayaran Supplier <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'terminpembayaran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
            </div>
        </div>
        <?php
        $module = Yii::app()->controller->module->id;
        if ($module == 'gudangUmum') {
            echo $form->dropDownListRow($model, 'supplier_jenis',  CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => "jenissupplier", 'lookup_name' => "Umum")), 'lookup_value', 'lookup_name'), array('class' => 'span4 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
        } else {
            echo $form->dropDownListRow($model, 'supplier_jenis',  LookupM::model()->getItems('jenissupplier'), array('class' => 'span4 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
        } ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Supplier', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>

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

<?php
$this->widget('ext.LocationPicker2.CoordinatePicker', array(
    'model' => $model,
    'latitudeAttribute' => 'latitude',
    'longitudeAttribute' => 'longitude',
    //optional settings
    'editZoom' => 12,
    'pickZoom' => 7,
    'defaultLatitude' => $latitude,
    'defaultLongitude' => $longitude,
));
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SASupplierM_supplier_namalain').value = nama.value.toUpperCase();
    }
</script>