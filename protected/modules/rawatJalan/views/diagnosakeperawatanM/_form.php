<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadiagnosakeperawatan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return validasi()'),
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

                <?php echo CHtml::label('Diagnosa', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'diagnosa_id');
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name' => 'DiagnosaM[diagnosa_nama]',
                        //                                    'value'=>$modDiagnosa->diagnosa_id,
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
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
                                                $("#' . CHtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id)
                                                return false;
                                            }',

                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event);",
                            'class' => 'required'
                        ),
                        // 'tombolDialog'=>array('idDialog'=>'dialogDiagnosa'),
                    ));
                    ?>
                </div>
                <?php
                echo CHtml::htmlButton(
                    '<i class="entypo-search "></i>',
                    array(
                        'onclick' => '$("#dialogDiagnosa").dialog("open");return false;',
                        'class' => 'btn btn-primary ',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari diagnosa",
                    )
                );
                ?>
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

                $modDiagnosa = new RJDiagnosaM;
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sadiagnosa-m-grid',
                    'dataProvider' => $modDiagnosa->search(),
                    'filter' => $modDiagnosa,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
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
<table id="tbl-DiagnosaKeperawatan" class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th></th>
            <th>Kode</th>
            <th>Diagnosa Medis</th>
            <th>Diagnosa Keperawatan</th>
            <th>Diagnosa Tujuan</th>
            <th>Kriteria Hasil</th>
            <th>&nbsp;</th>

        </tr>
    </thead>
    <tbody>
        <tr class="rows">
            <td>
                <?php echo CHtml::hiddenField('urutan'); ?>
            </td>
            <td>
                <?php echo $form->textField($model, '[1]diagnosakeperawatan_kode', array('class' => 'span1 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textArea($model, '[1]diagnosa_medis', array('class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textArea($model, '[1]diagnosa_keperawatan', array('class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textArea($model, '[1]diagnosa_tujuan', array('class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>

            <?php //echo $form->checkBoxRow($model,'[1]lookup_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','LookupM_lookup_urutan')")); 
            ?>

            <td>
                <table class="kriteria">
                    <tbody>
                        <tr>
                            <td>
                                <?php echo CHtml::activeTextField($modKriteriaHasil, '[1][1]kriteriahasil_nama', array('class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php
                                //               // echo CHtml::activeHiddenField($model, 'kriteriahasil_id');
                                //                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                //                                    'name'=>'KriteriahasilM[kriteriahasil_nama]',
                                //                                    'value'=>$modKriteriaHasil->kriteriahasil_id,
                                //                                    'source'=>'js: function(request, response) {
                                //                                                   $.ajax({
                                //                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/KriteriaHasil').'",
                                //                                                       dataType: "json",
                                //                                                       data: {
                                //                                                           term: request.term,
                                //                                                       },
                                //                                                       success: function (data) {
                                //                                                               response(data);
                                //                                                       }
                                //                                                   })
                                //                                                }',
                                //                                     'options'=>array(
                                //                                           'showAnim'=>'fold',
                                //                                           'minLength' => 2,
                                //                                           'focus'=> 'js:function( event, ui ) {
                                //                                                $(this).val(ui.item.value);
                                //                                                return false;
                                //                                            }',
                                //                                           'select'=>'js:function( event, ui ) {
                                //                                                $("#'.CHtml::activeId($model, 'kriteriahasil_id').'").val(ui.item.kriteriahasil_id)
                                //                                                return false;
                                //                                            }',
                                //                                    ),
                                //                                )); 
                                //                
                                ?>
                            </td>
                            <td>
                                <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow2(this)', 'id' => 'row1-plus', 'title' => "Klik untuk menambah kriteria hasil")); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger', 'onclick' => 'addRow(this)', 'id' => 'row1-plus', 'title' => "Klik untuk menambah baris")); ?>
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
        $this->createUrl($this->id . '/create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('create') . '";} ); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Diagnosa Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('diagnosakeperawatanM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-DiagnosaKeperawatan tbody tr:first').html();
    $('#tbl-DiagnosaKeperawatan>tbody>tr:last').after('<tr class="rows">'+tr+'</tr>');
    $('#tbl-DiagnosaKeperawatan>tbody>tr:last>td:last').append('$buttonMinus');
        
        renameInput('DiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('DiagnosakeperawatanM','diagnosa_medis');
        renameInput('DiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('DiagnosakeperawatanM','diagnosa_tujuan');        
        renameInput2('KriteriahasilM','kriteriahasil_nama');
        $('#tbl-DiagnosaKeperawatan tr:last').find('input').val('');

}
function delRow(obj)
{
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();

			renameInput('DiagnosakeperawatanM','diagnosakeperawatan_kode');
			renameInput('DiagnosakeperawatanM','diagnosa_medis');
			renameInput('DiagnosakeperawatanM','diagnosa_keperawatan');
			renameInput('DiagnosakeperawatanM','diagnosa_tujuan');
		}
	});
}
function addRow2(obj)
{
    var tr = $('.kriteria tbody tr:first').html();
    $(obj).parents('tr').find('.kriteria tbody tr:last').after('<tr>'+tr+'</tr>');
    $(obj).parents('tr').find('.kriteria tbody tr:last td:last').append('$buttonMinus');
        renameInput2('KriteriahasilM','kriteriahasil_nama');
        $('.kriteria tr:last').find('input').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-DiagnosaKeperawatan tbody tr.rows').length;
    var i = 1;
    $('#tbl-DiagnosaKeperawatan tbody tr.rows').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        
    i++;    
    });
}

function renameInput2(modelName,attributeName)
{
    var trLength = $('#tbl-DiagnosaKeperawatan tbody tr').length;
    var i = 1;
    $('.kriteria').each(function(){
        var x = 1;
        $(this).find('tr').each(function(){
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+x+']['+attributeName+']');
            $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+x+']['+attributeName+']');
            $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+x+']['+attributeName+']');
            x++;
        });
    i++;    
    });
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function validasi() {
        var x = 0;
        $('input.required,textarea.required,select.required').each(function() {
            if ($(this).val() == "") {
                $(this).addClass("error");
                x++;
            } else {
                $(this).removeClass("error");
            }
        });
        if (x > 0) {
            return false;
        } else {
            return true;
        }

    }
</script>