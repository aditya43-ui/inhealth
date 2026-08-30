<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
 <legend class="rim2">Konsultasi Gizi Pasien</legend>
<fieldset>
    <legend class="rim">Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'Foto pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            
            <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::Label('Cara Membayar', 'carabayar_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly'=>true)); ?></td>
            
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::Label('Penjamin', 'penjamin_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly'=>true)); ?></td>
            
            
            <td><?php echo CHtml::Label('Dokter Pemeriksa', 'Dokter Pemeriksa',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->pegawai, 'nama_pegawai', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>   
<div class="isContent">
<style>
    .table thead tr th{
        vertical-align: middle;
    }
</style>

<fieldset>
    <legend class="accord1" style="width:460px;"><?php echo CHtml::checkBox('cekRiwayatPasien',false, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?> Riwayat Pasien </legend>
    <div id="divRiwayatPasien" class="control-group">
        <iframe src="<?php echo Yii::app()->createUrl('gizi/daftarPasien/getRiwayatPasien&id='.$modPasien->pasien_id); ?>" id="riwayatPasien" width="100%" height="100%" onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
</fieldset>

</div>
<?php

$js = <<< JS
$('#cekRiwayatPasien').change(function(){
        $('#divRiwayatPasien').slideToggle(500);
});

JS;
Yii::app()->clientScript->registerScript('JSriwayatPasien',$js,CClientScript::POS_READY);
?>
<?php
//========= Dialog Detail Anamnesa Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailAnamnesa',
    'options' => array(
        'title' => 'Data Anamnesa Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogAnamensa" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Konsultasi Gizi=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();

Yii::app()->clientScript->registerScript('resize',"
    function resizeIframe(obj){
       $('#divRiwayatPasien').slideToggle(1);
       obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
",  CClientScript::POS_HEAD);
?>

