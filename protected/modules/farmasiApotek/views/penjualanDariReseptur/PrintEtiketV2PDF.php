<style>
.barcode-label {
    margin-top: -20px;
    z-index: 1;
    text-align: center;
    letter-spacing: 10px;
}

td,
th {
    font-size: 6pt !important;
    /*        font-weight: bold;*/
}

body {
    width: 61mm;
}

.content {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
    color: #000000;
    height: 60mm;
    width: 70mm;
    margin: 6px 0px 30px 5px;
    position: relative;
}

@media print {
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 6pt !important;
    }

    body {
        width: 61mm;
    }

    .content {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
        color: #000000;
        height: 6cm;
        width: 7cm;
        margin: 0px 0px 30px 5px;
        position: relative;
        margin-top: 1%;
    }
}

@page {
    margin-top: 1%;
}

.tab_etiket {
    border-collapse: collapse;
    margin-right: 5px;
    margin-left: 5px;
}

.tab_etiket td {
    font-size: 6pt;
    font-family: Arial, Helvetica, sans-serif;
    /* vertical-align: top; */
    padding-left: 2px;
    padding-right: 1px;
    padding-top: 0px;
}

#logo {
    width: 30px;
    height: 30px;
}

.text {
    border-collapse: collapse;
}

.text tr td {
    font-size: 6.6pt;
    /* font-family: Arial, Helvetica, sans-serif;
        /* vertical-align: top; */
    /* padding-left: 2px;
        padding-right: 1px;
        padding-top: 0px; */
}

.header {
    text-align: center;
    font-size: 6.5pt;
}

.tbl-resep tr,
.tbl-resep td {
    vertical-align: top;
    line-height: 1pt;
}

.tbl-resep-obat tr,
.tbl-resep-obat td {
    vertical-align: top;
    line-height: 8pt;
}

.tbl-resep-obat {
    margin: -4pt 0;
}

table tr,
table td {
    vertical-align: top;
    font-size: 6.5pt;
}
</style>


<?php if (empty($caraPrint)) {
    echo CHtml::htmlButton('<i class="icon-print icon-white"></i> Print Semua', array(
        'class'=>'btn btn-info', 'onclick'=>'printAll();'
    ));
    echo "<hr/>";
} ?>
<?php

 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);

 $modResepturDet = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modReseptur->penjualanresep_id . " and racikan_id = " . $_GET['racikan']);

 foreach ($modResepturDet as $i=>$modObat){ 

    $obatalkespasien = ObatalkespasienT::model()->findByAttributes(array(
        'penjualanresep_id' => $modPenjualan->penjualanresep_id,
        'obatalkes_id' => $modObat->obatalkes_id,
        'racikan_id' => 2
    ));

    // var_dump($obatalkespasien); die;
        ?>
<?php

$penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);
// var_dump($penggunaan);die;
$jumlah = $modObat->jumlahpermintaan_obatnonracikan;

if (!empty($modReseptur)) {

    $detail = ResepturdetailT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
        'reseptur_id'=>$modReseptur->reseptur_id,
    ));

    if(empty($detail)){
        $detail = new ResepturdetailT();
    }

    if (!empty($detail)) {
        $jumlah = $detail->qty_reseptur;
    }

} else{
    $detail = ResepturdetailT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
    ));

    if(empty($detail)){
        $detail = new ResepturdetailT();
    }

    if (!empty($detail)) {
        $jumlah = $detail->qty_reseptur;
    } 
}

$format = new MyFormatter;
?>

<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;
$path2 = Params::pathProfilRSDirectory().$data->logo_rumahsakit_2;

$res = "";
$res2 = "";

$ext = "png";
$ext2 = "png";

$pasien = $modObat->pendaftaran->pasien;
$penjualan = $modObat->penjualanresep->reseptur;
$pendaftaran = $modObat->pendaftaran;
$oa = $modObat->obatalkes;


if (file_exists($path)) {
    $content = file_get_contents($path);
    $ext_data = pathinfo($path);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }
    
    $res = "data:image/".$ext.";base64,". base64_encode($content);
}

if (file_exists($path2)) {
    $content = file_get_contents($path2);
    $ext_data = pathinfo($path2);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext2 = $ext_data['extension'];
    }
    
    $res2 = "data:image/".$ext2.";base64,". base64_encode($content);
}




?>
<div class="header">
    <div style=""><br>INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR MALANG</div>
</div>
<hr style="text-align: center; width: 90%; margin: -1px 0;">
<div class="content" style="margin-left: 10px; width: 90%; margin-top: 0px;">
    <table style="width: 100%;" class="tbl-resep">
        <tr>
            <td style="width: 40%;">No. Resep </td>
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
            <td><?php echo "<b>" . $pasien->no_rekam_medik . "</b> - " . date('d-m-Y', strtotime($pasien->tanggal_lahir));?></td>
        <tr>
        <tr>
            <td style="width: 40%;">Ruangan </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo substr($pendaftaran->ruangan->ruangan_nama, 0, 24);?></td>
        <tr>
        <tr>
    </table>
    <table style="width: 100%; margin-top: -5pt; margin-bottom: 0pt;" class="">
        <tr>
            <td style="width: 40%;">Nama Obat </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo $oa->obatalkes_nama . " - " . $obatalkespasien->qty_oa ?? '';?></td>
        </tr>
    </table>
    <table style="width: 100%;  margin-top: -5pt; margin-bottom: -5pt;" class="tbl-obat">
    <tr class="tr-long">
            <td style="width: 40%;">Aturan </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo $obatalkespasien->etiket ?? ''; ?></td>
        <tr>
        </table>
    <table style="width: 100%;" class="tbl-resep">
        <tr>
            <td style="width: 40%;">Exp. Date </td>
            <?php
                $exp = "";

                if(!empty($oap)) {
                    $exp = $oap->kadaluarsa;
                }
            ?>
            <td style="width: 3%;"> : </td>
            <td><?=$exp ?></td>
        <tr>
    </table>
</div>


</div>
<?php } ?>

<?php if (empty($caraPrint)) : ?>



<?php endif; ?>