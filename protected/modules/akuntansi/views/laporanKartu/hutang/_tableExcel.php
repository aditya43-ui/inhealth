<?php
	//set_time_limit(0);
	//ini_set("memory_limit","-1");
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');

	$thead = true;
	$tableclass='tabel-akun tabel-akun-2';
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
	$colorheader = 'lap-header-akun-2';
	$bghead = '';
    if (isset($caraPrint)){
//        $data = $model->searchTablePrint();
//        $template = "{items}";
//        $sort = false;
		$tableclass='tabel-akun tabel-akun-2';

		if ($caraPrint == 'PDF'){
			$thead = false;
			$tableclass='tabel-akun tabel-akun-2-print';
			$colorheader  ='';
			$bghead = 'background-color:#edeff2;';
		}

		$data = $model->searchTable();
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
        $template = "{summary}\n{items}\n{pager}";
    }

	//var_dump($tableClass);
?>

<?php
    //if(isset($caraPrint)){
		$data->pagination = false;

		$res = array();
		$kel = array();

		foreach ($data->data as $item) {
			$res[$item['supplier_id']]['id'] = $item["supplier_id"];
			$res[$item['supplier_id']]['nama'] = $item["supplier_nama"];
			$res[$item['supplier_id']]['data'][$item['ref_id']]['ref_id'][] = $item->attributes;
		}
?>
<style>
	.head_rek td {
		font-weight: bold;
	}
	.num {
		text-align: right !important;
	}
