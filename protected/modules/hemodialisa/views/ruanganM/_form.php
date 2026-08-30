<?php  ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saruangan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#instalasi_id',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table class="table-condensed">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Instalasi','instalasi_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                     <?php echo CHtml::dropDownList('instalasi_id','',
                           CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
                           array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                           'empty'=>'-- Pilih --','onchange'=>'getRiwayatRuangan(this)')); ?>
                        </div>
                    </div>
                </td>
                <td>
                     <?php echo $form->textField($modRiwayatRuangan,'tglpenetapanruangan',array('style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$modRiwayatRuangan->getAttributeLabel('tglpenetapanruangan'))); ?>
                </td>
                <td>
                     <?php echo $form->textField($modRiwayatRuangan,'nopenetapanruangan',array('style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$modRiwayatRuangan->getAttributeLabel('nopenetapanruangan'))); ?>
                </td>
                <td>
                     <?php echo $form->textField($modRiwayatRuangan,'tentangpenetapan',array('style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$modRiwayatRuangan->getAttributeLabel('tentangpenetapan'))); ?>
                </td>
            </tr>
        </table>        
        
        <table id="tbl-ruangan" class="table table-striped table-bordered table-condensed">
            <tr>
                <td>
                    <?php echo $form->textField($model,'[1]ruangan_nama',array('class'=>'inputRequire','style'=>'width: 124px;', 'onkeyup'=>"namaLain(this)",'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('ruangan_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]ruangan_namalainnya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_namalainnya'))); ?>
                </td>
                 <td>
                    <?php // echo $form->textField($model,'[1]ruangan_lokasi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_lokasi'))); ?>
                    <?php 
                    echo $form->dropDownList($model,'[1]ruangan_lokasi',
                          CHtml::listData($model->LokasiItems, 'lookup_value', 'lookup_name'),
                          array('onkeypress'=>"return $(this).focusNextInputField(event)",
                                'empty'=>'-- Pilih Lokasi --',
                                'class'=>'span2')); 
                                ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]ruangan_singkatan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_singkatan'))); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]ruangan_jenispelayanan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_jenispelayanan'))); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]ruangan_fasilitas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_fasilitas'))); ?>
                    <?php echo Chtml::activeFileField($model,'[1]ruangan_image',array('maxlength'=>254,'Hint'=>'Isi Jika Akan Menambahkan Logo','placeholder'=> $model->getAttributeLabel('ruangan_image'))); ?>
                </td>
                
                
                <td>
                    <?php echo CHtml::button( '+', array('class'=>'btn btn-primary','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
            
            <?php //echo $form->checkBoxRow($model,'kelaspelayanan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'formSubmit(this,event)','onclick'=>'formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/ruanganM/admin'), 
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
$urlGetRiwayatRuangan=$this->createUrl('getRiwayatRuangan');
$tglpenetapanruangan= CHtml::activeId($modRiwayatRuangan,'tglpenetapanruangan');
$nopenetapanruangan=CHtml::activeId($modRiwayatRuangan,'nopenetapanruangan');
$tentangpenetapan=CHtml::activeId($modRiwayatRuangan,'tentangpenetapan');

$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-ruangan tr:first').html();
    $('#tbl-ruangan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-ruangan tr:last td:last').append('$buttonMinus');
    renameInput('HDRuanganM','ruangan_nama');
    renameInput('HDRuanganM','ruangan_namalainnya');
    renameInput('HDRuanganM','ruangan_lokasi');

    renameInput('HDRuanganM','ruangan_singkatan');
    renameInput('HDRuanganM','ruangan_jenispelayanan');
    renameInput('HDRuanganM','ruangan_fasilitas');
    renameInput('HDRuanganM','ruangan_image');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-penjaminPasien tr').length;
    var i = 1;
    $('#tbl-ruangan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function getRiwayatRuangan(obj)
{
   $.post("${urlGetRiwayatRuangan}",{instalasi_id: obj.value},
        function(data){
        $('#${tglpenetapanruangan}').val(data.tglpenetapanruangan);
        $('#${nopenetapanruangan}').val(data.nopenetapanruangan);
        $('#${tentangpenetapan}').val(data.tentangpenetapan);
        
        },"json");
                   
                
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('HDRuanganM','ruangan_nama');
        renameInput('HDRuanganM','ruangan_namalainnya');
        renameInput('HDRuanganM','ruangan_lokasi');
    }
}


JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SARuanganM_1_ruangan_namalainnya').value = nama.value.toUpperCase();
    }
</script>