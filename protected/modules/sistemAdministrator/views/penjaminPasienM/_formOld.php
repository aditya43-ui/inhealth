<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapenjamin-pasien-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'carabayar_id'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListRow($model, 'carabayar_id',  CHtml::listData($model->CarabayarItems, 'carabayar_id', 'carabayar_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>

<table id="tbl-penjaminPasien" class="table table-striped table-bordered table-condensed">
    <tr>
        <td>
            <?php echo $form->textField($model, '[1]penjamin_nama', array('class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAKelaspelayananM_penjamin_namalainnya','')", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('penjamin_nama'))); ?>
            <span class="required">*</span>
        </td>
        <td>
            <?php echo $form->textField($model, '[1]penjamin_namalainnya', array('class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'row1-plus','')", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('penjamin_namalainnya'))); ?>
        </td>
        <td>
            <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus')); ?>
        </td>
    </tr>
</table>

<?php //echo $form->checkBoxRow($model,'kelaspelayanan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/PenjaminPasienMAS/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-penjaminPasien tr:first').html();
    $('#tbl-penjaminPasien tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-penjaminPasien tr:last td:last').append('$buttonMinus');
    renameInput('SAPenjaminPasienM','penjamin_nama');
    renameInput('SAPenjaminPasienM','penjamin_namalainnya');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-penjaminPasien tr').length;
    var i = 1;
    $('#tbl-penjaminPasien tr').each(function(){
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
			renameInput('SAKelasPenjaminPasienM','penjamin_nama');
			renameInput('SAKelasPenjaminPasienM','penjamin_namalainnya');
		}
	});
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>