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
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Data Penghapusan Aset</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal Penghapusan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tglpenghapusan', array('class'=>'span3', 'placeholder'=>'Ketik nama kegiatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Cara', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'carapenghapusan', array('class'=>'span3', 'placeholder'=>'Ketik nama kegiatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Pegawai Mengetahui', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'penghapusanmengetahui_nama', array('class'=>'span3', 'placeholder'=>'Ketik nama pegawai','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Pegawai Menyetujui', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'menyetujui_nama', array('class'=>'span3', 'placeholder'=>'Ketik nama pegawai','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Nomor Penghapusan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopenghapusan', array('class'=>'span3', 'placeholder'=>'Ketik nama kegiatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Nomor SK Penghapusan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_sk_penghapusan', array('class'=>'span3', 'placeholder'=>'Ketik nama kegiatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Tanggal SK Penghapusan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tgl_sk_penghapusan', array('class'=>'span3', 'placeholder'=>'Ketik nama kegiatan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-group">
                    <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'ket_penghapusan', array('class'=>'span3', 'placeholder'=>'Ketik Keterangan Penghapusan','onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Detail Penghapusan Aset</div>
    </div>
    <div class="panel-body">
        
        <table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
            <thead>
                <tr>                  
                    <th>Nama Aset</th>
                    <th>No Aset</th>  
                    <th>Merk</th>
                    <th>Bahan</th>
                    <th>Ukuran</th>
                </tr>
                <?php
                    foreach($modelDetail as $modDetail){
                        $modPeralatan = InvperalatanT::model()->findByPk($modDetail['invperalatan_id']);
                ?>
                <tr>
                    <td><?php echo $modPeralatan['invperalatan_namabrg']?></td>
                    <td><?php echo $modPeralatan['invperalatan_kode']?></td>
                    <td><?php echo $modPeralatan['invperalatan_merk']?></td>
                    <td><?php echo $modPeralatan['invperalatan_bahan']?></td>
                    <td><?php echo $modPeralatan['invperalatan_ukuran']?></td>
                </tr>
                <?php
                    }
                ?>
            </thead>
            <tbody>
                    </tbody>
        </table>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    $( document ).ready(function(){
        $('.add-on').hide();
    });
</script> 