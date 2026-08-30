<div id="tableLaporan" class="grid-view">
    <?php $row = $model->getRatio(); 
// echo "<pre>";
// print_r($row);
// exit;
	?>
    <table class="table table-striped table-condensed">
      	<thead>
      		<th width="25px">No.</th>
      		<th>Jenis Rasio</th>
                <th>Rumus</th>
                <th>Perhitungan</th>
      		<th>Nilai</th>
      	</thead>
      	<tbody>
      		<tr>
      			<td style="width: 20px;">1.</td>
      			<td>Cash Ratio</td>
                        <td>
                            Kas dan Setara Kas<br>
                           --------------------------------------- x 100%<br>
                            Kewajiban
                        </td>
                        <td><?php echo number_format($row['kasdansetarakas']);?><br>
                            ----------------- x 100%<br>
                            <?php echo number_format($row['kewajiban']);?>                            
                        </td>
      			<td><?php echo number_format($row['cash_ratio'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>2</td>
      			<td>Quick Ratio</td>
                        <td>
                            Aktiva Lancar - Persediaan<br>
                           --------------------------------------- x 100%<br>
                            Kewajiban
                        </td>
                        <td><?php echo number_format($row['aktivalancar']);?> - <?php echo number_format($row['persediaan']);?><br>
                            ----------------- x 100%<br>
                            <?php echo number_format($row['kewajiban']);?>                            
                        </td>
      			<td><?php echo number_format($row['quick_ratio'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>3</td>
      			<td>Current Ratio</td>
                        <td>
                            Aktiva Lancar<br>
                           --------------------------------------- x 100%<br>
                            Kewajiban
                        </td>
                        <td align="center"><?php echo number_format($row['aktivalancar']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['kewajiban']);?>                            
                        </td>
      			<td><?php echo number_format($row['current_ratio'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>4</td>
      			<td>Solvabilitas Ratio</td>
                         <td>
                            Aktiva<br>
                           --------------------------------------- x 100%<br>
                            Kewajiban
                        </td>
                        <td align="center"><?php echo number_format($row['aktiva']);?><br>
                            ----------------- x 100%<br>
                            <?php echo number_format($row['kewajiban']);?>                            
                        </td>
      			<td><?php echo number_format($row['solvabilitas_ratio'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>5</td>
      			<td>Total Margin</td>
                        <td>
                            Laba/Rugi<br>
                           --------------------------------------- x 100%<br>
                            Pendapatan
                        </td>
                        <td align="center"><?php echo number_format($row['labarugi']);?> - <?php // echo number_format($row['rugi']);?><br>
                            ----------------- x 100%<br>
                            <?php echo number_format($row['pendapatan']);?>                            
                        </td>
      			<td><?php echo number_format($row['total_margin'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>6.</td>
      			<td>Return On Equity</td>
                        <td>
                            Laba/Rugi<br>
                           --------------------------------------- x 100%<br>
                            Ekuitas
                        </td>
                        <td align="center"><?php echo number_format($row['labarugi']);?> - <?php // echo number_format($row['rugi']);?><br>
                            ----------------- x 100%<br>
                            <?php echo number_format($row['ekuitas']);?>                            
                        </td>
      			<td><?php echo number_format($row['return_equity'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>7</td>
      			<td>Debt to Equity Ratio</td>
                        <td>
                            Kewajiban<br>
                           --------------------------------------- x 100%<br>
                            Ekuitas
                        </td>
                        <td align="center"><?php echo number_format($row['kewajiban']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['ekuitas']);?>                            
                        </td>
      			<td><?php echo number_format($row['debt_equity'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>8</td>
      			<td>Liabilities to Total Asset Ratio</td>
                        <td>
                            Kewajiban<br>
                           --------------------------------------- x 100%<br>
                            Aktiva
                        </td>
                        <td align="center"><?php echo number_format($row['kewajiban']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['aktiva']);?>                            
                        </td>
      			<td><?php echo number_format($row['liability_total'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>9</td>
      			<td>Equity to Total Asset Ratio</td>
                        <td>
                            Ekuitas<br>
                           --------------------------------------- x 100%<br>
                            Aktiva
                        </td>
                        <td align="center"><?php echo number_format($row['ekuitas']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['aktiva']);?>                            
                        </td>
      			<td><?php echo number_format($row['equity_total'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>10</td>
      			<td>Inventory Turn Over</td>
                        <td>
                            Pendapatan<br>
                           --------------------------------------- x 100%<br>
                            Persediaan
                        </td>
                        <td align="center"><?php echo number_format($row['pendapatan']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['persediaan']);?>                            
                        </td>
      			<td><?php echo number_format($row['inventory_turn'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>11</td>
      			<td>Receivable Turn Over</td>
                        <td>
                            Pendapatan<br>
                           --------------------------------------- x 100%<br>
                            Piutang
                        </td>
                        <td align="center"><?php echo number_format($row['pendapatan']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['piutang']);?>                            
                        </td>
      			<td><?php echo number_format($row['receivable_turn'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>12</td>
                        <td>Days of Cash on Hand</td>
                        <td>
                            Kas dan Setara Kas + Investasi Lancar<br>
                           --------------------------------------- x 100%<br>
                            (Beban OP + Beban Non Op) / 365
                        </td>
                        <td align="center"><?php echo number_format($row['kasdansetarakas']);?> + <?php echo number_format($row['investasilancar']);?><br>
                            ----------------- x 100%<br>
                            <?php echo number_format($row['beban']);?> + <?php echo number_format($row['bebanpenyusutandanamortisasi']);?> / 365                           
                        </td>
      			<td><?php echo number_format($row['days_cash'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>13</td>
      			<td>Days Revenue In Account Receivable</td>
                        <td>
                            Piutang<br>
                           --------------------------------------- x 100%<br>
                            Pendapatan / 365
                        </td>
                        <td align="center"><?php echo number_format($row['piutang']);?><br>
                            ----------------- x 100%<br>
                            <?php echo number_format($row['pendapatan']);?> / 365                           
                        </td>
      			<td><?php echo number_format($row['days_revenue'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>14</td>
      			<td>Current Asset Turn Over</td>
                        <td>
                            Pendapatan<br>
                           --------------------------------------- x 100%<br>
                            Aktiva Lancar
                        </td>
                        <td align="center"><?php echo number_format($row['pendapatan']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['aktivalancar']);?>                            
                        </td>
      			<td><?php echo number_format($row['current_asset'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>15</td>
      			<td>Fixed Asset Turn Over</td>
                        <td>
                            Pendapatan<br>
                           --------------------------------------- x 100%<br>
                            Aktiva Tetap
                        </td>
                        <td align="center"><?php echo number_format($row['pendapatan']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['aktivatetap']);?>                            
                        </td>
      			<td><?php echo number_format($row['fixed_asset'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>16</td>
      			<td>Total Asset Turn Over</td>
                        <td>
                            Pendapatan<br>
                           --------------------------------------- x 100%<br>
                            Aktiva
                        </td>
                        <td align="center"><?php echo number_format($row['pendapatan']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['aktiva']);?>                            
                        </td>
      			<td><?php echo number_format($row['total_asset'],2,",",".")." %"; ?></td>
      		</tr>
      		<tr>
      			<td>17</td>
      			<td>Average Age of Fixed Asset</td>
                        <td>
                            Akumulasi Penyusutan Aktiva Tetap<br>
                           --------------------------------------- x 100%<br>
                            Beban Penyusutan dan Amortisasi
                        </td>
                        <td align="center"><?php echo number_format($row['akumulasipenyusutanaktivatetap']);?><br>
                            ------------------ x 100%<br>
                            <?php echo number_format($row['bebanpenyusutandanamortisasi']);?>                            
                        </td>
      			<td><?php echo number_format($row['average_age'],2,",",".")." %"; ?></td>
      		</tr>
      	</tbody>
  	</table>
</div>