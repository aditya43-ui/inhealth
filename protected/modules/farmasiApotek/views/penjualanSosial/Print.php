<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>Nama Pengambil</td>
            <td>:</td>
            <td><?php echo isset($modPermohonanOa) ? $modPermohonanOa->pemohon_nama : ""; ?></td>
            
        </tr>
        <tr>
            <td>Nama Instansi</td>
            <td>:</td>
            <td><?php echo isset($modPermohonanOa) ? $modPermohonanOa->permohonanoa_instansi : ""; ?></td>
        </tr>
        <tr>
            <td>No. Surat</td>
            <td>:</td>
            <td><?php echo isset($modPermohonanOa) ? $modPermohonanOa->permohonanoa_nosurat : ""; ?></td>            
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>No.</th>
            <th>Nama Obat</th>
            <th>Jml</th>
            <th style="text-align: left;">Harga</th>  
            <th style="text-align: left;">Jml Harga</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modPenjualanDetail as $i=>$modObat){ 
        ?>
            <tr>
                <td align="center"><?php echo ($i+1); ?></td>
                <td align="center"><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td align="center"><?php echo $modObat->qty_oa; ?></td>
                <td align="left"><?php echo $format->formatUang($modObat->hargasatuan_oa); ?></td>
                <td align="left"><?php 
                    $discount = (($modObat->hargasatuan_oa * $modObat->qty_oa) * ($modObat->discount/100));
                    $subtotal = (($modObat->hargasatuan_oa * $modObat->qty_oa) - $discount);
                    if($subtotal <=0 ){
                        $subtotal = 0;
                    }
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tfoot class="border">
            <tr>
                <td colspan="4" align="center"><b>Total</b></td>
                <td align="left"><?php echo $format->formatUang($total); ?></td>
            </tr>
        </tfoot>
        
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Yang Menerima</div>
            <div style="margin-top:60px;"><?php echo isset($modPermohonanOa) ? $modPermohonanOa->pemohon_nama : ""; ?></div>
        </td>
    </tr>
    </table>
<?php } ?>
