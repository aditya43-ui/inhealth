<style>
    .border_c{
        border:1px solid;
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .border_a{
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
        <td>I. IDENTITAS PASIEN</td>
    </tr>
    <tr>
        <td>
            <div>
                
                <div style="margin-left:30px;">
                    <table width="100%" class="table_isi">
                        <tr>
                            <td width="15%">Nama</td>
                            <td width="2%"> </td>
                            <td width="40%" class="border_c"><?= isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : '-';?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>No Rekam Medis</td>
                            <td> </td>
                            <td class="border_c"><?= isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : '-';?></td>
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
                            <td>Jenis Kelamin</td>
                            <td> </td>
                            <td class="border_c"><?= $modPasien->jeniskelamin;?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Alamat Lengkap</td>
                            <td> </td>
                            <td class="border_c"><?= $modPasien->alamat_pasien;?></td>
                        </tr>
                        
                    </table>
                </div>

                
                <br><br>
            </div>
            
        
        </td>
    </tr>
    <tr>
        <td>II. Diagnosa</td>
    </tr>
    <tr>
        <td>
            <?php 
            $utama = json_decode($model->diagnosaresusitasi);
            
            ?>

            <table width="100%">
                <tr>
                    <td>Utama : <?php foreach($utama as $i => $diagnosa){
                        if ($i == "utama"){
                            echo $diagnosa;
                        }
                    }?></td>
                </tr>
                <tr>
                    <td>Tambahan : <?php foreach($utama as $i => $diagnosa){
                        if ($i == "tambahan"){
                            echo $diagnosa;
                        }
                    }?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>III. STATUS RESUSITASI</td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td>Apakah pasien butuh resusitasi atau bantuan hidup dasar 
                        <span class="<?php echo (($model->pasienbutuh_resusitasi == true) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>Ya
                        <span class="<?php echo (($model->pasienbutuh_resusitasi == false) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>Tidak
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="200px;">Jika tidak, berikan alasan</td>
                                <td width="400px;" class="border_a"><?= $model->resusitasi_tidak;?></td>
                                <td></td>
                            </tr>
                        </table>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                    <?php $data = array("Kondisi pasien mengindikasikan bahwa resusitasi atau bantuan hidup dasar tidak mungkin efektif atau berhasil",
										"Pasien menolak dilakukan resusitasi atau bantuan hidup dasar",
										"Alasan lain, "
					);?>
                     <?php $index = 0;

                        
                        $bentuk = json_decode($model->resusitasistatus);

                        if ($bentuk == null){
                            $bentuk = array();
                        }
                        $cek = false;
                        foreach ($data as $val => $label): 
                            //foreach ($bentuk as $key => $value) {
                                if ($bentuk[$index] == $label){
                                    $cek = true;
                                }else{
                                    $cek = false;
                                }
                            //}
                        ?>

                        <?php if ($label == 'Alasan lain, '){?>
                            <div style="margin-left: 20px;">
                                <span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span> <?= $label ?><u><?= $model->resusitasi_lainnya;?> </u>
                            </div>
                            
                        <?php } else { ?>
                            <div style="margin-left: 20px;">
                                <span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span> <?= $label ?>
                            </div>

                        <?php }?>
                       
                    <?php $index++; endforeach; ?>
                       
                    </td>
                </tr>
            </table>
        
        </td>
    </tr>
    <tr>
        <td>IV. KOMUNIKASI</td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td>Diskusikan dengan pasien
                        <span class="<?php echo (($model->isdiskusidengan_pasien == true) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>Ya
                        <span class="<?php echo (($model->isdiskusidengan_pasien == false) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>Tidak
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="200px;">Jika tidak, berikan alasan</td>
                                <td width="400px;" class="border_a"><?= $model->diskusipasien_tidak;?></td>
                                <td></td>
                            </tr>
                        </table>
                        
                    </td>
                </tr>
                <tr>
                    <td>Diskusikan dengan keluarga pasien
                        <span class="<?php echo (($model->isdiskusidengan_keluarga == true) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>Ya
                        <span class="<?php echo (($model->isdiskusidengan_keluarga == false) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>Tidak
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="200px;">Jika tidak, berikan alasan</td>
                                <td width="400px;" class="border_a"><?= $model->diskusikeluarga_tidak;?></td>
                                <td></td>
                            </tr>
                        </table>
                        
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    
                    <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser(date('Y-m-d'))." ".date('G:i:s');?></td>
                    <td width="33%" style="text-align:center;"></td>
                    
                </tr>
                <tr>
                    <td width="33%" style="text-align:center;">Dokter Penanggung Jawab Pasien</td>
                    <td width="33%" style="text-align:center;"><?= $model->penerima_informasi;?></td>
                    
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="min-height:50px;">
                            
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td style="text-align:center;">( <?= $modPendaftaran->pegawai->NamaLengkap;?> )</td>
                    <td style="text-align:center;">( <?php if ($model->penerima_informasi == "Pasien"){
                                echo $modPasien->nama_pasien;
                            }else {
                                echo $model->nama_penerima;
                            }?>) </td>
                    
                </tr>
            
            </table>
        </td>
    </tr>
</table>

