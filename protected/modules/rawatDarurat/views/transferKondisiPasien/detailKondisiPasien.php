<style type="text/css">
    .tablefont td{
        color: black;
        padding: 5px;
    }
    .borderclass {
        border: 1px solid black;
    }
</style>

<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>Kategori dan Pendampiangan Pasien Transfer</strong></div>
    </div>
    <div class="panel-body">
        <table width="100%" class="tablefont">
            <tr>
                <td width="30%" valign="top">
                    Derajat Pasien : <?php echo (!empty($model->derajatpasien)?$model->derajatpasien:"-"); ?>
                </td>
                <td width="40%" valign="top">
                    Nama Petugas Pendamping
                    <table width="100%">
                        <?php
                            if(!empty($model->prosestransferpasien_id)){
                                $modPendamping = PegawaipendampingtransferpasienT::model()->findAllByAttributes(array('prosestransferpasien_id'=>$model->prosestransferpasien_id));

                                if(count($modPendamping) > 0){
                                    $pendampingvalue = "";
                                    $index= 1;
                                    foreach ($modPendamping as $i => $dataPendamping){
                                        $pendampingvalue .= "<tr><td>".$index.". ".$dataPendamping->pegawai_nama."</td></tr>";
                                        $index++;
                                    }
                                    echo $pendampingvalue;
                                }
                            }
                        ?>
                    </table>
                </td>
                <td width="30%" valign="top">
                    Catatan : <?php echo (!empty($model->catatanpendampingtransfer)?$model->catatanpendampingtransfer:"-"); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>VI. Kondisi Pasien (Sebelum Ditransfer)</strong></div>
    </div>
    <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="120px">Tanggal & Jam</td>
                            <td width="10px">:</td>
                            <td><?php echo (!empty($model->sebelumtransfer_tanggal)? MyFormatter::formatDateTimeForUser($model->sebelumtransfer_tanggal):"-"); ?></td>
                        </tr>
                        <tr>
                            <td >Keadaan Umum</td>
                            <td>:</td>
                            <td><?php echo (!empty($model->sebelumtransfer_keadaanumum)?$model->sebelumtransfer_keadaanumum:"-"); ?></td>
                        </tr>
                        <tr>
                            <td>Kesadaran</td>
                            <td>:</td>
                            <td><?php echo (!empty($model->sebelumtransfer_kesadaran)?$model->sebelumtransfer_kesadaran:"-"); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="font-weight: bold; color: black;">Pemeriksaan Tanda Vital</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Tensi</td>
                            <td>:</td>
                            <td> <?php echo (!empty($model->sebelumtransfer_td_systolic)?$model->sebelumtransfer_td_systolic:"-").'/ '.(!empty($model->sebelumtransfer_td_diastolic)?$model->sebelumtransfer_td_diastolic:"-"); ?> mmHg</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Suhu</td>
                            <td>:</td>
                            <td> <?php echo (!empty($model->sebelumtransfer_suhutubuh)?$model->sebelumtransfer_suhutubuh:"-"); ?> &#176 Celcius</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Nadi</td>
                            <td>:</td>
                            <td> <?php echo (!empty($model->sebelumtransfer_nadi)?$model->sebelumtransfer_nadi:"-"); ?> x/menit </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px">Petugas yang menyerahkan pasien</td>
                            <td width="10px">:</td>
                            <td><?php echo (isset($model->sebelumtransferpegawaiygmenyerahkan)? $model->sebelumtransferpegawaiygmenyerahkan->namaLengkap: "-"); ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color: black;">Skor EWS</td>
                            <td>:</td>
                            <td> <?php echo (!empty($model->sebelumtransfer_skorews)?$model->sebelumtransfer_skorews:"-").' '.(!empty($model->sebelumtransfer_klasifikasi_skorews)?$model->sebelumtransfer_klasifikasi_skorews:"-"); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold; color: black;">Catatan Penting</td>
                        </tr>
                        <tr>
                            <td colspan="2"> <?php echo (!empty($model->sebelumtransfer_catatanpenting)?$model->sebelumtransfer_catatanpenting:"-"); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>



    
    
