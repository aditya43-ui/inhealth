<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadiagnosakeperawatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return cekIsian(); return false;'),
    'focus' => '#DiagnosaM_diagnosa_nama',
)); ?>

<?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?>

<?php //echo $form->textFieldRow($model,'diagnosa_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->textFieldRow($model,'diagnosakeperawatan_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); 
?>
<?php //echo $form->textAreaRow($model,'diagnosa_medis',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->textAreaRow($model,'diagnosa_keperawatan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php //echo $form->textAreaRow($model,'diagnosa_tujuan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->checkBoxRow($model,'diagnosa_keperawatan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<table>
    <thead>
        <tr>
            <td>
                <?php echo $form->errorSummary($model); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosa', 'DiagnosakeperawatanM_diagnosakeperawatan_kode', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model, 'diagnosa_id'); ?>
                        <?php $this->widget('MyJuiAutoComplete', array(
                            'name' => 'DiagnosaM[diagnosa_nama]',
                            'value' => (isset($modDiagnosa->diagnosa_id) ? $modDiagnosa->diagnosa_id : ""),
                            'source' => 'js: function(request, response) {
                                                               $.ajax({
                                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/Diagnosa') . '",
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
                                                            $(this).val(ui.item.diagnosa_nama);
                                                            return false;
                                                        }',
                                'select' => 'js:function( event, ui ) {
                                                            $("#' . CHtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id);
                                                            $("#DiagnosaM_diagnosa_nama").val(ui.item.diagnosa_nama);
                                                            return false;
                                                        }',
                            ),
                            'htmlOptions' => array(
                                'readonly' => false,
                                'placeholder' => 'Nama Diagnosa',
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                        )); ?>
                    </div>
                </div>

                <?php
                // Dialog buat nambah data diagnosa =========================
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogDiagnosa',
                    'options' => array(
                        'title' => 'Menambah data Diagnosa',
                        'autoOpen' => false,
                        'modal' => true,
                        'minWidth' => 600,
                        'height' => 400,
                        'resizable' => false,
                    ),
                ));

                $modDiagnosa = new RIDiagnosaM;
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sadiagnosa-m-grid',
                    'dataProvider' => $modDiagnosa->search(),
                    'filter' => $modDiagnosa,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Pilih',
                            'type' => 'raw',
                            'value' => '',

                            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectDiagnosa",
                                                      "onClick"=>"
                                                        $(\"#idDiagnosa\").val(\"$data->diagnosa_id\");
                                                        $(\"#' . CHtml::activeId($model, 'diagnosa_id') . '\").val(\"$data->diagnosa_id\");
                                                        $(\"#DiagnosaM_diagnosa_nama\").val(\"$data->diagnosa_nama\");
                                                        $(\"#dialogDiagnosa\").dialog(\"close\");    
                                                        "
                                                 ))',
                        ),
                        ////'diagnosa_id',
                        array(
                            'name' => 'diagnosa_id',
                            'value' => '$data->diagnosa_id',
                            'filter' => false,
                        ),
                        'diagnosa_kode',
                        'diagnosa_nama',

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
<table id="tbl-DiagnosaKeperawatan" class="table table-striped table-condensed">
    <thead>
        <tr>
            <th></th>
            <th>Kode</th>
            <th>Diagnosa Medis</th>
            <th>Diagnosa Keperawatan</th>
            <th>Diagnosa Tujuan</th>
            <th>Kriteria Hasil</th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td>

            </td>
            <td>
                <?php echo $form->textField($model, '[1]diagnosakeperawatan_kode', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textArea($model, '[1]diagnosa_medis', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </td>
            <td>
                <?php echo $form->textArea($model, '[1]diagnosa_keperawatan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textArea($model, '[1]diagnosa_tujuan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <?php //echo $form->checkBoxRow($model,'[1]lookup_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','LookupM_lookup_urutan')")); 
            ?>
            <td>
                <?php echo CHtml::activeTextField($modKriteriaHasil, '[1]kriteriahasil_nama', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus', 'style' => 'cursor:pointer;')); ?>
            </td>
        </tr>
    </tbody>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/diagnosakeperawatanM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit2c', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Diagnosa Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/rawatInap/DiagnosakeperawatanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-DiagnosaKeperawatan tbody tr:first').html();
    $('#tbl-DiagnosaKeperawatan>tbody>tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-DiagnosaKeperawatan>tbody>tr:last>td:last').append('$buttonMinus');
        
        renameInput('DiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('DiagnosakeperawatanM','diagnosa_medis');
        renameInput('DiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('DiagnosakeperawatanM','diagnosa_tujuan');
        $('#tbl-DiagnosaKeperawatan tr:last').find('input').val('');

}
function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        
        renameInput('DiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('DiagnosakeperawatanM','diagnosa_medis');
        renameInput('DiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('DiagnosakeperawatanM','diagnosa_tujuan');
    }
}
function addRow2(obj)
{
    var tr = $('#kriteria tbody tr:first').html();
    $(obj).parents('tr').find('#kriteria tbody tr:last').after('<tr>'+tr+'</tr>');
    $(obj).parents('tr').find('#kriteria tbody tr:last td:last').append('$buttonMinus');
        
        renameInput('KriteriahasilM','kriteriahasil_nama');
        $('#tbl-DiagnosaKeperawatan tr:last').find('input').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-DiagnosaKeperawatan tbody tr').length;
    var i = 1;
    $('#tbl-DiagnosaKeperawatan tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>
<script>
    function cekIsian() {
        var diagnosa_id = $('#DiagnosakeperawatanM_diagnosa_id').val();
        if (diagnosa_id == '') {
            myAlert('Silakan pilih Diagnosa');
            return false;
        } else {
            return true;
        }
    }
</script>