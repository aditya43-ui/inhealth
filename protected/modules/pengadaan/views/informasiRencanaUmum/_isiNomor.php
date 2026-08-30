<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rencanaumumpengadaan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<div class="panel panel-success">
    <div class="panel-body">
        <div class="col-sm-12">
            <?php echo $form->hiddenField($model, 'rencanaumumpengadaan_id', array('class'=>'span3', 'placeholder'=>'Ketik nama kegiatan'));?>
            <div class="control-group">
            <?php echo CHtml::label('Nomor SiRUP <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'kode_rup', array('class'=>'span3 required', 'placeholder'=>'Ketik Nomor SiRUP','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>
        <span style="color:red;">Pastikan nomor yang anda masukkan benar karena nomor yang dimasukkan tidak bisa diubah</span>
        <div class="form-actions">
        <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('onclick'=>'simpanNomor()','class'=>'btn btn-primary')); //formSubmit(this,event)        
        ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?> 

<script type="text/javascript">
function simpanNomor(){
    var nomor = $('#RencanaumumpengadaanT_kode_rup').val();
    var id = $('#RencanaumumpengadaanT_rencanaumumpengadaan_id').val();
    if(nomor != ''){
        var data = $("#rencanaumumpengadaan-form").serialize();
        $.ajax({
            type: 'POST',
            url:'<?php echo $this->createUrl('ajaxSimpanNomor'); ?>',
            data:data,
            success:function(data){
                        window.parent.$('#dialogNomor').dialog('close');
                        window.parent.reloadTabel('nosirup');
                        return true;
                       },
            error: function(data) { // if error occured
                  window.parent.reloadTabel('gagal');
             },
           });
   }else{
        myAlert("Isikan Nomor SiRUP terlebih dahulu");
        return false;
   }
}
</script>