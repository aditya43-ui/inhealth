<style>
    body {
        color: black;
    }
    
    .label_d {
        width: 150px;
        display: inline-block;
        text-align: right;
        margin-bottom: 5px;
    }
    .label_l {
        width: 150px;
        display: inline-block;
        text-align: left;
        margin-bottom: 5px;
    }
    .kolon_d {
        width: 5px;
        display: inline-block;
        vertical-align: top;
        text-align: right;
        margin-bottom: 5px;
    }
    .body_d {
        width: calc(100% - 170px);
        display: inline-block;
        vertical-align: top;
        margin-bottom: 5px;
    }
    
    .align_d {
        padding-left: 20px;
    }
    
    .radio_d {
        display: inline-block;
        width: 150px;
        vertical-align: top;
    }
    
    
    ol, ol > li {
        margin-bottom: 10px;
    }
    
    ol > li::before {
        vertical-align: top;
    }
</style>



<?php

$pasien = $pendaftaran->pasien;

?>

<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
        <table width="100%" class="table-condensed">
            <tr>
                <td><?php 
                
                $pendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran);
                echo CHtml::activeLabel($pendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($pasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pasien, 'no_rekam_medik', array('readonly' => true)); ?></td>

            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($pendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>
                
                <td><?php echo CHtml::activeLabel($pasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pasien, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($pendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pendaftaran, 'umur', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($pasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pasien, 'jeniskelamin', array('readonly' => true)); ?></td>

            </tr>   
            <tr>
                <td><?php echo CHtml::activeLabel($pendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($pendaftaran, 'carabayar_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?></td>

            </tr>   
            <tr>
                
                <td><?php echo CHtml::label('Dokter Pemeriksa', '', array('class' => 'control-label')); ?></td>
                <td>
                    <?php
                    $pegawaiNamaDpjp = "";
                    $pegawaiId = $pendaftaran->pegawai_id;

                    if (!empty($pegawaiId)) {
                        $modPeg = PegawaiM::model()->findByPk($pegawaiId);
                        $pegawaiNamaDpjp = (isset($modPeg) ? $modPeg->namaLengkap : "");
                    }
                    ?>
                    <?php echo CHtml::textField('nama_dokter_info', $pegawaiNamaDpjp, array('readonly' => true)); ?>
                </td>
                
                <td><?php echo CHtml::activeLabel($pendaftaran->penjamin, 'penjamin_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($pendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?></td>
            </tr>
        </table>
    </div>
</div>


<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Informasi Umum','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_1')),
        array('label'=>'Keluhan Utama','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_2')),
        array('label'=>'Faktor Predisposisi','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_3')),
        array('label'=>'Faktor Presipitasi','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_4')),
        array('label'=>'Fisik','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_5')),
        array('label'=>'Sosial-Kultur-Spiritual','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_6')),
        array('label'=>'Status Mental: Deskripsi Umum & Status Emosi','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_7')),
        array('label'=>'Status Mental: Persepsi, Proses Pikir & Sensori Kognisi','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_8')),
        array('label'=>'Mekanisme Koping','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_9')),
        array('label'=>'Masalah Psikososial dan Lingkungan','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_10')),
        array('label'=>'Kurangnya Pengatahuan, Aspek Medis & Diagnosis Keperawatan','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'panel_11')),
    ),
    'htmlOptions'=>array('class'=>'menu','id'=>'menuBoot')
));
?>


<?php echo $this->renderPartial($this->path_view."/detailView/informasiUmum", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/keluhanUtama", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/predisposisi", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/presipitasi", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/fisik", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/sosialKulturSpiritual", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/statusEmosi", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/prosesPikir", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/mekanismeKoping", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/psikososialLingkungan", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>
<?php echo $this->renderPartial($this->path_view."/detailView/kurangPendidikan", array(
    'pendaftaran'=>$pendaftaran,
    'pasien'=>$pasien,
    'model'=>$model,
    'diagnosa'=>$diagnosa,
), true); ?>


<script>
    
    function setTab(obj) {
        $(".panel_detail").hide();
        $("#" + $(obj).attr("tab")).show();
    }
    
    $(document).ready(function() {
        $("#menuBoot li").eq(0).click();
    });
    
</script>