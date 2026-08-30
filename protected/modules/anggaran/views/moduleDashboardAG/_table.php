<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Alokasi Anggaran
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
    <div class="panel-body with-table">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'table-grid',
            'dataProvider' => $dataTable->searchDashboard(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'No. Alokasi',
                    'type' => 'raw',
                    'value' => '$data->no_alokasi',
                ),
                array(
                    'header' => 'Tanggal',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglalokasianggaran)',
                ),
                array(
                    'header' => 'Unit Kerja',
                    'type' => 'raw',
                    'value' => '$data->unitkerja->namaunitkerja',
                ),
                array(
                    'header' => 'Nilai Rencana',
                    'type' => 'raw',
                    'value' => '$data->nilairencana',
                ),
                array(
                    'header' => 'Nilai Yang Dialokasikan',
                    'type' => 'raw',
                    'value' => '$data->nilaiygdialokasikan',
                ),
                array(
                    'header' => 'Sisa Anggaran',
                    'type' => 'raw',
                    'value' => '$data->sisaanggaran',
                ),
            ),
        ));
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