<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sarencana-keperawatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return cekIsian(); return false;'),
    'focus' => '#DiagnosakeperawatanM_diagnosakeperawatan_kode',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->textFieldRow($model,'rencana_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
?>
<?php //echo $form->textAreaRow($model,'rencana_intervensi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->textAreaRow($model,'rencana_rasionalisasi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->checkBoxRow($model,'iskolaborasiintervensi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<table>
    <thead>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosa', 'DiagnosakeperawatanM_diagnosakeperawatan_kode', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('diagnosakeperawatan_id'); ?>
                        <?php $this->widget('MyJuiAutoComplete', array(
                            'name' => 'DiagnosakeperawatanM[diagnosakeperawatan_kode]',
                            'value' => $model->diagnosakeperawatan_id,
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . Yii::app()->createUrl('ActionAutoComplete/DiagnosaKeperawatan') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $("#diagnosakeperawatan_id").val(ui.item.diagnosakeperawatan_id);
                                    $("#DiagnosakeperawatanM_diagnosakeperawatan_kode").val(ui.item.diagnosa_keperawatan);
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'readonly' => false,
                                'placeholder' => 'Nama Diagnosa Keperawatan',
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDiagnosaKeperawatan'),
                        )); ?>
                    </div>
                </div>
                <?php
                // Dialog buat nambah data diagnosa =========================
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogDiagnosaKeperawatan',
                    'options' => array(
                        'title' => 'Menambah data Diagnosa Keperawatan',
                        'autoOpen' => false,
                        'modal' => true,
                        'minWidth' => 600,
                        'height' => 400,
                        'resizable' => false,
                    ),
                ));

                $modDiagnosakeperawatan = new SADiagnosakeperawatanM;
                if (isset($_GET['SADiagnosakeperawatanM'])) {
                    $modDiagnosakeperawatan->diagnosa_keperawatan = $_GET['SADiagnosakeperawatanM']['diagnosa_keperawatan'];
                    $modDiagnosakeperawatan->diagnosa_medis = $_GET['SADiagnosakeperawatanM']['diagnosa_medis'];
                }
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sadiagnosakeperawatan-m-grid',
                    'dataProvider' => $modDiagnosakeperawatan->search(),
                    'filter' => $modDiagnosakeperawatan,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Pilih',
                            'type' => 'raw',
                            'value' => '',
                            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectDiagnosaKeperawatan",
                                    "onClick"=>"
                                      $(\"#idDiagnosakeperawatan\").val(\"$data->diagnosakeperawatan_id\");
                                      $(\"#diagnosakeperawatan_id\").val(\"$data->diagnosakeperawatan_id\");
                                      $(\"#DiagnosakeperawatanM_diagnosakeperawatan_kode\").val(\"$data->diagnosa_keperawatan\");
                                      $(\"#dialogDiagnosaKeperawatan\").dialog(\"close\");
                                      $(\"#RencanakeperawatanM_1_rencana_kode\").focus();
                                      "
                                ))',
                        ),
                        ////'diagnosa_id',
                        array(
                            'name' => 'diagnosakeperawatan_kode',
                            'value' => '$data->diagnosakeperawatan_kode',
                            'filter' => false,
                        ),
                        //'diagnosakeperawatan_kode',
                        'diagnosa_keperawatan',
                        'diagnosa_medis',

                        /*
                            'diagnosa_imunisasi',
                            'diagnosa_aktif',
                            */
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>

                <?php $this->endWidget(); ?>
            </td>
        </tr>
    </thead>
</table>
<table id="tbl-RencanaKeperawatan" class="table table-responsive table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Rencana Intervensi</th>
            <th>Rencana Rasionalisasi</th>
            <th>Kolaborasi Intervensi</th>
            <th>Tambah / Batal</th>
        </tr>
    </thead>
    <tr>
        <?php $isKolaborasi = array(
            0 => 'Tidak',
            1 => 'Ya'
        ); ?>
        <td>
            <?php echo $form->textField($model, '[1]rencana_kode', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        </td>
        <td>
            <?php echo $form->textArea($model, '[1]rencana_intervensi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->textArea($model, '[1]rencana_rasionalisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->dropDownList($model, '[1]iskolaborasiintervensi',  $isKolaborasi, array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus')); ?>
        </td>
    </tr>
</table>

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
$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit2c', array(), true);
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
        
        renameInput('SARencanakeperawatanM','rencana_kode');
        renameInput('SARencanakeperawatanM','rencana_intervensi');
        renameInput('SARencanakeperawatanM','rencana_rasionalisasi');
        renameInput('SARencanakeperawatanM','iskolaborasiintervensi');
$('#tbl-RencanaKeperawatan tr:last').find('input').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-RencanaKeperawatan tbody tr').length;
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
        
        renameInput('SARencanakeperawatanM','rencana_kode');
        renameInput('SARencanakeperawatanM','rencana_intervensi');
        renameInput('SARencanakeperawatanM','rencana_rasionalisasi');
        renameInput('SARencanakeperawatanM','iskolaborasiintervensi');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>
<script>
    function cekIsian() {
        var diagnosa_id = $('#DiagnosakeperawatanM_diagnosakeperawatan_kode').val();
        if (diagnosa_id == '') {
            myAlert('Silakan pilih Diagnosa');
            return false;
        } else {
            return true;
        }
    }
</script>