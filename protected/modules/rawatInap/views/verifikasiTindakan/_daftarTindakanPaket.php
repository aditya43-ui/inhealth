<?php     
    $modTindakan = new RIPaketpelayananV('searchTindakan');
    $modTindakan->unsetAttributes();    
    if(isset($_GET['RIPaketpelayananV'])) {
        $modTindakan->attributes = $_GET['RIPaketpelayananV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'giladiagnosa-m-grid2',
		'dataProvider'=>$modTindakan->searchTindakan(),
		'filter'=>$modTindakan,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectTindakan",
								"onClick" => "
									setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);
								"))',
				'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
			),
			array(
				'name'=>'kategoritindakan_nama',
				'value'=>'$data->kategoritindakan_nama',
				'type'=>'raw',
			),
			array(
				'name'=>'daftartindakan_kode',
				'value'=>'$data->daftartindakan_kode',
				'type'=>'raw',
			),
			array(
				'name'=>'daftartindakan_nama',
				'value'=>'$data->daftartindakan_nama',
				'type'=>'raw',
			),
			array(
				'name'=>'harga_tariftindakan',
				'value'=>'number_format($data->harga_tariftindakan,0,"",".")',
				'type'=>'raw', 
				'filter'=>false,
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>

<script type="text/javascript">
    
    $("#tableDaftarTindakanPaket .pagination ul li a").click(function(event){
        url = $(this).attr("href");
        $.get(url,{},function(data){
            $('#tableDaftarTindakanPaket').html(data);
        });
        return false;
    });
    
function setFilter(obj){
    url = $(obj).attr("attr-route");
    FilterForm = $(obj).val();
    $.get(url,{FilterForm:FilterForm},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}
function setFilter2(obj){
    url = $(obj).attr("attr-route");
    FilterForm2 = $(obj).val();
    $.get(url,{FilterForm2:FilterForm2},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}
function setFilter3(obj){
    url = $(obj).attr("attr-route");
    FilterForm3 = $(obj).val();
    $.get(url,{FilterForm3:FilterForm3},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}
function setFilter4(obj){
    url = $(obj).attr("attr-route");
    FilterForm4 = $(obj).val();
    $.get(url,{FilterForm4:FilterForm4},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}
</script>
