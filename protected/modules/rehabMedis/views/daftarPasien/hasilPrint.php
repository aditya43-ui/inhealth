<?php  $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());?>

<?php  echo $this->renderPartial('application.views.headerReport.headerPrint',array('judulLaporan'=>$judulLaporan)); 
?>

<br>
<table border="0" width="80%" align="center">
<tr>
    <td width="50%" style="vertical-align:top;">
    <table border="0" align="center" style="vertical-align:top;">
        <tr>
            <td width="15%">No. Pendaftaran</td><td width="1%">:</td><td width="33%"><?php echo $masukpenunjang->no_pendaftaran; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pendaftaran</td><td>:</td><td><?php echo substr($masukpenunjang->tgl_pendaftaran,0,-9); ?></td>
        </tr>
        <tr>
            <td>Ruangan</td><td>:</td><td><?php echo $masukpenunjang->ruangan_nama; ?></td>
        </tr>
        <tr>
            <td>No. Hasil Pemeriksaan</td><td>:</td><td><?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemeriksaan</td><td>:</td><td><?php echo substr($masukpenunjang->tglmasukpenunjang,0,-9); ?></td>
        </tr>
    </table>
    </td>
    <td width="50%">
        <table border="0" align="center">
        <tr>
            <td width="12%">No. DMK</td><td width="1%">:</td><td width="36%"><?php echo $masukpenunjang->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td><td>:</td><td><?php echo $masukpenunjang->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td><td>:</td><td><?php echo $masukpenunjang->tanggal_lahir; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td><td>:</td><td><?php echo $masukpenunjang->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Alamat</td><td>:</td><td><?php echo $masukpenunjang->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td>Jenis Penjamin</td><td>:</td><td><?php echo $masukpenunjang->carabayar_nama; ?> / <?php echo $masukpenunjang->penjamin_nama; ?></td>
        </tr>
    </table>
    </td>
</tr>
<tr><td>
<br>
Hasil Pemeriksaan 
</td></tr>
</table>
        <?php 
        if(count((array)$detailHasil) > 0){              
            foreach($detailHasil as $i=>$hasil){     
        ?> 
<div style="border: 1px solid #a1a1a1; width:80%; margin:auto;  page-break-after: auto; padding: 3px;">
    <?php echo ($i+1); ?> &nbsp; <?php echo $hasil->tindakanrm->tindakanrm_nama;?><br>
    Hasil Pemeriksaan :<?php echo $hasil->hasilpemeriksaanrm; ?><br>
    Keterangan : <?php echo $hasil->keteranganhasilrm; ?><br>
</div>
	<?php }} ?>
    
	<table border="0" width="30%" align="right">
		<tr>
			<td align="center">
				<?php 
                if ($masukpenunjang->instalasiasal_id == $masukpenunjang->instalasi_id) {
                    $peg = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
                    if (!empty($peg)) {
                        echo $peg->nama_pegawai;
                    } else {
                        echo "<br><i><b>*Belum ada dokter pemeriksa</b></i><br>";
                    }
                } else if (empty($masukpenunjang->nama_pegawai)){
					echo "<br><i><b>*Belum ada dokter pemeriksa</b></i><br>";
				}else { ?>
				<?php
                $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

                echo $profil->kabupaten->kabupaten_nama.",".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br>
				Dokter Pemeriksa <br><br><br><br><br><br>
				<?php echo $masukpenunjang->gelardokterasal;?>.&nbsp;<?php echo $masukpenunjang->nama_pegawai;?>
				<?php 
				echo "<br>";
				} ?>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
    
