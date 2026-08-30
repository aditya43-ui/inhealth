<style>

    .tab_laporan {
        width: 100%;
        margin-top: 10px;
    }
    
    .tab_laporan td, .tab_laporan th {
        color: black;
        padding: 2px;
    }
    
    .tab_laporan thead th {
        font-weight: bold;
        text-align: center;
        border : none;
        display: none;
    }
    
    
    .tab_laporan tfoot td, .tab_laporan .footie td {
        text-decoration: underline;
        font-weight: bold;
    }
    
</style>

<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
	$tableCss = 'tab_laporan';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
		
		$padd = 'paddingtext2';
		if ($caraPrint == "PDF"){
           // $table = 'ext.bootstrap.widgets.BootGridViewPDF';
			$padd = '';
		}
		$tableCss = 'tab_laporan '.$padd;
    } else{
        $data = $model->searchPrint();
         $template = "{items}";
    }
?>

<?php 
$res = array();
foreach ($data->data as $item) {
    
    if (empty($res[$item->jurnalrekening_id])) {
        $res[$item->jurnalrekening_id] = array(
            'info'=>$item->infoJurnal,
            'detail'=>array(),
        );
        
    }
    $res[$item->jurnalrekening_id]['detail'][] = $item;
    
} ?>

<table class="tab_laporan"> 
            
    <tbody>     
        <tr>
            <td colspan="2"></td>
            <td style="text-align:right;">D</td>
            <td style="text-align:right;">K</td>
        </tr>
        <?php foreach ($res as $item): ?>
        <tr>
            <td colspan="4" style="font-weight: bold;border-top:1px solid #333;"><?php echo $item['info']; ?></td>
        </tr>
        <?php 
            $c = 1;
            foreach ($item['detail'] as $item2):                
            ?>
        <tr>
            <td style="width: 2cm;"></td>
            <td><?php 
                    echo $item2->kdrekeninglast.' - '.$item2->nmrekeninglast;
                    //echo $item2->getKodeRekening($item2->jurnalposting_id)." - ".$item2->getNamaRekening($item2->jurnalposting_id); 
            ?></td>
            <td style="text-align: right;" nowrap><?php echo $item2->saldodebit == 0 ? null : MyFormatter::formatNumberForPrint($item2->saldodebit, 2); ?></td>
            <td style="text-align: right;" nowrap><?php echo $item2->saldokredit == 0 ? null : MyFormatter::formatNumberForPrint($item2->saldokredit, 2); ?></td>
        </tr>
        <?php $c++; endforeach; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="4"  style="border-top:1px solid #333;"></td>
        </tr>
        <tr class="footie">
            <td style="color: maroon" colspan="2">TOTAL SALDO</td>
            <td style="width: 150px; color: maroon; text-align: right; border-top: 1px solid black;" nowrap><?php echo $model->getTotal('saldodebit', $data); ?></td>
            <td style="width: 150px; color: maroon; text-align: right; border-top: 1px solid black;" nowrap><?php echo $model->getTotal('saldokredit', $data); ?></td>
        </tr>
    </tbody>
</table>
<?php if (isset ($caraPrint)){ ?>
 
<?php }?>
</style>

