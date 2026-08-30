
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
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
        height: 70px;
    }
</style>
<?php
    $data = ProfilrumahsakitM::model()->find();
?>
<div class="header">
    <table width="100%">
        <tr>
            <td align="right">Form RM10e</td>
        </tr>
        <tr>
             <td>
                    <B><span SIZE=4 style="letter-spacing: 2px;"><?php echo "FORMULIR KLAIM <br>RAWAT JALAN <br>" . strtoupper($data->nama_rumahsakit) . "<br>" ?></span></B>
                </td>
        </tr>
    </table>
</div>
<div class="content">
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>Nama Keluarga</td>
            <td>:</td>
            <td><?php echo !empty($modPenanggungjawab)?$modPenanggungjawab->nama_pj:'-';?></td>
        </tr>
        <tr>
            <td>No. RM</td>
            <td>:</td>
            <td><?php echo $modPasien->no_rekam_medik ?></td>
        </tr>
        <tr>
            <td>Penjamin</td>
            <td>:</td>
            <td><?php echo !empty($modPenjamin)?$modPenjamin->penjamin_nama:'-';?></td>
        </tr>
        <?php if ($modPendaftaran->carabayar_id != 1):
            $noKartuAsuransi = AsuransipasienM::model()->findByAttributes(array('pasien_id'=>$modPasien->pasien_id));
        ?>
        <tr>
            <td>Nomor Peserta</td>
            <td>:</td>
            <td><?php echo $noKartuAsuransi->nokartuasuransi;?></td>
        </tr>
    <?php endif; ?>
    </table>
    <table>
        <tr>
            <td>
                <p>
                    Pernyataan dan pemberi kuasa kepada dokter yang merawat, Rumah sakit/ Klinik:
                </p>
            </td>
        </tr>
        <tr>
            <td align="justify">
                Saya tertanggung / karyawan, dengan ini menyatakan bahwa keterangan tersebut di atas adalah lengkap dan benar
                , saya tertanggung / karyawan, dengan ini memberikan kuasa kepada dokter spesialis / dokter umum / rumah sakit / dengan
                siapa yang tertanggung di periksa atau di rawat, untuk memberikan keterangan lengkap
                mengenai keadaan / penyakit tertanggung termasuk data medis kepada pihak ketiga yang ditunjuk secara sah
            </td>
        </tr>
    </table>
    <table class="formfill">
        <tr>
            <td width="10%" height = "20px">Diagnosis<br>Primer<br>(Utama)</td>
            <td width="1%">:</td>
            <td width="60%">___________________________________________________________________________________</td>
        </tr>
        <tr>
            <td>Tindakan</td>
            <td>:</td>
            <td width="60%">___________________________________________________________________________________</td>
        </tr>
        <tr>
            <td>Pemeriksaan<br>Penunjang<br>(Utama)</td>
            <td>:</td>
            <td width="60%">___________________________________________________________________________________</td>
        </tr>
    </table>
    <table width='100%'>
                        <tr>
                            <td align='center'>Tanda Tangan</td>
                            <td align='center'><?php echo Yii::app()->user->getState('kecamatan_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                        </tr>
                        <tr>
                            <td align='center'>Tertanggung/Pasien/Karyawan</td>
                            <td align='center'><?php echo $data->nama_rumahsakit ?>,</td>
                        </tr>
                        <tr height='150px'>
                            <td align='center'>(.........................................)</td>
                            <td align='center'><?php echo $modPegawai->namaLengkap; ?><br>Tanda Tangan dan Stempel Dokter</td>
                        </tr>
                        
                    </table>
</div>