<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $itemCssClass = 'table table-striped table-condensed table-bordered';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrintPermintaanPembelian();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint == "PDF"){
            //$table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
       
          $itemCssClass = 'table border';
    } else{
        $data = $model->searchPermintaanPembelian();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php if(!isset($caraPrint)){ ?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                    array(
                        'header' => 'No.',
                        'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'header'=>'Tanggal Permintaan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpermintaanpembelian)))',
                    ),
					array(
                        'header'=>'No Permintaan',
                        'type'=>'raw',
                        'value'=>'$data->nopermintaan',
                    ),
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
                        'header'=>'Total Harga Netto',
                        'type'=>'raw',
                        'name'=>'total_harganetto',
                        'value'=>'number_format($data->total_harganetto,0,",",".")',
                        'htmlOptions'=>array('style'=>'text-align:right','class'=>'currency'),
                    ),
					/*array(
                        'header'=>'Print Detail',
                        'type'=>'raw',
                        'name'=>'total_harganetto',
                        'value'=>'CHtml::link("<i class=\"entypo-print\"></i>", "javascript:printDetail(\'$data->supplier_id\',\'$data->permintaanpembelian_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak Detail Laporan Permintaan Pembelian"))',
                        'htmlOptions'=>array('style'=>'text-align:center'),
                    ),*/
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php }else{ ?>
<?php $this->widget($table,array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                    array(
                        'header' => 'No.',
                        'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                        'value' => '$row+1'
                    ),
                    array(
                        'header'=>'Tanggal Permintaan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpermintaanpembelian)))."/ <br/>".$data->nopermintaan',
                    ),
					array(
                        'header'=>'No Permintaan',
                        'type'=>'raw',
                        'value'=>'$data->nopermintaan',
                    ),
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
                        'header'=>'Total Harga Netto',
                        'type'=>'raw',
                        'name'=>'total_harganetto',
                        'value'=>'number_format($data->total_harganetto,0,"",".")',
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
               window.open('${url}/PrintDetailLaporanPermintaanPembelian/id/'+id+'/idPembelian/'+idPembelian,'printwin','location=_new, width=900px');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('jsprintprice',$js, CClientScript::POS_HEAD);
?>