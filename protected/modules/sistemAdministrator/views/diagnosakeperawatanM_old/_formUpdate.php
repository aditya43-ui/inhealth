

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadiagnosakeperawatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SADiagnosakeperawatanM_diagnosakeperawatan_kode',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
            <?php //echo CHtml::textField('BKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
<!--<div class="control-group">
            <label for="SADiagnosakeperawatanM_diagnosakeperawatan_id" class="control-label">Diagnosa</label>
            <div class="controls">-->
            <?php 
               
//               echo CHtml::activeHiddenField($model, 'diagnosa_id');
//                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
//                                    'name'=>'DiagnosaM_diagnosa_nama',
//                                    'value'=>$model->diagnosa_nama,
//                                    'source'=>'js: function(request, response) {
//                                                   $.ajax({
//                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/Diagnosa').'",
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
//                                                $("#'.CHtml::activeId($model, 'diagnosa_id').'").val(ui.item.diagnosa_id)
//                                                return false;
//                                            }',
//                                    ),
//                                )); 
                ?>  
                <?php 
//                echo CHtml::htmlButton('<i class="entypo-search"></i>',
//                            array('onclick'=>'$("#dialogDiagnosa").dialog("open");return false;',
//                                  'class' => 'btn btn-danger',
//                                  'onkeypress'=>"return $(this).focusNextInputField(event)",
//                                  'rel'=>"tooltip",
//                                  'title'=>"Klik untuk mencari diagnosa",)); 
                ?>
                <?php 
// Dialog buat nambah data diagnosa =========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
//    'id'=>'dialogDiagnosa',
//    'options'=>array(
//        'title'=>'Menambah data Diagnosa',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'minWidth'=>600,
//        'minHeight'=>400,
//        'resizable'=>false,
//    ),
//));
//
// 
//$this->widget('ext.bootstrap.widgets.BootGridView',array( 
//    'id'=>'sadiagnosa-m-grid', 
//    'dataProvider'=>$modDiagnosa->search(), 
//    'filter'=>$modDiagnosa, 
//        'template'=>"{summary}\n{items}\n{pager}", 
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
//    'columns'=>array(
//        array(
//                    'header'=>'Pilih',
//                    'type'=>'raw',
//                    'value'=>'',
//            
//            'value'=>'CHtml::link("<i class=\"icon-check\"></i>","#", array("id" => "selectDiagnosa",
//                                                      "onClick"=>"
//                                                        $(\"#idDiagnosa\").val(\"$data->diagnosa_id\");
//                                                        $(\"#'.CHtml::activeId($model,'diagnosa_id').'\").val(\"$data->diagnosa_id\");
//                                                        $(\"#DiagnosaM_diagnosa_nama\").val(\"$data->diagnosa_nama\");
//                                                        $(\"#dialogDiagnosa\").dialog(\"close\");    
//                                                        "
//                                                 ))',
//                ), 
//        ////'diagnosa_id',
//        array( 
//                        'name'=>'diagnosa_id', 
//                        'value'=>'$data->diagnosa_id', 
//                        'filter'=>false, 
//                ),
//        'diagnosa_kode',
//        'diagnosa_nama',
//        
//        /*
//        'diagnosa_imunisasi',
//        'diagnosa_aktif',
//        */
//       ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
?>

                <?php //$this->endWidget(); ?>
 

<!--</div>
     </div>-->
            <?php echo $form->textFieldRow($model, 'diagnosa_nama', array('readonly'=>'readonly ')); ?>
            <?php echo $form->hiddenField($model, 'diagnosa_id'); ?>
            <?php echo $form->hiddenField($model,'diagnosakeperawatan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'diagnosakeperawatan_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model,'diagnosa_medis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model,'diagnosa_keperawatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model,'diagnosa_tujuan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model,'diagnosa_keperawatan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
   
        
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                           Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/diagnosakeperawatanM/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
		<?php
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-RencanaKeperawatan tbody tr:first').html();
    $('#tbl-DiagnosaKeperawatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-DiagnosaKeperawatan tr:last td:last').append('$buttonMinus');
        
        renameInput('SADiagnosakeperawatanM','diagnosa_id');
        renameInput('SADiagnosakeperawatanM','diagnosakeperawatan_id');
        renameInput('SADiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('SADiagnosakeperawatanM','diagnosa_medis');
        renameInput('SADiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('SADiagnosakeperawatanM','diagnosa_tujuan');
    $('#tbl-DiagnosaKeperawatan tr:last').find('input').val('');
    $('#tbl-DiagnosaKeperawatan tr:last').find('textarea').val('');
    $('#tbl-DiagnosaKeperawatan tr:last').find('select').val('');

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

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('SADiagnosakeperawatanM','diagnosa_id');
        renameInput('SADiagnosakeperawatanM','diagnosakeperawatan_id');
        renameInput('SADiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('SADiagnosakeperawatanM','diagnosa_medis');
        renameInput('SADiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('SADiagnosakeperawatanM','diagnosa_tujuan');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>