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

<?php if (empty($caraPrint)) {
    echo CHtml::htmlButton('<i class="icon-print icon-white"></i> Print Semua', array(
        'class'=>'btn btn-info', 'onclick'=>'printAll();'
    ));
    echo "<hr/>";
} ?>

<?php

 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);


$pasien = $modPenjualan->pendaftaran->pasien;
$penjualan = $modPenjualan;
$pendaftaran = $modPenjualan->pendaftaran;
$racikan = ($_GET['racikan'] == 0 ) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
$modResepturDet = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id . " and racikan_id = " . $racikan);

 $crke = new CDbCriteria;
 $crke->select = 'rke';
 $crke->group = 'rke';
 $crke->addCondition("penjualanresep_id = " .$modPenjualan->penjualanresep_id . "and racikan_id = " . $racikan);
 $crke->order = 'rke';
 $resepturdet_rke = ObatalkespasienT::model()->findAll($crke);

// echo '<pre>';var_dump($modPenjualan);die;
 
 $obat = [];
$rke = 0;

// echo '<pre>'; var_dump($resepturdet_rke); die;

 foreach ($resepturdet_rke as $i=>$rke){
    $obat = null;
    $obat = [];
     $modDet = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $_GET['penjualanresep_id'] . " AND racikan_id = 1 ORDER BY obatalkes_id");

     $modRDet = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $modPenjualan->penjualanresep_id . " AND rke = " . $rke->rke . " ORDER BY obatalkes_id");

    foreach ($modDet as $i=>$modObat){
        $penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);

        $format = new MyFormatter;


        $oa = $modObat->obatalkes;

        array_push($obat,   $oa->obatalkes_nama . " - " . $modObat->permintaan_oa . " " . $modRDet[$i]->satuankekuatan);
    } 
    
    echo $this->renderPartial('PrintEtiketRacikanPDF_page', array('pasien' => $pasien, 'penjualan' => $penjualan, 'pendaftaran' => $pendaftaran, 'rke' => $modObat->rke, 'obat' => $obat, 'modResepturDet' => $modResepturDet, 'modDet' => $modDet, 'modRDet' => $modRDet));
       

}  

?>



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
