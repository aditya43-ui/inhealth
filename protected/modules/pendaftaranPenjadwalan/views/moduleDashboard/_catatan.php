<div class="row">
	Contoh list catatan
	<div class="list-view">
		<div class="summary">Menampilkan 1-1 dari 1 hasil</div>
		<div class="items">
			<div class="view">
				<b>Tanggal: </b>28 Apr 2014 14:00:00<br>
				<b>Judul: </b>Pendaftaran Pasien<br>
				<b>Deskripsi: </b>Mendaftarkan pasien yang belum di input karena mati lampu<br>
				<b>Status: </b>Sedang<br>
				<b>Tindakan: </b>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Ubah Catatan"><i class="icon-pencil-brown"></i></a>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Hapus Catatan"><i class="icon-form-silang"></i></a><br>
			</div>
			<div class="view">
				<b>Tanggal: </b>28 Apr 2014 15:40:00<br>
				<b>Judul: </b>Memulangkan Pasien<br>
				<b>Deskripsi: </b>Memulangkan Pasien yang belum di pulangkan karena mati lampu<br>
				<b>Status: </b>Belum<br>
				<b>Tindakan: </b>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Ubah Catatan"><i class="icon-pencil-brown"></i></a>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Hapus Catatan"><i class="icon-form-silang"></i></a><br>
			</div>
			<div class="view">
				<b>Tanggal: </b>28 Apr 2014 16:00:00<br>
				<b>Judul: </b>Verifikasi<br>
				<b>Deskripsi: </b>Verifikasi tindakan pasien<br>
				<b>Status: </b>Belum<br>
				<b>Tindakan: </b>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Ubah Catatan"><i class="icon-pencil-brown"></i></a>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Hapus Catatan"><i class="icon-form-silang"></i></a><br>
			</div>
		</div>

	</div>
	<!--<table class="table table-striped table-bordered table-condensed">
		<thead>		
			<tr>
				<th>No.</th>
				<th>Tanggal</th>
				<th>Judul</th>
				<th>Deskripsi</th>
				<th>Status</th>
				<th>Tindakan</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>28 Apr 2014 14:00:00</td>
				<td>Pendaftaran Pasien</td>
				<td>Mendaftarkan pasien yang belum di input karena mati lampu</td>
				<td>Sedang</td>
				<td style="text-align:center;">
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Ubah Catatan"><i class="icon-pencil-brown"></i></a>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Hapus Catatan"><i class="icon-form-silang"></i></a>
				</td>
			</tr>
			<tr>
				<td>2</td>
				<td>28 Apr 2014 15:40:00</td>
				<td>Memulangkan Pasien</td>
				<td>Memulangkan Pasien yang belum di pulangkan karena mati lampu</td>
				<td>Belum</td>
				<td style="text-align:center;">
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Ubah Catatan"><i class="icon-pencil-brown"></i></a>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Hapus Catatan"><i class="icon-form-silang"></i></a>
				</td>
			</tr>
			<tr>
				<td>3</td>
				<td>28 Apr 2014 16:00:00</td>
				<td>Verifikasi</td>
				<td>Verifikasi tindakan pasien</td>
				<td>Belum</td>
				<td style="text-align:center;">
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Ubah Catatan"><i class="icon-pencil-brown"></i></a>
					<a href="javascript:void(0);" rel="tooltip" data-original-title="Hapus Catatan"><i class="icon-form-silang"></i></a>
				</td>
			</tr>
		</tbody>
	</table>-->
	<div class="col-sm-6">
	</div>
	<div class="col-sm-6">
	</div>
	
</div>
<!--Tombol action-->
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Buat Catatan',array('{icon}'=>'<i class="entypo-pencil"></i>')), array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'return false;')); ?>
</div>

