<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $pagination = 10;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        $pagination = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
        echo "
             <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass='table border';
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
        'itemsCssClass'=>$itemCssClass,
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
            'header'=>'Tanggal Pendaftaran',
            'type'=>'raw',
            'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran)))',
        ),
        array(
            'header' => 'No. Pendaftaran',
            'value'=>'$data->no_pendaftaran',
        ),
        
        array(
            'header'=>'Nama Pasien',
            'value'=>function($data){
                $p = PasienM::model()->findByPk($data->pasien_id);
                                
                    return $p->namadepan.' '.$data->nama_pasien;
                
            },
        ),
        array(
            'header'=>'Alamat',
            'name'=>'alamat_pasien',
        ),
        array(
            'header'=>'Tarif',
            'type'=>'raw',
            'name'=>'total',
            'value'=>'number_format($data->total,0,"",".")',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',                    
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=>'sum(total)',
        ),
        array(
            'header'=>'Biaya Administrasi',
            'type'=>'raw',
            'name'=>'administrasi',
            'value'=>'number_format($data->administrasi,0,"",".")',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',                    
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=>'sum(administrasi)',
        ),
        array(
            'header'=>'Keringanan',
            'type'=>'raw',
            'name'=>'totaldiscount',
            'value'=>'number_format($data->totaldiscount,0,"",".")',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',                    
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=>'sum(totaldiscount)',
        ),
        array(
            'header'=>'Deposit',
            'type'=>'raw',
            'name'=>'totaluangmuka',
            'value'=>'number_format($data->totaluangmuka,0,"",".")',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',                    
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=>'sum(totaluangmuka)',
        ),
        array(
            'header'=>'Bayar',
            'type'=>'raw',
            'name'=>'totalbayartindakan',
            'value'=>'number_format($data->totalbayartindakan,0,"",".")',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',                    
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
            'footer'=>'sum(totalbayartindakan)',
        ),
        array(
            'header'=>'Sisa',
            'type'=>'raw',
            'name'=>'totalsisatagihan',
            'value'=>'number_format($data->totalsisatagihan,0,"",".")',
            'htmlOptions'=>array(
                    'style'=>'text-align:right',                    
                ),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;',),
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
        }',
    )
);
?> 