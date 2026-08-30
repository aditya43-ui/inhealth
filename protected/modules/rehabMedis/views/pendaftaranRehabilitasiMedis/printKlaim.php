
<?php $this->widget('bootstrap.widgets.BootAlert');
function ceklis($st){
    $icon = '<span  style="font-family:FontAwesome;" >&#xf096;</span>';
    if ($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf046;</span>';
    }
    
    return $icon;
} ?>
<style>
    body {
/*        font-size: 8pt;*/
    }
    
    p{
        margin-left: 0;
        text-align: justify;
    }
    
    .tab-foot, .tab-foot td {
/*        font-size: 6pt;*/
    }
    .formfill tr{
        height: 50px;
    }
    
</style>
<?php
    $data = ProfilrumahsakitM::model()->find();
?>
<div class="header">
    <table width="100%">
        <tr>
            <td align="center">
            <B><span SIZE=4 style="letter-spacing: 2px;"><?php echo "FORMULIR KLAIM <br>RAWAT JALAN <br>" . strtoupper($data->nama_rumahsakit) . "<br>" ?></span></B>
            </td>
        </tr>
    </table>
</div>
<div class="content" style="margin: 0px 50px;">
    <table width= "100%" style="border: 1px solid;">
        <tr>
            <td>
                I. Diisi oleh Pasien/Peserta
            </td>
            <td></td>
            <td align="right">
                No RM/Req &nbsp; : <?php echo $modPasien->no_rekam_medik."/".$modPendaftaran->no_pendaftaran;?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class="formfill" width = "100%">
                    <tr>
                        <td width = "40%">Nama</td>
                        <td width = "1%">:</td>
                        <td><?php echo $modPasien->nama_pasien; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td><?php echo $modPasien->tanggal_lahir;//!empty($modPenanggungjawab)?$modPenanggungjawab->nama_pj:'-';?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?php echo $modPasien->alamat_pasien ?></td>
                    </tr>
                    <tr>
                        <td>Telp/HP</td>
                        <td>:</td>
                        <td><?php echo (!empty($modPasien->no_telepon_pasien)?$modPasien->no_telepon_pasien:'-')."/".(!empty($modPasien->no_mobile_pasien)?$modPasien->no_mobile_pasien:'-');?></td>
                    </tr>
                    <tr>
                        <td>Hubungan dengan tertanggung</td>
                        <td>:</td>
                        <td><?php if (!empty($modPenanggungjawab->hubungankeluarga)){?>
                            <table width="100%">
                                <tr>
                                    <td><?php echo !empty($modPenanggungjawab)?$modPenanggungjawab->nama_pj:'-';?></td>
                                    <td><?php echo ceklis($modPenanggungjawab->hubungankeluarga == 'SUAMI'||$modPenanggungjawab->hubungankeluarga == 'ISTRI' )."&nbsp;&nbsp;&nbsp;SUAMI/ISTRI" ?> </td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo ceklis($modPenanggungjawab->hubungankeluarga == 'ANAK')."&nbsp;&nbsp;&nbsp;ANAK" ?></td>
                                </tr>
                            </table>
                            <?php } else{?>
                                <table width="100%">
                                <tr>
                                    <td><?php echo !empty($modPenanggungjawab)?$modPenanggungjawab->nama_pj:'-';?></td>
                                </tr>
                            </table>
                            <?php } ?>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
        
    </table>
    <table width= "100%" style="border: 1px solid; margin-top:20px;" class="formfill">
        <tr>
            <td colspan="3">II. Diisi oleh Dokter SpKFR</td>
        </tr>
        <tr>
            <td width="40%">Tanggal Pelayanan</td>
            <td width="1%">:</td>
            <td></td>
        </tr>
        <tr>
            <td>Anamnesia</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Pemeriksaan Fisik dan Uji Fisik</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Diagnosis Medis (ICD-10)</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Diagnosis Fungsi (ICD-10)</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Pemeriksaan Penunjangan</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Tata Laksana KFR (ICD 9CM)</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Anjuran</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Evaluasi</td>
            <td>:</td>
            <td></td>
        </tr>
    </table>
    <table width='100%'>
                        <tr>
                            <td align='center'>Tanda Tangan Pasien</td>
                            <td align='center'><?php echo Yii::app()->user->getState('kecamatan_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                        </tr>
                        <tr>
                            <td align='center'>Tertanggung/Pasien/Karyawan</td>
                            <td align='center'><?php echo $data->nama_rumahsakit ?>,</td>
                        </tr>
                        <tr height='150px'>
                            <td align='center'>(.........................................)</td>
                            <td align='center'><?php echo $modPegawai->namaLengkap; ?></td>
                        </tr>
                        
                    </table>
</div>