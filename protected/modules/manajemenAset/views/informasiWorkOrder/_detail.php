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
        <div class="panel-title"> <i class="glyphicon glyphicon-file"></i> <b> Pemeliharaan </b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Status', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'status_pemeliharaan', array('class'=>'span3', 'placeholder'=>'Ketik status pemeliharaan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal Pemeliharaan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tglpemeliharaan', array('class'=>'span2', 'placeholder'=>'Ketik Tanggal Pemeliharaan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?> sd <?php echo $form->textField($model, 'tglpemeliharaan_selesai', array('class'=>'span2', 'placeholder'=>'Ketik nama kegiatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Peralatan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelView, 'invperalatan_namabrg', array('class'=>'span3', 'placeholder'=>'Ketik Jenis Peralatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nomor Aset', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelView, 'invperalatan_kode', array('class'=>'span3', 'placeholder'=>'Ketik Nomor Aset','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Teknisi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jenisteknisi', array('class'=>'span3', 'placeholder'=>'Ketik Jenis Teknisi','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Teknisi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'teknisiperalatan_nama', array('class'=>'span3', 'placeholder'=>'Ketik nama Teknisi','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                    <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'ket_pemeliharaan', array('class'=>'span3', 'placeholder'=>'Ketik Keterangan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            <div class="control-group">
                    <?php echo CHtml::label('Kondisi Barang', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelView, 'invperalatan_keadaan', array('class'=>'span3', 'placeholder'=>'Ketik Kondisi Barang','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
<<<<<<< HEAD
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pemohon</b>
        </div>
=======
        <div class="panel-title"> <i class="glyphicon glyphicon-file"></i> <b> Data Pemohon </b> </div>
>>>>>>> 152b37e85d299dbd8eb1b7ff84973d587254cd55
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Pegawai', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelView, 'pegawai_nama', array('class'=>'span3', 'placeholder'=>'Ketik nama pegawai','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelView, 'pegawai_nip', array('class'=>'span3', 'placeholder'=>'Ketik nip pegawai','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Jabatan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelView, 'jabatan_nama', array('class'=>'span3', 'placeholder'=>'Ketik jabatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('UnitKerja', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelView, 'ruangan_nama', array('class'=>'span3', 'placeholder'=>'Ketik unit kerja','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    $( document ).ready(function(){
        $('.add-on').hide();
    });
</script> 