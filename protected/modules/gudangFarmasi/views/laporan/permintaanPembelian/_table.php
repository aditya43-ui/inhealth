<?php 
/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = 'row+1';
        $data = $model->searchPermintaanPembelian();
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
    } else{
        $data = $model->searchPrintPermintaanPembelian();
         $template = "{summary}\n{items}\n{pager}";
    }
?>


<?php if(!isset($caraPrint)){ ?>
<?php 
    $data2 = $model->searchPermintaanPembelian();
    $total = 0;

    $data2->pagination = false;

    foreach ($data2->data as $item) {
        $total += $item->total_harganetto;
    }
    $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		array(
			'header'=>'Nama Supplier',
			'type'=>'raw',
			'value'=>'$data->supplier->supplier_nama',
            'footer'=>"&nbsp;"
		),
		array(
			'header'=>'Alamat Supplier',
			'type'=>'raw',
			'value'=>'$data->supplier->supplier_alamat',
            'footer'=>"&nbsp;"
		),
		array(
			'header'=>'No. Permintaan',
			'type'=>'raw',
			'value'=>'$data->nopermintaan',
            'footer'=>"&nbsp;"
		),
		array(
			'header'=>'Tanggal Permintaan',
			'type'=>'raw',
			'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpermintaanpembelian))',
            'footerHtmlOptions'=>array('style'=>('text-align: right;font-weight: bold;')),
            'footer'=>"Total",
		),
		array(
			'header'=>'Total Harga Netto',
			'type'=>'raw',
			'name'=>'total_harganetto',
			'value'=>'number_format($data->total_harganetto,0,",",".")',
			'htmlOptions'=>array('style'=>'text-align:right','class'=>'currency'),
            'footer'=>MyFormatter::formatNumberForPrint($total),
            'footerHtmlOptions'=>array('style'=>('text-align: right;font-weight: bold;')),
		),
		array(
			'header'=>'Print Detail',
			'type'=>'raw',
			'name'=>'total_harganetto',
			'value'=>'CHtml::link("<i class=\"entypo-print\"></i>", "javascript:printDetail(\'$data->supplier_id\',\'$data->permintaanpembelian_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak Detail Laporan Permintaan Pembelian"))',
			'htmlOptions'=>array('style'=>'text-align:center'),
            'footer'=>"&nbsp;"
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php }else{ ?>
<?php 
    $data2 = $model->searchPrintPermintaanPembelian();
    $total = 0;

    $data2->pagination = false;

    foreach ($data2->data as $item) {
        $total += $item->total_harganetto;
    }
    $this->widget($table,array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
    'template'=>$template,
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Nama Supplier',
                        'type'=>'raw',
                        'value'=>'$data->supplier->supplier_nama',
                        'footer'=>"&nbsp;"
                    ),
                    array(
                        'header'=>'Alamat Supplier',
                        'type'=>'raw',
                        'value'=>'$data->supplier->supplier_alamat',
                        'footer'=>"&nbsp;"
                    ),
                    array(
                        'header'=>'No. Permintaan',
                        'type'=>'raw',
                        'value'=>'$data->nopermintaan',
                        'footer'=>"&nbsp;"
                    ),
                    array(
                        'header'=>'Tanggal Permintaan',
                        'type'=>'raw',
						'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpermintaanpembelian))',
                        'footerHtmlOptions'=>array('style'=>('text-align: right;font-weight: bold;')),
                        'footer'=>"Total",
                    ),
                    array(
                        'header'=>'Total Harga Netto',
                        'type'=>'raw',
                        'name'=>'total_harganetto',
                        'value'=>'number_format($data->total_harganetto,0,"",".")',
                        'htmlOptions'=>array('style'=>'text-align:right','class'=>'currency'),
                        'footer'=>MyFormatter::formatNumberForPrint($total),
                        'footerHtmlOptions'=>array('style'=>('text-align: right;font-weight: bold;')),
                    ),                   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php } ?>
<?php 
    
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $js = <<< JSCRIPT

function printDetail(id,idPembelian)
   {    
               window.open('${url}/PrintDetailLaporanPermintaanPembelian/id/'+id+'/idPembelian/'+idPembelian,'printwin','location=_new, width=900px');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('jsprintprice',$js, CClientScript::POS_HEAD);
?>