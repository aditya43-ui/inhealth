<p style="margin: 0; text-align: center;"><h3>RESEPTUR</h3></p>
<?php 

 $style = 'margin-left:auto; margin-right:auto;';
        $style = "style='margin-left:auto; margin-right:auto;'";

    
?>

<table width="100%" <?php echo $style; ?>>
    <tr>
        <td <?php // $td = array(); echo $td; ?>>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin ')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
            
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Nama Dokter')); ?>:</label>
            <?php echo CHtml::encode(empty($modPendaftaran->pegawai) ? "-" : $modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
    </tr>
       
    </table>
<br>
<table id="tblDaftarResep" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Estimasi Harga Satuan</th>
            <th>Jumlah</th>
            <th <?php echo Params::HIDDEN_HARGA ?>>Sub Total</th>
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
        <td><?php echo $detail->satuankecil->satuankecil_nama ?></td>
        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($detail->hargasatuan_reseptur); ?></td>
        <td style="text-align: right;"><?php echo number_format($detail->qty_reseptur, 2, ",", "") ?></td>
        <td <?php echo Params::HIDDEN_HARGA ?>><?php echo number_format($detail->qty_reseptur * $detail->hargajual_reseptur) ?></td>
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
<br>