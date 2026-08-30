<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLap, 'colspan'=>35));      
?>
<p>&nbsp;</p>
<table class="table border" border="1">
	<tr>
		<th bgcolor="#149900">No</th>
		<th bgcolor="#149900">Ktp</th>
                <th bgcolor="#149900">Nip</th>
		<th bgcolor="#149900">Nama</th>
		<th bgcolor="#149900">Alamat</th>
		<th bgcolor="#149900">Tempat Tgl. Lahir</th>
		<th bgcolor="#149900">Status Perkawinan</th>
		<th bgcolor="#149900">Jenis Kelamin</th>
                <th bgcolor="#149900">Agama</th>
                <th bgcolor="#149900">NPWP</th>
                <th bgcolor="#149900">Kode PTKP</th>
                <th bgcolor="#149900">Unit Kerja</th>
                <th bgcolor="#149900">Kategori Pegawai Asal</th>
                <th bgcolor="#149900">Status</th>
		<th bgcolor="#149900">Pendidikan</th>
		<th bgcolor="#149900">Status Kepergawaian</th>
		<th bgcolor="#149900">Jabatan</th>

		<th bgcolor="#149900">Suku</th>
		<th bgcolor="#149900">Warga Negara</th>
		<th bgcolor="#149900">Kelompok Pegawai</th>
		<th bgcolor="#149900">Jenis Tenaga Medis</th>
		<th bgcolor="#149900">Kelompok Jabatan</th>
		<th bgcolor="#149900">Jenis Waktu Kerja</th>
		<th bgcolor="#149900">Masa Berlaku Surat Tanda Registrasi</th>
		<th bgcolor="#149900">Surat Tanda Registrasi</th>
		<th bgcolor="#149900">Masa Berlaku Surat Izin Praktek</th>
		<th bgcolor="#149900">Surat Izin Praktek</th>
		<th bgcolor="#149900">Masa Berlaku Tenaga Kesehatan</th>
		<th bgcolor="#149900">Masa Berlaku Medis</th>
		<!--<th bgcolor="#149900">No Rekening</th>-->
		<th bgcolor="#149900">Bank</th>
		<!--<th bgcolor="#149900">No. Telp/Hp</th>-->
		<th bgcolor="#149900">Email</th>
		<th bgcolor="#149900">Photo Pegawai</th>

		<th bgcolor="#149900">Mulai Kerja</th>
		<th bgcolor="#149900">Masa Kerja</th>
	</tr>	
	<?php
		$i  = 1;
		foreach ($data as $dt){
			$count = count((array)$dt['pembagian']);
			
			
			$total = 0;
			foreach ($dt['pembagian'] as $dt2){				
	?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $dt2['noidentitas']; ?></td>
					<td><?php echo $dt2['nomorindukpegawai']; ?></td>
					<td><?php echo $dt2['nama']; ?></td>
					<td><?php echo $dt2['alamat']; ?></td>
					<td><?php echo $dt2['ttl']; ?></td>
					<td><?php echo $dt2['statusperkawinan']; ?></td>
					<td><?php echo $dt2['jeniskelamin']; ?></td>
					<td><?php echo $dt2['agama']; ?></td>
					<td><?php echo $dt2['npwp']; ?></td>
					<td><?php echo $dt2['kodeptkp']; ?></td>
					<td><?php echo $dt2['unitkerja']; ?></td>
					<td><?php echo $dt2['kategoripegawaiasal']; ?></td>
					<td><?php echo $dt2['statuskepegawaian']; ?></td>
					<td><?php echo $dt2['pendidikan']; ?></td>
					<td><?php echo $dt2['status']; ?></td>
					<td><?php echo $dt2['jabatan']; ?></td>

					<td><?php echo $dt2['suku_id']; ?></td>
					<td><?php echo $dt2['warganegara_pegawai']; ?></td>
					<td><?php echo $dt2['kelompokpegawai_nama']; ?></td>
					<td><?php echo $dt2['jenistenagamedis_id']; ?></td>
					<td><?php echo $dt2['kelompokjabatan']; ?></td>
					<td><?php echo $dt2['jeniswaktukerja']; ?></td>
					<td><?php echo $dt2['masa_str']; ?></td>
					<td><?php echo $dt2['surattandaregistrasi']; ?></td>
					<td><?php echo $dt2['masa_sip']; ?></td>
					<td><?php echo $dt2['suratizinpraktek']; ?></td>
					<td><?php echo $dt2['masa_tenagasehat']; ?></td>
					<td><?php echo $dt2['masa_medis']; ?></td>
					<td><?php echo $dt2['no_rekening']; ?></td>
					<td><?php //echo $dt2['bank_no_rekening']; ?></td>
					<td><?php //echo $dt2['notelp_pegawai'] / $dt2['nomobile_pegawai']; ?></td>
					<td><?php echo $dt2['alamatemail']; ?></td>
					<td><?php echo $dt2['photopegawai']; ?></td>

					<td><?php echo $dt2['mulaikerja']; ?></td>
					<td><?php echo $dt2['masakerja']; ?></td>
				</tr>
	<?php
				$i++;
			}
	?>				
			
	<?php
		}
	?>
</table>