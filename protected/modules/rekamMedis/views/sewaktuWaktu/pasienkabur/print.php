<style>
    .border_c{
        border:1px solid;
    }

    .spasi{
        height:10px;
    }

    .table_isi, tr, td{
        padding:5px;
    }
</style>

<b>FRM/ REV 01/ RSBM</b>
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table border="1px" width="100%">
    <tr>
        <td>
            <div style="min-height:700px; margin-left:30px;">
                <br>
                <p>Saya yang bertandatangan dibawah ini :</p>
                <div style="margin-left:30px;">
                    <table width="100%" class="table_isi">
                        <tr>
                            <td width="15%">Nama Lengkap</td>
                            <td width="2%"> </td>
                            <td width="53%" class="border_c"><?= $model->nama_lengkap;?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td> </td>
                            <td class="border_c"><?= $model->jabatan;?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td> </td>
                            <td class="border_c"><?= $model->nip;?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <br>
                <p>Dengan ini menyatakan bahwa pada hari ini. Singaraja, tanggal dan jam : <?= MyFormatter::formatDateTimeForUser($model->tanggal_pengisian)?></p>
                <p>WITA terdapat Pasien Kabur dari Ruangan Saya identitas :</p>

                <br>
                <div style="margin-left:30px;">
                    <table width="100%" class="table_isi">
                        <tr>
                            <td width="15%">Nama pasien</td>
                            <td width="2%"> </td>
                            <td width="40%" class="border_c"><?= isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : '-';?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Nomor RM</td>
                            <td> </td>
                            <td class="border_c"><?= isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : '-';?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Ruang Perawatan</td>
                            <td> </td>
                            <td class="border_c"><?= $modPendaftaran->ruangan_nama;?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;">Ciri - Ciri Khusus</td>
                            <td> </td>
                            <td class="border_c"><div style="min-height:60px;"><?= $model->ciri_khusus;?></div></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;">Penyebab Kabur</td>
                            <td> </td>
                            <td class="border_c"><div style="min-height:60px;"><?= $model->penyebab_kabur;?></div></td>
                        </tr>
                    </table>
                </div>

                <br><br>
                <table width="100%">
                    <tr>
                        <td width="33%" style="text-align:center;">Mengetahui</td>
                        <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser(date('Y-m-d'));?></td>
                        
                    </tr>
                    <tr>
                        <td width="33%" style="text-align:center;"><?= $model->kepala_tanggungjawab;?></td>
                        <td width="33%" style="text-align:center;">Petugas Ruangan</td>
                        
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="min-height:50px;">
                                
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:center;">(<?= $model->petugas->NamaLengkap;?>)</td>
                        <td style="text-align:center;">(<?= $model->petugasRuangan->NamaLengkap;?>)</td>
                        
                    </tr>
                
                </table>
                <br><br>
            </div>
            
        
        </td>
    </tr>

</table>

