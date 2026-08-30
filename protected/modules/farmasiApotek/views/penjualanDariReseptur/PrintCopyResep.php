<?php
// if($caraPrint=='EXCEL')
// {
//     header('Content-Type: application/vnd.ms-excel');
//     header('Content-Disposition: attachment;filename="'.$modPenjualan->noresep.'-'.date("Y/m/d").'.xls"');
//     header('Cache-Control: max-age=0');     
// }
// if($caraPrint=='PDF'){
// 	$table_width = "100%";
// }else{
// 	$table_width = "50%";
// }
?>
<!-- <style>
    .heads td {
        vertical-align: top;
    }
</style> -->
<?php //$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<!-- <table width="<?php //echo $table_width; ?>">
        <tbody><tr>
            <td width="80" valign="MIDDLE" align="CENTER" rowspan="3">
                 <img src="<?php //echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br>
                <b><font size="4" color="black" face="Liberation Serif"><b><?php //echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif"><?php //echo $modProfilRs->alamatlokasi_rumahsakit; ?></font>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif">Telp. <?php //echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php //echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
        </tr>
         <tr>
            <td height="2" style="border-bottom: 3px solid #000000" colspan=" 10"></td>
        </tr>
                     <tr>
                <td valign="MIDDLE" align="CENTER" colspan=" 10"><font color="black"><h3></h3></font></td>
            </tr>
                         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 10"></td>
        </tr>  
</tbody>
</table>
<table>
	<br>
	<tr>
		<td style="font-size:12pt;"><b>Copy Resep</b></td>
	</tr>
</table>
<br>
<table width="<?php //echo $table_width; ?>" class="heads">
    <tr>
	
        <td>Tanggal Resep</td>
        <td>:</td>
        <td> <?php //echo MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
    </tr>
    <tr>
        <td>No. Resep</td>
        <td>:</td>
        <td> <?php //echo $modPenjualan->noresep; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td> <?php //echo $modPenjualan->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td nowrap>Nama / Kel / Sis / Umur</td>
        <td>:</td>
        <td> <?php //echo $modPendaftaran->pasien->nama_pasien; ?> / <?php echo $modPenjualan->pasien_id; ?> /  / <?php echo $modPendaftaran->umur; ?></td>
    </tr>
    <tr>
        <td>No. Alamat Pasien</td>
        <td>:</td>
        <td> <?php //echo $modPenjualan->pasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td>Atas Tanggungan</td>
        <td>:</td>
        <td> <?php //echo $modPendaftaran->penjamin->penjamin_nama; ?> - <?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
    </tr>
    <tr>
        <td nowrap>Nama Penanggung</td>
        <td>:</td>
        <td width="100%"> <?php //echo !empty($modPenjualan->pasien->pegawai_id)?$modPenjualan->pasien->pegawai->nama_pegawai:' - '; ?> </td>
    </tr>
    <tr>
        <td>Poliklinik</td>
        <td>:</td>
        <td> <?php //echo $modPenjualan->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Dokter</td>
        <td>:</td>
        <td> <?php //echo $modPenjualan->pegawai->NamaLengkap; ?></td>
    </tr>
    </table>
<br/><br/><br/><br/>

<style>
	.iter {
		border-top: 2px solid #000000;
		padding: 5px;
		width: 50%;
	} 
	.iter legend{
		padding: 10px;
		background: #ffffff;
		color: #000000;
		/*text-align: left;*/
		width:  30%;
		margin-left: 70%;
		font-size: 100%;
	} 
	.iter legend .oabaru{
		font-weight: normal;
		font-size: 75%;
	}  
	.iter2 {
		font-size: 130%;
		font-weight: bold;
		font-family: "Lucida Console";
	} 
</style> -->



<?php
//$iter_nol = true;
//foreach($modDetailResep as $i => $detailresep){
//	if($detailresep->iter == 0){
//		$iter_nol &= true;
//	}else{
//		$iter_nol &= false;
//	}
//}
?>

