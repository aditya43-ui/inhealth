<table width="100%" id ="riwayatrestrain" class = "table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>Waktu Transfusi Dimulai</th>
						<th>Kondisi</th>
						<th>Deskripsi</th>
						<th>Tanda Reaksi</th>
						<th>Waktu Transfusi</th>
						<th>Petugas</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				if (!empty($model->monitoringtranfusidarah_id)){
				$modDetail = TransfusidarahT::model()->findAllByAttributes(array('monitoringtranfusidarah_id'=>$model->monitoringtranfusidarah_id));
				if (count($modDetail) > 0){
					foreach ($modDetail as $i=>$data){?>
						<tr>
							<td> <?php echo $data->waktu_transfusi; ?> </td>       
							<td> <?php  echo $data->kondisi_transfusidarah; ?> </td>
							<td> <?php  echo $data->deskripsi; ?> </td>
							<td> <?php 
									$modTransDet = TransfusidarahdetT::model()->findAllByAttributes(array('transfusidarah_id'=>$data->transfusidarah_id));
									foreach ($modTransDet as $c => $det){
										echo $det->nama_tandareaksi."<br>";
										
									}?>
							</td>
							
							<td> <?php  echo $data->waktu_tranfusi." <br>".$data->jam_transfusi; ?> </td>
							<td> <?php  echo $data->petugas; ?> </td>     
						</tr>
					<?php }
				}}?>
				</tbody>
			</table>