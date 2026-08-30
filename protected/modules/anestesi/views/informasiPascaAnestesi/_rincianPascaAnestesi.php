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
			<h6>Data Pasca Anestesi</h6>
			<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
				<tr>
					<th>Tanggal Pasca Rencana</th>
					<td><?php echo isset($modPascaAnestesi->tglpascaanestesi) ? MyFormatter::formatDateTimeForUser($modPascaAnestesi->tglpascaanestesi) : "-"; ?></td>
				</tr>
				<tr>
					<th>No. Pasca Rencana</th>
					<td><?php echo isset($modPascaAnestesi->nopascaanestesi) ? $modPascaAnestesi->nopascaanestesi : "-"; ?></td>
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
			</table>
		</div>
	</div>
	<div class="span6">
		<div class="block-tabel">
			<h6>Data Ruangan Tujuan</h6>
			<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
				<tr>
					<th>Instalasi</th>
					<td><?php echo isset($modPraAnestesi->instalasi_id) ? $modPraAnestesi->instalasipasca->instalasi_nama : "-"; ?></td><td></td>
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
					<th>Status Anestesi</th>
					<td><?php echo isset($modPraAnestesi->pasienanastesi_id) ? $modPraAnestesi->pasienanastesi->statusanestesi : "-"; ?></td><td></td>
				</tr>
				<tr>
					<th>Perawat</th>
					<td><?php echo isset($modPascaAnestesi->perawatruangan_id) ? $modPascaAnestesi->perawatruangan->NamaLengkap : "-"; ?></td><td></td>
				</tr>
			</table>
		</div>
	</div>
	
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
	
	<div class="span12">
		<div class="block-tabel">
			<h6>Tabel Daftar <b>Pemantauan Kondisi Pasien</b></h6>
				<table class="items table table-striped table-bordered table-condensed" id="table-pemantauan-kondisi-pasien">
				<thead>
					<tr>
						<th>No.</th>
						<th>Tanggal Pemantauan</th>
						<th>Jam Mulai</th>
						<th>Jam Selesai</th>
						<th>Menit Ke-</th>
						<th>Oksigen L/mnt</th>
						<th>Ventilasi mmHg</th>
						<th>Sirkulasi</th>
						<th>Suhu</th>
						<th>Perfusi Jaringan</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($modKondisiPasien) > 0){
						foreach($modKondisiPasien AS $i=>$kondisi){ ?>
					<tr>
						<td><?php echo $i+1; ?></td>
						<td><?php echo isset($kondisi->tglpemantauan) ? MyFormatter::formatDateTimeForUser($kondisi->tglpemantauan) : ""; ?></td>
						<td><?php echo isset($kondisi->jammulai) ? $kondisi->jammulai : ""; ?></td>
						<td><?php echo isset($kondisi->jamselesai) ? $kondisi->jamselesai : ""; ?></td>
						<td><?php echo isset($kondisi->menitke) ? $kondisi->menitke : ""; ?></td>
						<td><?php echo isset($kondisi->oksigen_liter) ? $kondisi->oksigen_liter : ""; ?></td>
						<td><?php echo isset($kondisi->ventilasi_mmhg) ? $kondisi->ventilasi_mmhg : ""; ?></td>
						<td><?php echo isset($kondisi->sirkulasi) ? $kondisi->sirkulasi : ""; ?></td>
						<td><?php echo isset($kondisi->suhu) ? $kondisi->suhu : ""; ?></td>
						<td><?php echo isset($kondisi->perfusijaringan) ? $kondisi->perfusijaringan : ""; ?></td>
					</tr>
					<?php    }
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>