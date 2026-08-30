<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
    }
    .dasheds {
        border-bottom: 1px dashed black;
    }
</style>
<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrint'); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
             Data Pasien
        </td>
    </tr>
    <?php if($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){ ?>
    <tr>
        <td>No. Antrian</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
	<tr>
		<td colspan="3" class="dasheds"></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td>No. Pendaftaran</td>
		<td>:</td>
		<td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
	</tr>
	<tr>
		<td>Nama Pasien</td>
		<td>:</td>
		<td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
	</tr>
	<tr>
		<td>No. Rekam Medis</td>
		<td>:</td>
		<td><?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<?php 
	if(count((array)$modTindakans) > 0) {
		foreach($modTindakans AS $i => $modTindakan){
	?>
		<tr>
			<td>Karcis - <?php echo ($i+1); ?></td>
			<td>:</td>
			<td><?php echo (isset($modTindakan->karcis->karcis_nama) ? $modTindakan->karcis->karcis_nama : "-"); ?></td>
		</tr>
		<tr>
			<td>Harga Karcis</td>
			<td>:</td>
			<td><?php echo (isset($modTindakan->tarif_satuan) ? $format->formatUang($modTindakan->tarif_satuan * $modTindakan->qty_tindakan) : "-")?></td>
		</tr>
	<?php
		}
	}else{
	?>
		<tr>
			<td>Karcis</td>
			<td>:</td>
			<td>-</td>
		</tr>
		<tr>
			<td>Harga Karcis</td>
			<td>:</td>
			<td>-</td>
		</tr>
	<?php
	}
	?>
			
    
</table><br>
<table style="width: 100%; border: none;">
    <tr>
        <td width="50%"></td>
        <td>Petugas Loket</td>
    </tr>
    <tr height="60px" valign="bottom">
        <td></td>
        <td><?php echo empty($modPegawai)?"-":$modPegawai->nama_pegawai; ?></td>
    </tr>
</table>

    <?php }else{ ?>
    <tr>
        <td>No. Antrian</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
<!--<tr>
        <td>Ruangan Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>-->
    <tr>
        <td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
    </tr>
    </table>
    <?php } ?>
<!--<div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
    <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
    <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
</div>-->