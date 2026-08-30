<?php 
$rim = '';
// $model2 = $model;
?>
<?php //print_r($modDetail); ?>
<?php
        if((isset($data['filter']) && $data['filter'] == 'rekap')){
?>
<div id="rekapKas">
    <div style="<?php echo $rim; ?>">
        <table style="width:100%" border="1">
            <thead>
                <tr style="height:30px;">
                    <th rowspan="2" style="text-align:center">NO</th>
                    <th rowspan="2" style="text-align:center">URAIAN</th>
                    <th colspan="3" style="text-align:center">PENERIMAAN KAS</th>
                    <th rowspan="2" style="text-align:center">BERSYARAT<br>PIUTANG BARU</th>
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
                $totaltunai = 0;
                $totalpiutang = 0;
                $total = 0;
                $totalpiutangbaru = 0;
                $saldo = 0;
                    foreach($model as $i=>$data){
                        $data_total = (isset($data->total) ? $data->total : 0);
                        $totalpengeluaran = (isset($data->totalpengeluaran) ? $data->totalpengeluaran : 0);
                        $totaltunai += (isset($data->jumlahuang) ? $data->jumlahuang : 0);
                        $totalpiutang += (isset($data->piutang) ? $data->piutang : 0);
                        $total += (isset($data->total) ? $data->total : 0);
                        $totalpiutangbaru += (isset($data->totalpengeluaran) ? $data->totalpengeluaran : 0);
                        $saldo += $data_total - $totalpengeluaran;
                        $id = (isset($data->closingkasir_id) ? $data->closingkasir_id : null);
                ?>
                <tr>
                    <td style="text-align:center"><?php echo ($i+1); ?></td>
                    <td style="text-align:center"><?php echo (isset($data->keterangan_closing) ? $data->keterangan_closing : ""); ?></td>
                    <td style="text-align:right"><?php echo (isset($data->jumlahuang) ? number_format($data->jumlahuang) : 0);?></td>
                    <td style="text-align:right"><?php echo (isset($data->piutang) ? number_format($data->piutang) : 0);?></td>
                    <td style="text-align:right"><?php echo (isset($data->total) ? number_format($data->total) : 0);?></td>
                    <td style="text-align:right"><?php echo (isset($data->totalpengeluaran) ? number_format($data->totalpengeluaran) : 0);?></td>
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
//                        'name'=>'<p style="margin: 0; text-align: center;">PENERIMAAN KAS</p>',
//                        'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                        'start'=>2, //indeks kolom 3
//                        'end'=>4, //indeks kolom 4
//                    ),
//                ),
//                'columns'=>array(
//                    array(
//                        'header' => 'No.',
//                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
//                        'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;font-style:italic;'),
//                        'footer'=>'JUMLAH',
//                    ),
//                    array(
//                      'header'=>'<p style="margin: 0; text-align: center;">URAIAN</p>',
//                      'type'=>'raw',
//                      'headerHtmlOptions'=>array('style'=>'background-color:mintcream;text-align:center'),
//                      'value'=>'(empty($data->closingkasir_id) ? "-" : "$data->closingkasir_id" )',
//                    ),
//                    array(
//                      'header'=>'<p style="margin: 0; text-align: center;">TUNAI</p>',
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
//                      'header'=>'<p style="margin: 0; text-align: center;">PIUTANG</p>',
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
//                      'header'=>'<p style="margin: 0; text-align: center;">TOTAL</p>',
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
//                      'header'=>'<p style="margin: 0; text-align: center;">BERSYARAT <br> PIUTANG BARU</p>',
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
    <br><br>
    <div>
        <table style="max-width:300px;align:center;font-size:14px;font-family:tahoma;margin-left:250px;">
            <?php
                $total = (isset($total) ? $total : 0);
                $piutang = (isset($piutang) ? $piutang : 0);
            ?>
            <tr>
                <td style="text-align:right;"> Pendapatan (Tunai) </td>
                <td style='border-bottom:0px solid #000000;margin-left:50px; border-radius:2px;padding:2px;float:right;text-align:right;'> <?php echo (isset($total) ? number_format($total) : 0); ?></td>
            </tr>
            <tr>
                <td style="text-align:right;"> (Piutang)</td>
                <td style='border-bottom:1px solid #000000; border-radius:2px;padding:2px;'><div style='border-bottom:0px solid #000000; border-radius:2px;padding: 0;text-align:right;'></div><span style="text-align:right;float:right"><?php echo (isset($piutang) ? number_format($piutang) : 0); ?></span></td>
            </tr>
            <tr>
                <td style="text-align:right;"> Jumlah </td>
                <td style='border-bottom:0px solid #000000; border-radius:2px;padding:2px;float:right;text-align:right;'> <?php echo number_format($total + $piutang); ?></td>
            </tr>
            <tr>
                <td style="text-align:right"> Pengeluaran </td>
               <td style='border-bottom:1px solid #000000; border-radius:2px;padding:2px;'><div style='border-bottom:0px solid #000000; border-radius:2px;padding: 0;float:right;text-align:right;'><span style="text-align:right;float:right"><?php echo (isset($totalpengeluaran) ? number_format($totalpengeluaran) : 0); ?></span></td>
            </tr>
            <tr>
                <td style="text-align:right;"> Saldo </td>
                <td style='border-bottom:0px solid #000000; border-radius:2px;padding:2x;float:right;text-align:right;'> <?php echo (isset($saldo) ? number_format($saldo) : 0); ?> </td>
            </tr>
        </table>
    </div>
    <br>
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
                    
                    $criteria->select = 'closingkasir_id, nourutrincian, nilaiuang, sum(banyakuang) as banyakuang, sum(jumlahuang) as jumlahuang';
                    $criteria->group = 'nilaiuang,closingkasir_id,nourutrincian';
                    $criteria->order ='nourutrincian';
                    
					if(!empty($model->closingkasir_id)){
						$criteria->addCondition('closingkasir_id = '.$model->closingkasir_id);
					}
                    $modRincian = RincianclosingT::model()->findAll($criteria);
                ?>
                <?php
                if(isset($model) && count((array)$model) > 0){
                    foreach($modRincian as $i=>$data){
                            
                ?>  
                <tr>
                    <td style="text-align:right"> <?php echo number_format($data->nilaiuang); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber($data->banyakuang); ?></td>
                    <td style="text-align:right"><?php echo number_format($data->jumlahuang); ?> </td>
                </tr>
                <?php  } }else{?>
                <tr>
                    <td style="text-align:right"> <?php echo number_format(100000); ?> </td>
                    <td style="text-align:right"><?php echo CustomFunction::formatNUmber(0); ?></td>
                    <td style="text-align:right"><?php echo number_format(0); ?> </td>
                           
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
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php    
        }else if((isset($data['filter']) && $data['filter'] == 'detail')){ 

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
                $totalpiutang = 0;
                $totaldeposit = 0;
                $totalpembayaran = 0;
                    foreach($modDetail as $i=>$detail){
                        $totalpiutang += $detail->piutang;
                        $totaldeposit += $detail->jumlahuang - $detail->jumlahuang;
                        $totalpembayaran += $detail->jumlahuang;
                        $id = $detail->closingkasir_id;
                ?>
                <tr>
                    <td style="text-align:center"><?php echo ($i+1); ?></td>
                    <td style="text-align:center"><?php echo $detail->no_pendaftaran?></td>
                    <td style="text-align:center"><?php echo $detail->nama_pasien;?></td>
                    <td style="text-align:center"><?php echo $detail->keterangan_closing;?></td>
                    <td style="text-align:right"><?php echo number_format($detail->piutang);?></td>
                    <td style="text-align:right"><?php echo number_format($detail->jumlahuang - $detail->jumlahuang);?></td>
                    <td style="text-align:right"><?php echo number_format($detail->jumlahuang);?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align:RIGHT" colspan="4">Total</td>
                    <td style="text-align:RIGHT"><?php echo (isset($totalpiutang) ? number_format($totalpiutang) : 0); ?></td>
                    <td style="text-align:right"><?php echo (isset($totaldeposit) ? number_format($totaldeposit) : 0);?></td>
                    <td style="text-align:right"><?php echo (isset($totalpembayaran) ? number_format($totalpembayaran) : 0);?></td>
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
//                        'header' => 'No.',
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
//                      'header'=>'<p style="margin: 0; text-align: center;">Piutang</p>',
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
//                      'header'=>'<p style="margin: 0; text-align: center;">Deposit</p>',
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
//                      'header'=>'<p style="margin: 0; text-align: center;">Pembayaran</p>',
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
    </div><br><br>
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
<br>