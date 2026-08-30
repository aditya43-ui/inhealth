<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> 10 Pencucian/Perawatan Terbaru
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#">
                <i class="entypo-down-open"></i>
            </a>
            <a data-rel="reload" href="#">
                <i class="entypo-arrows-ccw"></i>
            </a>
        </div>
    </div>
    <div class="panel-body with-table table-responsive">

        <?php

        /*$this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'table-grid',
            'dataProvider'=>$dataTable->search10PegawaiBaru(),
            'template'=>"{pager}\n{items}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed table-responsive',
            'columns'=>array(
				'nomorindukpegawai',
				'nama_pegawai',
				'tglditerima',
				// array(
				// 	'header'=>'Tanggal Masuk Penunjang',
				// 	'type'=>'raw',
				// 	'value'=>'$data->tglmasukpenunjang',
				// ),
				// array(
				// 	'header'=>'Nomor Masuk Penunjang',
				// 	'type'=>'raw',
				// 	'value'=>'$data->no_masukpenunjang',
				// ),
				// array(
				// 	'header'=>'Nomor Rekam Medik',
				// 	'type'=>'raw',
				// 	'value'=>'$data->no_rekam_medik',
				// ),
				// array(
				// 	'header'=>'Nama Pasien',
				// 	'type'=>'raw',
				// 	'value'=>'$data->nama_pasien',
				// ),

            ),
        )); */
        ?>

        <?php /*
		<table class="table table-striped table-bordered table-condensed table-responsive">
			<thead>
				<tr>
					<td>No. Pendaftaran</td>
					<td>Tanggal Buat Janji</td>
					<td>Nama Pasien</td>
					<td>Poli Klinik</td>
					<td>Dokter</td>
					<td>Janji Melalui</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($dataTable as $updatePasien){ ?>
				<tr>
					<td><?php echo $updatePasien->no_pendaftaran; ?></td>
					<td><?php echo MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($updatePasien->tgl_pendaftaran))); ?></td>
					<td><?php echo $updatePasien->pasien->nama_pasien; ?></td>
					<td><?php echo $updatePasien->pasien->jeniskelamin; ?></td>
					<td><?php echo $updatePasien->statuspasien; ?></td>
					<td><?php echo $updatePasien->getJumlahKunjungan(); ?> Kali Berkunjung</td>
				</tr>
				<?php } ?>
			</tbody>
		</table> */ ?>
    </div>
</div>

<script type="text/javascript">
    function refreshTable() {
        $.fn.yiiGridView.update('table-grid');
    }
</script>