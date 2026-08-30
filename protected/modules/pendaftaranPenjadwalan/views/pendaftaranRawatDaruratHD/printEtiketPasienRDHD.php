<style>
	BODY, DIV, TABLE, TBODY, TFOOT, TR, TH, TD, P {
    font-family: "Arial";
    font-size: 7pt;
}
.tabel {
	width: 223px;
	height: 115px;
	/*border: 1px solid #000;*/
	margin-top: 7px;
	/*margin-bottom: 15px;*/
	/*background-color: #CCC;*/
}
.forimage{
	width: 200px;
	height: 35px;
	overflow-y: hidden;
}
img{
	border: 0 none;
    height: auto;
    margin-bottom: 0;
	width: 160px;
}
</style>
<?php // for($i=1; $i<=Params::PRINT_ETIKET_PENDAFTARAN; $i++){ ?>
<table class="tabel">
	<tr>
		<td>&nbsp; No. RM </td>
		<td>: &nbsp; <?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr>
		<td>&nbsp; Nama Pasien </td>
		<td>: &nbsp; <?php echo $modPasien->nama_pasien.", ".$modPasien->namadepan;?></td>
	</tr>
<!--	<tr>
		<td>&nbsp; Tgl. Lahir </td>
		<td>: &nbsp; <?php // echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
	</tr>
	<tr>
		<td>&nbsp; Jadwal HD</td>
		<td>: &nbsp; <?php // echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
	</tr>-->
	<tr>
		<td colspan="2">
			<div class="forimage">
				<p style="margin: 0; text-align: center;"><img src="index.php?r=barcode/myBarcode&code=<?php echo $modPasien->no_rekam_medik; ?>&is_text=">
				</p>
					</div>
			
		</td>
	</tr>
</table>
<?php
//}
?>