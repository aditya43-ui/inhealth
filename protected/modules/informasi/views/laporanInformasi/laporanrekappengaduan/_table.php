<style type="text/css">
	.table tr th{
		text-align: center;
	}
	.block-tabel{
		overflow-y: auto;
	}
</style>
<?php
$criteria=new CDbCriteria;
$criteria->addBetweenCondition('DATE(tgl_pengaduan)', $model->tgl_awal, $model->tgl_akhir);
// $criteria->compare('DATE(tgl_estimasi)',$model->tgl_estimasi);
$criteria->select = 'tgl_pengaduan, pasien_id, nama, alamat, jenis_pelayanan, instalasi_tujuan, uraian_keluhan, tindakan_awal, tindakan_lanjut, COUNT(jenis_pelayanan) AS jmljenispel, COUNT(instalasi_tujuan) AS jmlinstalasi, mediapengaduan, namakategori, estimasipenyelesaian, warnakategoripengaduan';
$criteria->group = 'tgl_pengaduan, pasien_id, nama, alamat, jenis_pelayanan, instalasi_tujuan, uraian_keluhan, tindakan_awal, tindakan_lanjut, mediapengaduan, namakategori, estimasipenyelesaian, warnakategoripengaduan';
$criteria->order = 'tgl_pengaduan DESC';
$lapPengaduan = INLaporanrekappengaduanV::model()->findAll($criteria);

$criteriaJenis=new CDbCriteria;
$criteriaJenis->addBetweenCondition('DATE(tgl_pengaduan)', $model->tgl_awal, $model->tgl_akhir);
$criteriaJenis->select = 'jenis_pelayanan, COUNT(jenis_pelayanan) AS jmljenispel';
$criteriaJenis->group = 'jenis_pelayanan';
$JenisPel = INLaporanrekappengaduanV::model()->findAll($criteriaJenis);
$jumlahJenis = count((array)$JenisPel);

$criteriaInstalasi=new CDbCriteria;
$criteriaInstalasi->addBetweenCondition('DATE(tgl_pengaduan)', $model->tgl_awal, $model->tgl_akhir);
$criteriaInstalasi->select = 'instalasi_tujuan, COUNT(instalasi_tujuan) AS jmlinstalasi';
$criteriaInstalasi->group = 'instalasi_tujuan';
$InsTujuan = INLaporanrekappengaduanV::model()->findAll($criteriaInstalasi);
$jumlahInstalasi = count((array)$InsTujuan);

		
?>
<table class="table table-condensed">
	<thead>
		<tr>
			<th rowspan="2">No.</th>
			<th rowspan="2">Tanggal Pengaduan</th>
			<th rowspan="2">Jenis Pengaduan</th>
			<th rowspan="2">Kategori Pengaduan</th>
			<th rowspan="2">Nama</th>
			<th rowspan="2">Alamat</th>
			<th rowspan="2">Uraian Keluhan</th>
			<th colspan="<?php echo $jumlahJenis; ?>">JENIS PELAYANAN</th>
			<th colspan="<?php echo $jumlahInstalasi; ?>">INSTALASI TUJUAN</th>
			<!-- <th rowspan="2">Tgl Estimasi Penyelesaian</th> -->
			<th rowspan="2">Estimasi Penyelesaian</th>
			<th rowspan="2">Tindakan Awal</th>
			<th rowspan="2">Tindakan Lanjut</th>
		</tr>
		<tr>
		<?php
		if($jumlahJenis > 0){
			foreach($JenisPel as $x => $namaJenis){
				echo '<th>';
				echo $namaJenis->jenis_pelayanan;
				echo '</th>';
			}
		}
		else{
			echo '<th>-</th>';
		}
		
		if($jumlahInstalasi > 0){
			foreach($InsTujuan as $y => $namaInst){
				echo '<th>';
				echo $namaInst->instalasi_tujuan;
				echo '</th>';
			}
		}
		else{
			echo '<th>-</th>';
		}
		?>
		</tr>
	</thead>
	<tbody>
	
	<?php
	if(count((array)$lapPengaduan) > 0){
		$no = 1;
		foreach($lapPengaduan as $i => $val){
			echo '<tr style="background-color:'.$val->warnakategoripengaduan.';">';
			echo '<td>'.$no.'</td>';
			echo '<td>'.MyFormatter::formatDateTimeForUser($val->tgl_pengaduan).'</td>';
			echo '<td>'.$val->mediapengaduan.'</td>';
			echo '<td>'.$val->namakategori.'</td>';
			echo '<td>'.$val->nama.'</td>';
			echo '<td>'.$val->alamat.'</td>';
			echo '<td>'.$val->uraian_keluhan.'</td>';
			
			foreach($JenisPel as $j => $nmJenis){
				echo '<td style="text-align:center;">';
				if($nmJenis->jenis_pelayanan == $val->jenis_pelayanan){
				// echo $val->jmljenispel;
					echo ' &#x2713; ';
				}
				else{
					echo '';
				}
				echo '</td>';
			}
			
			foreach($InsTujuan as $k => $nmInst){
				echo '<td style="text-align:center;">';
				if($nmInst->instalasi_tujuan == $val->instalasi_tujuan){
				// echo $val->jmlinstalasi;
					echo ' &#x2713; ';
				}
				else{
					echo '';
				}
				echo '</td>';
			}
			
			echo '<td>'.$val->estimasipenyelesaian.'</td>';
			// echo '<td>'.MyFormatter::formatDateTimeForUser($val->estimasipenyelesaian).'</td>'; // ini bukan tanggal tapi integer
			// echo '<td>'.MyFormatter::formatDateTimeForDb($val->tgl_estimasi).'</td>';
			echo '<td>'.$val->tindakan_awal.'</td>';
			echo '<td>'.$val->tindakan_lanjut.'</td>';
			echo '</tr>';
			$no++;
		}
		
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center;"><b>TOTAL</b></td>';
			foreach($JenisPel as $l => $jmlJenis){
				echo '<td style="text-align:center;"><b>';
//				echo $jmlJenis->jmljenispel;
				INLaporanrekappengaduanV::model()->JumlahDataJenis($jmlJenis->jenis_pelayanan, $model->tgl_awal, $model->tgl_akhir);
				echo '</b></td>';
			}
			foreach($InsTujuan as $m => $jmlInst){
				echo '<td style="text-align:center;"><b>';
//				echo $jmlInst->jmlinstalasi;
				INLaporanrekappengaduanV::model()->JumlahDataIns($jmlInst->instalasi_tujuan, $model->tgl_awal, $model->tgl_akhir);
				echo '</b></td>';
			}
		echo '<td colspan="3"></td>';
		echo '</tr>';
		
	}
	else{
		echo '<tr>';
		echo '<td colspan="12"><span class="empty">Tidak ditemukan hasil.</span></td>';
		echo '</tr>';
	}
	?>
	
	</tbody>
</table>