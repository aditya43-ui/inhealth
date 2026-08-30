<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ubahkelaspelayanan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->

	<?php echo $form->errorSummary($model); ?>
        
        <?php echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true)); ?>
        
        <?php //echo $form->textFieldRow($model,'pendaftaran_id',array()); ?>
        
        <div class="control-group">
            <?php echo CHtml::label('No. Pendaftaran ', 'noPendaftaran', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('noPendaftaran','noPendaftaran',array('readonly'=>true)); ?>
            </div>
        </div>
        
	<?php echo $form->dropDownListRow($model,'kelaspelayanan_id',CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true)), 'kelaspelayanan_id', 'kelaspelayanan_nama')); ?>
        
	<?php // echo $form->dropDownListRow($model,'penjamin_id',array()); ?>

	<?php echo $form->textAreaRow($model,'alasanperubahan',array()); ?>
		
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                       Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">

function loadPendaftaranId()
{
    var pendaftaran_id = $('#tempPendaftaranId').val();
    var noPendaftaran = $('#tempNoPendaftaran').val();
    var idCaraBayar = $('#tempCaraBayarId').val();
    $('#carabayardialog div.divForFormUbahCaraBayar #pendaftaran_id').val(pendaftaran_id);
    $('#carabayardialog div.divForFormUbahCaraBayar #noPendaftaran').val(noPendaftaran);
    
    $.post("<?php echo Yii::app()->createUrl('ActionAjax/getListCaraBayar')?>", { idCaraBayar: idCaraBayar },
        function(data){
            $('#carabayardialog div.divForFormUbahCaraBayar #UbahcarabayarR_carabayar_id').html(data.listCaraBayar);
            $('#carabayardialog div.divForFormUbahCaraBayar #UbahcarabayarR_penjamin_id').html(data.listPenjamin);
    }, "json");
}

loadPendaftaranId();

function listPenjamin(idCaraBayar)
{
    $.post("<?php echo Yii::app()->createUrl('ActionAjax/getListPenjamin')?>", { idCaraBayar: idCaraBayar },
        function(data){
            $('#carabayardialog div.divForFormUbahCaraBayar #UbahcarabayarR_penjamin_id').html(data.listPenjamin);
    }, "json");
}
</script>