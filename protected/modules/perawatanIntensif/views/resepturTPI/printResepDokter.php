
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

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
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="50%">
        <tbody><tr>
            <td width="80" valign="MIDDLE" align="CENTER" rowspan="3">
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <b><span size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</span></b><br>
                <b><span size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></span></b>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <span color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></span>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <span color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></span>
            </td>
        </tr>
         <tr>
            <td height="2" style="border-bottom: 3px solid #000000" colspan=" 10"></td>
        </tr>
                     <tr>
                <td valign="MIDDLE" align="CENTER" colspan=" 10"><span color="black"><h3></h3></span></td>
            </tr>
                         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 10"></td>
        </tr>  
</tbody>
</table>

<table width="50%" <?php echo $style; ?>>
    <tr>
        <td width='15%'>
            <label class='control-label'>NIP / No. Pendaftaran</label>
        </td>
		<td width='35%'>: <?php echo !empty($modPendaftaran->pasien->pegawai_id)?$modPendaftaran->pasien->pegawai->nomorindukpegawai:'-'; ?> / <?php echo $modPendaftaran->no_pendaftaran; ?></td>
        <td width='15%'>
			<label class='control-label'>No. Resep</label>
        </td>
        <td width='35%'>: <?php echo $modReseptur->noresep; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Nama Pasien</label>
        </td>
		<td width='35%'>: <?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        <td width='15%'>
			<label class='control-label'>Dokter Penulis Resep</label>
        </td>
        <td width='35%'>: <?php echo $modReseptur->pegawairl->NamaLengkap; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Umur</label>
        </td>
		<td width='35%'>: <?php echo $modPendaftaran->umur; ?></td>
        <td width='15%'>
			<label class='control-label'>Tanggal Resep</label>
        </td>
        <td width='35%'>: <?php echo $modReseptur->tglreseptur; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Alamat</label>
        </td>
		<td width='35%'>: <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
        <td width='15%'>
			<label class='control-label'>Ruangan</label>
        </td>
        <td width='35%'>: <?php echo $modReseptur->ruanganreseptur->ruangan_nama; ?></td>
    </tr>
       
    </table>
<br><br><br><br>

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
<?php foreach($kerangkaLooping as $i => $detail){ ?>
	<?php
		$criteriitem=new CDbCriteria;
		$criteriitem->addCondition("reseptur_id = ". $detail->reseptur_id);
		$criteriitem->addCondition("racikan_id = ". $detail->racikan_id);
		$criteriitem->addCondition("rke = ". $detail->rke);
		$items = ResepturdetailT::model()->findAll($criteriitem);
	?>
	<?php foreach($items as $ii => $item){ ?>
		<?php if($item->racikan_id == Params::RACIKAN_ID_NONRACIKAN){ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php echo $detail->rke; ?></td>
						<td width='50%' style="border-left: 0; border-right: 0;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'>No </td>
						<td width='25%'><?php echo CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
					<tr>
						<td colspan="4"><?php echo $item->signa_reseptur; ?></td>
					</tr>
				</tbody>
			</table>
		<?php }else{ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php echo $detail->rke; ?></td>
						<td width='50%' style="border-left: 0; border-right: 0;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'> </td>
						<td width='25%'></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $item->signa_reseptur; ?></td>
						<td><?php echo $item->satuansediaan; ?></td>
						<td><?php echo CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
		<?php } ?>
	<?php } ?>
	
	
 <fieldset class='iter'>
	 <legend>Iter <?php echo $detail->iter; ?></legend>
 </fieldset>
<br><br>
<?php } ?>