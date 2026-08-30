<?php 
// $model2 = $model;
?>
<?php //print_r($modDetail); ?>
<?php
        if($data['filter'] == 'rekap'){
?>
<div id="rekapKas">
    <div style="<?php echo $rim; ?>">
        <table style="width:100%" border="1">
            <thead>
                <tr style="height:30px;">
                    <th rowspan="2" style="text-align:center">NO</th>
                    <th rowspan="2" style="text-align:center">URAIAN</th>
                    <th colspan="3" style="text-align:center">PENERIMAAN KAS</th>
                    <th rowspan="2" style="text-align:center">BERSYARAT<br/>PIUTANG BARU</th>
                </tr>
                <tr style="height:30px;">
                    <th style="text-align:center">TUNAI</th>
                    <th style="text-align:center">PIUTANG</th>
                    <th style="text-align:center">TOTAL</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                    foreach($model as $i=>$data){
                        $totaltunai += $data->jumlahuang;
                        $totalpiutang += $data->piutang;
                        $total += $data->total;
                        $totalpiutangbaru += $data->totalpengeluaran;
                        $saldo += $data->total - $data->totalpengeluaran;
                        $id = $data->closingkasir_id;
                ?>
                <tr>
                    <td style="text-align:center"><?php echo ($i+1); ?></td>
                    <td style="text-align:center"><?php echo $data->keterangan_closing ?></td>
                    <td style="text-align:right"><?php echo number_format($data->jumlahuang);?></td>
                    <td style="text-align:right"><?php echo number_format($data->piutang);?></td>
                    <td style="text-align:right"><?php echo number_format($data->total);?></td>
                    <td style="text-align:right"><?php echo number_format($data->totalpengeluaran);?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align:RIGHT" colspan="2">JUMLAH</td>
                    <td style="text-align:RIGHT"><?php echo number_format($totaltunai); ?></td>
                    <td style="text-align:right"><?php echo number_format($totalpiutang);?></td>
                    <td style="text-align:right"><?php echo number_format($total);?></td>
                    <td style="text-align:right"><?php echo number_format($totalpengeluaran);?></td>
                </tr>
            </tfoot>
            
        </table>
    <?php 
        
//        $this->widget($table,array(
//            'id'=>'laporankasharianlab-grid',
//            'dataProvider'=>$dataProvider,
//            'enableSorting'=>$sort,
//            'template'=>$template,
//                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//             'mergeHeaders'=>array(
//                    array(
//                        'name'=>'<center>PENERIMAAN KAS</center>',
//                        'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                        'start'=>2, //indeks kolom 3
//                        'end'=>4, //indeks kolom 4
//                    ),
//                ),
//                'columns'=>array(
//                    array(
//                        'header' => 'No',
//                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
//                        'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;font-style:italic;'),
//                        'footer'=>'JUMLAH',
//                    ),
//                    array(
//                      'header'=>'<center>URAIAN</center>',
//                      'type'=>'raw',
//                      'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                      'value'=>'(empty($data->closingkasir_id) ? "-" : "$data->closingkasir_id" )',
//                    ),
//                    array(
//                      'header'=>'<center>TUNAI</center>',
//                      'name'=>'jumlahuang',
//                      'type'=>'raw',
////                      'htmlOptions'=>array('style'=>'text-align:right;'),
//                      'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                      'footer'=>'sum(jumlahuang)',
//                      'value'=>'(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang))',
//                      'htmlOptions'=>array(
//                          'style'=>'text-align:right',
//                      ),
//                    ),
//                    array(
//                      'header'=>'<center>PIUTANG</center>',
//                      'name'=>'piutang',
//                      'type'=>'raw',
//                      'value'=>'(empty($data->piutang) ? "0" : number_format($data->piutang))',
//                      'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                      'footer'=>'sum(piutang)',
////                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
//                      'htmlOptions'=>array(
//                          'style'=>'text-align:right',
//                      ),
//                    ),
//                    array(
//                      'header'=>'<center>TOTAL</center>',
//                      'name'=>'total',
//                      'type'=>'raw',
//                      'value'=>'(empty($data->total) ? "0" : number_format($data->total) )',
//                      'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                      'footer'=>'sum(total)',
////                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
//                      'htmlOptions'=>array(
//                          'style'=>'text-align:right',
//                      ),
//                    ),
//                    array(
//                      'header'=>'<center>BERSYARAT <br/> PIUTANG BARU</center>',
//                      'name'=>'totalpengeluaran',
//                      'type'=>'raw',
//                      'value'=>'(empty($data->totalpengeluaran) ? "0" : number_format($data->totalpengeluaran))',
//                      'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                      'footer'=>'sum(totalpengeluaran)',
////                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
//                      'htmlOptions'=>array(
//                          'style'=>'text-align:right',
//                      ),
//                    ),
//                ),
//                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//        )); 
        ?>
    </div>
    <br/><br/>
    <div>
        <table style="max-width:300px;align:center;font-size:14px;font-family:tahoma;margin-left:250px;">
            <tr>
                <td style="text-align:right;"> Pendapatan (Tunai) </td>
                <td style='border-bottom:0px solid #000000;margin-left:50px; border-radius:2px;padding:2px;float:right;text-align:right;'> <?php echo number_format($total); ?></td>
            </tr>
            <tr>
                <td style="text-align:right;"> (Piutang)</td>
                <td style='border-bottom:1px solid #000000; border-radius:2px;padding:2px;'><div style='border-bottom:0px solid #000000; border-radius:2px;padding:0px;text-align:right;'></div><font style="text-align:right;float:right"><?php echo number_format($piutang); ?></font></td>
            </tr>
            <tr>
                <td style="text-align:right;"> Jumlah </td>
                <td style='border-bottom:0px solid #000000; border-radius:2px;padding:2px;float:right;text-align:right;'> <?php echo number_format($total + $piutang); ?></td>
            </tr>
            <tr>
                <td style="text-align:right"> Pengeluaran </td>
               <td style='border-bottom:1px solid #000000; border-radius:2px;padding:2px;'><div style='border-bottom:0px solid #000000; border-radius:2px;padding:0px;float:right;text-align:right;'><font style="text-align:right;float:right"><?php echo number_format($totalpengeluaran); ?></font></td>
            </tr>
            <tr>
                <td style="text-align:right;"> Saldo </td>
                <td style='border-bottom:0px solid #000000; border-radius:2px;padding:2x;float:right;text-align:right;'> <?php echo number_format($saldo); ?> </td>
            </tr>
        </table>
    </div>
    <br/>
    <div>
        <table style="max-width:700px;margin-left:300px;" cellpadding="2px;" border="2"> 
            <thead>
                <tr>
                    <th  style="text-align:center"> Rincian </th>
                    <th  style="text-align:center"> Lembar </th>
                    <th  style="text-align:center"> Jumlah </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $criteria = new CDbCriteria;
                    
					if(!empty($model->closingkasir_id)){
						$criteria->addCondition('closingkasir_id = '.$model->closingkasir_id);
					}
                    $modRincian = RincianclosingT::model()->findAll($criteria);
                    
                ?>
                
                <tr>
                    <td style="text-align:right"> <?php echo number_format(100000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($uang100); ?></td>
                    <td style="text-align:right"><?php echo number_format($jumlah100); ?> </td>
                           
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(50000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(20000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(10000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(5000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(2000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(1000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(500); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(200); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(100); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(50); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($rincian->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($rincian->jumlahuang); ?> </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php    
        }else if($data['filter'] == 'detail'){ 

?>
<div id="detailKas">
    <div style="<?php echo $rim; ?>">
        <table style="width:100%" border="1">
            <thead>
                <tr style="height:30px;">
                    <th style="text-align:center">No.</th>
                    <th style="text-align:center">No. Reg Lab</th>
                    <th style="text-align:center">Nama </th>
                    <th style="text-align:center">Kedatangan</th>
                    <th style="text-align:center">Piutang</th>
                    <th style="text-align:center">Deposit</th>
                    <th style="text-align:center">Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                    foreach($modDetail as $i=>$detail){
                        $totalpiutang += $detail->piutang;
                        $totaldeposit += $detail->jumlahuang - $detail->totalpengeluaran;
                        $totalpembayaran += $detail->jumlahuang;
                        $id = $detail->closingkasir_id;
                ?>
                <tr>
                    <td style="text-align:center"><?php echo ($i+1); ?></td>
                    <td style="text-align:center"><?php echo $detail->no_pendaftaran?></td>
                    <td style="text-align:center"><?php echo $detail->nama_pasien;?></td>
                    <td style="text-align:center"><?php echo $detail->keterangan_closing;?></td>
                    <td style="text-align:right"><?php echo number_format($detail->piutang);?></td>
                    <td style="text-align:right"><?php echo number_format($detail->jumlahuang - $detail->totalpengeluaran);?></td>
                    <td style="text-align:right"><?php echo number_format($detail->jumlahuang);?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align:RIGHT" colspan="4">Total</td>
                    <td style="text-align:RIGHT"><?php echo number_format($totalpiutang); ?></td>
                    <td style="text-align:right"><?php echo number_format($totaldeposit);?></td>
                    <td style="text-align:right"><?php echo number_format($totalpembayaran);?></td>
                </tr>
            </tfoot>
            
        </table>
    <?php 
        
//        $this->widget($table,array(
//            'id'=>'detaillaporankasharianlab-grid',
//            'dataProvider'=>$dataDetail,
//            'enableSorting'=>$sort,
//            'template'=>$template,
//            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//                'columns'=>array(
//                    array(
//                        'header' => 'No',
//                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
//                        'footerHtmlOptions'=>array('colspan'=>'4','style'=>'text-align:right;font-style:italic;'),
//                        'footer'=>'Total:',
//                    ),
//                    array(
//                      'header'=>'No. Reg Lab ',
//                      'type'=>'raw',
//                      'value'=>'$data->no_pendaftaran',
//                    ),
//                    array(
//                      'header'=>'Nama',
//                      'type'=>'raw',
//                      'value'=>'$data->nama_pasien',
//                    ),
//                    array(
//                      'header'=>'Kedatangan',
//                      'type'=>'raw',
//                      'value'=>'(empty($data->keterangan_closing) ? "-" : $data->keterangan_closing)',
//                    ),
//                   array(
//                      'header'=>'<center>Piutang</center>',
//                      'name'=>'piutang',
//                      'type'=>'raw',
//                      'value'=>'(empty($data->piutang) ? "0" : number_format($data->piutang))',
//                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                      'footer'=>'sum(piutang)',
////                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
//                      'htmlOptions'=>array(
//                          'style'=>'text-align:right',
//                      ),
//                    ),
//                    array(
//                      'header'=>'<center>Deposit</center>',
//                      'name'=>'piutang',
//                      'type'=>'raw',
//                      'value'=>'(empty($data->piutang) ? "0" : number_format($data->piutang))',
//                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                      'footer'=>'sum(piutang)',
////                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
//                      'htmlOptions'=>array(
//                          'style'=>'text-align:right',
//                      ),
//                    ),
//                    array(
//                      'header'=>'<center>Pembayaran</center>',
//                      'name'=>'jumlahuang',
//                      'type'=>'raw',
//                      'value'=>'(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang))',
//                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                      'footer'=>'sum(jumlahuang)',
////                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
//                      'htmlOptions'=>array(
//                          'style'=>'text-align:right',
//                      ),
//                    ),
//                   
//                ),
//                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//            )); 
        ?>
    </div><br/><br/>
        <table style="width:800px;">
            <tr>
                <td style='text-align:right;'> Prosentase Keringanan & Gratis </td>
                <td></td>
                <td style='text-align:right;'> 0,00 % </td>
                <td></td>
                <td style='text-align:right;'>Nilai Uang Keringanan & Gratis </td>
                <td></td>
                <td style='text-align:right;'> 0,00 </td>
            </tr>
            <tr>
                <td style='text-align:right;'>Prosentase Tagihan</td>
                <td></td>
                <td style='text-align:right;'>0,00 %</td>
                <td></td>
                <td style='text-align:right;'>Nilai Uang Tagihan</td>
                <td></td>
                <td style='text-align:right;'>0,00</td>
            </tr>
            <tr>
                <td colspan="7"></td>
            </tr>
        </table>
</div>
<?php } ?>
<br/>