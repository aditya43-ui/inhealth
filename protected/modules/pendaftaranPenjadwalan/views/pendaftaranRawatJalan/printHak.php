<?php 
if (!empty($modPendaftaran)) {
    $nomor_pendaftaran = $modPendaftaran->no_pendaftaran;
    $nama_pasien = $modPendaftaran->pasien->nama_pasien;
    $umur = $modPendaftaran->umur;
    $alamat = $modPendaftaran->pasien->alamat_pasien;

} else if (!empty($modPenjualan->pasienpegawai_id)) {
    $pegpas = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
    if (!empty($pegpas)) {
        $nomor_pendaftaran = "-";
        $nama_pasien = $pegpas->namaLengkap;
        $alamat = $pegpas->alamat_pegawai;
        $umur = CustomFunction::hitungUmur($pegpas->tgl_lahirpegawai, $modPenjualan->tglpenjualan);
    } else {
        $nomor_pendaftaran = "-";
        $nama_pasien = "-";
        $umur = "-";
        $alamat = "-";
    }
} else {
    $nomor_pendaftaran = "-";
    $nama_pasien = "-";
    $umur = "-";
    $alamat = "-";

}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
// echo '<pre>';
// var_dump($modProfilRs);die;?>	 
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>

	.isiHak, .isiKewajiban
	{
		border-collapse: collapse;
		width: 100%;
	} 
	
	.isiHak, .isiKewajiban, td
	{
		/* border: 1px solid gainsboro; */
		padding: 10px;
	}
	
	.isiHak tbody tr:nth-child(even)
	{
		background-color: #ddd;
	}

	.isiKewajiban tbody tr:nth-child(even)
	{
		background-color: #ddd;
	}

	.datatable{
        position: absolute;
        bottom: 30;
        top:220px;
        left: 50%;
    }

	@page{ 
		font-style: "Arial Narrow";
	}
</style>
<table width="100%">
    <tbody>
        <tr>
            <td></td>
            <td align="right" width="50%"><font color="black" face="Liberation Serif">RM 20-1</font> </td>
        </tr>
    </tbody>
</table>
<table width="100%">
    <tbody>
        <tr>
            <td width="100" valign="MIDDLE" align="left" rowspan="2">
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit_2?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="left" colspan=" 9">
                <br>
                <!-- <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br> -->
                <b><font size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b><br>
                <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font><br>
                <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
			<td align="LEFT" colspan="7" style="height: 20px; border-top:1px solid;border-right:1px solid; border-left:1px solid;border-bottom:1px solid;">
                <br>
                <font size="3" color="black" face="Liberation Serif">No RM : <?php echo $modPendaftaran->pasien->no_rekam_medik;?></font><br>
                <font size="3" color="black" face="Liberation Serif">Nama Pasien : <?php echo $nama_pasien;?> <?php if($modPendaftaran->pasien->jeniskelamin == "Laki-Laki"){
                    echo "(L)";
                }else{
                    echo "(P)";
                } ?></font><br>
                <font size="3" color="black" face="Liberation Serif">Tgl. Lahir/Umur  : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)." / ". $modPendaftaran->umur;?></font><br>
                <font size="3" color="black" face="Liberation Serif">NIK : <?php echo $modPendaftaran->pasien->no_identitas_pasien;?></font>
            </td>
        </tr>
        
    </tbody>
</table>
<table width="100%">
	<th align='left' style="font-weight:bold;padding-left:10px;"><br><font style="font-size:17px;"><?php echo $judul_print; ?><br><?php //echo $data->nama_rumahsakit; ?></font></th>
</table>
<br>
<table width="50%" style = "text-align:left;">
	<thead>
		<th align='left' style="font-weight:bold;padding-left:12px;"><p>HAK-HAK PASIEN (Permenkes 69 Tahun 2014)</p></th>
	</thead>
	<tbody>
		<?php 
		$hak = HakpasienM::model()->findAllByAttributes(array(
			'hakpasien_aktif'=>true,
			'kelompok' => "Hak"
		), array(
			'order'=>'hakpasien_urutan'
		));
		
		foreach ($hak as $items) { ?>
			<tr>
				<td><?php echo $items->hakpasien_nama; ?></td>
			</tr>	
		<?php } ?>
	</tbody>
