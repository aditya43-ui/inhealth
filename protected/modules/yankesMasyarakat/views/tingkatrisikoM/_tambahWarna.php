<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'satuanbahanmakanan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<div class="panel panel-success">
    <div class="panel-body">
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <div class="col-sm-6">
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Nama Warna <span class="required">*</span>','', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'lookup_name',array('onkeyup' => 'namaLain(this)','class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <?php echo Chtml::label('Nilai','', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'lookup_value',array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions span12">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('onclick'=>'tambahSatuan()','class'=>'btn btn-primary')); //formSubmit(this,event)  ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function tambahSatuan(){
	var name = $('#LookupM_lookup_name').val();
	var value = $('#LookupM_lookup_value').val();
        if(name != ''){
            $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('simpanWarna'); ?>',
                    data: {name : name, value: value},//
                    dataType: "json",
                    success:function(data){
                        if(data.sukses == 1){
                            window.parent.$("#dialogTambahWarna").dialog('close');
                            window.parent.$("#TingkatrisikoM_tingkatrisiko_warna").val(value);
                            parent.location.reload();
                        }else{
                            myAlert('Data Gagal Ditambah');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert('Isikan Nama Satuan Terlebih Dahulu');
        }

}

function namaLain(obj){
    $("#<?php echo Chtml::activeId($model, 'lookup_value') ?>").val($(obj).val());
}
</script>