<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $pagination = 10;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        $pagination = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php
$this->widget($table,
    array(
        'id'=>'tableLaporanPembayaranPemeriksaan',
        'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
      'columns'=>array(
        array(
            'header' => 'No.',
            'type'=>'raw',
			'name'=>'no_pendaftaran',
            'value' => '$row+1',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;font-style:italic;'),
            'footer'=>'Total',
        ),
        array(
            'header' => 'No. Pendaftaran',
            'name'=>'no_pendaftaran',
        ),
        array(
            'header'=>'Tanggal Pendaftaran',
            'type'=>'raw',
			'value'=>'date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran))',
        ),
        array(
            'header'=>'Nama Pasien',
            'name'=>'nama_pasien',
        ),
        array(
            'header'=>'Alamat',
            'name'=>'alamat_pasien',
        ),
        array(
            'header'=>'Tarif',
            'type'=>'raw',
            'name'=>'total',
            'value'=>'number_format($data->total)',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',
                    'class'=>'currency'
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;','class'=>'currency'),
            'footer'=>'sum(total)',
        ),
        array(
            'header'=>'Biaya Administrasi',
            'type'=>'raw',
            'name'=>'administrasi',
            'value'=>'number_format($data->administrasi)',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',
                    'class'=>'currency'
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;','class'=>'currency'),
            'footer'=>'sum(administrasi)',
        ),
        array(
            'header'=>'Keringanan',
            'type'=>'raw',
            'name'=>'totaldiscount',
            'value'=>'number_format($data->totaldiscount)',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',
                    'class'=>'currency'
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;','class'=>'currency'),
            'footer'=>'sum(totaldiscount)',
        ),
        array(
            'header'=>'Deposit',
            'type'=>'raw',
            'name'=>'totaluangmuka',
            'value'=>'number_format($data->totaluangmuka)',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',
                    'class'=>'currency'
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;','class'=>'currency'),
            'footer'=>'sum(totaluangmuka)',
        ),
        array(
            'header'=>'Bayar',
            'type'=>'raw',
            'name'=>'totalbayartindakan',
            'value'=>'number_format($data->totalbayartindakan)',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',
                    'class'=>'currency'
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;','class=>currency'),
            'footer'=>'sum(totalbayartindakan)',
        ),
        array(
            'header'=>'Sisa',
            'type'=>'raw',
            'name'=>'totalsisatagihan',
            'value'=>'number_format($data->totalsisatagihan)',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',
                    'class'=>'currency'
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;','class=>currency'),
            'footer'=>'sum(totalsisatagihan)',
        ),
        array(
            'header'=>'Kasir',
            'type'=>'raw',
            'name'=>'nama_pegawai',
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;color:white;'),
            'footer'=>'-',
        ),
       
    ),
        'afterAjaxUpdate'=>'function(id, data)
        {
            var paging = $("#tableLaporanPembayaranPemeriksaan table").find("input[name=\'paging\']").val();
            if(typeof paging == \'undefined\')
            {
                paging = 0;
            }
            paging = parseInt(paging) + 1;
            $(".number_page").val(paging);
            
            $("#tableLaporanPembayaranPemeriksaan").parent().find("li").each(
                function()
                {
                    if($(this).attr("class") == "active")
                    {
                        setType(this);
                    }
                }
            );
            
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $(".currency").each(function(){
                $(this).text(
                    formatInteger($(this).text())
                );
            });
        }',
    )
);
?> 