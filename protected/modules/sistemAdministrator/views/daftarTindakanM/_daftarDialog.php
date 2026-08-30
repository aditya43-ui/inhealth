<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'komponentarif-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider'=>$dataProvider,
    'filter'=>$models,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectMenuDiet",
                                    "onClick" => "var data=[\"$data->komponentarif_id\", \"$data->komponentarif_nama\"]
                                                    setTindakanAuto(data, this);
                                                    $(\"#dialogKomponenTarif\").dialog(\"close\");
                            "))',
                ),
                array(
                    'header'=>'Komponen Tarif',
                    'filter'=>'<input type="text" name="FilterForm[komponentarif_nama]" value="'.$_GET['FilterForm'].'" attr-route ="'.$route.'" onblur="setFilter(this);">',
                    'name'=>'komponentarif_nama',
                    'value'=>'$data["komponentarif_nama"]',
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
<script type="text/javascript">
    
    $("#tableDaftarKomponenTarif .pagination ul li a").click(function(event){
        url = $(this).attr("href");
        $.get(url,{},function(data){
            $('#tableDaftarKomponenTarif').html(data);
        });
        return false;
    });
    
function setFilter(obj){
    url = $(obj).attr("attr-route");
    FilterForm = $(obj).val();
    $.get(url,{FilterForm:FilterForm},function(data){
        $('#tableDaftarKomponenTarif').html(data);
        $.fn.yiiGridView.update('komponentarif-grid');
    });
}

function setTindakanDialog(obj,item)
{
    $(obj).parents('tr').find('input[name$="[kategoriTindakanNama]"]').val(item.kategoritindakan_nama);
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val(item.daftartindakan_id);
}
</script>