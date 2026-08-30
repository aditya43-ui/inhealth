<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sarencana-keperawatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#SARencanaKeperawatanM_0_rencana_kode',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-12">
        <?php echo $form->textFieldRow($model, 'diagnosakeperawatan_id', array('value' => $modDiagnosakeperawatan->diagnosa_keperawatan, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
        <?php //echo $form->textFieldRow($model,'rencana_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
        ?>
        <?php //echo $form->textAreaRow($model,'rencana_intervensi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textAreaRow($model,'rencana_rasionalisasi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->checkBoxRow($model,'iskolaborasiintervensi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
    <div class="col-sm-12" style="overflow-x: auto;max-width: 100%">
        <table id="tbl-RencanaKeperawatan" class="table table-responsive table-bordered table-striped table-condensed">
            <thead>
                <tr>

                    <th>Kode</th>
                    <th>Rencana Intervensi</th>
                    <th>Rencana Rasionalisasi</th>
                    <th>Kolaborasi Intervensi</th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($modRencanaKeperawatan as $i => $rencanaKeperawatan) { ?>
                    <tr>
                        <?php $isKolaborasi = array(
                            0 => 'Tidak',
                            1 => 'Ya'
                        ); ?>
                        <td>
                            <?php echo $form->hiddenField($rencanaKeperawatan, "[$i]rencanakeperawatan_id", array('value' => $rencanaKeperawatan->rencanakeperawatan_id)); ?>
                            <?php echo $form->textField($rencanaKeperawatan, "[$i]rencana_kode", array('value' => $rencanaKeperawatan->rencana_kode, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($rencanaKeperawatan, "[$i]rencana_intervensi", array('value' => $rencanaKeperawatan->rencana_intervensi, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($rencanaKeperawatan, "[$i]rencana_rasionalisasi", array('value' => $rencanaKeperawatan->rencana_rasionalisasi, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($rencanaKeperawatan, "[$i]iskolaborasiintervensi",  $isKolaborasi, array('value' => $rencanaKeperawatan->iskolaborasiintervensi, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus')); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo CHtml::htmlButton(
    $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/rencanaKeperawatanM/admin'),
    array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Pengaturan Rencana Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
    array('class' => 'btn btn-success',)
); ?>
<?php
$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit2b', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-RencanaKeperawatan tbody tr:first').html();
    $('#tbl-RencanaKeperawatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-RencanaKeperawatan tr:last td:last').append('$buttonMinus');
        
        renameInput('RencanakeperawatanM','diagnosakeperawatan_id');
        renameInput('RencanakeperawatanM','rencanakeperawatan_id');
        renameInput('RencanakeperawatanM','rencana_kode');
        renameInput('RencanakeperawatanM','rencana_intervensi');
        renameInput('RencanakeperawatanM','rencana_rasionalisasi');
        renameInput('RencanakeperawatanM','iskolaborasiintervensi');
        renameInput('RencanakeperawatanM','rencanakeperawatan_id');
    $('#tbl-RencanaKeperawatan tr:last').find('input').val('');
    $('#tbl-RencanaKeperawatan tr:last').find('textarea').val('');
    $('#tbl-RencanaKeperawatan tr:last').find('select').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-RencanaKeperawatanM tbody tr').length;
    var i = 1;
    $('#tbl-RencanaKeperawatan tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('RencanakeperawatanM','diagnosakeperawatan_id');
        renameInput('RencanakeperawatanM','rencana_kode');
        renameInput('RencanakeperawatanM','rencana_intervensi');
        renameInput('RencanakeperawatanM','rencana_rasionalisasi');
        renameInput('RencanakeperawatanM','iskolaborasiintervensi');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>