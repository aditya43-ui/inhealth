

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sarencana-keperawatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#DiagnosakeperawatanM_diagnosakeperawatan_kode',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'rencana_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php //echo $form->textAreaRow($model,'rencana_intervensi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textAreaRow($model,'rencana_rasionalisasi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->checkBoxRow($model,'iskolaborasiintervensi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
            <?php echo CHtml::label('Diagnosa Keperawatan','DiagnosakeperawatanM_diagnosakeperawatan_kode',array('class'=>'control-label')); ?>
            <div class="controls">
            <?php 
               echo CHtml::hiddenField('diagnosakeperawatan_id');
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'name'=>'DiagnosakeperawatanM[diagnosakeperawatan_kode]',
                                    'value'=>$modDiagnosa->diagnosakeperawatan_id,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/DiagnosaKeperawatan').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                     'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'diagnosakeperawatan_id').'").val(ui.item.diagnosakeperawatan_id)
                                                return false;
                                            }',
                                    ),
                                )); 
                ?>  
                <?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
                            array('onclick'=>'$("#dialogDiagnosaKeperawatan").dialog("open");return false;',
                                  'class' => 'btn btn-danger',
                                  'onkeypress'=>"return $(this).focusNextInputField(event)",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari diagnosa keperawatan",)); ?>
            </div>
            </div>
                <?php 
// Dialog buat nambah data diagnosa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDiagnosaKeperawatan',
    'options'=>array(
        'title'=>'Menambah data Diagnosa Keperawatan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>600,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

 $modDiagnosakeperawatan =new SADiagnosakeperawatanM;
$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'sadiagnosakeperawatan-m-grid', 
    'dataProvider'=>$modDiagnosakeperawatan->search(), 
    'filter'=>$modDiagnosakeperawatan, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array(
        array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'',
            
            'value'=>'CHtml::link("<i class=\"icon-check\"></i>","#", array("id" => "selectDiagnosaKeperawatan",
                                                      "onClick"=>"
                                                        $(\"#diagnosakeperawatan_id\").val(\"$data->diagnosakeperawatan_id\");
                                                        $(\"#'.CHtml::activeId($model,'diagnosakeperawatan_id').'\").val(\"$data->diagnosakeperawatan_id\");
                                                        $(\"#DiagnosakeperawatanM_diagnosakeperawatan_kode\").val(\"$data->diagnosa_medis\");
                                                        $(\"#dialogDiagnosaKeperawatan\").dialog(\"close\");    
                                                        "
                                                 ))',
                ), 
        ////'diagnosa_id',
        array( 
                        'name'=>'diagnosakeperawatan_kode', 
                        'value'=>'$data->diagnosakeperawatan_kode', 
                        'filter'=>false, 
                ),
        //'diagnosakeperawatan_kode',
        'diagnosa_medis',
        
        /*
        'diagnosa_imunisasi',
        'diagnosa_aktif',
        */
       ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

                <?php $this->endWidget(); ?>
            <table id="tbl-Rencanakeperawatan" class="table table-striped table-bordered table-condensed">
           <thead>
            <tr>
               
                <th>Kode</th>
                <th>Rencana Intervensi</th>
                <th>Rencana Rasionalisasi</th>
                <th>Kolaborasi Intervensi</th>
                <th>&nbsp;</th>
                
                
            </tr>
            </thead>
            
            <tr>

                <?php $isKolaborasi = array(
                                        0 => 'Tidak',
                                        1 => 'Ya'); ?>
                <td>
                    <?php echo $form->textField($model,'[1]rencana_kode',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> 
                </td>
                <td>
                    <?php echo $form->textArea($model,'[1]rencana_intervensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                </td>
                <td>
                    <?php echo $form->textArea($model,'[1]rencana_rasionalisasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
               <td>
                   
                   <?php echo $form->dropDownList($model,'[1]iskolaborasiintervensi',  $isKolaborasi,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                   
                </td>
                <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                </td>
                        </div>
                    </div>      
                </td> 
            </tr>
        
        </table>
            
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.rencanaKeperawatanM.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>	

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-Rencanakeperawatan tbody tr:first').html();
    $('#tbl-Rencanakeperawatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-Rencanakeperawatan tr:last td:last').append('$buttonMinus');
        
        renameInput('RencanakeperawatanM','rencana_kode');
        renameInput('RencanakeperawatanM','rencana_intervensi');
        renameInput('RencanakeperawatanM','rencana_rasionalisasi');
        renameInput('RencanakeperawatanM','iskolaborasiintervensi');
$('#tbl-Rencanakeperawatan tr:last').find('input').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-Rencanakeperawatan tbody tr').length;
    var i = 1;
    $('#tbl-Rencanakeperawatan tbody tr').each(function(){
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
        
        renameInput('RencanakeperawatanM','rencana_kode');
        renameInput('RencanakeperawatanM','rencana_intervensi');
        renameInput('RencanakeperawatanM','rencana_rasionalisasi');
        renameInput('RencanakeperawatanM','iskolaborasiintervensi');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>