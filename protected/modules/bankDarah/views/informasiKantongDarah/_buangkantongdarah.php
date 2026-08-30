<?php 
    /** 
     * @author Aida Rahmawati <aidarahmawati@.com>
     */
     $nomorbarcode = $kantong->no_kantongdarah;
 ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'komponendarah-m-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#'.CHtml::activeId($model,'namakomponendrh')
)); ?>
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-md-4">
        <div class="control-group">
            <?php echo CHtml::label('Nomor Barcode <span class =required> * </span>','tglpembatalan' , array('class'=>'control-label required')) ?>
            <div class="controls">
                <?php echo CHtml::TextField('nomorbarcode', $nomorbarcode,array('readonly'=>true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Alasan Pembatalan <span class =required> * </span>','tglpembatalan' , array('class'=>'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'alasan_pembatalan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
                <?php echo $form->hiddenField($kantong,'kantongdarah_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array(
                        'class'=>'btn btn-primary submit', 
                        'type'=>'button',
                        'onclick'=>'setBatal();return false;',
                        'onKeypress'=>'return formSubmit(this,event)'
                )); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl('create'), 
                    array('class'=>'btn btn-danger',
                    'onclick'=>'return refreshForm(this);')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function setBatal(){
            var id = $('#KantongdarahT_kantongdarah_id').val();
            var alasan = $('#BatalkantongdarahT_alasan_pembatalan').val();
            if(alasan != ''){
                var data = $("#permintaandarah-r-grid").serialize();
                $.ajax({
                    type: 'POST',
                    url:'<?php echo $this->createUrl('ajaxBuang'); ?>',
                    data:{
                        id:id, 
                        alasan:alasan
                    },
                    dataType:'json',
                    success:function(data){
                            if(data.status == 'proses_form'){
                                window.parent.$('#dialogPembuatan').dialog('close');
                                window.parent.reloadTabel();
                            }else{
                                myAlert("Pembatalan Gagal Disimpan");
                            }
                    },
                    error: function(data) { // if error occured
                          myAlert("Pembatalan Gagal Disimpan");
                     },
                   });
           }else{
                myAlert("Isikan Data Alasan Terlebih Dahulu");
                return false;
           }
        }
</script>