<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<br><br>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'selesaioperasi-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<?php echo $form->errorSummary($modRencanaOperasi); ?>
<div class="control-group">
<?php echo $form->labelEx($modRencanaOperasi[0],'selesaioperasi', array('class'=>'control-label','onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
	<div class="controls">  
	<?php $this->widget('MyDateTimePicker',array(
						  'model'=>$modRencanaOperasi[0],
						  'attribute'=>'selesaioperasi',
						  'mode'=>'datetime',
						  'options'=> array(
							  'dateFormat'=>Params::DATE_FORMAT,
						  ),
						  'htmlOptions'=>array('readonly'=>true,
												'onkeypress'=>"return $(this).focusNextInputField(event)",
												'class'=>'dtPicker3',
							  ),
	)); ?> 
  </div>
</div>
<div class="control-group">
<?php echo $form->labelEx($modRencanaOperasi[0],'statusoperasi', array('class'=>'control-label','onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
	<div class="controls">
		<?php echo CHtml::radioButton('statusoperasi',true,array('value'=>'MULAI', 'onclick'=>'enableSimpan("MULAI");'));?> SEDANG OPERASI <br>
		<?php echo CHtml::radioButton('statusoperasi',false,array('value'=>'SELESAI','onclick'=>'enableSimpan("SELESAI");'));?> SELESAI OPERASI                        
	</div>
</div>
<br>
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)', 'disabled'=>true, 'onclick'=>'simpan();'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function enableSimpan(status)
    {
		if(status == "SELESAI"){
			$('#selesaioperasi-form').find("button").attr("disabled",false); 
		}else{
			$('#selesaioperasi-form').find("button").attr("disabled",true); 
		}
    }
	
//    function loadDataPasien()
//    {
//        var noRekamMedik = $('#temp_norekammedik').val();
//        $.post("<?php // echo $this->createUrl('cariPasien')?>", { norekammedik: noRekamMedik },
//            function(data){
//                $('#PasienM_no_rekam_medik').val(data.no_rekam_medik);
//                $('#PasienM_nama_pasien').val(data.nama_pasien);
//                $('#PasienM_pasien_id').val(data.pasien_id);
//                $('#jk').val(data.jeniskelamin);
//        }, "json");
//    }
//    loadDataPasien();
</script>