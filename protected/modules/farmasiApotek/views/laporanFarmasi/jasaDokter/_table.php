<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$mergeColumns = array('obatalkes_nama');
$data = $model->searchTabelJasaDokter();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrintJasaDokter();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView'; ?>
<style>
    .tableRincian thead, th{
        border: 1px #000 solid;
    }
</style>
  <?php  $itemsCssClass='table tableRincian';
}else{
  $itemsCssClass='table table-bordered table-striped table-condensed';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
//    'mergeColumns'=>$mergeColumns,
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemsCssClass,
	'columns'=>array(
            
            array(
                    'header' => 'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            ),
            array(
                'header'=>'No. Faktur',
                'name'=>'NoFaktur',
                'type'=>'raw',
                'value'=>'(!empty($data->NoFaktur) ? $data->NoFaktur : " - ")'
            ),
            array(
                'header'=>'Tanggal Faktur',
                'name'=>'TglFaktur',
                'type'=>'raw',
                'value'=>'(!empty($data->TglFaktur) ? date("d/m/Y H:i:s",strtotime($data->TglFaktur)) : " - ")'
            ),
            array(
                'header'=>'Tanggal Resep',
                'type'=>'raw',
				'value'=>'date("d/m/Y H:i:s",strtotime($data->tglresep))'
            ),
            array(
                'header'=>'No. Resep',
                'name'=>'noresep',
            ),
            array(
                'header'=>'Nama Dokter',
                'value'=>'$data->pegawai->nama_pegawai',
                'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Total',
            ),
//            array(
//                'name'=>'Tgl. Penjualan',
//                'type'=>'raw',
//                'value'=>'$data->tglpenjualan',
//            ),            
//            array(
//                'name'=>'Biaya Administrasi',
//                'type'=>'raw',
//                'value'=>'$data->biayaadministrasi  ',
//            ),
//            array(
//                'name'=>'Biaya Konseling',
//                'type'=>'raw',
//                'value'=>'$data->biayakonseling  ',
//            ),
            array(
                'header'=>'Jasa Resep',
                'name'=>'jasadokterresep',
                'value'=>'number_format($data->jasadokterresep,0,"",".")',
                'htmlOptions'=>array('class'=>'subTotal','style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>$model->getTotal('jasadokterresep'),
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<!--<table id="tableTotal" width="100%">
    <tr>
        <td width="75%"></td>
        <td><b>Total</b></td>
        <td class="total">0</td>
    </tr>
</table>-->
<script>
function hitungTotal(){
    var total = 0;
    $('#tableLaporan table tbody').find('tr').each(function(){
        var subTotal = parseFloat(unformatNumber($('.subTotal').html()));
        total += subTotal;
    });
    $('#tableTotal tr').find('.total').html(formatNumber(Math.ceil(total)));
}
//hitungTotal();
</script>