 <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'sakecamatan-m-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#propinsi',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    ));
    ?>

 <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

 <?php echo $form->errorSummary($model); ?>
 <div class="panel panel-success">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="entypo-credit-card"></i> Tabel <b>Kecamatan</b>
         </div>
     </div>
     <div class="panel-body table-responsive">
         <table>
             <tr>
                 <td>
                     <div class="control-group">
                         <?php echo CHtml::label('Provinsi', 'propinsi', array('class' => "control-label")) ?>
                         <div class="controls">
                             <?php
                                echo CHtml::dropDownList('propinsi', 'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'), array(
                                    'empty' => '-- Pilih --',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => Yii::app()->createUrl('ActionDynamic/GetKabupatendrNamaPropinsi', array('encode' => false, 'namaModel' => '', 'attr' => 'propinsi')),
                                        'update' => '#SAKecamatanM_kabupaten_id',
                                    )
                                ));
                                ?>

                         </div>
                     </div>
                 </td>
                 <td>
                     <?php echo $form->dropDownListRow($model, 'kabupaten_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                 </td>
             </tr>
         </table>
         <table id="tbl-kecamatan" class="table table-striped table-bordered table-condensed">
             <?php
                $x = 0;
                ?>
             <tr>
                 <td>
                     <?php echo $form->textField($model, '[1]kecamatan_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kecamatan_nama'))); ?>
                     <span class="required">*</span>
                 </td>
                 <td>
                     <?php echo $form->textField($model, '[1]kecamatan_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kecamatan_namalainnya'))); ?>
                 </td>
                 <td>
                     <?php echo $form->textField($model, '[1]longitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('longitude'))); ?>
                     <?php
                        echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
                            'class' => 'btn btn-primary btn-location',
                            'rel' => 'tooltip',
                            'id' => 'yw1',
                            'title' => 'Klik untuk mencari Longitude & Latitude',
                        ));
                        ?>
                 </td>
                 <td>
                     <?php echo $form->textField($model, '[1]latitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('latitude'))); ?>
                 </td>
                 <td>
                     <?php echo CHtml::link('<i class="icon-plus icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);$(this).focusNextInputField(event)', 'id' => 'row1-plus')); ?>
                 </td>
                 <!--Extension location-picker latitude & longitude-->
                 <?php
                    $this->widget('ext.LocationPicker2.CoordinatePicker', array(
                        'model' => $model,
                        'latitudeAttribute' => '[1]latitude',
                        'longitudeAttribute' => '[1]longitude',
                        //optional settings
                        'editZoom' => 12,
                        'pickZoom' => 7,
                        'defaultLatitude' => $latitude,
                        'defaultLongitude' => $longitude,
                    ));
                    ?>
             </tr>
         </table>
     </div>
 </div>
 <div class="form-actions">
     <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
     <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/kecamatanM/admin'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
        ?>
     <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kecamatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('KecamatanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        );
        ?>
     <?php
        $content = $this->renderPartial('../tips/tipsaddedit2b', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
 </div>
 <script type="text/javascript">
     var tr = new String(<?php echo CJSON::encode($this->renderPartial('_rowKecamatan', array('form' => $form, 'model' => $model), true)); ?>);
 </script>
 <?php $this->endWidget(); ?>

 <?php
    $buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
    $confimMessage = Yii::t('mds', 'Do You want to remove?');
    $js = <<< JSCRIPT
function addRow(obj)
{
//    var tr = $('#tbl-kecamatan tr:first').html();
    $('#tbl-kecamatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kecamatan tr:last td:last').append('$buttonMinus');
    renameInput('SAKecamatanM','kecamatan_nama');
    renameInput('SAKecamatanM','kecamatan_namalainnya');
    renameInput('SAKecamatanM','longitude');
    renameInput('SAKecamatanM','latitude');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kecamatan tr').length;
    var i = 1;
    $('#tbl-kecamatan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName);
        idButton = 'yw'+i;
		$(this).find('.btn-location').attr('id',idButton);
		if(attributeName=='latitude'){
			registerJSlocation(idButton,modelName,i);
		}
		i++;
    });
}
	
function registerJSlocation(id,modelName,i){
$('#'+id).on('click', function(){ 
	$('#'+id).coordinate_picker({'lat_selector':'#'+modelName+'_'+i+'_latitude','long_selector':'#'+modelName+'_'+i+'_longitude','default_lat':'-7.091932','default_long':'107.672491','edit_zoom':12,'pick_zoom':7})});
}		
function delRow(obj)
{
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();
			renameInput('SAKecamatanM','kecamatan_nama');
			renameInput('SAKecamatanM','kecamatan_namalainnya');
			renameInput('SAKecamatanM','longitude');
			renameInput('SAKecamatanM','latitude');
		}
	});
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
    ?>

 <script type="text/javascript">
     function namaLain(obj) {
         $(obj).parents('tr').find("input[name*='kecamatan_namalainnya']").val($(obj).val().toUpperCase());
     }
 </script>