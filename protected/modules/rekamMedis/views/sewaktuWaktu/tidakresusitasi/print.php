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

<b>FRM/ 121 / RSBM</b>
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table border="1px" width="100%">
    <tr>
        <td>
            <div style="margin-left:30px;">
                <br>
                <?php if (!empty($modPendaftaran->pasienadmisi_id)){ ?>
                    <p>Ruangan : <?= $modAdmisi->ruangan->ruangan_nama;?></p>
                    <p>Instalasi  : RAWAT INAP</p>
                <?php }else{ ?>
                    <p>Ruangan : <?= $modPendaftaran->ruangan->ruangan_nama;?></p>
                    <p>Instalasi  : <?= $modPendaftaran->instalasi->instalasi_nama;?></p>

                <?php }?>
                
            </div>
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
                <p>Dengan ini menyatakan bahwa saya membuat keputusan dan menyetujui untuk tidak dilakukan :</p>

                <?php $data = LookupM::getItemsUrutan('keputusanresusitasi');?>
                <?php $index = 0;

                        
                        $bentuk = json_decode($model->isikeputusan);

                        if ($bentuk == null){
                            $bentuk = array();
                        }
                        $cek = false;
                        foreach ($data as $val => $label): 
                            // foreach ($bentuk as $key => $value) {
                                if ($bentuk[$index] == $label){
                                    $cek = true;
                                }else{
                                    $cek = false;
                                }
                            // }
                        
                        ?>
                    <div style="margin-left: 20px;">
                        <span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span> <?= $label ?>
                        
                    </div>
                    <?php $index++; endforeach; ?>
                <br>
                <p>Terhadap Pasien :</p>
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
                            <td colspan="4" class="spasi"></td>
                        </tr>
                       
                    </table>
                </div>

                <p style="text-align:justify; margin-right:30px;">Saya menyatakan bahwa jika jantung saya berhenti mendetak atau jika saya berheti bernafas, tidak ada prosedur
				medis untuk mengembalikan sistem pernapasan atau berfungsi kembali jantung akan dilakukan oleh staf rumah sakit,
				namun tidak terbatas pada staf layanan medis darurat.<br>
				Saya memahami bahwa keputusan ini tidak mencegah saya menerima pelayanan kesehatan lainnya seperti pemberian
				manuver heimlich atau pemberian oksigen, dan kebutuhan dasar medis manusia lainnya.<br>
				Saya memberikan izin agar informasi ini diberikan kepada seluruh staf rumah sakit, saya memahami bahwa saya
				dapat mencabut keputusan ini setiap saat</p>

                <br><br>
                <table width="100%">
                    <tr>
                        <td width="33%" style="text-align:center;"></td>
                        <td width="33%" style="text-align:center;"></td>
                        <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser(date('Y-m-d'))." ".date('G:i:s');?></td>
                        
                    </tr>
                    <tr>
                        <td width="33%" style="text-align:center;">Yang Menyatakan</td>
                        <td width="33%" style="text-align:center;">Saksi I</td>
                        <td width="33%" style="text-align:center;">Saksi II</td>
                        
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="min-height:50px;">
                                
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:center;">( <u><?= $model->nama_menyatakan;?></u> )</td>
                        <td style="text-align:center;">( <u><?= $model->saksi1;?></u> )</td>
                        <td style="text-align:center;">( <u><?= $model->saksi->NamaLengkap;?></u> )</td>
                        
                    </tr>
                    <tr>
                        <td style="text-align:center;">( <?= $model->pasienmenyatakan;?> )</td>
                        <td style="text-align:center;">( Keluarga Pasien )</td>
                        <td style="text-align:center;">( Tenaga Kesehatan )</td>
                        
                    </tr>
                
                </table>
                <br><br>
            </div>
            
        
        </td>
    </tr>

</table>

