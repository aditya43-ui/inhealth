<div class="header" style="text-align: center;">
    <div style=""><br>INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR</div>
</div>
<hr style="text-align: center; width: 90%; margin-top: -1px;">
<div class="content" style="margin-left: 10px; width: 90%; margin-top: 0px;">
    <table style="width: 100%;" class="tbl-resep tbl-obat">
        <tr class="height1">
            <td style="width: 37%;">No. Resep </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo $penjualan->noresep;?></td>
        <tr>
        <tr>
            <td>Tanggal </td>
            <?php $tgl = explode(" ", $penjualan->tglreseptur) ?>
            <td> : </td>
            <td><?php echo $tgl[0] . " " . $tgl[1] . " " . $tgl[2];?></td>
        <tr>
        <tr>
            <td>Nama Px </td>
            <td> : </td>
            <td><?php echo "<b>" . substr($pasien->nama_pasien,0, 22) . "</b>";?></td>
        <tr>
        <tr>
            <td>No. RM / Tgl. Lahir </td>
            <td> : </td>
            <td><?php echo "<b>" . $pasien->no_rekam_medik . "</b> - " . date('d-m-Y', strtotime($pasien->tanggal_lahir));?>
            </td>
        <tr>
        <tr>
            <td>Ruangan </td>
            <td> : </td>
            <td><?php echo substr($pendaftaran->ruangan->ruangan_nama, 0, 24); ?></td>
        <tr>
    </table>

    <?php
        $oap = ObatalkespasienT::model()->find("obatalkespasien_id = " . $modDet[0]->obatalkespasien_id);
        $exp = "";
        $jml = 0;

        // echo '<pre>'; var_dump($modObat); die;
    
        if(!empty($oap)) {
            $exp = $oap->kadaluarsa;
            $jml = $oap->jumlahpermintaan_obatracikan;
            $satuansediaan = $oap->satuansediaan;
        }
    ?>
    <?php if(isset($_GET['pdf'])): ?>
        <table style="width: 100%; margin-top: -1pt; margin-bottom: -3pt;" class="tbl-obat">
    <?php else:?>
        <table style="width: 100%; margin-top: 0pt; margin-bottom: -6pt;" class="tbl-obat tbl-namaobat">
    <?php endif;?>
            <tr class="tr-long">
                <td style="width: 37%; font-size: 6pt;">Nama Obat </td>
                <td style="width: 3%;"> : </td>
                <td style="line-height: 8pt;padding-top:-2px;"><?php echo "Racik  $rke "?>
                    <p class="long-text" style="font-size: 6pt;"> 
                        <?php echo implode(" / ", $obat). " "  . $jml . " " . $satuansediaan;?>
                    </p>
                </td>
            <tr>
        </table>
        <table style="width: 100%;  margin-top: -5pt; margin-bottom: -6pt;" class="tbl-obat">
            <tr class="tr-long">
                <td style="width: 37%;">Aturan </td>
                <td style="width: 3%;"> : </td>
                <td style="line-height: 6px;"><?php echo $modDet[0]->etiket; ?></td>
            <tr>
        </table>
        <table style="width: 100%;" class="tbl-resep tbl-obat tbl-resep-obat">
            <tr>
                <td style="width: 37%;">Exp. Date </td>
                <td style="width: 3%;"> : </td>

                <td><?php echo $exp; ?></td>
            <tr>
        </table>
</div>