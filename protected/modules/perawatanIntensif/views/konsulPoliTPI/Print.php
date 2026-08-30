<?php
if ($caraPrint == 'EXCEL') {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
	header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

$style = 'margin-left:auto; margin-right:auto;';
if (isset($caraPrint)) {
	if ($caraPrint == "EXCEL")
		$style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
} else {
	$style = "style='margin-left:auto; margin-right:auto;";
//        $td ='';
}
?>

<table width="100%" <?php echo $style; ?> >
    <tr>
        <td style="text-align:center;width:100%;"><h3><?php echo $judulLaporan ?></h3></td>
    </tr>
</table>
<table width="100%" <?php echo $style; ?> >
	<tr>
		<td style="width:20%">Nama :</td>
		<td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
		<td style="width:20%">NO. Rekam Medik</td>
		<td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr>
		<td style="width:20%">Umur :</td>
		<td style="width:30%"><?php echo $modPendaftaran->umur . ' / ' . $modPasien->jeniskelamin; ?></td>
		<td style="width:20%">Ruangan</td>
		<td style="width:30%"><?php echo $modJawabKonsul->ruangan->ruangan_nama; ?></td>
	</tr>
</table>
<br><br>
<table width="100%" <?php echo $style; ?> >
	<tr>
		<td style="width:20%"></td>
		<td style="width:30%"></td>
		<td style="width:20%"><?php echo $modProfilRs->kabupaten->kabupaten_nama . ',';?></td>
		<td style="width:30%"><?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d', (strtotime($modJawabKonsul->tgljawabkonsul)))); ?></td>
	</tr>
</table>
<br><br>
<table width="100%" <?php echo $style; ?> >
	<tr>
		<td style="width:50%">T.S Yth 
                                    <?php // echo $modKonsul->getNamaLengkapDokter($modKonsul->pegawai_id); ?>
                                    <?php echo (isset($modKonsul->pegawai_id) ? $modKonsul->pegawai->getNamaLengkap() : ''); ?>
                </td>
		<td style="width:20%"></td>
		<td style="width:30%"></td>
	</tr>
	<tr>
		<td style="width:50%"></td>
		<td style="width:20%">Jam : </td>
		<td style="width:30%"><?php echo date('H:i:s', (strtotime($modJawabKonsul->tgljawabkonsul))); ?></td>
	</tr>
</table>
<br><br>
<table width="100%" <?php echo $style; ?> >
	<tr>
		<td>Menjawab konsul T.s mengenai O.s ini kami beritahukan bahwa pada pemeriksaan ditemukan: </td>
		
	</tr>
	<!-- <tr>
		<td><?php //echo $modJawabKonsul->jawabankonsul; ?></td>
	</tr> -->
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td width="20%" align="center">Subjective</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->objective) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->objective)) : " - ");
            }
        ?></td>
        <td width="20%" align="center">Objective</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->subjective) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->subjective)) : " - ");
            }
        ?></td>
    </tr>
    <tr>
        <td width="20%" align="center">Assessment</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->assessment) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->assessment)) : " - ");
            }
        ?></td>
        <td width="20%" align="center">Planning</td>
        <td width="40%" align="center"><?php
            foreach ($modRiwayatKonsul as $i => $konsul) {
                echo (isset($konsul->planning) ? CHtml::encode(preg_replace('#</?p.*?>#is', '', $konsul->planning)) : " - ");
            }
        ?></td>
    </tr>
</table>
<br><br>
<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
				
			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
				TTD,
				<br><br><br><br><br><br>
				( 
                                    <?php // echo $modJawabKonsul->getNamaLengkapDokter($modJawabKonsul->pegawai_id);?> 
                                    <?php echo (isset($modJawabKonsul->pegawai_id) ? $modJawabKonsul->pegawai->getNamaLengkap() : ''); ?>
                                )
			</th>
		</tr>
	</table>
