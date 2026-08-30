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
    .footer-tindakan {
        page-break-after: always;
    }

    .page-break {
        page-break-inside: avoid;
    }

</style>

<div class="header">
    <div><br>INSTALASI FARMASI<br>RSUD Dr. SAIFUL ANWAR MALANG</div>    
</div>
<hr style="text-align: center; width: 90%;">
<div class="content">
    <table style="width: 100%;">
        <tr>
            <td style="width: 40%;">No. Resep </td>
            <td style="width: 3%;"> : </td>
            <td><?php echo $modPenjualanResep->noresep;?></td>
        <tr>
        <tr>
            <td>Tanggal </td>
            <td> : </td>
            <td><?= MyFormatter::formatDateTimeForUser($modPenjualanResep->tglpenjualan) ?></td>
        <tr>
        <tr>
            <td>No RM </td>
            <td> : </td>
            <td><?php echo "<b>" . $modPasien->no_rekam_medik . "</b>";?></td>
        <tr>
        <tr>
            <td>Nama Px </td>
            <td> : </td>
            <td><?php echo "<b>" . $modPasien->nama_pasien . "</b>";?></td>
        <tr>
        
        <tr>
            <td>Nama Obat </td>
            <td> : </td>
            <td><?php echo $modObatAlkes->obatalkes->obatalkes_nama . " - " . $modObatAlkes->qty_oa . " $modObatAlkes->satuankekuatan";?></td>
        <tr>
       
       
    </table> 
</div>
<div class="page-break"></div>

