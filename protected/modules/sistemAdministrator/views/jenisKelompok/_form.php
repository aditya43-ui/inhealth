<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzlookup-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#GZLookupM_1_lookup_name',
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
            <?php
            echo    CHtml::hiddenField('no', 1, array('id' => 'nomor'));
            ?>
            <td>
                <?php echo $form->textField($model, '[1]lookup_name', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('lookup_name'))); ?>
                <span class="required">*</span>
            </td>
            <td>
                <?php echo $form->textField($model, '[1]lookup_value', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('lookup_value'))); ?>
                <span class="required">*</span>
            </td>
            <td>
                <?php echo $form->textField($model, '[1]lookup_kode', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('lookup_kode'))); ?>
                <span class="required">*</span>
            </td>
            <td>

                <?php echo $form->textField($model, '[1]lookup_urutan', array('class' => 'span1 numbersOnly required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => $model->getAttributeLabel('lookup_urutan'))); ?>
                <span class="required">*</span>
            </td>

            <?php //echo $form->checkBoxRow($model,'[1]lookup_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','LookupM_lookup_urutan')")); 
            ?>

            <td>
                <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'addRow(this)', 'id' => 'row1-plus', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>

        </tr>
    </tbody>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'CekValiditas()', 'id' => 'btn_simpan', 'onKeypress' => 'CekValiditas()')
    ); ?>
    <?php echo $ulang ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Kelompok', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit2b', array(), true);
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
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;')) ?>';
        var buttonTambah = '<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>';
        var tr = $('#tbl-Lookup tbody tr:first').html();
        var kdtrsblm = $(obj).parents('tr').find('input[name*="lookup_kode"]').val(); // Default Kode dari generator : STBRXXXX 
        var no = eval($('#nomor').val()) + 1;



        //var kodeangka = formatkode(parseInt(kdtrsblm.substr(4))+1,kdtrsblm.substr(4).length);
        //var kodesekarang = kdtrsblm.substr(0,4) + kodeangka;//
        var td = '   <td><input name = "GZLookupM[' + no + '][lookup_name]"  type = "text" id = "GZLookupM_' + no + '_lookup_name" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200" placeholder="<?php echo $model->getAttributeLabel('lookup_name'); ?>"> <span class="required">*<span></td>\n\
                        <td><input name = "GZLookupM[' + no + '][lookup_value]" type = "text" id = "GZLookupM_' + no + '_lookup_value" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200" placeholder="<?php echo $model->getAttributeLabel('lookup_value'); ?>"> <span class="required">*<span></td>\n\
                        <td><input name = "GZLookupM[' + no + '][lookup_kode]" type = "text" id = "GZLookupM_' + no + '_lookup_kode" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200" placeholder="<?php echo $model->getAttributeLabel('lookup_kode'); ?>"> <span class="required">*<span></td>\n\
                        <td><input name = "GZLookupM[' + no + '][lookup_urutan]" type = "text" id = "GZLookupM_' + no + '_lookup_urutan" class="span1 numbersOnly required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200" placeholder="<?php echo $model->getAttributeLabel('lookup_urutan'); ?>"> <span class="required">*<span></td>\n\
                        <td></td>';
        $('#tbl-Lookup tr:last').after('<tr>' + td + '</tr>');
        $('#tbl-Lookup tr:last td:last').append(buttonTambah);
        $('#tbl-Lookup tr:last td:last').append(buttonMinus);
        //renameInput('GZLookupM','lookup_name');
        //renameInput('GZLookupM','lookup_value');
        //renameInput('GZLookupM','lookup_kode');
        //renameInput('GZLookupM','lookup_urutan');
        //$('#GZLookupM_1_lookup_name').attr('id','GZLookupM_2_lookup_name')        

        //renam
        $('#tbl-Lookup tr:last').find('input').val('');
        $('#nomor').val(no);
        //$('#tbl-Lookup tr:last').find('input[name*="lookup_kode"]').val(kodesekarang);
    }

    // ni function buat ngeformat kode
    function formatkode(str, max) {
        str = str.toString();
        return str.length < max ? formatkode("0" + str, max) : str;
    }

    function delRow(obj) {
        var no = $('#nomor').val();
        $(obj).parent().parent().remove();
        renameInput('GZLookupM', 'lookup_name');
        renameInput('GZLookupM', 'lookup_value');
        renameInput('GZLookupM', 'lookup_kode');
        renameInput('GZLookupM', 'lookup_urutan');
        $('#nomor').val(eval(no) - 1);
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
                $('#gzlookup-m-form').submit();
            } else {
                myAlert('Bagian dengan tanda <span class="required">*</span> harus diisi.');
            }
        }
        return false;
    }
</script>