<p style="margin: 0; text-align: center;"><h3>RESEPTUR</h3></p>
<?php 
 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
    } else{
        $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
    }
    // var_dump($modReseptur->attributes); die;
?>

<table width="100%" <?php echo $style; ?>>
    <tr>
        <td>No. Rekam Medik</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        <td>No. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->namadepan.$modPendaftaran->pasien->nama_pasien); ?></td>
        <td>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>No. Reseptur</td><td>:</td><td><?php echo CHtml::encode($modReseptur->noresep); ?></td>
    </tr>
    <tr>
        <td>Umur</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td>Tgl. Reseptur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur)); ?></td>
    </tr>
    <tr>
        <td>Jenis Penjamin / Penjamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?></td>
        <td>Dokter</td><td>:</td><td><?php echo CHtml::encode(empty($modPendaftaran->pegawai) ? "-" : $modPendaftaran->pegawai->namaLengkap); ?></td>
    </tr>
       
</table>
<br>
<table id="tblDaftarResep" class="table" border="2">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <!--th>Satuan</th-->
            <th  <?php echo Params::HIDDEN_HARGA; ?>>Estimasi Harga Satuan</th>
            <th>Jumlah</th>
            <th  <?php echo Params::HIDDEN_HARGA; ?>>Sub Total</th>
<!--<th>&nbsp;</th>-->
        </tr>
    </thead>
    
    <?php //echo print_r($modReseptur); 
//    exit(); ?>
    <?php // foreach ($modReseptur as $i => $reseptur) { ?>
    <?php //   $details = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur->reseptur_id));
        foreach ($modDetailResep as $detail) { ?>
    <tr>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <!--td><?php //echo $detail->satuankecil->satuankecil_nama ?></td-->
        <td <?php echo Params::HIDDEN_HARGA; ?> style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->hargasatuan_reseptur) ?></td>
        <td style="text-align: right"><?php echo number_format($detail->qty_reseptur, 2, ",", "")." ".$detail->satuankecil->satuankecil_nama ?></td>
        <td <?php echo Params::HIDDEN_HARGA; ?> style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->qty_reseptur * $detail->hargasatuan_reseptur) ?></td>
    </tr>
    <?php } 
    
    $login = LoginpemakaiK::model()->findByPk($modReseptur->create_loginpemakai_id);
    $peg_nama = "";
    if (!empty($login)) {
        $peg_nama = !empty($login->pegawai) ? $login->pegawai->namaLengkap : "-";
    }
    echo '<tr><td colspan="4">Dibuat Oleh : '.$peg_nama.'</td></td>';
    ?>
</table>