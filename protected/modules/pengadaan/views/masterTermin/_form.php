<?php
/**
* digunakan untuk Master Termin
* @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
**/
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'adlookup-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'lookup_name'),
)); ?>
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-12">
        <?php echo $form->hiddenField($model, 'lookup_type', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readOnly' => true)); ?>
        <table id="tbl-Lookup" class="table table-responsive table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nama Termin</th>
                    <th>Jumlah Termin</th>
                    <th>Urutan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $form->textField($model, '[1]lookup_name', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('Nama Termin'))); ?>
                        <span class="required">*</span>
                    </td>
                    <td>
                        <?php echo $form->textField($model, '[1]lookup_value', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('Jumlah Termin'))); ?>
                        <span class="required">*</span>
                    </td>
                    <td>
                        <?php echo $form->textField($model, '[1]lookup_urutan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => $model->getAttributeLabel('Urutan'))); ?>
                        <span class="required">*</span>
                    </td>
                    <td>
                        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'addRow(this)', 'id' => 'row1-plus', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </td>
                </tr>
            </tbody>
        </table>		
    </div>
</div>                    
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'CekValiditas()', 'id' => 'btn_simpan', 'onKeypress' => 'CekValiditas()'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;});'));
    ?>           
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Termin', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'delRow(this); return false;'));
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
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'delRow(this); return false;')) ?>';
        var tr = $('#tbl-Lookup tbody tr:first').html();

        $('#tbl-Lookup tr:last').after('<tr>' + tr + '</tr>');
        $('#tbl-Lookup tr:last td:last').append(buttonMinus);

        renameInput('LookupM', 'lookup_name');
        renameInput('LookupM', 'lookup_value');
        renameInput('LookupM', 'lookup_urutan');
        $('#tbl-Lookup tr:last').find('input').val('');
    }

    function formatkode(str, max) {
        str = str.toString();
        return str.length < max ? formatkode("0" + str, max) : str;
    }

    function delRow(obj)
    {
        $(obj).parent().parent().remove();
        renameInput('GJJenisPinjamanM', 'lookup_name');
        renameInput('GJJenisPinjamanM', 'lookup_value');
        renameInput('GJJenisPinjamanM', 'lookup_urutan');
    }

    function CekValiditas() {
        if (requiredCheck($("form"))) {
            var lookup_name;
            var lookup_value;
            var lookup_urutan;
            var rowvalid = true;
            $('#tbl-Lookup tbody').find('tr').each(function () {
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
                $('#adlookup-m-form').submit();
            } else {
                myAlert('Bagian dengan tanda <span class="required">*</span> harus diisi.');
            }
        }
        return false;
    }

</script>