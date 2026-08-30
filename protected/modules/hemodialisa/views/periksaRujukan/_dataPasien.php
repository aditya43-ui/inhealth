<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span12">
    <table width="100%" class="table-condensed" border="0">
        <tr>
            <td><label> No.Pendaftaran </label></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><label> No. Rekam Medik </label></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            
        </tr>
        <tr>
            <td><label> Tgl.Pendaftaran </label></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><label>  Nama Pasien </label></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
            
        </tr>
        
        <tr>
            <td><label> Instalasi Asal </label></td>
            <td><?php echo CHtml::activeTextField($modPasienrujukan, 'instalasi_nama', array('readonly'=>true)); ?></td>
            
            <td><label> Alias </label></td>
            <td>
                <?php echo CHtml::textField('alias', "", ['readonly' => true])?>
            </td>
        </tr>
        
        <tr>
            <td><label> Ruangan Asal </label></td>
            <td><?php echo CHtml::activeTextField($modPasienrujukan, 'ruangan_nama', array('readonly'=>true)); ?></td>
            
            <td><label> Tanggal Lahir </label></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly'=>true)); ?></td>
        </tr>
        
        <tr>
            <td><label> Kelas Pelayanan Asal </label></td>
            <td>
                <?php 
                $modKelas = KelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id);
                echo CHtml::textField('kelaspelayanan', !empty($modKelas->kelaspelayanan_id) ? $modKelas->kelaspelayanan_nama : "", ['readonly' => true])?>
            
            <td><label> Umur </label></td>
            <td><?php 
            $datetime1 = new DateTime();
            $datetime2 = new DateTime($modPasien->tanggal_lahir);
            $interval = $datetime1->diff($datetime2);
            $elapsed = $interval->format('%y tahun %m bulan %a hari');
            echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true, 'value'=>$elapsed)); 
            ?></td>
        </tr>
        
        <tr>
            <td><label> Jenis Kasus Penyakit Asal </label></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            
            <td><label> Jenis Kelamin </label></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        
        <tr>
            <td><label> Jenis Penjamin </label></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly'=>true)); ?></td>
            
            <td><label> Alamat Pasien </label></td>
            <td rowspan="2"><?php echo CHtml::activeTextArea($modPasien, 'alamat_pasien', array('readonly'=>true, 'style'=>'height: 70px; width: 220px')); ?></td>
        </tr>
        
        <tr>
            <td><label>  Penjamin </label></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly'=>true)); ?></td>
            
            <td></td>
            <td></td>
        </tr>
        
        <tr>
            <td><label> Dokter Pengirim </label></td>
            <td><?php echo CHtml::activeTextField($model->pegawai, 'namaLengkap', array('readonly'=>true)); ?></td>
            <td><label> Catatan Dokter </label></td>
            <td rowspan="2"></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
            <td></td>
        </tr>
        

    </table>
            </div>
        </div>
    </div>
</div>
<div class="isContent">
<style>
    .table thead tr th{
        vertical-align: middle;
    }
</style>

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
