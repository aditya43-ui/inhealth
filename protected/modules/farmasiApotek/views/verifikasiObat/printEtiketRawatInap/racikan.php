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
		width: 70mm ;
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

    .text tr td {
        font-size: 6.8pt;
        /* font-family: Arial, Helvetica, sans-serif;
        /* vertical-align: top; */
        /* padding-left: 2px;
        padding-right: 1px;
        padding-top: 0px; */
    }

    table tr, table td {
        vertical-align: top;
    }

    .tbl-obat tr, .tbl-obat td {
        font-size: 6pt;
        line-height: 1pt;
        /* font-weight: bold; */
    }

    .tbl-namaobat tr, .tbl-namaobat td {
        font-size: 6pt;
        line-height: 12pt;
        /* font-weight: bold; */
    }

    p.long-text {
        font-size: 6pt;
        line-height: 8pt;
    }

    .tbl-resep-obat {
        margin-top: 5pt;
    }

</style>
<div class="header" style="text-align: center;">
    <div style=""><br>INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR</div>
</div>
<hr style="text-align: center; width: 90%; margin-top: -1px;">
<div class="content" style="margin-left: 10px; width: 90%; margin-top: 0px;">
    <table style="width: 100%;" class="tbl-resep tbl-obat">
        <tr class="height1">
            <td style="width: 37%;">No. Resep </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo $modPenjualan->noresep;?></td>
        <tr>
        <tr>
            <td>Tanggal </td>
            <?php $tgl = explode(" ", $modReseptur->tglreseptur) ?>
            <td> : </td>
            <td><?php echo $tgl[0] . " " . $tgl[1] . " " . $tgl[2];?></td>
        <tr>
        <tr>
            <td>Nama Px </td>
            <td> : </td>
            <td><?php echo "<b>" . substr($modPasien->nama_pasien,0, 22) . "</b>";?></td>
        <tr>
        <tr>
            <td>No. RM / Tgl. Lahir </td>
            <td> : </td>
            <td><?php echo "<b>" . $modPasien->no_rekam_medik . "</b> - " . date('d-m-Y', strtotime($modPasien->tanggal_lahir));?>
            </td>
        <tr>
        <tr>
            <td>Ruangan </td>
            <td> : </td>
            <td><?php echo substr($modPendaftaran->ruangan->ruangan_nama, 0, 24); ?></td>
        <tr>
    </table>

    <?php
        $exp = "";
        $jml = 0;

        if(!empty($obat['permintaan_oa'])) {
            $jml = $obat['permintaan_oa'];
        } 
        if(!empty($obat['kadaluarsa'])) {
            $exp = $obat['kadaluarsa'];
        }
    ?>
    <?php if(isset($_GET['pdf'])): ?>
        <table style="width: 100%; margin-top: 0pt; margin-bottom: -1pt;" class="tbl-obat">
    <?php else:?>
        <table style="width: 100%; margin-top: 0pt; margin-bottom: -5pt;" class="tbl-obat tbl-namaobat">
    <?php endif;?>
            <tr class="tr-long">
                <td style="width: 37%; font-size: 6pt;">Nama Obat </td>
                <td style="width: 3%;"> : </td>
                <td style="line-height: 6pt;"><?php echo "Racik " . $obat['rke']?>
                    <p class="long-text" style="margin-top: -100pt;">
                        <?php echo $obat['obatalkes_nama']. " "  . $jml . " " . $obat['satuansediaan'];?>
                    </p>
                </td>
            <tr>
        </table>
        <table style="width: 100%;  margin-top: -5pt; margin-bottom: -5pt;" class="tbl-obat">
            <tr class="tr-long">
                <td style="width: 37%;">Aturan </td>
                <td style="width: 3%;"> : </td>
                <td style="line-height: 6px;"><?php echo $obat['etiket']; ?></td>
            <tr>
        </table>
        <table style="width: 100%;" class="tbl-resep tbl-obat tbl-resep-obat">
            <tr>
                <td style="width: 37%;">Exp. Date </td>
                <td style="width: 3%;"> : </td>

                <td><?php echo $exp; ?></td>
            <tr>
            <tr>
                <td style="width: 40%;">Waktu </td>
                <td style="width: 3%;"> : </td>
                <td></td>
            <tr>
        </table>
</div>