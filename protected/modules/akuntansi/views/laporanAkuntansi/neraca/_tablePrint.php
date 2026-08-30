<style>
	.coler > tbody > tr > td {
		vertical-align: top;
	}
	.coler > tbody > tr > td > .grid-view td, .coler > tbody > tr > td > .grid-view th {
		font-size: 1em !important;
		padding: 2px;
		border: 1px solid black;
	}
        .footer {
            position: relative;
            width: 100%;
            bottom: 0;   
            page-break-inside: avoid;
        }
              
</style>
<table class="col-sm-12 coler " width="100%">
	<tbody>
		<tr>
			<td width="50%">
				<div id="tableLaporan" class="grid-view col-sm-6" style="<?php echo ""; //$layout; ?>">
					<table class="<?php echo $table; ?>">
					  <thead>
						<tr>
						  <th id="tableLaporan_c0">
							  Nama Rekening
						  </th>
						  <th id="tableLaporan_c0" class="span3">
							  Total Saldo
						  </th>
						</tr>
					  </thead>
					  <tbody>
						  <tr>
							  <td colspan="2" style="font-weight: bold; font-style: italic;">AKTIVA</td>
						  </tr>
						  <?php foreach ($detail['aktiva']['det'] as $item): ?>
						  <tr>
							  <td style="font-weight:bold;" colspan="2">&emsp;<?php echo strtoupper($item['nama']); ?></td>
						  </tr>
							  <?php foreach ($item['det'] as $item2): 
								  $v2 = MyFormatter::formatNumberForPrint($item2['total'], 2);
								  if ($item2['total'] < 0) {
									  $v2 = "(".MyFormatter::formatNumberForPrint(abs($item2['total']), 2).")";
								  } ?>
						  <tr>
							  <td>&emsp;&emsp;<?php echo $item2['nama']; ?></td>
							  <td style="text-align: right; padding-right: 80px;"><?php echo $v2; ?></td>
						  </tr>
							  <?php endforeach; ?>
						  <tr>
							  <?php 
							  $v2 = MyFormatter::formatNumberForPrint($item['total'], 2);
							  if ($item['total'] < 0) {
								  $v2 = "(".MyFormatter::formatNumberForPrint(abs($item['total']), 2).")";
							  }
							  ?>
							  <td style="font-weight: bold;">&emsp;&emsp;TOTAL <?php echo strtoupper($item['nama']); ?></td>
							  <td style="font-weight: bold; text-align: right;"><?php echo $v2; ?></td>
						  </tr>
						  <?php endforeach; ?>
						  <tr>
							  <?php 
							  $v2 = MyFormatter::formatNumberForPrint($detail['aktiva']['total'], 2);
							  if ($detail['aktiva']['total'] < 0) {
								  $v2 = "(".MyFormatter::formatNumberForPrint(abs($detail['aktiva']['total']), 2).")";
							  }
							  ?>
							  <td style="font-weight: bold; font-style: italic; text-align: center;">TOTAL AKTIVA</td>
							  <td style="font-weight: bold; font-style: italic; text-align: right;"><?php echo $v2; ?></td>
						  </tr>

					  </tbody>
					</table>
				  </div>
			</td>
			<td>
				<div id="tableLaporan2" class="grid-view col-sm-6" style="<?php echo ""; //$layout; ?>">
				<table class="<?php echo $table; ?>">
				  <thead>
					<tr>
					  <th id="tableLaporan_c0">
						  Nama Rekening
					  </th>
					  <th id="tableLaporan_c0" class="span3">
						  Total Saldo
					  </th>
					</tr>
				  </thead>
				  <tbody>

					  <tr>
						  <td colspan="2" style="font-weight: bold; font-style: italic;">PASSIVA</td>
					  </tr>
					  <?php foreach ($detail['passiva']['det'] as $item): ?>
					  <tr>
						  <td style="font-weight:bold;" colspan="2">&emsp;<?php echo strtoupper($item['nama']); ?></td>
					  </tr>
						  <?php foreach ($item['det'] as $item2): ?>
					  <tr>

						  <?php 
						  $v2 = MyFormatter::formatNumberForPrint($item2['total'], 2);
						  if ($item2['total'] < 0) {
							  $v2 = "(".MyFormatter::formatNumberForPrint(abs($item2['total']), 2).")";
						  }
						  ?>

						  <td>&emsp;&emsp;<?php echo $item2['nama']; ?></td>
						  <td style="text-align: right; padding-right: 80px;"><?php echo $v2; ?></td>
					  </tr>
						  <?php endforeach; ?>
					  <tr>

						  <?php 
						  $v2 = MyFormatter::formatNumberForPrint($item['total'], 2);
						  if ($item['total'] < 0) {
							  $v2 = "(".MyFormatter::formatNumberForPrint(abs($item['total']), 2).")";
						  }
						  ?>

						  <td style="font-weight: bold;">&emsp;&emsp;TOTAL <?php echo strtoupper($item['nama']); ?></td>
						  <td style="font-weight: bold; text-align: right;"><?php echo $v2; ?></td>
					  </tr>
					  <?php endforeach; ?>
					  <tr>

						  <?php 
						  $v2 = MyFormatter::formatNumberForPrint($detail['passiva']['total'], 2);
						  if ($detail['passiva']['total'] < 0) {
							  $v2 = "(".MyFormatter::formatNumberForPrint(abs($detail['passiva']['total']), 2).")";
						  }
						  ?>

						  <td style="font-weight: bold; font-style: italic; text-align: center;">TOTAL PASSIVA</td>
						  <td style="font-weight: bold; font-style: italic; text-align: right;"><?php echo $v2; ?></td>
					  </tr>
				  </tbody>
				</table>
			  </div>
			</td>
		</tr>
	</tbody>       
