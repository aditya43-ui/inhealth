<?php
/**
* - digunakan sebagai informasi work order
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'workorder-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Pemeliharaan Aset</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="control-group">
                <div class="control-group">
                    <?php echo $form->hiddenField($model, 'workorder_id', array('class'=>'span3', 'placeholder'=>'Ketik nama kegiatan'));?>
                    <?php echo CHtml::label('Tanggal Pemeliharaan Mulai', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglpemeliharaan',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
            //										'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('style' => 'width: 180px','class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal Pemeliharaan Selesai<span class="required">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglpemeliharaan_selesai',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
            //										'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('style' => 'width: 180px','class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Teknisi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenisteknisi', LookupM::getItems('jenisteknisi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--','onchange'=>'formjenisteknisi(this.value);')); ?>
                    </div>
                </div>
                <div class="control-group" id="form-teknisi">
                    <?php echo CHtml::label('Teknisi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php //echo $form->dropDownList($model, 'teknisiperalatan_id', CHtml::listData(TeknisiperalatanM::model()->findAll(), 'teknisiperalatan_id', 'namateknisi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--')); ?>
                        <?php echo $form->hiddenField($model, 'teknisiperalatan_id', array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php  
                            $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute'=>'teknisiperalatan_nama',
                                'value'=>$model->teknisiperalatan_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteTeknisi').'",
                                                   dataType: "json",
                                                   data: {
                                                       teknisiperalatan_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#WorkorderT_teknisiperalatan_id").val(ui.item.teknisiperalatan_id);
                                            $("#WorkorderT_teknisiperalatan_nama").val(ui.item.namateknisi);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Teknisi',
                                                    'rel'=>'tooltip',
                                    'class'=>'span3',
                                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                    'onblur'=> 'if(this.value===""){ $("#'.CHtml::activeId($model, 'teknisiperalatan_id').'").val(""); }'
                                    ),
                            )); 
                        
                        ?>
                    </div>
                </div>
                <div class="control-group" id="form-pegawai" hidden>
                    <?php echo CHtml::label('Teknisi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php //echo $form->dropDownList($model, 'teknisiperalatan_id', CHtml::listData(TeknisiperalatanM::model()->findAll(), 'teknisiperalatan_id', 'namateknisi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--')); ?>
                        <?php echo $form->hiddenField($model, 'teknisiint_id', array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php  
                            $this->widget('MyJuiAutoComplete', array(
                                'model'=>$model,
                                'attribute'=>'pegawai_nama',
                                'value'=>$model->pegawai_nama,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePegawai').'",
                                                   dataType: "json",
                                                   data: {
                                                       pegawai_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#WorkorderT_teknisiint_id").val(ui.item.pegawai_id);
                                            $("#WorkorderT_pegawai_nama").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Teknisi',
                                                    'rel'=>'tooltip',
                                    'class'=>'span3',
                                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                    'onblur'=> 'if(this.value===""){ $("#'.CHtml::activeId($model, 'pegawai_id').'").val(""); }'
                                    ),
                            )); 
                        
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kondisi Barang <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kondisi_barang', LookupM::getItems('kondisi_barang'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--')); ?>
                    </div>
                </div>
                <div class="control-group">
                <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'ket_pemeliharaan', array('class'=>'span3', 'placeholder'=>'Ketik Keterangan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="form-actions span12">
            <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('onclick'=>'simpanPemeliharaan()','class'=>'btn btn-primary')); //formSubmit(this,event)        
            ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?> 

<script type="text/javascript">
function simpanPemeliharaan(){
    var kondisi_barang = $('#WorkorderT_kondisi_barang option:selected').val();
    var tanggal = $('#WorkorderT_tglpemeliharaan_selesai').val();
    console.log(tanggal);
    if(kondisi_barang != '' && tanggal != '' & tanggal != '-'){
        var data = $("#workorder-form").serialize();
        $.ajax({
            type: 'POST',
            url:'<?php echo $this->createUrl('ajaxSimpanPemeliharaan'); ?>',
            data:data,
            success:function(data){
                        myAlert('Data Sukses Disimpan');
                        window.parent.$('#dialogPemeliharaan').dialog('close');
                        $.fn.yiiGridView.update('workorder-m-grid');
                        return true;
                       },
            error: function(data) { // if error occured
                  alert("Data Gagal Disimpan");
                  //alert(data);
             },
           });
           //myAlert("Berhasil");
   }else{
        myAlert("Pilih Kondisi Barang dan Isikan Tanggal Pemeliharaan selesai Terlebih Dahulu");
        return false;
   }
}

function formjenisteknisi(jenisteknisi){
	//$(".formjenisresep").addClass("animation-loading");
        var teknisi = $("#WorkorderT_jenisteknisi").val();
        //console.log(jenisteknisi);
	setTimeout(function(){
		if(jenisteknisi=='INTERNAL'){
			$("#form-teknisi").hide();
			$("#form-pegawai").show();
                        setKosong();
                        $("#WorkorderT_teknisiperalatan_nama").prop('disabled', true);
                        $("#WorkorderT_teknisiperalatan_id").prop('disabled', true);
                        $("#WorkorderT_pegawai_nama").prop('disabled', false);
                        $("#WorkorderT_teknisiint_id").prop('disabled', false);
		}else{
			$("#form-teknisi").show();
			$("#form-pegawai").hide();
                        setKosong();
                        $("#WorkorderT_teknisiperalatan_nama").prop('disabled', false);
                        $("#WorkorderT_teknisiperalatan_id").prop('disabled', false);
                        $("#WorkorderT_pegawai_nama").prop('disabled', true);
                        $("#WorkorderT_teknisiint_id").prop('disabled', true);
                        
		}
		//$(".formjenisresep").removeClass("animation-loading");
	},500);
}

function setKosong(){
    $("#WorkorderT_pegawai_nama").val("");
    $("#WorkorderT_teknisiint_id").val("");
    $("#WorkorderT_teknisiperalatan_nama").val("");
    $("#WorkorderT_teknisiperalatan_id").val("");
}

$(document).ready(function(){
    var teknisi = $("#WorkorderT_jenisteknisi").val();
    if(teknisi=='INTERNAL'){        
            $("#form-teknisi").hide();
            $("#form-pegawai").show();            
            $("#WorkorderT_teknisiperalatan_nama").prop('disabled', true);
            $("#WorkorderT_teknisiperalatan_id").prop('disabled', true);
            $("#WorkorderT_pegawai_nama").prop('disabled', false);
            $("#WorkorderT_teknisiint_id").prop('disabled', false);
    }else{
            $("#form-teknisi").show();
            $("#form-pegawai").hide();            
            $("#WorkorderT_teknisiperalatan_nama").prop('disabled', false);
            $("#WorkorderT_teknisiperalatan_id").prop('disabled', false);
            $("#WorkorderT_pegawai_nama").prop('disabled', true);
            $("#WorkorderT_teknisiint_id").prop('disabled', true);

    }
    
        
});
</script>