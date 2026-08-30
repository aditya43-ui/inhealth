<?php
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');

	$thead = true;
	$tableclass='tabel-akun tabel-akun-2';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
	$colorheader = 'lap-header-akun-2';
	$bghead = '';
    if (isset($caraPrint)){
		$tableclass='tabel-akun tabel-akun-2';

		if ($caraPrint == 'PDF'){
			$thead = false;
			$tableclass='tabel-akun tabel-akun-2-print';
			$colorheader  ='';
			$bghead = 'background-color:#edeff2;';
		}

		$data = $model->searchTable();
	  	if ($caraPrint == "EXCEL"){
				$table = 'ext.bootstrap.widgets.BootExcelGridView';
			}

    } else{
        $data = $model->searchTable();
        $template = "{summary}\n{items}\n{pager}";
    }

?>

<?php
		$data->pagination = false;

		$res = array();
		$kel = array();

		foreach ($data->data as $item) {
			$res[$item['jnspembayar_id']]['id'] = $item["jnspembayar_id"];
			$res[$item['jnspembayar_id']]['nama'] = $item["jnspembayar_nama"].' '.$item["namabank"];
			$res[$item['jnspembayar_id']]['data'][$item['notransaksi']]['notransaksi'][] = $item->attributes;
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
						<td style="text-align:center;" colspan="13"><span class="lap-akun-r1" style="font-size:12px;"><b><?php echo $item['nama']; ?></b></span></td>
					</tr>
					<tr class='<?php echo $colorheader; ?>' >
						<th align='center' width='80px' style="<?php echo $bghead ?>">Tanggal Transaksi</th>
						<th align='center' width='250px' style='<?php echo $bghead ?>'>Jenis Transaksi</th>
						<th align='center' width='100px' style='<?php echo $bghead ?>'>No. Referensi</th>
						<th align='center' width='80px' style='<?php echo $bghead ?>'>Tgl. Jatuh Tempo</th>
						<th align='center' style="text-align:right;width:100px;<?php echo $bghead ?>">Debit</th>
						<th align='center' style="text-align:right;width:100px;<?php echo $bghead ?>">Kredit</th>
						<th align='center' style="text-align:right;width:100px;<?php echo $bghead ?>">Saldo</th>
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
						foreach ($grup['notransaksi'] as $item2):

							$deb = '';
							$kre = '';
							$totDebit += $item2["saldodebit"];
							$totKredit += $item2["saldokredit"];

								$notrans = $item2['notransaksi'];

					?>

							<tr>
								<td style="color:#333;"><?php echo date('d/m/Y H:i:s', strtotime($item2["tglpembayaran"])); ?></td>
								<td><?php echo $item2['jenistransaksi']; ?></td>
								<td style="color:#333;"><?php echo ($item2["nopembayaran"]); ?></td>
								<td style="color:#333;"><?php
										if (!empty($item2["tgljatuhtempo"])){
											echo date("d/m/Y H:i:s", strtotime($item2["tgljatuhtempo"]));
										}
									?></td>
								<td align='right' style="color:#333;"><?php echo $item2["saldodebit"]; ?></td>
								<td align='right' style="color:#333;"><?php echo $item2["saldokredit"]; ?></td>
								<td align='right' style="color:#333;"></td>
							</tr>

						<?php
						$tempo++;
						endforeach;
						$grandDebit += $totDebit;
						$grandKredit += $totKredit;
						?>
							<tr>
								<td style="color:#333;">&nbsp;</td>
								<td style="color:#333;text-align:left;" colspan="3" class="border-sub-abu"><b>Saldo Piutang Pembayaran <?php echo $notrans; ?></b></td>
								<td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo $totDebit; ?></b></td>
								<td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo $totKredit; ?></b></td>
								<td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo 0; ?></b></td>
							</tr>
							<tr>
								<td colspan="7"></td>
							</tr>
					<?php
					}
						$grandSaldo = $grandDebit - $grandKredit;
						$totSeluruhD += $grandDebit;
						$totSeluruhK += $grandKredit;

						if ($grandDebit < 0){
							$grandDebit = "(".abs($grandDebit).")";
						}else{
							$grandDebit = $grandDebit;
						}

						if ($grandKredit < 0){
							$grandKredit = "(".abs($grandKredit).")";
						}else{
							$grandKredit = $grandKredit;
						}

						if ($grandSaldo < 0){
							$grandSaldo = "(".abs($grandSaldo).")";
						}else{
							$grandSaldo = $grandSaldo;
						}
					?>

					<tr class="lap-bottom-akun-2">
						<td style="text-align:left;" colspan="4"><b>Saldo Piutang <?php echo $item['nama'] ?></td>
						<td style="text-align:right"><b><?php echo $grandDebit; ?></b></td>
						<td style="text-align:right"><b><?php echo $grandKredit; ?></b></td>
						<td style="text-align:right"><b><?php echo $grandSaldo; ?></b></td>
					</tr>

					<?php

						if (count((array)$res) == $i){
							$totSeluruhS = $totSeluruhD - $totSeluruhK;

							if ($totSeluruhD < 0){
								$totSeluruhD = "(".abs($totSeluruhD).")";
							}else{
								$totSeluruhD = $totSeluruhD;
							}

							if ($totSeluruhK < 0){
								$totSeluruhK = "(".abs($totSeluruhK).")";
							}else{
								$totSeluruhK = $totSeluruhK;
							}

							if ($totSeluruhS < 0){
								$totSeluruhS = "(".abs($totSeluruhS).")";
							}else{
								$totSeluruhS = $totSeluruhS;
							}
					?>
							<tr>
								<td colspan="13"></td>
							</tr>
							<tr class="lap-bottom-akun-2">
								<td style="text-align:left;" colspan="4"><b>Total Seluruh Jenis Pembayaran</b></td>
								<td style="text-align:right"><b><?php echo $totSeluruhD; ?></b></td>
								<td style="text-align:right"><b><?php echo $totSeluruhK; ?></b></td>
								<td style="text-align:right"><b><?php echo $totSeluruhS; ?></b></td>
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
