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
    #logo{
        width:30px;
        height:30px;
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
 $racikan = ($_GET['racikan'] == 0 ) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;

 $modResepturDet = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id . " and racikan_id = ".$racikan);

 foreach ($modResepturDet as $i=>$modObat){ 
        ?>
<?php

$penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);
// var_dump($penggunaan);die;
$jumlah = $modObat->jumlahpermintaan_obatnonracikan;

if (!empty($modReseptur)) {

    $detail = ObatalkespasienT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
        'penjualanresep_id'=>$modPenjualan->penjualanresep_id,
    ));

    if(empty($detail)){
        $detail = new ObatalkespasienT();
    }

    if (!empty($detail)) {
        $jumlah = $detail->jumlahpermintaan_obatnonracikan;
    }

} else{
    $detail = ObatalkespasienT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
    ));

    if(empty($detail)){
        $detail = new ObatalkespasienT();
    }

    if (!empty($detail)) {
        $jumlah = $detail->jumlahpermintaan_obatnonracikan;
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

$pasien = $modPenjualan->pendaftaran->pasien;
$penjualan = $modPenjualan;
$pendaftaran = $modPenjualan->pendaftaran;
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
            <?php $tgl = explode(" ", $penjualan->tglpenjualan) ?>
            <td> : </td>
            <td><?php echo $tgl[0] . " " . $tgl[1];?></td>
        <tr>
        <tr>
            <td>Nama Px </td>
            <td> : </td>
            <td><?php echo "<b>" . $pasien->nama_pasien . "</b>";?></td>
        <tr>
        <tr>
            <td>No. RM / Tgl. Lahir </td>
            <td> : </td>
            <td><?php echo "<b>" . $pasien->no_rekam_medik . "</b> - " . date('d-m-Y', strtotime($pasien->tanggal_lahir));?></td>
        <tr>
        <tr>
            <td>Ruangan </td>
            <td> : </td>
            <td><?php echo $pendaftaran->ruangan->ruangan_nama;?></td>
        <tr>
        <tr>
            <td>Nama Obat </td>
            <td> : </td>
            <td><?php echo $oa->obatalkes_nama . " - " . $modObat->jumlahpermintaan_obatnonracikan . " $modObat->satuankekuatan";?></td>
        <tr>
        <tr>
            <td>Aturan </td>
            <td> : </td>
            <td><?php echo $modResepturDet[0]->etiket; ?></td>
        <tr>
       
    </table> 
</div>

<?php } ?>

<?php if (empty($caraPrint)) : ?>

<script>

    function printOA(id) {
        window.open("<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array('racikan'=>$racikan, 'penjualanresep_id'=>$modPenjualan->penjualanresep_id)); ?>&obatalkespasien_id=" + id + "&caraPrint=PRINT&pdf=true","",'location=_new, width=900px');
    }
    
    function printAll() {
        window.open("<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array('racikan'=>$racikan, 'penjualanresep_id'=>$modPenjualan->penjualanresep_id)); ?>&caraPrint=PRINT&pdf=true","",'location=_new, width=900px');
    }

</script>

<?php endif; ?>
