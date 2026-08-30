
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakabupaten-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#SAKabupatenM_propinsi_id',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
                
            <?php echo $form->dropDownListRow($model,'propinsi_id',  CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        
	<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kabupaten</b></div>
	</div>
		<div class="panel-body table-responsive">
	<table  class="table table-bordered table-striped datatable table-responsive">
            <tr>
                <th style ="text-align:center;">Kabupaten</th>
                <th style ="text-align:center;">Nama Lain</th>
                <th style ="text-align:center;">Latitude</th>
                <th style ="text-align:center;">Longitude</th>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textField($model,'kabupaten_nama',array('onkeyup'=>"namaLain(this)", 'class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kabupaten_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'kabupaten_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kabupaten_namalainnya'))); ?>
                </td>                
                <td>

                        <?php echo $form->textField($model,'latitude',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=> $model->getAttributeLabel('latitude'))); ?>
                        <?php echo CHtml::htmlButton('<i class="entypo-map"></i>',
                                                    array(
                                                            'class'=>'btn btn-primary btn-location',
                                                            'rel'=>'tooltip',
                                                            'id'=>'yw1',
                                                            'onclick' =>'changeSize()',
                                                            'title'=>'Klik untuk mencari Longitude & Latitude',)); 
                        ?>                        

                </td>
                <td>
                     <?php echo $form->textField($model,'longitude',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=> $model->getAttributeLabel('longitude'))); ?>                    
               
                    <!--Extension location-picker latitude & longitude-->
                   <?php               

                           $this->widget('ext.LocationPicker2.CoordinatePicker', array(
                                   'model' => $model,
                                   'latitudeAttribute' => 'latitude',
                                   'longitudeAttribute' => 'longitude',
                                   //optional settings
                                   'editZoom' => 12,
                                   'pickZoom' => 7,
                                   'defaultLatitude' => $model->latitude,
                                   'defaultLongitude' => $model->longitude,
                           ));
                   ?>    
                                        
                </td>
                <td>
                    <?php echo CHtml::htmlButton( '<i class="entypo-plus-circled"></i>', array('class' => 'btn btn-danger','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
	</div>
	</div>
         <table id="tbl-kabupaten" class="table table-striped table-bordered table-condensed">
             <?php
                echo CHtml::hiddenField('Nomor',0, array('id'=>'nomor'));
             ?>
           <?php    /*       
            <tr>
                <td>
                    <?php echo $form->textField($model,'[1]kabupaten_nama',array('class'=>'span3 required', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kabupaten_nama'), 'readonly'=>true)); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]kabupaten_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kabupaten_namalainnya'), 'readonly'=>true)); ?>
                </td>                
                <td>

                        <?php echo $form->textField($model,'[1]latitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)); ?>                                       

                </td>
                <td>
                     <?php echo $form->textField($model,'[1]longitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)); ?>                                                                        
                </td>                
            </tr> 
        */    ?>
        </table>
            
            <?php //echo $form->checkBoxRow($model,'kabupaten_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/kabupatenM/admin'), 
                                    array('class' => 'btn btn-default',
                                    'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}'=>'<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit2b',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>

<?php $this->endWidget(); ?>

<?php
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT

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
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
   
    function registerJSlocation(id,modelName,i)
     {
        $('#'+id).on('click', function(){ 
                $('#'+id).coordinate_picker({'lat_selector':'#'+modelName+'_'+i+'_latitude','long_selector':'#'+modelName+'_'+i+'_longitude','default_lat':'-7.091932','default_long':'107.672491','edit_zoom':12,'pick_zoom':7})                                
            });
                
    }
        
    function changeSize()
    {            
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:600px;';            
    }
    
    function addRow(obj)//input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']
    {   
        var buttonMinus = '<?php echo CHtml::link('<i class="entypo-minus-circled"></i>', '#', array('class' => 'btn btn-default','onclick'=>'delRow(this); return false;')) ?>';                
        var no = eval($('#nomor').val())+1;        
        var kabupaten = $('#RDKabupatenM_kabupaten_nama').val();
        var namalain = $('#RDKabupatenM_kabupaten_namalainnya').val();
        
        if ( (kabupaten != '') || (namalain != '') ){
            var td =    '   <td><input name = "RDKabupatenM['+no+'][kabupaten_nama]"  type = "text" id = "RDKabupatenM_'+no+'_kabupaten_nama" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#RDKabupatenM_kabupaten_nama').val()+'"> <span class="required">*<span></td>\n\
                            <td><input name = "RDKabupatenM['+no+'][kabupaten_namalainnya]" type = "text" id = "RDKabupatenM_'+no+'_kabupaten_namalainnya" class="span3 required" onkeypress = "return $(this).focusNextInputField(event);", maxlength = "200"  readonly = TRUE value = "'+$('#RDKabupatenM_kabupaten_namalainnya').val()+'"> <span class="required">*<span></td>\n\
                            <td><input name = "RDKabupatenM['+no+'][latitude]" type = "text" id = "RDKabupatenM_'+no+'_latitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);",  readonly = TRUE value = "'+$('#RDKabupatenM_latitude').val()+'"> </td>\n\
                            <td><input name = "RDKabupatenM['+no+'][longitude]" type = "text" id = "RDKabupatenM_'+no+'_longitude" class="span3 " onkeypress = "return $(this).focusNextInputField(event);", readonly = TRUE value = "'+$('#RDKabupatenM_longitude').val()+'"> </td>\n\
                            <td>'+buttonMinus+'</td>';                
            $('#tbl-kabupaten').append('<tr>'+td+'</tr>');
        }else{
            myAlert('Maaf Kabupaten dan Nama  Lain Tidak Boleh Kosong');
        }
                
        $('#nomor').val(no);
        clearRow();
    }
    
    function delRow(obj)
    {
        var no = $('#nomor').val();
        myConfirm("Yakin Akan Menghapus Data ini?","Perhatian!",function(r) {
            if (r){
                 $(obj).parent().parent().remove();
            //renameInput('RDKabupatenM','kabupaten_nama');
            //renameInput('RDKabupatenM','kabupaten_namalainnya');
                $('#nomor').val(eval(no)-1);
           }
       });        
    }
    
    function namaLain(nama)
    {
        document.getElementById('RDKabupatenM_kabupaten_namalainnya').value = nama.value.toUpperCase();
    }
    
    function clearRow()
    {
        $('#RDKabupatenM_kabupaten_nama').val('');
        $('#RDKabupatenM_kabupaten_namalainnya').val('');
        $('#RDKabupatenM_latitude').val('');
        $('#RDKabupatenM_longitude').val('');
    }
</script>