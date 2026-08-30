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
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT PENOLAKAN TINDAKAN MEDIS"; ?></U></FONT></B>
                </TD>
            </TR>
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Liberation Serif" SIZE=4>NO : <?php echo $modSuratPersetujuan->nopersetujuan; ?></FONT></B>
                </TD>
            </TR>
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
        <p align="justify">Dengan ini menyatakan sesungguhnya, bahwa saya telah menerima informasi yang diberikan oleh Dokter sebagaimana di atas dan telah memahaminya. Untuk saya akan memberikan </p>
		<h3><center>PENOLAKAN/PEMBATALAN</center></h3>
		<p align="justify">
			Untuk dilakukan tindakan medis berupa 
			<?php if(!empty($modSuratPersetujuan->tindakanmedis)){ ?>
			<?php
				$style_tindakan = '';
				if(!empty($modSuratPersetujuan->tindakanmedis) > 0){
					$style_tindakan = 'style="margin-top:-25px;margin-left: 300px;padding-bottom:10px;"';
				}
			?>
			<div <?php echo $style_tindakan; ?>>
				<ul>
					<?php			
                                        $tindakan = explode(',', $modSuratPersetujuan->tindakanmedis);
					foreach($tindakan AS $i=>$nama_tindakan){ 
                                            if($nama_tindakan != ' '){
                                        ?>
							<li>
                                                            <?php 
                                                            echo $nama_tindakan;
//                                                                echo (!empty($tindakan->anastesi_id) ? $tindakan->anastesi->anastesi_nama : ""); 
                                                            ?>
                                                        </li>
					<?php
                                            }
                                        }
					?>			
				</ul>
			</div>
			<?php }else{ echo "-"; } ?>
		</p>
        <p align="justify" style="margin-left: 50px; text-indent: 0px;">
			Bedah/Operasi : <br/>
			<?php echo empty($modSuratPersetujuan->bedah_operasi) ? "-" : $modSuratPersetujuan->bedah_operasi; ?>
        </p>
        <p align="justify" style="margin-left: 50px; text-indent: 0px;">
			Transfusi Darah : <br/>
			<?php echo empty($modSuratPersetujuan->transfusi_darah) ? "-" : $modSuratPersetujuan->transfusi_darah; ?>
        </p>
		<p align="justify">
			Dengan obat dan alat kesehatan
			<?php if(!empty($modSuratPersetujuan->obatalkes)){ ?>
			<?php
				$style_obat = '';
				if(!empty($modSuratPersetujuan->obatalkes)){
					$style_obat = 'style="margin-top:-25px;margin-left: 300px;padding-bottom:10px;"';
				}
			?>
			<div <?php echo $style_obat; ?>>				
				<ul>
					<?php			
                                        $obat = explode(':::', $modSuratPersetujuan->obatalkes);
					foreach($obat AS $i=>$nama_obat){ 
                                            if($nama_obat != ' '){
                                        ?>
							<li>
                                                            <?php 
                                                            echo $nama_obat;
//                                                                echo (!empty($obat->obatalkespasien_id) ? $obat->obatalkespasien->obatalkes->obatalkes_nama : "");
                                                            ?>
                                                        </li>
					<?php
                                            }
                                        }
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
            <td align="center" width='35%'>Dokter</td>
            <td>&nbsp;</td>
            <td align="center" width='30%'>Yang Membuat</td>
        </tr>
        <tr>
			<td align="center" width='35%'><?php echo isset($modSuratPersetujuan->dokter->NamaLengkap) ?  "<u>".$modSuratPersetujuan->dokter->NamaLengkap."</u>" : ""; ?></td>
            <td>&nbsp;</td>
			<td align="center" width='30%'><?php echo isset($modSuratPersetujuan->nama_yangmenyetujui) ?  "<u>".$modSuratPersetujuan->nama_yangmenyetujui."</u>" : ""; ?></td>
        </tr>
		<tr height='100px'>
            <td align="center" width='35%'>Saksi Rumah Sakit</td>
            <td>&nbsp;</td>
            <td align="center" width='30%'>Saksi Pasien</td>
        </tr>
		<tr>
			<td align="center" width='35%'><?php echo isset($modSuratPersetujuan->pegawaisaksi1->NamaLengkap) ?  "<u>".$modSuratPersetujuan->pegawaisaksi1->NamaLengkap."</u>" : ""; ?></td>
            <td align="center" width='35%'></td>
            <td align="center" width='30%'><?php echo isset($modSuratPersetujuan->nama_saksi2) ?  "<u>".$modSuratPersetujuan->nama_saksi2."</u>" : ""; ?></td>
        </tr>
    </table>
</TABLE>