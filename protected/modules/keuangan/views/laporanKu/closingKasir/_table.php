<?php

use function PHPSTORM_META\type;

$cek = !empty($model->pegawai_id)?false:true;

$prov = $model->searchInformasi();
$prov2 = $model->searchInformasi();

// echo "<pre>";
// var_dump($prov2->data);die;

$prov2->criteria->select = 'sum(terimauangmuka) as terimauangmuka, '
    . 'sum(terimauangpelayanan) as terimauangpelayanan,'
    . 'sum(totalpengeluaran) as totalpengeluaran,'
    . 'sum(nilaiclosingtrans) as nilaiclosingtrans,'
    . 'sum(jmltransaksi) as jmltransaksi,'
    . 'sum(jmluanglogam) as jmluanglogam,'
    . 'sum(jmluangkertas) as jmluangkertas,'
    . 'sum(piutang) as piutang,'
    . 'sum(totalsetoran) as totalsetoran,'
    . 'sum(jumlah_returtagihan) as jumlah_returtagihan,'
    . 'sum(jumlahdebit) as jumlah_debit,'
    . 'sum(jumlahkredit) as jumlah_kredit';

$terimauangmuka = 0;
$terimauangpelayanan = 0;
$totalpengeluaran = 0;
$nilaiclosingtrans = 0;
$totalsetoran = 0;
$jmltransaksi = 0;
$jmluanglogam = 0;
$jmluangkertas = 0;
$piutang = 0;
$refund = 0;
$jumlah_kredit = 0;
$jumlah_debit = 0;
$totalSetoran = 0;
$totalClosing = 0;
$saldoawal = 0;
// echo '<pre>';var_dump($prov->data);die;
foreach ($prov->data as $item){
    $setoran_tunai = $item->closingsaldoawal + $item->terimauangmuka + $item->terimauangpelayanan - $item->jumlah_returtagihan;
    $jumlahClosing = $item->closingsaldoawal + $item->terimauangmuka + $item->terimauangpelayanan - $item->jumlah_returtagihan + $item->piutang + $item->jumlahdebit + $item->jumlahkredit;
    $totalSetoran += $item->totalsetoran;
    $totalClosing += $item->nilaiclosingtrans;
    $jumlah_kredit += $item->jumlahkredit;
    $jumlah_debit += $item->jumlahdebit;
    $saldoawal += $item->closingsaldoawal;
}

foreach ($prov2->data as $item) {
    $terimauangmuka += $item->terimauangmuka;
    $terimauangpelayanan += $item->terimauangpelayanan;
    $totalpengeluaran += $item->totalpengeluaran;
    $nilaiclosingtrans += $item->nilaiclosingtrans;
    $totalsetoran += $item->totalsetoran;
    $jmltransaksi += $item->jmltransaksi;
    $jmluanglogam += $item->jmluanglogam;
    $jmluangkertas += $item->jmluangkertas;
    $piutang += $item->piutang;
    $refund += $item->jumlah_returtagihan;
    
} 


$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'laporanclosingkasir-m-grid',
	'dataProvider'=>$model->searchInformasi(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Penerimaan</p>',
                'start'=>4, 
                'end'=>5, 
            ),
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Penerimaan Non Tunai</p>',
                'start'=>8, 
                'end'=>10, 
            ),
            // array(
            //     'name'=>'<p style="margin: 0; text-align: center;">Banyaknya</p>',
            //     'start'=>9, 
            //     'end'=>11, 
            // ),
        ),
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                    'footer' => 'Total',
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'name'=>'tglclosingkasir',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglclosingkasir)',
                    'footer'=>'&nbsp;',
                ),
                array(
                    'name'=>'closingdari',
                    'header'=>'Closing Dari <br>Sampai Dengan',
                    'type'=>'raw',
                    'value'=>'date("H:i:s",strtotime($data->closingdari))." <br>s/d ".date("H:i:s",strtotime($data->sampaidengan))',
                    'footer'=>'&nbsp;',
                ),
                                
