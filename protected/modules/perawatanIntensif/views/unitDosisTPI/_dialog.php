<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
    'dataProvider'=>$dataProvider,
    'filter'=>$models,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectObat",
                "onClick" => "setObatAuto($data->obatalkes_id);return false;"))',
        ),
        array(
            'header'=>'Kode Obat',
            'filter'=>'<input type="text" name="FilterForm[obatalkes_kode]" value="'.$_GET['FilterForm'].'" attr-route ="'.$route.'" onblur="setFilter(this);">',
            'name'=>'obatalkes_kode',
            'value'=>'$data["obatalkes_kode"]',
        ),
       array(
            'header'=>'Nama Obat',
            'name'=>'obatalkes_nama',
            'filter'=>'<input type="text" name="FilterForm2[obatalkes_nama]" value="'.$_GET['FilterForm2'].'" attr-route ="'.$route2.'" onblur="setFilter2(this);">',
            'value'=>'$data["obatalkes_nama"]',
        ),
//        array(
//            'header'=>'Tgl. Kedaluwarsa',
//            'name'=>'tgl_kadaluarsa',
//            'value'=>'$data["tgl_kadaluarsa"]',
//        ),
//        
//        array(
//            'header'=>'Satuan Kecil',
//            'name'=>'satuankecil_nama',
//            'filter'=>'<input type="text" name="FilterForm3[satuankecil_nama]" value="'.$_GET['FilterForm3'].'" attr-route ="'.$route3.'" onblur="setFilter3(this);">',
//            'value'=>'$data["satuankecil_nama"]',
//        ),
//        array(
//            'header'=>'Satuan Besar',
//            'name'=>'satuanbesar_nama',
//            'filter'=>'<input type="text" name="FilterForm4[satuanbesar_nama]" value="'.$_GET['FilterForm4'].'" attr-route ="'.$route4.'" onblur="setFilter4(this);">',
//            'value'=>'$data["satuanbesar_nama"]',
//        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
<script type="text/javascript">
    
    $("#tableObat .pagination ul li a").click(function(event){
        url = $(this).attr("href");
        $.get(url,{},function(data){
            $('#tableObat').html(data);
        });
        return false;
    });
    
function setFilter(obj){
    url = $(obj).attr("attr-route");
    FilterForm = $(obj).val();
    $.get(url,{FilterForm:FilterForm},function(data){
        $('#tableObat').html(data);
        $.fn.yiiGridView.update('obatAlkesDialog-m-grid');
    });
}
function setFilter2(obj){
    url = $(obj).attr("attr-route");
    FilterForm2 = $(obj).val();
    $.get(url,{FilterForm2:FilterForm2},function(data){
        $('#tableObat').html(data);
        $.fn.yiiGridView.update('obatAlkesDialog-m-grid');
    });
}
function setFilter3(obj){
    url = $(obj).attr("attr-route");
    FilterForm3 = $(obj).val();
    $.get(url,{FilterForm3:FilterForm3},function(data){
        $('#tableObat').html(data);
        $.fn.yiiGridView.update('obatAlkesDialog-m-grid');
    });
}
function setFilter4(obj){
    url = $(obj).attr("attr-route");
    FilterForm4 = $(obj).val();
    $.get(url,{FilterForm4:FilterForm4},function(data){
        $('#tableObat').html(data);
        $.fn.yiiGridView.update('obatAlkesDialog-m-grid');
    });
}

</script>
