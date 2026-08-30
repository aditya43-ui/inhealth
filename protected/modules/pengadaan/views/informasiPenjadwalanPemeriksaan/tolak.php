<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'baserahterima-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
    <?php echo $form->hiddenField($model,'pegverifikasi_id',array('readonly' => true, 'class'=>'span4 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
    <?php echo $form->hiddenField($model,'pengadaanjadwalpemeriksaan_id',array('readonly' => true, 'class'=>'span4 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
    <?php echo $form->textFieldRow($model,'pengadaanjadwalpemeriksaan_nomor',array('readonly' => true, 'class'=>'span4 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
    <?php echo $form->textFieldRow($model,'tanggal_pemeriksaan',array('readonly' => true, 'class'=>'span4 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
    <div class="control-group">
        <?php echo CHtml::label("Alasan Penolakan <span class='required'>*</span> ", '', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php echo $form->textArea($model,'alasan_tolak',array('readonly' => false, 'class'=>'span4 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array(
                    'class'=>'btn btn-primary submit', 
                    'type'=>'button',
                    'onclick'=>'setTolak();return false;',
                    'onKeypress'=>'return formSubmit(this,event)'
            )); ?>

        </div>
    </div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function setTolak(){
            var id = $('#ADPengadaanjadwalpemeriksaanT_pengadaanjadwalpemeriksaan_id').val();
            var pegawai = $('#ADPengadaanjadwalpemeriksaanT_pegverifikasi_id').val();
            var alasan = $('#ADPengadaanjadwalpemeriksaanT_alasan_tolak').val();
            if(alasan != ''){
                var data = $("#permintaandarah-r-grid").serialize();
                $.ajax({
                    type: 'POST',
                    url:'<?php echo $this->createUrl('ajaxUbahStatus'); ?>',
                    data:{
                        id:id, 
                        alasan:alasan,
                        pegawai: pegawai
                    },
                    dataType:'json',
                    success:function(data){
                            if(data.status == 'proses_form'){
                                window.parent.$('#dialogTolak').dialog('close');
                                window.parent.reloadTabel();
                            }else{
                                toast.error("Penolakan Gagal Disimpan");
                            }
                    },
                    error: function(data) { // if error occured
                          myAlert("Penolakan Gagal Disimpan");
                     },
                   });
           }else{
                myAlert("Isikan Alasan Penolakan terlebih dahulu");
                return false;
           }
        }
</script>