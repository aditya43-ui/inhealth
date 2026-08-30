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
        font-size: 5pt;
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
 <?php /*
 
 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
 
 $modPenjualanDetailRes = [];
 foreach($modPenjualanDetail as $modObat) {

     if (empty($modPenjualanDetailRes[$modObat->rke])) {
         $modPenjualanDetailRes[$modObat->rke] = $modObat;
     }

     
     if (empty($modPenjualanDetailRes[$modObat->r])) {
        $modPenjualanDetailRes[$modObat->r] = $modObat;
    }
 }
 
 
 

 
 foreach ($modPenjualanDetailRes as $i=>$modObat){ 
        ?>
<?php

$penggunaan = "";
$jumlah = $modObat->qty_oa;
$satuan = "";
$penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);

if (!empty($modReseptur)) {

    $detail = ResepturdetailT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
        'reseptur_id'=>$modReseptur->reseptur_id,
    ));

    if (!empty($detail)) {
        $jumlah = $detail->qty_reseptur;
        $satuan = $detail->satuansediaan;
    }
} 
$format = new MyFormatter;
?>
<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;
// $path2 = Params::pathProfilRSDirectory().$data->logo_rumahsakit_2;

$res = "";
$ext = "png";

if (file_exists($path)) {
    $content = file_get_contents($path);
    $ext_data = pathinfo($path);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }
    
    $res = "data:image/".$ext.";base64,". base64_encode($content);
}

// $res2 = "";
// $ext = "png";

// if (file_exists($path2)) {
//     $content = file_get_contents($path2);
//     $ext_data = pathinfo($path2);
    
//     if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
//         $ext = $ext_data['extension'];
//     }
    
//     $res2 = "data:image/".$ext.";base64,". base64_encode($content);
// }

?>
<div class="header">
<?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNewEtiket'); ?>
    <table width='100%' style="padding-top: 0px">
        <tr>
            <td width='20%' ALIGN="CENTER" VALIGN="MIDDLE">
                <div class="logo">
                    <img src="<?php echo $res; ?>" style="width:10%;" class="logoRS">        
                </div>
            </td>
            <td width='80%' align="left" style="text-align:center; font-size:5pt;">
                <div class="namaRS" align="center">
                    <div>INSTALASI FARMASI <?php echo $data->nama_rumahsakit; ?></div>
                    <div><?php echo $data->alamatlokasi_rumahsakit; ?></div>
                    <?php $nama = PegawaiM::model()->findAll('pegawai_id = 427'); //14?>
                    <div>Apoteker : apt.Zulia Khozanah A M.Farm</div>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="content"> 
<table width="100%" class="tab_etiket">  	
<?php if (in_array($modPenjualan->jenispenjualan, array(Params::JENISPENJUALAN_KARYAWAN, Params::JENISPENJUALAN_DOKTER))): ?>
    <tr>
    <td width="30">NIK</td>
        <td width="5">:</td>
        <td><?php

        // $nip = "-";
        $nama_pegawai = "-";

        if (!empty($modPenjualan->pasienpegawai_id)) {
            $peg = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
            if (!empty($peg)) {
                // $nip = $peg->nomorindukpegawai;
                $nama_pegawai = $peg->namaLengkap;
            }
        }
        // echo $nip;
        echo $modPenjualan->pasien->no_identitas_pasien;

        ?>
        </td>
        <td width="45">Tgl.Pelayanan<b></b></td>
        <td>:</td>
        <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->tglpelayanan)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
    </tr>
    <tr>
        <td>Pegawai</td>
        <td width="5">:</td>
        <td><?php echo $nama_pegawai;  ?></td>
        <!-- <td rowspan="4">Kelas Terapi</td>
        <td rowspan="4">:</td>
        <td rowspan="4"><?php
        //$therapi = TherapiobatM::model()->findByPk($modObat->therapiobat_id);
        //if (!empty($therapi)) {
        //    echo $therapi->therapiobat_nama;
        //} else {
        //    echo "-";
        //}

        ?></td> -->
    </tr>
    <tr>
        <td width="35">Tgl Lahir</td>
        <td>:</td>
        <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->penjualanresep->pasien->tanggal_lahir)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
    </tr>
    <!-- <tr>
        <td>Dokter Resep</td>
        <td>:</td>
        <td><?php //echo empty($dokter) ? "-" : $dokter->namaLengkap; ?></td>
    </tr> -->
    <?php else: ?>

<!-- MULAI PERUBAHAN -->
<tr style="font-size:5pt">
        <td width="35">NO. RM</td>
        <td width="5">:</td>
        <td><?php echo $modObat->penjualanresep->pasien->no_rekam_medik;  ?></td>
        
        <td width="45">No. Resep</td>
        <td>:</td>
        <td width="50"><?php echo $modPenjualan->noresep;?></td>
    </tr>
    <tr>
    <td width="45">Nama</td>
        <td>:</td>
        <td><?php
        echo $modPenjualan->pasien->nama_pasien;  ?></td>
        <td width="45">Tgl. Resep</td>
        <td>:</td>
        <td width="50"><?php $jam = $modPenjualan->tglresep;
                            $tgl = explode(" ", $jam);
        echo MyFormatter::formatDateTimeForUser($tgl[0]);?></td>
    </tr>
    <tr>
        <td width="45">Tgl Lahir</td>
        <td>:</td>
        <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->penjualanresep->pasien->tanggal_lahir)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
       <td width="45">Ruangan</td>
        <td>:</td>
        <td width="50"><?php echo $modPenjualan->ruangan->ruangan_nama;?></td>
    </tr>
    <tr>
    <td width="25">Umur</td>
        <td>:</td>
        <td><?php echo $modPenjualan->pendaftaran->umur ?></td>
    </tr>
    
    <?php endif; ?>
</table>
<table class="text" width="100%" style="text-align:left; margin-top: 0px;margin-left: 5px ">
    <!-- <tr>
        <td colspan="2"><b><?php // echo $modObat->penjualanresep->pasien->nama_pasien;  ?> 
        <?php //if($modObat->penjualanresep->pasien->jeniskelamin == "Laki-Laki"){
        //     echo "(L)";
        // } else{
        //     echo "(P)";
        // }?><b></td>
    </tr> -->
	 <tr>
            <td><b><?php echo $modObat->r.'&nbsp;'.$modObat->rke; ?><?php echo $modObat->obatalkes->obatalkes_nama;?><b></td>
            <!-- <td width="50"><b> Qty: <?php //$modObat->qty_oa?><b></td> -->
    </tr>
   <!-- <tr>
     <td style ="font-size:6px;"><b><?php 
   // $jams = $modObat->etiket ?? "";
    //$tgls = explode("-", $jams); 
    
    // echo $tgls[0] ?? ""; ?></b></td>
    </tr> -->
    <tr>
       <td> <?php echo (!empty($modObat->etiket) ? $modObat->etiket :""); ?> </td>
    </tr> 
     <!-- <tr>
        <td><b><?php //echo $modObat->ket_penggunaan?><b></td>
     </tr> -->
     <tr>
       
	 </tr>
     <tr>
         <td><b>Tanggal Kadaluarsa</b> &nbsp;&nbsp; : &nbsp;&nbsp;  <?php echo $modObat->obatalkes->tglkadaluarsa;?></td>
     </tr>
</table>
<?php if (empty($caraPrint)) {
    echo CHtml::htmlButton('<i class="icon-print icon-white"></i> Print', array(
        'class'=>'btn btn-info', 'onclick'=>'printOA('.$modObat->obatalkespasien_id.');'
    ));
    echo "<hr/>";
} ?> 
</div>
<?php } */ ?>



