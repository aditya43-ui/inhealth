<table width="100%" id ="riwayatrestrain" class = "table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama Serah Terima</th>
						<th>Penjelasan</th>
						<th>Petugas Bank Darah</th>
						<th>Perawat</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				if (!empty($model->monitoringtranfusidarah_id)){
				$modDetail = SerahterimaT::model()->findAllByAttributes(array('monitoringtranfusidarah_id'=>$model->monitoringtranfusidarah_id));
				if (count($modDetail) > 0){
					foreach ($modDetail as $i=>$data){?>
						<tr>
							<td><?= $i+1;?></td>
							<td> <?php echo MyFormatter::formatdatetimeforuser($data->create_time); ?> </td>       
							<td> <?php echo $data->nama_serahterima; ?> </td>       
							<td> <?php echo $data->penjelasan; ?> </td>
							<td> <?php echo $data->petugas_bankdarah; ?> </td>
							<td> <?php echo $data->nama_perawat; ?> </td>     
							
						</tr>
					<?php }
				}}?>
				</tbody>
			</table>