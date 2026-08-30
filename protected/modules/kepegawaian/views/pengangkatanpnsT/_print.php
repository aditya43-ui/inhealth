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
                    array(
                        'label'=>'Photo',
                        'type'=>'raw',
                        'value'=>CHtml::image(((!empty($modPegawai->photopegawai))&&(file_exists(Params::pathPegawaiTumbsDirectory().$modPegawai->photopegawai))) ? Params::urlPegawaiTumbsDirectory().'kecil_'.$modPegawai->photopegawai : 'http://localhost/simrs/data/images/pasien/no_photo.jpeg', '', array('style'=>'width:150px')),
                    ),
//                    'pengangkatantphl_id',
//                    'pegawai_id',
//                'kelurahan.kelurahan_nama',
//                'kecamatan_id',
//                'profilrs_id',
//                'gelarbelakang_id',
//                'suku_id',
//                'kelompokpegawai_id',
//                'pendkualifikasi_id',
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
//                'propinsi_id',
//                'pangkat_id',
//                'kabupaten_id',
                'nomorindukpegawai',
//                'no_kartupegawainegerisipil',
//                'no_karis_karsu',
//                'no_taspen',
//                'no_askes',
//                'gelardepan',
                
//                'rhesus',
                'alamatemail',
                'notelp_pegawai',
                'nomobile_pegawai',
//                'warganegara_pegawai',
//                'jeniswaktukerja',
//                'kelompokjabatan',
//                'kategoripegawai',
//                'kategoripegawaiasal',
//                'photopegawai',
//                'pegawai_aktif',
//                'esselon_id',
//                'statuskepemilikanrumah_id',
//                'jenisidentitas',
//                'noidentitas',
//                'nofingerprint',
//                'tinggibadan',
//                'beratbadan',
//                'kemampuanbahasa',
//                'warnakulit',
//                'nip_lama',
//                'no_rekening',
//                'bank_no_rekening',
//                'npwp',
//                'tglditerima',
//                'tglberhenti',
                ),
            ));
            ?>
        </td>
        <td width ="8%">
            </td>
        <td width ="33%" style='vertical-align:top;'>
            <legend style = "color:#000;">Diusulkan</legend>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modUsulan,
                'attributes'=>array(
//                    'usulanpns_id',
//                    'pengangkatanpns_id',
                    'usulanpns_tglsk',
                    'usulanpns_nosk',
                    array(
                        'label'=>'Masa Kerja',
                        'type'=>'raw',
                        'value'=>$modUsulan->usulanpns_masakerjatahun.' Tahun - '.$modUsulan->usulanpns_masakerjabulan.' Bulan',
                    ),
//                    'usulanpns_masakerjatahun',
//                    'usulanpns_masakerjabulan',
                    //'usulanpns_gajipokok',
                    array(
                        'header' => 'Gaji Pokok',
                        'value' =>  'Rp'.number_format($modUsulan->usulanpns_gajipokok,0,"","."),
                        'htmlOptions' => array('style','color:blue;'),
                    ),
                    'usulanpns_pejabatygberwenang',
                ),
            )); ?>
            <?php if (isset($modPersetujuan)){ ?>
            <legend style = "color:#000;">Disetujui</legend>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPersetujuan,
                'attributes'=>array(
//                    'perspeng_id',
//                    'pengangkatanpns_id',
                    'perspeng_tglsk',
                    'perspeng_nosk',
                    array(
                        'label'=>'Masa Kerja',
                        'type'=>'raw',
                        'value'=>$modPersetujuan->perspeng_masakerjatahun.' Tahun - '.$modPersetujuan->perspeng_masakerjabulan.' Bulan',
                    ),
//                    'perspeng_masakerjatahun',
//                    'perspeng_masakerjabulan',
                    //'perspeng_gajipokok',
                    array(
                        'header' => 'Gaji Pokok',
                        'value' =>  'Rp'.number_format($modPersetujuan->perspeng_gajipokok,0,"","."),
                    ),
                    'perspeng_pejabatygberwenang',
                ),
            )); ?>
            <?php } ?>
            <?php if (isset($modRealisasi)){ ?>
            <legend style = "color:#000;">Direalisasi</legend>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modRealisasi,
                'attributes'=>array(
//                  realisasipns_id',
                    'realisasipns_tglsk',
                    'realisasipns_nosk',
                    array(
                        'label'=>'Masa Kerja',
                        'type'=>'raw',
                        'value'=>$modRealisasi->realisasipns_masakerjatahun.' Tahun - '.$modRealisasi->realisasipns_masakerjabulan.' Bulan',
                    ),
//                    'realisasipns_masakerjatahun',
//                    'realisasipns_masakerjabulan',
                    //'realisasipns_gajipokok',
                    array(
                        'header' => 'Gaji Pokok',
                        'value' =>  'Rp'.number_format($modRealisasi->realisasipns_gajipokok,0,"","."),
                    ),
                    'realisasipns_pejabatyangberwena',
//                    'pengangkatanpns_id',
                    
//                    'perspeng_masakerjatahun',
//                    'perspeng_masakerjabulan',
//                    'perspeng_gajipokok',
//                    'perspeng_pejabatygberwenang',
                ),
            )); ?>
            <?php } ?>
            <?php
//            $this->widget('ext.bootstrap.widgets.BootDetailView', array(
//                'data' => $model,
//                'attributes' => array(
////                    'pengangkatantphl_id',
//                    array(
//                        'label'=>'Photo',
//                        'type'=>'raw',
//                        'value'=>CHtml::image((!empty($model->pegawai->photopegawai)) ? Params::urlPegawaiTumbsDirectory().'kecil_'.$model->pegawai->photopegawai : Params::urlPhotoPasienDirectory().'no_photo.jpeg'),
//                    ),
//                    'pengangkatantphl_noperjanjian',
//                    'pengangkatantphl_tmt',
//                    'pengangkatantphl_tugaspekerjaan',
//                    'pengangkatantphl_nosk',
//                    'pengangkatantphl_tglsk',
//                    'pengangkatantphl_tmtsk',
//                    'pengangkatantphl_noskterakhir',
//                    'pengangkatantphl_keterangan',
//                    'pimpinannama',
//                ),
//            ));
            ?>
        </td>
        <td width ="13%">
        </td>
    </tr>
</table>
<?php //$this->widget('UserTips', array('type' => 'view')); ?>