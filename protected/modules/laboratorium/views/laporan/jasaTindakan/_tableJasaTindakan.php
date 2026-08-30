<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass='table border';  
        $totals = array();    
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
         
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'type' => 'raw',
            'value' => '$row+1',
            'footerHtmlOptions' => array('colspan' => 3, 'style' => 'text-align:Center;font-style:bold;'),
            'footer' => 'Total',
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'value' => 'JenispemeriksaanradM::model()->findByPk($data->jenispemeriksaanrad_id)->jenispemeriksaanrad_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => ' ',
        ),
        array(
            'name' => 'pemeriksaanrad_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
       
        array(
            'header' => 'Tarif Satuan',
            'name' => 'tarif_satuan',
            'value' => 'number_format($data->tarif_satuan)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(tarif_satuan)',
        ),

        array(
            'name' => 'qty_tindakan',
            'value' => '$data->qty_tindakan',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(qty_tindakan)',
        ),
        
        array(
            'header' => 'Total',
            'name' => 'totalTarif',
            'value' => 'number_format($data->totalTarif)',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(totalTarif)',
        ),
        array(
            'name' => 'carabayar_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => ' ',
        ),
        array(
            'name' => 'penjamin_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => ' ',
        ),
        array(
            'header' => 'Jenis Kunjungan',
            'value' => 'RuanganM::model()->findByPk($data->create_ruangan)->instalasi->instalasi_nama',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => ' ',
        ),                                         
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

