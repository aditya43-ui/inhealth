<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td><?php echo $modInfoPasien->no_pendaftaran; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modInfoPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo $modInfoPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modInfoPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modInfoPasien->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo $modInfoPasien->tanggal_lahir; ?> / <?php echo $modInfoPasien->umur; ?></td>
        </tr>
        <tr>
            <td>Jenis Penjamin / Penjamin</td>
            <td>:</td>
            <td><?php echo isset($modInfoPasien->carabayar_nama)?$modInfoPasien->carabayar_nama:''; ?> / <?php echo isset($modInfoPasien->penjamin_nama)?$modInfoPasien->penjamin_nama:''; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo isset($modInfoPasien->kelaspelayanan_nama)?$modInfoPasien->kelaspelayanan_nama:''; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modInfoPasien->ruangan_nama)?$modInfoPasien->ruangan_nama:''; ?></td>
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>No.</th>
			<th>Ruangan</th>
			<th>Tanggal Verifikasi Tindakan</th>
			<th width="30%">Verifikasi Tindakan/<br>Pemeriksa</th>
			<th>Keterangan</th>
			<th>Jumlah</th>
			<th>Satuan</th>
			<th>Jumlah Tarif</th>
        </thead>
        <?php 
		$total = 0;
        if(count((array)$modTindakans) > 0){
            foreach ($modTindakans AS $i => $tindakan){
				$total = $total + ($tindakan->qty_tindakan*$tindakan->tarif_satuan)
        ?>
            <tr>
                <td>
                    <?php echo ($i + 1); ?>
                </td>
                <td><?php echo ($tindakan->ruangan->ruangan_nama); ?></td>
                <td><?php echo ($format->formatDateTimeForUser($tindakan->tgl_tindakan)); ?></td>
                <td>
                    <?php echo ($tindakan->daftartindakan->kategoritindakan_nama)."-".($tindakan->daftartindakan->daftartindakan_nama); ?><br>
                </td>
                <td>
                    <?php echo $tindakan->keterangantindakan; ?><br>
                </td>
                <td><?php echo $tindakan->qty_tindakan; ?></td>
                <td><?php echo ($tindakan->satuantindakan); ?></td>
                <td style='text-align:right;'><?php echo $format->formatNumberForUser($tindakan->qty_tindakan*$tindakan->tarif_satuan); ?></td>
            </tr>
        <?php
            }
        } 
        ?>
        <tfoot class="border">
            <tr>
                <td colspan="7" align="center"><b>Total</b></td>
                <td align="right"><?php echo $format->formatUang($total); ?></td>
            </tr>
        </tfoot>
    </table>
<table width="100%" style="margin-top:20px;">
<tr>
	<td></td>
	<td></td>
	<td width="30%" align="center" align="top">
		<div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
		<div>Operator</div>
		<div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
	</td>
</tr>
</table>
