<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 6pt !important;
/*        font-weight: bold;*/
    }
    body{
        width:61mm;
    }
	.content{
		-webkit-transform: rotate(-90deg);
		-moz-transform: rotate(-90deg);
		-o-transform: rotate(-90deg);
		-ms-transform: rotate(0deg);
		transform: rotate(0deg);
		color:#000000;
		height: 60mm;
		width: 70mm;
		margin: 6px 0px 30px 5px;
		position:relative;
    }

	@media print{
		.barcode-label{
			margin-top:-20px;
			z-index: 1;
			text-align: center;
			letter-spacing: 10px;
		}
		td, th{
			font-size: 6pt !important;
		}
		body{
			width:61mm;
		}

		.content{
			-webkit-transform: rotate(-90deg);
			-moz-transform: rotate(-90deg);
			-o-transform: rotate(-90deg);
			-ms-transform: rotate(0deg);
			transform: rotate(0deg);
			color:#000000;
			height: 6cm;
			width: 7cm;
		    margin: 0px 0px 30px 5px;
			position:relative;
            margin-top: 1%;
		}
	}   
	@page {
    	margin-top: 1%;
	}

    .tab_etiket {
        border-collapse: collapse;
        margin-right: 5px;
    }

    .tab_etiket td {
        font-size: 5pt;
        vertical-align: top;
        padding-left: 2px;
        padding-right: 4px;
    }
</style>
 <?php

 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);


 $modResepturDet = ResepturdetailT::model()->findAll("reseptur_id = " . $modReseptur->reseptur_id);

 foreach ($modResepturDet as $i=>$modObat){ 
        ?>
<?php

$penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);
$jumlah = $modObat->qty_oa;

if (!empty($modReseptur)) {

    $detail = ResepturdetailT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
        'reseptur_id'=>$modReseptur->reseptur_id,
    ));

    if (!empty($detail)) {
        $jumlah = $detail->qty_reseptur;
    }

}

$format = new MyFormatter;

$pasien = $modObat->reseptur->pasien;
$penjualan = $modObat->reseptur;
$pendaftaran = $modObat->reseptur->pendaftaran;
$oa = $modObat->obatalkes;

?>
<div class="header">
    <div style=""><br>INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR MALANG</div>    
</div>
<hr style="text-align: center; width: 90%;">
<div class="content">
    <table style="width: 100%;">
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
            <td><?php echo "<b>" . $pasien->nama_pasien . "</b>";?></td>
        <tr>
        <tr>
            <td>No. RM / Tgl. Lahir </td>
            <td> : </td>
            <td><?php echo "<b>" . $pasien->no_rekam_medik . "</b> - " . $pasien->tanggal_lahir;?></td>
        <tr>
        <tr>
            <td>Nama Obat </td>
            <td> : </td>
            <td><?php echo $oa->obatalkes_nama . " - " . $modObat->jumlahpermintaan_obatnonracikan . " $modObat->satuankekuatan";?></td>
        <tr>
        <tr>
            <td>Aturan </td>
            <td> : </td>
            <td><?php echo $modObat->signa_reseptur; ?></td>
        <tr>
        <tr>
            <td>Tanggal Kedaluarsa </td>
            <td> : </td>
            <td><?php echo $oa->tglkadaluarsa; ?></td>
        <tr>
    </table> 
</div>
 <?php } ?>