<?php

 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);


$pasien = $modReseptur->pasien;
$penjualan = $modReseptur;
$pendaftaran = $modReseptur->pendaftaran;

$modResepturDet = ResepturdetailT::model()->findAll("reseptur_id = " . $modReseptur->reseptur_id . " and racikan_id = " . $_GET['racikan']);

 $crke = new CDbCriteria;
 $crke->select = 'rke';
 $crke->group = 'rke';
 $crke->addCondition("penjualanresep_id = " .$_GET['penjualanresep_id']. "and racikan_id = 1");
 $crke->order = 'rke';
 $resepturdet_rke = ObatalkespasienT::model()->findAll($crke);


 
 $obat = [];
$rke = 0;

// echo '<pre>'; var_dump($resepturdet_rke); die;

 foreach ($resepturdet_rke as $i=>$rke){
    $obat = null;
    $obat = [];
     $modDet = ObatalkespasienT::model()->findAll("penjualanresep_id = " . $_GET['penjualanresep_id'] . " AND racikan_id = 1 ORDER BY obatalkes_id");

     $modRDet = ResepturdetailT::model()->findAll("reseptur_id = " . $modReseptur->reseptur_id . " AND rke = " . $rke->rke . " ORDER BY obatalkes_id");

    foreach ($modDet as $i=>$modObat){
      ?>
<?php

$penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);

$format = new MyFormatter;
?>

<?php

$oa = $modObat->obatalkes;

array_push($obat,   $oa->obatalkes_nama . " - " . $modObat->permintaan_oa . " " . (!empty($modRDet[$i]->satuankekuatan) ? $modRDet[$i]->satuankekuatan : ""));

?>

<?php  ?>

<?php } 
        echo $this->renderPartial('PrintEtiketRacikanPDF_page', array('pasien' => $pasien, 'penjualan' => $penjualan, 'pendaftaran' => $pendaftaran, 'rke' => $modObat->rke, 'obat' => $obat, 'modResepturDet' => $modResepturDet, 'modDet' => $modDet, 'modRDet' => $modRDet));
        /* if (empty($caraPrint)) {
            echo CHtml::htmlButton('<i class="icon-print icon-white"></i> Print', array(
                'class'=>'btn btn-info', 'onclick'=>'printOA('.$modObat->obatalkespasien_id.');'
            ));
            echo "<hr/>";
        } */

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