</table>

<div class="footer">
<table width='100%' style = 'bottom: 0;'>
            <tr>
                <td width='34%'>&nbsp;</td>
                <td width='34%'>&nbsp;</td>
                <td width='31%'>
                    , <?php echo MyFormatter::formatDateTimeForUser($periode);//echo $model->periodeposting_nama;//echo '10 September 2017';//echo MyFormatter::formatDateTimeForUser(date('Y-m-d')); ?><br>                    
                </td>
            </tr>            
            <tr>
                <td>Dibuat Oleh,</td>                
                <td>Mengetahui</td>  
                <td>Menyetujui</td>                
            </tr>                            
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>            
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>   
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>   
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>   
            <tr>
                <td>
                    <?php
                        if (isset($_GET['pegawaiDibuat'])){
                            echo $_GET['pegawaiDibuat'];
                        }
                    ?>               
                </td>                
                <td >                                
                    <?php
                        if (isset($_GET['pegawaiMengetahui'])){
                            echo $_GET['pegawaiMengetahui'];
                        }
                    ?>                   
                </td>
                <td><?php
                        if (isset($_GET['pegawaiMenyetujui'])){
                            echo $_GET['pegawaiMenyetujui'];
                        }
                    ?>                  
                </td>
            </tr>     
            <tr>
                <td>
                    <div style='border-bottom:1px solid #333;width:170px;'></div>
                </td>
                 <td>
                    <div style='border-bottom:1px solid #333;width:170px;'></div>
                </td>
                 <td>
                    <div style='border-bottom:1px solid #333;width:170px;'></div>
                </td>
            </tr>
            <tr>
                <td>                  
                    <?php
                        if (isset($_GET['jabatanDibuat'])){
                            echo $_GET['jabatanDibuat'];
                        }
                    ?>
                </td>
                <td>
                     <?php
                        if (isset($_GET['jabatanMengetahui'])){
                            echo $_GET['jabatanMengetahui'];
                        }
                    ?>
                    
                </td>
                <td>                                                                      
                   <?php
                        if (isset($_GET['jabatanMenyetujui'])){
                            echo $_GET['jabatanMenyetujui'];
                        }
                    ?>
                </td>
            </tr>
</table>
</div>
