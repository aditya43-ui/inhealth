<style>
    .header-border {
        border-bottom: 1px solid black;
    }
</style>


<?php

$is_admisi = false;

if (!empty($admisi)) {
    $is_admisi = true;
    
    $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
    $pulang = empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;

    $vpulang = date('Y-m-d', strtotime($pulang));

    $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
    $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);

    $val_daftar = strtotime($daftar);
    $val_pulang = strtotime($vpulang);

    $res = (($val_pulang - $val_daftar)/ (3600 * 24)) + 1;


    $str = $tgl_daftar." - ".$tgl_pulang;
}

?>

<?php 
if (!empty($modPendaftaran->pasienadmisi_id)) {
    $kamarruangan = KamarruanganM::model()->findByPk($masukkamar->kamarruangan_id);
} 
?> 

<table class="identitas" width="100%">
    <tr>
        <td>No Pembayaran</td>
		<td>: <?php echo $modPembayaran->nopembayaran; ?></td>		
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <?php if (!empty($modPendaftaran->pasienadmisi_id)): ?>
        <td nowrap>Kelas Pelayanan</td>
		<td>: <?php echo !empty($modPendaftaran->pasienadmisi_id)?$admisi->kelaspelayanan->kelaspelayanan_nama:$modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>		
        <?php endif; ?>
    </tr>
    <tr>
        <td>Jenis Penjamin</td>
		<td>: <?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>		
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <?php if (!empty($asuransi) && !empty($modPendaftaran->pasienadmisi_id)): ?>
		<td nowrap>Kelas Tanggungan</td>
		<td>: <?php echo $asuransi->kelastanggunganasuransi->kelaspelayanan_nama; ?></td>		
		<?php endif; ?>
    </tr>
    <tr>
        <td>Penjamin</td>
		<td>: <?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>		
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <td>Total Biaya</td>
		<td>: <?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>		
    </tr>
    <tr class="header-border">
        <td>Terbilang</td>
		<td>: <?php echo $subtotalkotor==0?"NOL RUPIAH":strtoupper(MyFormatter::formatNumberTerbilang($grand_totals))." RUPIAH"; ?></td>		
    </tr>
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
    <tr>
        <td nowrap>No. Rekam Medik</td>
		<td>: <?php echo $pasien->no_rekam_medik; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <td nowrap>Tgl. Pendaftaran</td>
		<td>: <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>		
    </tr>
    <tr>
        <td>Nama Pasien</td>
		<td>: <?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>		
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <td>No. Pendaftaran</td>
		<td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>		
    </tr>
    <tr>
        <!--<td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php //echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>-->
        <td>Tanggal Lahir</td>
		<td>: <?php echo date('d / F /Y', strtotime($pasien->tanggal_lahir)); ?></td>		
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <td>Ruangan</td>
		<td>: <?php echo empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->ruangan->ruangan_nama:$admisi->kelaspelayanan->kelaspelayanan_nama; ?></td>		
    </tr>
    <?php if (!empty($admisi)): ?>
    
    <?php
        
        
        if ($admisi->penjamin_id == Params::PENJAMIN_ID_UMUM):
        
        ?>
    <tr>
        <td>Alamat</td>
		<td>: <?php echo $pasien->alamat_pasien; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>		
        <td>Selama</td>
		<td>: <?php echo $res." Hari - ".$str; ?></td>		
    </tr>
    <tr>
        <td>Dokter</td>
		<td>: <?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>		
    </tr>
    
    
    <?php else : ?>
    <tr>
        <td>Alamat</td>
		<td>: <?php echo $pasien->alamat_pasien; ?></td>		
		<td>&nbsp;</td>
		<td>&nbsp;</td>		
        <td>Tgl Masuk</td>
		<td>: <?php echo $tgl_daftar; ?></td>		
    </tr>
    <tr>
        <td>Dokter</td>
		<td>: <?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>		
        <td>Tgl Keluar</td>
		<td>: <?php echo $tgl_pulang; ?></td>		
    </tr>
    <?php endif; ?>
    
    
    <?php endif; ?>
</table>