<?php //echoif(!$iter_nol){ ?>

	<?php //foreach($kelompokiter as $i => $detail){ ?>
		<!-- <span class="iter2">Iter <?php //echo $detail->iter; ?>x</span>
		<br><br>
		<?//php// $modDetailResepIBN = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$modReseptur->reseptur_id,'iter'=>$detail->iter), array('order'=>'rke ASC, resepturdetail_id ASC'));?>
		<?//php// foreach($modDetailResepIBN as $ii => $item){ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php //echo $item->rke; ?></td>
						<td width='50%' style="border-left: 0px; border-right: 0px;"><?//php// echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'></td>
						<td width='25%'></td>
					</tr>
					<tr>
						<td></td>
						<td><?//php //echo $item->signa_reseptur; ?></td>
						<td><?//php// echo $item->satuansediaan; ?></td>
						<td>No <?php //echo ($item->qty_reseptur==0)?' - ':CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
			<fieldset class='iter'> -->
				<?php
				// $status_copy = '';
				// $modCopyResep = FACopyResepR::model()->findByAttributes(array('reseptur_id'=>$modReseptur->reseptur_id));
				
				// $jmlresep = $item->qty_reseptur;
				// $jmldilayani = $this->getJumlahDilayani($item->resepturdetail_id);
				// $iterke = floor($jmldilayani/$jmlresep);
				
				// if($iterke == 0){
				// 	$status_copy = 'Orig &nbsp'.$jmldilayani;
				// }else{
				// 	$jmldilayani = $jmldilayani-($jmlresep*$iterke);
				// 	$status_copy = 'Iter-'.$iterke.' &nbsp'.CustomFunction::Romawi($jmldilayani);
				// }
				
				// if($modObatAlkes[$ii]->qty_oa == 0){
				// 	echo "<legend><i>Net Det &nbsp".$status_copy." </i></legend>";
				// }else{
				// 	echo "<legend><i>Det &nbsp".$status_copy." </i></legend>";
				// }
				?>
			<!-- </fieldset> -->
		<?php //} ?>
		<!-- <br><br> -->
	<?php //} ?>
		
<?php //}else{ ?>

	<!-- <?php //foreach($kelompokiter as $i => $detail){ ?> -->
		<!-- <?php //foreach($modDetailResep as $ii => $item){ ?> -->
			<!-- <table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php //echo $item->rke; ?></td>
						<td width='50%' style="border-left: 0px; border-right: 0px;"><?php //echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'> </td>
						<td width='25%'></td>
					</tr>
					<tr>
						<td></td>
						<td><?php //echo $item->signa_reseptur; ?></td>
						<td><?php //echo $item->satuansediaan; ?></td>
						<td>No <?php //echo ($item->qty_reseptur==0)?' - ':CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
			<fieldset class='iter'> -->
				<?php 
				// $oa_baru = '';
				// if(!empty($modObatAlkes[$ii]->obatalkes_id) && $item->obatalkes_id != $modObatAlkes[$ii]->obatalkes_id){
				// 	$oa_baru = $modObatAlkes[$ii]->obatalkes->obatalkes_nama;
				// }
				// if(empty($modObatAlkes[$ii]->obatalkes_id) || $modObatAlkes[$ii]->qty_oa == 0){
				// 	echo "<legend><i>Net Det &nbsp <span class='oabaru'>".$oa_baru."</span>  &nbsp ".$item->qty_reseptur." </i></legend>";
				// }else{
				// 	echo "<legend><i>Det &nbsp <span class='oabaru'>".$oa_baru."</span>  &nbsp ".$modObatAlkes[$ii]->qty_oa." </i></legend>";
				// }
				?>
			<!-- </fieldset> -->
		<?php //} ?>
	<?php //} ?>

<?php //} ?>
<!-- <br><br>
<fieldset style="width:50%;">
	<h2 style='text-align: right; opacity: 0.7'><i>PCC</i></h2>
</fieldset> -->




<style>
    table td {
        vertical-align: top;
    }
    .iter {
		border-top: 2px solid #000000;
		padding: 5px;
		width: 50%;
	} 
	.iter legend{
		padding: 3px;
		background: #ffffff;
		color: #000000;
		text-align: center;
		width:  15%;
		margin-left: 85%;
	} 
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
    }
</style>
<?php 
// if($caraPrint=='EXCEL')
// {
//     header('Content-Type: application/vnd.ms-excel');
//     header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
//     header('Cache-Control: max-age=0');     
// }
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$modPenjualan->noresep.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint=='PDF'){
	$table_width = "100%";
}else{
	$table_width = "50%";
}

 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
    } else{
        $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
    }
    
?>
<?php

