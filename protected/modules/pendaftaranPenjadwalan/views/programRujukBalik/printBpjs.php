<?php 

$data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 

$bpjs = new BpjsVklaim;


?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>   

    body {
        color: black !important;
    }

    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td{
        font-size: 12pt !important;
    }

    td.header
    {
        padding-left:30px;
    }

    td
    {
        font-size: 12pt !important;
        vertical-align: top;
    }
</style>
<?php 

// var_dump($model->attributes);

//echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); ?>
<table width="100%" border = "0" style = "text-align:left;">
    <thead>
        <tr>
    <th width = "25%"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="300px"></th>
    <th align='left' style="font-weight:bold; text-align: left;"><span style="font-size:17px;"><?php echo $judulLaporan; ?><br><?php echo $data->nama_rumahsakit; ?></span></th>        
    <th align='left' width="300" style="font-weight:bold;"><span style="font-size:17px;">
    No. SRB. <?php echo $model->nosrb; ?><br/>
    Tanggal. <?php echo MyFormatter::formatDateTimeId($model->tglsrb); ?>
    </span></th>        
   <!--<th  style = "padding: 0;"><!--<img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit   ?>" width="120px"></th>-->
</tr>
</thead>
<tbody>
    <tr>
        <td colspan="3">
            <table width="100%">
                <tr>
                    <td width="50%">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td>Kepada Yth</td><td>:</td><td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td><td></td><td></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Mohon Pemeriksaan dan Penanganan Lebih Lanjut: </td>
                                </tr>
                                <tr>
                                    <td>No. Kartu</td><td>:</td><td><?php echo $model->nokartuasuransi; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Peserta</td><td>:</td><td><?php echo $model->nama_pasien; ?></td>
                                </tr>
                                <tr>
                                    <td>Tgl. Lahir</td><td>:</td><td><?php echo date('d/m/Y', strtotime($model->tanggal_lahir)); ?> </td>
                                </tr>
                                <tr>
                                    <td>Diagnosa</td><td>:</td><td><?php echo "" ?></td>
                                </tr>
                                <tr>
                                    <td>Program PRB</td><td>:</td><td><?php echo $model->programprb_nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td><td>:</td><td><?php echo $model->keterangan; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Saran Pengelolaan Lanjutan di FKTP :<br/><?php echo $model->saran; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td>R/.</td><td></td><td></td><td></td>
                                </tr>
                                <?php foreach ($modObat as $i => $item): 
                                    // var_dump($item->attributes);
                                    ?>
                                <tr>
                                    <td width="50"><?php echo $i + 1; ?></td>
                                    <td width="100"><?php echo $item->signa; ?></td>
                                    <td><?php echo $item->obatprb_bpjsnama; ?></td>
                                    <td width="50"><?php echo $item->qty_obat; ?></td>
                                </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <br/>
            <table width="100%">
                <tbody>
                    <tr>
                        <td>
                            Demikian atas bantuannya, diucapkan terima kasih
                            <br/><br/><br/>
                            <div>Tgl. Cetak. <?php echo date('d-m-Y H:i:s'); ?></div>

                        </td>
                        <td width="35%">
                            Mengatahui,
                            <br/><br/><br/>
                            ________________
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    <tr>
    
</tbody>
</table>

