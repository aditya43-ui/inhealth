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
        <td>Observasi dan Persetujuan Tindakan Restraint</td>
    </tr>
    <tr>
        <td><div style="margin-left:30px;">
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
        <td>
            <p>Dokter harus dihubungi terlebih dahulu untuk mengisi Aplikasi ini</p>
            <table width="100%">
                <tr>
                    <td width="15%">Tanggal Pengkajian</td>
                    <td width="2%">:</td>
                    <td width="28%" class="border_a"><?= MyFormatter::formatdatetimeforuser($model->tanggal_pengkajian);?></td>
                    <td width="10%"></td>
                    <td width="15%">Dilakukan oleh</td>
                    <td width="2%">:</td>
                    <td width="28%" class="border_a"><?= $model->dilakukanoleh;?></td>
                </tr>
                <tr>
                    <td>Pengkajian Restrain</td>
                    <td>:</td>
                    <td class="border_a"><?= $model->pengkajian_restrain;?></td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Dokter yang merawat</td>
                    <td>:</td>
                    <td class="border_a"><?= $model->dokteryang_merawat;?></td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>Dihubungi</td>
                    <td>:</td>
                    <td><span class="<?php echo (($model->dihubungi == true) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span> Ya
                    <span class="<?php echo (($model->dihubungi == false) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span> Tidak</td>
                    <td colspan="3"></td>
                </tr>

            </table>
            <br>
            <table width="100%" border="1px">
            <thead>
                <tr>
                    <th>Tipe Restrain</th>
                    <th>Lamanya Restrain</th>
                    <th>Frekuensi Evaluasi Penggunaan Restrain (Minimal setiap 24 Jam)</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                if (!empty($model->observasirestrain_id)){
                $modDetail = ObservasirestraindetT::model()->findAllByAttributes(array('observasirestrain_id'=>$model->observasirestrain_id));
                if (count($modDetail) > 0){
                    foreach ($modDetail as $i=>$data){?>
                        <tr>
                            <td> <?php echo $data->tiperestrain; ?> </td>       
                            <td> <?php echo $data->lamarestrain; ?> </td>       
                            <td> <?php  echo $data->frekuensirestrain; ?> </td>       
                            
                        </tr>
                    <?php }
                }}?>

            </tbody>
            </table>
        </td>

    </tr>
    <tr>
        <td>Persetujuan Oleh dokter yang merawat</td>
    </tr>
    <tr>
        <td>
            <br>
            <p>Saya menyetujui tindakan pengekangan (restrain) berdasarkan pada :</p>
            <table width="100%">
                <tr>
                    <?php $data = array("Observasi",
										"Informasi/komunikasi dengan perawat",
										"Komunikasi antar tim kesehatan"
					);
				
					if (!empty($model->persetujuanolehdokter)){
						$model->persetujuanolehdokter = json_decode($model->persetujuanolehdokter);	
					}?>
                    <?php $index = 0;
                        
                        foreach ($data as $val => $label): ?>
                        <?php 
                        $cek = false;
                        foreach($model->persetujuanolehdokter as $val){
                            if ($val == $label){
                                $cek = true;
                            }
                        }?>
                        <td width="33%"><span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span>&nbsp;<?= $label ?></td>
                        
                    <?php $index++; endforeach; ?>
                   
                </tr>
            </table>

            <table width="100%">
                <tr>
                    <td width="33%" style="text-align:center;"></td>
                    <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser(date('Y-m-d'));?></td>
                    
                </tr>
                <tr>
                    <td width="33%" style="text-align:center;">Dokter</td>
                    <td width="33%" style="text-align:center;">Dokter</td>
                    
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="min-height:50px;">
                            
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td style="text-align:center;">( <?= $model->dokteryang_merawat;?> )</td>
                    <td style="text-align:center;">( <?= $model->saksi;?> )</td>
                    
                </tr>
                <tr><td></td></tr>
            
            </table>
            <br>
        </td>
    </tr>

    <tr>
        <td>Pemberitahuan Kepada Keluarga</td>
    </tr>
    <tr>
        <td>
            <br>
            <table width="100%">
                <tr>
                    <td width="200px">Keluarga sudah diberitahu</td>
                    <td width="70%"><span class="<?php echo (($model->iskeluarga_diberitahu == true) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span> Ya
                    <span class="<?php echo (($model->iskeluarga_diberitahu == false) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span> Tidak</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td class="border_a"><?= $model->nama_keluarga;?></td>
                </tr>
                <tr>
                    <td>Hubungan degan pasien</td>
                    <td class="border_a"><?= $model->hubungan_keluarga;?></td>
                </tr>
                <tr>
                    <td>Kebutuhan Restrain</td>
                    <td><span class="<?php echo (($model->kebutuhan_restrain_fisik == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span> Fisik
                    <span class="<?php echo (($model->kebutuhanrestrain_obatobatan == false) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span> Obat - obatan</td>
                </tr>
                <tr>
                    <td>Tujuan Restrain</td>
                    <td class="border_a"><?= $model->tujuan_restrain;?></td>
                </tr>
            </table>
            <br>
            <p>Saya sudah menerima informasi dan mengerti perlunya tindakan ini.</p>
            <br>
        </td>
    </tr>
            
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="33%" style="text-align:center;"></td>
                    <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser(date('Y-m-d'));?></td>
                    
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

