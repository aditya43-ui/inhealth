<?php 
/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $data = $model->searchPenerimaanItems();
    if (isset($caraPrint)){
        $data = $model->searchPrintPenerimaanItems();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
         $data = $model->searchPenerimaanItems();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<style>
    .detail{
        cursor : pointer;
    }
</style>
<?php if(isset($caraPrint)){
    $this->widget($table,array(
	'id'=>'laporan-grid',
        'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
//        'mergeColumns'=>array('sumberdana_id'),
//        'extraRowColumns'=> array('supplier_id','sumberdana_id'),
	'columns'=>array(                    
/**
            array(
                    'header'=>'Nama Supplier',
                    'name'=>'supplier_id',
                    'type'=>'raw',
                    'value'=>'$data->supplier_nama',
                ),
                array(
                    'header'=>'No. Penerimaan',
                    'name'=>'noterima',
                    'type'=>'raw',
                    'value'=>'$data->noterima'
                ),
                array(
                    'header'=>'Tanggal Penerimaan',
                    'name'=>'tglterima',
                    'type'=>'raw',
                    'value'=>'$data->tglterima'
                ),
                array(
                    'header'=>'No. Faktur',
                    'name'=>'tglterima',
                    'type'=>'raw',
                    'value'=>'$data->tglterima'
                ),
                array(
                    'header'=>'Tanggal Faktur',
                    'name'=>'tglfaktur',
                    'type'=>'raw',
                    'value'=>'$data->tglfaktur'
                ),
 * 
 */
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Kode</p>',
                    'name'=>'obatalkes_kode',
                    'type'=>'raw',
                    'value'=>'$data->obatalkes_kode'
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Obat Alkes</p>',
                    'type'=>'raw',
                    'value'=>'$data->nama_obat',
                    'footerHtmlOptions'=>array(
                            'colspan'=>3,
                            'style'=>'text-align:right;font-style:italic;'
                    ),
                    'footer'=>'Total',
                ),
                array(
                    'header'=>'Satuan',
                    'name'=>'satuanbesar_nama',
                    'type'=>'raw',
                    'value'=>'$data->satuanbesar_nama',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
                // array(
                //     'header'=>'<p style="margin: 0; text-align: center;">Harga Satuan</p>',
                //     'type'=>'raw',
                //     'name'=>'hargabelibesar',
                //     'value'=>'number_format($data->hargabelibesar)',
                //     'htmlOptions'=>array('style'=>'text-align:right'),
                //     // 'footerHtmlOptions'=>array(
                //     //     'style'=>'text-align:right',
                //     //     'class'=>'currency'
                //     // ),                            
                //     // 'footer'=>'sum(hargabelibesar)',
                // ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
                    'name'=>'jumlahterima',
                    'type'=>'raw',
                    'value'=>'$data->jumlahterima',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:center',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(jumlahterima)',
                    
                ),
            /**
                array(
                    'header'=>'<a class="detail" onclick="return printDetail();">Asal Barang</a>',
                    'name'=>'sumberdana_id',
                    'type'=>'raw',
                    'value'=>'$data->sumberdana_nama',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
 * 
 */
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Bruto</p>',
                    'name'=>'hargabruto',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargabruto)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(hargabruto)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Keringanan (Rp)</p>',
                    'name'=>'persendiscount',
                    'type'=>'raw',
                    'value'=>'number_format($data->persendiscount)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(persendiscount)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Ppn (Rp)</p>',
                    'name'=>'hargappn',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargappn)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(hargappn)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">HPP / Netto</p>',
                    'name'=>'total_harga',
                    'type'=>'raw',
                    'value'=>'number_format($data->total_harga)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(total_harga)',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
}else{
    
?>
<?php 
    $this->widget($table,array(
	'id'=>'laporan-grid',
        'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
        'mergeColumns'=>array('sumberdana_id'),
//        'extraRowColumns'=> array('supplier_id','sumberdana_id'),
	'columns'=>array(                    
/**
            array(
                    'header'=>'Nama Supplier',
                    'name'=>'supplier_id',
                    'type'=>'raw',
                    'value'=>'$data->supplier_nama',
                ),
                array(
                    'header'=>'No. Penerimaan',
                    'name'=>'noterima',
                    'type'=>'raw',
                    'value'=>'$data->noterima'
                ),
                array(
                    'header'=>'Tanggal Penerimaan',
                    'name'=>'tglterima',
                    'type'=>'raw',
                    'value'=>'$data->tglterima'
                ),
                array(
                    'header'=>'No. Faktur',
                    'name'=>'tglterima',
                    'type'=>'raw',
                    'value'=>'$data->tglterima'
                ),
                array(
                    'header'=>'Tanggal Faktur',
                    'name'=>'tglfaktur',
                    'type'=>'raw',
                    'value'=>'$data->tglfaktur'
                ),
 * 
 */
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Kode</p>',
                    'name'=>'obatalkes_kode',
                    'type'=>'raw',
                    'value'=>'$data->obatalkes_kode'
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Obat Alkes</p>',
                    'type'=>'raw',
                    'value'=>'$data->nama_obat',
                    'footerHtmlOptions'=>array(
                            'colspan'=>3,
                            'style'=>'text-align:right;font-style:italic;'
                    ),
                    'footer'=>'Total',
                ),
                array(
                    'header'=>'Satuan',
                    'name'=>'satuanbesar_nama',
                    'type'=>'raw',
                    'value'=>'$data->satuanbesar_nama',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
                // array(
                //     'header'=>'<p style="margin: 0; text-align: center;">Harga Satuan</p>',
                //     'type'=>'raw',
                //     'name'=>'hargabelibesar',
                //     'value'=>'number_format($data->hargabelibesar)',
                //     'htmlOptions'=>array('style'=>'text-align:right'),
                //     'footerHtmlOptions'=>array(
                //         'style'=>'text-align:right',
                //         'class'=>'currency'
                //     ),                            
                //     'footer'=>'sum(hargabelibesar)',
                // ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
                    'name'=>'jumlahterima',
                    'type'=>'raw',
                    'value'=>'$data->jumlahterima',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:center',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(jumlahterima)',
                    
                ),
            /**
                array(
                    'header'=>'<a class="detail" onclick="return printDetail();">Asal Barang</a>',
                    'name'=>'sumberdana_id',
                    'type'=>'raw',
                    'value'=>'$data->sumberdana_nama',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
 * 
 */
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Bruto</p>',
                    'name'=>'hargabruto',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargabruto)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(hargabruto)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Keringanan (Rp)</p>',
                    'name'=>'persendiscount',
                    'type'=>'raw',
                    'value'=>'number_format($data->persendiscount)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(persendiscount)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Ppn (Rp)</p>',
                    'name'=>'hargappn',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargappn)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(hargappn)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">HPP / Netto</p>',
                    'name'=>'total_harga',
                    'type'=>'raw',
                    'value'=>'number_format($data->total_harga)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'sum(total_harga)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Print Detail</p>',
                    'name'=>'sumberdana_id',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\"entypo-print\"></i>", "javascript:printDetail(\'$data->penerimaanbarang_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak Detail Laporan Penerimaan Pembelian"))',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align:right;color:white',
                        'class'=>'currency'
                    ),                            
                    'footer'=>'-',
                ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
    
 /**
    $this->widget($table,array(
	'id'=>'laporan-grid',
        'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeColumns'=>array('supplier_id', 'noterima','sumberdana_id'),
        'extraRowColumns'=> array('supplier_id','sumberdana_id'),
	'columns'=>array(                    
                array(
                    'header'=>'Nama Supplier',
                    'name'=>'supplier_id',
                    'type'=>'raw',
                    'value'=>'$data->supplier_nama',
                ),
                array(
                    'header'=>'No. Penerimaan',
                    'name'=>'noterima',
                    'type'=>'raw',
                    'value'=>'$data->noterima'
                ),
                array(
                    'header'=>'Tanggal Penerimaan',
                    'name'=>'tglterima',
                    'type'=>'raw',
                    'value'=>'$data->tglterima'
                ),
                array(
                    'header'=>'No. Faktur',
                    'name'=>'tglterima',
                    'type'=>'raw',
                    'value'=>'$data->tglterima'
                ),
                array(
                    'header'=>'Tanggal Faktur',
                    'name'=>'tglfaktur',
                    'type'=>'raw',
                    'value'=>'$data->tglfaktur'
                ),
                array(
                    'header'=>'Kode',
                    'name'=>'obatalkes_kode',
                    'type'=>'raw',
                    'value'=>'$data->obatalkes_kode'
                ),
                array(
                    'header'=>'Obat Alkes',
                    'type'=>'raw',
                    'value'=>'$data->nama_obat',
                ),
                array(
                    'header'=>'Harga Satuan',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargabelibesar)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),
                array(
                    'header'=>'Jumlah',
                    'name'=>'jumlahterima',
                    'type'=>'raw',
                    'value'=>'$data->jumlahterima',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                ),
                array(
                    'header'=>'Satuan',
                    'name'=>'satuanbesar_nama',
                    'type'=>'raw',
                    'value'=>'$data->satuanbesar_nama',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
                array(
                    'header'=>'<a class="detail" onclick="return printDetail();">Asal Barang</a>',
                    'name'=>'sumberdana_id',
                    'type'=>'raw',
                    'value'=>'$data->sumberdana_nama',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
                array(
                    'header'=>'Bruto',
                    'name'=>'hargabelibesar',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargabelibesar * $data->jumlahterima)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),
                array(
                    'header'=>'Keringanan (Rp)',
                    'name'=>'persendiscount',
                    'type'=>'raw',
                    'value'=>'number_format($data->persendiscount)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),
                array(
                    'header'=>'Ppn (Rp)',
                    'name'=>'hargappn',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargappn)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),
                array(
                    'header'=>'HPP / Netto',
                    'name'=>'total_harga',
                    'type'=>'raw',
                    'value'=>'number_format($data->total_harga)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),
                array(
                    'header'=>'Print Detail',
                    'name'=>'supplier_id',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\"icon-list-alt\"></i>", "javascript:printDetail(\'$data->supplier_id\',\'$data->permintaanpembelian_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mencetak Detail Laporan Permintaan Pembelian"))',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
  * 
  */
?>
<?php } ?>
<?php 
    
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $js = <<< JSCRIPT

function printDetail(idTerimaBarang)
   {    
               window.open('${url}/PrintDetLapTerimaJenis&idTerimaBarang='+idTerimaBarang+'/'+$('#search-laporan').serialize(),'printwin','location=_new, width=900px');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('jsprintdetailpenerimaanitemsberdasarkanjenis',$js, CClientScript::POS_HEAD);
?>