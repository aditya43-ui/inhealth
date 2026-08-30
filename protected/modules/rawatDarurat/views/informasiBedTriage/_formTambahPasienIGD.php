<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onSubmit' => 'return requiredCheck(this)'),
            
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div style="padding: 20px;">
    <div class="control-group">
        <label for="" class="control-label">Bed Triage <span class="required">*</span></label>
        <div class="controls">
            <?php
                echo $form->dropDownList($model, 'bed_triage_id', CHtml::listData(BedTriageM::model()->findAllByAttributes(array('is_aktif'=>true),['order' => 'no_bed::integer asc']), 'bed_triage_id', 'BedTriageInUse'), array('onclick' => 'cekBed(this)','empty' => '-- Pilih --', 'class' => 'span2 required', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => isset($model->pendaftaran_id) ? true : false, 'disabled' => isset($model->pendaftaran_id) ? true : false));
            ?>
        </div>
    </div>


    <?php echo $form->textFieldRow($model, 'no_bed_triage',array('readonly'=>true, 'class' => 'span2')); ?>
 
    <div class="control-group">
        <label for="" class="control-label">Keterangan <span class="required">*</span></label>
        <div class="controls">
           <?php echo $form->textArea($model,'keterangan',array('rows'=>2, 'cols'=>60, 'class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>

</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
	// function closeDialog(){
    //     $.fn.yiiGridView.update('daftarpasien-v-grid', {
    //             data: $('form').serialize()
    //     });
	// 	window.parent.$('#tambahTriage').dialog('close');
	// }

    $(function(){
        <?php if(isset($_GET['sukses'])) { ?>
            
            window.parent.setFlashSukses();
		    window.parent.$('#dialogTambahTriage').dialog('close');
        <?php } ?>
    });

    function cekBed(obj) {
        var bed_triage_id = $(obj).val();
        $.ajax({
            type: 'POST',
            url: '<?= $this->createUrl('cekBed') ?>',            
            data:{
                bed_triage_id:bed_triage_id  
            },
            dataType: "json",
            success: function (data) {    
                if(data.ketersediaan == 0) {
                    myAlert(data.infobed);
                    $(obj).val('');
                } else if(data.ketersediaan == 2) {
                    // myAlert('Error : Tidak ada kiriman Data');
                }                      
            },
            error: function (jqXHR, textStatus, errorThrown) {                                    
            }
        });   
    }
</script>