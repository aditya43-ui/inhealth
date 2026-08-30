<?php 
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'menudiet-m-grid',
	'dataProvider'=>$dataProvider,
        'filter'=>$models,
//	'filter'=>$filtersForm,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                "id" => "selectMenu",
                                "onClick" => "setTindakanAuto($data->menudiet_id,$data->bahanmakanana_id);return false;"))',
                ),
                
                array(
                    'header'=>'Jenis Diet',
                    'name'=>'jenisdiet_id',
                    'type'=>'raw',
                    'value'=>'$data->jenisdiet->jenisdiet_nama',
                ),
                array(
                    'header'=>'Nama Menu',
                    'name'=>'menudiet_nama',
                    'type'=>'raw',
                    'value'=>'$data->menudiet_nama',
                ),
                array(
                    'header'=>'Jumlah Porsi',
                    'name'=>'jml_porsi',
                    'type'=>'raw',
                    'value'=>'$data->jml_porsi',
                ),
                array(
                    'header'=>'Ukuran Rumah Tangga',
                    'name'=>'ukuranrumahtangga',
                    'type'=>'raw',
                    'value'=>'$data->ukuranrumahtangga',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>

<script type="text/javascript">
    $("#tableDaftarMenuDiet .pagination ul li a").click(function(event){
        url = $(this).attr("href");
        $.get(url,{},function(data){
            $('#tableDaftarMenuDiet').html(data);
        });
        return false;
    });
    
function setFilter(obj){
    url = $(obj).attr("attr-route");
    FilterForm = $(obj).val();
    $.get(url,{FilterForm:FilterForm},function(data){
        $('#tableDaftarMenuDiet').html(data);
    });
}
function setFilter2(obj){
    url = $(obj).attr("attr-route");
    FilterForm2 = $(obj).val();
    $.get(url,{FilterForm2:FilterForm2},function(data){
        $('#tableDaftarMenuDiet').html(data);
    });
}
function setTindakanDialog(obj,item)
{
    $(obj).parents('tr').find('input[name$="[menudietNama]"]').val(item.menudiet_nama);
    $(obj).parents('tr').find('input[name$="[menudiet_id]"]').val(item.menudiet_id);
    tambahMenuDiet(item.daftartindakan_id,item.label);
}

</script>
