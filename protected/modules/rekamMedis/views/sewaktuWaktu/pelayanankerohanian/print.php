<p><b>FRM/ REV 01/ RSBM</b></p>
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>
<table border="1px" width="100%">
    <tr>
        <td>
            <div style="min-height:700px;">
                <br>
                <table width="100%">
                    <tr>
                        <td width="10%">Ruangan</td>
                        <td width="2%">:</td>
                        <td width="88%"><?= $model->ruangan->ruangan_nama;?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?= $model->agama;?></td>
                    </tr>
                    <tr>
                        <td>Permintaan</td>
                        <td>:</td>
                        <td><?= MyFormatter::formatdatetimeforuser($model->tgl_permintaan);?></td>
                    </tr>
                </table>

                <br>
                <p>Bentuk layanan kegiatan kerohanian yang diminta :</p>

                <?php $data = LookupM::getItemsUrutan('layanankerohanian');?>
                <?php $index = 0;

                        
                        $bentuk = json_decode($model->bentuk_layanan);


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
                            //}
                        
                        ?>
                    <div style="margin-left: 20px;">
                        <span class="<?php echo (($cek == true) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span> <?= $label ?>
                        
                    </div>
                    <?php $index++; endforeach; ?>
                
                <br>
                <table width="100%">
                    <tr>
                        <td width="15%">Nama petugas kerohanian</td>
                        <td width="2%">:</td>
                        <td width="83%"><?= isset($model->petugas_kerohanian) ? $model->petugas_kerohanian : '-';?></td>
                    </tr>
                    <tr>
                        <td>
                            Tanggal Kedatangan Petugas
                        </td>
                        <td>:</td>
                        <td><?= isset($model->tgl_kedatangan_petugas) ? MyFormatter::formatDateTimeForUser($model->tgl_kedatangan_petugas) : '-';?></td>
                    </tr>
                    <tr>
                        <td>
                            No Telepon / Hp
                        </td>
                        <td>:</td>
                        <td><?= $model->no_hp;?></td>
                    </tr>
                </table>

                <br><br>
                <table width="100%">
                    <tr>
                        <td width="33%" style="text-align:center;">Dokter</td>
                        <td width="33%" style="text-align:center;">Rohaniawan</td>
                        <td width="33%" style="text-align:center;">
                            <?= $model->penerima_informasi;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="min-height:50px;">
                                
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:center;">(<?= $modPendaftaran->pegawai->NamaLengkap;?>)</td>
                        <td style="text-align:center;">(<?= $model->petugas_kerohanian;?>)</td>
                        <td style="text-align:center;">
                            ( <?php if ($model->penerima_informasi == "Pasien"){
                                echo $modPasien->nama_pasien;
                            }else {
                                echo $model->nama_penerima;
                            }?>)
                        
                        </td>
                    </tr>
                
                </table>
                <br><br>
            </div>
            
        
        </td>
    </tr>

</table>