</table>
<table width="50%" style = "text-align:left;" class="datatable">
	<thead>
		<th colspan="2"><p>KEWAJIBAN PASIEN (Permenkes 69 Tahun 2014)</p></th>
	</thead>
	<tbody> 
		<?php 
		$kewajiban = HakpasienM::model()->findAllByAttributes(array(
			'hakpasien_aktif'=>true,
			'kelompok' => "Kewajiban"
		), array(
			'order'=>'hakpasien_urutan'
		));
		
		foreach ($kewajiban as $item) { ?>
			<tr>
				<td colspan="2"><?php echo $item->hakpasien_nama; ?></td>
			</tr>
		<?php } ?>
		<tr> 
			<td colspan="2"   align="justify" valign="middle" style="padding-left:15px;">
				<b>Saya Telah Memebaca</b> dan sepenuhnya setuju dengan setiap pernyataan yang terdapat pada formulir ini dan menandatangani tanpa paksaan dan dengan kesadaran penuh.
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-left:110px;"><br><?php echo Yii::app()->user->getState('kabupaten_nama')?>, <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i'))?></td>
		</tr>
		<tr>
			<td> &nbsp; </td>
		</tr>
		<tr>
			<td> &nbsp; </td>
		</tr>
		<tr>
			<td> &nbsp; </td>
		</tr>
		<tr>
			<td width="20%" style="padding-left:20px;" align="center"><?php echo $nama_pasien ?? "-"; ?><br>( Nama Jelas Pasien/Keluarga )</td>
			<td align="center" width="10%">_____________<br>( Petugas Administrasi )</td>
		</tr>
	</tbody>	
</table>
<!-- <table width="100%" border = "0" style = "text-align:left;" >
    <thead>
        <th width = "25%" style = "padding-left:20px;">
			<br><img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="max-width: 100px; width:100px;"/>
		</th>
        <th align='center' style="font-weight:bold;padding-right:200px;"><br><font style="font-size:17px;"><?php //echo $judul_print; ?><br><?php //echo $data->nama_rumahsakit; ?></font></th>
		
    </thead>
    <tbody>
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">
				<table class="isiHak">
					<thead>
						<th><p>HAK PASIEN</p></th>
					</thead>
					<tbody style="border: 2px solid gainsboro !important">
						<?php 
						//$hak = HakpasienM::model()->findAllByAttributes(array(
						//	'hakpasien_aktif'=>true,
						//	'kelompok' => "Hak"
						//), array(
						//	'order'=>'hakpasien_urutan'
						//));
						//
						//foreach ($hak as $items) { ?>
							<tr>
								<td><?php //echo $items->hakpasien_nama; ?></td>
							</tr>	
						<?php //} ?>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table class="isiKewajiban">
					<thead>
						<th><p>KEWAJIBAN PASIEN</p></th>
					</thead>
					<tbody style="border: 2px solid gainsboro !important"> 
						<?php 
						//$kewajiban = HakpasienM::model()->findAllByAttributes(array(
						//	'hakpasien_aktif'=>true,
						//	'kelompok' => "Kewajiban"
						//), array(
						//	'order'=>'hakpasien_urutan'
						//));
						//
						//foreach ($kewajiban as $item) { ?>
							<tr>
								<td><?php //echo $item->hakpasien_nama; ?></td>
							</tr>
						<?php //} ?>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><br></td>
		</tr>
		<tr>
			<td colspan="2">
				<table align="center">
					<tr>
						<td>
						<div style="text-align: center;">
						Pasien/Keluarga/ <br>
						Penanggung Jawab
						</div>
						</td>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
						<div style="text-align: center;">
							Pemberi Informasi,
						</div>
						</td>
					</tr>
					<tr>
						<td colspan="5"><br><br></td>
					</tr>
					<tr>
						<td>(..............................)</td>
						<td></td>
						<td style="text-align: center;">(&nbsp; <?php //echo $modLogin->nama_pemakai ?? "-"; ?> &nbsp;)</td>
					</tr>
				</table>
			</td>
		</tr>
    </tbody>
</table> -->