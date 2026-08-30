<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 

$jenis = ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan";
$jenis2 = ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "menyetujui" : "menolak";


?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-align: justify;
    }
    tr, td {
        padding: 7px;
    }
</style>
<TABLE>
    <div>
        <TABLE ALIGN="CENTER">
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Liberation Serif" SIZE=4><U><?php echo strtoupper($modSuratPersetujuan->jenissurat)." TINDAKAN KEDOKTERAN"; ?></U></FONT></B>
                </TD>
            </TR>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        Setelah mendapatkan informasi mengenai tindakan kedokteran, maka Saya yang bertanda tangan dibawah ini :
    </p>
    <p align="justify">
        <table width="100%">
            <tr>
                <td width="200">Nama </td>
                <td width="10">:</td>
                <td><?php echo isset($modSuratPersetujuan->nama_menyetujui) ?  $modSuratPersetujuan->nama_menyetujui : ""; ?></td>
            </tr>
            <tr>
                <td>Umur </td>
                <td>:</td>
				<td><?php echo isset($modSuratPersetujuan->umur_menyetujui) ?  $modSuratPersetujuan->umur_menyetujui : ""; ?> Tahun</td>
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
        <p align="justify">Menyatakan dengan sesungguhnya telah memberi <?php echo $jenis ?> untuk dilakukan tindakan <?php echo $modSuratPersetujuan->tindakanmedis; ?></p>
        <p align="justify">Terhadap <?php echo $modSuratPersetujuan->tindakanterhadap; ?> Saya :</p>
        
        <p>
			<table cellpadding="10" width="100%">
                <tr>
                    <td width="200">Nama</td>
                    <td width="10">:</td>
                    <td><?=$modPasien->nama_pasien?></td>
                </tr>
                <tr>
                    <td>No. Rekam Medis</td>
                    <td>:</td>
                    <td><?=$modPasien->no_rekam_medik?></td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td><?php
                    $umur = explode(" ", $modPendaftaran->umur);

                    echo $umur[0] ?> Tahun</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><?=$modPasien->jeniskelamin ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?=$modPasien->alamat_pasien ?></td>
                </tr>

            </table>
        </p>
        
        <?php 
        
        $informasi = PemberianinformasiT::model()->findByAttributes(array(
            'suratpersetujuantm_id'=>$modSuratPersetujuan->suratpersetujuantm_id
        ));
        
        $is_dokter = false;
        $is_resikotransfusi = false;
        
        if (!empty($informasi)) {
            $jenissurat = JenisSuratM::model()->findByPk($informasi->jenissurat_id);
            if (!empty($jenissurat)) {
                $is_dokter = $jenissurat->is_surat_tindakan_dokter;
                $is_resikotransfusi = $jenissurat->is_surat_tindakan_transfusiresiko;
            }
        }
        
        
        
        ?>
        
        <p>Dan saya menyatakan bahwa: </p>
        <?php if ($is_dokter): ?>
            <p>
                Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko dan 
                komplikasi yang mungkin timbul, disamping itu jika terjadi kecelakaan seperti tertusuknya jarum atau alat tajam pada petugas medis 
                selama berlangsungnya operasi, saya tidak memberikan izin untuk mengambil darah pasien untuk test HIV dan penyakit lainnya yang 
                penularannya adalah melalui darah
            </p>
        <?php endif; ?>
        
        <?php if ($is_resikotransfusi): ?>
            <p>
                <ul>
                    <li>
                        Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko 
                        dan komplikasi yang mungkin timbul.
                    </li>
                    <li>
                        Saya juga menyadari bahwa oleh karena ilmu kedokteran adalah bulan ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah 
                        keniscayaan, melainkan sangat bergnatung pada izi Tuhan Yang Maha Esa.
                    </li>
                </ul>
            </p>
        <?php endif; ?>
        <p>
            Berdasarkan hal-hal tersebut diatas, saya menjamin sepenuhnya bahwa tindakan saya untuk <?php echo $jenis2 ?> tindakan kedokteran di atas adalah 
            untuk mewakili kepentingan saya/pasien dan keluarga pasien dan saya bertanggung jawab sepenuhnya apabila terdpat pihak lain yang 
            mengajukan keberatan atas <?php echo $jenis ?> ini.
            
        </p>
        <p>
            Demikian <?php echo $jenis; ?> ini saya buat dengan penuh kesadaran dan tanpa paksaan pihak manapun.
        </p>
        
        
	<br><br><br><br><br>
	<table width='100%'>
        <tr>
            <td align="center" width='30%'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d', strtotime($modSuratPersetujuan->tglpersetujuan)))
                    ." pukul ".date('H:i:s', strtotime($modSuratPersetujuan->tglpersetujuan)); ?></td>
            <td width='35%'></td>
			<td width='35%'></td>
        </tr>
        <tr height='100px'>
            <td align="center" width='30%'>Yang Membuat Pernyataan,</td>
            <td>&nbsp;</td>
            <td align="center" width='35%'>Dokter,</td>
        </tr>
        <tr>
			<td align="center" width='30%'><?php echo isset($modSuratPersetujuan->nama_yangmenyetujui) ?  "<u>".$modSuratPersetujuan->nama_yangmenyetujui."</u>" : ""; ?></td>
            <td>&nbsp;</td>
			<td align="center" width='35%'><?php echo isset($modSuratPersetujuan->dokter->NamaLengkap) ?  "<u>".$modSuratPersetujuan->dokter->NamaLengkap."</u>" : ""; ?></td>
        </tr>
		<tr height='100px'>
            <td align="center" width='30%'>Saksi Pihak Keluarga,</td>
            <td>&nbsp;</td>
            <td align="center" width='35%'>Saksi Pihak RS,</td>
        </tr>
		<tr>
            <td align="center" width='30%'><?php echo isset($modSuratPersetujuan->nama_saksi2) ?  "<u>".$modSuratPersetujuan->nama_saksi2."</u>" : ""; ?></td>
            <td align="center" width='35%'></td>
			<td align="center" width='35%'><?php echo isset($modSuratPersetujuan->pegawaisaksi1->NamaLengkap) ?  "<u>".$modSuratPersetujuan->pegawaisaksi1->NamaLengkap."</u>" : ""; ?></td>
        </tr>
        <tr>
            <td align="center" width='30%'>No. KTP/SIM <?php echo isset($modSuratPersetujuan->noidentitas_saksi2) ?  "<u>".$modSuratPersetujuan->noidentitas_saksi2."</u>" : ""; ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
