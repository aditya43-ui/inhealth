<style>
    
    @page {
/*        margin-top: 12mm;*/
    }
	
	@media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
/*            padding-top:4cm;
            padding-left: 1mm;*/
            height:auto;
			width:100%
        }
    }
    
	.main-tab td {
		vertical-align: top;
	}
	
	.table td, .table th {
		background-color: white !important;
		border: 1px solid black;
	}
	.table {
		border-collapse: collapse;
		border: 1px solid black;
		box-shadow: none;
		
	}
    
    .tab_detail {
        width: 100%;
        color: black;
    }
    
    .tab_detail th, .tab_detail td {
        font-size: 10px;
        padding: 2px;
    }
    
    .tab_detail .row_totals {
        border-top: 1px solid black;
    }
    .tab_detail .row_totals_b {
        text-decoration: underline;
    }
</style>
<table class="tab_detail">
		<tbody>
<?php 
    $gtotal = 0;
    $totalpend = 0;
$totalproject = 0;
$totalop_expenses = 0;
$totalop_keluar = 0;

$total_pendluar = 0;
$total_bebanluar = 0;

 $arrAkhir = array();  
    foreach ($mainlap as $item): 
        if ($item['detail'] == 0) continue;
        ?>
	
            <?php foreach ($item['detail'] as $level1): 
                $stotal = 0;
                ?>
            <tr class="head_blue">
                <td colspan="7"><b><?php echo $level1['kode']." ".$level1['nama']; ?></b></td>
            </tr>
            
            <?php foreach ($level1['detail'] as $level2): 
                $stotal2 = 0;
                ?>
            
            <tr class="head_blue">
                <td colspan="7" class="tab_level2"><b><?php echo $level2['kode']." ".$level2['nama']; ?></b></td>
            </tr>
            
            
            <?php foreach ($level2['detail'] as $level3): 
                
                if ($level3['total'] == 0) {
                    continue;
                }
                
                ?>
            
            <tr>
                <td colspan="6" class="tab_level3" style="font-weight: bold;"><?php echo $level3['kode'].' '.$level3['nama']; ?></td>
                <td style="text-align: right;">
                </td>
            </tr>
            
            
            <?php foreach ($level3['detail'] as $level4): 
                
                if ($level4['total'] == 0) {
                    continue;
                }
                ?>
            
            
            <tr>
                <td colspan="6" class="tab_level4"><?php echo $level4['kode'].' '.$level4['nama']; ?></td>
                <td style="text-align: right;">
                    <?php 
                    if(!empty($level1['jenis'])){
                        if($level1['jenis'] == 'pendapatan'){
                            $totalpend += $level4['total'];
                        }
                        else if($level1['jenis'] == 'project'){
                            $totalproject += $level4['total'];
                        }
                        else if($level1['jenis'] == 'operasional'){
                            $totalop_expenses += $level4['total'];
                        }else if($level1['jenis'] == 'bebanluar'){
                            $totalop_keluar += $level4['total'];
                        }
                    }
                    else{
                        $gtotal += $level4['total'];
                    }
                    
                    if(!empty($level2['jenis'])){
                        if($level2['jenis'] == 'pendapatanluar'){
                            $total_pendluar += $level4['total'];
                        }
                        else if($level2['jenis'] == 'bebanluar'){
                            $total_bebanluar += $level4['total'];
                        }
                    }

                    
                    $stotal += $level4['total'];
                    $stotal2 += $level4['total'];
                    
                    if ($level4['total'] < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($level4['total']), 2).")"; 
                    } else {
                        echo MyFormatter::formatNumberForPrint($level4['total'], 2); 
                    }
                    ?>
                </td>
            </tr>
            
            
            <?php endforeach; ?>
            <?php endforeach; ?>

            <tr class="head_blue foot_total">
                <td colspan="6" class="tab_level2"><?php echo "TOTAL ".$level2['nama']?></td>
                <td style="text-align: right;">
                    <div class="foot_total_2">
                        <?php
                        if ($level2['total'] < 0) {
                            echo "(".MyFormatter::formatNumberForPrint(abs($level2['total']), 2).")"; 
                        } else {
                            echo MyFormatter::formatNumberForPrint($level2['total'], 2); 
                        }
                    ?>
                    </div>
                </td>
            </tr>
            
            <?php endforeach; ?>
            
            <tr class="head_blue foot_total">
                <td colspan="6" ><?php echo "TOTAL ".$level1['nama']?></td>
                <td style="text-align: right;">
                    <div class="foot_total_1">
                    <?php
                    $totalnilai1 = $level1['total'];
                    
                    if($level2['jenis'] == 'pendapatanluar' || $level2['jenis'] == 'bebanluar'){
                        $totalnilai1 = ($total_pendluar - $total_bebanluar);
                    }

                    if ($totalnilai1 < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($totalnilai1), 2).")"; 
                    } else {
                        echo MyFormatter::formatNumberForPrint($totalnilai1, 2); 
                    }
                    ?>
                        </div>
                </td>
            </tr>
            
            <?php endforeach; ?>
            <?php 
             
                if(!empty($item['nama'])){
                   
                    if($item['nama'] == 'Kotor Penjualan'){
                        $gtotal = ($totalpend - $totalproject);
                    }else if($item['nama'] == 'Usaha'){
                        $gtotal = (($totalpend - $totalproject) - $totalop_expenses - $totalop_keluar);
                    }else{
                        $totalSebelum = ((($totalpend - $totalproject) - $totalop_expenses - $totalop_keluar) + ($total_pendluar - $total_bebanluar));

                        if($item['nama'] == 'Bersih Sebelum Pajak'){
                            $arrAkhir[] = array('nama'=>$item['nama'],'total'=> $totalSebelum);
                        }else if($item['nama'] == 'Bersih Setelah Pajak'){
                            $arrAkhir[] = array('nama'=>$item['nama'],'total'=>$totalSebelum);
    
                        }
                    }
                }
                
             ?> 
            <?php if((!empty($item['nama'])) && ($item['nama'] == 'Kotor Penjualan' || $item['nama'] == 'Usaha')){ ?>
            <tr class="head_red foot_total">
                <td colspan="6" style="padding-bottom: 0px;"><?php echo "TOTAL ".strtoupper(($gtotal < 0 ? "Rugi" : "Laba")." ".(isset($item['nama'])?$item['nama']:"")); ?></td>
                <td style="text-align: right; border-bottom: 3px double black; width: 155px; padding-bottom: 0px;font-size:10px;">
                    <?php
                    if ($gtotal < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($gtotal), 2).")"; 
                    } else {
                        echo MyFormatter::formatNumberForPrint($gtotal, 2); 
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>
            
		
<?php endforeach; ?>
<?php if(!empty($arrAkhir)){
            foreach($arrAkhir as $dataAkhir){
                $nilai = 0;
                $nama = "";

            if(!empty($dataAkhir['nama'] == 'Bersih Sebelum Pajak')){
                $nilai = $dataAkhir['total'];
                $nama = $dataAkhir['nama'];
            }else if(!empty($dataAkhir['nama'] == 'Bersih Setelah Pajak')){
                $nilai = $dataAkhir['total'];
                $nama = $dataAkhir['nama'];
            }
                ?>
                <tr class="head_red foot_total">
                <td colspan="6" style="padding-bottom: 0px;"><?php echo "TOTAL ".strtoupper((($nilai) < 0 ? "Rugi" : "Laba")." ".$nama); ?></td>
                <td style="text-align: right; border-bottom: 3px double black; width: 155px; padding-bottom: 0px;">
                    <?php
                    if ($nilai < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($nilai), 2).")";
                    } else {
                        echo MyFormatter::formatNumberForPrint($nilai, 2);
                    }
                    ?>
                </td>
            </tr>
                <?php
            }   
            
            ?>
            <?php } ?> 
</tbody>
	</table>
<?php 


$labarugi = $detail['pendapatan']['total'] - $detail['beban']['total'];
if ($labarugi < 0) {
	$labarugi = "(".MyFormatter::formatNumberForPrint(abs($labarugi), 2).")";
} else {
	$labarugi = MyFormatter::formatNumberForPrint($labarugi, 2);
}
?>



<style>
	.tots td {
		font-weight: bold;
	}
	.tot {
		text-align: right !important;
		font-weight: bold;
		font-style: italic;
	}
	.totlr {
		text-align: right !important;
		font-weight: bold;
		font-style: italic;
		text-decoration: underline;
	}
</style>