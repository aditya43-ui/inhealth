<style>
    .border_c{
        border:1px solid;
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .spasi{
        height:10px;
    }

    .table_isi, tr, td{
        padding:5px;
    }
</style>

<b>FRM/125/RSBM</b>
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table border="1px" width="100%">
    <tr>
        <td>
            <div style="min-height:700px; margin-left:30px;">
                <br>
                <p>Yang bertandatangan dibawah ini :</p>
                <div style="margin-left:30px;">
                    <table width="100%" class="table_isi">
                        <tr>
                            <td width="15%">Nama Lengkap</td>
                            <td width="2%"> </td>
                            <td width="40%" class="border_c"><?= $model->nama_lengkap;?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td> </td>
                            <td class="border_c"><?= isset($model->tanggal_lahir) ? MyFormatter::formatdatetimeforuser($model->tanggal_lahir) : '-';?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> </td>
                            <td class="border_c"><?= $model->alamat;?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Hubungan dengan pasien</td>
                            <td> </td>
                            <td class="border_c"><?= $model->hubunganpasien;?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <br>
                <p>Dengan ini menyatakan permintaan untuk mendapatkan second opinion atas :</p>

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
                            <td>Tanggal Lahir</td>
                            <td> </td>
                            <td class="border_c"><?= isset($modPasien->tanggal_lahir) ? MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir) : '-';?></td>
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
                            <td>Alamat</td>
                            <td> </td>
                            <td class="border_c"><?= $modPasien->alamat_pasien;?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>

                        <tr>
                            <td>Dokter Sebagai Second Opinion</td>
                            <td> </td>
                            <td class="border_c"><?= isset($model->dokter_opinion) ?  $model->dokter_opinion : " - ";?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                       
                    </table>
                </div>

                <p style="text-align:justify; margin-right:30px;">Saya memahami perlunya dan manfaat second opinion tersebut sebagaimana telah dijelaskan kepada saya. Saya juga
                menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti dan selalu berkembang, maka perbedaan pendapat ahli adalah biasa
                terjadi dalam dunia kedokteran. <br>Saya menyadari beban biaya second opinion menjadi tanggung jawab saya</p>

                <br><br>
                <table width="100%">
                    <tr>
                        <td width="33%" style="text-align:center;"></td>
                        <td width="33%" style="text-align:center;"></td>
                        <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser(date('Y-m-d'));?></td>
                        
                    </tr>
                    <tr>
                        <td width="33%" style="text-align:center;"><?= $model->petugas_tanggungjawab?></td>
                        <td width="33%" style="text-align:center;">DPJP</td>
                        <td width="33%" style="text-align:center;"><?= $model->penerima_informasi?></td>
                        
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="min-height:50px;">
                                
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:center;">( <?= $model->petugas->NamaLengkap;?> )</td>
                        <td style="text-align:center;">( <?= $modPendaftaran->pegawai->NamaLengkap;?> )</td>
                        <td style="text-align:center;">( <?php if($model->penerima_informasi == "Pasien"){
                            echo $modPasien->nama_pasien;
                        }else{
                            echo $model->nama_penerima;
                        }?> )</td>
                        
                    </tr>
                
                </table>
                <br><br>
            </div>
            
        
        </td>
    </tr>

</table>

