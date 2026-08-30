<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $jenisform = !empty($jenisform)?$jenisform:null;
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<?php echo $form->hiddenField($model, 'pasien_id'); ?>
<?php  ?>

<div class="control-group">
    <div class="controls">
        <?php
            if (($jenisform=='tambah')){
                echo $form->hiddenField($model, 'notriage_pasien_id');
                echo $form->dropDownListRow($model, 'bed_triage_id', BedTriageM::getDropList(), array( 'class' => 'span2 bedtriage required', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'tambahNobed(this,"tambah")', 'maxlength' => 50));
            }else{
                echo $form->hiddenField($model, 'bed_triage_id');
                echo $form->dropDownListRow($model, 'notriage_pasien_id', RDNotriagePasienT::getDropTrigaePasien($model->pendaftaran_id), array('empty'=>'-- Pilih --','class' => 'span3 bedtriage required', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'tambahNobed(this,"ubah")', 'maxlength' => 50));
            }
        ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php echo $form->textFieldRow($model, 'no_bed_triage',array('readonly'=>true, 'class' => 'span2')); ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
       <?php echo $form->textAreaRow($model,'keterangan',array('readonly' => true,'rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    if ($sukses == 'tidak') {
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
        echo CHtml::htmlButton(
            Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
        );
    } else {
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)','disabled' => true));
        echo CHtml::htmlButton(
            Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
        );
    }
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo $this->createUrl('getDataPendaftaran'); ?>", { pendaftaran_id: pendaftaran_id},
            function(data){
                $('#<?php echo CHtml::activeId($model,"pendaftaran_id"); ?>').val(data.pendaftaran_id);
                $('#<?php echo CHtml::activeId($model,"pasien_id"); ?>').val(data.pasien_id);
            },
        "json");
    }

    function tambahNobed(obj,jenis)
    {
        var id = $(obj).find(":selected").val();
        $.post("<?php echo $this->createUrl('loadTriage'); ?>", {id: id,jenis:jenis},
            function(data){
                $('#RDNotriagePasienT_no_bed_triage').val(data.no_bed_triage);
                $('#RDNotriagePasienT_keterangan').val(data.keterangan);
                $('#RDNotriagePasienT_notriage_pasien_id').val(data.notriage_pasien_id);
                $('#RDNotriagePasienT_bed_triage_id').val(data.bed_triage_id);
            },
        "json");
    }

    // loadDataPendaftaran();

	function closeDialog(){
		window.parent.$('#tambahTriagePasien').dialog('close');
	}

$(document).ready(function(){
   $(".bedtriage").change();
});
</script>   