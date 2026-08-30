<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kategoriobat-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#LookupM_lookup_type',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lookup_name', array('class' => 'span3', 'placeholder' => 'Nama', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_value','LookupM_lookup_type')", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'lookup_value', array('class' => 'span3', 'placeholder' => 'Value', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_kode','LookupM_lookup_name')", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'lookup_kode', array('class' => 'span3', 'placeholder' => 'Kode', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_urutan','LookupM_lookup_value')", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lookup_urutan', array('class' => 'span1', 'placeholder' => '00', 'onkeypress' => "return nextFocus(this,event,'LookupM_lookup_aktif','LookupM_lookup_kode')")); ?>
        <?php echo $form->checkBoxRow($model, 'lookup_aktif', array('onkeypress' => "return nextFocus(this,event,'LookupM_lookup_aktif','LookupM_lookup_kode')")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kategoriObatM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kategori Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
$(document).ready(function(){
    $('.numbersOnly').keyup(function() {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
           this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });
});

function addRow(obj)
{
    var tr = $('#tbl-Lookup tbody tr:first').html();
    $('#tbl-Lookup tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-Lookup tr:last td:last').append('$buttonMinus');
        renameInput('LookupM','lookup_id');
        renameInput('LookupM','lookup_name');
        renameInput('LookupM','lookup_value');
        renameInput('LookupM','lookup_kode');
        renameInput('LookupM','lookup_urutan');
        renameInput('LookupM','lookup_type');
        renameInput('LookupM','lookup_aktif');
$('#tbl-Lookup tr:last').find('input').val('');
$('#tbl-Lookup tr:last').find(".lookupAktif").val(1);
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-Lookup tbody tr').length;
    var i = 1;
    $('#tbl-Lookup tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    myConfirm("$confimMessage","Perhatian!",
    function(r){
        if(r){
            return false;
        }else{
            $(obj).parent().parent().remove();
            renameInput('SALookupM','lookup_id');
            renameInput('SALookupM','lookup_name');
            renameInput('SALookupM','lookup_value');
            renameInput('SALookupM','lookup_kode');
            renameInput('SALookupM','lookup_urutan');
        }
    }); 
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>