<?php
Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#searchLaporan').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<?php
$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
	
}
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}
?>

<div id="tableLaporan" class="grid-view">
    <div style="max-width:1500px;overflow-x:scroll;">
		<table class="table table-striped table-condensed">
			<thead>
				<?php
				$jmlKolom = 0;
				$jenisWaktus = array();
				$tglKirims = array();
				echo "<tr>";
				echo "<th>Rincian</th>";
				foreach ($dataArray AS $row => $data) {
//					if (count((array)$data) > 1) {
//						if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
//							$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
//							echo "<th style='text-align:center'>";
//							echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal'])));
//							echo "</th>";
//						} else {
//							echo "<th>";
//							echo "</th>";
//						}
//						$jmlKolom ++;
//					} else {
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
//					}
				}
				echo "</tr>";
				?>
			</thead>
			<tbody>
				<?php
				$criteria = new CDbCriteria;
				$criteria->group = 'rekening1_id,nmrekening1,kdrekening1';
				$criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
				$criteria->order = 'rekening1_id,nmrekening1,kdrekening1';
				$modelLaporan = AKLaporanaruskasV::model()->findAll($criteria);
				$spasi1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$spasi4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$nmrekening1_temp = "";
				$totSaldo = 0;
				$labarugi = 0;
				$pendapatan = 0;
				$beban = 0;
				foreach ($modelLaporan as $i => $data) {

					if ($data->nmrekening1) {
						$totSaldo = $data->jumlah;
						$nmrekening1 = $data->nmrekening1;
						$rekening1_id = $data->rekening1_id;
					} else {
						$nmrekening1 = '-';
					}

					if ($nmrekening1_temp != $nmrekening1) {
						if ($data->kdrekening1) {
							$kdrekening1 = $data->kdrekening1;
							$rekening1_id = $data->rekening1_id;
						} else {
							$kdrekening1 = '-';
						}

						echo "
									<tr>
										  <td colspan=2><b><i>" . $nmrekening1 . "</i></b></td>";
						for ($i = 0; $i < $jmlKolom - 1; $i++) {
							echo "<td>";
							echo "</td>";
						}
						echo " </tr>
								";

						$criteria2 = new CDbCriteria;
						$termId1 = $rekening1_id;
						$term1 = $nmrekening1;
						$termKode1 = $kdrekening1;
						if (!empty($periodeposting_id)) {
							$criteria2->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
						}
						$conditionid1 = "rekening1_id = " . $termId1;
						$condition1 = "nmrekening1 ILIKE '%" . $term1 . "%'";
						$conditionKode1 = "kdrekening1 ILIKE '%" . $termKode1 . "%'";
//				$criteria2->addCondition($conditionid1);
//				$criteria2->addCondition($condition1);
//				$criteria2->addCondition($conditionKode1);
						$criteria2->limit = -1;
						$criteria2->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2';
						$criteria2->select = $criteria2->group . ', sum(jumlah) as jumlah';
						$criteria2->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2 ASC';

						$detail1 = AKLaporanaruskasV::model()->findAll($criteria2);
						$nmrekening2_temp = "";
						foreach ($detail1 as $key => $rekening2) {
							if ($rekening2->nmrekening2) {
								$nmrekening2 = $rekening2->nmrekening2;
							} else {
								$nmrekening2 = '-';
							}

							if ($nmrekening2_temp != $nmrekening2) {
								if ($rekening2->kdrekening2) {
									$kdrekening2 = $rekening2->kdrekening2;
								} else {
									$kdrekening2 = '-';
								}

								echo "
									<tr>
										  <td colspan=2><b><i>" . $spasi1 . $nmrekening2 . "</i></b></td>";
								for ($i = 0; $i < $jmlKolom - 1; $i++) {
									echo "<td>";
									echo "</td>";
								}
								echo " </tr>
								";

								$criteria3 = new CDbCriteria;
								$term2 = $nmrekening2;
								$termKode2 = $kdrekening2;
								if (!empty($periodeposting_id)) {
									$criteria3->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
								}
								$condition2 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%'";
								$conditionKode2 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%'";
								$criteria3->addCondition($condition2);
								$criteria3->addCondition($conditionKode2);
								$criteria3->limit = -1;
								$criteria3->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3';
								$criteria3->select = $criteria3->group;
								$criteria3->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3 ASC';

								$detail2 = AKLaporanaruskasV::model()->findAll($criteria3);
								$nmrekening3_temp = "";
								foreach ($detail2 as $key => $rekening3) {
									if ($rekening3->nmrekening3) {
										$nmrekening3 = $rekening3->nmrekening3;
									} else {
										$nmrekening3 = '-';
									}

									if ($nmrekening3_temp != $nmrekening3) {
										if ($rekening3->kdrekening3) {
											$kdrekening3 = $rekening3->kdrekening3;
										} else {
											$kdrekening3 = '-';
										}

										echo "
									<tr>
										  <td colspan=2><b><i>" . $spasi2 . $nmrekening3 . "</i></b></td>";
										for ($i = 0; $i < $jmlKolom - 1; $i++) {
											echo "<td>";
											echo "</td>";
										}
										echo " </tr>
								";

										$criteria4 = new CDbCriteria;
										$term3 = $nmrekening3;
										$termKode3 = $kdrekening3;
										if (!empty($periodeposting_id)) {
											$criteria4->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
										}
										$condition3 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%'";
										$conditionKode3 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%'";
										$criteria4->addCondition($condition3);
										$criteria4->addCondition($conditionKode3);
										$criteria4->limit = -1;
										$criteria4->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4';
										$criteria4->select = $criteria4->group . " ,sum(jumlah) as jumlah";
										$criteria4->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4 ASC';

										$detail3 = AKLaporanaruskasV::model()->findAll($criteria4);
										$nmrekening4_temp = "";

										foreach ($detail3 as $key => $rekening4) {
											if ($rekening4->nmrekening4) {
												$nmrekening4 = $rekening4->nmrekening4;
												$rekening4_id = $rekening4->rekening4_id;
											} else {
												$nmrekening4 = '-';
											}

											if ($nmrekening4_temp != $nmrekening4) {
												if ($rekening4->kdrekening4) {
													$kdrekening4 = $rekening4->kdrekening4;
													$rekening4_id = $rekening4->rekening4_id;
												} else {
													$kdrekening4 = '-';
												}

												echo "
													<tr>
														<td width='200px;'><b>" . $spasi3 . $nmrekening4 . "</b></td>";

												for ($i = 0; $i <= $jmlKolom - 1; $i++) {

													$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanaruskas_v
												WHERE rekening4_id =" . $rekening4_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";

													$result = Yii::app()->db->createCommand($sql)->queryRow();
													echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
												}

												echo "
													</tr>
												";

												$criteria5 = new CDbCriteria;
												$term4 = $nmrekening4;
												$termKode4 = $kdrekening4;
												if (!empty($periodeposting_id)) {
													$criteria5->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
												}
												$condition4 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%' AND nmrekening4 ILIKE '%" . $term4 . "%'";
												$conditionKode4 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%' AND kdrekening4 ILIKE '%" . $termKode4 . "%'";
												$criteria5->addCondition($condition4);
												$criteria5->addCondition($conditionKode4);
												$criteria5->limit = -1;
												$criteria5->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5';
												$criteria5->select = $criteria5->group . ', sum(jumlah) as jumlah';
												$criteria5->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5 ASC';

												$detail4 = AKLaporanaruskasV::model()->findAll($criteria5);
												$nmrekening5_temp = "";
												foreach ($detail4 as $key => $rekening5) {

													if ($rekening5->nmrekening5) {
														$nmrekening5 = $rekening5->nmrekening5;
														$rekening5_id = $rekening5->rekening5_id;
													} else {
														$nmrekening5 = '-';
													}


													echo "
													<tr>
														<td width='200px;'>" . $spasi4 . $nmrekening5 . "</td>";

													for ($i = 0; $i <= $jmlKolom - 1; $i++) {

														$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanaruskas_v
												WHERE rekening5_id =" . $rekening5_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";

														$result = Yii::app()->db->createCommand($sql)->queryRow();
														echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
													}

													echo "
													</tr>
												";
												}

												$nmrekening4_temp = $nmrekening4;
											}
										}

										$nmrekening3_temp = $nmrekening3;
									}
								}

								$nmrekening2_temp = $nmrekening2;
							}
						}

						echo "
							<tr>
									<td style='text-align:right'><b>Total " . $nmrekening1 . "</b></td>";
						for ($i = 0; $i <= $jmlKolom - 1; $i++) {

							$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanaruskas_v
												WHERE rekening1_id =" . $rekening1_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";

							$result = Yii::app()->db->createCommand($sql)->queryRow();
							echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
						}


						echo "
							</tr>
						";

						$nmrekening1_temp = $nmrekening1;
					}
				}
				echo "
							<tr>
									<td><b>Saldo Akhir</b></td>";
				$dateLoop = $tglKirims;
				for ($i = 0; $i <= $jmlKolom - 1; $i++) {
					$total = 0;
					$month = date("m", strtotime($dateLoop[0]['tglperiodeposting_awal']));
					for ($j = 0; $j < $jmlKolom - 1; $j++) {

						$sql = "
							SELECT 
							coalesce(sum(jumlah),0) as jumlah
							FROM laporanaruskas_v
							WHERE date(tglperiodeposting_awal) = '" . $dateLoop[$j]['tglperiodeposting_awal'] . "'";

						$pendapatan = Yii::app()->db->createCommand($sql)->queryRow();
						$total += $pendapatan['jumlah'];
					}

					if ($total < 0) {
						echo "<td width='150px;' style='text-align:right'>(" . number_format(abs($total)) . ")</td>";
					} else {
						echo "<td width='150px;' style='text-align:right'>" . number_format($total) . "</td>";
					}
					array_shift($dateLoop);
				}

				echo "
							</tr>
						";
				?>
			</tbody>
		</table>
    </div>
</div>