//                'shift_nama',
                array(
                    'name'=>'closingsaldoawal',
                    'type'=>'raw',
                    'value'=>'number_format($data->closingsaldoawal,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($saldoawal),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                    
                ),
                array(
                    'name'=>'terimauangmuka',
                    'type'=>'raw',
                    'value'=>'number_format($data->terimauangmuka,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($terimauangmuka),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'name'=>'terimauangpelayanan',
                    'type'=>'raw',
                    'value'=>'number_format($data->terimauangpelayanan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($terimauangpelayanan),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'header'=>'Refund',
                    'type'=>'raw',
                    'value'=>'number_format($data->jumlah_returtagihan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($refund),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'header' => 'Setoran Tunai',
                    'type' => 'raw',
                    // 'value' => 'number_format($data->closingsaldoawal + $data->terimauangmuka + $data->terimauangpelayanan - $data->jumlah_returtagihan,0,"",".")',
                    'value' => 'number_format($data->totalsetoran,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($totalSetoran),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'header'=>'Piutang',
                    'type'=>'raw',
                    'value'=>'number_format($data->piutang,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($piutang),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'header'=>'Dc',
                    'type'=>'raw',
                    'value'=>'number_format($data->jumlahdebit,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($jumlah_debit),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'header'=>'Cc',
                    'type'=>'raw',
                    'value'=>'number_format($data->jumlahkredit,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($jumlah_kredit),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                array(
                    'header' => 'Jumlah Closing',
                    'type' => 'raw',
                    'value' => 'number_format($data->nilaiclosingtrans,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($totalClosing),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;'
                    ),
                ),
                // array(
                //     'name'=>'totalpengeluaran',
                //     'type'=>'raw',
                //     'value'=>'number_format($data->totalpengeluaran,0,"",".")',
                //     'htmlOptions'=>array('style'=>'text-align:right;'),
                //     'footer'=>MyFormatter::formatNumberForPrint($totalpengeluaran),
                //     'footerHtmlOptions'=>array(
                //         'style'=>'text-align: right; font-weight: bold;'
                //     ),
                // ),
                // array(
                //     'name'=>'nilaiclosingtrans',
                //     'type'=>'raw',
                //     'value'=>'number_format($data->nilaiclosingtrans,0,"",".")',
                //     'htmlOptions'=>array('style'=>'text-align:right;'),
                //     'footer'=>MyFormatter::formatNumberForPrint($nilaiclosingtrans),
                //     'footerHtmlOptions'=>array(
                //         'style'=>'text-align: right; font-weight: bold;'
                //     ),
                // ),
                // array(
                //     'name'=>'totalsetoran',
                //     'type'=>'raw',
                //     'value'=>'number_format($data->totalsetoran,0,"",".")',
                //     'htmlOptions'=>array('style'=>'text-align:right;'),
                //     'footer'=>MyFormatter::formatNumberForPrint($totalsetoran),
                //     'footerHtmlOptions'=>array(
                //         'style'=>'text-align: right; font-weight: bold;'
                //     ),
                // ),
                // array(
                //     'name'=>'jmltransaksi',
                //     'type'=>'raw',
                //     'value'=>'number_format($data->jmltransaksi,0,"",".")',
                //     'htmlOptions'=>array('style'=>'text-align:right;'),
                //     'footer'=>MyFormatter::formatNumberForPrint($jmltransaksi),
                //     'footerHtmlOptions'=>array(
                //         'style'=>'text-align: right; font-weight: bold;'
                //     ),
                // ),
                // array(
                //     'name'=>'jmluanglogam',
                //     'type'=>'raw',
                //     'value'=>'number_format($data->jmluanglogam,0,"",".")',
                //     'htmlOptions'=>array('style'=>'text-align:right;'),
                //     'footer'=>MyFormatter::formatNumberForPrint($jmluanglogam),
                //     'footerHtmlOptions'=>array(
                //         'style'=>'text-align: right; font-weight: bold;'
                //     ),
                // ),
                // array(
                //     'name'=>'jmluangkertas',
                //     'type'=>'raw',
                //     'value'=>'number_format($data->jmluangkertas,0,"",".")',
                //     'htmlOptions'=>array('style'=>'text-align:right;'),
                //     'footer'=>MyFormatter::formatNumberForPrint($jmluangkertas),
                //     'footerHtmlOptions'=>array(
                //         'style'=>'text-align: right; font-weight: bold;'
                //     ),
                // ),
                
                array(
                    'name' => 'keterangan_closing',
                    'footer'=>'&nbsp;',
                ),
                array(
                    'name' => 'nama_pegawai',
                    'visible' => $cek,
                    'footer'=>'&nbsp;',
                ),
                array(
                    'header' => 'Shift',
                    'value' => '$data->shift_nama',
                    'footer'=>'&nbsp;',
                ),
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
