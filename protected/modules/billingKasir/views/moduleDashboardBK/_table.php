<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> 10 Terakhir Pasien Deposit
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

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'table-grid',
            'dataProvider' => $dataTable->searchBayarUangmukaTerakhir(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'No. Pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->pendaftaran->no_pendaftaran',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => '$data->pasien->nama_pasien',
                ),
                array(
                    'header' => 'Tanggal Deposit',
                    'type' => 'raw',
                    'value' => '$data->tgluangmuka',
                ),
                array(
                    'header' => 'Jumlah Uang Muka (Rp)',
                    'type' => 'raw',
                    'value' => function ($data) {
                        $total = $data->jumlahuangmuka;

                        return MyFormatter::formatNumberForPrint($total);
                    },
                    'htmlOptions' => array('style' => 'text-align: right;',),
                    //                        'value'=>'isset($data->jumlahuangmuka)?number_format($data->jumlahuangmuka, 0, " ", "."):0',
                ),
                //            	'pendaftaran.no_pendaftaran',
                //				'pasien.nama_pasien',
                //				'tgluangmuka',
                //				'jumlahuangmuka',
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