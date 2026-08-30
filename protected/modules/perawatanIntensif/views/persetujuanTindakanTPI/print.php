<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE>
    <div>
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT PERSETUJUAN TINDAKAN MEDIS"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO : <?php echo $modSuratPersetujuan->nopersetujuan; ?></span></B>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        Saya yang bertanda tangan dibawah ini:
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Nama </td>
                <td>:</td>
                <td><?php echo isset($modSuratPersetujuan->nama_menyetujui) ?  $modSuratPersetujuan->nama_menyetujui : ""; ?></td>
            </tr>
            <tr>
                <td>Umur </td>
                <td>:</td>
				<td><?php echo isset($modSuratPersetujuan->umur_menyetujui) ?  $modSuratPersetujuan->umur_menyetujui : ""; ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin </td>
                <td>:</td>
				<td><?php echo isset($modSuratPersetujuan->jeniskelamin_menyetujui) ?  $modSuratPersetujuan->jeniskelamin_menyetujui : ""; ?></td>
            </tr>
            <tr>
                <td>Alamat </td>
                <td>:</td>
				<td><?php echo isset($modSuratPersetujuan->alamat_menyetujui) ?  $modSuratPersetujuan->alamat_menyetujui : ""; ?></td>
            </tr>
            <tr>
                <td>No. KTP </td>
                <td>:</td>
				<td><?php echo isset($modSuratPersetujuan->noktp_menyetujui) ?  $modSuratPersetujuan->noktp_menyetujui : ""; ?></td>
            </tr>
        </table>
		<br>
        <p align="justify">Menyatakan dengan sesungguhnya telah memberi</p>
		<h3><p style="margin: 0; text-align: center;">PERSETUJUAN</p></h3>
		<p align="justify">
			Untuk dilakukan tindakan medis berupa 
			<?php if(count((array)$modTindakanAnestesi) > 0){ ?>
			<?php
				$style_tindakan = '';
				if(count((array)$modTindakanAnestesi) > 0){
					$style_tindakan = 'style="margin-top:-25px;margin-left: 300px;padding-bottom:10px;"';
				}
			?>
			<div <?php echo $style_tindakan; ?>>
				<ul>
					<?php					
						foreach($modTindakanAnestesi AS $i=>$tindakan){ ?>
							<li><?php echo (!empty($tindakan->anastesi_id) ? $tindakan->anastesi->anastesi_nama : ""); ?></li>
					<?php    }
					?>			
				</ul>
			</div>
			<?php }else{ echo "-"; } ?>
		</p>
		<p align="justify">
			Dengan obat dan alat kesehatan
			<?php if(count((array)$modObatAlkesAnestesi) > 0){ ?>
			<?php
				$style_obat = '';
				if(count((array)$modObatAlkesAnestesi) > 0){
					$style_obat = 'style="margin-top:-25px;margin-left: 300px;padding-bottom:10px;"';
				}
			?>
			<div <?php echo $style_obat; ?>>				
				<ul>
					<?php
						foreach($modObatAlkesAnestesi AS $i=>$obat){ ?>
							<li><?php echo (!empty($obat->obatalkespasien_id) ? $obat->obatalkespasien->obatalkes->obatalkes_nama : ""); ?></li>
					<?php    }
					?>			
				</ul>				
			</div>
			<?php }else{ echo "-"; } ?>
		</p>
        <p align="justify">
           Terhadap <?php echo isset($modSuratPersetujuan->tindakanterhadap) ? $modSuratPersetujuan->tindakanterhadap : ""; ?> , dengan
			<br>
			<table width="100%" style="width:500px;margin-left:80px;">
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td>
						<?php echo isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : ""; ?>
					</td>
				</tr>
				<tr>
					<td>Umur/Jenis Kelamin</td>
					<td>:</td>
					<td>
						<?php echo isset($modPendaftaran->umur) ? $modPendaftaran->umur : ""; ?> / <?php echo isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : ""; ?>
					</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td>
						<?php echo isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : ""; ?>
					</td>
				</tr>
				<tr>
					<td>No. KTP</td>
					<td>:</td>
					<td>
						<?php 
							if($modPasien->jenisidentitas == 'KTP'){
								echo isset($modPasien->no_identitas_pasien) ? $modPasien->no_identitas_pasien : "-";
							}else{
								echo "-";
							}
						?>
					</td>
				</tr>
				<tr>
					<td>Dirawat Di</td>
					<td>:</td>
					<td>
						<?php echo isset($modPraAnestesi->ruangan->ruangan_nama) ? $modPraAnestesi->ruangan->ruangan_nama : ""; ?> / <?php echo isset($modPraAnestesi->kamarruangan->KamarDanTempatTidurPasien) ? $modPraAnestesi->kamarruangan->KamarDanTempatTidurPasien : ""; ?>
					</td>
				</tr>
				<tr>
					<td>No. Rekam Medis</td>
					<td>:</td>
					<td>
						<?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : ""; ?>
					</td>
				</tr>
			</table>
        </p>
        <p align="justify">
           Yang tujuan, sifat dan perlunya tindakan medis tersebut diatas, serta resiko yang dapat ditimbulkannya telah cukup dijelaskan oleh dokter dan telah saya mengerti sepenuhnya.
        </p>
        <p align="justify">
           Demikian perenyataan ini saya buat dengan penuh kesadaran dan tanpa paksaan.
        </p>
	<br><br><br><br><br>
	<table width='100%'>
        <tr>
            <td width='35%'></td>
			<td width='35%'></td>
            <td align="center" width='30%'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr height='100px'>
            <td align="center" width='35%'>Saksi-Saksi</td>
            <td align="center" width='35%'>Dokter</td>
            <td align="center" width='30%'>Yang Membuat</td>
        </tr>
        <tr>
			<td align="center" width='35%'><?php echo isset($modSuratPersetujuan->pegawaisaksi1->NamaLengkap) ?  "<u>".$modSuratPersetujuan->pegawaisaksi1->NamaLengkap."</u>" : ""; ?></td>
			<td align="center" width='35%'><?php echo isset($modSuratPersetujuan->dokter->NamaLengkap) ?  "<u>".$modSuratPersetujuan->dokter->NamaLengkap."</u>" : ""; ?></td>
			<td align="center" width='30%'><?php echo isset($modSuratPersetujuan->nama_yangmenyetujui) ?  "<u>".$modSuratPersetujuan->nama_yangmenyetujui."</u>" : ""; ?></td>
        </tr>
		<tr height='100px'>
            <td align="center" width='35%'>Saksi 1</td>
            <td align="center" width='35%'></td>
            <td align="center" width='30%'></td>
        </tr>
		<tr>
            <td align="center" width='35%'><?php echo isset($modSuratPersetujuan->nama_saksi2) ?  "<u>".$modSuratPersetujuan->nama_saksi2."</u>" : ""; ?></td>
            <td align="center" width='35%'></td>
            <td align="center" width='30%'></td>
        </tr>
		<tr height='100px'>
            <td align="center" width='35%'>Saksi 2</td>
            <td align="center" width='35%'></td>
            <td align="center" width='30%'></td>
        </tr>
    </table>
</TABLE>