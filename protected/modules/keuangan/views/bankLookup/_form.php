<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lookup-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#LookupM_1_lookup_name',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'lookup_type', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('lookup_type', $model->lookup_type, array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?>
            </div>
        </div>

        <table id="tbl-Lookup" class="table table-responsive table-striped table-bordered table-condensed">
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
                        <?php echo $form->textField($model, '[1]lookup_name', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'keyNameToVal(this);', 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('lookup_name'))); ?>
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
                        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '', array('class' => 'btn btn-primary', 'onclick' => 'addRow(this)', 'id' => 'row1-plus', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'CekValiditas()', 'id' => 'btn_simpan', 'onKeypress' => 'CekValiditas()')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . "/" . Yii::app()->controller->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bank Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
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
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '', array('class' => 'btn btn-danger', 'onclick' => 'delRow(this); return false;')) ?>';
        var tr = $('#tbl-Lookup tbody tr:first').html();
        var kdtrsblm = $(obj).parents('tr').find('input[name*="lookup_kode"]').val(); // Default Kode dari generator : STBRXXXX
        var kodeangka = formatkode(parseInt(kdtrsblm.substr(4)) + 1, kdtrsblm.substr(4).length);
        var kodesekarang = kdtrsblm.substr(0, 4) + kodeangka;
        //	var urutLook =  parseInt($(obj).parents('tr').find('input[name*="lookup_urutan"]').val());

        $('#tbl-Lookup tr:last').after('<tr>' + tr + '</tr>');
        $('#tbl-Lookup tr:last td:last').append(buttonMinus);

        renameInput('LookupM', 'lookup_name');
        renameInput('LookupM', 'lookup_value');
        renameInput('LookupM', 'lookup_kode');
        renameInput('LookupM', 'lookup_urutan');
        $('#tbl-Lookup tr:last').find('input').val('');

        $('#tbl-Lookup tr:last').find('input[name*="lookup_kode"]').val(kodesekarang);
        //        $('#tbl-Lookup tr:last').find('input[name*="lookup_urutan"]').val((urutLook + 1));
    }

    $('#tbl-Lookup tr:last').after('<tr>' + tr + '</tr>');
    $('#tbl-Lookup tr:last td:last').append(buttonMinus);

    renameInput('LookupM', 'lookup_name');
    renameInput('LookupM', 'lookup_value');
    renameInput('LookupM', 'lookup_kode');
    renameInput('LookupM', 'lookup_urutan');
    $('#tbl-Lookup tr:last').find('input').val('');

    $('#tbl-Lookup tr:last').find('input[name*="lookup_kode"]').val(kodesekarang);
    //        $('#tbl-Lookup tr:last').find('input[name*="lookup_urutan"]').val((urutLook + 1));
    }

    // ni function buat ngeformat kode
    function formatkode(str, max) {
        str = str.toString();
        return str.length < max ? formatkode("0" + str, max) : str;
    }

    function keyNameToVal(obj) {
        var value = $(obj).parents('tr').find('input[name*="lookup_name"]').val();
        $(obj).parents('tr').find('input[name*="lookup_value"]').val(value);
    }
</script>