if (!empty($modPendaftaran)) {
    $nomor_pendaftaran = $modPendaftaran->no_pendaftaran;
    $nama_pasien = $modPendaftaran->pasien->nama_pasien;
    $umur = $modPendaftaran->umur;
    $alamat = $modPendaftaran->pasien->alamat_pasien;

} else if (!empty($modPenjualan->pasienpegawai_id)) {
    $pegpas = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
    if (!empty($pegpas)) {
        $nomor_pendaftaran = "-";
        $nama_pasien = $pegpas->namaLengkap;
        $alamat = $pegpas->alamat_pegawai;
        $umur = CustomFunction::hitungUmur($pegpas->tgl_lahirpegawai, $modPenjualan->tglpenjualan);
    } else {
        $nomor_pendaftaran = "-";
        $nama_pasien = "-";
        $umur = "-";
        $alamat = "-";
    }
} else {
    $nomor_pendaftaran = "-";
    $nama_pasien = "-";
    $umur = "-";
    $alamat = "-";

}

?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%">
    <tbody>
        <tr>
            <td></td>
            <td align="right" width="50%"><font color="black" face="Liberation Serif">CR</font> </td>
        </tr>
    </tbody>
</table>
<table width="100%" border="1">
        <tbody><tr>
            <td width="80" valign="MIDDLE" align="CENTER" rowspan="3">
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <br>
                <!-- <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br> -->
                <b><font size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b><br>
                <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font><br>
                <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
            <td valign="MIDDLE" align="LEFT" colspan=" 9">
                <br>
                <font size="3" color="black" face="Liberation Serif">Nama Pasien : <?php echo $nama_pasien;?> <?php if($modPendaftaran->pasien->jeniskelamin == "Laki-Laki"){
                    echo "(L)";
                }else{
                    echo "(P)";
                } ?></font><br>
                <font size="3" color="black" face="Liberation Serif">TTL  : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)." / ". $modPendaftaran->umur;?></font><br>
                <font size="3" color="black" face="Liberation Serif">No RM / No Reg : <?php echo $modPendaftaran->pasien->no_rekam_medik." / ".$modPendaftaran->no_pendaftaran;?></font>
            </td>
        </tr>
         <!-- <tr>
            <!-- <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif"><?php //echo $modProfilRs->alamatlokasi_rumahsakit; ?></font>
            </td> -->
            <!-- <td valign="MIDDLE" align="LEFT" colspan=" 9">
                <b><font size="3" color="black" face="Liberation Serif">Tgl. Lahir / Umur : <?php //echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)." / ". $modPendaftaran->umur;?></font></b><br>
            </td>
        </tr>
         <tr> -->
            <!-- <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif">Telp. <?php //echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php //echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td> -->
            <!-- <td valign="MIDDLE" align="LEFT" colspan=" 9">
                <b><font size="3" color="black" face="Liberation Serif">No RM : <?php //echo $modPendaftaran->pasien->no_rekam_medik;?></font></b><br>
            </td>
        </tr> -->
         <!-- <tr>
            <td height="2" style="border-bottom: 3px solid #000000" colspan=" 10"></td>
        </tr>
                     <tr>
                <td valign="MIDDLE" align="CENTER" colspan=" 10"><font color="black"><h3></h3></font></td>
            </tr>
                         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 10"></td>
        </tr>   -->
</tbody>
</table>

<?php

if (!empty($modPendaftaran)) {
    $nomor_pendaftaran = $modPendaftaran->no_pendaftaran;
    $nama_pasien = $modPendaftaran->pasien->nama_pasien;
    $umur = $modPendaftaran->umur;
    $alamat = $modPendaftaran->pasien->alamat_pasien;

} else if (!empty($modPenjualan->pasienpegawai_id)) {
    $pegpas = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
    if (!empty($pegpas)) {
        $nomor_pendaftaran = "-";
        $nama_pasien = $pegpas->namaLengkap;
        $alamat = $pegpas->alamat_pegawai;
        $umur = CustomFunction::hitungUmur($pegpas->tgl_lahirpegawai, $modPenjualan->tglpenjualan);
    } else {
        $nomor_pendaftaran = "-";
        $nama_pasien = "-";
        $umur = "-";
        $alamat = "-";
    }
} else {
    $nomor_pendaftaran = "-";
    $nama_pasien = "-";
    $umur = "-";
    $alamat = "-";

}

?>
<table width="100%" border="1px solid black" cellspacing="">
    <tr>
        <th rowspan="12" width="50%">Bismillahirohmanirohim<br>Copy Resep<?php
