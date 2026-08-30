<table class="tabel-akun">	
    <tbody>
		<?php 
			$a=1; 
			$totModal = 0;
			foreach ($detail as $rek1)  {  //turunun rekening 1 
			$tot1 = MyFormatter::formatNumberForPrint($rek1['total'],2);
			if ($rek1['total'] < 0){
				$tot1 = "(".MyFormatter::formatNumberForPrint(abs($rek1['total']),2).")";
			}	
			
			
			
			if ($rek1['id'] != 1){
				$totModal += $rek1['total'];
			}
		?>
				<tr>
					<td><span class="lap-akun-r1"><?php echo (($a==1)?'':$turunan1).$rek1['nama'] ?></span></td>
					<td></td>
					<td style='width:10px;'>&nbsp;</td>
					<td style='width:120px;'></td>
				</tr>		
				<?php 
						foreach ($rek1['det'] as $rek4){ //turunan rekening 4 
                            
                            if ($rek4['total'] == 0) {
                                continue;
                            }
                            
							$tot4 = MyFormatter::formatNumberForPrint($rek4['total'],2);
							if ($rek4['total'] < 0){
								$tot4 = "(".MyFormatter::formatNumberForPrint(abs($rek4['total']),2).")";
							}	
				?>
							<tr>
								<td><font class="lap-akun-r4"><?php echo $turunan2.$rek4['nama']; ?></font></td>
								<td></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<?php 
								foreach ($rek4['det'] as $rek5){ //turuenan rekneing 5 
                                    
                                    if ($rek5['total'] == 0) {
                                        continue;
                                    }
                                    
								$tot5 = MyFormatter::formatNumberForPrint($rek5['total'],2);
								if ($rek5['total'] < 0){
									$tot5 = "(".MyFormatter::formatNumberForPrint(abs($rek5['total']),2).")";
								}								
							?>
								<tr>
									<td><font class="lap-akun-det"><?php echo $turunan3.$rek5['kode'].' '.$rek5['nama']; ?></font></td>
									<td></td>
									<td>&nbsp;</td>
									<td style="text-align:right;"><?php echo !empty($rek5['det']) ? "" : $tot5; ?></td>
								</tr>

									<?php 
									if (!empty($rek5['det'])) {
										foreach ($rek5['det'] as $rek6){ //turuenan rekneing 5 
											if ($rek6['total'] == 0) {
												continue;
											}
											
											$tot6 = MyFormatter::formatNumberForPrint($rek6['total'],2);
											if ($rek6['total'] < 0){
												$tot6 = "(".MyFormatter::formatNumberForPrint(abs($rek6['total']),2).")";
											}								
									?>
											<tr>
												<td><font class="lap-akun-det"><?php echo $turunan4.$rek6['kode'].' '.$rek6['nama']; ?></font></td>
												<td></td>
												<td>&nbsp;</td>
												<td style="text-align:right;"><?php echo $tot6; ?></td>
											</tr>
									<?php }
									} ?>

							<?php } ?>
							<tr>
								<td><span class="lap-akun-subtotal"><?php echo $turunan3.'Total '.$rek4['nama']; ?></span></td>
								<td></td>
								<td>&nbsp;</td>
								<td class="border-sub" style="text-align:right;"><font class="lap-akun-subtotal"><?php echo $tot4; ?></font></td>
							</tr>
				<?php } ?>
				<tr>
					<td><font class="lap-akun-r1"><?php echo 'Total '.$rek1['nama'] ?></font></td>
					<td></td>
					<td class="border-sub">&nbsp;</td>
					<td class="border-sub" style="text-align:right;"><font class="lap-akun-r1"><?php echo $tot1; ?></font></td>
				</tr>					
		<?php $a++; } 
			$grand = MyFormatter::formatNumberForPrint($totModal,2);
			if ($totModal < 0){
				$grand = "(".MyFormatter::formatNumberForPrint(abs($totModal),2).")";
			}	

		?>
				<tr>
					<td><font class="lap-akun-grandtotal"><?php echo 'Total Kewajiban dan Modal ' ?></font></td>
					<td></td>
					<td class="border-sub">&nbsp;</td>
					<td class="border-sub" style="text-align:right;"><font class="lap-akun-grandtotal"><?php echo $grand; ?></font></td>
				</tr>	
	</tbody>
</table>
