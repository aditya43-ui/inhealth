<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporanPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
    }
    $criteria = new CDbCriteria;
    $criteria->group = 'rekening1_id,nmrekening1,kdrekening1';
    $criteria->select = $criteria->group." ,sum(saldoakhirberjalan) as saldoakhirberjalan";
    $criteria->order = 'rekening1_id,nmrekening1,kdrekening1';
	if(!empty($_GET['AKLaporanlabarugiV']['periodeposting_id']) || $model->periodeposting_id){
		$periodeposting_id = isset($_GET['AKLaporanlabarugiV']['periodeposting_id']) ? $_GET['AKLaporanlabarugiV']['periodeposting_id'] : isset($model->periodeposting_id) ? $model->periodeposting_id : null;
		$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
	}
    $modelLaporan = AKLaporanlabarugiV::model()->findAll($criteria);
?>

<div id="tableLaporan" class="grid-view">
  	<table class="table table-striped table-condensed">
	    <thead>
	      <tr>
	        <th id="tableLaporan_c0">
	          Rincian
	        </th>
	        <th style='text-align:right' id="tableLaporan_c1">
	          Total Nominal
	        </th>
	      </tr>
	    </thead>
	    <tbody>
			<?php
				$spasi1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$spasi4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$nmrekening1_temp = "";
				$totSaldo = 0;
				$labarugi = 0;
				$tot_operasional = 0;
				$tot_non_operasional = 0;
				foreach ($modelLaporan as $i => $data) {
					$beban_operasional = AKLaporanlabarugiV::model()->getLabaRugi($periodeposting_id,$data->rekening1_id,'operasional');
					$beban_non_operasional = AKLaporanlabarugiV::model()->getLabaRugi($periodeposting_id,$data->rekening1_id,'non_operasional');

					$tot_operasional = $beban_operasional;
					$tot_non_operasional = $beban_non_operasional;
					
					if ($data->nmrekening1) {
						$totSaldo = $data->saldoakhirberjalan;
						$nmrekening1 = $data->nmrekening1;
						$rekening1_id = $data->rekening1_id;
					} else {
						$nmrekening1 = '-';
					}
					
					if ($nmrekening1_temp != $nmrekening1) {							
						if ($data->kdrekening1) {
							$kdrekening1 = $data->kdrekening1;
						} else {
							$kdrekening1 = '-';
						}

						echo "
							<tr>
								  <td colspan=2><b><i>" . $nmrekening1 . "</i></b></td>
							</tr>
						";

						$criteria2 = new CDbCriteria;
						$termId1 = $rekening1_id;
						$term1 = $nmrekening1;
						$termKode1 = $kdrekening1;
						if (!empty($periodeposting_id)) {
							$criteria2->addCondition('periodeposting_id =' . $periodeposting_id);
						}
						$conditionid1 = "rekening1_id = ".$termId1;
						$condition1 = "nmrekening1 ILIKE '%" . $term1 . "%'";
						$conditionKode1 = "kdrekening1 ILIKE '%" . $termKode1 . "%'";
						$criteria2->addCondition($conditionid1);
						$criteria2->addCondition($condition1);
						$criteria2->addCondition($conditionKode1);
						$criteria2->limit = -1;
						$criteria2->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2';
						$criteria2->select = $criteria2->group.', sum(saldoakhirberjalan) as saldoakhirberjalan';
						$criteria2->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2 ASC';

						$detail1 = AKLaporanlabarugiV::model()->findAll($criteria2);
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
										  <td colspan=2><b><i>" . $spasi1.$nmrekening2 . "</i></b></td>
									</tr>
								";

								$criteria3 = new CDbCriteria;
								$term2 = $nmrekening2;
								$termKode2 = $kdrekening2;
								if (!empty($periodeposting_id)) {
									$criteria3->addCondition('periodeposting_id =' . $periodeposting_id);
								}
								$condition2 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%'";
								$conditionKode2 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%'";
								$criteria3->addCondition($condition2);
								$criteria3->addCondition($conditionKode2);
								$criteria3->limit = -1;
								$criteria3->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3';
								$criteria3->select = $criteria3->group;
								$criteria3->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3 ASC';

								$detail2 = AKLaporanlabarugiV::model()->findAll($criteria3);
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
												  <td colspan=2><b><i>" . $spasi2.$nmrekening3 . "</i></b></td>
											</tr>
										";

										$criteria4 = new CDbCriteria;
										$term3 = $nmrekening3;
										$termKode3 = $kdrekening3;
										if (!empty($periodeposting_id)) {
											$criteria4->addCondition('periodeposting_id =' . $periodeposting_id);
										}
										$condition3 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%'";
										$conditionKode3 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%'";
										$criteria4->addCondition($condition3);
										$criteria4->addCondition($conditionKode3);
										$criteria4->limit = -1;
										$criteria4->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4';
										$criteria4->select = $criteria4->group." ,sum(saldoakhirberjalan) as saldoakhirberjalan";
										$criteria4->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4 ASC';

										$detail3 = AKLaporanlabarugiV::model()->findAll($criteria4);
										$nmrekening4_temp = "";
										
										foreach ($detail3 as $key => $rekening4) {												
											if ($rekening4->nmrekening4) {
												$nmrekening4 = $rekening4->nmrekening4;
											} else {
												$nmrekening4 = '-';
											}
											
											if ($nmrekening4_temp != $nmrekening4) {												
												if ($rekening4->kdrekening4) {
													$kdrekening4 = $rekening4->kdrekening4;
												} else {
													$kdrekening4 = '-';
												}
												
												echo "
													<tr>
														<td width='200px;'><b>" . $spasi3.$nmrekening4 . "</b></td>
														<td width='150px;' style='text-align:right'><b>" . number_format($rekening4->saldoakhirberjalan) . "</b></td>
													</tr>
												";

												$criteria5= new CDbCriteria;
												$term4 = $nmrekening4;
												$termKode4 = $kdrekening4;
												if (!empty($periodeposting_id)) {
													$criteria5->addCondition('periodeposting_id =' . $periodeposting_id);
												}
												$condition4 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%' AND nmrekening4 ILIKE '%" . $term4 . "%'";
												$conditionKode4 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%' AND kdrekening4 ILIKE '%" . $termKode4 . "%'";
												$criteria5->addCondition($condition4);
												$criteria5->addCondition($conditionKode4);
												$criteria5->limit = -1;
												$criteria5->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5';
												$criteria5->select = $criteria5->group.', sum(saldoakhirberjalan) as saldoakhirberjalan';
												$criteria5->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5 ASC';

												$detail4 = AKLaporanlabarugiV::model()->findAll($criteria5);
												$nmrekening5_temp = "";
												foreach ($detail4 as $key => $rekening5) {	
													
													if ($rekening5->nmrekening5) {														
														$nmrekening5 = $rekening5->nmrekening5;
													} else {
														$nmrekening5 = '-';
													}
													
													
												
													echo "<tr>
														<td width='200px;'>" . $spasi4.$rekening5->getNamaRekening() . "</td>
														<td width='150px;' style='text-align:right'>" . number_format($rekening5->saldoakhirberjalan) . "</td>
													</tr>";
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
									<td style='text-align:right'><b>Total " . $nmrekening1 . "</b></td>
								<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
							</tr>
						";

						$nmrekening1_temp = $nmrekening1;
					}
				}
				
				$labarugi = $tot_operasional - $tot_non_operasional;
				if($labarugi < 0){
					$labarugi = "(".abs($labarugi).")";
				}else{
					$labarugi = $labarugi;
				}
			?>
			<tr>
				<td><b>Laba Rugi</b></td>
				<td width='150px;' style='text-align:right'><?php echo number_format($labarugi,0,"","."); ?></td>
			</tr>
	    </tbody>
    </table>
</div>