$iter_nol = true;
foreach($modDetailResep as $i => $detailresep){
	if($detailresep->iter == 0){
		$iter_nol &= true;
	}else{
		$iter_nol &= false;
	}
}
?>

<?php if(!$iter_nol){ ?>

	<?php foreach($kelompokiter as $i => $detail){ ?>
		<span class="iter2">Iter <?php echo $detail->iter; ?>x</span>
		<br><br>
		<?php $modDetailResepIBN = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$modReseptur->reseptur_id,'iter'=>$detail->iter), array('order'=>'rke ASC, resepturdetail_id ASC'));?>
		<?php foreach($modDetailResepIBN as $ii => $item){ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php echo $item->rke; ?></td>
						<td width='50%' style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'></td>
						<td width='25%'></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $item->signa_reseptur; ?></td>
						<td><?php echo $item->satuansediaan; ?></td>
						<td>No <?php echo ($item->qty_reseptur==0)?' - ':CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
			<fieldset class='iter'>
				<?php
				$status_copy = '';
				$modCopyResep = FACopyResepR::model()->findByAttributes(array('reseptur_id'=>$modReseptur->reseptur_id));
				
				$jmlresep = $item->qty_reseptur;
				$jmldilayani = $this->getJumlahDilayani($item->resepturdetail_id);
				$iterke = floor($jmldilayani/$jmlresep);
				
				if($iterke == 0){
					$status_copy = 'Orig &nbsp'.$jmldilayani;
				}else{
					$jmldilayani = $jmldilayani-($jmlresep*$iterke);
					$status_copy = 'Iter-'.$iterke.' &nbsp'.CustomFunction::Romawi($jmldilayani);
				}
				
				if($modObatAlkes[$ii]->qty_oa == 0){
					echo "<legend><i>Net Det &nbsp".$status_copy." </i></legend>";
				}else{
					echo "<legend><i>Det &nbsp".$status_copy." </i></legend>";
				}
				?>
			</fieldset>
		<?php } ?>
		<br><br>
	<?php } ?>
		
<?php }else{ ?>

	<?php foreach($kelompokiter as $i => $detail){ ?>
		<?php foreach($modDetailResep as $ii => $item){ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php echo $item->rke; ?></td>
						<td width='50%' style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'> </td>
						<td width='25%'></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $item->signa_reseptur; ?></td>
						<td><?php echo $item->satuansediaan; ?></td>
						<td>No <?php echo ($item->qty_reseptur==0)?' - ':CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
			<fieldset class='iter'>
				<?php 
				$oa_baru = '';
				if(!empty($modObatAlkes[$ii]->obatalkes_id) && $item->obatalkes_id != $modObatAlkes[$ii]->obatalkes_id){
					$oa_baru = $modObatAlkes[$ii]->obatalkes->obatalkes_nama;
				}
				if(empty($modObatAlkes[$ii]->obatalkes_id) || $modObatAlkes[$ii]->qty_oa == 0){
					echo "<legend><i>Net Det &nbsp <span class='oabaru'>".$oa_baru."</span>  &nbsp ".$item->qty_reseptur." </i></legend>";
				}else{
					echo "<legend><i>Det &nbsp <span class='oabaru'>".$oa_baru."</span>  &nbsp ".$modObatAlkes[$ii]->qty_oa." </i></legend>";
				}
				?>
			</fieldset>
		<?php } ?>
	<?php } ?>

<?php } ?>
    <!-- <br/><br/> -->
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <b><font size="2" color="black" face="Liberation Serif">"Dan apabila aku sakit, Dia-lah yang menyembuhkanku"</font></b><br>
        <font size="2" face="Liberation Serif">(QS. As-Syu'ara'26:80)</font>
    </th>
    <!-- <tr> -->
        <td colspan="4" align="left">Berat Badan :</td>
    </tr>
    <tr>
        <td colspan="4" align="left">Ruangan : <?php echo $modPenjualan->ruanganasal_nama; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="left">Dokter. : <?php echo empty($modPenjualan->pegawai) ? "-" : $modPenjualan->pegawai->namaLengkap; ?> <br> Sip : <?php echo !empty($modPenjualan->pegawai->suratizinpraktek) ? $modPenjualan->pegawai->suratizinpraktek : "-"; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="left">Tgl. : <?php echo MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center" >Riwayat Alergi Obat <br><br></td>
    </tr>
    <tr>
        <td colspan="4" align="left">Penelaahan Resep : <?php echo $modPenjualan->kiepenyerahan;?></td>
    </tr>
    <tr>
        <td colspan="4" align="left">Penelaahan Obat : <?php echo $modPenjualan['penelaahanobat'];?></td>
    </tr>
    <tr>
        <td align="center">Hargai</td>
        <td align="center">Teknik</td>
        <td align="center">Kemas</td>
        <td align="center">Penyerahan</td>
    </tr>
    <tr>
        <td align="center"><?php $data = PegawaiM::model()->findByPk($modPenjualan->harga_id) ; echo !empty($data->namaLengkap) ? $data->namaLengkap : "" ; ?><br></td>
        <td align="center"><?php $data = PegawaiM::model()->findByPk($modPenjualan->teknik_id) ; echo !empty($data->namaLengkap) ? $data->namaLengkap : "" ; ?></td>
        <td align="center"><?php $data = PegawaiM::model()->findByPk($modPenjualan->kemas_id) ; echo !empty($data->namaLengkap) ? $data->namaLengkap : "" ; ?></td>
        <td align="center"><?php echo $modPenjualan->namaygmenyerahkan; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">Menerima Obat Beserta Informasi</td>
        
    </tr>
    <tr>
        <td style="border: 1px solid;" colspan="4" align="left"><?php $url_photopasien = (!empty($modPenjualan->fotopenyerahanobat) ? $modPenjualan->fotopenyerahanobat : Params::urlAmbilObatDirectory() . "no_photo.jpeg"); ?>
        <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;"><?php echo CHtml::image($modPenjualan->ttdpenyerahan, null, array('width' => 150)); ?></td>
        
    </tr>
