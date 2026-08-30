<fieldset class="box">
	<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Masuk Penunjang</td>
            <td>:</td>
            <td><?php echo isset($modPasienAnestesi->pasienmasukpenunjang_id) ? $modPasienAnestesi->pasienmasukpenunjang->no_masukpenunjang : ""; ?></td>
			
			<td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : ""; ?></td>
        </tr>
        <tr>
            <td>Tgl. Masuk Penunjang</td>
            <td>:</td>
            <td><?php echo isset($modPasienAnestesi->pasienmasukpenunjang_id) ? MyFormatter::formatDateTimeForUser($modPasienAnestesi->pasienmasukpenunjang->tglmasukpenunjang) : ""; ?></td>
			
			<td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : ""; ?></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->umur) ? $modPendaftaran->umur : ""; ?></td>
			
			<td>Pekerjaan</td>
            <td>:</td>
            <td><?php echo isset($modPasien->pekerjaan_id) ? $modPasien->pekerjaan->pekerjaan_nama : ""; ?></td>
        </tr>
        <tr>
            <td>Jenis Kasus Penyakit</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->jeniskasuspenyakit_id) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : ""; ?></td>
			
			<td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : ""; ?></td>
        </tr>
        <tr>
            <td>Dokter Pemeriksa</td>
            <td>:</td>
            <td><?php echo isset($modPraAnestesi->dokter_id) ? $modPraAnestesi->dokter->NamaLengkap : ""; ?></td>
			
			<td>Alamat</td>
            <td>:</td>
            <td><?php echo (isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : ""); ?></td>
        </tr>
		<tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : ""; ?></td>
        </tr>
    </table>
