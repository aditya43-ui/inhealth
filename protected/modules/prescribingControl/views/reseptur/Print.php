
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
    } else{
        $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
    }
    
?>

<table width="100%" <?php echo $style; ?>>
    <tr>
        <td <?php $td = array(); echo $td; ?>>
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
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
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
            <th>Sub Total</th>
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
        <td><?php echo $detail->hargajual_reseptur ?></td>
        <td><?php echo $detail->qty_reseptur ?></td>
        <td><?php echo number_format($detail->qty_reseptur * $detail->hargajual_reseptur) ?></td>
    </tr>
    <?php } ?>
</table>
<br>
<table align="RIGHT">
    <tr>
        <td>
<div style="text-align: center;">
     Dokter Pemeriksa
    <br><br><br><br>
   ( <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?> )
</div>
        </td>
        
    </tr>
</table>
<table align="LEFT">
    <tr>
        <td>
<div style="text-align: center;">
     Catatan Dokter : <?php echo (isset($riwayat->catatandokterpengirim) ? CHtml::encode($riwayat->catatandokterpengirim) : ""); ?>
   
</div>
        </td>
        
    </tr>
    
</table>