<style>
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 7.0cm;
    }
    .content td{
        height: 1.0cm;
		vertical-align: middle;
    }
</style>

<table class="table table-condensed content" border="2" width="50%">
	<tr>
		<td width="18%">Nama</td>
		<td><h4><b>&nbsp; <?php echo $modPendaftaran->pasien->nama_pasien; ?></b></h4></td>
	</tr>
	<tr>
		<td>Umur</td>
		<td><h4><b>&nbsp; <?php echo $modPendaftaran->umur; ?></b></h4></td>
	</tr>
</table>
