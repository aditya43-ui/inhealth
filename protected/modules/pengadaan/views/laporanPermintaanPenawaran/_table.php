<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPermintaanPenawaran();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrintPermintaanPenawaran();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php if(!isset($caraPrint)){ ?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=>'Nama Supplier',
			'type'=>'raw',
			'value'=>'$data->supplier->supplier_nama',
		),
		array(
			'header'=>'Alamat Supplier',
			'type'=>'raw',
			'value'=>'$data->supplier->supplier_alamat',
		),
		 array(
			'header'=>'Tanggal Permintaan',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s", strtotime($data->tglpenawaran)))',
		), 
		array(
			'header'=>'No. Penawaran',
			'type'=>'raw',
			'value'=>'$data->nosuratpenawaran',
		),                   
		array(
			'header'=>'Total Harga Netto',
			'type'=>'raw',
			'name'=>'total_harganetto',
			'value'=>'MyFormatter::formatNumberForPrint($data->total_harganetto)',
			'htmlOptions'=>array('style'=>'text-align:right','class'=>'currency'),
		), 
		array(
			'header'=>'Print Detail',
			'type'=>'raw',
			'name'=>'total_harganetto',
			'value'=>'CHtml::link("<i class=\"entypo-print\"></i>", "javascript:printDetail(\'$data->supplier_id\',\'$data->permintaanpenawaran_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak Detail Laporan Permintaan Penawaran"))',
			'htmlOptions'=>array('style'=>'text-align:center'),
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php }else{ ?>
<?php $this->widget($table,array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Nama Supplier',
                        'type'=>'raw',
                        'value'=>'$data->supplier->supplier_nama',
                    ),
                    array(
                        'header'=>'Alamat Supplier',
                        'type'=>'raw',
                        'value'=>'$data->supplier->supplier_alamat',
                    ),
                    array(
                        'header'=>'No. Penawaran',
                        'type'=>'raw',
                        'value'=>'$data->nosuratpenawaran',
                    ),
                    array(
                        'header'=>'Tanggal Permintaan',
                        'type'=>'raw',
                        'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpenawaran))',
                    ), 
                    array(
                        'header'=>'Total Harga Netto',
                        'type'=>'raw',
                        'name'=>'total_harganetto',
                        'value'=>'MyFormatter::formatNumberForPrint($data->total_harganetto)',
                        'htmlOptions'=>array('style'=>'text-align:right','class'=>'currency'),
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
               window.open('${url}/PrintDetailLaporanPermintaanPenawaran&id='+id+'&idPembelian='+idPembelian,'printwin','location=_new, width=900px');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('jsprintprice',$js, CClientScript::POS_HEAD);
?>