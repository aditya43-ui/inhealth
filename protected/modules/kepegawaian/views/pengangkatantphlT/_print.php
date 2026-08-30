<?php
echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan));
?>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width ="13%">
        </td>
        <td width ="33%">
            <?php
            $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $modPegawai,
                'attributes' => array(
                'nama_pegawai',
                'nama_keluarga',
                'tempatlahir_pegawai',
                'tgl_lahirpegawai',
                'jeniskelamin',
                'statusperkawinan',
                'alamat_pegawai',
                'agama',
                'golongandarah',
                'jabatan.jabatan_nama',
                'pendidikan.pendidikan_nama',
                'nomorindukpegawai',
                'alamatemail',
                'notelp_pegawai',
                'nomobile_pegawai',
                ),
            ));
            ?>
        </td>
        <td width ="8%">
            </td>
        <td width ="33%"  style='vertical-align:top;'>
            <?php
            $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
//                    'pengangkatantphl_id',
                    array(
                        'label'=>'Photo',
                        'type'=>'raw',
                        'value'=>CHtml::image(((!empty($model->pegawai->photopegawai))&&(file_exists(Params::pathPegawaiTumbsDirectory().'kecil_'.$model->pegawai->photopegawai))) ? Params::urlPegawaiTumbsDirectory().'kecil_'.$modPegawai->photopegawai : 'http://localhost/simrs/data/images/pasien/no_photo.jpeg', '', array('style'=>'width:150px')),
                    ),
                    'pengangkatantphl_noperjanjian',
                    'pengangkatantphl_tmt',
                    'pengangkatantphl_tugaspekerjaan',
                    'pengangkatantphl_nosk',
                    'pengangkatantphl_tglsk',
                    'pengangkatantphl_tmtsk',
                    'pengangkatantphl_noskterakhir',
                    'pengangkatantphl_keterangan',
                    'pimpinannama',
                ),
            ));
            ?>
        </td>
        <td width ="13%">
        </td>
    </tr>
</table>