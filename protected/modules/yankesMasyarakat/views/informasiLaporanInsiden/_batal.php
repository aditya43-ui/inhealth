<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'batal-insiden-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
    ),
        ));
?>

<div class="row-fluid">
    <div class="control-group">
        <?php echo CHtml::label('Alasan Pembatalan <span class="required">*</span>', 'jenis_str', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'alasanpembatalan', array('class' => 'alasanpembatalan span4 required', 'rows' => 5,  'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
            <?php echo $form->hiddenField($model, 'insidenrs_id', array('class' => 'span3 insidenrs_id', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="row-fluid" style="text-align: center">
    <?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="fa fa-check"></i>')),array(
                            'class'=>'btn btn-primary submit', 
                            'type'=>'button',
                            'onclick'=>'setNonaktif();return false;',
                            'onKeypress'=>'return formSubmit(this,event)'
                        ));
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Tutup', array('{icon}' => '<i class="glyphicon glyphicon-remove"></i>')), array(
        'class' => 'btn btn-danger',
        'type' => 'button',
        'onclick' => 'closeDialog();return false;',
        'onKeypress' => 'return formSubmit(this,event)'
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function closeDialog() {
        window.parent.$("#dialogBatal").dialog('close');
    }
    
    function setNonaktif(){
        var id = $('.insidenrs_id').val();
        var alasan = $(".alasanpembatalan").val();
        if (alasan == '') {
            $('.alasanpembatalan').css('border-color', '#b94a48');
             window.parent.myAlert("Alasan pembatalan wajib diisi", "Perhatian!");
            return false;
        } else {
            $('.alasanpembatalan').css('border-color', '');
            window.parent.myConfirm('Yakin akan membatalkan pelaporan insiden ini?','Perhatian!',function(r){
                if (r){
                     $.ajax({
                        type: 'POST',
                        url:'<?php echo $this->createUrl('submitBatal'); ?>',
                        data:{
                            id:id, alasan:alasan
                        },
                        dataType:'json',
                        success:function(data){
                                if(data.status == '1'){
                                    closeDialog(); 
                                    window.parent.toastr.success(data.pesan, 'Perhatian!');
                                }else{
                                     window.parent.toastr.error(data.pesan, 'Perhatian!');
                                }
                        },
                        error: function(data) { // if error occured
                              myAlert("Data gagal Dibatalkan");
                         },
                   });
               }
            });
        }
            
    }
    
</script>