<div class="row-fluid">
    <div class="span11">        
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPasienMasukPenunjang,
                'attributes'=>array(
                    array(
                        'name'=>'tglmasukpenunjang',
                        'value'=>MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tglmasukpenunjang),
                    ),
                    'no_masukpenunjang',
                ),
        )); ?>  
		<?php if(count($modHasilPemeriksaan) > 0){ ?>
			<div class="block-tabel">
				<h6>Tabel Pemeriksaan <b>Laboratorium</b></h6>
				<table class='table table-striped table-bordered table-condensed' style="max-width:200px;overflow: scroll;">
					<thead>
						<tr>
							<th>
								No. Registrasi Lab
							</th>
							<th>
								Tgl. Pemeriksaan
							</th>
							<th>
								Nama Pemeriksaan
							</th>
							<th>
								Hasil Pemeriksaan
							</th>
							<th>
								Nilai Rujukan
							</th>

						</tr>
					</thead>
					<tbody>
					<?php
						if(count($modHasilPemeriksaan) > 0){
						foreach ($modHasilPemeriksaan as $key => $detail) {
							$hasilpemeriksaanlab_id = $detail['hasilpemeriksaanlab_id'];
							$pasienmasukpenunjang_id = $detail['pasienmasukpenunjang_id'];

							$modDetailPemeriksaan = LBDetailHasilPemeriksaanLabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $hasilpemeriksaanlab_id));
							$modNoPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id'=> $pasienmasukpenunjang_id));
							foreach ($modDetailPemeriksaan as $key => $datadetail) {
								// echo $datadetail['nilairujukan'];
					?>
						<tr>
							<td><?php echo $modNoPenunjang['no_masukpenunjang'] ?></td>
							<td><?php echo $detail['tglhasilpemeriksaanlab'] ?></td>
							<td><?php echo $datadetail->pemeriksaanlab->daftartindakan->daftartindakan_nama ?></td>
							<td><?php echo $datadetail['hasilpemeriksaan'] ?></td>
							<td><?php echo $datadetail->nilairujukan ?></td>
						</tr>
					<?php
							}
						}
					?>
					<?php }else{ ?>
						<tr>
							<td colspan="5">Data Pemeriksaan Laboratorium tidak ditemukan</td>
						</tr>
					<?php } ?>
					</tbody>

				</table>
			</div>
		<?php } ?>
		<?php if(count($modHasilPemeriksaanRad) > 0){ ?>
			<div class="block-tabel">
				<h6>Tabel Pemeriksaan <b>Radiologi</b></h6>
				<table class='table table-striped table-bordered table-condensed' style="max-width:200px;overflow: scroll;">
					<thead>
						<tr>
							<th>
								No. Registrasi Rad
							</th>
							<th>
								Tgl. Pemeriksaan
							</th>
							<th>
								Nama Pemeriksaan
							</th>
							<th>
								Hasil Pemeriksaan
							</th>
							<th>
								Kesimpulan Hasil
							</th>

						</tr>
					</thead>
					<tbody>
					<?php
						if(count($modHasilPemeriksaanRad) > 0){
						foreach ($modHasilPemeriksaanRad as $key => $detail) {
							$hasilpemeriksaanrad_id = $detail['hasilpemeriksaanrad_id'];
							$pasienmasukpenunjang_id = $detail['pasienmasukpenunjang_id'];

							$modNoPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id'=> $pasienmasukpenunjang_id));
					?>
						<tr>
							<td><?php echo $modNoPenunjang['no_masukpenunjang']; ?></td>
							<td><?php echo $detail['tglpemeriksaanrad']; ?></td>
							<td><?php echo $detail->pemeriksaanrad->daftartindakan->daftartindakan_nama ?></td>
							<td><?php echo $detail['hasil_radiologi']; ?></td>
							<td><?php echo $detail['kesimpulan_hasilrad']; ?></td>
						</tr>
					<?php
						}
					?>
					<?php }else{ ?>
						<tr>
							<td colspan="5">Data Pemeriksaan Laboratorium tidak ditemukan</td>
						</tr>
					<?php } ?>
					</tbody>

				</table>
			</div>
		<?php } ?>
	</div>
</div>