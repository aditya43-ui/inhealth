<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modPasien)) {
    $modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
    $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);

    $penerima = "";
    $dpjp2 = "";
    $dpjp3 = "";

    if (!empty($modAdmisi->dokterpenerima_id)) {
        $peg = PegawaiM::model()->findByPk($modAdmisi->dokterpenerima_id);
        $penerima = $peg->namaLengkap;
    }
    if (!empty($modAdmisi->dpjp2_id)) {
        $peg = PegawaiM::model()->findByPk($modAdmisi->dpjp2_id);
        $dpjp2 = $peg->namaLengkap;
    }
    if (!empty($modAdmisi->dpjp3_id)) {
        $peg = PegawaiM::model()->findByPk($modAdmisi->dpjp3_id);
        $dpjp3 = $peg->namaLengkap;
    }


    $kunjungan = InfokunjunganrjV::model()->findByAttributes(array(
        'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
        'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
    ));
    
    $modPendaftaran->dokter_pemeriksa = $modPendaftaran->dokter->namaLengkap;
    
    $jns_kunjungan = $modPendaftaran->kunjungan;
    
    if (!empty($kunjungan)) {
        $modPendaftaran->dokter_pemeriksa =  $kunjungan->gelardepan.$kunjungan->nama_pegawai.(empty($kunjungan->gelarbelakang_nama) ? "" : (", ".$kunjungan->gelarbelakang_nama));
    }
    
    echo CHtml::hiddenField('kunjungan', $jns_kunjungan, array('readonly' => true));
    echo CHtml::hiddenField('judul_sblm', '', array('readonly' => true));
    

?>

    <form class="form-horizontal">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::activeHiddenField($modPasien, 'nama_bin', array('readonly' => true)); ?>
                        <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                            <?php echo CHtml::activeHiddenField($modAdmisi, 'kelaspelayanan_id', array('readonly' => true)); ?>
                            <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Dokter Penerima', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('dokterpenerima', $penerima, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modAdmisi->pegawai, 'dokter_pemeriksa', array('class' => 'control-label', 'label' => 'DPJP 1')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modAdmisi->pegawai, 'namaLengkap', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('DPJP 2', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('dpjp2', $dpjp2, array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('DPJP 3', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('dpjp3', $dpjp3, array('readonly' => true)); ?>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true, 'class'=>'idrm')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::Label('No. Kamar / No. Bed', (isset($modAdmisi->kamarruangan_id) ? $modAdmisi->kamarruangan->kamarruangan_nokamar : ""), array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php if (isset($modAdmisi->kamarruangan_id)) { ?>
                                <?php echo CHtml::activeTextField($modAdmisi->kamarruangan, 'kamarruangan_nokamar', array('readonly' => true, 'style' => 'width:150px;')); ?>
                        </div>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modAdmisi->kamarruangan, 'kamarruangan_nobed', array('readonly' => true, 'style' => 'width:60px;')); ?>
                        <?php } else { ?>
                            <?php echo CHtml::TextField('kamarruangan_nokamar', '', array('readonly' => true, 'style' => 'width:70%')); ?> /
                            <?php echo CHtml::TextField('kamarruangan_nobed', '', array('readonly' => true, 'style' => 'width:20%')); ?>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modAdmisi->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modAdmisi->kelaspelayanan, 'kelaspelayanan_nama', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modAdmisi->carabayar, 'cara bayar ', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modAdmisi->carabayar, 'carabayar_nama', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modAdmisi->penjamin, 'penjamin', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modAdmisi->penjamin, 'penjamin_nama', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php
                            if (!empty($modPasien->photopasien)) {
                                echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                            } else {
                                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="isContent hide">
        <style>
            .table thead tr th {
                vertical-align: middle;
            }
        </style>

        <fieldset>
        
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-riwayat',
                'content' => array(
                    'content-detailpasien' => array(
                        'header' => '<b>Riwayat Pasien</b>',
                        'isi' => '<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
                        'active' => true,
                    ),
                ),
            )); ?>
            <?php

            if (!empty($modPasien->pasien_ibu_id)) {
                $ibu = PasienM::model()->findByPk($modPasien->pasien_ibu_id);
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-riwayat-pasien',
                    'content' => array(
                        'content-detailpasien-ibu' => array(
                            'header' => '<b>Riwayat Ibu - ' . $ibu->nama_pasien . ' - ' . $ibu->no_rekam_medik . '</b>',
                            'isi' => '<iframe src="" id="riwayatPasienIbu" style="width:100%; height: 98%;"></iframe>',
                            'active' => false,
                        ),
                    ),
                ));
            } ?>
        </fieldset>

    </div>
<?php
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

?>

<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData2',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="detailDialog2" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>