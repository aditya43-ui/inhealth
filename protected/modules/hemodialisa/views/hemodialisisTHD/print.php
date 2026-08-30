<style>
    td, th{
        font-size: 10.5pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 32px;
    }
			
			
		</style>
<?php echo $this->renderPartial($this->path_view.'_headerPrint'); ?>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
        <td style="width:20%">NO. RM</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">UMUR</td>
        <td style="width:30%"><?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tgl. Periksa</td>
        <td style="width:20%"><?php echo MyFormatter::formatDateTimeId($modHemodialisa->periksahd_tgl); ?></td>
        <td style="width:20%">Ruangan</td>
        <td style="width:20%"><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
</table>
<br><br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Jenis Hemodialisa</b></td>
		<td width="25%">
			<?php
			$jenisHD = JenishdM::model()->findByPk($modHemodialisa->jenishd_id);
			echo $jenisHD->jenishd_nama;
			?>
		</td>
		<td width="25%"><b>Akses Vaskular</b></td>
		<td width="25%">
			<?php
			$vaskular = AksesvaskularM::model()->findByPk($modHemodialisa->aksesvaskular_id);
			echo $vaskular->aksesvaskular_nama;
			?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Jenis Dialiser</b></td>
		<td width="25%">
			<?php
			$dialiser = JenisdialisatM::model()->findByPk($modHemodialisa->jenisdialisat_id);
			echo $dialiser->jenisdialisat_nama;
			?>
		</td>
		<td width="25%"><b>Penggunaan Dialiser Ke</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->dialiserke;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Tanggal Dialiser</b></td>
		<td width="25%">
			<?php
			echo MyFormatter::formatDateTimeForUser($modHemodialisa->periksahd_tgl);
			?>
		</td>
		<td width="25%"><b>Perawat</b></td>
		<td width="25%">
			<?php
			$perawat = PegawaiM::model()->findByPk($modHemodialisa->pegawai_id);
			echo $perawat->nama_pegawai;
			?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Aliran Darah (QB)</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->kec_darah_qb;
			?>
			ml/Menit
		</td>
		<td width="25%"><b>Aliran Dialisat (QD)</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->kec_dialisat_qd;
			?>
			ml/Menit
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Dosis Awal</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_dosisawal;
			?>
		</td>
		<td width="25%"><b>Kontinyu</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_continyu;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>LMWH</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_lmwh;
			?>
		</td>
		<td width="25%"><b>Tampa Heparin</b></td>
		<td width="25%">
			<?php
			$modHemodialisa->tanpaheparin_nama = !empty($modHemodialisa->tanpaheparin_nama) ? $modHemodialisa->tanpaheparin_nama : "-";
			echo $modHemodialisa->tanpaheparin_nama." : ".$modHemodialisa->tanpaheparin_jml;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Intermiten</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_intermiten;
			?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>BB Pra Hemodialisa</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bb_pra_hd_kg;
			?>
			Kg
		</td>
		<td width="25%"><b>BB Post Hemodialisa</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bb_post_hd_kg;
			?>
			Kg
		</td>
	</tr>
	<tr>
		<td width="25%"><b>BB Kering</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bb_kering_kg;
			?>
			Kg
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Ultrafiltrasi</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->ultrafiltrasi_mode;
			?>
		</td>
		<td width="25%"><b>Natrium</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->natrium_mode;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Bicarbonat</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bicarbonat_mode;
			?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Hemapo</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_hemapo." ".$modHemodialisa->obat_hemapo_stn;
			?>
		</td>
		<td width="25%"><b>Epodion</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_epodion." ".$modHemodialisa->obat_epodion_stn;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Recormon</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_recormon." ".$modHemodialisa->obat_recormon_stn;
			?>
		</td>
		<td width="25%"><b>Prep Besi</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->injeksi_preb_besi." ".$modHemodialisa->injeksi_preb_besi_stn;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Eprex</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_eprex." ".$modHemodialisa->obat_eprex_stn;
			?>
		</td>
		<td width="25%"><b>Asam Amir</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->injeksi_asamamir." ".$modHemodialisa->injeksi_asamamir_stn;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Epotrex</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_epotrex." ".$modHemodialisa->obat_epotrex_stn;
			?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Jenis Transfusi Darah</b></td>
		<td width="25%">
			<?php
			if(!empty($modHemodialisa->jenistransfusi_id)){
				$transfusi = JenistransfusiM::model()->findByPk($modHemodialisa->jenistransfusi_id);
				echo $transfusi->jenistransfusi_nama;
			}else{
				echo "-";
			}
			?>
		</td>
		<td width="25%"><b>Jumlah Labu</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->jmllabudarah;
			?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td style="text-align: center"><b>Penyulit</b></td>
	</tr>
	<tr>
		<td>
			<?php
			$penyulit = explode(" ,", $modHemodialisa->periksahd_penyulit);
			foreach ($penyulit as $value){
				echo " -".$value;
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="25%"><b>Predialysis BUN</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->pre_dialisis_bun;
			?>
			mg/dl
		</td>
		<td width="25%"><b>Urea Reduction Ratio</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->adekuasi_urr;
			?>
			%
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Postdialysis BUN</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->post_dialisis_bun;
			?>
			mg/dl
		</td>
		<td width="25%"><b>Kt/ V</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->adekuasi_kt_v;
			?>
		</td>
	</tr>
</table>
