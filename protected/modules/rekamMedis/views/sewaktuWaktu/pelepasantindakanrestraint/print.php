<style>
    .border_c{
        border:1px solid;
    }

    .border_a{
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

<!-- <b>FRM/123/RSBM</b> -->
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table border="1px" width="100%">
    <tr>
        <td><div>
                <br>
                <?php if (!empty($modPendaftaran->pasienadmisi_id)){ ?>
                    <p>Ruang : <?= $modAdmisi->ruangan->ruangan_nama;?></p>
                    <p>Alamat : <?= $modPasien->alamat_pasien;?></p>
                <?php }else{ ?>
                    <p>Ruang : <?= $modPendaftaran->ruangan->ruangan_nama;?></p>
                    <p>Alamat : <?= $modPasien->alamat_pasien;?></p>
                <?php }?>
                
            </div>
        </td>
    </tr>
    <tr>
        <td>Pengkajian Fisik dan Mental</td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="10%">Keadaan</td>
                    <td width="35%" class="border_a"><?= $model->kesadaran;?></td>
                    <td width="5%"></td>
                    <td width="10%">Tekanan Darah</td>
                    <td width="35%" class="border_a"><?= $model->tekanandarah;?></td>
                    <td width="5%">mmHg</td>
                </tr>
                <tr>
                    <td>GCS Eye</td>
                    <td class="border_a"><?= $model->gcs_eye;?></td>
                    <td></td>
                    <td>Pernapasan</td>
                    <td class="border_a"><?= $model->pernapasan;?></td>
                    <td>x/menit</td>
                </tr>
                <tr>
                    <td>GCS Verbal</td>
                    <td class="border_a"><?= $model->gcs_verbal;?></td>
                    <td></td>
                    <td>Suhu</td>
                    <td class="border_a"><?= $model->suhu;?></td>
                    <td>'C</td>
                </tr>
                <tr>
                    <td>GCS Motorik</td>
                    <td class="border_a"><?= $model->gcs_motorik;?></td>
                    <td></td>
                    <td>Nadi</td>
                    <td class="border_a"><?= $model->nadi;?></td>
                    <td>x/menit</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Skala Nyeri</td>
                    <td class="border_a"><?= $model->skala_nyeri;?></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>Hasil Observasi</td>
    </tr>
    <tr>
        <td>
            <?php $data = array("Pasien gelisah atau delirium dan berontak",
                                "Pasien tidak koperatif",
                                "Ketidak mampuan dalam mengikuti perintah atau tidak meninggalkan tempat tidur",
                                "Pasien koperatif"
            );
        
            if (!empty($model->hasilobservasi)){
                $model->hasilobservasi = json_decode($model->hasilobservasi);	
            }?>
            <table>
            <?php $index = 0;
                foreach ($data as $val => $label): ?>
                <?php 
                $cek = false;
                foreach($model->hasilobservasi as $val){
                    if ($val == $label){
                        $cek = true;
                    }
                }?>
                <tr>
                    <td>
                        <span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span>&nbsp;<?= $label ?><br>
                    </td>
                </tr>
                
            <?php $index++; endforeach; ?>
            </table>
        </td>
    </tr>
    <tr>
        <td>Penilaian dan Order Dokter</td>
    </tr>
    <tr>
        <td>
            <div style="margin-left:5px;">
                <p><b>A. Restrain Non Farmakologi</b></p>
            </div>
            <?php $data = array("Restrain tempat tidur atau bed rail",
									"Restrain pergelangan tangan",
									"Tangan kiri",
									"Tangan Kanan",
									"Restrain Pergelangan Kaki",
									"Kaki kiri",
									"Kaki kanan",
									"Lain - lain"
				);
        
            if (!empty($model->restrain_nonfarmotologi)){
                $model->restrain_nonfarmotologi = json_decode($model->restrain_nonfarmotologi);	
            }?>
            <table>
            <?php $index = 0;
                foreach ($data as $val => $label): ?>
                <?php 
                $cek = false;
                foreach($model->restrain_nonfarmotologi as $val){
                    if ($val == $label){
                        $cek = true;
                    }
                }?>
                <?php if ($label == 'Lain - lain'){?>
                    
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td><span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span>&nbsp;<?= $label ;?></td>
                                        <td width="300px" class="border_c"><?= $model->keterangan_lainnya;?></td>
                                    </tr>
                                </table>
                                
                               
                            </td>
                            
                        </tr>
                <?php } else {?>
                        <tr  style="height:10px;">
                            <td>
                                <div style="margin-left:5px;">
                                <span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span>&nbsp;<?= $label ?>
                                </div>
                            </td>
                           
                        </tr>
                    
                <?php }?>
                
                
            <?php $index++; endforeach; ?>
            </table>

            
            <table>
                <tr>
                    <td><b>B. Restrain Farmakologi</b></td>
                    <td width="300px" class="border_c"><?= $model->restrain_farmatologi;?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>Restrain Dilanjutkan</td>
    </tr>
            
    <tr>
        <td>
            <span class="<?php echo (($model->restraindilanjutkan == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span>&nbsp;Ya ( lanjutkan ke pengkajian lanjutan di catatan
					perkembangan terintegrasi dan di observasi di form observasi khusus )
            <br>
            <br>
            <span class="<?php echo (($model->restraintidak_dilanjutkan == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span>&nbsp;Tidak ( Penghentian Restrain )
            <table width="100%">
                <tr>
                    <td width="33%" style="text-align:center;"></td>
                    <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser(date('Y-m-d'))." ".date('G:i:s');?></td>
                    
                </tr>
                <tr>
                    <td width="33%" style="text-align:center;">Dijelaskan Oleh</td>
                    <td width="33%" style="text-align:center;">Yang Menerima Informasi</td>
                    
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="min-height:50px;">
                            
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td style="text-align:center;">( <?= $model->pemberi_informasi;?> )</td>
                    <td style="text-align:center;">( <?= $model->penerima_informasi;?> )</td>
                    
                </tr>
            
            </table>

        </td>
    </tr>
    
</table>

