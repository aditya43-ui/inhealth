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
        font-size: 5.2pt;
        vertical-align: top;
        padding-left: 2px;
        padding-right: 4px;
    }
    #logo{
        width:30px;
        height:30px;
    }
</style>
 <?php 
 
 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
 
 $modPenjualanDetailRes = [];
 foreach($modPenjualanDetail as $modObat) {
     if (empty($modPenjualanDetailRes[$modObat->rke])) {
         $modPenjualanDetailRes[$modObat->rke] = $modObat;
     }
 }
 
 
 
 
 foreach ($modPenjualanDetailRes as $i=>$modObat){ 
    if(!empty($modObat->formulaobatkronis_id)){
        $modKronis = FormulaobatkronisM::model()->findByAttributes(['formulaobatkronis_id' => $modObat->formulaobatkronis_id]);
        $jml = $modObat->qty_oa;
        $qty = 0;
        if(isset($modKronis)){
            $jmlKronisMax = $modKronis->jumlahobat_maksimal;
            $jmlObatKronis = $modKronis->jumlahobat;
            $qty = ($jml/$jmlObatKronis) * $jmlKronisMax;
        }
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
        <td width="45">NIP Penerima</td>
        <td width="5">:</td>
        <td><?php

        $nip = "-";
        $nama_pegawai = "-";

        if (!empty($modPenjualan->pasienpegawai_id)) {
            $peg = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
            if (!empty($peg)) {
                $nip = $peg->nomorindukpegawai;
                $nama_pegawai = $peg->namaLengkap;
            }
        }
        echo $nip;

        ?>
        </td>
        <td width="45">Tgl. Pelayanan<b></b></td>
        <td>:</td>
        <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->tglpelayanan)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
    </tr>
    <tr>
        <td>Pegawai Penerima</td>
        <td width="5">:</td>
        <td><?php echo $nama_pegawai;  ?></td>
        <td rowspan="4">Kelas Terapi</td>
        <td rowspan="4">:</td>
        <td rowspan="4"><?php
        $therapi = TherapiobatM::model()->findByPk($modObat->therapiobat_id);
        if (!empty($therapi)) {
            echo $therapi->therapiobat_nama;
        } else {
            echo "-";
        }

        ?></td>
    </tr>
    <tr>
        <td>Dokter Resep</td>
        <td>:</td>
        <td><?php echo empty($dokter) ? "-" : $dokter->namaLengkap; ?></td>
    </tr>
    <?php else: ?>

<!-- MULAI PERUBAHAN -->
    <tr style="font-size:5pt">
        <td width="35">NO. RM</td>
        <td width="5">:</td>
        <td><?php echo $modObat->penjualanresep->pasien->no_rekam_medik;  ?></td>;
        <td width="45">Tgl. Resep</td>
        <td>:</td>
        <td width="50"><?php $jam = $modPenjualan->tglresep;
                            $tgl = explode(" ", $jam);
        echo MyFormatter::formatDateTimeForUser($tgl[0]);?></td>
    </tr>
    <tr>
        <td width="35">Tgl Lahir</td>
        <td>:</td>
        <td width="45%"><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->penjualanresep->pasien->tanggal_lahir)));

        echo MyFormatter::formatDateTimeForUser($pelayanan)." (".$modPenjualan->pendaftaran->umur.")";  ?></td>
        <!-- <td width="25">Umur</td>
        <td>:</td>
        <td><?php //echo $modPenjualan->pendaftaran->umur ?></td> -->
    </tr>
    <tr>
        <td width="45">NIK</td>
        <td>:</td>
        <td><?php echo $modPenjualan->pasien->no_identitas_pasien;?>
    </tr>
    
    <?php endif; ?>
<!--    
	 <tr>
             <td><?php // echo $modObat->penjualanresep->pasien->nama_pasien.' - '.$modObat->penjualanresep->pasien->no_rekam_medik;  ?></td>
	 </tr>-->
</table>
<table class="text" width="100%" style="text-align:left; margin-top: 0px;">  	
    <tr>
        <td><b><?php echo $modObat->penjualanresep->pasien->nama_pasien;  ?> 
        <?php if($modObat->penjualanresep->pasien->jeniskelamin == "Laki-Laki"){
            echo "(L)";
        } else{
            echo "(P)";
        }?><b></td>;
    </tr>
	 <tr>
        <td><b><?php echo $modObat->obatalkes->obatalkes_nama;  ?><b></td>
        <td width="50"><b> Qty: <?= isset($detail->formulaobatkronis_id) ? $qty : $detail->qty_oa;?><b></td>
	 </tr>
     <tr>
        <td><b><?php echo $modObat->ket_penggunaan?><b></td>
     </tr>
     <tr>
        <td><b><?php //echo $modObat->signa_oa;
        echo $modObat->signa_oa;  ?> - (<?php echo !empty($modObat->etiket) ? $modObat->etiket : "-" ;//echo $penggunaan;  ?>)<b></td>
             
	 </tr>
     <tr>
         <td><?= isset($modObat->keterangan) ? $modObat->keterangan : "-"?></td>
     </tr>
</table>
         
</div>
 <?php }} ?> 

