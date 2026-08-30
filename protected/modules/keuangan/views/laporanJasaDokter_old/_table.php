<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporan();
        $template = "{items}";
        $sort = false;
//        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        echo "<style>
                .tableRincian thead, th{
                    border: 1px #000 solid;
                }
                .tableRincian{
                    width:100%;
                }
            </style>";
        $itemsCssClass='tableRincian';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-striped table-condensed';
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'mergeColumns'=>array('nama_pegawai'),
//    'extraRowColumns'=> array('nama_pegawai'),
    'columns'=>array( 
        array(
            'header' => 'No.',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header'=>'Nama Perujuk /Dokter',
            'name'=>'nama_pegawai',
            'type'=>'raw',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            'htmlOptions'=>array('class'=>'ruangantujuan','style'=>'text-align:center;'),
            'value'=>'empty($data->nama_pegawai) ? $data->namaperujuk."<br> (Rujukan Luar)" : $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama."<br>"',
            'footerHtmlOptions' => array('colspan' => 5, 'style' => 'text-align: right; font-weight: bold;'),
            'footer'=>'Jumlah Total',
        ),
        array(
            'header'=>'Tanggal Bayar Jasa',
            'type'=>'raw',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'date("d/m/Y H:i:s",strtotime($data->tglbayarjasa)',
        ),
        array(
            'header'=>'No. Bayar Jasa',
            'type'=>'raw',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->nobayarjasa',
        ),
        array(
            'header'=>'No. Kas Keluar',
            'type'=>'raw',
            'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->nokaskeluar',
        ),
        array(
            'name'=>'totaltarif',
            'header'=>'Total Tarif',
            'type'=>'raw',
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
            'value'=>'number_format($data->totaltarif,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totaltarif)',
        ),
        array(
            'name'=>'totaljasa',
            'header'=>'Total Jasa',
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
            'value'=>'number_format($data->totaljasa,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totaljasa)',
        ),
        array(
            'name'=>'totalbayarjasa',
            'header'=>'Total Bayar Jasa',
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
            'value'=>'number_format($data->totalbayarjasa,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totalbayarjasa)',
        ),
        array(
            'name'=>'totalsisajasa',
            'header'=>'Total Sisa Jasa',
            'headerHtmlOptions'=>array('style'=>'text-align:right;'),
            'value'=>'number_format($data->totalsisajasa,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totalsisajasa)',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>