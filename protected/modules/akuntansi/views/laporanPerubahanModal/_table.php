<?php
Yii::app()->clientScript->registerScript('cari cari', "
        $('#search-form').submit(function(){
                $('#tableLaporan').addClass('srbacLoading');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>
<?php
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}
?>
<div id="tableLaporan" class="grid-view">
	<table class="table table-striped table-condensed">
        <thead>
			<?php
			$jmlKolom = 0;
			$jenisWaktus = array();
			$tglKirims = array();
			echo "<tr>";
			echo "<th>Rincian</th>";
			foreach ($dataArray AS $row => $data) {
//				if (count((array)$data) > 1) {
//					if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
//						$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
//						echo "<th style='text-align:center'>";
//						echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal'])));
//						echo "</th>";
//					} else {
//						echo "<th>";
//						echo "</th>";
//					}
//					$jmlKolom ++;
//				} else {
					if (!empty($models) || !empty($data)) {
						$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data;
						echo "<th style='text-align:center'>";
						echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data)));
						echo "</th>";
					} else {
						echo "<th>";
						echo "</th>";
					}
					$jmlKolom ++;
//				}
			}
			echo "</tr>";
			?>
        </thead>
        <tbody>
			<?php
			$criteria = new CDbCriteria;
			$condition1 = "rekening2_id = 6";
			$criteria->addCondition($condition1);
			$criteria->group = 'rekening3_id,nmrekening3';
			$criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
			$criteria->order = 'rekening3_id,nmrekening3';
			$modelLaporan = AKLaporanperubahanmodalV::model()->findAll($criteria);

			$spasi1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$nmrekening3_temp = "";
			$jumlah = 0;
			foreach ($modelLaporan as $key => $rekening3) {
				if ($rekening3->nmrekening3) {
					$totSaldo = $rekening3->jumlah;
					$nmrekening3 = $rekening3->nmrekening3;
					$rekening3_id = $rekening3->rekening3_id;
				} else {
					$nmrekening3 = '-';
				}

				if ($nmrekening3_temp != $nmrekening3) {

					echo "
							<tr>
								<td width='200px;'><b>" . $nmrekening3 . "</b></td>";
					for ($i = 0; $i <= $jmlKolom - 1; $i++) {

						$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanperubahanmodal_v
												WHERE rekening3_id =" . $rekening3_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";

						$result = Yii::app()->db->createCommand($sql)->queryRow();
						echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
					}

//					echo "<td width='150px;' style='text-align:right'><b>" . number_format($rekening3->jumlah) . "</b></td>";
					echo "</tr>
						";
					$jumlah += $rekening3->jumlah;
					$criteria2 = new CDbCriteria;
					$term3 = $nmrekening3;
					if (!empty($periodeposting_id)) {
						$criteria2->addCondition('periodeposting_id =' . $periodeposting_id);
					}
					$condition4 = "nmrekening3 ILIKE '%" . $term3 . "%'";
//					$criteria2->addCondition($condition4);
					$criteria2->limit = -1;
					$criteria2->group = 'rekening3_id,nmrekening3,rekening4_id,nmrekening4';
					$criteria2->select = $criteria2->group . ', sum(jumlah) as jumlah';
					$criteria2->order = 'rekening3_id,nmrekening3,rekening4_id,nmrekening4 ASC';

					$detail = AKLaporanperubahanmodalV::model()->findAll($criteria2);
					foreach ($detail as $key => $rekening4) {

						if ($rekening4->nmrekening4) {
							$nmrekening4 = $rekening4->nmrekening4;
							$rekening4_id = $rekening4->rekening4_id;
						} else {
							$nmrekening4 = '-';
						}

						echo "<tr>
								<td width='200px;'>" . $spasi2 . $rekening4->getNamaRekening() . "</td>";
						
						for ($i = 0; $i <= $jmlKolom - 1; $i++) {

						$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanperubahanmodal_v
												WHERE rekening4_id =" . $rekening4_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";

						$result = Yii::app()->db->createCommand($sql)->queryRow();
						echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
					}
//								<td width='150px;' style='text-align:right'>" . number_format($rekening4->jumlah) . "</td>
					echo "</tr>";
						
						
					}

					$nmrekening3_temp = $nmrekening3;
				}
			}
			?>
			<tr>
				<td style='text-align:right'><b>Saldo Akhir</b></td>
			<?php 
			for ($i = 0; $i <= $jmlKolom - 1; $i++) {

					$sql = "
							SELECT 
							coalesce(sum(jumlah),0) as jumlah
							FROM laporanperubahanmodal_v
							WHERE rekening3_id = $rekening3_id AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";

					$total = Yii::app()->db->createCommand($sql)->queryRow();
					
						echo "<td width='150px;' style='text-align:right'>" . number_format($total['jumlah']) . "</td>";
					
					
				}
			?>
				<!--<td width='150px;' style='text-align:right'><b><?php // echo number_format($jumlah); ?></b></td>-->
			</tr>
		</tbody>
	</table>
</div>