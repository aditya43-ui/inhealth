 <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'sakabupaten-m-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#SAKabupatenM_propinsi_id',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>

 <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

 <?php echo $form->errorSummary($model); ?>

 <?php echo $form->dropDownListRow($model, 'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>

 <div class="panel panel-success">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="entypo-credit-card"></i> Tabel <b>Kabupaten</b>
         </div>
     </div>
     <div class="panel-body table-responsive">
         <table id="tbl-kabupaten" class="table table-striped table-bordered table-condensed">
             <tr>
                 <td>
                     <?php echo $form->textField($model, '[1]kabupaten_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => "namaLain(this)", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kabupaten_nama'))); ?>
                     <span class="required">*</span>
                 </td>
                 <td>
                     <?php echo $form->textField($model, '[1]kabupaten_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kabupaten_namalainnya'))); ?>
                 </td>
                 <td>
                     <?php echo CHtml::button('+', array('class' => 'btn btn-primary', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);$(this).nextFocus()', 'id' => 'row1-plus')); ?>
                 </td>
             </tr>
         </table>
     </div>
 </div>

 <?php //echo $form->checkBoxRow($model,'kabupaten_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
    ?>
 <div class="form-actions">
     <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
     <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/kabupatenM/admin'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
     <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('KabupatenM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        );
        ?>
     <?php
        $content = $this->renderPartial('../tips/tipsaddedit2b', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
 </div>

 <?php $this->endWidget(); ?>

 <?php
    $buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
    $confimMessage = Yii::t('mds', 'Do You want to remove?');
    $js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-kabupaten tr:first').html();
    $('#tbl-kabupaten tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kabupaten tr:last td:last').append('$buttonMinus');
    renameInput('SAKabupatenM','kabupaten_nama');
    renameInput('SAKabupatenM','kabupaten_namalainnya');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kabupaten tr').length;
    var i = 1;
    $('#tbl-kabupaten tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function delRow(obj)
{	
	myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();
			renameInput('SAKabupatenM','kabupaten_nama');
			renameInput('SAKabupatenM','kabupaten_namalainnya');
		}
	});
 }
JSCRIPT;
    Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
    ?>

 <script type="text/javascript">
     function namaLain(nama) {
         document.getElementById(nama.id + 'lainnya').value = nama.value.toUpperCase();
     }
 </script>