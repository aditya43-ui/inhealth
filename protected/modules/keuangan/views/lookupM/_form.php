<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lookup-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#LookupM_lookup_type',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);',
    ),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
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
                        <?php echo $form->textField($model, '[1]lookup_name', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('lookup_name'))); ?>
                        <span class="required">*</span>
                    </td>
                    <td>
                        <?php echo $form->textField($model, '[1]lookup_value', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200, 'placeholder' => $model->getAttributeLabel('lookup_value'))); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, '[1]lookup_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('lookup_kode'))); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, '[1]lookup_urutan', array('class' => 'span3 numbersOnly required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => $model->getAttributeLabel('lookup_urutan'))); ?>
                    </td>
                    <?php //echo $form->checkBoxRow($model,'[1]lookup_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','LookupM_lookup_urutan')")); 
                    ?>
                    <td>
                        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'addRow(this)', 'id' => 'row1-plus')); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'lookup_type',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100,)); 
?>
<?php //echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_value','LookupM_lookup_type')", 'maxlength'=>200)); 
?>
<?php //echo $form->textFieldRow($model,'lookup_value',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_kode','LookupM_lookup_name')", 'maxlength'=>200)); 
?>
<?php //echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_urutan','LookupM_lookup_value')", 'maxlength'=>50)); 
?>
<?php //echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LookupM_lookup_aktif','LookupM_lookup_kode')")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Transaksi', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
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
        
        renameInput('LookupM','lookup_name');
        renameInput('LookupM','lookup_value');
        renameInput('LookupM','lookup_kode');
        renameInput('LookupM','lookup_urutan');
$('#tbl-Lookup tr:last').find('input').val('');

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
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();

			renameInput('LookupM','lookup_name');
			renameInput('LookupM','lookup_value');
			renameInput('LookupM','lookup_kode');
			renameInput('LookupM','lookup_urutan');
		}
	});
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>