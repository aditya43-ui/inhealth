<?php
/**
 * menamabah kolom tabel sangat puas dan memperbaiki label
 * RSST-2665
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */

?>
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
$criteria->addBetweenCondition('DATE(tgl_sayhello)', $model->tgl_awal, $model->tgl_akhir);
$criteria->select = 'pendaftaran, tgl_sayhello, nama, tgl_krs, alamat, ruang, diagnosa, kondisi_pasien, ruang, COUNT(ruang) AS jmlruang';
$criteria->group = 'pendaftaran, tgl_sayhello, nama, tgl_krs, alamat, ruang, diagnosa, kondisi_pasien, ruang';
$criteria->order = 'tgl_sayhello DESC';
$lapSayHello = INLaporanrekapsayhelloV::model()->findAll($criteria);

$criteriaRuang=new CDbCriteria;
$criteriaRuang->addBetweenCondition('DATE(tgl_sayhello)', $model->tgl_awal, $model->tgl_akhir);
$criteriaRuang->select = 'ruang, COUNT(ruang) AS jmlruang';
$criteriaRuang->group = 'ruang';
$Ruangan = INLaporanrekapsayhelloV::model()->findAll($criteriaRuang);
$jumlahRuangan = count((array)$Ruangan);
                
                $criteriaSangatPuas=new CDbCriteria;
		$criteriaSangatPuas->addBetweenCondition('DATE(tgl_sayhello)', $model->tgl_awal, $model->tgl_akhir);
		$criteriaSangatPuas->addCondition("kesimpulan = 'SANGAT PUAS'");
		$SangatPuas = INLaporanrekapsayhelloV::model()->findAll($criteriaSangatPuas);
                
		$criteriaPuas=new CDbCriteria;
		$criteriaPuas->addBetweenCondition('DATE(tgl_sayhello)', $model->tgl_awal, $model->tgl_akhir);
		$criteriaPuas->addCondition("kesimpulan = 'PUAS'");
		$Puas = INLaporanrekapsayhelloV::model()->findAll($criteriaPuas);
		
		$criteriaTdkPuas=new CDbCriteria;
		$criteriaTdkPuas->addBetweenCondition('DATE(tgl_sayhello)', $model->tgl_awal, $model->tgl_akhir);
		$criteriaTdkPuas->addCondition("kesimpulan = 'TIDAK PUAS'");
		$TidakPuas = INLaporanrekapsayhelloV::model()->findAll($criteriaTdkPuas);
		
		$criteriaTlp=new CDbCriteria;
		$criteriaTlp->addBetweenCondition('DATE(tgl_sayhello)', $model->tgl_awal, $model->tgl_akhir);
		$criteriaTlp->addCondition("kesimpulan = 'TELP TIDAK DIANGKAT'");
		$TlpTdkDiangkat = INLaporanrekapsayhelloV::model()->findAll($criteriaTlp);
		
?>
<table class="table table-striped table-condensed">
	<thead>
		<tr>
			<th rowspan="2">Tgl. Say Hello</th>
			<th rowspan="2">No.</th>
			<th rowspan="2">Nama</th>
			<th rowspan="2">Tgl. KRS</th>
			<th rowspan="2">Alamat</th>
			<th colspan="<?php echo $jumlahRuangan; ?>">RUANG</th>
			<th rowspan="2">Diagnosa</th>
			<th rowspan="2">Kondisi Pasien Terkini Setelah Opname</th>
		</tr>
		<tr>
		<?php
		if($jumlahRuangan > 0){
			foreach($Ruangan as $x => $namaRuangan){
				echo '<th>';
//				echo INLaporanrekapsayhelloV::model()->getNamaRuangan($namaRuangan->ruang);
				echo $namaRuangan->ruang;
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
	if(count((array)$lapSayHello) > 0){
		$no = 1;
		foreach($lapSayHello as $i => $val){
			echo '<tr>';
			echo '<td>'.MyFormatter::formatDateTimeForUser($val->tgl_sayhello).'</td>';
			echo '<td>'.$no.'</td>';
			echo '<td>'.$val->nama.'</td>';
			echo '<td>'.MyFormatter::formatDateTimeForUser($val->tgl_krs).'</td>';
			echo '<td>'.$val->alamat.'</td>';
			
			foreach($Ruangan as $j => $nmRuangan){
				echo '<td style="text-align:center;">';
				if($nmRuangan->ruang == $val->ruang){
					echo $val->jmlruang;
				}
				else{
					echo '';
				}
				echo '</td>';
			}
			
			echo '<td>'.$val->diagnosa.'</td>';
			echo '<td>'.$val->kondisi_pasien.'</td>';
			echo '</tr>';
			$no++;
		}
		
		echo '<tr>';
		echo '<td colspan="5" style="text-align:center;"><b>JUMLAH</b></td>';
			foreach($Ruangan as $k => $jmlRuang){
				echo '<td style="text-align:center;"><b>';
				echo $jmlRuang->jmlruang;
				echo '</b></td>';
			}
		echo '<td colspan="2"></td>';
		echo '</tr>';
		echo '<tr><td colspan="'.($jumlahRuangan+7).'">KESIMPULAN</td></tr>';
                echo '<tr><td colspan="3" style="text-align:right;">SANGAT PUAS</td><td> : </td><td colspan="'.($jumlahRuangan+3).'">'.count((array)$SangatPuas).'</td></tr>';
		echo '<tr><td colspan="3" style="text-align:right;">PUAS</td><td> : </td><td colspan="'.($jumlahRuangan+3).'">'.count((array)$Puas).'</td></tr>';
		echo '<tr><td colspan="3" style="text-align:right;">TIDAK PUAS</td><td> : </td><td colspan="'.($jumlahRuangan+3).'">'.count((array)$TidakPuas).'</td></tr>';
		echo '<tr><td colspan="3" style="text-align:right;">TELP TIDAK BISA DIHUBUNGI</td><td> : </td><td colspan="'.($jumlahRuangan+3).'">'.count((array)$TlpTdkDiangkat).'</td></tr>';
		
	}
	else{
		echo '<tr>';
		echo '<td colspan="8"><span class="empty">Tidak ditemukan hasil.</span></td>';
		echo '</tr>';
	}
	?>
	
	</tbody>
</table>