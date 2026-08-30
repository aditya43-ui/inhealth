<?php
$this->widget('bootstrap.widgets.BootAlert');
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
?>
<div class="panel panel-primary panel-success" >
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>
                <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
                <td rowspan="4">
                    <?php
                    if (!empty($modPasien->photopasien)) {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'photo pasien', array('width' => 120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'photo pasien', array('width' => 120));
                    }
                    ?> 
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>
                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>
                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                <td>
                    <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                </td>
                <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar, 'cara bayar', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->dokter, 'namaLengkap', array('readonly' => true)); ?></td>
                <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="isContent">
<style>
    .table thead tr th{
        vertical-align: middle;
    }
</style>

<fieldset>
<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
	'id'=>'form-riwayat',
	'content'=>array(
		'content-detailpasien'=>array(
			'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pasien')).
                    '<b> Riwayat Pasien</b>',
			'isi'=>'<iframe src="" id="riwayatPasien" width="100%" height="100%"></iframe>',
			'active'=>false,
			),   
		),
)); ?>
</fieldset>


<?php //$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
//	'id'=>'form-riwayat',
//	'content'=>array(
//		'content-detailpasien'=>array(
//			'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pasien')).'<b> Riwayat Pasien</b>',
//			'isi'=>'<iframe src="" id="riwayatPasien" width="100%" height="100%"></iframe>',
//			'active'=>false,
//			),   
//		),
//)); ?>

</div>
<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
?>