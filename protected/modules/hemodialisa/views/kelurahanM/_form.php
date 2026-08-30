
<?php  ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelurahan-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#propinsi',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
            <div class="control-group">
                <?php echo CHtml::label('Propinsi','propinsi',array('class'=>"control-label")) ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('propinsi', 'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('empty'=>'-- Pilih --',
                                                                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                            'ajax'=>array(
                                                                                'type'=>'POST',
                                                                                'url'=>Yii::app()->createUrl('ActionDynamic/GetKabupaten',array('encode'=>false,'namaModel'=>'','attr'=>'propinsi')),
                                                                                'update'=>'#kabupaten',))); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Kabupaten','kabupaten',array('class'=>"control-label")) ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('kabupaten', 'kabupaten_id', array(),array('empty'=>'-- Pilih --',
                                                                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                            'ajax'=>array(
                                                                                'type'=>'POST',
                                                                                'url'=>Yii::app()->createUrl('ActionDynamic/GetKecamatan',array('encode'=>false,'namaModel'=>'','attr'=>'kabupaten')),
                                                                                'update'=>'#SAKelurahanM_kecamatan_id',))); 
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'kecamatan_id',array(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
             
            <table id="tbl-kelurahan" class="table table-striped table-bordered table-condensed">
                <tr>
                    <td>
                        <?php echo $form->textField($model,'[1]kelurahan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kelurahan_nama'))); ?>
                        <span class="required">*</span>
                    </td>
                    <td>
                        <?php echo $form->textField($model,'[1]kelurahan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kelurahan_namalainnya'))); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model,'[1]kode_pos',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kode_pos'))); ?>
                    </td>
                    <td>
                        <?php echo CHtml::htmlButton( '<i class="icon-plus-sign icon-white"></i>', array('class'=>'btn btn-primary','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>
                    </td>
                </tr>
            </table>
        
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/kelurahanM/admin'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit2b',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-kelurahan tr:first').html();
    $('#tbl-kelurahan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kelurahan tr:last td:last').append('$buttonMinus');
    renameInput('HDKelurahanM','kelurahan_nama');
    renameInput('HDKelurahanM','kelurahan_namalainnya');
    renameInput('HDKelurahanM','kode_pos');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kelurahan tr').length;
    var i = 1;
    $('#tbl-kelurahan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('HDKelurahanM','kelurahan_nama');
        renameInput('HDKelurahanM','kelurahan_namalainnya');
        renameInput('HDKelurahanM','kode_pos');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAKelurahanM_1_kelurahan_namalainnya').value = nama.value.toUpperCase();
    }
</script>