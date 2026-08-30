<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lookup-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#LookupM_1_lookup_name',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'lookup_type', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?>

<table id="tbl-Lookup" class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Value</th>
            <th>Kode</th>
            <th>Urutan</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>

            <td>
                <?php echo $form->textField($model, '[1]lookup_name', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('lookup_name'))); ?>
                <span class="required">*</span>
            </td>
            <td>
                <?php echo $form->textField($model, '[1]lookup_value', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('lookup_value'))); ?>
                <span class="required">*</span>
            </td>
            <td>
                <?php echo $form->textField($model, '[1]lookup_kode', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('lookup_kode'))); ?>
            </td>
            <td>

                <?php echo $form->textField($model, '[1]lookup_urutan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => $model->getAttributeLabel('lookup_urutan'))); ?>
                <span class="required">*</span>
            </td>

            <?php //echo $form->checkBoxRow($model,'[1]lookup_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','LookupM_lookup_urutan')")); 
            ?>

            <td>
                <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>

        </tr>
    </tbody>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'CekValiditas()', 'id' => 'btn_simpan', 'onKeypress' => 'CekValiditas()')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/lookupM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('gudangUmum.views.tips.tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Satuan Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangUmum/lookupM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-Lookup tbody tr').length;
    var i = 1;
    $('#tbl-Lookup tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>
<script>
    function addRow(obj) {
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;')) ?>';
        var tr = $('#tbl-Lookup tbody tr:first').html();
        var kdtrsblm = $(obj).parents('tr').find('input[name*="lookup_kode"]').val(); // Default Kode dari generator : STBRXXXX 
        var kodeangka = formatkode(parseInt(kdtrsblm.substr(4)) + 1, kdtrsblm.substr(4).length);
        var kodesekarang = kdtrsblm.substr(0, 4) + kodeangka;

        $('#tbl-Lookup tr:last').after('<tr>' + tr + '</tr>');
        $('#tbl-Lookup tr:last td:last').append(buttonMinus);

        renameInput('LookupM', 'lookup_name');
        renameInput('LookupM', 'lookup_value');
        renameInput('LookupM', 'lookup_kode');
        renameInput('LookupM', 'lookup_urutan');
        $('#tbl-Lookup tr:last').find('input').val('');

        $('#tbl-Lookup tr:last').find('input[name*="lookup_kode"]').val(kodesekarang);
    }

    // ni function buat ngeformat kode
    function formatkode(str, max) {
        str = str.toString();
        return str.length < max ? formatkode("0" + str, max) : str;
    }

    function delRow(obj) {
        $(obj).parent().parent().remove();
        renameInput('LookupM', 'lookup_name');
        renameInput('LookupM', 'lookup_value');
        renameInput('LookupM', 'lookup_kode');
        renameInput('LookupM', 'lookup_urutan');
    }

    function CekValiditas() {
        if (requiredCheck($("form"))) {
            var lookup_name;
            var lookup_value;
            var lookup_urutan;
            var rowvalid = true;
            $('#tbl-Lookup tbody').find('tr').each(function() {
                lookup_name = $(this).find('input[name*="[lookup_name]"]').val();
                lookup_value = $(this).find('input[name*="[lookup_value]"]').val();
                lookup_urutan = $(this).find('input[name*="[lookup_urutan]"]').val();
                if ((lookup_name != '') && (lookup_value != '') && (lookup_urutan != '')) {
                    rowvalid &= true;
                } else {
                    rowvalid &= false;
                }
            });
            if (rowvalid) {
                $('#lookup-m-form').submit();
            } else {
                myAlert('Bagian dengan tanda <span class="required">*</span> harus diisi.');
            }
        }
        return false;
    }
</script>