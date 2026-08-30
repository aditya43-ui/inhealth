<!--<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title"> 
                            <?php 
//                            if($ruangan_id == Params::RUANGAN_ID_HEMODIALISA){
//                                echo 'Pengantar Permintaan Tindakan Hemodialisa';
//                            }
//                            else{
//                                echo 'Daftar Tindakan Konsultasi Poliklinik';
//                            }
                            ?>
                            
                        </div>
		</div>-->
		<div class="panel-body table-responsive">
			<table class="items table table-bordered table-striped datatable" id="tblListKonsul">
				<thead>
					<tr>
						<th>Ruangan Tujuan</th>
						<th>Uraian Tindakan</th>
						<th hidden>Tarif</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					if(count((array)$model) > 0){
					foreach ($model as $i => $konsul) { ?>
					<tr>
						<td><?php echo $ruangan_nama ?></td>
						<td><?php echo $konsul->daftartindakan->daftartindakan_nama ?></td>
						<td hidden><?php echo MyFormatter::formatNumberForPrint($konsul->harga_tariftindakan); ?></td>
					</tr>
				<?php } ?>
				<?php }else{ ?>
					<tr>
						<td colspan="3">Data tidak ditemukan.</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
<!--</div>-->