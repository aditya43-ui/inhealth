<?php 
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));

if(!empty($modPasienPenunjang)){
?>
<fieldset>
    <table class="table table-condensed">
        <tr>
            <td>Tanggal Pendaftaran</td>
            <td>: <?php echo $modPasienPenunjang->tgl_pendaftaran; ?></td>
            
            <td>No. Rekam Medik</td>
            <td>: <?php echo $modPasienPenunjang->no_rekam_medik; ?></td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasienPenunjang->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasienPenunjang->photopasien, 'photo pasien', array('width'=>120));
                    } else {
                        echo "";
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td>No. Pendaftaran - Penunjang</td>
            <td>
                : <?php echo $modPasienPenunjang->no_pendaftaran; ?>
                -
                <?php echo $modPasienPenunjang->no_masukpenunjang; ?>
            </td>
            
            <td>Jenis Kelamin</td>
            <td>: <?php echo $modPasienPenunjang->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>: <?php echo $modPasienPenunjang->umur; ?></td>
            
            <td>Nama Pasien</td>
            <td>: <?php echo $modPasienPenunjang->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>Jenis Kasus Penyakit</td>
            <td>: <?php echo $modPasienPenunjang->jeniskasuspenyakit_nama; ?></td>
            
            <td>Nama Panggilan</td>
            <td>: <?php echo $modPasienPenunjang->nama_bin; ?></td>
        </tr>
    </table>
</fieldset>

<hr/>
<?php
} else {
    Yii::app()->user->setFlash('error',"Data pasien tidak ditemukan");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
<fieldset>
    <legend>Detail Jadwal Kunjungan</legend>
        
        <div class="control-group" style="display: <?php echo (!empty($listJadwalKunjungan)) ? 'none' : 'block' ?>">
            <?php echo CHtml::label('Lama Terapi Kunjungan', 'lamaterapi',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textfield('lamaterapi', '',array('style'=>'width:100px')) ?> <strong>Kali Kunjungan</strong>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} ',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                        array('class'=>'btn btn-success','onClick'=>'generateJadwal()','rel'=>'tooltip','data-title'=>'Klik untuk membuat jadwal kunjungan')); ?>
            </div>
        </div>
        
    <fieldset>
        <table class="table table-bordered table-condensed" id="tblDetailjadwal">
            <tr>
                <th>No. Urut</th>
                <th>Tgl. Jadwal Kunjungan</th>
                <th>Jenis - Tindakan</th>
                <th>Paramedis</th>
                <th>Dokter</th>
                <?php if(!empty($listJadwalKunjungan)){?>
                <th>Status Terapi</th>
                <?php } ?>
            </tr>
            <?php 
                if(!empty($listJadwalKunjungan))
                {
                    foreach ($listJadwalKunjungan as $jadwalKunjungan) {
            ?>
            <tr>
                <td><?php echo $jadwalKunjungan->nourutjadwal ?></td>
                <td><?php echo $jadwalKunjungan->harijadwalrm.' - '.$jadwalKunjungan->tgljadwalrm ?></td>
                <?php $tindakans = HasilpemeriksaanrmT::model()->findAllByAttributes(array('jadwalkunjunganrm_id'=>$jadwalKunjungan->jadwalkunjunganrm_id)) ?>
                <td>
                <?php 
                    foreach ($tindakans as $tindakan) {
                        $t = TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakan->tindakanrm_id);
                        echo $t->jenistindakanrm->jenistindakanrm_nama.' - ';
                        echo $t->tindakanrm_nama.'</br>';
                    } 
                ?>
                </td>
                <td>
                    <?php echo (!empty($jadwalKunjungan->paramedis1_id)) ?  ParamedisV::model()->findByAttributes(array('pegawai_id'=>$jadwalKunjungan->paramedis1_id))->nama_pegawai.' dan ' : '-' ?>
                    <?php echo (!empty($jadwalKunjungan->paramedis2_id)) ?  ParamedisV::model()->findByAttributes(array('pegawai_id'=>$jadwalKunjungan->paramedis2_id))->nama_pegawai : '-' ?>
                </td>
                <td>
                    <?php echo (!empty($jadwalKunjungan->pegawai_id)) ? DokterV::model()->findByAttributes(array('pegawai_id'=>$jadwalKunjungan->pegawai_id))->nama_pegawai : '-' ?>
                </td>
                <td>
                    <?php echo ($jadwalKunjungan->statusterapi) ? 'Sudah' : 'Belum' ?>
                </td>
            </tr>
            <?php            
                    }
                }
            ?>
        </table>
    </fieldset>
<table width='100%'>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td align='center'>Dicetak oleh</td>
        </tr>
        <tr height='100px'>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
        </tr>
</table>
</fieldset>
