<style type="text/css">
	body {
		font-size: 10pt;
	}
table.isiTable tr td{
	padding: 0;
	margin: 0;
	font-size: 12px;
}
table.headerIsi tr td{
	padding: 0;
	margin: 0 0 10px 0;
}
.nmrs{ font-size: 18px;}
table tr td.textKanan{ text-align: right; vertical-align: top; font-weight: bold;}
.dokter{font-size: 12px;}
.r{font-size: 30px;}
table tr td.imagelogo{
	vertical-align: top;
}
table.headerIsi tr td.buatNomor{
	border: 1px solid #000;
	height: 50px;
	width: 30px;
}
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
 $tab = ' &nbsp; &nbsp; &nbsp; ';
 $th = explode(" ",$modPendaftaran->umur);
 $tglreg = $modPendaftaran->tgl_pendaftaran;
 $tglregister = substr($tglreg, 8, 2).'/'.  substr($tglreg, 5, 2).'/'.  substr($tglreg, 0, 4);
?>
<div style="position: fixed; left: 0mm; top: 20mm; rotate: -90; width: 140mm;">
<table style="width: 100%; border: none;">
	<tr>
		<td width="100%">
			
			<table width="100%" class="headerIsi">
				<tr>
					<td rowspan="3" class="imagelogo">
						<?php
						if (file_exists(Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit)) {
							$gambar = Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit;
						?>
                                                    <img src="<?php echo $gambar ?> " style="max-width: 70px; width:70px;"/>
						<?php }else{
							
						}
						?>
					</td>
					<td><p style="margin: 0; text-align: center;"><strong class="nmrs"><?php echo $modProfilRs->nama_rumahsakit;?></b></p></td>
					<td class="buatNomor">
						&nbsp; 
						<b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b>
						&nbsp;
					</td>
				</tr>
				<tr>
<!--					<td></td>-->
					<td><p style="margin: 0; text-align: center;"><b><?php echo $modPendaftaran->ruangan->ruangan_nama;?></b></p></td>
				</tr>
				<tr>
					<!--<td></td>-->
					<td><p style="margin: 0; text-align: center;"><b>Type : LANGGANAN - status : <?php echo ucfirst(strtolower($modPendaftaran->statuspasien)); ?></b></p></td>
					
				</tr>
			</table>
			
			<table class='isiTable'>
				 <tr>
					 <td>
						 MR / REG / ANTRIAN  
					 </td>
					 <td>
						 : <b><?php echo isset($modPendaftaran->antrianTs->noantrian) ? $modPasien->no_rekam_medik.' / '.$modPendaftaran->no_pendaftaran.' / '.$modPendaftaran->antrianTs->no_antrian : $modPasien->no_rekam_medik.' / '.$modPendaftaran->no_pendaftaran; ?></b>
					 </td>
				 </tr>
				 <tr>
					 <td>
						PASIEN / UMUR / GOL  
					 </td>
					 <td>
						 : <b><?php echo $modPasien->nama_pasien.', '.$modPasien->namadepan.$tab.' / '.'('.$th[0].'/'.$th[2].'/'.$th[4].')'.' / Sex : '.  substr($modPasien->jeniskelamin, 0, 1); ?> </b> 
					 </td>
				 </tr>
				 <tr>
					 <td>
						 ALAMAT 
					 </td>
					 <td>
						: <?php echo $modPasien->alamat_pasien; ?> 
					 </td>
				 </tr>
				 <tr>
					 <td>
						No. SP 
					 </td>
					 <td>
						:
					 </td>
				 </tr>
				 <tr>
					 <td>
						PENJAMIN 
					 </td>
					 <td>
						 : <b><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></b>
					 </td>
				 </tr>
				 <tr>
					 <td>
						PSHN PESERTA 
					 </td>
					 <td>
						 : <b><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></b>
					 </td>
				 </tr>
				 <tr>
					 <td>
						ATAS NAMA  
					 </td>
					 <td>
						 : <b> <?php echo isset($modPendaftaran->penanggungjawab_id) ? $modPendaftaran->penanggungjawab->nama_pj : " - "; ?> </b>
					 </td>
				 </tr>
				 <tr>
					 <td>
						HUBUNGAN
					 </td>
					 <td>
						 : <b><?php echo isset($modPendaftaran->penanggungjawab_id) ? $modPendaftaran->penanggungjawab->hubungankeluarga : " - "; ?> </b>
					 </td>
				 </tr>
				 <tr>
					 <td>
						TGL REGISTER 
					 </td>
					 <td>
						 : <b><?php 
							//echo $tglregister.' - '; 
							echo MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran); 
							echo ' - ( ';
							echo isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : " - ";
							echo ' )';
							?></b>
					 </td>
				 </tr>
			 </table> 
			
			<table style="width: 100%; border: none;">
				<tr>
					<td>
						<div class='r'><b>R / </b></div>
					</td>
					<td class="textKanan">
						<div class='dokter'><b><?php echo $modPendaftaran->pegawai->nama_pegawai; ?></b></div>
					</td>
				</tr>
			</table>
			
			
		</td>
	</tr>
</table>
</div>

