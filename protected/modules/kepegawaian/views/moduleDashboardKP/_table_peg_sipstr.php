<div class="panel panel-default">
    <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i> Pegawai yang Akan Habis Masa SIP/STR
                </div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
			<a data-rel="reload" href="#" onclick="refreshTableKontrak();"><i class="entypo-arrows-ccw"></i></a>
		</div>
	</div>
	<div class="panel-body with-table">
		<?php 
		
		$this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'table-kontrak-grid',
            'dataProvider'=>$dataTable->searchDashboardSIPSTRAkhir(),
            'template'=>"{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed table-responsive',
            'columns'=>array(
                    [
                        'name' => 'nomorindukpegawai',
                        'htmlOptions' => [
                            'style' => 'vertical-align:middle;'
                        ]
                    ],
                   [
                        'name' => 'nama_pegawai',
                        'htmlOptions' => [
                            'style' => 'vertical-align:middle;'
                        ]
                    ],
                    [
                        'header' => 'Tgl Akhir SIP/STR',
                        'type'=>'raw',
                        'value' => function($data){
                            $set = '';
                            if (!empty($data->tanggal_str)){
                                $set .= "STR - ".MyFormatter::formatDateTimeForUser($data->masa_str, 'long');
                            }
                            
                            if (!empty($data->tanggal_sip)){
                                if (!empty($set))
                                    $set .= '<br/><hr/>';
                                        
                                $set .= "SIP - ".MyFormatter::formatDateTimeForUser($data->masa_sip, 'long');
                            }
                            
                            return $set;
                        }
                    ]				
            ),
        )); 
    ?>
		
		
		<?php /*
		<table class="table table-bordered table-responsive">
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
function refreshTableKontrak(){
	$.fn.yiiGridView.update('table-kontrak-grid');
}
</script>