</fieldset>
<div class="row-fluid">
	<div class="span6">
		<div class="block-tabel">
			<h6>Data Rencana Anestesi</h6>
			<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
				<tr>
					<th>Tanggal Rencana</th>
					<td><?php echo isset($modPraAnestesi->tglpraanestesi) ? MyFormatter::formatDateTimeForUser($modPraAnestesi->tglpraanestesi) : "-"; ?></td>
				</tr>
				<tr>
					<th>Dokter Anestesi</th>
					<td><?php echo isset($modPraAnestesi->dokter_id) ? $modPraAnestesi->dokter->NamaLengkap : "-"; ?></td>
				</tr>
				<tr>
					<th>Perawat Anestesi 1</th>
					<td><?php echo isset($modPraAnestesi->perawat1_id) ? $modPraAnestesi->perawat1->NamaLengkap : "-"; ?></td>
				</tr>
				<tr>
					<th>Perawat Anestesi 2</th>
					<td><?php echo isset($modPraAnestesi->perawat2_id) ? $modPraAnestesi->perawat2->NamaLengkap : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Ruangan</th>
					<td><?php echo isset($modPraAnestesi->ruangan_id) ? $modPraAnestesi->ruangan->ruangan_nama : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Kamar Ruangan</th>
					<td><?php echo isset($modPraAnestesi->kamarruangan_id) ? $modPraAnestesi->kamarruangan->KamarDanTempatTidur : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Keterangan Rencana</th>
					<td><?php echo isset($modPraAnestesi->ketpraanestesi) ? $modPraAnestesi->ketpraanestesi : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Status Anestesi</th>
					<td><?php echo isset($modPraAnestesi->pasienanastesi_id) ? $modPraAnestesi->pasienanastesi->statusanestesi : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Klasifikasi ASA</th>
					<td><?php echo isset($modPasienAnestesi->typeanastesi_id) ? $modPasienAnestesi->typeanastesi->typeanastesi_nama : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Teknik Sedasi</th>
					<td><?php echo isset($modPraAnestesi->tekniksedasi) ? $modPraAnestesi->tekniksedasi : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Tanggal Puasa</th>
					<td><?php echo isset($modPraAnestesi->tglpuasa) ? MyFormatter::formatDateTimeForUser($modPraAnestesi->tglpuasa) : "-"; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="span6">
		<div class="block-tabel">
			<h6>Rencana Tindakan Anestesi</h6>
			<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
				<thead>
					<tr>
						<th>No.</th>
						<th>Jenis Anestesi</th>
						<th>Teknik Anestesi</th>
						<th>Tipe Anestesi</th>
						<th>Jumlah</th>
						<th>Satuan</th>
						<th>Nominal Tarif</th>
						<th>Total Tarif</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($modTindakanAnestesi) > 0){
						foreach($modTindakanAnestesi AS $i=>$tindakan){ ?>
					<tr>
						<td><?php echo $i+1; ?></td>
						<td><?php echo (!empty($modPasienAnestesi->jenisanastesi_id) ? $modPasienAnestesi->jenisanastesi->jenisanastesi_nama : ""); ?></td>
						<td><?php echo (!empty($tindakan->anastesi_id) ? $tindakan->anastesi->anastesi_nama : ""); ?></td>
						<td><?php echo (!empty($modPasienAnestesi->typeanastesi_id) ? $modPasienAnestesi->typeanastesi->typeanastesi_nama : ""); ?></td>
						<td style="text-align: center;"><?php echo (!empty($tindakan->qty_tindakan) ? number_format($tindakan->qty_tindakan) : "0"); ?></td>
						<td style="text-align: center;"><?php echo (!empty($tindakan->tindakanpelayanan_id) ?  ($tindakan->tindakanpelayanan->satuantindakan) : "-"); ?></td>
						<td style="text-align: right;"><?php echo (!empty($tindakan->tarif_tindakan) ?  number_format($tindakan->tarif_tindakan) : "0"); ?></td>
						<td style="text-align: right;"><?php echo number_format($tindakan->qty_tindakan * $tindakan->tarif_tindakan); ?></td>
					</tr>
					<?php    }
					}
					?>
				</tbody>
			</table>
		</div>
		
		<div class="block-tabel">
			<h6>Rencana Obat dan Alat Kesehatan</h6>
			<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
				<thead>
					<tr>
						<th>No.</th>
						<th>Jenis Anestesi</th>
						<th>Nama Obat Alkes</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($modObatAlkesAnestesi) > 0){
						$no_urut = 0;
						foreach($modObatAlkesAnestesi AS $b=>$obat){
							if(empty($obat->obatalkespasien->daftartindakan_id)){
								$no_urut++;
					?>
					<tr>
						<td><?php echo $no_urut; ?></td>
						<td><?php echo (!empty($modPasienAnestesi->jenisanastesi_id) ? $modPasienAnestesi->jenisanastesi->jenisanastesi_nama : ""); ?></td>
						<td><?php echo (!empty($obat->obatalkespasien_id) ? $obat->obatalkespasien->obatalkes->obatalkes_nama : ""); ?></td>
						<td style="text-align: center;"><?php echo (!empty($obat->qty_oa) ? number_format($obat->qty_oa) : "0"); ?></td>
					</tr>
					<?php    }
						}
					}
					?>
				</tbody>
			</table>
		</div>
		
		<div class="block-tabel">
			<h6>Paket BMHP</h6>
			<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
				<thead>
					<tr>
						<th>No.</th>
						<th>Jenis Anestesi</th>
						<th>Nama Paket BMHP</th>
						<th>Nama Obat BMHP</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($modObatAlkesAnestesi) > 0){
						$no_urut = 0;
						foreach($modObatAlkesAnestesi AS $c=>$obat_bmhp){ 
							if(!empty($obat_bmhp->obatalkespasien->daftartindakan_id)){
								$no_urut++;
					?>
					<tr>
						<td><?php echo $no_urut; ?></td>
						<td><?php echo (!empty($modPasienAnestesi->jenisanastesi_id) ? $modPasienAnestesi->jenisanastesi->jenisanastesi_nama : ""); ?></td>
						<td><?php echo (!empty($obat_bmhp->obatalkespasien->daftartindakan_id) ? $obat_bmhp->obatalkespasien->daftartindakan->daftartindakan_nama : ""); ?></td>
						<td><?php echo (!empty($obat_bmhp->obatalkespasien_id) ? $obat_bmhp->obatalkespasien->obatalkes->obatalkes_nama : ""); ?></td>
						<td style="text-align: center;"><?php echo (!empty($obat_bmhp->qty_oa) ? number_format($obat_bmhp->qty_oa) : "0"); ?></td>
					</tr>
					<?php  } 
							}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>