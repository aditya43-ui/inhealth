

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saimplementasikeperawatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#DiagnosakeperawatanM_diagnosakeperawatan_kode',
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

            <?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'rencanakeperawatan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'implementasikeperawatan_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php //echo $form->textAreaRow($model,'implementasi_nama',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->checkBoxRow($model,'iskolaborasiimplementasi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
            <?php echo CHtml::label('Diagnosa Keperawatan','DiagnosakeperawatanM_diagnosakeperawatan_kode',array('class'=>'control-label')); ?>
            <div class="controls">
            <?php 
               echo CHtml::activeHiddenField($model, 'diagnosakeperawatan_id');
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
                                                $(this).val(ui.item.value);
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
                                                        $(\"#idDiagnosakeperawatan\").val(\"$data->diagnosakeperawatan_id\");
                                                        $(\"#'.CHtml::activeId($model,'diagnosakeperawatan_id').'\").val(\"$data->diagnosakeperawatan_id\");
                                                        $(\"#DiagnosakeperawatanM_diagnosakeperawatan_kode\").val(\"$data->diagnosakeperawatan_kode\");
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
        
        'diagnosa_medis',
        
        /*
        'diagnosa_imunisasi',
        'diagnosa_aktif',
        */
       ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

                <?php $this->endWidget(); ?>
            </div>
            </div>
                    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

                <table id="tbl-ImplementasiKeperawatan" class="table table-striped table-bordered table-condensed">
           <thead>
            <tr>
               
                <th>Rencana Keperawatan</th>
                <th>Implementasi Kode</th>
                <th>Implementasi Nama</th>
                <th>Kolaborasi Implementasi</th>
                
                
            </tr>
            </thead>
            
            <tr>

                <?php $isKolaborasi = array(
                                        0 => 'Tidak',
                                        1 => 'Ya'); ?>
                <td>
                    <?php echo $form->dropDownList($model,'[1]rencanakeperawatan_id',CHtml::listData(RencanakeperawatanM::model()->findAll(), 'rencanakeperawatan_id', 'rencana_kode'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]implementasikeperawatan_kode',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> 
                </td>
                <td>
                    <?php echo $form->textArea($model,'[1]implementasi_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                </td>
                
               <td>
                   
                   <?php echo $form->dropDownList($model,'[1]iskolaborasiimplementasi',  $isKolaborasi,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)array('empty'=>'-- Pilih --')")); ?>
                   
                </td>
                
                                 
                              
                        
              
                            <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                </td>
                        
                         
                 
            </tr>
        
        </table>
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.implementasikeperawatanM.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php
$content = $this->renderPartial('../tips/tips',array(),true);
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
    var tr = $('#tbl-ImplementasiKeperawatan tbody tr:first').html();
    $('#tbl-ImplementasiKeperawatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-ImplementasiKeperawatan tr:last td:last').append('$buttonMinus');
        
        renameInput('ImplementasikeperawatanM','rencanakeperawatan_id');
        renameInput('ImplementasikeperawatanM','implementasikeperawatan_kode');
        renameInput('ImplementasikeperawatanM','implementasi_nama');
        renameInput('ImplementasikeperawatanM','iskolaborasiimplementasi');
        $('#tbl-ImplementasiKeperawatan tr:last').find('input').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-ImplementasiKeperawatan tbody tr').length;
    var i = 1;
    $('#tbl-ImplementasiKeperawatan tbody tr').each(function(){
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
        
        renameInput('ImplementasikeperawatanM','rencanakeperawatan_id');
        renameInput('ImplementasikeperawatanM','implementasikeperawatan_kode');
        renameInput('ImplementasikeperawatanM','implementasi_nama');
        renameInput('ImplementasikeperawatanM','iskolaborasiimplementasi');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>