</style>

	<?php
		$i = 1;
		$totSeluruhD = 0;
		$totSeluruhK = 0;
		$totSeluruhS = 0;
		foreach ($res as $kd=>$item) :

	?>

			<table class="<?php echo $tableClass ?>" width="100%">
				<thead>
					<tr>
						<td style="text-align:center;" colspan="13"><span class="lap-akun-r1" style="font-size:12px;"><b><?php echo $item['nama']; ?> (IDR)</b></span></td>
					</tr>
					<tr class='<?php echo $colorheader; ?>' >
						<th bgcolor='#edeff2' align='left' width='40px' style="<?php echo $bghead ?>">Tanggal</th>
						<th bgcolor='#edeff2' align='center' width='20px' style='<?php echo $bghead ?>'>Jenis Transaksi</th>
						<th bgcolor='#edeff2' align='left'  style='<?php echo $bghead ?>'>No. Referensi</th>
						<th bgcolor='#edeff2' align='left' style='<?php echo $bghead ?>'>Jatuh Tempo</th>
						<th bgcolor='#edeff2' width="10px" style="<?php echo $bghead ?>"></th>
						<th bgcolor='#edeff2' align='center' width="70px" style="<?php echo $bghead ?>">Mata Uang</th>
						<th bgcolor='#edeff2' width="10px" style="<?php echo $bghead ?>"></th>
						<th bgcolor='#edeff2' width="10px" style='<?php echo $bghead ?>'></th>
						<th bgcolor='#edeff2' align='right' style="text-align:right;width:100px;<?php echo $bghead ?>">Debit</th>
						<th bgcolor='#edeff2' width="1px" style='<?php echo $bghead ?>'></th>
						<th bgcolor='#edeff2' align='right' style="text-align:right;width:100px;<?php echo $bghead ?>">Kredit</th>
						<th bgcolor='#edeff2' width="1px" style='<?php echo $bghead ?>'></th>
						<th bgcolor='#edeff2' align='right' style="text-align:right;width:100px;<?php echo $bghead ?>">Saldo</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$grandDebit = 0;
					$grandKredit = 0;
					$grandSaldo = 0;
					foreach($item['data'] as $grup){

						$notrans = '';
						$totKredit = 0;
						$totDebit = 0;
						$saldo = 0;
						$tempo = 1;
						foreach ($grup['ref_id'] as $item2):
						//	$psaldo = MyFormatter::formatNumberForPrint($saldo, 2);
						//	if ($saldo < 0){
						//		$psaldo = "(".MyFormatter::formatNumberForPrint(abs($saldo), 2).")";
						//	}

							$deb = '';
							$kre = '';

							if ($item2['debitkredit'] == 'K'){
								$kre = $item2['nilaitransaksi'];

								$totKredit += $kre;

								if ($kre < 0){
									$kre = "(".MyFormatter::formatNumberForPrint(abs($kre),2).")";
								}else{
									$kre = MyFormatter::formatNumberForPrint(($kre),2);
								}


							}elseif ($item2['debitkredit'] == 'D'){
								$deb = $item2['nilaitransaksi'];

								$totDebit += $deb;

								if ($deb < 0){
									$deb = "(".MyFormatter::formatNumberForPrint(abs($deb),2).")";
								}else{
									$deb = MyFormatter::formatNumberForPrint(($deb),2);
								}

								$notrans = $item2['notransaksi'];
							}

					?>

							<tr>
								<td style="color:#333;"><?php echo date('d/m/Y', strtotime($item2["tgltransaksi"])); ?></td>
								<td><?php echo isset($item2['jenistransaksi'])?$item2['jenistransaksi']:''; ?></td>
								<td style="color:#333;"><?php echo ($item2["notransaksi"]); ?></td>
								<td style="color:#333;">
								<?php
									if ($tempo == 1){
										if (!empty($item2["tgljatuhtempo"])){
											echo date("d/m/Y", strtotime($item2["tgljatuhtempo"]));
										}
									}
									?>
								</td>
								<th>&nbsp;</th>
								<td style="color:#333;text-align: center;">IDR</td>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<td align='right' style="color:#333;"><?php echo $deb; ?></td>
								<th>&nbsp;</th>
								<td align='right' style="color:#333;"><?php echo $kre; ?></td>
								<th>&nbsp;</th>
								<td align='right' style="color:#333;"><?php //echo $psaldo; ?></td>
							</tr>

						<?php
						$tempo++;
						endforeach;
							$saldo = $totDebit - $totKredit;
							$grandDebit += $totDebit;
							$grandKredit += $totKredit;

							if ($totKredit < 0){
								$totKredit = "(".MyFormatter::formatNumberForPrint(abs($totKredit),2).")";
							}else{
								$totKredit = MyFormatter::formatNumberForPrint(($totKredit),2);
							}

							if ($totDebit < 0){
								$totDebit = "(".MyFormatter::formatNumberForPrint(abs($totDebit),2).")";
							}else{
								$totDebit = MyFormatter::formatNumberForPrint(($totDebit),2);
							}

							if ($saldo < 0){
								$saldo = "(".MyFormatter::formatNumberForPrint(abs($saldo),2).")";
							}else{
								$saldo = MyFormatter::formatNumberForPrint(($saldo),2);
							}
						?>
							<tr>
								<td style="color:#333;">&nbsp;</td>
								<td >&nbsp;</td>
								<td style="color:#333;text-align:left;" colspan="2" class="border-sub-abu"><b>Saldo Faktur <?php echo $notrans.' :' ?></b></td>
								<td >&nbsp;</td>
								<td style="color:#333;text-align: center;" class="border-sub-abu"><b>IDR</b></td>
								<td >&nbsp;</td>
								<td ></td>
								<td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo $totDebit; ?></b></td>
								<td >&nbsp;</td>
								<td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo $totKredit; ?></b></td>
								<td >&nbsp;</td>
								<td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo $saldo; ?></b></td>
							</tr>
							<tr>
								<td colspan="11"></td>
							</tr>
					<?php
					}
						$grandSaldo = $grandDebit - $grandKredit;
						$totSeluruhD += $grandDebit;
						$totSeluruhK += $grandKredit;

						if ($grandDebit < 0){
							$grandDebit = "(".MyFormatter::formatNumberForPrint(abs($grandDebit),2).")";
						}else{
							$grandDebit = MyFormatter::formatNumberForPrint(($grandDebit),2);
						}

						if ($grandKredit < 0){
							$grandKredit = "(".MyFormatter::formatNumberForPrint(abs($grandKredit),2).")";
						}else{
							$grandKredit = MyFormatter::formatNumberForPrint(($grandKredit),2);
						}

						if ($grandSaldo < 0){
							$grandSaldo = "(".MyFormatter::formatNumberForPrint(abs($grandSaldo),2).")";
						}else{
							$grandSaldo = MyFormatter::formatNumberForPrint(($grandSaldo),2);
						}
					?>

					<tr class="lap-bottom-akun-2">
						<td bgcolor='#c2c4c6' style="text-align:left;" colspan="4"><b>Saldo Supplier <?php echo $item['nama'] ?>:</td>
						<td bgcolor='#c2c4c6'>&nbsp;</td>
						<td bgcolor='#c2c4c6' style='text-align:center;'><b>IDR</td>
						<td bgcolor='#c2c4c6'>&nbsp;</td>
						<td bgcolor='#c2c4c6'>&nbsp;</td>
						<td bgcolor='#c2c4c6' style="text-align:right"><b><?php echo $grandDebit; ?></b></td>
						<td bgcolor='#c2c4c6'>&nbsp;</td>
						<td bgcolor='#c2c4c6' style="text-align:right"><b><?php echo $grandKredit; ?></b></td>
						<td bgcolor='#c2c4c6'>&nbsp;</td>
						<td bgcolor='#c2c4c6' style="text-align:right"><b><?php echo $grandSaldo; ?></b></td>
					</tr>

					<?php

						if (count((array)$res) == $i){
							$totSeluruhS = $totSeluruhD - $totSeluruhK;

							if ($totSeluruhD < 0){
								$totSeluruhD = "(".MyFormatter::formatNumberForPrint(abs($totSeluruhD),2).")";
							}else{
								$totSeluruhD = MyFormatter::formatNumberForPrint(($totSeluruhD),2);
							}

							if ($totSeluruhK < 0){
								$totSeluruhK = "(".MyFormatter::formatNumberForPrint(abs($totSeluruhK),2).")";
							}else{
								$totSeluruhK = MyFormatter::formatNumberForPrint(($totSeluruhK),2);
							}

							if ($totSeluruhS < 0){
								$totSeluruhS = "(".MyFormatter::formatNumberForPrint(abs($totSeluruhS),2).")";
							}else{
								$totSeluruhS = MyFormatter::formatNumberForPrint(($totSeluruhS),2);
							}
					?>
							<tr>
								<td colspan="13"></td>
							</tr>
							<tr class="lap-bottom-akun-2">
								<td bgcolor='#c2c4c6' style="text-align:left;" colspan="4"><b>Total Seluruh Supplier :</b></td>	
								<td bgcolor='#c2c4c6'>&nbsp;</td>
								<td bgcolor='#c2c4c6' style='text-align:center;'><b>IDR</b></td>
								<td bgcolor='#c2c4c6'>&nbsp;</td>
								<td bgcolor='#c2c4c6'>&nbsp;</td>
								<td bgcolor='#c2c4c6' style="text-align:right"><b><?php echo $totSeluruhD; ?></b></td>
								<td bgcolor='#c2c4c6'>&nbsp;</td>
								<td bgcolor='#c2c4c6' style="text-align:right"><b><?php echo $totSeluruhK; ?></b></td>
								<td bgcolor='#c2c4c6'>&nbsp;</td>
								<td bgcolor='#c2c4c6' style="text-align:right"><b><?php echo $totSeluruhS; ?></b></td>
							</tr>
					<?php
						}

					?>
				</tbody>
			</table>
	<?php
		$i++;
		endforeach;
	?>
