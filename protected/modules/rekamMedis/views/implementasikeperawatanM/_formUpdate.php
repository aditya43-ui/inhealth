<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saimplementasikeperawatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('value'=>$row->diagnosakeperawatan_id, 'class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'ImplementasikeperawatanM_implementasikeperawatan_kode','ImplementasikeperawatanM_rencanakeperawatan_id','')")); ?>
            <?php //echo $form->textFieldRow($model,'rencanakeperawatan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'implementasikeperawatan_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php //echo $form->textAreaRow($model,'implementasi_nama',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->checkBoxRow($model,'iskolaborasiimplementasi', array('onkeypress'=>"return $(this).focusNextInputField(event);",'checked'=>'checked')); ?>
	
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
            <tbody>
                <?php foreach($modImplementasiKeperawatan as $i=>$ImplementasiKeperawatan) { ?>
                <tr>

                <?php $isKolaborasi = array(
                                        0 => 'Tidak',
                                        1 => 'Ya'); ?>
                <td>
                    <?php echo $form->hiddenField($ImplementasiKeperawatan, "[$i]implementasikeperawatan_id", array('value'=>$ImplementasiKeperawatan->implementasikeperawatan_id));?>
                    <?php echo $form->dropDownList($ImplementasiKeperawatan,"[$i]rencanakeperawatan_id",CHtml::listData(RencanakeperawatanM::model()->findAll(), 'rencanakeperawatan_id', 'rencana_kode'), array('value'=>$ImplementasiKeperawatan->rencanakeperawatan_id, 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> 
                </td>
                <td>
                    <?php echo $form->textField($ImplementasiKeperawatan,"[$i]implementasikeperawatan_kode",array('value'=>$ImplementasiKeperawatan->implementasikeperawatan_kode,'class'=>'span2','onkeypress'=>"return $(this).focusNextInputField(event);")); ?> 
                </td>
                <td>
                    <?php echo $form->textArea($ImplementasiKeperawatan,"[$i]implementasi_nama",array('value'=>$ImplementasiKeperawatan->implementasi_nama,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                </td>
                
               <td>
                   
                   <?php echo $form->dropDownList($ImplementasiKeperawatan,'[1]iskolaborasiimplementasi',  $isKolaborasi,array('value'=>$ImplementasiKeperawatan->iskolaborasiimplementasi,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)array('empty'=>'-- Pilih --')")); ?>
                   
                </td>
                
                                 
                              
                        
              
                            <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                    <?php //echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default','onclick'=>'delRow(this); return false;')); ?>
                </td>
                        
              <?php } ?>           
                 
            </tr>
            </tbody>
            
        
        </table>
        
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.implementasikeperawatanM.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	

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
        renameInput('SAImplementasikeperawatanM','implementasikeperawatan_id');
        renameInput('SAImplementasikeperawatanM','rencanakeperawatan_id');
        renameInput('SAImplementasikeperawatanM','implementasikeperawatan_kode');
        renameInput('SAImplementasikeperawatanM','implementasi_nama');
        renameInput('SAImplementasikeperawatanM','iskolaborasiimplementasi');
        $('#tbl-ImplementasiKeperawatan tr:last').find('input').val('');
        $('#tbl-ImplementasiKeperawatan tr:last').find('textarea').val('');
        $('#tbl-ImplementasiKeperawatan tr:last').find('select').val('');

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
        renameInput('SAImplementasikeperawatanM','implementasikeperawatan_id');
        renameInput('SAImplementasikeperawatanM','rencanakeperawatan_id');
        renameInput('SAImplementasikeperawatanM','implementasikeperawatan_kode');
        renameInput('SAImplementasikeperawatanM','implementasi_nama');
        renameInput('SAImplementasikeperawatanM','iskolaborasiimplementasi');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
                ?>
