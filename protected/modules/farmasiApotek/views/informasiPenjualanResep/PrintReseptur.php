<table>
    <tr>
        <td colspan="3">
            <table>
                <tr>
                    <td>
                        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultStruk'); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="margin-left:10px">
    <tr>
        <td>Tgl. Pendaftaran </td>
        <td>:</td>
        <td><?php echo $daftar->tgl_pendaftaran;?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $daftar->no_pendaftaran;?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No. RM</td>
        <td>:</td>
        <td><?php echo $pasien->no_rekam_medik; ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $pasien->nama_pasien;?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No. Resep</td>
        <td>:</td>
        <td><?php echo $reseptur->noresep;?></td>
        <td></td>
        <td></td>
    </tr>
</table><br>
<table border="2" style="margin-left:10px;border-bottom-color:black;">
    <thead>
        <tr>
            <th>No.</th><th>Nama Obat</th><th>Jumlah</th><th>Harga Satuan</th><th>Keringanan</th><th>Sub Total</th>
        </tr>
    </thead>
    
<?php if($reseptur != null){ ?>
    <tbody>
        <?php 
        $total = 0;
        foreach($detailreseptur as $i=>$rincian) { 
            $subTotal =($rincian->hargajual_oa - ($rincian->hargajual_oa * ($rincian->discount / 100)));
            $total = $total + $subTotal;
            $diskon = FAPenjualanResepT::model()->findByAttributes(array('penjualanresep_id'=>$rincian->penjualanresep_id))
        ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $rincian->obatalkes->obatalkes_nama; ?></td>
            <td style="text-align: right;"><?php echo $rincian->qty_oa; ?></td>
            <td style="text-align: right;"><?php echo number_format($rincian->harganetto_oa); ?></td>
            <td style="text-align: right;"><?php echo number_format($rincian->discount); ?></td>
            <td style="text-align: right;"><?php echo number_format($subTotal); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <tr>
            <td style="text-align: right;" colspan="5">Biaya Administrasi</td>
            <td style="text-align: right;"><?php echo number_format($diskon->biayaadministrasi); ?></td>
            </tr>
             <tr>
                <td style="text-align: right;" colspan="5">Biaya Konseling</td>
                <td style="text-align: right;"><?php echo number_format($diskon->biayakonseling); ?></td>
            </tr>
             <tr>
                <td style="text-align: right;" colspan="5">Total Tarif Service</td>
                <td style="text-align: right;"><?php echo number_format($diskon->totaltarifservice); ?></td>
            </tr>
             <tr>
                <td style="text-align: right;" colspan="5">Jasa Dokter Resep</td>
                <td style="text-align: right;"><?php echo number_format($diskon->jasadokterresep); ?></td>
            </tr>
            
             <tr>
                <td style="text-align: right;" colspan="5">Keringanan</td>
                <td style="text-align: right;"><?php echo number_format($diskon->discount); ?></td>
            </tr>
            
            <td style="text-align: right;" colspan="5">TOTAL</td>
            <td style="text-align: right;"><?php echo number_format($total + $diskon->biayaadministrasi + $diskon->biayakonseling + $diskon->totaltarifservice); ?></td>
        </tr>
    </tbody>
</table>
<?php }else{ ?>
   <tbody>
        <?php 
        $total = 0;
        foreach($detailreseptur as $i=>$rincian) { 
            $subTotal = $rincian->qty_oa * $rincian->hargajual_oa;
            $total = $total + $subTotal;
        ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $rincian->obatalkes->obatalkes_nama; ?></td>
            <td style="text-align: right;"><?php echo $rincian->qty_oa; ?></td>
            <td style="text-align: right;"><?php echo number_format($rincian->hargajual_oa); ?></td>
            <td style="text-align: right;"><?php echo number_format($rincian->discount); ?></td>
            <td style="text-align: right;"><?php echo number_format($subTotal); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <tr>
            <td style="text-align: right;" colspan="5">Biaya Administrasi</td>
            <td style="text-align: right;"><?php echo number_format($diskon->biayaadministrasi); ?></td>
            </tr>
             <tr>
                <td style="text-align: right;" colspan="5">Biaya Konseling</td>
                <td style="text-align: right;"><?php echo number_format($diskon->biayakonseling); ?></td>
            </tr>
             <tr>
                <td style="text-align: right;" colspan="5">Total Tarif Service</td>
                <td style="text-align: right;"><?php echo number_format($diskon->totaltarifservice); ?></td>
            </tr>
             <tr>
                <td style="text-align: right;" colspan="5">Jasa Dokter Resep</td>
                <td style="text-align: right;"><?php echo number_format($diskon->jasadokterresep); ?></td>
            </tr>
            
             <tr>
                <td style="text-align: right;" colspan="5">Keringanan</td>
                <td style="text-align: right;"><?php echo number_format($diskon->discount); ?></td>
            </tr>
            
            <td style="text-align: right;" colspan="5">TOTAL</td>
            <td style="text-align: right;"><?php echo number_format($total + $diskon->biayaadministrasi + $diskon->biayakonseling + $diskon->totaltarifservice); ?></td>
        </tr>
    </tbody>
</table>
<?php } ?>