</table>
<table width="100%" border="1px solid black">
    <tr>
        <td colspan="4" align="center">Perubahan Resep</td>
        <td width="25%" rowspan="2" align="center">Petugas Farmasi</td>
        <td width="25%" rowspan="2" align="center">Disetujui</td>
    </tr>
    <tr>
        <td align="center">Tertulis</td>
        <td align="center">Menjadi</td>
    </tr>
</table>
<table width="100%" border="1px solid black">
    <tr>
        <td><br><br></td>
        <td></td>
        <td><br></td>
        <td></td>
    </tr>
</table>
<!-- <table width="80%" <?php //echo $style; ?>>
    <tr>
        <td nowrap></td>
        <td></td>
        <td width="100%"><?php //echo $nomor_pendaftaran; ?></td>
        
        <td colspan="3">Berat Badan :</td>
        <!-- <td>:</td> -->
        <!-- <td nowrap> <?php //echo $modPenjualan->noresep; ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td> <?php //echo $nama_pasien; ?></td>
        
        <td nowrap>Dokter</td>
        <td>:</td>
        <td nowrap> <?php //echo empty($modPenjualan->pegawai) ? "-" : $modPenjualan->pegawai->namaLengkap; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td> <?php //echo $umur; ?></td>
        
        <td>Tanggal Resep</td>
        <td>: </td>
        <td nowrap><?php //echo $modPenjualan->tglpenjualan; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td> <?php //echo $alamat; ?></td>
        
        <td>Ruangan</td>
        <td>:</td>
        <td nowrap> <?php //echo $modPenjualan->ruanganasal_nama; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Jenis Penjamin</label>
        </td>
        <td>:</td>
		<td width='35%'> <?php //echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Penjamin</label>
        </td>
        <td>:</td>
		<td width='35%'> <?php //echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
    </tr>
</table> -->
<br/><br/><br/><br/>

<style>
	.iter {
		border-top: 2px solid #000000;
		padding: 5px;
		width: 50%;
	} 
	.iter legend{
		padding: 3px;
		background: #ffffff;
		color: #000000;
		text-align: center;
		width:  15%;
		margin-left: 85%;
	} 
</style>
<!-- 
<table width="50%">
    <tr>
        <td width="50%">
        <?php //$url_photopasien = (!empty($modPenjualan->fotopenyerahanobat) ? $modPenjualan->fotopenyerahanobat : Params::urlAmbilObatDirectory() . "no_photo.jpeg"); ?>
        <img id="photo-preview" src="<?php //echo $url_photopasien ?>" style="width: 160px;"><br>
        </td>
        <td>Diserahkan Oleh:<br/><?php //echo $modPenjualan->namaygmenyerahkan; ?></td>
    </tr>
</table> -->