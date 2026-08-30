<style>
    .table {
        box-shadow: none;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid black;
    }
</style>


<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));


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
<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			<div class="judulcontent"> RINCIAN RESEPTUR </div>
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
        <td>Dokter</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?></td>
    </tr>

</table>
<br/>
<table id="tblDaftarResep" class="table" border="2">
    <thead>
        <tr>
            <th>Resep</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Harga Satuan (Rp)</th>
            <th>Total Embalase (Rp)</th>
            <th>PPN (%)</th>
            <th>PPN (Rp)</th>
            <th>Sub Total (Rp)</th>
        </tr>
    </thead>
    <tbody>
    <?php //echo print_r($modReseptur);
//    exit(); ?>
    <?php // foreach ($modReseptur as $i => $reseptur) { ?>
    <?php //   $details = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur->reseptur_id));
        $total = 0;
        $jasapelayanan_farmasi = 0;
        foreach ($modDetailResep as $detail) {
            //$total += $detail->qty_reseptur * $detail->hargasatuan_reseptur;
            $total += $detail->hargajual_reseptur;
            ?>
    <tr>
        <td><?php echo 'R/ ' . $detail->rke ?></td>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <!--td><?php //echo $detail->satuankecil->satuankecil_nama ?></td-->
        <td style="text-align: right"><?php echo number_format($detail->qty_reseptur, 2, ",", "")." ".$detail->satuankecil->satuankecil_nama ?></td>
        <td  <?php //echo Params::HIDDEN_HARGA; ?> style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->hargasatuan_reseptur,2) ?></td>
        <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->total_embalase,2) ?></td>

        <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->persenppnjual,2) ?></td>
        <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->jumlahppn,2) ?></td>
        <td  <?php //echo Params::HIDDEN_HARGA; ?> style="text-align: right"><?php
        //  $jasapelayanan_farmasi = $modReseptur->jasapelayanan_farmasi;
        // $total = $jasapelayanan_farmasi + $detail->hargajual_reseptur;
        // echo MyFormatter::formatNumberForPrint($detail->hargajual_reseptur,2) 
        echo MyFormatter::formatNumberForPrint($detail->hargajual_reseptur)?></td>
    </tr>
    <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">Total</td>
            <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($total,2); ?></td>
        </tr>
    </tfoot>
</table>
<br/>
<table align="RIGHT">
    <tr>
        <td>
<div align="CENTER">
     Dokter Pemeriksa
    <br/><br/><br/><br/>
   ( <?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?> )
</div>
        </td>

    </tr>
</table>
<table align="LEFT">
    <tr>
        <td>
<div align="CENTER">
</div>
        </td>

    </tr>

</table>
		</div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
